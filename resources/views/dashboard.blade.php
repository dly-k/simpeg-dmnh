<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <title>SIKEMAH - Dashboard</title>
  
  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />  
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}" />
</head>

<body>
<div class="layout">
  <div class="sidebar" id="sidebar">
    <div class="brand">SI<span>KEMAH</span></div>
    <div class="menu-wrapper">
      <div class="menu">
        <a href="/dashboard" aria-label="Dashboard" class="active"><i class="lni lni-grid-alt"></i> Dashboard</a>
        <p>Menu Utama</p>
        <a href="/daftar-pegawai"><i class="lni lni-users"></i> Daftar Pegawai</a>
        <a href="/surat-tugas"><i class="lni lni-folder"></i> Manajemen Surat Tugas</a>
        <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#editorKegiatan" aria-expanded="false" aria-controls="editorKegiatan">
          <i class="lni lni-pencil-alt"></i> Editor Kegiatan
          <i class="lni lni-chevron-down toggle-icon"></i>
        </button>
        <div class="collapse submenu" id="editorKegiatan" aria-expanded="true" aria-controls="editorKegiatan">
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
      <h1><i class="lni lni-grid-alt"></i> <span id="page-title">Dashboard</span></h1>
    </div>

    <div class="main-content">
      <div class="card-container">
        <div class="stat-card">
          <div class="card-icon" style="background-color: #3B82F6;">
            <i class="lni lni-users"></i>
          </div>
          <div>
            <div class="card-label">Total Pegawai</div>
            <div class="card-value">46</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="card-icon" style="background-color: #10B981;">
            <i class="lni lni-stats-up"></i>
          </div>
          <div>
            <div class="card-label">Kegiatan Tahun Ini</div>
            <div class="card-value">125</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="card-icon" style="background-color: #F59E0B;">
            <i class="lni lni-folder"></i>
          </div>
          <div>
            <div class="card-label">Surat Tugas</div>
            <div class="card-value">30</div>
          </div>
        </div>
      </div>

      <div class="chart-container">
        <div class="chart-box">
          <h3>Statistik Kegiatan per Jenis</h3>
          <canvas id="jenisChart"></canvas>
        </div>
        <div class="chart-box">
          <h3>Kegiatan Dosen per Bulan</h3>
          <canvas id="bulanChart"></canvas>
        </div>
      </div>
    </div>

    <footer class="footer-custom">
      <span>© 2025 Forest Management — All Rights Reserved</span>
    </footer>
  </div>
</div>

<script src="{{ asset('assets/js/dashboard.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>