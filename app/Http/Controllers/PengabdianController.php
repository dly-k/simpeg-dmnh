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
     * Menampilkan halaman utama dengan data pengabdian yang sudah difilter.
     */
    public function index(Request $request)
    {
        $query = Pengabdian::with('anggota.pegawai', 'dokumen');

        // 1. Filter Pencarian
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                // Mencari di kolom-kolom tabel utama 'pengabdians'
                $q->where('kegiatan', 'like', "%{$search}%")
                  ->orWhere('nama_kegiatan', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  
                  // Mencari nama dosen di dalam relasi
                  ->orWhereHas('anggota', function ($anggotaQuery) use ($search) {
                      $anggotaQuery->where('jenis', 'dosen')
                                   ->whereHas('pegawai', function ($pegawaiQuery) use ($search) {
                                       $pegawaiQuery->where('nama_lengkap', 'like', "%{$search}%");
                                   });
                  });
            });
        }

        // 2. Filter Periode (Semester/Tahun) berdasarkan tgl_mulai
        if ($periode = $request->input('periode')) {
            list($year, $semester) = explode('_', $periode);
            $months = ($semester === 'ganjil') ? [1, 6] : [7, 12];
            $query->whereYear('tgl_mulai', $year)
                  ->whereBetween(DB::raw('MONTH(tgl_mulai)'), $months);
        }

        // 3. Filter Jenis Pengabdian
        if ($jenis = $request->input('jenis_pengabdian')) {
            $query->where('jenis_pengabdian', $jenis);
        }

        // 4. Filter Status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Ambil data pegawai aktif untuk form modal
        $pegawais = Pegawai::where('status_pegawai', 'Aktif')
                           ->orderBy('nama_lengkap')
                           ->get(['id', 'nama_lengkap']);

        // Data statis untuk dropdown Jenis Pengabdian
        $jenisPengabdianOptions = [
            'Biomedik', 'Hibah HI-LINK', 'Ipteks', 'Ipteks Bagi Inovasi Kreativitas Kampus',
            'Ipteks Bagi Kewirausahaan', 'Iptek Bagi Masyarakat', 'Iptek Bagi Produk Ekspor',
            'Iptek Bagi Wilayah', 'Iptek Bagi Wilayah Antara PT-CSR/PT-PEMDA-CSR',
            'Kerjasama Luar Negeri dan Publikasi Internasional', 'KKN Pembelajaran Pemberdayaan Masyarakat',
            'Mobil Listrik Nasional', 'MP3EI', 'Pendidikan Magister Doktor Sarjana Unggul',
            'Penelitian Disertasi Doktor', 'Penelitian Dosen Pemula', 'Penelitian Fundamental',
            'Penelitian Hibah Bersaing', 'Penelitian Kerjasama Antar Perguruan Tinggi',
            'Penelitian Kompetensi', 'Penelitian Srategis Nasional', 'Penelitian Tim Pascasarjana',
            'Penelitian Unggulan Perguruan Tinggi', 'Penelitian Unggulan Strategis Nasional',
            'Riset Andalan Perguruan Tinggi dan Industri'
        ];

        return view('pages.pengabdian', [
            'pengabdians' => $query->latest()->paginate(10)->withQueryString(),
            'pegawais' => $pegawais,
            'periodeOptions' => $this->getPeriodeOptions(),
            'jenisPengabdianOptions' => $jenisPengabdianOptions,
        ]);
    }
    
    /**
     * Helper untuk membuat opsi filter periode dinamis.
     */
    private function getPeriodeOptions()
    {
        $dates = Pengabdian::select(DB::raw('YEAR(tgl_mulai) as year, MONTH(tgl_mulai) as month'))
            ->whereNotNull('tgl_mulai')
            ->distinct()
            ->orderBy('year', 'desc')
            ->get();

        $options = [];
        foreach ($dates as $date) {
            $semester = ($date->month >= 1 && $date->month <= 6) ? 'ganjil' : 'genap';
            $label = ($semester === 'ganjil' ? 'Ganjil' : 'Genap') . ' ' . $date->year;
            $value = $date->year . '_' . $semester;
            $options[$value] = $label;
        }
        return $options;
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