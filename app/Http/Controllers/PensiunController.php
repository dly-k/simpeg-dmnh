<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pensiun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PensiunController extends Controller
{
    /**
     * Menyimpan data baru.
     */
    public function store(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'jenis_pensiun' => 'required|string|max:255',
            'nomor_sk' => 'required|string|max:255',
            'tanggal_sk' => 'required|date',
            'tmt_pensiun' => 'required|date',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        if ($request->hasFile('dokumen')) {
            $validated['file_path'] = $request->file('dokumen')->store('sk_pensiun', 'public');
        }

        $pegawai->pensiuns()->create($validated);

        return back()->with([
            'success' => 'Data Pensiun berhasil ditambahkan!',
            'active_tab' => 'sk',
            'active_subtab' => 'pensiun'
        ]);
    }

    /**
     * Memperbarui data yang ada. (Belum diimplementasikan)
     */
    public function update(Request $request, Pegawai $pegawai, Pensiun $pensiun)
    {
        // Logika untuk update data
        return back()->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Menghapus data. (Belum diimplementasikan)
     */
    public function destroy(Pegawai $pegawai, Pensiun $pensiun)
    {
        // Logika untuk hapus data
        return back()->with('success', 'Data berhasil dihapus!');
    }
}