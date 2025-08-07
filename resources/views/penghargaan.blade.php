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
                <div class="btn-tambah-container">
                    <a href="#" class="btn btn-tambah fw-bold" onclick="openModal('penghargaanModal')"><i class="fa fa-plus me-2"></i> Tambah Data</a>
                </div>
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
                <tbody>
                    <script>
                      for(let i=1; i<=6; i++){ 
                          document.write(`
                              <tr>
                                  <td class="text-center">${i}</td>
                                  <td class="text-start">Alex Kurniawan</td>
                                  <td class="text-center">IPDN</td>
                                  <td class="text-center">Biometrika Hutan</td>
                                  <td class="text-center">Magos</td>
                                  <td class="text-center">Nasional</td>
                                  <td class="text-center">2023</td>
                                  <td class="text-center"><a href="#" class="btn btn-sm btn-lihat text-white">Lihat</a></td>
                                  <td class="text-center">
                                      <div class="d-flex gap-2 justify-content-center">
                                          <a href="#" class="btn-aksi btn-lihat" title="Lihat Detail"><i class="fa fa-eye"></i></a>
                                          <a href="#" class="btn-aksi btn-edit" title="Edit Data" onclick="openEditModal()"><i class="fa fa-edit"></i></a>
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
  
  <div class="modal-backdrop" id="penghargaanModal">
        <div class="modal-content-wrapper">
            <div class="modal-header-custom">
                <h5 id="modalTitle"><i class="fas fa-plus-circle"></i> Tambah Data Penghargaan</h5>
            </div>
            <div class="modal-body-custom">
                <form id="penghargaanForm">
                    <div class="row g-3">
                        <div class="col-12"><label class="form-label">Pegawai</label><input type="text" class="form-control" placeholder="Lorem Ipsum"></div>
                        <div class="col-12"><label class="form-label">Kegiatan</label><select class="form-select"><option selected>Lorem Ipsum</option></select></div>
                        <div class="col-12"><label class="form-label">Nama Penghargaan</label><input type="text" class="form-control" placeholder="Lorem Ipsum"></div>
                        <div class="col-md-6"><label class="form-label">Nomor</label><input type="text" class="form-control" placeholder="2020/2021"></div>
                        <div class="col-md-6"><label class="form-label">Tanggal Perolehan</label><input type="date" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Lingkup</label><select class="form-select"><option selected>2020/2021</option></select></div>
                        <div class="col-md-6"><label class="form-label">Negara</label><input type="text" class="form-control" placeholder="2020/2021"></div>
                        <div class="col-12"><label class="form-label">Instansi</label><input type="text" class="form-control" placeholder="Lorem Ipsum"></div>
                        
                        <div class="col-12"><label class="form-label">Jenis Dokumen</label><select class="form-select"><option selected>-- Pilih Salah Satu --</option></select></div>
                        
                        <div class="col-12">
                            <div class="upload-area">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Drag & Drop File here<br><small>Ukuran Maksimal 5 MB</small></p>
                                <input type="file" hidden>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="row g-2">
                                <div class="col-md-4"><input type="text" class="form-control" placeholder="Nama Dokumen"></div>
                                <div class="col-md-4"><input type="text" class="form-control" placeholder="Nomor"></div>
                                <div class="col-md-4"><input type="text" class="form-control" placeholder="Tautan"></div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn btn-danger" onclick="closeModal('penghargaanModal')">Batal</button>
                <button type="button" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>

  <script src="{{ asset('assets/js/penghargaan.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>