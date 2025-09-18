<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>SIKEMAH - Editor Kegiatan (Pendidikan)</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/pendidikan.css') }}" />
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
          <a href="/pendidikan" aria-label="Pendidikan" class="active">Pendidikan</a>
          <a href="/penelitian" aria-label="Penelitian">Penelitian</a>
          <a href="/pengabdian" aria-label="Pengabdian">Pengabdian</a>
          <a href="/penunjang" aria-label="Penunjang">Penunjang</a>
          <a href="/pelatihan" aria-label="Pelatihan">Pelatihan</a>
          <a href="/penghargaan" aria-label="Penghargaan">Penghargaan</a>
          <a href="/sk-non-pns" aria-label="SK Non PNS">SK Non PNS</a>
        </div>
        <a href="/kerjasama" aria-label="Kerjasama"><i class="lni lni-handshake"></i> Kerjasama</a>
        <a href="/master-data" aria-label="Master Data"><i class="lni lni-database"></i> Master Data</a>
      </div>
    </div>
  </div>

  <div class="overlay" id="overlay"></div>

  <div class="navbar-custom">
    <div class="d-flex align-items-center">
      <button class="btn btn-link text-dark me-3" id="toggleSidebar" aria-label="Toggle Sidebar">
        <i class="lni lni-menu"></i>
      </button>
    </div>
    <div class="d-flex align-items-center">
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
    <h1><i class="lni lni-pencil-alt"></i> <span id="page-title">Editor Kegiatan - Pendidikan</span></h1>
  </div>

    <div class="main-content">
      <div class="card">
          <ul class="nav nav-tabs mb-4" id="pendidikanTab" role="tablist">
            <li class="nav-item" role="presentation"><button class="nav-link active" id="pengajaran-lama-tab" data-bs-toggle="tab" data-bs-target="#pengajaran-lama" type="button" role="tab">Pengajaran Lama</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="pengajaran-luar-tab" data-bs-toggle="tab" data-bs-target="#pengajaran-luar" type="button" role="tab">Pengajaran Luar IPB</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="pengujian-lama-tab" data-bs-toggle="tab" data-bs-target="#pengujian-lama" type="button" role="tab">Pengujian Lama</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="pembimbing-lama-tab" data-bs-toggle="tab" data-bs-target="#pembimbing-lama" type="button" role="tab">Pembimbing Lama</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="penguji-luar-tab" data-bs-toggle="tab" data-bs-target="#penguji-luar" type="button" role="tab">Penguji Luar IPB</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="pembimbing-luar-tab" data-bs-toggle="tab" data-bs-target="#pembimbing-luar" type="button" role="tab">Pembimbing Luar IPB</button></li>
          </ul>

          <div class="tab-content" id="pendidikanTabContent">
            {{-- =================================== PENGAJARAN LAMA =================================== --}}
            <div class="tab-pane fade show active" id="pengajaran-lama" role="tabpanel">
                <div class="search-filter-container">
                    <div class="btn-tambah-container ms-auto">
                        <a href="#" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahEditPengajaranLama" id="btnTambahPengajaranLama">
                            <i class="fa fa-plus me-2"></i> Tambah Data
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light"><tr class="text-center"><th>No</th><th>Nama Dosen</th><th>Tahun Semester</th><th>Mata Kuliah</th><th>Verifikasi</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                        <tbody>
                            @forelse ($dataPengajaranLama as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->pegawai->nama_lengkap ?? 'N/A' }}</td>
                                <td class="text-center">{{ $item->tahun_semester }}</td>
                                <td>{{ $item->nama_mk }} ({{$item->kode_mk}})</td>
                                <td class="text-center"><i class="fas fa-{{ $item->is_verified ? 'check-circle text-success' : 'times-circle text-danger' }}"></i></td>
                                <td class="text-center"><a href="{{ $item->file_path ? asset($item->file_path) : '#' }}" class="btn btn-sm btn-lihat text-white {{ $item->file_path ? '' : 'disabled' }}" target="_blank">Lihat</a></td>
                                <td class="text-center">{{-- Tombol Aksi --}}</td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center text-muted">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- =================================== PENGAJARAN LUAR =================================== --}}
            <div class="tab-pane fade" id="pengajaran-luar" role="tabpanel">
                <div class="search-filter-container">
                    <div class="btn-tambah-container ms-auto">
                        <a href="#" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#modalPengajaranLuar" id="btnTambahPengajaranLuar">
                            <i class="fa fa-plus me-2"></i> Tambah Data
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light"><tr class="text-center"><th>No</th><th>Nama Dosen</th><th>Institusi</th><th>Mata Kuliah</th><th>Verifikasi</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                        <tbody>
                            @forelse ($dataPengajaranLuar as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->pegawai->nama_lengkap ?? 'N/A' }}</td>
                                <td>{{ $item->universitas }}</td>
                                <td>{{ $item->nama_mk }}</td>
                                <td class="text-center"><i class="fas fa-{{ $item->is_verified ? 'check-circle text-success' : 'times-circle text-danger' }}"></i></td>
                                <td class="text-center"><a href="{{ $item->file_path ? asset($item->file_path) : '#' }}" class="btn btn-sm btn-lihat text-white {{ $item->file_path ? '' : 'disabled' }}" target="_blank">Lihat</a></td>
                                <td class="text-center">{{-- Tombol Aksi --}}</td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center text-muted">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- =================================== PENGUJIAN LAMA =================================== --}}
            <div class="tab-pane fade" id="pengujian-lama" role="tabpanel">
                <div class="search-filter-container">
                     <div class="btn-tambah-container ms-auto">
                        <a href="#" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#modalPengujianLama" id="btnTambahPengujianLama">
                            <i class="fa fa-plus me-2"></i> Tambah Data
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light"><tr class="text-center"><th>No</th><th>Nama Dosen</th><th>Nama Mahasiswa</th><th>Departemen</th><th>Verifikasi</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                        <tbody>
                            @forelse ($dataPengujianLama as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->pegawai->nama_lengkap ?? 'N/A' }}</td>
                                <td>{{ $item->nama_mahasiswa }} ({{$item->nim}})</td>
                                <td>{{ $item->departemen }}</td>
                                <td class="text-center"><i class="fas fa-{{ $item->is_verified ? 'check-circle text-success' : 'times-circle text-danger' }}"></i></td>
                                <td class="text-center"><a href="{{ $item->file_path ? asset($item->file_path) : '#' }}" class="btn btn-sm btn-lihat text-white {{ $item->file_path ? '' : 'disabled' }}" target="_blank">Lihat</a></td>
                                <td class="text-center">{{-- Tombol Aksi --}}</td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center text-muted">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- =================================== PEMBIMBING LAMA =================================== --}}
            <div class="tab-pane fade" id="pembimbing-lama" role="tabpanel">
                  <div class="search-filter-container">
                      <div class="btn-tambah-container ms-auto">
                          <a href="#" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#modalPembimbingLama" id="btnTambahPembimbingLama">
                              <i class="fa fa-plus me-2"></i> Tambah Data
                          </a>
                      </div>
                  </div>
                  <div class="table-responsive">
                      <table class="table table-hover table-bordered">
                          <thead class="table-light"><tr class="text-center"><th>No</th><th>Nama Dosen</th><th>Kegiatan</th><th>Nama Mahasiswa</th><th>Verifikasi</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                          <tbody>
                            @forelse ($dataPembimbingLama as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->pegawai->nama_lengkap ?? 'N/A' }}</td>
                                <td class="text-start">{{ Str::limit($item->kegiatan, 30) }}</td>
                                <td>{{ $item->nama_mahasiswa }}</td>
                                <td class="text-center"><i class="fas fa-{{ $item->is_verified ? 'check-circle text-success' : 'times-circle text-danger' }}"></i></td>
                                <td class="text-center"><a href="{{ $item->file_path ? asset($item->file_path) : '#' }}" class="btn btn-sm btn-lihat text-white {{ $item->file_path ? '' : 'disabled' }}" target="_blank">Lihat</a></td>
                                <td class="text-center">{{-- Tombol Aksi --}}</td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center text-muted">Belum ada data.</td></tr>
                            @endforelse
                          </tbody>
                      </table>
                  </div>
            </div>
            
            {{-- =================================== PENGUJI LUAR =================================== --}}
            <div class="tab-pane fade" id="penguji-luar" role="tabpanel">
                <div class="search-filter-container">
                    <div class="btn-tambah-container ms-auto">
                        <a href="#" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#modalPengujiLuar" id="btnTambahPengujiLuar">
                            <i class="fa fa-plus me-2"></i> Tambah Data
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light"><tr class="text-center"><th>No</th><th>Nama Dosen</th><th>Nama Mahasiswa</th><th>Universitas</th><th>Status</th><th>Verifikasi</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                        <tbody>
                            @forelse ($dataPengujiLuar as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->pegawai->nama_lengkap ?? 'N/A' }}</td>
                                <td>{{ $item->nama_mahasiswa }}</td>
                                <td>{{ $item->universitas }}</td>
                                <td>{{ $item->status }}</td>
                                <td class="text-center"><i class="fas fa-{{ $item->is_verified ? 'check-circle text-success' : 'times-circle text-danger' }}"></i></td>
                                <td class="text-center"><a href="{{ $item->file_path ? asset($item->file_path) : '#' }}" class="btn btn-sm btn-lihat text-white {{ $item->file_path ? '' : 'disabled' }}" target="_blank">Lihat</a></td>
                                <td class="text-center">{{-- Tombol Aksi --}}</td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="text-center text-muted">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- =================================== PEMBIMBING LUAR =================================== --}}
            <div class="tab-pane fade" id="pembimbing-luar" role="tabpanel">
                <div class="search-filter-container">
                    <div class="btn-tambah-container ms-auto">
                        <a href="#" class="btn btn-tambah fw-bold" data-bs-toggle="modal" data-bs-target="#modalPembimbingLuar" id="btnTambahPembimbingLuar">
                            <i class="fa fa-plus me-2"></i> Tambah Data
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light"><tr class="text-center"><th>No</th><th>Nama Dosen</th><th>Nama Mahasiswa</th><th>Universitas</th><th>Status</th><th>Verifikasi</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                        <tbody>
                             @forelse ($dataPembimbingLuar as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->pegawai->nama_lengkap ?? 'N/A' }}</td>
                                <td>{{ $item->nama_mahasiswa }}</td>
                                <td>{{ $item->universitas }}</td>
                                <td>{{ $item->status }}</td>
                                <td class="text-center"><i class="fas fa-{{ $item->is_verified ? 'check-circle text-success' : 'times-circle text-danger' }}"></i></td>
                                <td class="text-center"><a href="{{ $item->file_path ? asset($item->file_path) : '#' }}" class="btn btn-sm btn-lihat text-white {{ $item->file_path ? '' : 'disabled' }}" target="_blank">Lihat</a></td>
                                <td class="text-center">{{-- Tombol Aksi --}}</td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="text-center text-muted">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
          </div>
          
          {{-- Paginasi (jika Anda menggunakannya) --}}
          <div class="d-flex justify-content-between align-items-center mt-4">
              <span class="text-muted small">Menampilkan data</span>
              <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm mb-0">
                  {{-- ... --}}
                </ul>
              </nav>
          </div>
      </div>
  </div>

  <footer class="footer-custom">
    <span>© 2025 Forest Management — All Rights Reserved</span>
  </footer>

{{-- ... --}}
  {{-- =================================== KUMPULAN MODAL =================================== --}}
    @include('components.konfirmasi-hapus')
    @include('components.konfirmasi-berhasil')
    @include('components.konfirmasi-verifikasi')
    
    {{-- Memanggil setiap modal DETAIL dan TAMBAH hanya SATU KALI --}}
    {{-- Pastikan variabel $dosenAktif dilewatkan ke setiap modal TAMBAH --}}

    @include('components.pendidikan.detail-pengajaran-lama')
    @include('components.pendidikan.tambah-pengajaran-lama', ['dosenAktif' => $dosenAktif])

    @include('components.pendidikan.detail-pengajaran-luar')
    @include('components.pendidikan.tambah-pengajaran-luar', ['dosenAktif' => $dosenAktif])

    @include('components.pendidikan.detail-pengujian-lama')
    @include('components.pendidikan.tambah-pengujian-lama', ['dosenAktif' => $dosenAktif])
    
    @include('components.pendidikan.detail-pembimbing-lama')
    @include('components.pendidikan.tambah-pembimbing-lama', ['dosenAktif' => $dosenAktif])
    
    @include('components.pendidikan.detail-penguji-luar')
    @include('components.pendidikan.tambah-penguji-luar', ['dosenAktif' => $dosenAktif])
    
    @include('components.pendidikan.detail-pembimbing-luar')
    @include('components.pendidikan.tambah-pembimbing-luar', ['dosenAktif' => $dosenAktif])
{{-- ... --}}
  

  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="{{ asset('assets/js/pendidikan.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>