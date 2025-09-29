<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="flash-success" content="{{ session('success') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SIKEMAH - Editor Kegiatan (Pembicara)</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/pembicara.css') }}" />
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
          <span id="page-title">Editor Kegiatan - Pembicara</span>
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
                    placeholder="Cari Pembicara ...."
                  >
                </div>

                <!-- Tahun -->
                <select class="form-select" style="max-width: 160px;">
                  <option value="">Semua Tahun</option>
                  <option>2023</option>
                  <option>2024</option>
                  <option>2025</option>
                </select>

                <!-- Kategori Capaian -->
                <select class="form-select" style="max-width: 200px;">
                  <option value="">Semua Capaian</option>
                  <option>Nasional</option>
                  <option>Internasional</option>
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
                <button class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#pembicaraModal">
                  <i class="fa fa-plus me-2"></i> Tambah Data
                </button>
              </div>
            </div>
            <!-- End Filter Bar -->

            <!-- Tabel Pembicara -->
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead class="table-light">
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Kegiatan</th>
                    <th>Kategori Capaian</th>
                    <th>Kategori Pembicara</th>
                    <th>Judul Makalah</th>
                    <th>Nama Pertemuan</th>
                    <th>Tanggal Pelaksanaan</th>
                    <th>Verifikasi</th>
                    <th>Dokumen</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Dr. Andi Saputra</td>
                    <td>Seminar Nasional</td>
                    <td>Nasional</td>
                    <td>Keynote Speaker</td>
                    <td>Peran AI dalam Pendidikan</td>
                    <td>Seminar Teknologi Pendidikan</td>
                    <td>15 Jan 2024</td>
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
                        <button class="btn btn-sm btn-lihat btn-detail-pembicara"
                          data-nama="Budi Santoso"
                          data-kegiatan="Seminar Teknologi"
                          data-capaian="Internasional"
                          data-kategori="Keynote Speaker"
                          data-makalah="Tren AI dalam Dunia Industri"
                          data-pertemuan="Seminar Nasional Teknologi"
                          data-tanggal="12 Oktober 2025"
                          data-penyelenggara="Universitas IPB"
                          data-tingkat="Internasional"
                          data-bahasa="Indonesia"
                          data-litabmas="Litabmas 2025"
                          data-sertifikat="uploads/sertifikat.pdf"
                          data-sk="uploads/sk.pdf"
                        >
                          <i class="fa fa-eye"></i> 
                        </button>
                        <button 
                          class="btn btn-sm btn-warning btn-edit" 
                          data-bs-toggle="modal" 
                          data-bs-target="#editPembicaraModal"
                          data-nama="Dr. Andi Saputra"
                          data-kegiatan="Seminar Nasional"
                          data-capaian="Nasional"
                          data-kategori="utama"
                          data-judul="Peran AI dalam Pendidikan"
                          data-pertemuan="Seminar Teknologi Pendidikan"
                          data-tanggal="2024-01-15"
                          data-penyelenggara="Kemdikbud">
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
                    <td>Prof. Budi Santoso</td>
                    <td>Konferensi Internasional</td>
                    <td>Internasional</td>
                    <td>Invited Speaker</td>
                    <td>Ekonomi Digital di Era 5.0</td>
                    <td>International Conference on Economics</td>
                    <td>20 Mei 2024</td>
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
                        <button class="btn btn-sm btn-lihat btn-detail-pembicara"
                          data-nama="Budi Santoso"
                          data-kegiatan="Seminar Teknologi"
                          data-capaian="Internasional"
                          data-kategori="Keynote Speaker"
                          data-makalah="Tren AI dalam Dunia Industri"
                          data-pertemuan="Seminar Nasional Teknologi"
                          data-tanggal="12 Oktober 2025"
                          data-penyelenggara="Universitas IPB"
                          data-tingkat="Internasional"
                          data-bahasa="Indonesia"
                          data-litabmas="Litabmas 2025"
                          data-sertifikat="uploads/sertifikat.pdf"
                          data-sk="uploads/sk.pdf"
                        >
                          <i class="fa fa-eye"></i> 
                        </button>                        <button 
                          class="btn btn-sm btn-warning btn-edit" 
                          data-bs-toggle="modal" 
                          data-bs-target="#editPembicaraModal">
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
  @include('components.pembicara.detail-pembicara')
  @include('components.pembicara.tambah-pembicara')
  @include('components.pembicara.edit-pembicara')

  <!-- Scripts -->
  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="{{ asset('assets/js/pembicara.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>