<?php

use App\Http\Controllers\Backend\RegisterController ;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DataGuruController;
use App\Http\Controllers\Backend\DataPenggunaController;
use App\Http\Controllers\Backend\HasilController;
use App\Http\Controllers\Backend\HasilDataPenilaianController;
use App\Http\Controllers\Backend\KriteriaController;
use App\Http\Controllers\Backend\LoginController;
use App\Http\Controllers\Backend\PengisianController;
use App\Http\Controllers\Backend\PenilaianController;
use App\Http\Controllers\Backend\PenilaianKinerjaGuruController;
use App\Http\Controllers\Backend\PerbandingankriteriaController;
use App\Http\Controllers\Backend\PerbandingansubkriteriaController;
use App\Http\Controllers\Backend\PilihanController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SubkriteriaController;
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

Route::get('/', function () {
    return view('backend/autentikasi.login');
});
Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['cek_login:admin']], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::post('/profile/{id}',[ProfileController::class, 'update'])->name('updateprofile');

        /*Start Data Pengguna */
        Route::get('/datapengguna', [DataPenggunaController::class, 'index'])->name('datapengguna');
        /* Route::post('/datapengguna{id}', [DataPenggunaController::class, 'edit'])->name('editdatapengguna'); */
        Route::post('/datapengguna', [DataPenggunaController::class, 'store'])->name('pengguna.store');
        Route::get('/fetch-user', [DataPenggunaController::class, 'fetchuser']);
        Route::get('/edit-user/{id}',[DataPenggunaController::class, 'edit']);
        Route::put('/update-user/{id}',[DataPenggunaController::class, 'update']);
        Route::delete('/delete-user/{id}',[DataPenggunaController::class, 'destroy']);
        /* End Data Pengguna */

        /* Start Data Guru */
        Route::get('/dataguru', [DataGuruController::class, 'index'])->name('dataguru');
        Route::get('/fetch-guru', [DataGuruController::class, 'fetchguru']);
        Route::get('/edit-guru/{id}',[DataGuruController::class, 'edit']);
        Route::post('/update-guru/{id}',[DataGuruController::class, 'update'])->name('update.guru');
        Route::delete('/delete-guru/{id}',[DataGuruController::class, 'destroy']);
        /* End Data Guru */

        /* Start Data Kriteria */
        Route::get('/datakriteria', [KriteriaController::class, 'index'])->name('datakriteria');
        Route::post('/datakriteria', [KriteriaController::class, 'store'])->name('kriteria.store');
        Route::get('/fetch-kriteria', [KriteriaController::class, 'fetchkriteria']);
        Route::get('/edit-kriteria/{id}',[KriteriaController::class, 'edit'])->name('editkriteria');
        Route::post('/update-kriteria/{id}',[KriteriaController::class, 'update'])->name('update.kriteria');
        Route::delete('/delete-kriteria/{id}',[KriteriaController::class, 'destroy']);
        /* End Data Kriteria */

        /* Start Data Subkriteria */
        Route::get('/datasubkriteria', [SubkriteriaController::class, 'index'])->name('datasubkriteria');
        Route::get('/show-subkriteria/{id}',[SubkriteriaController::class, 'show'])->name('showkriteria');
        Route::get('/fetch-subkriteria/{id}', [SubkriteriaController::class, 'fetchsubkriteria']);
        Route::get('/edit-subkriteria/{id}',[SubkriteriaController::class, 'edit'])->name('editsubkriteria');
        Route::post('/update-subkriteria/{id}',[SubkriteriaController::class, 'update'])->name('update.subkriteria');
        Route::post('/datasubkriteria', [SubkriteriaController::class, 'store'])->name('subkriteria.store');
        Route::delete('/delete-subkriteria/{id}',[SubkriteriaController::class, 'destroy']);
        /* End Data Subkriteria */

        /* Start Data Penilaian */
        Route::get('/datapenilaian', [PenilaianController::class, 'index'])->name('datapenilaian');
        Route::post('/datapenilaian', [PenilaianController::class, 'store'])->name('penilaian.store');
        Route::get('/fetch-penilaian', [PenilaianController::class, 'fetchpenilaian']);
        Route::get('/edit-penilaian/{id}',[PenilaianController::class, 'edit'])->name('editpenilaian');
        Route::post('/update-penilaian/{id}',[PenilaianController::class, 'update'])->name('update.penilaian');
        Route::delete('/delete-penilaian/{id}',[PenilaianController::class, 'destroy']);
        /* End Data Penilaian */

        /* Start Data Pengisian */
        Route::get('/datapengisian', [PengisianController::class, 'index'])->name('datapengisian');
        Route::get('/show-pengisian/{id}',[PengisianController::class, 'show'])->name('showpengisian');
        Route::get('/fetch-pengisian/{id}', [PengisianController::class, 'fetchpengisian']);
        Route::get('/edit-pengisian/{id}',[PengisianController::class, 'edit'])->name('editpengisian');
        Route::post('/update-pengisian/{id}',[PengisianController::class, 'update'])->name('update.pengisian');
        Route::post('/datapengisian', [PengisianController::class, 'store'])->name('pengisian.store');
        Route::delete('/delete-pengisian/{id}',[PengisianController::class, 'destroy']);
        Route::get('/getsubkriteria/{id}', [PengisianController::class, 'getSubkriteria'])->name('getSubkriteria');
                
        /* End Data Pengisian */

        /* Start Data Pilihan */
        Route::get('/datapilihan', [PilihanController::class, 'index'])->name('datapilihan');
        Route::get('/show-pilihan/{id}',[PilihanController::class, 'show'])->name('showpilihan');
        Route::get('/fetch-pilihan/{id}', [PilihanController::class, 'fetchpilihan']);
        Route::get('/edit-pilihan/{id}',[PilihanController::class, 'edit'])->name('editpilihan');
        Route::post('/update-pilihan/{id}',[PilihanController::class, 'update'])->name('update.pilihan');
        Route::post('/datapilihan', [PilihanController::class, 'store'])->name('pilihan.store');
        Route::delete('/delete-pilihan/{id}',[PilihanController::class, 'destroy']);
        /* End Data Pilihan */

        /* Start Perbandingan Kriteria */
        Route::get('/perbandingankriteria', [PerbandingankriteriaController::class, 'index'])->name('perbandingankriteria');
        Route::post('/perbandingansimpan', [PerbandingankriteriaController::class, 'store'])->name('perbandingansimpan');
        Route::post('/perbandinganproses', [PerbandingankriteriaController::class, 'proses'])->name('perbandinganproses');
        /* End Perbandingan Kriteria */

        /* Start Perbandingan SubKriteria */
        Route::get('/perbandingansubkriteria', [PerbandingansubkriteriaController::class, 'index'])->name('perbandingansubkriteria');
        Route::get('/show-perbandingansubkriteria/{id}',[PerbandingansubkriteriaController::class, 'show'])->name('showperbandingansubkriteria');
        Route::post('/subperbandinganproses', [PerbandingansubkriteriaController::class, 'proses'])->name('subperbandinganproses');
        /* End Perbandingan SubKriteria */

        /* Start Hasil Penilaian */
        Route::get('/daftarpenilaian', [HasilDataPenilaianController::class, 'index'])->name('daftarpenilaian');
        Route::get('/hasilpenilaian/{id}', [HasilDataPenilaianController::class, 'show'])->name('hasilpenilaian');
        Route::get('/hasilpenilaiancek/{id}/cek/{pen}', [HasilDataPenilaianController::class, 'cek'])->name('hasilpenilaiancek');
        Route::post('/penilaiancek', [HasilDataPenilaianController::class, 'hasilcek'])->name('penilaiancek');
        Route::get('/gettotalnilaicek/{id}/total/{user}', [HasilDataPenilaianController::class, 'totalnilai'])->name('gettotalnilaicek');

        Route::get('/daftarpenilaianrangking', [HasilController::class, 'index'])->name('daftarpenilaianrangking');
        Route::get('/hasilrangkingpenilaian/{id}', [HasilController::class, 'show'])->name('hasilrangkingpenilaian');
        /* End Hasil Penilaian */


        /* Start Cetak */
        Route::get('/hasilpenilaian/cetakpdf/{id}', [HasilDataPenilaianController::class, 'cetak_pdf'])->name('hasilpenilaiancetakpdf');
        /* End Cetak */
    });
    Route::group(['middleware' => ['cek_login:guru']], function () {
        Route::get('/dashboardguru', [DashboardController::class, 'index'])->name('dashboardguru');
        Route::get('/profileguru', [ProfileController::class, 'index'])->name('profileguru');
        Route::post('/profileguru/{id}',[ProfileController::class, 'update'])->name('updateprofileguru');
        Route::get('/penilaiankinerjaguru',[PenilaianKinerjaGuruController::class, 'index'])->name('penilaiankinerjaguru');
        Route::get('/detailkinerjaguru/{id}',[PenilaianKinerjaGuruController::class, 'show'])->name('detailkinerjaguru');
        Route::post('/gethasilpenilaian', [PenilaianKinerjaGuruController::class, 'hasilpilihan'])->name('gethasilpenilaian');
        Route::get('/gettotalnilai/{id}', [PenilaianKinerjaGuruController::class, 'totalnilai'])->name('gettotalnilai');
    });
});
Route::get('/masukLogin', [LoginController::class, 'index'])->name('masuklogin');
Route::post('/authenticate', [LoginController::class, 'masukLogin'])->name('masukLogin');
Route::post('/keluarlogout', [LoginController::class, 'logout'])->name('keluarlogout');
Route::get('/daftarregister', [RegisterController::class, 'index'])->name('daftarregister');
Route::post('/simpanregistrasi', [RegisterController::class, 'simpanregistrasi'])->name('simpanregistrasi');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
