<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIKEMAH - Daftar Pegawai</title>

    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/daftar-pegawai.css') }}" />
</head>

<body>
<div class="layout">
    @include('layouts.sidebar')

    <div class="main-wrapper">
        @include('layouts.header')

        <!-- Title Bar -->
        <div class="title-bar">
            <h1>
                <i class="lni lni-users"></i>
                <span id="page-title">Daftar Pegawai</span>
            </h1>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="table-card">

                <!-- Tabs -->
                <div class="tab-bar-container d-flex justify-content-between align-items-center">
                    <ul class="nav nav-pills" id="pegawaiTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active"
                                    id="pegawai-aktif-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#pegawai-aktif"
                                    type="button"
                                    role="tab"
                                    aria-controls="pegawai-aktif"
                                    aria-selected="true">
                                Pegawai Aktif
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link"
                                    id="riwayat-pegawai-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#riwayat-pegawai"
                                    type="button"
                                    role="tab"
                                    aria-controls="riwayat-pegawai"
                                    aria-selected="false">
                                Riwayat Pegawai
                            </button>
                        </li>
                    </ul>
                    <a href="/tambah-pegawai" class="btn btn-tambah btn-sm fw-bold" id="btn-tambah-pegawai">
                        <i class="fa fa-plus me-2"></i> Tambah Data
                    </a>
                </div>

                <!-- Tab Content -->
                <div class="tab-content" id="pegawaiTabContent">

                    <!-- Pegawai Aktif -->
                    <div class="tab-pane fade show active" id="pegawai-aktif" role="tabpanel" aria-labelledby="pegawai-aktif-tab">
                        
                        <!-- Filter -->
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">
                            <div class="d-flex align-items-center flex-wrap gap-2 flex-grow-1">
                                <!-- Search -->
                                <div class="search-group flex-grow-1">
                                    <div class="input-group bg-white">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-search search-icon"></i>
                                        </span>
                                        <input type="text" class="form-control form-control-sm bg-transparent border-0" placeholder="Cari Pegawai Aktif..." />
                                    </div>
                                </div>
                                <!-- Filter Kepegawaian -->
                                <div>
                                    <select class="form-select form-select-sm w-100">
                                        <option selected disabled>Kepegawaian</option>
                                        <option value="pns">Dosen PNS</option>
                                        <option value="pppk">Dosen Tetap</option>
                                        <option value="honorer">Tendik Tetap</option>
                                        <option value="kontrak">Tendik Kontrak</option>
                                        <option value="dosen_tamu">Dosen Tamu</option>
                                        <option value="thl">THL</option>
                                    </select>
                                </div>
                                <!-- Export -->
                                <div>
                                    <button class="btn btn-export btn-sm fw-bold">
                                        <i class="fa-solid fa-file-excel me-2"></i> Export Excel
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Table Pegawai Aktif -->
                        <div class="table-responsive mt-4">
                            <table class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>NIP</th>
                                        <th>Status Kepegawaian</th>
                                        <th>Jabatan Fungsional</th>
                                        <th>Jabatan Struktural</th>
                                        <th>Pangkat/Gol</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <script>
                                        const dataAktif = [
                                            {
                                                name: 'Dr. Soni Trison, S.Hut, M.Si',
                                                nip: '197801012003121002',
                                                status_kepegawaian: 'Dosen PNS',
                                                jabatan_fungsional: 'Lektor Kepala',
                                                jabatan_struktural: 'Kepala Divisi',
                                                pangkat: 'Pembina / IV-a',
                                                status_pegawai: 'Aktif'
                                            },
                                            {
                                                name: 'Dr. Budi Santoso, M.Kom',
                                                nip: '198205102006041001',
                                                status_kepegawaian: 'Dosen Tetap',
                                                jabatan_fungsional: 'Lektor',
                                                jabatan_struktural: 'Koordinator Prodi',
                                                pangkat: 'Penata / III-c',
                                                status_pegawai: 'Aktif'
                                            }
                                        ];
                                        
                                        dataAktif.forEach((item, index) => {
                                            document.write(`
                                                <tr>
                                                    <td class="text-center">${index + 1}</td>
                                                    <td>${item.name}</td>
                                                    <td class="text-center">${item.nip}</td>
                                                    <td class="text-center">${item.status_kepegawaian}</td>
                                                    <td class="text-center">${item.jabatan_fungsional}</td>
                                                    <td class="text-center">${item.jabatan_struktural}</td>
                                                    <td class="text-center">${item.pangkat}</td>
                                                    <td class="text-center">
                                                        <span class="badge text-bg-success">${item.status_pegawai}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <a href="/detail-pegawai" class="btn-aksi btn-lihat" title="Lihat Detail"><i class="fa fa-eye"></i></a>
                                                            <a href="/edit-pegawai" class="btn-aksi btn-edit" title="Edit Data"><i class="fa fa-edit"></i></a>
                                                            <a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            `);
                                        });
                                    </script>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center flex-wrap mt-3 w-100">
                            <span class="text-muted small mb-2 mb-md-0">Menampilkan 2 dari 10 data</span>
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">Berikutnya</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <!-- Riwayat Pegawai -->
                    <div class="tab-pane fade" id="riwayat-pegawai" role="tabpanel" aria-labelledby="riwayat-pegawai-tab">
                        
                        <!-- Filter -->
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">
                            <div class="d-flex align-items-center flex-wrap gap-2 flex-grow-1">
                                <!-- Search -->
                                <div class="search-group flex-grow-1">
                                    <div class="input-group bg-white">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-search search-icon"></i>
                                        </span>
                                        <input type="text" class="form-control form-control-sm bg-transparent border-0" placeholder="Cari Riwayat Pegawai..." />
                                    </div>
                                </div>
                                <!-- Status Riwayat -->
                                <div>
                                    <select class="form-select form-select-sm w-100">
                                        <option selected disabled>Status Riwayat</option>
                                        <option value="pensiun">Pensiun</option>
                                        <option value="pensiun-muda">Pensiun Muda</option>
                                        <option value="diberhentikan">Diberhentikan</option>
                                        <option value="meninggal">Meninggal</option>
                                        <option value="kontrak_selesai">Kontrak Selesai</option>
                                        <option value="mengundurkan_diri">Mengundurkan Diri</option>
                                        <option value="mutasi">Mutasi</option>
                                    </select>
                                </div>
                                <!-- Kepegawaian -->
                                <div>
                                    <select class="form-select form-select-sm w-100">
                                        <option selected disabled>Kepegawaian</option>
                                        <option value="pns">Dosen PNS</option>
                                        <option value="pppk">Dosen Tetap</option>
                                        <option value="honorer">Tendik Tetap</option>
                                        <option value="kontrak">Tendik Kontrak</option>
                                        <option value="dosen_tamu">Dosen Tamu</option>
                                        <option value="thl">THL</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Table Riwayat Pegawai -->
                        <div class="table-responsive mt-4">
                            <table class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>NIP</th>
                                        <th>Status Kepegawaian</th>
                                        <th>Jabatan Terakhir</th>
                                        <th>Pangkat/Gol</th>
                                        <th>Status Riwayat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <script>
                                        const dataRiwayat = [
                                            {
                                                name: 'Joko Anwar S.pd',
                                                nip: '194909061979031001',
                                                status_kepegawaian: 'Dosen tetap',
                                                jabatan_struktural: 'Ketua Departemen',
                                                pangkat: 'Penata Muda / III-a',
                                                status_pegawai: 'Meninggal'
                                            },
                                            {
                                                name: 'Ria Kodariah, S.Si',
                                                nip: '198103152005012001',
                                                status_kepegawaian: 'Tendik Tetap',
                                                jabatan_struktural: 'Staf Administrasi',
                                                pangkat: 'Pengatur / II-c',
                                                status_pegawai: 'Pensiun'
                                            },
                                            {
                                                name: 'Meli Surnami',
                                                nip: '198505202015042001',
                                                status_kepegawaian: 'Tendik Tetap',
                                                jabatan_struktural: 'Staf Keuangan',
                                                pangkat: 'Penata Muda / III-a',
                                                status_pegawai: 'Nonaktif'
                                            }
                                        ];
                                        
                                        dataRiwayat.forEach((item, index) => {
                                            document.write(`
                                                <tr>
                                                    <td class="text-center">${index + 1}</td>
                                                    <td>${item.name}</td>
                                                    <td class="text-center">${item.nip}</td>
                                                    <td class="text-center">${item.status_kepegawaian}</td>
                                                    <td class="text-center">${item.jabatan_struktural}</td>
                                                    <td class="text-center">${item.pangkat}</td>
                                                    <td class="text-center">
                                                        <span class="badge 
                                                            ${item.status_pegawai === 'Pensiun' ? 'text-bg-warning' :
                                                              item.status_pegawai === 'Diberhentikan' ? 'text-bg-danger' :
                                                              item.status_pegawai === 'Meninggal' ? 'text-bg-dark' :
                                                              item.status_pegawai === 'Kontrak Selesai' ? 'text-bg-info' :
                                                              item.status_pegawai === 'Mengundurkan Diri' ? 'text-bg-primary' :
                                                              item.status_pegawai === 'Mutasi' ? 'text-bg-secondary' :
                                                              item.status_pegawai === 'Nonaktif' ? 'text-bg-secondary' :
                                                              'text-bg-light'}">
                                                            ${item.status_pegawai}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <a href="/detail-pegawai" class="btn-aksi btn-lihat" title="Lihat Detail Riwayat">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            `);
                                        });
                                    </script>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center flex-wrap mt-3 w-100">
                            <span class="text-muted small mb-2 mb-md-0">Menampilkan 3 dari 3 data</span>
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">Berikutnya</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        @include('layouts.footer')
    </div>
</div>

@include('components.konfirmasi-hapus')
@include('components.konfirmasi-berhasil')

<!-- Scripts -->
<script src="{{ asset('assets/js/daftar-pegawai.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>