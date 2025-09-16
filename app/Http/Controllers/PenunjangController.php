<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Penunjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PenunjangController extends Controller
{
    /**
     * Menampilkan halaman utama Penunjang beserta datanya.
     */
    public function index()
    {
        // Ambil HANYA pegawai yang berstatus 'Aktif' untuk pilihan form
        $pegawais = Pegawai::where('status_pegawai', 'Aktif')
                          ->orderBy('nama_lengkap')
                          ->get(['id', 'nama_lengkap']);
                          
        $penunjangs = Penunjang::with('anggota.pegawai', 'dokumen')->latest()->get();

        return view('pages.penunjang', compact('pegawais', 'penunjangs'));
    }

    /**
     * Menyimpan data Penunjang baru ke database.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kegiatan' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|string|max:255',
            'lingkup' => 'required|string|max:255',
            'nama_kegiatan' => 'required|string|max:255',
            'instansi' => 'required|string|max:255',
            'nomor_sk' => 'required|string|max:255',
            'tmt_mulai' => 'required|date',
            'tmt_selesai' => 'required|date|after_or_equal:tmt_mulai',
            'anggota' => 'sometimes|array',
            'anggota.*.pegawai_id' => 'required|exists:pegawais,id',
            'anggota.*.peran' => 'required|string|max:255',
            'dokumen' => 'sometimes|array',
            'dokumen.*.file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $penunjang = Penunjang::create($request->only([
                'kegiatan', 'jenis_kegiatan', 'lingkup', 'nama_kegiatan', 
                'instansi', 'nomor_sk', 'tmt_mulai', 'tmt_selesai'
            ]));

            if ($request->has('anggota')) {
                foreach ($request->anggota as $anggotaData) {
                    $penunjang->anggota()->create($anggotaData);
                }
            }

            if ($request->has('dokumen')) {
                foreach ($request->dokumen as $key => $dokumenData) {
                    if (isset($request->file('dokumen')[$key]['file'])) {
                        $file = $request->file('dokumen')[$key]['file'];
                        $path = $file->store('dokumen_penunjang', 'public');
                        
                        $penunjang->dokumen()->create([
                            'jenis_dokumen' => $dokumenData['jenis'],
                            'nama_dokumen' => $dokumenData['nama'],
                            'nomor_dokumen' => $dokumenData['nomor'],
                            'tautan' => $dokumenData['tautan'],
                            'file_path' => $path,
                        ]);
                    }
                }
            }
            
            DB::commit();
            $newPenunjang = Penunjang::with('anggota.pegawai', 'dokumen')->find($penunjang->id);
            return response()->json(['success' => 'Data penunjang berhasil ditambahkan.', 'data' => $newPenunjang], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Mengambil data detail satu Penunjang untuk ditampilkan.
     */
    public function show(Penunjang $penunjang)
    {
        $penunjang->load('anggota.pegawai', 'dokumen');
        return response()->json($penunjang);
    }

    /**
     * Memperbarui data Penunjang yang ada di database.
     */
    public function update(Request $request, Penunjang $penunjang)
    {
        $validator = Validator::make($request->all(), [
            'kegiatan' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|string|max:255',
            'lingkup' => 'required|string|max:255',
            'nama_kegiatan' => 'required|string|max:255',
            'instansi' => 'required|string|max:255',
            'nomor_sk' => 'required|string|max:255',
            'tmt_mulai' => 'required|date',
            'tmt_selesai' => 'required|date|after_or_equal:tmt_mulai',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $penunjang->update($request->only([
                'kegiatan', 'jenis_kegiatan', 'lingkup', 'nama_kegiatan', 
                'instansi', 'nomor_sk', 'tmt_mulai', 'tmt_selesai'
            ]));

            $penunjang->anggota()->delete();
            if ($request->has('anggota')) {
                foreach ($request->anggota as $anggotaData) {
                    $penunjang->anggota()->create($anggotaData);
                }
            }

            if ($request->has('dokumen')) {
                foreach ($penunjang->dokumen as $doc) {
                    Storage::disk('public')->delete($doc->file_path);
                }
                $penunjang->dokumen()->delete();

                foreach ($request->dokumen as $key => $dokumenData) {
                    if (isset($request->file('dokumen')[$key]['file'])) {
                        $file = $request->file('dokumen')[$key]['file'];
                        $path = $file->store('dokumen_penunjang', 'public');
                        
                        $penunjang->dokumen()->create([
                            'jenis_dokumen' => $dokumenData['jenis'],
                            'nama_dokumen' => $dokumenData['nama'],
                            'nomor_dokumen' => $dokumenData['nomor'],
                            'tautan' => $dokumenData['tautan'],
                            'file_path' => $path,
                        ]);
                    }
                }
            }

            DB::commit();
            $updatedPenunjang = Penunjang::with('anggota.pegawai', 'dokumen')->find($penunjang->id);
            return response()->json(['success' => 'Data berhasil diperbarui.', 'data' => $updatedPenunjang]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal memperbarui data: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Menghapus data dari storage dan database.
     */
    public function destroy(Penunjang $penunjang)
    {
        DB::beginTransaction();
        try {
            foreach ($penunjang->dokumen as $doc) {
                Storage::disk('public')->delete($doc->file_path);
            }
            
            $penunjang->delete();
            DB::commit();
            return response()->json(['success' => 'Data berhasil dihapus secara permanen.']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal menghapus data: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Memperbarui status verifikasi data penunjang.
     */
    public function verifikasi(Request $request, Penunjang $penunjang)
    {
        $validator = Validator::make($request->all(), [
            'status' => [
                'required',
                Rule::in(['Sudah Diverifikasi', 'Ditolak']),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $penunjang->update(['status' => $request->status]);
            return response()->json([
                'success' => 'Status verifikasi berhasil diperbarui.',
                'new_status' => $request->status,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memperbarui status: ' . $e->getMessage()], 500);
        }
    }
}