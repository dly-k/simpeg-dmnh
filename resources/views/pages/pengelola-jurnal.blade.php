<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="flash-success" content="{{ session('success') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SIKEMAH - Editor Kegiatan (Pengelola Jurnal)</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/pengelola-jurnal.css') }}" />
</head>

<body>
  <div class="layout">
    @include('layouts.sidebar')

    <div class="main-wrapper">
      @include('layouts.header')

      <!-- Title Bar -->
      <div class="title-bar">
        <h1>
          <i class="lni lni-book"></i>
          <span id="page-title">Editor Kegiatan - Pengelola Jurnal</span>
        </h1>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <div class="card">
          <div class="card-body p-4">

            <!-- Filter Bar -->
<form action="{{ route('pengelola-jurnal.index') }}" method="GET" id="filterForm">
  <div class="d-flex flex-wrap align-items-center mb-3 gap-2">
    <div class="d-flex flex-grow-1 gap-2">

      <div class="input-group flex-grow-1">
        <span class="input-group-text bg-light border-end-0">
          <i class="fas fa-search text-success"></i>
        </span>
        <input 
          type="text" 
          class="form-control border-start-0 search-input" 
          name="search"
          placeholder="Cari berdasarkan kegiatan, media, atau nama pegawai..."
          value="{{ request('search') }}"
        >
      </div>

      <select name="semester" class="form-select" style="max-width: 200px;">
        <option value="">Semua Semester</option>
        @foreach ($semesterOptions as $value => $text)
          <option value="{{ $value }}" {{ request('semester') == $value ? 'selected' : '' }}>
            {{ $text }}
          </option>
        @endforeach
      </select>

      <select name="status" class="form-select" style="max-width: 180px;">
        <option value="">Semua Status</option>
        <option value="Belum Diverifikasi" {{ request('status') == 'Belum Diverifikasi' ? 'selected' : '' }}>Belum Diverifikasi</option>
        <option value="Sudah Diverifikasi" {{ request('status') == 'Sudah Diverifikasi' ? 'selected' : '' }}>Sudah Diverifikasi</option>
        <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
      </select>
      
      {{-- Tombol Filter dan Reset dihapus dari sini --}}

    </div>

    <div class="ms-auto">
      <button type="button" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#pengelolaJurnalModal">
        <i class="fa fa-plus me-2"></i> Tambah Data
      </button>
    </div>
  </div>
</form>
            <!-- End Filter Bar -->

            <!-- Tabel Pengelola Jurnal -->
<div class="table-responsive">
  <table class="table table-hover table-bordered align-middle">
    <thead class="table-light text-center">
      <tr>
        <th>No</th>
        <th>Kegiatan</th>
        <th>Media Publikasi</th>
        <th>Peran</th>
        <th>Pegawai</th>
        <th>Tahun</th>
        <th>Verifikasi</th>
        <th>Dokumen</th>
        <th class="text-center">Aksi</th>
      </tr>
    </thead>
    <tbody class="text-center">
      {{-- Gunakan @forelse untuk looping data, sekaligus handle jika data kosong --}}
      @forelse ($pengelolaJurnals as $jurnal)
        <tr>
          {{-- Menampilkan nomor urut yang benar sesuai halaman pagination --}}
          <td>{{ ($pengelolaJurnals->currentPage() - 1) * $pengelolaJurnals->perPage() + $loop->iteration }}</td>
          <td>{{ $jurnal->kegiatan }}</td>
          <td>{{ $jurnal->media_publikasi }}</td>
          <td>{{ $jurnal->peran }}</td>
          {{-- Ambil nama dari relasi 'pegawai' --}}
          <td class="text-start">{{ $jurnal->pegawai->nama_lengkap ?? 'N/A' }}</td>
          {{-- Ambil tahun dari tanggal mulai --}}
          <td>{{ \Carbon\Carbon::parse($jurnal->tanggal_mulai)->format('Y') }}</td>
          <td>
            @if ($jurnal->status_verifikasi == 'Sudah Diverifikasi')
              <span class="badge rounded-circle bg-success text-white" title="Sudah Diverifikasi">
                <i class="fa fa-check"></i>
              </span>
            @elseif ($jurnal->status_verifikasi == 'Ditolak')
              <span class="badge rounded-circle bg-danger text-white" title="Ditolak">
                <i class="fa fa-times"></i>
              </span>
            @else {{-- Status 'Belum Diverifikasi' --}}
              <span class="badge rounded-circle bg-warning text-white" title="Belum Diverifikasi">
                <i class="fa fa-question"></i>
              </span>
            @endif
          </td>
          <td>
          {{-- Cek apakah ada dokumen yang terhubung dengan jurnal ini --}}
          @if ($jurnal->dokumen->isNotEmpty())
              
              {{-- Ambil dokumen pertama dari koleksi/list dokumen --}}
              @php
                  $firstDocument = $jurnal->dokumen->first();
              @endphp

              {{-- Pastikan dokumen pertama tersebut memiliki file yang diunggah (bukan hanya link) --}}
              @if ($firstDocument->path_file)
                  <a href="{{ Storage::url($firstDocument->path_file) }}" class="btn btn-sm btn-lihat" target="_blank">
                      Lihat
                  </a>
              @else
                  {{-- Jika dokumen pertama hanya punya link eksternal, bisa diarahkan ke sana --}}
                  <a href="{{ $firstDocument->tautan_dokumen ?? '#' }}" class="btn btn-sm btn-lihat" target="_blank">
                      Lihat
                  </a>
              @endif

          @else
              {{-- Jika tidak ada dokumen sama sekali, tampilkan tombol non-aktif --}}
              <button class="btn btn-sm btn-secondary" disabled>Kosong</button>
          @endif
          </td>
          <td class="text-center">
            <div class="d-flex justify-content-center gap-2">
              <button class="btn-aksi btn-verifikasi" title="Verifikasi Data"
                {{-- Gunakan satu data-url saja --}}
                data-url="{{ route('pengelola-jurnal.verifikasi', $jurnal->id) }}">
                <i class="fa fa-check"></i>
              </button>
              <button 
                  class="btn btn-sm btn-lihat text-white btn-detail"
                  data-bs-toggle="modal" 
                  data-bs-target="#detailPengelolaJurnalModal"
                  data-nama="{{ $jurnal->pegawai->nama_lengkap ?? 'N/A' }}"
                  data-kegiatan="{{ $jurnal->kegiatan }}"
                  data-media="{{ $jurnal->media_publikasi }}"
                  data-peran="{{ $jurnal->peran }}"
                  data-no-sk="{{ $jurnal->no_sk }}"
                  data-tgl-mulai="{{ $jurnal->tanggal_mulai }}"
                  data-tgl-selesai="{{ $jurnal->tanggal_selesai }}"
                  data-status="{{ $jurnal->status }}"
                  {{-- [TAMBAHAN] Atribut ini berisi semua data dokumen dalam format JSON --}}
                  data-dokumen='@json($jurnal->dokumen)'>
                  <i class="fas fa-eye"></i>
                </button>
                              <button 
                class="btn btn-sm btn-warning btn-edit" 
                data-bs-toggle="modal" 
                data-bs-target="#editPengelolaJurnalModal"
                data-id="{{ $jurnal->id }}"
                data-update-url="{{ route('pengelola-jurnal.update', $jurnal->id) }}">
                <i class="fa fa-edit"></i>
              </button>
              <button class="btn-aksi btn-hapus btn-hapus-data" title="Hapus Data"
                data-url="{{ route('pengelola-jurnal.destroy', $jurnal->id) }}"
                data-nama="{{ $jurnal->media_publikasi }}">
                <i class="fa fa-trash"></i>
              </button>
            </div>
          </td>
        </tr>
      @empty
        {{-- Tampilan jika tidak ada data sama sekali di database --}}
        <tr>
          <td colspan="9" class="text-center">Data Pengelola Jurnal tidak ditemukan.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
<div class="d-flex justify-content-end mt-3">
    {{ $pengelolaJurnals->links() }}
</div>
            <!-- End Tabel -->

          </div>
        </div>
      </div>

      @include('layouts.footer')
    </div>
  </div>

  <!-- Modal  -->
  @include('components.konfirmasi-hapus')
  @include('components.konfirmasi-berhasil')
  @include('components.konfirmasi-verifikasi')
  @include('components.pengelola-jurnal.detail-pengelola-jurnal')
  @include('components.pengelola-jurnal.tambah-pengelola-jurnal', ['pegawais' => $pegawais])
  @include('components.pengelola-jurnal.edit-pengelola-jurnal', ['pegawais' => $pegawais])

  <!-- Scripts -->
  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="{{ asset('assets/js/pengelola-jurnal.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>