<?php
//untuk menampilkan preview dokumen disetiap detail sub tab pendidikan
namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class DokumenController extends Controller
{
    public function show($path)
    {
        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        $file = Storage::disk('public')->get($path);

        $fullPath = Storage::disk('public')->path($path);

        $type = File::mimeType($fullPath);
        
        $headers = [
            'Content-Type' => $type,
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"'
        ];

        return new Response($file, 200, $headers);
    }
}