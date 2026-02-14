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
                        {{-- Ganti $data['target_jabatan'] menjadi $pegawai->jabatan_tujuan --}}
                        <h4 class="fw-bold text-navy">{{ $pegawai->jabatan_tujuan ?? 'Belum Ditentukan' }}</h4>
                    </div>

                    <div class="progress-container text-center py-4 px-3 rounded-4 border bg-white mb-4 shadow-sm">
                        {{-- Ganti $data['current_kum'] menjadi $currentKUM --}}
                        <div class="display-4 fw-bold text-primary mb-0">{{ $currentKUM }}</div>
                        <div class="text-muted small">Angka Kredit Saat Ini (Integrasi + Konversi)</div>
                        
                        <div class="progress mt-3" style="height: 12px; border-radius: 10px;">
                            {{-- Hitung persentase secara dinamis --}}
                            @php
                                $percentage = $targetKUM > 0 ? min(($currentKUM / $targetKUM) * 100, 100) : 0;
                            @endphp
                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" 
                                style="width: {{ $percentage }}%"></div>
                        </div>
                        
                        {{-- Ganti $data['target_kum'] menjadi $targetKUM --}}
                        <div class="mt-2 fw-bold small text-success">Target: {{ $targetKUM }} KUM</div>
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
    @foreach($requirements as $index => $req)
    <tr>
        <td class="ps-3">
            <div class="fw-bold small">{{ $req['name'] }}</div>
            {{-- Sesuaikan pengecekan catatan jika Anda memiliki kolom 'note' di database --}}
            @if(isset($req['note']) && $req['note'])
            <div class="text-danger small" style="font-size: 0.75rem;">
                <i class="fas fa-exclamation-circle me-1"></i>Catatan: {{ $req['note'] }}
            </div>
            @endif
        </td>
        <td class="text-center">
            @if($req['is_uploaded'])
                <span class="badge rounded-pill bg-light-success text-success border border-success px-3">
                    <i class="fas fa-check-circle me-1"></i>Tersedia
                </span>
            @else
                <span class="badge rounded-pill bg-light-danger text-danger border border-danger px-3">
                    <i class="fas fa-times-circle me-1"></i>Kosong
                </span>
            @endif
        </td>
        <td class="text-center">
            <div class="d-flex gap-1 justify-content-center">
                @if($req['is_uploaded'])
                    {{-- Pratinjau Berkas --}}
                    <a href="{{ $req['is_link'] ? $req['path'] : asset('storage/'.$req['path']) }}" 
                       target="_blank" class="btn btn-sm btn-info text-white" title="Lihat Dokumen">
                        <i class="fas fa-eye"></i>
                    </a>
                @else
                    {{-- Info jika kosong --}}
                    <span class="text-muted small italic text-center">Menunggu Admin</span>
                @endif
            </div>
        </td>
    </tr>
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