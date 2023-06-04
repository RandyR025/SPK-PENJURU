<?php

use App\Http\Controllers\Backend\RegisterController ;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DataGuruController;
use App\Http\Controllers\Backend\DataKelasController;
use App\Http\Controllers\Backend\DataPenggunaController;
use App\Http\Controllers\Backend\DataWaliController;
use App\Http\Controllers\Backend\DetailKelasController;
use App\Http\Controllers\Backend\HasilController;
use App\Http\Controllers\Backend\HasilDataPenilaianController;
use App\Http\Controllers\Backend\KriteriaController;
use App\Http\Controllers\Backend\LoginController;
use App\Http\Controllers\Backend\PengisianController;
use App\Http\Controllers\Backend\PenilaianController;
use App\Http\Controllers\Backend\PenilaianKenirjaWaliController;
use App\Http\Controllers\Backend\PenilaianKinerjaGuruController;
use App\Http\Controllers\Backend\PenilaianKinerjaKepalaSekolahController;
use App\Http\Controllers\Backend\PerbandingankriteriaController;
use App\Http\Controllers\Backend\PerbandingansubkriteriaController;
use App\Http\Controllers\Backend\PilihanController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\RekapLaporanController;
use App\Http\Controllers\Backend\SubkriteriaController;
use App\Http\Controllers\Backend\TanggalPenilaianController;
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

        /* Start Data Wali */
        Route::get('/datawali', [DataWaliController::class, 'index'])->name('datawali');
        Route::get('/fetch-wali', [DataWaliController::class, 'fetchwali']);
        Route::get('/edit-wali/{id}',[DataWaliController::class, 'edit']);
        Route::post('/update-wali/{id}',[DataWaliController::class, 'update'])->name('update.wali');
        Route::delete('/delete-wali/{id}',[DataWaliController::class, 'destroy']);
        /* End Data Wali */

        /* Start Data Kelas */
        Route::get('/datakelas', [DataKelasController::class, 'index'])->name('datakelas');
        Route::post('/datakelas', [DataKelasController::class, 'store'])->name('kelas.store');
        Route::get('/fetch-kelas', [DataKelasController::class, 'fetchkelas']);
        Route::get('/edit-kelas/{id}',[DataKelasController::class, 'edit'])->name('editkelas');
        Route::post('/update-kelas/{id}',[DataKelasController::class, 'update'])->name('update.kelas');
        Route::get('/show-kelas/{id}',[DataKelasController::class, 'show'])->name('showkelas');
        Route::delete('/delete-kelas/{id}',[DataKelasController::class, 'destroy']);
        /* End Data Kelas */

        /* Start Data Detail Kelas */
        Route::get('/datadetailkelas', [DetailKelasController::class, 'index'])->name('datadetailkelas');
        Route::post('/datadetailkelas', [DetailKelasController::class, 'store'])->name('detailkelas.store');
        Route::get('/fetch-detailkelas', [DetailKelasController::class, 'fetchkelas']);
        Route::get('/edit-detailkelas/{id}',[DetailKelasController::class, 'edit'])->name('editdetailkelas');
        Route::post('/update-detailkelas/{id}',[DetailKelasController::class, 'update'])->name('update.detailkelas');
        Route::get('/show-detailkelas/{id}',[DetailKelasController::class, 'show'])->name('showdetailkelas');
        Route::delete('/delete-detailkelas/{id}',[DetailKelasController::class, 'destroy']);
        /* End Data Detail Kelas */

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

        /* Start Data Penilaian */
        Route::get('/tanggalpenilaian', [TanggalPenilaianController::class, 'index'])->name('tanggalpenilaian');
        Route::post('/tanggalpenilaian', [TanggalPenilaianController::class, 'store'])->name('tanggalpenilaian.store');
        Route::get('/fetch-tanggalpenilaian', [TanggalPenilaianController::class, 'fetchpenilaian']);
        Route::get('/edit-tanggalpenilaian/{id}',[TanggalPenilaianController::class, 'edit'])->name('edittanggalpenilaian');
        Route::post('/update-tanggalpenilaian/{id}',[TanggalPenilaianController::class, 'update'])->name('update.tanggalpenilaian');
        Route::delete('/delete-tanggalpenilaian/{id}',[TanggalPenilaianController::class, 'destroy']);
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
        Route::get('/hasilpenilaian/{id}/tanggal/{tgl}', [HasilDataPenilaianController::class, 'show'])->name('hasilpenilaian');
        Route::get('/hasilpenilaiankepsek/{id}/tanggal/{tgl}', [HasilDataPenilaianController::class, 'showKepsek'])->name('hasilpenilaiankepsek');
        Route::get('/hasilpenilaianwali/{id}/tanggal/{tgl}', [HasilDataPenilaianController::class, 'showWali'])->name('hasilpenilaianwali');
        Route::get('/hasilpenilaiancek/{id}/cek/{pen}/{tgl}', [HasilDataPenilaianController::class, 'cek'])->name('hasilpenilaiancek');
        Route::post('/penilaiancek', [HasilDataPenilaianController::class, 'hasilcek'])->name('penilaiancek');
        Route::get('/gettotalnilaicek/{id}/total/{user}/{tgl}', [HasilDataPenilaianController::class, 'totalnilai'])->name('gettotalnilaicek');
        Route::delete('/delete-cekjawaban/{id}/penilaian/{penilaian}',[HasilDataPenilaianController::class, 'destroy']);

        Route::get('/daftarpenilaianrangking', [HasilController::class, 'index'])->name('daftarpenilaianrangking');
        Route::get('/hasilrangkingpenilaian/{id}/{tgl}', [HasilController::class, 'show'])->name('hasilrangkingpenilaian');
        Route::get('/hasilrangkingpenilaianwali/{id}/{tgl}', [HasilController::class, 'showwali'])->name('hasilrangkingpenilaianwali');
        /* End Hasil Penilaian */

        /* Penilaian Kinerja Kepala Sekolah */
        Route::get('/penilaiankinerjakepalasekolah',[PenilaianKinerjaKepalaSekolahController::class, 'index'])->name('penilaiankinerjakepalasekolah');
        Route::get('/nilaiguruu',[PenilaianKinerjaKepalaSekolahController::class, 'cari'])->name('nilaiguruu');
        Route::get('/detailkinerjakepalasekolah/{id}/guru/{user}/{tgl}',[PenilaianKinerjaKepalaSekolahController::class, 'show'])->name('detailkinerjakepalasekolah');
        Route::post('/gethasilpenilaiankepalasekolah', [PenilaianKinerjaKepalaSekolahController::class, 'hasilpilihankepalasekolah'])->name('gethasilpenilaiankepalasekolah');
        Route::get('/gettotalnilaikepalasekolah/{id}/total/{user}/tanggal/{tgl}', [PenilaianKinerjaKepalaSekolahController::class, 'totalnilaikepalasekolah'])->name('gettotalnilaikepalasekolah');
        /* Penilaian Kinerja Kepala Sekolah */


        /* Start Cetak */
        Route::get('/hasilpenilaian/cetakpdf/{id}/{tgl}/{cek}', [HasilDataPenilaianController::class, 'cetak_pdf'])->name('hasilpenilaiancetakpdf');
        Route::get('/hasilpenilaian/cetakxlsx/{id}/{tgl}/{cek}', [HasilDataPenilaianController::class, 'eksport_excel'])->name('hasilpenilaiancetakexcel');
        Route::get('/hasilpenilaianrangking/cetakpdf/{id}/{tgl}', [HasilController::class, 'cetak_pdf'])->name('hasilpenilaianrangkingcetakpdf');
        Route::get('/hasilpenilaianrangking/cetakxlsx/{id}/{tgl}', [HasilController::class, 'eksport_excel'])->name('hasilpenilaianrangkingcetakexcel');
        Route::get('/hasilpenilaianrangkingwali/cetakpdf/{id}/{tgl}', [HasilController::class, 'cetak_pdf_wali'])->name('hasilpenilaianrangkingwalicetakpdf');
        Route::get('/hasilpenilaianrangkingwali/cetakxlsx/{id}/{tgl}', [HasilController::class, 'eksport_excel_wali'])->name('hasilpenilaianrangkingwalicetakexcel');
        /* End Cetak */

        /* Start Import */
        Route::post('/datapenggunaimportexcel', [DataPenggunaController::class, 'import'])->name('datapenggunaimportexcel');
        /* End Import */

        /* Start Rekap Laporan */
        Route::get('/rekaplaporan', [RekapLaporanController::class, 'index'])->name('rekaplaporan');
        Route::get('/rekaplaporancetak', [RekapLaporanController::class, 'cetak'])->name('rekaplaporancetak');
        /* End Rekap Laporan */
    });

    Route::group(['middleware' => ['cek_login:guru']], function () {
        Route::get('/dashboardguru', [DashboardController::class, 'index'])->name('dashboardguru');
        Route::get('/ubah_password_guru', [ProfileController::class, 'index_ubahpassword'])->name('ubah_password_guru');
        Route::get('/profileguru', [ProfileController::class, 'index'])->name('profileguru');
        Route::post('/profileguru/{id}',[ProfileController::class, 'update'])->name('updateprofileguru');
        Route::get('/penilaiankinerjaguru',[PenilaianKinerjaGuruController::class, 'index'])->name('penilaiankinerjaguru');
        Route::get('/detailkinerjaguru/{id}/tanggal/{tgl}',[PenilaianKinerjaGuruController::class, 'show'])->name('detailkinerjaguru');
        Route::post('/gethasilpenilaian', [PenilaianKinerjaGuruController::class, 'hasilpilihan'])->name('gethasilpenilaian');
        Route::get('/gettotalnilai/{id}/tanggal/{tgl}', [PenilaianKinerjaGuruController::class, 'totalnilai'])->name('gettotalnilai');
    });

    Route::group(['middleware' => ['cek_login:wali']], function () {
        Route::get('/dashboardwali', [DashboardController::class, 'index'])->name('dashboardwali');
        Route::get('/ubah_password_wali', [ProfileController::class, 'index_ubahpassword'])->name('ubah_password_wali');
        Route::get('/profilewali', [ProfileController::class, 'index'])->name('profilewali');
        Route::post('/profilewali/{id}',[ProfileController::class, 'update'])->name('updateprofilewali');
        Route::get('/penilaiankinerjawali',[PenilaianKenirjaWaliController::class, 'index'])->name('penilaiankinerjawali');
        Route::get('/nilaiguru',[PenilaianKenirjaWaliController::class, 'cari'])->name('nilaiguru');
        Route::get('/detailkinerjawali/{id}/guru/{user}/{tgl}',[PenilaianKenirjaWaliController::class, 'show'])->name('detailkinerjawali');
        Route::post('/gethasilpenilaianwali', [PenilaianKenirjaWaliController::class, 'hasilpilihanwali'])->name('gethasilpenilaianwali');
        Route::get('/gettotalnilaiwali/{id}/total/{user}/tanggal/{tgl}', [PenilaianKenirjaWaliController::class, 'totalnilaiwali'])->name('gettotalnilaiwali');
    });
});
Route::get('/masukLogin', [LoginController::class, 'index'])->name('masuklogin');
Route::post('/authenticate', [LoginController::class, 'masukLogin'])->name('masukLogin');
Route::post('/keluarlogout', [LoginController::class, 'logout'])->name('keluarlogout');
Route::get('/daftarregister', [RegisterController::class, 'index'])->name('daftarregister');
Route::post('/simpanregistrasi', [RegisterController::class, 'simpanregistrasi'])->name('simpanregistrasi');
Route::get('/ubah_password', [ProfileController::class, 'index_ubahpassword'])->name('ubah_password');
Route::put('/ubah_password_baru', [ProfileController::class, 'changePassword'])->name('changepassword');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
