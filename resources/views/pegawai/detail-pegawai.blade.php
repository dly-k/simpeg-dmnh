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
                        <li><a class="dropdown-item d-flex align-items-center" href="/ubah-password"><i class="lni lni-key me-2"></i> Ubah Password</a></li>
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
            <a href="/daftar-pegawai" class="btn-kembali d-flex align-items-center gap-2"  style="text-decoration: none;">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
   
        <div class="main-content">
            <div class="search-filter-container">
                <div class="search-filter-row">
                    <div class="search-box">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-search" style="color: green;"></i></span>
                            <input type="text" class="form-control border-start-0" placeholder="Cari Data Pegawai...">
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
                    <div class="d-flex flex-column flex-md-row gap-4 mb-5" style=" margin-bottom: 30px !important">
                        <div class="text-center flex-shrink-0">
                            <!-- Foto -->
                            <div style="width: 220px; height: 250px; background-color: #e9ecef; position: relative; overflow: hidden; border-radius: 3px;" 
                                class="mb-2 mx-auto d-flex align-items-center justify-content-center">
                                <i class="lni lni-user" style="font-size: 5rem; color: #bfbfbf;"></i>
                            </div>
                            <!-- Tombol Edit -->
                            <button class="btn btn-editfoto btn-sm w-100" style="max-width: 220px" onclick="editPhoto()">
                                Edit Foto
                            </button>
                        </div>
                        <div class="flex-grow-1">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="small text-secondary">NIP</label>
                                    <div class="detail-box">3212302291827320009</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="small text-secondary">Agama</label>
                                    <div class="detail-box">Islam</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="small text-secondary">Nama Lengkap</label>
                                    <div class="detail-box">Joko Anwar S.Hut</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="small text-secondary">Status Pernikahan</label>
                                    <div class="detail-box">Belum Menikah</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="small text-secondary">Jenis Kelamin</label>
                                    <div class="detail-box">Laki-laki</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="small text-secondary">Pendidikan Terakhir</label>
                                    <div class="detail-box">S3</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="small text-secondary">Tempat Lahir</label>
                                    <div class="detail-box">Jakarta</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="small text-secondary">Bidang Ilmu</label>
                                    <div class="detail-box">Ilmu Pengelolaan Hutan</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="small text-secondary">Tanggal Lahir</label>
                                    <div class="detail-box">13 Agustus 1961</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-4" style="color: #939393">
                     
                  <!-- Kolom Main-Tab (Biodata)-->
                  <div class="d-flex flex-column flex-lg-row gap-4">
                    <div class="nav flex-column nav-pills main-tab-nav" id="main-tab-nav" style="min-width: 20px; flex-shrink:0;">
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

                            <!-- Kepegawaian Content -->
                            <div class="sub-tab-content" id="kepegawaian" style="display: block;">
                                <div class="row g-3">

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Status Kepegawaian</label>
                                        <div class="detail-box">Dosen PNS</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Status Pegawai</label>
                                        <div class="detail-box">Aktif</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Unit Kerja</label>
                                        <div class="detail-box">Fakultas Kehutanan dan Lingkungan</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Divisi</label>
                                        <div class="detail-box">Departemen Manajemen Hutan</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Nomor Arsip Berkas Kepegawaian</label>
                                        <div class="detail-box">046</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Jabatan Fungsional</label>
                                        <div class="detail-box">Tidak ada</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Pangkat/Golongan</label>
                                        <div class="detail-box">Juru Muda / I-a</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">TMT Pangkat Terakhir</label>
                                        <div class="detail-box">01 Maret 2021</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Jabatan Struktural (jika ada)</label>
                                        <div class="detail-box">Tidak ada</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Periode Jabatan Struktural (TMT s/d TST)</label>
                                        <div class="detail-box">14 Juli 2023 s/d 01 Maret 2028</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Finger Print ID</label>
                                        <div class="detail-box">15213</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">NPWP</label>
                                        <div class="detail-box">764906129203000</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Nama Bank</label>
                                        <div class="detail-box">Bank BRI</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">No Rekening</label>
                                        <div class="detail-box">012819102912191</div>
                                    </div>

                                </div>
                            </div>
                            
                            <!-- Dosen Content -->
                            <div class="sub-tab-content" id="dosen" style="display: none;">
                                <div class="row g-3">
                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">NUPTK</label>
                                        <div class="detail-box">1234567890123456</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">SINTA ID</label>
                                        <div class="detail-box">1234-5678</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">NIDN</label>
                                        <div class="detail-box">123456781273811</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Scopus ID</label>
                                        <div class="detail-box">56766236300</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">No. Sertifikasi Dosen</label>
                                        <div class="detail-box">24-001013-0100</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Orchid ID</label>
                                        <div class="detail-box">0000-0002-1825-0097</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Tgl. Sertifikasi Dosen</label>
                                        <div class="detail-box">17 Agustus 1880</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Google Scholar ID</label>
                                        <div class="detail-box">abcdefg12345678</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Domisili Content -->
                            <div class="sub-tab-content" id="domisili" style="display: none;">
                                <div class="row g-3">
                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Provinsi</label>
                                        <div class="detail-box">Jawa Barat</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Alamat</label>
                                        <div class="detail-box">JL. Lodaya</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Kota</label>
                                        <div class="detail-box">Bandung</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Kode Pos</label>
                                        <div class="detail-box">10021</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Kecamatan</label>
                                        <div class="detail-box">Bandung Tengah</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">No. Telepon/HP</label>
                                        <div class="detail-box">081239128991</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Kelurahan</label>
                                        <div class="detail-box">Ciawi</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Email Pribadi / Institusi</label>
                                        <div class="detail-box">aexyifshsi@gmail.com</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kependudukan Content -->
                            <div class="sub-tab-content" id="kependudukan" style="display: none;">
                                <div class="row g-3">

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Nomor KTP</label>
                                        <div class="detail-box">31862908812645811</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Kecamatan</label>
                                        <div class="detail-box">Talang Ubi</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Nomor KK</label>
                                        <div class="detail-box">8011447152211029</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Kelurahan</label>
                                        <div class="detail-box">Pisangan Timur</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Warga Negara</label>
                                        <div class="detail-box">Indonesia</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Kode Pos</label>
                                        <div class="detail-box">01984</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Provinsi</label>
                                        <div class="detail-box">Sumatera Barat</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-secondary">Kabupaten/Kota</label>
                                        <div class="detail-box">Cimahi</div>
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label class="small text-secondary">Alamat</label>
                                        <div class="detail-box">Jalan Cendrawasih No. 25, RT 03/RW 05</div>
                                    </div>
                                </div>
                            </div>

                            <!-- efile Content -->
                            <div class="sub-tab-content" id="efile" style="display: none;">
                                <div class="efile-header">
                                    <h4>Dokumen</h4>
                                    <button class="btn btn-tambah"><i class="lni lni-plus me-1"></i> Tambah</button>
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
                        <div class="main-tab-content" id="pendidikan-content" style="display: none;">
                            <div id="pendidikan-sub-tabs" class="btn-group flex-wrap gap-2 mb-3">
                                <button type="button" class="btn active" data-tab="pengajaran-lama">Pengajaran Lama</button>
                                <button type="button" class="btn" data-tab="pengajaran-luar">Pengajaran Luar</button>
                                <button type="button" class="btn" data-tab="pengujian-lama">Pengujian Lama</button>
                                <button type="button" class="btn" data-tab="pembimbing-lama">Pembimbing Lama</button>
                                <button type="button" class="btn" data-tab="penguji-luar">Penguji Luar</button>
                                <button type="button" class="btn" data-tab="pembimbing-luar">Pembimbing Luar</button>
                            </div>
                            
                            <!-- Pengajaran Lama Content -->
                            <div class="sub-tab-content" id="pengajaran-lama" style="display: block">
                            <div class="tab-filters">
                                <div class="filter-dropdown-wrapper"><select class="form-select filter-select"><option selected>Semester</option><option>Genap 2024/2025</option></select></div>
                                <div class="input-group" style="width: auto; max-width: 300px;"><span class="input-group-text bg-light"><i class="fas fa-search" style="color: green;"></i></span><input type="text" class="form-control search-input border-start-0" placeholder="Cari Data ...."></div>
                            </div>
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
                                                        <button class="btn btn-sm text-white btn-aksi btn-hapus" title="Hapus">
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
                                                        <button class="btn btn-sm text-white btn-aksi btn-hapus" title="Hapus">
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
                                                        <button class="btn btn-sm text-white btn-aksi btn-hapus" title="Hapus">
                                                            <i class="lni lni-trash-can"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                                
                            <!-- Pengajaran Luar Content -->
                            <div class="sub-tab-content" id="pengajaran-luar" style="display: none;">
                            <div class="tab-filters">
                                <div class="filter-dropdown-wrapper"><select class="form-select filter-select"><option selected>Semester</option><option>Genap 2024/2025</option></select></div>
                                <div class="input-group" style="width: auto; max-width: 300px;"><span class="input-group-text bg-light"><i class="fas fa-search" style="color: green;"></i></span><input type="text" class="form-control search-input border-start-0" placeholder="Cari Data ...."></div>
                            </div>
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
                                                        <button class="btn btn-sm text-white btn-aksi btn-hapus" title="Hapus">
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
                                                        <button class="btn btn-sm text-white btn-aksi btn-hapus" title="Hapus">
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
                                                        <button class="btn btn-sm text-white btn-aksi btn-hapus" title="Hapus">
                                                            <i class="lni lni-trash-can"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                                
                            <!-- Pengujian Lama Content -->
                            <div class="sub-tab-content" id="pengujian-lama" style="display: none;">
                            <div class="tab-filters">
                                <div class="filter-dropdown-wrapper"><select class="form-select filter-select"><option selected>Semester</option><option>Genap 2024/2025</option></select></div>
                                <div class="input-group" style="width: auto; max-width: 300px;"><span class="input-group-text bg-light"><i class="fas fa-search" style="color: green;"></i></span><input type="text" class="form-control search-input border-start-0" placeholder="Cari Data ...."></div>
                            </div>
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
                                                        <button class="btn btn-sm text-white btn-aksi btn-hapus" title="Hapus">
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
                                                        <button class="btn btn-sm text-white btn-aksi btn-hapus" title="Hapus">
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
                                                        <button class="btn btn-sm text-white btn-aksi btn-hapus" title="Hapus">
                                                            <i class="lni lni-trash-can"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Pembimbing Lama Content -->
                            <div class="sub-tab-content" id="pembimbing-lama" style="display: none;">
                            <div class="tab-filters">
                                <div class="filter-dropdown-wrapper"><select class="form-select filter-select"><option selected>Semester</option><option>Genap 2024/2025</option></select></div>
                                <div class="input-group" style="width: auto; max-width: 300px;"><span class="input-group-text bg-light"><i class="fas fa-search" style="color: green;"></i></span><input type="text" class="form-control search-input border-start-0" placeholder="Cari Data ...."></div>
                            </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-sm">
                                        <thead><tr><th>No</th><th>Tahun Semester</th><th>Kegiatan</th><th>Nim</th><th>Nama Mahasiswa</th><th>Strata</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                        <tbody>
                                            <tr><td>1</td><td>2020/2021 Genap</td><td>Membimbing dan ikut membimbing.. </td><td>E2039383</td><td>Alex Feruso</td><td>S1</td><td>Pembimbing Pendamping</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-hapus" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>
                                            <tr><td>2</td><td>2020/2021 Genap</td><td>Membimbing dan ikut membimbing.. </td><td>E2039383</td><td>Alex Feruso</td><td>S1</td><td>Pembimbing Pendamping</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-hapus" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>
                                            <tr><td>3</td><td>2020/2021 Genap</td><td>Membimbing dan ikut membimbing.. </td><td>E2039383</td><td>Alex Feruso</td><td>S1</td><td>Pembimbing Pendamping</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-hapus" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Penguji Luar Content -->
                            <div class="sub-tab-content" id="penguji-luar" style="display: none;">
                            <div class="tab-filters">
                                <div class="filter-dropdown-wrapper"><select class="form-select filter-select"><option selected>Semester</option><option>Genap 2024/2025</option></select></div>
                                <div class="input-group" style="width: auto; max-width: 300px;"><span class="input-group-text bg-light"><i class="fas fa-search" style="color: green;"></i></span><input type="text" class="form-control search-input border-start-0" placeholder="Cari Data ...."></div>
                            </div>  
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
                                                for(let i=1; i<=3; i++){ 
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
                                                                <button class="btn btn-sm text-white btn-aksi btn-hapus" title="Hapus"><i class="lni lni-trash-can"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>`);
                                                }
                                            </script>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- Pembimbing Luar Content -->
                            <div class="sub-tab-content" id="pembimbing-luar" style="display: none;">
                            <div class="tab-filters">
                                <div class="filter-dropdown-wrapper"><select class="form-select filter-select"><option selected>Semester</option><option>Genap 2024/2025</option></select></div>
                                <div class="input-group" style="width: auto; max-width: 300px;"><span class="input-group-text bg-light"><i class="fas fa-search" style="color: green;"></i></span><input type="text" class="form-control search-input border-start-0" placeholder="Cari Data ...."></div>
                            </div>
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
                                                for(let i=1; i<=3; i++){ 
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
                                                                <button class="btn btn-sm text-white btn-aksi btn-hapus" title="Hapus"><i class="lni lni-trash-can"></i></button>
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

                        <!-- Penelitian Content -->
                        <div class="main-tab-content" id="penelitian-content" style="display: none;">
                        <div class="tab-filters">
                                <div class="filter-dropdown-wrapper d-flex gap-2">
                                <select class="form-select filter-select">
                                    <option>Tahun</option>
                                    <option>2025</option>
                                    <option>2026</option>
                                    <option>2027</option>
                                </select>
                                <select class="form-select filter-select" style="width: 175px;">
                                    <option>Jenis SKIM</option>
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
                                <div class="input-group" style="width: 300px;"><span class="input-group-text bg-light"><i class="fas fa-search" style="color: green;"></i></span><input type="text" class="form-control search-input" placeholder="Cari Data..."></div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-sm">
                                    <thead><tr><th>No</th><th>Judul</th><th>Tgl. Terbit</th><th>Jenis</th><th>Publik</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                    <tbody>
                                        <script>for(let i=1; i<=3; i++){ document.write(`<tr><td>${i}</td><td>Pengaruh Air Terhadap Tumbuh Kembang Leles</td><td>24 Desember 2021</td><td>Karya</td><td>Ya</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-hapus" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>`);}</script>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                            
                        <!-- Pengabdian Content -->
                        <div class="main-tab-content" id="pengabdian-content" style="display: none;">
                            <div class="tab-filters">
                            <div class="filter-dropdown-wrapper d-flex gap-2">
                            <select class="form-select filter-select">
                                    <option>Tahun</option>
                                    <option>2025</option>
                                    <option>2026</option>
                                    <option>2027</option>
                                </select>
                                <select class="form-select filter-select" style="width: 175px;">
                                    <option>Jenis SKIM</option>
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
                                <div class="input-group" style="width: 300px;"><span class="input-group-text bg-light"><i class="fas fa-search" style="color: green;"></i></span><input type="text" class="form-control search-input" placeholder="Cari Data..."></div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-sm">
                                    <thead><tr><th>No</th><th>Kegiatan</th><th>Nama Kegiatan</th><th>Afiliasi</th><th>Lokasi</th><th>Nomor SK</th><th>Tahun</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                    <tbody>
                                        <tr>
                                        <td>1</td>
                                        <td>Penyuluhan</td>
                                        <td>Pengelolaan Hutan Lestari</td>
                                        <td>Desa Cibodas, Bogor</td>
                                        <td>Kementerian Lingkungan Hidup</td>
                                        <td>SK-123/2022</td>
                                        <td>2022</td>
                                        <td>
                                            <button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-center">
                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                <i class="lni lni-eye"></i>
                                            </button>
                                            <button class="btn btn-sm text-white btn-aksi btn-hapus" title="Hapus">
                                                <i class="lni lni-trash-can"></i>
                                            </button>
                                            </div>
                                        </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                            
                        <!-- Penunjang Content -->
                        <div class="main-tab-content" id="penunjang-content" style="display: none;">
                            <div class="tab-filters">
                                <div class="filter-dropdown-wrapper d-flex gap-2">
                                <select class="form-select filter-select">
                                    <option>Tahun</option>
                                    <option>2025</option>
                                    <option>2026</option>
                                    <option>2027</option>
                                </select>
                                <select class="form-select filter-select" style="width: 175px;">
                                    <option>Lingkup</option>
                                    <option>Lokal</option>
                                    <option>Nasional</option>
                                    <option>Internasional</option>
                                </select>
                            </div>
                                <div class="input-group" style="width: 300px;"><span class="input-group-text bg-light"><i class="fas fa-search" style="color: green;"></i></span><input type="text" class="form-control search-input" placeholder="Cari Data..."></div>
                            </div>
                            
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-sm">
                                        <thead><tr><th>No</th><th>Kegiatan</th><th>Lingkup</th><th>Nama Kegiatan</th><th>Instansi</th><th>Nomor SK</th><th>TMT</th><th>TST</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                        <tbody>
                                        <tr>
                                        <td>1</td>
                                        <td>Penyuluhan</td>
                                        <td>Pengelolaan Hutan</td>
                                        <td>Desa Cibodas, Bogor</td>
                                        <td>Kementerian Lingkungan Hidup</td>
                                        <td>SK-123/2022</td>
                                        <td>15-08-2022</td>
                                        <td>17-08-2022</td>
                                        <td>
                                            <button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-center">
                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                <i class="lni lni-eye"></i>
                                            </button>
                                            <button class="btn btn-sm text-white btn-aksi btn-hapus" title="Hapus">
                                                <i class="lni lni-trash-can"></i>
                                            </button>
                                            </div>
                                        </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- Pelatihan Content -->
                            <div class="main-tab-content" id="pelatihan-content" style="display: none;">
                                <div class="tab-filters">
                                   <div class="filter-dropdown-wrapper d-flex gap-2">
                                   <select class="form-select filter-select">
                                        <option>Tahun</option>
                                        <option>2025</option>
                                        <option>2026</option>
                                        <option>2027</option>
                                    </select>
                                    <select class="form-select filter-select" style="width: 175px;">
                                        <option>Posisi</option>
                                        <option>Peserta</option>
                                        <option>Pembicara</option>
                                        <option>Panitia</option>
                                    </select>
                                </div>
                                    <div class="input-group" style="width: 300px;"><span class="input-group-text bg-light"><i class="fas fa-search" style="color: green;"></i></span><input type="text" class="form-control search-input" placeholder="Cari Data..."></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-sm">
                                        <thead><tr><th>No</th><th>Nama Kegiatan</th><th>Penyelenggara</th><th>Tgl. Pelaksanaan</th><th>Posisi</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                        <tbody>
                                            <tr><td>1</td><td>Pelatihan Manajemen Hutan Berkelanjutan</td><td>Kementerian Lingkungan Hidup</td><td>10-12 Januari 2023</td><td>Bogor</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-hapus" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- Penghargaan Content -->
                            <div class="main-tab-content" id="penghargaan-content" style="display: none;">
                                <div class="tab-filters">
                                   <div class="filter-dropdown-wrapper d-flex gap-2">
                                   <select class="form-select filter-select">
                                        <option>Tahun</option>
                                        <option>2025</option>
                                        <option>2026</option>
                                        <option>2027</option>
                                    </select>
                                    <select class="form-select filter-select" style="width: 175px;">
                                        <option>Lingkup</option>
                                        <option>Lokal</option>
                                        <option>Nasional</option>
                                        <option>Internasional</option>
                                    </select>
                                </div>
                                    <div class="input-group" style="width: 300px;"><span class="input-group-text bg-light"><i class="fas fa-search" style="color: green;"></i></span><input type="text" class="form-control search-input" placeholder="Cari Data..."></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-sm">
                                        <thead><tr><th>No</th><th>Nama Kegiatan</th><th>Nomor</th><th>Tahun</th><th>Lokasi</th><th>Lingkup</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                        <tbody>
                                            <tr><td>1</td><td>Dosen Berprestasi</td><td>SK-123/FP/2023</td><td>2021</td><td>Jakarta</td><td>Internasional</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-hapus" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>
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

<script src="{{ asset('assets/js/detail-pegawai.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>