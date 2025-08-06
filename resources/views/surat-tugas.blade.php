<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIKEMAH - Manajemen Surat Tugas</title>
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
    .sidebar a[href="/surat-tugas"] {
      font-size: 14px;
    }

    .sidebar a[href="/surat-tugas"]:active,
    .sidebar a[href="/surat-tugas"].active,
    .sidebar a[href="/surat-tugas"]:focus {
      font-size: 12.5px;
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

    
    /* Main Area */
    .main-wrapper {
        flex-grow: 1;
        margin-left: 250px;
        transition: margin-left 0.3s ease-in-out;
        display: flex;
        flex-direction: column;
        height: 100vh;
    }
    .sidebar.hidden ~ .main-wrapper {
        margin-left: 0;
    }

      .main-content {
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
    .btn-lihat { background-color: #0c7e8f; border-color: #0c7e8f; }
    .btn-edit { background-color: #ffc107; border-color: #ffc107; }
    .btn-hapus { background-color: #dc3545; border-color: #dc3545; }

    .btn-lihat:hover {
        background-color: #0a7181;
        color: white;
        transform: scale(1.15); /* Sedikit membesar */
        filter: brightness(1.2); /* Mencerahkan warna tombol */
        box-shadow: 0 2px 8px rgba(0,0,0,0.25);
    }
.btn-export {
  background-color: var(--primary); /* hijau */
  color: white;
  border: none;
}
.btn-export:hover {
  background-color: #04885e !important;
  color: white;
  border: none;
}

.btn-tambah {
  background-color: #2d3748;
  color: white;
  border: none;
}
.btn-tambah:hover {
  background-color: #1a202c !important;
  color: white;
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
     .upload-area {
        border: 2px dashed #dee2e6;
        border-radius: .5rem;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: background-color .2s;
    }
    .upload-area:hover {
        background-color: #f8f9fa;
    }
    .upload-area i {
        font-size: 2rem;
        color: #6c757d;
    }
    .upload-area p {
        margin-top: 1rem;
        color: #6c757d;
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
        <a href="/daftar-pegawai" aria-label="Daftar Pegawai"><i class="lni lni-users"></i> Daftar Pegawai</a>
        <a href="/surat-tugas" aria-label="Manajemen Surat Tugas" class="active"><i class="lni lni-folder"></i> Manajemen Surat Tugas</a>
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

    <!-- Title Bar -->
    <div class="title-bar">
      <h1><i class="lni lni-folder"></i> <span id="page-title">Manajemen Surat Tugas</span></h1>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="table-card">
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

      <!-- Filter Tanggal -->
      <div style="min-width: 120px;">
        <select class="form-select filter-select">
          <option selected>Tahun</option>
          <option>2021</option>
          <option>2022</option>
          <option>2023</option>
        </select>      
      </div>

              <div class="d-flex gap-2">
                  <a href="#" class="btn btn-export fw-bold"><i class="fa fa-file-excel me-2"></i> Export Excel</a>
                  <a href="#" class="btn btn-tambah fw-bold" onclick="openModal('suratTugasModal')"><i class="fa fa-plus me-2"></i> Tambah Data</a>
              </div>
          </div>
      </div>

          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead class="table-light">
                <tr class="text-center">
                  <th>No</th>
                  <th class="text-start">Nama Dosen</th>
                  <th>Peran</th>
                  <th>Diminta Sebagai</th>
                  <th>Mitra/Instansi</th>
                  <th>No & Tgl Surat Instansi</th>
                  <th>No & Tgl Surat Kadep</th>
                  <th>Tgl Kegiatan</th>
                  <th>Ket. Lokasi</th>
                  <th>Dokumen</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <script>
                    const data = [
                        { nama: 'Dr. Stone', peran: 'Dosen', sebagai: 'Penelitian', mitra: 'Pt. Lele Berkumis', surat_instansi: '001/INT/2025 - 1 Juni 2025', surat_kadep: '001/INT/2025 - 1 Juni 2025', tgl_kegiatan: '20 Juni 2021', lokasi: 'Empang Hj Ujang' },
                        { nama: 'Joko Anwar S.pd', peran: 'Dosen', sebagai: 'Pengabdian', mitra: 'Desa Cikoneng', surat_instansi: '002/EXT/2025 - 5 Juni 2025', surat_kadep: '002/EXT/2025 - 6 Juni 2025', tgl_kegiatan: '25 Juli 2021', lokasi: 'Balai Desa' },
                        { nama: 'Ria Kodariah, S.Si', peran: 'Dosen', sebagai: 'Narasumber', mitra: 'Universitas Maju Jaya', surat_instansi: '003/UMJ/2025 - 10 Juni 2025', surat_kadep: '003/UMJ/2025 - 11 Juni 2025', tgl_kegiatan: '1 Agustus 2021', lokasi: 'Auditorium Univ' },
                    ];
                    data.forEach((item, index) => {
                        document.write(`
                            <tr>
                                <td class="text-center">${index + 1}</td>
                                <td>${item.nama}</td>
                                <td class="text-center">${item.peran}</td>
                                <td class="text-center">${item.sebagai}</td>
                                <td>${item.mitra}</td>
                                <td class="text-center">${item.surat_instansi}</td>
                                <td class="text-center">${item.surat_kadep}</td>
                                <td class="text-center">${item.tgl_kegiatan}</td>
                                <td>${item.lokasi}</td>
                                <td class="text-center">
                               <button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button>
                               </td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="#" class="btn-aksi btn-edit" title="Edit Data" onclick="openEditModal()"><i class="fa fa-edit"></i></a>
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

          <div class="d-flex justify-content-between align-items-center mt-3">
            <span class="text-muted small">Menampilkan 3 dari 13 data</span>
            <nav aria-label="Page navigation">
              <ul class="pagination pagination-sm mb-0">
                <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Berikutnya</a></li>
              </ul>
            </nav>
          </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer-custom">
      <span>© 2025 Forest Management — All Rights Reserved</span>
    </footer>
  </div>
  
  <!-- Modal Tambah/Edit Surat Tugas -->
    <div class="modal-backdrop" id="suratTugasModal">
        <div class="modal-content-wrapper">
            <div class="modal-header-custom">
                <h5 id="modalTitle"><i class="fas fa-plus-circle"></i> Tambah Surat Tugas</h5>
            </div>
            <div class="modal-body-custom">
                <form>
                    <div class="row g-3">
                        <div class="col-12"><label class="form-label">Nama Dosen</label><select class="form-select"><option selected>-- Pilih Salah Satu --</option><option>Dr. Stone</option></select></div>
                        <div class="col-12"><label class="form-label">Peran</label><input type="text" class="form-control" placeholder="Masukkan peran. Contoh: Narasumber, Pembicara, Moderator"></div>
                        <div class="col-12"><label class="form-label">Pemohon / Menjadi</label><input type="text" class="form-control" placeholder="2020/2021"></div>
                        <div class="col-12"><label class="form-label">Mitra / Nama Instansi</label><input type="text" class="form-control" placeholder="2020/2021"></div>
                        <div class="col-md-6"><label class="form-label">No & Tanggal Surat Instansi</label><input type="text" class="form-control" placeholder="001/INT/2025 - 1 Juni 2025"></div>
                        <div class="col-md-6"><label class="form-label">No & Tanggal Surat Kadep</label><input type="text" class="form-control" placeholder="001/INT/2025 - 1 Juni 2025"></div>
                        <div class="col-md-6"><label class="form-label">Tanggal Kegiatan</label><input type="date" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Link Surat Tugas Dekan</label><input type="text" class="form-control" placeholder="Praktikum"></div>
                        <div class="col-12"><label class="form-label">Lokasi Kegiatan</label><input type="text" class="form-control" placeholder="Praktikum"></div>
                        <div class="col-12">
                            <label class="form-label">Upload File</label>
                            <div class="upload-area">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Drag & Drop File here<br><small>Ukuran Maksimal 5 MB</small></p>
                                <input type="file" hidden>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn btn-danger" onclick="closeModal('suratTugasModal')">Batal</button>
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
        modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Surat Tugas';
        modal.querySelector('form').reset();
        if (modal) {
            modal.style.display = 'flex';
        }
    }
    
    function openEditModal() {
        const modal = document.getElementById('suratTugasModal');
        const modalTitle = modal.querySelector('#modalTitle');
        modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Surat Tugas';
        // Di sini Anda akan mengisi form dengan data yang ada
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
