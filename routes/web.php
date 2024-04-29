<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\kontrolBarang;
use App\Http\Controllers\UserKontrol;
use Illuminate\Support\Facades\Route;

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
//sign-up
Route::GET('/sign-up',[kontrolBarang::class,'index'])->name('daftar');
//sign-in
Route::GET('/next',[kontrolBarang::class,'haveAkun']);
//home
// Route::GET('/admin/dashboard',[kontrolBarang::class,'home'])->name('beranda');
//show data
Route::GET('/admin/dashboard',[kontrolBarang::class,'data'])->name('data');
//add data
Route::GET('/add_table_data',[kontrolBarang::class,'add_data']);
//store-data
Route::GET('/stored_data',[kontrolBarang::class,'store_data']);
//delete data
Route::GET('/delete/{idbarang}',[kontrolBarang::class,'delete'])->name('delete');
//info data
Route::GET('/show/{idbarang}',[kontrolBarang::class, 'showInfoData'])->name('data.info');
//generate qr code
Route::get('/generateQRCode/{idbarang}', [kontrolBarang::class, 'generateQRCode'])->name('generate-qr-code');
//show qr code
Route::get('/showQRCode/{idbarang}', [kontrolBarang::class, 'showQRCode'])->name('show-qr-code');
//update data
Route::GET('/barang/update/{idbarang}', [kontrolBarang::class, 'update'])->name('barang.update');
//edit data
Route::GET('/edit/{idbarang}', [kontrolBarang::class, 'edit'])->name('barang.edit');

//Search Feature
Route::GET('/admin/search', [kontrolBarang::class, 'search'])->name('barang.search');
//Search Feature Gedung A
Route::GET('/gedung-A/search', [kontrolBarang::class, 'searchGedungA'])->name('gedung-A.search');
//Search Feature Gedung B
Route::GET('/gedung-B/search', [kontrolBarang::class, 'searchGedungB'])->name('gedung-B.search');
//Search Feature Gedung C
Route::GET('/gedung-C/search', [kontrolBarang::class, 'searchGedungC'])->name('gedung-C.search');
//Search Feature laporan
Route::GET('/laporan/search', [kontrolBarang::class, 'searchLaporan'])->name('laporan.search');

//Filtrasi
Route::GET('/admin/filter', [kontrolBarang::class, 'filterdata'])->name('barang.filter');
//filtrasi Gedung A
Route::GET('/admin/ruang-A/filter', [kontrolBarang::class, 'filterRA'])->name('gedung-A.filter');
//filtrasi Gedung B
Route::GET('/admin/ruang-B/filter', [kontrolBarang::class, 'filterRB'])->name('gedung-B.filter');
//filtrasi Gedung hhhhhhhhh
Route::GET('/ruang-C/filter', [kontrolBarang::class, 'filterGedungC'])->name('gedung-C.filter');
//filtrasi laporan
Route::GET('/laporan/filter', [kontrolBarang::class, 'filterLaporan'])->name('laporan.filter');

//Gedung A
Route::GET('/gedung-A', [kontrolBarang::class, 'GedungA'])->name('Gedung.A');
//Gedung B
Route::GET('/gedung-B', [kontrolBarang::class, 'GedungB'])->name('Gedung.B');
//Gedung C
Route::GET('/gedung-C', [kontrolBarang::class, 'GedungC'])->name('Gedung.C');


//admin LELANG
route::get('/admin/lelang', [kontrolBarang::class, 'lelang'])->name('lelang');
// filter lelang
Route::GET('/admin/lelang/filter', [kontrolBarang::class, 'filterLelang'])->name('lelang.filter');
Route::post('/lelang/data/send', [kontrolBarang::class, 'sendToPimpinan'])->name('lelang.sendToPimpinan');
Route::post('/send-email', [kontrolBarang::class, 'sendEmail'])->middleware('pimpinan');
// Route::get('/admin/lelang/email', [kontrolBarang::class, 'getEmail'])->name('lelang.email');
Route::GET('/admin/edit/{idbarang}', [kontrolBarang::class,'editHarga'])->name('lelang.edit');
Route::GET('/admin/update/{idbarang}', [kontrolBarang::class, 'updateHarga'])->name('lelang.update');

//admin LELANG
route::get('/admin/hapus', [kontrolBarang::class, 'hapus'])->name('hapus');
// filter lelang
Route::GET('/admin/hapus/filter', [kontrolBarang::class, 'filterHapus'])->name('hapus.filter');

route::get('/laporan', [kontrolBarang::class, 'laporan'])->name('laporan');
Route::GET('/admin/statistik/laporan', [kontrolBarang::class, 'statistik'])->name('laporan.statistik');
//CETAK DATA PER RUANG
Route::GET('/admin/laporan/Cetak', [kontrolBarang::class, 'cetakGedungA'])->name('cetak.ruangAdmin');
Route::GET('/admin/Laporan/Ruang-admin', [kontrolBarang::class, 'ruangAdmin'])->name('ruang.admin');



//Rute User Pimpinan
Route::POST('/stored-data', [UserKontrol::class, 'store'])->name('user.store');

//Rute User Login
Route::GET('/sign-in', [AuthController::class, 'showLoginForm'])->name('login');

Route::POST('/log-in', [AuthController::class, 'login'])->name('loginform');

Route::GET('/log-out', [AuthController::class, 'logout'])->name('logout');


//RUTE untuk Pimpinan
//home
Route::GET('/pimpinan/dashboard',[UserKontrol::class,'homePimpinan'])->name('beranda.pimpinan');

//data
Route::GET('/pimpinan/data', [UserKontrol::class,'dataPimpinan'])->name('data.pimpinan');
//show information data
Route::GET('/pimpinan/show/{idbarang}',[UserKontrol::class, 'showInfoData'])->name('data.info.pimpinan');
//generate qr code
Route::get('/pimpinan/generateQRCode/{idbarang}', [UserKontrol::class, 'generateQRCode'])->name('generate-qr-code.pimpinan');
//show qr code
Route::get('/pimpinan/showQRCode/{idbarang}', [UserKontrol::class, 'showQRCode'])->name('show-qr-code');
//Search data Pimpinan
Route::GET('/pimpinan/search', [UserKontrol::class, 'search'])->name('pimpinan.search');
//Filtrasi data pimpinan
Route::GET('/pimpinan/filter', [UserKontrol::class, 'filterdata'])->name('pimpinan.filter');
// lelang milik pimpinan
Route::GET('/pimpinan/lelang', [UserKontrol::class, 'lelangPimpinan'])->name('lelang.pimpinan');

Route::GET('/pimpinan/lelang/approve/{idbarang}', [UserKontrol::class, 'approve'])->name('lelang.approve');

Route::GET('/pimpinan/lelang/reject/{idbarang}', [UserKontrol::class, 'reject'])->name('lelang.reject');

Route::delete('/barang/{idbarang}', [BarangController::class, 'destroy'])->name('barang.destroy');

Route::Get('/pimpinan/hapus-data', [UserKontrol::class, 'hapusPimpinan'])->name('hapus.pimpinan');
