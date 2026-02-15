<?php

namespace App\Http\Controllers;

use App\Models\EFile;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EFileController extends Controller
{
public function store(Request $request, $id)
{
    // Validasi - sesuaikan dengan nama field di form
    $request->validate([
        'kategori' => 'required|string',           // ubah dari kategori_dokumen
        'nama_dokumen' => 'required|string',
        'keaslian' => 'required|string',           // ubah dari keaslian_dokumen
        'tanggal_dokumen' => 'required|date',
        'metode' => 'required|in:file,link',       // tambahkan kembali field metode
        'dokumen' => 'required_if:metode,file|nullable|file|mimes:pdf|max:2048', // kembalikan ke 'dokumen'
        'link_url' => 'required_if:metode,link|nullable|url',
    ]);

    $path = null;
    $isLink = false;

    if ($request->metode === 'file') {
        if ($request->hasFile('dokumen')) {
            $path = $request->file('dokumen')->store('uploads/efile', 'public');
        }
    } elseif ($request->metode === 'link') {
        $path = $request->link_url;
        // Pastikan link memiliki http atau https agar tidak dianggap path lokal
        if (!preg_match("~^(?:f|ht)tps?://~i", $path)) {
            $path = "https://" . $path;
        }
        $isLink = true;
    }

    // Simpan data
    \App\Models\EFile::updateOrCreate(
        [
            'pegawai_id' => $id,
            'nama_dokumen' => $request->nama_dokumen,
        ],
        [
            'kategori_dokumen' => $request->kategori,     // mapping dari 'kategori'
            'keaslian_dokumen' => $request->keaslian,     // mapping dari 'keaslian'
            'tanggal_dokumen' => $request->tanggal_dokumen,
            'file_path' => !$isLink ? $path : null,
            'link_url' => $isLink ? $path : null,
            'is_link' => $isLink,
        ]
    );

    return back()->with('success', 'Dokumen ' . $request->nama_dokumen . ' berhasil disimpan.');
}

    public function destroy(EFile $efile)
    {
        if (Storage::disk('public')->exists($efile->file_path)) {
            Storage::disk('public')->delete($efile->file_path);
        }
        $efile->delete();
        return back()->with('success', 'Dokumen E-File berhasil dihapus.');
    }
}