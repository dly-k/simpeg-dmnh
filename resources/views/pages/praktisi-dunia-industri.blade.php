<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="flash-success" content="{{ session('success') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SIKEMAH - Editor (Praktisi Dunia Industri)</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/praktisi.css') }}" />
</head>

<body data-success-sound="{{ asset('assets/sounds/Success.mp3') }}">
  <div class="layout">
    @include('layouts.sidebar')

    <div class="main-wrapper">
      @include('layouts.header')

      <!-- Title Bar -->
      <div class="title-bar">
        <h1>
          <i class="lni lni-write"></i>
          <span id="page-title">Editor - Praktisi Dunia Industri</span>
        </h1>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <div class="card">
          <div class="card-body p-4">

            <!-- Filter Bar -->
<div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
  <div class="d-flex flex-grow-1 gap-2">
    <div class="input-group flex-grow-1">
      <span class="input-group-text bg-light border-end-0">
        <i class="fas fa-search text-success"></i>
      </span>
      <input 
        type="text" 
        id="searchInput" {{-- ID ditambahkan --}}
        class="form-control border-start-0 search-input" 
        placeholder="Cari Nama/Institusi ...."
        value="{{ request('search') }}"
      >
    </div>

    <select class="form-select" id="semesterFilter" style="max-width: 200px;"> {{-- ID diubah --}}
      <option value="">Semua Semester</option>
      @foreach($semesterOptions as $value => $label)
        <option value="{{ $value }}" {{ request('semester') == $value ? 'selected' : '' }}>{{ $label }}</option>
      @endforeach
    </select>

    <select class="form-select" id="statusFilter" style="max-width: 180px;"> {{-- ID ditambahkan --}}
        <option value="">Semua Status</option>
        <option value="Sudah Diverifikasi" {{ request('status') == 'Sudah Diverifikasi' ? 'selected' : '' }}>Sudah Diverifikasi</option>
        <option value="Belum Diverifikasi" {{ request('status') == 'Belum Diverifikasi' ? 'selected' : '' }}>Belum Diverifikasi</option>
        <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
    </select>
  </div>

  <div>
    <button class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#pengalamanKerjaModal">
    <i class="fa fa-plus me-2"></i> Tambah Data
    </button>
  </div>
</div>
            <!-- End Filter Bar -->

            <!-- Tabel Praktisi Dunia Industri -->
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead class="table-light">
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Institusi</th>
                    <th>Jenis Pekerjaan</th>
                    <th>TMT</th>
                    <th>TST</th>
                    <th>Surat Tugas</th>
                    <th>Verifikasi</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
<tbody>
  @forelse ($praktisis as $index => $praktisi)
  <tr>
    <td>{{ $praktisis->firstItem() + $index }}</td>
    <td>{{ $praktisi->pegawai->nama_lengkap ?? 'Pegawai Tidak Ditemukan' }}</td>
    <td>{{ $praktisi->instansi }}</td>
    <td>{{ $praktisi->jenis_pekerjaan }}</td>
    <td>{{ \Carbon\Carbon::parse($praktisi->tmt)->isoFormat('DD MMM YYYY') }}</td>
    <td>{{ \Carbon\Carbon::parse($praktisi->tst)->isoFormat('DD MMM YYYY') }}</td>
    <td>
      @if ($praktisi->surat_instansi)
        <a href="{{ asset('storage/' . $praktisi->surat_instansi) }}" target="_blank" class="btn btn-sm btn-lihat text-white px-3">Lihat</a>
      @else
        <span class="text-muted fst-italic">Tidak Ada</span>
      @endif
    </td>
    <td>
      @if($praktisi->status == 'Belum Diverifikasi')
        <span class="badge rounded-circle bg-warning text-white" title="Belum Diverifikasi">
          <i class="fa fa-question"></i>
        </span>
      @elseif($praktisi->status == 'Sudah Diverifikasi')
        <span class="badge rounded-circle bg-success text-white" title="Sudah Diverifikasi">
          <i class="fa fa-check"></i>
        </span>
      @else
        <span class="badge rounded-circle bg-danger text-white" title="Ditolak">
          <i class="fa fa-times"></i>
        </span>
      @endif
    </td>
    <td>
      <div class="d-flex gap-2">
            <button
                class="btn-aksi btn-verifikasi"
                title="Verifikasi"
                data-url="{{ route('praktisi.verify', $praktisi->id) }}">
                <i class="fa fa-check"></i>
            </button>
            <button
                class="btn btn-sm btn-lihat"
                data-bs-toggle="modal"
                data-bs-target="#detailPraktisiModal"
                data-url="{{ route('praktisi.show', $praktisi->id) }}">
                <i class="fa fa-eye"></i>
            </button>
        <button
            class="btn btn-sm btn-warning btn-edit"
            data-bs-toggle="modal"
            data-bs-target="#editPengalamanKerjaModal"
            data-id="{{ $praktisi->id }}"
            data-url="{{ route('praktisi.show', $praktisi->id) }}"
            data-update-url="{{ route('praktisi.update', $praktisi->id) }}">
            <i class="fa fa-edit"></i>
        </button>
        <button 
            class="btn-aksi btn-hapus btn-hapus-data" 
            title="Hapus Data"
            data-url="{{ route('praktisi.destroy', $praktisi->id) }}">
            <i class="fa fa-trash"></i>
        </button>
      </div>
    </td>
  </tr>
  @empty
  <tr>
    <td colspan="9" class="text-center">Belum ada data praktisi.</td>
  </tr>
  @endforelse
</tbody>
<div class="d-flex justify-content-end mt-3">
    {{ $praktisis->links() }}
</div>
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
  @include('components.praktisi.detail-praktisiindustri')
  @include('components.praktisi.tambah-praktisiindustri', ['pegawais' => $pegawais])
  @include('components.praktisi.edit-praktisiindustri', ['pegawais' => $pegawais])

{{-- ... (kode lainnya) ... --}}
  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="{{ asset('assets/js/praktisi.js') }}"></script> {{-- File ini hanya untuk modal sukses --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  
  {{-- Pindahkan script untuk error validasi ke sini --}}
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      @if($errors->any())
        const errorModalElement = document.getElementById('pengalamanKerjaModal');
        if (errorModalElement) {
            const errorModal = new bootstrap.Modal(errorModalElement);
            errorModal.show();
        }
      @endif
    });
  </script>
</body>
</html>