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

// Menu Lain
Route::view('/pendidikan', 'pages.pendidikan');
Route::view('/penelitian', 'pages.penelitian');
Route::view('/pengabdian', 'pages.pengabdian');
Route::view('/penunjang', 'pages.penunjang');

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