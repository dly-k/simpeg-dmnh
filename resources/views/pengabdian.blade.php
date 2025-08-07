<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIKEMAH - Editor Kegiatan Pengabdian</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/pengabdian.css') }}">
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
          <a href="/pendidikan" aria-label="Pendidikan">Pendidikan</a>
          <a href="/penelitian" aria-label="Penelitian">Penelitian</a>
          <a href="/pengabdian" aria-label="Pengabdian" class="active">Pengabdian</a>
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

  <div class="title-bar">
    <h1><i class="lni lni-pencil-alt"></i> <span id="page-title">Editor Kegiatan - Pengabdian</span></h1>
  </div>

  <div class="main-content">
      <div class="card">
          <div class="search-filter-container">
            <div class="search-filter-row">
                <div class="search-box">
                  <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-search" style="color: green;"></i></span>
                    <input type="text" class="form-control border-start-0 search-input" placeholder="Cari Data ....">
                  </div>
                </div>
                <select class="form-select filter-select"><option selected>Tahun</option><option>2012</option></select>
                <select class="form-select filter-select">
                  <option selected>Jenis SKIM</option>
                  <option value="Biomedik">Biomedik</option>
                  <option value="Hibah HI-LINK">Hibah HI-LINK</option>
                  <option value="Ipteks">Ipteks</option>
                  <option value="Ipteks Bagi Inovasi Kreativitas Kampus">Ipteks Bagi Inovasi Kreativitas Kampus</option>
                  <option value="Ipteks Bagi Kewirausahaan">Ipteks Bagi Kewirausahaan</option>
                  <option value="Iptek Bagi Masyarakat">Iptek Bagi Masyarakat</option>
                  <option value="Iptek Bagi Produk Ekspor">Iptek Bagi Produk Ekspor</option>
                  <option value="Iptek Bagi Wilayah">Iptek Bagi Wilayah</option>
                  <option value="Iptek Bagi Wilayah Antara PT-CSR/PT-PEMDA-CSR">Iptek Bagi Wilayah Antara PT-CSR/PT-PEMDA-CSR</option>
                  <option value="Kerjasama Luar Negeri dan Publikasi Internasional">Kerjasama Luar Negeri dan Publikasi Internasional</option>
                  <option value="KKN Pembelajaran Pemberdayaan Masyarakat">KKN Pembelajaran Pemberdayaan Masyarakat</option>
                  <option value="Mobil Listrik Nasional">Mobil Listrik Nasional</option>
                  <option value="MP3EI">MP3EI</option>
                  <option value="Pendidikan Magister Doktor Sarjana Unggul">Pendidikan Magister Doktor Sarjana Unggul</option>
                  <option value="Penelitian Disertasi Doktor">Penelitian Disertasi Doktor</option>
                  <option value="Penelitian Dosen Pemula">Penelitian Dosen Pemula</option>
                  <option value="Penelitian Fundamental">Penelitian Fundamental</option>
                  <option value="Penelitian Hibah Bersaing">Penelitian Hibah Bersaing</option>
                  <option value="Penelitian Kerjasama Antar Perguruan Tinggi">Penelitian Kerjasama Antar Perguruan Tinggi</option>
                  <option value="Penelitian Kompetensi">Penelitian Kompetensi</option>
                  <option value="Penelitian Srategis Nasional">Penelitian Srategis Nasional</option>
                  <option value="Penelitian Tim Pascasarjana">Penelitian Tim Pascasarjana</option>
                  <option value="Penelitian Unggulan Perguruan Tinggi">Penelitian Unggulan Perguruan Tinggi</option>
                  <option value="Penelitian Unggulan Strategis Nasional">Penelitian Unggulan Strategis Nasional</option>
                  <option value="Riset Andalan Perguruan Tinggi dan Industri">Riset Andalan Perguruan Tinggi dan Industri</option>
                </select>
                <select class="form-select filter-select">
                  <option selected>Status</option><option>Sudah Diverifikasi</option><option>Belum Diverifikasi</option><option>Ditolak</option>
                </select>
                <div class="btn-tambah-container">
                  <a href="#" class="btn btn-tambah fw-bold" onclick="openModal('pengabdianModal')"><i class="fa fa-plus me-2"></i> Tambah Data</a>
                </div>
            </div>
          </div>

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
                                  <td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td>
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
          
          <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
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
  
  <div class="modal-backdrop" id="pengabdianModal">
      <div class="modal-content-wrapper">
          <div class="modal-header-custom">
              <h5 id="modalTitle"><i class="fas fa-plus-circle"></i> Tambah Data Pengabdian</h5>
          </div>
          <div class="modal-body-custom">
              <form id="pengabdianForm">
                  <div class="row">
                      <div class="col-md-7">
                          <div class="row g-3">
                              <div class="col-12"><label class="form-label">Kegiatan</label><input type="text" class="form-control" placeholder="Melaksanakan Perkuliahan/Tutorial/..."></div>
                              <div class="col-12"><label class="form-label">Nama Kegiatan</label><select class="form-select"><option selected>-- Pilih Salah Satu --</option></select></div>
                              <div class="col-md-6"><label class="form-label">Afiliasi Non PT</label><input type="text" class="form-control" placeholder="Contoh: Dinas Kehutanan"></div>
                              <div class="col-md-6"><label class="form-label">Jenis SKIM</label><select class="form-select"><option selected>-- Pilih Salah Satu --</option></select></div>
                              <div class="col-12"><label class="form-label">Tahun</label><div class="d-flex gap-2"><input type="number" class="form-control" placeholder="Usulan"><input type="number" class="form-control" placeholder="Kegiatan"><input type="number" class="form-control" placeholder="Pelaksanaan"></div></div>
                              <div class="col-md-6"><label class="form-label">Terhitung Mulai Tanggal</label><input type="date" class="form-control"></div>
                              <div class="col-md-6"><label class="form-label">Terhitung Sampai Tanggal</label><input type="date" class="form-control"></div>
                              <div class="col-12"><label class="form-label">Lama Kegiatan</label><input type="text" class="form-control" placeholder="Contoh: 6 Bulan"></div>
                              <div class="col-12"><label class="form-label">In Kind</label><input type="text" class="form-control" placeholder="Deskripsi In Kind"></div>
                              <div class="col-12"><label class="form-label">No SK Penugasan</label><input type="text" class="form-control" placeholder="Nomor SK"></div>
                              <div class="col-12"><label class="form-label">Tanggal SK Penugasan</label><input type="date" class="form-control"></div>
                              <div class="col-12"><label class="form-label">Litabmas</label><input type="text" class="form-control" placeholder="Keterangan Litabmas"></div>
                              <div class="col-12"><label class="form-label">Dana</label><div class="row g-2"><div class="col-md-4"><input type="number" class="form-control" placeholder="DIKTI"></div><div class="col-md-4"><input type="number" class="form-control" placeholder="Perguruan Tinggi"></div><div class="col-md-4"><input type="number" class="form-control" placeholder="Institusi Lain"></div></div></div>
                          </div>
                      </div>
                      <div class="col-md-5">
                          <div class="d-grid gap-2 mb-3">
                              <button type="button" class="btn btn-outline-primary" onclick="addAnggota('dosen')">+ Tambah Dosen</button>
                              <div id="dosen-list"></div>
                              <button type="button" class="btn btn-outline-primary mt-2" onclick="addAnggota('mahasiswa')">+ Tambah Mahasiswa</button>
                              <div id="mahasiswa-list"></div>
                              <button type="button" class="btn btn-outline-primary mt-2" onclick="addAnggota('kolaborator')">+ Tambah Kolaborator</button>
                              <div id="kolaborator-list"></div>
                          </div>
                          <hr>
                          <div class="mb-3">
                              <label class="form-label">Jenis Dokumen</label>
                              <select class="form-select"><option selected>-- Pilih Salah Satu --</option></select>
                          </div>
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
              <button type="button" class="btn btn-danger" onclick="closeModal('pengabdianModal')">Batal</button>
              <button type="button" class="btn btn-success">Simpan</button>
          </div>
      </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
    // === Sidebar Logic ===
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const toggleSidebarBtn = document.getElementById('toggleSidebar');

    if (toggleSidebarBtn) {
      toggleSidebarBtn.addEventListener('click', function () {
        const isMobile = window.innerWidth <= 991;
        if (isMobile) {
          // Logika untuk Mobile (menampilkan overlay)
          sidebar.classList.toggle('show');
          overlay.classList.toggle('show', sidebar.classList.contains('show'));
        } else {
          // Logika untuk Desktop (menggeser konten)
          sidebar.classList.toggle('hidden');
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
    
    // === Modal Logic ===
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        const modalTitle = modal.querySelector('#modalTitle');
        modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Pengabdian';
        modal.querySelector('form').reset();
        
        // Clear dynamic lists
        document.getElementById('dosen-list').innerHTML = '';
        document.getElementById('mahasiswa-list').innerHTML = '';
        document.getElementById('kolaborator-list').innerHTML = '';

        if (modal) {
            modal.style.display = 'flex';
        }
    }
    
    function openEditModal() {
        const modal = document.getElementById('pengabdianModal');
        const modalTitle = modal.querySelector('#modalTitle');
        modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Pengabdian';
        // Logic to fill the form with existing data would go here
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
    
    // === Dynamic Member Add Logic ===
    function addAnggota(type) {
        let container, content;
        if (type === 'dosen') {
            container = document.getElementById('dosen-list');
            content = `
                <div class="dynamic-row">
                    <div class="row g-2">
                        <div class="col-12"><input type="text" class="form-control form-control-sm" placeholder="Nama Dosen"></div>
                        <div class="col-md-6"><select class="form-select form-select-sm"><option selected>Jabatan</option></select></div>
                        <div class="col-md-6"><select class="form-select form-select-sm"><option selected>Aktif</option></select></div>
                    </div>
                    <button class="btn btn-sm dynamic-row-close-btn" type="button" onclick="this.parentElement.remove()"><i class="fa fa-times"></i></button>
                </div>
            `;
        } else if (type === 'mahasiswa') {
            container = document.getElementById('mahasiswa-list');
            content = `
                <div class="dynamic-row">
                    <div class="row g-2">
                        <div class="col-md-6"><select class="form-select form-select-sm"><option selected>Strata</option></select></div>
                        <div class="col-md-6"><input type="text" class="form-control form-control-sm" placeholder="Nama Mahasiswa"></div>
                        <div class="col-md-6"><select class="form-select form-select-sm"><option selected>Jabatan</option></select></div>
                        <div class="col-md-6"><select class="form-select form-select-sm"><option selected>Aktif</option></select></div>
                    </div>
                    <button class="btn btn-sm dynamic-row-close-btn" type="button" onclick="this.parentElement.remove()"><i class="fa fa-times"></i></button>
                </div>
            `;
        } else { // kolaborator
            container = document.getElementById('kolaborator-list');
            content = `
                <div class="dynamic-row">
                    <div class="row g-2">
                        <div class="col-12"><input type="text" class="form-control form-control-sm" placeholder="Nama Kolaborator"></div>
                        <div class="col-md-6"><select class="form-select form-select-sm"><option selected>Jabatan</option></select></div>
                        <div class="col-md-6"><select class="form-select form-select-sm"><option selected>Aktif</option></select></div>
                    </div>
                    <button class="btn btn-sm dynamic-row-close-btn" type="button" onclick="this.parentElement.remove()"><i class="fa fa-times"></i></button>
                </div>
            `;
        }

        container.insertAdjacentHTML('beforeend', content);
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