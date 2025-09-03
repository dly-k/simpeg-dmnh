<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SIKEMAH - Editor Kegiatan (SK Non PNS)</title>
  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/sk-non-pns.css') }}" />
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
          <a href="/pengabdian" aria-label="Pengabdian">Pengabdian</a>
          <a href="/penunjang" aria-label="Penunjang">Penunjang</a>
          <a href="/pelatihan" aria-label="Pelatihan">Pelatihan</a>
          <a href="/penghargaan" aria-label="Penghargaan">Penghargaan</a>
          <a href="/sk-non-pns" aria-label="SK Non PNS" class="active">SK Non PNS</a>
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
    <h1><i class="lni lni-pencil-alt"></i> <span id="page-title">Editor Kegiatan - SK Non PNS</span></h1>
  </div>

  <div class="main-content">
      @if ($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <h5 class="alert-heading">Terjadi Kesalahan Validasi!</h5>
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      @endif
      
      <div class="card">
          <div class="search-filter-container">
            <div class="search-filter-row">
                <div class="search-box">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search search-icon"></i></span>
                        <input type="text" class="form-control border-start-0 search-input" placeholder="Cari Data ....">
                    </div>
                </div>
                <select class="form-select filter-select "><option selected>Tahun</option><option>2025</option><option>2024</option></select>
                <a href="#" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#skNonPnsModal">
                    <i class="fa fa-plus me-2"></i> Tambah Data
                </a>
            </div>
          </div>

<div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>Unit</th>
                        <th>Nomor SK</th>
                        <th>Tanggal SK</th>
                        <th>Dokumen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                  {{-- Gunakan perulangan @forelse untuk menampilkan data --}}
                  @forelse ($skData as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + $skData->firstItem() - 1 }}</td>
                        <td>{{ $item->nama_pegawai }}</td>
                        <td>{{ $item->nama_unit }}</td>
                        <td>{{ $item->nomor_sk }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_sk)->format('d M Y') }}</td>
                        <td class="text-center">
                        <a href="{{ Storage::url($item->dokumen_path) }}" target="_blank" class="btn-lihat-dokumen btn btn-sm btn-lihat text-white">Lihat</a>
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="#" 
                                   class="btn-aksi btn-lihat-detail" 
                                   title="Detail" 
                                   data-bs-toggle="modal" 
                                   data-bs-target="#modalDetailSkNonPns"
                                   data-nomor_sk="{{ $item->nomor_sk }}"
                                   data-tanggal_sk="{{ \Carbon\Carbon::parse($item->tanggal_sk)->format('d M Y') }}"
                                   data-pegawai="{{ $item->nama_pegawai }}"
                                   data-unit="{{ $item->nama_unit }}"
                                   data-jenis_sk="{{ $item->jenis_sk }}"
                                   data-tgl_mulai="{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}"
                                   data-tgl_selesai="{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}"
                                   data-dokumen_path="{{ Illuminate\Support\Facades\Storage::url($item->dokumen_path) }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#" class="btn-aksi btn-edit" title="Edit" 
                                  data-id="{{ $item->id }}"
                                  data-bs-toggle="modal" 
                                  data-bs-target="#skNonPnsModal">
                                    <i class="fas fa-edit"></i>
                                </a>
                                {{-- Di dalam perulangan @forelse pada tabel --}}
                                <a href="#" class="btn-aksi btn-hapus" title="Hapus"
                                  data-id="{{ $item->id }}"
                                  data-nama="{{ $item->nama_pegawai }}">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                  @empty
                    {{-- Tampil jika tidak ada data sama sekali --}}
                    <tr>
                        <td colspan="7" class="text-center text-muted">Data tidak ditemukan.</td>
                    </tr>
  
                  @endforelse
                </tbody>
            </table>
          </div>
          
          {{-- Ganti bagian ini dengan data paginasi dari controller --}}
          <div class="d-flex justify-content-between align-items-center mt-4">
              <span class="text-muted small">
                Menampilkan {{ $skData->firstItem() }} sampai {{ $skData->lastItem() }} dari {{ $skData->total() }} data
              </span>
              <nav aria-label="Page navigation">
                {{-- Tampilkan link paginasi --}}
                {{ $skData->links() }}
              </nav>
          </div>
      </div>
  </div>

  <footer class="footer-custom">
    <span>© 2025 Forest Management — All Rights Reserved</span>
  </footer>

  @include('components.konfirmasi-hapus')
  @include('components.konfirmasi-berhasil')
  @include('components.sk-nonpns.detail-sk-non-pns')
  @include('components.sk-nonpns.tambah-sk-non-pns')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="{{ asset('assets/js/sk-non-pns.js') }}"></script>

  @if (session('success'))
  <script>
      document.addEventListener('DOMContentLoaded', () => {
          // Memanggil fungsi showSuccessModal yang sudah global dari sk-non-pns.js
          showSuccessModal('Berhasil!', '{{ session('success') }}');
      });
  </script>
  @endif
</body>
</html>