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
<div class="table-card p-4 shadow-sm border-0 bg-white" style="border-radius: 15px;">
    <h5 class="fw-bold mb-4 text-navy"><i class="fas fa-user-shield me-2"></i>Audit Kelayakan Saya</h5>
    
    @php 
        // 1. Definisikan logika status terlebih dahulu
        $isKUMOk = (($currentKUM ?? 0) >= ($targetKUM ?? 0) && ($targetKUM ?? 0) > 0);
        $isKonversiOk = (($currentKonversi ?? 0) >= ($targetKonversi ?? 0) && ($targetKonversi ?? 0) > 0);
        $isEligible = ($isKUMOk && $isKonversiOk);
        
        // 2. Hitung nilai progress bar
        $progress = 0;
        if($isEligible) {
            $progress = 100;
        } elseif($isKUMOk || $isKonversiOk) {
            $progress = 50;
        }
    @endphp

    <div class="row g-3 text-center mb-4">
        {{-- Bagian Angka Kredit (KUM) --}}
        <div class="col-6">
            <div class="small fw-bold text-muted mb-1">ANGKA KREDIT</div>
            <div class="h2 fw-bold text-primary mb-0">{{ number_format($currentKUM ?? 0, 2) }}</div>
            <div class="badge {{ $isKUMOk ? 'bg-success' : 'bg-danger' }} rounded-pill mt-2">
                {{ $isKUMOk ? 'Terpenuhi' : 'Kurang ' . number_format(($targetKUM ?? 0) - ($currentKUM ?? 0), 2) }}
            </div>
        </div>

        {{-- Bagian Konversi --}}
        <div class="col-6 border-start">
            <div class="small fw-bold text-muted mb-1">KONVERSI</div>
            <div class="h2 fw-bold text-info mb-0">{{ number_format($currentKonversi ?? 0, 2) }}</div>
            <div class="badge {{ $isKonversiOk ? 'bg-success' : 'bg-danger' }} rounded-pill mt-2">
                {{ $isKonversiOk ? 'Terpenuhi' : 'Kurang ' . number_format(($targetKonversi ?? 0) - ($currentKonversi ?? 0), 2) }}
            </div>
        </div>
    </div>

    {{-- Bagian Progress Bar --}}
    <div class="progress-info mb-1 d-flex justify-content-between small">
        <span class="fw-bold">Progres Kelayakan Nilai</span>
        <span class="text-navy fw-bold">{{ $progress }}%</span>
    </div>
    <div class="progress" style="height: 12px; border-radius: 10px;">
        <div class="progress-bar progress-bar-striped progress-bar-animated {{ $progress == 100 ? 'bg-success' : 'bg-primary' }}" 
             style="width: {{ $progress }}%"></div>
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
    <td>
        <div class="fw-bold text-navy">{{ $req['name'] }}</div>

        {{-- Tampilkan Pesan Catatan Admin --}}
        @if($req['catatan_verifikator'])
            <div class="alert alert-danger py-2 px-3 mt-2 mb-0 small border-start border-danger border-4">
                <strong><i class="fas fa-comment-dots"></i> Catatan Admin:</strong><br>
                {{ $req['catatan_verifikator'] }}
            </div>
        @endif
    </td>
    <td class="text-center">
        @if($req['is_uploaded'])
            @if($req['status_verifikasi'] == 'Perlu Revisi')
                <span class="badge bg-danger">Perlu Revisi</span>
            @elseif($req['status_verifikasi'] == 'Disetujui')
                <span class="badge bg-success">Terverifikasi</span>
            @else
                <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
            @endif
        @else
            <span class="badge bg-secondary">Kosong</span>
        @endif
    </td>
    <td>
<div class="d-flex gap-2">
    @if($req['is_uploaded'])
        {{-- Tombol LIHAT selalu muncul --}}
        <a href="{{ $req['is_link'] ? $req['path'] : asset('storage/'.$req['path']) }}" 
           target="_blank" 
           class="btn btn-sm btn-info text-white" 
           title="Lihat Berkas">
            <i class="fas fa-eye"></i> Lihat
        </a>
        
        {{-- Logika: Sembunyikan tombol GANTI jika sudah 'Disetujui' --}}
        @if($req['status_verifikasi'] !== 'Disetujui')
            <button class="btn btn-sm btn-warning text-dark fw-bold" 
                    data-bs-toggle="modal" 
                    data-bs-target="#modalUpload{{ $index }}" 
                    title="Ganti/Revisi Berkas">
                <i class="fas fa-sync-alt"></i> Ganti
            </button>
        @else
            {{-- Opsional: Tampilkan ikon kunci untuk memberi info bahwa berkas terkunci --}}
            <span class="btn btn-sm btn-light disabled text-muted">
                <i class="fas fa-lock"></i> Terkunci
            </span>
        @endif

    @else
        {{-- Tombol jika masih kosong --}}
        <button class="btn btn-sm btn-primary fw-bold" 
                data-bs-toggle="modal" 
                data-bs-target="#modalUpload{{ $index }}">
            <i class="fas fa-upload"></i> Unggah
        </button>
    @endif
</div>
    </td>
</tr>

{{-- MODAL UPLOAD (Digunakan untuk Unggah Baru maupun Ganti) --}}
<div class="modal fade" id="modalUpload{{ $index }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('efile.store', $pegawai->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- Mapping field agar sesuai dengan Controller Store EFile Anda --}}
            <input type="hidden" name="nama_dokumen" value="{{ $req['name'] }}">
            <input type="hidden" name="kategori" value="Lain-lain">
            <input type="hidden" name="metode" id="metode_val{{ $index }}" value="file"> {{-- Default metode file --}}

            <div class="modal-content">
                <div class="modal-header {{ $req['is_uploaded'] ? 'bg-warning' : 'bg-primary' }} text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-file-upload me-2"></i>
                        {{ $req['is_uploaded'] ? 'Ganti/Revisi Berkas' : 'Unggah Berkas' }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info py-2 small">
                        <i class="fas fa-info-circle me-1"></i> 
                        Dokumen: <strong>{{ $req['name'] }}</strong>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tanggal Dokumen</label>
                        <input type="date" name="tanggal_dokumen" class="form-control" required value="{{ date('Y-m-d') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Keaslian</label>
                        <select name="keaslian" class="form-select" required>
                            <option value="Asli">Asli (Scan Warna)</option>
                            <option value="Fotokopi">Fotokopi Legalisir</option>
                        </select>
                    </div>

                    {{-- Pilihan Metode --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Metode Unggah</label>
                        <select class="form-select" onchange="document.getElementById('metode_val{{ $index }}').value = this.value; toggleDosenMetode(this.value, {{ $index }})">
                            <option value="file">Unggah Berkas PDF</option>
                            <option value="link">Gunakan Link URL</option>
                        </select>
                    </div>

                    <div id="div_dosen_file{{ $index }}">
                        <label class="form-label small fw-bold text-primary">Pilih File PDF (Max 2MB)</label>
                        <input type="file" name="dokumen" class="form-control" accept=".pdf">
                    </div>

                    <div id="div_dosen_link{{ $index }}" style="display: none;">
                        <label class="form-label small fw-bold text-success">Link Cloud (G-Drive/OneDrive)</label>
                        <input type="url" name="link_url" class="form-control" placeholder="https://...">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn {{ $req['is_uploaded'] ? 'btn-warning' : 'btn-primary' }} w-100 fw-bold">
                        {{ $req['is_uploaded'] ? 'Update & Simpan Perubahan' : 'Simpan Dokumen' }}
                    </button>
                </div>
            </div>
        </form>
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

<script>
function toggleDosenMetode(val, index) {
    const dFile = document.getElementById('div_dosen_file' + index);
    const dLink = document.getElementById('div_dosen_link' + index);
    if(val === 'file') {
        dFile.style.display = 'block';
        dLink.style.display = 'none';
    } else {
        dFile.style.display = 'none';
        dLink.style.display = 'block';
    }
}
</script>

<style>
    .text-navy { color: #001f3f; }
    .bg-navy { background-color: #001f3f; }
    .btn-navy { background-color: #001f3f; color: white; }
    .btn-navy:hover { background-color: #001226; color: white; }
</style>

</body>
</html>