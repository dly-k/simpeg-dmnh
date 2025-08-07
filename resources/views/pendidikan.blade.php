<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIKEMAH - Editor Kegiatan Pendidikan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
  --primary: #049466;
  --primary-light: #e3f7ec;
  --primary-dark: #047857;
  --border-color: #e2e8f0;

  --info: #03b9de;
  --info-hover: #0aa6c6;

  --verifikasi: #11ba82;
  --verifikasi-hover: #0ba572;

  --warning: #ffc107;
  --warning-hover: #d39e00;

  --danger: #dc3545;
  --danger-hover: #b02a37;

  --dark: #2d3748;
  --dark-hover: #1a202c;

  --light: #f5f6fa;
  --gray: #6c757d;
  --white: #ffffff;
    }

    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      background-color: #f5f6fa;
    }

    /* Sidebar */
    .sidebar {
      width: 250px;
      height: 100vh;
      background-color: #fff;
      border-right: 1px solid var(--border-color);
      position: fixed;
      top: 0;
      left: 0;
      display: flex;
      flex-direction: column;
      transition: transform 0.3s ease-in-out;
      z-index: 1001;
      transform: translateX(0);
    }
    .sidebar.hidden { transform: translateX(-100%); }

    .sidebar .brand {
      font-size: 24px;
      font-weight: 700;
      color: #222;
      text-align: center;
      padding: 14.5px 0;
      border-bottom: 1px solid #ccc;
      letter-spacing: 1px;
    }
    .sidebar .brand span { color: var(--primary); }

    .sidebar .menu-wrapper {
      overflow-y: auto;
      flex-grow: 1;
    }

    .menu p {
      font-size: 13px;
      font-weight: 500;
      padding: 0 20px;
      margin: 12px 0 8px;
      color: #888;
    }

    .sidebar .menu a,
    .sidebar .menu button {
      display: flex;
      align-items: center;
      padding: 12px 20px;
      text-decoration: none;
      color: #333;
      font-size: 13px;
      transition: all 0.2s ease-in-out;
      width: 100%;
      background: none;
      border: none;
      text-align: left;
    }
    .sidebar .menu a:hover,
    .sidebar .menu button:hover {
      background-color: var(--primary-light);
      color: var(--primary);
    }
    .sidebar .menu a.active,
    .sidebar .menu button.active {
      background-color: var(--primary);
      color: #fff;
      font-weight: 600;
    }
    .sidebar .menu a:first-of-type {
      margin-top: 10px;
    }
    .sidebar .menu a i,
    .sidebar .menu button i {
      margin-right: 12px;
      font-size: 16px;
      min-width: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .sidebar .submenu a {
      padding: 9px 20px 9px 45px;
      font-size: 12.5px;
    }
    .sidebar .submenu a.active {
      color: var(--primary);
      font-weight: 600;
      background-color: var(--primary-light);
    }
    
    .toggle-icon {
      margin-left: auto;
      transition: transform 0.3s;
    }
    .collapsed .toggle-icon { transform: rotate(-90deg); }

    /* Overlay for mobile sidebar */
    .overlay {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.4);
      z-index: 1000;
      display: none;
    }
    .overlay.show { display: block; }
    
    /* Navbar */
    .navbar-custom {
      height: 66px;
      background: #fff;
      border-bottom: 1px solid var(--border-color);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 20px;
      margin-left: 250px;
      transition: margin-left 0.3s ease-in-out;
      position: fixed;
      top: 0;
      right: 0;
      left: 0;
      z-index: 999;
    }
    body.sidebar-collapsed .navbar-custom { margin-left: 0; }
    
    .time-date {
      font-size: 13px;
      display: flex;
      align-items: center;
      gap: 20px;
      font-weight: 400;
    }
    .time-date div {
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .time-date i { color: #4b5563; font-size: 13px; }

    .account {
      display: flex;
      align-items: center;
      font-size: 13px;
      font-weight: 400;
      cursor: pointer;
      margin-left: 10px;
      gap: 6px;
    }
    .icon-circle {
      background: var(--primary);
      color: white;
      border-radius: 50%;
      width: 28px;
      height: 28px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      flex-shrink: 0;
    }
    .dropdown-item i {
      min-width: 24px;
      text-align: center;
    }
    .dropdown-menu {
      margin-top: 5px !important;
      padding: 0;
      overflow: hidden;
      border-radius: 0.375rem;
    }
    .dropdown-item {
      padding: 10px 16px;
      font-size: 13px;
    }
    .dropdown-divider {
      margin: 0;
    }
    .dropdown-item-danger {
      color: #dc3545;
    }
    .dropdown-item-danger:hover,
    .dropdown-item-danger:focus {
      color: #fff;
      background-color: #dc3545;
    }

    /* Title Bar */
    .title-bar {
      background: linear-gradient(to right, #059669, #047857);
      color: white;
      padding: 20px 25px;
      margin-left: 250px;
      transition: margin-left 0.3s ease-in-out;
      position: fixed;
      top: 66px;
      left: 0;
      right: 0;
      z-index: 998;
      display: flex;
      align-items: center;
    }
    body.sidebar-collapsed .title-bar { margin-left: 0; }

    .title-bar h1 {
      font-size: 20px;
      margin: 0;
      display: flex;
      align-items: center;
      gap: 12px;
      font-weight: 600;
    }
    .title-bar h1 i { font-size: 22px; }

    /* Main Content */
    .main-content {
      margin-left: 250px;
      padding: 25px;
      transition: margin-left 0.3s ease-in-out;
      background-color: #f5f6fa;
      margin-top: 130px;
      font-size: 14px;
      padding-bottom: 70px;
    }
    body.sidebar-collapsed .main-content { margin-left: 0; }
    
    .card {
      background: white;
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
      border: none;
    }
    
    /* Filter Section */
    .search-filter-container {
      padding: 0;
      margin-bottom: 1.5rem;
    }
    .search-filter-row {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      align-items: center;
    }
    .search-box {
      flex: 1;
      min-width: 250px;
    }
    .filter-select {
      width: 180px;
    }
    .btn-tambah-container {
      margin-left: auto;
    }
    
    .table {
        vertical-align: middle;
        font-size: 12px;
    }

    .table th {
        font-weight: 600;
        vertical-align: middle !important;
        text-align: center !important;
    }

    
    .btn-aksi {
      width: 32px;
      height: 32px;
      border-radius: 6px !important;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0;
      color: white;
      text-decoration: none;
    }
/* Tombol Aksi */
.btn-lihat {
  background-color: #0dcaf0;
}

.btn-edit {
  background-color: #ffc107;
}

.btn-hapus {
  background-color: #dc3545;
}

.btn-verifikasi {
  background-color: #10b981;
}

/* Nav Tabs */
.nav-tabs {
  border-bottom: none;
}

.nav-tabs .nav-item {
  margin-right: 0.5rem; /* Jarak antar tab */
}

.nav-tabs .nav-link {
  border: none;
  color: #6c757d;
  font-weight: 600;
  font-size: 0.9rem;
  padding: 0.4rem 0.75rem;
  border-radius: 0.375rem;
  transition: background-color 0.3s ease, color 0.3s ease;
}

.nav-tabs .nav-link:focus {
  outline: none;
  box-shadow: none;
}

.nav-tabs .nav-link.active {
  background-color: var(--primary);
  color: white;
  border-radius: 0.375rem !important;
}

.search-input::placeholder {
  color: rgba(0, 0, 0, 0.4);
  opacity: 1;
}

.btn-tambah {
  background-color: var(--dark);
  color: var(--white);
  transition: all 0.3s ease;
}
.btn-tambah:hover {
  background-color: var(--dark-hover);
  color: var(--white);
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.btn-verifikasi {
  background-color: var(--verifikasi);
  color: var(--white);
  transition: all 0.3s ease;
}
.btn-verifikasi:hover {
  background-color: var(--verifikasi-hover);
  color: var(--white);
  transform: scale(1.15);
  box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.btn-lihat, .btn-lihat-detail {
  background-color: var(--info);
  color: var(--white);
  transition: all 0.3s ease;
}
.btn-lihat:hover, .btn-lihat-detail:hover {
  background-color: var(--info-hover);
  color: var(--white);
  transform: scale(1.15);
}

.btn-edit {
  background-color: var(--warning);
  color: var(--white);
  transition: all 0.3s ease;
}
.btn-edit:hover {
  background-color: var(--warning-hover);
  color: var(--white);
  transform: scale(1.15);
}

.btn-hapus {
  background-color: var(--danger);
  color: var(--white);
  transition: all 0.3s ease;
}
.btn-hapus:hover {
  background-color: var(--danger-hover);
  color: var(--white);
  transform: scale(1.15);
}

    /* Footer */
    .footer-custom {
      background: #fff;
      border-top: 1px solid var(--border-color);
      height: 45px;
      display: flex;
      align-items: center;
      justify-content: flex-end;
      padding: 0 20px;
      font-size: 12px;
      color: #555;
      position: fixed;
      bottom: 0;
      right: 0;
      left: 0;
      margin-left: 250px;
      transition: margin-left 0.3s ease-in-out;
      z-index: 997;
    }
    body.sidebar-collapsed .footer-custom {
      margin-left: 0;
    }
    
    /* Responsive */
    @media (max-width: 991px) {
      .sidebar { transform: translateX(-100%); }
      .sidebar.show { transform: translateX(0); }
      .navbar-custom, .title-bar, .main-content, .footer-custom { margin-left: 0 !important; }
      .time-date { flex-direction: column; gap: 6px; align-items: flex-start; }
      .account span { font-size: 12px; }
      .sidebar .menu a, .sidebar .menu button { font-size: 12.5px; }

      .search-filter-row {
        flex-direction: column;
        align-items: stretch;
      }
      .search-box, .filter-select {
        width: 100%;
      }
      .btn-tambah-container {
        margin-left: 0;
        width: 100%;
      }
      .btn-tambah {
        width: 100%;
      }
    }
         /* Pagination Kustom */
    .pagination .page-item.active .page-link {
        background-color: var(--primary);
        border-color: var(--primary);
        color: white;
    }
    .pagination .page-link {
        color: var(--primary);
    }
    .pagination .page-link:hover {
        background-color: var(--primary-light);
    }
    .pagination .page-item.disabled .page-link {
        color: #6c757d;
    }
  </style>
</head>
<body>

  <div class="sidebar" id="sidebar">
    <div class="brand">SI<span>KEMAH</span></div>
    <div class="menu-wrapper">
      <div class="menu">
        <a href="/dashboard" aria-label="Dashboard"><i class="lni lni-grid-alt"></i> Dashboard</a>
        <p>Menu Utama</p>
        <a href="/daftar-pegawai" aria-label="Daftar Pegawai"><i class="lni lni-users"></i> Daftar Pegawai</a>
        <a href="/surat-tugas" aria-label="Manajemen Surat Tugas"><i class="lni lni-folder"></i> Manajemen Surat Tugas</a>
        <button class="active" data-bs-toggle="collapse" data-bs-target="#editorKegiatan" aria-expanded="true" aria-controls="editorKegiatan">
          <i class="lni lni-pencil-alt"></i> Editor Kegiatan
          <i class="lni lni-chevron-down toggle-icon"></i>
        </button>
        <div class="collapse show submenu" id="editorKegiatan">
          <a href="/pendidikan" aria-label="Pendidikan" class="active">Pendidikan</a>
          <a href="/penelitian" aria-label="Penelitian">Penelitian</a>
          <a href="/pengabdian" aria-label="Pengabdian">Pengabdian</a>
          <a href="/penunjang" aria-label="Penunjang">Penunjang</a>
          <a href="/pelatihan" aria-label="Pelatihan">Pelatihan</a>
          <a href="/penghargaan" aria-label="Penghargaan">Penghargaan</a>
          <a href="/sk-non-pns" aria-label="SK Non PNS">SK Non PNS</a>
        </div>
        <a href="/kerjasama" aria-label="Kerjasama"><i class="lni lni-handshake"></i> Kerjasama</a>
        <a href="/master-data" aria-label="Master Data"><i class="lni lni-database"></i> Master Data</a>
      </div>
    </div>
  </div>

  <div class="overlay" id="overlay"></div>

  <div class="navbar-custom">
    <div class="d-flex align-items: center">
      <button class="btn btn-link text-dark me-3" id="toggleSidebar" aria-label="Toggle Sidebar">
        <i class="lni lni-menu"></i>
      </button>
    </div>
    <div class="d-flex align-items: center">
      <div class="time-date me-2">
        <div><i class="lni lni-calendar"></i> <span id="current-date"></span></div>
        <div><i class="lni lni-timer"></i> <span id="current-time"></span></div>
      </div>
      <div class="dropdown">
        <a href="#" class="account text-decoration-none text-dark" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="icon-circle"><i class="lni lni-user"></i></span>
          <span>Halo, Ketua TU</span>
          <i class="lni lni-chevron-down"></i>
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
  </div>

  <div class="title-bar">
    <h1><i class="lni lni-pencil-alt"></i> <span id="page-title">Editor Kegiatan - Pendidikan</span></h1>
  </div>

  <div class="main-content">
      <div class="card">
          <ul class="nav nav-tabs mb-4" id="pendidikanTab" role="tablist">
            <li class="nav-item" role="presentation"><button class="nav-link active" id="pengajaran-lama-tab" data-bs-toggle="tab" data-bs-target="#pengajaran-lama" type="button" role="tab">Pengajaran Lama</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="pengajaran-luar-tab" data-bs-toggle="tab" data-bs-target="#pengajaran-luar" type="button" role="tab">Pengajaran Luar IPB</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="pengujian-lama-tab" data-bs-toggle="tab" data-bs-target="#pengujian-lama" type="button" role="tab">Pengujian Lama</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="pembimbing-lama-tab" data-bs-toggle="tab" data-bs-target="#pembimbing-lama" type="button" role="tab">Pembimbing Lama</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="penguji-luar-tab" data-bs-toggle="tab" data-bs-target="#penguji-luar" type="button" role="tab">Penguji Luar IPB</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="pembimbing-luar-tab" data-bs-toggle="tab" data-bs-target="#pembimbing-luar" type="button" role="tab">Pembimbing Luar IPB</button></li>
          </ul>

          <div class="search-filter-container">
            <div class="search-filter-row">
                <div class="search-box">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search" style="color: green;"></i></span>
                        <input type="text" class="form-control search-input border-start-0" placeholder="Cari Data ....">
                    </div>
                </div>
                <select class="form-select filter-select"><option selected>Semester</option><option>Genap 2024/2025</option></select>
                <select class="form-select filter-select">
                  <option selected>Status</option><option>Sudah Diverifikasi</option><option>Belum Diverifikasi</option><option>Ditolak</option>
                </select>                <div class="btn-tambah-container">
                    <a href="#" class="btn btn-tambah fw-bold"><i class="fa fa-plus me-2"></i> Tambah Data</a>
                </div>
            </div>
          </div>

          <div class="tab-content" id="pendidikanTabContent">
            
            <div class="tab-pane fade show active" id="pengajaran-lama" role="tabpanel">
                <div class="table-responsive">
                  <table class="table table-hover table-bordered">
                      <thead class="table-light">
                          <tr class="text-center"><th>No</th><th class="text-start">Nama</th><th>Tahun Semester</th><th>Kode MK</th><th>Mata Kuliah</th><th>SKS</th><th>Kelas Paralel (Jenis)</th><th>Jumlah Pertemuan</th><th>Verifikasi</th><th>Dokumen</th><th>Aksi</th></tr>
                      </thead>
                      <tbody>
                          <script>for(let i=1; i<=8; i++){ document.write(`<tr><td class="text-center">${i}</td><td>Alex Kurniawan</td><td class="text-center">2018/2019 Ganjil</td><td class="text-center">MNH211</td><td>Biometrika Hutan</td><td class="text-center">3 (3-0)</td><td class="text-center">1 (K)</td><td class="text-center">K,S, P,O, R,O</td><td class="text-center">${i % 2 === 0 ? '<i class="fas fa-check-circle text-success"></i>' : '<i class="fas fa-times-circle text-danger"></i>'}</td><td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td><td class="text-center"><div class="d-flex gap-2 justify-content-center"><a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi Data"><i class="fa fa-check"></i></a><a href="#" class="btn-aksi btn-lihat" title="Lihat Detail"><i class="fa fa-eye"></i></a><a href="#" class="btn-aksi btn-edit" title="Edit Data"><i class="fa fa-edit"></i></a><a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a></div></td></tr>`);}</script>
                      </tbody>
                  </table>
                </div>
            </div>

            <div class="tab-pane fade" id="pengajaran-luar" role="tabpanel">
                <div class="table-responsive">
                  <table class="table table-hover table-bordered">
                      <thead class="table-light">
                          <tr class="text-center"><th>No</th><th class="text-start">Nama</th><th>Tahun Semester</th><th>Kode MK</th><th>Mata Kuliah</th><th>Jumlah Pertemuan</th><th>Institusi</th><th>Program Studi</th><th>Verifikasi</th><th>Dokumen</th><th>Aksi</th></tr>
                      </thead>
                      <tbody>
                          <script>for(let i=1; i<=6; i++){ document.write(`<tr><td class="text-center">${i}</td><td>Alex Kurniawan</td><td class="text-center">2018/2019 Ganjil</td><td class="text-center">MNH211</td><td>Biometrika Hutan</td><td class="text-center">K,S, P,O, R,O</td><td>Universitas Indonesia</td><td>Magos</td><td class="text-center"><i class="fas fa-check-circle text-success"></i></td><td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td><td class="text-center"><div class="d-flex gap-2 justify-content-center"><a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi Data"><i class="fa fa-check"></i></a><a href="#" class="btn-aksi btn-lihat" title="Lihat Detail"><i class="fa fa-eye"></i></a><a href="#" class="btn-aksi btn-edit" title="Edit Data"><i class="fa fa-edit"></i></a><a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a></div></td></tr>`);}</script>
                      </tbody>
                  </table>
                </div>
            </div>

            <div class="tab-pane fade" id="pengujian-lama" role="tabpanel">
                <div class="table-responsive">
                  <table class="table table-hover table-bordered">
                      <thead class="table-light">
                          <tr class="text-center"><th>No</th><th class="text-start">Nama</th><th>Tahun Semester</th><th>NIM</th><th>Nama Mahasiswa</th><th>Strata</th><th>Departemen</th><th>Status</th><th>Verifikasi</th><th>Dokumen</th><th>Aksi</th></tr>
                      </thead>
                      <tbody>
                          <script>for(let i=1; i<=6; i++){ document.write(`<tr><td class="text-center">${i}</td><td>Alex Kurniawan</td><td class="text-center">2018/2019 Ganjil</td><td class="text-center">E1232019</td><td>Alex Ramdana</td><td class="text-center">S1</td><td>Manajemen Hutan</td><td>Anggota Penguji</td><td class="text-center"><i class="fas fa-check-circle text-success"></i></td><td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td><td class="text-center"><div class="d-flex gap-2 justify-content-center"><a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi Data"><i class="fa fa-check"></i></a><a href="#" class="btn-aksi btn-lihat" title="Lihat Detail"><i class="fa fa-eye"></i></a><a href="#" class="btn-aksi btn-edit" title="Edit Data"><i class="fa fa-edit"></i></a><a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a></div></td></tr>`);}</script>
                      </tbody>
                  </table>
                </div>
            </div>

            <div class="tab-pane fade" id="pembimbing-lama" role="tabpanel">
                <div class="table-responsive">
                  <table class="table table-hover table-bordered">
                      <thead class="table-light">
                          <tr class="text-center"><th>No</th><th class="text-start">Kegiatan</th><th>Nama</th><th>Tahun Semester</th><th>NIM</th><th>Nama Mahasiswa</th><th>Strata</th><th>Departemen</th><th>Status</th><th>Verifikasi</th><th>Dokumen</th><th>Aksi</th></tr>
                      </thead>
                      <tbody>
                          <script>for(let i=1; i<=5; i++){ document.write(`<tr><td class="text-center">${i}</td><td class="text-start">Membimbing dan ikut membimbing..</td><td>Dr. Ir Kevin Ms</td><td class="text-center">2018/2019 Ganjil</td><td class="text-center">E1292019</td><td>Eni Murtini</td><td class="text-center">S1</td><td>Manajemen Hutan</td><td>Pembimbing Pendamping</td><td class="text-center"><i class="fas fa-check-circle text-success"></i></td><td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td><td class="text-center"><div class="d-flex gap-2 justify-content-center"><a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi Data"><i class="fa fa-check"></i></a><a href="#" class="btn-aksi btn-lihat" title="Lihat Detail"><i class="fa fa-eye"></i></a><a href="#" class="btn-aksi btn-edit" title="Edit Data"><i class="fa fa-edit"></i></a><a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a></div></td></tr>`);}</script>
                      </tbody>
                  </table>
                </div>
            </div>

            <div class="tab-pane fade" id="penguji-luar" role="tabpanel">
                <div class="table-responsive">
                  <table class="table table-hover table-bordered">
                      <thead class="table-light">
                          <tr class="text-center"><th>No</th><th class="text-start">Nama</th><th>Tahun Semester</th><th>NIM</th><th>Nama Mahasiswa</th><th>Universitas</th><th>Status</th><th>Verifikasi</th><th>Dokumen</th><th>Aksi</th></tr>
                      </thead>
                      <tbody>
                          <script>for(let i=1; i<=10; i++){ document.write(`<tr><td class="text-center">${i}</td><td>Nama Dosen</td><td class="text-center">Genap 2024</td><td class="text-center">Jurnal</td><td>Siapa nama</td><td>IPB University</td><td>Anggota Penguji</td><td class="text-center"><i class="fas fa-check-circle text-success"></i></td><td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td><td class="text-center"><div class="d-flex gap-2 justify-content-center"><a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi Data"><i class="fa fa-check"></i></a><a href="#" class="btn-aksi btn-lihat" title="Lihat Detail"><i class="fa fa-eye"></i></a><a href="#" class="btn-aksi btn-edit" title="Edit Data"><i class="fa fa-edit"></i></a><a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a></div></td></tr>`);}</script>
                      </tbody>
                  </table>
                </div>
            </div>

            <div class="tab-pane fade" id="pembimbing-luar" role="tabpanel">
                <div class="table-responsive">
                  <table class="table table-hover table-bordered">
                      <thead class="table-light">
                          <tr class="text-center"><th>No</th><th class="text-start">Nama</th><th>Tahun Semester</th><th>NIM</th><th>Nama Mahasiswa</th><th>Universitas</th><th>Status</th><th>Verifikasi</th><th>Dokumen</th><th>Aksi</th></tr>
                      </thead>
                      <tbody>
                          <script>for(let i=1; i<=10; i++){ document.write(`<tr><td class="text-center">${i}</td><td>Nama Dosen</td><td class="text-center">Genap 2024</td><td class="text-center">Jurnal</td><td>Siapa nama</td><td>IPB University</td><td>Pembimbing</td><td class="text-center"><i class="fas fa-check-circle text-success"></i></td><td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td><td class="text-center"><div class="d-flex gap-2 justify-content-center"><a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi Data"><i class="fa fa-check"></i></a><a href="#" class="btn-aksi btn-lihat" title="Lihat Detail"><i class="fa fa-eye"></i></a><a href="#" class="btn-aksi btn-edit" title="Edit Data"><i class="fa fa-edit"></i></a><a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a></div></td></tr>`);}</script>
                      </tbody>
                  </table>
                </div>
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
  </div>

  <footer class="footer-custom">
    <span>© 2025 Forest Management — All Rights Reserved</span>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // === Sidebar Logic ===
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      const toggleSidebarBtn = document.getElementById('toggleSidebar');
      const body = document.body;

      if (toggleSidebarBtn) {
        toggleSidebarBtn.addEventListener('click', function () {
          const isMobile = window.innerWidth <= 991;
          if (isMobile) {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show', sidebar.classList.contains('show'));
          } else {
            sidebar.classList.toggle('hidden');
            body.classList.toggle('sidebar-collapsed');
          }
        });
      }

      if (overlay) {
        overlay.addEventListener('click', function () {
          sidebar.classList.remove('show');
          overlay.classList.remove('show');
        });
      }
      
      // === Date and Time Logic ===
      function updateDateTime() {
        const now = new Date();
        const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false, timeZone: 'Asia/Jakarta' };
        
        document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', dateOptions);
        document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID', timeOptions);
      }
      setInterval(updateDateTime, 1000);
      updateDateTime();
    });
  </script>
</body>
</html>