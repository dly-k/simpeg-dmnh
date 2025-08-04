<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIKEMAH - Editor Kegiatan Pengabdian</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
      overflow: hidden;
    }

    .sidebar {
      width: 250px;
      background: white;
      padding: 20px;
      box-shadow: 2px 0 5px rgba(0,0,0,0.1);
      overflow-y: auto;
      flex-shrink: 0;
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

    .menu-item.active, .sidebar ul ul .menu-item.active-sub {
      background-color: #d1fae5;
      color: #059669;
      font-weight: 600;
    }
    
    .menu-item.active-main {
        background-color: #059669;
        color: white;
        font-weight: 600;
    }
     .menu-item.active-main i {
        color: white;
    }


    .main {
      flex: 1;
      display: flex;
      flex-direction: column;
      overflow-y: hidden;
    }

    .header {
      background: white;
      display: flex;
      justify-content: space-between;
      padding: 15px 30px;
      border-bottom: 1px solid #e2e8f0;
      align-items: center;
      flex-shrink: 0;
    }

    .title-bar {
      background: linear-gradient(to right, #059669, #047857);
      color: white;
      padding: 20px 30px;
      flex-shrink: 0;
    }

    .title-bar h1 {
      font-size: 24px;
      margin: 0;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .content-area {
      padding: 30px;
      flex-grow: 1;
      overflow-y: auto;
    }

    .card {
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }
    
    .table {
        vertical-align: middle;
    }

    .table th {
        font-weight: 600;
    }
    
    .btn-aksi {
        width: 32px;
        height: 32px;
        border-radius: 6px !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        color: white;
        text-decoration: none;
    }
    .btn-lihat { background-color: #0dcaf0; border-color: #0dcaf0; }
    .btn-edit { background-color: #ffc107; border-color: #ffc107; }
    .btn-hapus { background-color: #dc3545; border-color: #dc3545; }
    .btn-verifikasi { background-color: #10b981; border-color: #10b981; }


    .footer {
      text-align: right;
      font-size: 12px;
      color: #a0aec0;
      padding: 10px 30px;
      flex-shrink: 0;
    }
    .btn-tambah {
        background-color: #2d3748;
        color: white;
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
          <li><a href="/dashboard" class="menu-item"><i class="fa fa-chart-bar"></i> Dashboard</a></li>
          <li><a href="/daftar-pegawai" class="menu-item"><i class="fa fa-users"></i> Daftar Pegawai</a></li>
          <li><a href="/surat-tugas" class="menu-item"><i class="fa fa-envelope"></i> Manajemen Surat Tugas</a></li>
          <li><a href="/editor" class="menu-item active-main"><i class="fa fa-edit"></i> Editor Kegiatan</a></li>
          <ul style="margin-left: 20px;">
              <li><a href="/pendidikan" class="menu-item">🎓 Pendidikan</a></li>
              <li><a href="/penelitian" class="menu-item">🔬 Penelitian</a></li>
              <li><a href="/pengabdian" class="menu-item active-sub">🤝 Pengabdian</a></li>
              <li><a href="/penunjang" class="menu-item">📎 Penunjang</a></li>
              <li><a href="/pelatihan" class="menu-item">📚 Pelatihan</a></li>
              <li><a href="/penghargaan" class="menu-item">🏅 Penghargaan</a></li>
              <li><a href="/sk-non-pns" class="menu-item">📄 SK Non PNS</a></li>
          </ul>
          <li><a href="/kerjasama" class="menu-item"><i class="fa fa-handshake"></i> Kerjasama</a></li>
          <li><a href="/master-data" class="menu-item"><i class="fa fa-database"></i> Master Data</a></li>
      </ul>
    </div>

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
        <h1><i class="fa fa-edit"></i> Editor Kegiatan - Pengabdian</h1>
      </div>

      <div class="content-area">
        <div class="card">
            <!-- Filters and Actions -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div class="d-flex gap-2 flex-wrap">
                    <select class="form-select" style="width: auto;"><option selected>Tahun</option><option>2012</option></select>
                    <select class="form-select" style="width: auto;"><option selected>Jenis SKIM</option></select>
                    <select class="form-select" style="width: auto;"><option selected>Afiliasi</option></select>
                    <div class="input-group" style="width: 250px;">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control border-start-0" placeholder="Cari Data ....">
                    </div>
                </div>
                <a href="#" class="btn btn-tambah fw-bold"><i class="fa fa-plus me-2"></i> Tambah Data</a>
            </div>

            <!-- Table -->
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                  <thead class="table-light">
                      <tr class="text-center">
                          <th>No</th>
                          <th class="text-start">Kegiatan</th>
                          <th>Nama Kegiatan</th>
                          <th>Afiliasi</th>
                          <th>Lokasi</th>
                          <th>Nomor SK</th>
                          <th>Tahun</th>
                          <th>Verifikasi</th>
                          <th>Dokumen</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                      <script>
                          for(let i=1; i<=11; i++){ 
                              document.write(`
                                  <tr>
                                      <td class="text-center">${i}</td>
                                      <td class="text-start">Pengaruh Air Terhadap Tumbuh Kembang Lele</td>
                                      <td class="text-center">24 Desember 2021</td>
                                      <td class="text-center">Jurnal</td>
                                      <td class="text-center">Ya</td>
                                      <td class="text-center">SK-129013a7uw</td>
                                      <td class="text-center">2012</td>
                                      <td class="text-center">${i % 2 === 0 ? '<i class="fas fa-check-circle text-success"></i>' : '<i class="fas fa-times-circle text-danger"></i>'}</td>
                                      <td class="text-center"><a href="#" class="btn btn-sm btn-info text-white">Lihat</a></td>
                                      <td class="text-center">
                                          <div class="d-flex gap-2 justify-content-center">
                                              <a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi Data"><i class="fa fa-check"></i></a>
                                              <a href="#" class="btn-aksi btn-lihat" title="Lihat Detail"><i class="fa fa-eye"></i></a>
                                              <a href="#" class="btn-aksi btn-edit" title="Edit Data"><i class="fa fa-edit"></i></a>
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

      <div class="footer">
        © 2025 Forest Management — All Rights Reserved
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
