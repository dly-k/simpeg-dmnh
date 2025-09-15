<?php

namespace App\Http\Controllers;

use App\Models\Pegawai; // <-- Diimpor
use App\Models\SuratTugas;
use Illuminate\Http\Request;
use App\Exports\SuratTugasExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreSuratTugasRequest;
use App\Http\Requests\UpdateSuratTugasRequest;

class SuratTugasController extends Controller
{
    /**
     * Tampilkan daftar surat tugas.
     */
    public function index(Request $request)
    {
        $query = SuratTugas::query();

        // Filter search
        if ($request->filled('q')) {
            $query->where('nama_dosen', 'like', '%' . $request->q . '%');
        }

        // Filter semester otomatis
        if ($request->filled('semester')) {
            [$tahun, $tipe] = explode('-', $request->semester); // contoh: 2023-genap
            $range = $tipe === 'genap'
                ? ["{$tahun}-01-01", "{$tahun}-06-30"]
                : ["{$tahun}-07-01", "{$tahun}-12-31"];

            $query->whereBetween('tgl_kegiatan', $range);
        }

        $data = $query->latest()->paginate(10);

        // Generate daftar semester unik dari data tgl_kegiatan
        $semesters = SuratTugas::selectRaw('YEAR(tgl_kegiatan) as tahun, MONTH(tgl_kegiatan) as bulan')
            ->whereNotNull('tgl_kegiatan')
            ->get()
            ->map(fn($item) => [
                'tahun' => $item->tahun,
                'tipe'  => $item->bulan <= 6 ? 'genap' : 'ganjil',
            ])
            ->unique(fn($s) => $s['tahun'].'-'.$s['tipe'])
            ->sortByDesc(fn($s) => $s['tahun'])
            ->values();

        // Ambil data pegawai untuk dropdown
        $pegawais = Pegawai::orderBy('nama_lengkap')->get();

        // Kirim semua data yang diperlukan ke view
        return view('pages.surat-tugas.index', compact('data', 'semesters', 'pegawais'));
    }

    /**
     * Export data ke Excel.
     */
    public function export(Request $request)
    {
        $query = SuratTugas::query();

        // Apply filter search
        if ($request->filled('q')) {
            $query->where('nama_dosen', 'like', '%' . $request->q . '%');
        }

        // Apply filter semester
        $semester = null;
        if ($request->filled('semester')) {
            [$tahun, $tipe] = explode('-', $request->semester);
            $semester = $tipe . '_' . $tahun;

            if ($tipe === 'genap') {
                $query->whereBetween('tgl_kegiatan', [
                    "{$tahun}-01-01",
                    "{$tahun}-06-30"
                ]);
            } else {
                $query->whereBetween('tgl_kegiatan', [
                    "{$tahun}-07-01",
                    "{$tahun}-12-31"
                ]);
            }
        }

        $data = $query->get();

        // Format nama file
        $filename = 'surat_tugas';
        if ($semester) {
            $filename .= '_' . $semester;
        }
        if ($request->filled('q')) {
            $filename .= ' (' . $request->q . ')';
        }
        $filename .= '.xlsx';

        // Export pakai Laravel Excel + kirim semester
        return Excel::download(new SuratTugasExport($data, $semester), $filename);
    }

    /**
     * Simpan data surat tugas baru.
     */
    public function store(StoreSuratTugasRequest $request)
    {
        $input = $request->validated();
        // Upload dokumen jika ada
        if ($request->hasFile('dokumen')) {
            $input['dokumen'] = $request->file('dokumen')->store('dokumen', 'public');
        }

        SuratTugas::create($input);

        return redirect()
            ->route('surat-tugas.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Update data surat tugas.
     */
    public function update(UpdateSuratTugasRequest $request, $id)
    {
        $surat = SuratTugas::findOrFail($id);
        $input = $request->validated();

        if ($request->hasFile('dokumen')) {
            if ($surat->dokumen && Storage::disk('public')->exists($surat->dokumen)) {
                Storage::disk('public')->delete($surat->dokumen);
            }
            $input['dokumen'] = $request->file('dokumen')->store('dokumen', 'public');
        }

        $surat->update($input);

        return redirect()
            ->route('surat-tugas.index')
            ->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Hapus data surat tugas beserta dokumen terkait.
     */
    public function destroy($id)
    {
        $surat = SuratTugas::find($id);

        if (!$surat) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        // Kalau ada dokumen, hapus juga file dari storage
        if ($surat->dokumen && Storage::disk('public')->exists($surat->dokumen)) {
            Storage::disk('public')->delete($surat->dokumen);
        }

        $surat->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus.'
        ]);
    }
}