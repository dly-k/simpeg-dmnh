<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIKEMAH - Editor Kegiatan Penelitian</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

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

    .layout {
      display: flex;
      height: 100vh;
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

    .sidebar .menu-wrapper {
      overflow-y: auto;
      flex-grow: 1;
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
    }
    .sidebar .menu a.active,
    .sidebar .menu button.active {
      background-color: var(--primary);
      color: #fff;
      font-weight: 600;
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
      padding: 9px 20px 9px 45px;
      font-size: 12.5px;
    }
     .sidebar .submenu a.active {
        color: var(--primary);
        font-weight: 600;
        background-color: var(--primary-light);
    }
    
    .toggle-icon {
      margin-left: auto;
      transition: transform 0.3s;
    }
    .collapsed .toggle-icon { transform: rotate(-90deg); }

    /* Overlay for mobile sidebar */
    .overlay {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.4);
      z-index: 1000;
      display: none;
    }
    .overlay.show { display: block; }
    
    /* Main Area */
    .main-wrapper {
        flex-grow: 1;
        margin-left: 250px;
        transition: margin-left 0.3s ease-in-out;
        display: flex;
        flex-direction: column;
        height: 100vh;
    }
    .sidebar.hidden ~ .main-wrapper {
        margin-left: 0;
    }

    /* Navbar */
    .navbar-custom {
      height: 66px;
      background: #fff;
      border-bottom: 1px solid var(--border-color);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 20px;
      flex-shrink: 0;
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
    .account-circle {
      background: orange;
      color: #fff;
      border-radius: 50%;
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 12px;
    }

    /* Title Bar */
    .title-bar {
      background: linear-gradient(to right, #059669, #047857);
      color: white;
      padding: 20px 25px;
      display: flex;
      align-items: center;
      flex-shrink: 0;
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

    /* Main Content */
    .main-content {
      padding: 25px;
      background-color: #f5f6fa;
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

    .btn-tambah {
        background-color: #2d3748;
        color: white;
    }
    .btn-tambah:hover {
        background-color: #1a202c;
        color: white;
    }

    /* Footer */
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
      flex-shrink: 0;
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
    
    /* Responsive */
    @media (max-width: 991px) {
      .sidebar { transform: translateX(-100%); }
      .sidebar.show { transform: translateX(0); }
      .main-wrapper { margin-left: 0; }
      .time-date { flex-direction: column; gap: 6px; align-items: flex-start; }
      .account span { font-size: 12px; }
      .sidebar .menu a, .sidebar .menu button { font-size: 12.5px; }
    }
  </style>
</head>
<body>

<div class="layout">
  <!-- Sidebar -->
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
          <a href="/penelitian" aria-label="Penelitian" class="active">Penelitian</a>
          <a href="/pengabdian" aria-label="Pengabdian">Pengabdian</a>
          <a href="/penunjang" aria-label="Penunjang">Penunjang</a>
          <a href="/pelatihan" aria-label="Pelatihan">Pelatihan</a>
          <a href="/penghargaan" aria-label="Penghargaan">Penghargaan</a>
          <a href="/sk-non-pns" aria-label="SK Non PNS">SK Non PNS</a>
        </div>
        <a href="/kerjasama" aria-label="Kerjasama"><i class="lni lni-handshake"></i> Kerjasama</a>
        <a href="/master-data" aria-label="Master Data"><i class="lni lni-database"></i> Master Data</a>
      </div>
    </div>
  </div>

  <!-- Overlay -->
  <div class="overlay" id="overlay"></div>

  <div class="main-wrapper">
    <!-- Navbar -->
    <div class="navbar-custom">
      <div class="d-flex align-items: center">
        <button class="btn btn-link text-dark me-3" id="toggleSidebar" aria-label="Toggle Sidebar">
          <i class="lni lni-menu"></i>
        </button>
      </div>
      <div class="d-flex align-items: center">
        <div class="time-date me-2">
          <div><i class="lni lni-calendar"></i> <span id="current-date"></span></div>
          <div><i class="lni lni-timer"></i> <span id="current-time"></span></div>
        </div>
        <div class="account">
          <div class="account-circle">KTU</div>
          <span>Halo, Ketua TU</span>
          <i class="lni lni-chevron-down"></i>
        </div>
      </div>
    </div>

    <!-- Title Bar -->
    <div class="title-bar">
      <h1><i class="lni lni-pencil-alt"></i> <span id="page-title">Editor Kegiatan - Penelitian</span></h1>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="card">
            <!-- Filters and Actions -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div class="d-flex gap-2 flex-wrap">
                    <select class="form-select" style="width: auto;"><option selected>Tahun</option><option>2021</option></select>
                    <select class="form-select" style="width: auto;"><option selected>Jenis Karya</option><option>Jurnal</option></select>
                    <div class="input-group" style="width: 250px;">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control border-start-0" placeholder="Cari Data ....">
                    </div>
                </div>
                <a href="#" class="btn btn-tambah fw-bold" onclick="openModal('penelitianModal')"><i class="fa fa-plus me-2"></i> Tambah Data</a>
            </div>

            <!-- Table -->
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                  <thead class="table-light">
                      <tr class="text-center">
                          <th>No</th>
                          <th class="text-start">Judul</th>
                          <th>Tanggal Terbit</th>
                          <th>Jenis Karya</th>
                          <th>Publik</th>
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
                                      <td class="text-center">${i % 2 === 0 ? '<i class="fas fa-check-circle text-success"></i>' : '<i class="fas fa-times-circle text-danger"></i>'}</td>
                                      <td class="text-center"><a href="#" class="btn btn-sm btn-info text-white">Lihat</a></td>
                                      <td class="text-center">
                                          <div class="d-flex gap-2 justify-content-center">
                                              <a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi Data"><i class="fa fa-check"></i></a>
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

    <!-- Footer -->
    <footer class="footer-custom">
      <span>© 2025 Forest Management — All Rights Reserved</span>
    </footer>
  </div>
  
  <!-- Modal Tambah/Edit Penelitian -->
    <div class="modal-backdrop" id="penelitianModal">
        <div class="modal-content-wrapper">
            <div class="modal-header-custom">
                <h5 id="modalTitle"><i class="fas fa-plus-circle"></i> Tambah Data Penelitian</h5>
            </div>
            <div class="modal-body-custom">
                <form id="penelitianForm">
                    <div class="row g-3">
                        <div class="col-12"><label class="form-label">Judul</label><input type="text" class="form-control" name="judul" placeholder="Melaksanakan Perkuliahan/Tutorial/Perkuliahan Praktikum & Membimbing...."></div>
                        <div class="col-12"><label class="form-label">Jenis Karya</label><select class="form-select" name="jenisKarya"><option selected>-- Pilih Salah Satu --</option></select></div>
                        <div class="col-md-6"><label class="form-label">Volume/Issue</label><input type="text" class="form-control" name="volume" placeholder="2020/2021"></div>
                        <div class="col-md-6"><label class="form-label">Jumlah Halaman</label><select class="form-select" name="jumlahHalaman"><option selected>-- Pilih Salah Satu --</option></select></div>
                        <div class="col-md-6"><label class="form-label">Tanggal Terbit</label><input type="date" class="form-control" name="tanggalTerbit"></div>
                        <div class="col-md-6"><label class="form-label">Publik</label><select class="form-select" name="publik"><option selected>-- Pilih Salah Satu --</option><option value="Ya">Ya</option><option value="Tidak">Tidak</option></select></div>
                        <div class="col-md-6"><label class="form-label">ISBN</label><input type="text" class="form-control" name="isbn" placeholder="Masukkan ISBN Anda"></div>
                        <div class="col-md-6"><label class="form-label">ISSN</label><input type="text" class="form-control" name="issn" placeholder="Masukkan ISSN Anda"></div>
                        <div class="col-md-6"><label class="form-label">DOI</label><input type="text" class="form-control" name="doi" placeholder="2020/2021"></div>
                        <div class="col-md-6"><label class="form-label">URL</label><input type="text" class="form-control" name="url" placeholder="2020/2021"></div>

                        <div class="col-12">
                            <label class="form-label">Dokumen Terkait</label>
                            <div class="upload-area">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Drag & Drop File here<br><small>Ukuran Maksimal 5 MB</small></p>
                                <input type="file" hidden>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Penulis IPB</label>
                            <div id="penulis-ipb-list">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" placeholder="Nama">
                                    <label class="input-group-text">Upload SK</label>
                                    <input type="file" class="form-control">
                                    <button class="btn btn-outline-success" type="button" onclick="addPenulis('penulis-ipb-list')">+ Tambah</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Penulis Luar IPB</label>
                            <div id="penulis-luar-list">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" placeholder="Nama">
                                    <label class="input-group-text">Upload SK</label>
                                    <input type="file" class="form-control">
                                    <button class="btn btn-outline-success" type="button" onclick="addPenulis('penulis-luar-list')">+ Tambah</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Penulis Mahasiswa</label>
                            <div id="penulis-mahasiswa-list">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" placeholder="Nama">
                                    <button class="btn btn-outline-success" type="button" onclick="addPenulis('penulis-mahasiswa-list')">+ Tambah</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn btn-danger" onclick="closeModal('penelitianModal')">Batal</button>
                <button type="button" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const toggleSidebarBtn = document.getElementById('toggleSidebar');

    toggleSidebarBtn.addEventListener('click', function () {
      const isMobile = window.innerWidth <= 991;
      if (isMobile) {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show', sidebar.classList.contains('show'));
      } else {
        sidebar.classList.toggle('hidden');
      }
    });

    overlay.addEventListener('click', function () {
      sidebar.classList.remove('show');
      overlay.classList.remove('show');
    });

    function updateDateTime() {
      const now = new Date();
      const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
      document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', options);
      document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID', { 
        hour: '2-digit', 
        minute: '2-digit', 
        second: '2-digit'
      });
    }
    setInterval(updateDateTime, 1000);
    updateDateTime();
    
    let penulisCounter = 0;
    // Modal Functions
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        const modalTitle = modal.querySelector('#modalTitle');
        modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Penelitian';
        modal.querySelector('form').reset();

        // Reset dynamic fields
        document.getElementById('penulis-ipb-list').innerHTML = `<div class="input-group mb-2"><input type="text" class="form-control" placeholder="Nama"><label class="input-group-text">Upload SK</label><input type="file" class="form-control"><button class="btn btn-outline-success" type="button" onclick="addPenulis('penulis-ipb-list')">+ Tambah</button></div>`;
        document.getElementById('penulis-luar-list').innerHTML = `<div class="input-group mb-2"><input type="text" class="form-control" placeholder="Nama"><label class="input-group-text">Upload SK</label><input type="file" class="form-control"><button class="btn btn-outline-success" type="button" onclick="addPenulis('penulis-luar-list')">+ Tambah</button></div>`;
        document.getElementById('penulis-mahasiswa-list').innerHTML = `<div class="input-group mb-2"><input type="text" class="form-control" placeholder="Nama"><button class="btn btn-outline-success" type="button" onclick="addPenulis('penulis-mahasiswa-list')">+ Tambah</button></div>`;

        if (modal) {
            modal.style.display = 'flex';
        }
    }
    
    function openEditModal() {
        const modal = document.getElementById('penelitianModal');
        const modalTitle = modal.querySelector('#modalTitle');
        modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Penelitian';
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
    
    function addPenulis(listId) {
        penulisCounter++;
        const list = document.getElementById(listId);
        const newInput = document.createElement('div');
        newInput.className = 'input-group mb-2';
        
        let inputFields = `<input type="text" class="form-control" placeholder="Nama">`;
        if (listId !== 'penulis-mahasiswa-list') {
            inputFields += `<label class="input-group-text" for="upload-sk-${penulisCounter}">Upload SK</label><input type="file" class="form-control" id="upload-sk-${penulisCounter}">`;
        }
        
        newInput.innerHTML = `${inputFields}<button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">-</button>`;
        list.appendChild(newInput);
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
