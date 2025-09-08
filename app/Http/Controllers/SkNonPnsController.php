<?php

namespace App\Http\Controllers;

use App\Models\SkNonPns;
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
        $query = SkNonPns::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pegawai', 'like', "%{$search}%")
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

        return view('pages.sk-non-pns', compact('skData', 'years'));
    }
    
    /**
     * Menyimpan data SK Non PNS yang baru.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
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
            SkNonPns::create([
                'nama_pegawai' => $validatedData['nama_pegawai'],
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
        return response()->json($skNonPn);
    }

    /**
     * Memperbarui data SK Non PNS yang ada.
     */
    public function update(Request $request, SkNonPns $skNonPn)
    {
        $validatedData = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
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
                Storage::delete($skNonPn->dokumen_path);
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
                Storage::delete($skNonPn->dokumen_path);
            }
            $skNonPn->delete();
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus data.'], 500);
        }
    }
}