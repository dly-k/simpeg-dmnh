<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIKEMAH - Editor Kegiatan Pelatihan</title>
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
  background-color: var(--light);
}

/* Sidebar */
.sidebar {
  width: 250px;
  height: 100vh;
  background-color: var(--white);
  border-right: 1px solid var(--border-color);
  position: fixed;
  top: 0; left: 0;
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

.sidebar .menu-wrapper { overflow-y: auto; flex-grow: 1; }

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
  font-size: 13px;
  color: #333;
  text-decoration: none;
  width: 100%;
  border: none;
  background: none;
  transition: all 0.2s ease-in-out;
  text-align: left;
}
.sidebar .menu a:hover,
.sidebar .menu button:hover {
  background-color: var(--primary-light);
  color: var(--primary-dark);
}
.sidebar .menu a.active,
.sidebar .menu button.active {
  background-color: var(--primary);
  color: var(--white);
  font-weight: 600;
}
.sidebar .menu a:first-of-type { margin-top: 10px; }

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
  background-color: var(--primary-light);
  color: var(--primary-dark);
  font-weight: 600;
}

.toggle-icon { margin-left: auto; transition: transform 0.3s; }
.collapsed .toggle-icon { transform: rotate(-90deg); }

/* Overlay */
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
  background: var(--white);
  border-bottom: 1px solid var(--border-color);
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 20px;
  margin-left: 250px;
  transition: margin-left 0.3s ease-in-out;
  position: fixed;
  top: 0; left: 0; right: 0;
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
.time-date div { display: flex; align-items: center; gap: 6px; }
.time-date i { font-size: 13px; color: #4b5563; }

/* Account */
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

/* Dropdown */
.dropdown-menu {
  margin-top: 5px !important;
  padding: 0;
  border-radius: 0.375rem;
  overflow: hidden;
}
.dropdown-item {
  font-size: 13px;
  padding: 10px 16px;
}
.dropdown-item i { min-width: 24px; text-align: center; }
.dropdown-item:hover,
.dropdown-item:focus {
  background-color: #f0f0f0;
  color: #111;
  text-decoration: none;
  outline: none;
  box-shadow: none;
}
.dropdown-item:active {
  background-color: #e9e9e9;
  color: #111;
}
.dropdown-divider { margin: 0; }
.dropdown-item-danger { color: var(--danger); }
.dropdown-item-danger:hover,
.dropdown-item-danger:focus {
  background-color: var(--danger);
  color: var(--white);
}

/* Pagination */
.pagination .page-item.active .page-link {
  background-color: var(--primary);
  border-color: var(--primary);
  color: var(--white);
}
.pagination .page-link { color: var(--primary); }
.pagination .page-link:hover {
  background-color: var(--primary-light);
  color: var(--primary-dark);
}
.pagination .page-item.disabled .page-link { color: var(--gray); }

/* Title Bar */
.title-bar {
  background: linear-gradient(to right, var(--primary), var(--primary-dark));
  color: var(--white);
  padding: 20px 25px;
  margin-left: 250px;
  transition: margin-left 0.3s ease-in-out;
  position: fixed;
  top: 66px; left: 0; right: 0;
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

/* Main Content */
.main-content {
  margin: 130px 0 70px 250px;
  padding: 25px;
  background-color: var(--light);
  transition: margin-left 0.3s ease-in-out;
  font-size: 14px;
}
.sidebar.hidden ~ .navbar-custom ~ .title-bar ~ .main-content { margin-left: 0; }

/* Card */
.card {
  background: var(--white);
  padding: 1.5rem;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.05);
  border: none;
}

/* Search Filter */
.search-filter-row {
  display: flex;
  flex-wrap: nowrap;
  gap: 1rem;
  align-items: center;
  justify-content: flex-start;
  margin-bottom: 1.5rem;
}
.search-box {
  flex: 1 1 auto;
  min-width: 200px;
  max-width: 100%;
}
.filter-select {
  flex: 0 0 180px;
}
.btn-tambah-container {
  flex: 0 0 auto;
  margin-left: auto;
  display: flex;
  align-items: center;
}
.search-input::placeholder {
  color: rgba(0, 0, 0, 0.4);
  opacity: 1;
}

/* Table */
.table {
  font-size: 12px;
  vertical-align: middle;
}
.table th {
  font-weight: 600;
  text-align: center !important;
  vertical-align: middle !important;
}

/* Buttons */
.btn-aksi {
  width: 32px; height: 32px;
  border-radius: 6px !important;
  display: inline-flex;
  align-items: center; justify-content: center;
  padding: 0;
  color: var(--white);
  text-decoration: none;
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
  bottom: 0; left: 0; right: 0;
  margin-left: 250px;
  transition: margin-left 0.3s ease-in-out;
  z-index: 997;
}
.sidebar.hidden ~ .navbar-custom ~ .title-bar ~ .main-content ~ .footer-custom {
  margin-left: 0;
}

/* Modal */
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
  background: linear-gradient(to right, var(--primary), var(--primary-dark));
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
  border-top: 1px solid var(--border-color);
}
.upload-area {
  border: 2px dashed #dee2e6;
  border-radius: .5rem;
  padding: 2rem;
  text-align: center;
  cursor: pointer;
  transition: background-color .2s;
}
.upload-area:hover { background-color: #f8f9fa; }
.upload-area i { font-size: 2rem; color: var(--gray); }
.upload-area p { margin-top: 1rem; color: var(--gray); }
.dynamic-row {
  border: 1px solid var(--border-color);
  border-radius: .375rem;
  padding: 1rem;
  position: relative;
}
.dynamic-row-close-btn {
  position: absolute;
  top: .5rem;
  right: .5rem;
}

/* Responsive */
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
     @media (max-width: 768px) {
      .table {
        font-size: 0.8125rem;
      }
      .table th,
      .table td {
        padding: 0.5rem 0.75rem;
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
          <a href="/penunjang" aria-label="Penunjang">Penunjang</a>
          <a href="/pelatihan" aria-label="Pelatihan" class="active">Pelatihan</a>
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
    <h1><i class="lni lni-pencil-alt"></i> <span id="page-title">Editor Kegiatan - Pelatihan</span></h1>
  </div>

  <div class="main-content">
      <div class="card">
          <div class="search-filter-container">
            <div class="search-filter-row">
                <div class="search-box">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search" style="color: green;"></i></span>
                        <input type="text" class="form-control border-start-0 search-input" placeholder="Cari Data ....">
                    </div>
                </div>
                <select class="form-select filter-select"><option selected>Tahun</option><option>2023</option></select>
                <select class="form-select filter-select"><option selected>-- posisi --</option><option>Peserta</option><option>Pembicara</option><option>Panitia</option></select>
                <div class="btn-tambah-container">
                    <a href="#" class="btn btn-tambah fw-bold" onclick="openModal('pelatihanModal')"><i class="fa fa-plus me-2"></i> Tambah Data</a>
                </div>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>No</th>
                        <th class="text-start">Nama Kegiatan</th>
                        <th>Penyelenggara</th>
                        <th>Pegawai</th>
                        <th>Posisi</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Dokumen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <script>
                      for(let i=1; i<=7; i++){ 
                          document.write(`
                              <tr>
                                  <td class="text-center">${i}</td>
                                  <td class="text-start">Alex Kurniawan</td>
                                  <td class="text-center">IPDN</td>
                                  <td class="text-center">Biometrika Hutan</td>
                                  <td class="text-center">Peserta</td>
                                  <td class="text-center">12 Januari 2023</td>
                                  <td class="text-center">19 Januari 2023</td>
                                  <td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td>
                                  <td class="text-center">
                                      <div class="d-flex gap-2 justify-content-center">
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
  
  <div class="modal-backdrop" id="pelatihanModal">
        <div class="modal-content-wrapper">
            <div class="modal-header-custom">
                <h5 id="modalTitle"><i class="fas fa-plus-circle"></i> Tambah Data Pelatihan</h5>
            </div>
            <div class="modal-body-custom">
                <form id="pelatihanForm">
                    <div class="row g-3">
                        <div class="col-12"><label class="form-label">Nama Pelatihan</label><input type="text" class="form-control" placeholder="Lorem Ipsum"></div>
                        <div class="col-12"><label class="form-label">Posisi Pelatihan</label><select class="form-select"><option selected>Lorem Ipsum</option></select></div>
                        <div class="col-12"><label class="form-label">Kota/Kabupaten</label><input type="text" class="form-control" placeholder="Lorem Ipsum"></div>
                        <div class="col-12"><label class="form-label">Lokasi</label><input type="text" class="form-control" placeholder="Lorem Ipsum"></div>
                        <div class="col-12"><label class="form-label">Penyelenggara</label><input type="text" class="form-control" placeholder="Lorem Ipsum"></div>
                        <div class="col-md-6"><label class="form-label">Tanggal Mulai</label><input type="date" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Tanggal Selesai</label><input type="date" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Jumlah Jam</label><input type="number" class="form-control" placeholder="Contoh: 8"></div>
                        <div class="col-md-6"><label class="form-label">Jumlah Hari</label><input type="number" class="form-control" placeholder="Contoh: 3"></div>
                        <div class="col-md-6"><label class="form-label">Jenis Diklat</label><input type="text" class="form-control" placeholder="Contoh: Teknis"></div>
                        <div class="col-md-6"><label class="form-label">Lingkup</label><input type="text" class="form-control" placeholder="Contoh: Nasional"></div>
                        <div class="col-md-6"><label class="form-label">Struktural</label><select class="form-select"><option selected>-- Pilih --</option></select></div>
                        <div class="col-md-6"><label class="form-label">Sertifikasi</label><select class="form-select"><option selected>-- Pilih --</option></select></div>
                        
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0">Anggota Kegiatan</label>
                                <button type="button" class="btn btn-sm btn-primary" onclick="addAnggota()">+ Tambah Anggota</button>
                            </div>
                            <div id="anggota-list" class="vstack gap-2">
                                </div>
                        </div>

                        <div class="col-12"><label class="form-label">Jenis Dokumen</label><select class="form-select"><option selected>-- Pilih Salah Satu --</option></select></div>
                        
                        <div class="col-12">
                            <div class="upload-area">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Drag & Drop File here<br><small>Ukuran Maksimal 5 MB</small></p>
                                <input type="file" hidden>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="row g-2" id="dokumen-info">
                                <div class="col-md-4"><input type="text" class="form-control" placeholder="Nama Dokumen"></div>
                                <div class="col-md-4"><input type="text" class="form-control" placeholder="Nomor"></div>
                                <div class="col-md-4"><input type="text" class="form-control" placeholder="Tautan"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn btn-danger" onclick="closeModal('pelatihanModal')">Batal</button>
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
        modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Pelatihan';
        modal.querySelector('form').reset();
        
        document.getElementById('anggota-list').innerHTML = '';

        if (modal) {
            modal.style.display = 'flex';
        }
    }
    
    function openEditModal() {
        const modal = document.getElementById('pelatihanModal');
        const modalTitle = modal.querySelector('#modalTitle');
        modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Pelatihan';
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
    
    function addAnggota() {
        const list = document.getElementById('anggota-list');
        const newRow = document.createElement('div');
        newRow.className = 'dynamic-row';
        newRow.innerHTML = `
            <button type="button" class="btn-close dynamic-row-close-btn" aria-label="Close" onclick="this.parentElement.remove()"></button>
            <div class="row g-2">
                <div class="col-12">
                    <label class="form-label form-label-sm">Nama Anggota</label>
                    <input type="text" class="form-control form-control-sm" placeholder="Nama Anggota">
                </div>
                <div class="col-md-6">
                    <label class="form-label form-label-sm">Angkatan</label>
                    <input type="text" class="form-control form-control-sm" placeholder="Angkatan">
                </div>
                <div class="col-md-6">
                    <label class="form-label form-label-sm">Predikat</label>
                    <input type="text" class="form-control form-control-sm" placeholder="Predikat">
                </div>
            </div>
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