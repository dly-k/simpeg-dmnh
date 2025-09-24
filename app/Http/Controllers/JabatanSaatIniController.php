<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\JabatanSaatIni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JabatanSaatIniController extends Controller
{
    /**
     * Menyimpan data baru.
     */
    public function store(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'jenis_jabatan' => 'required|string|max:255',
            'nomor_sk' => 'required|string|max:255',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        if ($request->hasFile('dokumen')) {
            $validated['file_path'] = $request->file('dokumen')->store('sk_jabatan_saat_ini', 'public');
        }

        $pegawai->jabatanSaatInis()->create($validated);

        return back()->with([
            'success' => 'Data Jabatan Saat Ini berhasil ditambahkan!',
            'active_tab' => 'sk',
            'active_subtab' => 'jabatan-saat-ini'
        ]);
    }

    /**
     * Memperbarui data yang ada. (Belum diimplementasikan)
     */
    public function update(Request $request, Pegawai $pegawai, JabatanSaatIni $jabatanSaatIni)
    {
        // Logika untuk update data
        return back()->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Menghapus data. (Belum diimplementasikan)
     */
    public function destroy(Pegawai $pegawai, JabatanSaatIni $jabatanSaatIni)
    {
        // Logika untuk hapus data
        return back()->with('success', 'Data berhasil dihapus!');
    }
}