<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Praktisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon; // <-- Pastikan ini ditambahkan

class PraktisiController extends Controller
{
    /**
     * =================================================================
     * METHOD INDEX (DIPERBARUI)
     * Menampilkan daftar praktisi dengan fungsionalitas filter dan pencarian.
     * =================================================================
     */
    public function index(Request $request)
    {
        // 1. Membuat daftar Opsi Semester Dinamis
        $semesterOptions = [];
        $minDate = Praktisi::min('tmt');
        $maxDate = Praktisi::max('tst');

        if ($minDate && $maxDate) {
            $startYear = Carbon::parse($minDate)->year;
            $endYear = Carbon::parse($maxDate)->year;

            for ($year = $startYear; $year <= $endYear; $year++) {
                // Semester Ganjil (Januari - Juni)
                $semesterOptions[$year . '-ganjil'] = $year . '/Ganjil';
                // Semester Genap (Juli - Desember)
                $semesterOptions[$year . '-genap'] = $year . '/Genap';
            }
        }

        // 2. Query Builder untuk Filter
        $query = Praktisi::query()->with('pegawai');

        // Filter berdasarkan Pencarian (Nama Pegawai atau Institusi)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('instansi', 'like', "%{$searchTerm}%")
                  ->orWhereHas('pegawai', function ($subQ) use ($searchTerm) {
                      $subQ->where('nama_lengkap', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // Filter berdasarkan Status Verifikasi
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan Semester
        if ($request->filled('semester')) {
            [$year, $semesterType] = explode('-', $request->semester);

            if ($semesterType == 'ganjil') {
                $startMonth = 1; // Januari
                $endMonth = 6;   // Juni
            } else { // genap
                $startMonth = 7; // Juli
                $endMonth = 12;  // Desember
            }

            $semesterStartDate = Carbon::create($year, $startMonth, 1)->startOfDay();
            $semesterEndDate = Carbon::create($year, $endMonth, 1)->endOfMonth()->endOfDay();

            // Logika overlap: rentang waktu praktisi bersinggungan dengan rentang semester
            $query->where(function($q) use ($semesterStartDate, $semesterEndDate) {
                $q->where('tmt', '<=', $semesterEndDate)
                  ->where('tst', '>=', $semesterStartDate);
            });
        }

        // 3. Ambil data dengan paginasi dan sertakan query string filter
        $praktisis = $query->latest()->paginate(10)->withQueryString();
        
        $pegawais = Pegawai::where('status_pegawai', 'Aktif')->orderBy('nama_lengkap')->get();

        return view('pages.praktisi-dunia-industri', compact('praktisis', 'pegawais', 'semesterOptions'));
    }

    public function export(Request $request)
    {
        $query = Praktisi::with('pegawai');

        // Filter search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('instansi', 'like', '%' . $request->search . '%')
                ->orWhereHas('pegawai', function ($subq) use ($request) {
                    $subq->where('nama_lengkap', 'like', '%' . $request->search . '%');
                });
            });
        }

        // Filter status
        $status = null;
        if ($request->filled('status')) {
            $status = $request->status;
            $query->where('status', $status);
        }

        // Filter semester
        $semester = null;
        if ($request->filled('semester')) {
            $semester = $request->semester;
            [$year, $semesterType] = explode('-', $semester);

            if ($semesterType == 'ganjil') {
                $startMonth = 1;
                $endMonth   = 6;
            } else {
                $startMonth = 7;
                $endMonth   = 12;
            }

            $semesterStartDate = \Carbon\Carbon::create($year, $startMonth, 1)->startOfDay();
            $semesterEndDate   = \Carbon\Carbon::create($year, $endMonth, 1)->endOfMonth()->endOfDay();

            $query->where(function ($q) use ($semesterStartDate, $semesterEndDate) {
                $q->where('tmt', '<=', $semesterEndDate)
                ->where('tst', '>=', $semesterStartDate);
            });
        }

        // Ambil data setelah filter
        $data = $query->get();

        // Buat nama file dinamis
        $filename = 'Data_Praktisi';
        if ($semester) {
            $filename .= '_' . $semester;
        }
        if ($status) {
            $filename .= '_' . preg_replace('/[^A-Za-z0-9\-]/', '', $status);
        }
        if ($request->filled('search')) {
            $filename .= '_(' . preg_replace('/[^A-Za-z0-9\-]/', '', $request->search) . ')';
        }
        $filename .= '.xlsx';

        // Export ke Excel
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\PraktisiExport($data, $semester, $status, $request->search),
            $filename
        );
    }

    /**
     * Menyimpan data praktisi baru.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'bidang_usaha' => 'required|string|max:255',
            'jenis_pekerjaan' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'instansi' => 'required|string|max:255',
            'divisi' => 'nullable|string|max:255',
            'deskripsi_kerja' => 'nullable|string',
            'tmt' => 'required|date',
            'tst' => 'required|date',
            'area_pekerjaan' => 'required|string|max:255',
            'kategori_pekerjaan' => 'required|string|max:255',
            'surat_ipb' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx,txt|max:2048',
            'surat_instansi' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx,txt|max:2048',
            'cv' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx,txt|max:2048',
            'profil_perusahaan' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx,txt|max:2048',
        ]);

        try {
            $storeFile = function ($fileKey) use ($request, &$validatedData) {
                if ($request->hasFile($fileKey)) {
                    $path = $request->file($fileKey)->store('dokumen_praktisi', 'public');
                    $validatedData[$fileKey] = $path;
                }
            };

            $storeFile('surat_ipb');
            $storeFile('surat_instansi');
            $storeFile('cv');
            $storeFile('profil_perusahaan');

            Praktisi::create($validatedData);

            return redirect()->route('praktisi.index')->with('success', 'Data praktisi berhasil ditambahkan!');

        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data praktisi: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.')->withInput();
        }
    }

    /**
     * Menampilkan data spesifik untuk modal edit/detail.
     */
    public function show(Praktisi $praktisi)
    {
        $praktisi->load('pegawai');
        return response()->json($praktisi);
    }

    /**
     * Memperbarui data praktisi yang sudah ada.
     */
    public function update(Request $request, Praktisi $praktisi)
    {
        $validatedData = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'bidang_usaha' => 'required|string|max:255',
            'jenis_pekerjaan' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'instansi' => 'required|string|max:255',
            'divisi' => 'nullable|string|max:255',
            'deskripsi_kerja' => 'nullable|string',
            'tmt' => 'required|date',
            'tst' => 'required|date',
            'area_pekerjaan' => 'required|string|max:255',
            'kategori_pekerjaan' => 'required|string|max:255',
            'surat_ipb' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx,txt|max:2048',
            'surat_instansi' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx,txt|max:2048',
            'cv' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx,txt|max:2048',
            'profil_perusahaan' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx,txt|max:2048',
        ]);

        try {
            $updateFile = function ($fileKey) use ($request, $praktisi, &$validatedData) {
                if ($request->hasFile($fileKey)) {
                    if ($praktisi->{$fileKey}) {
                        Storage::disk('public')->delete($praktisi->{$fileKey});
                    }
                    $path = $request->file($fileKey)->store('dokumen_praktisi', 'public');
                    $validatedData[$fileKey] = $path;
                }
            };

            $updateFile('surat_ipb');
            $updateFile('surat_instansi');
            $updateFile('cv');
            $updateFile('profil_perusahaan');

            $praktisi->update($validatedData);

            return redirect()->route('praktisi.index')->with('success', 'Data praktisi berhasil diperbarui!');

        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data praktisi: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data. Silakan coba lagi.');
        }
    }

    /**
     * Menghapus data praktisi.
     */
    public function destroy(Praktisi $praktisi)
    {
        try {
            $filesToDelete = [
                $praktisi->surat_ipb,
                $praktisi->surat_instansi,
                $praktisi->cv,
                $praktisi->profil_perusahaan,
            ];

            foreach ($filesToDelete as $file) {
                if ($file && Storage::disk('public')->exists($file)) {
                    Storage::disk('public')->delete($file);
                }
            }

            $praktisi->delete();

            return redirect()->route('praktisi.index')->with('success', 'Data berhasil dihapus!');

        } catch (\Exception $e) {
            Log::error('Gagal menghapus data praktisi: ' . $e->getMessage());
            // Mengembalikan redirect dengan pesan error jika gagal
            return back()->with('error', 'Gagal menghapus data.');
        }
    }

    /**
     * Memperbarui status verifikasi data.
     */
    public function verify(Request $request, Praktisi $praktisi)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:Sudah Diverifikasi,Ditolak',
        ]);

        try {
            $praktisi->update(['status' => $validated['status']]);
            return redirect()->route('praktisi.index')->with('success', 'Status data berhasil diperbarui!');

        } catch (\Exception $e) {
            Log::error('Gagal memverifikasi data praktisi: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui status data.');
        }
    }
}