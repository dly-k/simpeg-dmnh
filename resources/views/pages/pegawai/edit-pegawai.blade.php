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

                        {{-- Menampilkan Ringkasan Error Validasi --}}
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

                        <hr class="mb-4 divider-light">

                        <div class="main-tab-content" id="biodata-content">
                            <div id="biodata-sub-tabs" class="btn-group flex-wrap gap-2 mb-4">
                                <button type="button" class="btn active" data-tab="kepegawaian">Kepegawaian</button>
                                <button type="button" class="btn" data-tab="dosen">Dosen</button>
                                <button type="button" class="btn" data-tab="domisili">Alamat Domisili & Kontak</button>
                                <button type="button" class="btn" data-tab="kependudukan">Kependudukan</button>
                            </div>
                            
                            {{-- TAB KEPEGAWAIAN --}}
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
                                        <label class="small text-dark fw-medium mb-1">Nomor Arsip Berkas Kepegawaian</label>
                                        <input type="text" class="form-control form-control-sm" name="nomor_arsip" value="{{ old('nomor_arsip', $pegawai->nomor_arsip) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Jabatan Fungsional<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" name="jabatan_fungsional" required>
                                            <option value="Dosen" @if(old('jabatan_fungsional', $pegawai->jabatan_fungsional) == 'Dosen') selected @endif>Dosen</option>
                                            <option value="Asisten Ahli" @if(old('jabatan_fungsional', $pegawai->jabatan_fungsional) == 'Asisten Ahli') selected @endif>Asisten Ahli</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Pangkat/Golongan<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" name="pangkat_golongan" required>
                                            <option value="Penata Muda / III-a" @if(old('pangkat_golongan', $pegawai->pangkat_golongan) == 'Penata Muda / III-a') selected @endif>Penata Muda / III-a</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">TMT Pangkat Terakhir</label>
                                        <input type="date" class="form-control form-control-sm" name="tmt_pangkat" value="{{ old('tmt_pangkat', $pegawai->tmt_pangkat) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Jabatan Struktural (jika ada)</label>
                                        <input type="text" class="form-control form-control-sm" name="jabatan_struktural" value="{{ old('jabatan_struktural', $pegawai->jabatan_struktural) }}">
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
                            
                            <div class="sub-tab-content" id="domisili" style="display: none;">
                                <div class="row g-3">
                                    <div class="col-md-12 form-group">
                                        <label class="small text-dark fw-medium mb-1">Alamat Domisili</label>
                                        <textarea class="form-control form-control-sm" name="alamat_domisili" rows="2">{{ old('alamat_domisili', $pegawai->alamat_domisili) }}</textarea>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">No. Telepon/HP</label>
                                        <input type="text" class="form-control form-control-sm" name="no_telepon" value="{{ old('no_telepon', $pegawai->no_telepon) }}">
                                    </div>
                                     <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Email</label>
                                        <input type="email" class="form-control form-control-sm" name="email" value="{{ old('email', $pegawai->email) }}">
                                    </div>
                                </div>
                            </div>

                             <div class="sub-tab-content" id="kependudukan" style="display: none;">
                                <div class="row g-3">
                                    <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Nomor KTP</label>
                                        <input type="text" class="form-control form-control-sm" name="nomor_ktp" value="{{ old('nomor_ktp', $pegawai->nomor_ktp) }}">
                                    </div>
                                     <div class="col-md-6 form-group">
                                        <label class="small text-dark fw-medium mb-1">Nomor KK</label>
                                        <input type="text" class="form-control form-control-sm" name="nomor_kk" value="{{ old('nomor_kk', $pegawai->nomor_kk) }}">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label class="small text-dark fw-medium mb-1">Alamat KTP</label>
                                        <textarea class="form-control form-control-sm" name="alamat_ktp" rows="2">{{ old('alamat_ktp', $pegawai->alamat_ktp) }}</textarea>
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
</script>

</body>
</html>
