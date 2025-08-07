<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIKEMAH - Master Data</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="icon" href="{{ asset('assets/images/logo.png') }}"/>

  <style>
  /* === Root Variables === */
:root {
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
  --dark-hover: #1a202c;

  --light: #f5f6fa;
  --gray: #6c757d;
  --white: #ffffff;
  --border-color: #bbb;
  --shadow: rgba(0, 0, 0, 0.05);
}

/* === Global === */
body {
  font-family: 'Poppins', sans-serif;
  margin: 0;
  background-color: var(--light);
  font-size: 14px;
  color: var(--dark);
}

/* === Sidebar === */
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
.sidebar .menu a:first-of-type { margin-top: 10px; }

.toggle-icon { margin-left: auto; transition: transform 0.3s; }
.collapsed .toggle-icon { transform: rotate(-90deg); }

/* === Sidebar Overlay (Mobile) === */
.overlay {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0, 0, 0, 0.4);
  z-index: 1000;
  display: none;
}
.overlay.show { display: block; }

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

/* === Time & Account === */
.time-date {
  font-size: 13px;
  display: flex;
  align-items: center;
  gap: 20px;
  font-weight: 400;
}
.time-date div { display: flex; align-items: center; gap: 6px; }
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
  color: var(--white);
  border-radius: 50%;
  width: 28px; height: 28px;
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
}
.dropdown-item i { min-width: 24px; text-align: center; }
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
.dropdown-item-danger { color: var(--danger); }
.dropdown-item-danger:hover,
.dropdown-item-danger:focus {
  background-color: var(--danger);
  color: var(--white);
}

/* === Title Bar === */
.title-bar {
  background: linear-gradient(to right, var(--primary), var(--primary-hover));
  color: var(--white);
  padding: 20px 25px;
  margin-left: 250px;
  transition: margin-left 0.3s ease-in-out;
  position: fixed;
  top: 66px;
  left: 0; right: 0;
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
  min-height: calc(100vh - 190px);
  font-size: 14px;
}
.sidebar.hidden ~ .navbar-custom ~ .title-bar ~ .main-content { margin-left: 0; }

/* === Card & Table === */
.card {
  border: none;
  border-radius: 0.5rem;
  box-shadow: 0 0.1rem 0.5rem rgba(0,0,0,0.075);
  margin-bottom: 30px;
}
.table {
  text-align: center;
  vertical-align: middle;
  font-size: 12px;
}
.table th {
  font-weight: 600;
  text-align: center !important;
  vertical-align: middle !important;
  background-color: #f8f9fa;
}
.table td, .table th { padding: 1rem; }
.table-hover > tbody > tr:hover { background-color: var(--light); }

/* === Buttons === */
.btn-aksi {
  width: 32px; height: 32px;
  border-radius: 6px !important;
  display: inline-flex;
  align-items: center; justify-content: center;
  padding: 0;
  color: var(--white);
  transition: all 0.2s ease-in-out;
}
.btn-edit-row { background-color: var(--warning); }
.btn-edit-row:hover {
  background-color: var(--warning-hover);
  color: var(--white);
  transform: scale(1.15);
  filter: brightness(1.2);
  box-shadow: 0 2px 8px rgba(0,0,0,0.25);
}
.btn-delete-row { background-color: var(--danger); }
.btn-delete-row:hover {
  background-color: var(--danger-hover);
  color: var(--white);
  transform: scale(1.15);
  filter: brightness(1.2);
  box-shadow: 0 2px 8px rgba(0,0,0,0.25);
}
.btn-tambah {
  background-color: var(--dark);
  color: var(--white);
  border: none;
  transition: all 0.3s ease;
}
.btn-tambah:hover {
  background-color: var(--dark-hover);
  color: var(--white);
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

/* === Pagination === */
.pagination .page-item.active .page-link {
  background-color: var(--primary);
  border-color: var(--primary);
  color: var(--white);
}
.pagination .page-link { color: var(--primary); }
.pagination .page-link:hover { background-color: var(--primary-light); }
.pagination .page-item.disabled .page-link { color: var(--gray); }

/* === Modal === */
.modal-backdrop {
  position: fixed;
  top: 0; left: 0;
  width: 100vw; height: 100vh;
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
.modal-body-custom { padding: 1.5rem; overflow-y: auto; }
.modal-footer-custom {
  padding: 1rem;
  display: flex;
  justify-content: flex-end;
  gap: .5rem;
  border-top: 1px solid #e2e8f0;
}
.modal-footer-custom .btn:hover { filter: brightness(1.1); }

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
  bottom: 0; right: 0; left: 0;
  margin-left: 250px;
  transition: margin-left 0.3s ease-in-out;
  z-index: 997;
}
.sidebar.hidden ~ .navbar-custom ~ .title-bar ~ .main-content ~ .footer-custom {
  margin-left: 0;
}

/* === Responsive === */
@media (max-width: 991px) {
  .sidebar { transform: translateX(-100%); }
  .sidebar.show { transform: translateX(0); }
  .navbar-custom, .title-bar, .main-content, .footer-custom {
    margin-left: 0 !important;
  }
  .main-content { margin-top: 130px; font-size: 13px; }
  .title-bar h1 { font-size: 18px; }
  .time-date {
    flex-direction: column;
    gap: 6px;
    align-items: flex-start;
  }
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
    <h1><i class="lni lni-database"></i> <span id="page-title">Master Data</span></h1>
  </div>

  <div class="main-content">
    <div class="card">
      <div class="card-body p-4">
            <div class="d-flex justify-content-end mb-3">
      <button class="btn btn-tambah fw-bold" onclick="openModal('tambahDataModal')"><i class="lni lni-plus me-2"></i> Tambah Data</button>
    </div>
        <div class="table-responsive">
          <table class="table table-hover table-bordered">
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
        <h5><i class="fas fa-plus-circle"></i> Tambah Data Pengguna</h5>
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
                  <button class="btn btn-aksi btn-edit-row" title="Edit" onclick="openEditModal('${item.name}', '${item.user}', '${item.role}')"><i class="fa fa-edit"></i></button>
                  <button class="btn btn-aksi btn-delete-row" title="Hapus"><i class="fa fa-trash"></i></button>
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