<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="flash-success" content="{{ session('success') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SIKEMAH - Kerjasama</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/kerjasama.css') }}" />
</head>

<body>
  <div class="layout">
    @include('layouts.sidebar')

    <div class="main-wrapper">
      @include('layouts.header')

      <!-- Title Bar -->
      <div class="title-bar">
        <h1>
          <i class="lni lni-handshake"></i>
          <span id="page-title">Kerjasama</span>
        </h1>
      </div>

      <div class="main-content">
        <div class="card">
          <div class="card-body p-4">

            <!-- Top Action Bar -->
            <form id="searchForm" method="GET" class="top-action-bar d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
              <div class="d-flex align-items-center gap-3 flex-grow-1">
                <!-- Search Box -->
                <div class="input-group search-box">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-search search-icon"></i>
                  </span>
                  <input
                    type="text"
                    id="searchInput"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control border-start-0 search-input"
                    placeholder="Cari Data..."
                  />
                </div>

                <!-- Jenis Select -->
                <select name="jenis" class="form-select jenis-select" onchange="this.form.submit()">
                  <option value="Semua" {{ request('jenis') == 'Semua' ? 'selected' : '' }}>Semua Jenis</option>
                  <option value="MoU" {{ request('jenis') == 'MoU' ? 'selected' : '' }}>MoU</option>
                  <option value="LoA" {{ request('jenis') == 'LoA' ? 'selected' : '' }}>LoA</option>
                  <option value="SPK" {{ request('jenis') == 'SPK' ? 'selected' : '' }}>SPK</option>
                </select>
              </div>

              <!-- Buttons -->
              <div class="d-flex gap-2">
                  <a href="{{ route('kerjasama.index', array_merge(request()->all(), ['export' => 'excel'])) }}"
                    class="btn btn-export fw-bold">
                    <i class="fa-solid fa-file-excel me-2"></i> Export Excel
                  </a>
                <button type="button" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#kerjasamaModal">
                  <i class="fa fa-plus me-2"></i> Tambah Data
                </button>
              </div>
            </form>

            <!-- Table -->
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead class="table-light">
                  <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Mitra/Instansi</th>
                    <th>No Dokumen</th>
                    <th>TMT (Mulai)</th>
                    <th>TST (Selesai)</th>
                    <th>Departemen PJ</th>
                    <th>Tim</th>
                    <th>Lokasi</th>
                    <th>Besaran Dana</th>
                    <th>Jenis Kerjasama</th>
                    <th>File</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($kerjasama as $index => $item)
                    <tr>
                      <td>{{ $kerjasama->firstItem() + $index }}</td>
                      <td>{{ $item->judul }}</td>
                      <td>{{ $item->mitra }}</td>
                      <td>
                        @if($item->no_surat_mitra)
                          <strong>Mitra:</strong> {{ $item->no_surat_mitra }} <br>
                        @endif
                        @if($item->no_surat_departemen)
                          <strong>Dept:</strong> {{ $item->no_surat_departemen }}
                        @endif
                      </td>
                      <td>{{ $item->tmt?->format('d M Y') }}</td>
                      <td>{{ $item->tst?->format('d M Y') }}</td>
                      <td>{{ $item->departemen_penanggung_jawab }}</td>
                      <td>
                        <strong>Ketua:</strong>
                        <ul class="mb-0 ps-3">
                          @foreach($item->tim->where('jabatan','ketua') as $ketua)
                            <li>{{ $ketua->nama }} </li>
                          @endforeach
                        </ul>
                        <strong>Anggota:</strong>
                        <ul class="mb-0 ps-3">
                          @foreach($item->tim->where('jabatan','anggota') as $anggota)
                            <li>{{ $anggota->nama }} </li>
                          @endforeach
                        </ul>
                      </td>
                      <td>{{ $item->lokasi }}</td>
                      <td>Rp {{ number_format($item->besaran_dana ?? 0, 0, ',', '.') }}</td>
                      <td>
                        @if($item->jenis_kerjasama)
                          <span class="badge badge-kerjasama 
                            @if($item->jenis_kerjasama == 'MoU') badge-mou
                            @elseif($item->jenis_kerjasama == 'LoA') badge-loa
                            @elseif($item->jenis_kerjasama == 'SPK') badge-spk
                            @else badge-other
                            @endif">
                            {{ $item->jenis_kerjasama }}
                          </span>
                        @endif
                      </td>
                      <td>
                        <div class="d-flex flex-column gap-2">
                          @if($item->file_dokumen)
                            <a href="{{ asset('storage/'.$item->file_dokumen) }}" target="_blank" class="btn btn-filedoc btn-sm btn-file">Dokumen</a>
                          @endif
                          @if($item->file_laporan)
                            <a href="{{ asset('storage/'.$item->file_laporan) }}" target="_blank" class="btn btn-filelapor btn-sm btn-file">Laporan</a>
                          @endif
                        </div>
                      </td>
                      <td class="align-middle">
                        <div class="d-flex gap-2">
                          <!-- Tombol Lihat Detail -->
                          <button type="button" class="btn btn-sm btn-lihat" data-bs-toggle="modal" data-bs-target="#modalDetailKerjasama{{ $item->id }}">
                            <i class="fa fa-eye"></i>
                          </button>
                          
                          <!-- Tombol Edit -->
                          <button type="button" class="btn btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#editKerjasamaModal-{{ $item->id }}">
                              <i class="fa fa-edit"></i>
                          </button>

                          <!-- Tombol Hapus -->
                            <a href="#" 
                              class="btn btn-sm btn-hapus trigger-hapus" 
                              data-id="{{ $item->id }}" 
                              data-nama="{{ $item->judul }}">
                              <i class="fa fa-trash"></i>
                            </a>

                        </div>
                      </td>
                    </tr>

                    {{-- Modal Detail per Item --}}
                    @include('components.kerjasama.detail-kerjasama', ['kerjasama' => $item])

                    {{-- Modal Edit per Item --}}
                    @include('components.kerjasama.edit-kerjasama', ['kerjasama' => $item])

                  @empty
                    <tr>
                      <td colspan="15" class="text-center text-muted">Data Kerjasama belum tersedia</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            
              <!-- Pagination -->
            {{ $kerjasama->appends(request()->all())->links('pagination::bootstrap-5') }}
            </div>
          </div>
        </div>
      </div>

      @include('layouts.footer')
    </div>

    <!-- Global Modals -->
    @include('components.konfirmasi-hapus')
    @include('components.konfirmasi-berhasil')
    @include('components.kerjasama.tambah-kerjasama')

    <!-- Scripts -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <script src="{{ asset('assets/js/kerjasama.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  </div>
</body>
</html>