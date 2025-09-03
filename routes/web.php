<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SkNonPnsController;
use App\Http\Controllers\PenghargaanController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/ubah-password', function () {
    return view('auth.ubah-password');
});

Route::get('/master-data', function () {
    return view('auth.master-data');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard');
});

Route::get('/daftar-pegawai', function () {
    return view('pages.pegawai.daftar-pegawai');
});

Route::get('/surat-tugas', function () {
    return view('pages.surat-tugas');
});

Route::get('/pendidikan', function () {
    return view('pages.pendidikan');
});

Route::get('/penelitian', function () {
    return view('pages.penelitian');
});

Route::get('/pengabdian', function () {
    return view('pages.pengabdian');
});

Route::get('/penunjang', function () {
    return view('pages.penunjang');
});

Route::get('/kerjasama', function () {
    return view('pages.kerjasama');
});

Route::get('/detail-pegawai', function () {
    return view('pages.pegawai.detail-pegawai');
});

use App\Http\Controllers\PelatihanController;

// Cara terbaik adalah menggunakan resource route
Route::resource('pelatihan', PelatihanController::class);

Route::get('/sk-non-pns', function () {
    return view('pages.sk-non-pns');
})->name('sk-non-pns.index'); // <-- TAMBAHKAN BAGIAN INI
Route::get('/sk-non-pns', [SkNonPnsController::class, 'index'])->name('sk-non-pns.index');
Route::post('/sk-non-pns/store', [SkNonPnsController::class, 'store'])->name('sk-non-pns.store');
Route::get('/sk-non-pns/{skNonPn}/edit', [SkNonPnsController::class, 'edit'])->name('sk-non-pns.edit');
Route::put('/sk-non-pns/{skNonPn}', [SkNonPnsController::class, 'update'])->name('sk-non-pns.update');
Route::delete('/sk-non-pns/{skNonPn}', [SkNonPnsController::class, 'destroy'])->name('sk-non-pns.destroy');

Route::get('/penghargaan', [PenghargaanController::class, 'index'])->name('penghargaan.index');
Route::post('/penghargaan', [PenghargaanController::class, 'store'])->name('penghargaan.store');
Route::get('/penghargaan/{id}/edit', [PenghargaanController::class, 'edit'])->name('penghargaan.edit'); // <-- TAMBAHKAN INI
Route::post('/penghargaan/{id}', [PenghargaanController::class, 'update'])->name('penghargaan.update');
Route::delete('/penghargaan/{id}', [PenghargaanController::class, 'destroy'])->name('penghargaan.destroy');

Route::get('/sidebar', function () {
    return view('pages.sidebar');
});

Route::get('/edit-pegawai', function () {
    return view('pages.pegawai.edit-pegawai');
});

Route::get('/tambah-pegawai', function () {
    return view('pages.pegawai.tambah-pegawai');
});