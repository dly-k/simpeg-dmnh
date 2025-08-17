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

  {{-- Kumpulan Modal  --}}
    @include('components.konfirmasi-hapus')
    @include('components.konfirmasi-berhasil')
    @include('components.konfirmasi-verifikasi')
    
    @include('components.pendidikan.detail-pengajaran-lama')
    @include('components.pendidikan.tambah-pengajaran-lama')

    @include('components.pendidikan.detail-pengajaran-luar')
    @include('components.pendidikan.tambah-pengajaran-luar')

    @include('components.pendidikan.detail-pengujian-lama')
    @include('components.pendidikan.tambah-pengujian-lama')
    
    @include('components.pendidikan.detail-pembimbing-lama')
    @include('components.pendidikan.tambah-pembimbing-lama')
    
    @include('components.pendidikan.detail-penguji-luar')
    @include('components.pendidikan.tambah-penguji-luar')
    
    @include('components.pendidikan.detail-pembimbing-luar')
    @include('components.pendidikan.tambah-pembimbing-luar')

  <script src="{{ asset('assets/js/pendidikan.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>