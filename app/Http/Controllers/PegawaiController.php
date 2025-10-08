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
use App\Models\Penelitian;
use App\Models\Pengabdian; 
use App\Models\Penunjang;
use App\Models\Pelatihan;
use App\Models\Penghargaan;
use App\Models\SertifikatKompetensi;
use App\Models\Pembicara;
use App\Models\OrasiIlmiah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\PegawaiExport;
use Maatwebsite\Excel\Facades\Excel;

class PegawaiController extends Controller
{
    /**
     * Menampilkan daftar pegawai dengan fungsionalitas pencarian dan filter.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Query untuk Pegawai Aktif
        $queryAktif = Pegawai::where('status_pegawai', 'Aktif');
        $queryAktif->when($request->search_aktif, function ($q, $search) {
            return $q->where(fn($query) => $query->where('nama_lengkap', 'like', "%{$search}%")->orWhere('nip', 'like', "%{$search}%"));
        });
        $queryAktif->when($request->filter_kepegawaian_aktif, fn($q, $filter) => $q->where('status_kepegawaian', $filter));
        $pegawaiAktif = $queryAktif->latest()->paginate(10, ['*'], 'aktifPage')->withQueryString();

        // Query untuk Riwayat Pegawai
        $queryRiwayat = Pegawai::where('status_pegawai', '!=', 'Aktif');
        $queryRiwayat->when($request->search_riwayat, function ($q, $search) {
            return $q->where(fn($query) => $query->where('nama_lengkap', 'like', "%{$search}%")->orWhere('nip', 'like', "%{$search}%"));
        });
        $queryRiwayat->when($request->filter_status_riwayat, fn($q, $filter) => $q->where('status_pegawai', $filter));
        $pegawaiRiwayat = $queryRiwayat->latest()->paginate(10, ['*'], 'riwayatPage')->withQueryString();

        return view('pages.pegawai.daftar-pegawai', compact('pegawaiAktif', 'pegawaiRiwayat'));
    }

    /**
     * Menangani permintaan ekspor data pegawai ke Excel.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        $request->validate(['type' => 'required|in:aktif,riwayat']);
        $type = $request->input('type');
        $search = $type === 'aktif' ? $request->input('search_aktif') : $request->input('search_riwayat');
        $filter = $type === 'aktif' ? $request->input('filter_kepegawaian_aktif') : $request->input('filter_status_riwayat');
        $fileName = 'Daftar_Pegawai_' . ucfirst($type) . '_' . date('d-m-Y') . '.xlsx';
        return Excel::download(new PegawaiExport($type, $search, $filter), $fileName);
    }

    /**
     * Menampilkan form untuk membuat data pegawai baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('pages.pegawai.tambah-pegawai');
    }

    /**
     * Menyimpan data pegawai baru ke dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nip' => 'required|string|max:255|unique:pegawais,nip',
            'nama_lengkap' => 'required|string|max:255',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'agama' => 'nullable|string|max:255',
            'status_pernikahan' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|string|max:255',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'bidang_ilmu' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'status_kepegawaian' => 'required|string|max:255',
            'status_pegawai' => 'required|string|max:255',
            'nomor_arsip' => 'nullable|string|max:255',
            'jabatan_fungsional' => 'required|string|max:255',
            'pangkat_golongan' => 'required|string|max:255',
            'tmt_pangkat' => 'nullable|date',
            'jabatan_struktural' => 'nullable|string|max:255',
            'periode_jabatan_mulai' => 'nullable|date',
            'periode_jabatan_selesai' => 'nullable|date',
            'finger_print_id' => 'nullable|string|max:255',
            'npwp' => 'nullable|string|max:255',
            'nama_bank' => 'nullable|string|max:255',
            'nomor_rekening' => 'nullable|string|max:255',
            'nuptk' => 'nullable|string|max:255',
            'sinta_id' => 'nullable|string|max:255',
            'nidn' => 'nullable|string|max:255',
            'scopus_id' => 'nullable|string|max:255',
            'no_sertifikasi_dosen' => 'nullable|string|max:255',
            'orchid_id' => 'nullable|string|max:255',
            'tgl_sertifikasi_dosen' => 'nullable|date',
            'google_scholar_id' => 'nullable|string|max:255',
            'provinsi_domisili' => 'nullable|string|max:255',
            'alamat_domisili' => 'nullable|string',
            'kota_domisili' => 'nullable|string|max:255',
            'kode_pos_domisili' => 'nullable|string|max:255',
            'kecamatan_domisili' => 'nullable|string|max:255',
            'no_telepon' => 'nullable|string|max:255',
            'kelurahan_domisili' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'nomor_ktp' => 'nullable|string|max:255',
            'kecamatan_ktp' => 'nullable|string|max:255',
            'nomor_kk' => 'nullable|string|max:255',
            'kelurahan_ktp' => 'nullable|string|max:255',
            'warga_negara' => 'nullable|string|max:255',
            'kode_pos_ktp' => 'nullable|string|max:255',
            'provinsi_ktp' => 'nullable|string|max:255',
            'kabupaten_ktp' => 'nullable|string|max:255',
            'alamat_ktp' => 'nullable|string',
        ]);

        if ($request->hasFile('foto_profil')) {
            $filePath = $request->file('foto_profil')->store('foto_profil', 'public');
            $validatedData['foto_profil'] = $filePath;
        }

        Pegawai::create($validatedData);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail dari seorang pegawai beserta semua data relasinya.
     */
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
    
        $loadPendidikanData = function ($modelClass, $pageName) use ($pegawai, $request) {
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

        // --- 3. Logika untuk Data Penelitian ---
        $penelitianPegawai = Penelitian::whereHas('penulis', function ($query) use ($pegawai) {
            $query->where('pegawai_id', $pegawai->id);
        })->with('penulis.pegawai')->latest()->paginate(10, ['*'], 'penelitianPage')->withQueryString();

        // -- Data Pengabdian--
        $pengabdianPegawai = Pengabdian::whereHas('anggota', function ($query) use ($pegawai) {
            $query->where('jenis', 'dosen')->where('pegawai_id', $pegawai->id);
        })->with('dokumen')->latest()->paginate(10, ['*'], 'pengabdianPage')->withQueryString();
        
        //-- Data Penunjang --
        $penunjangPegawai = Penunjang::whereHas('anggota', function ($query) use ($pegawai) {
            $query->where('pegawai_id', $pegawai->id);
        })->latest()->paginate(10, ['*'], 'penunjangPage')->withQueryString();

        //== Data Diklat / Pelatihan ==
        $pelatihanPegawai = Pelatihan::where('pegawai_id', $pegawai->id)
            ->latest()
            ->paginate(10, ['*'], 'pelatihanPage')
            ->withQueryString();
        
        // -- Data Penghargaan --
                $penghargaanPegawai = Penghargaan::where('pegawai_id', $pegawai->id)
            ->latest()
            ->paginate(10, ['*'], 'penghargaanPage')
            ->withQueryString();

        //-- Sertifikat Kompetensi--
                $sertifikatKompetensiPegawai = SertifikatKompetensi::where('pegawai_id', $pegawai->id)
            ->latest()
            ->paginate(10, ['*'], 'sertifikatPage')
            ->withQueryString();
        
        //--Pembicara Pegawai--
         $pembicaraPegawai = Pembicara::where('pegawai_id', $pegawai->id)
            ->with('dokumen')
            ->latest()
            ->paginate(10, ['*'], 'pembicaraPage')
            ->withQueryString();

        //-- orasi ilmiah --
            $orasiIlmiahPegawai = OrasiIlmiah::where('pegawai_id', $pegawai->id)
            ->latest()
            ->paginate(10, ['*'], 'orasiIlmiahPage')
            ->withQueryString();

        // --- Relasi SK dengan Filter ---
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
            'dataPembimbingLama', 'dataPengujiLuar', 'dataPembimbingLuar',
            'penelitianPegawai',
            'pengabdianPegawai',
            'penunjangPegawai',
            'pelatihanPegawai',
            'penghargaanPegawai',
            'sertifikatKompetensiPegawai',
            'pembicaraPegawai',
            'orasiIlmiahPegawai'
        ));
    }

    /**
     * Menampilkan form untuk mengedit data pegawai.
     */
    public function edit(Pegawai $pegawai)
    {
        return view('pages.pegawai.edit-pegawai', compact('pegawai'));
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