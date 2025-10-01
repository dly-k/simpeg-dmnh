<?php

namespace App\Http\Controllers;

use App\Models\SertifikatKompetensi;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SertifikatKompetensiController extends Controller
{
    public function index()
    {
        // Ambil semua data sertifikat dan pegawai aktif
        $sertifikatKompetensis = SertifikatKompetensi::with('pegawai')->latest()->get();
        $pegawais = Pegawai::where('status_pegawai', 'Aktif')->orderBy('nama_lengkap')->get();

        return view('pages.sertifikat-kompetensi', compact('sertifikatKompetensis', 'pegawais'));
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
}