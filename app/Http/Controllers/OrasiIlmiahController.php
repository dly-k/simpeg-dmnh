<?php

namespace App\Http\Controllers;

use App\Models\OrasiIlmiah; // Tambahkan ini
use App\Models\Pegawai; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Tambahkan ini

class OrasiIlmiahController extends Controller
{
    /**
     * Menampilkan halaman daftar orasi ilmiah beserta data yang dibutuhkan.
     */
    public function index()
    {
        // Ambil semua data orasi ilmiah, eager loading relasi pegawai untuk efisiensi
        $orasiIlmiahs = OrasiIlmiah::with('pegawai')->latest()->get();

        // Ambil data pegawai yang statusnya 'Aktif' untuk dropdown
        $pegawais = Pegawai::where('status_pegawai', 'Aktif')->orderBy('nama_lengkap')->get();

        // Kirim data ke view
        return view('pages.orasi-ilmiah', compact('orasiIlmiahs', 'pegawais'));
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
}