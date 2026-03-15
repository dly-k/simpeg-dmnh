<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="line-chart-data" content='@json($lineChartData)'>
    <meta name="line-chart-labels" content='@json($lineChartLabels)'>
    <meta name="pie-chart-data" content='@json($pieChartData)'>
    <meta name="pendidikan-labels" content='@json($pendidikanLabels)'>
    <meta name="pendidikan-data" content='@json($pendidikanData)'>
    <meta name="pegawai-pendidikan" content='@json($pegawaiByPendidikan ?? [])'>
    <meta name="jabatan-labels" content='@json($jabatanLabels)'>
    <meta name="jabatan-laki" content='@json($jabatanLaki)'>
    <meta name="jabatan-perempuan" content='@json($jabatanPerempuan)'>
    <meta name="pangkat-labels" content='@json(array_keys($pangkatDosen->toArray()))'>
    <meta name="pangkat-data" content='@json(array_values($pangkatDosen->toArray()))'>

    <title>SIKEMAH - Dashboard</title>

    <link rel="icon" href="{{ asset('assets/images/logo.png') }}">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
</head>

<body>

<div class="layout">
    @include('layouts.sidebar')
    <div class="main-wrapper">
        @include('layouts.header')
        <div class="main-content">

            <div class="title-bar">
                <h1>
                    <i class="lni lni-grid-alt"></i>
                    Dashboard
                </h1>
            </div>

            <!-- Statistik Utama -->
            <div class="card-container">

                <div class="stat-card">
                    <div class="card-icon icon-blue">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div>
                        <div class="card-label">Jumlah Pegawai Aktif</div>
                        <div class="card-value">{{ $totalPegawaiAktif }}</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="card-icon icon-teal">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div>
                        <div class="card-label">Total Aktivitas Tridharma</div>
                        <div class="card-value">0</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="card-icon icon-indigo">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <div>
                        <div class="card-label">Surat Tugas Dosen</div>
                        <div class="card-value">{{ $totalSuratTugas }}</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="card-icon icon-pink">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <div>
                        <div class="card-label">Program Kerjasama</div>
                        <div class="card-value">{{ $totalKerjasama }}</div>
                    </div>
                </div>

            </div>

            <!-- Grafik -->
            <div class="chart-grid">

                <div class="chart-box pie-box">
                    <h3>
                        <i class="fas fa-user-graduate text-primary"></i>
                         Komposisi Pendidikan Pegawai
                    </h3>
                    <canvas id="pendidikanChart"></canvas>
                </div>

                <div class="chart-box bar-box">
                    <h3>
                        <i class="fas fa-user-tie text-success"></i>
                         Sebaran Jabatan Akademik Dosen
                    </h3>
                    <canvas id="JabatanChart"></canvas>
                </div>

                <div class="chart-box line-box">
                    <h3>
                        <i class="fas fa-chart-line text-info"></i>
                        Tren Kinerja Submisi Tahunan
                    </h3>
                    <canvas id="lineChart"></canvas>
                </div>

            </div>

            <!-- Tabel Analisis -->
            <div class="table-container">

                <!-- Pangkat -->
                <div class="table-box">
                    <h3>
                        <i class="fas fa-layer-group text-primary"></i>
                         Distribusi Pangkat Akademik
                    </h3>
                    <canvas id="pangkatChart"></canvas>
                </div>

                <!-- Top Dosen -->
                <div class="table-box">
                    <h3>
                        <i class="fas fa-crown text-warning"></i>
                        Top 5 Dosen Berdasarkan Kinerja
                    </h3>

                    <table class="table table-hover align-middle text-center">

                        <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Dosen</th>
                            <th>Jumlah Submisi</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($topPegawai as $pegawai)

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td class="text-start">
                                {{ $pegawai->nama_lengkap }}
                            </td>

                            <td>
                                <span class="badge bg-primary">
                                    {{ $pegawai->final_score }}
                                </span>
                            </td>
                        </tr>

                        @empty

                        <tr>
                            <td colspan="3">
                                Tidak ada data
                            </td>
                        </tr>

                        @endforelse
                        </tbody>

                    </table>

                    <small class="text-muted">
                        *Berdasarkan aktivitas yang telah diverifikasi
                    </small>

                </div>

                <!-- Status Verifikasi -->
                <div class="table-box">

                    <h3>
                        <i class="fas fa-clipboard-check text-success"></i>
                        Status Verifikasi (1 Bulan Terakhir)
                    </h3>

                    <div class="table-responsive">

                        <table class="table table-hover align-middle text-center">

                            <thead class="table-light">
                            <tr>
                                <th>Kategori</th>
                                <th>Menunggu</th>
                                <th>Diverifikasi</th>
                                <th>Ditolak</th>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($statusCounts as $category => $counts)

                            <tr>

                                <td class="text-start">
                                    {{ $category }}
                                </td>

                                <td>
                                    <span class="badge bg-warning">
                                        {{ $counts['menunggu'] }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bg-success">
                                        {{ $counts['diverifikasi'] }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bg-danger">
                                        {{ $counts['ditolak'] }}
                                    </span>
                                </td>

                            </tr>

                            @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

        <!-- Footer -->
        @include('layouts.footer')

    </div>

</div>

<!-- JS -->
<script src="{{ asset('assets/js/layout.js') }}"></script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>