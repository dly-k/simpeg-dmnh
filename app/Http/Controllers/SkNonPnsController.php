<?php

namespace App\Http\Controllers;

use App\Models\SkNonPns;
use App\Models\Pegawai; // <-- 1. TAMBAHKAN MODEL PEGAWAI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SkNonPnsController extends Controller
{
    /**
     * Menampilkan halaman utama dengan data SK Non PNS.
     */
    public function index(Request $request)
    {
        // PERUBAHAN: Gunakan eager loading 'pegawai' untuk efisiensi
        $query = SkNonPns::with('pegawai');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                // PERUBAHAN: Cari berdasarkan relasi ke tabel pegawai
                $q->whereHas('pegawai', function ($subQuery) use ($search) {
                    $subQuery->where('nama_lengkap', 'like', "%{$search}%");
                })
                ->orWhere('nama_unit', 'like', "%{$search}%")
                ->orWhere('nomor_sk', 'like', "%{$search}%");
            });
        }

        // Filter Tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_sk', $request->tahun);
        }

        // Data utama
        $skData = $query->orderBy('tanggal_sk', 'desc')->paginate(10);
        $skData->appends($request->all());

        // Ambil tahun unik untuk dropdown
        $years = SkNonPns::selectRaw('YEAR(tanggal_sk) as year')
                    ->distinct()
                    ->orderByDesc('year')
                    ->pluck('year');
        
        // <-- 2. AMBIL SEMUA DATA PEGAWAI UNTUK DIKIRIM KE VIEW
        $pegawai = Pegawai::orderBy('nama_lengkap', 'asc')->get();

        // <-- 3. KIRIM VARIABEL $pegawai KE VIEW
        return view('pages.sk-non-pns', compact('skData', 'years', 'pegawai'));
    }
    
    /**
     * Menyimpan data SK Non PNS yang baru.
     */
    public function store(Request $request)
    {
        // PERUBAHAN VALIDASI: dari 'nama_pegawai' menjadi 'pegawai_id'
        $validatedData = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'nama_unit' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'nomor_sk' => 'required|string|max:255|unique:sk_non_pns,nomor_sk',
            'tanggal_sk' => 'required|date',
            'jenis_sk' => 'required|string',
            'dokumen_sk' => 'required|file|mimes:pdf|max:5120',
        ]);

        $filePath = $request->file('dokumen_sk')->store('dokumen_sk', 'public');

        try {
            // PERUBAHAN PENYIMPANAN: dari 'nama_pegawai' menjadi 'pegawai_id'
            SkNonPns::create([
                'pegawai_id' => $validatedData['pegawai_id'],
                'nama_unit' => $validatedData['nama_unit'],
                'tanggal_mulai' => $validatedData['tanggal_mulai'],
                'tanggal_selesai' => $validatedData['tanggal_selesai'],
                'nomor_sk' => $validatedData['nomor_sk'],
                'tanggal_sk' => $validatedData['tanggal_sk'],
                'jenis_sk' => $validatedData['jenis_sk'],
                'dokumen_path' => $filePath,
            ]);

            return redirect()->route('sk-non-pns.index')->with('success', 'Data SK Non PNS berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.')->withInput();
        }
    }

    /**
     * Mengambil satu data SK untuk ditampilkan di form edit.
     */
    public function edit(SkNonPns $skNonPn)
    {
        // PERUBAHAN: Sertakan data relasi pegawai
        $skNonPn->load('pegawai');
        return response()->json($skNonPn);
    }

    /**
     * Memperbarui data SK Non PNS yang ada.
     */
    public function update(Request $request, SkNonPns $skNonPn)
    {
        // PERUBAHAN VALIDASI: dari 'nama_pegawai' menjadi 'pegawai_id'
        $validatedData = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'nama_unit' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'nomor_sk' => ['required', 'string', 'max:255', Rule::unique('sk_non_pns')->ignore($skNonPn->id)],
            'tanggal_sk' => 'required|date',
            'jenis_sk' => 'required|string',
            'dokumen_sk' => 'nullable|file|mimes:pdf|max:5120', 
        ]);

        if ($request->hasFile('dokumen_sk')) {
            if ($skNonPn->dokumen_path) {
                Storage::disk('public')->delete($skNonPn->dokumen_path);
            }
            $validatedData['dokumen_path'] = $request->file('dokumen_sk')->store('dokumen_sk', 'public');
        }

        $skNonPn->update($validatedData);

        return redirect()->route('sk-non-pns.index')->with('success', 'Data SK Non PNS berhasil diperbarui!');
    }

    /**
     * Menghapus data SK Non PNS.
     */
    public function destroy(SkNonPns $skNonPn)
    {
        try {
            if ($skNonPn->dokumen_path) {
                Storage::disk('public')->delete($skNonPn->dokumen_path);
            }
            $skNonPn->delete();
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus data.'], 500);
        }
    }
}