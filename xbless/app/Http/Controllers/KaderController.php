<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

use App\Models\Kabupaten;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use App\Models\Puskesmas;
use App\Models\Certificate;
use App\Models\Role;
use App\Models\User;
use App\Models\Kader;
use App\Imports\KaderImport;
use App\Models\Posyandu;

use DB;
use Auth;
use Excel;

class KaderController extends Controller
{
    function safe_encode($string)
    {

        $data = str_replace(array('/'), array('_'), $string);
        return $data;
    }

    function safe_decode($string,$mode=null) {
        $data = str_replace(array('_'),array('/'),$string);
        return $data;
    }
    protected $original_column = array(
        1 => "nama_kader",
    );

    public function index()
    {
        if(auth()->user()->can('provinsi.index')){
            $kabupatendata  = Kabupaten::select('*')->where('provinsi_id', auth()->user()->provinsi_id)->get();
        }else{
            $kabupatendata  = Kabupaten::all();
        }
        
        $kecamatandata  = Kecamatan::select('kecamatan.*')->leftJoin('kabupaten','kabupaten.code_kabupaten','kecamatan.kabkot_id')->where('kabupaten.id', auth()->user()->kabupaten_id)->get();
        if(auth()->user()->can('provinsi.index')){
            $kabupaten = TRUE;
            $kecamatan = TRUE;
            $posyandu  = TRUE;
        }else if(auth()->user()->can('kabupaten.index')){
            $kabupaten = FALSE;
            $kecamatan = TRUE;
            $posyandu  = TRUE;
        }else if(auth()->user()->can('kecamatan.index')){
            $kabupaten = FALSE;
            $kecamatan = FALSE;
            $posyandu  = TRUE;
        }
        return view('template/kader/index', compact('kabupatendata','kecamatandata', 'kabupaten','kecamatan','posyandu'));
    }

    public function tambah(){
        $posyandu = DB::table('posyandu')->select('*')->get();
        $selectedPosyandu = '';
        $kabupaten = Kabupaten::orderBy('name', 'ASC')->get();
        $selectedKabupaten = (auth()->user()->can('kabupaten.index')) ? auth()->user()->kabupaten_id : '';
        $kecamatan         = Kecamatan::select('kecamatan.*')->leftJoin('kabupaten','kabupaten.code_kabupaten','kecamatan.kabkot_id')->where('kabupaten.id', auth()->user()->kabupaten_id)->get();
        // return response()->json($posyandu);
        return view('template/kader/form', compact('posyandu','selectedPosyandu','kabupaten','selectedKabupaten','kecamatan'));
    }

    public function getPuskesmas(Request $request)
    {
        if($request->kabupaten){
            $kabupaten = Kabupaten::find($request->kabupaten);
        }else{
            $kabupaten = Kabupaten::find(auth()->user()->kabupaten_id);
        }
        $explode    = explode(' ', $kabupaten->name);
        if($request->kecamatan){
            $kecamatan = Kecamatan::find($request->kecamatan);
            $explodeKec    = explode(' ', $kecamatan->name);
        }

        $puskesmas = Puskesmas::select('id', 'code', 'name')
            ->where('kabupaten', "LIKE", "%{$explode[1]}%");

        if($request->kecamatan){
            $kecamatan      = Kecamatan::find($request->kecamatan);

            $puskesmas->where('kecamatan', 'LIKE', "%{$kecamatan->name}%");
        }

        $result = $puskesmas->get();

        return json_encode($result);
    }

    public function getKecamatan(Request $request)
    {
        $kabupaten = Kabupaten::find($request->kabupaten);
        $explode    = explode(' ', $kabupaten->name);
        $kecamatan  = Kecamatan::where('kabkot_id', $kabupaten->code_kabupaten)->get();
        return json_encode($kecamatan);
    }

    public function getDesa(Request $request)
    {
        $result = Desa::where('kecamatan_id', $request->kecamatan)->get();
        return json_encode($result);
    }

    public function getData(Request $request)
    {
        $limit = $request->length;
        $start = $request->start;
        $page  = $start + 1;
        $search = $request->search['value'];

        if(auth()->user()->can('provinsi.index')){
            $dataquery = Kader::select('kader.id','kader.name','desa.name as desa','kader.name_desa','kader.domisili','kabupaten.name as kabupaten','puskesmas.name as puskesmas','posyandu.name as posyandu');
            $dataquery->leftJoin('desa','desa.id','kader.desa');
            $dataquery->leftJoin('kabupaten','kabupaten.id','kader.kabupaten');
            $dataquery->leftJoin('puskesmas','puskesmas.id','kader.puskesmas');
            $dataquery->leftJoin('posyandu','posyandu.id','kader.posyandu');
        }else if(auth()->user()->can('kabupaten.index')){
            $dataquery = Kader::select('kader.id','kader.name','desa.name as desa','kader.name_desa','kader.domisili','kabupaten.name as kabupaten','kader.name_kecamatan','kecamatan.name as kecamatan','puskesmas.name as puskesmas','posyandu.name as posyandu');
            $dataquery->leftJoin('desa','desa.id','kader.desa');
            $dataquery->leftJoin('kabupaten','kabupaten.id','kader.kabupaten');
            $dataquery->leftJoin('kecamatan','kecamatan.id','kader.kecamatan');
            $dataquery->leftJoin('puskesmas','puskesmas.id','kader.puskesmas');
            $dataquery->leftJoin('posyandu','posyandu.id','kader.posyandu');
        }else{
            $dataquery = Kader::select('kader.id','kader.name','desa.name as desa','kader.name_desa','kader.domisili','kabupaten.name as kabupaten','puskesmas.name as puskesmas','posyandu.name as posyandu');
            $dataquery->leftJoin('desa','desa.id','kader.desa');
            $dataquery->leftJoin('kabupaten','kabupaten.id','kader.kabupaten');
            $dataquery->leftJoin('puskesmas','puskesmas.id','kader.puskesmas');
            $dataquery->leftJoin('posyandu','posyandu.id','kader.posyandu');
        }

        if (array_key_exists($request->order[0]['column'], $this->original_column)) {
            $dataquery->orderByRaw($this->original_column[$request->order[0]['column']] . ' ' . $request->order[0]['dir']);
        } else {
            $dataquery->orderBy('kader.id', 'DESC');
        }

        if ($search) {
            $dataquery->where(function ($query) use ($search) {
                $query->orWhere('kader.name', 'LIKE', "%{$search}%");
            });
        }

        if($request->kabupaten != ''){
            $dataquery->where('kader.kabupaten', $request->kabupaten);
        }

        if($request->kecamatan != ''){
            if(auth()->user()->can('kabupaten.index')){
                $dataquery->where(function ($query) use ($search) {
                    $kabupaten = Kabupaten::find(auth()->user()->kabupaten_id);
                    $explode = explode(' ', $kabupaten->name);
    
                    $query->orWhere('kader.name_kabupaten', 'LIKE', "%{$explode[1]}%");
                    $query->orWhere('kader.kabupaten', auth()->user()->kabupaten_id);
                });
            }
            $dataquery->where('kader.kecamatan', $request->kecamatan);
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
            if($request->user()->can('master.kader.ubah')){
                $action .= '<a href="' . route('master.kader.ubah', $enc_id) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-edit"></i> Edit</a>&nbsp;';
            }
            // $action .= '<a href="' . route('certificate.generate.detail', $enc_id) . '" class="btn btn-success btn-xs icon-btn md-btn-flat product-tooltip" title="Cetak"><i class="fa fa-print"></i> Cetak Certificate</a>&nbsp;';
            if($request->user()->can('master.kader.hapus')){
                $action .= '<a href="#" onclick="deleteData(this,\'' . $enc_id . '\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="fa fa-times"></i> Hapus</a>&nbsp;';
            }
            $action .= "</div>";

            $result->no          = $key + $page;
            $result->desa        = ($result->desa != NULL) ? $result->desa : $result->name_desa;
            if(auth()->user()->can('provinsi.index')){
                $result->kabupaten   = ($result->id_kabupaten != NULL) ? $result->kabupaten : $result->kabupaten_name;
            }else if(auth()->user()->can('kabupaten.index')){
                $result->kabupaten   = ($result->kecamatan != NULL) ? $result->kecamatan : $result->name_kecamatan;
            }else{
                $result->kabupaten   = ($result->kabupaten != NULL) ? $result->kabupaten : $result->name_kabupaten;
            }
            $result->puskesmas   = ($result->puskesmas != NULL) ? $result->puskesmas : $result->name_puskesmas;
            $result->posyandu    = ($result->posyandu != NULL) ? $result->posyandu : $result->name_posyandu;
            
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

    public function simpan(Request $req){
        // return response()->json($req->all());
        $enc_id     = $req->enc_id;

        if ($enc_id != null) {
            $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        } else {
            $dec_id = null;
        }

            try {
                if ($enc_id) {
                    $kader              = Kader::find($dec_id);
                    $kader->name        = $req->name;
                    $kader->no_hp       = $req->telp;
                    if(auth()->user()->can('kabupaten.index')){
                        $kader->kabupaten   = auth()->user()->kabupaten_id;
                    }else{
                        $kader->kabupaten   = $req->kabupaten;
                    }
                    $kader->kecamatan   = $req->kecamatan;
                    $kader->puskesmas   = $req->puskesmas;
                    $kader->posyandu    = $req->level;
                    $kader->desa        = $req->desa;
                    $kader->domisili    = $req->domisili;
                    $kader->save();

                    $json_data = array(
                        "success"         => TRUE,
                        "message"         => 'Data berhasil diperbarui.'
                    );
                } else {
                    $kader              = new Kader;
                    $kader->name        = $req->name;
                    $kader->no_hp       = $req->telp;
                    if(auth()->user()->can('kabupaten.index')){
                        $kader->kabupaten   = auth()->user()->kabupaten_id;
                    }else{
                        $kader->kabupaten   = $req->kabupaten;
                    }
                    $kader->kecamatan   = $req->kecamatan;
                    $kader->puskesmas   = $req->puskesmas;
                    $kader->posyandu    = $req->level;
                    $kader->desa        = $req->desa;
                    $kader->domisili    = $req->domisili;
                    $kader->save();

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
        return json_encode($json_data);
    }

    public function ubah($enc_id){
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        if ($dec_id) {
            $kader              = Kader::select('kader.*','kabupaten.name as kabupaten_name','kecamatan.name as kecamatan_name','puskesmas.name as puskesmas_name','posyandu.name as posyandu_name')->leftJoin('kabupaten','kabupaten.id','kader.kabupaten')->leftJoin('kecamatan','kecamatan.id','kader.kecamatan')->leftJoin('puskesmas','puskesmas.id','kader.puskesmas')->leftJoin('posyandu','posyandu.id','kader.posyandu')->where('kader.id',$dec_id)->first();
            $posyandu           = DB::table('posyandu')->select('*')->get();
            $selectedPosyandu   = $kader->posyandu;
            $kabupaten          = Kabupaten::orderBy('name', 'ASC')->get();
            $selectedKabupaten  = $kader->kabupaten;
            
            // return response()->json($kader);
            return view('template/kader/form', compact('enc_id', 'kader','kabupaten','selectedKabupaten','posyandu','selectedPosyandu'));
        } else {
            $json_data = array(
                "success"         => FALSE,
                "message"         => "data tidak ditemukan"
            );
            return json_encode($json_data);
        }
    }

    public function hapus(Request $req, $enc_id){
        try {
            $dec_id   = $this->safe_decode(Crypt::decryptString($enc_id));
            $kader    = Kader::find($dec_id);
            if($kader){
                $certificate    = Certificate::where('id_kader', $kader->id)->first();
                if($certificate){
                    $json_data = array(
                        "success"         => 'gagal',
                        "message"         => 'Maaf, Kader tidak bisa dihapus karena masih mempunyai sertifikat pada sistem'
                    );
                }else{
                    $kader->delete();
                    $json_data = array(
                        "status"         => 'success',
                        "message"         => 'Data berhasil dihapus.'
                    );
                }
            }
        } catch (\Throwable $th) {
            $json_data = array(
                "success"         => 'gagal',
                "message"         => $th->getMessage()
            );
        }
        return response()->json($json_data);
    }

    public function import(){
        return view('template/kader/import');
    }

    private function checkIsNull($index){
        if(!$index){
            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function prosesImport(Request $request){
        $count = 0;
        $gagal = 0;
        $sukses = 0;
        $jumlah = 0;
        $hello = "";
        $ketgagal ="";

        if($request->hasFile('file')){
            $file = $request->file('file'); //GET FILE
            $data= Excel::toArray(new KaderImport, $file); //IMPORT FILE

            // return response()->json($data);
            foreach ($data[0] as $key => $value) {
                if(!$this->checkIsNull($value['nama_kader']) || !$this->checkIsNull($value['kabupaten']) || !$this->checkIsNull($value['kecamatan']) || !$this->checkIsNull($value['puskesmas']) || !$this->checkIsNull($value['desa']) || !$this->checkIsNull($value['posyandu'])){
                    $gagal++;
                    $ketgagal .='No '.$value['no'].' Gagal diinput karena terdapat data yang kosong<br/> ';
                }else{
                    // $kabupaten  = Kabupaten::where('code_kabupaten', $value['kode_kabupaten'])->first();
                    // $puskesmas  = Puskesmas::where('code', $value['kode_puskesmas'])->first();
                    // $posyandu   = Posyandu::where('name', 'LIKE', "%{$value['posyandu']}%")->first();

                    $checkKader = Kader::where('name', 'LIKE', "%{$value['nama_kader']}%")->where('kecamatan', 'LIKE',"%{$value['kecamatan']}%")->where('posyandu', 'LIKE',"%{$value['posyandu']}%")->first();

                    if($checkKader){
                        $gagal++;
                        $ketgagal .='No '.$value['no'].' Gagal diinput karena Kader sudah terdaftar pada sistem<br/> ';
                    }else{
                        $kader              = new Kader;
                        $kader->name        = $value['nama_kader'];
                        $kader->name_kabupaten   = $value['kabupaten'];
                        $kader->name_puskesmas   = $value['puskesmas'];
                        $kader->name_kecamatan   = $value['kecamatan'];
                        $kader->name_desa        = $value['desa'];
                        $kader->name_posyandu    = $value['posyandu'];
                        $kader->domisili    = $value['domisili'];
                        $kader->save();
    
                        $sukses++;
                    }
                }

                $count++;
            }
        }
        $jmlData = 'Jumlah Data: '.$count;
        $sukses = 'Sukses di Import: '.$sukses;
        $gagal  = 'Jumlah Gagal: '.$gagal;
        $descGagal = 'Keterangan Gagal:'.$ketgagal;

        return redirect()->back()->with('message', [
            'status'    => 'info',
            'jmlData'   => $jmlData,
            'sukses'    => $sukses,
            'gagal'     => $gagal,
            'descGagal' => $descGagal
        ]);
    }
}
