<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIKEMAH - Kerjasama</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
      /* === Root Variables === */
      :root {
        /* Brand Colors */
        --primary: #049466;
        --primary-hover: #037856;
        --primary-light: #e3f7ec;

        --info: #03b9de;
        --info-hover: #0aa6c6;

        --warning: #ffc107;
        --warning-hover: #d39e00;

        --danger: #dc3545;
        --danger-hover: #b02a37;

        --dark: #2d3748;
        --dark-hover: #1f2937;

        /* Neutral Colors */
        --light: #f5f6fa;
        --gray: #6c757d;
        --white: #ffffff;
        --border-color: #bbb;
        --shadow: rgba(0,0,0,0.05);
      }

      /* === Global === */
      body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        background-color: var(--light);
        font-size: 14px;
        color: var(--dark);
      }
      /* Sidebar */
      .sidebar {
        width: 250px;
        height: 100vh;
        background-color: var(--white);
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
        box-shadow: inset 3px 0 0 var(--primary);
      }
      .sidebar .menu a.active {
        background-color: var(--primary);
        color: var(--white);
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

      /* === Sidebar Toggle Overlay (Mobile) === */
      .overlay {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.4);
        z-index: 1000;
        display: none;
      }
      .overlay.show { display: block; }

      .toggle-icon {
        margin-left: auto;
        transition: transform 0.3s;
      }
      .collapsed .toggle-icon { transform: rotate(-90deg); }

      /* === Navbar === */
      .navbar-custom {
        height: 66px;
        background: var(--white);
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

      /* === Title Bar === */
      .title-bar {
        background: linear-gradient(to right, var(--primary), var(--primary-hover));
        color: var(--white);
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
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
      }
      .title-bar h1 i { font-size: 22px; }

      /* === Main Content === */
      .main-content {
        margin: 130px 0 70px 250px;
        padding: 25px;
        background-color: var(--light);
        transition: margin-left 0.3s ease-in-out;
      }
      .sidebar.hidden ~ .navbar-custom ~ .title-bar ~ .main-content {
        margin-left: 0;
      }

      /* === Footer === */
      .footer-custom {
        background: var(--white);
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

      /* === Top Action Bar === */
      .top-action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
      }

      /* === Card & Table === */
      .card {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 0.1rem 0.5rem rgba(0,0,0,0.075);
      }

      .table {
        vertical-align: middle;
        font-size: 12px;
      }
      .table th {
        font-weight: 600;
        text-align: center !important;
        vertical-align: middle !important;
      }
      .table td, .table th {
        padding: 1rem;
      }
      .table-hover > tbody > tr:hover {
        background-color: var(--light);
      }

      /* === Pagination === */
      .pagination .page-item.active .page-link {
        background-color: var(--primary);
        border-color: var(--primary);
        color: var(--white);
      }
      .pagination .page-link {
        color: var(--primary);
      }
      .pagination .page-link:hover {
        background-color: var(--primary-light);
      }
      .pagination .page-item.disabled .page-link {
        color: var(--gray);
      }

      /* === Buttons === */
      .btn-aksi {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        color: var(--white);
        transition: all 0.2s ease-in-out;
      }

      /* Info */
      .btn-lihat, .btn-lihat-detail {
        background-color: var(--info);
        color: var(--white);
          transition: all 0.3s ease;
      }
      .btn-lihat:hover, .btn-lihat-detail:hover {
        background-color: var(--info-hover);
        color: var(--white);
        transform: scale(1.15); /* Sedikit membesar */
      }

      /* Warning */
      .btn-edit-row {
        background-color: var(--warning);
        transition: all 0.3s ease;
      }
      .btn-edit-row:hover {
        background-color: var(--warning-hover);
        color: var(--white);
        transform: scale(1.15); /* Sedikit membesar */
      }

      /* Danger */
      .btn-delete-row {
        background-color: var(--danger);
        color: var(--white);
        transition: all 0.3s ease;
      }
      .btn-delete-row:hover {
        background-color: var(--danger-hover);
        color: var(--white);
        transform: scale(1.15); /* Sedikit membesar */
      }

      /* Dark */
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

      /* Primary */
      .btn-export {
        background-color: var(--primary);
        color: var(--white);
        transition: all 0.3s ease;
      }
      .btn-export:hover {
        background-color: var(--primary-hover);
        color: var(--white);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
      }

      /* Placeholder abu/transparan */
      .search-input::placeholder {
        color: rgba(0, 0, 0, 0.4); /* Abu-abu muda */
        opacity: 1; /* Pastikan placeholder terlihat */
      }

      /* === Modal === */
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
        background-color: var(--white);
        border-radius: .5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,.5);
        width: 100%;
        max-width: 800px;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
      }
      .modal-header-custom {
        background: linear-gradient(to right, var(--primary), var(--primary-hover));
        color: var(--white);
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
      .modal-footer-custom .btn:hover {
        filter: brightness(1.1);
      }

      /* === File Upload Area === */
      .upload-area {
        border: 2px dashed #dee2e6;
        border-radius: .5rem;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: background-color 0.2s;
      }
      .upload-area:hover {
        background-color: var(--light);
      }
      .upload-area i {
        font-size: 2rem;
        color: var(--gray);
      }
      .upload-area p {
        margin-top: 1rem;
        color: var(--gray);
      }

      /* === Account & Dropdown === */
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
        color: var(--white);
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
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
        min-width: 24px;
        text-align: center;
      }
      .dropdown-item:hover,
      .dropdown-item:focus {
        background-color: var(--light);
        color: var(--dark);
        text-decoration: none;
        outline: none;
        box-shadow: none;
      }
      .dropdown-item:active {
        background-color: #e9e9e9;
        color: var(--dark);
      }
      .dropdown-divider { margin: 0; }
      .dropdown-item-danger {
        color: var(--danger);
      }
      .dropdown-item-danger:hover,
      .dropdown-item-danger:focus {
        background-color: var(--danger);
        color: var(--white);
      }

      /* === Time & Date === */
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
      .time-date i {
        color: #4b5563;
        font-size: 13px;
      }

      /* === Responsive === */
      @media (max-width: 1200px) {
        .top-action-bar {
          flex-direction: column;
          align-items: stretch !important;
        }
      }
      @media (max-width: 991px) {
        .sidebar { transform: translateX(-100%); }
        .sidebar.show { transform: translateX(0); }

        .navbar-custom,
        .title-bar,
        .main-content,
        .footer-custom {
          margin-left: 0 !important;
        }

        .time-date {
          flex-direction: column;
          gap: 6px;
          align-items: flex-start;
        }

        .account span { font-size: 12px; }
        .sidebar .menu a,
        .sidebar .menu button {
          font-size: 12.5px;
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
        <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#editorKegiatan" aria-expanded="true" aria-controls="editorKegiatan">
          <i class="lni lni-pencil-alt"></i> Editor Kegiatan
          <i class="lni lni-chevron-down toggle-icon"></i>
        </button>
        <div class="collapse show submenu" id="editorKegiatan">
          <a href="/pendidikan" aria-label="Pendidikan">Pendidikan</a>
          <a href="/penelitian" aria-label="Penelitian">Penelitian</a>
          <a href="/pengabdian" aria-label="Pengabdian">Pengabdian</a>
          <a href="/penunjang" aria-label="Penunjang">Penunjang</a>
          <a href="/pelatihan" aria-label="Pelatihan">Pelatihan</a>
          <a href="/penghargaan" aria-label="Penghargaan">Penghargaan</a>
          <a href="/sk-non-pns" aria-label="SK Non PNS">SK Non PNS</a>
        </div>
        <a href="/kerjasama" aria-label="Kerjasama" class="active"><i class="lni lni-handshake"></i> Kerjasama</a>
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
        <div><i class="lni lni-calendar"></i> <span id="current-date">Selasa, 5 Agustus 2025</span></div>
        <div><i class="lni lni-timer"></i> <span id="current-time">10:20:45</span></div>
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
    <h1><i class="lni lni-handshake"></i> <span id="page-title">Kerjasama</span></h1>
  </div>

 <div class="main-content">
  <div class="card">
    <div class="card-body p-4">

      <!-- TOP ACTION BAR DIPINDAHKAN KE SINI -->
      <div class="top-action-bar d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3 flex-grow-1">
        <div class="input-group search-box" style="min-width: 280px;">
          <span class="input-group-text bg-light border-end-0">
            <i class="fas fa-search" style="color: green;"></i>
          </span>
          <input type="text" class="form-control border-start-0 search-input" placeholder="Cari Data...">
        </div>
          <select class="form-select" style="width: 180px;">
            <option selected>Semua Jenis</option>
            <option>MoU</option>
            <option>LoA</option>
            <option>SPK</option>
          </select>
        </div>
        <div class="d-flex gap-2">
          <button class="btn btn-export fw-bold"><i class="lni lni-download me-2"></i> Export Excel</button>
          <button class="btn btn-tambah fw-bold" onclick="openModal()"><i class="lni lni-plus me-2"></i> Tambah Data</button>
        </div>
      </div>

      <!-- TABEL -->
      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th class="text-start">Judul</th>
              <th>Mitra/Instansi</th>
              <th>No Dokumen</th>
              <th>Tgl. Dokumen</th>
              <th>Ketua/Anggota Tim</th>
              <th>Lokasi</th>
              <th>Besaran Dana</th>
              <th>Jenis</th>
              <th>Dokumen</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="kerjasamaTableBody">
          </tbody>
        </table>
      </div>

      <!-- PAGINATION -->
      <div class="d-flex justify-content-between align-items-center mt-3">
        <span class="text-muted small">Menampilkan 1 sampai 3 dari 13 data</span>
        <nav>
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
</div>
  
  <div class="modal-backdrop" id="kerjasamaModal">
    <div class="modal-content-wrapper">
      <div class="modal-header-custom">
        <h5 id="modalTitle"><i class="fas fa-plus-circle"></i> Tambah Kerjasama</h5>
      </div>
      <div class="modal-body-custom">
        <form id="kerjasamaForm">
          <div class="row g-3">
            <div class="col-12"><label class="form-label">Judul</label><input type="text" class="form-control" name="judul" placeholder="Judul Kerjasama"></div>
            <div class="col-12"><label class="form-label">Mitra</label><input type="text" class="form-control" name="mitra" placeholder="Nama Mitra atau Instansi"></div>
            <div class="col-md-6"><label class="form-label">No Dokumen</label><input type="text" class="form-control" name="noDoc" placeholder="Nomor Dokumen"></div>
            <div class="col-md-6"><label class="form-label">Tgl. Dokumen</label><input type="date" name="tglDoc" class="form-control"></div>
            <div class="col-md-6"><label class="form-label">TMT</label><input type="date" class="form-control" name="tmt"></div>
            <div class="col-md-6"><label class="form-label">TST</label><input type="date" class="form-control" name="tst"></div>
            <div class="col-12"><label class="form-label">Departemen/Program Studi</label><select class="form-select" name="departemen"><option selected>-- Pilih Salah Satu --</option><option>Manajemen Hutan</option><option>Konservasi Sumberdaya Hutan</option><option>Teknologi Hasil Hutan</option></select></div>
            <div class="col-12"><label class="form-label">Ketua</label><input type="text" class="form-control" name="ketua" placeholder="Nama Ketua Tim"></div>
            <div class="col-12">
              <label class="form-label">Anggota Tim</label>
              <div id="anggota-list">
                </div>
            </div>
            <div class="col-md-6"><label class="form-label">Lokasi</label><input type="text" name="lokasi" class="form-control" placeholder="Lokasi Kegiatan"></div>
            <div class="col-md-6"><label class="form-label">Besaran Dana</label><input type="number" name="dana" class="form-control" placeholder="Contoh: 10000000"></div>
            <div class="col-12"><label class="form-label">Jenis Kerjasama</label><select class="form-select" name="jenis"><option selected>-- Pilih Salah Satu --</option><option>MoU</option><option>LoA</option><option>SPK</option></select></div>
            <div class="col-12">
              <label class="form-label">Upload File</label>
              <div class="upload-area" id="uploadArea">
                <i class="lni lni-cloud-upload"></i>
                <p>Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small></p>
                <input type="file" hidden>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer-custom">
        <button type="button" class="btn btn-danger" onclick="closeModal()">Batal</button>
        <button type="button" class="btn btn-success">Simpan</button>
      </div>
    </div>
  </div>

  <footer class="footer-custom">
    <span>© 2025 Forest Management — All Rights Reserved</span>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // === Bagian Inisialisasi & Event Listener Utama ===
    document.addEventListener('DOMContentLoaded', function () {
      setupSidebar();
      startDateTimeUpdater();
      renderKerjasamaTable();
    });

    // === Logika Sidebar ===
    function setupSidebar() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      const toggleSidebarBtn = document.getElementById('toggleSidebar');

      toggleSidebarBtn.addEventListener('click', function () {
        const isMobile = window.innerWidth <= 991;
        if (isMobile) {
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
    }

    // === Logika Waktu & Tanggal ===
    function startDateTimeUpdater() {
      const dateEl = document.getElementById('current-date');
      const timeEl = document.getElementById('current-time');
      
      function update() {
        const now = new Date();
        const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
        dateEl.textContent = now.toLocaleDateString('id-ID', dateOptions);
        timeEl.textContent = now.toLocaleTimeString('id-ID', timeOptions);
      }
      setInterval(update, 1000);
      update();
    }

    // === Logika Tabel Kerjasama ===
    function renderKerjasamaTable() {
      const kerjasamaData = [
        { judul: 'Pengembangan Model Hutan Tanaman Cerdas Iklim', mitra: 'Dinas Kehutanan Provinsi Jawa Barat', noDoc: 'MoU/001/AI/24', tglDoc: '2024-04-10', tmt: '2024-05-01', tst: '2025-05-01', departemen: 'Manajemen Hutan', ketua: 'Dr. Anton Jaya Puspita', anggota: ['Dr. Budi Santoso', 'Ir. Rina Melati, M.Sc.'], lokasi: 'Bogor', dana: '150000000', jenis: 'MoU' },
        { judul: 'Analisis Keanekaragaman Hayati di Cagar Alam', mitra: 'Balai Konservasi Sumber Daya Alam (BKSDA)', noDoc: 'LoA/015/BIO/24', tglDoc: '2024-02-20', tmt: '2024-03-01', tst: '2024-09-01', departemen: 'Konservasi Sumberdaya Hutan', ketua: 'Prof. Dr. Endang Sulistyawati', anggota: ['Ahmad Zulkifli, S.Hut.'], lokasi: 'Gunung Gede Pangrango', dana: '75000000', jenis: 'LoA' },
        { judul: 'Pemanfaatan Limbah Kayu untuk Produk Bernilai Tambah', mitra: 'PT. Kayu Sejahtera', noDoc: 'SPK/032/IND/24', tglDoc: '2024-06-05', tmt: '2024-06-10', tst: '2024-12-10', departemen: 'Teknologi Hasil Hutan', ketua: 'Ir. Heru Purnomo, M.T.', anggota: ['Siti Nurbaya, S.T.', 'Joko Widodo, S.T.'], lokasi: 'Jepara', dana: '250000000', jenis: 'SPK' }
      ];

      const tableBody = document.getElementById('kerjasamaTableBody');
      if (!tableBody) return;
      
      let rowsHtml = '';
      kerjasamaData.forEach((item, index) => {
        rowsHtml += `
          <tr>
            <td>${index + 1}</td>
            <td class="text-start" style="min-width: 250px;">${item.judul}</td>
            <td style="min-width: 200px;">${item.mitra}</td>
            <td>${item.noDoc}</td>
            <td>${new Date(item.tglDoc).toLocaleDateString('id-ID', {day: '2-digit', month: 'short', year: 'numeric'})}</td>
            <td class="text-start" style="min-width: 250px;"><b>Ketua:</b> ${item.ketua}<br><b>Anggota:</b> ${item.anggota.join(', ')}</td>
            <td>${item.lokasi}</td>
            <td class="text-end">${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.dana)}</td>
            <td><span class="badge text-bg-light border">${item.jenis}</span></td>
            <td class="text-center">
              <button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button>
            </td>
            <td>
              <div class="d-flex gap-2 justify-content-center">
                <button class="btn btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="fa fa-eye"></i></button>
                <button class="btn btn-aksi btn-edit-row" title="Edit" onclick='openEditModal(${JSON.stringify(item)})'><i class="fa fa-edit"></i></button>
                <button class="btn btn-aksi btn-delete-row" title="Hapus"><i class="fa fa-trash"></i></button>
              </div>
            </td>
          </tr>
        `;
      });
      tableBody.innerHTML = rowsHtml;
    }

    // === Logika Modal Umum ===
    const kerjasamaModalEl = document.getElementById('kerjasamaModal');
    function closeModal() {
        if (kerjasamaModalEl) kerjasamaModalEl.style.display = 'none';
    }
    window.onclick = function(event) {
      if (event.target === kerjasamaModalEl) closeModal();
    }

    // --- Buka Modal untuk Tambah Data ---
    function openModal() {
      const modalTitle = kerjasamaModalEl.querySelector('#modalTitle');
      const form = kerjasamaModalEl.querySelector('form');
      
      modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Kerjasama';
      form.reset();
      setupAnggotaList([]); // Siapkan daftar anggota kosong
      kerjasamaModalEl.style.display = 'flex';
    }

    // --- Buka Modal untuk Edit Data ---
    function openEditModal(data) {
      const modalTitle = kerjasamaModalEl.querySelector('#modalTitle');
      const form = kerjasamaModalEl.querySelector('form');

      modalTitle.innerHTML = '<i class="lni lni-pencil-alt"></i> Edit Kerjasama';
      
      // Isi form dengan data yang ada
      for (const key in data) {
        if (Object.hasOwnProperty.call(data, key) && key !== 'anggota') {
          const field = form.querySelector(`[name="${key}"]`);
          if (field) field.value = data[key];
        }
      }
      setupAnggotaList(data.anggota || []);
      kerjasamaModalEl.style.display = 'flex';
    }

    // === Logika Daftar Anggota Tim di Modal ===
    function setupAnggotaList(members = []) {
      const listContainer = document.getElementById('anggota-list');
      listContainer.innerHTML = ''; 

      // Tambahkan baris untuk setiap anggota yang sudah ada
      members.forEach(member => createAnggotaRow(listContainer, member));
      
      // Tambahkan baris kosong di akhir untuk menambah anggota baru
      createAnggotaRow(listContainer, '', true);
    }

    function createAnggotaRow(container, name, isAdder) {
      const row = document.createElement('div');
      row.className = 'input-group mb-2';
      const buttonHtml = isAdder
        ? `<button class="btn btn-outline-success" type="button" onclick="addNewAnggotaField(this)">+</button>`
        : `<button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">-</button>`;
      
      row.innerHTML = `<input type="text" class="form-control" placeholder="Nama Anggota" value="${name}">${buttonHtml}`;
      container.appendChild(row);
    }

    function addNewAnggotaField(addButton) {
      const row = addButton.parentElement;
      const input = row.querySelector('input');
      if (input.value.trim() === '') {
        input.focus();
        return;
      }
      // Ubah tombol '+' menjadi '-'
      addButton.outerHTML = `<button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">-</button>`;
      // Tambahkan baris baru dengan tombol '+'
      createAnggotaRow(document.getElementById('anggota-list'), '', true);
      document.getElementById('anggota-list').lastElementChild.querySelector('input').focus();
    }
  </script>
</body>
</html>