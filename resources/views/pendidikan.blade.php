<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIKEMAH - Editor Kegiatan Pendidikan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/pendidikan.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

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
          <a href="/pendidikan" aria-label="Pendidikan" class="active">Pendidikan</a>
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
    <h1><i class="lni lni-pencil-alt"></i> <span id="page-title">Editor Kegiatan - Pendidikan</span></h1>
  </div>

  <div class="main-content">
      <div class="card">
          <ul class="nav nav-tabs mb-4" id="pendidikanTab" role="tablist">
            <li class="nav-item" role="presentation"><button class="nav-link active" id="pengajaran-lama-tab" data-bs-toggle="tab" data-bs-target="#pengajaran-lama" type="button" role="tab">Pengajaran Lama</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="pengajaran-luar-tab" data-bs-toggle="tab" data-bs-target="#pengajaran-luar" type="button" role="tab">Pengajaran Luar IPB</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="pengujian-lama-tab" data-bs-toggle="tab" data-bs-target="#pengujian-lama" type="button" role="tab">Pengujian Lama</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="pembimbing-lama-tab" data-bs-toggle="tab" data-bs-target="#pembimbing-lama" type="button" role="tab">Pembimbing Lama</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="penguji-luar-tab" data-bs-toggle="tab" data-bs-target="#penguji-luar" type="button" role="tab">Penguji Luar IPB</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="pembimbing-luar-tab" data-bs-toggle="tab" data-bs-target="#pembimbing-luar" type="button" role="tab">Pembimbing Luar IPB</button></li>
          </ul>

          <div class="search-filter-container">
            <div class="search-filter-row">
                <div class="search-box">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search" style="color: green;"></i></span>
                        <input type="text" class="form-control search-input border-start-0" placeholder="Cari Data ....">
                    </div>
                </div>
                <select class="form-select filter-select"><option selected>Semester</option><option>Genap 2024/2025</option></select>
                <select class="form-select filter-select">
                  <option selected>Status</option><option>Sudah Diverifikasi</option><option>Belum Diverifikasi</option><option>Ditolak</option>
                </select>                <div class="btn-tambah-container">
                    <a href="#" class="btn btn-tambah fw-bold"><i class="fa fa-plus me-2"></i> Tambah Data</a>
                </div>
            </div>
          </div>

          <div class="tab-content" id="pendidikanTabContent">
            
            <div class="tab-pane fade show active" id="pengajaran-lama" role="tabpanel">
                <div class="table-responsive">
                  <table class="table table-hover table-bordered">
                      <thead class="table-light">
                          <tr class="text-center"><th>No</th><th class="text-start">Nama</th><th>Tahun Semester</th><th>Kode MK</th><th>Mata Kuliah</th><th>SKS</th><th>Kelas Paralel (Jenis)</th><th>Jumlah Pertemuan</th><th>Verifikasi</th><th>Dokumen</th><th>Aksi</th></tr>
                      </thead>
                      <tbody>
                          <script>for(let i=1; i<=8; i++){ document.write(`<tr><td class="text-center">${i}</td><td>Alex Kurniawan</td><td class="text-center">2018/2019 Ganjil</td><td class="text-center">MNH211</td><td>Biometrika Hutan</td><td class="text-center">3 (3-0)</td><td class="text-center">1 (K)</td><td class="text-center">K,S, P,O, R,O</td><td class="text-center">${i % 2 === 0 ? '<i class="fas fa-check-circle text-success"></i>' : '<i class="fas fa-times-circle text-danger"></i>'}</td><td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td><td class="text-center"><div class="d-flex gap-2 justify-content-center"><a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi Data"><i class="fa fa-check"></i></a><a href="#" class="btn-aksi btn-lihat" title="Lihat Detail"><i class="fa fa-eye"></i></a><a href="#" class="btn-aksi btn-edit" title="Edit Data"><i class="fa fa-edit"></i></a><a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a></div></td></tr>`);}</script>
                      </tbody>
                  </table>
                </div>
            </div>

            <div class="tab-pane fade" id="pengajaran-luar" role="tabpanel">
                <div class="table-responsive">
                  <table class="table table-hover table-bordered">
                      <thead class="table-light">
                          <tr class="text-center"><th>No</th><th class="text-start">Nama</th><th>Tahun Semester</th><th>Kode MK</th><th>Mata Kuliah</th><th>Jumlah Pertemuan</th><th>Institusi</th><th>Program Studi</th><th>Verifikasi</th><th>Dokumen</th><th>Aksi</th></tr>
                      </thead>
                      <tbody>
                          <script>for(let i=1; i<=6; i++){ document.write(`<tr><td class="text-center">${i}</td><td>Alex Kurniawan</td><td class="text-center">2018/2019 Ganjil</td><td class="text-center">MNH211</td><td>Biometrika Hutan</td><td class="text-center">K,S, P,O, R,O</td><td>Universitas Indonesia</td><td>Magos</td><td class="text-center"><i class="fas fa-check-circle text-success"></i></td><td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td><td class="text-center"><div class="d-flex gap-2 justify-content-center"><a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi Data"><i class="fa fa-check"></i></a><a href="#" class="btn-aksi btn-lihat" title="Lihat Detail"><i class="fa fa-eye"></i></a><a href="#" class="btn-aksi btn-edit" title="Edit Data"><i class="fa fa-edit"></i></a><a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a></div></td></tr>`);}</script>
                      </tbody>
                  </table>
                </div>
            </div>

            <div class="tab-pane fade" id="pengujian-lama" role="tabpanel">
                <div class="table-responsive">
                  <table class="table table-hover table-bordered">
                      <thead class="table-light">
                          <tr class="text-center"><th>No</th><th class="text-start">Nama</th><th>Tahun Semester</th><th>NIM</th><th>Nama Mahasiswa</th><th>Strata</th><th>Departemen</th><th>Status</th><th>Verifikasi</th><th>Dokumen</th><th>Aksi</th></tr>
                      </thead>
                      <tbody>
                          <script>for(let i=1; i<=6; i++){ document.write(`<tr><td class="text-center">${i}</td><td>Alex Kurniawan</td><td class="text-center">2018/2019 Ganjil</td><td class="text-center">E1232019</td><td>Alex Ramdana</td><td class="text-center">S1</td><td>Manajemen Hutan</td><td>Anggota Penguji</td><td class="text-center"><i class="fas fa-check-circle text-success"></i></td><td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td><td class="text-center"><div class="d-flex gap-2 justify-content-center"><a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi Data"><i class="fa fa-check"></i></a><a href="#" class="btn-aksi btn-lihat" title="Lihat Detail"><i class="fa fa-eye"></i></a><a href="#" class="btn-aksi btn-edit" title="Edit Data"><i class="fa fa-edit"></i></a><a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a></div></td></tr>`);}</script>
                      </tbody>
                  </table>
                </div>
            </div>

            <div class="tab-pane fade" id="pembimbing-lama" role="tabpanel">
                <div class="table-responsive">
                  <table class="table table-hover table-bordered">
                      <thead class="table-light">
                          <tr class="text-center"><th>No</th><th class="text-start">Kegiatan</th><th>Nama</th><th>Tahun Semester</th><th>NIM</th><th>Nama Mahasiswa</th><th>Strata</th><th>Departemen</th><th>Status</th><th>Verifikasi</th><th>Dokumen</th><th>Aksi</th></tr>
                      </thead>
                      <tbody>
                          <script>for(let i=1; i<=5; i++){ document.write(`<tr><td class="text-center">${i}</td><td class="text-start">Membimbing dan ikut membimbing..</td><td>Dr. Ir Kevin Ms</td><td class="text-center">2018/2019 Ganjil</td><td class="text-center">E1292019</td><td>Eni Murtini</td><td class="text-center">S1</td><td>Manajemen Hutan</td><td>Pembimbing Pendamping</td><td class="text-center"><i class="fas fa-check-circle text-success"></i></td><td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td><td class="text-center"><div class="d-flex gap-2 justify-content-center"><a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi Data"><i class="fa fa-check"></i></a><a href="#" class="btn-aksi btn-lihat" title="Lihat Detail"><i class="fa fa-eye"></i></a><a href="#" class="btn-aksi btn-edit" title="Edit Data"><i class="fa fa-edit"></i></a><a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a></div></td></tr>`);}</script>
                      </tbody>
                  </table>
                </div>
            </div>

            <div class="tab-pane fade" id="penguji-luar" role="tabpanel">
                <div class="table-responsive">
                  <table class="table table-hover table-bordered">
                      <thead class="table-light">
                          <tr class="text-center"><th>No</th><th class="text-start">Nama</th><th>Tahun Semester</th><th>NIM</th><th>Nama Mahasiswa</th><th>Universitas</th><th>Status</th><th>Verifikasi</th><th>Dokumen</th><th>Aksi</th></tr>
                      </thead>
                      <tbody>
                          <script>for(let i=1; i<=10; i++){ document.write(`<tr><td class="text-center">${i}</td><td>Nama Dosen</td><td class="text-center">Genap 2024</td><td class="text-center">Jurnal</td><td>Siapa nama</td><td>IPB University</td><td>Anggota Penguji</td><td class="text-center"><i class="fas fa-check-circle text-success"></i></td><td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td><td class="text-center"><div class="d-flex gap-2 justify-content-center"><a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi Data"><i class="fa fa-check"></i></a><a href="#" class="btn-aksi btn-lihat" title="Lihat Detail"><i class="fa fa-eye"></i></a><a href="#" class="btn-aksi btn-edit" title="Edit Data"><i class="fa fa-edit"></i></a><a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a></div></td></tr>`);}</script>
                      </tbody>
                  </table>
                </div>
            </div>

            <div class="tab-pane fade" id="pembimbing-luar" role="tabpanel">
                <div class="table-responsive">
                  <table class="table table-hover table-bordered">
                      <thead class="table-light">
                          <tr class="text-center"><th>No</th><th class="text-start">Nama</th><th>Tahun Semester</th><th>NIM</th><th>Nama Mahasiswa</th><th>Universitas</th><th>Status</th><th>Verifikasi</th><th>Dokumen</th><th>Aksi</th></tr>
                      </thead>
                      <tbody>
                          <script>for(let i=1; i<=10; i++){ document.write(`<tr><td class="text-center">${i}</td><td>Nama Dosen</td><td class="text-center">Genap 2024</td><td class="text-center">Jurnal</td><td>Siapa nama</td><td>IPB University</td><td>Pembimbing</td><td class="text-center"><i class="fas fa-check-circle text-success"></i></td><td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td><td class="text-center"><div class="d-flex gap-2 justify-content-center"><a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi Data"><i class="fa fa-check"></i></a><a href="#" class="btn-aksi btn-lihat" title="Lihat Detail"><i class="fa fa-eye"></i></a><a href="#" class="btn-aksi btn-edit" title="Edit Data"><i class="fa fa-edit"></i></a><a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a></div></td></tr>`);}</script>
                      </tbody>
                  </table>
                </div>
            </div>

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

  <footer class="footer-custom">
    <span>© 2025 Forest Management — All Rights Reserved</span>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // === Sidebar Logic ===
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      const toggleSidebarBtn = document.getElementById('toggleSidebar');
      const body = document.body;

      if (toggleSidebarBtn) {
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
      }

      if (overlay) {
        overlay.addEventListener('click', function () {
          sidebar.classList.remove('show');
          overlay.classList.remove('show');
        });
      }
      
      // === Date and Time Logic ===
      function updateDateTime() {
        const now = new Date();
        const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false, timeZone: 'Asia/Jakarta' };
        
        document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', dateOptions);
        document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID', timeOptions);
      }
      setInterval(updateDateTime, 1000);
      updateDateTime();
    });
  </script>
</body>
</html>