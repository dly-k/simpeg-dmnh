<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <title>SIKEMAH - Daftar Pegawai</title>
  
  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/daftar-pegawai.css') }}" />
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
        <a href="/daftar-pegawai" aria-label="Daftar Pegawai" class="active"><i class="lni lni-users"></i> Daftar Pegawai</a>
        <a href="/surat-tugas" aria-label="Manajemen Surat Tugas"><i class="lni lni-folder"></i> Manajemen Surat Tugas</a>
        <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#editorKegiatan" aria-expanded="false" aria-controls="editorKegiatan">
          <i class="lni lni-pencil-alt"></i> Editor Kegiatan
          <i class="lni lni-chevron-down toggle-icon"></i>
        </button>
        <div class="collapse submenu" id="editorKegiatan">
          <a href="/pendidikan" aria-label="Pendidikan">Pendidikan</a>
          <a href="/penelitian" aria-label="Penelitian">Penelitian</a>
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
    </div>

    <!-- Title Bar -->
    <div class="title-bar">
      <h1><i class="lni lni-users"></i> <span id="page-title">Daftar Pegawai</span></h1>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <div class="table-card">
        <!-- Top Action Bar -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
      
      <!-- Left side: Search & Filter -->
      <div class="d-flex align-items-center flex-wrap gap-2 flex-grow-1" style="min-width: 0;">
        
        <!-- Search Input -->
        <div class="search-group flex-grow-1">
          <div class="input-group bg-white" style="border-radius: .5rem; min-width: 180px;">
            <span class="input-group-text bg-light border-end-0">
              <i class="fas fa-search" style="color: green;"></i>
            </span>
            <input type="text" 
                  class="form-control form-control-sm bg-transparent border-0" 
                  placeholder="Cari Data...">
          </div>
        </div>

        <!-- Filter Status Pegawai -->
        <div style="min-width: 120px;">
          <select class="form-select form-select-sm w-100">
            <option selected disabled>Status</option>
            <option value="aktif">Aktif</option>
            <option value="pensiun">Pensiun</option>
            <option value="diberhentikan">Diberhentikan</option>
            <option value="meninggal">Meninggal</option>
            <option value="kontrak_selesai">Kontrak Selesai</option>
            <option value="mengundurkan_diri">Mengundurkan Diri</option>
            <option value="mutasi">Mutasi</option>
            <option value="nonaktif">Nonaktif</option>
          </select>
        </div>

        <!-- Filter Kepegawaian -->
        <div style="min-width: 180px;">
          <select class="form-select form-select-sm w-100">
            <option selected disabled>Kepegawaian</option>
            <option value="pns">Dosen PNS</option>
            <option value="pppk">Dosen Tetap</option>
            <option value="honorer">Tendik Tetap</option>
            <option value="kontrak">Tendik Kontrak</option>
            <option value="dosen_tamu">Dosen Tamu</option>
            <option value="thl">THL</option>
          </select>
        </div>
      </div>

      <!-- Right side: Add Data Button -->
      <div>
        <button class="btn btn-tambah btn-sm fw-bold" style="background-color: #2d3748; color: white;" onclick="openModal('pegawaiModal')">
          <i class="fa fa-plus me-2"></i> Tambah Data
        </button>
      </div>
    </div>


        <!-- Table -->
        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead class="table-light">
              <tr class="text-center">
                <th>No</th>
                <th class="text-start">Nama Lengkap</th>
                <th>NIP</th>
                <th>Status Kepegawaian</th>
                <th>Jabatan Fungsional</th>
                <th>Jabatan Struktural</th>
                <th>Pangkat/Gol</th>
                <th>Status Pegawai</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <script>
                const data = [
                  { name: 'Joko Anwar S.pd', nip: '194909061979031001', status_kepegawaian: 'Dosen tetap', jabatan_fungsional: 'Lektor', jabatan_struktural: 'Ketua Departemen', pangkat: 'Penata Muda / III-a', status_pegawai: 'Meninggal' },
                  { name: 'Dr. Soni Trison, S.Hut, M.Si', nip: '197801012003121002', status_kepegawaian: 'Dosen PNS', jabatan_fungsional: 'Lektor Kepala', jabatan_struktural: 'Kepala Divisi', pangkat: 'Pembina / IV-a', status_pegawai: 'Aktif' },
                  { name: 'Ria Kodariah, S.Si', nip: '198103152005012001', status_kepegawaian: 'Tendik Tetap', jabatan_fungsional: '-', jabatan_struktural: 'Staf Administrasi', pangkat: 'Pengatur / II-c', status_pegawai: 'Pensiun' },
                  { name: 'Meli Surnami', nip: '198505202015042001', status_kepegawaian: 'Tendik Tetap', jabatan_fungsional: '-', jabatan_struktural: 'Staf Keuangan', pangkat: 'Penata Muda / III-a', status_pegawai: 'Nonaktif' },
                ];
                
                data.forEach((item, index) => {
                  document.write(`
                    <tr>
                      <td class="text-center">${index + 1}</td>
                      <td>${item.name}</td>
                      <td class="text-center">${item.nip}</td>
                      <td class="text-center">${item.status_kepegawaian}</td>
                      <td class="text-center">${item.jabatan_fungsional}</td>
                      <td class="text-center">${item.jabatan_struktural}</td>
                      <td class="text-center">${item.pangkat}</td>
                      <td class="text-center">
                        <span class="badge 
                          ${item.status_pegawai === 'Aktif' ? 'text-bg-success' : 
                            item.status_pegawai === 'Pensiun' ? 'text-bg-warning' :
                            item.status_pegawai === 'Diberhentikan' ? 'text-bg-danger' :
                            item.status_pegawai === 'Meninggal' ? 'text-bg-dark' :
                            item.status_pegawai === 'Kontrak Selesai' ? 'text-bg-info' :
                            item.status_pegawai === 'Mengundurkan Diri' ? 'text-bg-primary' :
                            item.status_pegawai === 'Mutasi' ? 'text-bg-secondary' :
                            item.status_pegawai === 'Nonaktif' ? 'text-bg-secondary' :
                            'text-bg-light'}">
                          ${item.status_pegawai}
                        </span>
                      </td>
                      <td class="text-center">
                        <div class="d-flex gap-2 justify-content-center">
                          <a href="/detail-pegawai" class="btn-aksi btn-lihat" title="Lihat Detail">
                            <i class="fa fa-eye"></i>
                          </a>
                          <a href="/edit-pegawai" class="btn-aksi btn-edit" title="Edit Data">
                            <i class="fa fa-edit"></i>
                          </a>
                          <a href="#" class="btn-aksi btn-hapus" title="Hapus Data">
                            <i class="fa fa-trash"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                  `);
                });
              </script>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
      <div class="d-flex justify-content-between align-items-center flex-wrap mt-3 w-100">
        <span class="text-muted small mb-2 mb-md-0">Menampilkan 4 dari 13 data</span>
        <nav aria-label="Page navigation">
          <ul class="pagination pagination-sm mb-0">
            <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">Berikutnya</a></li>
          </ul>
        </nav>
      </div>


    <!-- Footer -->
    <footer class="footer-custom">
      <span>© 2025 Forest Management — All Rights Reserved</span>
    </footer>
  </div>
  
  <!-- Modal Tambah/Edit Pegawai -->
    <div class="modal-backdrop" id="pegawaiModal">
        <div class="modal-content-wrapper">
            <div class="modal-header-custom">
                <h5 id="modalTitle"><i class="fas fa-plus-circle"></i> Tambah Data Pegawai</h5>
            </div>
            <div class="modal-body-custom">
                <form id="pegawaiForm">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Nama Lengkap</label><input type="text" class="form-control" name="name"></div>
                        <div class="col-md-6"><label class="form-label">NIP</label><input type="text" class="form-control" name="nip"></div>
                        <div class="col-md-6"><label class="form-label">Status Kepegawaian</label><select class="form-select" name="status_kepegawaian"><option>Tenaga Pendidik - Dosen</option><option>Tenaga Kependidikan</option></select></div>
                        <div class="col-md-6"><label class="form-label">Jabatan Fungsional</label><input type="text" class="form-control" name="jabatan_fungsional"></div>
                        <div class="col-md-6"><label class="form-label">Jabatan Struktural</label><input type="text" class="form-control" name="jabatan_struktural"></div>
                        <div class="col-md-6"><label class="form-label">Pangkat/Golongan</label><input type="text" class="form-control" name="pangkat"></div>
                        <div class="col-md-6"><label class="form-label">Status Pegawai</label><select class="form-select" name="status_pegawai"><option value="Aktif">Aktif</option><option value="Nonaktif">Nonaktif</option></select></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn btn-danger" onclick="closeModal('pegawaiModal')">Batal</button>
                <button type="button" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>

  <script src="{{ asset('assets/js/daftar-pegawai.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
