<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/pelatihan', function () {
    return view('pages.pelatihan');
});

Route::get('/sk-non-pns', function () {
    return view('pages.sk-non-pns');
});

Route::get('/penghargaan', function () {
    return view('pages.penghargaan');
});

Route::get('/sidebar', function () {
    return view('pages.sidebar');
});

Route::get('/edit-pegawai', function () {
    return view('pages.pegawai.edit-pegawai');
});

Route::get('/tambah-pegawai', function () {
    return view('pages.pegawai.tambah-pegawai');
});