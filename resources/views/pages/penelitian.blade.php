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
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
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
    <div class="card">
      <div class="search-filter-container">
      <div class="search-filter-row">
        <div class="search-box">
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
              <i class="fas fa-search search-icon"></i>
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
                <th>No</th>
                <th>Judul</th>
                <th>Tanggal Terbit</th>
                <th>Jenis Karya</th>
                <th>Publik</th>
                <th>Verifikasi</th>
                <th>Dokumen</th>
                <th>Aksi</th>
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
                      <a id="btnLihatDetail" class="btn-aksi btn-lihat" title="Lihat Detail" data-bs-toggle="modal" data-bs-target="#detailModal"><i class="fa fa-eye"></i></a>
                      <a href="#" class="btn-aksi btn-edit" title="Edit Data"  onclick="openEditModal()"><i class="fa fa-edit"></i></a>
                      <a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a>
                  </div>
              </td>
              </tr>
              @endfor
            </tbody>
          </table>
        </div>
        
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
    
  {{-- Kumpulan Modal  --}}
    @include('components.konfirmasi-hapus')
    @include('components.konfirmasi-berhasil')
    @include('components.konfirmasi-verifikasi')
    @include('components.penelitian.detail-penelitian')
    @include('components.penelitian.tambah-penelitian')

  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="{{ asset('assets/js/penelitian.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>