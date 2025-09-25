<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pensiun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\PensiunExport;
use Maatwebsite\Excel\Facades\Excel;

class PensiunController extends Controller
{
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

        return back()->with(['success' => 'Data Pensiun berhasil ditambahkan!', 'active_tab' => 'sk', 'active_subtab' => 'pensiun']);
    }

    public function update(Request $request, Pegawai $pegawai, Pensiun $pensiun)
    {
        $validated = $request->validate([
            'jenis_pensiun' => 'required|string|max:255',
            'nomor_sk' => 'required|string|max:255',
            'tanggal_sk' => 'required|date',
            'tmt_pensiun' => 'required|date',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        if ($request->hasFile('dokumen')) {
            if ($pensiun->file_path) {
                Storage::disk('public')->delete($pensiun->file_path);
            }
            $validated['file_path'] = $request->file('dokumen')->store('sk_pensiun', 'public');
        }

        $pensiun->update($validated);

        return back()->with(['success' => 'Data Pensiun berhasil diperbarui!', 'active_tab' => 'sk', 'active_subtab' => 'pensiun']);
    }

    public function destroy(Pegawai $pegawai, Pensiun $pensiun)
    {
        if ($pensiun->file_path) {
            Storage::disk('public')->delete($pensiun->file_path);
        }
        $pensiun->delete();

        return back()->with(['success' => 'Data Pensiun berhasil dihapus!', 'active_tab' => 'sk', 'active_subtab' => 'pensiun']);
    }

    public function export(Request $request, Pegawai $pegawai)
    {
        $search = $request->input('search_pensiun');
        $tahun = $request->input('tahun_pensiun');
        
        $fileName = 'Riwayat_Pensiun_' . $pegawai->nama_lengkap . '.xlsx';

        return Excel::download(new PensiunExport($pegawai, $search, $tahun), $fileName);
    }
}