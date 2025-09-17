<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  {{-- Tambahkan CSRF Token untuk AJAX Request --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <title>SIKEMAH - Editor Kegiatan (Pengabdian)</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/pengabdian.css') }}" />
</head>

<body>
  <div class="sidebar" id="sidebar">
    <div class="brand">SI<span>KEMAH</span></div>
    <div class="menu-wrapper">
      <div class="menu">
        <a href="/dashboard" aria-label="Dashboard"><i class="lni lni-grid-alt"></i> Dashboard</a>

        <p>Menu Utama</p>
        <a href="/daftar-pegawai"><i class="lni lni-users"></i> Daftar Pegawai</a>
        <a href="/surat-tugas"><i class="lni lni-folder"></i> Manajemen Surat Tugas</a>

        <button class="active" data-bs-toggle="collapse" data-bs-target="#editorKegiatan" aria-expanded="true">
          <i class="lni lni-pencil-alt"></i> Editor Kegiatan
          <i class="lni lni-chevron-down toggle-icon"></i>
        </button>

        <div class="collapse show submenu" id="editorKegiatan">
          <a href="/pendidikan">Pendidikan</a>
          <a href="/penelitian">Penelitian</a>
          <a href="/pengabdian" class="active">Pengabdian</a>
          <a href="/penunjang">Penunjang</a>
          <a href="/pelatihan">Pelatihan</a>
          <a href="/penghargaan">Penghargaan</a>
          <a href="/sk-non-pns">SK Non PNS</a>
        </div>

        <a href="/kerjasama"><i class="lni lni-handshake"></i> Kerjasama</a>
        <a href="/master-data"><i class="lni lni-database"></i> Master Data</a>
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
          <li><a class="dropdown-item d-flex align-items-center" href="/ubah-password"><i class="lni lni-key me-2"></i> Ubah Password</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item d-flex align-items-center dropdown-item-danger" href="/logout"><i class="lni lni-exit me-2"></i> Keluar</a></li>
        </ul>
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
              <span class="input-group-text bg-light border-end-0"><i class="fas fa-search search-icon"></i></span>
              <input type="text" class="form-control border-start-0 search-input" placeholder="Cari Data ....">
            </div>
          </div>
          <select class="form-select filter-select"><option selected>Tahun</option><option>2024</option><option>2025</option></select>
          <select class="form-select filter-select"><option selected>Jenis Pengabdian</option></select>
          <select class="form-select filter-select"><option selected>Status</option><option>Sudah Diverifikasi</option><option>Belum Diverifikasi</option><option>Ditolak</option></select>
          <div class="btn-tambah-container">
            {{-- Tombol ini memanggil fungsi JavaScript `openModal()` --}}
            <button class="btn btn-tambah fw-bold" onclick="openModal()">
              <i class="fa fa-plus me-2"></i> Tambah Data
            </button>
          </div>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead class="table-light">
            <tr class="text-center">
              <th>No</th>
              <th>Kegiatan</th>
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
          <tbody id="pengabdian-table-body">
            {{-- Data dimuat dari controller dan ditampilkan di sini --}}
            @forelse ($pengabdians as $item)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-start">{{ $item->kegiatan }}</td>
                <td class="text-center">{{ $item->nama_kegiatan }}</td>
                <td class="text-center">{{ $item->afiliasi_non_pt ?? '-' }}</td>
                <td class="text-center">{{ $item->lokasi ?? '-' }}</td>
                <td class="text-center">{{ $item->no_sk_penugasan ?? '-' }}</td>
                <td class="text-center">{{ $item->tahun_pelaksanaan ?? '-' }}</td>
                <td class="text-center">
                  @if ($item->status == 'Sudah Diverifikasi')
                    <i class="fas fa-check-circle text-success" title="Sudah Diverifikasi"></i>
                  @elseif ($item->status == 'Ditolak')
                    <i class="fas fa-times-circle text-danger" title="Ditolak"></i>
                  @else
                    <i class="fas fa-question-circle text-warning" title="Belum Diverifikasi"></i>
                  @endif
                </td>
                <td class="text-center">
                    {{-- Cek apakah ada dokumen terkait --}}
                    @if($item->dokumen->isNotEmpty())
                        {{-- Ambil dokumen pertama dan buat link menggunakan Storage::url() --}}
                        <a href="{{ Storage::url($item->dokumen->first()->file_path) }}" target="_blank" class="btn btn-sm btn-lihat text-white">
                            Lihat
                        </a>
                    @else
                        {{-- Tampilkan strip jika tidak ada dokumen --}}
                        <span>-</span>
                    @endif
                </td>
                {{-- DIPERBARUI --}}
                <td class="text-center">
                  <div class="d-flex gap-2 justify-content-center">
                    <a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi" data-id="{{ $item->id }}"><i class="fa fa-check"></i></a>
                    <a href="#" class="btn-aksi btn-lihat" title="Lihat Detail" data-id="{{ $item->id }}" data-bs-toggle="modal" data-bs-target="#pengabdianDetailModal"><i class="fa fa-eye"></i></a>
                    <a href="#" class="btn-aksi btn-edit" title="Edit Data" data-id="{{ $item->id }}"><i class="fa fa-edit"></i></a>
                    <a href="#" class="btn-aksi btn-hapus" title="Hapus Data" data-id="{{ $item->id }}"><i class="fa fa-trash"></i></a>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="10" class="text-center">Tidak ada data untuk ditampilkan.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <span class="text-muted small">Menampilkan 1 sampai {{ $pengabdians->count() }} dari {{ $pengabdians->count() }} data</span>
        {{-- Jika menggunakan pagination: {{ $pengabdians->links() }} --}}
      </div>
    </div>
  </div>

  <footer class="footer-custom">
    <span>© 2025 Forest Management — All Rights Reserved</span>
  </footer>

  @include('components.konfirmasi-hapus')
  @include('components.konfirmasi-berhasil')
  @include('components.konfirmasi-verifikasi')
  @include('components.pengabdian.detail-pengabdian')
  @include('components.pengabdian.tambah-pengabdian')

  <script>
    // PENTING: Mengirim data pegawai dari PHP (Controller) ke JavaScript
    const pegawaiData = @json($pegawais);
  </script>
  
  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="{{ asset('assets/js/pengabdian.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>