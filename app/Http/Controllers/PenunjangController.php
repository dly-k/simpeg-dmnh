<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Penunjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class PenunjangController extends Controller
{
    /**
     * Menampilkan halaman utama ATAU data hasil filter & pencarian (AJAX).
     */
    public function index(Request $request)
    {
        $searchQuery = $request->input('search');
        $filterSemester = $request->input('semester');
        $filterLingkup = $request->input('lingkup');
        $filterStatus = $request->input('status');

        $query = Penunjang::with('anggota.pegawai', 'dokumen')->latest();

        if ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('kegiatan', 'like', "%{$searchQuery}%")
                  ->orWhere('nama_kegiatan', 'like', "%{$searchQuery}%")
                  ->orWhere('nomor_sk', 'like', "%{$searchQuery}%")
                  ->orWhere('jenis_kegiatan', 'like', "%{$searchQuery}%")
                  ->orWhere('lingkup', 'like', "%{$searchQuery}%")
                  ->orWhere('instansi', 'like', "%{$searchQuery}%")
                  ->orWhere('status', 'like', "%{$searchQuery}%")
                  ->orWhereHas('anggota.pegawai', function ($subQ) use ($searchQuery) {
                      $subQ->where('nama_lengkap', 'like', "%{$searchQuery}%");
                  });
            });
        }

        if ($filterLingkup) {
            $query->where('lingkup', $filterLingkup);
        }
        if ($filterStatus) {
            $query->where('status', $filterStatus);
        }

        if ($filterSemester) {
            list($semesterType, $year) = explode(' ', $filterSemester);
            
            if ($semesterType == 'Ganjil') {
                $semesterStart = Carbon::create($year, 1, 1)->startOfDay();
                $semesterEnd = Carbon::create($year, 6, 30)->endOfDay();
            } else { // Genap
                $semesterStart = Carbon::create($year, 7, 1)->startOfDay();
                $semesterEnd = Carbon::create($year, 12, 31)->endOfDay();
            }

            $query->where(function($q) use ($semesterStart, $semesterEnd) {
                $q->where('tmt_mulai', '<=', $semesterEnd)
                  ->where('tmt_selesai', '>=', $semesterStart);
            });
        }

        $penunjangs = $query->paginate(10)->appends($request->query());

        if ($request->ajax()) {
            return response()->json($penunjangs);
        }

        $pegawais = Pegawai::where('status_pegawai', 'Aktif')->orderBy('nama_lengkap')->get(['id', 'nama_lengkap']);
        
        return view('pages.penunjang', [
            'pegawais' => $pegawais,
            'penunjangs' => $penunjangs,
            'semesterOptions' => $this->generateSemesterOptions()
        ]);
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
            
            return response()->json([
                'success' => 'Data penunjang berhasil ditambahkan.',
                'semesterOptions' => $this->generateSemesterOptions()
            ], 201);

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
            
            return response()->json([
                'success' => 'Data berhasil diperbarui.',
                'semesterOptions' => $this->generateSemesterOptions()
            ]);

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

            return response()->json([
                'success' => 'Data berhasil dihapus secara permanen.',
                'semesterOptions' => $this->generateSemesterOptions()
            ]);

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

    /**
     * Fungsi helper untuk membuat opsi semester secara dinamis.
     */
    private function generateSemesterOptions()
    {
        // 1. Ambil semua rentang tanggal dari database dalam satu query
        $dateRanges = Penunjang::select('tmt_mulai', 'tmt_selesai')->get();
        $activeSemesters = [];

        // 2. Iterasi setiap rentang tanggal untuk menemukan semester aktif
        foreach ($dateRanges as $range) {
            $start = Carbon::parse($range->tmt_mulai)->startOfMonth();
            $end = Carbon::parse($range->tmt_selesai)->startOfMonth();

            // Loop dari bulan mulai hingga bulan selesai
            for ($date = $start; $date->lte($end); $date->addMonth()) {
                $year = $date->year;
                $semester = ($date->month <= 6) ? 'Ganjil' : 'Genap';
                $option = "$semester $year";
                // Gunakan key array untuk memastikan setiap semester unik
                $activeSemesters[$option] = true;
            }
        }

        // 3. Ambil key-nya saja dan urutkan
        $semesterOptions = array_keys($activeSemesters);
        
        // Urutkan dari yang terbaru (misal: Genap 2025, Ganjil 2025, Genap 2024, ...)
        usort($semesterOptions, function ($a, $b) {
            list($semesterA, $yearA) = explode(' ', $a);
            list($semesterB, $yearB) = explode(' ', $b);

            if ($yearA != $yearB) {
                return $yearB <=> $yearA; // Urutkan tahun descending (terbaru dulu)
            }
            // Jika tahun sama, Genap (nilai 2) lebih dulu dari Ganjil (nilai 1)
            return ($semesterB == 'Genap' ? 2 : 1) <=> ($semesterA == 'Genap' ? 2 : 1);
        });

        return $semesterOptions;
    }
}