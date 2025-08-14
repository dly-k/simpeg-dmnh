<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>SIKEMAH - Editor Kegiatan (SK Non PNS)</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/sk-non-pns.css') }}" />
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
          <a href="/penghargaan" aria-label="Penghargaan">Penghargaan</a>
          <a href="/sk-non-pns" aria-label="SK Non PNS" class="active">SK Non PNS</a>
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
    <h1><i class="lni lni-pencil-alt"></i> <span id="page-title">Editor Kegiatan - SK Non PNS</span></h1>
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
                <select class="form-select filter-select "><option selected>Tahun</option><option>2023</option></select>
                <a href="#" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#skNonPnsModal">
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
                        <th>Nomor SK</th>
                        <th>Tanggal</th>
                        <th>Dokumen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <script>
                      for(let i=1; i<=7; i++){ 
                          document.write(`
                              <tr>
                                  <td class="text-center">${i}</td>
                                  <td class="text-start">Alex Kurniawan</td>
                                  <td class="text-center">IPDN</td>
                                  <td class="text-center">Biometrika Hutan</td>
                                  <td class="text-center">12 Januari 2023</td>
                                  <td class="text-center"><a href="#" class="btn btn-sm btn-lihat-detail text-white">Lihat</a></td>
                                  <td class="text-center">
                                      <div class="d-flex gap-2 justify-content-center">
                                        <a href="#" class="btn-aksi btn-lihat btn-lihat-detail-sk" title="Lihat Detail" 
                                          data-bs-toggle="modal" 
                                          data-bs-target="#modalDetailSkNonPns"
                                          data-nama_kegiatan="Pengelolaan Keuangan Departemen"
                                          data-unit="Departemen Kehutanan"
                                          data-jenis_sk="Tenaga Kependidikan"
                                          data-nomor_sk="012/SK/IV/2024"
                                          data-tanggal_sk="15 April 2024"
                                          data-pegawai="Alex Kurniawan"
                                          data-tgl_mulai="01 Januari 2024"
                                          data-tgl_selesai="31 Desember 2024"
                                          data-dokumen_path="{{ asset('assets/pdf/example.pdf') }}">
                                          <i class="fa fa-eye"></i>
                                        </a>
                                          <a href="#" class="btn-aksi btn-edit" title="Edit Data" data-bs-toggle="modal" data-bs-target="#skNonPnsModal">
                                              <i class="fa fa-edit"></i>
                                          </a>
                                          <a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a>
                                      </div>
                                  </td>
                              </tr>
                          `);
                      }
                    </script>
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
  <!--Edit & Tambah modal-->  
  <div class="modal fade" id="skNonPnsModal" tabindex="-1" aria-labelledby="skNonPnsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="skNonPnsModalLabel"><i class="fas fa-plus-circle"></i> Tambah Data SK Non PNS</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="skNonPnsForm">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label">Pegawai</label>
              <select class="form-select">
                  <option selected>-- Pilih Pegawai --</option>
                  </select>
            </div>
            <div class="col-12">
              <label class="form-label">Unit</label>
              <select class="form-select">
                  <option selected>-- Pilih Unit --</option>
                  </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Tanggal Mulai</label>
              <input type="date" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Tanggal Selesai</label>
              <input type="date" class="form-control">
            </div>
            <div class="col-12">
              <label class="form-label">Nomor SK</label>
              <input type="text" class="form-control" placeholder="Masukkan Nomor SK">
            </div>
            <div class="col-12">
              <label class="form-label">Tanggal SK</label>
              <input type="date" class="form-control">
            </div>
            <div class="col-12">
              <label class="form-label">Jenis SK</label>
              <select class="form-select">
                  <option selected>-- Pilih Jenis SK --</option>
                  <option>Tenaga Kependidikan</option>
                  <option>Dosen</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label">Unggah Dokumen SK</label>
              <div class="upload-area">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small></p>
                <input type="file" hidden>
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

  <!--Detail Modal-->
  <div class="modal fade" id="modalDetailSkNonPns" tabindex="-1" aria-labelledby="modalDetailSkNonPnsLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailSkNonPnsLabel"><i class="fas fa-info-circle"></i> Detail SK Non PNS</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="detail-grid-container">
          <div class="detail-item"><small>Nama Kegiatan</small><p id="detail_sk_nama_kegiatan">-</p></div>
          <div class="detail-item"><small>Unit</small><p id="detail_sk_unit">-</p></div>
          <div class="detail-item"><small>Jenis SK</small><p id="detail_sk_jenis_sk">-</p></div>
          <div class="detail-item"><small>Nomor SK</small><p id="detail_sk_nomor_sk">-</p></div>
          <div class="detail-item"><small>Tanggal SK</small><p id="detail_sk_tanggal_sk">-</p></div>
          <div class="detail-item"><small>Pegawai</small><p id="detail_sk_pegawai">-</p></div>
          <div class="detail-item"><small>Tanggal Mulai</small><p id="detail_sk_tgl_mulai">-</p></div>
          <div class="detail-item"><small>Tanggal Selesai</small><p id="detail_sk_tgl_selesai">-</p></div>
        </div>

        <h6 class="mt-4">Dokumen</h6>
        <div class="document-viewer-container">
          <embed id="detail_sk_document_viewer" src="" type="application/pdf" width="100%" height="600px" />
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
<div class="konfirmasi-hapus-overlay" id="modalKonfirmasiHapus">
    <div class="konfirmasi-hapus-box">
        <div class="konfirmasi-hapus-icon">
            <i class="fas fa-exclamation"></i>
        </div>
        <h3 class="konfirmasi-hapus-title">Apakah Anda Yakin Menghapus Data Ini?</h3>
        <p class="konfirmasi-hapus-subtitle">Data ini akan dihapus secara permanen dari sistem.</p>
        <div class="konfirmasi-hapus-buttons">
            <button class="btn-popup btn-hapus" id="btnKonfirmasiHapus">Ya, Hapus</button>
            <button class="btn-popup btn-batal" id="btnBatalHapus">Batal</button>
        </div>
    </div>
</div>

  <script src="{{ asset('assets/js/sk-non-pns.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>