<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/daftar-pegawai', function () {
    return view('daftar-pegawai');
});

Route::get('/surat-tugas', function () {
    return view('surat-tugas');
});

Route::get('/pendidikan', function () {
    return view('pendidikan');
});

Route::get('/penelitian', function () {
    return view('penelitian');
});

Route::get('/pengabdian', function () {
    return view('pengabdian');
});

Route::get('/penunjang', function () {
    return view('penunjang');
});

Route::get('/kerjasama', function () {
    return view('kerjasama');
});

Route::get('/detail-pegawai', function () {
    return view('detail-pegawai');
});

Route::get('/pelatihan', function () {
    return view('pelatihan');
});

Route::get('/sk-non-pns', function () {
    return view('sk-non-pns');
});

Route::get('/penghargaan', function () {
    return view('penghargaan');
});

Route::get('/master-data', function () {
    return view('master-data');
});