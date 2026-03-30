<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="line-chart-labels" content='@json($lineChartLabels)'>
    <meta name="line-chart-datasets" content='@json($lineChartDatasets)'>
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

                <!-- Jumlah Pegawai -->
                <div class="stat-card blue">
                    <div class="card-icon icon-blue">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div>
                        <div class="card-label">Jumlah Pegawai Aktif</div>
                        <div class="card-value">{{ $totalPegawaiAktif }}</div>

                @if(auth()->user()->role === 'admin_verifikator')
                <div class="fw-semibold">
                    <span class="text-primary">Dosen: {{ $totalDosen }}</span>
                    <span class="mx-2">|</span>
                    <span class="text-secondary">Tendik: {{ $totalTendik }}</span>
                </div>
                @endif
                    </div>
                </div>

                {{-- Role Admin--}}
                @if(auth()->user()->role === 'admin')
                    <div class="stat-card purple">
                        <div class="card-icon icon-purple">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <div>
                            <div class="card-label">Total Akun Pengguna</div>
                            <div class="card-value">{{ \App\Models\User::count() }}</div>
                        </div>
                    </div>

                    <div class="stat-card green">
                        <div class="card-icon icon-green">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div>
                            <div class="card-label">Admin & Verifikator</div>
                            <div class="card-value">
                                {{ \App\Models\User::whereIn('role', ['admin', 'admin_verifikator'])->count() }}
                            </div>
                        </div>
                    </div>
                @endif

                @if(auth()->user()->role === 'admin_verifikator')
                <div class="stat-card orange" data-bs-toggle="modal" data-bs-target="#modalSubmisi">
                    <div class="card-icon icon-orange">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div>
                        <div class="card-label">Total Submisi</div>
                        <div class="card-value">{{ $totalSubmisi }}</div>

                        <small class="{{ $growthSubmisi >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ $growthSubmisi >= 0 ? '▲' : '▼' }} 
                            {{ number_format($growthSubmisi, 1) }}% dari bulan lalu
                        </small>
                    </div>
                </div>
                @endif

                @if(in_array(auth()->user()->role, ['admin_verifikator', 'tata_usaha']))
                <!-- Surat Tugas -->
                <div class="stat-card indigo">
                    <div class="card-icon icon-indigo">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <div>
                        <div class="card-label">Surat Tugas Dosen</div>
                        <div class="card-value">{{ $totalSuratTugas }}</div>

                        @if(auth()->user()->role === 'admin_verifikator')
                        <small class="{{ $growthSuratTugas >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ $growthSuratTugas >= 0 ? '▲' : '▼' }}
                            {{ number_format($growthSuratTugas, 1) }}% dari bulan lalu
                        </small>
                        @endif
                    </div>
                </div>

                <!-- Kerjasama -->
                <div class="stat-card pink">
                    <div class="card-icon icon-pink">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <div>
                        <div class="card-label">Program Kerjasama</div>
                        <div class="card-value">{{ $totalKerjasama }}</div>

                        @if(auth()->user()->role === 'admin_verifikator')
                        <small class="{{ $growthKerjasama >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ $growthKerjasama >= 0 ? '▲' : '▼' }}
                            {{ number_format($growthKerjasama, 1) }}% dari bulan lalu
                        </small>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            @if(auth()->user()->role === 'tata_usaha')
            <div class="card-container">
                {{-- DIKLAT --}}
                <div class="stat-card orange">
                    <div class="card-icon icon-orange">
                        <i class="fa-solid fa-chalkboard-user"></i>
                    </div>
                    <div>
                        <div class="card-label">Diklat</div>
                        <div class="card-value">{{ $totalPelatihan }}</div>
                    </div>
                </div>

                {{-- PENGHARGAAN --}}
                <div class="stat-card yellow">
                    <div class="card-icon icon-yellow">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <div>
                        <div class="card-label">Penghargaan</div>
                        <div class="card-value">{{ $totalPenghargaan }}</div>
                    </div>
                </div>

                {{-- PRAKTISI --}}
                <div class="stat-card dark">
                    <div class="card-icon icon-dark">
                        <i class="fa-solid fa-industry"></i>
                    </div>
                    <div>
                        <div class="card-label">Praktisi Industri</div>
                        <div class="card-value">{{ $totalPraktisi }}</div>
                    </div>
                </div>

                {{-- PEMBICARA --}}
                <div class="stat-card cyan">
                    <div class="card-icon icon-cyan">
                        <i class="fa-solid fa-microphone"></i>
                    </div>
                    <div>
                        <div class="card-label">Pembicara</div>
                        <div class="card-value">{{ $totalPembicara }}</div>
                    </div>
                </div>

                {{-- PENGABDIAN --}}
                <div class="stat-card teal">
                    <div class="card-icon icon-teal">
                        <i class="fa-solid fa-hand-holding-heart"></i>
                    </div>
                    <div>
                        <div class="card-label">Pengabdian</div>
                        <div class="card-value">{{ $totalPengabdian }}</div>
                    </div>
                </div>

                {{-- PENUNJANG --}}
                <div class="stat-card gray">
                    <div class="card-icon icon-secondary">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                    </div>
                    <div>
                        <div class="card-label">Penunjang</div>
                        <div class="card-value">{{ $totalPenunjang }}</div>
                    </div>
                </div>

                {{-- SERTIFIKAT --}}
                <div class="stat-card sky">
                    <div class="card-icon icon-sky">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <div>
                        <div class="card-label">Sertifikat Kompetensi</div>
                        <div class="card-value">{{ $totalSertifikatKompetensi }}</div>
                    </div>
                </div>

                {{-- PENDIDIKAN --}}
                <div class="stat-card purple">
                    <div class="card-icon icon-purple">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <div>
                        <div class="card-label">Pendidikan / Akademik</div>
                        <div class="card-value">{{ $totalSemuaPendidikan }}</div>
                    </div>
                </div>

                {{-- JURNAL --}}
                <div class="stat-card blue">
                    <div class="card-icon icon-blue">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <div>
                        <div class="card-label">Pengelola Jurnal</div>
                        <div class="card-value">{{ $totalPengelolaJurnal }}</div>
                    </div>
                </div>

                {{-- PENELITIAN --}}
                <div class="stat-card red">
                    <div class="card-icon icon-red">
                        <i class="fa-solid fa-flask"></i>
                    </div>
                    <div>
                        <div class="card-label">Penelitian</div>
                        <div class="card-value">{{ $totalPenelitian }}</div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Role Admin -->
            @if(auth()->user()->role === 'admin')
            <div class="table-box full-width">
                <h3>
                    <i class="fas fa-database text-danger"></i> 
                    Manajemen Master Data
                </h3>
                <p>Sebagai Admin, Anda bertanggung jawab penuh atas pengelolaan akun dan hak akses sistem.</p>
                
                <div class="d-flex gap-3">
                    <a href="{{ route('master-data.index') }}" class="btn btn-success">
                        <i class="fas fa-user-plus"></i> Kelola Akun Pengguna
                    </a>
                    <a href="{{ route('pegawai.index') }}" class="btn btn-outline-success">
                        <i class="fas fa-address-card"></i> Sinkronisasi Data Pegawai
                    </a>
                </div>
            @endif

            @if(auth()->user()->role === 'admin_verifikator')
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
                @endif
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