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
        $defaultpassword = 'abc321';
    	$akun    = $request->input("akun");
        $password = $request->input("password");
        $akun = User::where('username', '=', $akun)->orwhere('username', '=', strtoupper($akun))->orwhere('email', '=', $akun)->first();

        //VALIDASI
            if(!isset($akun)){
                $provinsi = Provinsi::where('name', '=', $request->input("akun"))->first();
                if(isset($provinsi)){
                    $staff = new User;
                    $staff->fullname      = $provinsi->name;
                    $staff->email         = str_replace(" ", "", strtolower($provinsi->name)).'@gmail.com';
                    $staff->password      = bcrypt($defaultpassword);
                    $staff->username      = $provinsi->name;
                    $staff->address       = $provinsi->name;
                    $staff->puskesmas_id  = null;
                    $staff->kabupaten_id  = null;
                    $staff->provinsi_id   = $provinsi->id;
                    $staff->no_hp         = null;
                    $staff->flag_user     = '9';
                    $staff->npwp          = null;
                    $staff->ktp           = null;
                    $staff->jk            = 'L';
                    $staff->status        = '1';
                    if($staff->save()){
                        $roleUser = new RoleUser;
                        $roleUser->role_id = '9';
                        $roleUser->user_id = $staff->id;
                        if(!$roleUser->save()){
                            $desc = 'Login gagal. Cek kembali email dan password Anda.';
                            return redirect()->route('manage.login')->with('message', ['status'=>'danger','desc'=>$desc]);
                        }
                    }else{
                        $desc = 'Login gagal. Cek kembali email dan password Anda.';
                        return redirect()->route('manage.login')->with('message', ['status'=>'danger','desc'=>$desc]);
                    }
                }else{
                    return redirect()->route('manage.login')->with('message', ['status'=>'danger','desc'=>'Maaf. Feature tersebut belum tersedia']);
                }

                // $balkesmas = Balkesmas::where('name', 'LIKE', "%{$request->input('akun')}%")->first();

                // if(isset($balkesmas)){
                //     $staff = new User;
                //     $staff->fullname      = $balkesmas->name;
                //     $staff->email         = str_replace(" ", "", strtolower($balkesmas->name)).'@gmail.com';
                //     $staff->password      = bcrypt($defaultpassword);
                //     $staff->username      = $balkesmas->name;
                //     $staff->address       = $balkesmas->name;
                //     $staff->puskesmas_id  = null;
                //     $staff->kabupaten_id  = null;
                //     $staff->provinsi_id   = null;
                //     $staff->balkesmas_id   = $balkesmas->id;
                //     $staff->no_hp         = null;
                //     $staff->flag_user     = '10';
                //     $staff->npwp          = null;
                //     $staff->ktp           = null;
                //     $staff->jk            = 'L';
                //     $staff->status        = '1';
                //     if($staff->save()){
                //         $roleUser = new RoleUser;
                //         $roleUser->role_id = '10';
                //         $roleUser->user_id = $staff->id;
                //         if(!$roleUser->save()){
                //             $desc = 'Login gagal. Cek kembali email dan password Anda.';
                //             return redirect()->route('manage.login')->with('message', ['status'=>'danger','desc'=>$desc]);
                //         }
                //     }else{
                //         $desc = 'Login gagal. Cek kembali email dan password Anda.';
                //         return redirect()->route('manage.login')->with('message', ['status'=>'danger','desc'=>$desc]);
                //     }
                // }

                // $kabupaten = Kabupaten::where('name', '=', $request->input("akun"))->first();

                // if(isset($kabupaten)){
                //     $staff = new User;
                //     $staff->fullname      = $kabupaten->name;
                //     $staff->email         = str_replace(" ", "", strtolower($kabupaten->name)).'@gmail.com';
                //     $staff->password      = bcrypt($defaultpassword);
                //     $staff->username      = $kabupaten->name;
                //     $staff->address       = $kabupaten->name;
                //     $staff->puskesmas_id  = null;
                //     $staff->kabupaten_id  = $kabupaten->id;
                //     $staff->provinsi_id   = null;
                //     $staff->no_hp         = null;
                //     $staff->flag_user     = '3';
                //     $staff->npwp          = null;
                //     $staff->ktp           = null;
                //     $staff->jk            = 'L';
                //     $staff->status        = '1';
                //     if($staff->save()){
                //         $roleUser = new RoleUser;
                //         $roleUser->role_id = '3';
                //         $roleUser->user_id = $staff->id;
                //         if(!$roleUser->save()){
                //             $desc = 'Login gagal. Cek kembali email dan password Anda.';
                //             return redirect()->route('manage.login')->with('message', ['status'=>'danger','desc'=>$desc]);
                //         }
                //     }else{
                //         $desc = 'Login gagal. Cek kembali email dan password Anda.';
                //         return redirect()->route('manage.login')->with('message', ['status'=>'danger','desc'=>$desc]);
                //     }
                // }

                // $puskesmas = Puskesmas::where('name', $request->input("akun"))->first();
                // if(isset($puskesmas)){
                //     $staff = new User;
                //     $staff->fullname      = $puskesmas->name;
                //     $staff->email         = str_replace(" ", "", strtolower($puskesmas->name)).'@gmail.com';
                //     $staff->password      = bcrypt($defaultpassword);
                //     $staff->username      = $puskesmas->name;
                //     $staff->address       = $puskesmas->name;
                //     $staff->puskesmas_id  = $puskesmas->id;
                //     $staff->kabupaten_id  = null;
                //     $staff->provinsi_id   = null;
                //     $staff->no_hp         = null;
                //     $staff->flag_user     = '2';
                //     $staff->npwp          = null;
                //     $staff->ktp           = null;
                //     $staff->jk            = 'L';
                //     $staff->status        = '1';
                //     if($staff->save()){
                //         $roleUser = new RoleUser;
                //         $roleUser->role_id = '2';
                //         $roleUser->user_id = $staff->id;
                //         if(!$roleUser->save()){
                //             $desc = 'Login gagal. Cek kembali email dan password Anda.';
                //             return redirect()->route('manage.login')->with('message', ['status'=>'danger','desc'=>$desc]);
                //         }
                //     }else{
                //         $desc = 'Login gagal. Cek kembali email dan password Anda.';
                //         return redirect()->route('manage.login')->with('message', ['status'=>'danger','desc'=>$desc]);
                //     }
                // }
                $akun = User::where('username', '=', $request->input("akun"))->orwhere('username', '=', strtoupper($request->input("akun")))->orwhere('email', '=', $request->input("akun"))->first();
            }
        //ENDVALIDASI
        if ($akun) {
           if ($akun->status=='1') {
              if(Hash::check($password,$akun->password))  {
                    $akun->last_login_at = now();
                    $akun->last_login_ip = $request->ip();
                    $akun->save();
                        if($akun->flag_user != 1){
                            if($akun->puskesmas_id != null){
                                $dataAkun = User::select('users.id', 'users.username', 'users.puskesmas_id', 'puskesmas.name as name')->leftJoin('puskesmas', 'puskesmas.id','users.puskesmas_id')->where('users.id', $akun->id)->first();
                                if(isset($dataAkun)){
                                    $data = ucwords("PUSK. ".$dataAkun->name);
                                }
                            }else if($akun->kabupaten_id != null){
                                $dataAkun = User::select('users.id', 'users.username', 'users.kabupaten_id', 'kabupaten.name as name')->leftJoin('kabupaten', 'kabupaten.id','users.kabupaten_id')->where('users.id', $akun->id)->first();
                                if(isset($dataAkun)){
                                    $explode = explode(" ",$dataAkun->name);
                                    $slice_kab = substr($explode[0], 0, 3);
                                    $data = ucwords($slice_kab.". ".$explode[1]);
                                }
                            }else if($akun->provinsi_id != null){
                                $dataAkun = User::select('users.id', 'users.username', 'users.provinsi_id', 'provinsi.name as name')->leftJoin('provinsi', 'provinsi.id','users.provinsi_id')->where('users.id', $akun->id)->first();
                                if(isset($dataAkun)){
                                    $data = strtoupper("PROV. ".$dataAkun->name);
                                }
                            }else if($akun->balkesmas_id != null){
                                $dataAkun = User::select('users.id', 'users.username', 'users.balkesmas_id', 'balkesmas.name as name')->leftJoin('balkesmas', 'balkesmas.id','users.balkesmas_id')->where('users.id', $akun->id)->first();
                                if(isset($dataAkun)){
                                    $data = strtoupper($dataAkun->name);
                                }
                            }
                            session(['profile' => $this->defaultProfilePhotoUrl($akun->fullname)]);
                            session(['namaakses' => $dataAkun? $data :'']);
                        }else{
                            session(['profile' => $this->defaultProfilePhotoUrl($akun->fullname)]);
                            session(['namaakses' => $akun->namaAkses?$akun->namaAkses->name:'']);
                        }
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
    // public function checkLogin(Request $request){
    // 	$akun    = $request->input("akun");
    //     $password = $request->input("password");

    //     $akun = User::whereRaw("BINARY username='".$akun."'")->first();
    //     if ($akun) {
    //        if ($akun->status=='1') {
    //           if(Hash::check($password,$akun->password))  {
    //               $akun->last_login_at = now();
    //               $akun->last_login_ip = $request->ip();
    //               $akun->save();             
    //               session(['profile'   => url('assets/logo/fav.png')]);
    //               session(['namaakses' => $akun->namaAkses?$akun->namaAkses->name:'']);
    //               Auth::login($akun);
    //               return redirect()->route('manage.beranda');
    //           } else {
    //               $desc = 'Login gagal. Cek kembali email dan password Anda.';
    //               return redirect()->route('manage.login')->with('message', ['status'=>'danger','desc'=>$desc]);
    //           }
    //        }if ($akun->status=='2'){
    //           $desc = 'Login gagal. Akun anda telah terblokir. Silahkan hubungi Admin.';
    //           return redirect()->route('manage.login')->with('message', ['status'=>'danger','desc'=>$desc]);
    //        }else{
    //          $desc = 'Login gagal. Akun anda belum terverifikasi. Silahkan melakukan verifikasi terlebih dahulu.';
    //          return redirect()->route('manage.login')->with('message', ['status'=>'danger','desc'=>$desc]);
    //        }
    //     }else{
    //         $desc = 'Login gagal. Akun tidak ditemukan di sistem kami.';
    //         return redirect()->route('manage.login')->with('message', ['status'=>'danger','desc'=>$desc]);
    //     }      
    // }
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
