<?php

namespace App\Http\Controllers;

use App\Models\Assist;
use App\Models\Dd_fr_ptm_keswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Models\Puskesmas;
use App\Models\Posyandu;
use App\Models\Kabupaten;
use App\Models\Certificate;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use App\Models\Kasus_ptm;
use App\Models\Odgj;
use App\Models\Program_ptm_keswa;

use DB;
use Auth;
use Carbon;
use LDAP\Result;
use Mpdf\Tag\I;

class BerandaController extends Controller
{


    public function index(){

        $reg_certificate = DB::table('certificate')->get();
        $certificate = $reg_certificate->count();

        $reg_puskesmas = DB::table('puskesmas')->get();
        $puskesmas = $reg_puskesmas->count();

        $reg_kecamatan = DB::table('kecamatan')->get();
        $kecamatan = $reg_kecamatan->count();

        $tot_kader_2022 = DB::table('kader')->whereYear('created_at','2022')->get();
        $tot_kader_2022 = $tot_kader_2022->count();

        $tot_kader_2023 = DB::table('kader')->whereYear('created_at','2023')->get();
        $tot_kader_2023 = $tot_kader_2023->count();

        $tot_kader_pratama = DB::table('kader')->where('posyandu',1)->get();
        $tot_kader_pratama = $tot_kader_pratama->count();

        $tot_kader_madya = DB::table('kader')->where('posyandu',2)->get();
        $tot_kader_madya = $tot_kader_madya->count();

        $tot_kader_purnama = DB::table('kader')->where('posyandu',3)->get();
        $tot_kader_purnama = $tot_kader_purnama->count();

        $tot_kader_mandiri = DB::table('kader')->where('posyandu',4)->get();
        $tot_kader_mandiri = $tot_kader_mandiri->count();

        return view('backend/beranda/index',compact('certificate','puskesmas','kecamatan','tot_kader_2022','tot_kader_2023',
                    'tot_kader_pratama','tot_kader_madya','tot_kader_purnama','tot_kader_mandiri'));
    }

    public function getDataKaderKabupaten(Request $request){
        $kabupatenData = Kabupaten::orderBy('name')->get();

        $kabupaten = [];
        foreach ($kabupatenData as $key => $value) {
            $kabupaten['name'][]   = $value->name;
            $explode    = explode(" ",  $value->name);
            $kader = Certificate::where('kabupaten_name', 'LIKE', "%{$explode[1]}%")->count();
            $kabupaten['nilai'][]   = $kader;
        }

        $data_array = collect([]);
        foreach ($kabupaten['name'] as $key => $value) {
            $collect = collect([
                'field' => $value,
                'nilai' => $kabupaten['nilai'][$key],
            ]);
            $data_array->push($collect);
        }
        $sorted = $data_array->sortByDesc('nilai');
        $new_result = [];
        $posyandu   = Posyandu::all();
        foreach ($sorted->values()->all() as $key => $value) {
            if ($key == 0) {
                if ($value['nilai'] < 1) {
                    $new_result['success'] = false;
                    break;
                }
            }

            $new_result['kabupaten'][] = $value['field'];
            $new_result['nilai'][] = $value['nilai'];

            foreach ($posyandu as $keys => $kunci) {
                $new_result[$kunci->name]['nilai'][] = $this->getDataPosyanduKabupaten($value['field'], $kunci->name);
            }
        }

        $data = [];
        foreach ($posyandu as $key => $value) {
            $result = Certificate::where('jenis_posyandu', 'LIKE', "%{$value->name}%")->count();

            $data[$key] = $result;
        }
        $new_result['pie']  = $data;

        if (!isset($new_result['success'])) {
            $new_result['success'] = true;
        }


        return response()->json(['data' => $new_result]);
    }

    public function getDataPosyanduKabupaten($kabupatenData, $kategori){
        // $kabupatenData = Kabupaten::orderBy('name')->get();

        $kabupaten = [];
        $explode    = explode(" ",  $kabupatenData);
        $posyandu   = Posyandu::all();
        $kader = Certificate::where('kabupaten_name', 'LIKE', "%{$explode[1]}%")->where('jenis_posyandu', 'LIKE', "%{$kategori}%")->count();

        return $kader;
    }
}
