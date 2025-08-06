<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIKEMAH - Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    .card-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
      margin-bottom: 20px;
    }

    .stat-card {
      background: white;
      border-radius: 10px;
      padding: 20px;
      display: flex;
      align-items: center;
      gap: 15px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
      opacity: 0;
      transform: translateY(20px);
      animation: fadeInUp 0.6s ease forwards;
    }
    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }

    .card-icon {
      width: 50px;
      height: 50px;
      font-size: 24px;
      display: flex;
      justify-content: center;
      align-items: center;
      border-radius: 50%;
      color: white;
      flex-shrink: 0;
    }
    .card-label { color: #718096; }
    .card-value { font-size: 32px; font-weight: 700; }

    .chart-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
      gap: 20px;
    }

    .chart-box {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
      opacity: 0;
      transform: translateY(20px);
      animation: fadeInUp 0.6s ease forwards;
      animation-delay: 0.4s;
    }

    .chart-box h3 {
      font-size: 16px;   /* Ukuran judul grafik lebih kecil */
      font-weight: 600;
      margin-bottom: 15px;
      text-align: center; /* Biar judul di tengah */
      color: #374151;     /* (opsional) abu-abu tua biar elegan */
    }

    @keyframes fadeInUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
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

    @media (max-width: 991px) {
      .sidebar { transform: translateX(-100%); }
      .sidebar.show { transform: translateX(0); }
      .navbar-custom, .title-bar, .main-content, .footer-custom { margin-left: 0 !important; }
      .time-date { flex-direction: column; gap: 6px; align-items: flex-start; }
      .main-content { margin-top: 130px; font-size: 13px; }
      .account span { font-size: 12px; }
      .sidebar .menu a, .sidebar .menu button { font-size: 12.5px; }
      .search-filter-wrapper {flex-direction: column;} 
      .filter-action-group {
          flex-direction: row;
          flex-wrap: wrap;
          width: 100%;
          gap: 8px;
        }
      .filter-action-group > div {flex: 1 1 auto;}
      .filter-action-group button {width: 100%;}
    }
  </style>
</head>
<body class="">

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
    document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', { 
      weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' 
    });
    document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID', { 
      hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false
    });
  }
  setInterval(updateDateTime, 1000);
  updateDateTime();

  const ctxJenis = document.getElementById('jenisChart').getContext('2d');
  new Chart(ctxJenis, {
    type: 'bar',
    data: {
      labels: ['Pendidikan', 'Penelitian', 'Pengabdian', 'Penunjang'],
      datasets: [{
        label: 'Jumlah',
        data: [88, 25, 12, 10],
        backgroundColor: '#059669',
        borderRadius: 5,
      }]
    },
    options: {
      responsive: true,
      plugins: {
        tooltip: {
          callbacks: {
            label: function(context) {
              return ` Jumlah: ${context.parsed.y}`;
            }
          }
        },
        legend: { display: false }
      },
      onClick: (e, elements) => {
        if (elements.length > 0) {
          const index = elements[0].index;
          const label = elements[0].chart.data.labels[index];
          alert(`Klik pada: ${label}`);
        }
      },
      scales: { y: { beginAtZero: true } }
    }
  });

  const ctxBulan = document.getElementById('bulanChart').getContext('2d');
  const gradient = ctxBulan.createLinearGradient(0, 0, 0, 300);
  gradient.addColorStop(0, '#05966999');
  gradient.addColorStop(1, '#05966911');

  new Chart(ctxBulan, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'],
      datasets: [{
        label: 'Kegiatan',
        data: [2, 10, 8, 18, 17, 20, 22],
        fill: true,
        backgroundColor: gradient,
        borderColor: '#059669',
        tension: 0.4,
        pointBackgroundColor: '#059669',
        pointRadius: 5
      }]
    },
    options: {
      responsive: true,
      plugins: {
        tooltip: {
          callbacks: {
            label: function(context) {
              return ` Kegiatan: ${context.parsed.y}`;
            }
          }
        },
        legend: { display: false }
      },
      onClick: (e, elements) => {
        if (elements.length > 0) {
          const index = elements[0].index;
          const label = elements[0].chart.data.labels[index];
          alert(`Klik pada bulan: ${label}`);
        }
      },
      scales: { y: { beginAtZero: true } }
    }
  });
</script>
</body>
</html>