<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Models\Provinsi;
use App\Models\KepalaBidang;
use DB;
use Auth;

class KepalaBidangController extends Controller
{
    protected $original_column = array(
        1 => "name",
    );

    public function index()
    {
        return view('template/kabid/index');
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
        $cek = KepalaBidang::where('id', '!=', $id)->where($column, '=', $var)->first();
        return (!empty($cek) ? false : true);
    }

    public function getData(Request $request)
    {
        $limit = $request->length;
        $start = $request->start;
        $page  = $start + 1;
        $search = $request->search['value'];

        $dataquery = KepalaBidang::select('*');
        
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
            $action .= '<a href="' . route('master.kabid.ubah', $enc_id) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;';
            // $action .= '<a href="#" onclick="deleteData(this,\'' . $enc_id . '\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="fa fa-times"></i> Hapus</a>&nbsp;';
            $action .= "</div>";

            $provinsi = Provinsi::find($result->provid);

            if ($result->status == '1') {
                $status = '<span class="label label-primary">Aktif</span>';
            } else if ($result->status == '0') {
                $status = '<span class="label label-warning">Tidak Aktif</span>';
            }

            $result->no               = $key + $page;
            $result->id               = $result->id;
            $result->img              = ($result->img) ? url($result->img) : '';
            $result->status           = $status;
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

    public function tambah(){
        return view('template/kabid/form');
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
        $cek_nip = $this->cekExist('nip', $req->nip, $dec_id);
        if (!$cek_nama) {
            $json_data = array(
                "success"         => FALSE,
                "message"         => 'Mohon maaf. Nama Kepala Bidang sudah terdaftar pada sistem.'
            );
        } else if (!$cek_nip) {
            $json_data = array(
                "success"         => FALSE,
                "message"         => 'Mohon maaf. Nip sudah terdaftar pada sistem.'
            );
        } else {
            try {
                $path = 'web/images/kabid/';
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                    chmod($path, 0777);
                }

                if($req->file('img') != null){
                    $fileName = $req->file('img')->getClientOriginalName();
                    $pathName = $path.$fileName;
                }

                if ($enc_id) {
                    $desa = KepalaBidang::find($dec_id);
                    if($req->file('img') != null){
                        if($desa->img != 'web/images/no_img.png'){
                            if(file_exists($desa->img)){
                                unlink($desa->img);
                            }
                        }
                    }

                    $desa->nip              = $req->nip;
                    $desa->name             = $req->name;
                    $desa->tingkatan        = $req->pangkat;
                    $desa->status           = $req->status;
                    if($req->file('img') != null){
                        $req->file('img')->move($path, $fileName);
                        chmod($path.$fileName, 0775);
                        $desa->img       = $pathName;
                    }

                    $desa->save();
                    $json_data = array(
                        "success"         => TRUE,
                        "message"         => 'Data berhasil diperbarui.'
                    );
                } else {
                    $desa                   = new KepalaBidang;
                    $desa->nip              = $req->nip;
                    $desa->name             = $req->name;
                    $desa->tingkatan        = $req->pangkat;
                    $desa->status           = $req->status;
                    if($req->file('img') != null){
                        $req->file('img')->move($path, $fileName);
                        chmod($path.$fileName, 0775);
                        $desa->img       = $pathName;
                    }
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
        if($dec_id){
            $kabid = KepalaBidang::find($dec_id);
            // return response()->json($kabid);
            return view('template/kabid/form', compact('enc_id','kabid'));
        }else{
            $json_data = array(
                "success"         => FALSE,
                "message"         => $th->getMessage()
            );
            return json_encode($json_data);
        }
    }
}
