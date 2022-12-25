<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

use App\Models\Paket;

class PaketController extends Controller
{
    protected $original_column = array(
        1 => "name",
    );

    public function index(){
        return view('backend/master/paket/index');
    }

    public function getdata(Request $request){
        $limit = $request->length;
        $start = $request->start;
        $page  = $start +1;
        $search = $request->search['value'];

        $dataquery = Paket::select('*');
        if(array_key_exists($request->order[0]['column'], $this->original_column)){
           $dataquery->orderByRaw($this->original_column[$request->order[0]['column']].' '.$request->order[0]['dir']);
        }else{
            $dataquery->orderBy('id','DESC');
        }

        if($search) {
            $dataquery->where(function ($query) use ($search) {
                $query->orWhere('name', 'LIKE', "%{$search}%");
            });
        }

        $totalData = $dataquery->get()->count();

        $totalFiltered = $dataquery->get()->count();

        $dataquery->limit($limit);
        $dataquery->offset($start);
        $data = $dataquery->get();
        foreach ($data as $key=> $result){
            $enc_id = $this->safe_encode(Crypt::encryptString($result->id));
            $action = "";

            $action.="";
            $action.="<div class='btn-group'>";
            $action.='<a href="'.route('admin.master.kategori.paket.ubah', $enc_id).'" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;';
            $action.='<a href="#" onclick="deleteData(this,\''.$enc_id.'\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="fa fa-times"></i> Hapus</a>&nbsp;';
            $action.="</div>";

            $result->no             = $key+$page;
            $result->action         = $action;
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        return json_encode($json_data);
    }

    public function tambah(){
        return view('backend/master/paket/form');
    }

    public function simpan(Request $request){
        if ($request->enc_id != null) {
            $dec_id = $this->safe_decode(Crypt::decryptString($request->enc_id));
        }else{
            $dec_id = null;
        }

        $check_name = $this->cekExist('pakets','name', $request->name, $dec_id);

        if(!$check_name){
            return $this->duplicateEntry('Kecepatan Jaringan');
        }

        if(!$dec_id){
            $data   = new Paket;
            $data->code         = strtoupper(Str::random(8));
            $data->name         = $request->name;
            $data->detail       = $request->detail;
            $data->save();

            $action = 'Menyimpan';
        }else{
            $data   = Paket::find($dec_id);
            $data->name         = $request->name;
            $data->detail       = $request->detail;
            $data->save();

            $action = 'Mengubah';
        }

        if(!$data){
            return $this->failSubmit('Terjadi kesalahan pada sistem');
        }

        return $this->successSubmit($action, '');
    }

    public function edit($enc_id){
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));

        $data = Paket::find($dec_id);
        if(!$data){
            return $this->nodata('Data Paket tidak ditemukan');
        }

        return view('backend/master/paket/form', compact('enc_id','data'));

    }

    public function delete($enc_id){
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        $data = Paket::find($dec_id);
        if(!$data){
            return $this->nodata('Data Paket tidak ditemukan');
        }

        $paket_detail = $this->cekExist('detail_pakets','paket_id', $dec_id, NULL);
        if(!$paket_detail){
            return $this->failSubmit('Maaf, Data masih digunakan');
        }

        $data->delete();
        return $this->successSubmit('Menghapus', '');
    }
}
