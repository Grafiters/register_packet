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
use App\Exports\ReportRecapExports;

use QrCode;
use DB;
use Auth;
use PDF;
use Excel;

class LaporanController extends Controller
{
    public function index()
    {
        $kabupaten    = Kabupaten::all();
        $puskesmas    = Puskesmas::all();
        $posyandu     = Posyandu::all();
        if(session('filter_tgl_start')==""){
            $tgl_start = date('d-m-Y', strtotime(' - 30 days'));
        }else{
            $tgl_start = session('filter_tgl_start');
        }

        if(session('filter_tgl_end')==""){
            $tgl_end = date('d-m-Y');
        }else{
            $tgl_end = session('filter_tgl_end');
        }
        return view('template/laporan/index',compact('kabupaten','puskesmas','posyandu','tgl_start','tgl_end'));
    }

    protected $original_column = array(
        1 => "nama_kader",
    );

    public function getData(Request $request)
    {
        $limit = $request->length;
        $start = $request->start;
        $page  = $start + 1;
        $search = $request->search['value'];
        $request->session()->put('filter_kabupaten', $request->filter_kabupaten);
        $request->session()->put('filter_puskesmas', $request->filter_puskesmas);
        $request->session()->put('filter_posyandu', $request->filter_posyandu);
        $request->session()->put('filter_tgl_start', $request->filter_tgl_start);
        $request->session()->put('filter_tgl_end', $request->filter_tgl_end);

        $filter_kabupaten        = $request->filter_kabupaten;
        $filter_puskesmas        = $request->filter_puskesmas;
        $filter_posyandu        = $request->filter_posyandu;
        $filter_tgl_start       = $request->filter_tgl_start;
        $filter_tgl_end         = $request->filter_tgl_end;

        ini_set('memory_limit', '1024M');
        $dataquery = Certificate::select('certificate.*','puskesmas.name as nama_puskesmas','kader.name as nama_kader','kabupaten.name as kabupaten', 'posyandu.name as posyandu','certificate.created_at')
        ->leftJoin('puskesmas', 'certificate.id_puskesmas', '=', 'puskesmas.id')
        ->leftJoin('kabupaten','kabupaten.id','certificate.id_kabupaten')
        ->leftJoin('posyandu','posyandu.id','certificate.id_posyandu')
        ->leftJoin('kader', 'certificate.id_kader','kader.id');

        if (array_key_exists($request->order[0]['column'], $this->original_column)) {
            $dataquery->orderByRaw($this->original_column[$request->order[0]['column']] . ' ' . $request->order[0]['dir']);
        } else {
            $dataquery->orderBy('id', 'DESC');
        }

        if ($search) {
            $dataquery->where(function ($query) use ($search) {
                $query->orWhere('nama_kader', 'LIKE', "%{$search}%");
            });
        }

        if($filter_tgl_start != "" && $filter_tgl_end !=""){
            $dataquery->whereDate('certificate.created_at','>=',date('Y-m-d',strtotime($filter_tgl_start)));
            $dataquery->whereDate('certificate.created_at','<=',date('Y-m-d',strtotime($filter_tgl_end)));
        }

        if($filter_kabupaten != "all"){
            $kabupaten   = Kabupaten::find($filter_kabupaten);
            $explode = explode(" ", $kabupaten->name);
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
        $data = $dataquery->get();
        foreach ($data as $key => $result) {
            $enc_id = $this->safe_encode(Crypt::encryptString($result->id));
            $action = "";

            $action .= "";
            $action .= "<div class='btn-group'>";
            // $action .= '<a href="' . route('certificate.generate.ubah', $enc_id) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-edit"></i> Edit</a>&nbsp;';
            $action .= '<a href="' . route('certificate.generate.detail', $enc_id) . '" class="btn btn-success btn-xs icon-btn md-btn-flat product-tooltip" title="Cetak"><i class="fa fa-print"></i> Cetak Certificate</a>&nbsp;';
            $action .= '<a href="' . route('sertifikat', [$enc_id]) . '"  target="_blank" class="btn btn-white btn-xs icon-btn md-btn-flat product-tooltip" title="Cetak"><i class="fa fa-link"></i> Link Sertifikat</a>&nbsp;';
            $action .= "</div>";

            $result->no          = $key + $page;
            $result->kabupaten   = ($result->id_kabupaten) ? $result->kabupaten : $result->kabupaten_name;
            $result->puskesmas   = ($result->id_puskesmas) ? $result->nama_puskesmas : $result->puskesmas_name;
            $result->kader       = ($result->id_kader) ? $result->nama_kader : $result->kader_name;
            $result->posyandu    = ($result->id_posyandu) ? $result->posyandu_name : $result->posyandu_name;
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

    function safe_encode($string)
    {

        $data = str_replace(array('/'), array('_'), $string);
        return $data;
    }

    function safe_decode($string,$mode=null) {
        $data = str_replace(array('_'),array('/'),$string);
        return $data;
    }

    public function print(Request $request){
        $start = $request->start;
        $page  = $start + 1;

        $filter_posyandu        = $request->filter_posyandu;
        $filter_tgl_start       = $request->filter_tgl_start;
        $filter_tgl_end         = $request->filter_tgl_end;

        ini_set('memory_limit', '1024M');
        $query = Certificate::select('certificate.id','certificate.id_posyandu','puskesmas.name as nama_puskesmas','kader.name as nama_kader','kabupaten.name as kabupaten', 'posyandu.name as posyandu','certificate.created_at')
        ->leftJoin('puskesmas', 'certificate.id_puskesmas', '=', 'puskesmas.id')
        ->leftJoin('kabupaten','kabupaten.id','certificate.id_kabupaten')
        ->leftJoin('posyandu','posyandu.id','certificate.id_posyandu')
        ->leftJoin('kader', 'certificate.id_kader','kader.id');

        if($filter_tgl_start != "" && $filter_tgl_end !=""){
            $query->whereDate('certificate.created_at','>=',date('Y-m-d',strtotime($filter_tgl_start)));
            $query->whereDate('certificate.created_at','<=',date('Y-m-d',strtotime($filter_tgl_end)));
        }

        if($filter_posyandu != "all"){
            $query->where('certificate.id_posyandu',$filter_posyandu);
        }
        $data = $query->get();

        foreach($data as $key=> $value)
        {
            $value->no          = $value->id;
            $value->kabupaten   = ($value->id_kabupaten) ? $value->kabupaten : $value->kabupaten_name;
            $value->puskesmas   = ($value->id_puskesmas) ? $value->nama_puskesmas : $value->puskesmas_name;
            $value->kader       = ($value->id_kader) ? $value->nama_kader : $value->kader_name;
            $value->posyandu    = ($value->id_posyandu) ? $value->posyandu_name : $value->posyandu_name;
            $value->kader       = $value->nama_kader;

        }
        return view('template/laporan/print',compact('data','filter_tgl_start','filter_tgl_end'));
    }

    public function pdf(Request $request){

        $filter_posyandu        = session('filter_posyandu');
        $filter_tgl_start       = session('filter_tgl_start');
        $filter_tgl_end         = session('filter_tgl_end');

        ini_set('memory_limit', '1024M');
        $query = Certificate::select('certificate.id','certificate.id_posyandu','puskesmas.name as nama_puskesmas','kader.name as nama_kader','kabupaten.name as kabupaten', 'posyandu.name as posyandu','certificate.created_at')
        ->leftJoin('puskesmas', 'certificate.id_puskesmas', '=', 'puskesmas.id')
        ->leftJoin('kabupaten','kabupaten.id','certificate.id_kabupaten')
        ->leftJoin('posyandu','posyandu.id','certificate.id_posyandu')
        ->leftJoin('kader', 'certificate.id_kader','kader.id');

        if($filter_tgl_start != "" && $filter_tgl_end !=""){
            $query->whereDate('certificate.created_at','>=',date('Y-m-d',strtotime($filter_tgl_start)));
            $query->whereDate('certificate.created_at','<=',date('Y-m-d',strtotime($filter_tgl_end)));
        }

        if($filter_posyandu != "all"){
            $query->where('certificate.id_posyandu',$filter_posyandu);
        }
        $data = $query->get();
        foreach($data as $key=> $value)
        {
            $value->no          = $value->id;
            $value->kabupaten   = ($value->id_kabupaten) ? $value->kabupaten : $value->kabupaten_name;
            $value->puskesmas   = ($value->id_puskesmas) ? $value->nama_puskesmas : $value->puskesmas_name;
            $value->kader       = ($value->id_kader) ? $value->nama_kader : $value->kader_name;
            $value->posyandu    = ($value->id_posyandu) ? $value->posyandu_name : $value->posyandu_name;
        }
        $config = [
            'mode'                  => '',
            'format'                => 'A4',
            'default_font_size'     => '11',
            'default_font'          => 'sans-serif',
            'margin_left'           => 5,
            'margin_right'          => 5,
            'margin_top'            => 30,
            'margin_bottom'         => 20,
            'margin_header'         => 0,
            'margin_footer'         => 0,
            'orientation'           => 'L',
            'title'                 => 'CETAK PDF',
            'author'                => '',
            'watermark'             => '',
            'show_watermark'        => true,
            'show_watermark_image'  => true,
            'mirrorMargins'         => 1,
            'watermark_font'        => 'sans-serif',
            'display_mode'          => 'default',
        ];
        $pdf = PDF::loadView('template/laporan/pdf', ['data'=>$data,'filter_tgl_start'   => $filter_tgl_start,'filter_tgl_end'   => $filter_tgl_end ],[],$config);
        ob_get_clean();
        return $pdf->stream('Report Laporan Rekap"'.date('d_m_Y H_i_s').'".pdf');
    }

    public function excel(Request $request)
    {
        $filter_posyandu        = session('filter_posyandu');
        $filter_tgl_start       = session('filter_tgl_start');
        $filter_tgl_end         = session('filter_tgl_end');
        $filter_kabupaten       = session('filter_kabupaten');
        $filter_puskesmas       = session('filter_puskesmas');
        
        return Excel::download(new ReportRecapExports($filter_posyandu,$filter_tgl_start,$filter_tgl_end, $filter_kabupaten, $filter_puskesmas),'Report Recap Kader Posyandu.xlsx');
    }


}
