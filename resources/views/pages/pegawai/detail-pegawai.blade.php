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
                                <div class="col-md-6"><label class="small text-dark fw-medium mb-1">NIP</label><div class="detail-box">{{ $pegawai->nip ?? '-' }}</div></div>
                                <div class="col-md-6"><label class="small text-dark fw-medium mb-1">Agama</label><div class="detail-box">{{ $pegawai->agama ?? '-' }}</div></div>
                                <div class="col-md-6"><label class="small text-dark fw-medium mb-1">Nama Lengkap</label><div class="detail-box">{{ $pegawai->nama_lengkap ?? '-' }}</div></div>
                                <div class="col-md-6"><label class="small text-dark fw-medium mb-1">Status Pernikahan</label><div class="detail-box">{{ $pegawai->status_pernikahan ?? '-' }}</div></div>
                                <div class="col-md-6"><label class="small text-dark fw-medium mb-1">Jenis Kelamin</label><div class="detail-box">{{ $pegawai->jenis_kelamin ?? '-' }}</div></div>
                                <div class="col-md-6"><label class="small text-dark fw-medium mb-1">Pendidikan Terakhir</label><div class="detail-box">{{ $pegawai->pendidikan_terakhir ?? '-' }}</div></div>
                                <div class="col-md-6"><label class="small text-dark fw-medium mb-1">Tempat Lahir</label><div class="detail-box">{{ $pegawai->tempat_lahir ?? '-' }}</div></div>
                                <div class="col-md-6"><label class="small text-dark fw-medium mb-1">Bidang Ilmu</label><div class="detail-box">{{ $pegawai->bidang_ilmu ?? '-' }}</div></div>
                                <div class="col-md-6"><label class="small text-dark fw-medium mb-1">Tanggal Lahir</label><div class="detail-box">{{ $pegawai->tanggal_lahir ? \Carbon\Carbon::parse($pegawai->tanggal_lahir)->isoFormat('D MMMM YYYY') : '-' }}</div></div>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-4 divider-light">
                     
                  <div class="d-flex flex-column flex-lg-row gap-4">
                    <div class="nav flex-column nav-pills main-tab-nav" id="main-tab-nav">
                        <button class="nav-link text-start active" data-main-tab="biodata">Biodata</button>
                        <button class="nav-link text-start" data-main-tab="sk">Identitas SK</button>
                        <button class="nav-link text-start" data-main-tab="pendidikan">Akademik/Pendidikan</button>
                        <button class="nav-link text-start" data-main-tab="penelitian">Penelitian</button>
                        <button class="nav-link text-start" data-main-tab="pengabdian">Pengabdian</button>
                        <button class="nav-link text-start" data-main-tab="penunjang">Penunjang</button>
                        <button class="nav-link text-start" data-main-tab="pembicara">Pembicara</button>
                        <button class="nav-link text-start" data-main-tab="orasi-ilmiah">Orasi Ilmiah</button>
                        <button class="nav-link text-start" data-main-tab="sertifikat">Sertifikat Kompetensi</button>
                        <button class="nav-link text-start" data-main-tab="pengelola-jurnal">Pengelola Jurnal</button>
                        <button class="nav-link text-start" data-main-tab="pelatihan">Diklat</button>
                        <button class="nav-link text-start" data-main-tab="penghargaan">Penghargaan</button>
                        <button class="nav-link text-start" data-main-tab="praktisi">Praktisi Dunia Industri</button>
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
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Status Kepegawaian</label><div class="detail-box">{{ $pegawai->status_kepegawaian ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Status Pegawai</label><div class="detail-box">{{ $pegawai->status_pegawai ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Unit Kerja</label><div class="detail-box">Fakultas Kehutanan dan Lingkungan</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Divisi</label><div class="detail-box">Departemen Manajemen Hutan</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Nomor Arsip Berkas Kepegawaian</label><div class="detail-box">{{ $pegawai->nomor_arsip ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Jabatan Fungsional</label><div class="detail-box">{{ $pegawai->jabatan_fungsional ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Pangkat/Golongan</label><div class="detail-box">{{ $pegawai->pangkat_golongan ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">TMT Pangkat Terakhir</label><div class="detail-box">{{ $pegawai->tmt_pangkat ? \Carbon\Carbon::parse($pegawai->tmt_pangkat)->isoFormat('D MMMM YYYY') : '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Jabatan Struktural (jika ada)</label><div class="detail-box">{{ $pegawai->jabatan_struktural ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Periode Jabatan Struktural (TMT s/d TST)</label><div class="detail-box">@if($pegawai->periode_jabatan_mulai && $pegawai->periode_jabatan_selesai){{ \Carbon\Carbon::parse($pegawai->periode_jabatan_mulai)->isoFormat('D MMM YYYY') }} s/d {{ \Carbon\Carbon::parse($pegawai->periode_jabatan_selesai)->isoFormat('D MMM YYYY') }}@else - @endif</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Finger Print ID</label><div class="detail-box">{{ $pegawai->finger_print_id ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">NPWP</label><div class="detail-box">{{ $pegawai->npwp ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Nama Bank</label><div class="detail-box">{{ $pegawai->nama_bank ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">No Rekening</label><div class="detail-box">{{ $pegawai->nomor_rekening ?? '-' }}</div></div>
                                </div>
                            </div>
                            
                            <div class="sub-tab-content" id="dosen" style="display: none;">
                               <div class="row g-3">
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">NUPTK</label><div class="detail-box">{{ $pegawai->nuptk ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">SINTA ID</label><div class="detail-box">{{ $pegawai->sinta_id ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">NIDN</label><div class="detail-box">{{ $pegawai->nidn ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium">Scopus ID</label><div class="detail-box">{{ $pegawai->scopus_id ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">No. Sertifikasi Dosen</label><div class="detail-box">{{ $pegawai->no_sertifikasi_dosen ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Orchid ID</label><div class="detail-box">{{ $pegawai->orchid_id ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Tgl. Sertifikasi Dosen</label><div class="detail-box">{{ $pegawai->tgl_sertifikasi_dosen ? \Carbon\Carbon::parse($pegawai->tgl_sertifikasi_dosen)->isoFormat('D MMMM YYYY') : '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Google Scholar ID</label><div class="detail-box">{{ $pegawai->google_scholar_id ?? '-' }}</div></div>
                               </div>
                            </div>
                            
                            <div class="sub-tab-content" id="domisili" style="display: none;">
                                <div class="row g-3">
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Provinsi</label><div class="detail-box">{{ $pegawai->provinsi_domisili ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Kota/Kabupaten</label><div class="detail-box">{{ $pegawai->kota_domisili ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Kecamatan</label><div class="detail-box">{{ $pegawai->kecamatan_domisili ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Kelurahan</label><div class="detail-box">{{ $pegawai->kelurahan_domisili ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Kode Pos</label><div class="detail-box">{{ $pegawai->kode_pos_domisili ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Alamat</label><div class="detail-box">{{ $pegawai->alamat_domisili ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">No. Telepon/HP</label><div class="detail-box">{{ $pegawai->no_telepon ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Email</label><div class="detail-box">{{ $pegawai->email ?? '-' }}</div></div>
                                </div>
                            </div>

                            <div class="sub-tab-content" id="kependudukan" style="display: none;">
                                <div class="row g-3">
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Nomor KTP</label><div class="detail-box">{{ $pegawai->nomor_ktp ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Nomor KK</label><div class="detail-box">{{ $pegawai->nomor_kk ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Warga Negara</label><div class="detail-box">{{ $pegawai->warga_negara ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Provinsi KTP</label><div class="detail-box">{{ $pegawai->provinsi_ktp ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Kabupaten/Kota KTP</label><div class="detail-box">{{ $pegawai->kabupaten_ktp ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Kecamatan KTP</label><div class="detail-box">{{ $pegawai->kecamatan_ktp ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Kelurahan KTP</label><div class="detail-box">{{ $pegawai->kelurahan_ktp ?? '-' }}</div></div>
                                    <div class="col-md-6 form-group"><label class="small text-dark fw-medium mb-1">Kode Pos KTP</label><div class="detail-box">{{ $pegawai->kode_pos_ktp ?? '-' }}</div></div>
                                    <div class="col-md-12 form-group"><label class="small text-dark fw-medium mb-1">Alamat KTP</label><div class="detail-box">{{ $pegawai->alamat_ktp ?? '-' }}</div></div>
                                </div>
                            </div>

                           <div class="sub-tab-content" id="efile" style="display: none;">
                                <div class="efile-header">
                                    <h4>Dokumen</h4>
                                    <button class="btn btn-tambah" data-bs-toggle="modal" data-bs-target="#tambahDokumenModal"><i class="lni lni-plus me-1"></i> Tambah</button>
                                </div>
                                @php
                                    $groupedFiles = $pegawai->efiles->groupBy('kategori_dokumen');
                                    $kategoriMap = ['biodata' => 'Biodata', 'pendidikan' => 'Pendidikan', 'jf' => 'Jabatan Fungsional', 'sk' => 'Surat Keputusan', 'sp' => 'Surat Penting', 'lain' => 'Lain-lain'];
                                @endphp
                                @if($pegawai->efiles->isEmpty())
                                    <div class="text-center text-muted mt-5 py-5"><p>Belum ada dokumen E-File yang diunggah.</p></div>
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
                                                                $badgeClass = 'badge-scan';
                                                                if ($keaslian == 'asli') $badgeClass = 'badge-asli';
                                                                if ($keaslian == 'legalisir') $badgeClass = 'badge-legalisir';
                                                            @endphp
                                                            <span class="file-badge {{ $badgeClass }}">{{ $file->keaslian_dokumen ?? 'N/A' }}</span>
                                                            <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                                            <p title="{{ $file->file_name }}">{{ $file->nama_dokumen }}<span>{{ \Carbon\Carbon::parse($file->tanggal_dokumen)->isoFormat('D MMM YYYY') }}</span></p>
                                                            <div class="file-item-actions">
                                                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">Lihat</a>
                                                                <form action="{{ route('efile.destroy', $file->id) }}" method="POST" class="d-inline form-hapus-efile w-100">
                                                                    @csrf @method('DELETE')
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
                                <div class="d-flex align-items-center flex-wrap gap-2 mb-3">
                                    <form action="{{ route('pegawai.show', $pegawai->id) }}" method="GET" class="d-flex gap-2 me-auto">
                                        <input type="hidden" name="tab" value="sk"><input type="hidden" name="subtab" value="penetapan-pangkat">
                                        <div class="input-group"><span class="input-group-text"><i class="fas fa-search"></i></span><input type="text" name="search_pangkat" class="form-control" placeholder="Cari No SK/Golongan..." value="{{ request('search_pangkat') }}"></div>
                                        <select name="tahun_pangkat" class="form-select" style="width: auto;" onchange="this.form.submit()"><option value="">Semua Tahun</option>@foreach ($tahunOptions['pangkat'] as $tahun)<option value="{{ $tahun }}" {{ request('tahun_pangkat') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>@endforeach</select>
                                    </form>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('pangkat.export', ['pegawai' => $pegawai->id, 'search_pangkat' => request('search_pangkat'), 'tahun_pangkat' => request('tahun_pangkat')]) }}" class="btn btn-outline-success"><i class="fa fa-file-export me-2"></i>Export</a>
                                        <button class="btn btn-success btn-tambah" type="button" data-bs-toggle="modal" data-bs-target="#pangkatModal" data-store-url="{{ route('pangkat.store', $pegawai->id) }}"><i class="fa fa-plus me-2"></i>Tambah</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="text-center"><tr><th>Golongan</th><th>Persetujuan BKN</th><th>Tgl BKN</th><th>Nomor SK</th><th>Tgl SK</th><th>TMT</th><th>File</th><th>Aksi</th></tr></thead>
                                        <tbody>
                                            @forelse ($pegawai->penetapanPangkats as $item)
                                                <tr>
                                                    <td class="text-center">{{ $item->golongan }}</td>
                                                    <td>{{ $item->nomor_bkn }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_bkn)->isoFormat('D MMM YYYY') }}</td>
                                                    <td>{{ $item->nomor_sk }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_sk)->isoFormat('D MMM YYYY') }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tmt_pangkat)->isoFormat('D MMM YYYY') }}</td>
                                                    <td class="text-center">@if($item->file_path)<a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>@else - @endif</td>
                                                    <td class="text-center">
                                                        <button class="btn btn-warning btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#pangkatModal" data-item='@json($item)' data-update-url="{{ route('pangkat.update', ['pegawai' => $pegawai->id, 'pangkat' => $item->id]) }}"><i class="fa fa-edit"></i></button>
                                                        <form action="{{ route('pangkat.destroy', ['pegawai' => $pegawai->id, 'pangkat' => $item->id]) }}" method="POST" class="d-inline form-hapus-sk">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="8" class="text-center">Data tidak ditemukan.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="sub-tab-content" id="jabatan" style="display: none;">
                                 <div class="d-flex align-items-center flex-wrap gap-2 mb-3">
                                    <form action="{{ route('pegawai.show', $pegawai->id) }}" method="GET" class="d-flex gap-2 me-auto">
                                        <input type="hidden" name="tab" value="sk"><input type="hidden" name="subtab" value="jabatan">
                                        <div class="input-group"><span class="input-group-text"><i class="fas fa-search"></i></span><input type="text" name="search_jabatan" class="form-control" placeholder="Cari No SK/Jabatan..." value="{{ request('search_jabatan') }}"></div>
                                        <select name="tahun_jabatan" class="form-select" style="width: auto;" onchange="this.form.submit()"><option value="">Semua Tahun</option>@foreach ($tahunOptions['jabatan'] as $tahun)<option value="{{ $tahun }}" {{ request('tahun_jabatan') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>@endforeach</select>
                                    </form>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('jabatan.export', ['pegawai' => $pegawai->id, 'search_jabatan' => request('search_jabatan'), 'tahun_jabatan' => request('tahun_jabatan')]) }}" class="btn btn-outline-success"><i class="fa fa-file-export me-2"></i>Export</a>
                                        <button class="btn btn-success btn-tambah" type="button" data-bs-toggle="modal" data-bs-target="#jabatanModal" data-store-url="{{ route('jabatan.store', $pegawai->id) }}"><i class="fa fa-plus me-2"></i>Tambah</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="text-center"><tr><th>No</th><th>Nama Jabatan</th><th>Jenis SK</th><th>Nomor SK</th><th>Tgl SK</th><th>TMT</th><th>File</th><th>Aksi</th></tr></thead>
                                        <tbody>
                                            @forelse ($pegawai->jabatans as $index => $item)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td>{{ $item->nama_jabatan }}</td>
                                                    <td>{{ $item->jenis_sk }}</td>
                                                    <td>{{ $item->nomor_sk }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_sk)->isoFormat('D MMM YYYY') }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tmt_jabatan)->isoFormat('D MMM YYYY') }}</td>
                                                    <td class="text-center">@if($item->file_path)<a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>@else - @endif</td>
                                                    <td class="text-center">
                                                        <button class="btn btn-warning btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#jabatanModal" data-item='@json($item)' data-update-url="{{ route('jabatan.update', ['pegawai' => $pegawai->id, 'jabatan' => $item->id]) }}"><i class="fa fa-edit"></i></button>
                                                        <form action="{{ route('jabatan.destroy', ['pegawai' => $pegawai->id, 'jabatan' => $item->id]) }}" method="POST" class="d-inline form-hapus-sk">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="8" class="text-center">Data tidak ditemukan.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="sub-tab-content" id="jabatan-saat-ini" style="display: none;">
                                <div class="d-flex align-items-center flex-wrap gap-2 mb-3">
                                    <form action="{{ route('pegawai.show', $pegawai->id) }}" method="GET" class="d-flex gap-2 me-auto">
                                        <input type="hidden" name="tab" value="sk"><input type="hidden" name="subtab" value="jabatan-saat-ini">
                                        <div class="input-group"><span class="input-group-text"><i class="fas fa-search"></i></span><input type="text" name="search_jabatan_saat_ini" class="form-control" placeholder="Cari No SK/Jabatan..." value="{{ request('search_jabatan_saat_ini') }}"></div>
                                        <select name="tahun_jabatan_saat_ini" class="form-select" style="width: auto;" onchange="this.form.submit()"><option value="">Semua Tahun</option>@foreach ($tahunOptions['jabatanSaatIni'] as $tahun)<option value="{{ $tahun }}" {{ request('tahun_jabatan_saat_ini') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>@endforeach</select>
                                    </form>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('jabatan-saat-ini.export', ['pegawai' => $pegawai->id, 'search_jabatan_saat_ini' => request('search_jabatan_saat_ini'), 'tahun_jabatan_saat_ini' => request('tahun_jabatan_saat_ini')]) }}" class="btn btn-outline-success"><i class="fa fa-file-export me-2"></i>Export</a>
                                        <button class="btn btn-success btn-tambah" type="button" data-bs-toggle="modal" data-bs-target="#jabatanSaatIniModal" data-store-url="{{ route('jabatan-saat-ini.store', $pegawai->id) }}"><i class="fa fa-plus me-2"></i>Tambah</button>
                                    </div>
                                </div>
                               <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="text-center"><tr><th>Nama Jabatan</th><th>Jenis Jabatan</th><th>Nomor SK</th><th>File</th><th>Aksi</th></tr></thead>
                                        <tbody>
                                            @forelse ($pegawai->jabatanSaatInis as $item)
                                                <tr>
                                                    <td>{{ $item->nama_jabatan }}</td>
                                                    <td>{{ $item->jenis_jabatan }}</td>
                                                    <td>{{ $item->nomor_sk }}</td>
                                                    <td class="text-center">@if($item->file_path)<a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>@else - @endif</td>
                                                    <td class="text-center">
                                                        <button class="btn btn-warning btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#jabatanSaatIniModal" data-item='@json($item)' data-update-url="{{ route('jabatan-saat-ini.update', ['pegawai' => $pegawai->id, 'jabatanSaatIni' => $item->id]) }}"><i class="fa fa-edit"></i></button>
                                                        <form action="{{ route('jabatan-saat-ini.destroy', ['pegawai' => $pegawai->id, 'jabatanSaatIni' => $item->id]) }}" method="POST" class="d-inline form-hapus-sk">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="5" class="text-center">Data tidak ditemukan.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="sub-tab-content" id="pensiun" style="display: none;">
                                <div class="d-flex align-items-center flex-wrap gap-2 mb-3">
                                    <form action="{{ route('pegawai.show', $pegawai->id) }}" method="GET" class="d-flex gap-2 me-auto">
                                        <input type="hidden" name="tab" value="sk"><input type="hidden" name="subtab" value="pensiun">
                                        <div class="input-group"><span class="input-group-text"><i class="fas fa-search"></i></span><input type="text" name="search_pensiun" class="form-control" placeholder="Cari No SK..." value="{{ request('search_pensiun') }}"></div>
                                        <select name="tahun_pensiun" class="form-select" style="width: auto;" onchange="this.form.submit()"><option value="">Semua Tahun</option>@foreach ($tahunOptions['pensiun'] as $tahun)<option value="{{ $tahun }}" {{ request('tahun_pensiun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>@endforeach</select>
                                    </form>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('pensiun.export', ['pegawai' => $pegawai->id, 'search_pensiun' => request('search_pensiun'), 'tahun_pensiun' => request('tahun_pensiun')]) }}" class="btn btn-outline-success"><i class="fa fa-file-export me-2"></i>Export</a>
                                        <button class="btn btn-success btn-tambah" type="button" data-bs-toggle="modal" data-bs-target="#pensiunModal" data-store-url="{{ route('pensiun.store', $pegawai->id) }}"><i class="fa fa-plus me-2"></i>Tambah</button>
                                    </div>
                                </div>
                               <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="text-center"><tr><th>No</th><th>Jenis Pensiun</th><th>Nomor SK</th><th>Tgl SK</th><th>TMT Pensiun</th><th>File</th><th>Aksi</th></tr></thead>
                                        <tbody>
                                            @forelse ($pegawai->pensiuns as $index => $item)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td>{{ $item->jenis_pensiun }}</td>
                                                    <td>{{ $item->nomor_sk }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_sk)->isoFormat('D MMM YYYY') }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tmt_pensiun)->isoFormat('D MMM YYYY') }}</td>
                                                    <td class="text-center">@if($item->file_path)<a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>@else - @endif</td>
                                                    <td class="text-center">
                                                        <button class="btn btn-warning btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#pensiunModal" data-item='@json($item)' data-update-url="{{ route('pensiun.update', ['pegawai' => $pegawai->id, 'pensiun' => $item->id]) }}"><i class="fa fa-edit"></i></button>
                                                        <form action="{{ route('pensiun.destroy', ['pegawai' => $pegawai->id, 'pensiun' => $item->id]) }}" method="POST" class="d-inline form-hapus-sk">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="7" class="text-center">Data tidak ditemukan.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="sub-tab-content" id="sk-kenaikan-gaji" style="display: none;">
                                <div class="d-flex align-items-center flex-wrap gap-2 mb-3">
                                    <form action="{{ route('pegawai.show', $pegawai->id) }}" method="GET" class="d-flex gap-2 me-auto">
                                        <input type="hidden" name="tab" value="sk"><input type="hidden" name="subtab" value="sk-kenaikan-gaji">
                                        <div class="input-group"><span class="input-group-text"><i class="fas fa-search"></i></span><input type="text" name="search_gaji_berkala" class="form-control" placeholder="Cari No SK..." value="{{ request('search_gaji_berkala') }}"></div>
                                        <select name="tahun_gaji_berkala" class="form-select" style="width: auto;" onchange="this.form.submit()"><option value="">Semua Tahun</option>@foreach ($tahunOptions['gajiBerkala'] as $tahun)<option value="{{ $tahun }}" {{ request('tahun_gaji_berkala') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>@endforeach</select>
                                    </form>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('gaji-berkala.export', ['pegawai' => $pegawai->id, 'search_gaji_berkala' => request('search_gaji_berkala'), 'tahun_gaji_berkala' => request('tahun_gaji_berkala')]) }}" class="btn btn-outline-success"><i class="fa fa-file-export me-2"></i>Export</a>
                                        <button class="btn btn-success btn-tambah" type="button" data-bs-toggle="modal" data-bs-target="#gajiBerkalaModal" data-store-url="{{ route('gaji-berkala.store', $pegawai->id) }}"><i class="fa fa-plus me-2"></i>Tambah</button>
                                    </div>
                                </div>
                               <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="text-center"><tr><th>No</th><th>Golongan</th><th>Nomor SK</th><th>Tgl SK</th><th>TMT Gaji</th><th>Gaji Pokok</th><th>File</th><th>Aksi</th></tr></thead>
                                        <tbody>
                                            @forelse ($pegawai->kenaikanGajiBerkalas as $index => $item)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td class="text-center">{{ $item->golongan }}</td>
                                                    <td>{{ $item->nomor_sk }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_sk)->isoFormat('D MMM YYYY') }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tmt_gaji)->isoFormat('D MMM YYYY') }}</td>
                                                    <td>Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}</td>
                                                    <td class="text-center">@if($item->file_path)<a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>@else - @endif</td>
                                                    <td class="text-center">
                                                        <button class="btn btn-warning btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#gajiBerkalaModal" data-item='@json($item)' data-update-url="{{ route('gaji-berkala.update', ['pegawai' => $pegawai->id, 'gajiBerkala' => $item->id]) }}"><i class="fa fa-edit"></i></button>
                                                        <form action="{{ route('gaji-berkala.destroy', ['pegawai' => $pegawai->id, 'gajiBerkala' => $item->id]) }}" method="POST" class="d-inline form-hapus-sk">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="8" class="text-center">Data tidak ditemukan.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="sub-tab-content" id="sk-tugas-belajar" style="display: none;">
                                <div class="d-flex align-items-center flex-wrap gap-2 mb-3">
                                    <form action="{{ route('pegawai.show', $pegawai->id) }}" method="GET" class="d-flex gap-2 me-auto">
                                        <input type="hidden" name="tab" value="sk"><input type="hidden" name="subtab" value="sk-tugas-belajar">
                                        <div class="input-group"><span class="input-group-text"><i class="fas fa-search"></i></span><input type="text" name="search_tugas_belajar" class="form-control" placeholder="Cari No SK..." value="{{ request('search_tugas_belajar') }}"></div>
                                        <select name="tahun_tugas_belajar" class="form-select" style="width: auto;" onchange="this.form.submit()"><option value="">Semua Tahun</option>@foreach ($tahunOptions['tugasBelajar'] as $tahun)<option value="{{ $tahun }}" {{ request('tahun_tugas_belajar') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>@endforeach</select>
                                    </form>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('tugas-belajar.export', ['pegawai' => $pegawai->id, 'search_tugas_belajar' => request('search_tugas_belajar'), 'tahun_tugas_belajar' => request('tahun_tugas_belajar')]) }}" class="btn btn-outline-success"><i class="fa fa-file-export me-2"></i>Export</a>
                                        <button class="btn btn-success btn-tambah" type="button" data-bs-toggle="modal" data-bs-target="#tugasBelajarModal" data-store-url="{{ route('tugas-belajar.store', $pegawai->id) }}"><i class="fa fa-plus me-2"></i>Tambah</button>
                                    </div>
                                </div>
                               <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="text-center"><tr><th>No</th><th>Jenis Tugas Belajar</th><th>Nomor SK</th><th>Tgl SK</th><th>Tgl Mulai</th><th>Tgl Selesai</th><th>File</th><th>Aksi</th></tr></thead>
                                        <tbody>
                                            @forelse ($pegawai->tugasBelajars as $index => $item)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td>{{ $item->jenis_tugas_belajar }}</td>
                                                    <td>{{ $item->nomor_sk }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_sk)->isoFormat('D MMM YYYY') }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->isoFormat('D MMM YYYY') }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_selesai)->isoFormat('D MMM YYYY') }}</td>
                                                    <td class="text-center">@if($item->file_path)<a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>@else - @endif</td>
                                                    <td class="text-center">
                                                        <button class="btn btn-warning btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#tugasBelajarModal" data-item='@json($item)' data-update-url="{{ route('tugas-belajar.update', ['pegawai' => $pegawai->id, 'tugasBelajar' => $item->id]) }}"><i class="fa fa-edit"></i></button>
                                                        <form action="{{ route('tugas-belajar.destroy', ['pegawai' => $pegawai->id, 'tugasBelajar' => $item->id]) }}" method="POST" class="d-inline form-hapus-sk">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="8" class="text-center">Data tidak ditemukan.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="sub-tab-content" id="sk-non-pns" style="display: none;">
                                <div class="d-flex align-items-center flex-wrap gap-2 mb-3">
                                    <form action="{{ route('pegawai.show', $pegawai->id) }}" method="GET" class="d-flex gap-2 me-auto">
                                        <input type="hidden" name="tab" value="sk"><input type="hidden" name="subtab" value="sk-non-pns">
                                        <div class="input-group"><span class="input-group-text"><i class="fas fa-search"></i></span><input type="text" name="search_sk_non_pns" class="form-control" placeholder="Cari No SK..." value="{{ request('search_sk_non_pns') }}"></div>
                                        <select name="tahun_sk_non_pns" class="form-select" style="width: auto;" onchange="this.form.submit()"><option value="">Semua Tahun</option>@foreach ($tahunOptions['skNonPns'] as $tahun)<option value="{{ $tahun }}" {{ request('tahun_sk_non_pns') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>@endforeach</select>
                                    </form>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('sk-non-pns.export', ['pegawai' => $pegawai->id, 'search_sk_non_pns' => request('search_sk_non_pns'), 'tahun_sk_non_pns' => request('tahun_sk_non_pns')]) }}" class="btn btn-outline-success"><i class="fa fa-file-export me-2"></i>Export</a>
                                        <button class="btn btn-success btn-tambah" type="button" data-bs-toggle="modal" data-bs-target="#nonPnsModal" data-store-url="{{ route('sk-non-pns.store', $pegawai->id) }}"><i class="fa fa-plus me-2"></i>Tambah</button>
                                    </div>
                                </div>
                               <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="text-center"><tr><th>No</th><th>Jenis SK</th><th>Nomor SK</th><th>Tgl SK</th><th>Tgl Mulai</th><th>Tgl Selesai</th><th>File</th><th>Aksi</th></tr></thead>
                                        <tbody>
                                            @forelse ($pegawai->skNonPns as $index => $item)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td>{{ $item->jenis_sk }}</td>
                                                    <td>{{ $item->nomor_sk }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_sk)->isoFormat('D MMM YYYY') }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->isoFormat('D MMM YYYY') }}</td>
                                                    <td class="text-center">{{ $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->isoFormat('D MMM YYYY') : '-' }}</td>
                                                    <td class="text-center">@if($item->file_path)<a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>@else - @endif</td>
                                                    <td class="text-center">
                                                        <button class="btn btn-warning btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#nonPnsModal" data-item='@json($item)' data-update-url="{{ route('sk-non-pns.update', ['pegawai' => $pegawai->id, 'skNonPn' => $item->id]) }}"><i class="fa fa-edit"></i></button>
                                                        <form action="{{ route('sk-non-pns.destroy', ['pegawai' => $pegawai->id, 'skNonPn' => $item->id]) }}" method="POST" class="d-inline form-hapus-sk">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="8" class="text-center">Data tidak ditemukan.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="main-tab-content" id="pendidikan-content" style="display: none;">
                            <div class="card">
                                {{-- PERUBAHAN DIMULAI DARI SINI: Mengganti ul.nav-tabs dengan div.sub-tab-nav --}}
                                <div id="pendidikan-sub-tabs-detail" class="sub-tab-nav d-flex flex-wrap gap-2 mb-4">
                                    <button type="button" class="btn active" data-tab="pengajaran-lama-detail">Pengajaran Lama</button>
                                    <button type="button" class="btn" data-tab="pengajaran-luar-detail">Pengajaran Luar IPB</button>
                                    <button type="button" class="btn" data-tab="pengujian-lama-detail">Pengujian Lama</button>
                                    <button type="button" class="btn" data-tab="pembimbing-lama-detail">Pembimbing Lama</button>
                                    <button type="button" class="btn" data-tab="penguji-luar-detail">Penguji Luar IPB</button>
                                    <button type="button" class="btn" data-tab="pembimbing-luar-detail">Pembimbing Luar IPB</button>
                                </div>

                                <div class="tab-content" id="pendidikanTabContentDetail">
                                    {{-- PERUBAHAN KELAS DAN STYLE PADA SETIAP PANEL KONTEN --}}
                                    <div class="sub-tab-content" id="pengajaran-lama-detail" style="display: block;">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered">
                                                <thead class="table-light"><tr class="text-center"><th>Tahun Semester</th><th>Mata Kuliah</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                                <tbody>
                                                    @forelse ($dataPengajaranLama as $item)
                                                    <tr>
                                                        <td class="text-center">{{ $item->tahun_semester }}</td>
                                                        <td>{{ $item->nama_mk }} ({{$item->kode_mk}})</td>
                                                        <td class="text-center">
                                                            @if ($item->status_verifikasi == 'diverifikasi') <i class="fas fa-check-circle text-success" title="Diverifikasi"></i>
                                                            @elseif ($item->status_verifikasi == 'ditolak') <i class="fas fa-times-circle text-danger" title="Ditolak"></i>
                                                            @else <i class="fas fa-question-circle text-warning" title="Menunggu"></i> @endif
                                                        </td>
                                                        <td class="text-center"><a href="{{ $item->file_path ? Storage::url($item->file_path) : '#' }}" class="btn btn-sm btn-lihat text-white {{ $item->file_path ? '' : 'disabled' }}" target="_blank">Lihat</a></td>
                                                        <td class="text-center">
                                                            <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-pengajaran-lama" title="Lihat Detail" data-bs-toggle="modal" data-bs-target="#modalDetailPengajaranLama" data-id="{{ $item->id }}"><i class="fa fa-eye"></i></a>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr><td colspan="5" class="text-center text-muted">Data tidak ditemukan.</td></tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-end mt-4">
                                            @if ($dataPengajaranLama->hasPages())
                                                <nav aria-label="Page navigation">
                                                    {{ $dataPengajaranLama->links('pagination::bootstrap-5') }}
                                                </nav>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="sub-tab-content" id="pengajaran-luar-detail" style="display: none;">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered">
                                                <thead class="table-light"><tr class="text-center"><th>Institusi</th><th>Mata Kuliah</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                                <tbody>
                                                    @forelse ($dataPengajaranLuar as $item)
                                                    <tr>
                                                        <td>{{ $item->universitas }}</td>
                                                        <td>{{ $item->nama_mk }}</td>
                                                        <td class="text-center">
                                                            @if ($item->status_verifikasi == 'diverifikasi') <i class="fas fa-check-circle text-success" title="Diverifikasi"></i>
                                                            @elseif ($item->status_verifikasi == 'ditolak') <i class="fas fa-times-circle text-danger" title="Ditolak"></i>
                                                            @else <i class="fas fa-question-circle text-warning" title="Menunggu"></i> @endif
                                                        </td>
                                                        <td class="text-center"><a href="{{ $item->file_path ? Storage::url($item->file_path) : '#' }}" class="btn btn-sm btn-lihat text-white {{ $item->file_path ? '' : 'disabled' }}" target="_blank">Lihat</a></td>
                                                        <td class="text-center">
                                                            <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-pengajaran-luar" title="Lihat Detail" data-bs-toggle="modal" data-bs-target="#modalDetailPengajaranLuar" data-id="{{ $item->id }}"><i class="fa fa-eye"></i></a>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr><td colspan="5" class="text-center text-muted">Data tidak ditemukan.</td></tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-end mt-4">
                                            @if ($dataPengajaranLuar->hasPages())
                                                <nav aria-label="Page navigation">
                                                    {{ $dataPengajaranLuar->links('pagination::bootstrap-5') }}
                                                </nav>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="sub-tab-content" id="pengujian-lama-detail" style="display: none;">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered">
                                                <thead class="table-light"><tr class="text-center"><th>Nama Mahasiswa</th><th>Departemen</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                                <tbody>
                                                    @forelse ($dataPengujianLama as $item)
                                                    <tr>
                                                        <td>{{ $item->nama_mahasiswa }} ({{$item->nim}})</td>
                                                        <td>{{ $item->departemen }}</td>
                                                        <td class="text-center">
                                                            @if ($item->status_verifikasi == 'diverifikasi') <i class="fas fa-check-circle text-success" title="Diverifikasi"></i>
                                                            @elseif ($item->status_verifikasi == 'ditolak') <i class="fas fa-times-circle text-danger" title="Ditolak"></i>
                                                            @else <i class="fas fa-question-circle text-warning" title="Menunggu"></i> @endif
                                                        </td>
                                                        <td class="text-center"><a href="{{ $item->file_path ? Storage::url($item->file_path) : '#' }}" class="btn btn-sm btn-lihat text-white {{ $item->file_path ? '' : 'disabled' }}" target="_blank">Lihat</a></td>
                                                        <td class="text-center">
                                                            <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-pengujian-lama" title="Lihat Detail" data-bs-toggle="modal" data-bs-target="#modalDetailPengujianLama" data-id="{{ $item->id }}"><i class="fa fa-eye"></i></a>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr><td colspan="5" class="text-center text-muted">Data tidak ditemukan.</td></tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-end mt-4">
                                            @if ($dataPengujianLama->hasPages())
                                                <nav aria-label="Page navigation">
                                                    {{ $dataPengujianLama->links('pagination::bootstrap-5') }}
                                                </nav>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="sub-tab-content" id="pembimbing-lama-detail" style="display: none;">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered">
                                                <thead class="table-light"><tr class="text-center"><th>Kegiatan</th><th>Nama Mahasiswa</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                                <tbody>
                                                    @forelse ($dataPembimbingLama as $item)
                                                    <tr>
                                                        <td class="text-start">{{ Str::limit($item->kegiatan, 40) }}</td>
                                                        <td>{{ $item->nama_mahasiswa }}</td>
                                                        <td class="text-center">
                                                            @if ($item->status_verifikasi == 'diverifikasi') <i class="fas fa-check-circle text-success" title="Diverifikasi"></i>
                                                            @elseif ($item->status_verifikasi == 'ditolak') <i class="fas fa-times-circle text-danger" title="Ditolak"></i>
                                                            @else <i class="fas fa-question-circle text-warning" title="Menunggu"></i> @endif
                                                        </td>
                                                        <td class="text-center"><a href="{{ $item->file_path ? Storage::url($item->file_path) : '#' }}" class="btn btn-sm btn-lihat text-white {{ $item->file_path ? '' : 'disabled' }}" target="_blank">Lihat</a></td>
                                                        <td class="text-center">
                                                            <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-pembimbing-lama" title="Lihat Detail" data-bs-toggle="modal" data-bs-target="#modalDetailPembimbingLama" data-id="{{ $item->id }}"><i class="fa fa-eye"></i></a>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr><td colspan="5" class="text-center text-muted">Data tidak ditemukan.</td></tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-end mt-4">
                                            @if ($dataPembimbingLama->hasPages())
                                                <nav aria-label="Page navigation">
                                                    {{ $dataPembimbingLama->links('pagination::bootstrap-5') }}
                                                </nav>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="sub-tab-content" id="penguji-luar-detail" style="display: none;">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered">
                                                <thead class="table-light"><tr class="text-center"><th>Nama Mahasiswa</th><th>Universitas</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                                <tbody>
                                                    @forelse ($dataPengujiLuar as $item)
                                                    <tr>
                                                        <td>{{ $item->nama_mahasiswa }}</td>
                                                        <td>{{ $item->universitas }}</td>
                                                        <td class="text-center">
                                                            @if ($item->status_verifikasi == 'diverifikasi') <i class="fas fa-check-circle text-success" title="Diverifikasi"></i>
                                                            @elseif ($item->status_verifikasi == 'ditolak') <i class="fas fa-times-circle text-danger" title="Ditolak"></i>
                                                            @else <i class="fas fa-question-circle text-warning" title="Menunggu"></i> @endif
                                                        </td>
                                                        <td class="text-center"><a href="{{ $item->file_path ? Storage::url($item->file_path) : '#' }}" class="btn btn-sm btn-lihat text-white {{ $item->file_path ? '' : 'disabled' }}" target="_blank">Lihat</a></td>
                                                        <td class="text-center">
                                                            <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-penguji-luar" title="Lihat Detail" data-bs-toggle="modal" data-bs-target="#modalDetailPengujiLuar" data-id="{{ $item->id }}"><i class="fa fa-eye"></i></a>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr><td colspan="5" class="text-center text-muted">Data tidak ditemukan.</td></tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-end mt-4">
                                            @if ($dataPengujiLuar->hasPages())
                                                <nav aria-label="Page navigation">
                                                    {{ $dataPengujiLuar->links('pagination::bootstrap-5') }}
                                                </nav>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="sub-tab-content" id="pembimbing-luar-detail" style="display: none;">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered">
                                                <thead class="table-light"><tr class="text-center"><th>Nama Mahasiswa</th><th>Universitas</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                                <tbody>
                                                    @forelse ($dataPembimbingLuar as $item)
                                                    <tr>
                                                        <td>{{ $item->nama_mahasiswa }}</td>
                                                        <td>{{ $item->universitas }}</td>
                                                        <td class="text-center">
                                                            @if ($item->status_verifikasi == 'diverifikasi') <i class="fas fa-check-circle text-success" title="Diverifikasi"></i>
                                                            @elseif ($item->status_verifikasi == 'ditolak') <i class="fas fa-times-circle text-danger" title="Ditolak"></i>
                                                            @else <i class="fas fa-question-circle text-warning" title="Menunggu"></i> @endif
                                                        </td>
                                                        <td class="text-center"><a href="{{ $item->file_path ? Storage::url($item->file_path) : '#' }}" class="btn btn-sm btn-lihat text-white {{ $item->file_path ? '' : 'disabled' }}" target="_blank">Lihat</a></td>
                                                        <td class="text-center">
                                                            <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-pembimbing-luar" title="Lihat Detail" data-bs-toggle="modal" data-bs-target="#modalDetailPembimbingLuar" data-id="{{ $item->id }}"><i class="fa fa-eye"></i></a>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr><td colspan="5" class="text-center text-muted">Data tidak ditemukan.</td></tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-end mt-4">
                                            @if ($dataPembimbingLuar->hasPages())
                                                <nav aria-label="Page navigation">
                                                    {{ $dataPembimbingLuar->links('pagination::bootstrap-5') }}
                                                </nav>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="main-tab-content" id="penelitian-content" style="display: none;">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                  <thead class="table-light text-center align-middle">
                                    <tr>
                                      <th>No</th>
                                      <th>Judul & Penulis</th>
                                      <th>Tgl Terbit</th>
                                      <th>Jenis Karya</th>
                                      <th>Publik</th>
                                      <th>Status</th>
                                      <th>Dokumen</th>
                                      <th>Aksi</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @forelse($penelitianPegawai as $item)
                                    <tr data-row-id="{{ $item->id }}">
                                      <td class="text-center">{{ $loop->iteration + $penelitianPegawai->firstItem() - 1 }}</td>
                                      <td>
                                        {{ $item->judul }}
                                        <small class="text-muted d-block mt-1">
                                          @php
                                              $penulisDisplay = $item->penulis->map(fn($p) => $p->pegawai->nama_lengkap ?? $p->nama_penulis);
                                          @endphp
                                          <i class="fas fa-users me-1"></i> {{ $penulisDisplay->implode(', ') }}
                                        </small>
                                      </td>
                                      <td class="text-center">{{ $item->tanggal_terbit ? $item->tanggal_terbit->format('d M Y') : '-' }}</td>
                                      <td class="text-center">{{ $item->jenis_karya }}</td>
                                      <td class="text-center">{{ $item->is_publik ? 'Ya' : 'Tidak' }}</td>
                                      
                                      <td class="text-center status-cell">
                                        @if ($item->status == 'Sudah Diverifikasi')
                                          <i class="fas fa-check-circle text-success" title="Sudah Diverifikasi"></i>
                                        @elseif ($item->status == 'Ditolak')
                                          <i class="fas fa-times-circle text-danger" title="Ditolak"></i>
                                        @else
                                          <i class="fas fa-question-circle text-warning" title="Belum Diverifikasi"></i>
                                        @endif
                                      </td>
                      
                                      <td class="text-center">
                                        @if($item->dokumen_path)
                                          <a href="{{ asset('storage/' . $item->dokumen_path) }}" target="_blank" class="btn btn-sm btn-lihat text-white">
                                              Lihat
                                          </a>
                                        @else
                                          <span>-</span>
                                        @endif
                                      </td>
                      
                                      <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="#" class="btn-aksi btn-lihat" title="Lihat Detail" onclick="event.preventDefault(); openDetailModal({{ $item->id }})">
                                              <i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                      </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="8" class="text-center py-4">Pegawai ini belum memiliki data penelitian.</td></tr>
                                    @endforelse
                                  </tbody>
                                </table>
                            </div>
                      
                            {{-- Pagination --}}
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="text-muted small">
                                    @if ($penelitianPegawai->total() > 0)
                                        Menampilkan {{ $penelitianPegawai->firstItem() }} sampai {{ $penelitianPegawai->lastItem() }} dari {{ $penelitianPegawai->total() }} data
                                    @else
                                        Tidak ada data untuk ditampilkan
                                    @endif
                                </span>
                                
                                @if ($penelitianPegawai->hasPages())
                                    <div class="d-flex justify-content-end">
                                        {{-- Menambahkan parameter 'tab' agar tetap di tab penelitian saat ganti halaman --}}
                                        {{ $penelitianPegawai->appends(['tab' => 'penelitian'])->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="main-tab-content" id="pengabdian-content" style="display: none;">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr class="text-center">
                                    <th>No</th>
                                    <th>Kegiatan</th>
                                    <th>Nama Kegiatan</th>
                                    <th>Afiliasi</th>
                                    <th>Lokasi</th>
                                    <th>Nomor SK</th>
                                    <th>Tahun</th>
                                    <th>Verifikasi</th>
                                    <th>Dokumen</th>
                                    <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pengabdianPegawai as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $pengabdianPegawai->firstItem() + $index }}</td>
                                        <td class="text-start">{{ $item->kegiatan }}</td>
                                        <td class="text-center">{{ $item->nama_kegiatan }}</td>
                                        <td class="text-center">{{ $item->afiliasi_non_pt ?? '-' }}</td>
                                        <td class="text-center">{{ $item->lokasi ?? '-' }}</td>
                                        <td class="text-center">{{ $item->no_sk_penugasan ?? '-' }}</td>
                                        <td class="text-center">{{ $item->tahun_pelaksanaan ?? '-' }}</td>
                                        <td class="text-center">
                                        @if ($item->status == 'Sudah Diverifikasi')
                                            <i class="fas fa-check-circle text-success" title="Sudah Diverifikasi"></i>
                                        @elseif ($item->status == 'Ditolak')
                                            <i class="fas fa-times-circle text-danger" title="Ditolak"></i>
                                        @else
                                            <i class="fas fa-question-circle text-warning" title="Belum Diverifikasi"></i>
                                        @endif
                                        </td>
                                        <td class="text-center">
                                            @if($item->dokumen->isNotEmpty())
                                                <a href="{{ Storage::url($item->dokumen->first()->file_path) }}" target="_blank" class="btn btn-sm btn-lihat text-white">
                                                    Lihat
                                                </a>
                                            @else
                                                <span>-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="#" class="btn-aksi btn-lihat" title="Lihat Detail" data-id="{{ $item->id }}" data-bs-toggle="modal" data-bs-target="#pengabdianDetailModal"><i class="fa fa-eye"></i></a>
                                        </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted">Pegawai ini belum memiliki data pengabdian.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                </table>
                            </div>

                            {{-- Pagination --}}
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <span class="text-muted small">
                                    @if ($pengabdianPegawai->total() > 0)
                                        Menampilkan {{ $pengabdianPegawai->firstItem() }} sampai {{ $pengabdianPegawai->lastItem() }} dari {{ $pengabdianPegawai->total() }} data
                                    @else
                                        Tidak ada data untuk ditampilkan
                                    @endif
                                </span>
                                @if ($pengabdianPegawai->hasPages())
                                    <div class="d-flex justify-content-end">
                                        {{ $pengabdianPegawai->appends(['tab' => 'pengabdian'])->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="main-tab-content" id="penunjang-content" style="display: none;">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="table-light">
                                        <tr class="text-center">
                                        <th>No</th>
                                        <th>Kegiatan</th>
                                        <th>Lingkup</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Instansi</th>
                                        <th>Nomor SK</th>
                                        <th>TMT</th>
                                        <th>TST</th>
                                        <th>Verifikasi</th>
                                        <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($penunjangPegawai as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration + $penunjangPegawai->firstItem() - 1 }}</td>
                                            <td class="text-start">{{ $item->kegiatan }}</td>
                                            <td class="text-center">{{ $item->lingkup }}</td>
                                            <td class="text-center">{{ $item->nama_kegiatan }}</td>
                                            <td class="text-center">{{ $item->instansi }}</td>
                                            <td class="text-center">{{ $item->nomor_sk }}</td>
                                            <td class="text-center">{{ \Carbon\Carbon::parse($item->tmt_mulai)->format('d M Y') }}</td>
                                            <td class="text-center">{{ \Carbon\Carbon::parse($item->tmt_selesai)->format('d M Y') }}</td>
                                            <td class="text-center">
                                                @if ($item->status == 'Sudah Diverifikasi')
                                                    <i class="fas fa-check-circle text-success" title="Sudah Diverifikasi"></i>
                                                @elseif ($item->status == 'Ditolak')
                                                    <i class="fas fa-times-circle text-danger" title="Ditolak"></i>
                                                @else
                                                    <i class="fas fa-question-circle text-warning" title="Belum Diverifikasi"></i>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <a href="#" class="btn-aksi btn-lihat" title="Lihat Detail" 
                                                    data-id="{{ $item->id }}" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#penunjangDetailModal">
                                                    <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="10" class="text-center">Pegawai ini belum memiliki data penunjang.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Pagination --}}
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <span class="text-muted small">
                                    @if ($penunjangPegawai->total() > 0)
                                        Menampilkan {{ $penunjangPegawai->firstItem() }} sampai {{ $penunjangPegawai->lastItem() }} dari {{ $penunjangPegawai->total() }} data
                                    @else
                                        Tidak ada data untuk ditampilkan
                                    @endif
                                </span>
                                @if ($penunjangPegawai->hasPages())
                                    <div class="d-flex justify-content-end">
                                        {{ $penunjangPegawai->appends(['tab' => 'penunjang'])->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="main-tab-content" id="pelatihan-content" style="display: none;">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="table-light">
                                        <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Penyelenggara</th>
                                        <th>Posisi</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Dokumen</th>
                                        <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pelatihanPegawai as $pelatihan)
                                        <tr>
                                            <td class="text-center">{{ $pelatihanPegawai->firstItem() + $loop->index }}</td>
                                            <td class="text-start">{{ $pelatihan->nama_kegiatan }}</td>
                                            <td class="text-center">{{ $pelatihan->penyelenggara }}</td>
                                            <td class="text-center">
                                            {{ $pelatihan->posisi === 'Lainnya' ? $pelatihan->posisi_lainnya : $pelatihan->posisi }}
                                            </td>
                                            <td class="text-center">{{ $pelatihan->tgl_mulai->format('d F Y') }}</td>
                                            <td class="text-center">{{ $pelatihan->tgl_selesai->format('d F Y') }}</td>
                                            <td class="text-center">
                                                <a href="{{ asset('storage/' . $pelatihan->file_path) }}" 
                                                    target="_blank" 
                                                    class="btn btn-sm btn-lihat text-white">Lihat</a>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-detail-pelatihan" 
                                                    title="Lihat Detail"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalDetailPelatihan"
                                                    data-pegawai="{{ $pelatihan->pegawai->nama_lengkap ?? 'N/A' }}"
                                                    data-nama_kegiatan="{{ $pelatihan->nama_kegiatan }}"
                                                    data-posisi="{{ $pelatihan->posisi === 'Lainnya' ? $pelatihan->posisi_lainnya : $pelatihan->posisi }}"
                                                    data-kota="{{ $pelatihan->kota }}"
                                                    data-lokasi="{{ $pelatihan->lokasi }}"
                                                    data-penyelenggara="{{ $pelatihan->penyelenggara }}"
                                                    data-jenis_diklat="{{ $pelatihan->jenis_diklat }}"
                                                    data-tgl_mulai="{{ $pelatihan->tgl_mulai->format('d F Y') }}"
                                                    data-tgl_selesai="{{ $pelatihan->tgl_selesai->format('d F Y') }}"
                                                    data-lingkup="{{ $pelatihan->lingkup }}"
                                                    data-jam="{{ $pelatihan->jumlah_jam }}"
                                                    data-hari="{{ $pelatihan->jumlah_hari }}"
                                                    data-struktural="{{ $pelatihan->struktural ? 'Ya' : 'Tidak' }}"
                                                    data-sertifikasi="{{ $pelatihan->sertifikasi ? 'Ya' : 'Tidak' }}"
                                                    data-dokumen_path="{{ asset('storage/' . $pelatihan->file_path) }}">
                                                    <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">Pegawai ini belum memiliki data diklat.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Pagination --}}
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <span class="text-muted small">
                                    @if ($pelatihanPegawai->total() > 0)
                                        Menampilkan {{ $pelatihanPegawai->firstItem() }} sampai {{ $pelatihanPegawai->lastItem() }} dari {{ $pelatihanPegawai->total() }} data
                                    @else
                                        Tidak ada data untuk ditampilkan
                                    @endif
                                </span>
                                @if ($pelatihanPegawai->hasPages())
                                    <div class="d-flex justify-content-end">
                                        {{ $pelatihanPegawai->appends(['tab' => 'pelatihan'])->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="main-tab-content" id="penghargaan-content" style="display: none;">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="table-light">
                                        <tr class="text-center">
                                        <th>No</th>
                                        <th>Kegiatan</th>
                                        <th>Penghargaan</th>
                                        <th>Nomor SK</th>
                                        <th>Lingkup</th>
                                        <th>Tahun</th>
                                        <th>Dokumen</th>
                                        <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($penghargaanPegawai as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration + $penghargaanPegawai->firstItem() - 1 }}</td>
                                            <td class="text-start">{{ $item->kegiatan }}</td>
                                            <td class="text-center">{{ $item->nama_penghargaan }}</td>
                                            <td class="text-center">{{ $item->nomor_sk }}</td>
                                            <td class="text-center">{{ $item->lingkup }}</td>
                                            <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_perolehan)->format('Y') }}</td>
                                            <td class="text-center">
                                                <a href="{{ asset('storage/' . $item->file_path) }}" 
                                                target="_blank"
                                                class="btn btn-sm btn-lihat text-white">Lihat</a>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <a href="#" class="btn-aksi btn-lihat-detail btn-lihat-detail-penghargaan"
                                                    title="Lihat Detail"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalDetailPenghargaan"
                                                    data-pegawai="{{ $item->pegawai->nama_lengkap ?? '' }}"
                                                    data-kegiatan="{{ $item->kegiatan }}"
                                                    data-nama_penghargaan="{{ $item->nama_penghargaan }}"
                                                    data-nomor="{{ $item->nomor_sk }}"
                                                    data-tanggal_perolehan="{{ \Carbon\Carbon::parse($item->tanggal_perolehan)->isoFormat('D MMMM YYYY') }}"
                                                    data-lingkup="{{ $item->lingkup }}"
                                                    data-negara="{{ $item->negara }}"
                                                    data-instansi="{{ $item->instansi_pemberi }}"
                                                    data-jenis_dokumen="{{ $item->jenis_dokumen }}"
                                                    data-nama_dokumen="{{ $item->nama_dokumen }}"
                                                    data-nomor_dokumen="{{ $item->nomor_dokumen ?? '-' }}"
                                                    data-tautan="{{ $item->tautan ?? '#' }}"
                                                    data-dokumen_path="{{ asset('storage/' . $item->file_path) }}">
                                                    <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">Pegawai ini belum memiliki data penghargaan.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Pagination --}}
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <span class="text-muted small">
                                    @if ($penghargaanPegawai->total() > 0)
                                        Menampilkan {{ $penghargaanPegawai->firstItem() }} sampai {{ $penghargaanPegawai->lastItem() }} dari {{ $penghargaanPegawai->total() }} data
                                    @else
                                        Tidak ada data untuk ditampilkan
                                    @endif
                                </span>
                                @if ($penghargaanPegawai->hasPages())
                                    <div class="d-flex justify-content-end">
                                        {{ $penghargaanPegawai->appends(['tab' => 'penghargaan'])->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="main-tab-content" id="pembicara-content" style="display: none;">
                        {{-- 1. Isi konten tab pembicara --}}
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Judul Makalah</th>
                                        <th>Kategori Pembicara</th>
                                        <th>Nama Pertemuan</th>
                                        <th>Tanggal</th>
                                        <th>Verifikasi</th>
                                        <th>Dokumen</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    {{-- 2. Gunakan variabel $pembicaraPegawai --}}
                                    @forelse ($pembicaraPegawai as $item)
                                        <tr>
                                            <td>{{ $loop->iteration + $pembicaraPegawai->firstItem() - 1 }}</td>
                                            <td class="text-start">{{ Str::limit($item->judul_makalah, 40) }}</td>
                                            <td>{{ Str::limit(ucfirst($item->kategori_pembicara), 20) }}</td>
                                            <td class="text-start">{{ Str::limit($item->nama_pertemuan, 40) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_pelaksana)->translatedFormat('d M Y') }}</td>
                                            <td>
                                                @if($item->status_verifikasi == 'belum_diverifikasi')
                                                    <span class="badge rounded-circle bg-warning text-white" title="Belum Diverifikasi"><i class="fa fa-question"></i></span>
                                                @elseif($item->status_verifikasi == 'sudah_diverifikasi')
                                                    <span class="badge rounded-circle bg-success text-white" title="Sudah Diverifikasi"><i class="fa fa-check"></i></span>
                                                @else
                                                    <span class="badge rounded-circle bg-danger text-white" title="Ditolak"><i class="fa fa-times"></i></span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->dokumen->isNotEmpty() && $item->dokumen->first()->file_path)
                                                    <a href="{{ asset($item->dokumen->first()->file_path) }}" class="btn btn-sm btn-lihat" target="_blank">Lihat</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{-- 3. Sederhanakan Aksi --}}
                                                <button class="btn-aksi btn-lihat btn-detail-pembicara" 
                                                        title="Lihat Detail"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#detailPembicaraModal" 
                                                        data-id="{{ $item->id }}">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">Data pembicara belum tersedia untuk pegawai ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
    
                    {{-- 4. Tambahkan Pagination --}}
                    @if ($pembicaraPegawai->hasPages())
                        <div class="d-flex justify-content-end mt-4">
                            {{ $pembicaraPegawai->appends(['tab' => 'pembicara'])->links() }}
                        </div>
                    @endif
                </div>

                        <div class="main-tab-content" id="orasi-ilmiah-content" style="display: none;">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered align-middle">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Kategori Pembicara</th>
                                            <th>Judul Makalah</th>
                                            <th>Nama Pertemuan</th>
                                            <th>Tingkat</th>
                                            <th>Penyelenggara</th>
                                            <th>Tanggal</th>
                                            <th>Verifikasi</th>
                                            <th>Dokumen</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="orasiIlmiahTableBody" class="text-center">
                                        @forelse ($orasiIlmiahPegawai as $item)
                                        <tr>
                                            <td>{{ $loop->iteration + $orasiIlmiahPegawai->firstItem() - 1 }}</td>
                                            <td>{{ $item->kategori_pembicara }}</td>
                                            <td class="text-start">{{ Str::limit($item->judul_makalah, 30) }}</td>
                                            <td class="text-start">{{ Str::limit($item->nama_pertemuan, 30) }}</td>
                                            <td>{{ $item->lingkup }}</td>
                                            <td>{{ $item->penyelenggara }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_pelaksana)->format('d-m-Y') }}</td>
                                            <td>
                                                @if ($item->verifikasi == 'Sudah Diverifikasi')
                                                  <span class="badge rounded-circle bg-success text-white" title="Sudah Diverifikasi"><i class="fa fa-check"></i></span>
                                                @elseif ($item->verifikasi == 'Ditolak')
                                                  <span class="badge rounded-circle bg-danger text-white" title="Ditolak"><i class="fa fa-times"></i></span>
                                                @else
                                                  <span class="badge rounded-circle bg-warning text-white" title="Belum Diverifikasi"><i class="fa fa-question"></i></span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->dokumen)
                                                  <a href="{{ asset('storage/' . $item->dokumen) }}" class="btn btn-sm btn-lihat" target="_blank">Lihat</a>
                                                @else
                                                  -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button 
                                                  class="btn-aksi btn-lihat" 
                                                  title="Lihat Detail"
                                                  data-bs-toggle="modal" 
                                                  data-bs-target="#modalDetailOrasiIlmiah"
                                                  data-pegawai="{{ $item->pegawai->nama_lengkap ?? 'N/A' }}"
                                                  data-litabmas="{{ $item->litabmas ?? '-' }}"
                                                  data-kategori="{{ $item->kategori_pembicara ?? '-' }}"
                                                  data-lingkup="{{ $item->lingkup ?? '-' }}"
                                                  data-judul="{{ $item->judul_makalah ?? '-' }}"
                                                  data-pertemuan="{{ $item->nama_pertemuan ?? '-' }}"
                                                  data-penyelenggara="{{ $item->penyelenggara ?? '-' }}"
                                                  data-tanggal="{{ \Carbon\Carbon::parse($item->tanggal_pelaksana)->format('d F Y') }}"
                                                  data-bahasa="{{ $item->bahasa ?? '-' }}"
                                                  data-jenis-dokumen="{{ $item->jenis_dokumen ?? '-' }}"
                                                  data-nama-dokumen="{{ $item->nama_dokumen ?? '-' }}"
                                                  data-nomor-dokumen="{{ $item->nomor_dokumen ?? '-' }}"
                                                  data-tautan="{{ $item->tautan_dokumen ?? '-' }}"
                                                  data-dokumen-src="{{ $item->dokumen ? asset('storage/' . $item->dokumen) : '' }}">
                                                  <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="10" class="text-center text-muted">Data Orasi Ilmiah belum tersedia</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{-- 4. Tambahkan Pagination --}}
                            @if ($orasiIlmiahPegawai->hasPages())
                                <div class="d-flex justify-content-end mt-4">
                                    {{ $orasiIlmiahPegawai->appends(['tab' => 'orasi-ilmiah'])->links() }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="main-tab-content" id="sertifikat-content" style="display: none;">
                {{-- 1. Ganti placeholder dengan kode tabel di bawah --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>No</th>
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
                            {{-- 2. Ganti variabel di forelse --}}
                            @forelse ($sertifikatKompetensiPegawai as $item)
                            <tr>
                                <td>{{ $loop->iteration + $sertifikatKompetensiPegawai->firstItem() - 1 }}</td>
                                <td>{{ $item->kegiatan }}</td>
                                <td>{{ $item->judul_kegiatan }}</td>
                                <td>{{ $item->lembaga_sertifikasi }}</td>
                                <td>{{ $item->tahun_sertifikasi }}</td>
                                <td>
                                    @if ($item->verifikasi == 'Sudah Diverifikasi')
                                    <span class="badge rounded-circle bg-success text-white" title="Sudah Diverifikasi">
                                        <i class="fa fa-check"></i>
                                    </span>
                                    @elseif ($item->verifikasi == 'Ditolak')
                                    <span class="badge rounded-circle bg-danger text-white" title="Ditolak">
                                        <i class="fa fa-times"></i>
                                    </span>
                                    @else
                                    <span class="badge rounded-circle bg-warning text-white" title="Belum Diverifikasi">
                                        <i class="fa fa-question"></i>
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->dokumen)
                                    <a href="{{ asset('storage/' . $item->dokumen) }}" class="btn btn-sm btn-lihat" target="_blank">Lihat</a>
                                    @else - @endif
                                </td>
                                <td class="text-center">
                                    {{-- 3. Sederhanakan kolom Aksi --}}
                                    <button class="btn-aksi btn-lihat" data-bs-toggle="modal"
                                        data-bs-target="#modalDetailSertifikatKompetensi" title="Lihat Detail"
                                        data-nama="{{ $pegawai->nama_lengkap ?? 'N/A' }}"
                                        data-kegiatan="{{ $item->kegiatan }}"
                                        data-judul="{{ $item->judul_kegiatan }}"
                                        data-no-reg="{{ $item->no_reg_pendidik ?? '-' }}"
                                        data-no-sk="{{ $item->no_sk_sertifikasi }}"
                                        data-tahun="{{ $item->tahun_sertifikasi }}"
                                        data-tmt="{{ \Carbon\Carbon::parse($item->tmt_sertifikasi)->format('d F Y') }}"
                                        data-tst="{{ $item->tst_sertifikasi ? \Carbon\Carbon::parse($item->tst_sertifikasi)->format('d F Y') : '-' }}"
                                        data-bidang="{{ $item->bidang_studi }}"
                                        data-lembaga="{{ $item->lembaga_sertifikasi }}"
                                        data-dokumen="{{ $item->dokumen ? asset('storage/' . $item->dokumen) : '' }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    Data Sertifikat Kompetensi belum tersedia untuk pegawai ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
    
                {{-- 4. Tambahkan Pagination --}}
                @if ($sertifikatKompetensiPegawai->hasPages())
                    <div class="d-flex justify-content-end mt-4">
                        {{ $sertifikatKompetensiPegawai->appends(['tab' => 'sertifikat'])->links() }}
                    </div>
                @endif
            </div>

            <div class="main-tab-content" id="praktisi-content" style="display: none;">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Institusi</th>
                            <th>Jenis Pekerjaan</th>
                            <th>TMT</th>
                            <th>TST</th>
                            <th>Surat Tugas</th>
                            <th>Verifikasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($praktisiPegawai as $index => $praktisi)
                        <tr>
                            <td>{{ $praktisiPegawai->firstItem() + $index }}</td>
                            <td class="text-start">{{ $praktisi->instansi }}</td>
                            <td class="text-start">{{ $praktisi->jenis_pekerjaan }}</td>
                            <td>{{ \Carbon\Carbon::parse($praktisi->tmt)->isoFormat('DD MMM YYYY') }}</td>
                            <td>{{ \Carbon\Carbon::parse($praktisi->tst)->isoFormat('DD MMM YYYY') }}</td>
                            <td>
                                @if ($praktisi->surat_instansi)
                                <a href="{{ asset('storage/' . $praktisi->surat_instansi) }}" target="_blank" class="btn btn-sm btn-lihat text-white px-3">Lihat</a>
                                @else
                                <span class="text-muted fst-italic">Tidak Ada</span>
                                @endif
                            </td>
                            <td>
                                @if($praktisi->status == 'Belum Diverifikasi')
                                <span class="badge rounded-circle bg-warning text-white" title="Belum Diverifikasi"><i class="fa fa-question"></i></span>
                                @elseif($praktisi->status == 'Sudah Diverifikasi')
                                <span class="badge rounded-circle bg-success text-white" title="Sudah Diverifikasi"><i class="fa fa-check"></i></span>
                                @else
                                <span class="badge rounded-circle bg-danger text-white" title="Ditolak"><i class="fa fa-times"></i></span>
                                @endif
                            </td>
                            <td class="text-center">
                                {{-- 3. Aksi hanya berisi tombol lihat detail --}}
                                <a href="#" class="btn-aksi btn-lihat" title="Lihat Detail"
                                    data-bs-toggle="modal" data-bs-target="#detailPraktisiModal"
                                    data-url="{{ route('praktisi.show', $praktisi->id) }}">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Data Praktisi Dunia Industri belum tersedia</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            @if ($praktisiPegawai->hasPages())
                <div class="d-flex justify-content-end mt-4">
                    {{ $praktisiPegawai->appends(['tab' => 'praktisi'])->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
                    </div> 
                </div>
            </div>
        </div>

    <footer class="footer-custom"><span>© 2025 Forest Management — All Rights Reserved</span></footer>
    </div>
</div>

    {{-- Modal General --}}
    @include('components.tambah-efile')
    @include('components.konfirmasi-hapus')
    @include('components.konfirmasi-berhasil')
    
    {{-- Modal Untuk Menu SK (Form Tambah & Edit Gabungan) --}}
    @include('components.pendidikan.tambah-penetapan-pangkat')
    @include('components.pendidikan.tambah-jabatan')
    @include('components.pendidikan.tambah-jabatan-saat-ini')
    @include('components.pendidikan.tambah-pensiun')
    @include('components.pendidikan.tambah-sk-kenaikan-gaji')
    @include('components.pendidikan.tambah-sk-tugas-belajar')
    @include('components.pendidikan.tambah-sk-non-pns')

     {{-- Modal Detail Untuk Menu Pendidikan --}}
    @include('components.pendidikan.detail-pengajaran-lama')
    @include('components.pendidikan.detail-pengajaran-luar')
    @include('components.pendidikan.detail-pengujian-lama')
    @include('components.pendidikan.detail-pembimbing-lama')
    @include('components.pendidikan.detail-penguji-luar')
    @include('components.pendidikan.detail-pembimbing-luar')

    @include('components.penelitian.detail-penelitian')
    @include('components.pengabdian.detail-pengabdian')
    @include('components.penunjang.detail-penunjang')
    @include('components.diklat.detail-diklat')
    @include('components.penghargaan.detail-penghargaan') 
    @include('components.sertifikat-kompetensi.detail-sertifikat-kompetensi')
    @include('components.pembicara.detail-pembicara')
    @include('components.orasi-ilmiah.detail-orasi-ilmiah')
    @include('components.praktisi.detail-praktisiindustri')

    @if (session('success'))
        <div id="success-trigger" data-title="Berhasil!" data-message="{{ session('success') }}" data-active-tab="{{ session('active_tab') }}" data-active-subtab="{{ session('active_subtab') }}"></div>
    @endif
        
<script src="{{ asset('assets/js/layout.js') }}"></script>
<script src="{{ asset('assets/js/detail-pegawai.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

{{-- Asset JS --}}
<script src="{{ asset('assets/js/penelitian.js') }}"></script>
<script src="{{ asset('assets/js/pengabdian.js') }}"></script>
<script src="{{ asset('assets/js/penunjang.js') }}"></script> 
<script src="{{ asset('assets/js/diklat.js') }}"></script> 
<script src="{{ asset('assets/js/penghargaan.js') }}"></script>


</body>
</html>