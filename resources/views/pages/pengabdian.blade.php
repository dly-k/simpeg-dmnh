<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <title>SIKEMAH - Editor Kegiatan (Pengabdian)</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/pengabdian.css') }}" />
</head>

<body>
 <div class="layout">
    @include('layouts.sidebar')

    <div class="main-wrapper">
      @include('layouts.header')

      <div class="title-bar">
        <h1>
          <i class="lni lni-pencil-alt"></i>
          <span id="page-title">Editor Kegiatan - Pengabdian</span>
        </h1>
      </div>

  <div class="main-content">
    <div class="card">
      <form action="{{ route('pengabdian.index') }}" method="GET" id="filter-form">
          <div class="search-filter-container">
              <div class="search-filter-row">
                  <div class="search-box">
                      <div class="input-group">
                          <span class="input-group-text bg-light border-end-0"><i class="fas fa-search search-icon"></i></span>
                          <input type="text" name="search" class="form-control border-start-0 search-input" placeholder="Cari Kegiatan/Lokasi..." value="{{ request('search') }}">
                      </div>
                  </div>

                  <select name="periode" class="form-select filter-select">
                      <option value="">Semua Periode</option>
                      @foreach($periodeOptions as $value => $label)
                          <option value="{{ $value }}" @if(request('periode') == $value) selected @endif>{{ $label }}</option>
                      @endforeach
                  </select>

                  <select name="jenis_pengabdian" class="form-select filter-select">
                      <option value="">Semua Jenis Pengabdian</option>
                      @foreach($jenisPengabdianOptions as $jenis)
                          <option value="{{ $jenis }}" @if(request('jenis_pengabdian') == $jenis) selected @endif>{{ $jenis }}</option>
                      @endforeach
                  </select>

                  <select name="status" class="form-select filter-select">
                      <option value="">Semua Status</option>
                      <option value="Sudah Diverifikasi" @if(request('status') == 'Sudah Diverifikasi') selected @endif>Sudah Diverifikasi</option>
                      <option value="Belum Diverifikasi" @if(request('status') == 'Belum Diverifikasi') selected @endif>Belum Diverifikasi</option>
                      <option value="Ditolak" @if(request('status') == 'Ditolak') selected @endif>Ditolak</option>
                  </select>
                  
                  <div class="btn-tambah-container">
                      <button type="button" class="btn btn-tambah fw-bold" onclick="openModal()">
                          <i class="fa fa-plus me-2"></i> Tambah Data
                      </button>
                  </div>
              </div>
          </div>
      </form>

      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead class="table-light">
            <tr class="text-center">
              <th>No</th>
              <th>Kegiatan</th>
              <th>Nama Kegiatan</th>
              <th>Afiliasi</th>
              <th>Lokasi</th>
              <th>Nomor SK</th>
              <th>Tahun</th>
              <th>Verifikasi</th>
              <th>Dokumen</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="pengabdian-table-body">
            @forelse ($pengabdians as $index => $item)
              <tr>
                <td class="text-center">{{ $pengabdians->firstItem() + $index }}</td>
                <td class="text-start">{{ $item->kegiatan }}</td>
                <td class="text-center">{{ $item->nama_kegiatan }}</td>
                <td class="text-center">{{ $item->afiliasi_non_pt ?? '-' }}</td>
                <td class="text-center">{{ $item->lokasi ?? '-' }}</td>
                <td class="text-center">{{ $item->no_sk_penugasan ?? '-' }}</td>
                <td class="text-center">{{ $item->tahun_pelaksanaan ?? '-' }}</td>
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
                    @if($item->dokumen->isNotEmpty())
                        <a href="{{ Storage::url($item->dokumen->first()->file_path) }}" target="_blank" class="btn btn-sm btn-lihat text-white">
                            Lihat
                        </a>
                    @else
                        <span>-</span>
                    @endif
                </td>
                <td class="text-center">
                  <div class="d-flex gap-2 justify-content-center">
                    <a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi" data-id="{{ $item->id }}"><i class="fa fa-check"></i></a>
                    <a href="#" class="btn-aksi btn-lihat" title="Lihat Detail" data-id="{{ $item->id }}" data-bs-toggle="modal" data-bs-target="#pengabdianDetailModal"><i class="fa fa-eye"></i></a>
                    <a href="#" class="btn-aksi btn-edit" title="Edit Data" data-id="{{ $item->id }}"><i class="fa fa-edit"></i></a>
                    <a href="#" class="btn-aksi btn-hapus" title="Hapus Data" data-id="{{ $item->id }}"><i class="fa fa-trash"></i></a>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="10" class="text-center text-muted">Data tidak ditemukan.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <span class="text-muted small">
            @if ($pengabdians->total() > 0)
                Menampilkan {{ $pengabdians->firstItem() }} sampai {{ $pengabdians->lastItem() }} dari {{ $pengabdians->total() }} data
            @else
                Tidak ada data untuk ditampilkan
            @endif
        </span>
        @if ($pengabdians->hasPages())
            <div class="d-flex justify-content-end">
                {{ $pengabdians->links() }}
            </div>
        @endif
      </div>
    </div>
  </div>

    @include('layouts.footer')
</div>

  @include('components.konfirmasi-hapus')
  @include('components.konfirmasi-berhasil')
  @include('components.konfirmasi-verifikasi')
  @include('components.pengabdian.detail-pengabdian')
  @include('components.pengabdian.tambah-pengabdian')

  <script>
    const pegawaiData = @json($pegawais);
  </script>
  
  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('assets/js/pengabdian.js') }}"></script>
</body>
</html>