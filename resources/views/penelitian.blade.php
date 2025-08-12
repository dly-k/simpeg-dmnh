<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>SIKEMAH - Editor Kegiatan (Penelitian)</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/penelitian.css') }}" />
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

  <div class="title-bar">
    <h1><i class="lni lni-pencil-alt"></i> <span id="page-title">Editor Kegiatan - Penelitian</span></h1>
  </div>

  <div class="main-content">
    <!-- Table Section -->
    <div class="card">
      <!-- Search and Filter Section -->
    <div class="search-filter-container">
      <div class="search-filter-row">
        <div class="search-box">
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
              <i class="fas fa-search" style="color: green;"></i>
            </span>
            <input type="text" class="form-control border-start-0 search-input" placeholder="Cari Data...">
          </div>
        </div>
        
        <select class="form-select filter-select">
          <option selected>Tahun</option>
          <option>2021</option>
          <option>2022</option>
          <option>2023</option>
        </select>
        
        <select class="form-select filter-select" name="jenis_karya_lengkap">
          <option selected disabled>Jenis Karya</option>
                      <option value="Buku Monograf">Buku Monograf</option>
                      <option value="Buku Referensi">Buku Referensi</option>
                      <option value="Book Chapter Internasional">Book Chapter Tingkat Internasional</option>
                      <option value="Book Chapter Nasional">Book Chapter Tingkat Nasional</option>
                      <option value="Menyunting Buku">Mengedit/Menyunting Karya Ilmiah dalam Bentuk Buku yang Diterbitkan</option>
                      <option value="Jurnal Internasional Bereputasi">Jurnal Internasional Bereputasi</option>
                      <option value="Jurnal Internasional Terindeks">Jurnal Internasional Terindeks</option>
                      <option value="Jurnal Nasional">Jurnal Nasional</option>
                      <option value="Jurnal Nasional Terakreditasi">Jurnal Nasional Terakreditasi</option>
                      <option value="Jurnal Nasional Terakreditasi Peringkat 1 dan 2">Jurnal Nasional Terakreditasi Kemenristekdikti Peringkat 1 dan 2</option>
                      <option value="Jurnal Nasional Terakreditasi Peringkat 3 dan 4">Jurnal Nasional Terakreditasi Kemenristekdikti Peringkat 3 dan 4</option>
                      <option value="Jurnal Nasional Bhs Indonesia DOAJ">Jurnal Nasional Berbahasa Indonesia Terindeks pada DOAJ</option>
                      <option value="Jurnal Nasional Bhs Inggris/PBB DOAJ">Jurnal Nasional Berbahasa Inggris atau Bahasa Resmi PBB Terindeks pada DOAJ</option>
                      <option value="Prosiding Internasional (Dipresentasikan)">Prosiding Internasional - Makalah Dipresentasikan</option>
                      <option value="Prosiding Internasional (Tidak Dipresentasikan)">Prosiding Internasional - Makalah Tidak Dipresentasikan</option>
                      <option value="Prosiding Internasional Terindeks WoS/Scopus">Prosiding Internasional Terindeks Web of Science/Scopus</option>
                      <option value="Prosiding Nasional (Dipresentasikan)">Prosiding Nasional - Makalah Dipresentasikan</option>
                      <option value="Prosiding Nasional (Tidak Dipresentasikan)">Prosiding Nasional - Makalah Tidak Dipresentasikan</option>
                      <option value="Hasil Penelitian Disajikan (Non-Prosiding)">Hasil Penelitian/Pemikiran yang Disajikan dalam Forum Ilmiah Internasional</option>
                      <option value="Poster Internasional (Non-Prosiding)">Poster Dipresentasikan dalam Forum Ilmiah Internasional</option>
                      <option value="Poster Prosiding Nasional">Poster Dimuat dalam Prosiding Nasional yang Dipublikasikan</option>
                      <option value="Hasil Penelitian Tidak Dipublikasikan">Hasil Penelitian/Pemikiran/Kerja Sama Industri yang Tidak Dipublikasikan</option>
                      <option value="Koran/Majalah Populer">Koran/Majalah Populer/Majalah Umum</option>
                      <option value="Karya Terdaftar HaKI">Rancangan/Karya Teknologi atau Seni Terdaftar di HaKI Tingkat Nasional</option>
                      <option value="Paten Sederhana">Paten Sederhana</option>
                      <option value="Karya Cipta/Desain Industri">Karya Cipta/Desain Industri/Indikasi Geografis</option>
                      <option value="Rumusan Kebijakan Monumental">Rumusan Kebijakan Monumental</option>
        </select>
                        <select class="form-select filter-select">
                  <option selected>Status</option><option>Sudah Diverifikasi</option><option>Belum Diverifikasi</option><option>Ditolak</option>
                </select>
        
        <div class="btn-tambah-container">
          <a href="#" class="btn btn-tambah fw-bold" onclick="openModal('penelitianModal')">
            <i class="fas fa-plus me-2"></i> Tambah Data
          </a>
        </div>
      </div>
    </div>
      <div class="card-body px-4 pb-4 pt-2">
        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead class="table-light">
              <tr class="text-center">
                <th style="width: 5%">No</th>
                <th style="width: 30%" class="text-start">Judul</th>
                <th style="width: 10%">Tanggal Terbit</th>
                <th style="width: 10%">Jenis Karya</th>
                <th style="width: 5%">Publik</th>
                <th style="width: 10%">Verifikasi</th>
                <th style="width: 10%">Dokumen</th>
                <th style="width: 20%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @for($i=1; $i<=11; $i++)
              <tr>
                <td class="text-center">{{ $i }}</td>
                <td class="text-start">Pengaruh Air Terhadap Tumbuh Kembang Lele</td>
                <td class="text-center">24 Desember 2021</td>
                <td class="text-center">Jurnal</td>
                <td class="text-center">Ya</td>
                <td class="text-center">
                  @if($i % 2 === 0)
                    <i class="fas fa-check-circle text-success"></i>
                  @else
                    <i class="fas fa-times-circle text-danger"></i>
                  @endif
                </td>
              <td class="text-center">
                <button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button>
              </td>
              <td class="text-center">
                  <div class="d-flex gap-2 justify-content-center">
                      <a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi Data" data-id="{{ $i }}">
                          <i class="fa fa-check"></i>
                      </a>
                      <a href="javascript:void(0);" id="btnLihatDetail" class="btn-aksi btn-lihat" title="Lihat Detail"><i class="fa fa-eye"></i></a>
                      <a href="#" class="btn-aksi btn-edit" title="Edit Data"  onclick="openEditModal()"><i class="fa fa-edit"></i></a>
                      <a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a>
                  </div>
              </td>
              </tr>
              @endfor
            </tbody>
          </table>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3">
          <span class="text-muted small">Menampilkan 1 sampai 10 dari 13 data</span>
          <nav>
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
  </div>
  
  <!-- Modal Penelitian -->
  <div class="modal-backdrop" id="penelitianModal">
    <div class="modal-content-wrapper">
      <div class="modal-header-custom">
        <h5 id="modalTitle"><i class="fas fa-plus-circle"></i> Tambah Data Penelitian</h5>
      </div>
      <div class="modal-body-custom">
        <form id="penelitianForm">
          <div class="row g-3">
            <div class="col-12"><label class="form-label">Judul</label><input type="text" class="form-control" name="judul" placeholder="Judul Penelitian"></div>
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
                <p>Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small></p>
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

  <footer class="footer-custom">
    <span>© 2025 Forest Management — All Rights Reserved</span>
  </footer>

<div id="detailModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <div class="modal-title-group">
                <i class="fas fa-info-circle"></i>
                <h2>Detail Penelitian</h2>
            </div>
            </div>

        <div class="modal-body">
            <div class="modal-row">
                <strong>Judul</strong>
                <p class="detail-value">Analisis Pengaruh Kotoran Sapi Terhadap Pertumbuhan Kecambah Pada Media Kapas</p>
            </div>
            
            <div class="modal-row multi-column">
                <div class="detail-field">
                    <strong>Jenis Karya</strong>
                    <p class="detail-value">UGE - 912</p>
                </div>
                <div class="detail-field">
                    <strong>Volume/Issue</strong>
                    <p class="detail-value">Pembudidayaan Ikan Lele</p>
                </div>
                <div class="detail-field">
                    <strong>Jumlah Halaman</strong>
                    <p class="detail-value">Teknologi Rekayasa Empang</p>
                </div>
            </div>

            <div class="modal-row multi-column">
                <div class="detail-field">
                    <strong>Tanggal Terbit</strong>
                    <p class="detail-value">-</p>
                </div>
                <div class="detail-field">
                    <strong>Publik</strong>
                    <p class="detail-value">Ya</p>
                </div>
                <div class="detail-field">
                    <strong>ISBN</strong>
                    <p class="detail-value">Tidak Ber Jenis</p>
                </div>
            </div>

            <div class="modal-row multi-column">
                <div class="detail-field">
                    <strong>ISSN</strong>
                    <p class="detail-value">1</p>
                </div>
                <div class="detail-field">
                    <strong>DOI</strong>
                    <p class="detail-value">6</p>
                </div>
                <div class="detail-field">
                    <strong>URL</strong>
                    <p class="detail-value">6</p>
                </div>
            </div>

            <div class="modal-row">
                <strong>Dokumen Pendukung</strong>
                <p class="detail-value"><a href="#" class="dokumen-link">Dokumen</a></p>
            </div>

            <div class="modal-row">
                <div class="penulis-header">
                    <strong>Penulis IPB</strong>
                    <a href="#" class="dokumen-link">Dokumen</a>
                </div>
                <p class="detail-value nama-penulis">Siapa gatau</p>
            </div>
            
            <div class="modal-row">
                <div class="penulis-header">
                    <strong>Penulis Luar IPB</strong>
                    <a href="#" class="dokumen-link">Dokumen</a>
                </div>
                <p class="detail-value nama-penulis">Siapa gatau</p>
            </div>

            <div class="modal-row no-border">
                <div class="penulis-header">
                    <strong>Penulis Mahasiswa</strong>
                </div>
                <p class="detail-value nama-penulis">Siapa gatau</p>
            </div>
        </div>

        <div class="modal-footer">
            <button id="tutupBtn" class="btn-tutup">Tutup</button>
        </div>
    </div>
</div>

<div id="modalKonfirmasiPenelitian">
    <div class="confirmation-popup-box">
        <h3 class="popup-title">Konfirmasi Verifikasi Data</h3>
        <p class="popup-subtitle">Apakah Anda yakin ingin melanjutkan proses ini?</p>
        <div class="popup-buttons">
            <button class="btn-popup btn-terima" id="popupBtnTerima">Terima</button>
            <button class="btn-popup btn-tolak" id="popupBtnTolak">Tolak</button>
            <button class="btn-popup btn-kembali" id="popupBtnKembali">Kembali</button>
        </div>
    </div>
</div>


  <script src="{{ asset('assets/js/penelitian.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>