<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Penelitian;
use App\Models\PenulisPenelitian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PenelitianController extends Controller
{
    /**
     * Menampilkan halaman utama dengan data penelitian yang sudah difilter.
     */
    public function index(Request $request)
    {
        $query = Penelitian::with('penulis.pegawai');

        // 1. Filter Pencarian (Judul atau Penulis)
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhereHas('penulis', function ($subq) use ($search) {
                      $subq->where('nama_penulis', 'like', "%{$search}%")
                           ->orWhereHas('pegawai', function ($pegawaiSubq) use ($search) {
                               $pegawaiSubq->where('nama_lengkap', 'like', "%{$search}%");
                           });
                  });
            });
        }

        // 2. Filter Periode (Ganjil/Genap per Tahun)
        if ($periode = $request->input('periode')) {
            list($year, $semester) = explode('_', $periode);
            $months = ($semester === 'ganjil') ? [1, 6] : [7, 12];
            $query->whereYear('tanggal_terbit', $year)
                  ->whereBetween(DB::raw('MONTH(tanggal_terbit)'), $months);
        }

        // 3. Filter Jenis Karya
        if ($jenis_karya = $request->input('jenis_karya_lengkap')) {
            $query->where('jenis_karya', $jenis_karya);
        }

        // 4. Filter Status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $penelitian = $query->latest()->paginate(10)->withQueryString();
        $pegawai = Pegawai::where('status_pegawai', 'Aktif')->orderBy('nama_lengkap')->get();
        
        return view('pages.penelitian', [
            'penelitian' => $penelitian,
            'pegawai' => $pegawai,
            'periodeOptions' => $this->getPeriodeOptions(),
        ]);
    }

    /**
     * Helper untuk membuat opsi filter periode dinamis.
     */
    private function getPeriodeOptions()
    {
        $dates = Penelitian::select(DB::raw('YEAR(tanggal_terbit) as year, MONTH(tanggal_terbit) as month'))
            ->whereNotNull('tanggal_terbit')
            ->distinct()
            ->orderBy('year', 'desc')
            ->get();

        $options = [];
        foreach ($dates as $date) {
            $semester = ($date->month >= 1 && $date->month <= 6) ? 'ganjil' : 'genap';
            $label = ($semester === 'ganjil' ? 'Ganjil' : 'Genap') . ' ' . $date->year;
            $value = $date->year . '_' . $semester;
            $options[$value] = $label; // Menggunakan value sebagai key untuk otomatis handle duplikat
        }
        return $options;
    }

    public function export(Request $request)
    {
        $query = \App\Models\Penelitian::with('penulis.pegawai');

        // Filter search (judul / penulis)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                ->orWhereHas('penulis.pegawai', function ($subq) use ($search) {
                    $subq->where('nama_lengkap', 'like', '%' . $search . '%');
                });
            });
        }

        // Filter periode (berdasarkan tanggal_terbit)
        $periode = null;
        if ($request->filled('periode')) {
            $periode = $request->periode;
            [$year, $semester] = explode('_', $periode);

            $months = ($semester === 'ganjil') ? [1, 6] : [7, 12];
            $query->whereYear('tanggal_terbit', $year)
                ->whereBetween(DB::raw('MONTH(tanggal_terbit)'), $months);
        }

        // Filter jenis karya
        $jenis = null;
        if ($request->filled('jenis_karya_lengkap')) {
            $jenis = $request->jenis_karya_lengkap;
            $query->where('jenis_karya', $jenis);
        }

        // Filter status
        $status = null;
        if ($request->filled('status')) {
            $status = $request->status;
            $query->where('status', $status);
        }

        // Ambil data setelah semua filter
        $data = $query->get();

        // Buat nama file dinamis
        $filename = 'Data_Penelitian';
        if ($periode) {
            $filename .= '_' . preg_replace('/[^A-Za-z0-9\-]/', '', $periode);
        }
        if ($jenis) {
            $filename .= '_' . preg_replace('/[^A-Za-z0-9\-]/', '', $jenis);
        }
        if ($status) {
            $filename .= '_' . preg_replace('/[^A-Za-z0-9\-]/', '', $status);
        }
        if ($request->filled('search')) {
            $filename .= '_(' . preg_replace('/[^A-Za-z0-9\-]/', '', $request->search) . ')';
        }
        $filename .= '.xlsx';

        // Export ke Excel
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\PenelitianExport($data, $periode, $jenis, $status, $request->search),
            $filename
        );
    }

    /**
     * Menyimpan data penelitian baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'jenis_karya' => 'required|string',
            'publik' => 'required|string',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'penulis_ipb.*.pegawai_id' => 'required_with:penulis_ipb|exists:pegawais,id',
            'penulis_luar.*.nama' => 'nullable|string',
            'penulis_mahasiswa.*.nama' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $dokumenPath = null;
            if ($request->hasFile('dokumen')) {
                $dokumenPath = $request->file('dokumen')->store('dokumen-penelitian', 'public');
            }

            $penelitian = Penelitian::create([
                'judul' => $request->judul,
                'jenis_karya' => $request->jenis_karya,
                'volume' => $request->volume,
                'jumlah_halaman' => $request->jumlah_halaman,
                'tanggal_terbit' => $request->tanggal_terbit,
                'is_publik' => $request->publik == 'Ya',
                'isbn' => $request->isbn,
                'issn' => $request->issn,
                'doi' => $request->doi,
                'url' => $request->url,
                'dokumen_path' => $dokumenPath,
            ]);

            $this->simpanPenulis($request, $penelitian->id);
            
            DB::commit();
            return redirect()->route('penelitian.index')->with('success', 'Data penelitian berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving research data: ' . $e->getMessage());
            return redirect()->back()->withErrors('Gagal menyimpan data. Terjadi kesalahan pada server.')->withInput();
        }
    }

    /**
     * Mengambil data spesifik untuk form edit.
     */
    public function edit(Penelitian $penelitian)
    {
        $penelitian->load('penulis.pegawai');
        return response()->json($penelitian);
    }

    /**
     * Memperbarui data penelitian di database.
     */
    public function update(Request $request, Penelitian $penelitian)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'jenis_karya' => 'required|string',
            'publik' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $updateData = $request->except(['dokumen', 'penulis_ipb', 'penulis_luar', 'penulis_mahasiswa', '_method']);
            
            if ($request->hasFile('dokumen')) {
                if ($penelitian->dokumen_path && Storage::disk('public')->exists($penelitian->dokumen_path)) {
                    Storage::disk('public')->delete($penelitian->dokumen_path);
                }
                $updateData['dokumen_path'] = $request->file('dokumen')->store('dokumen-penelitian', 'public');
            }

            $penelitian->update($updateData);
            $penelitian->penulis()->delete();
            $this->simpanPenulis($request, $penelitian->id);

            DB::commit();
            return redirect()->route('penelitian.index')->with('success', 'Data penelitian berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating research data: ' . $e->getMessage());
            return redirect()->back()->withErrors('Gagal memperbarui data. Terjadi kesalahan.')->withInput();
        }
    }

    /**
     * Memperbarui status verifikasi data penelitian.
     */
    public function verifikasi(Request $request, Penelitian $penelitian)
    {
        $request->validate([
            'status' => ['required', Rule::in(['Sudah Diverifikasi', 'Ditolak'])],
        ]);

        $penelitian->status = $request->status;
        $penelitian->save();

        $newStatusHtml = '';
        if ($penelitian->status == 'Sudah Diverifikasi') {
            $newStatusHtml = '<i class="fas fa-check-circle text-success" title="Sudah Diverifikasi"></i>';
        } elseif ($penelitian->status == 'Ditolak') {
            $newStatusHtml = '<i class="fas fa-times-circle text-danger" title="Ditolak"></i>';
        }

        return response()->json([
            'success' => true,
            'message' => 'Status penelitian berhasil diperbarui!',
            'newStatusHtml' => $newStatusHtml,
        ]);
    }

    /**
     * Helper function untuk menyimpan data penulis.
     */
    private function simpanPenulis(Request $request, $penelitian_id)
    {
        if ($request->penulis_ipb) {
            foreach ($request->penulis_ipb as $p) {
                if (empty($p['pegawai_id'])) continue;
                $skPath = isset($p['sk']) && $p['sk']->isValid() ? $p['sk']->store('sk-penelitian', 'public') : null;
                PenulisPenelitian::create([
                    'penelitian_id' => $penelitian_id,
                    'pegawai_id' => $p['pegawai_id'],
                    'tipe_penulis' => 'IPB',
                    'sk_penugasan_path' => $skPath
                ]);
            }
        }
        if ($request->penulis_luar) {
            foreach ($request->penulis_luar as $p) {
                if (empty($p['nama'])) continue;
                $skPath = isset($p['sk']) && $p['sk']->isValid() ? $p['sk']->store('sk-penelitian', 'public') : null;
                PenulisPenelitian::create([
                    'penelitian_id' => $penelitian_id,
                    'nama_penulis' => $p['nama'],
                    'afiliasi' => $p['afiliasi'] ?? null,
                    'tipe_penulis' => 'Luar IPB',
                    'sk_penugasan_path' => $skPath
                ]);
            }
        }
        if ($request->penulis_mahasiswa) {
            foreach ($request->penulis_mahasiswa as $p) {
                if (empty($p['nama'])) continue;
                PenulisPenelitian::create([
                    'penelitian_id' => $penelitian_id,
                    'nama_penulis' => $p['nama'],
                    'tipe_penulis' => 'Mahasiswa'
                ]);
            }
        }
    }
    
    /**
     * Menghapus data penelitian dari database.
     */
     public function destroy(Penelitian $penelitian)
    {
        DB::beginTransaction();
        try {
            // 1. Hapus file-file terkait dari storage
            // Hapus SK Penugasan setiap penulis
            foreach ($penelitian->penulis as $penulis) {
                if ($penulis->sk_penugasan_path && Storage::disk('public')->exists($penulis->sk_penugasan_path)) {
                    Storage::disk('public')->delete($penulis->sk_penugasan_path);
                }
            }

            // Hapus dokumen utama penelitian
            if ($penelitian->dokumen_path && Storage::disk('public')->exists($penelitian->dokumen_path)) {
                Storage::disk('public')->delete($penelitian->dokumen_path);
            }

            // 2. Hapus data dari database
            // Menghapus data penelitian akan otomatis menghapus data penulis terkait
            // karena kita sudah set 'onDelete('cascade')' di migrasi.
            $penelitian->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data penelitian berhasil dihapus!',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting research data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data.',
            ], 500);
        }
    }
}