<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SIKEMAH - Editor Kegiatan (Penelitian)</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
  
  {{-- Aset CSS Anda --}}
  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/penelitian.css') }}" />
</head>

<body>
  {{-- Sidebar --}}
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

  {{-- Navbar --}}
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
            <li><a class="dropdown-item d-flex align-items-center" href="/ubah-password"><i class="lni lni-key me-2"></i> Ubah Password</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item d-flex align-items-center dropdown-item-danger" href="/logout"><i class="lni lni-exit me-2"></i> Keluar</a></li>
          </ul>
        </div>
    </div>
  </div>

  {{-- Title Bar --}}
  <div class="title-bar">
    <h1><i class="lni lni-pencil-alt"></i> <span id="page-title">Editor Kegiatan - Penelitian</span></h1>
  </div>

  {{-- Main Content --}}
  <div class="main-content">
    <div class="card">
      <div class="search-filter-container">
        <div class="search-filter-row">
          <div class="search-box">
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0"><i class="fas fa-search search-icon"></i></span>
              <input type="text" class="form-control border-start-0 search-input" placeholder="Cari Judul, Penulis...">
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
            <option value="Menyunting Buku">Mengedit/Menyunting Karya Ilmiah</option>
            <option value="Jurnal Internasional Bereputasi">Jurnal Internasional Bereputasi</option>
            <option value="Jurnal Internasional Terindeks">Jurnal Internasional Terindeks</option>
            <option value="Jurnal Nasional">Jurnal Nasional</option>
            <option value="Jurnal Nasional Terakreditasi">Jurnal Nasional Terakreditasi</option>
            <option value="Prosiding Internasional Terindeks WoS/Scopus">Prosiding Internasional Terindeks WoS/Scopus</option>
            <option value="Paten Sederhana">Paten Sederhana</option>
          </select>

          <select class="form-select filter-select">
            <option selected>Status</option>
            <option>Sudah Diverifikasi</option>
            <option>Belum Diverifikasi</option>
            <option>Ditolak</option>
          </select>
          
          <div class="btn-tambah-container">
            <a href="#" class="btn btn-tambah fw-bold" onclick="openModal()">
              <i class="fas fa-plus me-2"></i> Tambah Data
            </a>
          </div>
        </div>
      </div>

      <div class="card-body px-4 pb-4 pt-2">
        {{-- Menampilkan Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5 class="alert-heading">Gagal Menyimpan Data!</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Tabel Data Dinamis --}}
        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead class="table-light text-center align-middle">
              <tr>
                <th>No</th>
                <th>Judul & Penulis</th>
                <th>Tgl Terbit</th>
                <th>Jenis Karya</th>
                <th>Publik</th>
                <th>Status</th>
                <th>Dokumen</th>
                <th>Aksi</th>
              </tr>
            </thead>
<tbody id="penelitian-table-body">
  @forelse($penelitian as $item)
  <tr data-row-id="{{ $item->id }}">
    <td class="text-center">{{ $loop->iteration + $penelitian->firstItem() - 1 }}</td>
    <td>
      {{ $item->judul }}
      <small class="text-muted d-block mt-1">
        @php
            $penulisDisplay = $item->penulis->map(fn($p) => $p->pegawai->nama_lengkap ?? $p->nama_penulis);
        @endphp
        <i class="fas fa-users me-1"></i> {{ $penulisDisplay->implode(', ') }}
      </small>
    </td>
    <td class="text-center">{{ $item->tanggal_terbit ? $item->tanggal_terbit->format('d M Y') : '-' }}</td>
    <td class="text-center">{{ $item->jenis_karya }}</td>
    <td class="text-center">{{ $item->is_publik ? 'Ya' : 'Tidak' }}</td>
    
    <td class="text-center status-cell">
      @if ($item->status == 'Sudah Diverifikasi')
        <i class="fas fa-check-circle text-success" title="Sudah Diverifikasi"></i>
      @elseif ($item->status == 'Ditolak')
        <i class="fas fa-times-circle text-danger" title="Ditolak"></i>
      @else
        <i class="fas fa-question-circle text-warning" title="Belum Diverifikasi"></i>
      @endif
    </td>

    <td class="text-center">
      @if($item->dokumen_path)
        <a href="{{ asset('storage/' . $item->dokumen_path) }}" target="_blank" class="btn btn-sm btn-lihat text-white">
            Lihat
        </a>
      @else
        <span>-</span>
      @endif
    </td>

    <td class="text-center">
      <div class="d-flex gap-2 justify-content-center">
          <a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi Data" 
            data-id="{{ $item->id }}" 
            data-judul="{{ $item->judul }}">
            <i class="fa fa-check"></i>
          </a>
          <a href="#" class="btn-aksi btn-lihat" title="Lihat Detail" onclick="event.preventDefault(); openDetailModal({{ $item->id }})">
            <i class="fa fa-eye"></i>
          </a>
          <a href="#" class="btn-aksi btn-edit" title="Edit Data" onclick="event.preventDefault(); openEditModal({{ $item->id }})"><i class="fa fa-edit"></i></a>
          <a href="#" class="btn-aksi btn-hapus" title="Hapus Data" data-id="{{ $item->id }}"><i class="fa fa-trash"></i></a>
      </div>
    </td>
  </tr>
  @empty
  <tr><td colspan="8" class="text-center py-4">Belum ada data penelitian yang ditambahkan.</td></tr>
  @endforelse
</tbody>
          </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-between align-items-center mt-3">
            {{-- Teks informasi jumlah data --}}
            <span class="text-muted small">
                Menampilkan {{ $penelitian->firstItem() }} sampai {{ $penelitian->lastItem() }} dari {{ $penelitian->total() }} data
            </span>
            
            {{-- Link halaman --}}
            <div class="d-flex justify-content-end">
                {{ $penelitian->links() }}
            </div>
        </div>
      </div>
    </div>
  </div>
  
  {{-- Footer --}}
  <footer class="footer-custom">
    <span>© 2025 Forest Management — All Rights Reserved</span>
  </footer>
    
  {{-- Kumpulan Modal --}}
  @include('components.konfirmasi-hapus')
  @include('components.konfirmasi-berhasil')
  @include('components.konfirmasi-verifikasi')
  @include('components.penelitian.detail-penelitian')
  @include('components.penelitian.tambah-penelitian')

    <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  
  {{-- 1. PASTIKAN FILE INI DIMUAT DULUAN --}}
  <script src="{{ asset('assets/js/penelitian.js') }}"></script>
  
  {{-- 2. BARU SKRIP INI DIJALANKAN --}}
  <script>
    const pegawaiData = @json($pegawai->map(fn($p) => ['id' => $p->id, 'nama' => $p->nama_lengkap]));
    window.initPegawaiList(pegawaiData);

    @if (session('success'))
      document.addEventListener('DOMContentLoaded', () => {
        showSuccessModal("Berhasil!", "{{ session('success') }}");
      });
    @endif
  </script>
</body>
</html>