<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>SIKEMAH - Editor Kegiatan (Pengabdian)</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/pengabdian.css') }}" />
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
                                          <a href="javascript:void(0);" id="btnLihatPengabdian" class="btn-aksi btn-lihat" title="Lihat Detail Pengabdian"><i class="fa fa-eye"></i></a>
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
  {{-- Tambah Data Pengabdian --}}
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

<!--Detail Pengabdian-->
<div id="pengabdianDetailModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <div class="modal-title-group">
                <i class="fas fa-info-circle"></i>
                <h2>Detail Pengabdian</h2>
            </div>
        </div>

        <div class="modal-body">
            <div class="modal-row">
                <strong>Judul</strong>
                <p class="detail-value">Analisis Pengaruh Kotoran Sapi Terhadap Pertumbuhan Kecambah Pada Media Kapas</p>
            </div>
            <div class="modal-row">
                <strong>Nama Kegiatan</strong>
                <p class="detail-value">Analisis Pengaruh Kotoran Sapi Terhadap Pertumbuhan Kecambah Pada Media Kapas</p>
            </div>
             <div class="modal-row multi-column">
                <div class="detail-field">
                    <strong>Afiliasi Non-PT</strong>
                    <p class="detail-value">UGE - 912</p>
                </div>
                <div class="detail-field">
                    <strong>Jenis SKIM</strong>
                    <p class="detail-value">Pembudidayaan Ikan Lele</p>
                </div>
                <div class="detail-field">
                    <strong>Lama Kegiatan</strong>
                    <p class="detail-value">Teknologi Rekayasa Empang</p>
                </div>
            </div>
             <div class="modal-row multi-column">
                <div class="detail-field">
                    <strong>Tahun Usulan</strong>
                    <p class="detail-value">2025</p>
                </div>
                <div class="detail-field">
                    <strong>Tahun Kegiatan</strong>
                    <p class="detail-value">2025</p>
                </div>
                <div class="detail-field">
                    <strong>Tahun Pelaksanaan</strong>
                    <p class="detail-value">2025</p>
                </div>
            </div>
             <div class="modal-row multi-column">
                <div class="detail-field">
                    <strong>In Kind</strong>
                    <p class="detail-value">2025</p>
                </div>
                <div class="detail-field">
                    <strong>Libtamas</strong>
                    <p class="detail-value">2025</p>
                </div>
                <div class="detail-field">
                    <strong>Tanggal SK Penugasan</strong>
                    <p class="detail-value">2025</p>
                </div>
            </div>
             <div class="modal-row">
                <strong>No SK Penugasan</strong>
                <p class="detail-value">2025</p>
            </div>
             <div class="modal-row multi-column">
                <div class="detail-field">
                    <strong>Dana DIKTI</strong>
                    <p class="detail-value">2025</p>
                </div>
                <div class="detail-field">
                    <strong>Dana Perguruan Tinggi</strong>
                    <p class="detail-value">2025</p>
                </div>
                <div class="detail-field">
                    <strong>Dana Institusi Lain</strong>
                    <p class="detail-value">2025</p>
                </div>
            </div>
             <div class="modal-row multi-column">
                <div class="detail-field">
                    <strong>Dokumen Pendukung</strong>
                    <p class="detail-value"><a href="#" class="dokumen-link">Dokumen</a></p>
                </div>
                <div class="detail-field">
                    <strong>Jenis Dokumen</strong>
                    <p class="detail-value">Dokumen</p>
                </div>
            </div>
             <div class="modal-row multi-column">
                <div class="detail-field">
                    <strong>Nama Dokumen</strong>
                    <p class="detail-value">2025</p>
                </div>
                <div class="detail-field">
                    <strong>Nomor</strong>
                    <p class="detail-value">2025</p>
                </div>
                <div class="detail-field">
                    <strong>Tautan</strong>
                    <p class="detail-value">2025</p>
                </div>
            </div>
             <div class="sub-header">Dosen</div>
            <div class="modal-row multi-column">
                <div class="detail-field"><strong>Strata</strong><p class="detail-value">Siapa gatau</p></div>
                <div class="detail-field"><strong>Nama</strong><p class="detail-value">Siapa gatau</p></div>
                <div class="detail-field"><strong>Jabatan</strong><p class="detail-value">Siapa gatau</p></div>
                <div class="detail-field"><strong>Aktif</strong><p class="detail-value">Siapa gatau</p></div>
            </div>
             <div class="sub-header">Mahasiswa</div>
            <div class="modal-row multi-column">
                <div class="detail-field"><strong>Nama</strong><p class="detail-value">Siapa gatau</p></div>
                <div class="detail-field"><strong>Jabatan</strong><p class="detail-value">2025</p></div>
                <div class="detail-field"><strong>Aktif</strong><p class="detail-value">2025</p></div>
            </div>
             <div class="sub-header">Kolaborator</div>
            <div class="modal-row multi-column no-border">
                <div class="detail-field"><strong>Nama</strong><p class="detail-value">Siapa gatau</p></div>
                <div class="detail-field"><strong>Jabatan</strong><p class="detail-value">2025</p></div>
                <div class="detail-field"><strong>Aktif</strong><p class="detail-value">2025</p></div>
            </div>
            
        </div>

        <div class="modal-footer">
            <button id="closePengabdianDetailBtn" class="btn btn-secondary">Tutup</button>
        </div>
    </div>
</div>  

<!--Konfirmasi Verifisi-->
<div class="konfirmasi-pengabdian-overlay" id="modalKonfirmasiPengabdian" style="display: none;">
    <div class="konfirmasi-pengabdian-box">
        <h3 class="konfirmasi-pengabdian-title">Konfirmasi Verifikasi Data</h3>
        <p class="konfirmasi-pengabdian-subtitle">Apakah Anda yakin ingin melanjutkan proses ini?</p>
        <div class="konfirmasi-pengabdian-buttons">
            <button class="btn-popup btn-terima" id="popupBtnTerima">Terima</button>
            <button class="btn-popup btn-tolak" id="popupBtnTolak">Tolak</button>
            <button class="btn-popup btn-kembali" id="popupBtnKembali">Kembali</button>
        </div>
    </div>
</div>

<!--Hapus Penelitian-->
<!-- Modal Konfirmasi Hapus -->
<div class="konfirmasi-hapus-overlay" id="modalKonfirmasiHapus" style="display: none;">
    <div class="konfirmasi-hapus-box">
        <div class="konfirmasi-hapus-icon">
            <i class="fas fa-exclamation"></i>
        </div>
        <h3 class="konfirmasi-hapus-title">Apakah Anda Yakin Menghapus Data Ini?</h3>
        <p class="konfirmasi-hapus-subtitle">Data ini akan dihapus secara permanen dari sistem.</p>
        <div class="konfirmasi-hapus-buttons">
            <button class="btn-popup btn-hapus" id="btnKonfirmasiHapus">Ya, Hapus</button>
            <button class="btn-popup btn-batal" id="btnBatalHapus">Batal</button>
        </div>
    </div>
</div>

<!--Modal Berhasil-->
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
  
  <script src="{{ asset('assets/js/pengabdian.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>