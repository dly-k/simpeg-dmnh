<?php

namespace App\Http\Controllers;

use App\Models\EFile;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EFileController extends Controller
{
    public function store(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'kategori' => 'required|string',
            'nama_dokumen' => 'required|string',
            'keaslian' => 'required|string', // Validasi 'keaslian' dari form
            'tanggal_dokumen' => 'required|date',
            'dokumen' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->store('efiles/' . $pegawai->id, 'public');

            EFile::create([
                'pegawai_id' => $pegawai->id,
                'kategori_dokumen' => $request->kategori,
                'nama_dokumen' => $request->nama_dokumen,
                'keaslian_dokumen' => $request->keaslian, // UBAH INI (gunakan 'keaslian')
                'tanggal_dokumen' => $request->tanggal_dokumen,
                'file_path' => $filePath,
                'file_name' => $fileName,
            ]);
        }

        return back()->with('success', 'Dokumen E-File berhasil diunggah!');
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