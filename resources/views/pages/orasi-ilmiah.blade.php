<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="flash-success" content="{{ session('success') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SIKEMAH - Editor Kegiatan (Orasi Ilmiah)</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/orasi-ilmiah.css') }}" />
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
          <span id="page-title">Editor Kegiatan - Orasi Ilmiah</span>
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
                          id="searchInput" {{-- Tambahkan ID --}}
                          class="form-control border-start-0 search-input" 
                          placeholder="Cari berdasarkan judul, nama, penyelenggara..."
                      >
                  </div>

                  <select id="semesterFilter" class="form-select" style="max-width: 220px;"> {{-- Tambahkan ID --}}
                      <option value="">Semua Semester</option>
                      {{-- Loop untuk opsi semester dinamis --}}
                      @foreach($semesterOptions as $option)
                          <option value="{{ $option['value'] }}">{{ $option['text'] }}</option>
                      @endforeach
                  </select>

                  <select id="statusFilter" class="form-select" style="max-width: 180px;"> {{-- Tambahkan ID --}}
                      <option value="">Semua Status</option>
                      <option value="Sudah Diverifikasi">Sudah Diverifikasi</option>
                      <option value="Belum Diverifikasi">Belum Diverifikasi</option>
                      <option value="Ditolak">Ditolak</option>
                  </select>
              </div>

              <!-- Right: Button Tambah Data -->
              <div class="ms-auto">
                <button class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#orasiIlmiahModal">
                  <i class="fa fa-plus me-2"></i> Tambah Data
                </button>
              </div>
            </div>
            <!-- End Filter Bar -->

            <!-- Tabel Orasi Ilmiah -->
            <div class="table-responsive">
              <table class="table table-hover table-bordered align-middle">
                <thead class="table-light text-center">
                  <tr>
                    <th>No</th>
                    <th>Pegawai</th>
                    <th>Kategori Pembicara</th>
                    <th>Judul Makalah</th>
                    <th>Nama Pertemuan</th>
                    <th>Tingkat Pertemuan</th>
                    <th>Penyelenggara</th>
                    <th>Tanggal Pelaksanaan</th>
                    <th>Bahasa</th>
                    <th>Verifikasi</th>
                    <th>Dokumen</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                {{-- Ganti seluruh isi <tbody> dengan kode ini --}}
                <tbody id="orasiIlmiahTableBody" class="text-center">
                      <tr id="noDataFoundRow" style="display: none;">
                          <td colspan="12">Data tidak ditemukan.</td>
                      </tr>
                    @forelse ($orasiIlmiahs as $item)
                    <tr data-tanggal="{{ $item->tanggal_pelaksana }}" data-status="{{ $item->verifikasi }}">
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-start">{{ $item->pegawai->nama_lengkap ?? 'N/A' }}</td>
                        <td>{{ $item->kategori_pembicara }}</td>
                        <td>{{ $item->judul_makalah }}</td>
                        <td>{{ $item->nama_pertemuan }}</td>
                        <td>{{ $item->lingkup }}</td>
                        <td>{{ $item->penyelenggara }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pelaksana)->format('d-m-Y') }}</td>
                        <td>{{ $item->bahasa ?? '-' }}</td>
                        <td>
                            @if ($item->verifikasi == 'Sudah Diverifikasi')
                                <span class="badge rounded-circle bg-success text-white" title="Sudah Diverifikasi">
                                    <i class="fa fa-check"></i>
                                </span>
                            @elseif ($item->verifikasi == 'Ditolak')
                                <span class="badge rounded-circle bg-danger text-white" title="Ditolak">
                                    <i class="fa fa-times"></i>
                                </span>
                            @else
                                <span class="badge rounded-circle bg-warning text-white" title="Belum Diverifikasi">
                                    <i class="fa fa-question"></i>
                                </span>
                            @endif
                        </td>
                        <td>
                            @if ($item->dokumen)
                            <a href="{{ asset('storage/' . $item->dokumen) }}" class="btn btn-sm btn-lihat" target="_blank">Lihat</a>
                            @else
                            -
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                              @if ($item->verifikasi != 'Sudah Diverifikasi')
                                  <a href="#" 
                                    class="btn-aksi btn-verifikasi" 
                                    title="Verifikasi"
                                    data-verifikasi-url="{{ route('orasi-ilmiah.verifikasi', $item->id) }}">
                                      <i class="fa fa-check"></i>
                                  </a>
                              @endif
                            <button class="btn btn-sm btn-lihat" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalDetailOrasiIlmiah"
                                    data-pegawai="{{ $item->pegawai->nama_lengkap ?? 'N/A' }}"
                                    data-litabmas="{{ $item->litabmas ?? '-' }}"
                                    data-kategori="{{ $item->kategori_pembicara ?? '-' }}"
                                    data-lingkup="{{ $item->lingkup ?? '-' }}"
                                    data-judul="{{ $item->judul_makalah ?? '-' }}"
                                    data-pertemuan="{{ $item->nama_pertemuan ?? '-' }}"
                                    data-penyelenggara="{{ $item->penyelenggara ?? '-' }}"
                                    data-tanggal="{{ \Carbon\Carbon::parse($item->tanggal_pelaksana)->format('d F Y') }}"
                                    data-bahasa="{{ $item->bahasa ?? '-' }}"
                                    data-jenis-dokumen="{{ $item->jenis_dokumen ?? '-' }}"
                                    data-nama-dokumen="{{ $item->nama_dokumen ?? '-' }}"
                                    data-nomor-dokumen="{{ $item->nomor_dokumen ?? '-' }}"
                                    data-tautan="{{ $item->tautan_dokumen ?? '-' }}"
                                    data-dokumen-src="{{ $item->dokumen ? asset('storage/' . $item->dokumen) : '' }}">
                                <i class="fas fa-eye"></i>
                            </button>
                                <button 
                                    class="btn btn-sm btn-warning btn-edit" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editOrasiIlmiahModal"
                                    data-edit-url="{{ route('orasi-ilmiah.edit', $item->id) }}" {{-- Tambahkan ini --}}
                                    data-update-url="{{ route('orasi-ilmiah.update', $item->id) }}" {{-- Tambahkan ini --}}
                                >
                                    <i class="fa fa-edit"></i>
                                </button>
                                <a href="#" 
                                  class="btn-aksi btn-hapus" 
                                  title="Hapus Data"
                                  data-delete-url="{{ route('orasi-ilmiah.destroy', $item->id) }}">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" class="text-center">Data Orasi Ilmiah belum ada.</td>
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
  @include('components.konfirmasi-hapus')
  @include('components.konfirmasi-berhasil')
  @include('components.konfirmasi-verifikasi')
  @include('components.orasi-ilmiah.detail-orasi-ilmiah')
  @include('components.orasi-ilmiah.tambah-orasi-ilmiah')
  @include('components.orasi-ilmiah.edit-orasi-ilmiah')

  <!-- Scripts -->
  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="{{ asset('assets/js/orasi-ilmiah.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>