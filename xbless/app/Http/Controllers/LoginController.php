<?php

namespace App\Http\Controllers;

use App\Models\Balkesmas;
use App\Models\Kabupaten;
use App\Models\Provinsi;
use App\Models\Puskesmas;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Support\Facades\Hash;
use Auth;

class LoginController extends Controller
{
	// index:halaman login
    public function index(){
    	return view('login');
    }

    public function checkLogin(Request $request){
    	$akun    = $request->input("email");
        $password = $request->input("password");

        $akun = User::whereRaw("BINARY email='".$akun."'")->first();
        if ($akun) {
           if ($akun->status=='1') {
              if(Hash::check($password,$akun->password))  {
                  $akun->last_login_at = now();
                  $akun->last_login_ip = $request->ip();
                  $akun->save();             
                  session(['profile'   => url('assets/logo/fav.png')]);
                  session(['namaakses' => $akun->namaAkses?$akun->namaAkses->name:'']);
                  Auth::login($akun);
                  return redirect()->route('manage.beranda');
              } else {
                  $desc = 'Login gagal. Cek kembali email dan password Anda.';
                  return redirect()->route('manage.login')->with('message', ['status'=>'danger','desc'=>$desc]);
              }
           }if ($akun->status=='2'){
              $desc = 'Login gagal. Akun anda telah terblokir. Silahkan hubungi Admin.';
              return redirect()->route('manage.login')->with('message', ['status'=>'danger','desc'=>$desc]);
           }else{
             $desc = 'Login gagal. Akun anda belum terverifikasi. Silahkan melakukan verifikasi terlebih dahulu.';
             return redirect()->route('manage.login')->with('message', ['status'=>'danger','desc'=>$desc]);
           }
        }else{
            $desc = 'Login gagal. Akun tidak ditemukan di sistem kami.';
            return redirect()->route('manage.login')->with('message', ['status'=>'danger','desc'=>$desc]);
        }      
    }
    // logout::fungsi logout
    public function logout(Request $request){
    	Auth::logout();
    	return redirect()->route('manage.login');
    }
    protected function defaultProfilePhotoUrl($name)
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=ffffff&background=54828d&rounded=true&length=2';
    }

    public function filter_user(Request $req){
        $provinsi = Provinsi::select('name')->get();
        $kabupaten = Kabupaten::select('name')->get();
        $puskesmas = Puskesmas::select('name')->get();
        $balkesmas = Balkesmas::select('name')->get();
        $all = collect($provinsi);
        if ($req->search != null || $req->search != '') {
            if($req->search == 'vexia'){
                $alldata = array([
                    'name' => 'vexia'
                ]);
            }else{
                $search = $req->search;
                $alldataa = $all->merge($kabupaten)->merge($puskesmas)->merge($balkesmas);
                $alldata = collect($alldataa)->filter(function ($item) use ($search) {
                    // replace stristr with your choice of matching function
                    return false !== stristr($item->name, $search);
                })->take(10);
            }
        }
        else {
            $alldata = $all->merge($kabupaten)->merge($puskesmas)->merge($balkesmas)->take(10);
        }

        return json_encode($alldata);
    }
}
