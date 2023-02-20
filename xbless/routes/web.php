<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SpeedController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\DetailPaketController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LandingPageController::class, 'index'])->name('index');
Route::get('/paket', [LandingPageController::class, 'detailPaket'])->name('paket');
Route::get('/confirm/{code?}', [LandingPageController::class, 'confirm'])->name('confirm');
Route::post('/regis_paket', [LandingPageController::class, 'regis'])->name('regis_paket');

Route::get('/admin/login', [LoginController::class, 'index'])->name('manage.login');
Route::post('/admin/login', [LoginController::class, 'checkLogin'])->name('manage.checklogin');
Route::group(['middleware' => ['auth', 'acl:web']], function () {
    Route::get('/admin', [BerandaController::class, 'index'])->name('manage.beranda');

    Route::get('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

    // STAFF
    Route::get('admin/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::post('admin/staff/getdata', [StaffController::class, 'getData'])->name('staff.getdata');
    Route::get('admin/staff/tambah', [StaffController::class, 'tambah'])->name('staff.tambah');
    Route::get('admin/staff/detail/{id}', [StaffController::class, 'detail'])->name('staff.detail');
    Route::get('admin/staff/ubah/{id}', [StaffController::class, 'ubah'])->name('staff.ubah');
    Route::delete('admin/staff/hapus/{id?}', [StaffController::class, 'hapus'])->name('staff.hapus');
    Route::post('admin/staff/simpan', [StaffController::class, 'simpan'])->name('staff.simpan');
    Route::get('admin/staff/resetpwd/{id?}', [StaffController::class, 'resetpwd'])->name('staff.resetpwd');

    //PERMISSION
    Route::get('admin/permission', [PermissionController::class, 'index'])->name('permission.index');
    Route::get('admin/permission/tambah', [PermissionController::class, 'tambah'])->name('permission.tambah');
    Route::get('admin/permission/ubah/{id}', [PermissionController::class, 'ubah'])->name('permission.ubah');
    Route::post('admin/permission/simpan/{id?}', [PermissionController::class, 'simpan'])->name('permission.simpan');
    Route::get('admin/permission/sidebar', [PermissionController::class, 'sidebar'])->name('permission.sidebar');

    //ROLE
    Route::get('admin/role', [RoleController::class, 'index'])->name('role.index');
    Route::get('admin/role/lihat/{id}', [RoleController::class, 'lihat'])->name('role.lihat');
    Route::get('admin/role/tambah', [RoleController::class, 'form'])->name('role.tambah');
    Route::get('admin/role/ubah/{id}', [RoleController::class, 'form'])->name('role.ubah');
    Route::get('admin/role/user/{id}', [RoleController::class, 'formuser'])->name('role.user');
    Route::post('admin/role/tambah', [RoleController::class, 'save'])->name('role.tambah');
    Route::post('admin/role/ubah/{id}', [RoleController::class, 'save'])->name('role.ubah');
    Route::post('admin/role/user/{id}', [RoleController::class, 'saveuser'])->name('role.user');
    Route::post('admin/role/getdata', [RoleController::class, 'getData'])->name('role.getdata');
    Route::delete('admin/role/hapus/{id?}', [RoleController::class, 'delete'])->name('role.hapus');

    //PROFILE
    Route::get('admin/profil', [StaffController::class, 'profil'])->name('profil.index');
    Route::post('admin/profil/simpan', [StaffController::class, 'profilSimpan'])->name('profil.simpan');
    Route::post('admin/profil/update', [StaffController::class, 'updateprofil'])->name('profil.update');
    Route::get('admin/newpassword', [StaffController::class, 'profilPassword'])->name('profil.password');
    Route::post('admin/password/simpan', [StaffController::class, 'profilNewPassword'])->name('profil.simpanpassword');

    //master
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){
        Route::group(['prefix' => 'master', 'as' => 'master.'], function () {
            Route::group(['prefix' => 'kategori', 'as' => 'kategori.'], function () {
                Route::group(['prefix' => 'paket', 'as' => 'paket.'], function () {
                    Route::get('/', [PaketController::class, 'index'])->name('index');
                    Route::get('/tambah', [PaketController::class, 'tambah'])->name('tambah');
                    Route::get('/ubah/{id?}', [PaketController::class, 'edit'])->name('ubah');
                    Route::post('/getdata', [PaketController::class, 'getData'])->name('getdata');
                    Route::post('/simpan', [PaketController::class, 'simpan'])->name('simpan');
                    Route::delete('/delete/{id?}', [PaketController::class, 'delete'])->name('hapus');
                });
    
                Route::group(['prefix' => 'speed', 'as' => 'speed.'], function () {
                    Route::get('/', [SpeedController::class, 'index'])->name('index');
                    Route::get('/tambah', [SpeedController::class, 'tambah'])->name('tambah');
                    Route::get('/ubah/{id?}', [SpeedController::class, 'edit'])->name('ubah');
                    Route::post('/getdata', [SpeedController::class, 'getData'])->name('getdata');
                    Route::post('/simpan', [SpeedController::class, 'simpan'])->name('simpan');
                    Route::delete('/delete/{id?}', [SpeedController::class, 'delete'])->name('hapus');
                });
            });

            Route::group(['prefix' => 'paket', 'as' => 'paket.'], function () {
                Route::group(['prefix' => 'detail', 'as' => 'detail.'], function () {
                    Route::get('/', [DetailPaketController::class, 'index'])->name('index');
                    Route::get('/tambah', [DetailPaketController::class, 'tambah'])->name('tambah');
                    Route::get('/ubah/{id?}', [DetailPaketController::class, 'edit'])->name('ubah');
                    Route::post('/getdata', [DetailPaketController::class, 'getData'])->name('getdata');
                    Route::post('/simpan', [DetailPaketController::class, 'simpan'])->name('simpan');
                    Route::delete('/delete/{id?}', [DetailPaketController::class, 'delete'])->name('hapus');
                });
            });
        });

        Route::group(['prefix' => 'register', 'as' => 'register.'], function () {
            Route::get('/', [RegisterController::class, 'index'])->name('index');
            Route::get('/tambah', [RegisterController::class, 'tambah'])->name('tambah');
            Route::get('/ubah/{id?}', [RegisterController::class, 'edit'])->name('ubah');
            Route::get('/detail/{id?}', [RegisterController::class, 'detailRegister'])->name('detail');
            Route::get('/img/{id?}', [RegisterController::class, 'detailImg'])->name('detail_img');
            Route::post('/getdata', [RegisterController::class, 'getData'])->name('getdata');
            Route::post('/simpan', [RegisterController::class, 'simpan'])->name('simpan');
            // Route::delete('/delete/{id?}', [DetailPaketController::class, 'delete'])->name('hapus');
        });
    });
});