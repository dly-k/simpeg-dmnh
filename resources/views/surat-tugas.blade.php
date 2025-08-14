<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>SIKEMAH - Manajemen Surat Tugas</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/surat-tugas.css') }}" />
</head>

<body>
<div class="layout">
  <div class="sidebar" id="sidebar">
    <div class="brand">SI<span>KEMAH</span></div>
    <div class="menu-wrapper">
      <div class="menu">
        <a href="/dashboard" aria-label="Dashboard"><i class="lni lni-grid-alt"></i> Dashboard</a>
        <p>Menu Utama</p>
        <a href="/daftar-pegawai" aria-label="Daftar Pegawai"><i class="lni lni-users"></i> Daftar Pegawai</a>
        <a href="/surat-tugas" aria-label="Manajemen Surat Tugas" class="active"><i class="lni lni-folder"></i> Manajemen Surat Tugas</a>
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

  <div class="overlay" id="overlay"></div>

  <div class="main-wrapper">
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
      <h1><i class="lni lni-folder"></i> <span id="page-title">Manajemen Surat Tugas</span></h1>
    </div>

  <div class="main-content">
  <div class="table-card">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
      
      <div class="d-flex align-items-center flex-wrap gap-2 flex-grow-1" style="min-width: 0;">
        
        <div class="search-group flex-grow-1">
          <div class="input-group search-box bg-white" style="border-radius: .5rem; min-width: 280px;">
            <span class="input-group-text bg-light border-end-0">
              <i class="fas fa-search" style="color: green;"></i>
            </span>
            <input type="text" class="form-control border-start-0 search-input" placeholder="Cari Data...">
          </div>
        </div>

        <div style="min-width: 120px;">
          <select class="form-select filter-select">
            <option selected>Tahun</option>
            <option>2021</option>
            <option>2022</option>
            <option>2023</option>
          </select>
        </div>

        <div class="d-flex gap-2">
          <a href="#" class="btn btn-export fw-bold">
            <i class="fa fa-file-excel me-2"></i> Export Excel
          </a>
          <a href="#" class="btn btn-tambah fw-bold" onclick="openModal('suratTugasModal')">
            <i class="fa fa-plus me-2"></i> Tambah Data
          </a>
        </div>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-hover table-bordered">
        <thead class="table-light">
          <tr class="text-center">
            <th>No</th>
            <th class="text-start">Nama Dosen</th>
            <th>Peran</th>
            <th>Diminta Sebagai</th>
            <th>Mitra/Instansi</th>
            <th>No & Tgl Surat Instansi</th>
            <th>No & Tgl Surat Kadep</th>
            <th>Tgl Kegiatan</th>
            <th>Ket. Lokasi</th>
            <th>Dokumen</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="data-body"></tbody>
      </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3">
      <span class="text-muted small">Menampilkan 3 dari 13 data</span>
      <nav aria-label="Page navigation">
        <ul class="pagination pagination-sm mb-0">
          <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
          <li class="page-item active"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item"><a class="page-link" href="#">Berikutnya</a></li>
        </ul>
      </nav>
    </div>
  </div>
</div>
    <footer class="footer-custom">
      <span>© 2025 Forest Management — All Rights Reserved</span>
    </footer>
  </div>
  
  <div class="modal-backdrop" id="suratTugasModal">
      <div class="modal-content-wrapper">
          <div class="modal-header-custom">
              <h5 id="modalTitle"><i class="fas fa-plus-circle"></i> Tambah Surat Tugas</h5>
          </div>
          <div class="modal-body-custom">
              <form>
                  <div class="row g-3">
                      <div class="col-12"><label class="form-label">Nama Dosen</label><select class="form-select"><option selected>-- Pilih Salah Satu --</option><option>Dr. Stone</option></select></div>
                      <div class="col-12"><label class="form-label">Peran</label><input type="text" class="form-control" placeholder="Masukkan peran. Contoh: Narasumber, Pembicara, Moderator"></div>
                      <div class="col-12"><label class="form-label">Pemohon / Menjadi</label><input type="text" class="form-control" placeholder="2020/2021"></div>
                      <div class="col-12"><label class="form-label">Mitra / Nama Instansi</label><input type="text" class="form-control" placeholder="2020/2021"></div>
                      <div class="col-md-6"><label class="form-label">No & Tanggal Surat Instansi</label><input type="text" class="form-control" placeholder="001/INT/2025 - 1 Juni 2025"></div>
                      <div class="col-md-6"><label class="form-label">No & Tanggal Surat Kadep</label><input type="text" class="form-control" placeholder="001/INT/2025 - 1 Juni 2025"></div>
                      <div class="col-md-6"><label class="form-label">Tanggal Kegiatan</label><input type="date" class="form-control"></div>
                      <div class="col-md-6"><label class="form-label">Link Surat Tugas Dekan</label><input type="text" class="form-control" placeholder="Praktikum"></div>
                      <div class="col-12"><label class="form-label">Lokasi Kegiatan</label><input type="text" class="form-control" placeholder="Praktikum"></div>
                      <div class="col-12">
                          <label class="form-label">Upload File</label>
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
              <button type="button" class="btn btn-danger" onclick="closeModal('suratTugasModal')">Batal</button>
              <button type="button" class="btn btn-success" id="btnSimpanData">Simpan</button>
          </div>
      </div>
  </div>

  <div class="konfirmasi-hapus-overlay" id="modalKonfirmasiHapus">
      <div class="konfirmasi-hapus-box">
          <div class="konfirmasi-hapus-icon">
              <i class="fas fa-exclamation"></i>
          </div>
          <h3 class="konfirmasi-hapus-title">Apakah Anda Yakin Menghapus Data Ini?</h3>
          <p class="konfirmasi-hapus-subtitle">Data ini akan dihapus dari permanen sistem.</p>
          <div class="konfirmasi-hapus-buttons">
              <button class="btn-popup btn-hapus" id="btnKonfirmasiHapus">Ya, Hapus</button>
              <button class="btn-popup btn-batal" id="btnBatalHapus">Batal</button>
          </div>
      </div>
  </div>

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

  <script src="{{ asset('assets/js/surat-tugas.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>