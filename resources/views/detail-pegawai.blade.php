<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pegawai - SIKEMAH</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/detail-pns.css') }}">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="layout">
    <div class="sidebar" id="sidebar">
        <div class="brand">SI<span>KEMAH</span></div>
        <div class="menu-wrapper">
            <div class="menu">
                <a href="/dashboard"><i class="lni lni-grid-alt"></i> Dashboard</a>
                <p>Menu Utama</p>
                <a href="/daftar-pegawai" class="active"><i class="lni lni-users"></i> Daftar Pegawai</a>
                <a href="/surat-tugas"><i class="lni lni-folder"></i> Manajemen Surat Tugas</a>
                <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#editorKegiatan" aria-expanded="true">
                    <i class="lni lni-pencil-alt"></i> Editor Kegiatan <i class="lni lni-chevron-down toggle-icon"></i>
                </button>
                <div class="collapse show submenu" id="editorKegiatan">
                    <a href="/pendidikan">Pendidikan</a><a href="/penelitian">Penelitian</a><a href="/pengabdian">Pengabdian</a>
                    <a href="/penunjang">Penunjang</a><a href="/pelatihan">Pelatihan</a><a href="/penghargaan">Penghargaan</a><a href="/sk-non-pns">SK Non PNS</a>
                </div>
                <a href="/kerjasama"><i class="lni lni-handshake"></i> Kerjasama</a>
                <a href="/master-data"><i class="lni lni-database"></i> Master Data</a>
            </div>
        </div>
    </div>

    <div class="overlay" id="overlay"></div>

    <div class="main-wrapper">
        <nav class="navbar-custom">
            <button class="btn btn-link text-dark me-3" id="toggleSidebar" aria-label="Toggle Sidebar">
                <i class="lni lni-menu"></i>
            </button>
            <div class="d-flex align-items-center">
                <div class="time-date me-3">
                    <div><i class="lni lni-calendar"></i> <span id="current-date"></span></div>
                    <div><i class="lni lni-timer"></i> <span id="current-time"></span></div>
                </div>
                <div class="dropdown">
                    <a href="#" class="account text-decoration-none text-dark" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="icon-circle"><i class="lni lni-user"></i></span>
                        <span class="d-none d-sm-inline">Halo, Ketua TU</span><i class="lni lni-chevron-down ms-1"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li><a class="dropdown-item d-flex align-items-center" href="/ubah-password"><i class="lni lni-key me-2"></i> Ubah Password</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item d-flex align-items-center dropdown-item-danger" href="/logout"><i class="lni lni-exit me-2"></i> Keluar</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="title-bar">
            <h1><i class="lni lni-users"></i> Detail Pegawai</h1>
        </div>

        <div class="main-content">
            <div class="search-filter-container">
                <div class="search-filter-row">
                    <div class="search-box">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="lni lni-search-alt"></i></span>
                            <input type="text" class="form-control border-start-0" placeholder="Cari Data Pegawai...">
                        </div>
                    </div>
                    <div class="btn-tambah-container">
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="/daftar-pegawai" class="btn btn-outline-secondary"><i class="lni lni-arrow-left me-2"></i>Kembali</a>
                            <button class="btn btn-success"><i class="lni lni-save me-2"></i>Simpan</button>
                            <button class="btn btn-danger"><i class="lni lni-trash-can me-2"></i>Hapus</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-md-row gap-4 mb-5">
                        <div class="text-center flex-shrink-0">
                            <div style="width: 120px; height: 120px; background-color: #e9ecef;" class="rounded-circle mb-2 mx-auto d-flex align-items-center justify-content-center">
                                <i class="lni lni-user" style="font-size: 3rem; color: var(--light-text);"></i>
                            </div>
                            <button class="btn btn-success btn-sm w-100">Edit</button>
                        </div>
                        <div class="flex-grow-1">
                            <div class="row g-3">
                                <div class="col-md-6 form-group"><label class="small text-secondary">NIP*</label><input type="text" class="form-control form-control-sm" value="3212302291827320009"></div>
                                <div class="col-md-6 form-group"><label class="small text-secondary">Agama*</label><select class="form-select form-select-sm"><option selected>Islam</option><option>Kristen</option></select></div>
                                <div class="col-md-6 form-group"><label class="small text-secondary">Nama Lengkap*</label><small class="form-text text-muted">termasuk gelar jika ada</small><input type="text" class="form-control form-control-sm" value="Alex Ferguso"></div>
                                <div class="col-md-6 form-group"><label class="small text-secondary">Status Pernikahan*</label><select class="form-select form-select-sm"><option>--Pilih Salah Satu--</option><option>Menikah</option></select></div>
                                <div class="col-md-6 form-group">
                                    <label class="small text-secondary">Jenis Kelamin*</label>
                                    <div>
                                        <div class="form-check form-check-inline pt-1">
                                            <input class="form-check-input" type="radio" name="jk" id="lk" checked>
                                            <label class="form-check-label" for="lk" style="font-weight: normal;">Laki-laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jk" id="pr">
                                            <label class="form-check-label" for="pr" style="font-weight: normal;">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group"><label class="small text-secondary">Pendidikan Terakhir*</label><select class="form-select form-select-sm"><option>S1</option><option>S2</option><option selected>S3</option></select></div>
                                <div class="col-md-6 form-group"><label class="small text-secondary">Tempat Lahir*</label><input type="text" class="form-control form-control-sm" value="Jakarta"></div>
                                <div class="col-md-6 form-group"><label class="small text-secondary">Bidang Ilmu*</label><input type="text" class="form-control form-control-sm" placeholder="Contoh: Ilmu Pengelolaan Hutan"></div>
                                <div class="col-md-6 form-group"><label class="small text-secondary">Tgl. Lahir*</label><input type="date" class="form-control form-control-sm" value="1980-05-25"></div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-lg-row gap-4">
                        <div class="nav flex-column nav-pills main-tab-nav" id="main-tab-nav" style="min-width: 220px; flex-shrink:0;">
                            <button class="nav-link text-start active" data-main-tab="biodata">Biodata</button>
                            <button class="nav-link text-start" data-main-tab="pendidikan">Pelaksanaan Pendidikan</button>
                            <button class="nav-link text-start" data-main-tab="penelitian">Pelaksanaan Penelitian</button>
                            <button class="nav-link text-start" data-main-tab="pengabdian">Pelaksanaan Pengabdian</button>
                            <button class="nav-link text-start" data-main-tab="penunjang">Penunjang</button>
                            <button class="nav-link text-start" data-main-tab="pelatihan">Pelatihan</button>
                            <button class="nav-link text-start" data-main-tab="penghargaan">Penghargaan</button>
                        </div>
                        
                        <div class="flex-grow-1">
                            <!-- Biodata Content -->
                            <div class="main-tab-content" id="biodata-content" style="display: block;">
                                <div id="biodata-sub-tabs" class="btn-group flex-wrap gap-2 mb-4">
                                    <button type="button" class="btn active" data-tab="kepegawaian">Kepegawaian</button>
                                    <button type="button" class="btn" data-tab="dosen">Dosen</button>
                                    <button type="button" class="btn" data-tab="domisili">Alamat Domisili & Kontak</button>
                                    <button type="button" class="btn" data-tab="kependudukan">Kependudukan</button>
                                    <button type="button" class="btn" data-tab="efile">E-File</button>
                                </div>
                                <div class="sub-tab-content" id="kepegawaian" style="display: block;"><div class="row g-3"><div class="col-md-6 form-group"><label class="small text-secondary">Status Kepegawaian</label><select class="form-select form-select-sm"><option selected>Dosen PNS</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">Status Pegawai</label><select class="form-select form-select-sm"><option selected>Aktif</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">Unit Kerja</label><select class="form-select form-select-sm"><option selected>Fakultas Kehutanan dan Lingkungan</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">Divisi</label><select class="form-select form-select-sm"><option selected>Departemen Manajemen Hutan</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">Nomor Arsip Berkas Kepegawaian</label><input type="text" class="form-control form-control-sm"></div><div class="col-md-6 form-group"><label class="small text-secondary">Jabatan Fungsional</label><select class="form-select form-select-sm"><option>--Pilih Salah Satu--</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">Pangkat/Golongan</label><select class="form-select form-select-sm"><option selected>Penata III/c</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">TMT Pangkat Terakhir</label><input type="text" class="form-control form-control-sm" placeholder="mm/dd/yyyy"></div><div class="col-md-6 form-group"><label class="small text-secondary">Jabatan Struktural (jika ada)</label><input type="text" class="form-control form-control-sm"></div><div class="col-md-6 form-group"><label class="small text-secondary">Periode Jabatan Struktural (TMT s/d TST)</label><input type="text" class="form-control form-control-sm" placeholder="mm/dd/yyyy"></div><div class="col-md-6 form-group"><label class="small text-secondary">ID Finger Print</label><input type="text" class="form-control form-control-sm"></div><div class="col-md-6 form-group"><label class="small text-secondary">NPWP</label><input type="text" class="form-control form-control-sm"></div><div class="col-md-6 form-group"><label class="small text-secondary">Nama Bank</label><input type="text" class="form-control form-control-sm"></div><div class="col-md-6 form-group"><label class="small text-secondary">No Rekening</label><input type="text" class="form-control form-control-sm"></div></div></div>
                                <div class="sub-tab-content" id="dosen" style="display: none;"><div class="row g-3"><div class="col-md-6 form-group"><label class="small text-secondary">NUPTK</label><input type="text" class="form-control form-control-sm" placeholder="Contoh: 23071959"></div><div class="col-md-6 form-group"><label class="small text-secondary">SINTA ID</label><input type="text" class="form-control form-control-sm" placeholder="Opsional"></div><div class="col-md-6 form-group"><label class="small text-secondary">NIDN</label><input type="text" class="form-control form-control-sm"></div><div class="col-md-6 form-group"><label class="small text-secondary">Scopus ID</label><input type="text" class="form-control form-control-sm" placeholder="Opsional"></div><div class="col-md-6 form-group"><label class="small text-secondary">No. Sertifikasi Dosen</label><input type="text" class="form-control form-control-sm" placeholder="SERDOS-0123-00123"></div><div class="col-md-6 form-group"><label class="small text-secondary">Orchid ID</label><input type="text" class="form-control form-control-sm" placeholder="Opsional"></div><div class="col-md-6 form-group"><label class="small text-secondary">Tgl. Sertifikasi Dosen</label><input type="text" class="form-control form-control-sm" placeholder="mm/dd/yyyy"></div><div class="col-md-6 form-group"><label class="small text-secondary">Google Scholar ID</label><input type="text" class="form-control form-control-sm" placeholder="Opsional"></div></div></div>
                                <div class="sub-tab-content" id="domisili" style="display: none;"><div class="row g-3"><div class="col-md-6 form-group"><label class="small text-secondary">Provinsi</label><select class="form-select form-select-sm"><option selected>Jawa Barat</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">Alamat</label><textarea class="form-control form-control-sm">JL. Lodaya</textarea></div><div class="col-md-6 form-group"><label class="small text-secondary">Kota</label><select class="form-select form-select-sm"><option selected>Bandung</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">Kode Pos</label><input type="text" class="form-control form-control-sm" value="10021"></div><div class="col-md-6 form-group"><label class="small text-secondary">Kecamatan</label><select class="form-select form-select-sm"><option selected>Bandung Tengah</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">No. Telepon/HP</label><input type="text" class="form-control form-control-sm" value="081239128991"></div><div class="col-md-6 form-group"><label class="small text-secondary">Kelurahan</label><select class="form-select form-select-sm"><option selected>Ciawi</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">Email Pribadi / Institusi</label><input type="text" class="form-control form-control-sm" value="aexyifshsi@gmail.com"></div></div></div>
                                <div class="sub-tab-content" id="kependudukan" style="display: none;"><div class="row g-3"><div class="col-md-6 form-group"><label class="small text-secondary">Nomor KTP</label><input type="text" class="form-control form-control-sm" value="31862908812645811"></div><div class="col-md-6 form-group"><label class="small text-secondary">Kecamatan</label><select class="form-select form-select-sm"><option selected>Talang Ubi</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">Nomor KK</label><input type="text" class="form-control form-control-sm" value="8011447152211029"></div><div class="col-md-6 form-group"><label class="small text-secondary">Kelurahan</label><select class="form-select form-select-sm"><option selected>Talang Ubi Barat</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">Warga Negara</label><select class="form-select form-select-sm"><option>--Pilih Salah Satu--</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">Alamat</label><textarea class="form-control form-control-sm">Jl Pendopo</textarea></div><div class="col-md-6 form-group"><label class="small text-secondary">Provinsi</label><select class="form-select form-select-sm"><option selected>Sumatera Selatan</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">Kode Pos</label><input type="text" class="form-control form-control-sm" value="01984"></div><div class="col-md-6 form-group"><label class="small text-secondary">Kabupaten/Kota</label><select class="form-select form-select-sm"><option selected>Sumatera Selatan</option></select></div></div></div>
                                <div class="sub-tab-content" id="efile" style="display: none;">
                                    <div class="efile-header">
                                        <h4>Dokumen</h4>
                                        <button class="btn btn-success"><i class="lni lni-plus me-1"></i> Tambah</button>
                                    </div>

                                    <div class="file-category">
                                        <p class="file-category-title">Biodata</p>
                                        <div class="file-grid">
                                            <div class="file-item">
                                                <span class="file-badge badge-asli">Asli</span>
                                                <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                                <p>Dokumen <span class="d-block">(2020)</span></p>
                                                <div class="file-item-actions">
                                                    <button class="btn btn-sm btn-success"><i class="lni lni-download me-1"></i> Unduh</button>
                                                    <button class="btn btn-sm btn-danger"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                                </div>
                                            </div>
                                            <div class="file-item">
                                                <span class="file-badge badge-asli">Asli</span>
                                                <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                                <p>Dokumen <span class="d-block">(2020)</span></p>
                                                <div class="file-item-actions">
                                                    <button class="btn btn-sm btn-success"><i class="lni lni-download me-1"></i> Unduh</button>
                                                    <button class="btn btn-sm btn-danger"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                                </div>
                                            </div>
                                            <div class="file-item">
                                                <span class="file-badge badge-legalisir">Legalisir</span>
                                                <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                                <p>Dokumen <span class="d-block">(2020)</span></p>
                                                <div class="file-item-actions">
                                                    <button class="btn btn-sm btn-success"><i class="lni lni-download me-1"></i> Unduh</button>
                                                    <button class="btn btn-sm btn-danger"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                                </div>
                                            </div>
                                            <div class="file-item">
                                                <span class="file-badge badge-scan">Scan</span>
                                                <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                                <p>Dokumen <span class="d-block">(2020)</span></p>
                                                <div class="file-item-actions">
                                                    <button class="btn btn-sm btn-success"><i class="lni lni-download me-1"></i> Unduh</button>
                                                    <button class="btn btn-sm btn-danger"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="file-category">
                                        <p class="file-category-title">Pendidikan</p>
                                        <div class="file-grid">
                                            <div class="file-item">
                                                <span class="file-badge badge-legalisir">Legalisir</span>
                                                <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                                <p>Dokumen <span class="d-block">(2020)</span></p>
                                                <div class="file-item-actions">
                                                    <button class="btn btn-sm btn-success"><i class="lni lni-download me-1"></i> Unduh</button>
                                                    <button class="btn btn-sm btn-danger"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                                </div>
                                            </div>
                                            <div class="file-item">
                                                <span class="file-badge badge-asli">Asli</span>
                                                <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                                <p>Dokumen <span class="d-block">(2020)</span></p>
                                                <div class="file-item-actions">
                                                    <button class="btn btn-sm btn-success"><i class="lni lni-download me-1"></i> Unduh</button>
                                                    <button class="btn btn-sm btn-danger"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                                </div>
                                            </div>
                                            <div class="file-item">
                                                <span class="file-badge badge-scan">Scan</span>
                                                <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                                <p>Dokumen <span class="d-block">(2020)</span></p>
                                                <div class="file-item-actions">
                                                    <button class="btn btn-sm btn-success"><i class="lni lni-download me-1"></i> Unduh</button>
                                                    <button class="btn btn-sm btn-danger"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                                </div>
                                            </div>
                                            <div class="file-item">
                                                <span class="file-badge badge-asli">Asli</span>
                                                <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                                <p>Dokumen <span class="d-block">(2020)</span></p>
                                                <div class="file-item-actions">
                                                    <button class="btn btn-sm btn-success"><i class="lni lni-download me-1"></i> Unduh</button>
                                                    <button class="btn btn-sm btn-danger"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="main-tab-content" id="pendidikan-content" style="display: none;">
                                <div id="pendidikan-sub-tabs" class="btn-group flex-wrap gap-2 mb-3">
                                    <button type="button" class="btn active" data-tab="pengajaran-lama">Pengajaran Lama</button>
                                    <button type="button" class="btn" data-tab="pengajaran-luar">Pengajaran Luar</button>
                                    <button type="button" class="btn" data-tab="pengujian-lama">Pengujian Lama</button>
                                    <button type="button" class="btn" data-tab="pembimbing-lama">Pembimbing Lama</button>
                                    <button type="button" class="btn" data-tab="penguji-luar">Penguji Luar</button>
                                    <button type="button" class="btn" data-tab="pembimbing-luar">Pembimbing Luar</button>
                                </div>
                                
                                <div class="tab-filters">
                                    <div class="filter-dropdown-wrapper"><select class="filter-dropdown"><option>Semua Semester</option></select></div>
                                    <div class="input-group" style="width: auto; max-width: 300px;"><span class="input-group-text bg-white"><i class="lni lni-search-alt text-muted"></i></span><input type="text" class="form-control" placeholder="Cari Data..."></div>
                                </div>
                                
                                <div class="sub-tab-content" id="pengajaran-lama" style="display: block;">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tahun Semester</th>
                                                    <th>Kode MK</th>
                                                    <th>Mata Kuliah</th>
                                                    <th>SKS</th>
                                                    <th>Kelas Paralel (Jenis)</th>
                                                    <th>Jumlah Pertemuan</th>
                                                    <th>Dokumen</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>2023/2024 Ganjil</td>
                                                    <td>MNH211</td>
                                                    <td>Biometrika Hutan</td>
                                                    <td>3 (3-0)</td>
                                                    <td>1 (K)</td>
                                                    <td>K,S,P,O,R,O</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>2023/2024 Genap</td>
                                                    <td>MNH215</td>
                                                    <td>Silvikultur Intensif</td>
                                                    <td>2 (2-0)</td>
                                                    <td>2 (K)</td>
                                                    <td>K,S,P,O</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>2022/2023 Ganjil</td>
                                                    <td>THH301</td>
                                                    <td>Teknologi Hasil Hutan</td>
                                                    <td>3 (2-1)</td>
                                                    <td>1 (P)</td>
                                                    <td>K,S,P</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>2022/2023 Genap</td>
                                                    <td>MNH310</td>
                                                    <td>Ekologi Hutan</td>
                                                    <td>3 (3-0)</td>
                                                    <td>3 (K)</td>
                                                    <td>K,S,P,O,R</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>2021/2022 Ganjil</td>
                                                    <td>MNH401</td>
                                                    <td>Manajemen Hutan</td>
                                                    <td>3 (3-0)</td>
                                                    <td>1 (K)</td>
                                                    <td>K,S,P,O,R,O</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="sub-tab-content" id="pengajaran-luar" style="display: none;">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tahun Semester</th>
                                                    <th>Kode MK</th>
                                                    <th>Mata Kuliah</th>
                                                    <th>Jumlah Pertemuan</th>
                                                    <th>Institusi</th>
                                                    <th>Program Studi</th>
                                                    <th>Dokumen</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>2023/2024 Ganjil</td>
                                                    <td>SKL401</td>
                                                    <td>Silvikultur Intensif</td>
                                                    <td>K,S, P,O, R,O</td>
                                                    <td>Universitas Gadjah Mada</td>
                                                    <td>Kehutanan</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>2023/2024 Genap</td>
                                                    <td>EKL302</td>
                                                    <td>Ekologi Hutan</td>
                                                    <td>K,S, P,O, R,O</td>
                                                    <td>Universitas Hasanuddin</td>
                                                    <td>Manajemen Hutan</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>2022/2023 Ganjil</td>
                                                    <td>THT501</td>
                                                    <td>Teknologi Hasil Hutan</td>
                                                    <td>K,S, P,O, R,O</td>
                                                    <td>Institut Pertanian Bogor</td>
                                                    <td>Teknologi Hasil Hutan</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>2022/2023 Genap</td>
                                                    <td>MNH212</td>
                                                    <td>Biometrika Hutan</td>
                                                    <td>K,S, P,O, R,O</td>
                                                    <td>Universitas Mulawarman</td>
                                                    <td>Kehutanan</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>2021/2022 Ganjil</td>
                                                    <td>ILH403</td>
                                                    <td>Ilmu Lingkungan Hutan</td>
                                                    <td>K,S, P,O, R,O</td>
                                                    <td>Universitas Brawijaya</td>
                                                    <td>Kehutanan</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="sub-tab-content" id="pengujian-lama" style="display: none;">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tahun Semester</th>
                                                    <th>NIM</th>
                                                    <th>Nama Mahasiswa</th>
                                                    <th>Strata</th>
                                                    <th>Departemen</th>
                                                    <th>Status</th>
                                                    <th>Dokumen</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>2023/2024 Genap</td>
                                                    <td>H2417001</td>
                                                    <td>Andi Wijaya</td>
                                                    <td>S2</td>
                                                    <td>Manajemen Hutan</td>
                                                    <td>Anggota Penguji</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>2023/2024 Ganjil</td>
                                                    <td>H2417002</td>
                                                    <td>Budi Santoso</td>
                                                    <td>S2</td>
                                                    <td>Teknologi Hasil Hutan</td>
                                                    <td>Anggota Penguji</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>2022/2023 Genap</td>
                                                    <td>H2317003</td>
                                                    <td>Citra Dewi</td>
                                                    <td>S3</td>
                                                    <td>Ilmu Kehutanan</td>
                                                    <td>Anggota Penguji</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="sub-tab-content" id="pembimbing-lama" style="display: none;">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-sm">
                                            <thead><tr><th>No</th><th>Tahun Semester</th><th>Kegiatan</th><th>Nim</th><th>Nama Mahasiswa</th><th>Strata</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                            <tbody>
                                                <tr><td>1</td><td>2020/2021 Genap</td><td>Membimbing dan ikut membimbing.. </td><td>E2039383</td><td>Alex Feruso</td><td>S1</td><td>Pembimbing Pendamping</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>
                                                <tr><td>2</td><td>2020/2021 Genap</td><td>Membimbing dan ikut membimbing.. </td><td>E2039383</td><td>Alex Feruso</td><td>S1</td><td>Pembimbing Pendamping</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>
                                                <tr><td>3</td><td>2020/2021 Genap</td><td>Membimbing dan ikut membimbing.. </td><td>E2039383</td><td>Alex Feruso</td><td>S1</td><td>Pembimbing Pendamping</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="sub-tab-content" id="penguji-luar" style="display: none;">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tahun Semester</th>
                                                    <th>NIM</th>
                                                    <th>Nama Mahasiswa</th>
                                                    <th>Strata</th>
                                                    <th>Universitas</th>
                                                    <th>Status</th>
                                                    <th>Dokumen</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <script>
                                                    for(let i=1; i<=10; i++){ 
                                                        document.write(`
                                                        <tr>
                                                            <td class="text-center">${i}</td>
                                                            <td>2018/2019 Ganjil</td>
                                                            <td class="text-center">160648032</td>
                                                            <td class="text-center">HAQQI ANNAZILLI</td>
                                                            <td>S1</td>
                                                            <td>IPB University</td>
                                                            <td>Anggota Penguji</td>
                                                            <td class="text-center"><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                            <td class="text-center">
                                                                <div class="d-flex gap-2 justify-content-center">
                                                                    <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button>
                                                                    <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="lni lni-trash-can"></i></button>
                                                                </div>
                                                            </td>
                                                        </tr>`);
                                                    }
                                                </script>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="sub-tab-content" id="pembimbing-luar" style="display: none;">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tahun Semester</th>
                                                    <th>NIM</th>
                                                    <th>Nama Mahasiswa</th>
                                                    <th>Strata</th>
                                                    <th>Universitas</th>
                                                    <th>Status</th>
                                                    <th>Dokumen</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <script>
                                                    for(let i=1; i<=10; i++){ 
                                                        document.write(`
                                                        <tr>
                                                            <td class="text-center">${i}</td>
                                                            <td>2018/2019 Ganjil</td>
                                                            <td class="text-center">160648032</td>
                                                            <td class="text-center">HAQQI ANNAZILLI</td>
                                                            <td>S2</td>
                                                            <td>IPB University</td>
                                                            <td>Pembimbing</td>
                                                            <td class="text-center"><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                            <td class="text-center">
                                                                <div class="d-flex gap-2 justify-content-center">
                                                                    <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button>
                                                                    <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="lni lni-trash-can"></i></button>
                                                                </div>
                                                            </td>
                                                        </tr>`);
                                                    }
                                                </script>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="main-tab-content" id="penelitian-content" style="display: none;">
                               <div class="tab-filters">
                                    <div class="filter-dropdown-wrapper"><select class="filter-dropdown"><option>Semua Tahun</option></select></div>
                                    <div class="input-group" style="width: auto; max-width: 300px;"><span class="input-group-text bg-white"><i class="lni lni-search-alt text-muted"></i></span><input type="text" class="form-control" placeholder="Cari Data..."></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-sm">
                                        <thead><tr><th>No</th><th>Judul</th><th>Tgl. Terbit</th><th>Jenis</th><th>Publik</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                        <tbody>
                                            <script>for(let i=1; i<=5; i++){ document.write(`<tr><td>${i}</td><td>Pengaruh Air Terhadap Tumbuh Kembang Leles</td><td>24 Desember 2021</td><td>Karya</td><td>Ya</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>`);}</script>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="main-tab-content" id="pengabdian-content" style="display: none;">
                                <div class="tab-filters">
                                    <div class="filter-dropdown-wrapper"><select class="filter-dropdown"><option>Semua Tahun</option></select></div>
                                    <div class="input-group" style="width: auto; max-width: 300px;"><span class="input-group-text bg-white"><i class="lni lni-search-alt text-muted"></i></span><input type="text" class="form-control" placeholder="Cari Data..."></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-sm">
                                        <thead><tr><th>No</th><th>Judul</th><th>Lokasi</th><th>Tgl. Pelaksanaan</th><th>Dana</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                        <tbody>
                                            <tr><td>1</td><td>Penyuluhan Pengelolaan Hutan Lestari</td><td>Desa Cibodas, Bogor</td><td>15-17 Agustus 2022</td><td>Rp 5.000.000</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="main-tab-content" id="penunjang-content" style="display: none;">
                                <div class="tab-filters">
                                    <div class="filter-dropdown-wrapper"><select class="filter-dropdown" id="penunjang-filter"><option value="organisasi">Organisasi</option><option value="jabatan">Jabatan</option><option value="penghargaan">Penghargaan</option></select></div>
                                    <div class="input-group" style="width: auto; max-width: 300px;"><span class="input-group-text bg-white"><i class="lni lni-search-alt text-muted"></i></span><input type="text" class="form-control" placeholder="Cari Data..."></div>
                                </div>
                                
                                <div class="sub-tab-content" id="organisasi">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-sm">
                                            <thead><tr><th>No</th><th>Nama Organisasi</th><th>Jabatan</th><th>Periode</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                            <tbody>
                                                <tr><td>1</td><td>Ikatan Sarjana Kehutanan Indonesia</td><td>Anggota</td><td>2020-2025</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="sub-tab-content" id="jabatan" style="display: none;">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-sm">
                                            <thead><tr><th>No</th><th>Jabatan</th><th>Unit Kerja</th><th>Periode</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                            <tbody>
                                                <tr><td>1</td><td>Ketua Program Studi</td><td>Manajemen Hutan</td><td>2018-2022</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="main-tab-content" id="pelatihan-content" style="display: none;">
                                <div class="tab-filters">
                                    <div class="filter-dropdown-wrapper"><select class="filter-dropdown"><option>Semua Tahun</option></select></div>
                                    <div class="input-group" style="width: auto; max-width: 300px;"><span class="input-group-text bg-white"><i class="lni lni-search-alt text-muted"></i></span><input type="text" class="form-control" placeholder="Cari Data..."></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-sm">
                                        <thead><tr><th>No</th><th>Nama Pelatihan</th><th>Penyelenggara</th><th>Tgl. Pelaksanaan</th><th>Lokasi</th><th>Sertifikat</th><th>Aksi</th></tr></thead>
                                        <tbody>
                                            <tr><td>1</td><td>Pelatihan Manajemen Hutan Berkelanjutan</td><td>Kementerian Lingkungan Hidup</td><td>10-12 Januari 2023</td><td>Bogor</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="main-tab-content" id="penghargaan-content" style="display: none;">
                                <div class="tab-filters">
                                    <div class="filter-dropdown-wrapper"><select class="filter-dropdown"><option>Semua Tahun</option></select></div>
                                    <div class="input-group" style="width: auto; max-width: 300px;"><span class="input-group-text bg-white"><i class="lni lni-search-alt text-muted"></i></span><input type="text" class="form-control" placeholder="Cari Data..."></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-sm">
                                        <thead><tr><th>No</th><th>Nama Penghargaan</th><th>Pemberi</th><th>Tahun</th><th>Keterangan</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                        <tbody>
                                            <tr><td>1</td><td>Dosen Berprestasi</td><td>IPB University</td><td>2021</td><td>Juara 2 Tingkat Fakultas</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        
        <footer class="footer-custom">
            <span>© 2025 Forest Management — All Rights Reserved</span>
        </footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const toggleSidebarBtn = document.getElementById('toggleSidebar');
        toggleSidebarBtn.addEventListener('click', function () {
            if (window.innerWidth <= 991) {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show', sidebar.classList.contains('show'));
            } else {
                sidebar.classList.toggle('hidden');
            }
        });
        overlay.addEventListener('click', function () {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
        function updateDateTime() {
            const now = new Date();
            document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }).replace(/\./g, ':');
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();
        document.getElementById('main-tab-nav').addEventListener('click', function(e) {
            if (e.target.matches('button.nav-link')) {
                document.querySelectorAll('.main-tab-nav .nav-link').forEach(tab => tab.classList.remove('active'));
                document.querySelectorAll('.main-tab-content').forEach(content => content.style.display = 'none');
                e.target.classList.add('active');
                const contentEl = document.getElementById(`${e.target.dataset.mainTab}-content`);
                if(contentEl) contentEl.style.display = 'block';
            }
        });
        document.querySelectorAll('#pendidikan-sub-tabs, #biodata-sub-tabs').forEach(tabContainer => {
            tabContainer.addEventListener('click', function(e) {
                if (e.target.matches('button')) {
                    const parentContent = this.closest('.main-tab-content');
                    this.querySelectorAll('button').forEach(btn => btn.classList.remove('active'));
                    e.target.classList.add('active');
                    parentContent.querySelectorAll('.sub-tab-content').forEach(content => content.style.display = 'none');
                    const contentEl = parentContent.querySelector(`#${e.target.dataset.tab}`);
                    if(contentEl) contentEl.style.display = 'block';
                }
            });
        });
        const penunjangFilter = document.getElementById('penunjang-filter');
        if (penunjangFilter) {
            penunjangFilter.addEventListener('change', function() {
                const parentContent = this.closest('.main-tab-content');
                parentContent.querySelectorAll('.sub-tab-content').forEach(tab => tab.style.display = 'none');
                const activeTab = document.getElementById(this.value);
                if (activeTab) activeTab.style.display = 'block';
            });
        }
    });
</script>
</body>
</html>