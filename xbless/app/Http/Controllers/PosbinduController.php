<?php

namespace App\Http\Controllers;

use App\Exports\ExportExcel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Models\Puskesmas;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Posbindu;
use App\Models\Program_ptm_keswa;
use PDF;

use DB;
use Auth;
use Carbon;
use Maatwebsite\Excel\Facades\Excel;

class PosbinduController extends Controller
{
    protected $original_column = array(
        1 => "name",
    );

    public function index()
    {
        if (auth()->user()->can('provinsi.index')) {
            $kabupaten = Kabupaten::all();
        } elseif (auth()->user()->can('balkesmas.index')) {
            $kabupaten = Kabupaten::where('balkesmas_id', auth()->user()->balkesmas_id)->get();
        } else {
            $kabupaten = [];
        }
        if (auth()->user()->can('kabupaten.index')) {
            $user = Kabupaten::find(auth()->user()->kabupaten_id);
        } else if (auth()->user()->can('puskesmas.index')) {
            $user = Puskesmas::find(auth()->user()->puskesmas_id);
        } else if (auth()->user()->can('provinsi.index')) {
            $user = Puskesmas::find(auth()->user()->provinsi_id);
        } else if (auth()->user()->can('balkesmas.index')) {
            $user = Puskesmas::find(auth()->user()->provinsi_id);
        }
        $kabupatenUser = auth()->user();
        $date_now = date('M-Y');

        return view('template/profil/posbindu/index', compact('kabupaten', 'user', 'date_now'));
    }

    function safe_encode($string)
    {
        $data = str_replace(array('/'), array('_'), $string);
        return $data;
    }

    function safe_decode($string, $mode = null)
    {
        $data = str_replace(array('_'), array('/'), $string);
        return $data;
    }

    private function cekExist($column, $var, $id)
    {
        $cek = Posbindu::where('id', '!=', $id)->where($column, '=', $var)->first();
        return (!empty($cek) ? false : true);
    }

    public function tambah()
    {
        $kabupaten = Kabupaten::find(auth()->user()->kabupaten_id);
        $kabupaten_name = explode(" ", $kabupaten->name);
        if($kabupaten_name[0] != 'KOTA'){
            $kab = ucwords(strtolower($kabupaten_name[1]));
        }else{
            $kab = ucwords(strtolower($kabupaten->name));
        }

        $total_puskesmas  = Puskesmas::select('id', 'name', 'kabupaten')->where('kabupaten', $kab)->orderBy('name', 'ASC')->get()->count();;
        $date_now   = date('M-Y');
        // return response()->json($kabupaten);
        return view('template/profil/posbindu/form', compact('kabupaten', 'total_puskesmas', 'date_now'));
    }

    private function get_data_record($kabupaten, $periode_start, $periode_end, $field)
    {
        $dataquery  = Posbindu::select('*');
        $dataquery->where('kabupaten_id', $kabupaten)->where('periode', '>=', $periode_start)->where('periode', '<=', $periode_end);
        $result = $dataquery->sum($field);

        return $result;
    }
    public function update_nilai($periode){

        $periode = date('Y-m-d', strtotime('01-'.$periode));
        $posbindu = Posbindu::where('periode', $periode)->first();
        if(isset($posbindu)){
            return response()->json([
                'success' => true,
                'data' => $posbindu
            ]);
        }else{
            return response()->json([
                'success' => false,
                'data' => []
            ]);
        }
        return response()->json($posbindu);
        // return $periode;
    }

    public function getData(Request $request)
    {
        $limit = $request->length;
        $start = $request->start;
        $page  = $start + 1;
        $search = $request->search['value'];

        if ($request->periode_start != '') {
            $periode_start = date('Y-m-d', strtotime('01-' . $request->periode_start));
        } else {
            $periode_start = date('Y-m-d');
        }
        if ($request->periode_end != '') {
            $periode_end = date('Y-m-d', strtotime('01-' . $request->periode_end));
        } else {
            $periode_end = date('Y-m-d');
        }

        if ($request->user()->can('provinsi.index')) {
            $dataquery  = Kabupaten::select('id', 'name')->where('provinsi_id', auth()->user()->provinsi_id);

            if ($request->kabupaten != NULL) {
                $dataquery->where('kabupaten.id', $request->kabupaten);
            }
            if ($search) {
                $dataquery->where(function ($query) use ($search) {
                    $query->orWhere('name', 'LIKE', "%{$search}%");
                });
            }
        } else if ($request->user()->can('balkesmas.index')) {
            $dataquery  = Kabupaten::select('id', 'name')->where('balkesmas_id', auth()->user()->balkesmas_id);

            if ($request->kabupaten != NULL) {
                $dataquery->where('kabupaten.id', $request->kabupaten);
            }
            if ($search) {
                $dataquery->where(function ($query) use ($search) {
                    $query->orWhere('name', 'LIKE', "%{$search}%");
                });
            }
        } else if ($request->user()->can('kabupaten.index')) {
            $dataquery = Posbindu::select('posbindu.*', 'kabupaten.name as kabname', 'kabupaten.id as kabid');
            $dataquery->leftJoin('kabupaten', 'kabupaten.id', 'posbindu.kabupaten_id');
            $dataquery->where('posbindu.kabupaten_id', auth()->user()->kabupaten_id);
            if (array_key_exists($request->order[0]['column'], $this->original_column)) {
                $dataquery->orderByRaw($this->original_column[$request->order[0]['column']] . ' ' . $request->order[0]['dir']);
            } else {
                $dataquery->orderBy('posbindu.id', 'ASC');
            }
            if ($search) {
                $dataquery->where(function ($query) use ($search) {
                    $query->orWhere('kabname', 'LIKE', "%{$search}%");
                });
            }

            if ($request->kabupaten != NULL) {
                $dataquery->where('kabupaten.id', $request->kabupaten);
            }

            // if ($request->periode != null) {
            //     // $dataquery->whereMonth('posbindu.periode', date('m', strtotime($periode)))->whereYear('posbindu.periode', date('Y', strtotime($periode)));
            // }
            $dataquery->where('posbindu.periode', '>=', $periode_start)->where('posbindu.periode', '<=', $periode_end)->where('kabupaten_id', auth()->user()->kabupaten_id);
        }

        $totalData = $dataquery->get()->count();

        $totalFiltered = $dataquery->get()->count();

        $dataquery->limit($limit);
        $dataquery->offset($start);
        $data = $dataquery->get();
        // return $data;
        foreach ($data as $key => $result) {
            $enc_id = $this->safe_encode(Crypt::encryptString($result->id));
            $action = "";

            $action .= "";
            $action .= "<div class='btn-group'>";
            if ($request->user()->can('profil.posbindu.ubah')) {
                $array = array(
                    'enc' => $enc_id,
                    'start' => $periode_start,
                    'end' => $periode_end
                );
                $action .= '<a onclick="editData(\'enc='.$array['enc'] . '&start=' . $array['start'] . '&end=' . $array['end'].'\')" href="#" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;';
            }
            if ($request->user()->can('profil.posbindu.hapus')) {
                $action .= '<a href="#" onclick="deleteData(this,\'' . $enc_id . '\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="fa fa-times"></i> Hapus</a>&nbsp;';
            }
            $action .= "</div>";

            $result->no                           = $key + $page;
            $result->id                           = $result->id;
            $result->action                       = $action;
            if ($request->user()->can('provinsi.index')) {
                // $result->kabupaten                    = $result->name;
                $kabupaten_name = explode(" ", $result->name);
                if ($kabupaten_name[0] != 'KOTA') {
                    $result->kabupaten            = strtoupper($kabupaten_name[1]);
                } else {
                    $result->kabupaten                    = $result->name;
                }
                // return $result;
                $program_ptm_keswa = Program_ptm_keswa::where('periode', '>=', $periode_start)->where('periode', '<=', $periode_end)->where('kabupaten_id', $result->id)->first();
                $result->jml_pusk                     = $this->get_data_record($result->id, $periode_start, $periode_end, 'jml_pusk');
                $result->jml_posbindu_ptm             = $this->get_data_record($result->id, $periode_start, $periode_end, 'jml_posbindu_ptm');
                $result->jml_desa                     = $program_ptm_keswa->sum('jml_desa');
                $result->desa_posbindu                = $program_ptm_keswa->sum('jml_desa_posbindu');
                if ($result->jml_desa == 0 || $result->desa_posbindu == 0) {
                    $result->cakupan = '0%';
                } else {
                    $result->cakupan                  = round(($result->desa_posbindu / $result->jml_desa) * 100) . "%";
                }
            } else if ($request->user()->can('balkesmas.index')) {
                // $result->kabupaten                    = $result->name;
                $kabupaten_name = explode(" ", $result->name);
                if ($kabupaten_name[0] != 'KOTA') {
                    $result->kabupaten            = strtoupper($kabupaten_name[1]);
                } else {
                    $result->kabupaten                    = $result->name;
                }
                // return $result;
                $program_ptm_keswa = Program_ptm_keswa::where('periode', '>=', $periode_start)->where('periode', '<=', $periode_end)->where('kabupaten_id', $result->id)->get();
                $result->jml_pusk                     = $this->get_data_record($result->id, $periode_start, $periode_end, 'jml_pusk');
                $result->jml_posbindu_ptm             = $this->get_data_record($result->id, $periode_start, $periode_end, 'jml_posbindu_ptm');
                $result->jml_desa                     = $program_ptm_keswa->sum('jml_desa');
                $result->desa_posbindu                = $program_ptm_keswa->sum('jml_desa_posbindu');
                if ($result->jml_desa == 0 || $result->desa_posbindu == 0) {
                    $result->cakupan = '0%';
                } else {
                    $result->cakupan                  = round(($result->desa_posbindu / $result->jml_desa) * 100) . "%";
                }
            } else if ($request->user()->can('kabupaten.index')) {
                // $result->kabupaten                    = $result->kabname;
                $kabupaten_name = explode(" ", $result->kabname);
                if ($kabupaten_name[0] != 'KOTA') {
                    $result->kabupaten            = strtoupper($kabupaten_name[1]);
                } else {
                    $result->kabupaten                    = $result->kabname;
                }
                $program_ptm_keswa = Program_ptm_keswa::where('periode', '>=', $periode_start)->where('periode', '<=', $periode_end)->where('kabupaten_id', auth()->user()->kabupaten_id)->get();
                $result->jml_pusk                     = $result->jml_pusk;
                $result->jml_posbindu_ptm             = $result->jml_posbindu_ptm;
                $result->jml_desa                     = $program_ptm_keswa->sum('jml_desa');
                $result->desa_posbindu                = $program_ptm_keswa->sum('jml_desa_posbindu');
                if ($result->jml_desa == 0 || $result->desa_posbindu == 0) {
                    $result->cakupan = '0%';
                } else {
                    $result->cakupan                  = round(($result->desa_posbindu / $result->jml_desa) * 100) . "%";
                }
            }
        }
        $array['kabupaten']          = $data->count();
        $array['jml_pusk']          = $data->sum('jml_pusk');
        $array['jml_posbindu_ptm']  = $data->sum('jml_posbindu_ptm');
        $array['jml_desa']          = $data->sum('jml_desa');
        $array['desa_posbindu']     = $data->sum('desa_posbindu');
        if ($array['jml_desa'] == 0 || $array['desa_posbindu'] == 0) {
            $array['cakupan']                        = '0%';
        } else {
            $array['cakupan']                        = round(($array['desa_posbindu'] / $array['jml_desa']) * 100) . "%";
        }
        if(auth()->user()->can('kabupaten.index')){
            if(count($data) <= 0){
                $data = [];
                $array = [];
            }
        }
        if ($request->user()->can('profil.posbindu.index')) {
            $json_data = array(
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $data,
                "sum_data"        => $array
            );
        } else {
            $json_data = array(
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => 0,
                "recordsFiltered" => 0,
                "data"            => [],
                "sum_data"        => $array
            );
        }
        return json_encode($json_data);
    }

    public function simpan_(Request $req)
    {
        $enc_id     = $req->enc_id;
        // return response()->json(['data' => $req->all()]);

        if ($enc_id != null) {
            $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        } else {
            $dec_id = null;
        }


        $cek_nama = $this->cekExist('periode', date("Y", strtotime($req->periode)), $dec_id);
        if (!$cek_nama) {
            $json_data = array(
                "success"         => FALSE,
                "message"         => 'Mohon maaf. Nama Jabatan sudah terdaftar pada sistem.'
            );
        } else {
            try {
                DB::beginTransaction();
                if ($enc_id) {
                    $posbindu = Posbindu::find($dec_id);
                    $posbindu->jml_pusk                     = $req->jml_pusk;
                    $posbindu->jml_posbindu_ptm             = $req->jml_posbindu_ptm;
                    $posbindu->periode                      = date("Y-m-d", strtotime('01-' . $req->periode));
                    $posbindu->save();
                    DB::commit();
                    $json_data = array(
                        "success"         => TRUE,
                        "message"         => 'Data berhasil diperbarui.'
                    );
                } else {
                    $cek = Posbindu::where('kabupaten_id', auth()->user()->kabupaten_id)->where('periode', date("Y-m-d", strtotime('01-' . $req->periode)))->first();
                    if (isset($cek)) {
                        return response()->json([
                            "success"         => FALSE,
                            "message"         => 'Data gagal diperbarui, data sudah pernah diinput di periode ini'
                        ]);
                    }
                    $posbindu                               = new Posbindu();
                    $posbindu->user_id                      = auth()->user()->id;
                    $posbindu->kabupaten_id                 = auth()->user()->kabupaten_id;
                    $posbindu->jml_pusk                     = $req->jml_pusk;
                    $posbindu->jml_posbindu_ptm             = $req->jml_posbindu_ptm;
                    $posbindu->periode                      = date("Y-m-d", strtotime('01-' . $req->periode));
                    $posbindu->save();

                    DB::commit();
                    $json_data = array(
                        "success"         => TRUE,
                        "message"         => 'Data berhasil ditambahkan.'
                    );
                }
            } catch (\Throwable $th) {
                DB::rollback();
                $json_data = array(
                    "success"         => FALSE,
                    "message"         => $th->getMessage()
                );
            }
        }
        return json_encode($json_data);
    }
    public function simpan(Request $req){
        // return $req->all();
        $periode = date('Y-m-d', strtotime('01-'.$req->periode));
        $posbindu = Posbindu::where('puskesmas_id', auth()->user()->puskesmas_id)->where('periode', $periode)->first();
        // return $posbindu;
        // $spm            = Spm::where('puskesmas_id', auth()->user()->puskesmas_id)->where('periode', $periode)->first();

        try{
            DB::beginTransaction();
            if(isset($posbindu)){
                $posbindu->jml_pusk                     = $req->jml_pusk;
                $posbindu->jml_posbindu_ptm             = $req->jml_posbindu_ptm;
                $posbindu->periode                      = date("Y-m-d", strtotime('01-' . $req->periode));
                $posbindu->save();
                DB::commit();
                $json_data = array(
                    "success"         => TRUE,
                    "message"         => 'Data berhasil diperbarui.'
                );
            }else{

                $posbindu                               = new Posbindu();
                $posbindu->user_id                      = auth()->user()->id;
                $posbindu->kabupaten_id                 = auth()->user()->kabupaten_id;
                $posbindu->jml_pusk                     = $req->jml_pusk;
                $posbindu->jml_posbindu_ptm             = $req->jml_posbindu_ptm;
                $posbindu->periode                      = date("Y-m-d", strtotime('01-' . $req->periode));
                $posbindu->save();

                DB::commit();
                $json_data = array(
                    "success"         => TRUE,
                    "message"         => 'Data berhasil ditambahkan.'
                );
            }
        }catch(\Throwable $th){
            DB::rollback();
            $json_data = array(
                "success"         => FALSE,
                "message"         => $th->getMessage()
            );
        }
        return json_encode($json_data);

    }

    public function ubah($enc_id)
    {
        parse_str($enc_id, $get_array);
        $dec_id = $this->safe_decode(Crypt::decryptString($get_array['enc']));
        if ($dec_id) {
            $query = Kabupaten::find(auth()->user()->kabupaten_id);
            $kabupaten = $query;
            // return $kabupaten;

            $posbindu = Posbindu::where('kabupaten_id', $kabupaten->id)->where('periode', $get_array['start'])->first();
            // return $posbindu;
            $periode = date('M-Y', strtotime($posbindu->periode));
            $posbindu->date_periode = $periode;
            // return response()->json(['data' => $ptm]);
            return view('template/profil/posbindu/form', compact('enc_id', 'kabupaten', 'posbindu'));
        } else {
            $json_data = array(
                "success"         => FALSE,
                "message"         => $th->getMessage()
            );
            return json_encode($json_data);
        }

        // return response()->json($puskesmas);

    }

    public function hapus(Request $req, $enc_id)
    {
        try {
            $dec_id     = $this->safe_decode(Crypt::decryptString($enc_id));
            $posbindu        = Posbindu::find($dec_id);
            $posbindu->delete();

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
    public function cetak_pdf(Request $request)
    {

        if ($request->periode != '') {
            $periode = date('Y-m-d', strtotime('01-' . $request->periode));
        } else {
            $periode = date('Y-m-d');
        }

        if ($request->user()->can('provinsi.index')) {
            $dataquery  = Kabupaten::select('id', 'name')->where('provinsi_id', auth()->user()->provinsi_id);

            if ($request->kabupaten != NULL) {
                $dataquery->where('kabupaten.id', $request->kabupaten);
            }
        } else if ($request->user()->can('balkesmas.index')) {
            $dataquery  = Kabupaten::select('id', 'name')->where('balkesmas_id', auth()->user()->balkesmas_id);

            if ($request->kabupaten != NULL) {
                $dataquery->where('kabupaten.id', $request->kabupaten);
            }
        } else if ($request->user()->can('kabupaten.index')) {
            $dataquery = Posbindu::select('posbindu.*', 'kabupaten.name as kabname', 'kabupaten.id as kabid');
            $dataquery->leftJoin('kabupaten', 'kabupaten.id', 'posbindu.kabupaten_id');
            $dataquery->where('posbindu.kabupaten_id', auth()->user()->kabupaten_id);

            if ($request->kabupaten != NULL) {
                $dataquery->where('kabupaten.id', $request->kabupaten);
            }

            if ($request->periode != null) {
                $dataquery->whereMonth('posbindu.periode', date('m', strtotime($periode)))->whereYear('posbindu.periode', date('Y', strtotime($periode)));
            }
        }


        $data = $dataquery->get();
        foreach ($data as $key => $result) {
            $enc_id = $this->safe_encode(Crypt::encryptString($result->id));
            $action = "";

            $action .= "";
            $action .= "<div class='btn-group'>";
            if ($request->user()->can('profil.posbindu.ubah')) {
                $action .= '<a href="' . route('profil.posbindu.ubah', $enc_id) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;';
            }
            if ($request->user()->can('profil.posbindu.hapus')) {
                $action .= '<a href="#" onclick="deleteData(this,\'' . $enc_id . '\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="fa fa-times"></i> Hapus</a>&nbsp;';
            }
            $action .= "</div>";

            // $result->no                           = $key + $page;
            $result->id                           = $result->id;
            $result->action                       = $action;
            if ($request->user()->can('provinsi.index')) {
                // $result->kabupaten                    = $result->name;
                $kabupaten_name = explode(" ", $result->name);
                if ($kabupaten_name[0] != 'KOTA') {
                    $result->kabupaten            = strtoupper($kabupaten_name[1]);
                } else {
                    $result->kabupaten                    = $result->name;
                }
                // return $result;
                $program_ptm_keswa = Program_ptm_keswa::where('periode', $periode)->where('kabupaten_id', $result->id)->first();
                $result->jml_pusk                     = $this->get_data_record($result->id, $periode, 'jml_pusk');
                $result->jml_posbindu_ptm             = $this->get_data_record($result->id, $periode, 'jml_posbindu_ptm');
                $result->jml_desa                     = isset($program_ptm_keswa) ? $program_ptm_keswa->jml_desa : 0;
                $result->desa_posbindu                = isset($program_ptm_keswa) ? $program_ptm_keswa->jml_desa_posbindu : 0;
                if ($result->jml_desa == 0 || $result->desa_posbindu == 0) {
                    $result->cakupan = '0%';
                } else {
                    $result->cakupan                  = round(($result->desa_posbindu / $result->jml_desa) * 100) . "%";
                }
            } else if ($request->user()->can('balkesmas.index')) {
                // $result->kabupaten                    = $result->name;
                $kabupaten_name = explode(" ", $result->name);
                if ($kabupaten_name[0] != 'KOTA') {
                    $result->kabupaten            = strtoupper($kabupaten_name[1]);
                } else {
                    $result->kabupaten                    = $result->name;
                }
                // return $result;
                $program_ptm_keswa = Program_ptm_keswa::where('periode', $periode)->where('kabupaten_id', $result->id)->first();
                $result->jml_pusk                     = $this->get_data_record($result->id, $periode, 'jml_pusk');
                $result->jml_posbindu_ptm             = $this->get_data_record($result->id, $periode, 'jml_posbindu_ptm');
                $result->jml_desa                     = isset($program_ptm_keswa) ? $program_ptm_keswa->jml_desa : 0;
                $result->desa_posbindu                = isset($program_ptm_keswa) ? $program_ptm_keswa->jml_desa_posbindu : 0;
                if ($result->jml_desa == 0 || $result->desa_posbindu == 0) {
                    $result->cakupan = '0%';
                } else {
                    $result->cakupan                  = round(($result->desa_posbindu / $result->jml_desa) * 100) . "%";
                }
            } else if ($request->user()->can('kabupaten.index')) {
                // $result->kabupaten                    = $result->kabname;
                $kabupaten_name = explode(" ", $result->kabname);
                if ($kabupaten_name[0] != 'KOTA') {
                    $result->kabupaten            = strtoupper($kabupaten_name[1]);
                } else {
                    $result->kabupaten                    = $result->kabname;
                }
                $program_ptm_keswa = Program_ptm_keswa::where('periode', $periode)->where('kabupaten_id', auth()->user()->kabupaten_id)->first();
                $result->jml_pusk                     = $result->jml_pusk;
                $result->jml_posbindu_ptm             = $result->jml_posbindu_ptm;
                $result->jml_desa                     = isset($program_ptm_keswa) ? $program_ptm_keswa->jml_desa : 0;
                $result->desa_posbindu                = isset($program_ptm_keswa) ? $program_ptm_keswa->jml_desa_posbindu : 0;
                if ($result->jml_desa == 0 || $result->desa_posbindu == 0) {
                    $result->cakupan = '0%';
                } else {
                    $result->cakupan                  = round(($result->desa_posbindu / $result->jml_desa) * 100) . "%";
                }
            }
        }
        $array['kabupaten']          = $data->count();
        $array['jml_pusk']          = $data->sum('jml_pusk');
        $array['jml_posbindu_ptm']  = $data->sum('jml_posbindu_ptm');
        $array['jml_desa']          = $data->sum('jml_desa');
        $array['desa_posbindu']     = $data->sum('desa_posbindu');
        if ($array['jml_desa'] == 0 || $array['desa_posbindu'] == 0) {
            $array['cakupan']                        = '0%';
        } else {
            $array['cakupan']                        = round(($array['desa_posbindu'] / $array['jml_desa']) * 100) . "%";
        }
        // return $data;
        $view = 'template/profil/posbindu/cetak';
        if ($request->cetakan == 'excel') {
            return Excel::download(new ExportExcel($data, $array, $view), 'ProfilPosbindu.xlsx');
        }
        $config = [
            'mode'                  => '',
            'format'                => 'A4',
            'default_font_size'     => '11',
            'default_font'          => 'sans-serif',
            'margin_left'           => 8,
            'margin_right'          => 8,
            'margin_top'            => 8,
            'margin_bottom'         => 8,
            'margin_header'         => 0,
            'margin_footer'         => 0,
            'orientation'           => 'L',
            'title'                 => 'POSBINDU',
            'author'                => '',
            'watermark'             => '',
            'show_watermark'        => true,
            'show_watermark_image'  => true,
            'watermark_font'        => 'sans-serif',
            'display_mode'          => 'fullpage',
            'watermark_text_alpha'  => 0.2,
        ];




        //download : langsung download
        //stream : open preview
        $pdf = PDF::loadview('template/profil/posbindu/cetak', ['data' => $data, 'sum_data' => $array], [], $config);
        return $pdf->download('laporan-POSBINDU.pdf');
    }
}
