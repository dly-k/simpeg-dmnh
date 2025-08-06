<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIKEMAH - Editor Kegiatan Penunjang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

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
    .sidebar .menu a i,
    .sidebar .menu button i {
      margin-right: 12px;
      font-size: 16px;
      min-width: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .sidebar .menu a:first-of-type {
      margin-top: 10px;
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
    .sidebar.hidden ~ .navbar-custom { margin-left: 0; }
    
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

    /*akunnn*/
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
    .sidebar.hidden ~ .navbar-custom ~ .title-bar { margin-left: 0; }

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
    .sidebar.hidden ~ .navbar-custom ~ .title-bar ~ .main-content { margin-left: 0; }

    .card {
      border: none; 
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
      border-radius: 0.5rem;
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
    .btn-lihat { background-color: #0dcaf0; border-color: #0dcaf0; }
    .btn-edit { background-color: #ffc107; border-color: #ffc107; }
    .btn-hapus { background-color: #dc3545; border-color: #dc3545; }
    .btn-verifikasi { background-color: #10b981; border-color: #10b981; }

    .btn-tambah {
      background-color: #2d3748;
      color: white;
    }
    .btn-tambah:hover {
      background-color: #1a202c;
      color: white;
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
    .sidebar.hidden ~ .navbar-custom ~ .title-bar ~ .main-content ~ .footer-custom {
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
      .navbar-custom, .title-bar, .main-content, .footer-custom { margin-left: 0; }
      .time-date { flex-direction: column; gap: 6px; align-items: flex-start; }
      .account span { font-size: 12px; }
      .sidebar .menu a, .sidebar .menu button { font-size: 12.5px; }

      .search-filter-row {
        flex-direction: column;
        align-items: stretch;
      }
      .search-box,
      .filter-select {
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
          <a href="/pendidikan" aria-label="Pendidikan">Pendidikan</a>
          <a href="/penelitian" aria-label="Penelitian">Penelitian</a>
          <a href="/pengabdian" aria-label="Pengabdian">Pengabdian</a>
          <a href="/penunjang" aria-label="Penunjang" class="active">Penunjang</a>
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

  <div class="title-bar">
    <h1><i class="lni lni-pencil-alt"></i> <span id="page-title">Editor Kegiatan - Penunjang</span></h1>
  </div>

  <div class="main-content">
      <div class="card">
          <div class="search-filter-container">
            <div class="search-filter-row">
                <div class="search-box">
                  <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-search" style="color: green;"></i></span>
                    <input type="text" class="form-control border-start-0" placeholder="Cari Data ....">
                  </div>
                </div>
                <select class="form-select filter-select"><option selected>Tahun</option><option>2024</option></select>
                <select class="form-select filter-select"><option selected>Lingkup</option></select>
                <select class="form-select filter-select"><option selected>Verifikasi</option></select>
                <div class="btn-tambah-container">
                  <a href="#" class="btn btn-tambah fw-bold" onclick="openModal('penunjangModal')"><i class="fa fa-plus me-2"></i> Tambah Data</a>
                </div>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>No</th>
                        <th class="text-start">Kegiatan</th>
                        <th>Lingkup</th>
                        <th>Nama</th>
                        <th>Instansi</th>
                        <th>Nomor SK</th>
                        <th>TMT</th>
                        <th>TST</th>
                        <th>Verifikasi</th>
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
                                  <td class="text-start">Pengaruh Air Terhadap Tumbuh Kembang Lele</td>
                                  <td class="text-center">Nasional</td>
                                  <td class="text-center">Jurnal</td>
                                  <td class="text-center">Ya</td>
                                  <td class="text-center">SK-129013a7uw</td>
                                  <td class="text-center">25 Jun 2024</td>
                                  <td class="text-center">25 Jun 2024</td>
                                  <td class="text-center">${i % 2 === 0 ? '<i class="fas fa-check-circle text-success"></i>' : '<i class="fas fa-times-circle text-danger"></i>'}</td>
                                  <td class="text-center"><a href="#" class="btn btn-sm btn-info text-white">Lihat</a></td>
                                  <td class="text-center">
                                      <div class="d-flex gap-2 justify-content-center">
                                          <a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi Data"><i class="fa fa-check"></i></a>
                                          <a href="#" class="btn-aksi btn-lihat" title="Lihat Detail"><i class="fa fa-eye"></i></a>
                                          <a href="#" class="btn-aksi btn-edit" title="Edit Data" onclick="openEditModal()"><i class="fa fa-edit"></i></a>
                                          <a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a>
                                      </div>
                                  </td>
                              </tr>
                          `);
                      }
                    </script>
                </tbody>
            </table>
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
  
  <div class="modal-backdrop" id="penunjangModal">
        <div class="modal-content-wrapper">
            <div class="modal-header-custom">
                <h5 id="modalTitle"><i class="fas fa-plus-circle"></i> Tambah Data Penunjang</h5>
            </div>
            <div class="modal-body-custom">
                <form id="penunjangForm">
                    <div class="row g-3">
                        <div class="col-12"><label class="form-label">Kegiatan</label><input type="text" class="form-control" placeholder="Lorem Ipsum"></div>
                        <div class="col-12"><label class="form-label">Jenis Kegiatan Penunjang Lainnya</label><input type="text" class="form-control" placeholder="Lorem Ipsum"></div>
                        <div class="col-12"><label class="form-label">Lingkup</label><input type="text" class="form-control" placeholder="Lorem Ipsum"></div>
                        <div class="col-12"><label class="form-label">Nama Kegiatan</label><input type="text" class="form-control" placeholder="Lorem Ipsum"></div>
                        <div class="col-12"><label class="form-label">Instansi</label><input type="text" class="form-control" placeholder="Lorem Ipsum"></div>
                        <div class="col-12"><label class="form-label">Nomor SK</label><input type="text" class="form-control" placeholder="Melaksanakan Perkuliahan/Tutorial/Perkuliahan Praktikum & Membimbing...."></div>
                        <div class="col-md-6"><label class="form-label">Terhitung Mulai Tanggal</label><input type="date" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Terhitung Sampai Tanggal</label><input type="date" class="form-control"></div>
                        
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0">Dokumen</label>
                                <button type="button" class="btn btn-sm btn-primary" onclick="addDokumen()">+ Tambah Dokumen</button>
                            </div>
                            <div id="dokumen-list">
                                </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0">Anggota Kegiatan</label>
                                <button type="button" class="btn btn-sm btn-primary" onclick="addAnggota()">+ Tambah Anggota</button>
                            </div>
                            <div id="anggota-list">
                                </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn btn-danger" onclick="closeModal('penunjangModal')">Batal</button>
                <button type="button" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // === Sidebar Logic ===
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      const toggleSidebarBtn = document.getElementById('toggleSidebar');

      if (toggleSidebarBtn) {
        toggleSidebarBtn.addEventListener('click', function () {
          const isMobile = window.innerWidth <= 991;
          if (isMobile) {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show', sidebar.classList.contains('show'));
          } else {
            sidebar.classList.toggle('hidden');
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
    
    // === Modal Functions ===
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        const modalTitle = modal.querySelector('#modalTitle');
        modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Penunjang';
        modal.querySelector('form').reset();
        
        document.getElementById('dokumen-list').innerHTML = '';
        document.getElementById('anggota-list').innerHTML = '';

        if (modal) {
            modal.style.display = 'flex';
        }
    }
    
    function openEditModal() {
        const modal = document.getElementById('penunjangModal');
        const modalTitle = modal.querySelector('#modalTitle');
        modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Penunjang';
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
    
    function addDokumen() {
        const list = document.getElementById('dokumen-list');
        const newRow = document.createElement('div');
        newRow.className = 'border rounded p-3 mb-3';
        newRow.innerHTML = `
            <div class="row g-2">
                <div class="col-12">
                    <select class="form-select form-select-sm">
                        <option selected>-- Pilih Jenis Dokumen --</option>
                    </select>
                </div>
                <div class="col-md-4"><input type="text" class="form-control form-control-sm" placeholder="Nama Dokumen"></div>
                <div class="col-md-4"><input type="text" class="form-control form-control-sm" placeholder="Nomor"></div>
                <div class="col-md-4"><input type="text" class="form-control form-control-sm" placeholder="Tautan"></div>
                <div class="col-12">
                    <div class="upload-area" style="padding: 1rem;">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p class="mb-0"><small>Drag & Drop File / Max 5 MB</small></p>
                        <input type="file" hidden>
                    </div>
                </div>
            </div>
             <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="this.parentElement.remove()"><i class="fa fa-trash"></i> Hapus Dokumen</button>
        `;
        list.appendChild(newRow);
    }
    
    function addAnggota() {
        const list = document.getElementById('anggota-list');
        const newRow = document.createElement('div');
        newRow.className = 'input-group mb-2';
        newRow.innerHTML = `
            <input type="text" class="form-control" placeholder="Nama Dosen">
            <select class="form-select">
                <option selected>-- Pilih Salah Satu Peran --</option>
            </select>
            <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()"><i class="fa fa-trash"></i></button>
        `;
        list.appendChild(newRow);
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