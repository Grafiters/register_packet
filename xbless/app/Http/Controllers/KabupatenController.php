<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Models\Kabupaten;
use App\Models\Provinsi;
use DB;
use Auth;

class KabupatenController extends Controller
{
    protected $original_column = array(
        1 => "name",
    );

    public function index(){
        return view('template/master_daerah/kabupaten/index');
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
        $cek = Kabupaten::where('id','!=',$id)->where($column,'=',$var)->first();
        return (!empty($cek) ? false : true);
    }

    public function getSelect(Request $request)
    {
      $term = $request->term;

      $query = Kabupaten::select('*');
      $query->take(10);
      $query->orderBy('id','asc');
      if($term){
          $query->where('name', 'LIKE', "%{$term}%");
          $query->orWhere('code_kabupaten', 'LIKE', "%{$term}%");
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

    public function getData(Request $request){
        $limit = $request->length;
        $start = $request->start;
        $page  = $start +1;
        $search = $request->search['value'];

        $dataquery = Kabupaten::select('kabupaten.*','provinsi.code as procode');
        $dataquery->leftJoin('provinsi','provinsi.id','kabupaten.provinsi_id');
        if(array_key_exists($request->order[0]['column'], $this->original_column)){
           $dataquery->orderByRaw($this->original_column[$request->order[0]['column']].' '.$request->order[0]['dir']);
        }
         else{
          $dataquery->orderBy('id','ASC');
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
          $action.='<a href="'.route('master.kabupaten.ubah',$enc_id).'" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;';
          $action.='<a href="#" onclick="deleteData(this,\''.$enc_id.'\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="fa fa-times"></i> Hapus</a>&nbsp;';
          $action.="</div>";

          $result->no             = $key+$page;
          $result->id             = $result->id;
          $result->code           = $result->code_kabupaten;
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
        $provinsi = Provinsi::all();
        $selectedKabupaten = '';

        return view('template/master_daerah/kabupaten/form', compact('provinsi', 'selectedKabupaten'));
    }

    private function genCodeKabupaten($data, $id_prov){
        $provinsi = Provinsi::find($id_prov);
        $code = $provinsi->code.".".$data;
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
                $kabupaten = Kabupaten::find($dec_id);
                $kabupaten->code         = $req->code;
                $kabupaten->code_kabupaten = $this->genCodeKabupaten($req->code, $req->provinsi);
                $kabupaten->provinsi_id  = $req->provinsi;
                $kabupaten->name         = $req->name;
                $kabupaten->save();
                  $json_data = array(
                        "success"         => TRUE,
                        "message"         => 'Data berhasil diperbarui.'
                     );
              }else{
                $kabupaten              = new Kabupaten;
                $kabupaten->provinsi_id  = $req->provinsi;
                $kabupaten->code_kabupaten = $this->genCodeKabupaten($req->code, $req->provinsi);
                $kabupaten->code        = $req->code;
                $kabupaten->name        = $req->name;
                $kabupaten->save();
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
            $kabupaten = Kabupaten::find($dec_id);
            $provinsi = Provinsi::all();
            $selectedKabupaten = $kabupaten->provinsi_id;
            return view('template/master_daerah/kabupaten/form', compact('enc_id','kabupaten','provinsi','selectedKabupaten'));
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
            $kabupaten    = Kabupaten::find($dec_id);
            $kabupaten->delete();

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
