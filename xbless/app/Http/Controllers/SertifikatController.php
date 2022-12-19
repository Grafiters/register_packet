<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Models\Kabupaten;
use App\Models\Provinsi;

use App\Models\Puskesmas;
use App\Models\Kader;
use App\Models\Posyandu;
use App\Models\Certificate;
use App\Models\KepalaBidang;

use QrCode;
use DB;
use Auth;

class SertifikatController extends Controller
{
    public function index()
    {
        $kabupaten    = Kabupaten::all();
        $puskesmas    = Puskesmas::limit(10)->get();
        $posyandu     = Posyandu::all();

        return view('template/certificates/generate_certificate/index',compact('kabupaten','puskesmas','posyandu'));
    }

    protected $original_column = array(
        1 => "nama_kader",
    );

    public function tambah()
    {
        $kabupaten = Kabupaten::orderBy('name', 'ASC')->get();
        $selectedKabupaten = '';
        $puskesmas = Puskesmas::all();
        $selectedPuskesmas = '';
        $kader = Kader::all();
        $selectedKader = '';
        $posyandu = Posyandu::all();
        $selectedPosyandu = "";

        return view('template/certificates/generate_certificate/form', compact('posyandu', 'selectedPosyandu', 'puskesmas', 'selectedPuskesmas','kader','selectedKader', 'kabupaten', 'selectedKabupaten'));
    }

    public function getPuskesmas(Request $request){
        $kabupaten = Puskesmas::where('kabupaten',$request->puskesmas)->get();

        return json_encode($kabupaten);
    }

    public function getKader(Request $request){
        $query = Kader::select('*');
        if($request->kabupaten){
            $query->where('kabupaten', $request->kabupaten);
        }

        if($request->puskesmas){
            $query->where('puskesmas', $request->puskesmas);
        }

        $result = $query->get();

        return json_encode($result);
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

        $cek_nama = $this->cekExist('id_puskesmas','id_kader','id_posyandu', $req->level, $req->kader, $req->posyandu, $dec_id);
        if (!$cek_nama) {
            $json_data = array(
                "success"         => FALSE,
                "message"         => 'Mohon maaf. Sertifikat oleh kader sudah terdaftar pada sistem.'
            );
        } else {

            try {
                if ($enc_id) {
                    $certificate = Certificate::find($dec_id);
                    $certificate->id_kabupaten      = $req->kabupaten;
                    // return response()->json(['data' => $puskesmas]);
                    $certificate->id_puskesmas   = $req->level;
                    $certificate->id_kader       = $req->kader;
                    $certificate->id_posyandu    = $req->posyandu;
                    $certificate->save();

                    $json_data = array(
                        "success"         => TRUE,
                        "message"         => 'Data berhasil diperbarui.'
                    );
                } else {
                    $certificate                    = new Certificate;
                    $certificate->nomor_certificate = $this->generateKode();
                    $certificate->id_kabupaten      = $req->kabupaten;
                    $certificate->id_puskesmas      = $req->level;
                    $certificate->id_kader          = $req->kader;
                    $certificate->id_posyandu       = $req->posyandu;
                    $certificate->save();

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

    private function cekExist($column_pus,$column_kader,$column_pos, $var, $var2, $var3, $id)
    {
        $cek = Certificate::where('id', '!=', $id)
        ->where($column_pus, '=', $var)
        ->where($column_kader, '=', $var2)
        ->where($column_pos, '=', $var3)->first();

        return (!empty($cek) ? false : true);
    }

    public function getData(Request $request)
    {
        $limit = $request->length;
        $start = $request->start;
        $page  = $start + 1;
        $search = $request->search['value'];
        
        $request->session()->put('filter_kabupaten', $request->filter_kabupaten);
        $request->session()->put('filter_puskesmas', $request->filter_puskesmas);
        $request->session()->put('filter_posyandu', $request->filter_posyandu);

        $filter_kabupaten       = $request->filter_kabupaten;
        $filter_puskesmas       = $request->filter_puskesmas;
        $filter_posyandu        = $request->filter_posyandu;

        ini_set('memory_limit', '1024M');
        if(auth()->user()->can('provinsi.index')){
            $dataquery = Certificate::select('certificate.*','puskesmas.name as nama_puskesmas','kader.name as nama_kader','kabupaten.name as kabupaten', 'posyandu.name as posyandu')
            ->leftJoin('puskesmas', 'certificate.id_puskesmas', '=', 'puskesmas.id')
            ->leftJoin('kabupaten','kabupaten.id','certificate.id_kabupaten')
            ->leftJoin('posyandu','posyandu.id','certificate.id_posyandu')
            ->leftJoin('kader', 'certificate.id_kader','kader.id');
            // ->where('kabupaten.provinsi_id', auth()->user()->provinsi_id);
        }else if(auth()->user()->can('kabupaten.index')){
            $dataquery = Certificate::select('certificate.*','puskesmas.name as nama_puskesmas','kader.name as nama_kader','puskesmas.kecamatan as kecamatan','kabupaten.name as kabupaten', 'posyandu.name as posyandu')
            ->leftJoin('puskesmas', 'certificate.id_puskesmas', '=', 'puskesmas.id')
            ->leftJoin('kabupaten','kabupaten.id','certificate.id_kabupaten')
            ->leftJoin('posyandu','posyandu.id','certificate.id_posyandu')
            ->leftJoin('kader', 'certificate.id_kader','kader.id');
            $dataquery->where(function ($query) use ($search) {
                $kabupaten = Kabupaten::find(auth()->user()->kabupaten_id);
                $explode = explode(' ', $kabupaten->name);

                $query->orWhere('certificate.kabupaten_name', 'LIKE', "%{$explode[1]}%");
                $query->orWhere('certificate.id_kabupaten', auth()->user()->kabupaten_id);
            });
        }else{
            $dataquery = Certificate::select('certificate.*','puskesmas.name as nama_puskesmas','kader.name as nama_kader','kabupaten.name as kabupaten', 'posyandu.name as posyandu')
            ->leftJoin('puskesmas', 'certificate.id_puskesmas', '=', 'puskesmas.id')
            ->leftJoin('kabupaten','kabupaten.id','certificate.id_kabupaten')
            ->leftJoin('posyandu','posyandu.id','certificate.id_posyandu')
            ->leftJoin('kader', 'certificate.id_kader','kader.id');
        }

        if($filter_kabupaten != "all"){
            $kabupaten  = Kabupaten::find($filter_kabupaten);
            $explode    = explode(" ", $kabupaten->name);
            $dataquery->where('certificate.kabupaten_name','LIKE', "%{$explode[1]}%");
        }

        if($filter_puskesmas != "all"){
            $puskesmas   = Puskesmas::find($filter_puskesmas);
            $dataquery->where('certificate.puskesmas_name','LIKE', "%{$puskesmas->name}%");
        }

        if($filter_posyandu != "all"){
            $posyandu   = Posyandu::find($filter_posyandu);
            $dataquery->where('certificate.jenis_posyandu','LIKE', "%{$posyandu->name}%");
        }

        $totalData = $dataquery->get()->count();
        $totalFiltered = $dataquery->get()->count();

        $dataquery->limit($limit);
        $dataquery->offset($start);

        if (array_key_exists($request->order[0]['column'], $this->original_column)) {
            $dataquery->orderByRaw($this->original_column[$request->order[0]['column']] . ' ' . $request->order[0]['dir']);
        } else {
            $dataquery->orderBy('id', 'DESC');
        }

        if ($search) {
            $dataquery->where(function ($query) use ($search) {
                $query->orWhere('certificate.kader_name', 'LIKE', "%{$search}%");
                $query->orWhere('certificate.puskesmas_name', 'LIKE', "%{$search}%");
                $query->orWhere('certificate.kabupaten_name', 'LIKE', "%{$search}%");
                $query->orWhere('certificate.posyandu_name', 'LIKE', "%{$search}%");
            });
        }

        $data = $dataquery->get();
        foreach ($data as $key => $result) {
            $enc_id = $this->safe_encode(Crypt::encryptString($result->id));
            // $sertif = ($result->id_kader != NULL) ? $enc_id :  ;

            $action = "";

            $action .= "";
            $action .= "<div class='btn-group'>";
            // $action .= '<a href="' . route('certificate.generate.ubah', $enc_id) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-edit"></i> Edit</a>&nbsp;';
            $action .= '<a href="' . route('certificate.generate.detail', $enc_id) . '" class="btn btn-success btn-xs icon-btn md-btn-flat product-tooltip" title="Cetak"><i class="fa fa-print"></i> Cetak Certificate</a>&nbsp;';
            $action .= '<a href="#" onclick="deleteData(this,\'' . $enc_id . '\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="fa fa-times"></i> Hapus</a>&nbsp;';
            $action .= '<a href="' . route('sertifikat', [$enc_id]) . '"  target="_blank" class="btn btn-white btn-xs icon-btn md-btn-flat product-tooltip" title="Cetak"><i class="fa fa-link"></i> Link Sertifikat</a>&nbsp;';
            $action .= "</div>";

            $result->no          = $key + $page;
            if(auth()->user()->can('provinsi.index')){
                $result->kabupaten   = ($result->id_kabupaten != NULL) ? $result->kabupaten : $result->kabupaten_name;
            }else if(auth()->user()->can('kabupaten.index')){
                $explode = explode(' ', $result->puskesmas_name);
                $puskesmas = Puskesmas::where('kabupaten', 'LIKE', "%{$result->kabupaten_name}%")->where('name', 'LIKE', "%{$explode[0]}%")->first();
                $result->kabupaten   = $puskesmas->kecamatan;
            }else{
                $result->kabupaten   = ($result->id_kabupaten != NULL) ? $result->kabupaten : $result->kabupaten_name;
            }

            $result->puskesmas   = ($result->id_puskesmas != NULL) ? $result->nama_puskesmas : $result->puskesmas_name;
            $result->kader       = ($result->id_kader != NULL ) ? $result->nama_kader : $result->kader_name;
            $result->posyandu    = ($result->id_posyandu != NULL ) ? $result->posyandu : $result->posyandu_name;
            $result->action      = $action;
        }
        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        return json_encode($json_data);
    }

    public function cetak($enc_id){
        $detail = array();
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        $certificate    = Certificate::where('id', $dec_id)->with(['getPuskesmas', 'getKader','getPosyandu'])->first();
        $explode = explode(' ', $certificate->puskesmas_name);
        $pieces = explode(' ', $certificate->kabupaten_name);
        $last_word = array_pop($pieces);
        $puskesmas = Puskesmas::where('kabupaten', 'LIKE', "%{$last_word}%")->where('name', 'LIKE', "%{$explode[0]}%")->first();
        // $certificate->kecamatan_name = $puskesmas->kecamatan;

        $detail[]       = $certificate;
        $kadin          = KepalaBidang::where('status', 1)->first();
        $link           = route('sertifikat', [$enc_id]);

        return view('template/certificates/generate_certificate/cetak',
        [
            'certificate' => $detail,
            'kadin'         => $kadin,
            'link'          => $link
        ]);
    }

    public function cetakall(Request $req){
       $detail = array();
       $kadin          = KepalaBidang::where('status', 1)->first();
        if(count($req->id_sertif) > 0){
            foreach ($req->id_sertif as $key => $result) {
                $certificate = Certificate::where('id', $result)->with(['getPuskesmas', 'getKader','getPosyandu'])->first();
                $explode = explode(' ', $certificate->puskesmas_name);
                $puskesmas = Puskesmas::where('kabupaten', 'LIKE', "%{$certificate->kabupaten_name}%")->where('name', 'LIKE', "%{$explode[0]}%")->first();

                // $certificate->kecamatan_name = $puskesmas->kecamatan;
                $detail[] = $certificate;
            }
        }
        $link           = route('sertifikat', [$enc_id]);
        //return json_encode($detail);
        return view('template/certificates/generate_certificate/cetak',
        [
            'certificate'   => $detail,
            'kadin'         => $kadin,
            'link'          => $link
        ]);

    }

    public function detail($enc_id){

        $kadin          = KepalaBidang::where('status', 1)->first();
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        $certificate = Certificate::where('id', $dec_id)->with(['getPuskesmas', 'getKader'])->first();
        $detail_kader = $certificate->getKader;
        $detail_puskesmas = $certificate->getPuskesmas;
        $posyandu = Posyandu::find($certificate->id_posyandu);
        if(isset($posyandu)){
            $posyandu = $posyandu->name;
        }else{
            $posyandu = $certificate->posyandu_name;
        }

        $explode = explode(' ', $certificate->puskesmas_name);
        $puskesmas = Puskesmas::where('kabupaten', 'LIKE', "%{$certificate->kabupaten_name}%")->where('name', 'LIKE', "%{$explode[0]}%")->first();
        $link           = route('sertifikat', [$enc_id]);

        return view('template/certificates/generate_certificate/detail',
        [
            'enc_id' => $enc_id,
            'certificate' => $certificate,
            'jenis_kader' => $detail_kader,
            'jenis_puskesmas' => $puskesmas,
            'jenis_posyandu' => $posyandu,
            'link'      => $link,
            'kadin'         => $kadin,
        ]);
    }

    public function getSertifikat($enc_id){
        $detail = array();
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        $certificate = Certificate::where('id', $dec_id)->with(['getPuskesmas', 'getKader','getPosyandu'])->first();
        $detail[] = $certificate;
        $kadin          = KepalaBidang::where('status', 1)->first();
        $link           = route('sertifikat', [$enc_id]);
        return view('template/certificates/generate_certificate/cetak',
        [
            'certificate' => $detail,
            'kadin'         => $kadin,
            'link'          => $link
        ]);
    }

    function safe_encode($string)
    {
        $data = str_replace(array('/'), array('_'), $string);
        return $data;
    }

    function safe_decode($string,$mode=null) {
        $data = str_replace(array('_'),array('/'),$string);
        return $data;
    }

    public function generateKode()
      {
            $next_no = '';
            $tahun = date('y');
            $bulan = date('m');
            $format="CERT-".$tahun.'-'.$bulan.'-';
            $max_value = Certificate::max('id');
            if ($max_value) {
                $data  = Certificate::find($max_value);
                $ambil = substr($data->nomor_certificate, -4);
            }
            if ($max_value==null) {
                $next_no = '0001';
            }elseif (strlen($ambil)<4) {
                $next_no = '0001';
            }elseif ($ambil == '9999') {
                $next_no = '0001';
            }else {
                $next_no = substr('0000', 0, 4-strlen($ambil+1)).($ambil+1);
            }
            return $format.''.$next_no;
      }

}
