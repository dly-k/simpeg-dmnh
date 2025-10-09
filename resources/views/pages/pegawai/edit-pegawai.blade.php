<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <title>Edit Data Pegawai - SIKEMAH</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/edit-pegawai.css') }}" />
</head>

<body>
<div class="layout">
    @include('layouts.sidebar')

    <div class="main-wrapper">
        @include('layouts.header')

        <div class="title-bar d-flex align-items-center justify-content-between">
            <h1 class="m-0">
                <i class="fa fa-user-pen"></i> Edit Data Pegawai
            </h1>
            <a href="{{ route('pegawai.index') }}" class="btn-kembali d-flex align-items-center gap-2">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>

        <main class="main-content">
            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @if ($errors->any())
                            <div class="alert alert-danger mb-4" role="alert">
                                <h5 class="alert-heading">Whoops! Terjadi beberapa masalah.</h5>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="d-flex flex-column flex-md-row gap-4 mb-4">
                            <div class="text-center flex-shrink-0">
                                <div class="mb-2 mx-auto d-flex align-items-center justify-content-center bg-light rounded foto-profil" id="foto-preview-container">
                                     @if($pegawai->foto_profil)
                                        <img src="{{ asset('storage/' . $pegawai->foto_profil) }}" alt="Foto Profil" class="img-fluid rounded" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <i class="lni lni-user"></i>
                                    @endif
                                </div>
                                <button class="btn btn-editfoto btn-sm w-100" type="button" id="btn-edit-foto">Edit Foto</button>
                                <input type="file" name="foto_profil" id="foto-profil-input" class="d-none" accept="image/*">
                                @error('foto_profil')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="flex-grow-1">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">NIP<span class="text-danger">*</span></label>
                                        <input type="text" name="nip" class="form-control form-control-sm @error('nip') is-invalid @enderror" value="{{ old('nip', $pegawai->nip) }}" required>
                                        @error('nip')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">Agama<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm @error('agama') is-invalid @enderror" name="agama" required>
                                            <option value="Islam" {{ old('agama', $pegawai->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                            <option value="Kristen" {{ old('agama', $pegawai->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                            <option value="Katolik" {{ old('agama', $pegawai->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                            <option value="Hindu" {{ old('agama', $pegawai->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                            <option value="Budha" {{ old('agama', $pegawai->agama) == 'Budha' ? 'selected' : '' }}>Budha</option>
                                            <option value="Khonghucu" {{ old('agama', $pegawai->agama) == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                                        </select>
                                        @error('agama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">Nama Lengkap<span class="text-danger">*</span></label>
                                        <input type="text" name="nama_lengkap" class="form-control form-control-sm @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $pegawai->nama_lengkap) }}" placeholder="Termasuk gelar jika ada" required>
                                        @error('nama_lengkap')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">Status Pernikahan<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm @error('status_pernikahan') is-invalid @enderror" name="status_pernikahan" required>
                                            <option value="Belum Menikah" {{ old('status_pernikahan', $pegawai->status_pernikahan) == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                            <option value="Menikah" {{ old('status_pernikahan', $pegawai->status_pernikahan) == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                            <option value="Janda" {{ old('status_pernikahan', $pegawai->status_pernikahan) == 'Janda' ? 'selected' : '' }}>Janda</option>
                                            <option value="Duda" {{ old('status_pernikahan', $pegawai->status_pernikahan) == 'Duda' ? 'selected' : '' }}>Duda</option>
                                        </select>
                                        @error('status_pernikahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">Jenis Kelamin<span class="text-danger">*</span></label>
                                        <div>
                                            <div class="form-check form-check-inline pt-1">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="lk" value="Laki-laki" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'Laki-laki' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="lk">Laki-laki</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="pr" value="Perempuan" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pr">Perempuan</label>
                                            </div>
                                        </div>
                                         @error('jenis_kelamin')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">Pendidikan Terakhir<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm @error('pendidikan_terakhir') is-invalid @enderror" name="pendidikan_terakhir">
                                            <option value="SD" {{ old('pendidikan_terakhir', $pegawai->pendidikan_terakhir) == 'SD' ? 'selected' : '' }}>SD</option>
                                            <option value="SMP" {{ old('pendidikan_terakhir', $pegawai->pendidikan_terakhir) == 'SMP' ? 'selected' : '' }}>SMP</option>
                                            <option value="SMA" {{ old('pendidikan_terakhir', $pegawai->pendidikan_terakhir) == 'SMA' ? 'selected' : '' }}>SMA</option>
                                            <option value="S1" {{ old('pendidikan_terakhir', $pegawai->pendidikan_terakhir) == 'S1' ? 'selected' : '' }}>S1</option>
                                            <option value="S2" {{ old('pendidikan_terakhir', $pegawai->pendidikan_terakhir) == 'S2' ? 'selected' : '' }}>S2</option>
                                            <option value="S3" {{ old('pendidikan_terakhir', $pegawai->pendidikan_terakhir) == 'S3' ? 'selected' : '' }}>S3</option>
                                        </select>
                                        @error('pendidikan_terakhir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">Tempat Lahir<span class="text-danger">*</span></label>
                                        <input type="text" name="tempat_lahir" class="form-control form-control-sm @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir', $pegawai->tempat_lahir) }}">
                                        @error('tempat_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">Bidang Ilmu<span class="text-danger">*</span></label>
                                        <input type="text" name="bidang_ilmu" class="form-control form-control-sm @error('bidang_ilmu') is-invalid @enderror" value="{{ old('bidang_ilmu', $pegawai->bidang_ilmu) }}" placeholder="Contoh: Ilmu Pengelolaan Hutan">
                                        @error('bidang_ilmu')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-dark fw-medium mb-1">Tanggal Lahir<span class="text-danger">*</span></label>
                                        <input type="date" name="tanggal_lahir" class="form-control form-control-sm @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir) }}">
                                        @error('tanggal_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="mb-4 custom-hr">

                        <div class="main-tab-content" id="biodata-content">
                            <div id="biodata-sub-tabs" class="btn-group flex-wrap gap-2 mb-4">
                                <button type="button" class="btn active" data-tab="kepegawaian">Kepegawaian</button>
                                <button type="button" class="btn" data-tab="dosen">Dosen</button>
                                <button type="button" class="btn" data-tab="domisili">Alamat Domisili & Kontak</button>
                                <button type="button" class="btn" data-tab="kependudukan">Kependudukan</button>
                            </div>
                            
                            <div class="sub-tab-content" id="kepegawaian">
                                <div class="row g-3">
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Status Kepegawaian<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" name="status_kepegawaian" required>
                                            <option value="Dosen PNS" @if(old('status_kepegawaian', $pegawai->status_kepegawaian) == 'Dosen PNS') selected @endif>Dosen PNS</option>
                                            <option value="Tendik PNS" @if(old('status_kepegawaian', $pegawai->status_kepegawaian) == 'Tendik PNS') selected @endif>Tendik PNS</option>
                                            <option value="Dosen Tetap" @if(old('status_kepegawaian', $pegawai->status_kepegawaian) == 'Dosen Tetap') selected @endif>Dosen Tetap</option>
                                            <option value="Tendik Tetap" @if(old('status_kepegawaian', $pegawai->status_kepegawaian) == 'Tendik Tetap') selected @endif>Tendik Tetap</option>
                                            <option value="Tendik Kontrak" @if(old('status_kepegawaian', $pegawai->status_kepegawaian) == 'Tendik Kontrak') selected @endif>Tendik Kontrak</option>
                                            <option value="Dosen Tamu" @if(old('status_kepegawaian', $pegawai->status_kepegawaian) == 'Dosen Tamu') selected @endif>Dosen Tamu</option>
                                            <option value="Tenaga Harian Lepas (THL)" @if(old('status_kepegawaian', $pegawai->status_kepegawaian) == 'Tenaga Harian Lepas (THL)') selected @endif>Tenaga Harian Lepas (THL)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Status Pegawai<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" name="status_pegawai" required>
                                            <option value="Aktif" @if(old('status_pegawai', $pegawai->status_pegawai) == 'Aktif') selected @endif>Aktif</option>
                                            <option value="Pensiun" @if(old('status_pegawai', $pegawai->status_pegawai) == 'Pensiun') selected @endif>Pensiun</option>
                                            <option value="Pensiun Muda" @if(old('status_pegawai', $pegawai->status_pegawai) == 'Pensiun Muda') selected @endif>Pensiun Muda</option>
                                            <option value="Diberhentikan" @if(old('status_pegawai', $pegawai->status_pegawai) == 'Diberhentikan') selected @endif>Diberhentikan</option>
                                            <option value="Meninggal Dunia" @if(old('status_pegawai', $pegawai->status_pegawai) == 'Meninggal Dunia') selected @endif>Meninggal Dunia</option>
                                            <option value="Kontrak Selesai" @if(old('status_pegawai', $pegawai->status_pegawai) == 'Kontrak Selesai') selected @endif>Kontrak Selesai</option>
                                            <option value="Mengundurkan diri" @if(old('status_pegawai', $pegawai->status_pegawai) == 'Mengundurkan diri') selected @endif>Mengundurkan diri</option>
                                            <option value="Mutasi" @if(old('status_pegawai', $pegawai->status_pegawai) == 'Mutasi') selected @endif>Mutasi</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Unit Kerja</label>
                                        <input type="text" class="form-control form-control-sm readonly-input" value="Fakultas Kehutanan dan Lingkungan" readonly>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Divisi</label>
                                        <input type="text" class="form-control form-control-sm readonly-input" value="Departemen Manajemen Hutan" readonly>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Nomor Arsip Berkas Kepegawaian</label>
                                        <input type="text" class="form-control form-control-sm" name="nomor_arsip" value="{{ old('nomor_arsip', $pegawai->nomor_arsip) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Jabatan Fungsional<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm @error('jabatan_fungsional') is-invalid @enderror" name="jabatan_fungsional" required>
                                            @php $fungsionalValue = old('jabatan_fungsional', $pegawai->jabatan_fungsional); @endphp
                                            <option value="Tidak ada" @if($fungsionalValue == 'Tidak ada') selected @endif>Tidak ada</option>
                                            <option value="Dosen" @if($fungsionalValue == 'Dosen') selected @endif>Dosen</option>
                                            <option value="Asisten Ahli" @if($fungsionalValue == 'Asisten Ahli') selected @endif>Asisten Ahli</option>
                                            <option value="Lektor" @if($fungsionalValue == 'Lektor') selected @endif>Lektor</option>
                                            <option value="Lektor Kepala" @if($fungsionalValue == 'Lektor Kepala') selected @endif>Lektor Kepala</option>
                                            <option value="Guru Besar" @if($fungsionalValue == 'Guru Besar') selected @endif>Guru Besar</option>
                                            <option value="Pranata Laboratorium Pendidikan Pelaksana Lanjutan" @if($fungsionalValue == 'Pranata Laboratorium Pendidikan Pelaksana Lanjutan') selected @endif>Pranata Laboratorium Pendidikan Pelaksana Lanjutan</option>
                                            <option value="Pranata Laboratorium Pendidikan Muda" @if($fungsionalValue == 'Pranata Laboratorium Pendidikan Muda') selected @endif>Pranata Laboratorium Pendidikan Muda</option>
                                            <option value="Pranata Laboratorium Pendidikan Pertama" @if($fungsionalValue == 'Pranata Laboratorium Pendidikan Pertama') selected @endif>Pranata Laboratorium Pendidikan Pertama</option>
                                            <option value="Teknisi Hardware dan Software" @if($fungsionalValue == 'Teknisi Hardware dan Software') selected @endif>Teknisi Hardware dan Software</option>
                                            <option value="Pengadministrasi Akademik & Kemahasiswaan PS IPH" @if($fungsionalValue == 'Pengadministrasi Akademik & Kemahasiswaan PS IPH') selected @endif>Pengadministrasi Akademik & Kemahasiswaan PS IPH</option>
                                            <option value="Pengadministrasi Akademik & Kemahasiswaan MNH" @if($fungsionalValue == 'Pengadministrasi Akademik & Kemahasiswaan MNH') selected @endif>Pengadministrasi Akademik & Kemahasiswaan MNH</option>
                                            <option value="Pengadministrasi Umum, Sarana & Prasarana" @if($fungsionalValue == 'Pengadministrasi Umum, Sarana & Prasarana') selected @endif>Pengadministrasi Umum, Sarana & Prasarana</option>
                                            <option value="Pengadministrasi Persuratan & Arsip" @if($fungsionalValue == 'Pengadministrasi Persuratan & Arsip') selected @endif>Pengadministrasi Persuratan & Arsip</option>
                                            <option value="Pengadministrasi Jurnal Ilmiah" @if($fungsionalValue == 'Pengadministrasi Jurnal Ilmiah') selected @endif>Pengadministrasi Jurnal Ilmiah</option>
                                            <option value="Adm. Bagian/Divisi" @if($fungsionalValue == 'Adm. Bagian/Divisi') selected @endif>Adm. Bagian/Divisi</option>
                                            <option value="Staf Kepegawaian" @if($fungsionalValue == 'Staf Kepegawaian') selected @endif>Staf Kepegawaian</option>
                                            <option value="Laboran Penafsiran Potret Udara" @if($fungsionalValue == 'Laboran Penafsiran Potret Udara') selected @endif>Laboran Penafsiran Potret Udara</option>
                                            <option value="Pramu Kantor" @if($fungsionalValue == 'Pramu Kantor') selected @endif>Pramu Kantor</option>
                                            <option value="Pramu Gedung dan Halaman" @if($fungsionalValue == 'Pramu Gedung dan Halaman') selected @endif>Pramu Gedung dan Halaman</option>
                                            <option value="Media Branding & Staf Jurnal Departemen" @if($fungsionalValue == 'Media Branding & Staf Jurnal Departemen') selected @endif>Media Branding & Staf Jurnal Departemen</option>
                                        </select>
                                        @error('jabatan_fungsional') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Pangkat/Golongan<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" name="pangkat_golongan" required>
                                            @php $pangkatValue = old('pangkat_golongan', $pegawai->pangkat_golongan); @endphp
                                            <option value="Juru Muda / I-a" @if($pangkatValue == 'Juru Muda / I-a') selected @endif>Juru Muda / I-a</option>
                                            <option value="Juru Muda Tingkat I / I-b" @if($pangkatValue == 'Juru Muda Tingkat I / I-b') selected @endif>Juru Muda Tingkat I / I-b</option>
                                            <option value="Juru / I-c" @if($pangkatValue == 'Juru / I-c') selected @endif>Juru / I-c</option>
                                            <option value="Juru Tingkat I / I-d" @if($pangkatValue == 'Juru Tingkat I / I-d') selected @endif>Juru Tingkat I / I-d</option>
                                            <option value="Pengatur Muda / II-a" @if($pangkatValue == 'Pengatur Muda / II-a') selected @endif>Pengatur Muda / II-a</option>
                                            <option value="Pengatur Muda Tingkat I / II-b" @if($pangkatValue == 'Pengatur Muda Tingkat I / II-b') selected @endif>Pengatur Muda Tingkat I / II-b</option>
                                            <option value="Pengatur / II-c" @if($pangkatValue == 'Pengatur / II-c') selected @endif>Pengatur / II-c</option>
                                            <option value="Pengatur Tingkat I / II-d" @if($pangkatValue == 'Pengatur Tingkat I / II-d') selected @endif>Pengatur Tingkat I / II-d</option>
                                            <option value="Penata Muda / III-a" @if($pangkatValue == 'Penata Muda / III-a') selected @endif>Penata Muda / III-a</option>
                                            <option value="Penata Muda Tingkat I / III-b" @if($pangkatValue == 'Penata Muda Tingkat I / III-b') selected @endif>Penata Muda Tingkat I / III-b</option>
                                            <option value="Penata III/c" @if($pangkatValue == 'Penata III/c') selected @endif>Penata III/c</option>
                                            <option value="Penata Tingkat I / III-d" @if($pangkatValue == 'Penata Tingkat I / III-d') selected @endif>Penata Tingkat I / III-d</option>
                                            <option value="Pembina / IV-a" @if($pangkatValue == 'Pembina / IV-a') selected @endif>Pembina / IV-a</option>
                                            <option value="Pembina Tingkat I / IV-b" @if($pangkatValue == 'Pembina Tingkat I / IV-b') selected @endif>Pembina Tingkat I / IV-b</option>
                                            <option value="Pembina Utama Muda / IV-c" @if($pangkatValue == 'Pembina Utama Muda / IV-c') selected @endif>Pembina Utama Muda / IV-c</option>
                                            <option value="Pembina Utama Madya / IV-d" @if($pangkatValue == 'Pembina Utama Madya / IV-d') selected @endif>Pembina Utama Madya / IV-d</option>
                                            <option value="Pembina Utama / IV-e" @if($pangkatValue == 'Pembina Utama / IV-e') selected @endif>Pembina Utama / IV-e</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">TMT Pangkat Terakhir</label>
                                        <input type="date" class="form-control form-control-sm" name="tmt_pangkat" value="{{ old('tmt_pangkat', $pegawai->tmt_pangkat) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Jabatan Struktural</label>
                                        <select class="form-select form-select-sm" name="jabatan_struktural">
                                            @php $jabatanValue = old('jabatan_struktural', $pegawai->jabatan_struktural); @endphp
                                            <option value="Tidak ada" @if($jabatanValue == 'Tidak ada') selected @endif>Tidak ada</option>
                                            <option value="Ketua Departemen MNH" @if($jabatanValue == 'Ketua Departemen MNH') selected @endif>Ketua Departemen MNH</option>
                                            <option value="Sekretaris Departemen MNH" @if($jabatanValue == 'Sekretaris Departemen MNH') selected @endif>Sekretaris Departemen MNH</option>
                                            <option value="Sekretaris Program Studi" @if($jabatanValue == 'Sekretaris Program Studi') selected @endif>Sekretaris Program Studi</option>
                                            <option value="Ketua Program Studi Pascasarjana IPH" @if($jabatanValue == 'Ketua Program Studi Pascasarjana IPH') selected @endif>Ketua Program Studi Pascasarjana IPH</option>
                                            <option value="Sekretaris Program Studi Pascasarjana IPH" @if($jabatanValue == 'Sekretaris Program Studi Pascasarjana IPH') selected @endif>Sekretaris Program Studi Pascasarjana IPH</option>
                                            <option value="Kepala Tata Usaha (KTU)" @if($jabatanValue == 'Kepala Tata Usaha (KTU)') selected @endif>Kepala Tata Usaha (KTU)</option>
                                            <option value="Sub Koordinator Administrasi Akademik" @if($jabatanValue == 'Sub Koordinator Administrasi Akademik') selected @endif>Sub Koordinator Administrasi Akademik</option>
                                            <option value="Sub Koordinator Keuangan dan Umum" @if($jabatanValue == 'Sub Koordinator Keuangan dan Umum') selected @endif>Sub Koordinator Keuangan dan Umum</option>
                                            <option value="Komisi Akademik" @if($jabatanValue == 'Komisi Akademik') selected @endif>Komisi Akademik</option>
                                            <option value="Anggota Komisi Akademik" @if($jabatanValue == 'Anggota Komisi Akademik') selected @endif>Anggota Komisi Akademik</option>
                                            <option value="Komisi Kemahasiswaan" @if($jabatanValue == 'Komisi Kemahasiswaan') selected @endif>Komisi Kemahasiswaan</option>
                                            <option value="Anggota Komisi Kemahasiswaan" @if($jabatanValue == 'Anggota Komisi Kemahasiswaan') selected @endif>Anggota Komisi Kemahasiswaan</option>
                                            <option value="Kepala Divisi Perencanaan Kehutanan" @if($jabatanValue == 'Kepala Divisi Perencanaan Kehutanan') selected @endif>Kepala Divisi Perencanaan Kehutanan</option>
                                            <option value="Kepala Divisi Kebijakan Kehutanan" @if($jabatanValue == 'Kepala Divisi Kebijakan Kehutanan') selected @endif>Kepala Divisi Kebijakan Kehutanan</option>
                                            <option value="Kepala Divisi Pemanfaatan Sumberdaya Hutan" @if($jabatanValue == 'Kepala Divisi Pemanfaatan Sumberdaya Hutan') selected @endif>Kepala Divisi Pemanfaatan Sumberdaya Hutan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Periode Jabatan Struktural</label>
                                        <div class="d-flex gap-2">
                                            <input type="date" class="form-control form-control-sm" name="periode_jabatan_mulai" value="{{ old('periode_jabatan_mulai', $pegawai->periode_jabatan_mulai) }}">
                                            <span class="pt-1">s/d</span>
                                            <input type="date" class="form-control form-control-sm" name="periode_jabatan_selesai" value="{{ old('periode_jabatan_selesai', $pegawai->periode_jabatan_selesai) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Finger Print ID</label>
                                        <input type="text" class="form-control form-control-sm" name="finger_print_id" value="{{ old('finger_print_id', $pegawai->finger_print_id) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">NPWP</label>
                                        <input type="text" class="form-control form-control-sm" name="npwp" value="{{ old('npwp', $pegawai->npwp) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Nama Bank</label>
                                        <input type="text" class="form-control form-control-sm" name="nama_bank" value="{{ old('nama_bank', $pegawai->nama_bank) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">No Rekening</label>
                                        <input type="text" class="form-control form-control-sm" name="nomor_rekening" value="{{ old('nomor_rekening', $pegawai->nomor_rekening) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="sub-tab-content" id="dosen" style="display: none;">
                                <div class="row g-3">
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">NUPTK</label>
                                        <input type="text" class="form-control form-control-sm" name="nuptk" value="{{ old('nuptk', $pegawai->nuptk) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">SINTA ID</label>
                                        <input type="text" class="form-control form-control-sm" name="sinta_id" placeholder="Opsional" value="{{ old('sinta_id', $pegawai->sinta_id) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">NIDN</label>
                                        <input type="text" class="form-control form-control-sm" name="nidn" value="{{ old('nidn', $pegawai->nidn) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Scopus ID</label>
                                        <input type="text" class="form-control form-control-sm" name="scopus_id" placeholder="Opsional" value="{{ old('scopus_id', $pegawai->scopus_id) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">No. Sertifikasi Dosen</label>
                                        <input type="text" class="form-control form-control-sm" name="no_sertifikasi_dosen" value="{{ old('no_sertifikasi_dosen', $pegawai->no_sertifikasi_dosen) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Orchid ID</label>
                                        <input type="text" class="form-control form-control-sm" name="orchid_id" placeholder="Opsional" value="{{ old('orchid_id', $pegawai->orchid_id) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Tgl. Sertifikasi Dosen</label>
                                        <input type="date" class="form-control form-control-sm" name="tgl_sertifikasi_dosen" value="{{ old('tgl_sertifikasi_dosen', $pegawai->tgl_sertifikasi_dosen) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Google Scholar ID</label>
                                        <input type="text" class="form-control form-control-sm" name="google_scholar_id" placeholder="Opsional" value="{{ old('google_scholar_id', $pegawai->google_scholar_id) }}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="sub-tab-content" id="domisili" style="display: none;">
                                <div class="row g-3">
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Provinsi</label>
                                        <input type="text" class="form-control form-control-sm" name="provinsi_domisili" placeholder="Contoh: Jawa Barat" value="{{ old('provinsi_domisili', $pegawai->provinsi_domisili) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Alamat</label>
                                        <textarea class="form-control form-control-sm" name="alamat_domisili" placeholder="Contoh: JL. Lodaya">{{ old('alamat_domisili', $pegawai->alamat_domisili) }}</textarea>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kabupaten/Kota</label>
                                        <input type="text" class="form-control form-control-sm" name="kota_domisili" placeholder="Contoh: Bandung" value="{{ old('kota_domisili', $pegawai->kota_domisili) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kode Pos</label>
                                        <input type="text" class="form-control form-control-sm" name="kode_pos_domisili" placeholder="Contoh: 10021" value="{{ old('kode_pos_domisili', $pegawai->kode_pos_domisili) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kecamatan</label>
                                        <input type="text" class="form-control form-control-sm" name="kecamatan_domisili" placeholder="Contoh: Bandung Tengah" value="{{ old('kecamatan_domisili', $pegawai->kecamatan_domisili) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">No. Telepon/HP</label>
                                        <input type="text" class="form-control form-control-sm" name="no_telepon" placeholder="Contoh: 081239128991" value="{{ old('no_telepon', $pegawai->no_telepon) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kelurahan</label>
                                        <input type="text" class="form-control form-control-sm" name="kelurahan_domisili" placeholder="Contoh: Ciawi" value="{{ old('kelurahan_domisili', $pegawai->kelurahan_domisili) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Email Pribadi / Institusi</label>
                                        <input type="email" class="form-control form-control-sm" name="email" placeholder="Contoh: aexyifshsi@gmail.com" value="{{ old('email', $pegawai->email) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="sub-tab-content" id="kependudukan" style="display: none;">
                                <div class="row g-3">
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Nomor KTP</label>
                                        <input type="text" class="form-control form-control-sm" name="nomor_ktp" placeholder="Contoh: 31862908812645811" value="{{ old('nomor_ktp', $pegawai->nomor_ktp) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kecamatan</label>
                                        <input type="text" class="form-control form-control-sm" name="kecamatan_ktp" placeholder="Contoh: Talang Ubi" value="{{ old('kecamatan_ktp', $pegawai->kecamatan_ktp) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Nomor KK</label>
                                        <input type="text" class="form-control form-control-sm" name="nomor_kk" placeholder="Contoh: 8011447152211029" value="{{ old('nomor_kk', $pegawai->nomor_kk) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kelurahan</label>
                                        <input type="text" class="form-control form-control-sm" name="kelurahan_ktp" placeholder="Contoh: Pisangan Timur" value="{{ old('kelurahan_ktp', $pegawai->kelurahan_ktp) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Warga Negara</label>
                                        <select class="form-select form-select-sm" name="warga_negara">
                                            @php $wargaNegaraValue = old('warga_negara', $pegawai->warga_negara); @endphp
                                            <option value="">--Pilih Salah Satu--</option>
                                            <option value="WNI" @if($wargaNegaraValue == 'WNI') selected @endif>Warga Negara Indonesia (WNI)</option>
                                            <option value="WNA" @if($wargaNegaraValue == 'WNA') selected @endif>Warga Negara Asing (WNA)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kode Pos</label>
                                        <input type="text" class="form-control form-control-sm" name="kode_pos_ktp" placeholder="Contoh: 01984" value="{{ old('kode_pos_ktp', $pegawai->kode_pos_ktp) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Provinsi</label>
                                        <input type="text" class="form-control form-control-sm" name="provinsi_ktp" placeholder="Contoh: Sumatera Barat" value="{{ old('provinsi_ktp', $pegawai->provinsi_ktp) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Kabupaten/Kota</label>
                                        <input type="text" class="form-control form-control-sm" name="kabupaten_ktp" placeholder="Contoh: Cimahi" value="{{ old('kabupaten_ktp', $pegawai->kabupaten_ktp) }}">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label class="small text-dark fw-medium mb-1">Alamat</label>
                                        <textarea class="form-control form-control-sm" rows="2" name="alamat_ktp" placeholder="Contoh: Jl Pendopo">{{ old('alamat_ktp', $pegawai->alamat_ktp) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-simpan w-100 mt-4">
                            <i class="lni lni-save me-2"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </main>

        @include('layouts.footer')
    </div>
</div>

<script src="{{ asset('assets/js/layout.js') }}"></script>
<script src="{{ asset('assets/js/edit-pegawai.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnEditFoto = document.getElementById('btn-edit-foto');
    const fotoInput = document.getElementById('foto-profil-input');
    const fotoPreviewContainer = document.getElementById('foto-preview-container');

    btnEditFoto.addEventListener('click', () => {
        fotoInput.click();
    });

    fotoInput.addEventListener('change', () => {
        const file = fotoInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                fotoPreviewContainer.innerHTML = `<img src="${e.target.result}" alt="Foto Profil" class="img-fluid rounded" style="width: 100%; height: 100%; object-fit: cover;">`;
            }
            reader.readAsDataURL(file);
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    // Ambil semua input dengan tipe 'date'
    const dateInputs = document.querySelectorAll('input[type="date"]');

    // Tambahkan event listener ke setiap input tanggal
    dateInputs.forEach(input => {
        input.addEventListener('click', function(e) {
            // Tampilkan date picker bawaan browser
            try {
                this.showPicker();
            } catch (error) {
                // Fallback untuk browser yang tidak mendukung showPicker()
                console.log("Browser tidak mendukung showPicker(), tapi seharusnya tetap berfungsi di browser modern.");
            }
        });
    });
});
</script>

</body>
</html>