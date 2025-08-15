<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <title>SIKEMAH - Ubah Password</title>
  
  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />  
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/ubah-password.css') }}" />
</head>

<body>
<div class="layout">
  <div class="sidebar" id="sidebar">
    <div class="brand">SI<span>KEMAH</span></div>
    <div class="menu-wrapper">
      <div class="menu">
        <a href="/dashboard" aria-label="Dashboard"><i class="lni lni-grid-alt"></i> Dashboard</a>
        <p>Menu Utama</p>
        <a href="/daftar-pegawai"><i class="lni lni-users"></i> Daftar Pegawai</a>
        <a href="/surat-tugas"><i class="lni lni-folder"></i> Manajemen Surat Tugas</a>
        
        <button data-bs-toggle="collapse" data-bs-target="#editorKegiatan" aria-expanded="true" aria-controls="editorKegiatan">
          <i class="lni lni-pencil-alt"></i> Editor Kegiatan
          <i class="lni lni-chevron-down toggle-icon"></i>
        </button>
        <div class="collapse submenu show" id="editorKegiatan">
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
  </div>

  <div class="overlay" id="overlay"></div>

  <div class="main-wrapper">
    <div class="navbar-custom">
      <div class="d-flex align-items-center">
        <button class="btn btn-link text-dark me-3" id="toggleSidebar"><i class="lni lni-menu"></i></button>
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
      <h1><i class="fas fa-key"></i> <span id="page-title">Password</span></h1>
    </div>

<div class="main-content">
  <div class="password-form-container">
    <div class="form-header">
      <h2>Ubah Password</h2>
    </div>
    <div class="form-body">
      <form id="ubahPasswordForm" novalidate>
        
        <div class="mb-4">
          <label for="password_lama" class="form-label">Password Lama<span class="text-danger">*</span></label>
          <div class="password-field-wrapper">
            <input type="password" class="form-control" id="password_lama" placeholder="Masukkan Password Lama Anda" required aria-describedby="password_lama-error">
            <i class="fas fa-eye toggle-password"></i>
            </div>
          <div id="password_lama-error" class="error-message"></div>
        </div>

        <div class="mb-4">
          <label for="password_baru" class="form-label">Password Baru<span class="text-danger">*</span></label>
          <div class="password-field-wrapper">
            <input type="password" class="form-control" id="password_baru" placeholder="Masukkan Password Baru Anda" required aria-describedby="password_baru-error">
            <i class="fas fa-eye toggle-password"></i>
            </div>
          <div id="password_baru-error" class="error-message"></div>
        </div>
        
        <div class="mb-4">
          <label for="konfirmasi_password_baru" class="form-label">Konfirmasi Password Baru<span class="text-danger">*</span></label>
          <div class="password-field-wrapper">
            <input type="password" class="form-control" id="konfirmasi_password_baru" placeholder="Masukkan Password Baru Anda" required aria-describedby="konfirmasi_password_baru-error">
            <i class="fas fa-eye toggle-password"></i>
            </div>
          <div id="konfirmasi_password_baru-error" class="error-message"></div>
        </div>

        <button type="submit" class="btn btn-simpan w-100">Simpan</button>
      </form>
    </div>
  </div>
</div>

    <footer class="footer-custom">
      <span>© 2025 Forest Management — All Rights Reserved</span>
    </footer>
  </div>
</div>

  <!--Modal Berhasil-->
    <div class="modal-berhasil-overlay" id="modalBerhasil">
      <div class="modal-berhasil-box">
          <div class="modal-berhasil-icon">
              <i class="fas fa-check"></i>
          </div>
          <h3 class="modal-berhasil-title" id="berhasil-title">Data Berhasil Disimpan</h3>
          <p class="modal-berhasil-subtitle" id="berhasil-subtitle">Data Anda Berhasil Disimpan Pada Sistem</p>
          <div class="modal-berhasil-buttons">
              <button class="btn-popup btn-selesai" id="btnSelesai">Selesai</button>
          </div>
      </div>
  </div>

<script src="{{ asset('assets/js/ubah-password.js') }}"></script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>