<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\PenetapanPangkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenetapanPangkatController extends Controller
{
    public function store(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'golongan' => 'required|string|max:255',
            'nomor_bkn' => 'required|string|max:255',
            'tanggal_bkn' => 'required|date',
            'nomor_sk' => 'required|string|max:255',
            'tanggal_sk' => 'required|date',
            'tmt_pangkat' => 'required|date',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        if ($request->hasFile('dokumen')) {
            $validated['file_path'] = $request->file('dokumen')->store('sk_pangkat', 'public');
        }

        $pegawai->penetapanPangkats()->create($validated);

        return back()->with([
            'success' => 'Data Penetapan Pangkat berhasil ditambahkan!',
            'active_tab' => 'sk',
            'active_subtab' => 'penetapan-pangkat'
        ]);
    }

    public function update(Request $request, Pegawai $pegawai, PenetapanPangkat $pangkat)
    {
        $validated = $request->validate([
            'golongan' => 'required|string|max:255',
            'nomor_bkn' => 'required|string|max:255',
            'tanggal_bkn' => 'required|date',
            'nomor_sk' => 'required|string|max:255',
            'tanggal_sk' => 'required|date',
            'tmt_pangkat' => 'required|date',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        if ($request->hasFile('dokumen')) {
            if ($pangkat->file_path) {
                Storage::disk('public')->delete($pangkat->file_path);
            }
            $validated['file_path'] = $request->file('dokumen')->store('sk_pangkat', 'public');
        }

        $pangkat->update($validated);

        return back()->with([
            'success' => 'Data Penetapan Pangkat berhasil diperbarui!',
            'active_tab' => 'sk',
            'active_subtab' => 'penetapan-pangkat'
        ]);
    }

    public function destroy(Pegawai $pegawai, PenetapanPangkat $pangkat)
    {
        if ($pangkat->file_path) {
            Storage::disk('public')->delete($pangkat->file_path);
        }
        $pangkat->delete();
        
        return back()->with([
            'success' => 'Data Penetapan Pangkat berhasil dihapus!',
            'active_tab' => 'sk',
            'active_subtab' => 'penetapan-pangkat'
        ]);
    }
}