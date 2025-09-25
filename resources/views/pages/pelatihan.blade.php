<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>SIKEMAH - Editor (Diklat)</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/diklat.css') }}" />
</head>

<body>
  <div class="layout">
    @include('layouts.sidebar')

    <div class="main-wrapper">
      @include('layouts.header')

      <!-- Title Bar -->
      <div class="title-bar">
        <h1>
          <i class="lni lni-write"></i>
          <span id="page-title">Editor - Diklat</span>
        </h1>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <div class="card">

          <!-- Search & Filter -->
          <div class="search-filter-container">
            <div class="search-filter-row">
              <form method="GET" id="searchForm" action="{{ route('pelatihan.index') }}"
                    class="d-flex align-items-center flex-grow-1 gap-2">

                <!-- Search -->
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-search search-icon"></i>
                  </span>
                  <input type="text" 
                         name="search" 
                         id="searchInput" 
                         class="form-control border-start-0 search-input" 
                         placeholder="Cari nama pegawai, kegiatan..." 
                         value="{{ request('search') }}">
                </div>

                <!-- Filter Tahun -->
                <select class="form-select filter-select" 
                        name="tahun" 
                        onchange="this.form.submit()">
                  <option value="">Semua Tahun</option>
                  @foreach ($tahunList as $tahun)
                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                      {{ $tahun }}
                    </option>
                  @endforeach
                </select>

                <!-- Filter Posisi -->
                <select class="form-select filter-select" 
                        name="posisi" 
                        onchange="this.form.submit()">
                  <option value="">Semua Posisi</option>
                  @foreach ($fixedPosisi as $posisi)
                    <option value="{{ $posisi }}" {{ request('posisi') == $posisi ? 'selected' : '' }}>
                      {{ $posisi }}
                    </option>
                  @endforeach
                  @foreach ($posisiLainnya as $lainnya)
                    <option value="{{ $lainnya }}" {{ request('posisi') == $lainnya ? 'selected' : '' }}>
                      {{ $lainnya }}
                    </option>
                  @endforeach
                </select>
              </form>

              <!-- Button Tambah -->
              <a href="#" class="btn btn-tambah fw-bold" 
                 data-bs-toggle="modal" 
                 data-bs-target="#pelatihanModal">
                <i class="fa fa-plus me-2"></i> Tambah Data
              </a>
            </div>
          </div>
          <!-- End Search & Filter -->

          <!-- Table -->
          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead class="table-light">
                <tr class="text-center">
                  <th>No</th>
                  <th>Nama Pegawai</th>
                  <th>Nama Kegiatan</th>
                  <th>Penyelenggara</th>
                  <th>Posisi</th>
                  <th>Tanggal Mulai</th>
                  <th>Tanggal Selesai</th>
                  <th>Dokumen</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($dataPelatihan as $pelatihan)
                  <tr id="pelatihan-{{ $pelatihan->id }}">
                    <td class="text-center">{{ $dataPelatihan->firstItem() + $loop->index }}</td>
                    <td class="text-start">{{ $pelatihan->pegawai->nama_lengkap ?? 'N/A' }}</td>
                    <td class="text-start">{{ $pelatihan->nama_kegiatan }}</td>
                    <td class="text-center">{{ $pelatihan->penyelenggara }}</td>
                    <td class="text-center">
                      {{ $pelatihan->posisi === 'Lainnya' ? $pelatihan->posisi_lainnya : $pelatihan->posisi }}
                    </td>
                    <td class="text-center">{{ $pelatihan->tgl_mulai->format('d F Y') }}</td>
                    <td class="text-center">{{ $pelatihan->tgl_selesai->format('d F Y') }}</td>
                    <td class="text-center">
                      <a href="{{ asset('storage/' . $pelatihan->file_path) }}" 
                         target="_blank" 
                         class="btn btn-sm btn-lihat text-white">Lihat</a>
                    </td>
                    <td class="text-center">
                      <div class="d-flex gap-2 justify-content-center">
                        <!-- Lihat Detail -->
                        <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-detail-pelatihan" 
                           title="Lihat Detail"
                           data-bs-toggle="modal" 
                           data-bs-target="#modalDetailPelatihan"
                           data-pegawai="{{ $pelatihan->pegawai->nama_lengkap ?? 'N/A' }}"
                           data-nama_kegiatan="{{ $pelatihan->nama_kegiatan }}"
                           data-posisi="{{ $pelatihan->posisi === 'Lainnya' ? $pelatihan->posisi_lainnya : $pelatihan->posisi }}"
                           data-kota="{{ $pelatihan->kota }}"
                           data-lokasi="{{ $pelatihan->lokasi }}"
                           data-penyelenggara="{{ $pelatihan->penyelenggara }}"
                           data-jenis_diklat="{{ $pelatihan->jenis_diklat }}"
                           data-tgl_mulai="{{ $pelatihan->tgl_mulai->format('d F Y') }}"
                           data-tgl_selesai="{{ $pelatihan->tgl_selesai->format('d F Y') }}"
                           data-lingkup="{{ $pelatihan->lingkup }}"
                           data-jam="{{ $pelatihan->jumlah_jam }}"
                           data-hari="{{ $pelatihan->jumlah_hari }}"
                           data-struktural="{{ $pelatihan->struktural ? 'Ya' : 'Tidak' }}"
                           data-sertifikasi="{{ $pelatihan->sertifikasi ? 'Ya' : 'Tidak' }}"
                           data-dokumen_path="{{ asset('storage/' . $pelatihan->file_path) }}">
                          <i class="fa fa-eye"></i>
                        </a>

                        <!-- Edit -->
                        <a href="#" class="btn-aksi btn-edit" 
                           title="Edit Data"
                           data-id="{{ $pelatihan->id }}"
                           data-bs-toggle="modal" 
                           data-bs-target="#pelatihanModal">
                          <i class="fa fa-edit"></i>
                        </a>

                        <!-- Hapus -->
                        <a href="#" class="btn-aksi btn-hapus" 
                           title="Hapus Data"
                           data-id="{{ $pelatihan->id }}" 
                           data-nama="{{ $pelatihan->pegawai->nama_lengkap ?? 'Data' }}">
                          <i class="fa fa-trash"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="9" class="text-center text-muted">
                      Data Diklat belum tersedia
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <!-- End Table -->

          <!-- Pagination -->
          {{ $dataPelatihan->appends(request()->query())->links('pagination::bootstrap-5') }}

        </div>
      </div>

      @include('layouts.footer')
    </div>
  </div>

  <!-- Modal & Komponen -->
  @include('components.konfirmasi-hapus')
  @include('components.konfirmasi-berhasil')
  @include('components.diklat.detail-diklat')
  @include('components.diklat.tambah-diklat', ['pegawais' => $pegawais])

  <!-- Scripts -->
  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="{{ asset('assets/js/diklat.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
</body>
</html>