<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProvinsiController;
use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\PuskesmasController;
use App\Http\Controllers\PosbinduController;
use App\Http\Controllers\SertifikatController;
use App\Http\Controllers\KaderController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\KepalaBidangController;

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

Route::get('/manage/login', [LoginController::class, 'index'])->name('manage.login');
Route::get('/filter_username', [LoginController::class, 'filter_user'])->name('filter_user');
Route::post('/manage/login', [LoginController::class, 'checkLogin'])->name('manage.checklogin');
Route::get('/certifikat/{id}', [SertifikatController::class, 'getSertifikat'])->name('sertifikat');
Route::group(['middleware' => ['auth', 'acl:web']], function () {
    Route::get('/', [BerandaController::class, 'index'])->name('manage.beranda');

    Route::get('/manage/logout', [LoginController::class, 'logout'])->name('manage.logout');

    // STAFF
    Route::get('manage/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::post('manage/staff/getdata', [StaffController::class, 'getData'])->name('staff.getdata');
    Route::get('manage/staff/tambah', [StaffController::class, 'tambah'])->name('staff.tambah');
    Route::get('manage/staff/detail/{id}', [StaffController::class, 'detail'])->name('staff.detail');
    Route::get('manage/staff/ubah/{id}', [StaffController::class, 'ubah'])->name('staff.ubah');
    Route::delete('manage/staff/hapus/{id?}', [StaffController::class, 'hapus'])->name('staff.hapus');
    Route::post('manage/staff/simpan', [StaffController::class, 'simpan'])->name('staff.simpan');
    Route::get('manage/staff/resetpwd/{id?}', [StaffController::class, 'resetpwd'])->name('staff.resetpwd');

    //PERMISSION
    Route::get('manage/permission', [PermissionController::class, 'index'])->name('permission.index');
    Route::get('manage/permission/tambah', [PermissionController::class, 'tambah'])->name('permission.tambah');
    Route::get('manage/permission/ubah/{id}', [PermissionController::class, 'ubah'])->name('permission.ubah');
    Route::post('manage/permission/simpan/{id?}', [PermissionController::class, 'simpan'])->name('permission.simpan');
    Route::get('manage/permission/sidebar', [PermissionController::class, 'sidebar'])->name('permission.sidebar');

    //ROLE
    Route::get('manage/role', [RoleController::class, 'index'])->name('role.index');
    Route::get('manage/role/lihat/{id}', [RoleController::class, 'lihat'])->name('role.lihat');
    Route::get('manage/role/tambah', [RoleController::class, 'form'])->name('role.tambah');
    Route::get('manage/role/ubah/{id}', [RoleController::class, 'form'])->name('role.ubah');
    Route::get('manage/role/user/{id}', [RoleController::class, 'formuser'])->name('role.user');
    Route::post('manage/role/tambah', [RoleController::class, 'save'])->name('role.tambah');
    Route::post('manage/role/ubah/{id}', [RoleController::class, 'save'])->name('role.ubah');
    Route::post('manage/role/user/{id}', [RoleController::class, 'saveuser'])->name('role.user');
    Route::post('manage/role/getdata', [RoleController::class, 'getData'])->name('role.getdata');
    Route::delete('manage/role/hapus/{id?}', [RoleController::class, 'delete'])->name('role.hapus');

    //PROFILE
    Route::get('manage/profil', [StaffController::class, 'profil'])->name('profil.index');
    Route::post('manage/profil/simpan', [StaffController::class, 'profilSimpan'])->name('profil.simpan');
    Route::post('manage/profil/update', [StaffController::class, 'updateprofil'])->name('profil.update');
    Route::get('manage/newpassword', [StaffController::class, 'profilPassword'])->name('profil.password');
    Route::post('manage/password/simpan', [StaffController::class, 'profilNewPassword'])->name('profil.simpanpassword');

    //master
    Route::group(['prefix' => 'master', 'as' => 'master.'], function () {
        Route::group(['prefix' => 'provinsi', 'as' => 'provinsi.'], function () {
            Route::get('/', [ProvinsiController::class, 'index'])->name('index');
            Route::get('/tambah', [ProvinsiController::class, 'tambah'])->name('tambah');
            Route::get('/ubah/{id?}', [ProvinsiController::class, 'ubah'])->name('ubah');
            Route::post('/getdata', [ProvinsiController::class, 'getData'])->name('getdata');
            Route::post('/simpan', [ProvinsiController::class, 'simpan'])->name('simpan');
            Route::delete('/delete/{id?}', [ProvinsiController::class, 'hapus'])->name('hapus');
        });

        Route::group(['prefix' => 'kabupaten', 'as' => 'kabupaten.'], function () {
            Route::get('/', [KabupatenController::class, 'index'])->name('index');
            Route::get('/tambah', [KabupatenController::class, 'tambah'])->name('tambah');
            Route::get('/ubah/{id?}', [KabupatenController::class, 'ubah'])->name('ubah');
            Route::post('/getdata', [KabupatenController::class, 'getData'])->name('getdata');
            Route::get('/getselect', [KabupatenController::class, 'getSelect'])->name('getselect');
            Route::post('/simpan', [KabupatenController::class, 'simpan'])->name('simpan');
            Route::delete('/delete/{id?}', [KabupatenController::class, 'hapus'])->name('hapus');
        });

        Route::group(['prefix' => 'kecamatan', 'as' => 'kecamatan.'], function () {
            Route::get('/', [KecamatanController::class, 'index'])->name('index');
            Route::get('/tambah', [KecamatanController::class, 'tambah'])->name('tambah');
            Route::get('/ubah/{id?}', [KecamatanController::class, 'ubah'])->name('ubah');
            Route::post('/getdata', [KecamatanController::class, 'getData'])->name('getdata');
            Route::post('/simpan', [KecamatanController::class, 'simpan'])->name('simpan');
            Route::delete('/delete/{id?}', [KecamatanController::class, 'hapus'])->name('hapus');
        });

        Route::group(['prefix' => 'puskesmas', 'as' => 'puskesmas.'], function () {
            Route::get('/', [PuskesmasController::class, 'index'])->name('index');
            Route::get('/tambah', [PuskesmasController::class, 'tambah'])->name('tambah');
            Route::get('/ubah/{id?}', [PuskesmasController::class, 'ubah'])->name('ubah');
            Route::get('/kecamatan/{id?}', [PuskesmasController::class, 'kecamatan'])->name('kecamatan');
            Route::get('/filter_puskesmas', [PuskesmasController::class, 'getPuskesmas'])->name('filter_puskesmas');
            Route::post('/getdata', [PuskesmasController::class, 'getData'])->name('getdata');
            Route::get('/getselect', [PuskesmasController::class, 'getSelect'])->name('getselect');
            Route::post('/simpan', [PuskesmasController::class, 'simpan'])->name('simpan');
            Route::delete('/delete/{id?}', [PuskesmasController::class, 'hapus'])->name('hapus');
        });

        Route::group(['prefix' => 'kader', 'as' => 'kader.'], function () {
            Route::get('/', [KaderController::class, 'index'])->name('index');
            Route::get('/tambah', [KaderController::class, 'tambah'])->name('tambah');
            Route::get('/import', [KaderController::class, 'import'])->name('import');
            Route::post('/simpanimport', [KaderController::class, 'prosesImport'])->name('simpanimport');
            Route::get('/ubah/{id?}', [KaderController::class, 'ubah'])->name('ubah');
            Route::get('/puskesmas', [KaderController::class, 'getPuskesmas'])->name('puskesmas');
            Route::get('/desa', [KaderController::class, 'getDesa'])->name('desa');
            Route::get('/kecamatan', [KaderController::class, 'getKecamatan'])->name('kecamatan');
            Route::post('/simpan', [KaderController::class, 'simpan'])->name('simpan');
            Route::post('/getdata', [KaderController::class, 'getData'])->name('getdata');
            Route::delete('/delete/{id?}', [KaderController::class, 'hapus'])->name('hapus');
        });

        Route::group(['prefix' => 'desa', 'as' => 'desa.'], function () {
            Route::get('/', [DesaController::class, 'index'])->name('index');
            Route::get('/tambah', [DesaController::class, 'tambah'])->name('tambah');
            Route::get('/ubah/{id?}', [DesaController::class, 'ubah'])->name('ubah');
            Route::get('/puskesmas', [DesaController::class, 'getPuskesmas'])->name('puskesmas');
            Route::get('/kecamatan', [DesaController::class, 'getKecamatan'])->name('kecamatan');
            Route::post('/simpan', [DesaController::class, 'simpan'])->name('simpan');
            Route::post('/getdata', [DesaController::class, 'getData'])->name('getdata');
        });

        Route::group(['prefix' => 'kabid', 'as' => 'kabid.'], function () {
            Route::get('/', [KepalaBidangController::class, 'index'])->name('index');
            Route::get('/tambah', [KepalaBidangController::class, 'tambah'])->name('tambah');
            Route::get('/ubah/{id?}', [KepalaBidangController::class, 'ubah'])->name('ubah');
            Route::get('/puskesmas', [KepalaBidangController::class, 'getPuskesmas'])->name('puskesmas');
            Route::get('/kecamatan', [KepalaBidangController::class, 'getKecamatan'])->name('kecamatan');
            Route::post('/simpan', [KepalaBidangController::class, 'simpan'])->name('simpan');
            Route::post('/getdata', [KepalaBidangController::class, 'getData'])->name('getdata');
        });
    });

    //certificate
    Route::group(['prefix' => 'certificate', 'as' => 'certificate.'], function () {
      Route::group(['prefix' => 'generate', 'as' => 'generate.'], function () {
          Route::get('/', [SertifikatController::class, 'index'])->name('index');
          Route::get('/tambah', [SertifikatController::class, 'tambah'])->name('tambah');
          Route::get('/ubah/{id?}', [SertifikatController::class, 'ubah'])->name('ubah');
          Route::get('/cetak/{id?}', [SertifikatController::class, 'cetak'])->name('cetak');
          Route::post('/cetakall', [SertifikatController::class, 'cetakall'])->name('cetakall');
          Route::post('/cetakexcel', [SertifikatController::class, 'exportExcel'])->name('cetakexcel');
          Route::get('/puskesmas', [SertifikatController::class, 'getPuskesmas'])->name('puskesmas');
          Route::get('/kader', [SertifikatController::class, 'getkader'])->name('kader');
          Route::get('/detail/{id?}', [SertifikatController::class, 'detail'])->name('detail');
          Route::post('/simpan', [SertifikatController::class, 'simpan'])->name('simpan');
          Route::post('/getdata', [SertifikatController::class, 'getData'])->name('getdata');
      });
    });

    //laporan
    Route::group(['prefix' => 'laporan', 'as' => 'laporan.'], function () {
      Route::get('/rekap', [LaporanController::class, 'index'])->name('index');
      Route::post('/getdata', [LaporanController::class, 'getData'])->name('getdata');
      Route::get('/print', [LaporanController::class, 'print'])->name('print');
      Route::get('/pdf', [LaporanController::class, 'pdf'])->name('pdf');
      Route::get('/excel', [LaporanController::class, 'excel'])->name('excel');
    });

});
