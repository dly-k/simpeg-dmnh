<?php

namespace App\Http\Controllers;

use App\Models\EFile;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Facades\File;

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
            'status_verifikasi' => 'Menunggu Verifikasi', // Status balik jadi kuning
            'catatan_verifikator' => null,                // Hapus pesan error/revisi lama
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

// Fungsi 1: Hanya Update Komentar (Status tetap 'Menunggu Verifikasi' atau 'Perlu Revisi')
public function updateComment(Request $request, $id)
{
    $request->validate([
        'catatan_verifikator' => 'required|string'
    ]);
    
    $file = EFile::findOrFail($id);
    $file->update([
        'catatan_verifikator' => $request->catatan_verifikator,
        'status_verifikasi' => 'Perlu Revisi' // Status berubah otomatis
    ]);

    return back()->with('success', 'Komentar berhasil disimpan.');
}

// Fungsi 2: Verifikasi Final (Dokumen dianggap sah/selesai)
public function verify(Request $request, $id)
{
    $file = EFile::findOrFail($id);
    $file->update([
        'status_verifikasi' => 'Disetujui',
        'catatan_verifikator' => null // Bersihkan catatan jika sudah disetujui
    ]);

    return back()->with('success', 'Dokumen berhasil diverifikasi sebagai berkas final.');
}

public function downloadZip($pegawaiId)
{
    $pegawai = \App\Models\Pegawai::findOrFail($pegawaiId);
    $files = EFile::where('pegawai_id', $pegawaiId)
                  ->where('status_verifikasi', 'Disetujui')
                  ->where('is_link', false) // Hanya bisa mengompres file fisik
                  ->get();

    if ($files->isEmpty()) {
        return back()->with('error', 'Tidak ada dokumen fisik yang siap diunduh.');
    }

    $zipFileName = 'Berkas_Kenaikan_' . str_replace(' ', '_', $pegawai->nama_lengkap) . '.zip';
    $zip = new ZipArchive;
    $zipPath = storage_path('app/public/' . $zipFileName);

    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        foreach ($files as $file) {
            $filePath = storage_path('app/public/' . $file->file_path);
            if (File::exists($filePath)) {
                // Menambahkan file ke dalam ZIP dengan nama asli dokumennya
                $zip->addFile($filePath, $file->nama_dokumen . '.pdf');
            }
        }
        $zip->close();
    }

    return response()->download($zipPath)->deleteFileAfterSend(true);
}

}