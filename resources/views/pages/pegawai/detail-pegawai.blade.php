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
                        <button class="nav-link text-start" data-main-tab="sk">Identitas SK</button>
                        <button class="nav-link text-start" data-main-tab="pendidikan">Pelaksanaan Pendidikan</button>
                        <button class="nav-link text-start" data-main-tab="penelitian">Pelaksanaan Penelitian</button>
                        <button class="nav-link text-start" data-main-tab="pengabdian">Pelaksanaan Pengabdian</button>
                        <button class="nav-link text-start" data-main-tab="penunjang">Penunjang</button>
                        <button class="nav-link text-start" data-main-tab="pelatihan">Pelatihan</button>
                        <button class="nav-link text-start" data-main-tab="penghargaan">Penghargaan</button>
                    </div>
                    <div class="flex-grow-1">
                        <div class="main-tab-content" id="biodata-content">
                            <div id="biodata-sub-tabs" class="sub-tab-nav d-flex flex-wrap gap-2 mb-4">
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
                            
                            <div class="sub-tab-content" id="dosen" style="display: none;">
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
                            
                            <div class="sub-tab-content" id="domisili" style="display: none;">
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

                            <div class="sub-tab-content" id="kependudukan" style="display: none;">
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

                           <div class="sub-tab-content" id="efile" style="display: none;">
                                <div class="efile-header">
                                    <h4>Dokumen</h4>
                                    <button class="btn btn-tambah" data-bs-toggle="modal" data-bs-target="#tambahDokumenModal"><i class="lni lni-plus me-1"></i> Tambah</button>
                                </div>

                                @php
                                    $groupedFiles = $pegawai->efiles->groupBy('kategori_dokumen');
                                    $kategoriMap = [
                                        'biodata' => 'Biodata', 'pendidikan' => 'Pendidikan', 'jf' => 'Jabatan Fungsional',
                                        'sk' => 'Surat Keputusan', 'sp' => 'Surat Penting', 'lain' => 'Lain-lain'
                                    ];
                                @endphp

                                @if($pegawai->efiles->isEmpty())
                                    <div class="text-center text-muted mt-5 py-5">
                                        <p>Belum ada dokumen E-File yang diunggah.</p>
                                    </div>
                                @else
                                    @foreach($kategoriMap as $key => $namaKategori)
                                        @if($groupedFiles->has($key))
                                            <div class="file-category">
                                                <p class="file-category-title">{{ $namaKategori }}</p>
                                                <div class="file-grid">
                                                    @foreach($groupedFiles[$key] as $file)
                                                        <div class="file-item" data-file-url="{{ asset('storage/' . $file->file_path) }}">
                                                            @php
                                                                $keaslian = strtolower($file->keaslian_dokumen ?? '');
                                                                $badgeClass = 'badge-scan'; // Default
                                                                if ($keaslian == 'asli') $badgeClass = 'badge-asli';
                                                                if ($keaslian == 'legalisir') $badgeClass = 'badge-legalisir';
                                                            @endphp
                                                            <span class="file-badge {{ $badgeClass }}">{{ $file->keaslian_dokumen ?? 'N/A' }}</span>
                                                            <div class="file-item-icon">
                                                                <i class="lni lni-files"></i>
                                                            </div>
                                                            <p title="{{ $file->file_name }}">
                                                                {{ $file->nama_dokumen }}
                                                                <span>{{ \Carbon\Carbon::parse($file->tanggal_dokumen)->isoFormat('D MMM YYYY') }}</span>
                                                            </p>
                                                            <div class="file-item-actions">
                                                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">Lihat</a>
                                                                <form action="{{ route('efile.destroy', $file->id) }}" method="POST" class="d-inline form-hapus-efile w-100">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100" data-nama="{{ $file->nama_dokumen }}">Hapus</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>

                            <div class="main-tab-content" id="sk-content" style="display: none;">
                                <div id="sk-sub-tabs" class="sub-tab-nav d-flex flex-wrap gap-2 mb-4">
                                <button type="button" class="btn active" data-tab="penetapan-pangkat">Penetapan Pangkat</button>
                                <button type="button" class="btn" data-tab="jabatan">Jabatan</button>
                                <button type="button" class="btn" data-tab="jabatan-saat-ini">Jabatan Saat Ini</button>
                                <button type="button" class="btn" data-tab="pensiun">Pensiun</button>
                                <button type="button" class="btn" data-tab="sk-kenaikan-gaji">SK Kenaikan Gaji Berkala</button>
                                <button type="button" class="btn" data-tab="sk-tugas-belajar">SK Tugas Belajar</button>
                                <button type="button" class="btn" data-tab="sk-non-pns">SK Non PNS</button>
                            </div>

                            <div class="sub-tab-content" id="penetapan-pangkat" style="display: block;">
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <div class="input-group" style="flex: 1 1 250px;"><span class="input-group-text"><i class="fas fa-search"></i></span><input type="text" class="form-control" placeholder="Cari di tabel..."></div>
                                    <select class="form-select" style="flex: 0 1 180px;"><option selected>Filter Tahun</option><option>2025</option><option>2024</option><option>2023</option></select>
                                    <button class="btn btn-outline-success" style="flex: 0 1 auto;"><i class="fa fa-file-export me-2"></i>Export</button>
                                    <button class="btn btn-success" style="flex: 0 1 auto;" data-bs-toggle="modal" data-bs-target="#tambahPangkatModal"><i class="fa fa-plus me-2"></i>Tambah</button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="text-center">
                                            <tr><th>Golongan</th><th>Persetujuan BKN</th><th>Tanggal BKN</th><th>Nomor SK</th><th>Tanggal SK</th><th>TMT</th><th>File</th><th>Aksi</th></tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($pegawai->penetapanPangkats as $item)
                                                <tr>
                                                    <td class="text-center">{{ $item->golongan }}</td>
                                                    <td>{{ $item->nomor_bkn }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_bkn)->isoFormat('D MMM YYYY') }}</td>
                                                    <td>{{ $item->nomor_sk }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_sk)->isoFormat('D MMM YYYY') }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tmt_pangkat)->isoFormat('D MMM YYYY') }}</td>
                                                    <td class="text-center">
                                                        @if($item->file_path)
                                                            <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Lihat</a>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="text-center"><button class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="8" class="text-center">Belum ada data.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="sub-tab-content" id="jabatan" style="display: none;">
                                 <div class="d-flex flex-wrap gap-2 mb-3">
                                    <div class="input-group" style="flex: 1 1 250px;"><span class="input-group-text"><i class="fas fa-search"></i></span><input type="text" class="form-control" placeholder="Cari di tabel..."></div>
                                    <select class="form-select" style="flex: 0 1 180px;"><option selected>Filter Tahun</option><option>2025</option><option>2024</option><option>2023</option></select>
                                    <button class="btn btn-outline-success" style="flex: 0 1 auto;"><i class="fa fa-file-export me-2"></i>Export</button>
                                    <button class="btn btn-success" style="flex: 0 1 auto;" data-bs-toggle="modal" data-bs-target="#tambahJabatanModal"><i class="fa fa-plus me-2"></i>Tambah</button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="text-center">
                                            <tr><th>No</th><th>Nama Jabatan</th><th>Jenis SK</th><th>Nomor SK</th><th>Tanggal SK</th><th>TMT</th><th>File</th><th>Aksi</th></tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($pegawai->jabatans as $index => $item)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td>{{ $item->nama_jabatan }}</td>
                                                    <td>{{ $item->jenis_sk }}</td>
                                                    <td>{{ $item->nomor_sk }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_sk)->isoFormat('D MMM YYYY') }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tmt_jabatan)->isoFormat('D MMM YYYY') }}</td>
                                                    <td class="text-center">
                                                        @if($item->file_path)
                                                            <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Lihat</a>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="text-center"><button class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="8" class="text-center">Belum ada data.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="sub-tab-content" id="jabatan-saat-ini" style="display: none;">
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <div class="input-group" style="flex: 1 1 250px;"><span class="input-group-text"><i class="fas fa-search"></i></span><input type="text" class="form-control" placeholder="Cari di tabel..."></div>
                                    <select class="form-select" style="flex: 0 1 180px;"><option selected>Filter Tahun</option><option>2025</option><option>2024</option><option>2023</option></select>
                                    <button class="btn btn-outline-success" style="flex: 0 1 auto;"><i class="fa fa-file-export me-2"></i>Export</button>
                                    <button class="btn btn-success" style="flex: 0 1 auto;" data-bs-toggle="modal" data-bs-target="#tambahJabatanSaatIniModal"><i class="fa fa-plus me-2"></i>Tambah</button>
                                </div>
                               <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="text-center">
                                            <tr><th>Nama Jabatan</th><th>Jenis Jabatan</th><th>Nomor SK</th><th>File</th><th>Aksi</th></tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($pegawai->jabatanSaatInis as $item)
                                                <tr>
                                                    <td>{{ $item->nama_jabatan }}</td>
                                                    <td>{{ $item->jenis_jabatan }}</td>
                                                    <td>{{ $item->nomor_sk }}</td>
                                                    <td class="text-center">
                                                        @if($item->file_path)
                                                            <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Lihat</a>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="text-center"><button class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="5" class="text-center">Belum ada data.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="sub-tab-content" id="pensiun" style="display: none;">
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <div class="input-group" style="flex: 1 1 250px;"><span class="input-group-text"><i class="fas fa-search"></i></span><input type="text" class="form-control" placeholder="Cari di tabel..."></div>
                                    <select class="form-select" style="flex: 0 1 180px;"><option selected>Filter Tahun</option><option>2025</option><option>2024</option><option>2023</option></select>
                                    <button class="btn btn-outline-success" style="flex: 0 1 auto;"><i class="fa fa-file-export me-2"></i>Export</button>
                                    <button class="btn btn-success" style="flex: 0 1 auto;" data-bs-toggle="modal" data-bs-target="#tambahPensiunModal"><i class="fa fa-plus me-2"></i>Tambah</button>
                                </div>
                               <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="text-center">
                                            <tr><th>No</th><th>Jenis Pensiun</th><th>Nomor SK</th><th>Tanggal SK</th><th>TMT Pensiun</th><th>File</th><th>Aksi</th></tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($pegawai->pensiuns as $index => $item)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td>{{ $item->jenis_pensiun }}</td>
                                                    <td>{{ $item->nomor_sk }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_sk)->isoFormat('D MMM YYYY') }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tmt_pensiun)->isoFormat('D MMM YYYY') }}</td>
                                                    <td class="text-center">
                                                        @if($item->file_path)
                                                            <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Lihat</a>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="text-center"><button class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="7" class="text-center">Belum ada data.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="sub-tab-content" id="sk-kenaikan-gaji" style="display: none;">
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <div class="input-group" style="flex: 1 1 250px;"><span class="input-group-text"><i class="fas fa-search"></i></span><input type="text" class="form-control" placeholder="Cari di tabel..."></div>
                                    <select class="form-select" style="flex: 0 1 180px;"><option selected>Filter Tahun</option><option>2025</option><option>2024</option><option>2023</option></select>
                                    <button class="btn btn-outline-success" style="flex: 0 1 auto;"><i class="fa fa-file-export me-2"></i>Export</button>
                                    <button class="btn btn-success" style="flex: 0 1 auto;" data-bs-toggle="modal" data-bs-target="#tambahGajiBerkalaModal"><i class="fa fa-plus me-2"></i>Tambah</button>
                                </div>
                               <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="text-center">
                                            <tr><th>No</th><th>Golongan</th><th>Nomor SK</th><th>Tanggal SK</th><th>TMT Gaji</th><th>Gaji Pokok</th><th>File</th><th>Aksi</th></tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($pegawai->kenaikanGajiBerkalas as $index => $item)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td class="text-center">{{ $item->golongan }}</td>
                                                    <td>{{ $item->nomor_sk }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_sk)->isoFormat('D MMM YYYY') }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tmt_gaji)->isoFormat('D MMM YYYY') }}</td>
                                                    <td>Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}</td>
                                                    <td class="text-center">
                                                        @if($item->file_path)
                                                            <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Lihat</a>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="text-center"><button class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="8" class="text-center">Belum ada data.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="sub-tab-content" id="sk-tugas-belajar" style="display: none;">
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <div class="input-group" style="flex: 1 1 250px;"><span class="input-group-text"><i class="fas fa-search"></i></span><input type="text" class="form-control" placeholder="Cari di tabel..."></div>
                                    <select class="form-select" style="flex: 0 1 180px;"><option selected>Filter Tahun</option><option>2025</option><option>2024</option><option>2023</option></select>
                                    <button class="btn btn-outline-success" style="flex: 0 1 auto;"><i class="fa fa-file-export me-2"></i>Export</button>
                                    <button class="btn btn-success" style="flex: 0 1 auto;" data-bs-toggle="modal" data-bs-target="#tambahTugasBelajarModal"><i class="fa fa-plus me-2"></i>Tambah</button>
                                </div>
                               <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="text-center">
                                            <tr><th>No</th><th>Jenis Tugas Belajar</th><th>Nomor SK</th><th>Tanggal SK</th><th>Tanggal Mulai</th><th>Tanggal Selesai</th><th>File</th><th>Aksi</th></tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($pegawai->tugasBelajars as $index => $item)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td>{{ $item->jenis_tugas_belajar }}</td>
                                                    <td>{{ $item->nomor_sk }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_sk)->isoFormat('D MMM YYYY') }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->isoFormat('D MMM YYYY') }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_selesai)->isoFormat('D MMM YYYY') }}</td>
                                                    <td class="text-center">
                                                        @if($item->file_path)
                                                            <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Lihat</a>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="text-center"><button class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="8" class="text-center">Belum ada data.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="sub-tab-content" id="sk-non-pns" style="display: none;">
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <div class="input-group" style="flex: 1 1 250px;"><span class="input-group-text"><i class="fas fa-search"></i></span><input type="text" class="form-control" placeholder="Cari di tabel..."></div>
                                    <select class="form-select" style="flex: 0 1 180px;"><option selected>Filter Tahun</option><option>2025</option><option>2024</option><option>2023</option></select>
                                    <button class="btn btn-outline-success" style="flex: 0 1 auto;"><i class="fa fa-file-export me-2"></i>Export</button>
                                    <button class="btn btn-success" style="flex: 0 1 auto;" data-bs-toggle="modal" data-bs-target="#tambahNonPnsModal"><i class="fa fa-plus me-2"></i>Tambah</button>
                                </div>
                               <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="text-center">
                                            <tr><th>No</th><th>Jenis SK</th><th>Nomor SK</th><th>Tanggal SK</th><th>Tanggal Mulai</th><th>Tanggal Selesai</th><th>File</th><th>Aksi</th></tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($pegawai->skNonPns as $index => $item)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td>{{ $item->jenis_sk }}</td>
                                                    <td>{{ $item->nomor_sk }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_sk)->isoFormat('D MMM YYYY') }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->isoFormat('D MMM YYYY') }}</td>
                                                    <td class="text-center">{{ $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->isoFormat('D MMM YYYY') : '-' }}</td>
                                                    <td class="text-center">
                                                        @if($item->file_path)
                                                            <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Lihat</a>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="text-center"><button class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="8" class="text-center">Belum ada data.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
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
    
    {{-- Modal Untuk Menu SK --}}
    @include('components.pendidikan.tambah-penetapan-pangkat')
    @include('components.pendidikan.tambah-jabatan')
    @include('components.pendidikan.tambah-jabatan-saat-ini')
    @include('components.pendidikan.tambah-pensiun')
    @include('components.pendidikan.tambah-sk-kenaikan-gaji')
    @include('components.pendidikan.tambah-sk-tugas-belajar')
    @include('components.pendidikan.tambah-sk-non-pns')

    @if (session('success'))
    <div id="success-trigger" 
            data-title="Berhasil!"
            data-message="{{ session('success') }}"
            data-active-tab="{{ session('active_tab') }}"
            data-active-subtab="{{ session('active_subtab') }}">
    </div>
    @endif
        
<script src="{{ asset('assets/js/layout.js') }}"></script>
<script src="{{ asset('assets/js/detail-pegawai.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>