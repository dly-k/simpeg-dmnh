<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="flash-success" content="{{ session('success') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SIKEMAH - Editor Kegiatan (Orasi Ilmiah)</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/orasi-ilmiah.css') }}" />
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
          <span id="page-title">Editor Kegiatan - Orasi Ilmiah</span>
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
                    placeholder="Cari Orasi Ilmiah ...."
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
                <button class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#orasiIlmiahModal">
                  <i class="fa fa-plus me-2"></i> Tambah Data
                </button>
              </div>
            </div>
            <!-- End Filter Bar -->

            <!-- Tabel Orasi Ilmiah -->
            <div class="table-responsive">
              <table class="table table-hover table-bordered align-middle">
                <thead class="table-light text-center">
                  <tr>
                    <th>No</th>
                    <th>Pegawai</th>
                    <th>Kategori Pembicara</th>
                    <th>Judul Makalah</th>
                    <th>Nama Pertemuan</th>
                    <th>Tingkat Pertemuan</th>
                    <th>Penyelenggara</th>
                    <th>Tanggal Pelaksanaan</th>
                    <th>Bahasa</th>
                    <th>Verifikasi</th>
                    <th>Dokumen</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  <tr>
                    <td>1</td>
                    <td class="text-start">Dr. Ahmad</td>
                    <td>Narasumber Utama</td>
                    <td>Inovasi Pendidikan di Era Digital</td>
                    <td>Seminar Nasional Pendidikan</td>
                    <td>Nasional</td>
                    <td>Universitas Negeri</td>
                    <td>12-05-2024</td>
                    <td>Indonesia</td>
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
                    <td class="text-center">
                      <div class="d-flex justify-content-center gap-2">
                        <a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi">
                          <i class="fa fa-check"></i>
                        </a>
                        <button class="btn btn-sm btn-lihat" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalDetailOrasiIlmiah"
                                data-pegawai="Budi Santoso"
                                data-judul="Makalah Tentang AI"
                                data-pertemuan="Seminar Nasional AI"
                                data-penyelenggara="Universitas X"
                                data-tanggal="2025-10-01"
                                data-bahasa="Indonesia"
                                data-jenis-dokumen="Sertifikat"
                                data-nama-dokumen="Sertifikat AI"
                                data-nomor-dokumen="123/AI/2025"
                                data-tautan="https://drive.google.com/xxxxx"
                                data-dokumen-src="/uploads/dokumen_ai.pdf">
                          <i class="fas fa-eye"></i>
                        </button>
                        <button 
                          class="btn btn-sm btn-warning btn-edit" 
                          data-bs-toggle="modal" 
                          data-bs-target="#editOrasiIlmiahModal">
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
                    <td class="text-start">Prof. Siti</td>
                    <td>Pembicara Undangan</td>
                    <td>Strategi Riset Multidisiplin</td>
                    <td>International Conference on Research</td>
                    <td>Internasional</td>
                    <td>ICR Organizing Committee</td>
                    <td>20-08-2023</td>
                    <td>Inggris</td>
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
                    <td class="text-center">
                      <div class="d-flex justify-content-center gap-2">
                        <a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi">
                          <i class="fa fa-check"></i>
                        </a>
                        <!-- Tombol dengan data attribute -->
                        <button class="btn btn-sm btn-lihat" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalDetailOrasiIlmiah"
                                data-pegawai="Budi Santoso"
                                data-litabmas="LIT123"
                                data-kategori="Pembicara Kunci"
                                data-lingkup="Nasional"
                                data-judul="Makalah Tentang AI"
                                data-pertemuan="Seminar Nasional AI"
                                data-penyelenggara="Universitas X"
                                data-tanggal="2025-10-01"
                                data-bahasa="Indonesia"
                                data-jenis-dokumen="Sertifikat"
                                data-nama-dokumen="Sertifikat AI"
                                data-nomor-dokumen="123/AI/2025"
                                data-tautan="https://drive.google.com/xxxxx"
                                data-dokumen-src="/uploads/dokumen_ai.pdf">
                          <i class="fas fa-eye"></i>
                        </button>

                        <button 
                          class="btn btn-sm btn-warning btn-edit" 
                          data-bs-toggle="modal" 
                          data-bs-target="#editOrasiIlmiahModal">
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
    @include('components.orasi-ilmiah.detail-orasi-ilmiah')
  @include('components.orasi-ilmiah.tambah-orasi-ilmiah')
  @include('components.orasi-ilmiah.edit-orasi-ilmiah')

  <!-- Scripts -->
  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="{{ asset('assets/js/orasi-ilmiah.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>