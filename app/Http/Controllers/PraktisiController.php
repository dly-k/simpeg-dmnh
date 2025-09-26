<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Praktisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Tambahkan untuk logging error

class PraktisiController extends Controller
{
    /**
     * Menampilkan daftar praktisi dan data pegawai untuk form.
     */
    public function index()
    {
        $praktisis = Praktisi::with('pegawai')->latest()->paginate(10);
        $pegawais = Pegawai::where('status_pegawai', 'Aktif')->orderBy('nama_lengkap')->get();
        return view('pages.praktisi-dunia-industri', compact('praktisis', 'pegawais'));
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
            // Helper function untuk menyimpan file
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
        public function show(Praktisi $praktisi)
    {
        // Memuat relasi pegawai untuk mendapatkan nama lengkap
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
            // Helper function untuk mengelola upload file (hapus yang lama, simpan yang baru)
            $updateFile = function ($fileKey) use ($request, $praktisi, &$validatedData) {
                if ($request->hasFile($fileKey)) {
                    // 1. Hapus file lama jika ada
                    if ($praktisi->{$fileKey}) {
                        Storage::disk('public')->delete($praktisi->{$fileKey});
                    }
                    // 2. Simpan file baru
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
}