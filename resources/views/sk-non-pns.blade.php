<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIKEMAH - Editor Kegiatan SK Non PNS</title>
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
    
    /* Modal Styles */
    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0,0,0,0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1050;
        padding: 1rem;
    }
    .modal-content-wrapper {
        background-color: #fff;
        border-radius: .5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,.5);
        width: 100%;
        max-width: 800px;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
    }
    .modal-header-custom {
        background: linear-gradient(to right, #059669, #047857);
        color: white;
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
        border-top: 1px solid #e2e8f0;
    }
    .upload-area {
        border: 2px dashed #dee2e6;
        border-radius: .5rem;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: background-color .2s;
    }
    .upload-area:hover {
        background-color: #f8f9fa;
    }
    .upload-area i {
        font-size: 2rem;
        color: #6c757d;
    }
    .upload-area p {
        margin-top: 1rem;
        color: #6c757d;
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
              <li><a href="/pengabdian" class="menu-item">🤝 Pengabdian</a></li>
              <li><a href="/penunjang" class="menu-item">📎 Penunjang</a></li>
              <li><a href="/pelatihan" class="menu-item">📚 Pelatihan</a></li>
              <li><a href="/penghargaan" class="menu-item">🏅 Penghargaan</a></li>
              <li><a href="/sk-non-pns" class="menu-item active-sub">📄 SK Non PNS</a></li>
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
        <h1><i class="fa fa-edit"></i> Editor Kegiatan - SK Non PNS</h1>
      </div>

      <div class="content-area">
        <div class="card">
            <!-- Filters and Actions -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div class="d-flex gap-2 flex-wrap">
                    <div class="input-group" style="width: 250px;">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control border-start-0" placeholder="Cari Data ....">
                    </div>
                </div>
                <a href="#" class="btn btn-tambah fw-bold" onclick="openModal('skNonPnsModal')"><i class="fa fa-plus me-2"></i> Tambah Data</a>
            </div>

            <!-- Table -->
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                  <thead class="table-light">
                      <tr class="text-center">
                          <th>No</th>
                          <th class="text-start">Nama Kegiatan</th>
                          <th>Unit</th>
                          <th>Nomor SK</th>
                          <th>Tanggal</th>
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
                                      <td class="text-center">12 Januari 2023</td>
                                      <td class="text-center"><a href="#" class="btn btn-sm btn-info text-white">Lihat</a></td>
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

      <div class="footer">
        © 2025 Forest Management — All Rights Reserved
      </div>
    </div>
  </div>
  
  <!-- Modal Tambah/Edit SK Non PNS -->
    <div class="modal-backdrop" id="skNonPnsModal">
        <div class="modal-content-wrapper">
            <div class="modal-header-custom">
                <h5 id="modalTitle"><i class="fas fa-plus-circle"></i> Tambah Data SK Non PNS</h5>
            </div>
            <div class="modal-body-custom">
                <form id="skNonPnsForm">
                    <div class="row g-3">
                        <div class="col-12"><label class="form-label">Pegawai</label><input type="text" class="form-control" placeholder="Lorem Ipsum"></div>
                        <div class="col-12"><label class="form-label">Unit</label><select class="form-select"><option selected>Lorem Ipsum</option></select></div>
                        <div class="col-md-6"><label class="form-label">Tanggal Mulai</label><input type="date" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Tanggal Selesai</label><input type="date" class="form-control"></div>
                        <div class="col-12"><label class="form-label">Nomor SK</label><input type="text" class="form-control" placeholder="Lorem Ipsum"></div>
                        <div class="col-12"><label class="form-label">Tanggal SK</label><input type="date" class="form-control"></div>
                        <div class="col-12"><label class="form-label">Jenis SK</label><select class="form-select"><option selected>Lorem Ipsum</option></select></div>
                        <div class="col-12">
                            <label class="form-label">Jenis Dokumen</label>
                            <div class="upload-area">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Drag & Drop File here<br><small>Ukuran Maksimal 5 MB</small></p>
                                <input type="file" hidden>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn btn-danger" onclick="closeModal('skNonPnsModal')">Batal</button>
                <button type="button" class="btn btn-success">Simpan</button>
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
    
    // Modal Functions
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        const modalTitle = modal.querySelector('#modalTitle');
        modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data SK Non PNS';
        modal.querySelector('form').reset();
        if (modal) {
            modal.style.display = 'flex';
        }
    }
    
    function openEditModal() {
        const modal = document.getElementById('skNonPnsModal');
        const modalTitle = modal.querySelector('#modalTitle');
        modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data SK Non PNS';
        // Di sini Anda akan mengisi form dengan data yang ada
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

    // Close modal if backdrop is clicked
    window.onclick = function(event) {
        if (event.target.classList.contains('modal-backdrop')) {
            closeModal(event.target.id);
        }
    }
  </script>
</body>
</html>
