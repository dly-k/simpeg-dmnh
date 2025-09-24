<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\TugasBelajar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TugasBelajarController extends Controller
{
    /**
     * Menyimpan data baru.
     */
    public function store(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'jenis_tugas_belajar' => 'required|string|max:255',
            'nomor_sk' => 'required|string|max:255',
            'tanggal_sk' => 'required|date',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        if ($request->hasFile('dokumen')) {
            $validated['file_path'] = $request->file('dokumen')->store('sk_tugas_belajar', 'public');
        }

        $pegawai->tugasBelajars()->create($validated);

        return back()->with([
            'success' => 'Data Tugas Belajar berhasil ditambahkan!',
            'active_tab' => 'sk',
            'active_subtab' => 'sk-tugas-belajar'
        ]);
    }

    /**
     * Memperbarui data yang ada. (Belum diimplementasikan)
     */
    public function update(Request $request, Pegawai $pegawai, TugasBelajar $tugasBelajar)
    {
        // Logika untuk update data
        return back()->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Menghapus data. (Belum diimplementasikan)
     */
    public function destroy(Pegawai $pegawai, TugasBelajar $tugasBelajar)
    {
        // Logika untuk hapus data
        return back()->with('success', 'Data berhasil dihapus!');
    }
}