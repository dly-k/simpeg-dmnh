<?php

namespace App\Http\Controllers;

use App\Models\SertifikatKompetensi;
use App\Models\Pegawai;
use App\Exports\SertifikatKompetensiExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SertifikatKompetensiController extends Controller
{
    public function index(Request $request)
    {
        // Inisialisasi query dengan relasi pegawai
        $query = SertifikatKompetensi::with('pegawai');
        
        // Ambil data sertifikat + relasi pegawai, pakai pagination
        $sertifikatKompetensis = SertifikatKompetensi::with('pegawai')
            ->latest()
            ->paginate(10)
            ->appends($request->query()); 

        // Filter berdasarkan pencarian
        if ($request->filled('cari')) {
            $search = $request->cari;
            $query->where(function ($q) use ($search) {
                $q->where('kegiatan', 'like', "%{$search}%")
                  ->orWhere('judul_kegiatan', 'like', "%{$search}%")
                  ->orWhere('lembaga_sertifikasi', 'like', "%{$search}%")
                  ->orWhereHas('pegawai', function ($subq) use ($search) {
                      $subq->where('nama_lengkap', 'like', "%{$search}%");
                  });
            });
        }

        // Data pegawai aktif
        $pegawais = Pegawai::where('status_pegawai', 'Aktif')
            ->orderBy('nama_lengkap')
            ->get();

        // Ambil tahun unik untuk filter
        $tahunOptions = SertifikatKompetensi::selectRaw('DISTINCT tahun_sertifikasi')
            ->orderBy('tahun_sertifikasi', 'desc')
            ->pluck('tahun_sertifikasi');

        // Kirim ke view
        return view('pages.sertifikat-kompetensi', compact(
            'sertifikatKompetensis',
            'pegawais',
            'tahunOptions'
        ));
    }

    public function export(Request $request)
    {
        // ===============================
        // Inisialisasi query
        // ===============================
        $query = SertifikatKompetensi::with('pegawai');

        // ===============================
        // Filter berdasarkan pencarian
        // ===============================
        if ($request->filled('cari')) {
            $search = $request->cari;
            $query->where(function ($q) use ($search) {
                $q->where('kegiatan', 'like', "%{$search}%")
                    ->orWhere('judul_kegiatan', 'like', "%{$search}%")
                    ->orWhere('lembaga_sertifikasi', 'like', "%{$search}%")
                    ->orWhereHas('pegawai', function ($subq) use ($search) {
                        $subq->where('nama_lengkap', 'like', "%{$search}%");
                    });
            });
        }

        // ===============================
        // Filter berdasarkan tahun sertifikasi
        // ===============================
        $tahun = $request->filled('tahun') ? $request->tahun : null;
        if ($tahun) {
            $query->where('tahun_sertifikasi', $tahun);
        }

        // ===============================
        // Filter berdasarkan status verifikasi
        // ===============================
        $status = $request->filled('status') ? $request->status : null;
        if ($status) {
            $query->where('verifikasi', $status);
        }

        // ===============================
        // Ambil semua data hasil filter
        // ===============================
        $data = $query->get();

        // ===============================
        // Buat nama file dinamis
        // ===============================
        $filenameParts = ['Data_Sertifikat_Kompetensi'];

        if ($tahun) {
            $filenameParts[] = "Tahun_{$tahun}";
        }

        if ($status) {
            $filenameParts[] = preg_replace('/\s+/', '_', $status);
        }

        if ($request->filled('cari')) {
            $filenameParts[] = 'Cari_' . preg_replace('/[^A-Za-z0-9\-]/', '', $request->cari);
        }

        $filename = implode('_', $filenameParts) . '.xlsx';

        // ===============================
        // Eksekusi export pakai class SertifikatKompetensiExport
        // ===============================
        return Excel::download(
            new SertifikatKompetensiExport($data, $tahun, $status, $request->cari),
            $filename
        );
    }

public function store(Request $request)
{
    // 1. Validasi data yang masuk dari form
    $validatedData = $request->validate([
        'pegawai_id' => 'required|exists:pegawais,id',
        'kegiatan' => 'required|string|max:255',
        'judul_kegiatan' => 'required|string|max:255',
        'no_reg_pendidik' => 'nullable|string|max:255',
        'no_sk_sertifikasi' => 'required|string|max:255',
        'tahun_sertifikasi' => 'required|digits:4|integer',
        'tmt_sertifikasi' => 'required|date',
        'tst_sertifikasi' => 'nullable|date',
        'bidang_studi' => 'required|string|max:255',
        'lembaga_sertifikasi' => 'required|string|max:255',
        // ATURAN BARU: Wajib diisi JIKA lembaga_sertifikasi adalah 'lainnya'
        'lembaga_sertifikasi_lainnya' => 'required_if:lembaga_sertifikasi,lainnya|nullable|string|max:255',
        'dokumen' => 'nullable|file|mimes:pdf|max:5120',
    ], [
        // Pesan error kustom agar lebih jelas
        'lembaga_sertifikasi_lainnya.required_if' => 'Kolom ini wajib diisi jika Anda memilih "Lainnya".'
    ]);

    // 2. Jika user memilih 'lainnya', gunakan input dari 'lainnya'
    if ($request->lembaga_sertifikasi === 'lainnya') {
        $validatedData['lembaga_sertifikasi'] = $request->lembaga_sertifikasi_lainnya;
    }

    // 3. Handle upload file
    if ($request->hasFile('dokumen')) {
        $validatedData['dokumen'] = $request->file('dokumen')->store('dokumen_sertifikat_kompetensi', 'public');
    }

    // 4. Hapus field 'lainnya' dari array sebelum disimpan
    unset($validatedData['lembaga_sertifikasi_lainnya']);

    // 5. Buat record baru di database
    SertifikatKompetensi::create($validatedData);

    // 6. Redirect kembali dengan pesan sukses
    return redirect()->route('sertifikat-kompetensi.index')->with('success', 'Data berhasil ditambahkan!');
}

public function edit(SertifikatKompetensi $sertifikatKompetensi)
    {
        return response()->json($sertifikatKompetensi);
    }

    /**
     * Memperbarui data di database.
     */
    public function update(Request $request, SertifikatKompetensi $sertifikatKompetensi)
    {
        $validatedData = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'kegiatan' => 'required|string|max:255',
            'judul_kegiatan' => 'required|string|max:255',
            'no_reg_pendidik' => 'nullable|string|max:255',
            'no_sk_sertifikasi' => 'required|string|max:255',
            'tahun_sertifikasi' => 'required|digits:4|integer',
            'tmt_sertifikasi' => 'required|date',
            'tst_sertifikasi' => 'nullable|date',
            'bidang_studi' => 'required|string|max:255',
            'lembaga_sertifikasi' => 'required|string|max:255',
            'lembaga_sertifikasi_lainnya' => 'required_if:lembaga_sertifikasi,lainnya|nullable|string|max:255',
            'dokumen' => 'nullable|file|mimes:pdf|max:5120', // Hanya divalidasi jika ada file baru
        ]);

        if ($request->lembaga_sertifikasi === 'lainnya') {
            $validatedData['lembaga_sertifikasi'] = $request->lembaga_sertifikasi_lainnya;
        }

        if ($request->hasFile('dokumen')) {
            // Hapus file lama jika ada
            if ($sertifikatKompetensi->dokumen && Storage::disk('public')->exists($sertifikatKompetensi->dokumen)) {
                Storage::disk('public')->delete($sertifikatKompetensi->dokumen);
            }
            // Simpan file baru
            $validatedData['dokumen'] = $request->file('dokumen')->store('dokumen_sertifikat_kompetensi', 'public');
        }
        
        unset($validatedData['lembaga_sertifikasi_lainnya']);
        $sertifikatKompetensi->update($validatedData);

        return redirect()->route('sertifikat-kompetensi.index')->with('success', 'Data berhasil diperbarui!');
    }
    public function destroy(SertifikatKompetensi $sertifikatKompetensi)
{
    // 1. Hapus file dokumen dari storage jika ada
    if ($sertifikatKompetensi->dokumen && Storage::disk('public')->exists($sertifikatKompetensi->dokumen)) {
        Storage::disk('public')->delete($sertifikatKompetensi->dokumen);
    }

    // 2. Hapus data dari database
    $sertifikatKompetensi->delete();

    // 3. Redirect kembali dengan pesan sukses
    return redirect()->route('sertifikat-kompetensi.index')->with('success', 'Data berhasil dihapus!');
}
public function verifikasi(Request $request, SertifikatKompetensi $sertifikatKompetensi)
{
    // 1. Validasi input status
    $request->validate([
        'status' => 'required|in:Sudah Diverifikasi,Ditolak',
    ]);

    // 2. Update kolom verifikasi di database
    $sertifikatKompetensi->verifikasi = $request->status;
    $sertifikatKompetensi->save();

    // 3. Redirect kembali dengan pesan sukses
    return redirect()->route('sertifikat-kompetensi.index')->with('success', 'Status verifikasi berhasil diperbarui!');
}
}