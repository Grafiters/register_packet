<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;
use App\Models\DetailPaket;
use App\Models\RegisterPaket;
use App\Models\Contact;
use App\Models\ImageRegis;

use DB;

class LandingPageController extends Controller
{
    public function index(){
        $paket = Paket::where('status', 1)->get();

        return view('landing_page/index',compact('paket'));
    }

    public function detailPaket(Request $request){
        $paket = Paket::find($request->paket);

        if(!$paket){
            return $this->nodata('Maaf Data Kosong');
        }

        $detail = DetailPaket::select('detail_pakets.*' , 'speeds.name as speed')->leftJoin('speeds','speeds.id','detail_pakets.speed_id')->where('paket_id', $paket->id)->where('status', 1)->get();
        if(!$detail){
            return $this->nodata('Maaf Data Kosong');
        }

        $build_response = $this->build_response($paket, $detail);
        return $this->successSubmit('Get Data', $build_response);
    }

    private function build_response($paket, $detail){
        $paket = [
            'paket' => $paket->name,
            'description' => $paket->detail
        ];

        $newDetail = [];
        foreach ($detail as $key => $value) {
            $newDetail['detail'][$key] = [
                'code'  => $value->code,
                'speed' => $value->speed,
                'price' => number_format($value->price,0,',','.'),
                'description'   => $value->description
            ];
        }

        return array_merge($paket, $newDetail);
    }

    public function confirm($code){
        $query = DetailPaket::select('detail_pakets.*', 'pakets.name as paket', 'speeds.name as speed');
        $query->leftJoin('pakets','pakets.id','detail_pakets.paket_id');
        $query->leftJoin('speeds','speeds.id','detail_pakets.speed_id');
        $query->where('detail_pakets.code', $code);
        $paket = $query->first();

        // return response()->json($paket);
        return view('landing_page/confirm', compact('code', 'paket'));
    }

    private function img_list(){
        $array = array(
            0 => 'img_ktp',
            1 => 'img_kk',
            2 => 'img_selfie',
            3 => 'img_lokasi',
            4 => 'img_usaha',
            5 => 'img_nib'
        );

        return $array;
    }

    public function regis(Request $request){
        // return response()->json($this->img_list()[3]);
        DB::beginTransaction();

        try {
            $register = new RegisterPaket;
            $register->code = $request->code_paket;
            $register->nik  = $request->nik;
            $register->name = $request->name;
            $register->address  = $request->alamat;
            $register->usaha    = $request->usaha;
            $register->email    = $request->email;
            $register->note = $request->note;
            $register->save();
            if($register){
                for($i = 0; $i < count($request->contact); $i++){
                    $contact = new Contact;
                    $contact->register_paket_id = $register->id;
                    $contact->contact = $request->contact[$i];
                    $contact->save();
                }

                $path = 'web/images/'.$request->nik.'/';
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                    chmod($path, 0777);
                }

                for ($i=0; $i < 6; $i++) { 
                    if($request->file($this->img_list()[$i]) != null){
                        $fileName = $request->file($this->img_list()[$i])->getClientOriginalName();
                        $pathName = $path.$fileName;

                        $request->file($this->img_list()[$i])->move($path, $fileName);
                        chmod($path.$fileName, 0775);

                        $image = new ImageRegis;
                        $image->register_paket_id     = $register->id;
                        $image->name                  = $this->img_list()[$i];
                        $image->img                   = ($pathName) ? $pathName : NULL;
                        $image->save();
                    }else{
                        $pathName = 'assets/img/no-img.png';
                        $image = new ImageRegis;
                        $image->register_paket_id     = $register->id;
                        $image->name                  = $this->img_list()[$i];
                        $image->img                   = $pathName;
                        $image->save();
                    }
                }
            }

            DB::commit();
            return $this->successSubmit('Terimakasih Sudah Mandaftar, Silahkan menunggu konfirmasi dari admin', '');
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->failSubmit('Maaf Sedang terjadi kendala pada server silahkan hubungi admin');
        }
    }
}