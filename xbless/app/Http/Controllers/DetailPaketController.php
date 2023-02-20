<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

use App\Models\Speed;
use App\Models\Paket;
use App\Models\DetailPaket;

class DetailPaketController extends Controller
{
    protected $original_column = array(
        1 => "name",
    );

    private function checkDetailPaket($paket, $speed){
        $detail = DetailPaket::where('paket_id', $paket)->where('speed_id', $speed)->first();

        return (!empty($detail)) ? false : true;
    }

    private function paket(){
        return Paket::listPaket();
    }

    private function speed(){
        return Speed::listSpeed();
    }

    public function index(){
        return view('backend/master/paket/detail/index');
    }

    public function getdata(Request $request){
        $limit = $request->length;
        $start = $request->start;
        $page  = $start +1;
        $search = $request->search['value'];

        $dataquery = DetailPaket::select('detail_pakets.*', 'speeds.name as speed', 'pakets.name as paket');
        $dataquery->leftJoin('speeds', 'speeds.id', 'detail_pakets.speed_id');
        $dataquery->leftJoin('pakets', 'pakets.id', 'detail_pakets.paket_id');
        if(array_key_exists($request->order[0]['column'], $this->original_column)){
           $dataquery->orderByRaw($this->original_column[$request->order[0]['column']].' '.$request->order[0]['dir']);
        }else{
            $dataquery->orderBy('detail_pakets.id','DESC');
        }

        if($search) {
            $dataquery->where(function ($query) use ($search) {
                $query->orWhere('detail_pakets.price', 'LIKE', "%{str_replace('.','',$search)}%");
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

            if ($result->status == 1) {
                $status = '<span class="label label-primary">Aktif</span>';
            } else if ($result->status == 0) {
                $status = '<span class="label label-warning">Tidak Aktif</span>';
            }

            $result->no             = $key+$page;
            $result->status         = $status;
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
        $paket  = $this->paket();
        $speed  = $this->speed();

        return view('backend/master/paket/detail/form', compact('speed', 'paket'));
    }

    public function simpan(Request $request){
        // return response()->json($request->all());
        if ($request->enc_id != null) {
            $dec_id = $this->safe_decode(Crypt::decryptString($request->enc_id));
        }else{
            $dec_id = null;
        }

        $check_speed = $this->checkDetailPaket($request->paket, $request->speed);

        if(!$check_speed){
            return $this->duplicateEntry('Paket ');
        }

        if(!$dec_id){
            $data   = new DetailPaket;
            $data->code         = strtoupper(Str::random(8));
            $data->paket_id     = $request->paket;
            $data->speed_id     = $request->speed;
            $data->price        = str_replace('.','',$request->harga);
            $data->description  = $request->benefit;
            $data->save();

            $action = 'Menyimpan';
        }else{
            $data   = DetailPaket::find($dec_id);
            // $data->code         = strtoupper(Str::random(8));
            $data->paket_id     = $request->paket;
            $data->speed_id     = $request->speed;
            $data->price        = str_replace('.','',$request->price);
            $data->description  = $request->description;
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

        $data = DetailPaket::find($dec_id);
        if(!$data){
            return $this->nodata('Data Paket tidak ditemukan');
        }

        return view('backend/master/paket/detail/form', compact('enc_id','data'));

    }

    public function delete($enc_id){
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        $data = DetailPaket::find($dec_id);
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
