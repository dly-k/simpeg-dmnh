<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  {{-- Token CSRF untuk keamanan request AJAX --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>SIKEMAH - Editor Kegiatan (Penghargaan)</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/penghargaan.css') }}" />
</head>

<body>
  <div class="sidebar" id="sidebar">
    <div class="brand">SI<span>KEMAH</span></div>
    <div class="menu-wrapper">
      <div class="menu">
        <a href="/dashboard" aria-label="Dashboard">
          <i class="lni lni-grid-alt"></i> Dashboard
        </a>
        <p>Menu Utama</p>
        <a href="/daftar-pegawai" aria-label="Daftar Pegawai">
          <i class="lni lni-users"></i> Daftar Pegawai
        </a>
        <a href="/surat-tugas" aria-label="Manajemen Surat Tugas"><i class="lni lni-folder"></i> Manajemen Surat Tugas</a>
        <button class="active" data-bs-toggle="collapse" data-bs-target="#editorKegiatan"
          aria-expanded="true" aria-controls="editorKegiatan">
          <i class="lni lni-pencil-alt"></i> Editor Kegiatan
          <i class="lni lni-chevron-down toggle-icon"></i>
        </button>
        <div class="collapse show submenu" id="editorKegiatan">
          <a href="/pendidikan" aria-label="Pendidikan">Pendidikan</a>
          <a href="/penelitian" aria-label="Penelitian">Penelitian</a>
          <a href="/pengabdian" aria-label="Pengabdian">Pengabdian</a>
          <a href="/penunjang" aria-label="Penunjang">Penunjang</a>
          <a href="/pelatihan" aria-label="Pelatihan">Pelatihan</a>
          <a href="/penghargaan" aria-label="Penghargaan" class="active">Penghargaan</a>
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
    <h1>
      <i class="lni lni-pencil-alt"></i>
      <span id="page-title">Editor Kegiatan - Penghargaan</span>
    </h1>
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
              <input type="text" class="form-control border-start-0 search-input" placeholder="Cari Data ....">
            </div>
          </div>
          <select class="form-select filter-select">
            <option selected>Tahun</option>
            <option>2025</option>
            <option>2024</option>
          </select>
          <select class="form-select lingkup-select">
            <option selected>Lingkup</option>
            <option>Internasional</option>
            <option>Nasional</option>
            <option>Lokal</option>
          </select>
          <a href="#" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#penghargaanModal">
            <i class="fa fa-plus me-2"></i> Tambah Data
          </a>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead class="table-light">
            <tr class="text-center">
              <th>No</th>
              <th>Pegawai</th>
              <th>Kegiatan</th>
              <th>Penghargaan</th>
              <th>Nomor SK</th>
              <th>Lingkup</th>
              <th>Tahun</th>
              <th>Dokumen</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="penghargaan-table-body">
            @forelse ($dataPenghargaan as $item)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-start">{{ $item->nama_pegawai }}</td>
                <td class="text-start">{{ $item->kegiatan }}</td>
                <td class="text-center">{{ $item->nama_penghargaan }}</td>
                <td class="text-center">{{ $item->nomor_sk }}</td>
                <td class="text-center">{{ $item->lingkup }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_perolehan)->format('Y') }}</td>
                <td class="text-center">
                  <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-sm btn-lihat text-white">Lihat</a>
                </td>
                <td class="text-center">
                  <div class="d-flex gap-2 justify-content-center">
                    <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-detail-penghargaan"
                       title="Lihat Detail"
                       data-bs-toggle="modal"
                       data-bs-target="#modalDetailPenghargaan"
                       data-pegawai="{{ $item->nama_pegawai }}"
                       data-kegiatan="{{ $item->kegiatan }}"
                       data-nama_penghargaan="{{ $item->nama_penghargaan }}"
                       data-nomor="{{ $item->nomor_sk }}"
                       data-tanggal_perolehan="{{ \Carbon\Carbon::parse($item->tanggal_perolehan)->isoFormat('D MMMM YYYY') }}"
                       data-lingkup="{{ $item->lingkup }}"
                       data-negara="{{ $item->negara }}"
                       data-instansi="{{ $item->instansi_pemberi }}"
                       data-jenis_dokumen="{{ $item->jenis_dokumen }}"
                       data-nama_dokumen="{{ $item->nama_dokumen }}"
                       data-nomor_dokumen="{{ $item->nomor_dokumen ?? '-' }}"
                       data-tautan="{{ $item->tautan ?? '#' }}"
                       data-dokumen_path="{{ asset('storage/' . $item->file_path) }}">
                      <i class="fa fa-eye"></i>
                    </a>

                    <a href="#" class="btn-aksi btn-edit" title="Edit Data"
                      data-bs-toggle="modal" data-bs-target="#penghargaanModal"
                      data-id="{{ $item->id }}">
                      <i class="fa fa-edit"></i>
                    </a>

                    <a href="#" class="btn-aksi btn-hapus" title="Hapus Data" data-id="{{ $item->id }}">
                      <i class="fa fa-trash"></i>
                    </a>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="text-center">Belum ada data penghargaan.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

          {{-- Ganti bagian ini dengan data paginasi dari controller --}}
          <div class="d-flex justify-content-between align-items-center mt-4">
              <span class="text-muted small">
                Menampilkan {{ $dataPenghargaan->firstItem() }} sampai {{ $dataPenghargaan->lastItem() }} dari {{ $dataPenghargaan->total() }} data
              </span>
              <nav aria-label="Page navigation">
                {{-- Tampilkan link paginasi --}}
                {{ $dataPenghargaan->links() }}
              </nav>
          </div>
    </div>
  </div>

  <footer class="footer-custom">
    <span>© 2025 Forest Management — All Rights Reserved</span>
  </footer>

  {{-- Ganti path 'components.nama-file' sesuai struktur folder Anda --}}
  @include('components.konfirmasi-hapus')
  @include('components.konfirmasi-berhasil')
  @include('components.penghargaan.detail-penghargaan')
  @include('components.penghargaan.tambah-penghargaan')

  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="{{ asset('assets/js/penghargaan.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>