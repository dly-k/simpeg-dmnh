<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>SIKEMAH - Editor (Penghargaan)</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/penghargaan.css') }}" />
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
          <span id="page-title">Editor - Penghargaan</span>
        </h1>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <div class="card">

          <!-- Search & Filter -->
          <div class="search-filter-container">
            <div class="search-filter-row">
              <form method="GET" id="searchForm" action="{{ route('penghargaan.index') }}"
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
                         placeholder="Cari Data ...." 
                         value="{{ request('search') }}">
                </div>

                <!-- Filter Tahun -->
                <select class="form-select filter-select tahun-filter" 
                        name="tahun" 
                        onchange="this.form.submit()">
                  <option value="">Semua Tahun</option>
                  @foreach ($listTahun as $tahun)
                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                      {{ $tahun }}
                    </option>
                  @endforeach
                </select>

                <!-- Filter Lingkup -->
                <select class="form-select lingkup-select lingkup-filter" 
                        name="lingkup" 
                        onchange="this.form.submit()">
                  <option value="">Semua Lingkup</option>
                  <option value="Nasional" {{ request('lingkup') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                  <option value="Lokal" {{ request('lingkup') == 'Lokal' ? 'selected' : '' }}>Lokal</option>
                  <option value="Internasional" {{ request('lingkup') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                </select>
              </form>

              <!-- Button Tambah -->
              <a href="#" class="btn btn-tambah fw-bold" 
                 data-bs-toggle="modal" 
                 data-bs-target="#penghargaanModal">
                <i class="fa fa-plus me-2"></i> Tambah Data
              </a>
            </div>
          </div>
          <!-- End Search & Filter -->

          <!-- Tabel -->
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
                    <td class="text-center">{{ $loop->iteration + $dataPenghargaan->firstItem() - 1 }}</td>
                    <td class="text-start">{{ $item->pegawai->nama_lengkap ?? 'N/A' }}</td>
                    <td class="text-start">{{ $item->kegiatan }}</td>
                    <td class="text-center">{{ $item->nama_penghargaan }}</td>
                    <td class="text-center">{{ $item->nomor_sk }}</td>
                    <td class="text-center">{{ $item->lingkup }}</td>
                    <td class="text-center">
                      {{ \Carbon\Carbon::parse($item->tanggal_perolehan)->format('Y') }}
                    </td>
                    <td class="text-center">
                      <a href="{{ asset('storage/' . $item->file_path) }}" 
                         target="_blank"
                         class="btn btn-sm btn-lihat text-white">Lihat</a>
                    </td>
                    <td class="text-center">
                      <div class="d-flex gap-2 justify-content-center">
                        <!-- Lihat Detail -->
                        <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-detail-penghargaan"
                           title="Lihat Detail"
                           data-bs-toggle="modal"
                           data-bs-target="#modalDetailPenghargaan"
                           data-pegawai="{{ $item->pegawai->nama_lengkap ?? '' }}"
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

                        <!-- Edit -->
                        <a href="#" class="btn-aksi btn-edit" 
                           title="Edit Data"
                           data-bs-toggle="modal"
                           data-bs-target="#penghargaanModal"
                           data-id="{{ $item->id }}">
                          <i class="fa fa-edit"></i>
                        </a>

                        <!-- Hapus -->
                        <a href="#" class="btn-aksi btn-hapus" 
                           title="Hapus Data"
                           data-id="{{ $item->id }}" 
                           data-nama="{{ $item->pegawai->nama_lengkap ?? '' }}">
                          <i class="fa fa-trash"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="9" class="text-center text-muted">
                      Data penghargaan belum tersedia
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <!-- End Tabel -->

          <!-- Pagination -->
          {{ $dataPenghargaan->appends(request()->query())->links('pagination::bootstrap-5') }}

        </div>
      </div>

      @include('layouts.footer')
    </div>
  </div>

  <!-- Modal & Komponen -->
  @include('components.konfirmasi-hapus')
  @include('components.konfirmasi-berhasil')
  @include('components.penghargaan.detail-penghargaan')
  @include('components.penghargaan.tambah-penghargaan')

  <!-- Scripts -->
  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="{{ asset('assets/js/penghargaan.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
</body>
</html>