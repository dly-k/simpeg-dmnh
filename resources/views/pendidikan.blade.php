<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>SIKEMAH - Editor Kegiatan (Pendidikan)</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/pendidikan.css') }}" />
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

          <div class="tab-content" id="pendidikanTabContent">
            {{-- PENGAJARAN LAMA --}}
            <div class="tab-pane fade show active" id="pengajaran-lama" role="tabpanel">
                {{-- Container untuk Pencarian dan Filter --}}
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
                        </select>
                        <div class="btn-tambah-container">
                            <a href="#" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahEditPengajaranLama" id="btnTambahPengajaranLama">
                                <i class="fa fa-plus me-2"></i> Tambah Data
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Tabel Data --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr class="text-center"><th>No</th><th class="text-start">Nama</th><th>Tahun Semester</th><th>Kode MK</th><th>Mata Kuliah</th><th>SKS</th><th>Kelas Paralel (Jenis)</th><th>Jumlah Pertemuan</th><th>Verifikasi</th><th>Dokumen</th><th>Aksi</th></tr>
                        </thead>
                        <tbody>
                            @php
                                // Contoh data lengkap untuk Pengajaran Lama
                                $dataPengajaran = collect(json_decode('[{"id": 1, "kegiatan": "Senam Lele Merdeka", "nama": "Dr. Stone Pamungkas", "tahun_semester": "2018/2019 Ganjil", "kode_mk": "UGE - 912", "nama_mk": "Pembudidayaan Ikan Lele", "pengampu": "Teknologi Rekayasa Empang", "sks_kuliah": "0", "sks_praktikum": "99", "jenis": "Tidak Berjenis", "kelas_paralel": "1", "jenis_kelas": "K", "jumlah_pertemuan": 6, "verified": true, "dokumen_path": "assets/pdf/example.pdf"}, {"id": 1, "kegiatan": "Senam Lele Merdeka", "nama": "Dr. Stone Pamungkas", "tahun_semester": "2018/2019 Ganjil", "kode_mk": "UGE - 912", "nama_mk": "Pembudidayaan Ikan Lele", "pengampu": "Teknologi Rekayasa Empang", "sks_kuliah": "0", "sks_praktikum": "99", "jenis": "Tidak Berjenis", "kelas_paralel": "1", "jenis_kelas": "K", "jumlah_pertemuan": 6, "verified": false, "dokumen_path": "assets/pdf/example.pdf"}]'));
                            @endphp

                            @foreach ($dataPengajaran as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td class="text-center">{{ $item->tahun_semester }}</td>
                                <td class="text-center">{{ $item->kode_mk }}</td>
                                <td>{{ $item->nama_mk }}</td>
                                <td class="text-center">{{ (int)$item->sks_kuliah + (int)$item->sks_praktikum }} ({{$item->sks_kuliah}}-{{$item->sks_praktikum}})</td>
                                <td class="text-center">{{ $item->kelas_paralel }} ({{ $item->jenis_kelas }})</td>
                                <td class="text-center">{{ $item->jumlah_pertemuan }}</td>
                                <td class="text-center">
                                    @if ($item->verified)
                                        <i class="fas fa-check-circle text-success"></i>
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i>
                                    @endif
                                </td>
                                <td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="#" class="btn-aksi btn-verifikasi btn-konfirmasi-pendidikan" 
                                            title="Verifikasi Data" 
                                            data-id="{{ $item->id }}">
                                              <i class="fa fa-check"></i>
                                          </a>
                                        
                                        {{-- Tombol Lihat Detail --}}
                                        <a href="#" class="btn-aksi btn-lihat-detail" title="Lihat Detail"
                                          data-bs-toggle="modal"
                                          data-bs-target="#modalDetailPengajaranLama"
                                          data-kegiatan="{{ $item->kegiatan }}"
                                          data-nama="{{ $item->nama }}"
                                          data-tahun_semester="{{ $item->tahun_semester }}"
                                          data-kode_mk="{{ $item->kode_mk }}"
                                          data-nama_mk="{{ $item->nama_mk }}"
                                          data-pengampu="{{ $item->pengampu }}"
                                          data-sks_kuliah="{{ $item->sks_kuliah }}"
                                          data-sks_praktikum="{{ $item->sks_praktikum }}"
                                          data-jenis="{{ $item->jenis }}"
                                          data-kelas_paralel="{{ $item->kelas_paralel }}"
                                          data-jumlah_pertemuan="{{ $item->jumlah_pertemuan }}"
                                          data-dokumen_path="{{ $item->dokumen_path }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        
                                        {{-- Tombol Edit --}}
                                        <a href="#" class="btn-aksi btn-edit" title="Edit Data" 
                                          data-bs-toggle="modal" 
                                          data-bs-target="#modalTambahEditPengajaranLama"
                                          data-id="{{ $item->id }}"
                                          data-nama="{{ $item->nama }}"
                                          data-tahun_semester="{{ $item->tahun_semester }}"
                                          data-kode_mk="{{ $item->kode_mk }}"
                                          data-nama_mk="{{ $item->nama_mk }}"
                                          data-sks_kuliah="{{ $item->sks_kuliah }}"
                                          data-sks_praktikum="{{ $item->sks_praktikum }}"
                                          data-kelas_paralel="{{ $item->kelas_paralel }}"
                                          data-jumlah_pertemuan="{{ $item->jumlah_pertemuan }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- PENGAJARAN LUAR --}}
            <div class="tab-pane fade" id="pengajaran-luar" role="tabpanel">
                {{-- Container untuk Pencarian dan Filter --}}
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
                        </select>
                        <div class="btn-tambah-container">
                            <a href="#" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#modalPengajaranLuar" id="btnTambahPengajaranLuar">
                                <i class="fa fa-plus me-2"></i> Tambah Data
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Tabel Data --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr class="text-center"><th>No</th><th class="text-start">Nama</th><th>Tahun Semester</th><th>Kode MK</th><th>Mata Kuliah</th><th>Jumlah Pertemuan</th><th>Institusi</th><th>Program Studi</th><th>Verifikasi</th><th>Dokumen</th><th>Aksi</th></tr>
                        </thead>
                        <tbody>
                            @php
                                // Contoh data lengkap untuk Pengajaran Luar
                                $dataPengajaranLuar = collect(json_decode('[{"id": 1, "nama": "Dr. Stone Pamungkas", "tahun_semester": "2018/2019 Ganjil", "universitas": "Universitas Gali Empang", "kode_mk": "UGE - 912", "nama_mk": "Pembudidayaan Ikan Lele", "program_studi": "Teknologi Rekayasa Empang", "sks_kuliah": 0, "sks_praktikum": 99, "jenis": "Tidak Berjenis", "kelas_paralel": "1", "jumlah_pertemuan": 6, "is_insidental": "Tidak", "is_lebih_satu_semester": "Ya", "verified": true, "dokumen_path": "assets/pdf/example.pdf"}, {"id": 1, "nama": "Dr. Stone Pamungkas", "tahun_semester": "2018/2019 Ganjil", "universitas": "Universitas Gali Empang", "kode_mk": "UGE - 912", "nama_mk": "Pembudidayaan Ikan Lele", "program_studi": "Teknologi Rekayasa Empang", "sks_kuliah": 0, "sks_praktikum": 99, "jenis": "Tidak Berjenis", "kelas_paralel": "1", "jumlah_pertemuan": 6, "is_insidental": "Tidak", "is_lebih_satu_semester": "Ya", "verified": false, "dokumen_path": "assets/pdf/example.pdf"}]'));
                            @endphp

                            @foreach ($dataPengajaranLuar as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td class="text-center">{{ $item->tahun_semester }}</td>
                                <td class="text-center">{{ $item->kode_mk }}</td>
                                <td>{{ $item->nama_mk }}</td>
                                <td class="text-center">{{ $item->jumlah_pertemuan }}</td>
                                <td>{{ $item->universitas }}</td>
                                <td>{{ $item->program_studi }}</td>
                                <td class="text-center">
                                    @if ($item->verified)
                                        <i class="fas fa-check-circle text-success"></i>
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i>
                                    @endif
                                </td>
                                <td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                          <a href="#" class="btn-aksi btn-verifikasi btn-konfirmasi-pendidikan" 
                                            title="Verifikasi Data" 
                                            data-id="{{ $item->id }}">
                                              <i class="fa fa-check"></i>
                                          </a>
                                        {{-- Tombol Lihat Detail --}}
                                        <a href="#" class="btn-aksi btn-lihat-detail" title="Lihat Detail"
                                          data-bs-toggle="modal"
                                          data-bs-target="#modalDetailPengajaranLuar"
                                          data-nama="{{ $item->nama }}"
                                          data-tahun_semester="{{ $item->tahun_semester }}"
                                          data-universitas="{{ $item->universitas }}"
                                          data-kode_mk="{{ $item->kode_mk }}"
                                          data-nama_mk="{{ $item->nama_mk }}"
                                          data-program_studi="{{ $item->program_studi }}"
                                          data-sks_kuliah="{{ $item->sks_kuliah }}"
                                          data-sks_praktikum="{{ $item->sks_praktikum }}"
                                          data-jenis="{{ $item->jenis }}"
                                          data-kelas_paralel="{{ $item->kelas_paralel }}"
                                          data-jumlah_pertemuan="{{ $item->jumlah_pertemuan }}"
                                          data-is_insidental="{{ $item->is_insidental }}"
                                          data-is_lebih_satu_semester="{{ $item->is_lebih_satu_semester }}"
                                          data-dokumen_path="{{ $item->dokumen_path }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        
                                        {{-- Tombol Edit --}}
                                        <a href="#" class="btn-aksi btn-edit btn-edit-pengajaran-luar" title="Edit Data"
                                          data-bs-toggle="modal"
                                          data-bs-target="#modalPengajaranLuar"
                                          data-id="{{ $item->id }}">
                                          <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- PENGUJIAN LAMA --}}
            <div class="tab-pane fade" id="pengujian-lama" role="tabpanel">
                {{-- Container untuk Pencarian dan Filter --}}
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
                        </select>
                        <div class="btn-tambah-container">
                            <a href="#" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#modalPengujianLama" id="btnTambahPengujianLama">
                                <i class="fa fa-plus me-2"></i> Tambah Data
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Tabel Data --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr class="text-center"><th>No</th><th class="text-start">Nama</th><th>Tahun Semester</th><th>NIM</th><th>Nama Mahasiswa</th><th>Strata</th><th>Departemen</th><th>Status</th><th>Verifikasi</th><th>Dokumen</th><th>Aksi</th></tr>
                        </thead>
                        <tbody>
                            @php
                                // Contoh data lengkap untuk Pengujian Lama
                                $dataPengujianLama = collect(json_decode('[{"id": 1, "kegiatan": "Senam Lele Merdeka", "nama": "Dr. Stone Pamungkas", "strata": "S1", "tahun_semester": "2018/2019 Ganjil", "nim": "UGE - 912", "nama_mahasiswa": "Pembudidayaan Ikan Lele", "departemen": "Teknologi Rekayasa Empang", "status_penguji": "Ketua Penguji", "verified": true, "dokumen_path": "assets/pdf/example.pdf"}, {"id": 1, "kegiatan": "Senam Lele Merdeka", "nama": "Dr. Stone Pamungkas", "strata": "S1", "tahun_semester": "2018/2019 Ganjil", "nim": "UGE - 912", "nama_mahasiswa": "Pembudidayaan Ikan Lele", "departemen": "Teknologi Rekayasa Empang", "status_penguji": "Ketua Penguji", "verified": false, "dokumen_path": "assets/pdf/example.pdf"}]'));
                            @endphp

                            @foreach ($dataPengujianLama as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td class="text-center">{{ $item->tahun_semester }}</td>
                                <td class="text-center">{{ $item->nim }}</td>
                                <td>{{ $item->nama_mahasiswa }}</td>
                                <td class="text-center">{{ $item->strata }}</td>
                                <td>{{ $item->departemen }}</td>
                                <td>{{ $item->status_penguji }}</td>
                                <td class="text-center">
                                    @if ($item->verified)
                                        <i class="fas fa-check-circle text-success"></i>
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i>
                                    @endif
                                </td>
                                <td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                          <a href="#" class="btn-aksi btn-verifikasi btn-konfirmasi-pendidikan" 
                                            title="Verifikasi Data" 
                                            data-id="{{ $item->id }}">
                                              <i class="fa fa-check"></i>
                                          </a>
                                        
                                        {{-- Tombol Lihat Detail --}}
                                        <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-detail-pengujian" title="Lihat Detail"
                                          data-bs-toggle="modal"
                                          data-bs-target="#modalDetailPengujianLama"
                                          data-kegiatan="{{ $item->kegiatan }}"
                                          data-nama="{{ $item->nama }}"
                                          data-tahun_semester="{{ $item->tahun_semester }}"
                                          data-nim="{{ $item->nim }}"
                                          data-nama_mahasiswa="{{ $item->nama_mahasiswa }}"
                                          data-departemen="{{ $item->departemen }}"
                                          data-dokumen_path="{{ $item->dokumen_path }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        
                                        {{-- Tombol Edit --}}
                                        <a href="#" class="btn-aksi btn-edit btn-edit-pengujian-lama" title="Edit Data"
                                          data-bs-toggle="modal"
                                          data-bs-target="#modalPengujianLama"
                                          data-id="{{ $item->id }}">
                                          <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- PEMBIMBING LAMA --}}
            <div class="tab-pane fade" id="pembimbing-lama" role="tabpanel">
                  {{-- Container untuk Pencarian dan Filter --}}
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
                          </select>
                          <div class="btn-tambah-container">
                              <a href="#" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#modalPembimbingLama" id="btnTambahPembimbingLama">
                                  <i class="fa fa-plus me-2"></i> Tambah Data
                              </a>
                          </div>
                      </div>
                  </div>

                  {{-- Tabel Data --}}
                  <div class="table-responsive">
                      <table class="table table-hover table-bordered">
                          <thead class="table-light">
                              <tr class="text-center"><th>No</th><th class="text-start">Kegiatan</th><th>Nama</th><th>Tahun Semester</th><th>NIM</th><th>Nama Mahasiswa</th><th>Departemen</th><th>Status</th><th>Verifikasi</th><th>Dokumen</th><th>Aksi</th></tr>
                          </thead>
                          <tbody>
                              @php
                                  // Contoh data lengkap untuk Pembimbing Lama
                                  $dataPembimbingLama = collect(json_decode('[{"id": 1, "kegiatan": "Membimbing dan ikut membimbing dalam menghasilkan disertasi", "nama": "Dr. Stone Pamungkas", "tahun_semester": "2018/2019 Ganjil", "nim": "UGE - 912", "nama_mahasiswa": "Pembudidayaan Ikan Lele", "strata": "S1", "departemen": "Teknologi Rekayasa Empang", "lokasi": "PT. Lele Tanpa Ekor", "nama_dokumen": "Laporan PL", "status_pembimbing": "Pembimbing Utama", "verified": true, "dokumen_path": "assets/pdf/example.pdf"}, {"id": 1, "kegiatan": "Membimbing dan ikut membimbing dalam menghasilkan disertasi", "nama": "Dr. Stone Pamungkas", "tahun_semester": "2018/2019 Ganjil", "nim": "UGE - 912", "nama_mahasiswa": "Pembudidayaan Ikan Lele", "strata": "S1", "departemen": "Teknologi Rekayasa Empang", "lokasi": "PT. Lele Tanpa Ekor", "nama_dokumen": "Laporan PL", "status_pembimbing": "Pembimbing Utama", "verified": false, "dokumen_path": "assets/pdf/example.pdf"}]'));
                              @endphp

                              @foreach ($dataPembimbingLama as $index => $item)
                              <tr>
                                  <td class="text-center">{{ $index + 1 }}</td>
                                  <td class="text-start">{{ Str::limit($item->kegiatan, 30) }}</td>
                                  <td>{{ $item->nama }}</td>
                                  <td class="text-center">{{ $item->tahun_semester }}</td>
                                  <td class="text-center">{{ $item->nim }}</td>
                                  <td>{{ $item->nama_mahasiswa }}</td>
                                  <td>{{ $item->departemen }}</td>
                                  <td>{{ $item->status_pembimbing }}</td>
                                  <td class="text-center">
                                      @if ($item->verified)
                                          <i class="fas fa-check-circle text-success"></i>
                                      @else
                                          <i class="fas fa-times-circle text-danger"></i>
                                      @endif
                                  </td>
                                  <td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td>
                                  <td class="text-center">
                                      <div class="d-flex gap-2 justify-content-center">
                                          <a href="#" class="btn-aksi btn-verifikasi btn-konfirmasi-pendidikan" 
                                            title="Verifikasi Data" 
                                            data-id="{{ $item->id }}">
                                              <i class="fa fa-check"></i>
                                          </a>
                                          
                                          {{-- Tombol Lihat Detail --}}
                                          <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-detail-pembimbing" title="Lihat Detail"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDetailPembimbingLama"
                                            data-kegiatan="{{ $item->kegiatan }}"
                                            data-nama="{{ $item->nama }}"
                                            data-tahun_semester="{{ $item->tahun_semester }}"
                                            data-lokasi="{{ $item->lokasi }}"
                                            data-nim="{{ $item->nim }}"
                                            data-nama_mahasiswa="{{ $item->nama_mahasiswa }}"
                                            data-departemen="{{ $item->departemen }}"
                                            data-nama_dokumen="{{ $item->nama_dokumen }}"
                                            data-dokumen_path="{{ $item->dokumen_path }}">
                                              <i class="fa fa-eye"></i>
                                          </a>
                                          
                                          {{-- Tombol Edit --}}
                                          <a href="#" class="btn-aksi btn-edit btn-edit-pembimbing-lama" title="Edit Data"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalPembimbingLama"
                                            data-id="{{ $item->id }}"
                                            data-kegiatan="{{ $item->kegiatan }}"
                                            data-nama="{{ $item->nama }}"
                                            data-tahun_semester="{{ $item->tahun_semester }}"
                                            data-nim="{{ $item->nim }}"
                                            data-nama_mahasiswa="{{ $item->nama_mahasiswa }}"
                                            data-departemen="{{ $item->departemen }}"
                                            data-lokasi="{{ $item->lokasi }}"
                                            data-nama_dokumen="{{ $item->nama_dokumen }}">
                                            <i class="fa fa-edit"></i>
                                          </a>
                                          <a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a>
                                      </div>
                                  </td>
                              </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>
            </div>
            
            {{-- PENGUJI LUAR --}}
            <div class="tab-pane fade" id="penguji-luar" role="tabpanel">
                {{-- Container untuk Pencarian dan Filter --}}
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
                        </select>
                        <div class="btn-tambah-container">
                            <a href="#" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#modalPengujiLuar" id="btnTambahPengujiLuar">
                                <i class="fa fa-plus me-2"></i> Tambah Data
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Tabel Data --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr class="text-center"><th>No</th><th class="text-start">Nama</th><th>Tahun Semester</th><th>NIM</th><th>Nama Mahasiswa</th><th>Universitas</th><th>Status</th><th>Verifikasi</th><th>Dokumen</th><th>Aksi</th></tr>
                        </thead>
                        <tbody>
                            @php
                                // Contoh data lengkap untuk Penguji Luar
                                $dataPengujiLuar = collect(json_decode('[{"id": 1, "kegiatan": "Senam Lele Merdeka", "nama": "Dr. Stone Pamungkas", "status": "Dosen Penguji", "tahun_semester": "2018/2019 Ganjil", "nim": "UGE - 912", "nama_mahasiswa": "Budi Lele", "universitas": "Universitas Gali Empang", "program_studi": "Teknologi Rekayasa Empang", "is_insidental": "Ya", "is_lebih_satu_semester": "Tidak", "verified": true, "dokumen_path": "assets/pdf/example.pdf"}, {"id": 1, "kegiatan": "Senam Lele Merdeka", "nama": "Dr. Stone Pamungkas", "status": "Dosen Penguji", "tahun_semester": "2018/2019 Ganjil", "nim": "UGE - 912", "nama_mahasiswa": "Budi Lele", "universitas": "Universitas Gali Empang", "program_studi": "Teknologi Rekayasa Empang", "is_insidental": "Ya", "is_lebih_satu_semester": "Tidak", "verified": false, "dokumen_path": "assets/pdf/example.pdf"}]'));
                            @endphp

                            @foreach ($dataPengujiLuar as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td class="text-center">{{ $item->tahun_semester }}</td>
                                <td class="text-center">{{ $item->nim }}</td>
                                <td>{{ $item->nama_mahasiswa }}</td>
                                <td>{{ $item->universitas }}</td>
                                <td>{{ $item->status }}</td>
                                <td class="text-center">
                                    @if ($item->verified)
                                        <i class="fas fa-check-circle text-success"></i>
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i>
                                    @endif
                                </td>
                                <td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                          <a href="#" class="btn-aksi btn-verifikasi btn-konfirmasi-pendidikan" 
                                            title="Verifikasi Data" 
                                            data-id="{{ $item->id }}">
                                              <i class="fa fa-check"></i>
                                          </a>
                                        
                                        {{-- Tombol Lihat Detail --}}
                                        <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-detail-penguji-luar" title="Lihat Detail"
                                          data-bs-toggle="modal"
                                          data-bs-target="#modalDetailPengujiLuar"
                                          data-kegiatan="{{ $item->kegiatan }}"
                                          data-nama="{{ $item->nama }}"
                                          data-status="{{ $item->status }}"
                                          data-tahun_semester="{{ $item->tahun_semester }}"
                                          data-nim="{{ $item->nim }}"
                                          data-nama_mahasiswa="{{ $item->nama_mahasiswa }}"
                                          data-universitas="{{ $item->universitas }}"
                                          data-program_studi="{{ $item->program_studi }}"
                                          data-is_insidental="{{ $item->is_insidental }}"
                                          data-is_lebih_satu_semester="{{ $item->is_lebih_satu_semester }}"
                                          data-dokumen_path="{{ $item->dokumen_path }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        
                                        {{-- Tombol Edit --}}
                                        <a href="#" class="btn-aksi btn-edit btn-edit-penguji-luar" title="Edit Data"
                                          data-bs-toggle="modal"
                                          data-bs-target="#modalPengujiLuar"
                                          data-id="{{ $item->id }}">
                                          <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- PEMBIMBING LUAR --}}
            <div class="tab-pane fade" id="pembimbing-luar" role="tabpanel">
                {{-- Container untuk Pencarian dan Filter --}}
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
                        </select>
                        <div class="btn-tambah-container">
                            <a href="#" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#modalPembimbingLuar" id="btnTambahPembimbingLuar">
                                <i class="fa fa-plus me-2"></i> Tambah Data
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Tabel Data --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr class="text-center"><th>No</th><th class="text-start">Nama</th><th>Tahun Semester</th><th>NIM</th><th>Nama Mahasiswa</th><th>Universitas</th><th>Status</th><th>Verifikasi</th><th>Dokumen</th><th>Aksi</th></tr>
                        </thead>
                        <tbody>
                            @php
                                // Contoh data lengkap untuk Pembimbing Luar
                                $dataPembimbingLuar = collect(json_decode('[{"id": 1, "kegiatan": "Senam Lele Merdeka", "nama": "Dr. Stone Pamungkas", "status": "Dosen Pembimbing", "tahun_semester": "2018/2019 Ganjil", "nim": "UGE - 912", "nama_mahasiswa": "Budi Lele", "universitas": "Universitas Gali Empang", "program_studi": "Teknologi Rekayasa Empang", "is_insidental": "Ya", "is_lebih_satu_semester": "Tidak", "verified": true, "dokumen_path": "assets/pdf/example.pdf"}, {"id": 1, "kegiatan": "Senam Lele Merdeka", "nama": "Dr. Stone Pamungkas", "status": "Dosen Pembimbing", "tahun_semester": "2018/2019 Ganjil", "nim": "UGE - 912", "nama_mahasiswa": "Budi Lele", "universitas": "Universitas Gali Empang", "program_studi": "Teknologi Rekayasa Empang", "is_insidental": "Ya", "is_lebih_satu_semester": "Tidak", "verified": false, "dokumen_path": "assets/pdf/example.pdf"}]'));
                            @endphp

                            @foreach ($dataPembimbingLuar as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td class="text-center">{{ $item->tahun_semester }}</td>
                                <td class="text-center">{{ $item->nim }}</td>
                                <td>{{ $item->nama_mahasiswa }}</td>
                                <td>{{ $item->universitas }}</td>
                                <td>{{ $item->status }}</td>
                                <td class="text-center">
                                    @if ($item->verified)
                                        <i class="fas fa-check-circle text-success"></i>
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i>
                                    @endif
                                </td>
                                <td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                          <a href="#" class="btn-aksi btn-verifikasi btn-konfirmasi-pendidikan" 
                                            title="Verifikasi Data" 
                                            data-id="{{ $item->id }}">
                                              <i class="fa fa-check"></i>
                                          </a>
                                        
                                        {{-- Tombol Lihat Detail --}}
                                        <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-detail-pembimbing-luar" title="Lihat Detail"
                                          data-bs-toggle="modal"
                                          data-bs-target="#modalDetailPembimbingLuar"
                                          data-kegiatan="{{ $item->kegiatan }}"
                                          data-nama="{{ $item->nama }}"
                                          data-status="{{ $item->status }}"
                                          data-tahun_semester="{{ $item->tahun_semester }}"
                                          data-nim="{{ $item->nim }}"
                                          data-nama_mahasiswa="{{ $item->nama_mahasiswa }}"
                                          data-universitas="{{ $item->universitas }}"
                                          data-program_studi="{{ $item->program_studi }}"
                                          data-is_insidental="{{ $item->is_insidental }}"
                                          data-is_lebih_satu_semester="{{ $item->is_lebih_satu_semester }}"
                                          data-dokumen_path="{{ $item->dokumen_path }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        
                                        {{-- Tombol Edit --}}
                                        <a href="#" class="btn-aksi btn-edit btn-edit-pembimbing-luar" title="Edit Data"
                                          data-bs-toggle="modal"
                                          data-bs-target="#modalPembimbingLuar"
                                          data-id="{{ $item->id }}">
                                          <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
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

  {{-- SECTION MODAL FORM ALL --}}
  {{-- Pengajaran Lama --}}
    <div class="modal fade" id="modalTambahEditPengajaranLama" tabindex="-1" aria-labelledby="modalPengajaranLamaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalPengajaranLamaLabel">
            {{-- Menambahkan ikon. Anda bisa menggunakan fa-info-circle atau fa-exclamation-circle --}}
            <i class="fas fa-plus-circle"></i>
            {{-- Membungkus teks judul dengan span agar mudah diubah oleh JS --}}
            <span id="modalTitleText">Tambah Pengajaran Lama</span>
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formPengajaranLama">
            {{-- Hidden input untuk menyimpan ID saat mode edit --}}
            <input type="hidden" id="editPengajaranId" name="id">

            <div class="mb-3">
              <label for="kegiatan" class="form-label">Kegiatan</label>
              <input type="text" class="form-control" id="kegiatan" value="Melaksanakan Perkuliahan/Tutorial/Perkuliahan Praktikum & Membimbing...." readonly disabled>
            </div>

            <div class="mb-3">
              <label for="nama" class="form-label">Nama</label>
              <select class="form-select" id="nama" name="nama">
                <option selected disabled value="">-- Pilih Salah Satu --</option>
                {{-- Anda bisa mengisi opsi ini dari database --}}
                <option value="Alex Kurniawan">Alex Kurniawan</option>
                <option value="Budi Santoso">Budi Santoso</option>
              </select>
            </div>
            
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="tahun_semester" class="form-label">Tahun Semester</label>
                <input type="text" class="form-control" id="tahun_semester" name="tahun_semester" placeholder="Contoh: 2020/2021">
              </div>
              <div class="col-md-6 mb-3">
                <label for="nama_mk" class="form-label">Nama Mata Kuliah</label>
                <input type="text" class="form-control" id="nama_mk" name="nama_mk" placeholder="Masukkan Nama Mata Kuliah">
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="kode_mk" class="form-label">Kode Mata Kuliah</label>
                <input type="text" class="form-control" id="kode_mk" name="kode_mk" placeholder="Masukkan Kode Mata Kuliah">
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">SKS</label>
                <div class="input-group">
                  <span class="input-group-text">Perkuliahan</span>
                  <input type="number" class="form-control" id="sks_kuliah" name="sks_kuliah" placeholder="0">
                  <span class="input-group-text">Praktikum</span>
                  <input type="number" class="form-control" id="sks_praktikum" name="sks_praktikum" placeholder="0">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="pengampu" class="form-label">Pengampu</label>
                <select class="form-select" id="pengampu" name="pengampu">
                  <option selected disabled value="">-- Pilih Salah Satu --</option>
                  <option value="1">Pilihan 1</option>
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label for="jenis" class="form-label">Jenis</label>
                <select class="form-select" id="jenis" name="jenis">
                  <option selected disabled value="">-- Pilih Salah Satu --</option>
                  <option value="K">Kuliah</option>
                  <option value="P">Praktikum</option>
                </select>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="kelas_paralel" class="form-label">Kelas Paralel</label>
                <input type="text" class="form-control" id="kelas_paralel" name="kelas_paralel" placeholder="Masukkan Kelas Paralel">
              </div>
              <div class="col-md-6 mb-3">
                <label for="jumlah_pertemuan" class="form-label">Jumlah Pertemuan</label>
                <input type="number" class="form-control" id="jumlah_pertemuan" name="jumlah_pertemuan" placeholder="Masukkan Jumlah Pertemuan">
              </div>
            </div>

            <div class="mb-3">
              <label for="upload_file" class="form-label">Upload File</label>
              <div class="file-drop-area">
                <i class="fas fa-cloud-upload-alt fa-3x mb-2 text-muted"></i>
                <span class="file-message">Drag & Drop File here</span>
                <span class="text-muted">Ukuran Maksimal 5 MB</span>
                <input class="file-input" type="file" id="upload_file" name="file">
              </div>
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" id="btnSimpanPengajaran">Simpan</button>
        </div>
      </div>
    </div>
    </div>
  {{-- Detail --}}
    <div class="modal fade" id="modalDetailPengajaranLama" tabindex="-1" aria-labelledby="modalDetailPengajaranLamaLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalDetailPengajaranLamaLabel">
            <i class="fas fa-info-circle"></i>
            <span id="modalTitleTextDetailPengajaranLama">Detail Pengajaran Lama</span>
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="detail-grid-container">
              <div class="detail-item full-width-detail">
                  <small>Kegiatan</small>
                  <p id="detail_pl_kegiatan">-</p>
              </div>
              <div class="detail-item">
                  <small>Nama</small>
                  <p id="detail_pl_nama">-</p>
              </div>
              <div class="detail-item">
                  <small>Tahun Semester</small>
                  <p id="detail_pl_tahun_semester">-</p>
              </div>
              <div class="detail-item">
                  <small>Kode Mata Kuliah</small>
                  <p id="detail_pl_kode_mk">-</p>
              </div>
              <div class="detail-item">
                  <small>Nama Mata Kuliah</small>
                  <p id="detail_pl_nama_mk">-</p>
              </div>
              <div class="detail-item">
                  <small>Pengampu</small>
                  <p id="detail_pl_pengampu">-</p>
              </div>
              <div class="detail-item">
                  <small>SKS Perkuliahan</small>
                  <p id="detail_pl_sks_kuliah">-</p>
              </div>
              <div class="detail-item">
                  <small>SKS Praktikum</small>
                  <p id="detail_pl_sks_praktikum">-</p>
              </div>
              <div class="detail-item">
                  <small>Jenis</small>
                  <p id="detail_pl_jenis">-</p>
              </div>
              <div class="detail-item">
                  <small>Kelas Paralel</small>
                  <p id="detail_pl_kelas_paralel">-</p>
              </div>
              <div class="detail-item">
                  <small>Jumlah Pertemuan</small>
                  <p id="detail_pl_jumlah_pertemuan">-</p>
              </div>
          </div>

          <h6 class="mt-4">Dokumen</h6>
          <div class="document-viewer-container">
              {{-- Path ke file PDF akan diisi oleh JavaScript --}}
              <embed id="detail_pl_document_viewer" src="" type="application/pdf" width="100%" height="600px" />
          </div>
        </div>
        <div class="modal-footer justify-content-end">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
    </div>

  {{-- Pengajaran Luar --}}
    <div class="modal fade" id="modalPengajaranLuar" tabindex="-1" aria-labelledby="modalPengajaranLuarLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalPengajaranLuarLabel">
              <i class="fas fa-plus-circle"></i>
              <span id="modalTitleTextPengajaranLuar">Tambah Kegiatan Pengajaran Luar IPB</span>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="formPengajaranLuar" onsubmit="return false;">
              <input type="hidden" id="editPengajaranLuarId" name="id">

              <div class="mb-3">
                <label for="pl_nama" class="form-label">Nama</label>
                <select class="form-select" id="pl_nama" name="nama">
                  <option selected disabled value="">-- Pilih Salah Satu --</option>
                  <option value="Alex Kurniawan">Alex Kurniawan</option>
                </select>
              </div>

              <div class="mb-3">
                <label for="pl_tahun_semester" class="form-label">Tahun Semester</label>
                <input type="text" class="form-control" id="pl_tahun_semester" name="tahun_semester" placeholder="Contoh: 2020/2021">
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="pl_kode_mk" class="form-label">Kode Mata Kuliah</label>
                  <input type="text" class="form-control" id="pl_kode_mk" name="kode_mk">
                </div>
                <div class="col-md-6">
                  <label for="pl_nama_mk" class="form-label">Nama Mata Kuliah</label>
                  <input type="text" class="form-control" id="pl_nama_mk" name="nama_mk">
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">SKS</label>
                <div class="row">
                    <div class="col-md-6">
                        <input type="number" class="form-control" id="pl_sks_kuliah" name="sks_kuliah" placeholder="Perkuliahan">
                    </div>
                    <div class="col-md-6">
                        <input type="number" class="form-control" id="pl_sks_praktikum" name="sks_praktikum" placeholder="Praktikum">
                    </div>
                </div>
              </div>

              <div class="mb-3">
                <label for="pl_universitas" class="form-label">Universitas</label>
                <input type="text" class="form-control" id="pl_universitas" name="universitas" placeholder="Masukan Universitas Kegiatan Anda">
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="pl_strata" class="form-label">Strata</label>
                  <select class="form-select" id="pl_strata" name="strata">
                    <option selected disabled value="">-- Pilih Salah Satu --</option>
                    <option value="S1">S1</option>
                    <option value="S2">S2</option>
                    <option value="S3">S3</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="pl_program_studi" class="form-label">Program Studi</label>
                  <input type="text" class="form-control" id="pl_program_studi" name="program_studi">
                </div>
              </div>

              <div class="mb-3">
                  <label for="pl_jenis" class="form-label">Jenis</label>
                  <select class="form-select" id="pl_jenis" name="jenis">
                    <option selected disabled value="">-- Pilih Salah Satu --</option>
                    <option value="K">Kuliah</option>
                    <option value="P">Praktikum</option>
                  </select>
              </div>
              
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="pl_kelas_paralel" class="form-label">Kelas Paralel</label>
                  <input type="text" class="form-control" id="pl_kelas_paralel" name="kelas_paralel">
                </div>
                <div class="col-md-6">
                  <label for="pl_jumlah_pertemuan" class="form-label">Jumlah Pertemuan</label>
                  <input type="number" class="form-control" id="pl_jumlah_pertemuan" name="jumlah_pertemuan">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="pl_is_insidental" class="form-label">Insidental</label>
                  <select class="form-select" id="pl_is_insidental" name="is_insidental">
                    <option selected disabled value="">-- Pilih Salah Satu --</option>
                    <option value="Ya">Ya</option>
                    <option value="Tidak">Tidak</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="pl_is_lebih_satu_semester" class="form-label">Lebih Dari 1 Semester</label>
                  <select class="form-select" id="pl_is_lebih_satu_semester" name="is_lebih_satu_semester">
                    <option selected disabled value="">-- Pilih Salah Satu --</option>
                    <option value="Ya">Ya</option>
                    <option value="Tidak">Tidak</option>
                  </select>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">Upload File</label>
                <div class="file-drop-area">
                  <i class="fas fa-cloud-upload-alt fa-3x mb-2 text-muted"></i>
                  <span class="file-message">Drag & Drop File here</span>
                  <span class="text-muted">Ukuran Maksimal 5 MB</span>
                  <input class="file-input" type="file" name="file">
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn" id="btnBatalPengajaranLuar" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn" id="btnSimpanPengajaranLuar">Simpan</button>
          </div>
        </div>
      </div>
      </div>
  {{-- detail --}}
  <div class="modal fade" id="modalDetailPengajaranLuar" tabindex="-1" aria-labelledby="modalDetailPengajaranLuarLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalDetailPengajaranLuarLabel">
            <i class="fas fa-info-circle"></i>
            <span id="modalTitleTextDetailPengajaranLuar">Detail Pengajaran Luar IPB</span>
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="detail-grid-container">
              <div class="detail-item"><small>Nama</small><p id="detail_pluar_nama">-</p></div>
              <div class="detail-item"><small>Tahun Semester</small><p id="detail_pluar_tahun_semester">-</p></div>
              <div class="detail-item"><small>Universitas</small><p id="detail_pluar_universitas">-</p></div>
              <div class="detail-item"><small>Kode Mata Kuliah</small><p id="detail_pluar_kode_mk">-</p></div>
              <div class="detail-item"><small>Nama Mata Kuliah</small><p id="detail_pluar_nama_mk">-</p></div>
              <div class="detail-item"><small>Program Studi</small><p id="detail_pluar_program_studi">-</p></div>
              <div class="detail-item"><small>SKS Perkuliahan</small><p id="detail_pluar_sks_kuliah">-</p></div>
              <div class="detail-item"><small>SKS Praktikum</small><p id="detail_pluar_sks_praktikum">-</p></div>
              <div class="detail-item"><small>Jenis</small><p id="detail_pluar_jenis">-</p></div>
              <div class="detail-item"><small>Kelas Paralel</small><p id="detail_pluar_kelas_paralel">-</p></div>
              <div class="detail-item"><small>Jumlah Pertemuan</small><p id="detail_pluar_jumlah_pertemuan">-</p></div>
              <div class="detail-item"><small>Insidental</small><p id="detail_pluar_insidental">-</p></div>
              <div class="detail-item"><small>Lebih Dari 1 Semester</small><p id="detail_pluar_lebih_satu_semester">-</p></div>
          </div>
          <h6 class="mt-4">Dokumen</h6>
          <div class="document-viewer-container">
              <embed id="detail_pluar_document_viewer" src="" type="application/pdf" width="100%" height="600px" />
          </div>
        </div>
        <div class="modal-footer justify-content-end">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  {{-- Pengujian Lama --}}
  <div class="modal fade" id="modalPengujianLama" tabindex="-1" aria-labelledby="modalPengujianLamaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalPengujianLamaLabel">
            <i class="fas fa-plus-circle"></i>
            <span id="modalTitleTextPengujianLama">Tambah Kegiatan Pengujian Lama</span>
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formPengujianLama" onsubmit="return false;">
            <input type="hidden" id="editPengujianLamaId" name="id">

            <div class="mb-3">
              <label for="pjl_kegiatan" class="form-label">Kegiatan</label>
              <select class="form-select" id="pjl_kegiatan" name="kegiatan">
                  <option selected disabled value="">Bertugas sebagai penguji pada Ujian Akhir/Profesi (Setiap Mahasiswa): Ketua Penguji</option>
                  <option value="Ketua Penguji">Ketua Penguji</option>
                  <option value="Anggota Penguji">Anggota Penguji</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="pjl_nama" class="form-label">Nama</label>
              <select class="form-select" id="pjl_nama" name="nama">
                <option selected disabled value="">-- Pilih Salah Satu --</option>
                <option value="Alex Kurniawan">Alex Kurniawan</option>
              </select>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="pjl_strata" class="form-label">Strata</label>
                <select class="form-select" id="pjl_strata" name="strata">
                  <option selected disabled value="">-- Pilih Salah Satu --</option>
                  <option value="S1">S1</option>
                  <option value="S2">S2</option>
                  <option value="S3">S3</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="pjl_tahun_semester" class="form-label">Tahun Semester</label>
                <input type="text" class="form-control" id="pjl_tahun_semester" name="tahun_semester" placeholder="Contoh: 2020/2021">
              </div>
            </div>
            
            <div class="mb-3">
              <label for="pjl_nim" class="form-label">NIM</label>
              <input type="text" class="form-control" id="pjl_nim" name="nim" placeholder="Masukkan NIM Mahasiswa">
            </div>

            <div class="mb-3">
              <label for="pjl_nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
              <input type="text" class="form-control" id="pjl_nama_mahasiswa" name="nama_mahasiswa" placeholder="Masukkan Nama Mahasiswa">
            </div>

            <div class="mb-3">
              <label for="pjl_departemen" class="form-label">Departemen</label>
              <select class="form-select" id="pjl_departemen" name="departemen">
                <option selected disabled value="">-- Pilih Salah Satu --</option>
                <option value="Manajemen Hutan">Manajemen Hutan</option>
                <option value="Teknologi Hasil Hutan">Teknologi Hasil Hutan</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Upload File</label>
              <div class="file-drop-area">
                <i class="fas fa-cloud-upload-alt fa-3x mb-2 text-muted"></i>
                <span class="file-message">Drag & Drop File here</span>
                <span class="text-muted">Ukuran Maksimal 5 MB</span>
                <input class="file-input" type="file" name="file">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" id="btnBatalPengujianLama" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn" id="btnSimpanPengujianLama">Simpan</button>
        </div>
      </div>
    </div>
  </div>
  {{-- DETAIL --}}
  <div class="modal fade" id="modalDetailPengujianLama" tabindex="-1" aria-labelledby="modalDetailPengujianLamaLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalDetailPengujianLamaLabel">
              <i class="fas fa-info-circle"></i>
              <span id="modalTitleTextDetailPengujianLama">Detail Pengujian Lama</span>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="detail-grid-container">
                <div class="detail-item full-width-detail"><small>Kegiatan</small><p id="detail_pjl_kegiatan">-</p></div>
                <div class="detail-item"><small>Nama</small><p id="detail_pjl_nama">-</p></div>
                <div class="detail-item"><small>Tahun Semester</small><p id="detail_pjl_tahun_semester">-</p></div>
                <div class="detail-item"><small>NIM</small><p id="detail_pjl_nim">-</p></div>
                <div class="detail-item"><small>Nama Mahasiswa</small><p id="detail_pjl_nama_mahasiswa">-</p></div>
                <div class="detail-item"><small>Departemen</small><p id="detail_pjl_departemen">-</p></div>
            </div>
            <h6 class="mt-4">Dokumen</h6>
            <div class="document-viewer-container">
                <embed id="detail_pjl_document_viewer" src="" type="application/pdf" width="100%" height="600px" />
            </div>
          </div>
          <div class="modal-footer justify-content-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
  </div>

  {{-- Pembimbing Lama --}}
  <div class="modal fade" id="modalPembimbingLama" tabindex="-1" aria-labelledby="modalPembimbingLamaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalPembimbingLamaLabel">
            <i class="fas fa-plus-circle"></i>
            <span id="modalTitleTextPembimbingLama">Tambah Kegiatan Pembimbing Lama</span>
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formPembimbingLama" onsubmit="return false;">
            <input type="hidden" id="editPembimbingLamaId" name="id">

            <div class="mb-3">
              <label for="pbl_kegiatan" class="form-label">Kegiatan</label>
              <select class="form-select" id="pbl_kegiatan" name="kegiatan">
                  <option selected disabled value="">-- Pilih Salah Satu --</option>
                  <option value="Membimbing dan ikut membimbing dalam menghasilkan disertasi">Membimbing dan ikut membimbing dalam menghasilkan disertasi</option>
                  <option value="Kegiatan Lain">Kegiatan Lain</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="pbl_nama" class="form-label">Nama</label>
              <select class="form-select" id="pbl_nama" name="nama">
                <option selected disabled value="">-- Pilih Salah Satu --</option>
                <option value="Dr. Ir Kevin Ms">Dr. Ir Kevin Ms</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="pbl_tahun_semester" class="form-label">Tahun Semester</label>
              <input type="text" class="form-control" id="pbl_tahun_semester" name="tahun_semester" placeholder="Contoh: 2020/2021">
            </div>
            
            <div class="mb-3">
              <label for="pbl_nim" class="form-label">NIM</label>
              <input type="text" class="form-control" id="pbl_nim" name="nim" placeholder="Masukkan NIM Mahasiswa">
            </div>

            <div class="mb-3">
              <label for="pbl_nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
              <input type="text" class="form-control" id="pbl_nama_mahasiswa" name="nama_mahasiswa" placeholder="Masukkan Nama Mahasiswa">
            </div>

            <div class="mb-3">
              <label for="pbl_departemen" class="form-label">Departemen</label>
              <select class="form-select" id="pbl_departemen" name="departemen">
                <option selected disabled value="">-- Pilih Salah Satu --</option>
                <option value="Manajemen Hutan">Manajemen Hutan</option>
                <option value="Teknologi Hasil Hutan">Teknologi Hasil Hutan</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="pbl_lokasi" class="form-label">Lokasi (PL/KKN)</label>
              <input type="text" class="form-control" id="pbl_lokasi" name="lokasi" placeholder="Masukkan Lokasi PL/KKN">
            </div>

            <div class="mb-3">
              <label for="pbl_nama_dokumen" class="form-label">Nama Dokumen</label>
              <input type="text" class="form-control" id="pbl_nama_dokumen" name="nama_dokumen" placeholder="Contoh: Surat Tugas">
            </div>

            <div class="mb-3">
              <label class="form-label">Upload File</label>
              <div class="file-drop-area">
                <i class="fas fa-cloud-upload-alt fa-3x mb-2 text-muted"></i>
                <span class="file-message">Drag & Drop File here</span>
                <span class="text-muted">Ukuran Maksimal 5 MB</span>
                <input class="file-input" type="file" name="file">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" id="btnBatalPembimbingLama" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn" id="btnSimpanPembimbingLama">Simpan</button>
        </div>
      </div>
    </div>
  </div>
  {{-- Detail --}}
  <div class="modal fade" id="modalDetailPembimbingLama" tabindex="-1" aria-labelledby="modalDetailPembimbingLamaLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalDetailPembimbingLamaLabel">
              <i class="fas fa-info-circle"></i>
              <span id="modalTitleTextDetailPembimbingLama">Detail Pembimbing Lama</span>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="detail-grid-container">
                <div class="detail-item full-width-detail"><small>Kegiatan</small><p id="detail_pbl_kegiatan">-</p></div>
                <div class="detail-item"><small>Nama</small><p id="detail_pbl_nama">-</p></div>
                <div class="detail-item"><small>Tahun Semester</small><p id="detail_pbl_tahun_semester">-</p></div>
                <div class="detail-item"><small>Lokasi (PL/KKN)</small><p id="detail_pbl_lokasi">-</p></div>
                <div class="detail-item"><small>NIM</small><p id="detail_pbl_nim">-</p></div>
                <div class="detail-item"><small>Nama Mahasiswa</small><p id="detail_pbl_nama_mahasiswa">-</p></div>
                <div class="detail-item"><small>Departemen</small><p id="detail_pbl_departemen">-</p></div>
                <div class="detail-item"><small>Nama Dokumen</small><p id="detail_pbl_nama_dokumen">-</p></div>
            </div>
            <h6 class="mt-4">Dokumen</h6>
            <div class="document-viewer-container">
                <embed id="detail_pbl_document_viewer" src="" type="application/pdf" width="100%" height="600px" />
            </div>
          </div>
          <div class="modal-footer justify-content-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
  </div>

  {{-- Penguji Luar IPB --}}
  <div class="modal fade" id="modalPengujiLuar" tabindex="-1" aria-labelledby="modalPengujiLuarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalPengujiLuarLabel">
            <i class="fas fa-plus-circle"></i>
            <span id="modalTitleTextPengujiLuar">Tambah Kegiatan Penguji Luar IPB</span>
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formPengujiLuar" onsubmit="return false;">
            <input type="hidden" id="editPengujiLuarId" name="id">

            <div class="mb-3">
              <label for="pjl_kegiatan" class="form-label">Kegiatan</label>
              <select class="form-select" id="pjl_kegiatan" name="kegiatan">
                  <option selected disabled value="">-- Pilih Salah Satu --</option>
                  <option value="Ujian Akhir">Ujian Akhir</option>
                  <option value="Ujian Disertasi">Ujian Disertasi</option>
              </select>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                  <label for="pjl_nama" class="form-label">Nama</label>
                  <select class="form-select" id="pjl_nama" name="nama">
                    <option selected disabled value="">-- Pilih Salah Satu --</option>
                    <option value="Nama Dosen">Nama Dosen</option>
                  </select>
              </div>
              <div class="col-md-6">
                  <label for="pjl_status" class="form-label">Status</label>
                  <select class="form-select" id="pjl_status" name="status">
                    <option selected disabled value="">-- Pilih Salah Satu --</option>
                    <option value="Ketua Penguji">Ketua Penguji</option>
                    <option value="Anggota Penguji">Anggota Penguji</option>
                  </select>
              </div>
            </div>

            <div class="mb-3">
              <label for="pjl_tahun_semester_luar" class="form-label">Tahun Semester</label>
              <input type="text" class="form-control" id="pjl_tahun_semester_luar" name="tahun_semester" placeholder="Contoh: 2020/2021">
            </div>
            
            <div class="mb-3">
              <label for="pjl_nim_luar" class="form-label">NIM</label>
              <input type="text" class="form-control" id="pjl_nim_luar" name="nim" placeholder="Masukkan NIM Mahasiswa">
            </div>

            <div class="mb-3">
              <label for="pjl_nama_mahasiswa_luar" class="form-label">Nama Mahasiswa</label>
              <input type="text" class="form-control" id="pjl_nama_mahasiswa_luar" name="nama_mahasiswa" placeholder="Masukkan Nama Mahasiswa">
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="pjl_universitas" class="form-label">Universitas</label>
                <input type="text" class="form-control" id="pjl_universitas" name="universitas" placeholder="Nama Universitas">
              </div>
              <div class="col-md-6">
                <label for="pjl_strata_luar" class="form-label">Strata</label>
                <select class="form-select" id="pjl_strata_luar" name="strata">
                  <option selected disabled value="">-- Pilih Salah Satu --</option>
                  <option value="S1">S1</option>
                  <option value="S2">S2</option>
                  <option value="S3">S3</option>
                </select>
              </div>
            </div>

            <div class="mb-3">
              <label for="pjl_program_studi" class="form-label">Program Studi</label>
              <input type="text" class="form-control" id="pjl_program_studi" name="program_studi" placeholder="Nama Program Studi">
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="pjl_is_insidental" class="form-label">Insidental</label>
                <select class="form-select" id="pjl_is_insidental" name="is_insidental">
                  <option selected disabled value="">-- Pilih Salah Satu --</option>
                  <option value="Ya">Ya</option>
                  <option value="Tidak">Tidak</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="pjl_is_lebih_satu_semester" class="form-label">Lebih Dari 1 Semester</label>
                <select class="form-select" id="pjl_is_lebih_satu_semester" name="is_lebih_satu_semester">
                  <option selected disabled value="">-- Pilih Salah Satu --</option>
                  <option value="Ya">Ya</option>
                  <option value="Tidak">Tidak</option>
                </select>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Upload File</label>
              <div class="file-drop-area">
                <i class="fas fa-cloud-upload-alt fa-3x mb-2 text-muted"></i>
                <span class="file-message">Drag & Drop File here</span>
                <span class="text-muted">Ukuran Maksimal 5 MB</span>
                <input class="file-input" type="file" name="file">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" id="btnBatalPengujiLuar" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn" id="btnSimpanPengujiLuar">Simpan</button>
        </div>
      </div>
    </div>
  </div>
  {{-- Detail --}}
  <div class="modal fade" id="modalDetailPengujiLuar" tabindex="-1" aria-labelledby="modalDetailPengujiLuarLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalDetailPengujiLuarLabel">
              <i class="fas fa-info-circle"></i>
              <span id="modalTitleTextDetailPengujiLuar">Detail Penguji Luar IPB</span>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="detail-grid-container">
                <div class="detail-item full-width-detail"><small>Kegiatan</small><p id="detail_pjl_luar_kegiatan">-</p></div>
                <div class="detail-item"><small>Nama</small><p id="detail_pjl_luar_nama">-</p></div>
                <div class="detail-item"><small>Status</small><p id="detail_pjl_luar_status">-</p></div>
                <div class="detail-item"><small>Tahun Semester</small><p id="detail_pjl_luar_tahun_semester">-</p></div>
                <div class="detail-item"><small>NIM</small><p id="detail_pjl_luar_nim">-</p></div>
                <div class="detail-item"><small>Nama Mahasiswa</small><p id="detail_pjl_luar_nama_mahasiswa">-</p></div>
                <div class="detail-item"><small>Universitas</small><p id="detail_pjl_luar_universitas">-</p></div>
                <div class="detail-item"><small>Program Studi</small><p id="detail_pjl_luar_program_studi">-</p></div>
                <div class="detail-item"><small>Insidental</small><p id="detail_pjl_luar_insidental">-</p></div>
                <div class="detail-item"><small>Lebih Dari 1 Semester</small><p id="detail_pjl_luar_lebih_satu_semester">-</p></div>
            </div>
            <h6 class="mt-4">Dokumen</h6>
            <div class="document-viewer-container">
                <embed id="detail_pjl_luar_document_viewer" src="" type="application/pdf" width="100%" height="600px" />
            </div>
          </div>
          <div class="modal-footer justify-content-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
  </div>

  {{-- Pembimbing Luar IPB --}}
  <div class="modal fade" id="modalPembimbingLuar" tabindex="-1" aria-labelledby="modalPembimbingLuarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPembimbingLuarLabel">
          <i class="fas fa-plus-circle"></i>
          <span id="modalTitleTextPembimbingLuar">Tambah Kegiatan Pembimbing Luar IPB</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formPembimbingLuar" onsubmit="return false;">
          <input type="hidden" id="editPembimbingLuarId" name="id">

          <div class="mb-3">
            <label for="pbl_kegiatan_luar" class="form-label">Kegiatan</label>
            <select class="form-select" id="pbl_kegiatan_luar" name="kegiatan">
                <option selected disabled value="">-- Pilih Salah Satu --</option>
                <option value="Membimbing Disertasi">Membimbing Disertasi</option>
                <option value="Membimbing Tesis">Membimbing Tesis</option>
            </select>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
                <label for="pbl_nama_luar" class="form-label">Nama</label>
                <select class="form-select" id="pbl_nama_luar" name="nama">
                  <option selected disabled value="">-- Pilih Salah Satu --</option>
                  <option value="Nama Dosen">Nama Dosen</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="pbl_status_luar" class="form-label">Status</label>
                <select class="form-select" id="pbl_status_luar" name="status">
                  <option selected disabled value="">-- Pilih Salah Satu --</option>
                  <option value="Pembimbing Utama">Pembimbing Utama</option>
                  <option value="Pembimbing Pendamping">Pembimbing Pendamping</option>
                </select>
            </div>
          </div>

          <div class="mb-3">
            <label for="pbl_tahun_semester_luar" class="form-label">Tahun Semester</label>
            <input type="text" class="form-control" id="pbl_tahun_semester_luar" name="tahun_semester" placeholder="Contoh: 2020/2021">
          </div>
          
          <div class="mb-3">
            <label for="pbl_nim_luar" class="form-label">NIM</label>
            <input type="text" class="form-control" id="pbl_nim_luar" name="nim" placeholder="Masukkan NIM Mahasiswa">
          </div>

          <div class="mb-3">
            <label for="pbl_nama_mahasiswa_luar" class="form-label">Nama Mahasiswa</label>
            <input type="text" class="form-control" id="pbl_nama_mahasiswa_luar" name="nama_mahasiswa" placeholder="Masukkan Nama Mahasiswa">
          </div>

          <div class="mb-3">
            <label for="pbl_universitas_luar" class="form-label">Universitas</label>
            <input type="text" class="form-control" id="pbl_universitas_luar" name="universitas" placeholder="Nama Universitas">
          </div>

          <div class="mb-3">
            <label for="pbl_program_studi_luar" class="form-label">Program Studi</label>
            <input type="text" class="form-control" id="pbl_program_studi_luar" name="program_studi" placeholder="Nama Program Studi">
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="pbl_is_insidental_luar" class="form-label">Insidental</label>
              <select class="form-select" id="pbl_is_insidental_luar" name="is_insidental">
                <option selected disabled value="">-- Pilih Salah Satu --</option>
                <option value="Ya">Ya</option>
                <option value="Tidak">Tidak</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="pbl_is_lebih_satu_semester_luar" class="form-label">Lebih Dari 1 Semester</label>
              <select class="form-select" id="pbl_is_lebih_satu_semester_luar" name="is_lebih_satu_semester">
                <option selected disabled value="">-- Pilih Salah Satu --</option>
                <option value="Ya">Ya</option>
                <option value="Tidak">Tidak</option>
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Upload File</label>
            <div class="file-drop-area">
              <i class="fas fa-cloud-upload-alt fa-3x mb-2 text-muted"></i>
              <span class="file-message">Drag & Drop File here</span>
              <span class="text-muted">Ukuran Maksimal 5 MB</span>
              <input class="file-input" type="file" name="file">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" id="btnBatalPembimbingLuar" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn" id="btnSimpanPembimbingLuar">Simpan</button>
      </div>
    </div>
  </div>
  </div>
  {{-- Detail --}}
  <div class="modal fade" id="modalDetailPembimbingLuar" tabindex="-1" aria-labelledby="modalDetailPembimbingLuarLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalDetailPembimbingLuarLabel">
              <i class="fas fa-info-circle"></i>
              <span id="modalTitleTextDetailPembimbingLuar">Detail Pembimbing Luar IPB</span>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="detail-grid-container">
                <div class="detail-item full-width-detail"><small>Kegiatan</small><p id="detail_pbl_luar_kegiatan">-</p></div>
                <div class="detail-item"><small>Nama</small><p id="detail_pbl_luar_nama">-</p></div>
                <div class="detail-item"><small>Status</small><p id="detail_pbl_luar_status">-</p></div>
                <div class="detail-item"><small>Tahun Semester</small><p id="detail_pbl_luar_tahun_semester">-</p></div>
                <div class="detail-item"><small>NIM</small><p id="detail_pbl_luar_nim">-</p></div>
                <div class="detail-item"><small>Nama Mahasiswa</small><p id="detail_pbl_luar_nama_mahasiswa">-</p></div>
                <div class="detail-item"><small>Universitas</small><p id="detail_pbl_luar_universitas">-</p></div>
                <div class="detail-item"><small>Program Studi</small><p id="detail_pbl_luar_program_studi">-</p></div>
                <div class="detail-item"><small>Insidental</small><p id="detail_pbl_luar_insidental">-</p></div>
                <div class="detail-item"><small>Lebih Dari 1 Semester</small><p id="detail_pbl_luar_lebih_satu_semester">-</p></div>
            </div>
            <h6 class="mt-4">Dokumen</h6>
            <div class="document-viewer-container">
                <embed id="detail_pbl_luar_document_viewer" src="" type="application/pdf" width="100%" height="600px" />
            </div>
          </div>
          <div class="modal-footer justify-content-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
  </div>

  {{-- konfirmasi modal --}}
<div class="confirmation-popup-overlay" id="modalKonfirmasiPendidikan" style="display: none;">
    <div class="confirmation-popup-box">
        <h3 class="popup-title" id="popupKonfirmasiTitle">Konfirmasi Verifikasi Data</h3>
        <p class="popup-subtitle">Apakah Anda yakin ingin melanjutkan proses ini?</p>
        <div class="popup-buttons">
            <button class="btn-popup btn-terima" id="popupBtnTerima">Terima</button>
            <button class="btn-popup btn-tolak" id="popupBtnTolak">Tolak</button>
            <button class="btn-popup btn-kembali" id="popupBtnKembali">Kembali</button>
        </div>
    </div>
</div>

  <script src="{{ asset('assets/js/pendidikan.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>