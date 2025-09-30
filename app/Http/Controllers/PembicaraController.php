<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pembicara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PembicaraController extends Controller
{
    public function index()
    {
        $pembicaras = Pembicara::with('pegawai', 'dokumen')->latest()->get();
        
        $pegawais = Pegawai::where('status_pegawai', 'Aktif')
                          ->orderBy('nama_lengkap', 'asc')
                          ->get(['id', 'nama_lengkap']);

        return view('pages.pembicara', compact('pembicaras', 'pegawais'));
    }

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
            'dokumen.*.jenis' => 'nullable|string',
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

                        // [PERBAIKAN] Menggunakan metode store() sesuai saran Anda.
                        // Laravel akan membuat nama file unik secara otomatis.
                        // Nama folder di sini adalah 'dokumen_pembicara'.
                        $path = $file->store('dokumen_pembicara', 'public');

                        $pembicara->dokumen()->create([
                            'jenis_dokumen' => $docData['jenis'],
                            'nama_dokumen' => $docData['nama'],
                            'nomor' => $docData['nomor'],
                            'tautan' => $docData['tautan'],
                            // Simpan path yang dikembalikan oleh store() ke database.
                            // Kita tambahkan 'storage/' di depan agar URL-nya benar.
                            'file_path' => 'storage/' . $path,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('pembicara.index')
                ->with('success', 'Data pembicara berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan data pembicara: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data.')
                ->withInput();
        }
    }
}