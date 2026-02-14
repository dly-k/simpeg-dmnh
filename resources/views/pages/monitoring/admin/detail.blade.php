<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIKEMAH - Verifikasi Berkas</title>

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

        <div class="title-bar d-flex justify-content-between align-items-center">
            <h1>
                <i class="lni lni-protection"></i>
                <span id="page-title">Verifikasi Berkas Kenaikan</span>
            </h1>
            <div>
                <a href="{{ route('monitoring.admin.index') }}" class="btn btn-secondary btn-sm fw-bold px-3 shadow-sm" style="border-radius: 8px;">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
                </a>
            </div>
        </div>

        <div class="main-content">
            <div class="alert bg-white shadow-sm border-0 d-flex align-items-center mb-4 p-3" style="border-radius: 12px; border-left: 5px solid #001f3f !important;">
                <div class="icon-box me-3 bg-light p-3 rounded-circle" style="color: #001f3f;">
                    <i class="fas fa-user-tie fa-2x"></i>
                </div>
                <div class="flex-grow-1">
                    <h5 class="fw-bold mb-1" style="color: #001f3f;">{{ $pegawai->nama_lengkap }}</h5>
                        <div class="d-flex flex-wrap gap-3">
                            <span class="text-muted small"><i class="fas fa-id-card me-1"></i> NIP. {{ $pegawai->nip }}</span>
                            <span class="text-muted small"><i class="fas fa-briefcase me-1"></i> Jabatan: <strong>{{ $pegawai->jabatan_fungsional }} ({{ $pegawai->pangkat_golongan }})</strong></span>
                            <span class="text-muted small"><i class="fas fa-bullseye me-1"></i> Target: <strong class="text-primary">{{ $pegawai->jabatan_tujuan }}</strong></span>
                            
                            <span class="text-danger small fw-bold"><i class="fas fa-clock me-1"></i> Estimasi Pensiun: 
                                @php
                                    $pensiun = $pegawai->estimasi_pensiun_manual 
                                        ? \Carbon\Carbon::parse($pegawai->estimasi_pensiun_manual)
                                        : \Carbon\Carbon::parse($pegawai->tanggal_lahir)->addYears(65);
                                @endphp
                                {{ $pensiun->isoFormat('D MMMM YYYY') }}
                            </span>
                        </div>
                </div>
            </div>

            <div class="row g-4">
<div class="col-lg-4">
    <div class="table-card p-4 h-100">
        <h5 class="fw-bold mb-4 border-bottom pb-2" style="color: #001f3f;">
            <i class="fas fa-calculator me-2"></i>Audit Kelayakan Nilai
        </h5>
        
        <div class="mb-4">
            <label class="text-muted small text-uppercase fw-bold">Jabatan yang Dituju:</label>
            <div class="d-flex align-items-center mt-1">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                    <i class="fas fa-arrow-up small"></i>
                </div>
                <h6 class="fw-bold mb-0 text-dark">{{ $pegawai->jabatan_tujuan ?? 'Belum Diatur' }}</h6>
            </div>
            <p class="text-muted small mt-1 ps-4">Syarat Minimum: <strong>{{ number_format($targetKUM, 0) }} KUM</strong></p>
        </div>

        <div class="text-center py-4 mb-4 bg-light rounded-3 border">
            <h1 class="display-4 fw-bold text-primary mb-0">{{ number_format($currentKUM, 2) }}</h1>
            <p class="text-muted small text-uppercase">Total KUM Saat Ini</p>
            <div class="small text-muted">AK Lama: {{ $pegawai->ak_lama }}</div>
        </div>

        @php $isEligible = ($currentKUM >= $targetKUM && $targetKUM > 0); @endphp
        <div class="p-3 mb-4 rounded-3 border {{ $isEligible ? 'bg-success-subtle text-success border-success' : 'bg-warning-subtle text-warning border-warning' }}">
            <div class="d-flex align-items-center justify-content-center mb-1">
                <i class="fas {{ $isEligible ? 'fa-check-circle' : 'fa-exclamation-triangle' }} me-2 fa-lg"></i>
                <span class="fw-bold text-uppercase">{{ $isEligible ? 'Memenuhi' : 'Belum Memenuhi' }}</span>
            </div>
            
            @if(!$isEligible && $targetKUM > 0)
                <div class="text-center mt-2 pt-2 border-top border-warning border-opacity-25">
                    <span class="small text-dark">Kekurangan:</span>
                    <h4 class="fw-bold text-danger mb-0">{{ number_format($targetKUM - $currentKUM, 2) }} <span class="small">KUM</span></h4>
                </div>
            @elseif($targetKUM > 0)
                <div class="text-center mt-2 pt-2 border-top border-success border-opacity-25">
                    <small class="fw-bold italic">Syarat nilai minimum terpenuhi</small>
                </div>
            @endif
        </div>

        <form action="{{ route('monitoring.admin.updateAK', $pegawai->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label small fw-bold">Update AK Konversi (SKP)</label>
                <div class="input-group">
                    <input type="number" step="0.001" class="form-control" name="ak_baru" value="{{ $pegawai->ak_baru }}" placeholder="0.00">
                    <button class="btn btn-primary fw-bold" type="submit" title="Simpan Perubahan">
                        <i class="fas fa-save"></i>
                    </button>
                </div>
                <div class="form-text small italic text-muted">*Nilai akan otomatis menjumlahkan total KUM kumulatif.</div>
            </div>
        </form>
    </div>
</div>

<div class="col-lg-8">
    <div class="table-card h-100">
        {{-- TAB NAVIGASI BERKAS --}}
        <div class="tab-bar-container border-bottom">
            <ul class="nav nav-pills p-3" id="dokumenTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold" id="upload-dosen-tab" data-bs-toggle="tab" data-bs-target="#upload-dosen" type="button" role="tab">
                        <i class="fas fa-file-import me-2"></i>Unggahan Dosen
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold" id="dokumen-final-tab" data-bs-toggle="tab" data-bs-target="#dokumen-final" type="button" role="tab">
                        <i class="fas fa-check-double me-2"></i>Berkas Final (Kompilasi)
                    </button>
                </li>
            </ul>
        </div>

        <div class="tab-content" id="dokumenTabContent">
            {{-- SUB-TAB 1: DOKUMEN YANG DIUPLOAD DOSEN --}}
<div class="tab-pane fade show active" id="upload-dosen" role="tabpanel">
    <div class="table-responsive p-3">
        <table class="table table-hover align-middle border">
            <thead class="table-light">
                <tr class="text-center small">
                    <th class="text-start ps-3">Nama Dokumen</th>
                    <th style="width: 120px;">Status</th>
                    <th style="width: 220px;">Aksi Verifikator</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requirements as $index => $req)
                <tr>
                    <td class="ps-3">
                        <div class="fw-bold">{{ $req['name'] }}</div>
                        <small class="text-muted fst-italic">Sumber: E-File / Link Drive</small>
                    </td>
                    <td class="text-center">
                        @if($req['is_uploaded'])
                            <span class="badge rounded-pill bg-success px-3">Tersedia</span>
                        @else
                            <span class="badge rounded-pill bg-secondary px-3">Kosong</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex gap-1 justify-content-center">
                            @if($req['is_uploaded'])
                                <a href="{{ $req['is_link'] ? $req['path'] : asset('storage/'.$req['path']) }}" 
                                   target="_blank" class="btn btn-sm btn-info text-white" title="Pratinjau Berkas">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn btn-sm btn-warning text-dark" title="Beri Catatan">
                                    <i class="fas fa-comment-dots"></i>
                                </button>
                                <button class="btn btn-sm btn-success" title="Validasi Final">
                                    <i class="fas fa-check"></i>
                                </button>
                            @else
                                {{-- TOMBOL UPLOAD KHUSUS ADMIN JIKA BERKAS MASIH KOSONG --}}
                                <button class="btn btn-sm btn-outline-primary fw-bold px-3" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalUploadAdmin{{ $index }}">
                                    <i class="fas fa-upload me-1"></i> Upload Admin
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>

                {{-- MODAL UPLOAD ADMIN --}}
                <div class="modal fade" id="modalUploadAdmin{{ $index }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-navy text-white">
                                <h5 class="modal-title small fw-bold">Upload Dokumen (Oleh Admin)</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="#" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Jenis Dokumen</label>
                                        <input type="text" class="form-control bg-light" value="{{ $req['name'] }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Pilih File PDF</label>
                                        <input type="file" class="form-control" name="file_admin" accept=".pdf">
                                        <div class="form-text small italic">Max size: 2MB (Format PDF)</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Atau Gunakan Link (Hybrid)</label>
                                        <input type="url" class="form-control" name="link_admin" placeholder="https://drive.google.com/...">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary btn-sm fw-bold">Simpan Berkas</button>
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

            {{-- SUB-TAB 2: DOKUMEN FINAL --}}
            <div class="tab-pane fade" id="dokumen-final" role="tabpanel">
                <div class="table-responsive p-3">
                    <div class="alert alert-success py-2 small mb-3 border-0 shadow-none">
                        <i class="fas fa-archive me-2"></i> Daftar dokumen yang sudah divalidasi dan siap untuk proses kompilasi universitas.
                    </div>
                    <table class="table table-hover align-middle border">
                        <thead class="table-dark small">
                            <tr class="text-center">
                                <th class="text-start ps-3">Dokumen Terverifikasi</th>
                                <th style="width: 150px;">Tgl Validasi</th>
                                <th style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Contoh data jika sudah ada yang divalidasi --}}
                            <tr class="bg-light-subtle">
                                <td class="ps-3 fw-bold"><i class="fas fa-file-pdf text-danger me-2"></i>SK Jabatan Terakhir (Final)</td>
                                <td class="text-center small">07 Feb 2026</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-undo me-1"></i>Batal</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="mt-4 text-end">
                        <button class="btn btn-navy fw-bold shadow-sm px-4 rounded-pill" disabled>
                            <i class="fas fa-file-export me-2"></i>Kompilasi Berkas (ZIP/PDF)
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            </div>
        </div>

        @include('layouts.footer')
    </div>
</div>

<script src="{{ asset('assets/js/layout.js') }}"></script>
<script src="{{ asset('assets/js/daftar-pegawai.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .bg-success-subtle { background-color: #e8f5e9; }
    .bg-warning-subtle { background-color: #fffde7; }
    .table-card { background: #fff; border-radius: 12px; border: 1px solid #eee; }
    /* Menjaga tinggi kolom agar seimbang */
    @media (min-width: 992px) {
        .h-lg-100 { height: 100%; }
    }
    .btn-navy { background-color: #001f3f; color: white; }
    .btn-navy:hover { background-color: #001226; color: white; }
    .bg-light-subtle { background-color: #f8f9fa; }
    .nav-pills .nav-link.active { background-color: #001f3f !important; }
    .nav-pills .nav-link { color: #6c757d; }
</style>

</body>
</html>