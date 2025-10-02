<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SIKEMAH - Editor Kegiatan (Penelitian)</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/penelitian.css') }}" />
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
          <span id="page-title">Editor Kegiatan - Penelitian</span>
        </h1>
      </div>

  {{-- Main Content --}}
  <div class="main-content">
    <div class="card">
        <form action="{{ route('penelitian.index') }}" method="GET" id="filter-form">
            <div class="search-filter-container">
                <div class="search-filter-row">
                    <div class="search-box">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-search search-icon"></i></span>
                            <input type="text" name="search" class="form-control border-start-0 search-input" placeholder="Cari Judul, Penulis..." value="{{ request('search') }}">
                        </div>
                    </div>
                    
                    <select name="periode" class="form-select filter-select">
                        <option value="">Semua Periode</option>
                        @foreach($periodeOptions as $value => $label)
                            <option value="{{ $value }}" @if(request('periode') == $value) selected @endif>{{ $label }}</option>
                        @endforeach
                    </select>
                    
                    <select name="jenis_karya_lengkap" class="form-select filter-select">
                        <option value="">Semua Jenis Karya</option>
                        <option value="Buku Monograf" @if(request('jenis_karya_lengkap') == 'Buku Monograf') selected @endif>Buku Monograf</option>
                        <option value="Buku Referensi" @if(request('jenis_karya_lengkap') == 'Buku Referensi') selected @endif>Buku Referensi</option>
                        <option value="Book Chapter Internasional" @if(request('jenis_karya_lengkap') == 'Book Chapter Internasional') selected @endif>Book Chapter Internasional</option>
                        <option value="Book Chapter Nasional" @if(request('jenis_karya_lengkap') == 'Book Chapter Nasional') selected @endif>Book Chapter Nasional</option>
                        <option value="Menyunting Buku" @if(request('jenis_karya_lengkap') == 'Menyunting Buku') selected @endif>Menyunting Buku</option>
                        <option value="Jurnal Internasional Bereputasi" @if(request('jenis_karya_lengkap') == 'Jurnal Internasional Bereputasi') selected @endif>Jurnal Internasional Bereputasi</option>
                        <option value="Jurnal Internasional Terindeks" @if(request('jenis_karya_lengkap') == 'Jurnal Internasional Terindeks') selected @endif>Jurnal Internasional Terindeks</option>
                        <option value="Jurnal Nasional" @if(request('jenis_karya_lengkap') == 'Jurnal Nasional') selected @endif>Jurnal Nasional</option>
                        <option value="Jurnal Nasional Terakreditasi" @if(request('jenis_karya_lengkap') == 'Jurnal Nasional Terakreditasi') selected @endif>Jurnal Nasional Terakreditasi</option>
                        <option value="Prosiding Internasional Terindeks WoS/Scopus" @if(request('jenis_karya_lengkap') == 'Prosiding Internasional Terindeks WoS/Scopus') selected @endif>Prosiding Internasional Terindeks WoS/Scopus</option>
                        <option value="Paten Sederhana" @if(request('jenis_karya_lengkap') == 'Paten Sederhana') selected @endif>Paten Sederhana</option>
                    </select>

                    <select name="status" class="form-select filter-select">
                        <option value="">Semua Status</option>
                        <option value="Sudah Diverifikasi" @if(request('status') == 'Sudah Diverifikasi') selected @endif>Sudah Diverifikasi</option>
                        <option value="Belum Diverifikasi" @if(request('status') == 'Belum Diverifikasi') selected @endif>Belum Diverifikasi</option>
                        <option value="Ditolak" @if(request('status') == 'Ditolak') selected @endif>Ditolak</option>
                    </select>
                    
                    <div class="btn-tambah-container">
                        <a href="#" class="btn btn-tambah fw-bold" onclick="openModal()">
                            <i class="fas fa-plus me-2"></i> Tambah Data
                        </a>
                    </div>
                </div>
            </div>
        </form>

      <div class="card-body px-4 pb-4 pt-2">
        {{-- Menampilkan Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5 class="alert-heading">Gagal Menyimpan Data!</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Tabel Data Dinamis --}}
        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead class="table-light text-center align-middle">
              <tr>
                <th>No</th>
                <th>Judul & Penulis</th>
                <th>Tgl Terbit</th>
                <th>Jenis Karya</th>
                <th>Publik</th>
                <th>Status</th>
                <th>Dokumen</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody id="penelitian-table-body">
              @forelse($penelitian as $item)
              <tr data-row-id="{{ $item->id }}">
                <td class="text-center">{{ $loop->iteration + $penelitian->firstItem() - 1 }}</td>
                <td>
                  {{ $item->judul }}
                  <small class="text-muted d-block mt-1">
                    @php
                        $penulisDisplay = $item->penulis->map(fn($p) => $p->pegawai->nama_lengkap ?? $p->nama_penulis);
                    @endphp
                    <i class="fas fa-users me-1"></i> {{ $penulisDisplay->implode(', ') }}
                  </small>
                </td>
                <td class="text-center">{{ $item->tanggal_terbit ? $item->tanggal_terbit->format('d M Y') : '-' }}</td>
                <td class="text-center">{{ $item->jenis_karya }}</td>
                <td class="text-center">{{ $item->is_publik ? 'Ya' : 'Tidak' }}</td>
                
                <td class="text-center status-cell">
                  @if ($item->status == 'Sudah Diverifikasi')
                    <i class="fas fa-check-circle text-success" title="Sudah Diverifikasi"></i>
                  @elseif ($item->status == 'Ditolak')
                    <i class="fas fa-times-circle text-danger" title="Ditolak"></i>
                  @else
                    <i class="fas fa-question-circle text-warning" title="Belum Diverifikasi"></i>
                  @endif
                </td>

                <td class="text-center">
                  @if($item->dokumen_path)
                    <a href="{{ asset('storage/' . $item->dokumen_path) }}" target="_blank" class="btn btn-sm btn-lihat text-white">
                        Lihat
                    </a>
                  @else
                    <span>-</span>
                  @endif
                </td>

                <td class="text-center">
                  <div class="d-flex gap-2 justify-content-center">
                      <a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi Data" 
                        data-id="{{ $item->id }}" 
                        data-judul="{{ $item->judul }}">
                        <i class="fa fa-check"></i>
                      </a>
                      <a href="#" class="btn-aksi btn-lihat" title="Lihat Detail" onclick="event.preventDefault(); openDetailModal({{ $item->id }})">
                        <i class="fa fa-eye"></i>
                      </a>
                      <a href="#" class="btn-aksi btn-edit" title="Edit Data" onclick="event.preventDefault(); openEditModal({{ $item->id }})"><i class="fa fa-edit"></i></a>
                      <a href="#" class="btn-aksi btn-hapus" title="Hapus Data" data-id="{{ $item->id }}"><i class="fa fa-trash"></i></a>
                  </div>
                </td>
              </tr>
              @empty
              <tr><td colspan="8" class="text-center text-muted">Data Penelitian belum tersedia</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        {{ $penelitian->appends(request()->query())->links('pagination::bootstrap-5') }}

      </div>
    </div>
  </div>
  
  {{-- Footer --}}
      @include('layouts.footer')
    </div>
    
  {{-- Kumpulan Modal --}}
  @include('components.konfirmasi-hapus')
  @include('components.konfirmasi-berhasil')
  @include('components.konfirmasi-verifikasi')
  @include('components.penelitian.detail-penelitian')
  @include('components.penelitian.tambah-penelitian')

  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  
  <script src="{{ asset('assets/js/penelitian.js') }}"></script>
  
  <script>
    const pegawaiData = @json($pegawai->map(fn($p) => ['id' => $p->id, 'nama' => $p->nama_lengkap]));
    window.initPegawaiList(pegawaiData);

    @if (session('success'))
      document.addEventListener('DOMContentLoaded', () => {
        showSuccessModal("Berhasil!", "{{ session('success') }}");
      });
    @endif
  </script>
</body>
</html>