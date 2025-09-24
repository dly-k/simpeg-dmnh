<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JabatanController extends Controller
{
    /**
     * Menyimpan data baru.
     */
    public function store(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'jenis_sk' => 'required|string|max:255',
            'nomor_sk' => 'required|string|max:255',
            'tanggal_sk' => 'required|date',
            'tmt_jabatan' => 'required|date',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        if ($request->hasFile('dokumen')) {
            $validated['file_path'] = $request->file('dokumen')->store('sk_jabatan', 'public');
        }

        $pegawai->jabatans()->create($validated);

        return back()->with([
            'success' => 'Data Jabatan berhasil ditambahkan!',
            'active_tab' => 'sk',
            'active_subtab' => 'jabatan'
        ]);
    }

    /**
     * Memperbarui data yang ada. (Belum diimplementasikan)
     */
    public function update(Request $request, Pegawai $pegawai, Jabatan $jabatan)
    {
        // Logika untuk update data
        return back()->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Menghapus data. (Belum diimplementasikan)
     */
    public function destroy(Pegawai $pegawai, Jabatan $jabatan)
    {
        // Logika untuk hapus data
        return back()->with('success', 'Data berhasil dihapus!');
    }
}