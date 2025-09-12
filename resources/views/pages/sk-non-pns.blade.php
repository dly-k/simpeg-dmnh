<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="flash-success" content="{{ session('success') }}" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <title>SIKEMAH - Editor Kegiatan (SK Non PNS)</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/sk-non-pns.css') }}" />
</head>
<body>
  <div class="layout">
    @include('layouts.sidebar')

    <div class="main-wrapper">
      @include('layouts.header')

      <div class="title-bar">
        <h1>
          <i class="lni lni-pencil-alt"></i>
          <span id="page-title">Editor Kegiatan - SK Non PNS</span>
        </h1>
      </div>

      <div class="main-content">
        
        @if ($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h5 class="alert-heading">Terjadi Kesalahan Validasi!</h5>
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <div class="card">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div class="d-flex align-items-center flex-wrap gap-2 flex-grow-1">
              <form method="GET" id="searchForm" action="{{ route('sk-non-pns.index') }}" class="d-flex align-items-center flex-grow-1 gap-2">
                <div class="input-group search-box bg-white flex-grow-1">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-search search-icon"></i>
                  </span>
                  <input type="text" name="search" id="searchInput" value="{{ request('search') }}" class="form-control border-start-0 search-input" placeholder="Cari Data ...."/>
                </div>

                <select name="tahun" class="form-select filter-select" onchange="this.form.submit()">
                  <option value="">Semua Tahun</option>
                  @foreach($years as $year)
                    <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                      {{ $year }}
                    </option>
                  @endforeach
                </select>
              </form>

              <a href="#" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#skNonPnsModal">
                <i class="fa fa-plus me-2"></i> Tambah Data
              </a>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead class="table-light text-center">
                <tr>
                  <th>No</th>
                  <th>Nama Pegawai</th>
                  <th>Unit</th>
                  <th>Nomor SK</th>
                  <th>Tanggal SK</th>
                  <th>Dokumen</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($skData as $item)
                  <tr>
                    <td class="text-center">
                      {{ $loop->iteration + $skData->firstItem() - 1 }}
                    </td>
                    {{-- =============================================== --}}
                    {{-- == PERUBAHAN 1: Menampilkan Nama dari Relasi == --}}
                    {{-- =============================================== --}}
                    <td>{{ $item->pegawai->nama_lengkap ?? 'Pegawai Tidak Ditemukan' }}</td>
                    <td>{{ $item->nama_unit }}</td>
                    <td>{{ $item->nomor_sk }}</td>
                    <td class="text-center">
                      {{ \Carbon\Carbon::parse($item->tanggal_sk)->format('d M Y') }}
                    </td>
                    <td class="text-center">
                      <a href="{{ Storage::url($item->dokumen_path) }}" target="_blank" class="btn btn-sm btn-lihat text-white">
                        Lihat
                      </a>
                    </td>
                    <td class="text-center">
                      <div class="d-flex gap-2 justify-content-center">
                        <a 
                          href="#" 
                          class="btn-aksi btn-lihat-detail" 
                          title="Detail" 
                          data-bs-toggle="modal" 
                          data-bs-target="#modalDetailSkNonPns"
                          data-nomor_sk="{{ $item->nomor_sk }}"
                          data-tanggal_sk="{{ \Carbon\Carbon::parse($item->tanggal_sk)->format('d M Y') }}"
                          {{-- =============================================== --}}
                          {{-- == PERUBAHAN 2: Mengirim Nama ke Modal Detail == --}}
                          {{-- =============================================== --}}
                          data-pegawai="{{ $item->pegawai->nama_lengkap ?? '' }}"
                          data-unit="{{ $item->nama_unit }}"
                          data-jenis_sk="{{ $item->jenis_sk }}"
                          data-tgl_mulai="{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}"
                          data-tgl_selesai="{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}"
                          data-dokumen_path="{{ Storage::url($item->dokumen_path) }}">
                          <i class="fas fa-eye"></i>
                        </a>

                        <a 
                          href="#" 
                          class="btn-aksi btn-edit" 
                          title="Edit" 
                          data-id="{{ $item->id }}" 
                          data-bs-toggle="modal" 
                          data-bs-target="#skNonPnsModal">
                          <i class="fas fa-edit"></i>
                        </a>

                        <a 
                          href="#" 
                          class="btn-aksi btn-hapus" 
                          title="Hapus" 
                          data-id="{{ $item->id }}" 
                          {{-- =============================================== --}}
                          {{-- == PERUBAHAN 3: Mengirim Nama ke Modal Hapus  == --}}
                          {{-- =============================================== --}}
                          data-nama="{{ $item->pegawai->nama_lengkap ?? '' }}">
                          <i class="fas fa-trash"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="text-center text-muted">
                      Data SK Non PNS belum tersedia
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>

            {{ $skData->appends(request()->all())->links('pagination::bootstrap-5') }}
          </div>
        </div>
      </div>

      @include('layouts.footer')
    </div>

    @include('components.konfirmasi-hapus')
    @include('components.konfirmasi-berhasil')
    @include('components.sk-nonpns.detail-sk-non-pns')
    @include('components.sk-nonpns.tambah-sk-non-pns')
  </div>

  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="{{ asset('assets/js/sk-non-pns.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
</body>
</html>