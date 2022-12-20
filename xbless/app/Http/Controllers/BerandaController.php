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
        return view('backend/beranda/index');
    }
}
