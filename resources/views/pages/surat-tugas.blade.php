<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SIKEMAH - Manajemen Surat Tugas</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/surat-tugas.css') }}" />
</head>
<body>
  <div class="layout">

    <!-- ================= Sidebar ================= -->
    @include('layouts.sidebar')

    <div class="main-wrapper">

      <!-- ================= Header ================= -->
      @include('layouts.header')

      <!-- ================= Title Bar ================= -->
      <div class="title-bar">
        <h1>
          <i class="lni lni-folder"></i>
          <span id="page-title">Manajemen Surat Tugas</span>
        </h1>
      </div>

      <!-- ================= Main Content ================= -->
      <div class="main-content">
        <div class="table-card">

          <!-- ================= Toolbar ================= -->
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div class="d-flex align-items-center flex-wrap gap-2 flex-grow-1">

              <!-- Search -->
              <div class="search-group flex-grow-1">
                <div class="input-group search-box bg-white">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-search search-icon"></i>
                  </span>
                  <input type="text" class="form-control border-start-0 search-input" placeholder="Cari Data..." />
                </div>
              </div>

              <!-- Filter Semester -->
              <div>
                <select id="filterSemester" class="form-select filter-select">
                  <option value="all" selected>Semua Semester</option>
                  <option value="2021-genap">Semester Genap 2021</option>
                  <option value="2021-ganjil">Semester Ganjil 2021</option>
                  <option value="2022-genap">Semester Genap 2022</option>
                  <option value="2022-ganjil">Semester Ganjil 2022</option>
                  <option value="2023-genap">Semester Genap 2023</option>
                  <option value="2023-ganjil">Semester Ganjil 2023</option>
                </select>
              </div>

              <!-- Actions -->
              <div class="d-flex gap-2">
                <a href="#" class="btn btn-export fw-bold">
                  <i class="fa fa-file-excel me-2"></i> Export Excel
                </a>
                <a href="#" class="btn btn-tambah fw-bold" onclick="openModal('suratTugasModal')">
                  <i class="fa fa-plus me-2"></i> Tambah Data
                </a>
              </div>
            </div>
          </div>

          <!-- ================= Table ================= -->
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
                  <th>Ket. Lokasi</th>
                  <th>Dokumen</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="data-body"></tbody>
            </table>
          </div>

          <!-- ================= Pagination ================= -->
          <div class="d-flex justify-content-between align-items-center mt-3">
            <span class="text-muted small">Menampilkan 3 dari 13 data</span>
            <nav aria-label="Page navigation">
              <ul class="pagination pagination-sm mb-0">
                <li class="page-item disabled">
                  <a class="page-link" href="#">Sebelumnya</a>
                </li>
                <li class="page-item active">
                  <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#">Berikutnya</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>

      <!-- ================= Footer ================= -->
      @include('layouts.footer')
    </div>

    <!-- ================= Modals ================= -->
    @include('components.konfirmasi-hapus')
    @include('components.konfirmasi-berhasil')
    @include('components.tambah-surat-tugas')
  </div>

  <!-- ================= Scripts ================= -->
  <script src="{{ asset('assets/js/surat-tugas.js') }}"></script>
  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>