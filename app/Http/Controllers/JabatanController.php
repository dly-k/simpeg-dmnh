<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JabatanController extends Controller
{
    public function store(Request $request, Pegawai $pegawai)
    {
        // ... kode store
    }
    
    public function update(Request $request, Pegawai $pegawai, Jabatan $jabatan)
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
            if ($jabatan->file_path) {
                Storage::disk('public')->delete($jabatan->file_path);
            }
            $validated['file_path'] = $request->file('dokumen')->store('sk_jabatan', 'public');
        }

        $jabatan->update($validated);

        return back()->with([
            'success' => 'Data Jabatan berhasil diperbarui!',
            'active_tab' => 'sk',
            'active_subtab' => 'jabatan'
        ]);
    }
    
    public function destroy(Pegawai $pegawai, Jabatan $jabatan)
    {
        if ($jabatan->file_path) {
            Storage::disk('public')->delete($jabatan->file_path);
        }
        $jabatan->delete();
        
        return back()->with([
            'success' => 'Data Jabatan berhasil dihapus!',
            'active_tab' => 'sk',
            'active_subtab' => 'jabatan'
        ]);
    }
}