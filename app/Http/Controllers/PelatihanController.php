<?php

namespace App\Http\Controllers;

use App\Models\Pelatihan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PelatihanController extends Controller
{
    /**
     * Menampilkan halaman utama dengan data pelatihan.
     */
    public function index(Request $request)
    {
        $query = Pelatihan::with('pegawai');

        // Filter tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tgl_mulai', $request->tahun);
        }

        // Filter posisi
        if ($request->filled('posisi')) {
            if (in_array($request->posisi, ['Peserta', 'Pembicara', 'Panitia'])) {
                $query->where('posisi', $request->posisi);
            } else {
                $query->where('posisi', 'Lainnya')
                    ->where('posisi_lainnya', $request->posisi);
            }
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_kegiatan', 'like', '%' . $request->search . '%')
                  ->orWhere('penyelenggara', 'like', '%' . $request->search . '%')
                  ->orWhereHas('pegawai', function($subq) use ($request) {
                      $subq->where('nama_lengkap', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $dataPelatihan = $query->orderBy('tgl_mulai', 'desc')->paginate(10);

        // Ambil daftar tahun
        $tahunList = Pelatihan::selectRaw('YEAR(tgl_mulai) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Posisi fix
        $fixedPosisi = ['Peserta', 'Pembicara', 'Panitia'];

        // Posisi lainnya unik
        $posisiLainnya = Pelatihan::where('posisi', 'Lainnya')
            ->whereNotNull('posisi_lainnya')
            ->distinct()
            ->pluck('posisi_lainnya');
            
        // Ambil daftar pegawai aktif untuk dropdown
        $pegawais = Pegawai::where('status_pegawai', 'Aktif')->orderBy('nama_lengkap')->get();

        return view('pages.pelatihan', compact('dataPelatihan', 'tahunList', 'fixedPosisi', 'posisiLainnya', 'pegawais'));
    }

    /**
     * Menyimpan data baru dari form modal.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pegawai_id'    => 'required|integer|exists:pegawais,id',
            'nama_kegiatan' => 'required|string|max:255',
            'posisi'        => 'required|string',
            'penyelenggara' => 'required|string|max:255',
            'tgl_mulai'     => 'required|date',
            'tgl_selesai'   => 'required|date|after_or_equal:tgl_mulai',
            'kota'          => 'nullable|string|max:100',
            'lokasi'        => 'nullable|string|max:255',
            'dokumen'       => 'required|file|mimes:pdf,jpg,png,jpeg,doc,docx|max:5120', // Maks 5MB
            'nama_dokumen'  => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $filePath = $request->file('dokumen')->store('dokumen_pelatihan', 'public');

            Pelatihan::create([
                'pegawai_id'     => $request->pegawai_id,
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
            'pegawai_id'    => 'required|integer|exists:pegawais,id',
            'nama_kegiatan' => 'required|string|max:255',
            'posisi'        => 'required|string',
            'penyelenggara' => 'required|string|max:255',
            'tgl_mulai'     => 'required|date',
            'tgl_selesai'   => 'required|date|after_or_equal:tgl_mulai',
            'dokumen'       => 'nullable|file|mimes:pdf,jpg,png,jpeg,doc,docx|max:5120', // Dokumen tidak wajib saat update
            'nama_dokumen'  => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $pelatihan = Pelatihan::findOrFail($id);
            $dataToUpdate = $request->except(['dokumen', '_method']);
            
            $dataToUpdate['posisi_lainnya'] = $request->posisi === 'Lainnya' ? $request->posisi_lainnya : null;
            $dataToUpdate['struktural'] = $request->struktural === 'Ya';
            $dataToUpdate['sertifikasi'] = $request->sertifikasi === 'Ya';

            if ($request->hasFile('dokumen')) {
                if ($pelatihan->file_path && Storage::disk('public')->exists($pelatihan->file_path)) {
                    Storage::disk('public')->delete($pelatihan->file_path);
                }
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