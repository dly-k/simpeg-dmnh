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
    $request->validate([
        'kategori' => 'required',
        'nama_dokumen' => 'required',
        'keaslian' => 'required',
        'tanggal_dokumen' => 'required|date',
        'metode' => 'required|in:file,link',
        'dokumen' => 'required_if:metode,file|nullable|file|max:5120',
        'link_url' => 'required_if:metode,link|nullable|url',
    ]);

    $efile = new \App\Models\EFile();
    $efile->pegawai_id = $id;
    $efile->kategori_dokumen = $request->kategori;
    $efile->nama_dokumen = $request->nama_dokumen;
    $efile->keaslian_dokumen = $request->keaslian;
    $efile->tanggal_dokumen = $request->tanggal_dokumen;

    if ($request->metode === 'file') {
        $efile->file_path = $request->file('dokumen')->store('efiles', 'public');
        $efile->is_link = false;
    } else {
        $efile->link_url = $request->link_url;
        $efile->is_link = true;
    }

    $efile->save();
    return back()->with('success', 'Berhasil menambahkan ' . ($efile->is_link ? 'tautan' : 'dokumen'));
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