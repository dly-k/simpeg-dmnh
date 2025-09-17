<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pengabdian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PengabdianController extends Controller
{
    /**
     * Menampilkan halaman utama dengan data pengabdian dan pegawai.
     */
    public function index()
    {
        // Ambil data pengabdian terbaru beserta relasinya (anggota dan dokumen)
        $pengabdians = Pengabdian::with('anggota.pegawai', 'dokumen')->latest()->get();

        // Ambil data pegawai yang berstatus 'Aktif' untuk dikirim ke dropdown di form
        $pegawais = Pegawai::where('status_pegawai', 'Aktif')
                           ->orderBy('nama_lengkap')
                           ->get(['id', 'nama_lengkap']);

        return view('pages.pengabdian', compact('pengabdians', 'pegawais'));
    }

    /**
     * Menyimpan data pengabdian baru ke database.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kegiatan' => 'required|string|max:255',
            'nama_kegiatan' => 'required|string|max:255',
            'jenis_pengabdian' => 'required|string|max:255',
            'dokumen_file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'jenis_dokumen' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            // 1. Simpan data utama ke tabel 'pengabdians'
            $pengabdian = Pengabdian::create([
                'kegiatan' => $request->kegiatan,
                'nama_kegiatan' => $request->nama_kegiatan,
                'afiliasi_non_pt' => $request->afiliasi_non_pt,
                'lokasi' => $request->lokasi,
                'jenis_pengabdian' => $request->jenis_pengabdian,
                'tahun_usulan' => $request->tahun_usulan,
                'tahun_kegiatan' => $request->tahun_kegiatan,
                'tahun_pelaksanaan' => $request->tahun_pelaksanaan,
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_selesai' => $request->tgl_selesai,
                'lama_kegiatan' => $request->lama_kegiatan,
                'in_kind' => $request->in_kind,
                'no_sk_penugasan' => $request->no_sk_penugasan,
                'tgl_sk_penugasan' => $request->tgl_sk_penugasan,
                'litabmas' => $request->litabmas,
                'dana_dikti' => $request->dana_dikti,
                'dana_pt' => $request->dana_pt,
                'dana_institusi_lain' => $request->dana_institusi_lain,
            ]);

            // 2. Simpan semua jenis anggota
            if ($request->has('dosen')) {
                foreach ($request->dosen as $d) {
                    $pengabdian->anggota()->create(['jenis' => 'dosen'] + $d);
                }
            }
            if ($request->has('mahasiswa')) {
                foreach ($request->mahasiswa as $m) {
                    $pengabdian->anggota()->create(['jenis' => 'mahasiswa'] + $m);
                }
            }
            if ($request->has('kolaborator')) {
                foreach ($request->kolaborator as $k) {
                    $pengabdian->anggota()->create(['jenis' => 'kolaborator'] + $k);
                }
            }

            // 3. Handle Upload Dokumen
            if ($request->hasFile('dokumen_file')) {
                $file = $request->file('dokumen_file');
                $path = $file->store('dokumen_pengabdian', 'public');
                $pengabdian->dokumen()->create([
                    'jenis_dokumen' => $request->jenis_dokumen,
                    'file_path' => $path,
                    'nama_file' => $file->getClientOriginalName(),
                ]);
            }
            
            DB::commit();

            $newPengabdian = Pengabdian::with('anggota.pegawai', 'dokumen')->find($pengabdian->id);

            return response()->json([
                'success' => 'Data pengabdian berhasil ditambahkan.',
                'data' => $newPengabdian
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Mengambil data spesifik untuk form edit.
     */
    public function edit(Pengabdian $pengabdian)
    {
        $pengabdian->load('anggota.pegawai', 'dokumen');
        return response()->json($pengabdian);
    }

    /**
     * Memperbarui data pengabdian di database.
     */
    public function update(Request $request, Pengabdian $pengabdian)
    {
        $validator = Validator::make($request->all(), [
            'kegiatan' => 'required|string|max:255',
            'nama_kegiatan' => 'required|string|max:255',
            'jenis_pengabdian' => 'required|string|max:255',
            'dokumen_file' => 'sometimes|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            // 1. Update data utama pada tabel 'pengabdians'
            $pengabdian->update($request->except(['_method', 'dosen', 'mahasiswa', 'kolaborator', 'dokumen_file', 'jenis_dokumen']));

            // 2. Hapus semua anggota lama, lalu buat ulang dari data form
            $pengabdian->anggota()->delete();

            if ($request->has('dosen')) {
                foreach ($request->dosen as $d) {
                    $pengabdian->anggota()->create(['jenis' => 'dosen'] + $d);
                }
            }
            if ($request->has('mahasiswa')) {
                foreach ($request->mahasiswa as $m) {
                    $pengabdian->anggota()->create(['jenis' => 'mahasiswa'] + $m);
                }
            }
            if ($request->has('kolaborator')) {
                foreach ($request->kolaborator as $k) {
                    $pengabdian->anggota()->create(['jenis' => 'kolaborator'] + $k);
                }
            }

            // 3. Jika ada file dokumen baru di-upload
            if ($request->hasFile('dokumen_file')) {
                foreach ($pengabdian->dokumen as $doc) {
                    Storage::disk('public')->delete($doc->file_path);
                }
                $pengabdian->dokumen()->delete();

                $file = $request->file('dokumen_file');
                $path = $file->store('dokumen_pengabdian', 'public');
                $pengabdian->dokumen()->create([
                    'jenis_dokumen' => $request->jenis_dokumen,
                    'file_path' => $path,
                    'nama_file' => $file->getClientOriginalName(),
                ]);
            }
            
            DB::commit();

            $updatedPengabdian = Pengabdian::with('anggota.pegawai', 'dokumen')->find($pengabdian->id);
            
            return response()->json([
                'success' => 'Data pengabdian berhasil diperbarui.',
                'data' => $updatedPengabdian
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal memperbarui data: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Menghapus data pengabdian dari database.
     */
    public function destroy(Pengabdian $pengabdian)
    {
        DB::beginTransaction();
        try {
            // 1. Hapus semua file dokumen terkait dari storage
            foreach ($pengabdian->dokumen as $doc) {
                Storage::disk('public')->delete($doc->file_path);
            }
            
            // 2. Hapus data utama dari tabel 'pengabdians'.
            // Data di tabel 'pengabdian_anggotas' dan 'pengabdian_dokumens'
            // akan terhapus otomatis karena kita menggunakan onDelete('cascade') di migrasi.
            $pengabdian->delete();

            DB::commit();

            return response()->json(['success' => 'Data berhasil dihapus secara permanen.']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal menghapus data: ' . $e->getMessage()], 500);
        }
    }

    public function show(Pengabdian $pengabdian)
    {
        // Muat semua relasi yang dibutuhkan: anggota beserta data pegawai, dan dokumen.
        $pengabdian->load('anggota.pegawai', 'dokumen');
        
        // Kirim data lengkap sebagai respons JSON
        return response()->json($pengabdian);
    }

    /**
 * Memperbarui status verifikasi data penunjang.
 */
    public function verifikasi(Request $request, Pengabdian $pengabdian)
    {
        // 1. Validasi input
        $validator = Validator::make($request->all(), [
            'status' => [
                'required',
                // Pastikan status yang dikirim hanya salah satu dari dua nilai ini
                Rule::in(['Sudah Diverifikasi', 'Ditolak']),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // 2. Update status di database
            $pengabdian->update(['status' => $request->status]);

            // 3. Kirim respons sukses beserta status baru
            return response()->json([
                'success' => 'Status verifikasi berhasil diperbarui.',
                'new_status' => $request->status,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memperbarui status: ' . $e->getMessage()], 500);
        }
    }

}
