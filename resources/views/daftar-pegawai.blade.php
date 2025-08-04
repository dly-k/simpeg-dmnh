<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIKEMAH - Daftar Pegawai</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
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

    .menu-item.active {
      background-color: #d1fae5;
      color: #059669;
      font-weight: 600;
    }

    .btn-blue {
      background-color: #3B82F6;
      color: white;
      padding: 8px 16px;
      border: none;
      border-radius: 6px;
      font-weight: 600;
      cursor: pointer;
    }


    .main {
      flex: 1;
      display: flex;
      flex-direction: column;
      overflow-x: auto;
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

    .content {
      padding: 30px;
    }

    .table-card {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
    }

    table th, table td {
      border: 1px solid #e2e8f0;
      padding: 10px;
      text-align: left;
    }

    table th {
      background-color: #f9fafb;
    }

    .actions i {
      margin: 0 5px;
      cursor: pointer;
    }

    .btn-primary {
      background-color: #059669;
      color: white;
      padding: 8px 16px;
      border: none;
      border-radius: 6px;
      font-weight: 600;
      cursor: pointer;
    }

    .search-box {
      display: flex;
      justify-content: space-between;
      margin-bottom: 15px;
      flex-wrap: wrap;
    }

    .search-box input {
      padding: 8px 12px;
      width: 250px;
      border: 1px solid #ccc;
      border-radius: 6px;
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
          <a href="/dashboard" class="menu-item">
            <i class="fa fa-chart-bar"></i> Dashboard
          </a>
        </li>

        <li><div class="menu-item active"><i class="fa fa-users"></i> Daftar Pegawai</div></li>
        <li><a href="/surat-tugas" class="menu-item"><i class="fa fa-envelope"></i> Manajemen Surat Tugas</a></li>
        <li><div class="menu-item"><i class="fa fa-edit"></i> Editor Kegiatan</div></li>
        <ul style="margin-left: 20px;">
          <li><div class="menu-item">📘 Pendidikan</div></li>
          <li><div class="menu-item">🔬 Penelitian</div></li>
          <li><div class="menu-item">🤝 Pengabdian</div></li>
          <li><div class="menu-item">🧾 Penunjang</div></li>
        </ul>
        <li><div class="menu-item"><i class="fa fa-handshake"></i> Kerjasama</div></li>
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
        <h1><i class="fa fa-users"></i> Daftar Pegawai</h1>
      </div>

<!-- ... (tidak berubah sampai bagian .content) -->
<div class="content">
  <div class="table-card">
    <div class="search-box">
      <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <input type="text" placeholder="🔍 Cari Data ...." />
        <select style="padding: 8px 12px; border: 1px solid #ccc; border-radius: 6px;">
          <option value="">-- Filter Status --</option>
          <option value="aktif">Aktif</option>
          <option value="nonaktif">Nonaktif</option>
        </select>
      </div>
      <button class=" btn-blue"><i class="fa fa-plus"></i> Tambah Data</button>
    </div>

    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Lengkap</th>
          <th>NIP</th>
          <th>Status Kepegawaian</th>
          <th>Jabatan Fungsional</th>
          <th>Jabatan Struktural</th>
          <th>Pangkat/Golongan</th>
          <th>Status Pegawai</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Joko Anwar S.pd</td>
          <td>292281910</td>
          <td>Tenaga Pendidik - Dosen</td>
          <td>Lektor</td>
          <td>Ketua Departemen</td>
          <td>Penata Muda / III-a</td>
          <td>Aktif</td>
          <td class="actions">
            <i class="fa fa-eye" style="color: gray;"></i>
            <i class="fa fa-edit" style="color: orange;"></i>
            <i class="fa fa-trash" style="color: red;"></i>
          </td>
        </tr>
        <!-- Tambahkan baris lainnya sesuai kebutuhan -->
      </tbody>
    </table>

    <div style="margin-top: 10px; display: flex; justify-content: space-between; font-size: 12px;">
      <div>Menampilkan 1 sampai 10 dari 13 data</div>
      <div>
        <button>⬅ Sebelumnya</button>
        <button style="background-color: #059669; color: white;">1</button>
        <button>2</button>
        <button>Berikutnya ➡</button>
      </div>
    </div>
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
  </script>
</body>
</html>
