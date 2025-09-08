<?php

namespace App\Http\Controllers;

use App\Models\Penghargaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PenghargaanController extends Controller
{
    /**
     * Menampilkan halaman utama dengan data penghargaan.
     */
    public function index(Request $request)
    {
        $query = Penghargaan::orderBy('tanggal_perolehan', 'desc');

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pegawai', 'like', "%{$search}%")
                ->orWhere('kegiatan', 'like', "%{$search}%")
                ->orWhere('nama_penghargaan', 'like', "%{$search}%")
                ->orWhere('nomor_sk', 'like', "%{$search}%")
                ->orWhere('lingkup', 'like', "%{$search}%");
            });
        }

        // Filter tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_perolehan', $request->tahun);
        }

        // Filter lingkup
        if ($request->filled('lingkup')) {
            $query->where('lingkup', $request->lingkup);
        }

        // Pagination
        $dataPenghargaan = $query->paginate(10);
        $dataPenghargaan->appends($request->all());

        // Ambil daftar tahun unik buat dropdown filter
        $listTahun = Penghargaan::selectRaw('YEAR(tanggal_perolehan) as tahun')
                        ->distinct()
                        ->orderBy('tahun', 'desc')
                        ->pluck('tahun');

        return view('pages.penghargaan', compact('dataPenghargaan', 'listTahun'));
    }

    /**
     * Menyimpan data baru dari form modal.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pegawai'     => 'required|string|max:255',
            'kegiatan'         => 'required|string|max:255',
            'nama_penghargaan' => 'required|string|max:255',
            'nomor_sk'         => 'required|string|max:100',
            'tanggal_perolehan'=> 'required|date',
            'lingkup'          => 'required|string|max:50',
            'negara'           => 'required|string|max:100',
            'instansi_pemberi' => 'required|string|max:255',
            'jenis_dokumen'    => 'required|string|max:100',
            'dokumen'          => 'required|file|mimes:pdf|max:5120',
            'nama_dokumen'     => 'required|string|max:255',
            'nomor_dokumen'    => 'nullable|string|max:100',
            'tautan'           => 'nullable|url|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $filePath = $request->file('dokumen')->store('dokumen_penghargaan', 'public');

            Penghargaan::create([
                'nama_pegawai'     => $request->nama_pegawai,
                'kegiatan'         => $request->kegiatan,
                'nama_penghargaan' => $request->nama_penghargaan,
                'nomor_sk'         => $request->nomor_sk,
                'tanggal_perolehan'=> $request->tanggal_perolehan,
                'lingkup'          => $request->lingkup,
                'negara'           => $request->negara,
                'instansi_pemberi' => $request->instansi_pemberi,
                'jenis_dokumen'    => $request->jenis_dokumen,
                'file_path'        => $filePath,
                'nama_dokumen'     => $request->nama_dokumen,
                'nomor_dokumen'    => $request->nomor_dokumen,
                'tautan'           => $request->tautan,
            ]);

            return response()->json(['success' => 'Data penghargaan berhasil disimpan!']);

        } catch (\Exception $e) {
            Log::error('Error saving penghargaan: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat menyimpan data.'], 500);
        }
    }

    /**
     * Mengambil data untuk form edit.
     */
    public function edit($id)
    {
        try {
            $penghargaan = Penghargaan::findOrFail($id);
            return response()->json($penghargaan);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data tidak ditemukan.'], 404);
        }
    }

    /**
     * Memperbarui data yang ada di database.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_pegawai'     => 'required|string|max:255',
            'kegiatan'         => 'required|string|max:255',
            'nama_penghargaan' => 'required|string|max:255',
            'nomor_sk'         => 'required|string|max:100',
            'tanggal_perolehan'=> 'required|date',
            'lingkup'          => 'required|string|max:50',
            'negara'           => 'required|string|max:100',
            'instansi_pemberi' => 'required|string|max:255',
            'jenis_dokumen'    => 'required|string|max:100',
            'dokumen'          => 'nullable|file|mimes:pdf|max:5120',
            'nama_dokumen'     => 'required|string|max:255',
            'nomor_dokumen'    => 'nullable|string|max:100',
            'tautan'           => 'nullable|url|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $penghargaan = Penghargaan::findOrFail($id);
            $dataToUpdate = $request->except(['dokumen', '_method']);

            if ($request->hasFile('dokumen')) {
                if ($penghargaan->file_path && Storage::disk('public')->exists($penghargaan->file_path)) {
                    Storage::disk('public')->delete($penghargaan->file_path);
                }
                $filePath = $request->file('dokumen')->store('dokumen_penghargaan', 'public');
                $dataToUpdate['file_path'] = $filePath;
            }

            $penghargaan->update($dataToUpdate);

            return response()->json(['success' => 'Data penghargaan berhasil diperbarui!']);

        } catch (\Exception $e) {
            Log::error('Error updating penghargaan: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat memperbarui data.'], 500);
        }
    }

    /**
     * Menghapus data dari database.
     */
    public function destroy($id)
    {
        try {
            $penghargaan = Penghargaan::findOrFail($id);

            if ($penghargaan->file_path && Storage::disk('public')->exists($penghargaan->file_path)) {
                Storage::disk('public')->delete($penghargaan->file_path);
            }

            $penghargaan->delete();

            return response()->json(['success' => 'Data penghargaan berhasil dihapus!']);

        } catch (\Exception $e) {
            Log::error('Error deleting penghargaan: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus data.'], 500);
        }
    }
}