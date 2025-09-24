<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SIKEMAH - Editor Kegiatan (Penunjang)</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/penunjang.css') }}" />
</head>

<body>
<div class="layout">
    @include('layouts.sidebar')

    <div class="main-wrapper">
      @include('layouts.header')

      <div class="title-bar">
        <h1>
          <i class="lni lni-pencil-alt"></i>
          <span id="page-title">Editor Kegiatan - Penunjang</span>
        </h1>
      </div>

  <div class="main-content">
    <div class="card">
      <div class="search-filter-container">
        <div class="search-filter-row">
          <div class="search-box">
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-success"></i></span>
              <input type="text" class="form-control border-start-0 search-input" placeholder="Cari Data ....">
            </div>
          </div>

          {{-- Dropdown Semester Dinamis --}}
          <select class="form-select filter-select" id="filter-semester">
            <option value="">Semua Semester</option>
            @foreach ($semesterOptions as $option)
                <option value="{{ $option }}">{{ $option }}</option>
            @endforeach
          </select>

          {{-- Dropdown Lingkup --}}
          <select class="form-select filter-select" id="filter-lingkup">
            <option value="">Semua Lingkup</option>
            <option>Lokal</option>
            <option>Nasional</option>
            <option>Internasional</option>
          </select>

          {{-- Dropdown Status --}}
          <select class="form-select filter-select" id="filter-status">
            <option value="">Semua Status</option>
            <option>Sudah Diverifikasi</option>
            <option>Belum Diverifikasi</option>
            <option>Ditolak</option>
          </select>

          <div class="btn-tambah-container">
            <button class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#penunjangModal">
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
              <th>Lingkup</th>
              <th>Nama Kegiatan</th>
              <th>Instansi</th>
              <th>Nomor SK</th>
              <th>TMT</th>
              <th>TST</th>
              <th>Verifikasi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="penunjang-table-body">
            {{-- Data dimuat dari controller dan ditampilkan di sini --}}
            @forelse ($penunjangs as $item)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-start">{{ $item->kegiatan }}</td>
                <td class="text-center">{{ $item->lingkup }}</td>
                <td class="text-center">{{ $item->nama_kegiatan }}</td>
                <td class="text-center">{{ $item->instansi }}</td>
                <td class="text-center">{{ $item->nomor_sk }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($item->tmt_mulai)->format('d M Y') }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($item->tmt_selesai)->format('d M Y') }}</td>
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
                  <div class="d-flex gap-2 justify-content-center">
                    <a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi" data-id="{{ $item->id }}">
                        <i class="fa fa-check"></i>
                    </a>
                    <a href="#" class="btn-aksi btn-lihat" title="Lihat Detail" 
                      data-id="{{ $item->id }}" 
                      data-bs-toggle="modal" 
                      data-bs-target="#penunjangDetailModal">
                      <i class="fa fa-eye"></i>
                    </a>
                    <a href="#" class="btn-aksi btn-edit" title="Edit Data" data-id="{{ $item->id }}">
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
                <td colspan="10" class="text-center">Tidak ada data untuk ditampilkan.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-between align-items-center mt-4">
          <span class="text-muted small pagination-info">
              @if ($penunjangs->count() > 0)
                  Menampilkan 1 sampai {{ $penunjangs->count() }} dari {{ $penunjangs->count() }} data
              @else
                  Menampilkan 0 dari 0 data
              @endif
          </span>
          {{-- Pagination links can be added here if using pagination --}}
      </div>
    </div>
  </div>

    @include('layouts.footer')
</div>

  {{-- Pastikan file-file ini ada di dalam folder `resources/views/components` --}}
  @include('components.konfirmasi-hapus')
  @include('components.konfirmasi-berhasil')
  @include('components.konfirmasi-verifikasi')
  @include('components.penunjang.tambah-penunjang')
  @include('components.penunjang.detail-penunjang')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  {{-- Script ini penting untuk memberikan data pegawai ke JavaScript --}}
  <script>
    const pegawaiData = @json($pegawais);
  </script>
  
  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="{{ asset('assets/js/penunjang.js') }}"></script>
</body>
</html>