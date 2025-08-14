<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tambah Data Pegawai - SIKEMAH</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/tambah-pegawai.css') }}" />
</head>

<body>
<div class="layout">
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="brand">SI<span>KEMAH</span></div>
        <div class="menu-wrapper">
            <div class="menu">
                <a href="/dashboard"><i class="lni lni-grid-alt"></i> Dashboard</a>
                <p>Menu Utama</p>
                <a href="/daftar-pegawai" class="active"><i class="lni lni-users"></i> Daftar Pegawai</a>
                <a href="/surat-tugas"><i class="lni lni-folder"></i> Manajemen Surat Tugas</a>
                <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#editorKegiatan" aria-expanded="true">
                    <i class="lni lni-pencil-alt"></i> Editor Kegiatan 
                    <i class="lni lni-chevron-down toggle-icon"></i>
                </button>
                <div class="collapse show submenu" id="editorKegiatan">
                    <a href="/pendidikan">Pendidikan</a>
                    <a href="/penelitian">Penelitian</a>
                    <a href="/pengabdian">Pengabdian</a>
                    <a href="/penunjang">Penunjang</a>
                    <a href="/pelatihan">Pelatihan</a>
                    <a href="/penghargaan">Penghargaan</a>
                    <a href="/sk-non-pns">SK Non PNS</a>
                </div>
                <a href="/kerjasama"><i class="lni lni-handshake"></i> Kerjasama</a>
                <a href="/master-data"><i class="lni lni-database"></i> Master Data</a>
            </div>
        </div>
    </aside>

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
                    <a href="#" class="account text-decoration-none text-dark" data-bs-toggle="dropdown">
                        <span class="icon-circle"><i class="lni lni-user"></i></span>
                        <span class="d-none d-sm-inline">Halo, Ketua TU</span>
                        <i class="lni lni-chevron-down ms-1"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="/ubah-password">
                                <i class="lni lni-key me-2"></i> Ubah Password
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center dropdown-item-danger" href="/logout">
                                <i class="lni lni-exit me-2"></i> Keluar
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Title Bar -->
        <div class="title-bar d-flex align-items-center justify-content-between">
            <h1 class="m-0">
                <i class="fa fa-user-plus"></i> Tambah Data Pegawai
            </h1>
            <a href="/daftar-pegawai" class="btn-kembali d-flex align-items-center gap-2"  style="text-decoration: none;">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- Main Content -->
        <main class="main-content">
            <div class="card">
                <div class="card-body p-4">
                    <!-- Profile Section -->
                    <div class="d-flex flex-column flex-md-row gap-4 mb-4">
                        <div class="text-center flex-shrink-0">
                            <!-- Foto -->
                            <div class="mb-2 mx-auto d-flex align-items-center justify-content-center bg-light rounded" 
                                 style="width: 220px; height: 250px; overflow: hidden;">
                                <i class="lni lni-user" style="font-size: 5rem; color: #bfbfbf;"></i>
                            </div>
                            <!-- Tombol Edit -->
                            <button class="btn btn-editfoto btn-sm w-100" style="max-width: 220px" onclick="editPhoto()">
                                Edit Foto
                            </button>
                        </div>

                        <!-- Form Data Dasar -->
                        <div class="flex-grow-1">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="small text-secondary">NIP<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm search-input" placeholder="Contoh: 198709152023021001" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-secondary">Agama<span class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm" required>
                                        <option selected>Islam</option>
                                        <option>Kristen</option>
                                        <option>Katolik</option>
                                        <option>Hindu</option>
                                        <option>Budha</option>
                                        <option>Khonghucu</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-secondary">Nama Lengkap<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm search-input" placeholder="Termasuk gelar jika ada" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-secondary">Status Pernikahan<span class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm" required>
                                        <option selected>Belum Menikah</option>
                                        <option>Menikah</option>
                                        <option>Janda</option>
                                        <option>Duda</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-secondary">Jenis Kelamin<span class="text-danger">*</span></label>
                                    <div>
                                        <div class="form-check form-check-inline pt-1">
                                            <input class="form-check-input" type="radio" name="jk" id="lk" checked>
                                            <label class="form-check-label" for="lk">Laki-laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jk" id="pr">
                                            <label class="form-check-label" for="pr">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-secondary">Pendidikan Terakhir<span class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm">
                                        <option class="search-input" selected>--Pilih Salah Satu--</option>
                                        <option>SD</option>
                                        <option>SMP</option>
                                        <option>SMA</option>
                                        <option>S1</option>
                                        <option>S2</option>
                                        <option>S3</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-secondary">Tempat Lahir<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" value="Jakarta">
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-secondary">Bidang Ilmu<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm search-input" placeholder="Contoh: Ilmu Pengelolaan Hutan">
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-secondary">Tanggal Lahir<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="mb-4" style="color: #939393">
                    <div class="main-tab-content" id="biodata-content" style="display: block;">
                    <div id="biodata-sub-tabs" class="btn-group flex-wrap gap-2 mb-4">
                        <button type="button" class="btn active" data-tab="kepegawaian">Kepegawaian</button>
                        <button type="button" class="btn" data-tab="dosen">Dosen</button>
                        <button type="button" class="btn" data-tab="domisili">Alamat Domisili & Kontak</button>
                        <button type="button" class="btn" data-tab="kependudukan">Kependudukan</button>
                        <button type="button" class="btn" data-tab="efile">E-File</button>
                    </div>
                    <!-- TAB: Kepegawaian -->
                    <div class="sub-tab-content" id="kepegawaian" style="display: block;">
                        <div class="row g-3">

                        <!-- Status Kepegawaian -->
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Status Kepegawaian<span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm" required>
                            <option selected>Dosen PNS</option>
                            <option>Tendik PNS</option>
                            <option>Dosen Tetap</option>
                            <option>Tendik Tetap</option>
                            <option>Tendik Kontrak</option>
                            <option>Dosen Tamu</option>
                            <option>Tenaga Harian Lepas (THL)</option>
                            </select>
                        </div>

                        <!-- Status Pegawai -->
                        <div class="col-md-6 form-group" required>
                            <label class="small text-secondary">Status Pegawai<span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm">
                            <option selected>Aktif</option>
                            <option>Pensiun</option>
                            <option>Diberhentikan</option>
                            <option>Meninggal Dunia</option>
                            <option>Kontrak Selesai</option>
                            <option>Mengundurkan diri</option>
                            <option>Mutasi</option>
                            </select>
                        </div>

                        <!-- Unit Kerja -->
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Unit Kerja</label>
                            <input type="text" class="form-control form-control-sm" value="Fakultas Kehutanan dan Lingkungan"
                                style="background-color: #e9ecef; color: #495057" readonly>
                        </div>

                        <!-- Divisi -->
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Divisi</label>
                            <input type="text" class="form-control form-control-sm" value="Departemen Manajemen Hutan"
                                style="background-color: #e9ecef; color: #495057" readonly>
                        </div>

                        <!-- Nomor Arsip -->
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Nomor Arsip Berkas Kepegawaian<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" required>
                        </div>

                        <!-- Jabatan Fungsional -->
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Jabatan Fungsional<span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm" required>
                            <option>Tidak ada</option>
                            <option>Dosen</option>
                            <option>Asisten Ahli</option>
                            <option>Lektor</option>
                            <option>Lektor Kepala</option>
                            <option>Guru Besar</option>
                            <option>Pranata Laboratorium Pendidikan Pelaksana Lanjutan</option>
                            <option>Pranata Laboratorium Pendidikan Muda</option>
                            <option>Pranata Laboratorium Pendidikan Pertama</option>
                            <option>Teknisi Hardware dan Software</option>
                            <option>Pengadministrasi Akademik & Kemahasiswaan PS IPH</option>
                            <option>Pengadministrasi Akademik & Kemahasiswaan MNH</option>
                            <option>Pengadministrasi Umum, Sarana & Prasarana</option>
                            <option>Pengadministrasi Persuratan & Arsip</option>
                            <option>Pengadministrasi Jurnal Ilmiah</option>
                            <option>Adm. Bagian/Divisi</option>
                            <option>Staf Kepegawaian</option>
                            <option>Laboran Penafsiran Potret Udara</option>
                            <option>Pramu Kantor</option>
                            <option>Pramu Gedung dan Halaman</option>
                            <option>Media Branding & Staf Jurnal Departemen</option>
                            </select>
                        </div>

                        <!-- Pangkat Golongan -->
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Pangkat/Golongan<span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm" required>
                            <option selected>Juru Muda / I-a</option>
                            <option>Juru Muda Tingkat I / I-b</option>
                            <option>Juru / I-c</option>
                            <option>Juru Tingkat I / I-d</option>
                            <option>Pengatur Muda / II-a</option>
                            <option>Pengatur Muda Tingkat I / II-b</option>
                            <option>Pengatur / II-c</option>
                            <option>Pengatur Tingkat I / II-d</option>
                            <option>Penata Muda / III-a</option>
                            <option>Penata Muda Tingkat I / III-b</option>
                            <option>Penata III/c</option>
                            <option>Penata Tingkat I / III-d</option>
                            <option>Pembina / IV-a</option>
                            <option>Pembina Tingkat I / IV-b</option>
                            <option>Pembina Utama Muda / IV-c</option>
                            <option>Pembina Utama Madya / IV-d</option>
                            <option>Pembina Utama / IV-e</option>
                            </select>
                        </div>

                        <!-- TMT Pangkat -->
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">TMT Pangkat Terakhir<span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-sm" required>
                        </div>

                        <!-- Jabatan Struktural -->
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Jabatan Struktural (jika ada)</label>
                            <select class="form-select form-select-sm">
                            <option selected>Tidak ada</option>
                            <option value="ketua-departemen-mnh">Ketua Departemen MNH</option>
                            <option value="sekretaris-departemen-mnh">Sekretaris Departemen MNH</option>
                            <option value="sekretaris-prodi">Sekretaris Program Studi</option>
                            <option value="ketua-prodi-pp-ip-h">Ketua Program Studi Pascasarjana IPH</option>
                            <option value="sekretaris-prodi-pp-ip-h">Sekretaris Program Studi Pascasarjana IPH</option>
                            <option value="ktu">Kepala Tata Usaha (KTU)</option>
                            <option value="sub-koordinator-akademik">Sub Koordinator Administrasi Akademik</option>
                            <option value="sub-koordinator-keuangan-umum">Sub Koordinator Keuangan dan Umum</option>
                            <option value="komisi-akademik">Komisi Akademik</option>
                            <option value="anggota-komisi-akademik">Anggota Komisi Akademik</option>
                            <option value="komisi-kemahasiswaan">Komisi Kemahasiswaan</option>
                            <option value="anggota-komisi-kemahasiswaan">Anggota Komisi Kemahasiswaan</option>
                            <option value="kepala-divisi-perencanaan-kehutanan">Kepala Divisi Perencanaan Kehutanan</option>
                            <option value="kepala-divisi-kebijakan-kehutanan">Kepala Divisi Kebijakan Kehutanan</option>
                            <option value="kepala-divisi-pemanfaatan-sdh">Kepala Divisi Pemanfaatan Sumberdaya Hutan</option>
                            </select>
                        </div>

                        <!-- Periode Jabatan -->
                        <div class="col-md-6 form-group">
                        <label class="small text-secondary">Periode Jabatan Struktural</label>
                        <div class="d-flex gap-2 periode-jabatan">
                            <input type="date" class="form-control form-control-sm" placeholder="TMT">
                            <span class="pt-1">s/d</span>
                            <input type="date" class="form-control form-control-sm" placeholder="TST">
                        </div>
                        </div>

                        <!-- Finger Print -->
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Finger Print ID</label>
                            <input type="text" class="form-control form-control-sm">
                        </div>

                        <!-- NPWP -->
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">NPWP<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" required>
                        </div>

                        <!-- Nama Bank -->
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Nama Bank<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" required>
                        </div>

                        <!-- No Rekening -->
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">No Rekening<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" required>
                        </div>
                        </div>
                    </div>

                    <!-- TAB: Dosen -->
                    <div class="sub-tab-content" id="dosen" style="display: none;">
                        <div class="row g-3">
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">NUPTK</label>
                            <input type="text" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">SINTA ID</label>
                            <input type="text" class="form-control form-control-sm search-input" placeholder="Opsional">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">NIDN</label>
                            <input type="text" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Scopus ID</label>
                            <input type="text" class="form-control form-control-sm search-input" placeholder="Opsional">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">No. Sertifikasi Dosen</label>
                            <input type="text" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Orchid ID</label>
                            <input type="text" class="form-control form-control-sm search-input" placeholder="Opsional">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Tgl. Sertifikasi Dosen</label>
                            <input type="date" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Google Scholar ID</label>
                            <input type="text" class="form-control form-control-sm search-input" placeholder="Opsional">
                        </div>
                        </div>
                    </div>

                    <!-- TAB: Domisili -->
                    <div class="sub-tab-content" id="domisili" style="display: none;">
                        <div class="row g-3">
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Provinsi<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm search-input" placeholder="Contoh: Jawa Barat" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Alamat<span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm" required>JL. Lodaya</textarea>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Kota<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm search-input" placeholder="Contoh: Bandung" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Kode Pos<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" value="10021" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Kecamatan<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm search-input" placeholder="Contoh: Bandung Tengah" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">No. Telepon/HP<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" value="081239128991" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Kelurahan<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm search-input" placeholder="Contoh: Ciawi" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Email Pribadi / Institusi<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" value="aexyifshsi@gmail.com" required>
                        </div>
                        </div>
                    </div>

                    <!-- TAB: Kependudukan -->
                    <div class="sub-tab-content" id="kependudukan" style="display: none;">
                        <div class="row g-3">

                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Nomor KTP<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" value="31862908812645811" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Kecamatan<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm search-input" placeholder="Contoh: Talang Ubi" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Nomor KK<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" value="8011447152211029" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Kelurahan<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm search-input" placeholder="Contoh: Pisangan Timur" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Warga Negara<span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm" required>
                            <option>--Pilih Salah Satu--</option>
                            <option>Indonesia</option>
                            <option>Warga Negara Asing (WNA)</option>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Kode Pos<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" value="01984" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Provinsi<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm search-input" placeholder="Contoh: Sumatera Barat" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="small text-secondary">Kabupaten/Kota<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm search-input" placeholder="Contoh: Cimahi" required>
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="small text-secondary">Alamat<span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm" rows="2" required>Jl Pendopo</textarea>
                        </div>
                        </div>
                    </div>

                    <!-- TAB: E-file -->
                    <div class="sub-tab-content" id="efile" style="display: none;">
                        <!-- Tombol Tambah di pojok kanan -->
                        <div class="d-flex justify-content-end mb-3">
                            <button type="button" class="btn btn-tambah btn-sm" id="add-dokumen">
                                + Tambah Dokumen
                            </button>
                        </div>

                        <div id="dokumen-wrapper">
                            <div class="dokumen-item border p-4 pt-5 mb-4 rounded position-relative">
                                <!-- Nomor Urut -->
                                <span class="badge nomor-dokumen position-absolute top-0 start-0 m-3">No. 1</span>

                                <!-- Tombol Hapus -->
                                <button type="button" class="btn btn-danger btn-sm btn-hapus position-absolute top-0 end-0 m-3">
                                    &times;
                                </button>

                                <!-- Kategori -->
                                <div class="mb-3">
                                <label class="small text-secondary">Kategori<span class="text-danger">*</span></label>
                                <select id="kategori" class="form-select form-select-sm" required>
                                    <option value="" selected disabled>-- Pilih Kategori --</option>
                                    <option value="biodata">Biodata</option>
                                    <option value="pendidikan">Pendidikan</option>
                                    <option value="jf">Jabatan Fungsional</option>
                                    <option value="sk">Surat Keputusan Kepangkatan</option>
                                    <option value="sp">Surat Penting</option>
                                    <option value="lain">Dokumen Pendukung Lainnya</option>
                                </select>
                                </div>

                                <!-- Jenis Dokumen -->
                                <div class="mb-3">
                                <label class="small text-secondary">Jenis Dokumen<span class="text-danger">*</span></label>
                                <select id="jenis-dokumen" class="form-select form-select-sm" required>
                                    <option value="" selected disabled>-- Pilih Jenis Dokumen --</option>
                                </select>
                                </div>

                                <!-- Keaslian Dokumen -->
                                <div class="mb-3">
                                    <label class="small text-secondary">Keaslian Dokumen<span class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm" required>
                                        <option value="" selected disabled>-- Pilih Keaslian --</option>
                                        <option>Asli</option>
                                        <option>Scan</option>
                                        <option>Legalisir</option>
                                    </select>
                                </div>

                                <!-- Tanggal Dokumen -->
                                <div class="mb-3">
                                    <label class="small text-secondary">Tanggal Dokumen<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control form-control-sm" required>
                                </div>

                                <!-- Upload Dokumen (Drag & Drop) -->
                                <div class="mb-3">
                                    <label class="small text-secondary">Upload Dokumen<span class="text-danger">*</span></label>
                                    <div class="upload-box border rounded d-flex flex-column align-items-center justify-content-center p-4 text-center"
                                        onclick="this.querySelector('input').click()">
                                        <i class="fa fa-cloud-upload-alt fa-2x text-secondary mb-2"></i>
                                        <p class="mb-1 text-secondary">Drag & Drop File here</p>
                                        <small class="text-muted">Ukuran Maksimal 5 MB</small>
                                        <input type="file" class="file-input" accept=".pdf,.jpg,.jpeg,.png" hidden required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Simpan -->
                    <button class="btn btn-simpan w-100">
                        <i class="lni lni-save me-2"></i> Simpan
                    </button>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="footer-custom">
            <span>© 2025 Forest Management — All Rights Reserved</span>
        </footer>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('assets/js/tambah-pegawai.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>