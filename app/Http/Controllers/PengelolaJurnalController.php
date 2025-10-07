<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\PengelolaJurnal;
use App\Models\DokumenPengelolaJurnal; // Tambahan penting
use Illuminate\Http\Request;
use App\Exports\PengelolaJurnalExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage; // Tambahan yang Anda tanyakan
use Illuminate\Validation\Rule;


class PengelolaJurnalController extends Controller
{
public function index(Request $request) // Tambahkan Request $request
{
    // 1. Ambil data pegawai aktif untuk dropdown modal (tidak berubah)
    $pegawais = Pegawai::where('status_pegawai', 'Aktif')
                       ->select('id', 'nama_lengkap')
                       ->orderBy('nama_lengkap', 'asc')
                       ->get();

    // 2. [BARU] Hasilkan opsi filter semester secara dinamis dari data yang ada
    $tanggalData = DB::table('pengelola_jurnals')
                      ->selectRaw('YEAR(tanggal_mulai) as year, MONTH(tanggal_mulai) as month')
                      ->distinct()
                      ->orderBy('year', 'desc')
                      ->orderBy('month', 'desc')
                      ->get();

    $semesterOptions = [];
    foreach ($tanggalData as $data) {
        if ($data->month >= 1 && $data->month <= 6) {
            $semester = 'Ganjil';
            $value = 'ganjil_' . $data->year;
        } else {
            $semester = 'Genap';
            $value = 'genap_' . $data->year;
        }
        // Pastikan tidak ada duplikat
        if (!isset($semesterOptions[$value])) {
            $semesterOptions[$value] = "Semester {$semester} {$data->year}";
        }
    }

    // 3. [BARU] Query utama dengan filter kondisional
    $query = PengelolaJurnal::with('pegawai', 'dokumen');

    // Terapkan filter pencarian (search)
    $query->when($request->search, function ($q, $search) {
        $q->where(function ($subQuery) use ($search) {
            $subQuery->where('kegiatan', 'like', "%{$search}%")
                     ->orWhere('media_publikasi', 'like', "%{$search}%")
                     ->orWhereHas('pegawai', function ($pegawaiQuery) use ($search) {
                         $pegawaiQuery->where('nama_lengkap', 'like', "%{$search}%");
                     });
        });
    });

    // Terapkan filter status verifikasi
    $query->when($request->status, function ($q, $status) {
        $q->where('status_verifikasi', $status);
    });

    // Terapkan filter semester
    $query->when($request->semester, function ($q, $semester) {
        [$periode, $tahun] = explode('_', $semester);
        $bulanRange = ($periode == 'ganjil') ? [1, 6] : [7, 12];
        
        $q->whereYear('tanggal_mulai', $tahun)
          ->whereBetween(DB::raw('MONTH(tanggal_mulai)'), $bulanRange);
    });

    // 4. Eksekusi query dengan pagination
    // withQueryString() penting agar filter tetap aktif saat pindah halaman
    $pengelolaJurnals = $query->latest()->paginate(10)->withQueryString();

    // 5. Kirim semua data yang diperlukan ke view
    return view('pages.pengelola-jurnal', compact(
        'pegawais', 
        'pengelolaJurnals', 
        'semesterOptions'
    ));
}

public function export(Request $request)
{
    $query = PengelolaJurnal::with('pegawai', 'dokumen');

    // Filter search
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('kegiatan', 'like', '%' . $request->search . '%')
            ->orWhere('media_publikasi', 'like', '%' . $request->search . '%')
            ->orWhereHas('pegawai', function ($subq) use ($request) {
                $subq->where('nama_lengkap', 'like', '%' . $request->search . '%');
            });
        });
    }

    // Filter status verifikasi
    $status = null;
    if ($request->filled('status')) {
        $status = $request->status;
        $query->where('status_verifikasi', $status);
    }

    // Filter semester (pakai tanggal mulai)
    $semester = null;
    if ($request->filled('semester')) {
        [$periode, $tahun] = explode('_', $request->semester);
        $semester = $periode . ' ' . $tahun;

        if ($periode == 'ganjil') {
            $startMonth = 1;
            $endMonth   = 6;
        } else {
            $startMonth = 7;
            $endMonth   = 12;
        }

        $semesterStart = Carbon::create($tahun, $startMonth, 1)->startOfDay();
        $semesterEnd   = Carbon::create($tahun, $endMonth, 1)->endOfMonth()->endOfDay();

        $query->whereBetween('tanggal_mulai', [$semesterStart, $semesterEnd]);
    }

    $data = $query->get();

    // Nama file dinamis
    $filename = 'Data_Pengelola_Jurnal';
    if ($semester) $filename .= '_' . str_replace(' ', '_', $semester);
    if ($status) $filename .= '_' . preg_replace('/[^A-Za-z0-9\-]/', '', $status);
    if ($request->filled('search')) $filename .= '_(' . preg_replace('/[^A-Za-z0-9\-]/', '', $request->search) . ')';
    $filename .= '.xlsx';

    return Excel::download(new PengelolaJurnalExport($data, $semester, $status, $request->search), $filename);
}

    /**
     * Menyimpan data pengelola jurnal baru.
     */
    public function store(Request $request)
    {
        // 2. Validasi data yang masuk
        $validator = Validator::make($request->all(), [
            'nama' => 'required|exists:pegawais,id',
            'kegiatan' => 'required|string',
            'media_publikasi' => 'required|string|max:255',
            'peran' => 'required|string|max:255',
            'no_sk' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|string',
            'dokumen.*.jenis' => 'required|string',
            'dokumen.*.nama' => 'nullable|string|max:255',
            'dokumen.*.nomor' => 'nullable|string|max:255',
            'dokumen.*.tautan' => 'nullable|url',
            'dokumen.*.file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx,txt|max:5120', // Maksimal 5MB
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 3. Menggunakan DB Transaction untuk memastikan semua data tersimpan
        DB::beginTransaction();
        try {
            $pengelolaJurnal = PengelolaJurnal::create([
                'pegawai_id' => $request->nama,
                'kegiatan' => $request->kegiatan,
                'media_publikasi' => $request->media_publikasi,
                'peran' => $request->peran,
                'no_sk' => $request->no_sk,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'status' => $request->status,
            ]);

            // 4. Menyimpan dokumen jika ada
            if ($request->has('dokumen')) {
                foreach ($request->dokumen as $index => $doc) {
                    $path_file = null;
                    if ($request->hasFile("dokumen.{$index}.file")) {
                        $file = $request->file("dokumen.{$index}.file");
                        $path_file = $file->store('dokumen_pengelola_jurnal', 'public');
                    }

                    $pengelolaJurnal->dokumen()->create([
                        'jenis_dokumen' => $doc['jenis'],
                        'nama_dokumen' => $doc['nama'],
                        'nomor_dokumen' => $doc['nomor'],
                        'tautan_dokumen' => $doc['tautan'],
                        'path_file' => $path_file,
                    ]);
                }
            }

            DB::commit(); // Konfirmasi semua perubahan jika berhasil
            return response()->json(['success' => 'Data pengelola jurnal berhasil disimpan!'], 200);

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua perubahan jika terjadi error
            Log::error('Error saving pengelola jurnal: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan pada server.'], 500);
        }
    }
    public function verifikasi(Request $request, PengelolaJurnal $pengelolaJurnal)
    {
        // 1. Validasi input agar sesuai dengan nilai di ENUM database
        $validated = $request->validate([
            'status' => ['required', Rule::in(['Sudah Diverifikasi', 'Ditolak'])],
        ]);

        try {
            // 2. Update kolom status_verifikasi dengan data yang sudah divalidasi
            $pengelolaJurnal->update(['status_verifikasi' => $validated['status']]);
            
            return response()->json(['success' => 'Status verifikasi berhasil diperbarui!']);
        } catch (\Exception $e) {
            Log::error('Verification failed: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memperbarui status.'], 500);
        }
    }
    public function edit(PengelolaJurnal $pengelolaJurnal)
    {
        // Muat relasi dokumen agar datanya ikut terkirim
        $pengelolaJurnal->load('dokumen');
        
        // Kirim data sebagai respons JSON
        return response()->json($pengelolaJurnal);
    }

    /**
     * Memperbarui data pengelola jurnal di database.
     */
    public function update(Request $request, PengelolaJurnal $pengelolaJurnal)
    {
        // Validasi data (mirip dengan store, tapi beberapa aturan disesuaikan)
        $validator = Validator::make($request->all(), [
            'nama' => 'required|exists:pegawais,id',
            'kegiatan' => 'required|string',
            'media_publikasi' => 'required|string|max:255',
            'peran' => 'required|string|max:255',
            'no_sk' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|string',
            // Dokumen yang sudah ada
            'dokumen.*.id' => 'nullable|exists:dokumen_pengelola_jurnals,id',
            'dokumen.*.jenis' => 'required|string',
            'dokumen.*.nama' => 'nullable|string|max:255',
            'dokumen.*.file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx,txt|max:5120',
            // Dokumen baru
            'new_dokumen.*.jenis' => 'required|string',
            'new_dokumen.*.nama' => 'nullable|string|max:255',
            'new_dokumen.*.file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx,txt|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            // 1. Update data utama
            $pengelolaJurnal->update([
                'pegawai_id' => $request->nama,
                'kegiatan' => $request->kegiatan,
                'media_publikasi' => $request->media_publikasi,
                'peran' => $request->peran,
                'no_sk' => $request->no_sk,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'status' => $request->status,
            ]);

            $existingDocIds = [];

            // 2. Proses dokumen yang sudah ada
            if ($request->has('dokumen')) {
                foreach ($request->dokumen as $index => $docData) {
                    $docId = $docData['id'];
                    $existingDocIds[] = $docId;
                    $dokumen = DokumenPengelolaJurnal::find($docId);

                    if ($dokumen) {
                        $path_file = $dokumen->path_file;
                        // Cek apakah ada file baru yang diupload untuk dokumen ini
                        if ($request->hasFile("dokumen.{$index}.file")) {
                            // Hapus file lama jika ada
                            if ($path_file && Storage::disk('public')->exists($path_file)) {
                                Storage::disk('public')->delete($path_file);
                            }
                            // Simpan file baru
                            $path_file = $request->file("dokumen.{$index}.file")->store('dokumen_pengelola_jurnal', 'public');
                        }
                        
                        $dokumen->update([
                            'jenis_dokumen' => $docData['jenis'],
                            'nama_dokumen' => $docData['nama'],
                            'nomor_dokumen' => $docData['nomor'],
                            'tautan_dokumen' => $docData['tautan'],
                            'path_file' => $path_file,
                        ]);
                    }
                }
            }

            // 3. Hapus dokumen lama yang tidak ada di request (dihapus user)
            $pengelolaJurnal->dokumen()->whereNotIn('id', $existingDocIds)->get()->each(function($doc){
                if ($doc->path_file && Storage::disk('public')->exists($doc->path_file)) {
                    Storage::disk('public')->delete($doc->path_file);
                }
                $doc->delete();
            });


            // 4. Tambah dokumen baru
            if ($request->has('new_dokumen')) {
                foreach ($request->new_dokumen as $index => $docData) {
                    $path_file = null;
                    if ($request->hasFile("new_dokumen.{$index}.file")) {
                        $path_file = $request->file("new_dokumen.{$index}.file")->store('dokumen_pengelola_jurnal', 'public');
                    }
                    $pengelolaJurnal->dokumen()->create([
                        'jenis_dokumen' => $docData['jenis'],
                        'nama_dokumen' => $docData['nama'],
                        'nomor_dokumen' => $docData['nomor'],
                        'tautan_dokumen' => $docData['tautan'],
                        'path_file' => $path_file,
                    ]);
                }
            }
            
            DB::commit();
            return response()->json(['success' => 'Data berhasil diperbarui!']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating data: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan pada server.'], 500);
        }
    }
    public function destroy(PengelolaJurnal $pengelolaJurnal)
    {
        DB::beginTransaction();
        try {
            // 1. Hapus semua file terkait dari storage terlebih dahulu
            foreach ($pengelolaJurnal->dokumen as $dokumen) {
                if ($dokumen->path_file && Storage::disk('public')->exists($dokumen->path_file)) {
                    Storage::disk('public')->delete($dokumen->path_file);
                }
            }

            // 2. Hapus data dari database
            // Catatan: Record di tabel 'dokumen_pengelola_jurnals' akan ikut terhapus
            // karena kita sudah set onDelete('cascade') di migrasi.
            $pengelolaJurnal->delete();
            
            DB::commit();
            return response()->json(['success' => 'Data berhasil dihapus!']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Delete failed: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal menghapus data.'], 500);
        }
    }
}