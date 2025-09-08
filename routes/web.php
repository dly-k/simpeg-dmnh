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
Route::view('/daftar-pegawai', 'pages.pegawai.daftar-pegawai');
Route::view('/edit-pegawai', 'pages.pegawai.edit-pegawai');
Route::view('/tambah-pegawai', 'pages.pegawai.tambah-pegawai');
Route::view('/detail-pegawai', 'pages.pegawai.detail-pegawai');

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