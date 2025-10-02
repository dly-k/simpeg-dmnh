<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SIKEMAH - Master Data</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/master-data.css') }}" />
</head>

<body>
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

            <!-- Tombol Tambah Data -->
            <div class="d-flex justify-content-end mb-3">
              <button class="btn btn-tambah fw-bold" onclick="openModal('tambahDataModal')">
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
                          <button class="btn btn-warning btn-sm" onclick="openModal('editDataModal-{{ $user->id }}')">
                              <i class="fas fa-edit"></i>
                          </button>
                          <!-- Tombol Hapus -->
                          <form action="{{ route('master-data.destroy', $user) }}" method="POST" class="d-inline">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                  <i class="fas fa-trash"></i>
                              </button>
                          </form>
                      </td>
                  </tr>
                  @empty
                  <tr>
                      <td colspan="5" class="text-center">Belum ada data pengguna.</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>

      <!-- Footer -->
      @include('layouts.footer')
    </div>
  </div>

  <!-- Modal Tambah -->
  @include('components.master-data.tambah-master-data', ['pegawais' => $pegawais])
  
  <!-- Modal Edit -->
  @foreach ($users as $user)
    @include('components.master-data.edit-master-data', ['user' => $user])
  @endforeach

  <!-- Modal Berhasil -->
  @include('components.konfirmasi-berhasil')

  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="{{ asset('assets/js/master-data.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

  @if (session('success'))
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      console.log("Showing success modal for: {{ session('success') }}");
      window.showSuccessModal("Berhasil", "{{ session('success') }}");
    });
  </script>
  @endif
</body>
</html>
