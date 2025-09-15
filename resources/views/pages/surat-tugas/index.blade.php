<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="flash-success" content="{{ session('success') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <title>SIKEMAH - Manajemen Surat Tugas</title>

  {{-- Stylesheets --}}
  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/surat-tugas.css') }}" />
</head>
<body>
  <div class="layout">
    @include('layouts.sidebar')

    <div class="main-wrapper">

      @include('layouts.header')

      <div class="title-bar">
        <h1>
          <i class="lni lni-folder"></i>
          <span id="page-title">Manajemen Surat Tugas</span>
        </h1>
      </div>

      <div class="main-content">
        <div class="table-card">

          <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div class="d-flex align-items-center flex-wrap gap-2 flex-grow-1">
                <form action="{{ route('surat-tugas.index') }}" method="GET" id="searchForm" class="d-flex align-items-center flex-grow-1 gap-2">
                    <div class="input-group search-box bg-white flex-grow-1">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search search-icon"></i>
                        </span>
                        <input type="text" name="q" value="{{ request('q') }}" id="searchInput" class="form-control border-start-0 search-input" placeholder="Cari nama dosen ...." />
                    </div>

                    <select name="semester" class="form-select filter-select" style="width:200px" onchange="this.form.submit()">
                        <option value="">Semua Semester</option>
                        @foreach($semesters as $s)
                            <option value="{{ $s['tahun'] }}-{{ $s['tipe'] }}" {{ request('semester') == $s['tahun'].'-'.$s['tipe'] ? 'selected' : '' }}>
                                Semester {{ ucfirst($s['tipe']) }} {{ $s['tahun'] }}
                            </option>
                        @endforeach
                    </select>
                </form>

                <div class="d-flex gap-2">
                    <a href="{{ route('surat-tugas.export', request()->all()) }}" class="btn btn-export fw-bold">
                        <i class="fa fa-file-excel me-2"></i> Export Excel
                    </a>
                    <button type="button" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#suratTugasModal">
                        <i class="fa fa-plus me-2"></i> Tambah Data
                    </button>
                </div>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead class="table-light text-center">
                <tr>
                  <th>No</th>
                  <th>Nama Dosen</th>
                  <th>Peran</th>
                  <th>Diminta Sebagai</th>
                  <th>Mitra/Instansi</th>
                  <th>No & Tgl Surat Instansi</th>
                  <th>No & Tgl Surat Kadep</th>
                  <th>Tgl Kegiatan</th>
                  <th>Lokasi</th>
                  <th>Dokumen</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="data-body">
                @forelse($data as $index => $item)
                  <tr>
                    <td class="text-center">{{ $data->firstItem() + $index }}</td>
                    {{-- PERBAIKAN: Menampilkan nama dari relasi pegawai --}}
                    <td>{{ $item->pegawai->nama_lengkap ?? 'Pegawai Telah Dihapus' }}</td>
                    <td>{{ $item->peran }}</td>
                    <td>{{ $item->diminta_sebagai ?? '-' }}</td>
                    <td>{{ $item->mitra_instansi ?? '-' }}</td>
                    <td>
                      {{ $item->no_surat_instansi ?? '-' }}<br>
                      <small>{{ $item->tgl_surat_instansi ? $item->tgl_surat_instansi->format('d M Y') : '' }}</small>
                    </td>
                    <td>
                      {{ $item->no_surat_kadep ?? '-' }}<br>
                      <small>{{ $item->tgl_surat_kadep ? $item->tgl_surat_kadep->format('d M Y') : '' }}</small>
                    </td>
                    <td>{{ $item->tgl_kegiatan ? $item->tgl_kegiatan->format('d M Y') : '-' }}</td>
                    <td>{{ $item->lokasi ?? '-' }}</td>
                    <td class="text-center">
                      @if($item->dokumen)
                        <a href="{{ asset('storage/'.$item->dokumen) }}" target="_blank" class="btn btn-sm text-white px-3 btn-lihat">
                          Lihat
                        </a>
                      @else
                        -
                      @endif
                    </td>
                    <td class="text-center">
                      <div class="d-flex gap-2 justify-content-center">
                        <a href="#" class="btn-aksi btn-edit" title="Edit Data" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                          <i class="fa fa-edit"></i>
                        </a>
                        {{-- PERBAIKAN: Mengambil data nama dari relasi untuk konfirmasi hapus --}}
                        <a href="#" class="btn-aksi btn-hapus" data-id="{{ $item->id }}" data-nama="{{ $item->pegawai->nama_lengkap ?? 'Data' }}">
                            <i class="fas fa-trash"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                  {{-- Mengirimkan variabel $pegawais ke modal edit --}}
                  @include('pages.surat-tugas.edit', ['item' => $item, 'pegawais' => $pegawais])
                @empty
                  <tr>
                    <td colspan="11" class="text-center text-muted">Data Surat Tugas belum tersedia</td>
                  </tr>
                @endforelse
              </tbody>
            </table>

            <div class="mt-4">
              {{ $data->appends(request()->all())->links('pagination::bootstrap-5') }}
            </div>
          </div>
        </div>
      </div>

      @include('layouts.footer')
    </div>
  </div>

    @include('components.konfirmasi-hapus')
    @include('components.konfirmasi-berhasil')
    {{-- Mengirimkan variabel $pegawais ke modal create --}}
    @include('pages.surat-tugas.create', ['pegawais' => $pegawais])

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="{{ asset('assets/js/surat-tugas.js') }}"></script>
</body>
</html>