<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>SIKEMAH - Editor Kegiatan (Akademik)</title>

    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/pendidikan.css') }}" />
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
          <span id="page-title">Editor Kegiatan - Akademik</span>
        </h1>
      </div>

    <div class="main-content">
      <div class="card">
          <ul class="nav nav-tabs mb-4" id="pendidikanTab" role="tablist">
            <li class="nav-item" role="presentation"><button class="nav-link active" id="pengajaran-lama-tab" data-bs-toggle="tab" data-bs-target="#pengajaran-lama" type="button" role="tab">Pengajaran Lama</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="pengajaran-luar-tab" data-bs-toggle="tab" data-bs-target="#pengajaran-luar" type="button" role="tab">Pengajaran Luar IPB</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="pengujian-lama-tab" data-bs-toggle="tab" data-bs-target="#pengujian-lama" type="button" role="tab">Pengujian Lama</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="pembimbing-lama-tab" data-bs-toggle="tab" data-bs-target="#pembimbing-lama" type="button" role="tab">Pembimbing Lama</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="penguji-luar-tab" data-bs-toggle="tab" data-bs-target="#penguji-luar" type="button" role="tab">Penguji Luar IPB</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="pembimbing-luar-tab" data-bs-toggle="tab" data-bs-target="#pembimbing-luar" type="button" role="tab">Pembimbing Luar IPB</button></li>
          </ul>

          <div class="tab-content" id="pendidikanTabContent">
            {{-- =================================== PENGAJARAN LAMA =================================== --}}
            <div class="tab-pane fade show active" id="pengajaran-lama" role="tabpanel">
                <form action="{{ route('pendidikan.index') }}" method="GET" class="filter-form">
                    <div class="search-filter-container">
                        <div class="search-filter-row">
                            <div class="search-box">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-search search-icon"></i></span>
                                    <input type="text" name="search" class="form-control search-input border-start-0" placeholder="Cari Nama Dosen/MK..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <select name="tahun_akademik" class="form-select filter-select">
                                <option value="">Semua Semester</option>
                                @foreach($tahunAkademikOptions as $tahun)
                                    <option value="{{ $tahun }}" @if(request('tahun_akademik') == $tahun) selected @endif>{{ $tahun }}</option>
                                @endforeach
                            </select>
                            <select name="status" class="form-select filter-select">
                                <option value="">Semua Status</option>
                                <option value="diverifikasi" @if(request('status') == 'diverifikasi') selected @endif>Diverifikasi</option>
                                <option value="ditolak" @if(request('status') == 'ditolak') selected @endif>Ditolak</option>
                                <option value="menunggu" @if(request('status') == 'menunggu') selected @endif>Menunggu</option>
                            </select>
                            <div class="btn-tambah-container">
                               <a href="{{ route('pengajaran-lama.export', request()->all()) }}" class="btn btn-export fw-bold">
                                <i class="fa fa-file-excel me-2"></i> Export Excel
                               </a>
                                <a href="#" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahEditPengajaranLama" id="btnTambahPengajaranLama">
                                    <i class="fa fa-plus me-2"></i> Tambah Data
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light"><tr class="text-center"><th>No</th><th>Nama Dosen</th><th>Tahun Semester</th><th>Mata Kuliah</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                        <tbody>
                            @forelse ($dataPengajaranLama as $index => $item)
                            <tr>
                                <td class="text-center">{{ $dataPengajaranLama->firstItem() + $index }}</td>
                                <td>{{ $item->pegawai->nama_lengkap ?? 'N/A' }}</td>
                                <td class="text-center">{{ $item->tahun_semester }}</td>
                                <td>{{ $item->nama_mk }} ({{$item->kode_mk}})</td>
                                <td class="text-center">
                                    @if ($item->status_verifikasi == 'diverifikasi')
                                        <i class="fas fa-check-circle text-success" title="Diverifikasi"></i>
                                    @elseif ($item->status_verifikasi == 'ditolak')
                                        <i class="fas fa-times-circle text-danger" title="Ditolak"></i>
                                    @else
                                        <i class="fas fa-question-circle text-warning" title="Menunggu"></i>
                                    @endif
                                </td>
                                <td class="text-center"><a href="{{ $item->file_path ? Storage::url($item->file_path) : '#' }}" class="btn btn-sm btn-lihat text-white {{ $item->file_path ? '' : 'disabled' }}" target="_blank">Lihat</a></td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        @if (Auth::user()->role == 'admin_verifikator')
                                        <a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi Data" data-id="{{ $item->id }}" data-type="pengajaran-lama"><i class="fa fa-check"></i></a>
                                        @endif
                                        <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-pengajaran-lama" title="Lihat Detail" data-bs-toggle="modal" data-bs-target="#modalDetailPengajaranLama" data-id="{{ $item->id }}"><i class="fa fa-eye"></i></a>
                                        <a href="#" class="btn-aksi btn-edit btn-edit-pengajaran-lama" title="Edit Data" data-id="{{ $item->id }}"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="btn-aksi btn-hapus" title="Hapus Data" data-id="{{ $item->id }}" data-type="pengajaran-lama"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center text-muted">Data Pengajaran Lama belum tersedia</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                {{ $dataPengajaranLama->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
            
            {{-- =================================== PENGAJARAN LUAR =================================== --}}
            <div class="tab-pane fade" id="pengajaran-luar" role="tabpanel">
                <form action="{{ route('pendidikan.index') }}" method="GET" class="filter-form">
                    <div class="search-filter-container">
                        <div class="search-filter-row">
                            <div class="search-box">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-search search-icon"></i></span>
                                    <input type="text" name="search" class="form-control search-input border-start-0" placeholder="Cari Nama Dosen/Univ..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <select name="tahun_akademik" class="form-select filter-select">
                                <option value="">Semua Semester</option>
                                @foreach($tahunAkademikOptions as $tahun)
                                    <option value="{{ $tahun }}" @if(request('tahun_akademik') == $tahun) selected @endif>{{ $tahun }}</option>
                                @endforeach
                            </select>
                            <select name="status" class="form-select filter-select">
                                <option value="">Semua Status</option>
                                <option value="diverifikasi" @if(request('status') == 'diverifikasi') selected @endif>Diverifikasi</option>
                                <option value="ditolak" @if(request('status') == 'ditolak') selected @endif>Ditolak</option>
                                <option value="menunggu" @if(request('status') == 'menunggu') selected @endif>Menunggu</option>
                            </select>
                            <div class="btn-tambah-container">
                              <a href="{{ route('pengajaran-luar.export', request()->all()) }}" class="btn btn-export fw-bold">
                                <i class="fa fa-file-excel me-2"></i> Export Excel
                               </a>
                                <a href="#" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#modalPengajaranLuar" id="btnTambahPengajaranLuar">
                                    <i class="fa fa-plus me-2"></i> Tambah Data
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light"><tr class="text-center"><th>No</th><th>Nama Dosen</th><th>Institusi</th><th>Mata Kuliah</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                        <tbody>
                            @forelse ($dataPengajaranLuar as $index => $item)
                            <tr>
                                <td class="text-center">{{ $dataPengajaranLuar->firstItem() + $index }}</td>
                                <td>{{ $item->pegawai->nama_lengkap ?? 'N/A' }}</td>
                                <td>{{ $item->universitas }}</td>
                                <td>{{ $item->nama_mk }}</td>
                                <td class="text-center">
                                    @if ($item->status_verifikasi == 'diverifikasi')
                                        <i class="fas fa-check-circle text-success" title="Diverifikasi"></i>
                                    @elseif ($item->status_verifikasi == 'ditolak')
                                        <i class="fas fa-times-circle text-danger" title="Ditolak"></i>
                                    @else
                                        <i class="fas fa-question-circle text-warning" title="Menunggu"></i>
                                    @endif
                                </td>
                                <td class="text-center"><a href="{{ $item->file_path ? Storage::url($item->file_path) : '#' }}" class="btn btn-sm btn-lihat text-white {{ $item->file_path ? '' : 'disabled' }}" target="_blank">Lihat</a></td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi Data" data-id="{{ $item->id }}" data-type="pengajaran-luar"><i class="fa fa-check"></i></a>
                                        <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-pengajaran-luar" title="Lihat Detail" data-bs-toggle="modal" data-bs-target="#modalDetailPengajaranLuar" data-id="{{ $item->id }}"><i class="fa fa-eye"></i></a>
                                        <a href="#" class="btn-aksi btn-edit btn-edit-pengajaran-luar" title="Edit Data" data-id="{{ $item->id }}"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="btn-aksi btn-hapus" title="Hapus Data" data-id="{{ $item->id }}" data-type="pengajaran-luar"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center text-muted">Data Pengajaran Luar IPB belum tersedia</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                {{ $dataPengajaranLuar->appends(request()->query())->links('pagination::bootstrap-5') }}
                
            </div>
            
            {{-- =================================== PENGUJIAN LAMA =================================== --}}
            <div class="tab-pane fade" id="pengujian-lama" role="tabpanel">
                <form action="{{ route('pendidikan.index') }}" method="GET" class="filter-form">
                    <div class="search-filter-container">
                        <div class="search-filter-row">
                            <div class="search-box">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-search search-icon"></i></span>
                                    <input type="text" name="search" class="form-control search-input border-start-0" placeholder="Cari Nama Dosen/Mhs..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <select name="tahun_akademik" class="form-select filter-select">
                                <option value="">Semua Semester</option>
                                @foreach($tahunAkademikOptions as $tahun)
                                    <option value="{{ $tahun }}" @if(request('tahun_akademik') == $tahun) selected @endif>{{ $tahun }}</option>
                                @endforeach
                            </select>
                            <select name="status" class="form-select filter-select">
                                <option value="">Semua Status</option>
                                <option value="diverifikasi" @if(request('status') == 'diverifikasi') selected @endif>Diverifikasi</option>
                                <option value="ditolak" @if(request('status') == 'ditolak') selected @endif>Ditolak</option>
                                <option value="menunggu" @if(request('status') == 'menunggu') selected @endif>Menunggu</option>
                            </select>
                            <div class="btn-tambah-container">
                              <a href="{{ route('pengujian-lama.export', request()->all()) }}" class="btn btn-export fw-bold">
                                <i class="fa fa-file-excel me-2"></i> Export Excel
                               </a>
                                <a href="#" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#modalPengujianLama" id="btnTambahPengujianLama">
                                    <i class="fa fa-plus me-2"></i> Tambah Data
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light"><tr class="text-center"><th>No</th><th>Nama Dosen</th><th>Nama Mahasiswa</th><th>Departemen</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                        <tbody>
                            @forelse ($dataPengujianLama as $index => $item)
                            <tr>
                                <td class="text-center">{{ $dataPengujianLama->firstItem() + $index }}</td>
                                <td>{{ $item->pegawai->nama_lengkap ?? 'N/A' }}</td>
                                <td>{{ $item->nama_mahasiswa }} ({{$item->nim}})</td>
                                <td>{{ $item->departemen }}</td>
                                <td class="text-center">
                                    @if ($item->status_verifikasi == 'diverifikasi')
                                        <i class="fas fa-check-circle text-success" title="Diverifikasi"></i>
                                    @elseif ($item->status_verifikasi == 'ditolak')
                                        <i class="fas fa-times-circle text-danger" title="Ditolak"></i>
                                    @else
                                        <i class="fas fa-question-circle text-warning" title="Menunggu"></i>
                                    @endif
                                </td>
                                <td class="text-center"><a href="{{ $item->file_path ? Storage::url($item->file_path) : '#' }}" class="btn btn-sm btn-lihat text-white {{ $item->file_path ? '' : 'disabled' }}" target="_blank">Lihat</a></td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi Data" data-id="{{ $item->id }}" data-type="pengujian-lama"><i class="fa fa-check"></i></a>
                                        <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-pengujian-lama" title="Lihat Detail" data-bs-toggle="modal" data-bs-target="#modalDetailPengujianLama" data-id="{{ $item->id }}"><i class="fa fa-eye"></i></a>
                                        <a href="#" class="btn-aksi btn-edit btn-edit-pengujian-lama" title="Edit Data" data-id="{{ $item->id }}"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="btn-aksi btn-hapus" title="Hapus Data" data-id="{{ $item->id }}" data-type="pengujian-lama"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center text-muted">Data Pengujian Lama belum tersedia</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                {{ $dataPengujianLama->appends(request()->query())->links('pagination::bootstrap-5') }}
               
            </div>

            {{-- =================================== PEMBIMBING LAMA =================================== --}}
            <div class="tab-pane fade" id="pembimbing-lama" role="tabpanel">
                <form action="{{ route('pendidikan.index') }}" method="GET" class="filter-form">
                    <div class="search-filter-container">
                        <div class="search-filter-row">
                            <div class="search-box">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-search search-icon"></i></span>
                                    <input type="text" name="search" class="form-control search-input border-start-0" placeholder="Cari Nama Dosen/Kegiatan..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <select name="tahun_akademik" class="form-select filter-select">
                                <option value="">Semua Semester</option>
                                @foreach($tahunAkademikOptions as $tahun)
                                    <option value="{{ $tahun }}" @if(request('tahun_akademik') == $tahun) selected @endif>{{ $tahun }}</option>
                                @endforeach
                            </select>
                            <select name="status" class="form-select filter-select">
                                <option value="">Semua Status</option>
                                <option value="diverifikasi" @if(request('status') == 'diverifikasi') selected @endif>Diverifikasi</option>
                                <option value="ditolak" @if(request('status') == 'ditolak') selected @endif>Ditolak</option>
                                <option value="menunggu" @if(request('status') == 'menunggu') selected @endif>Menunggu</option>
                            </select>
                            <div class="btn-tambah-container">
                               <a href="{{ route('pembimbing-lama.export', request()->all()) }}" class="btn btn-export fw-bold">
                                <i class="fa fa-file-excel me-2"></i> Export Excel
                               </a>
                                <a href="#" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#modalPembimbingLama" id="btnTambahPembimbingLama">
                                    <i class="fa fa-plus me-2"></i> Tambah Data
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
                  <div class="table-responsive">
                      <table class="table table-hover table-bordered">
                          <thead class="table-light"><tr class="text-center"><th>No</th><th>Nama Dosen</th><th>Kegiatan</th><th>Nama Mahasiswa</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                          <tbody>
                            @forelse ($dataPembimbingLama as $index => $item)
                            <tr>
                                <td class="text-center">{{ $dataPembimbingLama->firstItem() + $index }}</td>
                                <td>{{ $item->pegawai->nama_lengkap ?? 'N/A' }}</td>
                                <td class="text-start">{{ Str::limit($item->kegiatan, 30) }}</td>
                                <td>{{ $item->nama_mahasiswa }}</td>
                                <td class="text-center">
                                    @if ($item->status_verifikasi == 'diverifikasi')
                                        <i class="fas fa-check-circle text-success" title="Diverifikasi"></i>
                                    @elseif ($item->status_verifikasi == 'ditolak')
                                        <i class="fas fa-times-circle text-danger" title="Ditolak"></i>
                                    @else
                                        <i class="fas fa-question-circle text-warning" title="Menunggu"></i>
                                    @endif
                                </td>
                                <td class="text-center"><a href="{{ $item->file_path ? Storage::url($item->file_path) : '#' }}" class="btn btn-sm btn-lihat text-white {{ $item->file_path ? '' : 'disabled' }}" target="_blank">Lihat</a></td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi Data" data-id="{{ $item->id }}" data-type="pembimbing-lama"><i class="fa fa-check"></i></a>
                                        <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-pembimbing-lama" title="Lihat Detail" data-bs-toggle="modal" data-bs-target="#modalDetailPembimbingLama" data-id="{{ $item->id }}"><i class="fa fa-eye"></i></a>
                                        <a href="#" class="btn-aksi btn-edit btn-edit-pembimbing-lama" title="Edit Data" data-id="{{ $item->id }}"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="btn-aksi btn-hapus" title="Hapus Data" data-id="{{ $item->id }}" data-type="pembimbing-lama"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center text-muted">Data Pembimbing Lama belum tersedia</td></tr>
                            @endforelse
                          </tbody>
                      </table>
                  </div>
                  <!-- Pagination -->
                {{ $dataPembimbingLama->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
            
            {{-- =================================== PENGUJI LUAR =================================== --}}
            <div class="tab-pane fade" id="penguji-luar" role="tabpanel">
                <form action="{{ route('pendidikan.index') }}" method="GET" class="filter-form">
                    <div class="search-filter-container">
                        <div class="search-filter-row">
                            <div class="search-box">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-search search-icon"></i></span>
                                    <input type="text" name="search" class="form-control search-input border-start-0" placeholder="Cari Nama Dosen/Mhs..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <select name="tahun_akademik" class="form-select filter-select">
                                <option value="">Semua Semester</option>
                                @foreach($tahunAkademikOptions as $tahun)
                                    <option value="{{ $tahun }}" @if(request('tahun_akademik') == $tahun) selected @endif>{{ $tahun }}</option>
                                @endforeach
                            </select>
                            <select name="status" class="form-select filter-select">
                                <option value="">Semua Status</option>
                                <option value="diverifikasi" @if(request('status') == 'diverifikasi') selected @endif>Diverifikasi</option>
                                <option value="ditolak" @if(request('status') == 'ditolak') selected @endif>Ditolak</option>
                                <option value="menunggu" @if(request('status') == 'menunggu') selected @endif>Menunggu</option>
                            </select>
                            <div class="btn-tambah-container">
                               <a href="{{ route('penguji-luar.export', request()->all()) }}" class="btn btn-export fw-bold">
                                <i class="fa fa-file-excel me-2"></i> Export Excel
                               </a>
                                <a href="#" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#modalPengujiLuar" id="btnTambahPengujiLuar">
                                    <i class="fa fa-plus me-2"></i> Tambah Data
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light"><tr class="text-center"><th>No</th><th>Nama Dosen</th><th>Nama Mahasiswa</th><th>Universitas</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                        <tbody>
                            @forelse ($dataPengujiLuar as $index => $item)
                            <tr>
                                <td class="text-center">{{ $dataPengujiLuar->firstItem() + $index }}</td>
                                <td>{{ $item->pegawai->nama_lengkap ?? 'N/A' }}</td>
                                <td>{{ $item->nama_mahasiswa }}</td>
                                <td>{{ $item->universitas }}</td>
                                <td class="text-center">
                                    @if ($item->status_verifikasi == 'diverifikasi')
                                        <i class="fas fa-check-circle text-success" title="Diverifikasi"></i>
                                    @elseif ($item->status_verifikasi == 'ditolak')
                                        <i class="fas fa-times-circle text-danger" title="Ditolak"></i>
                                    @else
                                        <i class="fas fa-question-circle text-warning" title="Menunggu"></i>
                                    @endif
                                </td>
                                <td class="text-center"><a href="{{ $item->file_path ? Storage::url($item->file_path) : '#' }}" class="btn btn-sm btn-lihat text-white {{ $item->file_path ? '' : 'disabled' }}" target="_blank">Lihat</a></td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi Data" data-id="{{ $item->id }}" data-type="penguji-luar"><i class="fa fa-check"></i></a>
                                        <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-penguji-luar" title="Lihat Detail" data-bs-toggle="modal" data-bs-target="#modalDetailPengujiLuar" data-id="{{ $item->id }}"><i class="fa fa-eye"></i></a>
                                        <a href="#" class="btn-aksi btn-edit btn-edit-penguji-luar" title="Edit Data" data-id="{{ $item->id }}"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="btn-aksi btn-hapus" title="Hapus Data" data-id="{{ $item->id }}" data-type="penguji-luar"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center text-muted">Data Pengujian Luar IPB belum tersedia</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                {{ $dataPengujiLuar->appends(request()->query())->links('pagination::bootstrap-5') }}
              
            </div>
            
            {{-- =================================== PEMBIMBING LUAR =================================== --}}
            <div class="tab-pane fade" id="pembimbing-luar" role="tabpanel">
                <form action="{{ route('pendidikan.index') }}" method="GET" class="filter-form">
                    <div class="search-filter-container">
                        <div class="search-filter-row">
                            <div class="search-box">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-search search-icon"></i></span>
                                    <input type="text" name="search" class="form-control search-input border-start-0" placeholder="Cari Nama Dosen/Mhs..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <select name="tahun_akademik" class="form-select filter-select">
                                <option value="">Semua Semester</option>
                                @foreach($tahunAkademikOptions as $tahun)
                                    <option value="{{ $tahun }}" @if(request('tahun_akademik') == $tahun) selected @endif>{{ $tahun }}</option>
                                @endforeach
                            </select>
                            <select name="status" class="form-select filter-select">
                                <option value="">Semua Status</option>
                                <option value="diverifikasi" @if(request('status') == 'diverifikasi') selected @endif>Diverifikasi</option>
                                <option value="ditolak" @if(request('status') == 'ditolak') selected @endif>Ditolak</option>
                                <option value="menunggu" @if(request('status') == 'menunggu') selected @endif>Menunggu</option>
                            </select>
                            <div class="btn-tambah-container">
                               <a href="{{ route('pembimbing-luar.export', request()->all()) }}" class="btn btn-export fw-bold">
                                <i class="fa fa-file-excel me-2"></i> Export Excel
                               </a>
                                <a href="#" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#modalPembimbingLuar" id="btnTambahPembimbingLuar">
                                    <i class="fa fa-plus me-2"></i> Tambah Data
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light"><tr class="text-center"><th>No</th><th>Nama Dosen</th><th>Nama Mahasiswa</th><th>Universitas</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                        <tbody>
                             @forelse ($dataPembimbingLuar as $index => $item)
                            <tr>
                                <td class="text-center">{{ $dataPembimbingLuar->firstItem() + $index }}</td>
                                <td>{{ $item->pegawai->nama_lengkap ?? 'N/A' }}</td>
                                <td>{{ $item->nama_mahasiswa }}</td>
                                <td>{{ $item->universitas }}</td>
                                <td class="text-center">
                                    @if ($item->status_verifikasi == 'diverifikasi')
                                        <i class="fas fa-check-circle text-success" title="Diverifikasi"></i>
                                    @elseif ($item->status_verifikasi == 'ditolak')
                                        <i class="fas fa-times-circle text-danger" title="Ditolak"></i>
                                    @else
                                        <i class="fas fa-question-circle text-warning" title="Menunggu"></i>
                                    @endif
                                </td>
                                <td class="text-center"><a href="{{ $item->file_path ? Storage::url($item->file_path) : '#' }}" class="btn btn-sm btn-lihat text-white {{ $item->file_path ? '' : 'disabled' }}" target="_blank">Lihat</a></td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi Data" data-id="{{ $item->id }}" data-type="pembimbing-luar"><i class="fa fa-check"></i></a>
                                        <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-pembimbing-luar" title="Lihat Detail" data-bs-toggle="modal" data-bs-target="#modalDetailPembimbingLuar" data-id="{{ $item->id }}"><i class="fa fa-eye"></i></a>
                                        <a href="#" class="btn-aksi btn-edit btn-edit-pembimbing-luar" title="Edit Data" data-id="{{ $item->id }}"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="btn-aksi btn-hapus" title="Hapus Data" data-id="{{ $item->id }}" data-type="pembimbing-luar"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center text-muted">Data Pembimbing Luar IPB belum tersedia</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                {{ $dataPembimbingLuar->appends(request()->query())->links('pagination::bootstrap-5') }}

            </div>
          </div>
          
      </div>
  </div>

    @include('layouts.footer')
</div>

  {{-- =================================== KUMPULAN MODAL =================================== --}}
    @include('components.konfirmasi-hapus')
    @include('components.konfirmasi-berhasil')
    @include('components.konfirmasi-verifikasi')
    
    @include('components.pendidikan.detail-pengajaran-lama')
    @include('components.pendidikan.tambah-pengajaran-lama', ['dosenAktif' => $dosenAktif])

    @include('components.pendidikan.detail-pengajaran-luar')
    @include('components.pendidikan.tambah-pengajaran-luar', ['dosenAktif' => $dosenAktif])

    @include('components.pendidikan.detail-pengujian-lama')
    @include('components.pendidikan.tambah-pengujian-lama', ['dosenAktif' => $dosenAktif])
    
    @include('components.pendidikan.detail-pembimbing-lama')
    @include('components.pendidikan.tambah-pembimbing-lama', ['dosenAktif' => $dosenAktif])
    
    @include('components.pendidikan.detail-penguji-luar')
    @include('components.pendidikan.tambah-penguji-luar', ['dosenAktif' => $dosenAktif])
    
    @include('components.pendidikan.detail-pembimbing-luar')
    @include('components.pendidikan.tambah-pembimbing-luar', ['dosenAktif' => $dosenAktif])
  
  <!-- Scripts -->
  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="{{ asset('assets/js/pendidikan.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
<script>
$(document).ready(function() {
  // Jalankan Select2 setelah modal muncul agar tampil sempurna
  $('#modalTambahEditPengajaranLama').on('shown.bs.modal', function () {

    // Inisialisasi Select2 untuk Nama Dosen
    $('#nama').select2({
      theme: 'bootstrap-5',
      dropdownParent: $('#modalTambahEditPengajaranLama'),
      placeholder: '-- Pilih Salah Satu --',
      allowClear: true,
      width: '100%'
    });

    // Inisialisasi Select2 untuk Tahun Semester
    $('#pla_tahun_semester').select2({
      theme: 'bootstrap-5',
      dropdownParent: $('#modalTambahEditPengajaranLama'),
      placeholder: '-- Pilih Salah Satu --',
      allowClear: true,
      width: '100%'
    });

  });
});


$(document).ready(function() {
    // Jalankan Select2 setelah modal Pengajaran Luar muncul
    $('#modalPengajaranLuar').on('shown.bs.modal', function () {
        $('#pl_nama').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#modalPengajaranLuar'),
            placeholder: '-- Pilih Salah Satu --',
            allowClear: true,
            width: '100%'
        });
      // Inisialisasi Select2 untuk Tahun Semester
    $('#pl_tahun_semester').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#modalPengajaranLuar'),
        placeholder: '-- Pilih Salah Satu --',
        allowClear: true,
        width: '100%'
    });

  });
});

// Saat modal ditampilkan
$('#modalPengujianLama').on('shown.bs.modal', function () {
  // Inisialisasi Select2 untuk Nama Dosen
  $('#pjl_nama').select2({
    theme: 'bootstrap-5',
    dropdownParent: $('#modalPengujianLama'),
    placeholder: '-- Pilih Salah Satu --',
    allowClear: true,
    width: '100%'
  });

  // Inisialisasi Select2 untuk Departemen
  $('#pjl_departemen').select2({
    theme: 'bootstrap-5',
    dropdownParent: $('#modalPengujianLama'),
    placeholder: '-- Pilih Salah Satu --',
    allowClear: true,
    width: '100%'
  });

  // Inisialisasi Select2 untuk Tahun Semester
  $('#pjl_tahun_semester').select2({
    theme: 'bootstrap-5',
    dropdownParent: $('#modalPengujianLama'),
    placeholder: '-- Pilih Salah Satu --',
    allowClear: true,
    width: '100%'
  });
});
  
  // ===== Modal: Pembimbing Lama =====
  $('#modalPembimbingLama').on('shown.bs.modal', function () {
    $('#pbl_nama, #pbl_departemen, #pbl_tahun_semester').select2({
      theme: 'bootstrap-5',
      dropdownParent: $('#modalPembimbingLama'),
      placeholder: '-- Pilih Salah Satu --',
      allowClear: true,
      width: '100%'
    });
  });

$(document).ready(function() {
  // Jalankan Select2 setelah modal Penguji Luar muncul
  $('#modalPengujiLuar').on('shown.bs.modal', function () {

    // Inisialisasi Select2 untuk Nama Dosen
    $('#pjl_nama').select2({
      theme: 'bootstrap-5',
      dropdownParent: $('#modalPengujiLuar'),
      placeholder: '-- Pilih Salah Satu --',
      allowClear: true,
      width: '100%'
    });

    // Inisialisasi Select2 untuk Tahun Semester
    $('#tahun_semester').select2({
      theme: 'bootstrap-5',
      dropdownParent: $('#modalPengujiLuar'),
      placeholder: '-- Pilih Tahun Semester --',
      allowClear: true,
      width: '100%'
    });

  });
});

 $(document).ready(function() {
    // Inisialisasi Select2 untuk dropdown tahun semester
    $('#tahun_semester').select2({
      theme: 'bootstrap-5', // jika kamu pakai bootstrap 5
      dropdownParent: $('#modalPembimbingLama'), // penting agar tampil di dalam modal
      placeholder: '-- Pilih Tahun Semester --',
      width: '100%'
    });
  });

$(document).ready(function() {
  $('#modalPengujiLuar').on('shown.bs.modal', function () {
    $('#pjl_nama, #tahun_semester').select2({
      theme: 'bootstrap-5',
      dropdownParent: $('#modalPengujiLuar'),
      placeholder: '-- Pilih Salah Satu --',
      allowClear: true,
      width: '100%'
    });
  });
});

 $(document).ready(function () {
    // Aktifkan Select2 saat modal tampil
    $('#modalPembimbingLuar').on('shown.bs.modal', function () {
      $('#pbl_nama_luar, #pbl_tahun_semester').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#modalPembimbingLuar'),
        placeholder: '-- Pilih Salah Satu --',
        allowClear: true,
        width: '100%'
      });
    });
  });


$(document).ready(function () {
  // Saat modal ditampilkan
  $('#modalTambahEditPengajaranLama').on('show.bs.modal', function () {
    const id = $('#editPengajaranId').val();

    if (id) {
      // Mode Edit
      $('#modalTitleText').text('Edit Pengajaran Lama');
      $('#btnSimpanPengajaran .btn-text').text('Simpan Perubahan');
      $('#btnSimpanPengajaran').removeClass('btn-success').addClass('btn-success');
    } else {
      // Mode Tambah
      $('#modalTitleText').text('Tambah Pengajaran Lama');
      $('#btnSimpanPengajaran .btn-text').text('Simpan');
      $('#btnSimpanPengajaran').removeClass('btn-Success').addClass('btn-success');
    }

    // Pastikan tombol aktif & spinner hilang
    $('#btnSimpanPengajaran').prop('disabled', false);
    $('#btnSimpanPengajaran .spinner-border').addClass('d-none');
  });

  // Saat tombol disimpan ditekan
  $('#btnSimpanPengajaran').on('click', function () {
    const $btn = $(this);
    const $text = $btn.find('.btn-text');
    const $spinner = $btn.find('.spinner-border');

    // Ubah tampilan tombol jadi loading
    $spinner.removeClass('d-none');
    $btn.prop('disabled', true);
    $text.text('Menyimpan...');

    // Deteksi mode dari hidden input
    const id = $('#editPengajaranId').val();
    const mode = id ? 'edit' : 'tambah';

    // Simulasi proses (nanti ganti pakai AJAX)
    setTimeout(() => {
      $spinner.addClass('d-none');
      $btn.prop('disabled', false);
      $text.text(mode === 'edit' ? 'Simpan Perubahan' : 'Simpan');
      $('#modalTambahEditPengajaranLama').modal('hide');
    }, 2000);
  });
});

$(document).ready(function () {
  // Event saat modal dibuka
  $('#modalPengajaranLuar').on('show.bs.modal', function () {
    const id = $('#editPengajaranLuarId').val();

    if (id) {
      // Mode EDIT
      $('#modalTitleTextPengajaranLuar').text('Edit Kegiatan Pengajaran Luar IPB');
      $('#btnSimpanPengajaranLuar')
        .text('Simpan Perubahan');
    } else {
      // Mode TAMBAH
      $('#modalTitleTextPengajaranLuar').text('Tambah Kegiatan Pengajaran Luar IPB');
      $('#btnSimpanPengajaranLuar')
        .text('Simpan');
    }
  });

  // (Opsional) Reset nilai saat modal ditutup
  $('#modalPengajaranLuar').on('hidden.bs.modal', function () {
    $('#formPengajaranLuar')[0].reset();
    $('#editPengajaranLuarId').val('');
  });
});

$(document).ready(function () {
  // Event saat modal dibuka
  $('#modalPengujianLama').on('show.bs.modal', function () {
    const id = $('#editPengujianLamaId').val();

    if (id) {
      // Mode EDIT
      $('#modalTitleTextPengujianLama').text('Edit Kegiatan Pengujian Lama');
      $('#btnSimpanPengujianLama')
        .text('Simpan Perubahan');
    } else {
      // Mode TAMBAH
      $('#modalTitleTextPengujianLama').text('Tambah Kegiatan Pengujian Lama');
      $('#btnSimpanPengujianLama')
        .text('Simpan');
    }
  });

  // Reset form saat modal ditutup
  $('#modalPengujianLama').on('hidden.bs.modal', function () {
    $('#formPengujianLama')[0].reset();
    $('#editPengujianLamaId').val('');

    // Jika kamu pakai Select2 di form ini:
    $('#pjl_nama').val('').trigger('change');
    $('#pjl_departemen').val('').trigger('change');
  });
});

$(document).ready(function () {
  $('#modalPengujiLuar').on('show.bs.modal', function () {
    const id = $('#editPengujiLuarId').val();

    if (id) {
      $('#modalTitleTextPengujiLuar').text('Edit Kegiatan Penguji Luar IPB');
      $('#btnSimpanPengujiLuar').text('Simpan Perubahan');
    } else {
      $('#modalTitleTextPengujiLuar').text('Tambah Kegiatan Penguji Luar IPB');
      $('#btnSimpanPengujiLuar').text('Simpan');
    }
  });

  $('#modalPengujiLuar').on('hidden.bs.modal', function () {
    $('#formPengujiLuar')[0].reset();
    $('#editPengujiLuarId').val('');
    $('#pjl_nama').val('').trigger('change');
    $('#tahun_semester').val('').trigger('change');
  });
})
</script>

</body>
</html>