<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use App\Models\Contact;
use App\Models\ImageRegis;
use App\Models\RegisterPaket;

class RegisterController extends Controller
{
    public function index(){
        return view('backend/register/index');
    }

    protected $original_column = array(
        1 => "code",
        2 => "nik",
        3 => "name",
        4 => "email",
    );

    protected $img_list = array(
        0 => 'Foto KTP / SIM',
        1 => 'Foto KK',
        2 => 'Foto Selfi Pegang KTP / SIM',
        3 => 'Foto Lokasi Tampak Depan',
        4 => 'Foto Usaha',
        5 => 'Foto NIB / SKU / SIUB'
    );

    private function contact($id){
        $contact = Contact::where('register_paket_id', $id)->get();
        foreach ($contact as $key => $value) {
            $no = $key + 1;
            $contacts[] = 'Contact '.$no. ' : '.$value->contact;
        }

        return implode('<br>', $contacts);
    }

    public function getData(Request $request){
        $limit = $request->length;
        $start = $request->start;
        $page  = $start +1;
        $search = $request->search['value'];

        $dataquery = RegisterPaket::select('*');
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
            $action.='<a href="#" onclick="detailImg(this,\''.$result->id.'\')" class="btn btn-primary btn-sm icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="fa fa-image"></i> Img</a>&nbsp;';
            $action.='<a href="'.route('admin.register.detail', $enc_id).'" class="btn btn-success btn-xs icon-btn md-btn-flat product-tooltip" title="Detail"><i class="fa fa-eye"></i> Detail</a>&nbsp;';
            $action.="</div>";

            $result->no             = $key+$page;
            $result->contact        = $this->contact($result->id);
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

    public function detailImg($id){

        $img    = ImageRegis::where('register_paket_id', $id)->get();
        if ($img){
            foreach ($img as $key => $value) {
                $value->fullname = $this->img_list[$key];
            }
            $return = [
                'img' => $img
            ];

            return $this->dataExists($return);
        }

        return $this->nodata('Maaf gambar tidak ada');
    }

    public function detailRegister($enc_id){
        $id = $this->safe_decode(Crypt::decryptString($enc_id));
        $register = RegisterPaket::find($id);
        if($register){
            $contact = Contact::where('register_paket_id', $id)->get();
            $img    = ImageRegis::where('register_paket_id', $id)->get();

            foreach ($img as $key => $value) {
                $value->fullname = $this->img_list[$key];
            }

            $register->contact  = $contact;
            $register->img = $img;
        }

        return view('backend/register/detail', compact('register'));
        return response()->json($register);
    }
}