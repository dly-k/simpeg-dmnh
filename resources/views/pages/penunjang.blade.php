<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>SIKEMAH - Editor Kegiatan (Penunjang)</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/penunjang.css') }}" />
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="brand">SI<span>KEMAH</span></div>
    <div class="menu-wrapper">
      <div class="menu">
        <a href="/dashboard" aria-label="Dashboard"><i class="lni lni-grid-alt"></i> Dashboard</a>

        <p>Menu Utama</p>
        <a href="/daftar-pegawai"><i class="lni lni-users"></i> Daftar Pegawai</a>
        <a href="/surat-tugas"><i class="lni lni-folder"></i> Manajemen Surat Tugas</a>

        <button class="active" data-bs-toggle="collapse" data-bs-target="#editorKegiatan" aria-expanded="true">
          <i class="lni lni-pencil-alt"></i> Editor Kegiatan
          <i class="lni lni-chevron-down toggle-icon"></i>
        </button>

        <div class="collapse show submenu" id="editorKegiatan">
          <a href="/pendidikan">Pendidikan</a>
          <a href="/penelitian">Penelitian</a>
          <a href="/pengabdian">Pengabdian</a>
          <a href="/penunjang" class="active">Penunjang</a>
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

  <!-- Navbar -->
  <div class="navbar-custom">
    <div class="d-flex align-items-center">
      <button class="btn btn-link text-dark me-3" id="toggleSidebar">
        <i class="lni lni-menu"></i>
      </button>
    </div>

    <div class="d-flex align-items-center">
      <div class="time-date me-2">
        <div><i class="lni lni-calendar"></i> <span id="current-date"></span></div>
        <div><i class="lni lni-timer"></i> <span id="current-time"></span></div>
      </div>

      <div class="dropdown">
        <a href="#" class="account text-decoration-none text-dark" data-bs-toggle="dropdown">
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

  <!-- Title Bar -->
  <div class="title-bar">
    <h1><i class="lni lni-pencil-alt"></i> <span id="page-title">Editor Kegiatan - Penunjang</span></h1>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="card">
      <!-- Search & Filter -->
      <div class="search-filter-container">
        <div class="search-filter-row">
          <div class="search-box">
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0">
                <i class="fas fa-search text-success"></i>
              </span>
              <input type="text" class="form-control border-start-0 search-input" placeholder="Cari Data ....">
            </div>
          </div>

          <select class="form-select filter-select">
            <option selected>Tahun</option>
            <option>2024</option>
            <option>2025</option>
          </select>

          <select class="form-select filter-select">
            <option selected>Lingkup</option>
            <option>Lokal</option>
            <option>Nasional</option>
            <option>Internasional</option>
          </select>

          <select class="form-select filter-select">
            <option selected>Status</option>
            <option>Sudah Diverifikasi</option>
            <option>Belum Diverifikasi</option>
            <option>Ditolak</option>
          </select>

          <div class="btn-tambah-container">
            <a href="#" class="btn btn-tambah fw-bold" onclick="openModal('penunjangModal')">
              <i class="fa fa-plus me-2"></i> Tambah Data
            </a>
          </div>
        </div>
      </div>

      <!-- Table -->
      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead class="table-light">
            <tr class="text-center">
              <th>No</th>
              <th>Kegiatan</th>
              <th>Lingkup</th>
              <th>Nama</th>
              <th>Instansi</th>
              <th>Nomor SK</th>
              <th>TMT</th>
              <th>TST</th>
              <th>Verifikasi</th>
              <th>Dokumen</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <script>
              for (let i = 1; i <= 10; i++) {
                document.write(`
                  <tr>
                    <td class="text-center">${i}</td>
                    <td class="text-start">Pengaruh Air Terhadap Tumbuh Kembang Lele</td>
                    <td class="text-center">Nasional</td>
                    <td class="text-center">Jurnal</td>
                    <td class="text-center">Ya</td>
                    <td class="text-center">SK-129013a7uw</td>
                    <td class="text-center">25 Jun 2024</td>
                    <td class="text-center">25 Jun 2024</td>
                    <td class="text-center">
                      ${i % 2 === 0 
                        ? '<i class="fas fa-check-circle text-success"></i>' 
                        : '<i class="fas fa-times-circle text-danger"></i>'}
                    </td>
                    <td class="text-center">
                      <a href="#" class="btn btn-sm btn-lihat-detail text-white">Lihat</a>
                    </td>
                    <td class="text-center">
                      <div class="d-flex gap-2 justify-content-center">
                        <a href="#" class="btn-aksi btn-verifikasi"><i class="fa fa-check"></i></a>
                        <a href="#" class="btn-aksi btn-lihat" title="Lihat Detail Penunjang" data-bs-toggle="modal" data-bs-target="#penunjangDetailModal">
                          <i class="fa fa-eye"></i>
                        </a>
                        <a href="#" class="btn-aksi btn-edit" title="Edit Data" onclick="openEditModal()"><i class="fa fa-edit"></i></a>
                      <a href="#" class="btn-aksi btn-hapus" title="Hapus Data">
                        <i class="fa fa-trash"></i>
                      </a>
                      </div>
                    </td>
                  </tr>
                `);
              }
            </script>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
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

  <!-- Kumpulan Modal -->
  @include('components.konfirmasi-hapus')
  @include('components.konfirmasi-berhasil')
  @include('components.konfirmasi-verifikasi')
  @include('components.penunjang.tambah-penunjang')
  @include('components.penunjang.detail-penunjang')

  <!-- Scripts -->
  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="{{ asset('assets/js/penunjang.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>