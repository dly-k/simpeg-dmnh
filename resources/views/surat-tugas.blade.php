<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIKEMAH - Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; }
    body { font-family: 'Poppins', sans-serif; margin: 0; background-color: #f7fafc; }
    .layout { display: flex; height: 100vh; overflow: hidden; }
    .sidebar {
      width: 250px;
      background: white;
      padding: 20px;
      box-shadow: 2px 0 5px rgba(0,0,0,0.1);
      overflow-y: auto;
    }
    .sidebar ul { list-style: none; padding-left: 0; }
    .sidebar li { margin-bottom: 10px; }
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
    .menu-item:hover { background-color: #f0fdf4; color: #059669; }
    .menu-item.active {
      background-color: #d1fae5;
      color: #059669;
      font-weight: 600;
    }
    .main {
      flex: 1;
      display: flex;
      flex-direction: column;
      overflow: auto;
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
    .btn-primary {
      background-color: #3b82f6;
      color: white;
      padding: 8px 16px;
      border: none;
      border-radius: 6px;
      font-weight: 600;
      cursor: pointer;
    }

    .search-box {
      margin-bottom: 15px;
      flex-wrap: wrap;
    }

    .search-box input {
      padding: 8px 12px;
      width: 250px;
      border: 1px solid #ccc;
      border-radius: 6px;
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

    td button {
      min-width: 32px;
      height: 32px;
    }

    table th {
      background-color: #f9fafb;
    }
    .badge {
      background-color: #3b82f6;
      color: white;
      padding: 6px 12px;
      border-radius: 6px;
      font-size: 12px;
    }
    .btn-edit {
      background-color: #f59e0b;
      border: none;
      padding: 6px 10px;
      border-radius: 6px;
      color: white;
      cursor: pointer;
    }
    .btn-delete {
      background-color: #ef4444;
      border: none;
      padding: 6px 10px;
      border-radius: 6px;
      color: white;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="layout">
    <!-- Sidebar -->
    <div class="sidebar">
      <h1><span style="color: #000;">SI</span><span style="color: #059669;">KEMAH</span></h1>
      <hr/>
      <p style="font-weight: 600; margin-top: 30px;">Menu Utama</p>
      <ul>
        <li><a href="/dashboard" class="menu-item"><i class="fa fa-chart-bar"></i> Dashboard</a></li>
        <li><a href="/daftar-pegawai" class="menu-item"><i class="fa fa-users"></i> Daftar Pegawai</a></li>
        <li><a href="#" class="menu-item  active"><i class="fa fa-envelope"></i> Manajemen Surat Tugas</a></li>
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

    <!-- Main -->
    <div class="main">
      <div class="header">
        <div style="display: flex; gap: 20px;">
          <div style="display: flex; align-items: center; gap: 8px;">
            <i class="fa fa-calendar-days" style="color: #4b5563;"></i>
            <span id="current-date"></span>
          </div>
          <div style="display: flex; align-items: center; gap: 8px;">
            <i class="fa fa-clock" style="color: #4b5563;"></i>
            <strong id="current-time"></strong>
          </div>
        </div>
        <div style="display: flex; align-items: center; gap: 10px;">
          <div style="background-color: orange; width: 40px; height: 40px; border-radius: 50%; display: flex; justify-content: center; align-items: center; color: white; font-weight: bold;">KTU</div>
          <div>Halo, Ketua TU</div>
        </div>
      </div>

      <div class="title-bar">
        <h1><i class="fa fa-envelope"></i> Manajemen Surat Tugas</h1>
      </div>

<div class="content">
  <div class="table-card">
    <div class="search-box" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 15px;">
  <div style="display: flex; gap: 10px; flex-wrap: wrap;">
    <input type="text" placeholder=" Cari Data ...." /> 
    <select style="padding: 8px 12px; border: 1px solid #ccc; border-radius: 6px;">
      <option value="">-- Filter Tahun --</option>
      <option value="2025">2025</option>
      <option value="2024">2024</option>
      <option value="2023">2023</option>
    </select>
  </div>
  <div style="display: flex; gap: 10px;">
    <button class="btn-primary" style="background-color: #10b981;"><i class="fa fa-file-excel"></i> Export Excel</button>
    <button class="btn-primary" style="background-color: #3b82f6;"><i class="fa fa-plus"></i> Tambah Data</button>
  </div>
</div>


    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Dosen</th>
            <th>Peran</th>
            <th>Diminta Sebagai</th>
            <th>Mitra/Instansi</th>
            <th>No dan tgl Surat Instansi</th>
            <th>No dan tgl Surat Kadep</th>
            <th>Tgl Kegiatan</th>
            <th>Ket. Lokasi</th>
            <th>Dokumen</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Dr. Stone</td>
            <td>Dosen</td>
            <td>Penelitian</td>
            <td>Pt. Lele Berkumis</td>
            <td>001/INT/2025 - 1 Juni 2025</td>
            <td>001/INT/2025 - 1 Juni 2025</td>
            <td>20 Juni 2021</td>
            <td>Empang Hj Ujang</td>
            <td><span class="badge">Lihat</span></td>
            <td>
            <div style="display: flex; gap: 8px; justify-content: center; align-items: center; height: 100%;">
              <button class="btn-edit"><i class="fa fa-pen"></i></button>
              <button class="btn-delete"><i class="fa fa-trash"></i></button>
            </div>
          </td>

          </tr>
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
</div>

    </div>
  </div>

  <script>
    function updateClock() {
      const now = new Date();
      const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
      document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', options);
      document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID', { hour12: false });
    }
    setInterval(updateClock, 1000);
    updateClock();
  </script>
</body>
</html>