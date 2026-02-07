<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIKEMAH - Progres Saya</title>

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
                <i class="lni lni-consulting"></i>
                <span id="page-title">Progres Kenaikan Jabatan Saya</span>
            </h1>
        </div>

        <div class="main-content">
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="table-card p-4 h-100 shadow-sm border-0" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
                        <h5 class="fw-bold mb-4" style="color: #001f3f;">Status Kelayakan KUM</h5>
                        
                        <div class="text-center mb-4">
                            <span class="text-muted small text-uppercase fw-bold">Target Jabatan</span>
                            <h4 class="fw-bold text-navy">{{ $data['target_jabatan'] }}</h4>
                        </div>

                        <div class="progress-container text-center py-4 px-3 rounded-4 border bg-white mb-4 shadow-sm">
                            <div class="display-4 fw-bold text-primary mb-0">{{ $data['current_kum'] }}</div>
                            <div class="text-muted small">Angka Kredit Saat Ini (Integrasi + Konversi)</div>
                            <div class="progress mt-3" style="height: 12px; border-radius: 10px;">
                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" 
                                     style="width: {{ ($data['current_kum']/$data['target_kum'])*100 }}%"></div>
                            </div>
                            <div class="mt-2 fw-bold small text-success">Target: {{ $data['target_kum'] }} KUM</div>
                        </div>

                        @if($data['current_kum'] < $data['target_kum'])
                        <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center">
                            <i class="fas fa-info-circle fa-2x me-3"></i>
                            <div>
                                <small class="d-block fw-bold">Kekurangan Nilai:</small>
                                <span class="h5 fw-bold mb-0">{{ $data['target_kum'] - $data['current_kum'] }} KUM</span>
                            </div>
                        </div>
                        @else
                        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center">
                            <i class="fas fa-check-double fa-2x me-3"></i>
                            <div>
                                <small class="d-block fw-bold">Status:</small>
                                <span class="h5 fw-bold mb-0">LAYAK SECARA NILAI</span>
                            </div>
                        </div>
                        @endif

                        <div class="mt-4 p-3 rounded-3 bg-light border-start border-danger border-4">
                            <small class="text-muted d-block">Estimasi Masa Pensiun:</small>
                            <strong class="text-danger">{{ $data['tgl_pensiun'] }}</strong>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="table-card h-100 shadow-sm border-0">
                        <div class="tab-bar-container border-bottom px-3 pt-3">
                            <h5 class="fw-bold" style="color: #001f3f;">Kelengkapan Berkas Persyaratan</h5>
                        </div>

                        <div class="p-3">
                            <table class="table table-hover align-middle border">
                                <thead class="table-light small fw-bold">
                                    <tr class="text-center">
                                        <th class="text-start ps-3">Dokumen</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['requirements'] as $index => $req)
                                    <tr>
                                        <td class="ps-3">
                                            <div class="fw-bold small">{{ $req['name'] }}</div>
                                            @if($req['note'])
                                            <div class="text-danger small" style="font-size: 0.75rem;">
                                                <i class="fas fa-exclamation-circle me-1"></i>Catatan: {{ $req['note'] }}
                                            </div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $badgeClass = 'bg-secondary';
                                                if($req['status'] == 'Valid') $badgeClass = 'bg-success';
                                                elseif($req['status'] == 'Perlu Revisi') $badgeClass = 'bg-danger';
                                            @endphp
                                            <span class="badge rounded-pill {{ $badgeClass }} px-3" style="font-size: 0.7rem;">
                                                {{ $req['status'] }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($req['status'] == 'Valid')
                                                <button class="btn btn-sm btn-light border" disabled><i class="fas fa-check text-success"></i></button>
                                            @else
                                                <button class="btn btn-sm btn-primary fw-bold" 
                                                        style="font-size: 0.75rem;"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#modalUpload{{ $index }}">
                                                    <i class="fas fa-upload me-1"></i> Unggah
                                                </button>
                                            @endif
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="modalUpload{{ $index }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content shadow-lg border-0">
                                                <div class="modal-header bg-navy text-white">
                                                    <h6 class="modal-title fw-bold">Lengkapi {{ $req['name'] }}</h6>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="#" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-4">
                                                            <label class="form-label small fw-bold">Opsi 1: Unggah File Lokal (PDF)</label>
                                                            <input type="file" class="form-control" name="file_upload" accept=".pdf">
                                                            <div class="form-text small">Maksimal file 2MB</div>
                                                        </div>
                                                        <div class="text-center my-3">
                                                            <span class="badge bg-light text-dark border">ATAU</span>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-label small fw-bold">Opsi 2: Tautkan Link Cloud (Google Drive/Dropbox)</label>
                                                            <input type="url" class="form-control" name="link_upload" placeholder="https://drive.google.com/...">
                                                            <div class="form-text small">Pastikan link dapat diakses oleh Admin TU</div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-sm btn-navy fw-bold px-4">Kirim Berkas</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer')
    </div>
</div>

<script src="{{ asset('assets/js/layout.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .text-navy { color: #001f3f; }
    .bg-navy { background-color: #001f3f; }
    .btn-navy { background-color: #001f3f; color: white; }
    .btn-navy:hover { background-color: #001226; color: white; }
</style>

</body>
</html>