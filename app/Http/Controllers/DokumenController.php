<?php
//untuk menampilkan preview dokumen disetiap detail sub tab pendidikan
namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class DokumenController extends Controller
{
    // app/Http/Controllers/DokumenController.php

public function show($path)
{
    if (!Storage::disk('public')->exists($path)) {
        abort(404, 'File tidak ditemukan.');
    }

    // Menggunakan helper response() Laravel alih-alih Symfony Response
    return response()->file(Storage::disk('public')->path($path), [
        'Content-Disposition' => 'inline; filename="' . basename($path) . '"'
    ]);
}
}