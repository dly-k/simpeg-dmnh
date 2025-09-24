<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\SkNonPns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SkNonPnsController extends Controller
{
    public function store(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'jenis_sk' => 'required|string|max:255',
            'nomor_sk' => 'required|string|max:255',
            'tanggal_sk' => 'required|date',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        if ($request->hasFile('dokumen')) {
            $validated['file_path'] = $request->file('dokumen')->store('sk_non_pns', 'public');
        }

        $pegawai->skNonPns()->create($validated);

        return back()->with([
            'success' => 'Data SK Non PNS berhasil ditambahkan!',
            'active_tab' => 'sk',
            'active_subtab' => 'sk-non-pns'
        ]);
    }

    public function update(Request $request, Pegawai $pegawai, SkNonPns $skNonPn)
    {
        $validated = $request->validate([
            'jenis_sk' => 'required|string|max:255',
            'nomor_sk' => 'required|string|max:255',
            'tanggal_sk' => 'required|date',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        if ($request->hasFile('dokumen')) {
            if ($skNonPn->file_path) {
                Storage::disk('public')->delete($skNonPn->file_path);
            }
            $validated['file_path'] = $request->file('dokumen')->store('sk_non_pns', 'public');
        }

        $skNonPn->update($validated);

        return back()->with([
            'success' => 'Data SK Non PNS berhasil diperbarui!',
            'active_tab' => 'sk',
            'active_subtab' => 'sk-non-pns'
        ]);
    }

    public function destroy(Pegawai $pegawai, SkNonPns $skNonPn)
    {
        if ($skNonPn->file_path) {
            Storage::disk('public')->delete($skNonPn->file_path);
        }
        $skNonPn->delete();

        return back()->with([
            'success' => 'Data SK Non PNS berhasil dihapus!',
            'active_tab' => 'sk',
            'active_subtab' => 'sk-non-pns'
        ]);
    }
}