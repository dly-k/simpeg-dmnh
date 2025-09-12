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
        <div class="d-flex justify-content-end mb-3">
          <button class="btn btn-tambah fw-bold" onclick="openModal('tambahDataModal')">
            <i class="fa fa-plus me-2"></i> Tambah Data
          </button>
        </div>

        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Pegawai</th>
                <th>ID Pengguna</th>
                <th>Password</th>
                <th>Hak Akses</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody id="userDataBody"></tbody>
          </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
          <span class="text-muted small">Menampilkan 1 sampai 4 dari 13 data</span>
          <nav>
            <ul class="pagination pagination-sm mb-0">
              <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">Berikutnya</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>

      <!-- Footer -->
      @include('layouts.footer')
    </div>

  <!-- Modals -->
  @include('components.konfirmasi-hapus')
  @include('components.konfirmasi-berhasil')
  @include('components.master-data.tambah-master-data')

  <!-- Scripts -->
  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="{{ asset('assets/js/master-data.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>