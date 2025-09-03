<?php

namespace App\Http\Controllers;

use App\Models\Pelatihan; // Pastikan model Pelatihan sudah ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PelatihanController extends Controller
{
    /**
     * Menampilkan halaman utama dengan data pelatihan.
     */
// app/Http/Controllers/PelatihanController.php

public function index()
{
    $dataPelatihan = Pelatihan::orderBy('tgl_mulai', 'desc')->paginate(10);
    
    // Perbaiki path view agar sesuai dengan struktur folder Anda
    return view('pages.pelatihan', ['dataPelatihan' => $dataPelatihan]); 
}

    /**
     * Menyimpan data baru dari form modal.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kegiatan' => 'required|string|max:255',
            'posisi'        => 'required|string',
            'penyelenggara' => 'required|string|max:255',
            'tgl_mulai'     => 'required|date',
            'tgl_selesai'   => 'required|date|after_or_equal:tgl_mulai',
            'kota'          => 'nullable|string|max:100',
            'lokasi'        => 'nullable|string|max:255',
            'dokumen'       => 'required|file|mimes:pdf,jpg,png|max:5120', // Maks 5MB
            'nama_dokumen'  => 'required|string|max:255',
            // Tambahkan validasi lain sesuai kebutuhan
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $filePath = $request->file('dokumen')->store('dokumen_pelatihan', 'public');

            Pelatihan::create([
                'nama_kegiatan'  => $request->nama_kegiatan,
                'posisi'         => $request->posisi,
                'posisi_lainnya' => $request->posisi === 'Lainnya' ? $request->posisi_lainnya : null,
                'penyelenggara'  => $request->penyelenggara,
                'kota'           => $request->kota,
                'lokasi'         => $request->lokasi,
                'tgl_mulai'      => $request->tgl_mulai,
                'tgl_selesai'    => $request->tgl_selesai,
                'jumlah_jam'     => $request->jumlah_jam,
                'jumlah_hari'    => $request->jumlah_hari,
                'jenis_diklat'   => $request->jenis_diklat,
                'lingkup'        => $request->lingkup,
                'struktural'     => $request->struktural === 'Ya',
                'sertifikasi'    => $request->sertifikasi === 'Ya',
                'file_path'      => $filePath,
                'jenis_dokumen'  => $request->jenis_dokumen,
                'nama_dokumen'   => $request->nama_dokumen,
                'nomor_dokumen'  => $request->nomor_dokumen,
                'tautan_dokumen' => $request->tautan_dokumen,
            ]);

            return response()->json(['success' => 'Data pelatihan berhasil disimpan!']);

        } catch (\Exception $e) {
            Log::error('Error saat menyimpan pelatihan: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat menyimpan data.'], 500);
        }
    }

    /**
     * Mengambil data untuk form edit.
     */
    public function edit($id)
    {
        try {
            $pelatihan = Pelatihan::findOrFail($id);
            return response()->json($pelatihan);
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
            'nama_kegiatan' => 'required|string|max:255',
            'posisi'        => 'required|string',
            'penyelenggara' => 'required|string|max:255',
            'tgl_mulai'     => 'required|date',
            'tgl_selesai'   => 'required|date|after_or_equal:tgl_mulai',
            'dokumen'       => 'nullable|file|mimes:pdf,jpg,png|max:5120', // Dokumen tidak wajib saat update
            'nama_dokumen'  => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $pelatihan = Pelatihan::findOrFail($id);
            $dataToUpdate = $request->except(['dokumen', '_method']);
            
            // Tambahkan logika untuk field boolean dan kondisional
            $dataToUpdate['posisi_lainnya'] = $request->posisi === 'Lainnya' ? $request->posisi_lainnya : null;
            $dataToUpdate['struktural'] = $request->struktural === 'Ya';
            $dataToUpdate['sertifikasi'] = $request->sertifikasi === 'Ya';


            if ($request->hasFile('dokumen')) {
                // Hapus file lama jika ada
                if ($pelatihan->file_path && Storage::disk('public')->exists($pelatihan->file_path)) {
                    Storage::disk('public')->delete($pelatihan->file_path);
                }
                // Simpan file baru
                $filePath = $request->file('dokumen')->store('dokumen_pelatihan', 'public');
                $dataToUpdate['file_path'] = $filePath;
            }

            $pelatihan->update($dataToUpdate);

            return response()->json(['success' => 'Data pelatihan berhasil diperbarui!']);

        } catch (\Exception $e) {
            Log::error('Error saat memperbarui pelatihan: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat memperbarui data.'], 500);
        }
    }

    /**
     * Menghapus data dari database.
     */
    public function destroy($id)
    {
        try {
            $pelatihan = Pelatihan::findOrFail($id);

            // Hapus file terkait dari storage
            if ($pelatihan->file_path && Storage::disk('public')->exists($pelatihan->file_path)) {
                Storage::disk('public')->delete($pelatihan->file_path);
            }

            $pelatihan->delete();

            return response()->json(['success' => 'Data pelatihan berhasil dihapus!']);

        } catch (\Exception $e) {
            Log::error('Error saat menghapus pelatihan: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus data.'], 500);
        }
    }
}