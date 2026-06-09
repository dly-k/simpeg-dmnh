<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\Penelitian;
use App\Models\Pengabdian;
use App\Models\Penghargaan;
use App\Models\Pelatihan;
use App\Models\Kerjasama;
use App\Models\Pembicara;
use App\Models\SertifikatKompetensi;
use App\Models\Penunjang;
use App\Models\SuratTugas;
use App\Models\PengajaranLama;
use App\Models\PembimbingLama;
use App\Models\PengujianLama;
use App\Models\PengajaranLuar;
use App\Models\PembimbingLuar;
use App\Models\PengujiLuar;
use App\Models\PenulisPenelitian;
use App\Models\PengabdianAnggota;
use App\Models\PenunjangAnggota;
use App\Models\Praktisi;
use App\Models\PengelolaJurnal;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'dosen') {
            return redirect()->route('monitoring.dosen.index');
        }

        $dosenStatuses = ['Dosen PNS', 'Dosen Tetap', 'Dosen Tamu'];
        $tendikStatuses = ['Tendik PNS', 'Tendik Tetap', 'Tendik Kontrak', 'Tenaga Harian Lepas (THL)'];

        // --- Kartu Metriks Dasar ---
        $totalPegawaiAktif = Pegawai::where('status_pegawai', 'Aktif')->count();
        $totalDosen = Pegawai::where('status_pegawai', 'Aktif')->whereIn('status_kepegawaian', $dosenStatuses)->count();
        $totalTendik = Pegawai::where('status_pegawai', 'Aktif')->whereIn('status_kepegawaian', $tendikStatuses)->count();
        
        $totalSuratTugas = SuratTugas::count();
        $totalKerjasama = Kerjasama::count();
        $totalPelatihan = Pelatihan::count();
        $totalPenghargaan = Penghargaan::count();
        $totalPraktisi = Praktisi::count();
        $totalPembicara = Pembicara::count();
        $totalPengabdian = Pengabdian::count();
        $totalPenunjang = Penunjang::count();
        $totalSemuaPendidikan = PengajaranLama::count() + PembimbingLama::count() + PengujianLama::count() + PengajaranLuar::count() + PembimbingLuar::count() + PengujiLuar::count();
        $totalSertifikatKompetensi = SertifikatKompetensi::count();
        $totalPengelolaJurnal = PengelolaJurnal::count();
        $totalPenelitian = Penelitian::count();

        $totalSubmisi = $totalPelatihan + $totalPenghargaan + $totalPraktisi + $totalPembicara + $totalPengabdian + $totalPenunjang + $totalSertifikatKompetensi + $totalSemuaPendidikan + $totalPengelolaJurnal + $totalPenelitian;

        // --- Growth ---
        $startThisMonth = Carbon::now()->startOfMonth();
        $startLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endLastMonth = Carbon::now()->subMonth()->endOfMonth();

        $getMonthlyCount = function ($model, $column = 'created_at') use ($startThisMonth, $startLastMonth, $endLastMonth) {
            $thisMonth = $model::where($column, '>=', $startThisMonth)->count();
            $lastMonth = $model::whereBetween($column, [$startLastMonth, $endLastMonth])->count();
            return [$thisMonth, $lastMonth];
        };

        $models = [Pelatihan::class, Penelitian::class, Pengabdian::class, Penghargaan::class, Penunjang::class, Praktisi::class, Pembicara::class, SertifikatKompetensi::class, PengelolaJurnal::class];

        $bulanIni = 0; $bulanLalu = 0;
        foreach ($models as $model) {
            [$now, $last] = $getMonthlyCount($model);
            $bulanIni += $now; $bulanLalu += $last;
        }
        
        $growthSubmisi = $bulanLalu > 0 ? (($bulanIni - $bulanLalu) / $bulanLalu) * 100 : 0;
        [$suratNow, $suratLast] = $getMonthlyCount(SuratTugas::class);
        $growthSuratTugas = $suratLast > 0 ? (($suratNow - $suratLast) / $suratLast) * 100 : 0;
        [$kerjaNow, $kerjaLast] = $getMonthlyCount(Kerjasama::class);
        $growthKerjasama = $kerjaLast > 0 ? (($kerjaNow - $kerjaLast) / $kerjaLast) * 100 : 0;

        // ========================================================================
        // 1. PENDIDIKAN
        // ========================================================================
        $pendidikanData = Pegawai::select('nama_lengkap', 'pendidikan_terakhir', 'status_kepegawaian')
            ->where('status_pegawai', 'Aktif')->whereNotNull('pendidikan_terakhir')->get();

        $pendidikanLabels = $pendidikanData->pluck('pendidikan_terakhir')->unique()->sort()->values();
        $pendidikanDosen = []; $pendidikanTendik = []; $pegawaiByPendidikan = [];

        foreach ($pendidikanLabels as $label) {
            $dosenCount = 0; $tendikCount = 0;
            $pegawaiByPendidikan[$label] = [];

            foreach ($pendidikanData->where('pendidikan_terakhir', $label) as $p) {
                $isDosen = in_array($p->status_kepegawaian, $dosenStatuses);
                if ($isDosen) $dosenCount++; else $tendikCount++;
                $pegawaiByPendidikan[$label][] = ['nama' => $p->nama_lengkap, 'kategori' => $isDosen ? 'Dosen' : 'Tendik'];
            }
            $pendidikanDosen[] = $dosenCount;
            $pendidikanTendik[] = $tendikCount;
        }

        // ========================================================================
        // 2. JABATAN
        // ========================================================================
        $jabatanList = ['Guru Besar', 'Lektor Kepala', 'Lektor', 'Asisten Ahli', 'Dosen'];
        $jabatanLabels = $jabatanList;
        $jabatanLaki = []; $jabatanPerempuan = []; $pegawaiByJabatanGender = [];

        $jabatanData = Pegawai::select('nama_lengkap', 'jabatan_fungsional', 'jenis_kelamin')
            ->where('status_pegawai', 'Aktif')->whereNotNull('jabatan_fungsional')->get();

        foreach ($jabatanList as $jabatan) {
            $filtered = $jabatanData->where('jabatan_fungsional', $jabatan);
            $laki = $filtered->where('jenis_kelamin', 'Laki-laki');
            $perempuan = $filtered->where('jenis_kelamin', 'Perempuan');

            $jabatanLaki[] = $laki->count();
            $jabatanPerempuan[] = $perempuan->count();
            $pegawaiByJabatanGender[$jabatan] = [
                'Laki-laki' => $laki->pluck('nama_lengkap')->toArray(),
                'Perempuan' => $perempuan->pluck('nama_lengkap')->toArray()
            ];
        }

        // ========================================================================
        // 3. PANGKAT
        // ========================================================================
        $pangkatData = Pegawai::select('nama_lengkap', 'pangkat_golongan', 'status_kepegawaian')
            ->where('status_pegawai', 'Aktif')->whereNotNull('pangkat_golongan')->get();

        $pangkatDosen = $pangkatData->whereIn('status_kepegawaian', $dosenStatuses)->groupBy('pangkat_golongan')->map->count();
        $pangkatDosenData = $pangkatDosen; 
        $pangkatTendikData = $pangkatData->whereIn('status_kepegawaian', $tendikStatuses)->groupBy('pangkat_golongan')->map->count();

        $pegawaiByPangkat = [];
        foreach($pangkatData->groupBy('pangkat_golongan') as $pangkat => $items) {
            $pegawaiByPangkat[$pangkat] = $items->map(function($i) use ($dosenStatuses) {
                return ['nama' => $i->nama_lengkap, 'kategori' => in_array($i->status_kepegawaian, $dosenStatuses) ? 'Dosen' : 'Tendik'];
            })->toArray();
        }

        // ========================================================================
        // 4. UMUR (LANGSUNG SIAPKAN DETAIL UNTUK MODAL)
        // ========================================================================
        $pegawaiUmurDB = Pegawai::select('nama_lengkap', 'status_kepegawaian', 'tanggal_lahir', DB::raw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) AS umur'))
            ->where('status_pegawai', 'Aktif')->whereNotNull('tanggal_lahir')->get();

        $ageDosen = ['<= 35 Tahun'=>0, '36 - 40 Tahun'=>0, '41 - 50 Tahun'=>0, '51 - 60 Tahun'=>0, '61 - 70 Tahun'=>0];
        $ageTendik = ['<= 26 Tahun'=>0, '27 - 30 Tahun'=>0, '31 - 40 Tahun'=>0, '41 - 50 Tahun'=>0, '51 - 55 Tahun'=>0, '56 - 58 Tahun'=>0];

        $pegawaiUmurDosenDetail = ['<= 35 Tahun'=>[], '36 - 40 Tahun'=>[], '41 - 50 Tahun'=>[], '51 - 60 Tahun'=>[], '61 - 70 Tahun'=>[]];
        $pegawaiUmurTendikDetail = ['<= 26 Tahun'=>[], '27 - 30 Tahun'=>[], '31 - 40 Tahun'=>[], '41 - 50 Tahun'=>[], '51 - 55 Tahun'=>[], '56 - 58 Tahun'=>[]];

        foreach ($pegawaiUmurDB as $p) {
            $umur = $p->umur;
            $isDosen = in_array($p->status_kepegawaian, $dosenStatuses);
            $tgl_lahir_str = date('d M Y', strtotime($p->tanggal_lahir));
            
            if ($isDosen) {
                if ($umur <= 35) $key = '<= 35 Tahun';
                elseif ($umur <= 40) $key = '36 - 40 Tahun';
                elseif ($umur <= 50) $key = '41 - 50 Tahun';
                elseif ($umur <= 60) $key = '51 - 60 Tahun';
                else $key = '61 - 70 Tahun';

                $ageDosen[$key]++;
                $pegawaiUmurDosenDetail[$key][] = ['nama' => $p->nama_lengkap, 'umur' => $umur, 'tgl_lahir' => $tgl_lahir_str];
            } else {
                if ($umur <= 26) $key = '<= 26 Tahun';
                elseif ($umur <= 30) $key = '27 - 30 Tahun';
                elseif ($umur <= 40) $key = '31 - 40 Tahun';
                elseif ($umur <= 50) $key = '41 - 50 Tahun';
                elseif ($umur <= 55) $key = '51 - 55 Tahun';
                else $key = '56 - 58 Tahun';

                $stat = strtolower($p->status_kepegawaian);
                $subKat = 'Non PNS/Kontrak';
                if (strpos($stat, 'pns') !== false) $subKat = 'PNS';
                elseif (strpos($stat, 'thl') !== false || strpos($stat, 'lepas') !== false) $subKat = 'THL';

                $ageTendik[$key]++;
                $pegawaiUmurTendikDetail[$key][] = ['nama' => $p->nama_lengkap, 'umur' => $umur, 'tgl_lahir' => $tgl_lahir_str, 'sub_kategori' => $subKat];
            }
        }

        // --- LINE CHART: Tren Submisi Tahunan ---
        $years = collect(range(date('Y') - 2, date('Y'))); 
        $initYearArray = function () use ($years) { return collect(array_fill_keys($years->toArray(), 0)); };

        $pendidikanModels = [PengajaranLama::class, PembimbingLama::class, PengujianLama::class, PengajaranLuar::class, PembimbingLuar::class, PengujiLuar::class];
        $pendidikanTrend = $initYearArray();

        foreach ($pendidikanModels as $model) {
            $data = app($model)->select(DB::raw('YEAR(created_at) as year'), DB::raw('count(*) as total'))->groupBy('year')->pluck('total', 'year');
            foreach ($data as $year => $count) { if ($pendidikanTrend->has($year)) { $pendidikanTrend[$year] += $count; } }
        }

        $penelitianData = Penelitian::select(DB::raw('YEAR(created_at) as year'), DB::raw('count(*) as total'))->groupBy('year')->pluck('total', 'year');
        $penelitianFinal = $initYearArray();
        foreach ($penelitianData as $year => $count) { if ($penelitianFinal->has($year)) { $penelitianFinal[$year] = $count; } }

        $pengabdianData = Pengabdian::select(DB::raw('YEAR(created_at) as year'), DB::raw('count(*) as total'))->groupBy('year')->pluck('total', 'year');
        $pengabdianFinal = $initYearArray();
        foreach ($pengabdianData as $year => $count) { if ($pengabdianFinal->has($year)) { $pengabdianFinal[$year] = $count; } }

        $penunjangData = $initYearArray();
        $pData = Penunjang::select(DB::raw('YEAR(created_at) as year'), DB::raw('count(*) as total'))->groupBy('year')->pluck('total', 'year');
        foreach ($pData as $year => $count) { if ($penunjangData->has($year)) { $penunjangData[$year] += $count; } }

        $lineChartLabels = $years->toArray();
        $lineChartDatasets = [
            ['label' => 'Pendidikan', 'data' => array_values($pendidikanTrend->toArray())],
            ['label' => 'Penelitian', 'data' => array_values($penelitianFinal->toArray())],
            ['label' => 'Pengabdian', 'data' => array_values($pengabdianFinal->toArray())],
            ['label' => 'Penunjang', 'data' => array_values($penunjangData->toArray())]
        ];

        // --- PIE CHART: Jumlah Submisi per Kategori --- 
        $pieChartData = [
            'Pendidikan' => $totalSemuaPendidikan, 'Penelitian' => $totalPenelitian, 'Pengabdian' => $totalPengabdian,
            'Pelatihan' => $totalPelatihan + $totalSertifikatKompetensi, 'Penghargaan' => $totalPenghargaan,
            'Penunjang' => $totalPenunjang + $totalPraktisi + $totalPengelolaJurnal,
        ];

        $submissionCounts = [];
        $addCounts = function ($counts) use (&$submissionCounts) {
            foreach ($counts as $pegawai_id => $total) { $submissionCounts[$pegawai_id] = ($submissionCounts[$pegawai_id] ?? 0) + $total; }
        };

        foreach ([Pelatihan::class, Penghargaan::class] as $modelClass) {
            $counts = app($modelClass)->select('pegawai_id', DB::raw('COUNT(*) as total'))->whereNotNull('pegawai_id')->groupBy('pegawai_id')->pluck('total', 'pegawai_id');
            $addCounts($counts);
        }

        $counts = SertifikatKompetensi::select('pegawai_id', DB::raw('COUNT(*) as total'))->whereNotNull('pegawai_id')->whereRaw("LOWER(TRIM(verifikasi)) = 'sudah diverifikasi'")->groupBy('pegawai_id')->pluck('total', 'pegawai_id');
        $addCounts($counts);

        $otherModels = [PengajaranLama::class, PembimbingLama::class, PengujianLama::class, PengajaranLuar::class, PembimbingLuar::class, PengujiLuar::class, PenunjangAnggota::class, Praktisi::class, Pembicara::class, PengelolaJurnal::class];
        foreach ($otherModels as $modelClass) {
            $model = app($modelClass); $table = $model->getTable();
            $query = $model->select('pegawai_id', DB::raw('COUNT(*) as total'))->whereNotNull('pegawai_id');
            if (Schema::hasColumn($table, 'status_verifikasi')) { $query->whereIn(DB::raw("LOWER(TRIM(status_verifikasi))"), ['diverifikasi', 'sudah diverifikasi']); } 
            elseif (Schema::hasColumn($table, 'status')) { $query->whereIn(DB::raw("LOWER(TRIM(status))"), ['diverifikasi', 'sudah diverifikasi']); } 
            elseif (Schema::hasColumn($table, 'verifikasi')) { $query->whereIn(DB::raw("LOWER(TRIM(verifikasi))"), ['diverifikasi', 'sudah diverifikasi']); } 
            else { continue; }
            $addCounts($query->groupBy('pegawai_id')->pluck('total', 'pegawai_id'));
        }

        $joinQueries = [
            PengabdianAnggota::select('pengabdian_anggotas.pegawai_id', DB::raw('COUNT(*) as total'))->join('pengabdians', 'pengabdian_anggotas.pengabdian_id', '=', 'pengabdians.id')->whereNotNull('pengabdian_anggotas.pegawai_id')->whereRaw("LOWER(TRIM(pengabdians.status)) = 'sudah diverifikasi'")->groupBy('pengabdian_anggotas.pegawai_id'),
            PenunjangAnggota::select('penunjang_anggotas.pegawai_id', DB::raw('COUNT(*) as total'))->join('penunjangs', 'penunjang_anggotas.penunjang_id', '=', 'penunjangs.id')->whereNotNull('penunjang_anggotas.pegawai_id')->whereRaw("LOWER(TRIM(penunjangs.status)) = 'sudah diverifikasi'")->groupBy('penunjang_anggotas.pegawai_id'),
            PenulisPenelitian::select('penulis_penelitian.pegawai_id', DB::raw('COUNT(*) as total'))->join('penelitian', 'penulis_penelitian.penelitian_id', '=', 'penelitian.id')->whereNotNull('penulis_penelitian.pegawai_id')->whereRaw("LOWER(TRIM(penelitian.status)) = 'sudah diverifikasi'")->groupBy('penulis_penelitian.pegawai_id'),
        ];
        foreach ($joinQueries as $query) { $addCounts($query->pluck('total', 'pegawai_id')); }

        arsort($submissionCounts);
        $topPegawaiIds = array_slice(array_keys($submissionCounts), 0, 5);
        $topPegawai = Pegawai::whereIn('id', $topPegawaiIds)->get()->map(function ($pegawai) use ($submissionCounts) {
            $pegawai->final_score = $submissionCounts[$pegawai->id] ?? 0; return $pegawai;
        })->sortByDesc('final_score')->values();

        // --- TABEL STATUS VERIFIKASI ---
        $startDate = Carbon::now()->subMonth();
        $statusCounts = [
            'Praktisi Dunia Industri' => ['menunggu' => 0, 'diverifikasi' => 0, 'ditolak' => 0], 'Pembicara' => ['menunggu' => 0, 'diverifikasi' => 0, 'ditolak' => 0],
            'Pengabdian' => ['menunggu' => 0, 'diverifikasi' => 0, 'ditolak' => 0], 'Penunjang' => ['menunggu' => 0, 'diverifikasi' => 0, 'ditolak' => 0],
            'Sertifikat Kompetensi' => ['menunggu' => 0, 'diverifikasi' => 0, 'ditolak' => 0], 'Pendidikan / Akademik' => ['menunggu' => 0, 'diverifikasi' => 0, 'ditolak' => 0],
            'Pengelola Jurnal' => ['menunggu' => 0, 'diverifikasi' => 0, 'ditolak' => 0], 'Penelitian' => ['menunggu' => 0, 'diverifikasi' => 0, 'ditolak' => 0],
        ];

        $otherModelsTable = [
            'Praktisi Dunia Industri' => [Praktisi::class, 'status'], 'Pembicara' => [Pembicara::class, 'status_verifikasi'],
            'Pengabdian' => [Pengabdian::class, 'status'], 'Penunjang' => [Penunjang::class, 'status'],
            'Sertifikat Kompetensi' => [SertifikatKompetensi::class, 'verifikasi'], 'Pengelola Jurnal' => [PengelolaJurnal::class, 'status_verifikasi'],
            'Penelitian' => [Penelitian::class, 'status'],
        ];

        foreach ($otherModelsTable as $category => [$model, $column]) {
            $result = $model::where('created_at', '>=', $startDate)->select($column, DB::raw('count(*) as total'))->groupBy($column)->pluck('total', $column);
            $statusCounts[$category]['menunggu'] = ($result['Belum Diverifikasi'] ?? 0) + ($result['belum diverifikasi'] ?? 0);
            $statusCounts[$category]['diverifikasi'] = ($result['Sudah Diverifikasi'] ?? 0) + ($result['sudah diverifikasi'] ?? 0) + ($result['diverifikasi'] ?? 0);
            $statusCounts[$category]['ditolak'] = ($result['Ditolak'] ?? 0) + ($result['ditolak'] ?? 0);
        }

        foreach ($pendidikanModels as $model) {
            $result = $model::where('created_at', '>=', $startDate)->select('status_verifikasi', DB::raw('count(*) as total'))->groupBy('status_verifikasi')->pluck('total', 'status_verifikasi');
            $statusCounts['Pendidikan / Akademik']['menunggu'] += $result['belum diverifikasi'] ?? 0;
            $statusCounts['Pendidikan / Akademik']['diverifikasi'] += $result['diverifikasi'] ?? 0;
            $statusCounts['Pendidikan / Akademik']['ditolak'] += $result['ditolak'] ?? 0;
        }

        $dosenList = Pegawai::where('status_pegawai', 'Aktif')->whereIn('status_kepegawaian', $dosenStatuses)->orderBy('nama_lengkap')->pluck('nama_lengkap')->toArray();
        $tendikList = Pegawai::where('status_pegawai', 'Aktif')->whereIn('status_kepegawaian', $tendikStatuses)->orderBy('nama_lengkap')->pluck('nama_lengkap')->toArray();

        $submisiBreakdown = [
            'Pendidikan / Akademik' => $totalSemuaPendidikan, 'Penelitian' => $totalPenelitian, 'Pengabdian' => $totalPengabdian,
            'Diklat & Sertifikasi' => $totalPelatihan + $totalSertifikatKompetensi,
            'Penunjang (Praktisi, Jurnal, Pembicara)' => $totalPenunjang + $totalPraktisi + $totalPengelolaJurnal + $totalPembicara,
            'Penghargaan' => $totalPenghargaan,
        ];

        return view('pages.dashboard', compact(
            'totalPegawaiAktif', 'totalSemuaPendidikan', 'totalDosen', 'totalTendik',
            'totalPenelitian', 'totalPelatihan', 'totalPraktisi', 'totalPembicara', 'totalPengelolaJurnal',
            'totalPengabdian', 'totalPenghargaan', 'growthSuratTugas', 'growthKerjasama',
            'totalSertifikatKompetensi', 'totalPenunjang',
            'totalSuratTugas', 'totalKerjasama', 'lineChartLabels', 'lineChartDatasets', 'pieChartData', 'topPegawai', 'statusCounts',
            'pendidikanLabels', 'pendidikanDosen', 'pendidikanTendik', 'pendidikanTrend', 'jabatanLabels', 'jabatanLaki', 'jabatanPerempuan', 'pangkatDosen',
            'totalSubmisi', 'growthSubmisi', 'pangkatDosenData', 'pangkatTendikData', 
            'pegawaiByPendidikan', 'pegawaiByJabatanGender', 'pegawaiByPangkat',
            'ageDosen', 'ageTendik', 'pegawaiUmurDosenDetail', 'pegawaiUmurTendikDetail', // <--- Variabel Detail Umur Baru
            'dosenList', 'tendikList', 'submisiBreakdown'
        ));
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications->find($id);
        if ($notification) {
            $notification->markAsRead(); 
            return redirect($notification->data['url'] ?? '/dashboard');
        }
        return back();
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi berhasil ditandai telah dibaca.');
    }
}