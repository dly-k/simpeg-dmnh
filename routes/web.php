<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// ================== Pegawai ==================
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\EFileController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\PenetapanPangkatController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\JabatanSaatIniController;
use App\Http\Controllers\PensiunController;
use App\Http\Controllers\KenaikanGajiBerkalaController;
use App\Http\Controllers\TugasBelajarController;
use App\Http\Controllers\SkNonPnsController;

// ================== Surat Tugas ==================
use App\Http\Controllers\SuratTugasController;

// ================== Editor ==================
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\PenghargaanController;
use App\Http\Controllers\PraktisiController;

// ================== Editor Kegiatan ==================
use App\Http\Controllers\BahanAjarController;
use App\Http\Controllers\PembicaraController;
use App\Http\Controllers\PengabdianController;
use App\Http\Controllers\OrganisasiProfesiController;
use App\Http\Controllers\PembimbinganController;
use App\Http\Controllers\PenunjangController;
use App\Http\Controllers\OrasiIlmiahController;
use App\Http\Controllers\SertifikatKompetensiController;
use App\Http\Controllers\PendidikanController;
use App\Http\Controllers\PengelolaJurnalController;
use App\Http\Controllers\PenelitianController;
use App\Http\Controllers\KekayaanIntelektualController;

// ================== Kerjasama ==================
use App\Http\Controllers\KerjasamaController;


// ===================================================================
// ================== RUTE UNTUK AUTH & DASHBOARD ====================
// ===================================================================
Route::view('/', 'auth.login');
Route::view('/login', 'auth.login')->name('login');
Route::view('/ubah-password', 'auth.ubah-password');
Route::view('/master-data', 'auth.master-data');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Pegawai
Route::get('/daftar-pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
Route::get('/tambah-pegawai', [PegawaiController::class, 'create'])->name('pegawai.create');
Route::post('/tambah-pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
Route::get('/pegawai/{pegawai}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
Route::put('/pegawai/{pegawai}', [PegawaiController::class, 'update'])->name('pegawai.update');
Route::get('/pegawai/{pegawai}', [PegawaiController::class, 'show'])->name('pegawai.show');
Route::delete('/pegawai/{pegawai}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');
Route::get('/daftar-pegawai/export', [PegawaiController::class, 'export'])->name('pegawai.export');

// Rute untuk E-File dan Relasi Pegawai Lainnya
Route::post('/pegawai/{pegawai}/efile', [EFileController::class, 'store'])->name('efile.store');
Route::delete('/efile/{efile}', [EFileController::class, 'destroy'])->name('efile.destroy');
Route::get('/dokumen/preview/{path}', [DokumenController::class, 'show'])->where('path', '.*')->name('dokumen.preview');

// ===================================================================
// ================== RUTE UNTUK MENU SK (SURAT KEPUTUSAN) ==========
// ===================================================================

// Rute untuk Penetapan Pangkat
Route::prefix('pegawai/{pegawai}/pangkat')->name('pangkat.')->controller(PenetapanPangkatController::class)->group(function () {
    Route::get('/export', 'export')->name('export');
    Route::post('/', 'store')->name('store');
    Route::put('/{pangkat}', 'update')->name('update');
    Route::delete('/{pangkat}', 'destroy')->name('destroy');
});

// Rute untuk Jabatan
Route::prefix('pegawai/{pegawai}/jabatan')->name('jabatan.')->controller(JabatanController::class)->group(function () {
    Route::get('/export', 'export')->name('export');
    Route::post('/', 'store')->name('store');
    Route::put('/{jabatan}', 'update')->name('update');
    Route::delete('/{jabatan}', 'destroy')->name('destroy');
});

// Rute untuk Jabatan Saat Ini
Route::prefix('pegawai/{pegawai}/jabatan-saat-ini')->name('jabatan-saat-ini.')->controller(JabatanSaatIniController::class)->group(function () {
    Route::get('/export', 'export')->name('export');
    Route::post('/', 'store')->name('store');
    Route::put('/{jabatanSaatIni}', 'update')->name('update');
    Route::delete('/{jabatanSaatIni}', 'destroy')->name('destroy');
});

// Rute untuk Pensiun
Route::prefix('pegawai/{pegawai}/pensiun')->name('pensiun.')->controller(PensiunController::class)->group(function () {
    Route::get('/export', 'export')->name('export');
    Route::post('/', 'store')->name('store');
    Route::put('/{pensiun}', 'update')->name('update');
    Route::delete('/{pensiun}', 'destroy')->name('destroy');
});

// Rute untuk Kenaikan Gaji Berkala
Route::prefix('pegawai/{pegawai}/gaji-berkala')->name('gaji-berkala.')->controller(KenaikanGajiBerkalaController::class)->group(function () {
    Route::get('/export', 'export')->name('export');
    Route::post('/', 'store')->name('store');
    Route::put('/{gajiBerkala}', 'update')->name('update');
    Route::delete('/{gajiBerkala}', 'destroy')->name('destroy');
});

// Rute untuk Tugas Belajar
Route::prefix('pegawai/{pegawai}/tugas-belajar')->name('tugas-belajar.')->controller(TugasBelajarController::class)->group(function () {
    Route::get('/export', 'export')->name('export');
    Route::post('/', 'store')->name('store');
    Route::put('/{tugasBelajar}', 'update')->name('update');
    Route::delete('/{tugasBelajar}', 'destroy')->name('destroy');
});

// Rute untuk SK Non PNS
Route::prefix('pegawai/{pegawai}/sk-non-pns')->name('sk-non-pns.')->controller(SkNonPnsController::class)->group(function () {
    Route::get('/export', 'export')->name('export');
    Route::post('/', 'store')->name('store');
    Route::put('/{skNonPn}', 'update')->name('update');
    Route::delete('/{skNonPn}', 'destroy')->name('destroy');
});

// ================== Halaman Utama ==================
Route::view('/pendidikan', 'pages.pendidikan');
Route::get('/pendidikan', [PendidikanController::class, 'index'])->name('pendidikan.index');
Route::post('/pendidikan/verifikasi', [PendidikanController::class, 'verifikasi'])->name('pendidikan.verifikasi');
Route::delete('/pendidikan/hapus', [PendidikanController::class, 'hapus'])->name('pendidikan.hapus');

// ================== Pengajaran Lama ==================
Route::post('/pendidikan/pengajaran-lama', [PendidikanController::class, 'storePengajaranLama'])->name('pendidikan.pengajaran-lama.store');
Route::get('/pendidikan/pengajaran-lama/{id}/edit', [PendidikanController::class, 'editPengajaranLama']);
Route::post('/pendidikan/pengajaran-lama/{id}', [PendidikanController::class, 'updatePengajaranLama'])->name('pendidikan.pengajaran-lama.update');
Route::get('/pendidikan/pengajaran-lama/{id}', [PendidikanController::class, 'showPengajaranLama']);

// ================== Pengajaran Luar ==================
Route::post('/pendidikan/pengajaran-luar', [PendidikanController::class, 'storePengajaranLuar'])->name('pendidikan.pengajaran-luar.store');
Route::get('/pendidikan/pengajaran-luar/{id}/edit', [PendidikanController::class, 'editPengajaranLuar']);
Route::post('/pendidikan/pengajaran-luar/{id}', [PendidikanController::class, 'updatePengajaranLuar'])->name('pendidikan.pengajaran-luar.update');
Route::get('/pendidikan/pengajaran-luar/{id}', [PendidikanController::class, 'showPengajaranLuar']);

// ================== Pengujian Lama ==================
Route::post('/pendidikan/pengujian-lama', [PendidikanController::class, 'storePengujianLama'])->name('pendidikan.pengujian-lama.store');
Route::get('/pendidikan/pengujian-lama/{id}/edit', [PendidikanController::class, 'editPengujianLama']);
Route::post('/pendidikan/pengujian-lama/{id}', [PendidikanController::class, 'updatePengujianLama'])->name('pendidikan.pengujian-lama.update');
Route::get('/pendidikan/pengujian-lama/{id}', [PendidikanController::class, 'showPengujianLama']);

// ================== Pembimbing Lama ==================
Route::post('/pendidikan/pembimbing-lama', [PendidikanController::class, 'storePembimbingLama'])->name('pendidikan.pembimbing-lama.store');
Route::get('/pendidikan/pembimbing-lama/{id}/edit', [PendidikanController::class, 'editPembimbingLama']);
Route::post('/pendidikan/pembimbing-lama/{id}', [PendidikanController::class, 'updatePembimbingLama'])->name('pendidikan.pembimbing-lama.update');
Route::get('/pendidikan/pembimbing-lama/{id}', [PendidikanController::class, 'showPembimbingLama']);

// ================== Penguji Luar ==================
Route::post('/pendidikan/penguji-luar', [PendidikanController::class, 'storePengujiLuar'])->name('pendidikan.penguji-luar.store');
Route::get('/pendidikan/penguji-luar/{id}/edit', [PendidikanController::class, 'editPengujiLuar']);
Route::post('/pendidikan/penguji-luar/{id}', [PendidikanController::class, 'updatePengujiLuar'])->name('pendidikan.penguji-luar.update');
Route::get('/pendidikan/penguji-luar/{id}', [PendidikanController::class, 'showPengujiLuar']);

// ================== Pembimbing Luar ==================
Route::post('/pendidikan/pembimbing-luar', [PendidikanController::class, 'storePembimbingLuar'])->name('pendidikan.pembimbing-luar.store');
Route::get('/pendidikan/pembimbing-luar/{id}/edit', [PendidikanController::class, 'editPembimbingLuar']);
Route::post('/pendidikan/pembimbing-luar/{id}', [PendidikanController::class, 'updatePembimbingLuar'])->name('pendidikan.pembimbing-luar.update');
Route::get('/pendidikan/pembimbing-luar/{id}', [PendidikanController::class, 'showPembimbingLuar']);


Route::get('/penelitian', [PenelitianController::class, 'index'])->name('penelitian.index');
Route::post('/penelitian', [PenelitianController::class, 'store'])->name('penelitian.store');
Route::get('/penelitian/{penelitian}/edit', [PenelitianController::class, 'edit'])->name('penelitian.edit');
Route::patch('/penelitian/{penelitian}', [PenelitianController::class, 'update'])->name('penelitian.update');
Route::delete('/penelitian/{penelitian}', [PenelitianController::class, 'destroy'])->name('penelitian.destroy');
Route::post('/penelitian/{penelitian}/verifikasi', [PenelitianController::class, 'verifikasi'])->name('penelitian.verifikasi');

Route::get('/pengabdian', [PengabdianController::class, 'index'])->name('pengabdian.index');
Route::post('/pengabdian', [PengabdianController::class, 'store'])->name('pengabdian.store');
Route::get('/pengabdian/{pengabdian}/edit', [PengabdianController::class, 'edit'])->name('pengabdian.edit');
Route::patch('/pengabdian/{pengabdian}', [PengabdianController::class, 'update'])->name('pengabdian.update');
Route::delete('/pengabdian/{pengabdian}', [PengabdianController::class, 'destroy'])->name('pengabdian.destroy');
Route::get('/pengabdian/{pengabdian}', [PengabdianController::class, 'show'])->name('pengabdian.show');
Route::patch('/pengabdian/{pengabdian}/verifikasi', [PengabdianController::class, 'verifikasi'])->name('pengabdian.verifikasi');

Route::get('/penunjang', [PenunjangController::class, 'index'])->name('penunjang.index');
Route::post('/penunjang', [PenunjangController::class, 'store'])->name('penunjang.store');
Route::get('/penunjang/{penunjang}', [PenunjangController::class, 'show'])->name('penunjang.show');
Route::patch('/penunjang/{penunjang}', [PenunjangController::class, 'update'])->name('penunjang.update');
Route::delete('/penunjang/{penunjang}', [PenunjangController::class, 'destroy'])->name('penunjang.destroy');
Route::patch('/penunjang/{penunjang}/verifikasi', [PenunjangController::class, 'verifikasi'])->name('penunjang.verifikasi');

// Surat Tugas
Route::resource('surat-tugas', SuratTugasController::class)->except(['show']);
Route::get('/surat-tugas/export', [SuratTugasController::class, 'export'])
    ->name('surat-tugas.export');

// Pelatihan
Route::resource('pelatihan', PelatihanController::class);

// Penghargaan
Route::prefix('penghargaan')->name('penghargaan.')->controller(PenghargaanController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}', 'update')->name('update');
    Route::delete('/{id}', 'destroy')->name('destroy');
});

// Kerjasama
Route::resource('kerjasama', KerjasamaController::class);
Route::get('/kerjasama/export', [KerjasamaController::class, 'export'])
    ->name('kerjasama.export');


Route::get('/praktisi-dunia-industri', [PraktisiController::class, 'index'])->name('praktisi.index');
Route::post('/praktisi-dunia-industri', [PraktisiController::class, 'store'])->name('praktisi.store');
Route::get('/praktisi-dunia-industri/{praktisi}', [PraktisiController::class, 'show'])->name('praktisi.show');
Route::put('/praktisi-dunia-industri/{praktisi}', [PraktisiController::class, 'update'])->name('praktisi.update');
Route::delete('/praktisi-dunia-industri/{praktisi}', [PraktisiController::class, 'destroy'])->name('praktisi.destroy');
Route::patch('/praktisi-dunia-industri/{praktisi}/verifikasi', [PraktisiController::class, 'verify'])->name('praktisi.verify');


Route::get('/bahan-ajar', [BahanAjarController::class, 'index'])->name('bahan-ajar.index');


Route::get('/pembicara', [PembicaraController::class, 'index'])->name('pembicara.index');
Route::post('/pembicara', [PembicaraController::class, 'store'])->name('pembicara.store');
Route::get('/pembicara/{pembicara}/edit', [PembicaraController::class, 'edit'])->name('pembicara.edit');
Route::put('/pembicara/{pembicara}', [PembicaraController::class, 'update'])->name('pembicara.update');
Route::patch('/pembicara/{pembicara}/verifikasi', [PembicaraController::class, 'verifikasi'])->name('pembicara.verifikasi');
Route::delete('/pembicara/{pembicara}', [PembicaraController::class, 'destroy'])->name('pembicara.destroy');

Route::get('/organisasi-profesi', [OrganisasiProfesiController::class, 'index'])->name('organisasi-profesi.index');

Route::get('/pembimbingan', [PembimbinganController::class, 'index'])->name('pembimbingan.index');

// ORASI ILMIAH
Route::get('/orasi-ilmiah', [OrasiIlmiahController::class, 'index'])->name('orasi-ilmiah.index');
Route::post('/orasi-ilmiah', [OrasiIlmiahController::class, 'store'])->name('orasi-ilmiah.store');
Route::get('/orasi-ilmiah/{orasiIlmiah}/edit', [OrasiIlmiahController::class, 'edit'])->name('orasi-ilmiah.edit');
Route::put('/orasi-ilmiah/{orasiIlmiah}', [OrasiIlmiahController::class, 'update'])->name('orasi-ilmiah.update');
Route::delete('/orasi-ilmiah/{orasiIlmiah}', [OrasiIlmiahController::class, 'destroy'])->name('orasi-ilmiah.destroy');

Route::get('/sertifikat-kompetensi', [SertifikatKompetensiController::class, 'index'])->name('sertifikat-kompetensi.index');

Route::get('/pengelola-jurnal', [PengelolaJurnalController::class, 'index'])->name('pengelola-jurnal.index');

Route::get('/kekayaan-intelektual', [KekayaanIntelektualController::class, 'index'])->name('kekayaan-intelektual.index');