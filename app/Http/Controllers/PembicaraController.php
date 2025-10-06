<?php

namespace App\Http\Controllers;

use App\Models\DokumenPembicara;
use App\Models\Pegawai;
use App\Models\Pembicara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PembicaraController extends Controller
{
    /**
     * Menampilkan halaman daftar pembicara, mengambil semua data pembicara
     * dan data pegawai untuk mengisi dropdown pada modal.
     */
     public function index(Request $request)
    {
        // 1. Query dasar untuk data pembicara
        $query = Pembicara::with(['pegawai', 'dokumen']);

        // 2. Search
        $query->when($request->search, function ($q, $search) {
            $q->where(function ($subQuery) use ($search) {
                $subQuery->whereHas('pegawai', function ($pegawaiQuery) use ($search) {
                    $pegawaiQuery->where('nama_lengkap', 'like', "%{$search}%");
                })
                ->orWhere('judul_makalah', 'like', "%{$search}%");
            });
        });

        // 3. Filter Semester
        $query->when($request->semester, function ($q, $semesterValue) {
            [$semester, $tahun] = explode('_', $semesterValue);
            if ($semester === 'ganjil') {
                $q->whereYear('tanggal_pelaksana', $tahun)->whereMonth('tanggal_pelaksana', '<=', 6);
            } elseif ($semester === 'genap') {
                $q->whereYear('tanggal_pelaksana', $tahun)->whereMonth('tanggal_pelaksana', '>=', 7);
            }
        });

        // 4. Filter Tingkat
        $query->when($request->tingkat, fn($q, $tingkat) => $q->where('tingkat_pertemuan', $tingkat));

        // 5. Filter Status
        $query->when($request->status, fn($q, $status) => $q->where('status_verifikasi', $status));

        // 6. Ambil hasil dengan pagination
        $pembicaras = $query->latest()->paginate(10)->appends($request->query());

        // Data pegawai
        $pegawais = Pegawai::where('status_pegawai', 'Aktif')
            ->orderBy('nama_lengkap', 'asc')
            ->get(['id', 'nama_lengkap']);

        // Data semester untuk filter
        $semesterOptions = [];
        $uniqueSemesters = DB::table('pembicaras')
            ->selectRaw('YEAR(tanggal_pelaksana) as year, MONTH(tanggal_pelaksana) as month')
            ->distinct()->orderBy('year', 'desc')->orderBy('month', 'desc')->get();

        $addedSemesters = [];
        foreach ($uniqueSemesters as $item) {
            $semesterKey = ($item->month <= 6) ? "ganjil_{$item->year}" : "genap_{$item->year}";
            $semesterText = ($item->month <= 6) ? "Semester Ganjil/{$item->year}" : "Semester Genap/{$item->year}";
            if (!in_array($semesterKey, $addedSemesters)) {
                $semesterOptions[] = ['value' => $semesterKey, 'text' => $semesterText];
                $addedSemesters[] = $semesterKey;
            }
        }

        return view('pages.pembicara', compact('pembicaras', 'pegawais', 'semesterOptions'));
    }

    public function export(Request $request)
    {
        $query = Pembicara::with('pegawai');

        // Filter search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul_makalah', 'like', '%' . $search . '%')
                ->orWhereHas('pegawai', function ($subq) use ($search) {
                    $subq->where('nama_lengkap', 'like', '%' . $search . '%');
                });
            });
        }

        // Filter semester
        $semester = null;
        if ($request->filled('semester')) {
            $semester = $request->semester;
            [$semesterType, $year] = explode('_', $semester);

            if ($semesterType === 'ganjil') {
                $startMonth = 1;
                $endMonth   = 6;
            } else {
                $startMonth = 7;
                $endMonth   = 12;
            }

            $semesterStartDate = \Carbon\Carbon::create($year, $startMonth, 1)->startOfDay();
            $semesterEndDate   = \Carbon\Carbon::create($year, $endMonth, 1)->endOfMonth()->endOfDay();

            $query->whereBetween('tanggal_pelaksana', [$semesterStartDate, $semesterEndDate]);
        }

        // Filter tingkat
        $tingkat = null;
        if ($request->filled('tingkat')) {
            $tingkat = $request->tingkat;
            $query->where('tingkat_pertemuan', $tingkat);
        }

        // Filter status
        $status = null;
        if ($request->filled('status')) {
            $status = $request->status;
            $query->where('status_verifikasi', $status);
        }

        // Ambil data
        $data = $query->latest()->get();

        // Buat nama file dinamis
        $filename = 'Data_Pembicara';
        if ($semester) {
            $filename .= '_' . $semester;
        }
        if ($tingkat) {
            $filename .= '_' . $tingkat;
        }
        if ($status) {
            $filename .= '_' . $status;
        }
        if ($request->filled('search')) {
            $filename .= '_(' . preg_replace('/[^A-Za-z0-9\-]/', '', $request->search) . ')';
        }
        $filename .= '.xlsx';

        // Export ke Excel (pakai Export Class)
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\PembicaraExport($data, $semester, $status, $request->search, $tingkat),
            $filename
        );
    }

    /**
     * [PERBAIKAN] Menyimpan data pembicara baru dari form tambah.
     * Logika filter sudah dihapus dari sini.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kegiatan' => 'required|string|max:255',
            'pegawai_id' => 'required|exists:pegawais,id',
            'kategori_pembicara' => 'required|string|max:255',
            'judul_makalah' => 'required|string|max:255',
            'nama_pertemuan' => 'required|string|max:255',
            'penyelenggara' => 'required|string|max:255',
            'tanggal_pelaksana' => 'required|date',
            'dokumen.*.file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx,txt|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $pembicara = Pembicara::create($request->except('dokumen', '_token'));
            if ($request->has('dokumen')) {
                foreach ($request->dokumen as $docData) {
                    if (isset($docData['file'])) {
                        $file = $docData['file'];
                        $path = $file->store('dokumen_pembicara', 'public');
                        $pembicara->dokumen()->create([
                            'jenis_dokumen' => $docData['jenis'],
                            'nama_dokumen' => $docData['nama'],
                            'nomor' => $docData['nomor'],
                            'tautan' => $docData['tautan'],
                            'file_path' => 'storage/' . $path,
                        ]);
                    }
                }
            }
            DB::commit();
            return redirect()->route('pembicara.index')->with('success', 'Data pembicara berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan data pembicara: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.')->withInput();
        }
    }

    public function verifikasi(Request $request, Pembicara $pembicara)
    {
        // Validasi input yang masuk, harus 'sudah_diverifikasi' atau 'ditolak'
        $request->validate([
            'status' => 'required|string|in:sudah_diverifikasi,ditolak',
        ]);

        try {
            // Update kolom status_verifikasi
            $pembicara->status_verifikasi = $request->status;
            $pembicara->save();

            // Tentukan pesan sukses berdasarkan status
            $pesan = $request->status === 'sudah_diverifikasi' 
                ? 'Data pembicara berhasil diverifikasi.' 
                : 'Data pembicara berhasil ditolak.';

            // Kembalikan response JSON yang menandakan sukses
            return response()->json(['success' => true, 'message' => $pesan]);

        } catch (\Exception $e) {
            Log::error('Gagal verifikasi data pembicara: ' . $e->getMessage());
            // Kembalikan response JSON jika terjadi error
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan di server.'], 500);
        }
    }
    /**
     * Mengambil data spesifik untuk diedit dan mengembalikannya sebagai JSON.
     */
    public function edit(Pembicara $pembicara)
    {
        // [MODIFIKASI] Muat kedua relasi, 'dokumen' dan 'pegawai'
        $pembicara->load('dokumen', 'pegawai'); 
        return response()->json($pembicara);
    }

    public function destroy(Pembicara $pembicara)
    {
        try {
            DB::beginTransaction();

            // Hapus semua file dokumen terkait dari storage
            foreach ($pembicara->dokumen as $dokumen) {
                // Hapus prefix 'storage/' agar path-nya benar di dalam folder storage/app/public
                $filePath = str_replace('storage/', '', $dokumen->file_path);
                Storage::disk('public')->delete($filePath);
            }

            // Hapus record pembicara (record dokumen akan terhapus otomatis karena onDelete('cascade'))
            $pembicara->delete();

            DB::commit();

            return redirect()->route('pembicara.index')
                ->with('success', 'Data pembicara berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menghapus data pembicara: ' . $e->getMessage());
            return redirect()->route('pembicara.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    /**
     * Memperbarui data pembicara yang ada di database.
     */
    public function update(Request $request, Pembicara $pembicara)
    {
        $validator = Validator::make($request->all(), [
            'kegiatan' => 'required|string|max:255',
            'pegawai_id' => 'required|exists:pegawais,id',
            'kategori_pembicara' => 'required|string|max:255',
            'judul_makalah' => 'required|string|max:255',
            'nama_pertemuan' => 'required|string|max:255',
            'penyelenggara' => 'required|string|max:255',
            'tanggal_pelaksana' => 'required|date',
            'dokumen.*.file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx,txt|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $pembicara->update($request->except('dokumen', 'existing_dokumen', 'deleted_dokumen_ids', '_token', '_method'));

            if ($request->has('existing_dokumen')) {
                foreach ($request->existing_dokumen as $dokumenId => $dokumenData) {
                    $dokumenToUpdate = DokumenPembicara::find($dokumenId);
                    if ($dokumenToUpdate && $dokumenToUpdate->pembicara_id == $pembicara->id) {
                        $dokumenToUpdate->update($dokumenData);
                    }
                }
            }

            if ($request->filled('deleted_dokumen_ids')) {
                $deletedIds = explode(',', $request->deleted_dokumen_ids);
                $dokumenToDelete = $pembicara->dokumen()->whereIn('id', $deletedIds)->get();
                foreach ($dokumenToDelete as $doc) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $doc->file_path));
                    $doc->delete();
                }
            }
            
            if ($request->has('dokumen')) {
                foreach ($request->dokumen as $docData) {
                    if (isset($docData['file'])) {
                        $file = $docData['file'];
                        $path = $file->store('dokumen_pembicara', 'public');

                        $pembicara->dokumen()->create([
                            'jenis_dokumen' => $docData['jenis'],
                            'nama_dokumen' => $docData['nama'],
                            'nomor' => $docData['nomor'],
                            'tautan' => $docData['tautan'],
                            'file_path' => 'storage/' . $path,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('pembicara.index')
                ->with('success', 'Data pembicara berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui data pembicara: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())
                ->withInput();
        }
    }
}