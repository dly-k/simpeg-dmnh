<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIKEMAH - Dashboard</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}" />
</head>
<body>
    <div class="layout">
        @include('layouts.sidebar')
        <div class="main-wrapper">
            @include('layouts.header')

            <div class="main-content">
                <div class="title-bar">
                    <h1><i class="lni lni-grid-alt"></i> Dashboard</h1>
                </div>

                <div class="card-container">
                    {{-- Stat Cards Anda --}}
                    <div class="stat-card"><div class="card-icon icon-blue"><i class="lni lni-users"></i></div><div><div class="card-label">Total Pegawai</div><div class="card-value">{{ $totalPegawai }}</div></div></div>
                    <div class="stat-card"><div class="card-icon icon-teal"><i class="lni lni-graduation"></i></div><div><div class="card-label">Pendidikan</div><div class="card-value">{{ $totalSemuaPendidikan }}</div></div></div>
                    <div class="stat-card"><div class="card-icon icon-green"><i class="lni lni-microscope"></i></div><div><div class="card-label">Penelitian</div><div class="card-value">{{ $totalPenelitian }}</div></div></div>
                    <div class="stat-card"><div class="card-icon icon-orange"><i class="lni lni-users"></i></div><div><div class="card-label">Pengabdian</div><div class="card-value">{{ $totalPengabdian }}</div></div></div>
                    <div class="stat-card"><div class="card-icon icon-sky"><i class="lni lni-briefcase"></i></div><div><div class="card-label">Penunjang</div><div class="card-value">{{ $totalPenunjang }}</div></div></div>
                    <div class="stat-card"><div class="card-icon icon-yellow"><i class="lni lni-certificate"></i></div><div><div class="card-label">Pelatihan</div><div class="card-value">{{ $totalPelatihan }}</div></div></div>
                    <div class="stat-card"><div class="card-icon icon-purple"><i class="lni lni-trophy"></i></div><div><div class="card-label">Penghargaan</div><div class="card-value">{{ $totalPenghargaan }}</div></div></div>
                    <div class="stat-card"><div class="card-icon icon-red"><i class="lni lni-folder"></i></div><div><div class="card-label">Surat Tugas</div><div class="card-value">{{ $totalSuratTugas }}</div></div></div>
                </div>
                <div class="table-container">
                    <div class="table-box">
                        <h3><i class="lni lni-star"></i> 5 Pegawai Teratas</h3>
                        <ul class="list-group list-group-flush">
                           @forelse($topPegawai as $pegawai)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $pegawai->nama_lengkap }}
                                    <span class="badge bg-primary rounded-pill">{{ $pegawai->total_submissions }} submisi</span>
                                </li>
                            @empty
                                <li class="list-group-item">Tidak ada data pegawai.</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="table-box">
                        <h3><i class="lni lni-stats-up"></i> Status Verifikasi (1 Bulan Terakhir)</h3>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th>Kategori</th>
                                        <th>Menunggu</th>
                                        <th>Diverifikasi</th>
                                        <th>Ditolak</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($statusCounts as $category => $counts)
                                    <tr class="text-center">
                                        <td class="fw-bold text-start">{{ $category }}</td>
                                        <td><span class="badge bg-warning text-dark">{{ $counts['menunggu'] }}</span></td>
                                        <td><span class="badge bg-success">{{ $counts['diverifikasi'] }}</span></td>
                                        <td><span class="badge bg-danger">{{ $counts['ditolak'] }}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="chart-grid">
                    <div class="chart-box">
                        <h3>Peningkatan Submisi per Bulan</h3>
                        <canvas id="lineChart"></canvas>
                    </div>
                    <div class="chart-box">
                        <h3>Jumlah Submisi per Kategori</h3>
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
                


            </div>

            @include('layouts.footer')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const lineChartData = {
            labels: @json($lineChartLabels),
            data: @json($lineChartData)
        };
        const pieChartData = @json($pieChartData);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>