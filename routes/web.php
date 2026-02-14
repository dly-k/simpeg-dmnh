<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
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
use App\Http\Controllers\SuratTugasController;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\PenghargaanController;
use App\Http\Controllers\PraktisiController;
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
use App\Http\Controllers\KerjasamaController;
use App\Http\Controllers\MonitoringController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan rute web untuk aplikasi Anda. Rute-rute
| ini dimuat oleh RouteServiceProvider dan semuanya akan
| ditugaskan ke grup middleware "web". Buat sesuatu yang hebat!
|
*/

// ================== RUTE UNTUK AUTENTIKASI (LOGIN & LOGOUT) ====================
Route::get('/', [AuthController::class, 'showLoginForm']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ================== SEMUA RUTE DI BAWAH INI MEMBUTUHKAN LOGIN ====================
Route::middleware(['auth'])->group(function () {

    // HALAMAN UTAMA SETELAH LOGIN
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::view('/ubah-password', 'auth.ubah-password');
    Route::post('/ubah-password', [AuthController::class, 'updatePassword'])->name('password.update');
    Route::get('/dokumen/preview/{path}', [DokumenController::class, 'show'])->where('path', '.*')->name('dokumen.preview');

    // ================== HANYA BISA DIAKSES OLEH ROLE: admin ==================
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/master-data', [UserController::class, 'index'])->name('master-data.index');
        Route::post('/master-data', [UserController::class, 'store'])->name('master-data.store');
        Route::put('/master-data/{user}', [UserController::class, 'update'])->name('master-data.update');
        Route::delete('/master-data/{user}', [UserController::class, 'destroy'])->name('master-data.destroy');
    });

    // ================== TIDAK BISA DIAKSES OLEH ROLE: tata_usaha ==================
    Route::middleware(['role:admin,admin_verifikator'])->group(function () {
        // Pegawai
        Route::get('/daftar-pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
        Route::get('/tambah-pegawai', [PegawaiController::class, 'create'])->name('pegawai.create');
        Route::post('/tambah-pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
        Route::get('/pegawai/{pegawai}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
        Route::put('/pegawai/{pegawai}', [PegawaiController::class, 'update'])->name('pegawai.update');
        Route::get('/pegawai/{pegawai}', [PegawaiController::class, 'show'])->name('pegawai.show');
        Route::delete('/pegawai/{pegawai}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');
        Route::get('/daftar-pegawai/export', [PegawaiController::class, 'export'])->name('pegawai.export');

        // E-File dan Relasi Pegawai Lainnya
        Route::post('/pegawai/{id}/efile', [App\Http\Controllers\EFileController::class, 'store'])->name('efile.store');
        Route::delete('/efile/{efile}', [EFileController::class, 'destroy'])->name('efile.destroy');

        // SK Pegawai
        Route::prefix('pegawai/{pegawai}/pangkat')->name('pangkat.')->controller(PenetapanPangkatController::class)->group(function () {
            Route::get('/export', 'export')->name('export');
            Route::post('/', 'store')->name('store');
            Route::put('/{pangkat}', 'update')->name('update');
            Route::delete('/{pangkat}', 'destroy')->name('destroy');
        });
        Route::prefix('pegawai/{pegawai}/jabatan')->name('jabatan.')->controller(JabatanController::class)->group(function () {
            Route::get('/export', 'export')->name('export');
            Route::post('/', 'store')->name('store');
            Route::put('/{jabatan}', 'update')->name('update');
            Route::delete('/{jabatan}', 'destroy')->name('destroy');
        });
        Route::prefix('pegawai/{pegawai}/jabatan-saat-ini')->name('jabatan-saat-ini.')->controller(JabatanSaatIniController::class)->group(function () {
            Route::get('/export', 'export')->name('export');
            Route::post('/', 'store')->name('store');
            Route::put('/{jabatanSaatIni}', 'update')->name('update');
            Route::delete('/{jabatanSaatIni}', 'destroy')->name('destroy');
        });
        Route::prefix('pegawai/{pegawai}/pensiun')->name('pensiun.')->controller(PensiunController::class)->group(function () {
            Route::get('/export', 'export')->name('export');
            Route::post('/', 'store')->name('store');
            Route::put('/{pensiun}', 'update')->name('update');
            Route::delete('/{pensiun}', 'destroy')->name('destroy');
        });
        Route::prefix('pegawai/{pegawai}/gaji-berkala')->name('gaji-berkala.')->controller(KenaikanGajiBerkalaController::class)->group(function () {
            Route::get('/export', 'export')->name('export');
            Route::post('/', 'store')->name('store');
            Route::put('/{gajiBerkala}', 'update')->name('update');
            Route::delete('/{gajiBerkala}', 'destroy')->name('destroy');
        });
        Route::prefix('pegawai/{pegawai}/tugas-belajar')->name('tugas-belajar.')->controller(TugasBelajarController::class)->group(function () {
            Route::get('/export', 'export')->name('export');
            Route::post('/', 'store')->name('store');
            Route::put('/{tugasBelajar}', 'update')->name('update');
            Route::delete('/{tugasBelajar}', 'destroy')->name('destroy');
        });
        Route::prefix('pegawai/{pegawai}/sk-non-pns')->name('sk-non-pns.')->controller(SkNonPnsController::class)->group(function () {
            Route::get('/export', 'export')->name('export');
            Route::post('/', 'store')->name('store');
            Route::put('/{skNonPn}', 'update')->name('update');
            Route::delete('/{skNonPn}', 'destroy')->name('destroy');
        });
    });

    // ================== HANYA BISA DIAKSES OLEH ROLE: admin_verifikator ==================
    Route::middleware(['role:admin_verifikator'])->group(function () {
        Route::post('/pendidikan/verifikasi', [PendidikanController::class, 'verifikasi'])->name('pendidikan.verifikasi');
        Route::post('/penelitian/{penelitian}/verifikasi', [PenelitianController::class, 'verifikasi'])->name('penelitian.verifikasi');
        Route::patch('/pengabdian/{pengabdian}/verifikasi', [PengabdianController::class, 'verifikasi'])->name('pengabdian.verifikasi');
        Route::patch('/penunjang/{penunjang}/verifikasi', [PenunjangController::class, 'verifikasi'])->name('penunjang.verifikasi');
        Route::patch('/praktisi-dunia-industri/{praktisi}/verifikasi', [PraktisiController::class, 'verify'])->name('praktisi.verify');
        Route::patch('/pembicara/{pembicara}/verifikasi', [PembicaraController::class, 'verifikasi'])->name('pembicara.verifikasi');
        Route::patch('/orasi-ilmiah/{orasiIlmiah}/verifikasi', [OrasiIlmiahController::class, 'verifikasi'])->name('orasi-ilmiah.verifikasi');
        Route::patch('/sertifikat-kompetensi/{sertifikatKompetensi}/verifikasi', [SertifikatKompetensiController::class, 'verifikasi'])->name('sertifikat-kompetensi.verifikasi');
        Route::patch('/pengelola-jurnal/{pengelolaJurnal}/verifikasi', [PengelolaJurnalController::class, 'verifikasi'])->name('pengelola-jurnal.verifikasi');
    });

    // ================== BISA DIAKSES OLEH SEMUA ROLE (YANG SUDAH LOGIN) ==================
    
    // Surat Tugas
    Route::resource('surat-tugas', SuratTugasController::class)->except(['show']);
    Route::get('/surat-tugas/export', [SuratTugasController::class, 'export'])->name('surat-tugas.export');

    // Pelatihan
    Route::resource('pelatihan', PelatihanController::class)->except(['show']);
    Route::get('/pelatihan/export', [PelatihanController::class, 'export'])->name('pelatihan.export');

    // Penghargaan
    Route::prefix('penghargaan')->name('penghargaan.')->controller(PenghargaanController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::post('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });
    Route::get('/penghargaan/export', [PenghargaanController::class, 'export'])->name('penghargaan.export');

    // Praktisi
    Route::get('/praktisi-dunia-industri', [PraktisiController::class, 'index'])->name('praktisi.index');
    Route::post('/praktisi-dunia-industri', [PraktisiController::class, 'store'])->name('praktisi.store');
    Route::get('/praktisi-dunia-industri/{praktisi}', [PraktisiController::class, 'show'])->name('praktisi.show');
    Route::put('/praktisi-dunia-industri/{praktisi}', [PraktisiController::class, 'update'])->name('praktisi.update');
    Route::delete('/praktisi-dunia-industri/{praktisi}', [PraktisiController::class, 'destroy'])->name('praktisi.destroy');
    Route::get('/praktisi/export', [PraktisiController::class, 'export'])->name('praktisi.export');

    // Pembicara
    Route::get('/pembicara', [PembicaraController::class, 'index'])->name('pembicara.index');
    Route::post('/pembicara', [PembicaraController::class, 'store'])->name('pembicara.store');
    Route::get('/pembicara/{pembicara}/edit', [PembicaraController::class, 'edit'])->name('pembicara.edit');
    Route::put('/pembicara/{pembicara}', [PembicaraController::class, 'update'])->name('pembicara.update');
    Route::delete('/pembicara/{pembicara}', [PembicaraController::class, 'destroy'])->name('pembicara.destroy');
    Route::get('/pembicara/export', [PembicaraController::class, 'export'])->name('pembicara.export');

    // Pengabdian
    Route::get('/pengabdian/export', [PengabdianController::class, 'export'])->name('pengabdian.export');
    Route::get('/pengabdian', [PengabdianController::class, 'index'])->name('pengabdian.index');
    Route::post('/pengabdian', [PengabdianController::class, 'store'])->name('pengabdian.store');
    Route::get('/pengabdian/{pengabdian}/edit', [PengabdianController::class, 'edit'])->name('pengabdian.edit');
    Route::patch('/pengabdian/{pengabdian}', [PengabdianController::class, 'update'])->name('pengabdian.update');
    Route::delete('/pengabdian/{pengabdian}', [PengabdianController::class, 'destroy'])->name('pengabdian.destroy');
    Route::get('/pengabdian/{pengabdian}', [PengabdianController::class, 'show'])->name('pengabdian.show');

    // Penunjang
    Route::get('/penunjang/export', [PenunjangController::class, 'export'])->name('penunjang.export');
    Route::get('/penunjang', [PenunjangController::class, 'index'])->name('penunjang.index');
    Route::post('/penunjang', [PenunjangController::class, 'store'])->name('penunjang.store');
    Route::get('/penunjang/{penunjang}', [PenunjangController::class, 'show'])->name('penunjang.show');
    Route::patch('/penunjang/{penunjang}', [PenunjangController::class, 'update'])->name('penunjang.update');
    Route::delete('/penunjang/{penunjang}', [PenunjangController::class, 'destroy'])->name('penunjang.destroy');

    // Orasi Ilmiah
    Route::get('/orasi-ilmiah/export', [OrasiIlmiahController::class, 'export'])->name('orasi-ilmiah.export');
    Route::get('/orasi-ilmiah', [OrasiIlmiahController::class, 'index'])->name('orasi-ilmiah.index');
    Route::post('/orasi-ilmiah', [OrasiIlmiahController::class, 'store'])->name('orasi-ilmiah.store');
    Route::get('/orasi-ilmiah/{orasiIlmiah}/edit', [OrasiIlmiahController::class, 'edit'])->name('orasi-ilmiah.edit');
    Route::put('/orasi-ilmiah/{orasiIlmiah}', [OrasiIlmiahController::class, 'update'])->name('orasi-ilmiah.update');
    Route::delete('/orasi-ilmiah/{orasiIlmiah}', [OrasiIlmiahController::class, 'destroy'])->name('orasi-ilmiah.destroy');

    // Sertifikat Kompetensi
    Route::get('sertifikat-kompetensi/export', [SertifikatKompetensiController::class, 'export'])->name('sertifikat-kompetensi.export');
    Route::get('/sertifikat-kompetensi', [SertifikatKompetensiController::class, 'index'])->name('sertifikat-kompetensi.index');
    Route::post('/sertifikat-kompetensi', [SertifikatKompetensiController::class, 'store'])->name('sertifikat-kompetensi.store');
    Route::get('/sertifikat-kompetensi/{sertifikatKompetensi}/edit', [SertifikatKompetensiController::class, 'edit'])->name('sertifikat-kompetensi.edit');
    Route::put('/sertifikat-kompetensi/{sertifikatKompetensi}', [SertifikatKompetensiController::class, 'update'])->name('sertifikat-kompetensi.update');
    Route::delete('/sertifikat-kompetensi/{sertifikatKompetensi}', [SertifikatKompetensiController::class, 'destroy'])->name('sertifikat-kompetensi.destroy');

    // Pendidikan
    Route::get('/pendidikan', [PendidikanController::class, 'index'])->name('pendidikan.index');
    Route::delete('/pendidikan/hapus', [PendidikanController::class, 'hapus'])->name('pendidikan.hapus');

    Route::get('/pendidikan/pengajaran-lama/export', [PendidikanController::class, 'exportPengajaranLama'])->name('pengajaran-lama.export');
    Route::post('/pendidikan/pengajaran-lama', [PendidikanController::class, 'storePengajaranLama'])->name('pendidikan.pengajaran-lama.store');
    Route::get('/pendidikan/pengajaran-lama/{id}/edit', [PendidikanController::class, 'editPengajaranLama']);
    Route::post('/pendidikan/pengajaran-lama/{id}', [PendidikanController::class, 'updatePengajaranLama'])->name('pendidikan.pengajaran-lama.update');
    Route::get('/pendidikan/pengajaran-lama/{id}', [PendidikanController::class, 'showPengajaranLama']);

    Route::get('/pendidikan/pengajaran-luar/export', [PendidikanController::class, 'exportPengajaranLuar'])->name('pengajaran-luar.export');
    Route::post('/pendidikan/pengajaran-luar', [PendidikanController::class, 'storePengajaranLuar'])->name('pendidikan.pengajaran-luar.store');
    Route::get('/pendidikan/pengajaran-luar/{id}/edit', [PendidikanController::class, 'editPengajaranLuar']);
    Route::post('/pendidikan/pengajaran-luar/{id}', [PendidikanController::class, 'updatePengajaranLuar'])->name('pendidikan.pengajaran-luar.update');
    Route::get('/pendidikan/pengajaran-luar/{id}', [PendidikanController::class, 'showPengajaranLuar']);

    Route::get('/pendidikan/pengujian-lama/export', [PendidikanController::class, 'exportPengujianLama'])->name('pengujian-lama.export');
    Route::post('/pendidikan/pengujian-lama', [PendidikanController::class, 'storePengujianLama'])->name('pendidikan.pengujian-lama.store');
    Route::get('/pendidikan/pengujian-lama/{id}/edit', [PendidikanController::class, 'editPengujianLama']);
    Route::post('/pendidikan/pengujian-lama/{id}', [PendidikanController::class, 'updatePengujianLama'])->name('pendidikan.pengujian-lama.update');
    Route::get('/pendidikan/pengujian-lama/{id}', [PendidikanController::class, 'showPengujianLama']);

    Route::get('/pendidikan/pembimbing-lama/export', [PendidikanController::class, 'exportPembimbingLama'])->name('pembimbing-lama.export');
    Route::post('/pendidikan/pembimbing-lama', [PendidikanController::class, 'storePembimbingLama'])->name('pendidikan.pembimbing-lama.store');
    Route::get('/pendidikan/pembimbing-lama/{id}/edit', [PendidikanController::class, 'editPembimbingLama']);
    Route::post('/pendidikan/pembimbing-lama/{id}', [PendidikanController::class, 'updatePembimbingLama'])->name('pendidikan.pembimbing-lama.update');
    Route::get('/pendidikan/pembimbing-lama/{id}', [PendidikanController::class, 'showPembimbingLama']);

    Route::get('/pendidikan/penguji-luar/export', [PendidikanController::class, 'exportPengujiLuar'])->name('penguji-luar.export');
    Route::post('/pendidikan/penguji-luar', [PendidikanController::class, 'storePengujiLuar'])->name('pendidikan.penguji-luar.store');
    Route::get('/pendidikan/penguji-luar/{id}/edit', [PendidikanController::class, 'editPengujiLuar']);
    Route::post('/pendidikan/penguji-luar/{id}', [PendidikanController::class, 'updatePengujiLuar'])->name('pendidikan.penguji-luar.update');
    Route::get('/pendidikan/penguji-luar/{id}', [PendidikanController::class, 'showPengujiLuar']);

    Route::get('/pendidikan/pembimbing-luar/export', [PendidikanController::class, 'exportPembimbingLuar'])->name('pembimbing-luar.export');
    Route::post('/pendidikan/pembimbing-luar', [PendidikanController::class, 'storePembimbingLuar'])->name('pendidikan.pembimbing-luar.store');
    Route::get('/pendidikan/pembimbing-luar/{id}/edit', [PendidikanController::class, 'editPembimbingLuar']);
    Route::post('/pendidikan/pembimbing-luar/{id}', [PendidikanController::class, 'updatePembimbingLuar'])->name('pendidikan.pembimbing-luar.update');
    Route::get('/pendidikan/pembimbing-luar/{id}', [PendidikanController::class, 'showPembimbingLuar']);

    // Pengelola Jurnal
    Route::get('/pengelola-jurnal/export', [PengelolaJurnalController::class, 'export'])->name('pengelola-jurnal.export');
    Route::get('/pengelola-jurnal', [PengelolaJurnalController::class, 'index'])->name('pengelola-jurnal.index');
    Route::post('/pengelola-jurnal', [PengelolaJurnalController::class, 'store'])->name('pengelola-jurnal.store');
    Route::get('/pengelola-jurnal/{pengelolaJurnal}/edit', [PengelolaJurnalController::class, 'edit'])->name('pengelola-jurnal.edit');
    Route::post('/pengelola-jurnal/{pengelolaJurnal}', [PengelolaJurnalController::class, 'update'])->name('pengelola-jurnal.update');
    Route::delete('/pengelola-jurnal/{pengelolaJurnal}', [PengelolaJurnalController::class, 'destroy'])->name('pengelola-jurnal.destroy');

   // Penelitian
    Route::get('/penelitian/export', [PenelitianController::class, 'export'])->name('penelitian.export');
    Route::get('/penelitian', [PenelitianController::class, 'index'])->name('penelitian.index');
    Route::post('/penelitian', [PenelitianController::class, 'store'])->name('penelitian.store');
    Route::get('/penelitian/{penelitian}/edit', [PenelitianController::class, 'edit'])->name('penelitian.edit');
    Route::patch('/penelitian/{penelitian}', [PenelitianController::class, 'update'])->name('penelitian.update');
    Route::delete('/penelitian/{penelitian}', [PenelitianController::class, 'destroy'])->name('penelitian.destroy');

    // Kerjasama
    Route::resource('kerjasama', KerjasamaController::class);
    Route::get('/kerjasama/export', [KerjasamaController::class, 'export'])->name('kerjasama.export');

    // Lain-lain
    Route::get('/bahan-ajar', [BahanAjarController::class, 'index'])->name('bahan-ajar.index');
    Route::get('/organisasi-profesi', [OrganisasiProfesiController::class, 'index'])->name('organisasi-profesi.index');
    Route::get('/pembimbingan', [PembimbinganController::class, 'index'])->name('pembimbingan.index');
    Route::get('/kekayaan-intelektual', [KekayaanIntelektualController::class, 'index'])->name('kekayaan-intelektual.index');

 //TESTTT
Route::get('/admin/monitoring', [App\Http\Controllers\MonitoringController::class, 'indexAdmin'])->name('monitoring.admin.index');
Route::get('/admin/monitoring/{id}', [App\Http\Controllers\MonitoringController::class, 'detailAdmin'])->name('monitoring.admin.detail');
Route::get('/dosen/monitoring', [App\Http\Controllers\MonitoringController::class, 'indexDosen'])->name('monitoring.dosen.index');
// routes/web.php
Route::put('/admin/monitoring/target/{id}', [App\Http\Controllers\MonitoringController::class, 'updateTarget'])
    ->name('monitoring.admin.updateTarget');
Route::put('/admin/monitoring/update-ak/{id}', [App\Http\Controllers\MonitoringController::class, 'updateAK'])->name('monitoring.admin.updateAK');});