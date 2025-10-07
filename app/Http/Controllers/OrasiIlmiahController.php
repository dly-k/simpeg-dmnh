<?php

namespace App\Http\Controllers;

use App\Models\OrasiIlmiah; // Tambahkan ini
use App\Models\Pegawai; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Tambahkan ini

class OrasiIlmiahController extends Controller
{
    public function index(Request $request)
    {
        $query = OrasiIlmiah::with('pegawai')->latest();

        $orasiIlmiahs = $query->paginate(10)->appends($request->query());

        $pegawais = Pegawai::where('status_pegawai', 'Aktif')->orderBy('nama_lengkap')->get();

        // --- Semester Options tetap sama ---
        $semesterOptions = [];
        $uniqueSemesters = [];

        foreach ($orasiIlmiahs as $item) {
            $tanggal = new \DateTime($item->tanggal_pelaksana);
            $bulan = (int)$tanggal->format('m');
            $tahun = $tanggal->format('Y');

            if ($bulan >= 1 && $bulan <= 6) {
                $semester = 'Ganjil';
                $key = "ganjil-{$tahun}";
            } else {
                $semester = 'Genap';
                $key = "genap-{$tahun}";
            }

            if (!in_array($key, $uniqueSemesters)) {
                $uniqueSemesters[] = $key;
                $semesterOptions[] = [
                    'value' => $key,
                    'text' => "Semester {$semester} {$tahun}"
                ];
            }
        }

        usort($semesterOptions, fn($a, $b) => $b['value'] <=> $a['value']);

        return view('pages.orasi-ilmiah', compact('orasiIlmiahs', 'pegawais', 'semesterOptions'));
    }

    public function export(Request $request)
    {
        // Inisialisasi query dengan relasi pegawai
        $query = OrasiIlmiah::with('pegawai');

        // ===============================
        // Filter berdasarkan search
        // ===============================
        if ($request->filled('cari')) {
            $search = $request->cari;
            $query->where(function ($q) use ($search) {
                $q->where('judul_makalah', 'like', "%{$search}%")
                ->orWhere('nama_pertemuan', 'like', "%{$search}%")
                ->orWhere('penyelenggara', 'like', "%{$search}%")
                ->orWhereHas('pegawai', function ($subq) use ($search) {
                    $subq->where('nama_lengkap', 'like', "%{$search}%");
                });
            });
        }

        // ===============================
        // Filter berdasarkan status
        // ===============================
        $status = $request->filled('status') ? $request->status : null;
        if ($status) {
            $query->where('verifikasi', $status);
        }

        // ===============================
        // Filter berdasarkan semester
        // ===============================
        $semester = null;
        if ($request->filled('semester')) {
            $rawSemester = trim($request->semester);

            // Normalisasi input semester
            $parts = preg_split('/[-_\s]+/', $rawSemester);
            $year = null;
            $stype = null;

            foreach ($parts as $p) {
                if (preg_match('/^\d{4}$/', $p)) $year = $p;
                if (in_array(strtolower($p), ['ganjil','genap'])) $stype = ucfirst(strtolower($p));
            }

            if ($year && $stype) {
                $semester = "{$stype} {$year}"; // Contoh: "Ganjil 2025"
            } elseif ($year) {
                $semester = $year; // Hanya tahun
            } else {
                $semester = $rawSemester; // Fallback
            }

            // Hitung range tanggal berdasarkan semester
            if (preg_match('/^\d{4}$/', $semester)) {
                $start = \Carbon\Carbon::create($semester, 1, 1)->startOfDay();
                $end = \Carbon\Carbon::create($semester, 12, 31)->endOfDay();
            } elseif (strpos($semester, 'Ganjil') !== false) {
                [$stype, $y] = explode(' ', $semester);
                $start = \Carbon\Carbon::create($y, 1, 1)->startOfDay();
                $end = \Carbon\Carbon::create($y, 6, 30)->endOfDay();
            } elseif (strpos($semester, 'Genap') !== false) {
                [$stype, $y] = explode(' ', $semester);
                $start = \Carbon\Carbon::create($y, 7, 1)->startOfDay();
                $end = \Carbon\Carbon::create($y, 12, 31)->endOfDay();
            } else {
                $start = $end = null;
            }

            if ($start && $end) {
                $query->whereBetween('tanggal_pelaksana', [$start, $end]);
            }
        }

        // Ambil data
        $data = $query->get();

        // ===============================
        // Buat nama file dinamis
        // ===============================
        $filenameParts = ['Data_Orasi_Ilmiah'];

        if ($semester) {
            $filenameParts[] = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $semester));
        }

        if ($status) {
            $filenameParts[] = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $status));
        }

        if ($request->filled('search')) {
            $filenameParts[] = '_(' . preg_replace('/[^A-Za-z0-9\-]/', '', $request->search) . ')';
        }

        $filename = implode('_', $filenameParts) . '.xlsx';

        // ===============================
        // Export file
        // ===============================
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\OrasiIlmiahExport($data, $semester, $status, $request->cari),
            $filename
        );
    }

    /**
     * Menyimpan data orasi ilmiah baru dari form.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'litabmas' => 'nullable|string|max:255',
            'kategori_pembicara' => 'required|string|max:255',
            'lingkup' => 'required|string|max:255',
            'judul_makalah' => 'required|string|max:255',
            'nama_pertemuan' => 'required|string|max:255',
            'penyelenggara' => 'required|string|max:255',
            'tanggal_pelaksana' => 'required|date',
            'bahasa' => 'nullable|string|max:255',
            'jenis_dokumen' => 'required|string|max:255',
            'dokumen' => 'nullable|file|mimes:pdf|max:5120', // Maksimal 5MB
            'nama_dokumen' => 'nullable|string|max:255',
            'nomor_dokumen' => 'nullable|string|max:255',
            'tautan_dokumen' => 'nullable|url|max:255',
        ]);

        // 2. Handle Upload File
        if ($request->hasFile('dokumen')) {
            $filePath = $request->file('dokumen')->store('dokumen_orasi_ilmiah', 'public');
            $validatedData['dokumen'] = $filePath;
        }

        // 3. Simpan data ke database
        OrasiIlmiah::create($validatedData);

        // 4. Redirect kembali dengan pesan sukses
        return redirect()->route('orasi-ilmiah.index')->with('success', 'Data Orasi Ilmiah berhasil ditambahkan!');
    }
    public function edit(OrasiIlmiah $orasiIlmiah)
    {
        // Mengembalikan data sebagai JSON response
        return response()->json($orasiIlmiah);
    }

    /**
     * Memperbarui data di database.
     */
    public function update(Request $request, OrasiIlmiah $orasiIlmiah)
    {
        // 1. Validasi (mirip dengan store, tapi beberapa aturan disesuaikan)
        $validatedData = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'litabmas' => 'nullable|string|max:255',
            'kategori_pembicara' => 'required|string|max:255',
            'lingkup' => 'required|string|max:255',
            'judul_makalah' => 'required|string|max:255',
            'nama_pertemuan' => 'required|string|max:255',
            'penyelenggara' => 'required|string|max:255',
            'tanggal_pelaksana' => 'required|date',
            'bahasa' => 'nullable|string|max:255',
            'jenis_dokumen' => 'required|string|max:255',
            'dokumen' => 'nullable|file|mimes:pdf|max:5120', // Hanya validasi jika ada file baru
            'nama_dokumen' => 'nullable|string|max:255',
            'nomor_dokumen' => 'nullable|string|max:255',
            'tautan_dokumen' => 'nullable|url|max:255',
        ]);

        // 2. Handle upload file baru (jika ada)
        if ($request->hasFile('dokumen')) {
            // Hapus file lama jika ada
            if ($orasiIlmiah->dokumen && Storage::disk('public')->exists($orasiIlmiah->dokumen)) {
                Storage::disk('public')->delete($orasiIlmiah->dokumen);
            }
            // Simpan file baru
            $filePath = $request->file('dokumen')->store('dokumen_orasi_ilmiah', 'public');
            $validatedData['dokumen'] = $filePath;
        }

        // 3. Update data di database
        $orasiIlmiah->update($validatedData);

        // 4. Redirect dengan pesan sukses
        return redirect()->route('orasi-ilmiah.index')->with('success', 'Data Orasi Ilmiah berhasil diperbarui!');
    }
    public function destroy(OrasiIlmiah $orasiIlmiah)
    {
        // 1. Hapus file dokumen terkait dari storage jika ada
        if ($orasiIlmiah->dokumen && Storage::disk('public')->exists($orasiIlmiah->dokumen)) {
            Storage::disk('public')->delete($orasiIlmiah->dokumen);
        }

        // 2. Hapus data dari database
        $orasiIlmiah->delete();

        // 3. Redirect kembali dengan pesan sukses
        return redirect()->route('orasi-ilmiah.index')->with('success', 'Data Orasi Ilmiah berhasil dihapus!');
    }
        public function verifikasi(Request $request, OrasiIlmiah $orasiIlmiah)
    {
        // 1. Validasi input status
        $request->validate([
            'status' => 'required|in:Sudah Diverifikasi,Ditolak',
        ]);

        // 2. Update kolom verifikasi
        $orasiIlmiah->verifikasi = $request->status;
        $orasiIlmiah->save();

        // 3. Redirect kembali dengan pesan sukses
        return redirect()->route('orasi-ilmiah.index')->with('success', 'Status verifikasi berhasil diperbarui!');
    }
}