<?php

namespace App\Http\Controllers;

use App\Models\Pegawai; // Tambahkan ini
use App\Models\PengelolaJurnal; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Tambahkan ini
use Illuminate\Support\Facades\Log; // Tambahkan ini
use Illuminate\Support\Facades\Validator; // Tambahkan ini


class PengelolaJurnalController extends Controller
{
    public function index()
    {
        // 1. Ambil data pegawai aktif untuk dropdown (sudah ada)
        $pegawais = Pegawai::where('status_pegawai', 'Aktif')
                           ->select('id', 'nama_lengkap')
                           ->orderBy('nama_lengkap', 'asc')
                           ->get();

        // 2. [TAMBAHAN] Ambil data pengelola jurnal untuk ditampilkan di tabel
        //    Gunakan 'with('pegawai')' untuk Eager Loading agar lebih efisien
        $pengelolaJurnals = PengelolaJurnal::with('pegawai', 'dokumen')->latest()->paginate(10);

        // 3. Kirim kedua data tersebut ke view
        return view('pages.pengelola-jurnal', compact('pegawais', 'pengelolaJurnals'));
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
}