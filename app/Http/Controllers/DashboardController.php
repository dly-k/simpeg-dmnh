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
        // --- Kartu Metriks ---
        $totalPegawaiAktif = Pegawai::where('status_pegawai', 'Aktif')->count();
        $totalSuratTugas = SuratTugas::count();
        $totalKerjasama = Kerjasama::count();
                     
        $totalPenelitian = Penelitian::count();
        $totalPengabdian = Pengabdian::count();
        $totalPenghargaan = Penghargaan::count();
        $totalPenunjang = Penunjang::count();
        $totalSertifikatKompetensi = SertifikatKompetensi::count();
        $totalSemuaPendidikan = PengajaranLama::count() + PembimbingLama::count() + PengujianLama::count() + PengajaranLuar::count() + PembimbingLuar::count() + PengujiLuar::count();

        // --- Distribusi Status Pendidikan ---
        $distribusiPendidikan = Pegawai::select('pendidikan_terakhir', DB::raw('count(*) as total'))
            ->whereNotNull('pendidikan_terakhir')
            ->where('status_pegawai','Aktif')
            ->groupBy('pendidikan_terakhir')
            ->pluck('total','pendidikan_terakhir');

        $pegawaiByPendidikan = \App\Models\Pegawai::select('nama_lengkap','pendidikan_terakhir')
            ->where('status_pegawai','Aktif')
            ->whereNotNull('pendidikan_terakhir')
            ->get()
            ->groupBy('pendidikan_terakhir')
            ->map(function ($items) {
                return $items->pluck('nama_lengkap');
        });

        $pendidikanLabels = $distribusiPendidikan->keys();
        $pendidikanData = $distribusiPendidikan->values();

        // --- Distribusi Pangkat Dosen ---
        $pangkatDosen = Pegawai::select('pangkat_golongan', DB::raw('count(*) as total'))
            ->whereNotNull('pangkat_golongan')
            ->where('status_pegawai', 'Aktif')
            ->groupBy('pangkat_golongan')
            ->pluck('total', 'pangkat_golongan');

        // -- Distribusi Jabatan Akademik Berdasarkan Jenis Kelamin---
        $jabatanList = [
            'Guru Besar',
            'Lektor Kepala',
            'Lektor',
            'Asisten Ahli',
            'Dosen'
        ];

        $jabatanLaki = [];
        $jabatanPerempuan = [];

        foreach ($jabatanList as $jabatan) {

            $jabatanLaki[] = Pegawai::where('status_pegawai','Aktif')
                ->where('jabatan_fungsional',$jabatan)
                ->where('jenis_kelamin','Laki-laki')
                ->count();

            $jabatanPerempuan[] = Pegawai::where('status_pegawai','Aktif')
                ->where('jabatan_fungsional',$jabatan)
                ->where('jenis_kelamin','Perempuan')
                ->count();
        }

        $jabatanLabels = $jabatanList;
        
        // --- LINE CHART: Peningkatan Submisi per Bulan (LOGIKA BARU) ---
        $months = collect(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $monthlyTotals = collect(array_fill_keys($months->all(), 0));

        $modelsForLineChart = [
            Pelatihan::class,  Penghargaan::class, Praktisi::class, Pengabdian::class, PengajaranLama::class, 
            Penunjang::class, SertifikatKompetensi::class, PembimbingLama::class, PengujianLama::class, PengajaranLuar::class, 
            PembimbingLuar::class, PengujiLuar::class, Penelitian::class, PengelolaJurnal::class
        ];

        foreach ($modelsForLineChart as $modelClass) {
            $monthlyCounts = app($modelClass)->select(DB::raw("DATE_FORMAT(created_at, '%b') as month"), DB::raw('count(*) as count'))
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->pluck('count', 'month');

            foreach ($monthlyCounts as $month => $count) {
                if ($monthlyTotals->has($month)) {
                    $monthlyTotals[$month] += $count;
                }
            }
        }
        $lineChartLabels = $monthlyTotals->keys();
        $lineChartData = $monthlyTotals->values();

        // --- PIE CHART: Jumlah Submisi per Kategori --- 
        $pieChartData = [
            'Pendidikan' =>
                PengajaranLama::count() +
                PembimbingLama::count() +
                PengujianLama::count() +
                PengajaranLuar::count() +
                PembimbingLuar::count() +
                PengujiLuar::count(),

            'Penelitian' => Penelitian::count(),

            'Pengabdian' => Pengabdian::count(),

            'Pelatihan' =>
                Pelatihan::count() +
                SertifikatKompetensi::count(),

            'Penghargaan' => Penghargaan::count(),

            'Penunjang' =>
                Penunjang::count() +
                Praktisi::count() +
                PengelolaJurnal::count(),
        ];

        $submissionCounts = [];

        // helper untuk menambahkan count
        $addCounts = function ($counts) use (&$submissionCounts) {
            foreach ($counts as $pegawai_id => $total) {
                $submissionCounts[$pegawai_id] =
                    ($submissionCounts[$pegawai_id] ?? 0) + $total;
            }
        };

        $nonFilterModels = [
            Pelatihan::class,
            Penghargaan::class,
        ];

        foreach ($nonFilterModels as $modelClass) {

            $counts = app($modelClass)
                ->select('pegawai_id', DB::raw('COUNT(*) as total'))
                ->whereNotNull('pegawai_id')
                ->groupBy('pegawai_id')
                ->pluck('total', 'pegawai_id');

            $addCounts($counts);
        }

        $counts = SertifikatKompetensi::select('pegawai_id', DB::raw('COUNT(*) as total'))
            ->whereNotNull('pegawai_id')
            ->whereRaw("LOWER(TRIM(verifikasi)) = 'sudah diverifikasi'")
            ->groupBy('pegawai_id')
            ->pluck('total', 'pegawai_id');

        $addCounts($counts);

        $otherModels = [
            PengajaranLama::class,
            PembimbingLama::class,
            PengujianLama::class,
            PengajaranLuar::class,
            PembimbingLuar::class,
            PengujiLuar::class,
            PenunjangAnggota::class,
            Praktisi::class,
            Pembicara::class,
            PengelolaJurnal::class,
        ];

        foreach ($otherModels as $modelClass) {

            $model = app($modelClass);
            $table = $model->getTable();

            $query = $model->select('pegawai_id', DB::raw('COUNT(*) as total'))
                ->whereNotNull('pegawai_id');

        if (Schema::hasColumn($table, 'status_verifikasi')) {
            $query->whereIn(DB::raw("LOWER(TRIM(status_verifikasi))"), [
                'diverifikasi',
                'sudah diverifikasi'
            ]);
        } elseif (Schema::hasColumn($table, 'status')) {
            $query->whereIn(DB::raw("LOWER(TRIM(status))"), [
                'diverifikasi',
                'sudah diverifikasi'
            ]);
        } elseif (Schema::hasColumn($table, 'verifikasi')) {
            $query->whereIn(DB::raw("LOWER(TRIM(verifikasi))"), [
                'diverifikasi',
                'sudah diverifikasi'
            ]);
        } else {
            continue;
        }

            $counts = $query
                ->groupBy('pegawai_id')
                ->pluck('total', 'pegawai_id');

            $addCounts($counts);
        }

        $joinQueries = [
            PengabdianAnggota::select('pengabdian_anggotas.pegawai_id', DB::raw('COUNT(*) as total'))
                ->join('pengabdians', 'pengabdian_anggotas.pengabdian_id', '=', 'pengabdians.id')
                ->whereNotNull('pengabdian_anggotas.pegawai_id')
                ->whereRaw("LOWER(TRIM(pengabdians.status)) = 'sudah diverifikasi'")
                ->groupBy('pengabdian_anggotas.pegawai_id'),

            PenunjangAnggota::select('penunjang_anggotas.pegawai_id', DB::raw('COUNT(*) as total'))
                ->join('penunjangs', 'penunjang_anggotas.penunjang_id', '=', 'penunjangs.id')
                ->whereNotNull('penunjang_anggotas.pegawai_id')
                ->whereRaw("LOWER(TRIM(penunjangs.status)) = 'sudah diverifikasi'")
                ->groupBy('penunjang_anggotas.pegawai_id'),

            PenulisPenelitian::select('penulis_penelitian.pegawai_id', DB::raw('COUNT(*) as total'))
                ->join('penelitian', 'penulis_penelitian.penelitian_id', '=', 'penelitian.id')
                ->whereNotNull('penulis_penelitian.pegawai_id')
                ->whereRaw("LOWER(TRIM(penelitian.status)) = 'sudah diverifikasi'")
                ->groupBy('penulis_penelitian.pegawai_id'),
        ];

        foreach ($joinQueries as $query) {
            $addCounts($query->pluck('total', 'pegawai_id'));
        }

        // ambil top 5 pegawai
        arsort($submissionCounts);
        $topPegawaiIds = array_slice(array_keys($submissionCounts), 0, 5);
        $topPegawai = Pegawai::whereIn('id', $topPegawaiIds)
            ->get()
            ->map(function ($pegawai) use ($submissionCounts) {
                $pegawai->final_score = $submissionCounts[$pegawai->id] ?? 0;
                return $pegawai;
            })
            ->sortByDesc('final_score')
            ->values();

        // --- TABEL STATUS VERIFIKASI ---
        $startDate = Carbon::now()->subMonth();

        $statusCounts = [
            'Praktisi Dunia Industri' => ['menunggu' => 0, 'diverifikasi' => 0, 'ditolak' => 0],
            'Pembicara' => ['menunggu' => 0, 'diverifikasi' => 0, 'ditolak' => 0],
            'Pengabdian' => ['menunggu' => 0, 'diverifikasi' => 0, 'ditolak' => 0],
            'Penunjang' => ['menunggu' => 0, 'diverifikasi' => 0, 'ditolak' => 0],
            'Sertifikat Kompetensi' => ['menunggu' => 0, 'diverifikasi' => 0, 'ditolak' => 0],
            'Pendidikan / Akademik' => ['menunggu' => 0, 'diverifikasi' => 0, 'ditolak' => 0],
            'Pengelola Jurnal' => ['menunggu' => 0, 'diverifikasi' => 0, 'ditolak' => 0],
            'Penelitian' => ['menunggu' => 0, 'diverifikasi' => 0, 'ditolak' => 0],
        ];

        $otherModels = [
            'Praktisi Dunia Industri' => ['model' => Praktisi::class, 'column' => 'status'],
            'Pembicara' => ['model' => Pembicara::class, 'column' => 'status_verifikasi'],
            'Pengabdian' => ['model' => Pengabdian::class, 'column' => 'status'],
            'Penunjang' => ['model' => Penunjang::class, 'column' => 'status'],
            'Sertifikat Kompetensi' => ['model' => SertifikatKompetensi::class, 'column' => 'verifikasi'],
            'Pengelola Jurnal' => ['model' => PengelolaJurnal::class, 'column' => 'status_verifikasi'],
            'Penelitian' => ['model' => Penelitian::class, 'column' => 'status'],
        ];

        foreach ($otherModels as $category => $data) {

            $model = $data['model'];
            $column = $data['column'];

            $result = $model::where('created_at', '>=', $startDate)
                ->select($column, DB::raw('count(*) as total'))
                ->groupBy($column)
                ->pluck('total', $column);

            $statusCounts[$category]['menunggu'] = ($result['Belum Diverifikasi'] ?? 0) + ($result['belum diverifikasi'] ?? 0);
            $statusCounts[$category]['diverifikasi'] = ($result['Sudah Diverifikasi'] ?? 0) + ($result['sudah diverifikasi'] ?? 0) + ($result['diverifikasi'] ?? 0);
            $statusCounts[$category]['ditolak'] = ($result['Ditolak'] ?? 0) + ($result['ditolak'] ?? 0);
        }

        $pendidikanModels = [
            PengajaranLama::class, PembimbingLama::class, PengujianLama::class, PengajaranLuar::class, PembimbingLuar::class, PengujiLuar::class
        ];

        foreach ($pendidikanModels as $model) {

            $result = $model::where('created_at', '>=', $startDate)
                ->select('status_verifikasi', DB::raw('count(*) as total'))
                ->groupBy('status_verifikasi')
                ->pluck('total', 'status_verifikasi');

            $statusCounts['Pendidikan / Akademik']['menunggu'] += $result['belum diverifikasi'] ?? 0;
            $statusCounts['Pendidikan / Akademik']['diverifikasi'] += $result['diverifikasi'] ?? 0;
            $statusCounts['Pendidikan / Akademik']['ditolak'] += $result['ditolak'] ?? 0;
        }
        
return view('pages.dashboard', compact(
    'totalPegawaiAktif',
    'totalSemuaPendidikan',
    'totalPenelitian',
    'totalPengabdian',
    'totalPenghargaan',
    'totalSertifikatKompetensi',
    'totalPenunjang',
    'totalSuratTugas',
    'totalKerjasama',
    'lineChartLabels',
    'lineChartData',
    'pieChartData',
    'topPegawai',
    'statusCounts',
    'pendidikanLabels',
    'pendidikanData', 'pegawaiByPendidikan', 'jabatanLabels',
'jabatanLaki',
'jabatanPerempuan', 'pangkatDosen' 
));
    }
}
