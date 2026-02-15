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
    <div class="table-card h-100 bg-white shadow-sm" style="border-radius: 12px; overflow: hidden;">
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
                                    <div class="fw-bold text-navy">{{ $req['name'] }}</div>
                                    <small class="text-muted fst-italic">Sumber: E-File / Kenaikan Jabatan</small>
                                </td>
                                <td class="text-center">
                                    @if($req['is_uploaded'])
                                        <span class="badge {{ $req['status_verifikasi'] == 'Perlu Revisi' ? 'bg-danger' : ($req['status_verifikasi'] == 'Disetujui' ? 'bg-success' : 'bg-warning text-dark') }}">
                                            {{ $req['status_verifikasi'] }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">Belum Ada</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        @if($req['is_uploaded'])
                                            {{-- Tombol LIHAT selalu muncul untuk mengecek berkas --}}
                                            <a href="{{ ($req['is_link'] ?? false) ? $req['path'] : asset('storage/'.$req['path']) }}" 
                                            target="_blank" class="btn btn-sm btn-info text-white" title="Pratinjau Berkas">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            {{-- Logika: Sembunyikan Tombol Komen & Verif jika sudah 'Disetujui' --}}
                                            @if($req['status_verifikasi'] !== 'Disetujui')
                                                {{-- Tombol Komen --}}
                                                <button class="btn btn-sm btn-warning text-dark" data-bs-toggle="modal" 
                                                        data-bs-target="#modalKomen{{ $index }}" title="Beri Catatan">
                                                    <i class="fas fa-comment-dots"></i>
                                                </button>

                                                {{-- Tombol Verifikasi (Memicu Modal Konfirmasi) --}}
                                                <button type="button" class="btn btn-sm btn-success" title="Verifikasi Final" 
                                                        onclick="openVerifModal('{{ route('efile.verify', $req['id_file']) }}', {{ $index }})">
                                                    <i class="fas fa-check-double"></i>
                                                </button>
                                            @endif

                                        @else
                                            {{-- Tombol Upload Admin jika berkas kosong --}}
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
                                            
                                            <form action="{{ route('efile.store', $pegawai->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                {{-- Data Hidden untuk mapping Controller --}}
                                                <input type="hidden" name="kategori" value="Lain-lain">
                                                <input type="hidden" name="nama_dokumen" value="{{ $req['name'] }}">
                                                <input type="hidden" name="keaslian" value="Asli"> {{-- Memberikan nilai default sesuai validasi --}}

                                                <div class="modal-body text-start">
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold">Jenis Dokumen</label>
                                                        <input type="text" class="form-control bg-light" value="{{ $req['name'] }}" readonly>
                                                    </div>

                                                    {{-- Tambahkan Input Tanggal (Wajib sesuai validasi Controller) --}}
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold">Tanggal Dokumen / SK</label>
                                                        <input type="date" name="tanggal_dokumen" class="form-control" required value="{{ date('Y-m-d') }}">
                                                    </div>

                                                    {{-- Tambahkan Input Metode (Wajib sesuai validasi Controller) --}}
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold">Metode Unggah</label>
                                                        <select name="metode" id="metode{{ $index }}" class="form-select form-select-sm" onchange="toggleMetode({{ $index }})" required>
                                                            <option value="file">Unggah Berkas PDF</option>
                                                            <option value="link">Gunakan Link URL</option>
                                                        </select>
                                                    </div>

                                                    {{-- Opsi 1: Upload File --}}
                                                    <div id="div_file{{ $index }}" class="mb-3">
                                                        <label class="form-label small fw-bold text-primary">
                                                            <i class="fas fa-file-pdf me-1"></i>Pilih File PDF
                                                        </label>
                                                        <input type="file" class="form-control" name="dokumen" accept=".pdf"> {{-- Name diganti jadi 'dokumen' sesuai Controller --}}
                                                        <div class="form-text small italic">Format: PDF (Max 2MB)</div>
                                                    </div>

                                                    {{-- Opsi 2: Input Link --}}
                                                    <div id="div_link{{ $index }}" class="mb-3" style="display: none;">
                                                        <label class="form-label small fw-bold text-success">
                                                            <i class="fas fa-link me-1"></i>Gunakan Link (Google Drive/Cloud)
                                                        </label>
                                                        <input type="url" class="form-control" name="link_url" placeholder="https://drive.google.com/...">
                                                        <div class="form-text small italic text-muted">Pastikan link dapat diakses publik/verifikator.</div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary btn-sm fw-bold">
                                                        <i class="fas fa-save me-1"></i>Simpan Berkas
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{-- MODAL KOMENTAR / REVISI --}}
                                @if($req['is_uploaded'])
                                    {{-- Modal ini hanya dibuat JIKA dokumen sudah diupload (ID tidak null) --}}
                                    <div class="modal fade" id="modalKomen{{ $index }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            {{-- Parameter ID sekarang pasti ada --}}
                                            <form action="{{ route('efile.comment', $req['id_file']) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title small fw-bold">Beri Catatan Revisi: {{ $req['name'] }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <label class="form-label small fw-bold">Catatan untuk Dosen</label>
                                                        {{-- Pastikan name="catatan_verifikator" --}}
                                                        <textarea name="catatan_verifikator" class="form-control" rows="3" required>{{ $req['catatan_verifikator'] }}</textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary btn-sm">Simpan Catatan</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

                <div class="tab-pane fade" id="dokumen-final" role="tabpanel">
                    <div class="table-responsive p-3">
                        <div class="alert alert-success py-2 small mb-3 border-0 shadow-none" style="background-color: #e8f5e9; color: #2e7d32;">
                            <i class="fas fa-archive me-2"></i> Daftar dokumen yang sudah divalidasi dan siap untuk proses kompilasi universitas.
                        </div>
                        
                        <table class="table table-hover align-middle border">
                            {{-- Perubahan Warna Header ke Navy --}}
                            <thead style="background-color: #001f3f; color: white;" class="small text-center">
                                <tr>
                                    <th class="text-start ps-3 fw-semibold">Dokumen Terverifikasi</th>
                                    <th style="width: 150px;" class="fw-semibold">Tgl Validasi</th>
                                    <th style="width: 120px;" class="fw-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    // Ambil dokumen dari database yang sudah 'Disetujui' untuk pegawai ini
                                    $finalDocs = \App\Models\EFile::where('pegawai_id', $pegawai->id)
                                                ->where('status_verifikasi', 'Disetujui')
                                                ->get();
                                @endphp

                                @forelse($finalDocs as $doc)
                                <tr class="bg-light-subtle">
                                    <td class="ps-3">
                                        <div class="fw-bold text-navy">
                                            <i class="fas fa-check-circle text-success me-2"></i>{{ $doc->nama_dokumen }}
                                        </div>
                                        <small class="text-muted" style="font-size: 0.75rem;">Status: Terverifikasi Final</small>
                                    </td>
                                    <td class="text-center small text-secondary">
                                        {{ $doc->updated_at->isoFormat('D MMM YYYY') }}
                                    </td>
                                    <td class="text-center">
                                        {{-- Tombol Batal Verifikasi memicu Modal Konfirmasi Smooth --}}
                                        <button type="button" class="btn btn-sm btn-outline-danger border-0" 
                                                onclick="openBatalModal('{{ route('efile.comment', $doc->id) }}')" 
                                                title="Batalkan Verifikasi">
                                            <i class="fas fa-undo-alt me-1"></i> Batal
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted small italic">
                                        <i class="fas fa-folder-open d-block mb-2" style="font-size: 2rem; opacity: 0.3;"></i>
                                        Belum ada berkas yang divalidasi final (Disetujui).
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Tombol Kompilasi --}}
                        <div class="mt-4 text-end">
                            <form action="{{ route('efile.downloadZip', $pegawai->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-navy fw-bold shadow-sm px-4 rounded-pill" 
                                    {{ $finalDocs->count() == 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-file-export me-2"></i>Kompilasi Berkas (ZIP)
                                </button>
                            </form>
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

    <div id="modalKonfirmasiVerifikasi" class="custom-modal-overlay" style="display: none;">
        <div class="custom-modal-box">
            <div class="custom-modal-icon">
                <i class="fas fa-file-signature"></i>
            </div>
            <div class="custom-modal-content">
                <h5 class="modal-title-text text-navy">Konfirmasi Validasi</h5>
                <p class="modal-subtitle-text">Apakah berkas ini sudah diperiksa dan layak disetujui sebagai dokumen final?</p>
            </div>
            <div class="custom-modal-actions">
                <button class="btn-custom-modal btn-modal-accept" id="btnTerimaVerif">
                    <i class="fas fa-check-circle me-1"></i> Setujui
                </button>
                <button class="btn-custom-modal btn-modal-reject" id="btnTolakVerif">
                    <i class="fas fa-times-circle me-1"></i> Beri Catatan
                </button>
                <button class="btn-custom-modal btn-modal-cancel" onclick="closeAllModals()">
                    Batal
                </button>
            </div>
        </div>
    </div>

    <div id="modalKonfirmasiBatal" class="custom-modal-overlay" style="display: none;">
        <div class="custom-modal-box border-top border-danger border-4">
            <div class="custom-modal-icon bg-danger-subtle text-danger">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="custom-modal-content">
                <h5 class="modal-title-text text-danger">Batalkan Verifikasi</h5>
                <p class="modal-subtitle-text">Yakin ingin membatalkan verifikasi ini? Berkas akan dikembalikan ke daftar review untuk diperbaiki dosen.</p>
            </div>
            <div class="custom-modal-actions" style="grid-template-columns: 1fr;">
                <button class="btn-custom-modal btn-modal-reject w-100" id="btnProsesBatal">
                    <i class="fas fa-undo me-1"></i> Ya, Batalkan Verifikasi
                </button>
                <button class="btn-custom-modal btn-modal-cancel w-100 mt-2" onclick="closeAllModals()">
                    Kembali
                </button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/layout.js') }}"></script>
<script src="{{ asset('assets/js/daftar-pegawai.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

<script>
// modal verifikasi
let targetActionUrl = '';
let targetRowIndex = null;

// Fungsi Modal Hijau (Tab 1)
function openVerifModal(url, index) {
    targetActionUrl = url;
    targetRowIndex = index;
    closeAllModals();
    document.getElementById('modalKonfirmasiVerifikasi').style.display = 'flex';
}

// Fungsi Modal Merah (Tab 2)
function openBatalModal(url) {
    targetActionUrl = url;
    closeAllModals();
    document.getElementById('modalKonfirmasiBatal').style.display = 'flex';
}

function closeAllModals() {
    document.getElementById('modalKonfirmasiVerifikasi').style.display = 'none';
    document.getElementById('modalKonfirmasiBatal').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    // Aksi Setujui (Hijau)
    document.getElementById('btnTerimaVerif').addEventListener('click', function() {
        submitActionForm(targetActionUrl);
    });

    // Aksi Batal Verifikasi (Merah)
    document.getElementById('btnProsesBatal').addEventListener('click', function() {
        submitActionForm(targetActionUrl, "Verifikasi dibatalkan oleh admin.");
    });

    // Aksi Beri Catatan (Pindah ke modal bootstrap)
    document.getElementById('btnTolakVerif').addEventListener('click', function() {
        closeAllModals();
        const modalKomenId = 'modalKomen' + targetRowIndex;
        const bootstrapModal = new bootstrap.Modal(document.getElementById(modalKomenId));
        bootstrapModal.show();
    });

    // Helper Submit Form
    function submitActionForm(url, catatan = null) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = url;
        let html = `@csrf @method('PATCH')`;
        if (catatan) {
            html += `<input type="hidden" name="catatan_verifikator" value="${catatan}">`;
        }
        form.innerHTML = html;
        document.body.appendChild(form);
        form.submit();
    }
});
function toggleMetode(index) {
    const metode = document.getElementById('metode' + index).value;
    const divFile = document.getElementById('div_file' + index);
    const divLink = document.getElementById('div_link' + index);

    if (metode === 'file') {
        divFile.style.display = 'block';
        divLink.style.display = 'none';
    } else {
        divFile.style.display = 'none';
        divLink.style.display = 'block';
    }
}
</script>

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
    .text-navy { color: #001f3f; }
    .table thead th { border: none; padding: 12px; }
    .table-hover tbody tr:hover { background-color: #f0f4f8; }

/* verifikasi */
    .custom-modal-overlay {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 31, 63, 0.4); /* Navy transparan */
        backdrop-filter: blur(4px); /* Efek blur halus */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        transition: all 0.3s ease;
    }

    .custom-modal-box {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        width: 100%;
        max-width: 380px;
        text-align: center;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        animation: slideUp 0.3s ease-out;
    }

    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .custom-modal-icon {
        width: 50px;
        height: 50px;
        background: #f0f7ff;
        color: #001f3f; /* Navy */
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        margin: 0 auto 1rem;
        font-size: 1.2rem;
    }

    .modal-title-text {
        font-size: 1.1rem;
        font-weight: 700;
        color: #001f3f;
        margin-bottom: 0.5rem;
    }

    .modal-subtitle-text {
        font-size: 0.85rem;
        color: #6c757d;
        line-height: 1.4;
        margin-bottom: 1.5rem;
    }

    .custom-modal-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }

    .btn-custom-modal {
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        border: none;
        transition: all 0.2s;
        cursor: pointer;
    }

    .btn-modal-accept {
        background: #198754;
        color: white;
    }

    .btn-modal-reject {
        background: #dc3545;
        color: white;
    }

    .btn-modal-cancel {
        background: #e9ecef;
        color: #495057;
        grid-column: span 2; /* Tombol batal di baris baru */
        margin-top: 4px;
    }

    .btn-custom-modal:hover {
        filter: brightness(90%);
        transform: translateY(-1px);
    }

</style>

</body>
</html>