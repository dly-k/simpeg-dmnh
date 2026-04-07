<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="line-chart-labels" content='@json($lineChartLabels)'>
    <meta name="pegawai-jabatan-gender" content='@json($pegawaiByJabatanGender ?? [])'>
    <meta name="pegawai-pangkat" content='@json($pegawaiByPangkat ?? [])'>
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
                <div class="stat-card blue" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalPegawaiAktif" title="Klik untuk lihat daftar nama">
                    <div class="card-icon icon-blue">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div>
                        <div class="card-label">Jumlah Pegawai Aktif</div>
                        <div class="card-value">{{ $totalPegawaiAktif }}</div>
                        @if(auth()->user()->role === 'admin_verifikator')
                        <div class="fw-semibold mt-1">
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
                <div class="stat-card orange" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalSubmisi" title="Klik untuk lihat rincian dokumen">
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

                <div class="chart-box pie-box" id="cardPendidikan">
                    <h3>
                        <i class="fas fa-user-graduate text-primary"></i>
                         Komposisi Pendidikan Pegawai
                    </h3>
                    <canvas style="cursor: pointer;" id="pendidikanChart" title="Klik grafik untuk lihat detail"></canvas>
                </div>

                <div class="chart-box bar-box">
                    <h3>
                        <i class="fas fa-user-tie text-success"></i>
                         Sebaran Jabatan Akademik Dosen
                    </h3>
                    <canvas style="cursor: pointer;" id="JabatanChart" title="Klik untuk lihat daftar nama"></canvas>
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
                <div class="table-box d-flex flex-column" id="cardPangkat">
                    <h3>
                        <i class="fas fa-layer-group text-info"></i> 
                        Distribusi Pangkat Akademik 
                    </h3>
                    <div style="flex-grow: 1; position: relative;">
                        <canvas id="pangkatChart"  style="cursor: pointer;" title="Klik untuk lihat daftar nama"></canvas>
                    </div>
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

<div class="modal fade" id="modalSubmisi" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header border-bottom bg-white px-4 py-3">
                        <h5 class="modal-title fw-bold text-dark">
                            <i class="fas fa-book-open me-2" style="color: #fd7e14;"></i> Rincian Submisi per Kategori
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3 bg-light">
                        <div class="list-group shadow-sm">
                            @forelse($submisiBreakdown as $label => $jumlah)
                                <div class="list-group-item d-flex justify-content-between align-items-center border-0 mb-1 rounded px-3 py-3" style="background-color: #ffffff;">
                                    <div class="text-dark fw-medium" style="font-size: 0.95rem;">
                                        <i class="fas fa-check-circle opacity-50 me-2" style="color: #198754;"></i> 
                                        {{ $label }}
                                    </div>
                                    <div class="fw-bold text-dark" style="font-size: 1.1rem;">
                                        {{ $jumlah }} <span class="text-muted fw-normal" style="font-size: 0.75rem;">Submisi</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted py-4">Belum ada data yang dimasukkan.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalPegawaiAktif" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header border-bottom bg-light">
                        <h5 class="modal-title fw-bold text-dark"><i class="fas fa-users text-primary me-2"></i> Daftar Pegawai Aktif</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-0">
                        <ul class="nav nav-tabs nav-justified" id="pegawaiTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-semibold text-primary" data-bs-toggle="tab" data-bs-target="#tab-dosen" type="button">
                                    <i class="fas fa-chalkboard-teacher me-1"></i> Dosen ({{ count($dosenList) }})
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold text-secondary" data-bs-toggle="tab" data-bs-target="#tab-tendik" type="button">
                                    <i class="fas fa-user-cog me-1"></i> Tendik ({{ count($tendikList) }})
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content p-3" id="pegawaiTabContent">
                            <div class="tab-pane fade show active" id="tab-dosen">
                                <div class="list-group list-group-flush">
                                    @forelse($dosenList as $dosen) 
                                        <div class="list-group-item px-2 py-2 text-dark" style="font-size: 0.9rem;"><i class="fas fa-circle text-primary opacity-50 me-2" style="font-size: 8px;"></i> {{ $dosen }}</div> 
                                    @empty
                                        <div class="text-center text-muted py-3">Tidak ada data dosen aktif</div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-tendik">
                                <div class="list-group list-group-flush">
                                    @forelse($tendikList as $tendik) 
                                        <div class="list-group-item px-2 py-2 text-dark" style="font-size: 0.9rem;"><i class="fas fa-circle text-secondary opacity-50 me-2" style="font-size: 8px;"></i> {{ $tendik }}</div> 
                                    @empty
                                        <div class="text-center text-muted py-3">Tidak ada data tendik aktif</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalPendidikan" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header border-bottom bg-white px-4 py-3">
                        <h5 class="modal-title fw-bold text-dark">
                            <i class="fas fa-user-graduate text-primary me-2"></i> Data Pendidikan Pegawai
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-3 bg-light text-start"> 
                        <div class="accordion" id="accPendidikan">
                            @forelse($pegawaiByPendidikan as $jenjang => $namaPegawai)
                            <div class="accordion-item border-0 mb-2 shadow-sm rounded overflow-hidden">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold text-dark px-4 py-3" type="button" data-bs-toggle="collapse" data-bs-target="#pend-{{ Str::slug($jenjang) }}">
                                        {{ $jenjang }} 
                                        <span class="badge bg-primary rounded-pill ms-auto" style="font-size: 0.85rem; padding: 0.4em 0.8em;">
                                            {{ count($namaPegawai) }} Orang
                                        </span>
                                    </button>
                                </h2>
                                <div id="pend-{{ Str::slug($jenjang) }}" class="accordion-collapse collapse" data-bs-parent="#accPendidikan">
                                    <div class="accordion-body p-0 bg-white">
                                        <div class="list-group list-group-flush">
                                            @foreach($namaPegawai as $nama) 
                                                <div class="list-group-item px-4 py-2 text-dark d-flex justify-content-between align-items-center" style="font-size: 0.9rem; border-color: #eaecf4;">
                                                    <div><i class="fas fa-user-circle text-primary opacity-50 me-2 fs-5"></i> {{ $nama }}</div>
                                                    <small class="text-muted fst-italic" style="font-size: 0.75rem;">#{{ $loop->iteration }}</small>
                                                </div> 
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                                <div class="text-center text-muted py-5">
                                    <p class="mb-0">Belum ada data pendidikan.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalPendidikanAuto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom px-4">
                <h5 class="modal-title fw-bold text-dark">
                    <i class="fas fa-user-graduate text-primary me-2"></i> 
                    Detail Pegawai: <span id="labelJenjangTerpilih" class="text-primary"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3 bg-light text-start">
                <div id="listPegawaiPendidikan" class="list-group shadow-sm">
                    </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalJabatanAuto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold text-dark">
                    <i class="fas fa-user-tie text-success me-2"></i> 
                    Jabatan: <span id="labelJabatanTerpilih" class="text-success"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0 bg-light text-start">
                <ul class="nav nav-tabs nav-justified bg-white" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active fw-bold text-primary py-3" data-bs-toggle="tab" data-bs-target="#tab-laki" type="button">
                            <i class="fas fa-mars me-1"></i> Laki-laki (<span id="cnt-laki">0</span>)
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link fw-bold text-danger py-3" data-bs-toggle="tab" data-bs-target="#tab-perempuan" type="button">
                            <i class="fas fa-venus me-1"></i> Perempuan (<span id="cnt-perempuan">0</span>)
                        </button>
                    </li>
                </ul>
                
                <div class="tab-content p-3">
                    <div class="tab-pane fade show active" id="tab-laki">
                        <div id="list-laki" class="list-group shadow-sm"></div>
                    </div>
                    <div class="tab-pane fade" id="tab-perempuan">
                        <div id="list-perempuan" class="list-group shadow-sm"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPangkatAuto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom px-4">
                <h5 class="modal-title fw-bold text-dark">
                    <i class="fas fa-layer-group text-info me-2"></i> 
                    Golongan Pangkat: <span id="labelPangkatTerpilih" class="text-info"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3 bg-light text-start">
                <div id="listPegawaiPangkat" class="list-group shadow-sm">
                    </div>
            </div>
        </div>
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