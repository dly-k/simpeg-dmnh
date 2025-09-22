<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Pegawai;
use App\Models\PengajaranLama;
use App\Models\PengajaranLuar;
use App\Models\PengujianLama;
use App\Models\PembimbingLama;
use App\Models\PengujiLuar;
use App\Models\PembimbingLuar;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;

class PendidikanController extends Controller
{
    // Method untuk mengambil dan memfilter data secara dinamis
    private function getFilteredData(Request $request, $modelClass, array $searchableFields, $pageName)
    {
        $query = $modelClass::query()->with('pegawai');

        // Filter Pencarian
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search, $searchableFields) {
                // Pencarian pada relasi pegawai (nama dosen)
                $q->whereHas('pegawai', function ($subq) use ($search) {
                    $subq->where('nama_lengkap', 'like', "%{$search}%");
                });

                // Pencarian pada kolom-kolom lain di tabel utama
                foreach ($searchableFields as $field) {
                    $q->orWhere($field, 'like', "%{$search}%");
                }
            });
        }

        // Filter Tahun Akademik (Semester)
        if ($tahunAkademik = $request->input('tahun_akademik')) {
            $query->where('tahun_semester', $tahunAkademik);
        }

        // Filter Status
        if ($status = $request->input('status')) {
            $query->where('status_verifikasi', $status);
        }

        return $query->latest()->paginate(10, ['*'], $pageName)->withQueryString();
    }

    // Method untuk mendapatkan semua opsi tahun akademik yang unik dari semua tabel
    private function getTahunAkademikOptions(): Collection
    {
        $models = [
            PengajaranLama::class, PengajaranLuar::class, PengujianLama::class,
            PembimbingLama::class, PengujiLuar::class, PembimbingLuar::class,
        ];
        
        $allTahun = new Collection();

        foreach ($models as $model) {
            $allTahun = $allTahun->merge($model::select('tahun_semester')->distinct()->pluck('tahun_semester'));
        }

        return $allTahun->unique()->sort()->values();
    }

public function index(Request $request) {
        $dosenAktif = Pegawai::where('status_pegawai', 'Aktif')->orderBy('nama_lengkap')->get();
        $tahunAkademikOptions = $this->getTahunAkademikOptions();

        $programStudi = [
            "D1 - Pertanian", "D1 - Peternakan", "D1 - Pembinaan Hutan", "D1 - Penafsiran Potret Udara", 
            "D1 - Pengelola Alat Mesin Pertanian", "D1 - Perkebunan", "D1 - Prog. Pend. Vokasi Berkelanjutan (D1 Tek. Hasil Pertanian)",
            "D1 - Program Diploma D1 (Untuk Gelar) (DIP)", "D2 - Ekowisata", "D2 - Manajemen Informatika",
            "D2 - Teknologi dan Manajemen Produksi Hortikultura", "D2 - Teknologi dan Manajemen Produksi Perkebunan",
            "D2 - Teknologi Hasil Pertanian", "D2- Teknologi Industri Benih", "D2 - Teknologi Produksi dan Manajemen Perikanan Budidaya",
            "D2 - Manajer Koperasi Unit Desa", "D2 - Pendidikan Guru Kejuruan Pertanian", "D2 - Perpustakaan dan Informatika Pertanian",
            "D2 - Teknisi Reproduksi Satwa", "D2 - Program Diploma D2 (Untuk Gelar) (DIP)", "D3 - Agribisnis Peternakan",
            "D3 - Akutansi (AKN)", "D3 - Analisis Benih", "D3 - Analisis Kimia (KIM)", "D3 - Analisis Kimia Lingkungan",
            "D3 - Analisis Lingkungan", "D3 - Budidaya Hutan", "D3 - Budidaya Hutan Produksi", "D3 - Budidaya Hutan Tanaman",
            "D3 - Direktorat Program Diploma (DIPLOMA)", "D3 - Ekowisata (EKW)", "D3 - Ekowista Sukabumi",
            "D3 - Elektronika dan Teknologi Komputer", "D3 - Exchange Diploma 3", "D3 - Higiene Makanan", "D3 - Komunikasi (KMN)",
            "D3 - Komunikasi Sukabumi", "D3 - Manajemen Agribisnis (AGB)", "D3 - Manajemen Agribisnis Sukabumi",
            "D3 - Manajemen Hutan", "D3 - Manajemen Hutan Alam Produksi", "D3 - Manajemen Hutan Produksi",
            "D3 - Manajemen Industri (MI)", "D3 - Manajemen Industri Jasa Makanan dan Gizi (GZI)", "D3 - Manajemen Informatika (INF)",
            "D3 - Manajer Alat dan Mesin Pertanian", "D3 - Manejer Koperasi Unit Desa", "D3 - Manajemen Usaha Boga",
            "D3 - Paramedik Veteriner", "D3 - Penafsiran Potret Udara", "D3 - Pendayugunaan Lahan dan Air",
            "D3 - Pendidikan Guru Kejuruan Pertanian", "D3 - Pengelolaan Kelestarian Reproduksi", "D3 - Pengelolaan Perkebunan",
            "D3 - Perencanaan dan Pengedalian Produksi Manufaktur/Jasa", "D3 - Perkebunan Kelapa Sawit",
            "D3 - Perpustakaan dan Informatika Pertanian", "D3 - Petugas Lapangan Proyek Terpadu Perkebunan",
            "D3 - Program Keahlian Perencanaan Dan Pengendalian Produksi Manufaktur/Jasa", "D3 - Program Keahlian Teknologi Produksi Dan Pengembangan Masyarakat Pertanian",
            "D3 - Supervisor Jaminan Mutu Pangan (JMP)", "D3 - Teknik dan Manajemen Lingkungan (TML)", "D3 - Teknik Industri Benih Sukabumi",
            "D3 - Teknik Instrumentasi dan Kontrol", "D3 - Teknik Komputer (TEK)", "D3 - Teknik Pendayagunaan Lahan Dan Air",
            "D3 - Teknisi Pemetaan, Pengukuran Perencanaan Penggunaan Tanah", "D3 - Teknisi Reproduksi Satwa",
            "D3 - Teknologi dan Manajemen Produksi Perkebunan (TMPP)", "D3 - Teknologi dan Manajemen Ternak (TNK)",
            "D3 - Teknologi dan Manajemen Ternak Sukabumi", "D3 - Teknologi Industri Benih (TIB)",
            "D3 - Teknologi Informasi Kelautan", "D3 - Teknologi Produksi dan Manajemen Perikanan Budidaya (IKN)",
            "D3 - Teknologi Reproduksi Ikan", "D3 - Program Diploma D2 (Untuk Gelar) (DIP)", "D4 - Akuntansi (AKN)",
            "D4 - Analisis Kimia (KIM)", "D4 - Direktorat Program Diploma (DIPLOMA)", "D4 - Ekowisata (EKW)",
            "D4 - Ekowisata (Kampus Sukabumi) (EKW)", "D4 - Exchange Diploma 4", "D4 - Komunikasi Digital dan Media",
            "D4 - Komunikasi Digital dan Media (Kampus Sukabumi) (KMN)", "D4 - Manajemen Agribisnis (Kampus Sukabumi) (MAB)",
            "D4 - Manajemen Agribisnis (MAB)", "D4 - Manajemen Industri (MNI)", "D4 - Manajemen Industri Jasa Makanan dan Gizi (GZI)",
            "D4 - Paramedik Veteriner (PVT)", "D4 - Supervisor Jaminan Mutu Pangan (JMP)", "D4 - Teknik dan Manajemen Lingkungan (LNK)",
            "D4 - Teknologi dan Manajemen Pembenihan Ikan (IKN)", "D4 - Teknologi dan Manajemen Pembenihan Ikan (Kampus Sukabumi) (IKN)",
            "D4 - Teknologi dan Manajemen Produksi Perkebunan (TMP)", "D4 - Teknologi dan Manajemen Ternak (Kampus Sukabumi) (TNK)",
            "D4 - Teknologi dan Manajemen Ternak (TNK)", "D4 - Teknologi Produksi dan Pengembangan Masyarakat Pertanian (PPP)",
            "D4 - Teknologi Rekayasa Komputer (TEK)", "D4 - Teknologi Rekayasa Perangkat Lunak (TRPL)",
            "PRF - Pendidikan Profesi Dietisien (RDN)", "PRF - Pendidikan Profesi Dokter Hewan (PPDH)",
            "PRF - Pertanian dan Hasil Pertanian", "PRF - Profesi Kedokteran (DOK)", "PRF - Program Profesi Insinyur (PPI)",
            "S1 - Agribisnis (AGB)", "S1 - Agronomi dan Hortikultura (AGH)", "S1 - Aktuaria (AKT)",
            "S1 - Anatomi, Fisiologi dan Farmakologi", "S1 - Arsitektur Lanskap (ARL)", "S1 - BioInformatika (BIF)",
            "S1 - Biokimia (BIK)", "S1 - Biologi (BIO)", "S1 - Bisnis (SBI)", "S1 - Direktorat Pendidikan Kompetensi Umum (TPB)",
            "S1 - Ekonomi Pembangunan (EKO)", "S1 - Ekonomi Sumberdaya dan Lingkungan (ESL)", "S1 - Exchange",
            "S1 - Fisika (FIS)", "S1 - Ilmu dan Teknologi Kelautan (ITK)", "S1 - Ilmu Ekonomi Syariah (EKS)",
            "S1 - Ilmu Gizi (GIZ)", "S1 - Ilmu Keluarga dan Konsumen (IKK)", "S1 - Ilmu Komputer (KOM)",
            "S1 - Ilmu Penyakit Hewan dan Kesehatan Masyarakat Veteriner", "S1 - Kecerdasan Buatan (KCB)",
            "S1 - Kedokteran", "S1 - Kedokteran Hewan (FKH)", "S1 - Kimia (KIM)", "S1 - Klinik, Reproduksi dan Patologi",
            "S1 - Komunikasi dan Pengembangan Masyarakat (KPM)", "S1 - Konservasi Sumberdaya Hutan dan Ekowisata (KSH)",
            "S1 - Manajemen", "S1 - Manajemen Hutan (MNH)", "S1 - Manajemen Sumberdaya Lahan (TSL)",
            "S1 - Manajemen Sumberdaya Perairan (MSP)", "S1 - Matematika (MAT)", "S1 - Meteorologi Terapan (GFM)",
            "S1 - Nutrisi dan Teknologi Pakan (NTP)", "S1 - Pertanian (TAN)", "S1 - Peternakan (TER)",
            "S1 - Proteksi Tanaman (PTN)", "S1 - Sains Biomedis (SBM)", "S1 - Silvikultur (SVK)", "S1 - Smart Agriculture (SAG)",
            "S1 - Statistika", "S1 - Statistika dan Sains Data (STK)", "S1 - Teknik Industri Pertanian (TIN", "S1 - Teknik Kimia",
            "S1 - Teknik Mesin", "S1 - Teknik Mesin dan Biosistem (TMB)", "S1 - Teknik Pertanian dan Biosistem (TPB)",
            "S1 - Teknik Sipil dan Lingkungan (SIL)", "S1 - Teknologi dan Manajemen Perikanan Budidaya (BDP)",
            "S1 - Teknologi dan Manajemen Perikanan Tangkap (PSP)", "S1 - Teknologi Hasil Hutan (THH)",
            "S1 - Teknologi Hasil Perairan (THP)", "S1 - Teknologi Hasil Ternak (THT)", "S1 - Teknologi Industri Pertanian (TIP)",
            "S1 - Teknologi Pangan", "S1 - Teknologi Produksi Ternak (TPT)", "S2 - Agroklimatologi", "S2 - Agrometeorologi",
            "S2 - Agronomi", "S2 - Agronomi dan Hortikultura (AGH)", "S2 - Agroteknologi Tanah (ATT)", "S2 - Anatomi dan Perkembangan Hewan (APH)",
            "S2 - Arsitektur Lanskap (ARL)", "S2 - Arsitektur Pertamanan / Magister Sains", "S2 - Biofisika (BFS)", "S2 - Biokimia (BIK)",
            "S2 - Biologi", "S2 - Biologi Reproduksi (BRP)", "S2 - Biologi Tumbuhan (BOT)", "S2 - Biosains Hewan (BSH)",
            "S2 - Bioteknologi (BTK)", "S2 - Bioteknologi Tanah dan Lingkungan (BTL)", "S2 - Ekonomi Kelautan Tropika (EKT)",
            "S2 - Ekonomi Sumberdaya dan Lingkungan (ESL)", "S2 - Ekonomi Sumberdaya Kelautan Tropika", "S2 - Entomologi (ENT)",
            "S2 - Entomologi Kesehatan", "S2 - Exchange Magister", "S2 - Fitopatologi (FIT)", "S2 - Ilmu Akuakultur (AKU)",
            "S2 - Ilmu Biomedis Hewan (IBH)", "S2 - Ilmu dan Teknologi Benih (ITB)", "S2 - Ilmu Dan Teknologi Hasil Hutan'",
            "S2 - Ilmu Ekonomi (EKO)", "S2 - Ilmu Ekonomi Pertanian (EPN)", "S2 - Ilmu Ekonomi Syariah (EKS)", "S2 - Ilmu Gizi (GIZ)",
            "S2 - Ilmu Gizi Manusia (GMA)", "S2 - Ilmu Gizi Masyarakat (GMS)", "S2 - Ilmu Gizi Masyarakat Dan Sumberdaya Keluarga",
            "S2 - Ilmu Hayati", "S2 - Ilmu Kelautan (IKL)", "S2 - Ilmu Keluarga dan Perkembangan Anak (IKA)", "S2 - Ilmu Keteknikan Pertanian",
            "S2 - Ilmu Komputer (KOM)", "S2 - Ilmu Konsumen (IKO)", "S2 - Ilmu Manajemen (MAN)", "S2 - Ilmu Nutrisi dan Pakan (INP)",
            "S2 - Ilmu Pangan (IPN)", "S2 - Ilmu Pengelolaan Daerah Aliran Sungai ()", "S2 - Ilmu Pengelolaan Hutan",
            "S2 - Ilmu Pengelolaan Sumberdaya Alam dan Lingkungan (PSL)", "S2 - Ilmu Pengetahuan Kehutanan",
            "S2 - Ilmu Penyuluhan Pembangunan", "S2 - Ilmu Perairan", "S2 - Ilmu Perencanaan Pembangunan Wilayah dan Pedesaan (PWD)",
            "S2 - Ilmu Perencanaan Wilayah (PWL)", "S2 - Ilmu Perkayuan", "S2 - Ilmu Produksi dan Teknologi Peternakan (ITP)",
            "S2 - Ilmu Tanah (TNH)", "S2 - Ilmu Ternak", "S2 - Ilmu-Ilmu Faal dan Khasiat Obat (IFO)", "S2 - Ilmu Tanaman",
            "S2 - Information Technology for Natural Resource Management (MIT)", "S2 - Keamanan Pangan (KPN)",
            "S2 - Kesehatan Masyarakat Veteriner (KMV)", "S2 - Kimia (KIM)", "S2 - Klimatologi Terapan (KLI)",
            "S2 - Komunikasi Pembangunan Pertanian dan Pedesaan (KMP)", "S2 - Konservasi Biodiversitas Tropika",
            "S2 - Konservasi Biodiversitas Tropika (KVT)", "S2 - Konservasi Keanekaragaman Hayati (KKH)", "S2 - Logistik Agro-Maritim (LOG)",
            "S2 - Magister Pengembangan Masyarakat (MPM)", "S2 - Magister Teknologi Informasi Untuk Perpustakaan (MTP)",
            "S2 - Manajemen dan Bisnis", "S2 - Manajemen Ekowisata Dan Jasa Lingkungan", "S2 - Manajemen Ketahanan Pangan (MKP)",
            "S2 - Manajemen Pembangunan Daerah (MPD)", "S2 - Matematika Terapan (MAT)", "S2 - Mikrobiologi (MIK)",
            "S2 - Mikrobiologi Medik (MKM)", "S2 - Mitigasi Bencana Kerusakan Lahan (MBK)", "S2 - Parasitologi dan Entomologi Kesehatan (PEK)",
            "S2 - Pemuliaan dan Bioteknologi Tanaman (PBT)", "S2 - Pengelolaan Daerah Aliran Sungai (DAS)", "S2 - Pengelolaan Hama Terpadu",
            "S2 - Pengelolaan Sumberdaya Perairan (SDP)", "S2 - Pengelolaan Sumberdaya Pesisir dan Lautan (SPL)",
            "S2 - Pengembangan dan Pengerahan Sumberdaya Ekonomi dan Sosial Masyarakat", "S2 - Pengembangan Industri Kecil Menengah (MPI)",
            "S2 - Pengembangan Masyarakat", "S2 - Pengendalian Hama Terpadu (PHT)", "S2 - Penyuluhan Pembangunan (PPN)",
            "S2 - Primatologi (PRM)", "S2 - Profesional Konservasi Keanekaragaman Hayati", "S2 - Profesional Perbenihan (MPB)",
            "S2 - Profesional Teknologi Pangan (TPN)", "S2 - Rekayasa dan Peningkatan Mutu Hasil Hutan (RPM)", "S2 - Sains Agribisnis (AGB)",
            "S2 - Sains Veteriner", "S2 - Silvikultur Tropika (SVK)", "S2 - Sistem dan Pemodelan Perikanan Tangkap (SPT)",
            "S2 - Sosiologi Pedesaan (SPD)", "S2 - Statistika (STK)", "S2 - Statistika dan Sains Data (STK)",
            "S2 - Statistika Terapan (STT)", "S2 - Studi Pembangunan Musyawarah", "S2 - Teknik Industri Pertanian (TIP)",
            "S2 - Teknik Mesin Pertanian dan Pangan (TMP)", "S2 - Teknik Pertanian dan Biosistem (TPB)",
            "S2 - Teknik Sipil dan Lingkungan (SIL)", "S2 - Teknologi Hasil Perairan (THP)", "S2 - Teknologi Industri Pertanian (TIP)",
            "S2 - Teknologi Kelautan (TEK)", "S2 - Teknologi Pangan (TPN)", "S2 - Teknologi Pascapanen", "S2 - Teknologi Perikanan Laut (TPL)",
            "S2 - Teknologi Perikanan Tangkap (TPT)", "S2 - Teknologi Serat dan Komposit (TSK)", "S3 - Agronomi dan Hortikultura (AGH)",
            "S3 - Biokimia (BIK)", "S3 - Biologi Reproduksi (BRP)", "S3 - Biologi Tumbuhan (BOT)", "S3 - Biosains Hewan (BSH)",
            "S3 - Ekonomi Kelautan Tropika (EKT)", "S3 - Ekonomi Sumberdaya Kelautan Tropika (EKT)", "S3 - Ekonomi Sumberdaya Kelautan Tropika (ESK)",
            "S3 - Entomologi (ENT)", "S3 - Exchange Doktor", "S3 - Fisika (FIS)", "S3 - Fitopatologi (FIT)", "S3 - Ilmu Akuakultur (AKU)",
            "S3 - Ilmu Biomedis Hewan (IBH)", "S3 - Ilmu dan Teknologi Benih (ITB)", "S3 - Ilmu Dan Teknologi Hasil Hutan'",
            "S3 - Ilmu dan Teknologi Hasil Hutan (THH)", "S3 - Ilmu Ekonomi (EKO)", "S3 - Ilmu Ekonomi Pertanian (EPN)",
            "S3 - Ilmu Gizi (GIZ)", "S3 - Ilmu Gizi Manusia (GMA)", "S3 - Ilmu Kelautan (IKL)", "S3 - Ilmu Keluarga",
            "S3 - Ilmu Keteknikan Pertanian (TEP)", "S3 - Ilmu Kimia (KIM)", "S3 - Ilmu Komputer (KOM)", "S3 - Ilmu Nutrisi dan Pakan (INP)",
            "S3 - Ilmu Pangan (IPN)", "S3 - ILMU PENGELOLAAN HUTAN'", "S3 - Ilmu Pengelolaan Hutan (IPH)",
            "S3 - Ilmu Pengelolaan Sumberdaya Alam dan Lingkungan (PSL)", "S3 - Ilmu Perencanaan Pembangunan Wilayah dan Pedesaan (PWD)",
            "S3 - Ilmu Produksi dan Teknologi Peternakan (ITP)", "S3 - Ilmu Tanah (TNH)", "S3 - Ilmu-Ilmu Faal dan Khasiat Obat (IFO)",
            "S3 - Kesehatan Masyarakat Veteriner (KMV)", "S3 - Klimatologi Terapan (KLI)", "S3 - Komunikasi Pembangunan Pertanian dan Pedesaan (KMP)",
            "S3 - Konservasi Biodiversitas Tropika", "S3 - Manajemen dan Bisnis (MB)", "S3 - Manajemen Ekowisata dan Jasa Lingkungan (MEJ)",
            "S3 - Mikrobiologi (MIK)", "S3 - Parasitologi dan Entomologi Kesehatan (PEK)", "S3 - Pemuliaan dan Bioteknologi Tanaman (PBT)",
            "S3 - Pengelolaan Daerah Aliran Sungai (DAS)", "S3 - Pengelolaan Sumberdaya Perairan (SDP)", "S3 - Pengelolaan Sumberdaya Pesisir dan Lautan (SPL)",
            "S3 - Penyuluhan Pembangunan (PPN)", "S3 - Primatologi (PRM)", "S3 - Rekayasa dan Peningkatan Mutu Hasil Hutan (RPM)",
            "S3 - Sains Agribisnis (AGB)", "S3 - Silvikultur Tropika", "S3 - Sistem dan Pemodelan Perikanan Tangkap (SPT)",
            "S3 - Sosiologi Pedesaan (SPD)", "S3 - Statistika (STK)", "S3 - Statistika dan Sains Data (SSD)",
            "S3 - Teknik Industri Pertanian (TIP)", "S3 - Teknologi Hasil Perairan (THP)", "S3 - Teknologi Industri Pertanian (TIP)",
            "S3 - Teknologi Kelautan (TEK)", "S3 - Teknologi Perikanan Laut (TPL)", "S3 - Teknologi Perikanan Tangkap (TPT)",
            "S3 - Teknologi Serat dan Komposit (TSK)"
        ];

        return view('pages.pendidikan', [
            'dosenAktif' => $dosenAktif,
            'tahunAkademikOptions' => $tahunAkademikOptions,
            'programStudi' => $programStudi,
            'dataPengajaranLama' => $this->getFilteredData($request, PengajaranLama::class, ['nama_mk', 'kode_mk'], 'pengajaran_lama_page'),
            'dataPengajaranLuar' => $this->getFilteredData($request, PengajaranLuar::class, ['universitas', 'nama_mk'], 'pengajaran_luar_page'),
            'dataPengujianLama' => $this->getFilteredData($request, PengujianLama::class, ['nama_mahasiswa', 'nim', 'departemen'], 'pengujian_lama_page'),
            'dataPembimbingLama' => $this->getFilteredData($request, PembimbingLama::class, ['kegiatan', 'nama_mahasiswa'], 'pembimbing_lama_page'),
            'dataPengujiLuar' => $this->getFilteredData($request, PengujiLuar::class, ['nama_mahasiswa', 'universitas'], 'penguji_luar_page'),
            'dataPembimbingLuar' => $this->getFilteredData($request, PembimbingLuar::class, ['nama_mahasiswa', 'universitas'], 'pembimbing_luar_page'),
        ]);
    }

    // Fungsi untuk meng-handle upload file
    private function handleFileUpload(Request $request, $fieldName, $directory, $existingPath = null) {
        if ($request->hasFile($fieldName)) {
            if ($existingPath) {
                Storage::disk('public')->delete($existingPath);
            }
            return $request->file($fieldName)->store($directory, 'public');
        }
        return $existingPath;
    }

    private function storeData(Request $request, $modelClass, $validationRules, $directory) {
        $validationRules['pegawai_id'] = 'required|exists:pegawais,id';
        $validationRules['file'] = 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:5120';
        
        $validator = Validator::make($request->all(), $validationRules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->except(['file', 'id']);
        $data['file_path'] = $this->handleFileUpload($request, 'file', $directory);
        
        $modelClass::create($data);
        return response()->json(['success' => 'Data berhasil ditambahkan.']);
    }

    private function editData($modelClass, $id) {
        $data = $modelClass::find($id);
        return $data ? response()->json($data) : response()->json(['error' => 'Data tidak ditemukan.'], 404);
    }
    
    private function updateData(Request $request, $id, $modelClass, $validationRules, $directory) {
        $dataModel = $modelClass::find($id);
        if (!$dataModel) {
            return response()->json(['error' => 'Data tidak ditemukan.'], 404);
        }

        $validationRules['pegawai_id'] = 'required|exists:pegawais,id';
        $validationRules['file'] = 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:5120';

        $validator = Validator::make($request->all(), $validationRules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $data = $request->except(['file', 'id', '_method']);
        $data['file_path'] = $this->handleFileUpload($request, 'file', $directory, $dataModel->file_path);

        $dataModel->update($data);
        return response()->json(['success' => 'Data berhasil diperbarui.']);
    }

    public function storePengajaranLama(Request $request) {
        return $this->storeData($request, PengajaranLama::class, ['tahun_semester' => 'required', 'nama_mk' => 'required', 'kode_mk' => 'required', 'jenis' => 'required', 'kelas_paralel' => 'required', 'jumlah_pertemuan' => 'required|integer'], 'pendidikan/pengajaran-lama');
    }
    public function editPengajaranLama($id) { return $this->editData(PengajaranLama::class, $id); }
    public function updatePengajaranLama(Request $request, $id) {
        return $this->updateData($request, $id, PengajaranLama::class, ['tahun_semester' => 'required', 'nama_mk' => 'required', 'kode_mk' => 'required', 'jenis' => 'required', 'kelas_paralel' => 'required', 'jumlah_pertemuan' => 'required|integer'], 'pendidikan/pengajaran-lama');
    }
    public function showPengajaranLama($id) { return $this->showDetail(PengajaranLama::class, $id); }

    public function storePengajaranLuar(Request $request) {
        return $this->storeData($request, PengajaranLuar::class, ['tahun_semester' => 'required', 'kode_mk' => 'required', 'nama_mk' => 'required', 'universitas' => 'required', 'strata' => 'required', 'program_studi' => 'required', 'jenis' => 'required', 'kelas_paralel' => 'required', 'jumlah_pertemuan' => 'required|integer', 'is_insidental' => 'required', 'is_lebih_satu_semester' => 'required'], 'pendidikan/pengajaran-luar');
    }
    public function editPengajaranLuar($id) { return $this->editData(PengajaranLuar::class, $id); }
    public function updatePengajaranLuar(Request $request, $id) {
        return $this->updateData($request, $id, PengajaranLuar::class, ['tahun_semester' => 'required', 'kode_mk' => 'required', 'nama_mk' => 'required', 'universitas' => 'required', 'strata' => 'required', 'program_studi' => 'required', 'jenis' => 'required', 'kelas_paralel' => 'required', 'jumlah_pertemuan' => 'required|integer', 'is_insidental' => 'required', 'is_lebih_satu_semester' => 'required'], 'pendidikan/pengajaran-luar');
    }
    public function showPengajaranLuar($id) { return $this->showDetail(PengajaranLuar::class, $id); }

    public function storePengujianLama(Request $request) {
        return $this->storeData($request, PengujianLama::class, ['kegiatan' => 'required', 'strata' => 'required', 'tahun_semester' => 'required', 'nim' => 'required', 'nama_mahasiswa' => 'required', 'departemen' => 'required'], 'pendidikan/pengujian-lama');
    }
    public function editPengujianLama($id) { return $this->editData(PengujianLama::class, $id); }
    public function updatePengujianLama(Request $request, $id) {
        return $this->updateData($request, $id, PengujianLama::class, ['kegiatan' => 'required', 'strata' => 'required', 'tahun_semester' => 'required', 'nim' => 'required', 'nama_mahasiswa' => 'required', 'departemen' => 'required'], 'pendidikan/pengujian-lama');
    }
    public function showPengujianLama($id) { return $this->showDetail(PengujianLama::class, $id); }

    public function storePembimbingLama(Request $request) {
        return $this->storeData($request, PembimbingLama::class, ['kegiatan' => 'required', 'tahun_semester' => 'required', 'nim' => 'required', 'nama_mahasiswa' => 'required', 'departemen' => 'required'], 'pendidikan/pembimbing-lama');
    }
    public function editPembimbingLama($id) { return $this->editData(PembimbingLama::class, $id); }
    public function updatePembimbingLama(Request $request, $id) {
        return $this->updateData($request, $id, PembimbingLama::class, ['kegiatan' => 'required', 'tahun_semester' => 'required', 'nim' => 'required', 'nama_mahasiswa' => 'required', 'departemen' => 'required'], 'pendidikan/pembimbing-lama');
    }
    public function showPembimbingLama($id) { return $this->showDetail(PembimbingLama::class, $id); }

    public function storePengujiLuar(Request $request) {
        return $this->storeData($request, PengujiLuar::class, ['kegiatan' => 'required', 'status' => 'required', 'tahun_semester' => 'required', 'nim' => 'required', 'nama_mahasiswa' => 'required', 'universitas' => 'required', 'strata' => 'required', 'program_studi' => 'required', 'is_insidental' => 'required', 'is_lebih_satu_semester' => 'required'], 'pendidikan/penguji-luar');
    }
    public function editPengujiLuar($id) { return $this->editData(PengujiLuar::class, $id); }
    public function updatePengujiLuar(Request $request, $id) {
        return $this->updateData($request, $id, PengujiLuar::class, ['kegiatan' => 'required', 'status' => 'required', 'tahun_semester' => 'required', 'nim' => 'required', 'nama_mahasiswa' => 'required', 'universitas' => 'required', 'strata' => 'required', 'program_studi' => 'required', 'is_insidental' => 'required', 'is_lebih_satu_semester' => 'required'], 'pendidikan/penguji-luar');
    }
    public function showPengujiLuar($id) { return $this->showDetail(PengujiLuar::class, $id); }

    public function storePembimbingLuar(Request $request) {
        return $this->storeData($request, PembimbingLuar::class, ['kegiatan' => 'required', 'status' => 'required', 'tahun_semester' => 'required', 'nim' => 'required', 'nama_mahasiswa' => 'required', 'universitas' => 'required', 'program_studi' => 'required', 'is_insidental' => 'required', 'is_lebih_satu_semester' => 'required'], 'pendidikan/pembimbing-luar');
    }
    public function editPembimbingLuar($id) { return $this->editData(PembimbingLuar::class, $id); }
    public function updatePembimbingLuar(Request $request, $id) {
        return $this->updateData($request, $id, PembimbingLuar::class, ['kegiatan' => 'required', 'status' => 'required', 'tahun_semester' => 'required', 'nim' => 'required', 'nama_mahasiswa' => 'required', 'universitas' => 'required', 'program_studi' => 'required', 'is_insidental' => 'required', 'is_lebih_satu_semester' => 'required'], 'pendidikan/pembimbing-luar');
    }
    public function showPembimbingLuar($id) { return $this->showDetail(PembimbingLuar::class, $id); }

    private function showDetail($model, $id) {
        $data = $model::with('pegawai')->find($id);
        return $data ? response()->json($data) : response()->json(['error' => 'Data tidak ditemukan.'], 404);
    }

    public function verifikasi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'type' => 'required|string',
            'status' => 'required|in:diverifikasi,ditolak',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Data tidak valid.'], 422);
        }

        $modelMapping = [
            'pengajaran-lama' => PengajaranLama::class, 'pengajaran-luar' => PengajaranLuar::class,
            'pengujian-lama' => PengujianLama::class, 'pembimbing-lama' => PembimbingLama::class,
            'penguji-luar' => PengujiLuar::class, 'pembimbing-luar' => PembimbingLuar::class,
        ];

        $type = $request->input('type');
        if (!isset($modelMapping[$type])) {
            return response()->json(['error' => 'Tipe data tidak valid.'], 400);
        }

        $modelClass = $modelMapping[$type];
        $record = $modelClass::find($request->input('id'));

        if (!$record) {
            return response()->json(['error' => 'Data tidak ditemukan.'], 404);
        }

        $record->status_verifikasi = $request->input('status');
        $record->save();

        return response()->json(['success' => 'Status verifikasi berhasil diperbarui.']);
    }

    public function hapus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'type' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Data tidak valid.'], 422);
        }

        $modelMapping = [
            'pengajaran-lama' => PengajaranLama::class, 'pengajaran-luar' => PengajaranLuar::class,
            'pengujian-lama' => PengujianLama::class, 'pembimbing-lama' => PembimbingLama::class,
            'penguji-luar' => PengujiLuar::class, 'pembimbing-luar' => PembimbingLuar::class,
        ];

        $type = $request->input('type');
        if (!isset($modelMapping[$type])) {
            return response()->json(['error' => 'Tipe data tidak valid.'], 400);
        }

        $modelClass = $modelMapping[$type];
        $record = $modelClass::find($request->input('id'));

        if (!$record) {
            return response()->json(['error' => 'Data tidak ditemukan.'], 404);
        }

        if ($record->file_path) {
            Storage::disk('public')->delete($record->file_path);
        }

        $record->delete();

        return response()->json(['success' => 'Data berhasil dihapus.']);
    }
}