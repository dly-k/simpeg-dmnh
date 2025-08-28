<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Detail Pegawai - SIKEMAH</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/detail-pegawai.css') }}" />
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
                        <li><a class="dropdown-item d-flex align-items-center hover-lightgray" href="/ubah-password"><i class="lni lni-key me-2"></i> Ubah Password</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item d-flex align-items-center dropdown-item-danger" href="/logout"><i class="lni lni-exit me-2"></i> Keluar</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Title Bar -->
        <div class="title-bar d-flex align-items-center justify-content-between">
            <h1 class="m-0">
                <i class="fa fa-user"></i>Detail Pegawai
            </h1>
            <a href="/daftar-pegawai" class="btn-kembali d-flex align-items-center gap-2">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
   
        <div class="main-content">
            <div class="search-filter-container">
                <div class="search-filter-row">
                    <div class="search-box">
                        <div class="input-group custom-search">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-search search-icon"></i></span>
                            <input type="text" class="form-control border-start-0 search-icon search-input" placeholder="Cari Data Pegawai...">
                        </div>
                    </div>
                    <div class="btn-tambah-container">
                        <div class="d-flex gap-2 flex-wrap">
                        <a href="/edit-pegawai" class="btn btn-edit d-flex align-items-center justify-content-center">
                        <i class="fa fa-edit me-2"></i>
                        Edit Data
                        </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-md-row gap-4 mb-5 custom-gap-mb">
                        <div class="text-center flex-shrink-0">
                            <!-- Foto -->
                            <div class="mb-2 mx-auto d-flex align-items-center justify-content-center foto-profil">
                                <i class="lni lni-user"></i>
                            </div>
                            <!-- Tombol Edit -->
                            <button class="btn btn-editfoto btn-sm w-100" onclick="editPhoto()">
                                Edit Foto
                            </button>
                        </div>
                        <div class="flex-grow-1">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="small text-dark fw-medium">NIP</label>
                                    <div class="detail-box">3212302291827320009</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="small text-dark fw-medium">Agama</label>
                                    <div class="detail-box">Islam</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="small text-dark fw-medium">Nama Lengkap</label>
                                    <div class="detail-box">Joko Anwar S.Hut</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="small text-dark fw-medium">Status Pernikahan</label>
                                    <div class="detail-box">Belum Menikah</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="small text-dark fw-medium">Jenis Kelamin</label>
                                    <div class="detail-box">Laki-laki</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="small text-dark fw-medium">Pendidikan Terakhir</label>
                                    <div class="detail-box">S3</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="small text-dark fw-medium">Tempat Lahir</label>
                                    <div class="detail-box">Jakarta</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="small text-dark fw-medium">Bidang Ilmu</label>
                                    <div class="detail-box">Ilmu Pengelolaan Hutan</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="small text-dark fw-medium">Tanggal Lahir</label>
                                    <div class="detail-box">13 Agustus 1961</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-4 divider-light">
                     
                  <!-- Kolom Main-Tab (Biodata)-->
                  <div class="d-flex flex-column flex-lg-row gap-4">
                    <div class="nav flex-column nav-pills main-tab-nav" id="main-tab-nav">
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
                        <div class="main-tab-content" id="biodata-content">
                            <div id="biodata-sub-tabs" class="btn-group flex-wrap gap-2 mb-4">
                                <button type="button" class="btn active" data-tab="kepegawaian">Kepegawaian</button>
                                <button type="button" class="btn" data-tab="dosen">Dosen</button>
                                <button type="button" class="btn" data-tab="domisili">Alamat Domisili & Kontak</button>
                                <button type="button" class="btn" data-tab="kependudukan">Kependudukan</button>
                                <button type="button" class="btn" data-tab="efile">E-File</button>
                            </div>

                            <!-- Kepegawaian Content -->
                            <div class="sub-tab-content" id="kepegawaian">
                                <div class="row g-3">

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Status Kepegawaian</label>
                                        <div class="detail-box">Dosen PNS</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Status Pegawai</label>
                                        <div class="detail-box">Aktif</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Unit Kerja</label>
                                        <div class="detail-box">Fakultas Kehutanan dan Lingkungan</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Divisi</label>
                                        <div class="detail-box">Departemen Manajemen Hutan</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Nomor Arsip Berkas Kepegawaian</label>
                                        <div class="detail-box">046</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Jabatan Fungsional</label>
                                        <div class="detail-box">Tidak ada</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Pangkat/Golongan</label>
                                        <div class="detail-box">Juru Muda / I-a</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">TMT Pangkat Terakhir</label>
                                        <div class="detail-box">01 Maret 2021</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Jabatan Struktural (jika ada)</label>
                                        <div class="detail-box">Tidak ada</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Periode Jabatan Struktural (TMT s/d TST)</label>
                                        <div class="detail-box">14 Juli 2023 s/d 01 Maret 2028</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Finger Print ID</label>
                                        <div class="detail-box">15213</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">NPWP</label>
                                        <div class="detail-box">764906129203000</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Nama Bank</label>
                                        <div class="detail-box">Bank BRI</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">No Rekening</label>
                                        <div class="detail-box">012819102912191</div>
                                    </div>

                                </div>
                            </div>
                            
                            <!-- Dosen Content -->
                            <div class="sub-tab-content" id="dosen">
                                <div class="row g-3">
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">NUPTK</label>
                                        <div class="detail-box">1234567890123456</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">SINTA ID</label>
                                        <div class="detail-box">1234-5678</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">NIDN</label>
                                        <div class="detail-box">123456781273811</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Scopus ID</label>
                                        <div class="detail-box">56766236300</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">No. Sertifikasi Dosen</label>
                                        <div class="detail-box">24-001013-0100</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Orchid ID</label>
                                        <div class="detail-box">0000-0002-1825-0097</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Tgl. Sertifikasi Dosen</label>
                                        <div class="detail-box">17 Agustus 1880</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Google Scholar ID</label>
                                        <div class="detail-box">abcdefg12345678</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Domisili Content -->
                            <div class="sub-tab-content" id="domisili">
                                <div class="row g-3">
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Provinsi</label>
                                        <div class="detail-box">Jawa Barat</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Alamat</label>
                                        <div class="detail-box">JL. Lodaya</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Kota</label>
                                        <div class="detail-box">Bandung</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Kode Pos</label>
                                        <div class="detail-box">10021</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Kecamatan</label>
                                        <div class="detail-box">Bandung Tengah</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">No. Telepon/HP</label>
                                        <div class="detail-box">081239128991</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Kelurahan</label>
                                        <div class="detail-box">Ciawi</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Email Pribadi / Institusi</label>
                                        <div class="detail-box">aexyifshsi@gmail.com</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kependudukan Content -->
                            <div class="sub-tab-content" id="kependudukan">
                                <div class="row g-3">

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Nomor KTP</label>
                                        <div class="detail-box">31862908812645811</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Kecamatan</label>
                                        <div class="detail-box">Talang Ubi</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Nomor KK</label>
                                        <div class="detail-box">8011447152211029</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Kelurahan</label>
                                        <div class="detail-box">Pisangan Timur</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Warga Negara</label>
                                        <div class="detail-box">Indonesia</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Kode Pos</label>
                                        <div class="detail-box">01984</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Provinsi</label>
                                        <div class="detail-box">Sumatera Barat</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Kabupaten/Kota</label>
                                        <div class="detail-box">Cimahi</div>
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label class="small text-dark fw-medium">Alamat</label>
                                        <div class="detail-box">Jalan Cendrawasih No. 25, RT 03/RW 05</div>
                                    </div>
                                </div>
                            </div>

                            <!-- efile Content -->
                            <div class="sub-tab-content" id="efile">
                                <div class="efile-header">
                                    <h4>Dokumen</h4>
                                    <button class="btn btn-tambah" data-bs-toggle="modal" data-bs-target="#tambahDokumenModal"><i class="lni lni-plus me-1"></i> Tambah</button>
                                </div>

                                <div class="file-category">
                                    <p class="file-category-title">Biodata</p>
                                    <div class="file-grid">
                                        <div class="file-item" data-file="assets/pdf/example.pdf">
                                            <span class="file-badge badge-asli">Asli</span>
                                            <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                            <p>Dokumen <span class="d-block">(2020)</span></p>
                                            <div class="file-item-actions">
                                                <button class="btn btn-sm btn-unduh" data-file="assets/pdf/example.pdf">
                                                    <i class="lni lni-download me-1"></i> Unduh
                                                </button>
                                                <button class="btn btn-sm btn-hapusfile"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                            </div>
                                        </div>

                                        <div class="file-item">
                                            <span class="file-badge badge-legalisir">Legalisir</span>
                                            <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                            <p>Dokumen <span class="d-block">(2020)</span></p>
                                            <div class="file-item-actions">
                                                <button class="btn btn-sm btn-unduh"><i class="lni lni-download me-1"></i> Unduh</button>
                                                <button class="btn btn-sm btn-hapusfile"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                            </div>
                                        </div>
                                        <div class="file-item">
                                            <span class="file-badge badge-scan">Scan</span>
                                            <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                            <p>Dokumen <span class="d-block">(2020)</span></p>
                                            <div class="file-item-actions">
                                                <button class="btn btn-sm btn-unduh"><i class="lni lni-download me-1"></i> Unduh</button>
                                                <button class="btn btn-sm btn-hapusfile"><i class="lni lni-trash-can me-1"></i> Hapus</button>
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
                                                <button class="btn btn-sm btn-unduh"><i class="lni lni-download me-1"></i> Unduh</button>
                                                <button class="btn btn-sm btn-hapusfile"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                            </div>
                                        </div>
                                        <div class="file-item">
                                            <span class="file-badge badge-asli">Asli</span>
                                            <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                            <p>Dokumen <span class="d-block">(2020)</span></p>
                                            <div class="file-item-actions">
                                                <button class="btn btn-sm btn-unduh"><i class="lni lni-download me-1"></i> Unduh</button>
                                                <button class="btn btn-sm btn-hapusfile"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                            </div>
                                        </div>
                                        <div class="file-item">
                                            <span class="file-badge badge-scan">Scan</span>
                                            <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                            <p>Dokumen <span class="d-block">(2020)</span></p>
                                            <div class="file-item-actions">
                                                <button class="btn btn-sm btn-unduh"><i class="lni lni-download me-1"></i> Unduh</button>
                                                <button class="btn btn-sm btn-hapusfile"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="file-category">
                                    <p class="file-category-title">Jabatan Fungsional</p>
                                    <div class="file-grid">
                                        <div class="file-item">
                                            <span class="file-badge badge-legalisir">Legalisir</span>
                                            <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                            <p>Dokumen <span class="d-block">(2020)</span></p>
                                            <div class="file-item-actions">
                                                <button class="btn btn-sm btn-unduh"><i class="lni lni-download me-1"></i> Unduh</button>
                                                <button class="btn btn-sm btn-hapusfile"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                            </div>
                                        </div>
                                        <div class="file-item">
                                            <span class="file-badge badge-asli">Asli</span>
                                            <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                            <p>Dokumen <span class="d-block">(2020)</span></p>
                                            <div class="file-item-actions">
                                                <button class="btn btn-sm btn-unduh"><i class="lni lni-download me-1"></i> Unduh</button>
                                                <button class="btn btn-sm btn-hapusfile"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                            </div>
                                        </div>
                                        <div class="file-item">
                                            <span class="file-badge badge-scan">Scan</span>
                                            <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                            <p>Dokumen <span class="d-block">(2020)</span></p>
                                            <div class="file-item-actions">
                                                <button class="btn btn-sm btn-unduh"><i class="lni lni-download me-1"></i> Unduh</button>
                                                <button class="btn btn-sm btn-hapusfile"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="file-category">
                                    <p class="file-category-title">Surat Keputusan Kepangkatan</p>
                                    <div class="file-grid">
                                        <div class="file-item">
                                            <span class="file-badge badge-legalisir">Legalisir</span>
                                            <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                            <p>Dokumen <span class="d-block">(2020)</span></p>
                                            <div class="file-item-actions">
                                                <button class="btn btn-sm btn-unduh"><i class="lni lni-download me-1"></i> Unduh</button>
                                                <button class="btn btn-sm btn-hapusfile"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                            </div>
                                        </div>
                                        <div class="file-item">
                                            <span class="file-badge badge-asli">Asli</span>
                                            <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                            <p>Dokumen <span class="d-block">(2020)</span></p>
                                            <div class="file-item-actions">
                                                <button class="btn btn-sm btn-unduh"><i class="lni lni-download me-1"></i> Unduh</button>
                                                <button class="btn btn-sm btn-hapusfile"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                            </div>
                                        </div>
                                        <div class="file-item">
                                            <span class="file-badge badge-scan">Scan</span>
                                            <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                            <p>Dokumen <span class="d-block">(2020)</span></p>
                                            <div class="file-item-actions">
                                                <button class="btn btn-sm btn-unduh"><i class="lni lni-download me-1"></i> Unduh</button>
                                                <button class="btn btn-sm btn-hapusfile"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="file-category">
                                    <p class="file-category-title">Surat Penting</p>
                                    <div class="file-grid">
                                        <div class="file-item">
                                            <span class="file-badge badge-legalisir">Legalisir</span>
                                            <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                            <p>Dokumen <span class="d-block">(2020)</span></p>
                                            <div class="file-item-actions">
                                                <button class="btn btn-sm btn-unduh"><i class="lni lni-download me-1"></i> Unduh</button>
                                                <button class="btn btn-sm btn-hapusfile"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                            </div>
                                        </div>
                                        <div class="file-item">
                                            <span class="file-badge badge-asli">Asli</span>
                                            <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                            <p>Dokumen <span class="d-block">(2020)</span></p>
                                            <div class="file-item-actions">
                                                <button class="btn btn-sm btn-unduh"><i class="lni lni-download me-1"></i> Unduh</button>
                                                <button class="btn btn-sm btn-hapusfile"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                            </div>
                                        </div>
                                        <div class="file-item">
                                            <span class="file-badge badge-scan">Scan</span>
                                            <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                            <p>Dokumen <span class="d-block">(2020)</span></p>
                                            <div class="file-item-actions">
                                                <button class="btn btn-sm btn-unduh"><i class="lni lni-download me-1"></i> Unduh</button>
                                                <button class="btn btn-sm btn-hapusfile"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="file-category">
                                    <p class="file-category-title">Dokumen Pendukung Lainnya</p>
                                    <div class="file-grid">
                                        <div class="file-item">
                                            <span class="file-badge badge-legalisir">Legalisir</span>
                                            <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                            <p>Dokumen <span class="d-block">(2020)</span></p>
                                            <div class="file-item-actions">
                                                <button class="btn btn-sm btn-unduh"><i class="lni lni-download me-1"></i> Unduh</button>
                                                <button class="btn btn-sm btn-hapusfile"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                            </div>
                                        </div>
                                        <div class="file-item">
                                            <span class="file-badge badge-asli">Asli</span>
                                            <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                            <p>Dokumen <span class="d-block">(2020)</span></p>
                                            <div class="file-item-actions">
                                                <button class="btn btn-sm btn-unduh"><i class="lni lni-download me-1"></i> Unduh</button>
                                                <button class="btn btn-sm btn-hapusfile"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                            </div>
                                        </div>
                                        <div class="file-item">
                                            <span class="file-badge badge-scan">Scan</span>
                                            <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                            <p>Dokumen <span class="d-block">(2020)</span></p>
                                            <div class="file-item-actions">
                                                <button class="btn btn-sm btn-unduh"><i class="lni lni-download me-1"></i> Unduh</button>
                                                <button class="btn btn-sm btn-hapusfile"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Main-Tab (Pendidikan)-->
                        <div class="main-tab-content" id="pendidikan-content">
                            <div id="pendidikan-sub-tabs" class="btn-group flex-wrap gap-2 mb-3">
                                <button type="button" class="btn active" data-tab="pengajaran-lama">Pengajaran Lama</button>
                                <button type="button" class="btn" data-tab="pengajaran-luar">Pengajaran Luar</button>
                                <button type="button" class="btn" data-tab="pengujian-lama">Pengujian Lama</button>
                                <button type="button" class="btn" data-tab="pembimbing-lama">Pembimbing Lama</button>
                                <button type="button" class="btn" data-tab="penguji-luar">Penguji Luar</button>
                                <button type="button" class="btn" data-tab="pembimbing-luar">Pembimbing Luar</button>
                            </div>
                            
                            <!-- Pengajaran Lama Content -->
                            <div class="sub-tab-content" id="pengajaran-lama">
                            <div class="tab-filters">
                                <div class="filter-dropdown-wrapper"><select class="form-select filter-select"><option selected>Semester</option><option>Genap 2024/2025</option></select></div>
                                <div class="input-group custom-input-group"><span class="input-group-text bg-light"><i class="fas fa-search search-icon"></i></span><input type="text" class="form-control search-input border-start-0" placeholder="Cari Data ...."></div>
                            </div>
                            {{-- Tabel Data --}}
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr class="text-center"><th>No</th><th>Tahun Semester</th><th>Kode MK</th><th>Mata Kuliah</th><th>SKS</th><th>Kelas Paralel (Jenis)</th><th>Jumlah Pertemuan</th><th>Dokumen</th><th>Aksi</th></tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            // Contoh data lengkap untuk Pengajaran Lama
                                            $dataPengajaran = collect(json_decode('[{"id": 1, "kegiatan": "Senam Lele Merdeka", "nama": "Dr. Stone Pamungkas", "tahun_semester": "2018/2019 Ganjil", "kode_mk": "UGE - 912", "nama_mk": "Pembudidayaan Ikan Lele", "pengampu": "Teknologi Rekayasa Empang", "sks_kuliah": "0", "sks_praktikum": "99", "jenis": "Tidak Berjenis", "kelas_paralel": "1", "jenis_kelas": "K", "jumlah_pertemuan": 6, "verified": true, "dokumen_path": "assets/pdf/example.pdf"}, {"id": 1, "kegiatan": "Senam Lele Merdeka", "nama": "Dr. Stone Pamungkas", "tahun_semester": "2018/2019 Ganjil", "kode_mk": "UGE - 912", "nama_mk": "Pembudidayaan Ikan Lele", "pengampu": "Teknologi Rekayasa Empang", "sks_kuliah": "0", "sks_praktikum": "99", "jenis": "Tidak Berjenis", "kelas_paralel": "1", "jenis_kelas": "K", "jumlah_pertemuan": 6, "verified": false, "dokumen_path": "assets/pdf/example.pdf"}]'));
                                        @endphp

                                        @foreach ($dataPengajaran as $index => $item)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td class="text-center">{{ $item->tahun_semester }}</td>
                                            <td class="text-center">{{ $item->kode_mk }}</td>
                                            <td>{{ $item->nama_mk }}</td>
                                            <td class="text-center">{{ (int)$item->sks_kuliah + (int)$item->sks_praktikum }} ({{$item->sks_kuliah}}-{{$item->sks_praktikum}})</td>
                                            <td class="text-center">{{ $item->kelas_paralel }} ({{ $item->jenis_kelas }})</td>
                                            <td class="text-center">{{ $item->jumlah_pertemuan }}</td>
                                            <td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td>
                                            <td class="text-center">
                                                <div class="d-flex gap-2 justify-content-center">                                                   
                                                    {{-- Tombol Lihat Detail --}}
                                                    <a href="#" class="btn-aksi btn-lihat-detail" title="Lihat Detail"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalDetailPengajaranLama"
                                                    data-kegiatan="{{ $item->kegiatan }}"
                                                    data-nama="{{ $item->nama }}"
                                                    data-tahun_semester="{{ $item->tahun_semester }}"
                                                    data-kode_mk="{{ $item->kode_mk }}"
                                                    data-nama_mk="{{ $item->nama_mk }}"
                                                    data-pengampu="{{ $item->pengampu }}"
                                                    data-sks_kuliah="{{ $item->sks_kuliah }}"
                                                    data-sks_praktikum="{{ $item->sks_praktikum }}"
                                                    data-jenis="{{ $item->jenis }}"
                                                    data-kelas_paralel="{{ $item->kelas_paralel }}"
                                                    data-jumlah_pertemuan="{{ $item->jumlah_pertemuan }}"
                                                    data-dokumen_path="{{ $item->dokumen_path }}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            </div>
                                
                            <!-- Pengajaran Luar Content -->
                            <div class="sub-tab-content" id="pengajaran-luar">
                            <div class="tab-filters">
                                <div class="filter-dropdown-wrapper"><select class="form-select filter-select"><option selected>Semester</option><option>Genap 2024/2025</option></select></div>
                                <div class="input-group custom-input-group"><span class="input-group-text bg-light"><i class="fas fa-search search-icon"></i></span><input type="text" class="form-control search-input border-start-0" placeholder="Cari Data ...."></div>
                            </div>
                            {{-- Tabel Data --}}
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr class="text-center"><th>No</th><th>Tahun Semester</th><th>Kode MK</th><th>Mata Kuliah</th><th>Jumlah Pertemuan</th><th>Institusi</th><th>Program Studi</th><th>Dokumen</th><th>Aksi</th></tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            // Contoh data lengkap untuk Pengajaran Luar
                                            $dataPengajaranLuar = collect(json_decode('[{"id": 1, "nama": "Dr. Stone Pamungkas", "tahun_semester": "2018/2019 Ganjil", "universitas": "Universitas Gali Empang", "kode_mk": "UGE - 912", "nama_mk": "Pembudidayaan Ikan Lele", "program_studi": "Teknologi Rekayasa Empang", "sks_kuliah": 0, "sks_praktikum": 99, "jenis": "Tidak Berjenis", "kelas_paralel": "1", "jumlah_pertemuan": 6, "is_insidental": "Tidak", "is_lebih_satu_semester": "Ya", "verified": true, "dokumen_path": "assets/pdf/example.pdf"}, {"id": 1, "nama": "Dr. Stone Pamungkas", "tahun_semester": "2018/2019 Ganjil", "universitas": "Universitas Gali Empang", "kode_mk": "UGE - 912", "nama_mk": "Pembudidayaan Ikan Lele", "program_studi": "Teknologi Rekayasa Empang", "sks_kuliah": 0, "sks_praktikum": 99, "jenis": "Tidak Berjenis", "kelas_paralel": "1", "jumlah_pertemuan": 6, "is_insidental": "Tidak", "is_lebih_satu_semester": "Ya", "verified": false, "dokumen_path": "assets/pdf/example.pdf"}]'));
                                        @endphp

                                        @foreach ($dataPengajaranLuar as $index => $item)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td class="text-center">{{ $item->tahun_semester }}</td>
                                            <td class="text-center">{{ $item->kode_mk }}</td>
                                            <td>{{ $item->nama_mk }}</td>
                                            <td class="text-center">{{ $item->jumlah_pertemuan }}</td>
                                            <td>{{ $item->universitas }}</td>
                                            <td>{{ $item->program_studi }}</td>
                                            <td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td>
                                            <td class="text-center">
                                                <div class="d-flex gap-2 justify-content-center">
                                                    {{-- Tombol Lihat Detail --}}
                                                    <a href="#" class="btn-aksi btn-lihat-detail" title="Lihat Detail"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalDetailPengajaranLuar"
                                                    data-nama="{{ $item->nama }}"
                                                    data-tahun_semester="{{ $item->tahun_semester }}"
                                                    data-universitas="{{ $item->universitas }}"
                                                    data-kode_mk="{{ $item->kode_mk }}"
                                                    data-nama_mk="{{ $item->nama_mk }}"
                                                    data-program_studi="{{ $item->program_studi }}"
                                                    data-sks_kuliah="{{ $item->sks_kuliah }}"
                                                    data-sks_praktikum="{{ $item->sks_praktikum }}"
                                                    data-jenis="{{ $item->jenis }}"
                                                    data-kelas_paralel="{{ $item->kelas_paralel }}"
                                                    data-jumlah_pertemuan="{{ $item->jumlah_pertemuan }}"
                                                    data-is_insidental="{{ $item->is_insidental }}"
                                                    data-is_lebih_satu_semester="{{ $item->is_lebih_satu_semester }}"
                                                    data-dokumen_path="{{ $item->dokumen_path }}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            </div>
                                
                            <!-- Pengujian Lama Content -->
                            <div class="sub-tab-content" id="pengujian-lama">
                            <div class="tab-filters">
                                <div class="filter-dropdown-wrapper"><select class="form-select filter-select"><option selected>Semester</option><option>Genap 2024/2025</option></select></div>
                                <div class="input-group custom-input-group"><span class="input-group-text bg-light"><i class="fas fa-search search-icon"></i></span><input type="text" class="form-control search-input border-start-0" placeholder="Cari Data ...."></div>
                            </div>
                                {{-- Tabel Data --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr class="text-center"><th>No</th><th>Tahun Semester</th><th>NIM</th><th>Nama Mahasiswa</th><th>Strata</th><th>Departemen</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr>
                        </thead>
                        <tbody>
                            @php
                                // Contoh data lengkap untuk Pengujian Lama
                                $dataPengujianLama = collect(json_decode('[{"id": 1, "kegiatan": "Senam Lele Merdeka", "nama": "Dr. Stone Pamungkas", "strata": "S1", "tahun_semester": "2018/2019 Ganjil", "nim": "UGE - 912", "nama_mahasiswa": "Pembudidayaan Ikan Lele", "departemen": "Teknologi Rekayasa Empang", "status_penguji": "Ketua Penguji", "verified": true, "dokumen_path": "assets/pdf/example.pdf"}, {"id": 1, "kegiatan": "Senam Lele Merdeka", "nama": "Dr. Stone Pamungkas", "strata": "S1", "tahun_semester": "2018/2019 Ganjil", "nim": "UGE - 912", "nama_mahasiswa": "Pembudidayaan Ikan Lele", "departemen": "Teknologi Rekayasa Empang", "status_penguji": "Ketua Penguji", "verified": false, "dokumen_path": "assets/pdf/example.pdf"}]'));
                            @endphp

                            @foreach ($dataPengujianLama as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ $item->tahun_semester }}</td>
                                <td class="text-center">{{ $item->nim }}</td>
                                <td>{{ $item->nama_mahasiswa }}</td>
                                <td class="text-center">{{ $item->strata }}</td>
                                <td>{{ $item->departemen }}</td>
                                <td>{{ $item->status_penguji }}</td>
                                <td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        {{-- Tombol Lihat Detail --}}
                                        <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-detail-pengujian" title="Lihat Detail"
                                          data-bs-toggle="modal"
                                          data-bs-target="#modalDetailPengujianLama"
                                          data-kegiatan="{{ $item->kegiatan }}"
                                          data-nama="{{ $item->nama }}"
                                          data-tahun_semester="{{ $item->tahun_semester }}"
                                          data-nim="{{ $item->nim }}"
                                          data-nama_mahasiswa="{{ $item->nama_mahasiswa }}"
                                          data-departemen="{{ $item->departemen }}"
                                          data-dokumen_path="{{ $item->dokumen_path }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        
                                        <a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                            </div>

                            <!-- Pembimbing Lama Content -->
                            <div class="sub-tab-content" id="pembimbing-lama">
                            <div class="tab-filters">
                                <div class="filter-dropdown-wrapper"><select class="form-select filter-select"><option selected>Semester</option><option>Genap 2024/2025</option></select></div>
                                <div class="input-group custom-input-group"><span class="input-group-text bg-light"><i class="fas fa-search search-icon"></i></span><input type="text" class="form-control search-input border-start-0" placeholder="Cari Data ...."></div>
                            </div>
                            {{-- Tabel Data --}}
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr class="text-center"><th>No</th><th>Kegiatan</th><th>Tahun Semester</th><th>NIM</th><th>Nama Mahasiswa</th><th>Departemen</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            // Contoh data lengkap untuk Pembimbing Lama
                                            $dataPembimbingLama = collect(json_decode('[{"id": 1, "kegiatan": "Membimbing dan ikut membimbing dalam menghasilkan disertasi", "nama": "Dr. Stone Pamungkas", "tahun_semester": "2018/2019 Ganjil", "nim": "UGE - 912", "nama_mahasiswa": "Pembudidayaan Ikan Lele", "strata": "S1", "departemen": "Teknologi Rekayasa Empang", "lokasi": "PT. Lele Tanpa Ekor", "nama_dokumen": "Laporan PL", "status_pembimbing": "Pembimbing Utama", "verified": true, "dokumen_path": "assets/pdf/example.pdf"}, {"id": 1, "kegiatan": "Membimbing dan ikut membimbing dalam menghasilkan disertasi", "nama": "Dr. Stone Pamungkas", "tahun_semester": "2018/2019 Ganjil", "nim": "UGE - 912", "nama_mahasiswa": "Pembudidayaan Ikan Lele", "strata": "S1", "departemen": "Teknologi Rekayasa Empang", "lokasi": "PT. Lele Tanpa Ekor", "nama_dokumen": "Laporan PL", "status_pembimbing": "Pembimbing Utama", "verified": false, "dokumen_path": "assets/pdf/example.pdf"}]'));
                                        @endphp

                                        @foreach ($dataPembimbingLama as $index => $item)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td class="text-start">{{ Str::limit($item->kegiatan, 30) }}</td>
                                            <td class="text-center">{{ $item->tahun_semester }}</td>
                                            <td class="text-center">{{ $item->nim }}</td>
                                            <td>{{ $item->nama_mahasiswa }}</td>
                                            <td>{{ $item->departemen }}</td>
                                            <td>{{ $item->status_pembimbing }}</td>
                                            <td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td>
                                            <td class="text-center">
                                                <div class="d-flex gap-2 justify-content-center">
                                                    {{-- Tombol Lihat Detail --}}
                                                    <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-detail-pembimbing" title="Lihat Detail"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalDetailPembimbingLama"
                                                        data-kegiatan="{{ $item->kegiatan }}"
                                                        data-nama="{{ $item->nama }}"
                                                        data-tahun_semester="{{ $item->tahun_semester }}"
                                                        data-lokasi="{{ $item->lokasi }}"
                                                        data-nim="{{ $item->nim }}"
                                                        data-nama_mahasiswa="{{ $item->nama_mahasiswa }}"
                                                        data-departemen="{{ $item->departemen }}"
                                                        data-nama_dokumen="{{ $item->nama_dokumen }}"
                                                        data-dokumen_path="{{ $item->dokumen_path }}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    
                                                    <a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            </div>

                            <!-- Penguji Luar Content -->
                            <div class="sub-tab-content" id="penguji-luar">
                            <div class="tab-filters">
                                <div class="filter-dropdown-wrapper"><select class="form-select filter-select"><option selected>Semester</option><option>Genap 2024/2025</option></select></div>
                                <div class="input-group custom-input-group"><span class="input-group-text bg-light"><i class="fas fa-search search-icon"></i></span><input type="text" class="form-control search-input border-start-0" placeholder="Cari Data ...."></div>
                            </div>  
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr class="text-center"><th>No</th><th>Tahun Semester</th><th>NIM</th><th>Nama Mahasiswa</th><th>Universitas</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            // Contoh data lengkap untuk Penguji Luar
                                            $dataPengujiLuar = collect(json_decode('[{"id": 1, "kegiatan": "Senam Lele Merdeka", "nama": "Dr. Stone Pamungkas", "status": "Dosen Penguji", "tahun_semester": "2018/2019 Ganjil", "nim": "UGE - 912", "nama_mahasiswa": "Budi Lele", "universitas": "Universitas Gali Empang", "program_studi": "Teknologi Rekayasa Empang", "is_insidental": "Ya", "is_lebih_satu_semester": "Tidak", "verified": true, "dokumen_path": "assets/pdf/example.pdf"}, {"id": 1, "kegiatan": "Senam Lele Merdeka", "nama": "Dr. Stone Pamungkas", "status": "Dosen Penguji", "tahun_semester": "2018/2019 Ganjil", "nim": "UGE - 912", "nama_mahasiswa": "Budi Lele", "universitas": "Universitas Gali Empang", "program_studi": "Teknologi Rekayasa Empang", "is_insidental": "Ya", "is_lebih_satu_semester": "Tidak", "verified": false, "dokumen_path": "assets/pdf/example.pdf"}]'));
                                        @endphp

                                        @foreach ($dataPengujiLuar as $index => $item)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td class="text-center">{{ $item->tahun_semester }}</td>
                                            <td class="text-center">{{ $item->nim }}</td>
                                            <td>{{ $item->nama_mahasiswa }}</td>
                                            <td>{{ $item->universitas }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td>
                                            <td class="text-center">
                                                <div class="d-flex gap-2 justify-content-center">
                                                    {{-- Tombol Lihat Detail --}}
                                                    <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-detail-penguji-luar" title="Lihat Detail"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalDetailPengujiLuar"
                                                    data-kegiatan="{{ $item->kegiatan }}"
                                                    data-nama="{{ $item->nama }}"
                                                    data-status="{{ $item->status }}"
                                                    data-tahun_semester="{{ $item->tahun_semester }}"
                                                    data-nim="{{ $item->nim }}"
                                                    data-nama_mahasiswa="{{ $item->nama_mahasiswa }}"
                                                    data-universitas="{{ $item->universitas }}"
                                                    data-program_studi="{{ $item->program_studi }}"
                                                    data-is_insidental="{{ $item->is_insidental }}"
                                                    data-is_lebih_satu_semester="{{ $item->is_lebih_satu_semester }}"
                                                    data-dokumen_path="{{ $item->dokumen_path }}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            </div>
                            
                            <!-- Pembimbing Luar Content -->
                            <div class="sub-tab-content" id="pembimbing-luar">
                            <div class="tab-filters">
                                <div class="filter-dropdown-wrapper"><select class="form-select filter-select"><option selected>Semester</option><option>Genap 2024/2025</option></select></div>
                                <div class="input-group custom-input-group"><span class="input-group-text bg-light"><i class="fas fa-search search-icon"></i></span><input type="text" class="form-control search-input border-start-0" placeholder="Cari Data ...."></div>
                            </div>
                            {{-- Tabel Data --}}
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr class="text-center"><th>No</th><th>Tahun Semester</th><th>NIM</th><th>Nama Mahasiswa</th><th>Universitas</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                // Contoh data lengkap untuk Pembimbing Luar
                                                $dataPembimbingLuar = collect(json_decode('[{"id": 1, "kegiatan": "Senam Lele Merdeka", "nama": "Dr. Stone Pamungkas", "status": "Dosen Pembimbing", "tahun_semester": "2018/2019 Ganjil", "nim": "UGE - 912", "nama_mahasiswa": "Budi Lele", "universitas": "Universitas Gali Empang", "program_studi": "Teknologi Rekayasa Empang", "is_insidental": "Ya", "is_lebih_satu_semester": "Tidak", "verified": true, "dokumen_path": "assets/pdf/example.pdf"}, {"id": 1, "kegiatan": "Senam Lele Merdeka", "nama": "Dr. Stone Pamungkas", "status": "Dosen Pembimbing", "tahun_semester": "2018/2019 Ganjil", "nim": "UGE - 912", "nama_mahasiswa": "Budi Lele", "universitas": "Universitas Gali Empang", "program_studi": "Teknologi Rekayasa Empang", "is_insidental": "Ya", "is_lebih_satu_semester": "Tidak", "verified": false, "dokumen_path": "assets/pdf/example.pdf"}]'));
                                            @endphp

                                            @foreach ($dataPembimbingLuar as $index => $item)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td class="text-center">{{ $item->tahun_semester }}</td>
                                                <td class="text-center">{{ $item->nim }}</td>
                                                <td>{{ $item->nama_mahasiswa }}</td>
                                                <td>{{ $item->universitas }}</td>
                                                <td>{{ $item->status }}</td>
                                                <td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td>
                                                <td class="text-center">
                                                    <div class="d-flex gap-2 justify-content-center">                                       
                                                        {{-- Tombol Lihat Detail --}}
                                                        <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-detail-pembimbing-luar" title="Lihat Detail"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalDetailPembimbingLuar"
                                                        data-kegiatan="{{ $item->kegiatan }}"
                                                        data-nama="{{ $item->nama }}"
                                                        data-status="{{ $item->status }}"
                                                        data-tahun_semester="{{ $item->tahun_semester }}"
                                                        data-nim="{{ $item->nim }}"
                                                        data-nama_mahasiswa="{{ $item->nama_mahasiswa }}"
                                                        data-universitas="{{ $item->universitas }}"
                                                        data-program_studi="{{ $item->program_studi }}"
                                                        data-is_insidental="{{ $item->is_insidental }}"
                                                        data-is_lebih_satu_semester="{{ $item->is_lebih_satu_semester }}"
                                                        data-dokumen_path="{{ $item->dokumen_path }}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>

                                                        <a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <span class="text-muted small">Menampilkan 1 sampai 10 dari 13 data</span>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">Berikutnya</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>

                        <!-- Penelitian Content -->
                        <div class="main-tab-content" id="penelitian-content">
                        <div class="tab-filters">
                                <div class="filter-dropdown-wrapper d-flex gap-2">
                                <select class="form-select">
                                    <option>Tahun</option>
                                    <option>2025</option>
                                    <option>2026</option>
                                    <option>2027</option>
                                </select>
                                <select class="form-select filter-select">
                                    <option selected disabled>Jenis Karya</option>
                                    <option value="Buku Monograf">Buku Monograf</option>
                                    <option value="Buku Referensi">Buku Referensi</option>
                                    <option value="Book Chapter Internasional">Book Chapter Tingkat Internasional</option>
                                    <option value="Book Chapter Nasional">Book Chapter Tingkat Nasional</option>
                                    <option value="Menyunting Buku">Mengedit/Menyunting Karya Ilmiah dalam Bentuk Buku yang Diterbitkan</option>
                                    <option value="Jurnal Internasional Bereputasi">Jurnal Internasional Bereputasi</option>
                                    <option value="Jurnal Internasional Terindeks">Jurnal Internasional Terindeks</option>
                                    <option value="Jurnal Nasional">Jurnal Nasional</option>
                                    <option value="Jurnal Nasional Terakreditasi">Jurnal Nasional Terakreditasi</option>
                                    <option value="Jurnal Nasional Terakreditasi Peringkat 1 dan 2">Jurnal Nasional Terakreditasi Kemenristekdikti Peringkat 1 dan 2</option>
                                    <option value="Jurnal Nasional Terakreditasi Peringkat 3 dan 4">Jurnal Nasional Terakreditasi Kemenristekdikti Peringkat 3 dan 4</option>
                                    <option value="Jurnal Nasional Bhs Indonesia DOAJ">Jurnal Nasional Berbahasa Indonesia Terindeks pada DOAJ</option>
                                    <option value="Jurnal Nasional Bhs Inggris/PBB DOAJ">Jurnal Nasional Berbahasa Inggris atau Bahasa Resmi PBB Terindeks pada DOAJ</option>
                                    <option value="Prosiding Internasional (Dipresentasikan)">Prosiding Internasional - Makalah Dipresentasikan</option>
                                    <option value="Prosiding Internasional (Tidak Dipresentasikan)">Prosiding Internasional - Makalah Tidak Dipresentasikan</option>
                                    <option value="Prosiding Internasional Terindeks WoS/Scopus">Prosiding Internasional Terindeks Web of Science/Scopus</option>
                                    <option value="Prosiding Nasional (Dipresentasikan)">Prosiding Nasional - Makalah Dipresentasikan</option>
                                    <option value="Prosiding Nasional (Tidak Dipresentasikan)">Prosiding Nasional - Makalah Tidak Dipresentasikan</option>
                                    <option value="Hasil Penelitian Disajikan (Non-Prosiding)">Hasil Penelitian/Pemikiran yang Disajikan dalam Forum Ilmiah Internasional</option>
                                    <option value="Poster Internasional (Non-Prosiding)">Poster Dipresentasikan dalam Forum Ilmiah Internasional</option>
                                    <option value="Poster Prosiding Nasional">Poster Dimuat dalam Prosiding Nasional yang Dipublikasikan</option>
                                    <option value="Hasil Penelitian Tidak Dipublikasikan">Hasil Penelitian/Pemikiran/Kerja Sama Industri yang Tidak Dipublikasikan</option>
                                    <option value="Koran/Majalah Populer">Koran/Majalah Populer/Majalah Umum</option>
                                    <option value="Karya Terdaftar HaKI">Rancangan/Karya Teknologi atau Seni Terdaftar di HaKI Tingkat Nasional</option>
                                    <option value="Paten Sederhana">Paten Sederhana</option>
                                    <option value="Karya Cipta/Desain Industri">Karya Cipta/Desain Industri/Indikasi Geografis</option>
                                    <option value="Rumusan Kebijakan Monumental">Rumusan Kebijakan Monumental</option>
                                </select>
                            </div>
                                <div class="input-group custom-input-group"><span class="input-group-text bg-light"><i class="fas fa-search search-icon"></i></span><input type="text" class="form-control search-input" placeholder="Cari Data..."></div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-sm">
                                    <thead><tr><th>No</th><th>Judul</th><th>Tanggal Terbit</th><th>Jenis Karya</th><th>Publik</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                    <tbody>
                                        <script>for(let i=1; i<=3; i++){ document.write(`<tr><td class="text-center">${i}</td><td>Pengaruh Air Terhadap Tumbuh Kembang Leles</td><td class="text-center">24 Desember 2021</td><td class="text-center">Karya</td><td class="text-center">Ya</td><td class="text-center"><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td class="text-center"><div class="d-flex gap-2 justify-content-center"><button type="button" 
                                            class="btn btn-sm text-white btn-aksi btn-lihat-detail" 
                                            title="Lihat Detail" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#detailModal">
                                        <i class="lni lni-eye"></i>
                                    </button>
                                    <button class="btn btn-sm text-white btn-aksi btn-hapus" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>`);}</script>
                                    </tbody>
                                </table>
                            </div>
                                                    <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <span class="text-muted small">Menampilkan 1 sampai 10 dari 13 data</span>
                            <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">Berikutnya</a></li>
                            </ul>
                            </nav>
                        </div>
                        </div>
                            
                        <!-- Pengabdian Content -->
                        <div class="main-tab-content" id="pengabdian-content">
                            <div class="tab-filters">
                            <div class="filter-dropdown-wrapper d-flex gap-2">
                            <select class="form-select">
                                    <option>Tahun</option>
                                    <option>2025</option>
                                    <option>2026</option>
                                    <option>2027</option>
                                </select>
                                <select class="form-select filter-select">
                                    <option>Jenis Pengabdian</option>
                                    <option value="Biomedik">Biomedik</option>
                                    <option value="Hibah HI-LINK">Hibah HI-LINK</option>
                                    <option value="Ipteks">Ipteks</option>
                                    <option value="Ipteks Bagi Inovasi Kreativitas Kampus">Ipteks Bagi Inovasi Kreativitas Kampus</option>
                                    <option value="Ipteks Bagi Kewirausahaan">Ipteks Bagi Kewirausahaan</option>
                                    <option value="Iptek Bagi Masyarakat">Iptek Bagi Masyarakat</option>
                                    <option value="Iptek Bagi Produk Ekspor">Iptek Bagi Produk Ekspor</option>
                                    <option value="Iptek Bagi Wilayah">Iptek Bagi Wilayah</option>
                                    <option value="Iptek Bagi Wilayah Antara PT-CSR/PT-PEMDA-CSR">Iptek Bagi Wilayah Antara PT-CSR/PT-PEMDA-CSR</option>
                                    <option value="Kerjasama Luar Negeri dan Publikasi Internasional">Kerjasama Luar Negeri dan Publikasi Internasional</option>
                                    <option value="KKN Pembelajaran Pemberdayaan Masyarakat">KKN Pembelajaran Pemberdayaan Masyarakat</option>
                                    <option value="Mobil Listrik Nasional">Mobil Listrik Nasional</option>
                                    <option value="MP3EI">MP3EI</option>
                                    <option value="Pendidikan Magister Doktor Sarjana Unggul">Pendidikan Magister Doktor Sarjana Unggul</option>
                                    <option value="Penelitian Disertasi Doktor">Penelitian Disertasi Doktor</option>
                                    <option value="Penelitian Dosen Pemula">Penelitian Dosen Pemula</option>
                                    <option value="Penelitian Fundamental">Penelitian Fundamental</option>
                                    <option value="Penelitian Hibah Bersaing">Penelitian Hibah Bersaing</option>
                                    <option value="Penelitian Kerjasama Antar Perguruan Tinggi">Penelitian Kerjasama Antar Perguruan Tinggi</option>
                                    <option value="Penelitian Kompetensi">Penelitian Kompetensi</option>
                                    <option value="Penelitian Srategis Nasional">Penelitian Srategis Nasional</option>
                                    <option value="Penelitian Tim Pascasarjana">Penelitian Tim Pascasarjana</option>
                                    <option value="Penelitian Unggulan Perguruan Tinggi">Penelitian Unggulan Perguruan Tinggi</option>
                                    <option value="Penelitian Unggulan Strategis Nasional">Penelitian Unggulan Strategis Nasional</option>
                                    <option value="Riset Andalan Perguruan Tinggi dan Industri">Riset Andalan Perguruan Tinggi dan Industri</option>
                                </select>
                            </div>
                                <div class="input-group custom-input-group"><span class="input-group-text bg-light"><i class="fas fa-search search-icon"></i></span><input type="text" class="form-control search-input" placeholder="Cari Data..."></div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-sm">
                                    <thead><tr><th>No</th><th>Kegiatan</th><th>Nama Kegiatan</th><th>Afiliasi</th><th>Lokasi</th><th>Nomor SK</th><th>Tahun</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                    <tbody>
                                        <tr>
                                        <td class="text-center">1</td>
                                        <td>Penyuluhan</td>
                                        <td>Pengelolaan Hutan Lestari</td>
                                        <td>Desa Cibodas, Bogor</td>
                                        <td>Kementerian Lingkungan Hidup</td>
                                        <td class="text-center">SK-123/2022</td>
                                        <td class="text-center">2022</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a id="btnLihatPengabdiangDetail" class="btn-aksi btn-lihat" title="Lihat Detail Pengabdian" data-bs-toggle="modal" data-bs-target="#pengabdianDetailModal">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            <button class="btn btn-sm text-white btn-aksi btn-hapus" title="Hapus">
                                                <i class="lni lni-trash-can"></i>
                                            </button>
                                            </div>
                                        </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                                                    <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <span class="text-muted small">Menampilkan 1 sampai 10 dari 13 data</span>
                            <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">Berikutnya</a></li>
                            </ul>
                            </nav>
                        </div>
                        </div>
                            
                       <!-- Penunjang Content -->
                        <div class="main-tab-content" id="penunjang-content">

                        <!-- Filter Section -->
                        <div class="tab-filters d-flex flex-wrap gap-2 mb-3 justify-content-between align-items-center">
                            <div class="filter-dropdown-wrapper d-flex gap-2">
                            <select class="form-select">
                                <option>Tahun</option>
                                <option>2025</option>
                                <option>2026</option>
                                <option>2027</option>
                            </select>
                            <select class="form-select filter-select">
                                <option>Lingkup</option>
                                <option>Lokal</option>
                                <option>Nasional</option>
                                <option>Internasional</option>
                            </select>
                            </div>

                            <div class="input-group custom-input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-search search-icon"></i></span>
                            <input type="text" class="form-control search-input" placeholder="Cari Data...">
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                            <thead>
                                <tr class="text-center">
                                <th>No</th>
                                <th>Kegiatan</th>
                                <th>Lingkup</th>
                                <th>Nama Kegiatan</th>
                                <th>Instansi</th>
                                <th>Nomor SK</th>
                                <th>TMT</th>
                                <th>TST</th>
                                <th>Dokumen</th>
                                <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td class="text-center">1</td>
                                <td class="text-start">Pengaruh Air Terhadap Tumbuh Kembang Lele</td>
                                <td class="text-center">Nasional</td>
                                <td class="text-center">Jurnal</td>
                                <td class="text-center">Ya</td>
                                <td class="text-center">SK-129013a7uw</td>
                                <td class="text-center">25 Jun 2024</td>
                                <td class="text-center">25 Jun 2024</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-lihat-detail text-white">Lihat</a>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                    <a href="javascript:void(0);" id="btnLihatPenunjangDetail" class="btn-aksi btn-lihat" title="Lihat Detail Penunjang" data-bs-toggle="modal" data-bs-target="#penunjangDetailModal">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                                </tr>
                                <!-- Tambahkan baris lain di sini -->
                            </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <span class="text-muted small">Menampilkan 1 sampai 10 dari 13 data</span>
                            <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">Berikutnya</a></li>
                            </ul>
                            </nav>
                        </div>
                        </div>
                            
                            <!-- Pelatihan Content -->
                            <div class="main-tab-content" id="pelatihan-content">
                                <div class="tab-filters">
                                   <div class="filter-dropdown-wrapper d-flex gap-2">
                                   <select class="form-select">
                                        <option>Tahun</option>
                                        <option>2025</option>
                                        <option>2026</option>
                                        <option>2027</option>
                                    </select>
                                    <select class="form-select filter-select">
                                        <option>Posisi</option>
                                        <option>Peserta</option>
                                        <option>Pembicara</option>
                                        <option>Panitia</option>
                                    </select>
                                </div>
                                    <div class="input-group custom-input-group"><span class="input-group-text bg-light"><i class="fas fa-search search-icon"></i></span><input type="text" class="form-control search-input" placeholder="Cari Data..."></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-sm">
                                        <thead><tr><th>No</th><th>Nama Kegiatan</th><th>Penyelenggara</th><th>Posisi</th><th>Tanggal Mulai</th><th>Tanggal Selesai</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                        <tbody>
                                            <tr><td class="text-center">1</td><td>Pelatihan Manajemen Hutan Berkelanjutan</td><td>Kementerian Lingkungan Hidup</td><td class="text-center">Peserta</td><td class="text-center">12 Januari 2023</td><td class="text-center">19 Januari 2023</td><td class="text-center"><button class="btn btn-sm btn-lihat text-white">Lihat</button></td>
                                            <td>
                                            <div class="d-flex gap-2 justify-content-center">
                                            <a href="#" class="btn-aksi btn-lihat-detail  btn-lihat-detail-pelatihan" title="Lihat Detail"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDetailPelatihan"
                                            data-nama_pelatihan="Senam Lele Merdeka"
                                            data-posisi="Peserta"
                                            data-kota="Bogor"
                                            data-lokasi="Dramaga"
                                            data-penyelenggara="Fakultas Perikanan"
                                            data-jenis_diklat="Teknis"
                                            data-tgl_mulai="2025-08-10"
                                            data-tgl_selesai="2025-08-15"
                                            data-lingkup="Internal"
                                            data-jam="40"
                                            data-hari="5"
                                            data-struktural="Tidak"
                                            data-sertifikasi="Ya"
                                            data-dokumen_path="assets/pdf/example.pdf">
                                                <i class="fa fa-eye"></i>
                                            </a><button class="btn btn-sm text-white btn-aksi btn-hapus" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                  <div class="d-flex justify-content-between align-items-center mt-4">
                                    <span class="text-muted small" id="dataInfo">Menampilkan 1 sampai 10 dari 13 data</span>
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination pagination-sm mb-0">
                                            <li class="page-item disabled" id="prevPage">
                                                <a class="page-link" href="#" tabindex="-1">Sebelumnya</a>
                                            </li>
                                            <li class="page-item active" id="page1"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item" id="page2"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item" id="nextPage">
                                                <a class="page-link" href="#">Berikutnya</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            
                            <!-- Penghargaan Content -->
                            <div class="main-tab-content" id="penghargaan-content">
                                <div class="tab-filters">
                                   <div class="filter-dropdown-wrapper d-flex gap-2">
                                   <select class="form-select">
                                        <option>Tahun</option>
                                        <option>2025</option>
                                        <option>2026</option>
                                        <option>2027</option>
                                    </select>
                                    <select class="form-select filter-select">
                                        <option>Lingkup</option>
                                        <option>Lokal</option>
                                        <option>Nasional</option>
                                        <option>Internasional</option>
                                    </select>
                                </div>
                                    <div class="input-group custom-input-group"><span class="input-group-text bg-light"><i class="fas fa-search search-icon"></i></span><input type="text" class="form-control search-input" placeholder="Cari Data..."></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Nama Kegiatan</th>
                                                <th>Unit</th>
                                                <th>Nomor</th>
                                                <th>Penghargaan</th>
                                                <th>Lingkup</th>
                                                <th>Tahun</th>
                                                <th>Dokumen</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="penghargaan-table-body"> {{-- Tambahkan ID untuk target JavaScript --}}
                                            @php
                                                // Contoh data dinamis. Idealnya, variabel ini dikirim dari Controller.
                                                $dataPenghargaan = collect(json_decode('[
                                                    {"id": 1, "nama_kegiatan": "Inovasi Pembibitan Lele", "unit": "Fakultas Perikanan", "nomor": "SK-123/FP/2023", "penghargaan": "Dosen Inovatif", "lingkup": "Nasional", "tahun": "2023", "pegawai": "Dr. Stone Pamungkas", "tanggal_perolehan": "2023-11-20", "negara": "Indonesia", "instansi": "Kementerian Kelautan", "jenis_dokumen": "Sertifikat", "nama_dokumen": "Sertifikat Dosen Inovatif 2023", "nomor_dokumen": "SERT-001", "tautan": "https://sertifikat.id/001", "dokumen_path": "assets/pdf/example.pdf"},
                                                    {"id": 2, "nama_kegiatan": "Pengabdian Masyarakat Desa Ciaruteun", "unit": "LPPM", "nomor": "LPPM-456/PM/2024", "penghargaan": "Pengabdi Terbaik", "lingkup": "Kabupaten", "tahun": "2024", "pegawai": "Senam Lele Merdeka", "tanggal_perolehan": "2024-05-10", "negara": "Indonesia", "instansi": "Pemkab Bogor", "jenis_dokumen": "Piagam", "nama_dokumen": "Piagam Pengabdi Terbaik", "nomor_dokumen": "PGM-002", "tautan": "https://sertifikat.id/002", "dokumen_path": "assets/pdf/example.pdf"}
                                                ]'));
                                            @endphp

                                            @foreach ($dataPenghargaan as $index => $item)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td class="text-start">{{ $item->nama_kegiatan }}</td>
                                                <td class="text-center">{{ $item->unit }}</td>
                                                <td class="text-center">{{ $item->nomor }}</td>
                                                <td class="text-center">{{ $item->penghargaan }}</td>
                                                <td class="text-center">{{ $item->lingkup }}</td>
                                                <td class="text-center">{{ $item->tahun }}</td>
                                                <td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td>
                                                <td class="text-center">
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        {{-- Tombol Lihat Detail yang sudah fungsional --}}
                                                        <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-detail-penghargaan" title="Lihat Detail"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalDetailPenghargaan"
                                                        data-pegawai="{{ $item->pegawai }}"
                                                        data-kegiatan="{{ $item->nama_kegiatan }}"
                                                        data-nama_penghargaan="{{ $item->penghargaan }}"
                                                        data-nomor="{{ $item->nomor }}"
                                                        data-tanggal_perolehan="{{ $item->tanggal_perolehan }}"
                                                        data-lingkup="{{ $item->lingkup }}"
                                                        data-negara="{{ $item->negara }}"
                                                        data-instansi="{{ $item->instansi }}"
                                                        data-jenis_dokumen="{{ $item->jenis_dokumen }}"
                                                        data-nama_dokumen="{{ $item->nama_dokumen }}"
                                                        data-nomor_dokumen="{{ $item->nomor_dokumen }}"
                                                        data-tautan="{{ $item->tautan }}"
                                                        data-dokumen_path="{{ $item->dokumen_path }}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>

                                                        <a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <span class="text-muted small" id="dataInfo">Menampilkan 1 sampai 10 dari 13 data</span>
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination pagination-sm mb-0">
                                            <li class="page-item disabled" id="prevPage">
                                                <a class="page-link" href="#" tabindex="-1">Sebelumnya</a>
                                            </li>
                                            <li class="page-item active" id="page1"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item" id="page2"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item" id="nextPage">
                                                <a class="page-link" href="#">Berikutnya</a>
                                            </li>
                                        </ul>
                                    </nav>
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

    {{-- Modal General --}}
    @include('components.tambah-efile')
    @include('components.konfirmasi-hapus')
    @include('components.konfirmasi-berhasil')

    {{-- Modal Detail Pendidikan --}}
    @include('components.pendidikan.detail-pengajaran-lama')
    @include('components.pendidikan.detail-pengajaran-luar')
    @include('components.pendidikan.detail-pengujian-lama')
    @include('components.pendidikan.detail-pembimbing-lama')
    @include('components.pendidikan.detail-penguji-luar')
    @include('components.pendidikan.detail-pembimbing-luar')

    {{-- Modal Detail Penelitian --}}
    @include('components.penelitian.detail-penelitian')

    {{-- Modal Detail Pengabdian --}}
    @include('components.pengabdian.detail-pengabdian')

    {{-- Modal Detail Penunjang --}}
    @include('components.penunjang.detail-penunjang')

    {{-- Modal Detail Pelatihan --}}
    @include('components.pelatihan.detail-pelatihan')

    {{-- Modal Detail Penghargaan --}}
    @include('components.penghargaan.detail-penghargaan')

        
<script src="{{ asset('assets/js/layout.js') }}"></script>
<script src="{{ asset('assets/js/detail-pegawai.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>