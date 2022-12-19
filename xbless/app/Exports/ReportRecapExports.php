<?php

namespace App\Exports;

use DB;

use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Shared\Date;

use Illuminate\Contracts\View\View;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

use App\Models\Certificate;
use App\Models\Kabupaten;
use App\Models\Puskesmas;

class ReportRecapExports implements FromView,ShouldAutoSize
{


    protected $filter_posyandu;
    protected $filter_tgl_start;
    protected $filter_tgl_end;
    protected $filter_puskesmas;
    protected $filter_kabupaten;


    public function __construct($filter_posyandu,$filter_tgl_start,$filter_tgl_end, $filter_kabupaten, $filter_puskesmas)
    {
        $this->filter_posyandu      = $filter_posyandu;
        $this->filter_tgl_start     = $filter_tgl_start;
        $this->filter_tgl_end       = $filter_tgl_end;
        $this->filter_puskesmas     = $filter_puskesmas;
        $this->filter_kabupaten     = $filter_kabupaten;

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

    public function view(): View
    {
        ini_set('memory_limit', '2048M');
        $query = Certificate::select('certificate.*','puskesmas.name as nama_puskesmas','kader.name as nama_kader','kabupaten.name as kabupaten', 'posyandu.name as posyandu','certificate.created_at')
        ->leftJoin('puskesmas', 'certificate.id_puskesmas', '=', 'puskesmas.id')
        ->leftJoin('kabupaten','kabupaten.id','certificate.id_kabupaten')
        ->leftJoin('posyandu','posyandu.id','certificate.id_posyandu')
        ->leftJoin('kader', 'certificate.id_kader','kader.id');

        if($this->filter_tgl_start != "" && $this->filter_tgl_end !=""){
          $query->whereDate('certificate.created_at','>=',date('Y-m-d',strtotime($this->filter_tgl_start)));
          $query->whereDate('certificate.created_at','<=',date('Y-m-d',strtotime($this->filter_tgl_end)));
        }

        if($this->filter_kabupaten != "all"){
            $kabupaten   = Kabupaten::find($this->filter_kabupaten);
            $explode = explode(" ", $kabupaten->name);
            $query->where('certificate.kabupaten_name','LIKE', "%{$explode[1]}%");
        }

        if($this->filter_puskesmas != "all"){
            $puskesmas   = Puskesmas::find($this->filter_puskesmas);
            $query->where('certificate.puskesmas_name','LIKE', "%{$puskesmas->name}%");
        }

        if($this->filter_posyandu != "all"){
            $query->where('certificate.id_posyandu',$this->filter_posyandu);
        }

        $data = $query->get();
        $temp =0;
        foreach($data as $key=> $value)
        {
            $enc_id = $this->safe_encode(Crypt::encryptString($value->id));
            $action = "";

            $value->id          = $value->id;
            $value->kabupaten   = ($value->id_kabupaten) ? $value->kabupaten : $value->kabupaten_name;
            $value->puskesmas   = ($value->id_puskesmas) ? $value->nama_puskesmas : $value->puskesmas_name;
            $value->kader       = ($value->id_kader) ? $value->nama_kader : $value->kader_name;
            $value->posyandu    = ($value->id_posyandu) ? $value->posyandu_name : $value->posyandu_name;
            $value->link        = route('sertifikat', [$enc_id]);
        }

        if($this->filter_kabupaten != "all"){
            $kabupaten = Kabupaten::find($this->filter_kabupaten);
            $kabupaten      = $kabupaten->name;
        }else{
            $kabupaten      = "all";
        }

        if($this->filter_puskesmas != "all"){
            $puskesmas = Puskesmas::find($this->filter_puskesmas);
            $puskesmas      = $puskesmas->name;
        }else{
            $puskesmas      = "all";
        }


        return view('template/laporan/excel', [
                'data' => $data,
                'filter_tgl_start'          => $this->filter_tgl_start,
                'filter_tgl_end'            => $this->filter_tgl_end,
                'filter_kabupaten'          => $kabupaten,
                'filter_puskesmas'          => $puskesmas
        ]);
    }
}
