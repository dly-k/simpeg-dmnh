<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\PenetapanPangkat;
use App\Models\Jabatan;
use App\Models\JabatanSaatIni;
use App\Models\Pensiun;
use App\Models\KenaikanGajiBerkala;
use App\Models\TugasBelajar;
use App\Models\SkNonPns;
use App\Models\PengajaranLama;
use App\Models\PengajaranLuar;
use App\Models\PengujianLama;
use App\Models\PembimbingLama;
use App\Models\PengujiLuar;
use App\Models\PembimbingLuar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\PegawaiExport;
use Maatwebsite\Excel\Facades\Excel;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $queryAktif = Pegawai::where('status_pegawai', 'Aktif');
        $queryAktif->when($request->search_aktif, function ($q, $search) {
            return $q->where(fn($query) => $query->where('nama_lengkap', 'like', "%{$search}%")->orWhere('nip', 'like', "%{$search}%"));
        });
        $queryAktif->when($request->filter_kepegawaian_aktif, fn($q, $filter) => $q->where('status_kepegawaian', $filter));
        $pegawaiAktif = $queryAktif->latest()->paginate(10, ['*'], 'aktifPage')->withQueryString();

        $queryRiwayat = Pegawai::where('status_pegawai', '!=', 'Aktif');
        $queryRiwayat->when($request->search_riwayat, function ($q, $search) {
            return $q->where(fn($query) => $query->where('nama_lengkap', 'like', "%{$search}%")->orWhere('nip', 'like', "%{$search}%"));
        });
        $queryRiwayat->when($request->filter_status_riwayat, fn($q, $filter) => $q->where('status_pegawai', $filter));
        $pegawaiRiwayat = $queryRiwayat->latest()->paginate(10, ['*'], 'riwayatPage')->withQueryString();

        return view('pages.pegawai.daftar-pegawai', compact('pegawaiAktif', 'pegawaiRiwayat'));
    }

    public function export(Request $request)
    {
        $request->validate(['type' => 'required|in:aktif,riwayat']);
        $type = $request->input('type');
        $search = $type === 'aktif' ? $request->input('search_aktif') : $request->input('search_riwayat');
        $filter = $type === 'aktif' ? $request->input('filter_kepegawaian_aktif') : $request->input('filter_status_riwayat');
        $fileName = 'Daftar_Pegawai_' . ucfirst($type) . '_' . date('d-m-Y') . '.xlsx';
        return Excel::download(new PegawaiExport($type, $search, $filter), $fileName);
    }

    public function create()
    {
        return view('pages.pegawai.tambah-pegawai');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nip' => 'required|string|max:255|unique:pegawais,nip',
            'nama_lengkap' => 'required|string|max:255',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status_kepegawaian' => 'required|string|max:255',
            'status_pegawai' => 'required|string|max:255',
            // ... validasi lainnya ...
        ]);

        if ($request->hasFile('foto_profil')) {
            $filePath = $request->file('foto_profil')->store('foto_profil', 'public');
            $validatedData['foto_profil'] = $filePath;
        }

        Pegawai::create($validatedData);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan!');
    }

    public function show(Request $request, Pegawai $pegawai)
    {
        // --- 1. Logika untuk Data SK (Filter & Opsi Tahun) ---
        $getYears = function ($model, $dateColumn) use ($pegawai) {
            return $model::where('pegawai_id', $pegawai->id)
                ->selectRaw("YEAR($dateColumn) as year")
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year');
        };

        $tahunOptions = [
            'pangkat' => $getYears(new PenetapanPangkat, 'tanggal_sk'),
            'jabatan' => $getYears(new Jabatan, 'tanggal_sk'),
            'jabatanSaatIni' => $getYears(new JabatanSaatIni, 'created_at'),
            'pensiun' => $getYears(new Pensiun, 'tanggal_sk'),
            'gajiBerkala' => $getYears(new KenaikanGajiBerkala, 'tanggal_sk'),
            'tugasBelajar' => $getYears(new TugasBelajar, 'tanggal_sk'),
            'skNonPns' => $getYears(new SkNonPns, 'tanggal_sk'),
        ];
        
        // --- 2. Logika untuk Data Pendidikan ---
        $tahunAkademikOptions = PengajaranLama::select('tahun_semester')->distinct()->orderBy('tahun_semester', 'desc')->pluck('tahun_semester');
    
        $loadPendidikanData = function ($modelClass, $pageName) use ($pegawai) {
            return $modelClass::where('pegawai_id', $pegawai->id)
                ->latest()
                ->paginate(10, ['*'], $pageName)
                ->withQueryString();
        };

        $dataPengajaranLama = $loadPendidikanData(PengajaranLama::class, 'pengajaranLamaPage');
        $dataPengajaranLuar = $loadPendidikanData(PengajaranLuar::class, 'pengajaranLuarPage');
        $dataPengujianLama = $loadPendidikanData(PengujianLama::class, 'pengujianLamaPage');
        $dataPembimbingLama = $loadPendidikanData(PembimbingLama::class, 'pembimbingLamaPage');
        $dataPengujiLuar = $loadPendidikanData(PengujiLuar::class, 'pengujiLuarPage');
        $dataPembimbingLuar = $loadPendidikanData(PembimbingLuar::class, 'pembimbingLuarPage');

        // --- 3. Muat Relasi SK dengan Filter ---
        $pegawai->load([
            'efiles',
            'penetapanPangkats' => fn($q) => $q->when($request->search_pangkat, fn($q, $s) => $q->where('nomor_sk', 'like', "%{$s}%")->orWhere('golongan', 'like', "%{$s}%"))->when($request->tahun_pangkat, fn($q, $y) => $q->whereYear('tanggal_sk', $y)),
            'jabatans' => fn($q) => $q->when($request->search_jabatan, fn($q, $s) => $q->where('nomor_sk', 'like', "%{$s}%")->orWhere('nama_jabatan', 'like', "%{$s}%"))->when($request->tahun_jabatan, fn($q, $y) => $q->whereYear('tanggal_sk', $y)),
            'jabatanSaatInis' => fn($q) => $q->when($request->search_jabatan_saat_ini, fn($q, $s) => $q->where('nomor_sk', 'like', "%{$s}%")->orWhere('nama_jabatan', 'like', "%{$s}%"))->when($request->tahun_jabatan_saat_ini, fn($q, $y) => $q->whereYear('created_at', $y)),
            'pensiuns' => fn($q) => $q->when($request->search_pensiun, fn($q, $s) => $q->where('nomor_sk', 'like', "%{$s}%"))->when($request->tahun_pensiun, fn($q, $y) => $q->whereYear('tanggal_sk', $y)),
            'kenaikanGajiBerkalas' => fn($q) => $q->when($request->search_gaji_berkala, fn($q, $s) => $q->where('nomor_sk', 'like', "%{$s}%"))->when($request->tahun_gaji_berkala, fn($q, $y) => $q->whereYear('tanggal_sk', $y)),
            'tugasBelajars' => fn($q) => $q->when($request->search_tugas_belajar, fn($q, $s) => $q->where('nomor_sk', 'like', "%{$s}%"))->when($request->tahun_tugas_belajar, fn($q, $y) => $q->whereYear('tanggal_sk', $y)),
            'skNonPns' => fn($q) => $q->when($request->search_sk_non_pns, fn($q, $s) => $q->where('nomor_sk', 'like', "%{$s}%"))->when($request->tahun_sk_non_pns, fn($q, $y) => $q->whereYear('tanggal_sk', $y)),
        ]);

        return view('pages.pegawai.detail-pegawai', compact(
            'pegawai', 'tahunOptions', 'tahunAkademikOptions',
            'dataPengajaranLama', 'dataPengajaranLuar', 'dataPengujianLama',
            'dataPembimbingLama', 'dataPengujiLuar', 'dataPembimbingLuar'
        ));
    }

    /**
     * Memperbarui data pegawai di dalam database.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $validatedData = $request->validate([
            'nip' => 'required|string|max:255|unique:pegawais,nip,' . $pegawai->id,
            'nama_lengkap' => 'required|string|max:255',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($request->hasFile('foto_profil')) {
            if ($pegawai->foto_profil && Storage::disk('public')->exists($pegawai->foto_profil)) {
                Storage::disk('public')->delete($pegawai->foto_profil);
            }
            $filePath = $request->file('foto_profil')->store('foto_profil', 'public');
            $validatedData['foto_profil'] = $filePath;
        }

        $pegawai->update($validatedData);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui!');
    }

    /**
     * Menghapus data pegawai dari database.
     */
    public function destroy(Pegawai $pegawai)
    {
        if ($pegawai->foto_profil && Storage::disk('public')->exists($pegawai->foto_profil)) {
            Storage::disk('public')->delete($pegawai->foto_profil);
        }

        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil dihapus.');
    }
}