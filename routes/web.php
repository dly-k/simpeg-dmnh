<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\SkNonPnsController;
use App\Http\Controllers\PenghargaanController;
use App\Http\Controllers\SuratTugasController;
use App\Http\Controllers\KerjasamaController;
use App\Http\Controllers\EFileController;
use App\Http\Controllers\PegawaiController;

// Auth & Dashboard
Route::view('/', 'auth.login');
Route::view('/login', 'auth.login')->name('login');
Route::view('/ubah-password', 'auth.ubah-password');
Route::view('/master-data', 'auth.master-data');

Route::view('/dashboard', 'pages.dashboard');
Route::view('/sidebar', 'pages.sidebar');

// Pegawai
Route::get('/daftar-pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
Route::get('/tambah-pegawai', [PegawaiController::class, 'create'])->name('pegawai.create');
Route::post('/tambah-pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
Route::get('/pegawai/{pegawai}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
Route::put('/pegawai/{pegawai}', [PegawaiController::class, 'update'])->name('pegawai.update');
Route::get('/pegawai/{pegawai}', [PegawaiController::class, 'show'])->name('pegawai.show');
Route::delete('/pegawai/{pegawai}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');
Route::get('/daftar-pegawai/export', [PegawaiController::class, 'export'])->name('pegawai.export');

// Rute untuk E-File
Route::post('/pegawai/{pegawai}/efile', [EFileController::class, 'store'])->name('efile.store');
Route::delete('/efile/{efile}', [EFileController::class, 'destroy'])->name('efile.destroy');


use App\Http\Controllers\DokumenController;
Route::get('/dokumen/preview/{path}', [DokumenController::class, 'show'])->where('path', '.*')->name('dokumen.preview');

use App\Http\Controllers\PendidikanController;

// ================== Halaman Utama ==================
Route::view('/pendidikan', 'pages.pendidikan');
Route::get('/pendidikan', [PendidikanController::class, 'index'])->name('pendidikan.index');
Route::post('/pendidikan/verifikasi', [PendidikanController::class, 'verifikasi'])->name('pendidikan.verifikasi');

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



use App\Http\Controllers\PenelitianController;

Route::get('/penelitian', [PenelitianController::class, 'index'])->name('penelitian.index');
Route::post('/penelitian', [PenelitianController::class, 'store'])->name('penelitian.store');
Route::get('/penelitian/{penelitian}/edit', [PenelitianController::class, 'edit'])->name('penelitian.edit');
Route::patch('/penelitian/{penelitian}', [PenelitianController::class, 'update'])->name('penelitian.update');
Route::delete('/penelitian/{penelitian}', [PenelitianController::class, 'destroy'])->name('penelitian.destroy');
Route::post('/penelitian/{penelitian}/verifikasi', [PenelitianController::class, 'verifikasi'])->name('penelitian.verifikasi');

use App\Http\Controllers\PengabdianController;
Route::get('/pengabdian', [PengabdianController::class, 'index'])->name('pengabdian.index');
Route::post('/pengabdian', [PengabdianController::class, 'store'])->name('pengabdian.store');
Route::get('/pengabdian/{pengabdian}/edit', [PengabdianController::class, 'edit'])->name('pengabdian.edit');
Route::patch('/pengabdian/{pengabdian}', [PengabdianController::class, 'update'])->name('pengabdian.update');
Route::delete('/pengabdian/{pengabdian}', [PengabdianController::class, 'destroy'])->name('pengabdian.destroy');
Route::get('/pengabdian/{pengabdian}', [PengabdianController::class, 'show'])->name('pengabdian.show');
Route::patch('/pengabdian/{pengabdian}/verifikasi', [PengabdianController::class, 'verifikasi'])->name('pengabdian.verifikasi');

use App\Http\Controllers\PenunjangController;
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

// SK Non PNS
Route::prefix('sk-non-pns')->name('sk-non-pns.')->controller(SkNonPnsController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::get('/{skNonPn}/edit', 'edit')->name('edit');
    Route::put('/{skNonPn}', 'update')->name('update');
    Route::delete('/{skNonPn}', 'destroy')->name('destroy');
});

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