<?php

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


Route::get('/', 'IndexController@index')->name('index');

Auth::routes();

Route::middleware('permission:dashboard')->get('/home', 'HomeController@index')->name('home');

/* HOME */
Route::middleware(['auth', 'role:admin'])->prefix('home')->group(function () {
    Route::get('subkelompok-aset/{id_kelompok_aset}', 'HomeController@subkelompokaset');
    Route::get('daftar-aset-per-subkelompok/{id_subkelompok_aset}', 'HomeController@daftarasetpersubkelompok');
});

/* KELOMPOK PRODUK */
Route::middleware(['auth', 'role:admin'])->prefix('kelompokaset')->group(function () {
    Route::get('daftar-kelompok-aset', 'KelompokController@daftarkelompokaset');
    Route::get('tambah-kelompok-aset', 'KelompokController@tambahkelompokaset');
    Route::post('proses-tambah-kelompok-aset', 'KelompokController@prosestambahkelompokaset');
    Route::get('ubah-kelompok-aset/{id_kelompok_aset}', 'KelompokController@ubahkelompokaset');
    Route::post('proses-ubah-kelompok-aset', 'KelompokController@prosesubahkelompokaset');
    Route::get('hapus-kelompok-aset/{id_kelompok_aset}', 'KelompokController@hapuskelompokaset');
});

/* SUB KELOMPOK ASET */
Route::middleware(['auth', 'role:admin'])->prefix('subkelompokaset')->group(function () {
    Route::get('daftar-subkelompok-aset', 'SubkelompokController@daftarsubkelompokaset');
    Route::get('tambah-subkelompok-aset', 'SubkelompokController@tambahsubkelompokaset');
    Route::post('proses-tambah-subkelompok-aset', 'SubkelompokController@prosestambahsubkelompokaset');
    Route::get('ubah-subkelompok-aset/{id_subkelompok_aset}', 'SubkelompokController@ubahsubkelompokaset');
    Route::post('proses-ubah-subkelompok-aset', 'SubkelompokController@prosesubahsubkelompokaset');
    Route::get('hapus-subkelompok-aset/{id_subkelompok_aset}', 'SubkelompokController@hapussubkelompokaset');
    Route::get('jsondatakelompokaset/{id_kelompok_aset}','SubkelompokController@jsondatakelompokaset');
});

/* LOKASI */
Route::middleware(['auth', 'role:admin'])->prefix('lokasi')->group(function () {
    Route::get('daftar-lokasi', 'LokasiController@daftarlokasi');
    Route::get('tambah-lokasi', 'LokasiController@tambahlokasi');
    Route::post('proses-tambah-lokasi', 'LokasiController@prosestambahlokasi');
    Route::get('ubah-lokasi/{id_lokasi}', 'LokasiController@ubahlokasi');
    Route::post('proses-ubah-lokasi', 'LokasiController@prosesubahlokasi');
    Route::get('hapus-lokasi/{id_lokasi}', 'LokasiController@hapuslokasi');
});

/* ASET */
Route::middleware(['auth', 'role:admin'])->prefix('aset')->group(function () {
    Route::get('daftar-aset', 'AsetController@daftaraset');
    Route::get('tambah-aset', 'AsetController@tambahaset');
    Route::post('proses-tambah-aset', 'AsetController@prosestambahaset');
    Route::get('ubah-aset/{id_aset}', 'AsetController@ubahaset');
    Route::post('proses-ubah-aset', 'AsetController@prosesubahaset');
    Route::get('hapus-aset/{id_aset}', 'AsetController@hapusaset');
    Route::get('qrcode-aset/{id_aset}', 'AsetController@generateqrcode');
});

Route::prefix('aset')->group(function () {Route::get('detail-aset/{id_aset}', 'AsetController@detailaset');
});


/* PENGATURAN */
Route::get('role', 'PengaturanController@daftarrole');
Route::get('permission', 'PengaturanController@daftarpermission');
Route::get('tambahpermission', 'PengaturanController@tambahpermission');
Route::post('prosestambahpermission', 'PengaturanController@prosestambahpermission');
Route::get('user', 'PengaturanController@daftaruser');
Route::get('ubahuser/{id_user}','PengaturanController@ubahuser');
Route::post('prosesubahuser','PengaturanController@prosesubahuser');