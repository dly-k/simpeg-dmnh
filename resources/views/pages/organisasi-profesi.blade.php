<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="flash-success" content="{{ session('success') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SIKEMAH - Editor Kegiatan (Organisasi Profesi)</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/praktisi.css') }}" />
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
          <span id="page-title">Editor Kegiatan - Organisasi Profesi</span>
        </h1>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <div class="card">
          <div class="card-body p-4">

            <!-- Filter Bar -->
            <div class="d-flex flex-wrap align-items-center mb-3 gap-2">
              <div class="d-flex flex-grow-1 gap-2">
                <!-- Search -->
                <div class="input-group flex-grow-1">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-search text-success"></i>
                  </span>
                  <input 
                    type="text" 
                    class="form-control border-start-0 search-input" 
                    placeholder="Cari Organisasi Profesi ...."
                  >
                </div>

                <!-- Tahun -->
                <select class="form-select" style="max-width: 160px;">
                  <option value="">Semua Tahun</option>
                  <option>2023</option>
                  <option>2024</option>
                  <option>2025</option>
                </select>

                <!-- Status -->
                <select class="form-select" style="max-width: 180px;">
                  <option value="">Semua Status</option>
                  <option>Sudah Diverifikasi</option>
                  <option>Belum Diverifikasi</option>
                  <option>Ditolak</option>
                </select>
              </div>

              <!-- Right: Button Tambah Data -->
              <div class="ms-auto">
                <button class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#tambahOrganisasiModal">
                  <i class="fa fa-plus me-2"></i> Tambah Data
                </button>
              </div>
            </div>
            <!-- End Filter Bar -->

            <!-- Tabel Organisasi Profesi -->
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead class="table-light">
                  <tr>
                    <th>No</th>
                    <th>Kegiatan</th>
                    <th>Dosen</th>
                    <th>Asosiasi Profesi</th>
                    <th>Posisi</th>
                    <th>Nomor Anggota</th>
                    <th>Tahun Terdaftar</th>
                    <th>Selesai Keanggotaan</th>
                    <th>Verifikasi</th>
                    <th>Dokumen</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Rapat Tahunan</td>
                    <td>Dr. Andi Saputra</td>
                    <td>Ikatan Dokter Indonesia</td>
                    <td>Anggota</td>
                    <td>ID-2023-001</td>
                    <td>2020</td>
                    <td>2025</td>
                    <td>
                      <span class="badge rounded-circle bg-warning text-white" title="Belum Diverifikasi">
                        <i class="fa fa-question"></i>
                      </span>
                    </td>
                    <td>
                      <a href="{{ asset('uploads/bahan-ajar/web-dasar.pdf') }}" 
                         class="btn btn-sm btn-lihat" target="_blank">Lihat
                      </a>
                    </td>
                    <td>
                      <div class="d-flex gap-2">
                        <a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi">
                          <i class="fa fa-check"></i>
                        </a>
                        <button class="btn btn-sm btn-lihat"><i class="fa fa-eye"></i></button>
                        <button 
                          class="btn btn-sm btn-warning btn-edit" 
                          data-bs-toggle="modal" 
                          data-bs-target="#editOrganisasiModal">
                          <i class="fa fa-edit"></i>
                        </button>
                        <a href="#" class="btn-aksi btn-hapus" title="Hapus Data">
                          <i class="fa fa-trash"></i>
                        </a>
                      </div>
                    </td>
                  </tr>

                  <tr>
                    <td>2</td>
                    <td>Workshop Internasional</td>
                    <td>Prof. Budi Santoso</td>
                    <td>Asosiasi Ekonomi Dunia</td>
                    <td>Pengurus</td>
                    <td>AE-2022-045</td>
                    <td>2022</td>
                    <td>2026</td>
                    <td>
                      <span class="badge rounded-circle bg-success text-white" title="Sudah Diverifikasi">
                        <i class="fa fa-check"></i>
                      </span>
                    </td>
                    <td>
                      <a href="{{ asset('uploads/bahan-ajar/web-dasar.pdf') }}" 
                         class="btn btn-sm btn-lihat" target="_blank">Lihat
                      </a>
                    </td>
                    <td>
                      <div class="d-flex gap-2">
                        <a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi">
                          <i class="fa fa-check"></i>
                        </a>
                        <button class="btn btn-sm btn-lihat"><i class="fa fa-eye"></i></button>
                        <button 
                          class="btn btn-sm btn-warning btn-edit" 
                          data-bs-toggle="modal" 
                          data-bs-target="#editOrganisasiModal">
                          <i class="fa fa-edit"></i>
                        </button>
                        <a href="#" class="btn-aksi btn-hapus" title="Hapus Data">
                          <i class="fa fa-trash"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                </tbody>
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
  {{-- @include('components.konfirmasi-hapus') --}}
  {{-- @include('components.konfirmasi-berhasil') --}}
  {{-- @include('components.konfirmasi-verifikasi') --}}

  <!-- Scripts -->
  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="{{ asset('assets/js/praktisi.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>