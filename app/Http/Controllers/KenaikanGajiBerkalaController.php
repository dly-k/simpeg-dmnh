<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\KenaikanGajiBerkala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KenaikanGajiBerkalaController extends Controller
{
    /**
     * Menyimpan data baru.
     */
    public function store(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'golongan' => 'required|string|max:255',
            'nomor_sk' => 'required|string|max:255',
            'tanggal_sk' => 'required|date',
            'tmt_gaji' => 'required|date',
            'gaji_pokok' => 'required|integer',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        if ($request->hasFile('dokumen')) {
            $validated['file_path'] = $request->file('dokumen')->store('sk_gaji_berkala', 'public');
        }

        $pegawai->kenaikanGajiBerkalas()->create($validated);

        return back()->with([
            'success' => 'Data Kenaikan Gaji Berkala berhasil ditambahkan!',
            'active_tab' => 'sk',
            'active_subtab' => 'sk-kenaikan-gaji'
        ]);
    }

    /**
     * Memperbarui data yang ada. (Belum diimplementasikan)
     */
    public function update(Request $request, Pegawai $pegawai, KenaikanGajiBerkala $gajiBerkala)
    {
        // Logika untuk update data
        return back()->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Menghapus data. (Belum diimplementasikan)
     */
    public function destroy(Pegawai $pegawai, KenaikanGajiBerkala $gajiBerkala)
    {
        // Logika untuk hapus data
        return back()->with('success', 'Data berhasil dihapus!');
    }
}