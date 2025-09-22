<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Pegawai;
// Import semua model yang relevan
use App\Models\Penelitian;
use App\Models\Pengabdian;
use App\Models\Penghargaan;
use App\Models\Pelatihan;
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

class DashboardController extends Controller
{
    public function index()
    {
        // --- STAT CARD COUNTS ---
        $totalPegawai = Pegawai::count();
        $totalPenelitian = Penelitian::count();
        $totalPengabdian = Pengabdian::count();
        $totalPenghargaan = Penghargaan::count();
        $totalPelatihan = Pelatihan::count();
        $totalPenunjang = Penunjang::count();
        $totalSuratTugas = SuratTugas::count();
        $totalSemuaPendidikan = PengajaranLama::count() + PembimbingLama::count() + PengujianLama::count() + PengajaranLuar::count() + PembimbingLuar::count() + PengujiLuar::count();

        // --- LINE CHART: Peningkatan Submisi per Bulan (LOGIKA BARU) ---
        $months = collect(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $monthlyTotals = collect(array_fill_keys($months->all(), 0));

        $modelsForLineChart = [
            PengajaranLama::class, PembimbingLama::class, PengujianLama::class,
            PengajaranLuar::class, PembimbingLuar::class, PengujiLuar::class,
            Penelitian::class, Pengabdian::class, Penunjang::class,
            Pelatihan::class, Penghargaan::class,
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

        // --- PIE CHART: Jumlah Submisi per Kategori --- (Tidak ada perubahan)
        $pieChartData = [
            'Pendidikan' => $totalSemuaPendidikan, 'Penelitian' => $totalPenelitian, 'Pengabdian' => $totalPengabdian,
            'Penghargaan' => $totalPenghargaan, 'Pelatihan' => $totalPelatihan, 'Penunjang' => $totalPenunjang,
        ];

        // --- TOP 5 PEGAWAI --- (Tidak ada perubahan)
        $submissionCounts = [];
        $tablesToCount = [
            PengajaranLama::class, PembimbingLama::class, PengujianLama::class,
            PengajaranLuar::class, PembimbingLuar::class, PengujiLuar::class,
            Pelatihan::class, Penghargaan::class,
            PenulisPenelitian::class, PengabdianAnggota::class, PenunjangAnggota::class,
        ];
        foreach ($tablesToCount as $modelClass) {
            $counts = app($modelClass)->select('pegawai_id', DB::raw('count(*) as total'))->whereNotNull('pegawai_id')->groupBy('pegawai_id')->pluck('total', 'pegawai_id');
            foreach ($counts as $pegawai_id => $total) {
                if (!isset($submissionCounts[$pegawai_id])) $submissionCounts[$pegawai_id] = 0;
                $submissionCounts[$pegawai_id] += $total;
            }
        }
        arsort($submissionCounts);
        $topPegawaiIds = array_slice(array_keys($submissionCounts), 0, 5);
        $topPegawai = Pegawai::whereIn('id', $topPegawaiIds)->get()->map(function ($pegawai) use ($submissionCounts) {
            $pegawai->total_submissions = $submissionCounts[$pegawai->id];
            return $pegawai;
        })->sortByDesc('total_submissions');

        // --- TABEL STATUS VERIFIKASI --- (Tidak ada perubahan)
        $startDate = Carbon::now()->subMonth();
        $statusCounts = ['Pendidikan' => ['menunggu' => 0, 'diverifikasi' => 0, 'ditolak' => 0]];
        $pendidikanModels = [PengajaranLama::class, PembimbingLama::class, PengujianLama::class, PengajaranLuar::class, PembimbingLuar::class, PengujiLuar::class];
        foreach ($pendidikanModels as $model) {
            $result = $model::where('created_at', '>=', $startDate)->select('status_verifikasi', DB::raw('count(*) as total'))->groupBy('status_verifikasi')->pluck('total', 'status_verifikasi');
            $statusCounts['Pendidikan']['menunggu'] += $result['belum diverifikasi'] ?? 0;
            $statusCounts['Pendidikan']['diverifikasi'] += $result['sudah diverifikasi'] ?? 0;
            $statusCounts['Pendidikan']['ditolak'] += $result['ditolak'] ?? 0;
        }
        $otherModels = ['Penelitian' => Penelitian::class, 'Pengabdian' => Pengabdian::class, 'Penunjang' => Penunjang::class];
        foreach ($otherModels as $category => $model) {
            $result = $model::where('created_at', '>=', $startDate)->select('status', DB::raw('count(*) as total'))->groupBy('status')->pluck('total', 'status');
            $statusCounts[$category] = ['menunggu' => $result['Belum Diverifikasi'] ?? 0, 'diverifikasi' => $result['Sudah Diverifikasi'] ?? 0, 'ditolak' => $result['Ditolak'] ?? 0];
        }

        return view('pages.dashboard', compact(
            'totalPegawai', 'totalSemuaPendidikan', 'totalPenelitian', 'totalPengabdian',
            'totalPenghargaan', 'totalPelatihan', 'totalPenunjang', 'totalSuratTugas',
            'lineChartLabels', 'lineChartData', 'pieChartData',
            'topPegawai',
            'statusCounts'
        ));
    }
}