<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\SkNonPnsController;
use App\Http\Controllers\PenghargaanController;
use App\Http\Controllers\SuratTugasController;

// Auth & Dashboard
Route::view('/', 'auth.login');
Route::view('/login', 'auth.login')->name('login');
Route::view('/ubah-password', 'auth.ubah-password');
Route::view('/master-data', 'auth.master-data');

Route::view('/dashboard', 'pages.dashboard');
Route::view('/sidebar', 'pages.sidebar');

// Pegawai
use App\Http\Controllers\PegawaiController;
Route::get('/daftar-pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
Route::get('/tambah-pegawai', [PegawaiController::class, 'create'])->name('pegawai.create');
Route::post('/tambah-pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
Route::get('/pegawai/{pegawai}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
Route::put('/pegawai/{pegawai}', [PegawaiController::class, 'update'])->name('pegawai.update');
Route::get('/pegawai/{pegawai}', [PegawaiController::class, 'show'])->name('pegawai.show');
Route::delete('/pegawai/{pegawai}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');

// Menu Lain
Route::view('/pendidikan', 'pages.pendidikan');
Route::view('/penelitian', 'pages.penelitian');
Route::view('/pengabdian', 'pages.pengabdian');
Route::view('/penunjang', 'pages.penunjang');
Route::view('/kerjasama', 'pages.kerjasama');

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