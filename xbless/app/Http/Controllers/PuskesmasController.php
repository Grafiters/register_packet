<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Puskesmas;
use DB;
use Auth;

class PuskesmasController extends Controller
{

    public function getPuskesmas(Request $request)
    {
        $puskesmas = Puskesmas::select('id', 'code', 'name')
            ->orWhere('name', 'LIKE', "%{$request->search}%")
            ->orWhere('code', 'LIKE', "%{$request->search}%")
            ->orWhere('email', 'LIKE', "%{$request->search}%")
            ->orWhere('address', 'LIKE', "%{$request->search}%")
            ->limit(10)->get();

        $result = $puskesmas;

        return json_encode($result);
    }

    protected $original_column = array(
        1 => "name",
    );

    public function index()
    {
        return view('template/master_daerah/puskesmas/index');
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
        $cek = Puskesmas::where('id', '!=', $id)->where($column, '=', $var)->first();
        return (!empty($cek) ? false : true);
    }

    public function getSelect(Request $request)
    {
      $term = $request->term;

      $query = Puskesmas::select('*');
      $query->take(10);
      $query->orderBy('id','asc');
      if($term){
          $query->where('name', 'LIKE', "%{$term}%");
          $query->orWhere('code', 'LIKE', "%{$term}%");
      }
      $masterbank = $query->get();
      $out = [
          'results' => [],
          'pagination' => [
              'more' => false
          ]
      ];
      foreach($masterbank as $value){
          array_push($out['results'], [
              'id'   =>$value->id,
              'text' =>$value->name
          ]);
      }
      return response()->json($out, 200);
    }

    public function getData(Request $request)
    {
        $limit = $request->length;
        $start = $request->start;
        $page  = $start + 1;
        $search = $request->search['value'];

        $dataquery = Puskesmas::select('*');
        if (auth()->user()->can('kabupaten.index')) {
            $kabupaten = Kabupaten::select('id', 'name')->where('id', auth()->user()->kabupaten_id)->first();
            $kabupaten_name = explode(" ", $kabupaten->name);

            if($kabupaten_name[0] != 'Kota'){
                $kabupaten = ucwords(strtolower($kabupaten_name[1]));
            }else{
                $kabupaten = ucwords(strtolower($kabupaten->name));
            }
            // $kabupaten = $kabupaten_name[1];
            // return $kabupaten;
            $dataquery->where('kabupaten', $kabupaten);
        }
        if (array_key_exists($request->order[0]['column'], $this->original_column)) {
            $dataquery->orderByRaw($this->original_column[$request->order[0]['column']] . ' ' . $request->order[0]['dir']);
        } else {
            $dataquery->orderBy('id', 'DESC');
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
            $action .= '<a href="' . route('master.puskesmas.ubah', $enc_id) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;';
            $action .= '<a href="#" onclick="deleteData(this,\'' . $enc_id . '\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="fa fa-times"></i> Hapus</a>&nbsp;';
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
        $kecamatan = Kecamatan::all();

        $selectedKabupaten = '';
        $selectedKecamatan = '';

        if (auth()->user()->can('kabupaten.index')) {
            $kab = Kabupaten::find(auth()->user()->kabupaten_id);
            $selectedKabupaten = $kab->code_kabupaten;
            $selectedKecamatan = '';
        }
        return view('template/master_daerah/puskesmas/form', compact('kabupaten', 'kecamatan', 'selectedKabupaten', 'selectedKecamatan'));
    }

    public function kecamatan(Request $req, $id)
    {
        // $kabupaten = Kabupaten::where('code_kabupaten'$id);
        $data = Kecamatan::where('kabkot_id', $id)->get();
        if (count($data) > 0) {
            $json_data = array(
                "success"  => TRUE,
                "jumlah"   => count($data),
                "data"     => $data
            );
        } else {
            $json_data = array(
                "success"  => FALSE,
                "jumlah"   => 0,
                "data"     => []
            );
        }
        return json_encode($json_data);
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
                    $puskesmas = Puskesmas::find($dec_id);
                    // return response()->json(['data' => $puskesmas]);
                    $puskesmas->provinsi        = ucwords($provinsi->name);
                    $puskesmas->kabupaten       = explode_kab($kabupaten->name);
                    $puskesmas->kecamatan       = ucwords($kecamatan->name);
                    // return $puskesmas;
                    $puskesmas->code            = $req->code;
                    $puskesmas->name            = $req->name;
                    $puskesmas->address         = $req->address;
                    // $puskesmas->save();
                    $json_data = array(
                        "success"         => TRUE,
                        "message"         => 'Data berhasil diperbarui.'
                    );
                } else {
                    $puskesmas                  = new Puskesmas;
                    $puskesmas->provinsi        = ucwords($provinsi->name);
                    $explode = explode(" ", $kabupaten->name);
                    if($explode[0] != 'KOTA'){
                        $namekab = ucwords(strtolower($explode[1]));
                    }else{
                        $namekab = ucwords(strtolower($kabupaten->name));
                    }
                    $puskesmas->kabupaten       = $namekab;
                    $puskesmas->kecamatan       = ucwords($kecamatan->name);
                    $puskesmas->code            = $req->code;
                    $puskesmas->name            = $req->name;
                    $puskesmas->address         = $req->address;
                    $puskesmas->save();
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
            $puskesmas = Puskesmas::find($dec_id);
            $explode = explode(' ', $puskesmas->kabupaten);
            if(count($explode) > 1 ){
                $kab = strtoupper($puskesmas->kabupaten);
            }else{
                $kab = 'KABUPATEN '.strtoupper($puskesmas->kabupaten);
            }
            // return $kab;
            $kabupaten = Kabupaten::all();
            $kecamatan = Kecamatan::all();
            // return $kabupaten;
            $selectedKabupaten =  Kabupaten::where('name', $kab)->first()->code_kabupaten;
            // return $selectedKabupaten;
            $selectedKecamatan = Kecamatan::where('name', $puskesmas->kecamatan)->first()->id;
            // return $selectedKecamatan;
            // return $puskesmas;
            return view('template/master_daerah/puskesmas/form', compact('enc_id', 'kabupaten', 'puskesmas', 'kecamatan', 'selectedKabupaten', 'selectedKecamatan'));
        } else {
            $json_data = array(
                "success"         => FALSE,
                "message"         => "data tidak ditemukan"
            );
            return json_encode($json_data);
        }
    }

    public function hapus(Request $req, $enc_id)
    {
        try {
            $dec_id   = $this->safe_decode(Crypt::decryptString($enc_id));
            $puskesmas    = Puskesmas::find($dec_id);
            $puskesmas->delete();
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
