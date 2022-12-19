<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Models\Provinsi;
use DB;
use Auth;

class ProvinsiController extends Controller
{
    protected $original_column = array(
        1 => "name",
    );

    public function index(){
        return view('template/master_daerah/provinsi/index');
    }

    function safe_encode($string) {
      $data = str_replace(array('/'),array('_'),$string);
      return $data;
    }

    function safe_decode($string,$mode=null) {
        $data = str_replace(array('_'),array('/'),$string);
        return $data;
    }

    private function cekExist($column,$var,$id){
        $cek = Provinsi::where('id','!=',$id)->where($column,'=',$var)->first();
        return (!empty($cek) ? false : true);
    }

    public function getData(Request $request){
        $limit = $request->length;
        $start = $request->start;
        $page  = $start +1;
        $search = $request->search['value'];
        
        $dataquery = Provinsi::select('*');
        if(array_key_exists($request->order[0]['column'], $this->original_column)){
           $dataquery->orderByRaw($this->original_column[$request->order[0]['column']].' '.$request->order[0]['dir']);
        }
         else{
          $dataquery->orderBy('id','DESC');
        }
         if($search) {
          $dataquery->where(function ($query) use ($search) {
                  $query->orWhere('name','LIKE',"%{$search}%");
          });
        }
        $totalData = $dataquery->get()->count();
    
        $totalFiltered = $dataquery->get()->count();
    
        $dataquery->limit($limit);
        $dataquery->offset($start);
        $data = $dataquery->get();
        foreach ($data as $key=> $result)
        {
          $enc_id = $this->safe_encode(Crypt::encryptString($result->id));
          $action = "";
         
          $action.="";
          $action.="<div class='btn-group'>";
          $action.='<a href="'.route('master.provinsi.ubah',$enc_id).'" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;';
          $action.='<a href="#" onclick="deleteData(this,\''.$enc_id.'\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="fa fa-times"></i> Hapus</a>&nbsp;';
          $action.="</div>";
          
          $result->no             = $key+$page;
          $result->id             = $result->id;
          $result->code           = $result->code;
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

    public function tambah(){
        return view('template/master_daerah/provinsi/form');
    }

    private function genCodeProvinsi(){
        $provinsi = Provinsi::max('id');
        if($provinsi != null || $provinsi > 0){
            $idocde = $provinsi + 1;
        }else{
            $idocde = 1;
        }

        $code = sprintf("%'.02d", $idocde);
        return $code;
    }

    public function simpan(Request $req){
        $enc_id     = $req->enc_id;
            
        if ($enc_id != null) {
          $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        }else{
          $dec_id = null;
        }
    
        $cek_nama = $this->cekExist('name',$req->name,$dec_id);
        if(!$cek_nama){
            $json_data = array(
              "success"         => FALSE,
              "message"         => 'Mohon maaf. Nama Jabatan sudah terdaftar pada sistem.'
            );
        }else {
          try {
            if($enc_id){
                $provinsi = Provinsi::find($dec_id);
                $provinsi->code         = $req->code;
                $provinsi->name         = $req->name;
                $provinsi->save();
                
                if($provinsi) {
                  $json_data = array(
                        "success"         => TRUE,
                        "message"         => 'Data berhasil diperbarui.'
                     );
                }else{
                   $json_data = array(
                        "success"         => FALSE,
                        "message"         => 'Data gagal diperbarui.'
                     );
                }
              }else{
                $provinsi              = new Provinsi;
                $provinsi->code        = $req->code;
                $provinsi->name        = $req->name;
                $provinsi->save();
                if($provinsi) {
                  $json_data = array(
                        "success"         => TRUE,
                        "message"         => 'Data berhasil ditambahkan.'
                  );
                }else{
                  $json_data = array(
                        "success"         => FALSE,
                        "message"         => 'Data gagal ditambahkan.'
                  );
                }
        
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
            $provinsi = Provinsi::find($dec_id);
            return view('template/master_daerah/provinsi/form', compact('enc_id','provinsi'));
        }else{
            $json_data = array(
                "success"         => FALSE,
                "message"         => $th->getMessage()
            );
            return json_encode($json_data);
        }
    }

    public function hapus(Request $req, $enc_id){
        try {
            $dec_id   = $this->safe_decode(Crypt::decryptString($enc_id));
            $provinsi    = Provinsi::find($dec_id);
            $provinsi->delete();

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