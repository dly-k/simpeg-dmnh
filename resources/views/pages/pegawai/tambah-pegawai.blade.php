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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/edit-pegawai.css') }}" />
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
            <a href="{{ route('pegawai.index') }}" class="btn-kembali d-flex align-items-center gap-2">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>

        <main class="main-content">
            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('pegawai.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Menampilkan Ringkasan Error Validasi --}}
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4" role="alert">
                                <h5 class="alert-heading">Whoops! Terjadi beberapa masalah.</h5>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="d-flex flex-column flex-md-row gap-4 mb-4">
                            <div class="text-center flex-shrink-0">
                                <div class="mb-2 mx-auto d-flex align-items-center justify-content-center bg-light rounded foto-profil" id="foto-preview-container">
                                    <i class="lni lni-user"></i>
                                </div>
                                <button class="btn btn-editfoto btn-sm w-100" type="button" id="btn-edit-foto">Edit Foto</button>
                                <input type="file" name="foto_profil" id="foto-profil-input" class="d-none" accept="image/*">
                                @error('foto_profil')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="flex-grow-1">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">NIP<span class="text-danger">*</span></label>
                                        <input type="text" name="nip" class="form-control form-control-sm @error('nip') is-invalid @enderror" value="{{ old('nip') }}" placeholder="Contoh: 198709152023021001" required>
                                        @error('nip')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">Agama<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm @error('agama') is-invalid @enderror" name="agama">
                                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                            <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                            <option value="Budha" {{ old('agama') == 'Budha' ? 'selected' : '' }}>Budha</option>
                                            <option value="Khonghucu" {{ old('agama') == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                                        </select>
                                        @error('agama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">Nama Lengkap<span class="text-danger">*</span></label>
                                        <input type="text" name="nama_lengkap" class="form-control form-control-sm @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" placeholder="Termasuk gelar jika ada" required>
                                        @error('nama_lengkap')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">Status Pernikahan<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm @error('status_pernikahan') is-invalid @enderror" name="status_pernikahan">
                                            <option value="Belum Menikah" {{ old('status_pernikahan') == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                            <option value="Menikah" {{ old('status_pernikahan') == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                            <option value="Janda" {{ old('status_pernikahan') == 'Janda' ? 'selected' : '' }}>Janda</option>
                                            <option value="Duda" {{ old('status_pernikahan') == 'Duda' ? 'selected' : '' }}>Duda</option>
                                        </select>
                                        @error('status_pernikahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">Jenis Kelamin<span class="text-danger">*</span></label>
                                        <div>
                                            <div class="form-check form-check-inline pt-1">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="lk" value="Laki-laki" {{ old('jenis_kelamin', 'Laki-laki') == 'Laki-laki' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="lk">Laki-laki</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="pr" value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pr">Perempuan</label>
                                            </div>
                                        </div>
                                        @error('jenis_kelamin')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">Pendidikan Terakhir<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm @error('pendidikan_terakhir') is-invalid @enderror" name="pendidikan_terakhir">
                                            <option value="">--Pilih Salah Satu--</option>
                                            <option value="SD" {{ old('pendidikan_terakhir') == 'SD' ? 'selected' : '' }}>SD</option>
                                            <option value="SMP" {{ old('pendidikan_terakhir') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                            <option value="SMA" {{ old('pendidikan_terakhir') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                            <option value="S1" {{ old('pendidikan_terakhir') == 'S1' ? 'selected' : '' }}>S1</option>
                                            <option value="S2" {{ old('pendidikan_terakhir') == 'S2' ? 'selected' : '' }}>S2</option>
                                            <option value="S3" {{ old('pendidikan_terakhir') == 'S3' ? 'selected' : '' }}>S3</option>
                                        </select>
                                        @error('pendidikan_terakhir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">Tempat Lahir<span class="text-danger">*</span></label>
                                        <input type="text" name="tempat_lahir" class="form-control form-control-sm @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir') }}" placeholder="Contoh: Jakarta">
                                        @error('tempat_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">Bidang Ilmu<span class="text-danger">*</span></label>
                                        <input type="text" name="bidang_ilmu" class="form-control form-control-sm @error('bidang_ilmu') is-invalid @enderror" value="{{ old('bidang_ilmu') }}" placeholder="Contoh: Ilmu Pengelolaan Hutan">
                                        @error('bidang_ilmu')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">Tanggal Lahir<span class="text-danger">*</span></label>
                                        <input type="date" name="tanggal_lahir" class="form-control form-control-sm @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}">
                                        @error('tanggal_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                        <select class="form-select form-select-sm @error('status_kepegawaian') is-invalid @enderror" name="status_kepegawaian" required>
                                            <option value="Dosen PNS" {{ old('status_kepegawaian') == 'Dosen PNS' ? 'selected' : '' }}>Dosen PNS</option>
                                            <option value="Tendik PNS" {{ old('status_kepegawaian') == 'Tendik PNS' ? 'selected' : '' }}>Tendik PNS</option>
                                            <option value="Dosen Tetap" {{ old('status_kepegawaian') == 'Dosen Tetap' ? 'selected' : '' }}>Dosen Tetap</option>
                                            <option value="Tendik Tetap" {{ old('status_kepegawaian') == 'Tendik Tetap' ? 'selected' : '' }}>Tendik Tetap</option>
                                            <option value="Tendik Kontrak" {{ old('status_kepegawaian') == 'Tendik Kontrak' ? 'selected' : '' }}>Tendik Kontrak</option>
                                            <option value="Dosen Tamu" {{ old('status_kepegawaian') == 'Dosen Tamu' ? 'selected' : '' }}>Dosen Tamu</option>
                                            <option value="Tenaga Harian Lepas (THL)" {{ old('status_kepegawaian') == 'Tenaga Harian Lepas (THL)' ? 'selected' : '' }}>Tenaga Harian Lepas (THL)</option>
                                        </select>
                                        @error('status_kepegawaian')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Status Pegawai<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm @error('status_pegawai') is-invalid @enderror" name="status_pegawai" required>
                                            <option value="Aktif" {{ old('status_pegawai') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="Pensiun" {{ old('status_pegawai') == 'Pensiun' ? 'selected' : '' }}>Pensiun</option>
                                            <option value="Pensiun Muda" {{ old('status_pegawai') == 'Pensiun Muda' ? 'selected' : '' }}>Pensiun Muda</option>
                                            <option value="Diberhentikan" {{ old('status_pegawai') == 'Diberhentikan' ? 'selected' : '' }}>Diberhentikan</option>
                                            <option value="Meninggal Dunia" {{ old('status_pegawai') == 'Meninggal Dunia' ? 'selected' : '' }}>Meninggal Dunia</option>
                                            <option value="Kontrak Selesai" {{ old('status_pegawai') == 'Kontrak Selesai' ? 'selected' : '' }}>Kontrak Selesai</option>
                                            <option value="Mengundurkan diri" {{ old('status_pegawai') == 'Mengundurkan diri' ? 'selected' : '' }}>Mengundurkan diri</option>
                                            <option value="Mutasi" {{ old('status_pegawai') == 'Mutasi' ? 'selected' : '' }}>Mutasi</option>
                                        </select>
                                        @error('status_pegawai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                        <input type="text" class="form-control form-control-sm" name="nomor_arsip" value="{{ old('nomor_arsip') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Jabatan Fungsional<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm @error('jabatan_fungsional') is-invalid @enderror" name="jabatan_fungsional" required>
                                            <option value="Tidak ada">Tidak ada</option>
                                            <option value="Dosen">Dosen</option>
                                            <option value="Asisten Ahli">Asisten Ahli</option>
                                            <option value="Lektor">Lektor</option>
                                            <option value="Lektor Kepala">Lektor Kepala</option>
                                            <option value="Guru Besar">Guru Besar</option>
                                            <option value="Pranata Laboratorium Pendidikan Pelaksana Lanjutan">Pranata Laboratorium Pendidikan Pelaksana Lanjutan</option>
                                            <option value="Pranata Laboratorium Pendidikan Muda">Pranata Laboratorium Pendidikan Muda</option>
                                            <option value="Pranata Laboratorium Pendidikan Pertama">Pranata Laboratorium Pendidikan Pertama</option>
                                            <option value="Teknisi Hardware dan Software">Teknisi Hardware dan Software</option>
                                            <option value="Pengadministrasi Akademik & Kemahasiswaan PS IPH">Pengadministrasi Akademik & Kemahasiswaan PS IPH</option>
                                            <option value="Pengadministrasi Akademik & Kemahasiswaan MNH">Pengadministrasi Akademik & Kemahasiswaan MNH</option>
                                            <option value="Pengadministrasi Umum, Sarana & Prasarana">Pengadministrasi Umum, Sarana & Prasarana</option>
                                            <option value="Pengadministrasi Persuratan & Arsip">Pengadministrasi Persuratan & Arsip</option>
                                            <option value="Pengadministrasi Jurnal Ilmiah">Pengadministrasi Jurnal Ilmiah</option>
                                            <option value="Adm. Bagian/Divisi">Adm. Bagian/Divisi</option>
                                            <option value="Staf Kepegawaian">Staf Kepegawaian</option>
                                            <option value="Laboran Penafsiran Potret Udara">Laboran Penafsiran Potret Udara</option>
                                            <option value="Pramu Kantor">Pramu Kantor</option>
                                            <option value="Pramu Gedung dan Halaman">Pramu Gedung dan Halaman</option>
                                            <option value="Media Branding & Staf Jurnal Departemen">Media Branding & Staf Jurnal Departemen</option>
                                        </select>
                                        @error('jabatan_fungsional')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Pangkat/Golongan<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm @error('pangkat_golongan') is-invalid @enderror" name="pangkat_golongan" required>
                                            <option value="Juru Muda / I-a">Juru Muda / I-a</option>
                                            <option value="Juru Muda Tingkat I / I-b">Juru Muda Tingkat I / I-b</option>
                                            <option value="Juru / I-c">Juru / I-c</option>
                                            <option value="Juru Tingkat I / I-d">Juru Tingkat I / I-d</option>
                                            <option value="Pengatur Muda / II-a">Pengatur Muda / II-a</option>
                                            <option value="Pengatur Muda Tingkat I / II-b">Pengatur Muda Tingkat I / II-b</option>
                                            <option value="Pengatur / II-c">Pengatur / II-c</option>
                                            <option value="Pengatur Tingkat I / II-d">Pengatur Tingkat I / II-d</option>
                                            <option value="Penata Muda / III-a">Penata Muda / III-a</option>
                                            <option value="Penata Muda Tingkat I / III-b">Penata Muda Tingkat I / III-b</option>
                                            <option value="Penata III/c">Penata III/c</option>
                                            <option value="Penata Tingkat I / III-d">Penata Tingkat I / III-d</option>
                                            <option value="Pembina / IV-a">Pembina / IV-a</option>
                                            <option value="Pembina Tingkat I / IV-b">Pembina Tingkat I / IV-b</option>
                                            <option value="Pembina Utama Muda / IV-c">Pembina Utama Muda / IV-c</option>
                                            <option value="Pembina Utama Madya / IV-d">Pembina Utama Madya / IV-d</option>
                                            <option value="Pembina Utama / IV-e">Pembina Utama / IV-e</option>
                                        </select>
                                        @error('pangkat_golongan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">TMT Pangkat Terakhir</label>
                                        <input type="date" class="form-control form-control-sm" name="tmt_pangkat" value="{{ old('tmt_pangkat') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Jabatan Struktural</label>
                                        <select class="form-select form-select-sm" name="jabatan_struktural">
                                            <option value="Tidak ada">Tidak ada</option>
                                            <option value="Ketua Departemen MNH">Ketua Departemen MNH</option>
                                            <option value="Sekretaris Departemen MNH">Sekretaris Departemen MNH</option>
                                            <option value="Sekretaris Program Studi">Sekretaris Program Studi</option>
                                            <option value="Ketua Program Studi Pascasarjana IPH">Ketua Program Studi Pascasarjana IPH</option>
                                            <option value="Sekretaris Program Studi Pascasarjana IPH">Sekretaris Program Studi Pascasarjana IPH</option>
                                            <option value="Kepala Tata Usaha (KTU)">Kepala Tata Usaha (KTU)</option>
                                            <option value="Sub Koordinator Administrasi Akademik">Sub Koordinator Administrasi Akademik</option>
                                            <option value="Sub Koordinator Keuangan dan Umum">Sub Koordinator Keuangan dan Umum</option>
                                            <option value="Komisi Akademik">Komisi Akademik</option>
                                            <option value="Anggota Komisi Akademik">Anggota Komisi Akademik</option>
                                            <option value="Komisi Kemahasiswaan">Komisi Kemahasiswaan</option>
                                            <option value="Anggota Komisi Kemahasiswaan">Anggota Komisi Kemahasiswaan</option>
                                            <option value="Kepala Divisi Perencanaan Kehutanan">Kepala Divisi Perencanaan Kehutanan</option>
                                            <option value="Kepala Divisi Kebijakan Kehutanan">Kepala Divisi Kebijakan Kehutanan</option>
                                            <option value="Kepala Divisi Pemanfaatan Sumberdaya Hutan">Kepala Divisi Pemanfaatan Sumberdaya Hutan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Periode Jabatan Struktural</label>
                                        <div class="d-flex gap-2 periode-jabatan">
                                            <input type="date" class="form-control form-control-sm" name="periode_jabatan_mulai" placeholder="TMT" value="{{ old('periode_jabatan_mulai') }}">
                                            <span class="pt-1">s/d</span>
                                            <input type="date" class="form-control form-control-sm" name="periode_jabatan_selesai" placeholder="TST" value="{{ old('periode_jabatan_selesai') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Finger Print ID</label>
                                        <input type="text" class="form-control form-control-sm" name="finger_print_id" value="{{ old('finger_print_id') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">NPWP</label>
                                        <input type="text" class="form-control form-control-sm" name="npwp" value="{{ old('npwp') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Nama Bank</label>
                                        <input type="text" class="form-control form-control-sm" name="nama_bank" value="{{ old('nama_bank') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">No Rekening</label>
                                        <input type="text" class="form-control form-control-sm" name="nomor_rekening" value="{{ old('nomor_rekening') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="sub-tab-content" id="dosen" style="display: none;">
                                <div class="row g-3">
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">NUPTK</label>
                                        <input type="text" class="form-control form-control-sm" name="nuptk" value="{{ old('nuptk') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">SINTA ID</label>
                                        <input type="text" class="form-control form-control-sm" name="sinta_id" placeholder="Opsional" value="{{ old('sinta_id') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">NIDN</label>
                                        <input type="text" class="form-control form-control-sm" name="nidn" value="{{ old('nidn') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Scopus ID</label>
                                        <input type="text" class="form-control form-control-sm" name="scopus_id" placeholder="Opsional" value="{{ old('scopus_id') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">No. Sertifikasi Dosen</label>
                                        <input type="text" class="form-control form-control-sm" name="no_sertifikasi_dosen" value="{{ old('no_sertifikasi_dosen') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Orchid ID</label>
                                        <input type="text" class="form-control form-control-sm" name="orchid_id" placeholder="Opsional" value="{{ old('orchid_id') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Tgl. Sertifikasi Dosen</label>
                                        <input type="date" class="form-control form-control-sm" name="tgl_sertifikasi_dosen" value="{{ old('tgl_sertifikasi_dosen') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Google Scholar ID</label>
                                        <input type="text" class="form-control form-control-sm" name="google_scholar_id" placeholder="Opsional" value="{{ old('google_scholar_id') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="sub-tab-content" id="domisili" style="display: none;">
                                <div class="row g-3">
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Provinsi</label>
                                        <input type="text" class="form-control form-control-sm" name="provinsi_domisili" placeholder="Contoh: Jawa Barat" value="{{ old('provinsi_domisili') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Alamat</label>
                                        <textarea class="form-control form-control-sm" name="alamat_domisili" placeholder="Contoh: JL. Lodaya">{{ old('alamat_domisili') }}</textarea>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kota</label>
                                        <input type="text" class="form-control form-control-sm" name="kota_domisili" placeholder="Contoh: Bandung" value="{{ old('kota_domisili') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kode Pos</label>
                                        <input type="text" class="form-control form-control-sm" name="kode_pos_domisili" placeholder="Contoh: 10021" value="{{ old('kode_pos_domisili') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kecamatan</label>
                                        <input type="text" class="form-control form-control-sm" name="kecamatan_domisili" placeholder="Contoh: Bandung Tengah" value="{{ old('kecamatan_domisili') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">No. Telepon/HP</label>
                                        <input type="text" class="form-control form-control-sm" name="no_telepon" placeholder="Contoh: 081239128991" value="{{ old('no_telepon') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kelurahan</label>
                                        <input type="text" class="form-control form-control-sm" name="kelurahan_domisili" placeholder="Contoh: Ciawi" value="{{ old('kelurahan_domisili') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Email Pribadi / Institusi</label>
                                        <input type="email" class="form-control form-control-sm" name="email" placeholder="Contoh: aexyifshsi@gmail.com" value="{{ old('email') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="sub-tab-content" id="kependudukan" style="display: none;">
                                <div class="row g-3">
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Nomor KTP</label>
                                        <input type="text" class="form-control form-control-sm" name="nomor_ktp" placeholder="Contoh: 31862908812645811" value="{{ old('nomor_ktp') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kecamatan</label>
                                        <input type="text" class="form-control form-control-sm" name="kecamatan_ktp" placeholder="Contoh: Talang Ubi" value="{{ old('kecamatan_ktp') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Nomor KK</label>
                                        <input type="text" class="form-control form-control-sm" name="nomor_kk" placeholder="Contoh: 8011447152211029" value="{{ old('nomor_kk') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kelurahan</label>
                                        <input type="text" class="form-control form-control-sm" name="kelurahan_ktp" placeholder="Contoh: Pisangan Timur" value="{{ old('kelurahan_ktp') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Warga Negara</label>
                                        <select class="form-select form-select-sm" name="warga_negara">
                                            <option value="">--Pilih Salah Satu--</option>
                                            <option value="WNI" {{ old('warga_negara') == 'WNI' ? 'selected' : '' }}>Warga Negara Indonesia (WNI)</option>
                                            <option value="WNA" {{ old('warga_negara') == 'WNA' ? 'selected' : '' }}>Warga Negara Asing (WNA)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kode Pos</label>
                                        <input type="text" class="form-control form-control-sm" name="kode_pos_ktp" placeholder="Contoh: 01984" value="{{ old('kode_pos_ktp') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Provinsi</label>
                                        <input type="text" class="form-control form-control-sm" name="provinsi_ktp" placeholder="Contoh: Sumatera Barat" value="{{ old('provinsi_ktp') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kabupaten/Kota</label>
                                        <input type="text" class="form-control form-control-sm" name="kabupaten_ktp" placeholder="Contoh: Cimahi" value="{{ old('kabupaten_ktp') }}">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label class="small text-dark fw-medium mb-1">Alamat</label>
                                        <textarea class="form-control form-control-sm" rows="2" name="alamat_ktp" placeholder="Contoh: Jl Pendopo">{{ old('alamat_ktp') }}</textarea>
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

@if(session('success'))
    @include('components.konfirmasi-berhasil')
@endif

<script src="{{ asset('assets/js/layout.js') }}"></script>
<script src="{{ asset('assets/js/tambah-pegawai.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnEditFoto = document.getElementById('btn-edit-foto');
    const fotoInput = document.getElementById('foto-profil-input');
    const fotoPreviewContainer = document.getElementById('foto-preview-container');

    btnEditFoto.addEventListener('click', () => {
        fotoInput.click();
    });

    fotoInput.addEventListener('change', () => {
        const file = fotoInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                fotoPreviewContainer.innerHTML = `<img src="${e.target.result}" alt="Foto Profil" class="img-fluid rounded" style="width: 100%; height: 100%; object-fit: cover;">`;
            }
            reader.readAsDataURL(file);
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    // Ambil semua input dengan tipe 'date'
    const dateInputs = document.querySelectorAll('input[type="date"]');

    // Tambahkan event listener ke setiap input tanggal
    dateInputs.forEach(input => {
        input.addEventListener('click', function(e) {
            // Tampilkan date picker bawaan browser
            try {
                this.showPicker();
            } catch (error) {
                // Fallback untuk browser yang tidak mendukung showPicker()
                console.log("Browser tidak mendukung showPicker(), tapi seharusnya tetap berfungsi di browser modern.");
            }
        });
    });
});
</script>

</body>
</html>

