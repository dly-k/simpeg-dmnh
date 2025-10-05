<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>SIKEMAH - Master Data</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/master-data.css') }}" />
</head>

<body data-success="{{ session('success') }}">
 <div class="layout">
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <div class="main-wrapper">

      <!-- Header -->
      @include('layouts.header')

      <!-- Title Bar -->
      <div class="title-bar">
        <h1>
          <i class="lni lni-database"></i>
          <span id="page-title">Master Data</span>
        </h1>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <div class="card">
          <div class="card-body p-4">

            <!-- Alert Errors -->
            @if ($errors->any())
              <div class="alert alert-danger mb-3">
                  <ul class="mb-0">
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3">
              <!-- Search -->
              <form method="GET" action="{{ route('master-data.index') }}" class="d-flex flex-grow-1 me-3">
                  <div class="input-group flex-grow-1">
                      <span class="input-group-text bg-light border-end-0">
                          <i class="fas fa-search text-success"></i>
                      </span>
                      <input type="text" 
                            class="form-control border-start-0 search-input" 
                            name="search"
                            placeholder="Cari berdasarkan Nama/ID Pengguna..."
                            value="{{ request('search') }}">
                  </div>
              </form>

              <!-- Tombol Tambah Data -->
              <button class="btn btn-tambah fw-bold flex-shrink-0" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
                <i class="fa fa-plus me-2"></i> Tambah Data
              </button>
            </div>

            <!-- Tabel Data -->
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Pegawai</th>
                    <th>ID Pengguna</th>
                    <th>Hak Akses</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($users as $index => $user)
                  <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $user->pegawai->nama_lengkap ?? 'Pegawai Telah Dihapus' }}</td>
                      <td>{{ $user->username }}</td>
                      <td>{{ $user->role }}</td>
                      <td>
                          <!-- Tombol Edit -->
                          <button class="btn btn-edit btn-sm" data-bs-toggle="modal" data-bs-target="#editDataModal-{{ $user->id }}">
                              <i class="fas fa-edit"></i>
                          </button>
                          
                          <!-- Tombol Hapus -->
                          <button type="button" class="btn btn-delete btn-sm trigger-hapus" 
                                  data-id="{{ $user->id }}" 
                                  data-nama="{{ $user->pegawai->nama_lengkap ?? 'Pegawai Telah Dihapus' }}">
                              <i class="fas fa-trash"></i>
                          </button>
                      </td>
                  </tr>
                  @empty
                  <tr>
                      <td colspan="5" class="text-center">Belum ada data pengguna.</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>

            <!-- Pagination -->
            {{ $users->appends(request()->all())->links('pagination::bootstrap-5') }}
            </div>

          </div>
        </div>
      </div>

      <!-- Footer -->
      @include('layouts.footer')
    </div>
  </div>

  <!-- Konfirmasi Modal -->
  <form class="d-none" id="hapusForm" method="POST">
      @csrf
      @method('DELETE')
  </form>
  @include('components.konfirmasi-hapus')
  @include('components.konfirmasi-berhasil')
  @include('components.master-data.tambah-master-data', ['pegawais' => $pegawais])
  @foreach ($users as $user)
    @include('components.master-data.edit-master-data', ['user' => $user])
  @endforeach

  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="{{ asset('assets/js/master-data.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>