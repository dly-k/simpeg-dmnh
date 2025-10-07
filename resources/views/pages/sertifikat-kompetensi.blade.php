<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="flash-success" content="{{ session('success') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <title>SIKEMAH - Editor Kegiatan (Sertifikat Kompetensi)</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/sertifikat-kompetensi.css') }}" />
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
          <span id="page-title">Editor Kegiatan - Sertifikat Kompetensi</span>
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
                  <input type="text" id="searchInput" class="form-control border-start-0 search-input" 
                    placeholder="Cari berdasarkan judul, nama, dll...">
                </div>

                <!-- Filter Tahun -->
                <select id="tahunFilter" class="form-select tahun-filter">
                  <option value="">Semua Tahun</option>
                  @foreach($tahunOptions as $tahun)
                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                  @endforeach
                </select>

                <!-- Filter Status -->
                <select id="statusFilter" class="form-select status-filter">
                  <option value="">Semua Status</option>
                  <option value="Sudah Diverifikasi">Sudah Diverifikasi</option>
                  <option value="Belum Diverifikasi">Belum Diverifikasi</option>
                  <option value="Ditolak">Ditolak</option>
                </select>
              </div>

              <!-- Right: Button Export & Tambah -->
              <div class="ms-auto d-flex gap-2">
                <a href="{{ route('sertifikat-kompetensi.export', request()->all()) }}" class="btn btn-export fw-bold">
                  <i class="fa fa-file-excel me-2"></i> Export Excel
                </a>
                <button class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#sertifikatKompetensiModal">
                  <i class="fa fa-plus me-2"></i> Tambah Data
                </button>
              </div>
            </div>
            <!-- End Filter Bar -->

            <!-- Tabel Sertifikat Kompetensi -->
            <div class="table-responsive">
              <table class="table table-hover table-bordered align-middle">
                <thead class="table-light text-center">
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Kegiatan</th>
                    <th>Judul Kegiatan</th>
                    <th>Lembaga Sertifikasi</th>
                    <th>Tahun</th>
                    <th>Verifikasi</th>
                    <th>Dokumen</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>

                <tbody id="kompetensiTableBody" class="text-center">
                  <tr id="noDataFoundRow" class="no-data-row d-none">
                    <td colspan="9">Data tidak ditemukan.</td>
                  </tr>

                  @forelse ($sertifikatKompetensis as $item)
                    <tr 
                      data-tahun="{{ $item->tahun_sertifikasi }}" 
                      data-status="{{ $item->verifikasi }}"
                    >
                      <td>{{ $loop->iteration }}</td>
                      <td class="text-start">{{ $item->pegawai->nama_lengkap ?? 'N/A' }}</td>
                      <td>{{ $item->kegiatan }}</td>
                      <td>{{ $item->judul_kegiatan }}</td>
                      <td>{{ $item->lembaga_sertifikasi }}</td>
                      <td>{{ $item->tahun_sertifikasi }}</td>
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
                          <a 
                            href="{{ asset('storage/' . $item->dokumen) }}" 
                            class="btn btn-sm btn-lihat" 
                            target="_blank"
                          >Lihat</a>
                        @else
                          -
                        @endif
                      </td>
                      <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                          @if (Auth::user()->role == 'admin_verifikator')
                            @if ($item->verifikasi != 'Sudah Diverifikasi')
                              <a 
                                href="#" 
                                class="btn-aksi btn-verifikasi" 
                                title="Verifikasi" 
                                data-verifikasi-url="{{ route('sertifikat-kompetensi.verifikasi', $item->id) }}"
                              >
                                <i class="fa fa-check"></i>
                              </a>
                            @endif
                          @endif

                          <button 
                            class="btn btn-sm btn-lihat" 
                            data-bs-toggle="modal" 
                            data-bs-target="#modalDetailSertifikatKompetensi"
                            data-nama="{{ $item->pegawai->nama_lengkap ?? 'N/A' }}"
                            data-kegiatan="{{ $item->kegiatan }}"
                            data-judul="{{ $item->judul_kegiatan }}"
                            data-no-reg="{{ $item->no_reg_pendidik ?? '-' }}"
                            data-no-sk="{{ $item->no_sk_sertifikasi }}"
                            data-tahun="{{ $item->tahun_sertifikasi }}"
                            data-tmt="{{ \Carbon\Carbon::parse($item->tmt_sertifikasi)->format('d F Y') }}"
                            data-tst="{{ $item->tst_sertifikasi ? \Carbon\Carbon::parse($item->tst_sertifikasi)->format('d F Y') : '-' }}"
                            data-bidang="{{ $item->bidang_studi }}"
                            data-lembaga="{{ $item->lembaga_sertifikasi }}"
                            data-dokumen="{{ $item->dokumen ? asset('storage/' . $item->dokumen) : '' }}"
                          >
                            <i class="fas fa-eye"></i>
                          </button>

                          <button 
                            class="btn btn-sm btn-warning btn-edit" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editSertifikatKompetensiModal"
                            data-edit-url="{{ route('sertifikat-kompetensi.edit', $item->id) }}"
                            data-update-url="{{ route('sertifikat-kompetensi.update', $item->id) }}"
                             data-pegawai-id="{{ $item->pegawai->id }}"   
                          >
                            <i class="fa fa-edit"></i>
                          </button>

                          <a 
                            href="#" 
                            class="btn-aksi btn-hapus" 
                            title="Hapus Data" 
                            data-delete-url="{{ route('sertifikat-kompetensi.destroy', $item->id) }}"
                          >
                            <i class="fa fa-trash"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="9" class="text-center text-muted">
                        Data Sertifikat Kompetensi belum tersedia
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            <!-- End Tabel -->

          <!-- Pagination -->
          {{ $sertifikatKompetensis->appends(request()->query())->links('pagination::bootstrap-5') }}
          </div>
        </div>
      </div>

      @include('layouts.footer')
    </div>
  </div>

  <!-- Kumpulan Modal -->
  @include('components.konfirmasi-hapus')
  @include('components.konfirmasi-berhasil')
  @include('components.konfirmasi-verifikasi')
  @include('components.sertifikat-kompetensi.detail-sertifikat-kompetensi')
  @include('components.sertifikat-kompetensi.tambah-sertifikat-kompetensi')
  @include('components.sertifikat-kompetensi.edit-sertifikat-kompetensi')

  <!-- Scripts -->
  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="{{ asset('assets/js/sertifikat-kompetensi.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>