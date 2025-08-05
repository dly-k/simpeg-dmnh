<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIKEMAH - Master Data</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary: #049466;
      --primary-light: #e3f7ec;
      --border-color: #bbb;
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
      transform: translateX(0); /* Default aktif di desktop */
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
    .sidebar .menu > a:first-of-type {
      margin-top: 10px;
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

    .account {
      display: flex;
      align-items: center;
      font-size: 13px;
      font-weight: 400;
      cursor: pointer;
      margin-left: 10px;
      gap: 6px;
    }
    .account-circle {
      background: orange;
      color: #fff;
      border-radius: 50%;
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 12px;
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
      min-height: calc(100vh - 190px);
      margin-top: 130px;
      font-size: 14px;
    }
    .sidebar.hidden ~ .navbar-custom ~ .title-bar ~ .main-content { margin-left: 0; }
    
    .card { 
      border: none; 
      box-shadow: 0 0.1rem 0.5rem rgba(0,0,0,.075); 
      border-radius: .5rem;
      margin-bottom: 80px;
    }
      
    .table {
      text-align: center;
      vertical-align: middle;
    }
      
    .table th { 
      font-weight: 600; 
      background-color: #f8f9fa; 
    }
    
    .table td, .table th { 
      padding: 1rem; 
    }
    
    .table-hover > tbody > tr:hover {
      background-color: #f8f9fa;
    }

    .btn-aksi {
      width: 32px; height: 32px; border-radius: 6px !important;
      display: inline-flex;
      align-items: center; justify-content: center; padding: 0;
      color: white;
    }
    
    .btn-edit-row { background-color: #ffc107; border-color: #ffc107; }
    .btn-delete-row { background-color: #dc3545; border-color: #dc3545; }
      
    .btn-tambah {
      background-color: #2d3748;
      color: white;
      border: none;
    }

    .btn-tambah:hover{
        background-color: #1a202c;
        color: white;
    }

    .btn-edit-row:hover {
    background-color: #b58802;
    color: white;
    transform: scale(1.15); /* Sedikit membesar */
    filter: brightness(1.2); /* Mencerahkan warna tombol */
    box-shadow: 0 2px 8px rgba(0,0,0,0.25);
    }

    .btn-delete-row:hover {
    background-color: #a21927;
    color: white;
    transform: scale(1.15); /* Sedikit membesar */
    filter: brightness(1.2); /* Mencerahkan warna tombol */
    box-shadow: 0 2px 8px rgba(0,0,0,0.25);
    }

    .pagination .page-item.active .page-link { 
      background-color: #059669; 
      border-color: #059669; 
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
      max-width: 600px;
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

    /* Responsive */
    @media (max-width: 991px) {
      .sidebar { transform: translateX(-100%); }
      .sidebar.show { transform: translateX(0); }
      .navbar-custom, .title-bar, .main-content, .footer-custom { margin-left: 0; }
      .main-content { margin-top: 130px; font-size: 13px; }
      .title-bar h1 { font-size: 18px; }
      .time-date { flex-direction: column; gap: 6px; align-items: flex-start; }
      .account span { font-size: 12px; }
      .sidebar .menu a, .sidebar .menu button { font-size: 12.5px; }
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
        <a href="/kerjasama" aria-label="Kerjasama"><i class="lni lni-handshake"></i> Kerjasama</a>
        <a href="/master-data" aria-label="Master Data" class="active"><i class="lni lni-database"></i> Master Data</a>
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
      <div class="account">
        <div class="account-circle">KTU</div>
        <span>Halo, Ketua TU</span>
        <i class="lni lni-chevron-down"></i>
      </div>
    </div>
  </div>

  <div class="title-bar">
    <h1><i class="lni lni-database"></i> <span id="page-title">Master Data</span></h1>
  </div>

  <div class="main-content">
    <div class="d-flex justify-content-end mb-3">
      <button class="btn btn-tambah fw-bold" onclick="openModal('tambahDataModal')"><i class="lni lni-plus me-2"></i> Tambah Data</button>
    </div>

    <div class="card">
      <div class="card-body p-4">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th class="text-start">Nama Pegawai</th>
                <th>ID Pengguna</th>
                <th>Password</th>
                <th>Hak Akses</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody id="userDataBody">
              </tbody>
          </table>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-3">
          <span class="text-muted small">Menampilkan 1 sampai 4 dari 13 data</span>
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

  <div class="modal-backdrop" id="tambahDataModal">
    <div class="modal-content-wrapper">
      <div class="modal-header-custom">
        <h5><i class="lni lni-plus-circle"></i> Tambah Data Pengguna</h5>
      </div>
      <div class="modal-body-custom">
        <form>
          <div class="mb-3"><label class="form-label">Nama Pegawai</label><select class="form-select"><option selected>-- Pilih Salah Satu --</option><option>Dr. Soni Trison, S.Hut, M.Si</option><option>Ria Kodariah, S.Si</option></select></div>
          <div class="mb-3"><label class="form-label">ID Pengguna</label><input type="text" class="form-control"></div>
          <div class="row">
            <div class="col-md-6 mb-3"><label class="form-label">Hak Akses</label><select class="form-select"><option selected>-- Pilih Salah Satu --</option><option>Admin</option><option>Administrasi Kepegawaian</option></select></div>
            <div class="col-md-6 mb-3"><label class="form-label">Password</label><input type="password" class="form-control"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer-custom">
        <button type="button" class="btn btn-danger" onclick="closeModal('tambahDataModal')">Batal</button>
        <button type="button" class="btn btn-success">Simpan</button>
      </div>
    </div>
  </div>

  <div class="modal-backdrop" id="editDataModal">
    <div class="modal-content-wrapper">
      <div class="modal-header-custom">
        <h5><i class="lni lni-pencil-alt"></i> Edit Data Pengguna</h5>
      </div>
      <div class="modal-body-custom">
        <form>
          <div class="mb-3">
            <label class="form-label">Nama Pegawai</label>
            <select id="editNamaPegawai" class="form-select">
              <option>Dr. Soni Trison, S.Hut, M.Si</option>
              <option>Ria Kodariah, S.Si</option>
              <option>Meli Surnami</option>
              <option>Saeful Rohim</option>
            </select>
          </div>
          <div class="mb-3"><label class="form-label">ID Pengguna</label><input id="editIdPengguna" type="text" class="form-control"></div>
          <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Hak Akses</label>
                <select id="editHakAkses" class="form-select">
                    <option>Admin</option>
                    <option>Administrasi Kepegawaian</option>
                </select>
            </div>
            <div class="col-md-6 mb-3"><label class="form-label">Password <small class="text-muted" style="font-size: 70%">(Kosongkan jika tidak diubah)</small></label><input type="password" class="form-control"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer-custom">
        <button type="button" class="btn btn-danger" onclick="closeModal('editDataModal')">Batal</button>
        <button type="button" class="btn btn-success">Simpan Perubahan</button>
      </div>
    </div>
  </div>

  <footer class="footer-custom">
    <span>© 2025 Forest Management — All Rights Reserved</span>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      const toggleSidebarBtn = document.getElementById('toggleSidebar');

      // --- Sidebar Toggle Logic ---
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

      // --- Date and Time Update ---
      function updateDateTime() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', options);
        document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID', { 
          hour: '2-digit', 
          minute: '2-digit', 
          second: '2-digit',
          hour12: false
        });
      }
      setInterval(updateDateTime, 1000);
      updateDateTime();

      // --- Table Data Rendering ---
      const userData = [
        { name: 'Dr. Soni Trison, S.Hut, M.Si', user: 'Kadep_soni', role: 'Admin' },
        { name: 'Ria Kodariah, S.Si', user: 'Kadep_ria', role: 'Admin' },
        { name: 'Meli Surnami', user: 'Staff_meli', role: 'Administrasi Kepegawaian' },
        { name: 'Saeful Rohim', user: 'Staff_saeful', role: 'Administrasi Kepegawaian' }
      ];

      function renderTable() {
        const tableBody = document.getElementById('userDataBody');
        if (!tableBody) return;

        let tableRowsHtml = '';
        userData.forEach((item, index) => {
          tableRowsHtml += `
            <tr>
              <td>${index + 1}</td>
              <td class="text-start">${item.name}</td>
              <td>${item.user}</td>
              <td>••••••••••</td>
              <td>${item.role}</td>
              <td>
                <div class="d-flex gap-2 justify-content-center">
                  <button class="btn btn-aksi btn-edit-row" title="Edit" onclick="openEditModal('${item.name}', '${item.user}', '${item.role}')"><i class="lni lni-pencil-alt"></i></button>
                  <button class="btn btn-aksi btn-delete-row" title="Hapus"><i class="lni lni-trash-can"></i></button>
                </div>
              </td>
            </tr>
          `;
        });
        tableBody.innerHTML = tableRowsHtml;
      }
      renderTable();
    });

    // --- Modal Functions (Global Scope) ---
    function openModal(modalId) {
      const modal = document.getElementById(modalId);
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

    function openEditModal(nama, user, role) {
      document.getElementById('editNamaPegawai').value = nama;
      document.getElementById('editIdPengguna').value = user;
      document.getElementById('editHakAkses').value = role;
      openModal('editDataModal');
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