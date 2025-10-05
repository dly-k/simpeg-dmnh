<?php

namespace App\Http\Controllers;

use App\Models\Penghargaan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Exports\PenghargaanExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PenghargaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Penghargaan::with('pegawai')->orderBy('tanggal_perolehan', 'desc');

        // Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('pegawai', function ($subQuery) use ($search) {
                    $subQuery->where('nama_lengkap', 'like', "%{$search}%");
                })
                ->orWhere('nama_penghargaan', 'like', "%{$search}%")
                ->orWhere('nomor_sk', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_perolehan', $request->tahun);
        }
        if ($request->filled('lingkup')) {
            $query->where('lingkup', $request->lingkup);
        }
        if ($request->filled('pegawai')) {
            $query->where('pegawai_id', $request->pegawai);
        }

        $dataPenghargaan = $query->paginate(10)->appends($request->all());

        $listTahun = Penghargaan::selectRaw('YEAR(tanggal_perolehan) as tahun')
                        ->distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        
        $pegawai = Pegawai::where('status_pegawai', 'Aktif')->orderBy('nama_lengkap')->get();

        return view('pages.penghargaan', compact('dataPenghargaan', 'listTahun', 'pegawai'));
    }

    
    public function export(Request $request)
    {
        $query = Penghargaan::with('pegawai');

        // Filter search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('kegiatan', 'like', '%' . $request->search . '%')
                ->orWhere('nama_penghargaan', 'like', '%' . $request->search . '%')
                ->orWhereHas('pegawai', function ($subq) use ($request) {
                    $subq->where('nama_lengkap', 'like', '%' . $request->search . '%');
                });
            });
        }

        // Filter tahun
        $tahun = null;
        if ($request->filled('tahun')) {
            $tahun = $request->tahun;
            $query->whereYear('tanggal_perolehan', $tahun);
        }

        // Filter lingkup
        $lingkup = null;
        if ($request->filled('lingkup')) {
            $lingkup = $request->lingkup;
            $query->where('lingkup', $lingkup);
        }

        // Ambil data setelah filter (boleh kosong, tetap diexport)
        $data = $query->get();

        // Buat nama file dinamis
        $filename = 'Data_Penghargaan';
        if ($tahun) {
            $filename .= "_{$tahun}";
        }
        if ($lingkup) {
            $filename .= '_' . preg_replace('/[^A-Za-z0-9\-]/', '', $lingkup);
        }
        if ($request->filled('search')) {
            $filename .= '_(' . preg_replace('/[^A-Za-z0-9\-]/', '', $request->search) . ')';
        }
        $filename .= '.xlsx';

        // Export (walaupun data kosong tetap export header)
        return Excel::download(new PenghargaanExport($data, $tahun, $lingkup, $request->search), $filename);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pegawai_id'       => 'required|exists:pegawais,id',
            'kegiatan'         => 'required|string|max:255',
            'nama_penghargaan' => 'required|string|max:255',
            'nomor_sk'         => 'required|string|max:100',
            'tanggal_perolehan'=> 'required|date',
            'lingkup'          => 'required|string|max:50',
            'negara'           => 'required|string|max:100',
            'instansi_pemberi' => 'required|string|max:255',
            'jenis_dokumen'    => 'required|string|max:100',
            'dokumen'          => 'required|file|mimes:pdf|max:5120',
            'nama_dokumen'     => 'required|string|max:255',
            'nomor_dokumen'    => 'nullable|string|max:100',
            'tautan'           => 'nullable|url|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $validatedData = $validator->validated();
            $filePath = $request->file('dokumen')->store('dokumen_penghargaan', 'public');
            $validatedData['file_path'] = $filePath;

            Penghargaan::create($validatedData);

            return response()->json(['success' => 'Data penghargaan berhasil disimpan!']);
        } catch (\Exception $e) {
            Log::error('Error saving penghargaan: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat menyimpan data.'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $penghargaan = Penghargaan::findOrFail($id);
            return response()->json($penghargaan);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data tidak ditemukan.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pegawai_id'       => 'required|exists:pegawais,id',
            'kegiatan'         => 'required|string|max:255',
            'nama_penghargaan' => 'required|string|max:255',
            'nomor_sk'         => 'required|string|max:100',
            'tanggal_perolehan'=> 'required|date',
            'lingkup'          => 'required|string|max:50',
            'negara'           => 'required|string|max:100',
            'instansi_pemberi' => 'required|string|max:255',
            'jenis_dokumen'    => 'required|string|max:100',
            'dokumen'          => 'nullable|file|mimes:pdf|max:5120',
            'nama_dokumen'     => 'required|string|max:255',
            'nomor_dokumen'    => 'nullable|string|max:100',
            'tautan'           => 'nullable|url|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $penghargaan = Penghargaan::findOrFail($id);
            $dataToUpdate = $validator->validated();

            if ($request->hasFile('dokumen')) {
                if ($penghargaan->file_path) {
                    Storage::disk('public')->delete($penghargaan->file_path);
                }
                $dataToUpdate['file_path'] = $request->file('dokumen')->store('dokumen_penghargaan', 'public');
            }

            $penghargaan->update($dataToUpdate);

            return response()->json(['success' => 'Data penghargaan berhasil diperbarui!']);
        } catch (\Exception $e) {
            Log::error('Error updating penghargaan: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat memperbarui data.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $penghargaan = Penghargaan::findOrFail($id);
            if ($penghargaan->file_path) {
                Storage::disk('public')->delete($penghargaan->file_path);
            }
            $penghargaan->delete();

            return response()->json(['success' => 'Data penghargaan berhasil dihapus!']);
        } catch (\Exception $e) {
            Log::error('Error deleting penghargaan: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus data.'], 500);
        }
    }
}