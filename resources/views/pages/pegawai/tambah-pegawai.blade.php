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
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/tambah-pegawai.css') }}" />
</head>

<body>
<div class="layout">
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

        <div class="title-bar d-flex align-items-center justify-content-between">
            <h1 class="m-0">
                <i class="fa fa-user-plus"></i> Tambah Data Pegawai
            </h1>
            <a href="/daftar-pegawai" class="btn-kembali d-flex align-items-center gap-2">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>

        <main class="main-content">
            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('pegawai.store') }}" method="POST">
                        @csrf
                        <div class="d-flex flex-column flex-md-row gap-4 mb-4">
                            <div class="text-center flex-shrink-0">
                                <div class="foto-container mb-2 mx-auto d-flex align-items-center justify-content-center bg-light rounded">
                                    <i class="lni lni-user foto-icon"></i>
                                </div>
                                <button class="btn btn-editfoto btn-sm w-100 edit-foto-btn" type="button" onclick="editPhoto()">
                                    Edit Foto
                                </button>
                                <input type="file" name="foto_profil" class="d-none" id="foto-profil-input">
                            </div>

                            <div class="flex-grow-1">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">NIP<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm search-input" name="nip" placeholder="Contoh: 198709152023021001" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">Agama<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" name="agama">
                                            <option selected>Islam</option>
                                            <option>Kristen</option>
                                            <option>Katolik</option>
                                            <option>Hindu</option>
                                            <option>Budha</option>
                                            <option>Khonghucu</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">Nama Lengkap<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm search-input" name="nama_lengkap" placeholder="Termasuk gelar jika ada" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">Status Pernikahan<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" name="status_pernikahan">
                                            <option selected>Belum Menikah</option>
                                            <option>Menikah</option>
                                            <option>Janda</option>
                                            <option>Duda</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">Jenis Kelamin<span class="text-danger">*</span></label>
                                        <div>
                                            <div class="form-check form-check-inline pt-1">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="lk" value="Laki-laki" checked>
                                                <label class="form-check-label" for="lk">Laki-laki</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="pr" value="Perempuan">
                                                <label class="form-check-label" for="pr">Perempuan</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">Pendidikan Terakhir<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" name="pendidikan_terakhir">
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
                                        <label class="small text-dark fw-medium mb-1">Tempat Lahir<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm search-input" name="tempat_lahir" placeholder="Contoh: Jakarta">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">Bidang Ilmu<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm search-input" name="bidang_ilmu" placeholder="Contoh: Ilmu Pengelolaan Hutan">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">Tanggal Lahir<span class="text-danger">*</span></label>
                                        <input type="date" class="form-control form-control-sm" name="tanggal_lahir">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="mb-4 custom-hr">
                        <div class="main-tab-content" id="biodata-content">
                            <div id="biodata-sub-tabs" class="btn-group flex-wrap gap-2 mb-4">
                                <button type="button" class="btn active" data-tab="kepegawaian">Kepegawaian</button>
                                <button type="button" class="btn" data-tab="dosen">Dosen</button>
                                <button type="button" class="btn" data-tab="domisili">Alamat Domisili & Kontak</button>
                                <button type="button" class="btn" data-tab="kependudukan">Kependudukan</button>
                            </div>
                            <div class="sub-tab-content" id="kepegawaian">
                                <div class="row g-3">
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Status Kepegawaian<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" name="status_kepegawaian" required>
                                            <option selected>Dosen PNS</option>
                                            <option>Tendik PNS</option>
                                            <option>Dosen Tetap</option>
                                            <option>Tendik Tetap</option>
                                            <option>Tendik Kontrak</option>
                                            <option>Dosen Tamu</option>
                                            <option>Tenaga Harian Lepas (THL)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Status Pegawai<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" name="status_pegawai" required>
                                            <option selected>Aktif</option>
                                            <option>Pensiun</option>
                                            <option>Pensiun Muda</option>
                                            <option>Diberhentikan</option>
                                            <option>Meninggal Dunia</option>
                                            <option>Kontrak Selesai</option>
                                            <option>Mengundurkan diri</option>
                                            <option>Mutasi</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Unit Kerja</label>
                                        <input type="text" class="form-control form-control-sm readonly-input" value="Fakultas Kehutanan dan Lingkungan" readonly>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Divisi</label>
                                        <input type="text" class="form-control form-control-sm readonly-input" value="Departemen Manajemen Hutan" readonly>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Nomor Arsip Berkas Kepegawaian</label>
                                        <input type="text" class="form-control form-control-sm" name="nomor_arsip">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Jabatan Fungsional<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" name="jabatan_fungsional" required>
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
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Pangkat/Golongan<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" name="pangkat_golongan" required>
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
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">TMT Pangkat Terakhir</label>
                                        <input type="date" class="form-control form-control-sm" name="tmt_pangkat">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Jabatan Struktural</label>
                                        <select class="form-select form-select-sm" name="jabatan_struktural" required>
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
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Periode Jabatan Struktural</label>
                                        <div class="d-flex gap-2 periode-jabatan">
                                            <input type="date" class="form-control form-control-sm" name="periode_jabatan_mulai" placeholder="TMT">
                                            <span class="pt-1">s/d</span>
                                            <input type="date" class="form-control form-control-sm" name="periode_jabatan_selesai" placeholder="TST">
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Finger Print ID</label>
                                        <input type="text" class="form-control form-control-sm" name="finger_print_id">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">NPWP</label>
                                        <input type="text" class="form-control form-control-sm" name="npwp">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Nama Bank</label>
                                        <input type="text" class="form-control form-control-sm" name="nama_bank">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">No Rekening</label>
                                        <input type="text" class="form-control form-control-sm" name="nomor_rekening">
                                    </div>
                                </div>
                            </div>
                            <div class="sub-tab-content" id="dosen">
                                <div class="row g-3">
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">NUPTK</label>
                                        <input type="text" class="form-control form-control-sm" name="nuptk">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">SINTA ID</label>
                                        <input type="text" class="form-control form-control-sm search-input" name="sinta_id" placeholder="Opsional">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">NIDN</label>
                                        <input type="text" class="form-control form-control-sm" name="nidn">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Scopus ID</label>
                                        <input type="text" class="form-control form-control-sm search-input" name="scopus_id" placeholder="Opsional">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">No. Sertifikasi Dosen</label>
                                        <input type="text" class="form-control form-control-sm" name="no_sertifikasi_dosen">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Orchid ID</label>
                                        <input type="text" class="form-control form-control-sm search-input" name="orchid_id" placeholder="Opsional">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Tgl. Sertifikasi Dosen</label>
                                        <input type="date" class="form-control form-control-sm" name="tgl_sertifikasi_dosen">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Google Scholar ID</label>
                                        <input type="text" class="form-control form-control-sm search-input" name="google_scholar_id" placeholder="Opsional">
                                    </div>
                                </div>
                            </div>
                            <div class="sub-tab-content" id="domisili">
                                <div class="row g-3">
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Provinsi</label>
                                        <input type="text" class="form-control form-control-sm search-input" name="provinsi_domisili" placeholder="Contoh: Jawa Barat">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Alamat</label>
                                        <textarea class="form-control form-control-sm" name="alamat_domisili" placeholder="Contoh: JL. Lodaya"></textarea>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kota</label>
                                        <input type="text" class="form-control form-control-sm search-input" name="kota_domisili" placeholder="Contoh: Bandung">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kode Pos</label>
                                        <input type="text" class="form-control form-control-sm" name="kode_pos_domisili" placeholder="Contoh: 10021">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kecamatan</label>
                                        <input type="text" class="form-control form-control-sm search-input" name="kecamatan_domisili" placeholder="Contoh: Bandung Tengah">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">No. Telepon/HP</label>
                                        <input type="text" class="form-control form-control-sm" name="no_telepon" placeholder="Contoh: 081239128991">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kelurahan</label>
                                        <input type="text" class="form-control form-control-sm search-input" name="kelurahan_domisili" placeholder="Contoh: Ciawi">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Email Pribadi / Institusi</label>
                                        <input type="text" class="form-control form-control-sm" name="email" placeholder="Contoh: aexyifshsi@gmail.com">
                                    </div>
                                </div>
                            </div>
                            <div class="sub-tab-content" id="kependudukan">
                                <div class="row g-3">
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Nomor KTP</label>
                                        <input type="text" class="form-control form-control-sm" name="nomor_ktp" placeholder="Contoh: 31862908812645811">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kecamatan</label>
                                        <input type="text" class="form-control form-control-sm search-input" name="kecamatan_ktp" placeholder="Contoh: Talang Ubi">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Nomor KK</label>
                                        <input type="text" class="form-control form-control-sm" name="nomor_kk" placeholder="Contoh: 8011447152211029">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kelurahan</label>
                                        <input type="text" class="form-control form-control-sm search-input" name="kelurahan_ktp" placeholder="Contoh: Pisangan Timur">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Warga Negara</label>
                                        <select class="form-select form-select-sm" name="warga_negara">
                                            <option>--Pilih Salah Satu--</option>
                                            <option>Warna Negara Indonesia (WNI)</option>
                                            <option>Warga Negara Asing (WNA)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kode Pos</label>
                                        <input type="text" class="form-control form-control-sm" name="kode_pos_ktp" placeholder="Contoh: 01984">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Provinsi</label>
                                        <input type="text" class="form-control form-control-sm search-input" name="provinsi_ktp" placeholder="Contoh: Sumatera Barat">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kabupaten/Kota</label>
                                        <input type="text" class="form-control form-control-sm search-input" name="kabupaten_ktp" placeholder="Contoh: Cimahi">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label class="small text-dark fw-medium mb-1">Alamat</label>
                                        <textarea class="form-control form-control-sm" rows="2" name="alamat_ktp" placeholder="Contoh: Jl Pendopo"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-simpan w-100">
                            <i class="lni lni-save me-2"></i> Simpan
                        </button>
                    </form>
                </div>
            </div>
        </main>
        <footer class="footer-custom">
            <span>© 2025 Forest Management — All Rights Reserved</span>
        </footer>
    </div>
</div>
@include('components.konfirmasi-berhasil')
<script src="{{ asset('assets/js/layout.js') }}"></script>
<script src="{{ asset('assets/js/tambah-pegawai.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>