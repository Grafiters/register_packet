<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Puskesmas;
use App\Models\Desa;
use DB;
use Auth;

class DesaController extends Controller
{
    protected $original_column = array(
        1 => "name",
    );

    public function index()
    {
        return view('template/master_daerah/desa/index');
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
        $cek = Desa::where('id', '!=', $id)->where($column, '=', $var)->first();
        return (!empty($cek) ? false : true);
    }

    public function getData(Request $request)
    {
        $limit = $request->length;
        $start = $request->start;
        $page  = $start + 1;
        $search = $request->search['value'];

        $dataquery = Desa::select('desa.*', 'kecamatan.name as kecamatan','kabupaten.name as kabupaten','provinsi.name as provinsi');
        $dataquery->leftJoin('kecamatan','kecamatan.id','desa.kecamatan_id');
        $dataquery->leftJoin('kabupaten','kabupaten.code_kabupaten','kecamatan.kabkot_id');
        $dataquery->leftJoin('provinsi','provinsi.id','kabupaten.provinsi_id');
        
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
            $action .= '<a href="' . route('master.desa.ubah', $enc_id) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;';
            // $action .= '<a href="#" onclick="deleteData(this,\'' . $enc_id . '\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="fa fa-times"></i> Hapus</a>&nbsp;';
            $action .= "</div>";

            $provinsi = Provinsi::find($result->provid);

            $result->no               = $key + $page;
            $result->id               = $result->id;
            $result->action           = $action;
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
        // $kecamatan = Kecamatan::all();

        $selectedKabupaten = '';
        // $selectedKecamatan = '';

        return view('template/master_daerah/desa/form', compact('kabupaten', 'selectedKabupaten'));
    }

    public function simpan(Request $req)
    {
        // return $req->all();
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
                "message"         => 'Mohon maaf. Nama Puskesmas sudah terdaftar pada sistem.'
            );
        } else {
            $kabupaten = Kabupaten::where('code_kabupaten', $req->kabupaten)->first();
            $provinsi  = Provinsi::find($kabupaten->provinsi_id);
            $kecamatan = Kecamatan::find($req->kecamatan);
            // return $kecamatan;

            try {
                if ($enc_id) {
                    $desa = Desa::find($dec_id);
                    // $desa->kabupaten       = $req->kabupaten;
                    $desa->kecamatan_id     = $req->kecamatan;
                    $desa->id             = $req->code;
                    $desa->name             = $req->name;
                    $desa->save();
                    $json_data = array(
                        "success"         => TRUE,
                        "message"         => 'Data berhasil diperbarui.'
                    );
                } else {
                    $desa                  = new Desa;
                    // $desa->kabupaten       = $req->kabupaten;
                    $desa->kecamatan__id       = $req->kecamatan;
                    $desa->code            = $req->code;
                    $desa->name            = $req->name;
                    $desa->save();
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

    public function ubah($enc_id){
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        if ($dec_id) {
            $desa               = Desa::select('desa.*', 'kecamatan.name as kecamatan', 'kabupaten.code_kabupaten','kabupaten.name as kabupaten')->leftJoin('kecamatan','kecamatan.id','desa.kecamatan_id')->leftJoin('kabupaten','kabupaten.code_kabupaten','kecamatan.kabkot_id')->first();
            $kabupaten          = Kabupaten::orderBy('name', 'ASC')->get();
            $selectedKabupaten  = $desa->code_kabupaten;
            
            // return response()->json($kader);
            return view('template/master_daerah/desa/form', compact('enc_id', 'desa','kabupaten','selectedKabupaten'));
        } else {
            $json_data = array(
                "success"         => FALSE,
                "message"         => "data tidak ditemukan"
            );
            return json_encode($json_data);
        }
    }
}
