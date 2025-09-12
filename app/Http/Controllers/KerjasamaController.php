<?php

namespace App\Http\Controllers;

use App\Models\Kerjasama;
use App\Models\KerjasamaTim;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreKerjasamaRequest;
use App\Http\Requests\UpdateKerjasamaRequest;
use App\Exports\KerjasamaExport;
use Maatwebsite\Excel\Facades\Excel;

class KerjasamaController extends Controller
{
    /**
     * Menampilkan daftar kerjasama (index + export Excel)
     */
    public function index()
    {
        $query = Kerjasama::with('tim')
            ->when(request('search'), function ($query) {
                $query->where('judul', 'like', '%' . request('search') . '%')
                      ->orWhere('mitra', 'like', '%' . request('search') . '%');
            })
            ->when(request('jenis') && request('jenis') !== 'Semua', function ($query) {
                $query->where('jenis_kerjasama', request('jenis'));
            })
            ->latest();

        // 👉 Export Excel langsung dari index
        if (request()->has('export') && request('export') === 'excel') {
            return Excel::download(
                new KerjasamaExport(request('search'), request('jenis')),
                'data_kerjasama.xlsx'
            );
        }

        $kerjasama = $query->paginate(10);

        return view('pages.kerjasama', compact('kerjasama'));
    }

    /**
     * Form tambah kerjasama
     */
    public function create()
    {
        return view('components.kerjasama.tambah-kerjasama');
    }

    /**
     * Simpan data kerjasama
     */
    public function store(StoreKerjasamaRequest $request)
    {
        $data = $request->validated();

        // Upload file kalau ada
        if ($request->hasFile('file_dokumen')) {
            $data['file_dokumen'] = $request->file('file_dokumen')->store('dokumen', 'public');
        }

        if ($request->hasFile('file_laporan')) {
            $data['file_laporan'] = $request->file('file_laporan')->store('laporan', 'public');
        }

        // Simpan kerjasama
        $kerjasama = Kerjasama::create($data);

        // Simpan ketua
        if (!empty($data['ketua'])) {
            foreach ($data['ketua'] as $ketua) {
                $ketua['jabatan'] = 'ketua';
                $ketua['kerjasama_id'] = $kerjasama->id;
                KerjasamaTim::create($ketua);
            }
        }

        // Simpan anggota
        if (!empty($data['anggota'])) {
            foreach ($data['anggota'] as $anggota) {
                $anggota['jabatan'] = 'anggota';
                $anggota['kerjasama_id'] = $kerjasama->id;
                KerjasamaTim::create($anggota);
            }
        }

        return redirect()->route('kerjasama.index')
            ->with('success', 'Data kerjasama berhasil ditambahkan');
    }

    /**
     * Tampilkan detail kerjasama (JSON)
     */
    public function show($id)
    {
        $kerjasama = Kerjasama::with('tim')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $kerjasama
        ]);
    }

    /**
     * Form edit kerjasama
     */
    public function edit(Kerjasama $kerjasama)
    {
        $kerjasama->load('tim');
        return view('components.kerjasama.edit-kerjasama', compact('kerjasama'));
    }

    /**
     * Update data kerjasama
     */
    public function update(UpdateKerjasamaRequest $request, Kerjasama $kerjasama)
    {
        $data = $request->validated();

        // Upload file baru kalau ada
        if ($request->hasFile('file_dokumen')) {
            if ($kerjasama->file_dokumen) {
                Storage::disk('public')->delete($kerjasama->file_dokumen);
            }
            $data['file_dokumen'] = $request->file('file_dokumen')->store('dokumen', 'public');
        }

        if ($request->hasFile('file_laporan')) {
            if ($kerjasama->file_laporan) {
                Storage::disk('public')->delete($kerjasama->file_laporan);
            }
            $data['file_laporan'] = $request->file('file_laporan')->store('laporan', 'public');
        }

        // Update kerjasama
        $kerjasama->update($data);

        // Reset tim lama & simpan ulang
        $kerjasama->tim()->delete();

        // Ketua
        if (!empty($data['ketua'])) {
            foreach ($data['ketua'] as $ketua) {
                $ketua['jabatan'] = 'ketua';
                $ketua['kerjasama_id'] = $kerjasama->id;
                KerjasamaTim::create($ketua);
            }
        }

        // Anggota
        if (!empty($data['anggota'])) {
            foreach ($data['anggota'] as $anggota) {
                $anggota['jabatan'] = 'anggota';
                $anggota['kerjasama_id'] = $kerjasama->id;
                KerjasamaTim::create($anggota);
            }
        }

        return redirect()->route('kerjasama.index')
            ->with('success', 'Data kerjasama berhasil diperbarui');
    }

    /**
     * Hapus kerjasama
     */
    public function destroy(Kerjasama $kerjasama)
    {
        // Hapus file dari storage
        if ($kerjasama->file_dokumen) {
            Storage::disk('public')->delete($kerjasama->file_dokumen);
        }
        if ($kerjasama->file_laporan) {
            Storage::disk('public')->delete($kerjasama->file_laporan);
        }

        // Hapus tim & kerjasama
        $kerjasama->tim()->delete();
        $kerjasama->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}