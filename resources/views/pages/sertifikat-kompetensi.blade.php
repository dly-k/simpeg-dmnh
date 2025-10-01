<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="flash-success" content="{{ session('success') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SIKEMAH - Editor Kegiatan (Sertifikat Kompetensi)</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/sertifikat-kompetensi.css') }}" />
</head>

<body>
  <div class="layout">
    @include('layouts.sidebar')

    <div class="main-wrapper">
      @include('layouts.header')

      <!-- Title Bar -->
      <div class="title-bar">
        <h1>
          <i class="lni lni-certificate"></i>
          <span id="page-title">Editor Kegiatan - Sertifikat Kompetensi</span>
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
                    placeholder="Cari Sertifikat Kompetensi ...."
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
                <button class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#sertifikatKompetensiModal">
                  <i class="fa fa-plus me-2"></i> Tambah Data
                </button>
              </div>
            </div>
            <!-- End Filter Bar -->

            <!-- Tabel Sertifikat Kompetensi -->
            <div class="table-responsive">
              <table class="table table-hover table-bordered align-middle">
                <thead class="table-light text-center">
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Kegiatan</th>
                    <th>Judul Kegiatan</th>
                    <th>Lembaga Sertifikasi</th>
                    <th>Tahun</th>
                    <th>Verifikasi</th>
                    <th>Dokumen</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  <tr>
                    <td>1</td>
                    <td class="text-start">Budi Santoso</td>
                    <td>Pelatihan Digital Marketing</td>
                    <td>Strategi Pemasaran Online</td>
                    <td>BNSP</td>
                    <td>2024</td>
                    <td>
                      <span class="badge rounded-circle bg-warning text-white" title="Belum Diverifikasi">
                        <i class="fa fa-question"></i>
                      </span>
                    </td>
                    <td><a href="#" class="btn btn-sm btn-lihat">Lihat</a></td>
                    <td class="text-center">
                      <div class="d-flex justify-content-center gap-2">
                        <a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi">
                          <i class="fa fa-check"></i>
                        </a>
                     <button class="btn btn-sm btn-lihat"
                                data-bs-toggle="modal"
                                data-bs-target="#modalDetailSertifikatKompetensi"

                                data-nama="Pegawai 1"
                                data-kegiatan="Memperoleh sertifikat Kompetensi"
                                data-judul="Pelatihan AI Tingkat Lanjut"
                                data-no-reg="998877"
                                data-no-sk="19900-999-0001"
                                data-tahun="2025"
                                data-tmt="2025-01-01"
                                data-tst="2028-01-01"
                                data-bidang="Ilmu Komputer"
                                data-lembaga="Badan Nasional Sertifikasi Profesi"
                                data-dokumen="/uploads/sertifikat_ai.pdf">
                          <i class="fas fa-eye"></i> 
                        </button>
                        <button 
                          class="btn btn-sm btn-warning btn-edit" 
                          data-bs-toggle="modal" 
                          data-bs-target="#editSertifikatKompetensiModal">
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
                    <td class="text-start">Siti Aminah</td>
                    <td>Pelatihan Data Science</td>
                    <td>Machine Learning Fundamentals</td>
                    <td>Google Certification</td>
                    <td>2023</td>
                    <td>
                      <span class="badge rounded-circle bg-success text-white" title="Sudah Diverifikasi">
                        <i class="fa fa-check"></i>
                      </span>
                    </td>
                    <td><a href="#" class="btn btn-sm btn-lihat">Lihat</a></td>
                    <td class="text-center">
                      <div class="d-flex justify-content-center gap-2">
                        <a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi">
                          <i class="fa fa-check"></i>
                        </a>
                        <button class="btn btn-sm btn-lihat"
                                data-bs-toggle="modal"
                                data-bs-target="#modalDetailSertifikatKompetensi"

                                data-nama="Pegawai 1"
                                data-kegiatan="Memperoleh sertifikat Kompetensi"
                                data-judul="Pelatihan AI Tingkat Lanjut"
                                data-no-reg="998877"
                                data-no-sk="19900-999-0001"
                                data-tahun="2025"
                                data-tmt="2025-01-01"
                                data-tst="2028-01-01"
                                data-bidang="Ilmu Komputer"
                                data-lembaga="Badan Nasional Sertifikasi Profesi"
                                data-dokumen="/uploads/sertifikat_ai.pdf">
                          <i class="fas fa-eye"></i> 
                        </button>
                        <button 
                          class="btn btn-sm btn-warning btn-edit" 
                          data-bs-toggle="modal" 
                          data-bs-target="#editSertifikatKompetensiModal">
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
    @include('components.sertifikat-kompetensi.detail-sertifikat-kompetensi')
    @include('components.sertifikat-kompetensi.tambah-sertifikat-kompetensi')
    @include('components.sertifikat-kompetensi.edit-sertifikat-kompetensi')


  <!-- Scripts -->
  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="{{ asset('assets/js/sertifikat-kompetensi.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>