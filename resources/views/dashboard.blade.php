<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIKEMAH - Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      background-color: #f7fafc;
    }

    .layout {
      display: flex;
      height: 100vh;
    }

    .sidebar {
      width: 250px;
      background: white;
      padding: 20px;
      box-shadow: 2px 0 5px rgba(0,0,0,0.1);
      overflow-y: auto;
    }

    .sidebar ul {
      list-style: none;
      padding-left: 0;
    }

    .sidebar li {
      margin-bottom: 10px;
    }

    .menu-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px;
      border-radius: 8px;
      color: #2d3748;
      text-decoration: none;
      cursor: pointer;
      transition: background-color 0.2s ease;
    }

    .menu-item:hover {
      background-color: #f0fdf4;
      color: #059669;
    }

    .menu-item svg {
      width: 20px;
      height: 20px;
      stroke-width: 2;
    }

    .menu-item.active {
      background-color: #d1fae5;
      color: #059669;
      font-weight: 600;
    }

    .main {
      flex: 1;
      display: flex;
      flex-direction: column;
      overflow-x: hidden;
    }

    .header {
      background: white;
      display: flex;
      justify-content: space-between;
      padding: 15px 30px;
      border-bottom: 1px solid #e2e8f0;
      align-items: center;
    }

    .title-bar {
      background: linear-gradient(to right, #059669, #047857);
      color: white;
      padding: 20px 30px;
    }

    .title-bar h1 {
      font-size: 24px;
      margin: 0;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .card-container {
      display: flex;
      gap: 20px;
      padding: 20px 30px;
      margin-top: 20px;
      flex-wrap: wrap;
    }

    .card {
    flex: 1;
    background: white;
    border-radius: 10px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }

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

    .card-label {
    color: #718096;
    }

    .card-value {
    font-size: 32px;
    font-weight: 700;
    }


    .chart-container {
      display: flex;
      gap: 20px;
      padding: 0 30px 30px;
      flex-wrap: wrap;
    }

    .chart-box {
      flex: 1;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
      min-width: 300px;
    }

    .footer {
      text-align: right;
      font-size: 12px;
      color: #a0aec0;
      padding: 10px 30px;
    }
  </style>
</head>
<body>
  <div class="layout">
    <!-- Sidebar -->
        <div class="sidebar">
      <h1 style="font-weight: 700;">
        <span style="color: #000;">SI</span><span style="color: #059669;">KEMAH</span>
      </h1>
      <hr/>
      <p style="font-weight: 600; margin-top: 30px;">Menu Utama</p>
      <ul>
          <li>
              <a href="/dashboard" class="menu-item active">
                  <i class="fa fa-chart-bar"></i> Dashboard
              </a>
          </li>
          <li>
              <!-- Tag yang diperbaiki dan kelas 'active' ditambahkan agar sesuai dengan konteks halaman -->
              <a href="/daftar-pegawai" class="menu-item">
                  <i class="fa fa-users"></i> Daftar Pegawai
              </a>
          </li>
          <li>
              <a href="/surat-tugas" class="menu-item">
                  <i class="fa fa-envelope"></i> Manajemen Surat Tugas
              </a>
          </li>
          <li>
              <!-- Diubah menjadi tautan ke halaman editor umum -->
              <a href="/editor" class="menu-item">
                  <i class="fa fa-edit"></i> Editor Kegiatan
              </a>
          </li>
          <ul style="margin-left: 20px;">
              <!-- Semua item sub-menu sekarang menjadi tautan -->
              <li><a href="/pendidikan" class="menu-item">🎓 Pendidikan</a></li>
              <li><a href="/penelitian" class="menu-item">🔬 Penelitian</a></li>
              <li><a href="/pengabdian" class="menu-item">🤝 Pengabdian</a></li>
              <li><a href="/penunjang" class="menu-item">📎 Penunjang</a></li>
              <li><a href="/pelatihan" class="menu-item">📚 Pelatihan</a></li>
              <li><a href="/penghargaan" class="menu-item">🏅 Penghargaan</a></li>
              <li><a href="/sk-non-pns" class="menu-item">📄 SK Non PNS</a></li>
          </ul>
          <li>
              <!-- Diubah menjadi tautan -->
              <a href="/kerjasama" class="menu-item">
                  <i class="fa fa-handshake"></i> Kerjasama
              </a>
          </li>

          <li>
            <a href="/master-data" class="menu-item">
                <i class="fa fa-database"></i> Master Data
            </a>
        </li>
      </ul>
    </div>


    <!-- Main Content -->
    <div class="main">
      <div class="header">
        <div style="display: flex; align-items: center; gap: 20px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-calendar-days" style="color: #4b5563;"></i>
                <span id="current-date"></span>
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-clock" style="color: #4b5563;"></i>
                <strong id="current-time"></strong>
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 10px;">
          <div style="background-color: orange; width: 40px; height: 40px; border-radius: 50%; display: flex; justify-content: center; align-items: center; color: white; font-weight: bold;">KTU</div>
          <div>Halo, Ketua TU</div>
        </div>
      </div>

      <div class="title-bar">
        <h1>
          <svg width="24" height="24" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
            <path d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
          Dashboard
        </h1>
      </div>

      <div class="card-container">
        <div class="card">
            <div class="card-icon">👥</div>
            <div>
                <div class="card-label">Total Pegawai</div>
                <div class="card-value">40</div>
            </div>
        </div>

        <div class="card">
            <div class="card-icon">📊</div>
            <div>
                <div class="card-label">Total Pegawai</div>
                <div class="card-value">40</div>
            </div>
        </div>

         <div class="card">
            <div class="card-icon">📝</div>
            <div>
                <div class="card-label">Total Pegawai</div>
                <div class="card-value">40</div>
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

      <div class="footer">
        © 2025 Forest Management — All Rights Reserved
      </div>
    </div>
  </div>

  <script>
    function updateClock() {
      const now = new Date();
      const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
      document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', dateOptions);
      document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID', { hour12: false });
    }
    setInterval(updateClock, 1000);
    updateClock();

    const ctxJenis = document.getElementById('jenisChart').getContext('2d');
    new Chart(ctxJenis, {
      type: 'bar',
      data: {
        labels: ['BKD', 'Pengabdian', 'Sertifikasi', 'Penunjang'],
        datasets: [{
          label: 'Jumlah',
          data: [88, 25, 12, 10],
          backgroundColor: '#059669'
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
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
          tension: 0.4
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
      }
    });
  </script>
</body>
</html>
