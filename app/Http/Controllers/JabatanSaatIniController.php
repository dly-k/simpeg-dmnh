<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\JabatanSaatIni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\JabatanSaatIniExport;
use Maatwebsite\Excel\Facades\Excel;

class JabatanSaatIniController extends Controller
{
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

        return back()->with(['success' => 'Data Jabatan Saat Ini berhasil ditambahkan!', 'active_tab' => 'sk', 'active_subtab' => 'jabatan-saat-ini']);
    }

    public function update(Request $request, Pegawai $pegawai, JabatanSaatIni $jabatanSaatIni)
    {
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'jenis_jabatan' => 'required|string|max:255',
            'nomor_sk' => 'required|string|max:255',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        if ($request->hasFile('dokumen')) {
            if ($jabatanSaatIni->file_path) {
                Storage::disk('public')->delete($jabatanSaatIni->file_path);
            }
            $validated['file_path'] = $request->file('dokumen')->store('sk_jabatan_saat_ini', 'public');
        }

        $jabatanSaatIni->update($validated);

        return back()->with(['success' => 'Data Jabatan Saat Ini berhasil diperbarui!', 'active_tab' => 'sk', 'active_subtab' => 'jabatan-saat-ini']);
    }

    public function destroy(Pegawai $pegawai, JabatanSaatIni $jabatanSaatIni)
    {
        if ($jabatanSaatIni->file_path) {
            Storage::disk('public')->delete($jabatanSaatIni->file_path);
        }
        $jabatanSaatIni->delete();
        
        return back()->with(['success' => 'Data Jabatan Saat Ini berhasil dihapus!', 'active_tab' => 'sk', 'active_subtab' => 'jabatan-saat-ini']);
    }

    public function export(Request $request, Pegawai $pegawai)
    {
        $search = $request->input('search_jabatan_saat_ini');
        $tahun = $request->input('tahun_jabatan_saat_ini');
        
        $fileName = 'Riwayat_Jabatan_Saat_Ini_' . $pegawai->nama_lengkap . '.xlsx';

        return Excel::download(new JabatanSaatIniExport($pegawai, $search, $tahun), $fileName);
    }
}