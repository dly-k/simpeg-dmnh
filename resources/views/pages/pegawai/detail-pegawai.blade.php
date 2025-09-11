<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Detail Pegawai - SIKEMAH</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/detail-pegawai.css') }}" />
</head>

<body>
<div class="layout">
    @include('layouts.sidebar')

    <div class="overlay" id="overlay"></div>

    <div class="main-wrapper">
        @include('layouts.header')

        <div class="title-bar d-flex align-items-center justify-content-between">
            <h1 class="m-0">
                <i class="fa fa-user"></i>Detail Pegawai
            </h1>
            <a href="{{ route('pegawai.index') }}" class="btn-kembali d-flex align-items-center gap-2">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
   
        <div class="main-content">
            <div class="search-filter-container">
                <div class="search-filter-row">
                    <div class="search-box">
                        <div class="input-group custom-search">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-search search-icon"></i></span>
                            <input type="text" class="form-control border-start-0 search-icon search-input" placeholder="Cari Data Pegawai...">
                        </div>
                    </div>
                    <div class="btn-tambah-container">
                        <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-edit d-flex align-items-center justify-content-center">
                            <i class="fa fa-edit me-2"></i>
                            Edit Data
                        </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-md-row gap-4 mb-5 custom-gap-mb">
                        <div class="text-center flex-shrink-0">
                            <div class="mb-2 mx-auto d-flex align-items-center justify-content-center foto-profil">
                                @if($pegawai->foto_profil)
                                    <img src="{{ asset('storage/' . $pegawai->foto_profil) }}" alt="Foto Profil" class="img-fluid rounded" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <i class="lni lni-user"></i>
                                @endif
                            </div>
                            <!-- <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-editfoto btn-sm w-100">
                                Edit Foto
                            </a> -->
                        </div>
                        <div class="flex-grow-1">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="small text-dark fw-medium mb-1">NIP</label>
                                    <div class="detail-box">{{ $pegawai->nip ?? '-' }}</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="small text-dark fw-medium mb-1">Agama</label>
                                    <div class="detail-box">{{ $pegawai->agama ?? '-' }}</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="small text-dark fw-medium mb-1">Nama Lengkap</label>
                                    <div class="detail-box">{{ $pegawai->nama_lengkap ?? '-' }}</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="small text-dark fw-medium mb-1">Status Pernikahan</label>
                                    <div class="detail-box">{{ $pegawai->status_pernikahan ?? '-' }}</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="small text-dark fw-medium mb-1">Jenis Kelamin</label>
                                    <div class="detail-box">{{ $pegawai->jenis_kelamin ?? '-' }}</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="small text-dark fw-medium mb-1">Pendidikan Terakhir</label>
                                    <div class="detail-box">{{ $pegawai->pendidikan_terakhir ?? '-' }}</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="small text-dark fw-medium mb-1">Tempat Lahir</label>
                                    <div class="detail-box">{{ $pegawai->tempat_lahir ?? '-' }}</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="small text-dark fw-medium mb-1">Bidang Ilmu</label>
                                    <div class="detail-box">{{ $pegawai->bidang_ilmu ?? '-' }}</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="small text-dark fw-medium mb-1">Tanggal Lahir</label>
                                    <div class="detail-box">{{ $pegawai->tanggal_lahir ? \Carbon\Carbon::parse($pegawai->tanggal_lahir)->isoFormat('D MMMM YYYY') : '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-4 divider-light">
                     
                  <div class="d-flex flex-column flex-lg-row gap-4">
                    <div class="nav flex-column nav-pills main-tab-nav" id="main-tab-nav">
                        <button class="nav-link text-start active" data-main-tab="biodata">Biodata</button>
                        <button class="nav-link text-start" data-main-tab="pendidikan">Pelaksanaan Pendidikan</button>
                        <button class="nav-link text-start" data-main-tab="penelitian">Pelaksanaan Penelitian</button>
                        <button class="nav-link text-start" data-main-tab="pengabdian">Pelaksanaan Pengabdian</button>
                        <button class="nav-link text-start" data-main-tab="penunjang">Penunjang</button>
                        <button class="nav-link text-start" data-main-tab="pelatihan">Pelatihan</button>
                        <button class="nav-link text-start" data-main-tab="penghargaan">Penghargaan</button>
                    </div>
                    <div class="flex-grow-1">
                        <div class="main-tab-content" id="biodata-content">
                            <div id="biodata-sub-tabs" class="btn-group flex-wrap gap-2 mb-4">
                                <button type="button" class="btn active" data-tab="kepegawaian">Kepegawaian</button>
                                <button type="button" class="btn" data-tab="dosen">Dosen</button>
                                <button type="button" class="btn" data-tab="domisili">Alamat Domisili & Kontak</button>
                                <button type="button" class="btn" data-tab="kependudukan">Kependudukan</button>
                                <button type="button" class="btn" data-tab="efile">E-File</button>
                            </div>

                            <div class="sub-tab-content" id="kepegawaian">
                                <div class="row g-3">

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Status Kepegawaian</label>
                                        <div class="detail-box">{{ $pegawai->status_kepegawaian ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Status Pegawai</label>
                                        <div class="detail-box">{{ $pegawai->status_pegawai ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Unit Kerja</label>
                                        <div class="detail-box">Fakultas Kehutanan dan Lingkungan</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Divisi</label>
                                        <div class="detail-box">Departemen Manajemen Hutan</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Nomor Arsip Berkas Kepegawaian</label>
                                        <div class="detail-box">{{ $pegawai->nomor_arsip ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Jabatan Fungsional</label>
                                        <div class="detail-box">{{ $pegawai->jabatan_fungsional ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Pangkat/Golongan</label>
                                        <div class="detail-box">{{ $pegawai->pangkat_golongan ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">TMT Pangkat Terakhir</label>
                                        <div class="detail-box">{{ $pegawai->tmt_pangkat ? \Carbon\Carbon::parse($pegawai->tmt_pangkat)->isoFormat('D MMMM YYYY') : '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Jabatan Struktural (jika ada)</label>
                                        <div class="detail-box">{{ $pegawai->jabatan_struktural ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Periode Jabatan Struktural (TMT s/d TST)</label>
                                        <div class="detail-box">
                                            @if($pegawai->periode_jabatan_mulai && $pegawai->periode_jabatan_selesai)
                                                {{ \Carbon\Carbon::parse($pegawai->periode_jabatan_mulai)->isoFormat('D MMM YYYY') }} s/d {{ \Carbon\Carbon::parse($pegawai->periode_jabatan_selesai)->isoFormat('D MMM YYYY') }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Finger Print ID</label>
                                        <div class="detail-box">{{ $pegawai->finger_print_id ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">NPWP</label>
                                        <div class="detail-box">{{ $pegawai->npwp ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Nama Bank</label>
                                        <div class="detail-box">{{ $pegawai->nama_bank ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">No Rekening</label>
                                        <div class="detail-box">{{ $pegawai->nomor_rekening ?? '-' }}</div>
                                    </div>

                                </div>
                            </div>
                            
                            <div class="sub-tab-content" id="dosen">
                                <div class="row g-3">
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">NUPTK</label>
                                        <div class="detail-box">{{ $pegawai->nuptk ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">SINTA ID</label>
                                        <div class="detail-box">{{ $pegawai->sinta_id ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">NIDN</label>
                                        <div class="detail-box">{{ $pegawai->nidn ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium">Scopus ID</label>
                                        <div class="detail-box">{{ $pegawai->scopus_id ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">No. Sertifikasi Dosen</label>
                                        <div class="detail-box">{{ $pegawai->no_sertifikasi_dosen ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Orchid ID</label>
                                        <div class="detail-box">{{ $pegawai->orchid_id ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Tgl. Sertifikasi Dosen</label>
                                        <div class="detail-box">{{ $pegawai->tgl_sertifikasi_dosen ? \Carbon\Carbon::parse($pegawai->tgl_sertifikasi_dosen)->isoFormat('D MMMM YYYY') : '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Google Scholar ID</label>
                                        <div class="detail-box">{{ $pegawai->google_scholar_id ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="sub-tab-content" id="domisili">
                                <div class="row g-3">
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Provinsi</label>
                                        <div class="detail-box">{{ $pegawai->provinsi_domisili ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kota/Kabupaten</label>
                                        <div class="detail-box">{{ $pegawai->kota_domisili ?? '-' }}</div>
                                    </div>
                                    
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kecamatan</label>
                                        <div class="detail-box">{{ $pegawai->kecamatan_domisili ?? '-' }}</div>
                                    </div>
                                    
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kelurahan</label>
                                        <div class="detail-box">{{ $pegawai->kelurahan_domisili ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kode Pos</label>
                                        <div class="detail-box">{{ $pegawai->kode_pos_domisili ?? '-' }}</div>
                                    </div>
                                    
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Alamat</label>
                                        <div class="detail-box">{{ $pegawai->alamat_domisili ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">No. Telepon/HP</label>
                                        <div class="detail-box">{{ $pegawai->no_telepon ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Email</label>
                                        <div class="detail-box">{{ $pegawai->email ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="sub-tab-content" id="kependudukan">
                                <div class="row g-3">

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Nomor KTP</label>
                                        <div class="detail-box">{{ $pegawai->nomor_ktp ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Nomor KK</label>
                                        <div class="detail-box">{{ $pegawai->nomor_kk ?? '-' }}</div>
                                    </div>
                                    
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Warga Negara</label>
                                        <div class="detail-box">{{ $pegawai->warga_negara ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Provinsi KTP</label>
                                        <div class="detail-box">{{ $pegawai->provinsi_ktp ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kabupaten/Kota KTP</label>
                                        <div class="detail-box">{{ $pegawai->kabupaten_ktp ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kecamatan KTP</label>
                                        <div class="detail-box">{{ $pegawai->kecamatan_ktp ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kelurahan KTP</label>
                                        <div class="detail-box">{{ $pegawai->kelurahan_ktp ?? '-' }}</div>
                                    </div>
                                    
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kode Pos KTP</label>
                                        <div class="detail-box">{{ $pegawai->kode_pos_ktp ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label class="small text-dark fw-medium mb-1">Alamat KTP</label>
                                        <div class="detail-box">{{ $pegawai->alamat_ktp ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="sub-tab-content" id="efile">
                                <div class="efile-header">
                                    <h4>Dokumen</h4>
                                    <button class="btn btn-tambah" data-bs-toggle="modal" data-bs-target="#tambahDokumenModal"><i class="lni lni-plus me-1"></i> Tambah</button>
                                </div>
                                <div class="file-category">
                                    <p class="file-category-title">Contoh Kategori</p>
                                    <p class="text-muted">Fitur E-File akan diimplementasikan pada tahap selanjutnya.</p>
                                </div>
                            </div>
                        </div>

                        <div class="main-tab-content" id="pendidikan-content" style="display: none;">
                            <p>Konten Pelaksanaan Pendidikan akan dimuat di sini.</p>
                        </div>
                        <div class="main-tab-content" id="penelitian-content" style="display: none;">
                           <p>Konten Pelaksanaan Penelitian akan dimuat di sini.</p>
                        </div>
                        <div class="main-tab-content" id="pengabdian-content" style="display: none;">
                            <p>Konten Pelaksanaan Pengabdian akan dimuat di sini.</p>
                        </div>
                        <div class="main-tab-content" id="penunjang-content" style="display: none;">
                            <p>Konten Penunjang akan dimuat di sini.</p>
                        </div>
                         <div class="main-tab-content" id="pelatihan-content" style="display: none;">
                            <p>Konten Pelatihan akan dimuat di sini.</p>
                        </div>
                         <div class="main-tab-content" id="penghargaan-content" style="display: none;">
                            <p>Konten Penghargaan akan dimuat di sini.</p>
                        </div>

                    </div> 
                </div>
            </div>
        </div>

    <footer class="footer-custom">
        <span>© 2025 Forest Management — All Rights Reserved</span>
    </footer>
    </div>
</div>

    {{-- Modal General --}}
    @include('components.tambah-efile')
    @include('components.konfirmasi-hapus')
    @include('components.konfirmasi-berhasil')

    {{-- Modal Detail akan diimplementasikan nanti --}}
        
<script src="{{ asset('assets/js/layout.js') }}"></script>
<script src="{{ asset('assets/js/detail-pegawai.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>