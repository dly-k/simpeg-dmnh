<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIKEMAH - Monitoring Progress Jabatan</title>

    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/daftar-pegawai.css') }}" />
</head>

<body>
<div class="layout">
    @include('layouts.sidebar')

    <div class="main-wrapper">
        @include('layouts.header')

        <div class="title-bar">
            <h1>
                <i class="lni lni-timer"></i>
                <span id="page-title">Monitoring Progress Jabatan</span>
            </h1>
        </div>

        <div class="main-content">
            <div class="table-card">
                {{-- TAB DIVISI --}}
                <div class="tab-bar-container d-flex justify-content-between align-items-center">
                    <ul class="nav nav-pills" id="divisiTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="perencanaan-tab" data-bs-toggle="tab" data-bs-target="#perencanaan" type="button" role="tab">Perencanaan</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="kebijakan-tab" data-bs-toggle="tab" data-bs-target="#kebijakan" type="button" role="tab">Kebijakan</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pemanenan-tab" data-bs-toggle="tab" data-bs-target="#pemanenan" type="button" role="tab">Pemanenan</button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content mt-4" id="divisiTabContent">
                    <div class="tab-pane fade show active" id="perencanaan" role="tabpanel">
                        {{-- Fitur Cari --}}
                        <div class="search-group mb-4">
                            <div class="input-group bg-white shadow-sm" style="max-width: 400px; border-radius: 8px; overflow: hidden;">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control border-0" placeholder="Cari Nama atau NIP..." />
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle">
                                <thead class="table-light text-center small fw-bold">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama & NIP</th>
                                        <th>Usia</th>
                                        <th>Jabatan Terakhir</th>
                                        <th>Jabatan Tujuan</th>
                                        <th>Nilai Konversi</th>
                                        <th>Estimasi Pensiun</th>
                                        <th>Status Kelayakan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($submissions as $index => $s)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $s['nama'] }}</div>
                                            <small class="text-muted">{{ $s['nip'] }}</small>
                                        </td>
                                        <td class="text-center">{{ $s['usia'] }} Thn</td>
                                        <td class="text-center small">{{ $s['jabatan_terakhir'] }}</td>
                                        <td class="text-center small fw-bold text-primary">{{ $s['target'] }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border">{{ $s['nilai_konversi'] }}</span>
                                        </td>
                                        <td class="text-center small text-danger">{{ $s['tgl_pensiun'] }}</td>
                                        <td class="text-center">
                                            @if($s['is_eligible'])
                                                <span class="badge rounded-pill bg-success px-3">Layak Nilai</span>
                                            @else
                                                <span class="badge rounded-pill bg-warning text-dark px-3">Belum Layak</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="{{ route('monitoring.admin.detail', $s['id']) }}" class="btn-aksi btn-lihat" title="Detail Verifikasi">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <button class="btn-aksi btn-edit" title="Ubah Jabatan Tujuan" data-bs-toggle="modal" data-bs-target="#modalEditJabatan{{ $s['id'] }}">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- Tabpane Kebijakan dan Pemanenan bisa menggunakan struktur yang sama --}}
                </div>
            </div>
        </div>

        @include('layouts.footer')
    </div>
</div>

<script src="{{ asset('assets/js/layout.js') }}"></script>
<script src="{{ asset('assets/js/daftar-pegawai.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>