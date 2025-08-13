<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>SIKEMAH - Editor Kegiatan (Penghargaan)</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/penghargaan.css') }}" />
</head>

<body>
  <div class="sidebar" id="sidebar">
    <div class="brand">SI<span>KEMAH</span></div>
    <div class="menu-wrapper">
      <div class="menu">
        <a href="/dashboard" aria-label="Dashboard"><i class="lni lni-grid-alt"></i> Dashboard</a>
        <p>Menu Utama</p>
        <a href="/daftar-pegawai" aria-label="Daftar Pegawai"><i class="lni lni-users"></i> Daftar Pegawai</a>
        <a href="/surat-tugas" aria-label="Manajemen Surat Tugas"><i class="lni lni-folder"></i> Manajemen Surat Tugas</a>
        <button class="active" data-bs-toggle="collapse" data-bs-target="#editorKegiatan" aria-expanded="true" aria-controls="editorKegiatan">
          <i class="lni lni-pencil-alt"></i> Editor Kegiatan
          <i class="lni lni-chevron-down toggle-icon"></i>
        </button>
        <div class="collapse show submenu" id="editorKegiatan">
          <a href="/pendidikan" aria-label="Pendidikan">Pendidikan</a>
          <a href="/penelitian" aria-label="Penelitian">Penelitian</a>
          <a href="/pengabdian" aria-label="Pengabdian">Pengabdian</a>
          <a href="/penunjang" aria-label="Penunjang">Penunjang</a>
          <a href="/pelatihan" aria-label="Pelatihan">Pelatihan</a>
          <a href="/penghargaan" aria-label="Penghargaan" class="active">Penghargaan</a>
          <a href="/sk-non-pns" aria-label="SK Non PNS">SK Non PNS</a>
        </div>
        <a href="/kerjasama" aria-label="Kerjasama"><i class="lni lni-handshake"></i> Kerjasama</a>
        <a href="/master-data" aria-label="Master Data"><i class="lni lni-database"></i> Master Data</a>
      </div>
    </div>
  </div>

  <div class="overlay" id="overlay"></div>

  <div class="navbar-custom">
    <div class="d-flex align-items: center">
      <button class="btn btn-link text-dark me-3" id="toggleSidebar" aria-label="Toggle Sidebar">
        <i class="lni lni-menu"></i>
      </button>
    </div>
    <div class="d-flex align-items: center">
      <div class="time-date me-2">
        <div><i class="lni lni-calendar"></i> <span id="current-date"></span></div>
        <div><i class="lni lni-timer"></i> <span id="current-time"></span></div>
      </div>
      <div class="dropdown">
        <a href="#" class="account text-decoration-none text-dark" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="icon-circle"><i class="lni lni-user"></i></span>
          <span>Halo, Ketua TU</span>
          <i class="lni lni-chevron-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow">
          <li>
            <a class="dropdown-item d-flex align-items-center" href="/ubah-password">
              <i class="lni lni-key me-2"></i> Ubah Password
            </a>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item d-flex align-items-center dropdown-item-danger" href="/logout">
              <i class="lni lni-exit me-2"></i> Keluar
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="title-bar">
    <h1><i class="lni lni-pencil-alt"></i> <span id="page-title">Editor Kegiatan - Penghargaan</span></h1>
  </div>

  <div class="main-content">
      <div class="card">
          <div class="search-filter-container">
            <div class="search-filter-row">
                <div class="search-box">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search" style="color: green;"></i></span>
                        <input type="text" class="form-control border-start-0 search-input" placeholder="Cari Data ....">
                    </div>
                </div>
                <select class="form-select filter-select"><option selected>Tahun</option><option>2023</option></select>
                                <!-- Dropdown Lingkup -->
                <select class="form-select" style="width: 140px;">
                  <option selected>Lingkup</option>
                  <option>Internasional</option>
                  <option>Nasional</option>
                  <option>Lokal</option>
                </select>
                <a href="#" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#penghargaanModal">
                    <i class="fa fa-plus me-2"></i> Tambah Data
                </a>
            </div>
          </div>

<div class="table-responsive">
    <table class="table table-hover table-bordered">
        <thead class="table-light">
            <tr class="text-center">
                <th>No</th>
                <th class="text-start">Nama Kegiatan</th>
                <th>Unit</th>
                <th>Nomor</th>
                <th>Penghargaan</th>
                <th>Lingkup</th>
                <th>Tahun</th>
                <th>Dokumen</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="penghargaan-table-body"> {{-- Tambahkan ID untuk target JavaScript --}}
            @php
                // Contoh data dinamis. Idealnya, variabel ini dikirim dari Controller.
                $dataPenghargaan = collect(json_decode('[
                    {"id": 1, "nama_kegiatan": "Inovasi Pembibitan Lele", "unit": "Fakultas Perikanan", "nomor": "SK-123/FP/2023", "penghargaan": "Dosen Inovatif", "lingkup": "Nasional", "tahun": "2023", "pegawai": "Dr. Stone Pamungkas", "tanggal_perolehan": "2023-11-20", "negara": "Indonesia", "instansi": "Kementerian Kelautan", "jenis_dokumen": "Sertifikat", "nama_dokumen": "Sertifikat Dosen Inovatif 2023", "nomor_dokumen": "SERT-001", "tautan": "https://sertifikat.id/001", "dokumen_path": "assets/pdf/example.pdf"},
                    {"id": 2, "nama_kegiatan": "Pengabdian Masyarakat Desa Ciaruteun", "unit": "LPPM", "nomor": "LPPM-456/PM/2024", "penghargaan": "Pengabdi Terbaik", "lingkup": "Kabupaten", "tahun": "2024", "pegawai": "Senam Lele Merdeka", "tanggal_perolehan": "2024-05-10", "negara": "Indonesia", "instansi": "Pemkab Bogor", "jenis_dokumen": "Piagam", "nama_dokumen": "Piagam Pengabdi Terbaik", "nomor_dokumen": "PGM-002", "tautan": "https://sertifikat.id/002", "dokumen_path": "assets/pdf/example.pdf"}
                ]'));
            @endphp

            @foreach ($dataPenghargaan as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-start">{{ $item->nama_kegiatan }}</td>
                <td class="text-center">{{ $item->unit }}</td>
                <td class="text-center">{{ $item->nomor }}</td>
                <td class="text-center">{{ $item->penghargaan }}</td>
                <td class="text-center">{{ $item->lingkup }}</td>
                <td class="text-center">{{ $item->tahun }}</td>
                <td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td>
                <td class="text-center">
                    <div class="d-flex gap-2 justify-content-center">
                        {{-- Tombol Lihat Detail yang sudah fungsional --}}
                        <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-detail-penghargaan" title="Lihat Detail"
                           data-bs-toggle="modal"
                           data-bs-target="#modalDetailPenghargaan"
                           data-pegawai="{{ $item->pegawai }}"
                           data-kegiatan="{{ $item->nama_kegiatan }}"
                           data-nama_penghargaan="{{ $item->penghargaan }}"
                           data-nomor="{{ $item->nomor }}"
                           data-tanggal_perolehan="{{ $item->tanggal_perolehan }}"
                           data-lingkup="{{ $item->lingkup }}"
                           data-negara="{{ $item->negara }}"
                           data-instansi="{{ $item->instansi }}"
                           data-jenis_dokumen="{{ $item->jenis_dokumen }}"
                           data-nama_dokumen="{{ $item->nama_dokumen }}"
                           data-nomor_dokumen="{{ $item->nomor_dokumen }}"
                           data-tautan="{{ $item->tautan }}"
                           data-dokumen_path="{{ $item->dokumen_path }}">
                            <i class="fa fa-eye"></i>
                        </a>
                        
                        {{-- Tombol Edit (disesuaikan dengan standar Bootstrap) --}}
                        <a href="#" class="btn-aksi btn-edit" title="Edit Data"
                          data-bs-toggle="modal"
                          data-bs-target="#penghargaanModal">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
          
          <div class="d-flex justify-content-between align-items-center mt-4">
              <span class="text-muted small">Menampilkan 1 sampai 10 dari 13 data</span>
              <nav aria-label="Page navigation">
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

  <footer class="footer-custom">
    <span>© 2025 Forest Management — All Rights Reserved</span>
  </footer>
  
  <!--TAMBAH PENGHARGAAN-->
<div class="modal fade" id="penghargaanModal" tabindex="-1" aria-labelledby="penghargaanModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="penghargaanModalLabel"><i class="fas fa-plus-circle"></i> Tambah Data Penghargaan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="penghargaanForm">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label">Pegawai</label>
              <select class="form-select">
                <option selected>-- Pilih Pegawai --</option>
                </select>
            </div>
            <div class="col-12">
              <label class="form-label">Kegiatan</label>
              <select class="form-select">
                <option selected>-- Pilih Kegiatan Terkait --</option>
                </select>
            </div>
            <div class="col-12">
              <label class="form-label">Nama Penghargaan</label>
              <input type="text" class="form-control" placeholder="Contoh: Satyalancana Karya Satya X Tahun">
            </div>
            <div class="col-md-6">
              <label class="form-label">Nomor SK</label>
              <input type="text" class="form-control" placeholder="Masukkan nomor SK penghargaan">
            </div>
            <div class="col-md-6">
              <label class="form-label">Tanggal Perolehan</label>
              <input type="date" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Lingkup</label>
              <select class="form-select">
                <option selected>-- Pilih Lingkup --</option>
                <option>Internal</option>
                <option>Nasional</option>
                <option>Internasional</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Negara</label>
              <input type="text" class="form-control" placeholder="Contoh: Indonesia">
            </div>
            <div class="col-12">
              <label class="form-label">Instansi Pemberi</label>
              <input type="text" class="form-control" placeholder="Contoh: Presiden Republik Indonesia">
            </div>
            
            <div class="col-12"><hr></div>

            <div class="col-12">
              <label class="form-label">Jenis Dokumen</label>
              <select class="form-select">
                <option selected>-- Pilih Salah Satu --</option>
                <option>Sertifikat</option>
                <option>Piagam</option>
                <option>SK</option>
              </select>
            </div>
            
            <div class="col-12">
              <div class="upload-area">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small></p>
                <input type="file" hidden>
              </div>
            </div>
            
            <div class="col-12">
              <div class="row g-2">
                <div class="col-md-4"><label class="form-label-sm">Nama Dokumen</label><input type="text" class="form-control form-control-sm" placeholder="Nama Dokumen"></div>
                <div class="col-md-4"><label class="form-label-sm">Nomor</label><input type="text" class="form-control form-control-sm" placeholder="Nomor Dokumen (Jika Ada)"></div>
                <div class="col-md-4"><label class="form-label-sm">Tautan</label><input type="text" class="form-control form-control-sm" placeholder="Tautan (Jika Ada)"></div>
              </div>
            </div>

          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-success">Simpan</button>
      </div>
    </div>
  </div>
</div>

  <!--DETAIL PENGHARGAAN-->
<div class="modal fade" id="modalDetailPenghargaan" tabindex="-1" aria-labelledby="modalDetailPenghargaanLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailPenghargaanLabel">
          <i class="fas fa-info-circle"></i>
          <span>Detail Penghargaan</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="detail-grid-container">
            <div class="detail-item"><small>Pegawai</small><p id="detail_penghargaan_pegawai">-</p></div>
            <div class="detail-item"><small>Kegiatan</small><p id="detail_penghargaan_kegiatan">-</p></div>
            <div class="detail-item"><small>Nama Penghargaan</small><p id="detail_penghargaan_nama_penghargaan">-</p></div>
            <div class="detail-item"><small>Nomor</small><p id="detail_penghargaan_nomor">-</p></div>
            <div class="detail-item"><small>Tanggal Perolehan</small><p id="detail_penghargaan_tanggal_perolehan">-</p></div>
            <div class="detail-item"><small>Lingkup</small><p id="detail_penghargaan_lingkup">-</p></div>
            <div class="detail-item"><small>Negara</small><p id="detail_penghargaan_negara">-</p></div>
            <div class="detail-item"><small>Instansi</small><p id="detail_penghargaan_instansi">-</p></div>
        </div>
        
        <h6 class="mt-4">Dokumen</h6>
        <div class="detail-grid-container">
            <div class="detail-item"><small>Jenis Dokumen</small><p id="detail_penghargaan_jenis_dokumen">-</p></div>
            <div class="detail-item"><small>Nama Dokumen</small><p id="detail_penghargaan_nama_dokumen">-</p></div>
            <div class="detail-item"><small>Nomor Dokumen</small><p id="detail_penghargaan_nomor_dokumen">-</p></div>
            <div class="detail-item"><small>Tautan</small><p id="detail_penghargaan_tautan">-</p></div>
        </div>

        <div class="document-viewer-container mt-4">
            <embed id="detail_penghargaan_document_viewer" src="" type="application/pdf" width="100%" height="600px" />
        </div>
      </div>
      <div class="modal-footer justify-content-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!--Hapus Penelitian-->
<!-- Modal Konfirmasi Hapus -->
<div class="konfirmasi-hapus-overlay" id="modalKonfirmasiHapus" style="display: none;">
    <div class="konfirmasi-hapus-box">
        <div class="konfirmasi-hapus-icon">
            <i class="fas fa-exclamation"></i>
        </div>
        <h3 class="konfirmasi-hapus-title">Apakah Anda Yakin Menghapus Data Ini?</h3>
        <p class="konfirmasi-hapus-subtitle">Data ini akan dihapus secara permanen dari sistem.</p>
        <div class="konfirmasi-hapus-buttons">
            <button class="btn-popup btn-batal" id="btnBatalHapus">Batal</button>
            <button class="btn-popup btn-hapus" id="btnKonfirmasiHapus">Hapus</button>
        </div>
    </div>
</div>

  <script src="{{ asset('assets/js/penghargaan.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>