<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use DB;
use Auth;

class KecamatanController extends Controller
{
    protected $original_column = array(
        1 => "name",
    );

    public function index()
    {
        return view('template/master_daerah/kecamatan/index');
    }

    function safe_encode($string)
    {
        $data = str_replace(array('/'), array('_'), $string);
        return $data;
    }

    function safe_decode($string, $mode = null)
    {
        $data = str_replace(array('_'), array('/'), $string);
        return $data;
    }

    private function cekExist($column, $var, $id)
    {
        $cek = Kecamatan::where('id', '!=', $id)->where($column, '=', $var)->first();
        return (!empty($cek) ? false : true);
    }

    public function getData(Request $request)
    {
        $limit = $request->length;
        $start = $request->start;
        $page  = $start + 1;
        $search = $request->search['value'];

        $dataquery = Kecamatan::select('*');
        if (auth()->user()->can('kabupaten.index')) {
            $kabupaten = Kabupaten::find(auth()->user()->kabupaten_id);
            $dataquery->where('kabkot_id', $kabupaten->code_kabupaten);
        }
        if (array_key_exists($request->order[0]['column'], $this->original_column)) {
            $dataquery->orderByRaw($this->original_column[$request->order[0]['column']] . ' ' . $request->order[0]['dir']);
        } else {
            $dataquery->orderBy('id', 'ASC');
        }
        if ($search) {
            $dataquery->where(function ($query) use ($search) {
                $query->orWhere('name', 'LIKE', "%{$search}%");
            });
        }
        $totalData = $dataquery->get()->count();

        $totalFiltered = $dataquery->get()->count();

        $dataquery->limit($limit);
        $dataquery->offset($start);
        $data = $dataquery->get();
        foreach ($data as $key => $result) {
            $enc_id = $this->safe_encode(Crypt::encryptString($result->id));
            $action = "";

            $action .= "";
            $action .= "<div class='btn-group'>";
            $action .= '<a href="' . route('master.kecamatan.ubah', $enc_id) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;';
            $action .= '<a href="#" onclick="deleteData(this,\'' . $enc_id . '\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="fa fa-times"></i> Hapus</a>&nbsp;';
            $action .= "</div>";

            $result->no             = $key + $page;
            $result->id             = $result->id;
            $result->code           = $result->id;
            $result->name           = $result->name;
            $result->action         = $action;
        }
        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        // if ($request->user()->can('brand.index')) {
        //     $json_data = array(
        //         "draw"            => intval($request->input('draw')),
        //         "recordsTotal"    => intval($totalData),
        //         "recordsFiltered" => intval($totalFiltered),
        //         "data"            => $data
        //       );
        // }else{
        //     $json_data = array(
        //         "draw"            => intval($request->input('draw')),
        //         "recordsTotal"    => 0,
        //         "recordsFiltered" => 0,
        //         "data"            => []
        //       );

        // }
        return json_encode($json_data);
    }

    public function tambah()
    {
        $kabupaten = Kabupaten::all();
        $selectedKabupaten = '';

        if (auth()->user()->can('kabupaten.index')) {
            $kab = Kabupaten::find(auth()->user()->kabupaten_id);
            $selectedKabupaten = $kab->id;
        }


        return view('template/master_daerah/kecamatan/form', compact('kabupaten', 'selectedKabupaten'));
    }

    private function genCodeKabupaten($data, $id_prov)
    {
        $kabupaten = Kabupaten::find($id_prov);
        $code = $kabupaten->code_kabupaten;
        return $code;
    }

    public function simpan(Request $req)
    {
        $enc_id     = $req->enc_id;

        if ($enc_id != null) {
            $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        } else {
            $dec_id = null;
        }

        $cek_nama = $this->cekExist('name', $req->name, $dec_id);
        if (!$cek_nama) {
            $json_data = array(
                "success"         => FALSE,
                "message"         => 'Mohon maaf. Nama Jabatan sudah terdaftar pada sistem.'
            );
        } else {
            try {
                if ($enc_id) {
                    $kecamatan = Kecamatan::find($dec_id);
                    $kecamatan->id            = $req->id;
                    $kecamatan->kabkot_id     = $this->genCodeKabupaten($req->code, $req->kabupaten);
                    $kecamatan->kabupaten_id  = $req->kabupaten;
                    $kecamatan->name          = $req->name;
                    $kecamatan->save();
                    $json_data = array(
                        "success"         => TRUE,
                        "message"         => 'Data berhasil diperbarui.'
                    );
                } else {
                    $kecamatan              = new Kecamatan;
                    $kecamatan->id        = $req->id;
                    $kecamatan->kabkot_id = $this->genCodeKabupaten($req->code, $req->kabupaten);
                    $kecamatan->kabupaten_id  = $req->kabupaten;
                    $kecamatan->name        = $req->name;
                    $kecamatan->save();
                    $json_data = array(
                        "success"         => TRUE,
                        "message"         => 'Data berhasil ditambahkan.'
                    );
                }
            } catch (\Throwable $th) {
                $json_data = array(
                    "success"         => FALSE,
                    "message"         => $th->getMessage()
                );
            }
        }
        return json_encode($json_data);
    }

    public function ubah($enc_id)
    {
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        if ($dec_id) {
            $kecamatan = Kecamatan::find($dec_id);
            $kabupaten = Kabupaten::all();
            $selectedKabupaten = $kecamatan->kabupaten_id;
            return view('template/master_daerah/kecamatan/form', compact('enc_id', 'kabupaten', 'kecamatan', 'selectedKabupaten'));
        } else {
            $json_data = array(
                "success"         => FALSE,
                "message"         => $th->getMessage()
            );
            return json_encode($json_data);
        }
    }

    public function hapus(Request $req, $enc_id)
    {
        try {
            $dec_id   = $this->safe_decode(Crypt::decryptString($enc_id));
            $kecamatan    = Kecamatan::find($dec_id);
            $kecamatan->delete();

            $json_data = array(
                "status"         => 'success',
                "message"         => 'Data berhasil dihapus.'
            );
        } catch (\Throwable $th) {
            $json_data = array(
                "success"         => 'gagal',
                "message"         => $th->getMessage()
            );
        }
        return response()->json($json_data);
    }
}
