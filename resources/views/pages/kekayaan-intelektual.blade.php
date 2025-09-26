<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="flash-success" content="{{ session('success') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SIKEMAH - Editor Kegiatan (Kekayaan Intelektual)</title>

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
          <span id="page-title">Editor - Kekayaan Intelektual</span>
        </h1>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <div class="card">
          <div class="card-body p-4">

            <!-- Filter Bar -->
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
              <div class="d-flex flex-grow-1 gap-2">
                <!-- Search -->
                <div class="input-group flex-grow-1">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-search text-success"></i>
                  </span>
                  <input 
                    type="text" 
                    class="form-control border-start-0 search-input" 
                    placeholder="Cari Data ...."
                  >
                </div>

                <!-- Tahun -->
                <select class="form-select" style="max-width: 160px;">
                  <option value="">Semua Tahun</option>
                  <option>2023</option>
                  <option>2024</option>
                  <option>2025</option>
                </select>
              </div>

              <!-- Button Tambah Data -->
              <div>
                <button class="btn btn-tambah fw-bold">
                  <i class="fa fa-plus me-2"></i> Tambah Data
                </button>
              </div>
            </div>
            <!-- End Filter Bar -->

            <!-- Tabs -->
            <ul class="nav nav-tabs mb-4" id="kekayaan-intelektual-tab" role="tablist">
              <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#hak-cipta">Hak Cipta</button></li>
              <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#paten">Paten</button></li>
              <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#merek">Merek</button></li>
              <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#varietas">Varietas</button></li>
              <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#desain-industri">Desain Industri</button></li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content">
              
              <!-- Hak Cipta -->
              <div class="tab-pane fade show active" id="hak-cipta">
                <div class="table-responsive p-3">
                  <table class="table table-hover table-bordered">
                    <thead class="table-light">
                      <tr>
                        <th>No</th>
                        <th>Judul Ciptaan</th>
                        <th>Jenis Ciptaan</th>
                        <th>Nomor Permohonan</th>
                        <th>Tanggal Permohonan</th>
                        <th>Status Permohonan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>Sistem Informasi Akademik</td>
                        <td>Program Komputer</td>
                        <td>HC12345</td>
                        <td>12 Jan 2023</td>
                        <td>Disetujui</td>
                        <td>
                          <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-sm btn-edit"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-sm btn-hapus"><i class="fa fa-trash"></i></button>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <!-- Paten -->
              <div class="tab-pane fade" id="paten">
                <div class="table-responsive p-3">
                  <table class="table table-hover table-bordered">
                    <thead class="table-light">
                      <tr>
                        <th>No</th>
                        <th>Judul Invensi</th>
                        <th>Nomor Pendaftaran</th>
                        <th>Tanggal Pendaftaran</th>
                        <th>Status Permohonan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>Mesin Pendingin Ramah Lingkungan</td>
                        <td>IDP123456</td>
                        <td>20 Feb 2022</td>
                        <td>Proses</td>
                        <td>
                          <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-sm btn-edit"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-sm btn-hapus"><i class="fa fa-trash"></i></button>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <!-- Merek -->
              <div class="tab-pane fade" id="merek">
                <div class="table-responsive p-3">
                  <table class="table table-hover table-bordered">
                    <thead class="table-light">
                      <tr>
                        <th>No</th>
                        <th>Nama Merek</th>
                        <th>Kelas Merek</th>
                        <th>Nomor Pendaftaran</th>
                        <th>Tanggal Pendaftaran</th>
                        <th>Status Permohonan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>SIKEMAH</td>
                        <td>42</td>
                        <td>MRK78910</td>
                        <td>20 Mar 2023</td>
                        <td>Disetujui</td>
                        <td>
                          <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-sm btn-edit"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-sm btn-hapus"><i class="fa fa-trash"></i></button>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

<!-- Varietas -->
<div class="tab-pane fade" id="varietas">
  <div class="p-3">

    <!-- Tabel Pendaftaran -->
    <div class="varietas-section">
      <h6 class="section-title">Pendaftaran</h6>
      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead class="table-light">
            <tr>
              <th>No</th>
              <th>Nama Varietas</th>
              <th>Tanggal Pendaftaran</th>
              <th>Nomor Pendaftaran</th>
              <th>Status Permohonan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Padi Unggul A</td>
              <td>15 Jan 2022</td>
              <td>VAR12345</td>
              <td>Disetujui</td>
              <td>
                <div class="d-flex justify-content-center gap-2">
                  <button class="btn btn-sm btn-edit"><i class="fa fa-edit"></i></button>
                  <button class="btn btn-sm btn-hapus"><i class="fa fa-trash"></i></button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

                    <!-- Tabel Perlindungan -->
                    <div class="varietas-section">
                    <h6 class="section-title">Perlindungan</h6>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                            <th>No</th>
                            <th>Nama Varietas</th>
                            <th>Tanggal Pendaftaran</th>
                            <th>Nomor Pendaftaran</th>
                            <th>Status Permohonan</th>
                            <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td>1</td>
                            <td>Padi Unggul B</td>
                            <td>05 Apr 2021</td>
                            <td>VAR67890</td>
                            <td>Proses</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-sm btn-edit"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-sm btn-hapus"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    </div>

                    <!-- Tabel Pelepasan -->
                    <div class="varietas-section">
                    <h6 class="section-title">Pelepasan</h6>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                            <th>No</th>
                            <th>Nama Varietas</th>
                            <th>Tanggal Pelepasan</th>
                            <th>Nomor Pelepasan</th>
                            <th>Status Permohonan</th>
                            <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td>1</td>
                            <td>Padi Unggul C</td>
                            <td>12 Agu 2020</td>
                            <td>PLS54321</td>
                            <td>Disetujui</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-sm btn-edit"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-sm btn-hapus"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    </div>

                </div>
                </div>


              <!-- Desain Industri -->
              <div class="tab-pane fade" id="desain-industri">
                <div class="table-responsive p-3">
                  <table class="table table-hover table-bordered">
                    <thead class="table-light">
                      <tr>
                        <th>No</th>
                        <th>Nama Desain</th>
                        <th>Klasifikasi Locarno</th>
                        <th>Nomor Pendaftaran</th>
                        <th>Tanggal Pendaftaran</th>
                        <th>Status Permohonan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>Kursi Ergonomis</td>
                        <td>06-01</td>
                        <td>DSN54321</td>
                        <td>05 Apr 2022</td>
                        <td>Proses</td>
                        <td>
                          <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-sm btn-edit"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-sm btn-hapus"><i class="fa fa-trash"></i></button>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

            </div>
            <!-- End Tab Content -->

          </div>
        </div>
      </div>

      @include('layouts.footer')
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<style>
    /* Kasih jarak antar tab */
.nav-tabs .nav-link {
  margin-right: 8px;  /* bisa diubah jadi 10px atau 12px sesuai selera */
}

/* Tab aktif */
.nav-tabs .nav-item.show .nav-link, 
.nav-tabs .nav-link.active {
  color: #fff !important;
  background-color: #198754 !important;   /* hijau sama dengan sidebar */
  border-color: #198754 #198754 #fff !important;
  font-weight: 600;
}

/* Tab non aktif */
.nav-tabs .nav-link {
  color: #198754 !important;
  border: 1px solid transparent;
}

/* Hover tab non aktif */
.nav-tabs .nav-link:hover {
  color: #fff !important;
  background-color: #198754 !important;
  border-color: #198754 #198754 #fff !important;
}

/* Section khusus untuk tabel Varietas */
.varietas-section {
  padding: 16px;
  margin-bottom: 20px;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  background-color: #fafafa;
}

/* Judul tiap section di Varietas */
.section-title {
  font-size: 1rem;
  font-weight: 600;
  color: #198754;
  margin-bottom: 12px;
  padding-left: 8px;
}
</style>