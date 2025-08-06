<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIKEMAH - Daftar Pegawai</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #049466;
      --primary-light: #e3f7ec;
      --border-color: #e2e8f0;
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
    .sidebar.hidden {
      transform: translateX(-100%);
    }

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
      padding-bottom: 80px;
      max-height: calc(100vh - 66px);
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
    .sidebar .menu a.active {
      background-color: var(--primary);
      color: #fff;
      font-weight: 600;
      box-shadow: inset 4px 0 0 #034d26;
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
      padding: 9px 35px;
      font-size: 12.5px;
    }
    .sidebar .menu a:first-of-type {
      margin-top: 10px;
    }

    .toggle-icon {
      margin-left: auto;
      transition: transform 0.3s;
    }
    .collapsed .toggle-icon { transform: rotate(-90deg); }

   .overlay {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.4);
      z-index: 1000;
      display: none;
    }
    .overlay.show { display: block; }

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
    body.sidebar-collapsed .navbar-custom {
      margin-left: 0;
    }

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
      background: var(--primary);  /* hijau sesuai tema */
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
    .dropdown-item:hover,
    .dropdown-item:focus {
      background-color: #f0f0f0; /* warna hover abu-abu terang */
      color: #111;               /* warna teks tetap gelap */
      text-decoration: none;
      outline: none;
      box-shadow: none;
    }

    /* Hilangkan efek biru saat diklik/fokus */
    .dropdown-item:active {
      background-color: #e9e9e9;
      color: #111;
    }
    .dropdown-menu {
      margin-top: 5px !important;
      padding: 0;               /* Hapus padding agar elemen menempel */
      overflow: hidden;         /* Pastikan tidak terpotong */
      border-radius: 0.375rem;  /* Tetap rounded */
    }

    .dropdown-item {
      padding: 10px 16px;       /* Sedikit lebih kecil dari default */
      font-size: 13px;
    }

    .dropdown-divider {
      margin: 0;                /* Hapus margin atas-bawah garis */
    }

    .dropdown-item-danger {
      color: #dc3545;
    }

    .dropdown-item-danger:hover,
    .dropdown-item-danger:focus {
      color: #fff;
      background-color: #dc3545;
    }
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
     body.sidebar-collapsed .title-bar {
      margin-left: 0;
    }

    .title-bar h1 {
      font-size: 20px;
      margin: 0;
      display: flex;
      align-items: center;
      gap: 12px;
      font-weight: 600;
    }
    .title-bar h1 i { font-size: 22px; }

    .main-content {
      margin-left: 250px;
      padding: 25px;
      transition: margin-left 0.3s ease-in-out;
      background-color: #f5f6fa;
      margin-top: 130px;
      font-size: 14px;
      padding-bottom: 70px;
    }
     body.sidebar-collapsed .main-content {
      margin-left: 0;
    }
    
    .table-card {
      background: white;
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
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
    .btn-lihat { background-color: #0dcaf0; border-color: #0dcaf0; }
    .btn-edit { background-color: #ffc107; border-color: #ffc107; }
    .btn-hapus { background-color: #dc3545; border-color: #dc3545; }

    .btn-lihat:hover {
        background-color: #0593b0;
        color: white;
        transform: scale(1.15); /* Sedikit membesar */
        filter: brightness(1.2); /* Mencerahkan warna tombol */
        box-shadow: 0 2px 8px rgba(0,0,0,0.25);
    }

    .btn-edit:hover {
        background-color: #b58802;
        color: white;
        transform: scale(1.15); /* Sedikit membesar */
        filter: brightness(1.2); /* Mencerahkan warna tombol */
        box-shadow: 0 2px 8px rgba(0,0,0,0.25);
    }

    .btn-hapus:hover {
        background-color: #a21927;
        color: white;
        transform: scale(1.15); /* Sedikit membesar */
        filter: brightness(1.2); /* Mencerahkan warna tombol */
        box-shadow: 0 2px 8px rgba(0,0,0,0.25);
    }

.btn.fw-bold:hover {
  background-color: #545454; /* ganti sesuai kebutuhan */
  color: #fff;
  transform: scale(1.03); /* contoh efek membesar sedikit */
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); /* bayangan lembut */
  transition: all 0.2s ease-in-out;
}

   .search-group {
  border: 1px solid #e2e8f0; /* abu terang */
  border-radius: .5rem;
  background-color: white;
  transition: all 0.3s ease;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
}

.search-group:focus-within {
  border-color: var(--primary); /* hijau lembut */
  box-shadow: 0 0 0 2px rgba(4, 148, 102, 0.15); /* glow hijau tipis */
}

.search-group .input-group-text {
  background-color: transparent;
  border: none;
  color: var(--primary); /* hijau */
  font-size: 1rem;
}

.search-group .form-control {
  border: none;
  background-color: transparent;
  color: #2d3748; /* abu gelap */
  font-size: 14px;
}

.search-group .form-control::placeholder {
  color: #a0aec0; /* placeholder abu muda */
  font-weight: 400;
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
    
    /* Modal Styles */
    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0,0,0,0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1050;
        padding: 1rem;
    }
    .modal-content-wrapper {
        background-color: #fff;
        border-radius: .5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,.5);
        width: 100%;
        max-width: 800px;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
    }
    .modal-header-custom {
        background: linear-gradient(to right, #059669, #047857);
        color: white;
        padding: 1.25rem;
        border-top-left-radius: .5rem;
        border-top-right-radius: .5rem;
    }
    .modal-header-custom h5 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .modal-body-custom {
        padding: 1.5rem;
        overflow-y: auto;
    }
    .modal-footer-custom {
        padding: 1rem;
        display: flex;
        justify-content: flex-end;
        gap: .5rem;
        border-top: 1px solid #e2e8f0;
    }

    /* Responsive */
    @media (max-width: 991px) {
      .sidebar { transform: translateX(-100%); }
      .sidebar.show { transform: translateX(0); }
      .navbar-custom, .title-bar, .main-content, .footer-custom { margin-left: 0 !important; }
      .main-wrapper { margin-left: 0; }
      .time-date { flex-direction: column; gap: 6px; align-items: flex-start; }
      .account span { font-size: 12px; }
      .sidebar .menu a, .sidebar .menu button { font-size: 12.5px; }
    }
  </style>
</head>
<body>

<div class="layout">
  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="brand">SI<span>KEMAH</span></div>
    <div class="menu-wrapper">
      <div class="menu">
        <a href="/dashboard" aria-label="Dashboard"><i class="lni lni-grid-alt"></i> Dashboard</a>
        <p>Menu Utama</p>
        <a href="/daftar-pegawai" aria-label="Daftar Pegawai" class="active"><i class="lni lni-users"></i> Daftar Pegawai</a>
        <a href="/surat-tugas" aria-label="Manajemen Surat Tugas"><i class="lni lni-folder"></i> Manajemen Surat Tugas</a>
        <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#editorKegiatan" aria-expanded="false" aria-controls="editorKegiatan">
          <i class="lni lni-pencil-alt"></i> Editor Kegiatan
          <i class="lni lni-chevron-down toggle-icon"></i>
        </button>
        <div class="collapse submenu" id="editorKegiatan">
          <a href="/pendidikan" aria-label="Pendidikan">Pendidikan</a>
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

  <!-- Overlay -->
  <div class="overlay" id="overlay"></div>

  <div class="main-wrapper">
    <!-- Navbar -->
    <div class="navbar-custom">
      <div class="d-flex align-items-center">
        <button class="btn btn-link text-dark me-3" id="toggleSidebar" aria-label="Toggle Sidebar">
          <i class="lni lni-menu"></i>
        </button>
      </div>
      <div class="d-flex align-items-center">
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
    </div>

    <!-- Title Bar -->
    <div class="title-bar">
      <h1><i class="lni lni-users"></i> <span id="page-title">Daftar Pegawai</span></h1>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <div class="table-card">
        <!-- Top Action Bar -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
      
      <!-- Left side: Search & Filter -->
      <div class="d-flex align-items-center flex-wrap gap-2 flex-grow-1" style="min-width: 0;">
        
        <!-- Search Input -->
        <div class="search-group flex-grow-1">
          <div class="input-group bg-white shadow-sm" style="border-radius: .5rem; min-width: 180px;">
            <span class="input-group-text bg-light border-end-0">
              <i class="lni lni-search-alt small"></i>
            </span>
            <input type="text" 
                  class="form-control form-control-sm bg-transparent border-0" 
                  placeholder="Cari Data...">
          </div>
        </div>

        <!-- Filter Status Pegawai -->
        <div style="min-width: 120px;">
          <select class="form-select form-select-sm w-100">
            <option selected disabled>Status</option>
            <option value="aktif">Aktif</option>
            <option value="pensiun">Pensiun</option>
            <option value="diberhentikan">Diberhentikan</option>
            <option value="meninggal">Meninggal</option>
            <option value="kontrak_selesai">Kontrak Selesai</option>
            <option value="mengundurkan_diri">Mengundurkan Diri</option>
            <option value="mutasi">Mutasi</option>
            <option value="nonaktif">Nonaktif</option>
          </select>
        </div>

        <!-- Filter Kepegawaian -->
        <div style="min-width: 180px;">
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

      <!-- Right side: Add Data Button -->
      <div>
        <button class="btn btn-sm fw-bold" style="background-color: #2d3748; color: white;" onclick="openModal('pegawaiModal')">
          <i class="fa fa-plus me-2"></i> Tambah Data
        </button>
      </div>
    </div>


        <!-- Table -->
        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead class="table-light">
              <tr class="text-center">
                <th>No</th>
                <th class="text-start">Nama Lengkap</th>
                <th>NIP</th>
                <th>Status Kepegawaian</th>
                <th>Jabatan Fungsional</th>
                <th>Jabatan Struktural</th>
                <th>Pangkat/Gol</th>
                <th>Status Pegawai</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <script>
                const data = [
                  { name: 'Joko Anwar S.pd', nip: '194909061979031001', status_kepegawaian: 'Dosen tetap', jabatan_fungsional: 'Lektor', jabatan_struktural: 'Ketua Departemen', pangkat: 'Penata Muda / III-a', status_pegawai: 'Meninggal' },
                  { name: 'Dr. Soni Trison, S.Hut, M.Si', nip: '197801012003121002', status_kepegawaian: 'Dosen PNS', jabatan_fungsional: 'Lektor Kepala', jabatan_struktural: 'Kepala Divisi', pangkat: 'Pembina / IV-a', status_pegawai: 'Aktif' },
                  { name: 'Ria Kodariah, S.Si', nip: '198103152005012001', status_kepegawaian: 'Tendik Tetap', jabatan_fungsional: '-', jabatan_struktural: 'Staf Administrasi', pangkat: 'Pengatur / II-c', status_pegawai: 'Pensiun' },
                  { name: 'Meli Surnami', nip: '198505202015042001', status_kepegawaian: 'Tendik Tetap', jabatan_fungsional: '-', jabatan_struktural: 'Staf Keuangan', pangkat: 'Penata Muda / III-a', status_pegawai: 'Nonaktif' },
                ];
                
                data.forEach((item, index) => {
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
                        <span class="badge 
                          ${item.status_pegawai === 'Aktif' ? 'text-bg-success' : 
                            item.status_pegawai === 'Pensiun' ? 'text-bg-warning' :
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
                          <a href="/detail-pegawai" class="btn-aksi btn-lihat" title="Lihat Detail">
                            <i class="fa fa-eye"></i>
                          </a>
                         <button class="btn btn-aksi btn-edit" title="Edit" onclick='openEditModal(${JSON.stringify(item)})'><i class="lni lni-pencil-alt"></i></button>
                          <a href="#" class="btn-aksi btn-hapus" title="Hapus Data">
                            <i class="fa fa-trash"></i>
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
        <span class="text-muted small mb-2 mb-md-0">Menampilkan 4 dari 13 data</span>
        <nav aria-label="Page navigation">
          <ul class="pagination pagination-sm mb-0">
            <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">Berikutnya</a></li>
          </ul>
        </nav>
      </div>


    <!-- Footer -->
    <footer class="footer-custom">
      <span>© 2025 Forest Management — All Rights Reserved</span>
    </footer>
  </div>
  
  <!-- Modal Tambah/Edit Pegawai -->
    <div class="modal-backdrop" id="pegawaiModal">
        <div class="modal-content-wrapper">
            <div class="modal-header-custom">
                <h5 id="modalTitle"><i class="fas fa-plus-circle"></i> Tambah Data Pegawai</h5>
            </div>
            <div class="modal-body-custom">
                <form id="pegawaiForm">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Nama Lengkap</label><input type="text" class="form-control" name="name"></div>
                        <div class="col-md-6"><label class="form-label">NIP</label><input type="text" class="form-control" name="nip"></div>
                        <div class="col-md-6"><label class="form-label">Status Kepegawaian</label><select class="form-select" name="status_kepegawaian"><option>Tenaga Pendidik - Dosen</option><option>Tenaga Kependidikan</option></select></div>
                        <div class="col-md-6"><label class="form-label">Jabatan Fungsional</label><input type="text" class="form-control" name="jabatan_fungsional"></div>
                        <div class="col-md-6"><label class="form-label">Jabatan Struktural</label><input type="text" class="form-control" name="jabatan_struktural"></div>
                        <div class="col-md-6"><label class="form-label">Pangkat/Golongan</label><input type="text" class="form-control" name="pangkat"></div>
                        <div class="col-md-6"><label class="form-label">Status Pegawai</label><select class="form-select" name="status_pegawai"><option value="Aktif">Aktif</option><option value="Nonaktif">Nonaktif</option></select></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn btn-danger" onclick="closeModal('pegawaiModal')">Batal</button>
                <button type="button" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
 const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const toggleSidebarBtn = document.getElementById('toggleSidebar');
  const body = document.body;

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

  document.addEventListener("DOMContentLoaded", function() {
  const editorBtn = document.querySelector('[data-bs-target="#editorKegiatan"]');
  const editorMenu = document.getElementById("editorKegiatan");

  editorBtn.classList.remove("collapsed");
  editorBtn.setAttribute("aria-expanded", "true");
  editorMenu.classList.add("show");
});

    overlay.addEventListener('click', function () {
      sidebar.classList.remove('show');
      overlay.classList.remove('show');
    });

    function updateDateTime() {
      const now = new Date();
      const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
      document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', options);
      document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID', { 
        hour: '2-digit', 
        minute: '2-digit', 
        second: '2-digit'
      });
    }
    setInterval(updateDateTime, 1000);
    updateDateTime();
    
    // Modal Functions
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        const modalTitle = modal.querySelector('#modalTitle');
        modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Pegawai';
        modal.querySelector('form').reset();
        if (modal) {
            modal.style.display = 'flex';
        }
    }
    
    function openEditModal(data) {
        const modal = document.getElementById('pegawaiModal');
        const modalTitle = modal.querySelector('#modalTitle');
        modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Pegawai';
        
        // Populate form
        const form = modal.querySelector('form');
        form.querySelector('[name="name"]').value = data.name;
        form.querySelector('[name="nip"]').value = data.nip;
        form.querySelector('[name="status_kepegawaian"]').value = data.status_kepegawaian;
        form.querySelector('[name="jabatan_fungsional"]').value = data.jabatan_fungsional;
        form.querySelector('[name="jabatan_struktural"]').value = data.jabatan_struktural;
        form.querySelector('[name="pangkat"]').value = data.pangkat;
        form.querySelector('[name="status_pegawai"]').value = data.status_pegawai;

        if (modal) {
            modal.style.display = 'flex';
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
        }
    }

    // Close modal if backdrop is clicked
    window.onclick = function(event) {
        if (event.target.classList.contains('modal-backdrop')) {
            closeModal(event.target.id);
        }
    }
  </script>
</body>
</html>
