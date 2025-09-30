<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="flash-success" content="{{ session('success') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SIKEMAH - Editor Kegiatan (Pembicara)</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/pembicara.css') }}" />
</head>

<body>
  <div class="layout">
    @include('layouts.sidebar')

    <div class="main-wrapper">
      @include('layouts.header')

      <!-- Title Bar -->
      <div class="title-bar">
        <h1>
          <i class="lni lni-pencil-alt"></i>
          <span id="page-title">Editor Kegiatan - Pembicara</span>
        </h1>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <div class="card">
          <div class="card-body p-4">

            <!-- Filter Bar -->
            <div class="d-flex flex-wrap align-items-center mb-3 gap-2">
              <div class="d-flex flex-grow-1 gap-2">
                <!-- Search -->
                <div class="input-group flex-grow-1">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-search text-success"></i>
                  </span>
                  <input 
                    type="text" 
                    class="form-control border-start-0 search-input" 
                    placeholder="Cari Pembicara ...."
                  >
                </div>

                <!-- Tahun -->
                <select class="form-select" style="max-width: 160px;">
                  <option value="">Semua Tahun</option>
                  <option>2023</option>
                  <option>2024</option>
                  <option>2025</option>
                </select>

                <!-- Kategori Capaian -->
                <select class="form-select" style="max-width: 200px;">
                  <option value="">Semua Capaian</option>
                  <option>Nasional</option>
                  <option>Internasional</option>
                </select>

                <!-- Status -->
                <select class="form-select" style="max-width: 180px;">
                  <option value="">Semua Status</option>
                  <option>Sudah Diverifikasi</option>
                  <option>Belum Diverifikasi</option>
                  <option>Ditolak</option>
                </select>
              </div>

              <!-- Right: Button Tambah Data -->
              <div class="ms-auto">
                <button class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#pembicaraModal">
                  <i class="fa fa-plus me-2"></i> Tambah Data
                </button>
              </div>
            </div>
            <!-- End Filter Bar -->

            <!-- Tabel Pembicara -->
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead class="table-light">
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Kegiatan</th>
                    <th>Kategori Capaian</th>
                    <th>Kategori Pembicara</th>
                    <th>Judul Makalah</th>
                    <th>Nama Pertemuan</th>
                    <th>Tanggal Pelaksanaan</th>
                    <th>Verifikasi</th>
                    <th>Dokumen</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($pembicaras as $pembicara)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $pembicara->pegawai->nama_lengkap ?? 'N/A' }}</td>
                    <td>{{ $pembicara->kegiatan === 'lainnya' ? $pembicara->kegiatan_lainnya : Str::limit(ucfirst(str_replace('_', ' ', $pembicara->kegiatan)), 30) }}</td>
                    <td>{{ $pembicara->kategori_capaian ? Str::limit(ucfirst($pembicara->kategori_capaian), 20) : '-' }}</td>
                    <td>{{ Str::limit(ucfirst($pembicara->kategori_pembicara), 20) }}</td>
                    <td>{{ Str::limit($pembicara->judul_makalah, 35) }}</td>
                    <td>{{ Str::limit($pembicara->nama_pertemuan, 35) }}</td>
                    <td>{{ \Carbon\Carbon::parse($pembicara->tanggal_pelaksana)->translatedFormat('d M Y') }}</td>
                    <td>
                      @if($pembicara->status_verifikasi == 'belum_diverifikasi')
                        <span class="badge rounded-circle bg-warning text-white" title="Belum Diverifikasi"><i class="fa fa-question"></i></span>
                      @elseif($pembicara->status_verifikasi == 'sudah_diverifikasi')
                        <span class="badge rounded-circle bg-success text-white" title="Sudah Diverifikasi"><i class="fa fa-check"></i></span>
                      @else
                        <span class="badge rounded-circle bg-danger text-white" title="Ditolak"><i class="fa fa-times"></i></span>
                      @endif
                    </td>
                    <td>
                      @if($pembicara->dokumen->isNotEmpty() && $pembicara->dokumen->first()->file_path)
                        <a href="{{ asset($pembicara->dokumen->first()->file_path) }}" class="btn btn-sm btn-lihat" target="_blank">Lihat</a>
                      @else
                        <span class="text-muted fst-italic">N/A</span>
                      @endif
                    </td>
                    <td>
                      <div class="d-flex gap-2">
                        <a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi"><i class="fa fa-check"></i></a>
                        <button 
                            class="btn btn-sm btn-lihat btn-detail-pembicara" 
                            data-bs-toggle="modal" 
                            data-bs-target="#detailPembicaraModal" 
                            data-id="{{ $pembicara->id }}">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-warning btn-edit" data-bs-toggle="modal" data-id="{{ $pembicara->id }}" data-bs-target="#editPembicaraModal"><i class="fa fa-edit"></i></button>
                        <a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a>
                      </div>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="11" class="text-center py-4">
                      <p class="mb-0">Belum ada data pembicara.</p>
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            <!-- End Tabel -->

          </div>
        </div>
      </div>

      @include('layouts.footer')
    </div>
  </div>

  <!-- Modal  -->
  {{-- @include('components.konfirmasi-hapus') --}}
  @include('components.konfirmasi-berhasil')
  {{-- @include('components.konfirmasi-verifikasi') --}}
 @include('components.pembicara.detail-pembicara')
  @include('components.pembicara.tambah-pembicara', ['pegawais' => $pegawais])
  @include('components.pembicara.edit-pembicara', ['pegawais' => $pegawais])

  <!-- Scripts -->
  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="{{ asset('assets/js/pembicara.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>