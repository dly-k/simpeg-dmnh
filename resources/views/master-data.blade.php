<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>SIKEMAH - Master Data</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/master-data.css') }}" />
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

<!--Hapus Penelitian-->
<!-- Modal Konfirmasi Hapus -->
<div class="konfirmasi-hapus-overlay" id="modalKonfirmasiHapus" style="display: none;">
    <div class="konfirmasi-hapus-box">
        <div class="konfirmasi-hapus-icon">
            <i class="fas fa-exclamation"></i>
        </div>
        <h3 class="konfirmasi-hapus-title">Apakah Anda Yakin Menghapus Data Ini?</h3>
        <p class="konfirmasi-hapus-subtitle">Data ini akan dihapus secara permanen dari sistem.</p>
        <div class="konfirmasi-hapus-buttons">
            <button class="btn-popup btn-batal" id="btnBatalHapus">Batal</button>
            <button class="btn-popup btn-hapus" id="btnKonfirmasiHapus">Hapus</button>
        </div>
    </div>
</div>

  <script src="{{ asset('assets/js/master-data.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>