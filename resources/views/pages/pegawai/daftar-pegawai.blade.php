<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIKEMAH - Daftar Pegawai</title>

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
                <i class="lni lni-users"></i>
                <span id="page-title">Daftar Pegawai</span>
            </h1>
        </div>

        <div class="main-content">
            <div class="table-card">

                <div class="tab-bar-container d-flex justify-content-between align-items-center">
                    <ul class="nav nav-pills" id="pegawaiTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pegawai-aktif-tab" data-bs-toggle="tab" data-bs-target="#pegawai-aktif" type="button" role="tab" aria-controls="pegawai-aktif" aria-selected="true">
                                Pegawai Aktif
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="riwayat-pegawai-tab" data-bs-toggle="tab" data-bs-target="#riwayat-pegawai" type="button" role="tab" aria-controls="riwayat-pegawai" aria-selected="false">
                                Riwayat Pegawai
                            </button>
                        </li>
                    </ul>
                    <a href="{{ route('pegawai.create') }}" class="btn btn-tambah btn-sm fw-bold" id="btn-tambah-pegawai">
                        <i class="fa fa-plus me-2"></i> Tambah Data
                    </a>
                </div>

                <div class="tab-content" id="pegawaiTabContent">

                    {{-- TAB PEGAWAI AKTIF --}}
                    <div class="tab-pane fade show active" id="pegawai-aktif" role="tabpanel" aria-labelledby="pegawai-aktif-tab">
                        <form id="filter-form-aktif" action="{{ route('pegawai.index') }}" method="GET">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">
                                <div class="d-flex align-items-center flex-wrap gap-2 flex-grow-1">
                                    <div class="search-group flex-grow-1">
                                        <div class="input-group bg-white">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-search search-icon"></i>
                                            </span>
                                            <input type="text" name="search_aktif" class="form-control form-control-sm bg-transparent border-0" placeholder="Cari Nama atau NIP..." value="{{ request('search_aktif') }}" />
                                        </div>
                                    </div>
                                    <div>
                                        <select class="form-select form-select-sm w-100" name="filter_kepegawaian_aktif">
                                            <option value="">Semua Kepegawaian</option>
                                            <option value="Dosen PNS" @if(request('filter_kepegawaian_aktif') == 'Dosen PNS') selected @endif>Dosen PNS</option>
                                            <option value="Tendik PNS" @if(request('filter_kepegawaian_aktif') == 'Tendik PNS') selected @endif>Tendik PNS</option>
                                            <option value="Dosen Tetap" @if(request('filter_kepegawaian_aktif') == 'Dosen Tetap') selected @endif>Dosen Tetap</option>
                                            <option value="Tendik Tetap" @if(request('filter_kepegawaian_aktif') == 'Tendik Tetap') selected @endif>Tendik Tetap</option>
                                            <option value="Tendik Kontrak" @if(request('filter_kepegawaian_aktif') == 'Tendik Kontrak') selected @endif>Tendik Kontrak</option>
                                            <option value="Dosen Tamu" @if(request('filter_kepegawaian_aktif') == 'Dosen Tamu') selected @endif>Dosen Tamu</option>
                                            <option value="Tenaga Harian Lepas (THL)" @if(request('filter_kepegawaian_aktif') == 'Tenaga Harian Lepas (THL)') selected @endif>THL</option>
                                        </select>
                                    </div>
                                    <div>
                                        <a href="{{ route('pegawai.export', ['type' => 'aktif']) }}" class="btn btn-export btn-sm fw-bold">
                                            <i class="fa-solid fa-file-excel me-2"></i> Export Excel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive mt-4">
                            <table class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>NIP</th>
                                        <th>Status Kepegawaian</th>
                                        <th>Jabatan Fungsional</th>
                                        <th>Jabatan Struktural</th>
                                        <th>Pangkat/Gol</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pegawaiAktif as $index => $pegawai)
                                    <tr>
                                        <td class="text-center">{{ $pegawaiAktif->firstItem() + $index }}</td>
                                        <td>{{ $pegawai->nama_lengkap }}</td>
                                        <td class="text-center">{{ $pegawai->nip }}</td>
                                        <td class="text-center">{{ $pegawai->status_kepegawaian }}</td>
                                        <td class="text-center">{{ $pegawai->jabatan_fungsional }}</td>
                                        <td class="text-center">{{ $pegawai->jabatan_struktural ?? '-' }}</td>
                                        <td class="text-center">{{ $pegawai->pangkat_golongan }}</td>
                                        <td class="text-center">
                                            <span class="badge text-bg-success">{{ $pegawai->status_pegawai }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="{{ route('pegawai.show', $pegawai->id) }}" class="btn-aksi btn-lihat" title="Lihat Detail"><i class="fa fa-eye"></i></a>
                                                <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn-aksi btn-edit" title="Edit Data"><i class="fa fa-edit"></i></a>
                                                <form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST" class="d-inline form-hapus">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn-aksi btn-hapus" type="submit"  title="Hapus Data" data-nama="{{ $pegawai->nama_lengkap }}">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Tidak ada data pegawai aktif yang ditemukan.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center flex-wrap mt-3 w-100">
                            <span class="text-muted small mb-2 mb-md-0">
                                Menampilkan {{ $pegawaiAktif->firstItem() ?? 0 }} sampai {{ $pegawaiAktif->lastItem() ?? 0 }} dari {{ $pegawaiAktif->total() }} data
                            </span>
                            @if ($pegawaiAktif->hasPages())
                                <nav>
                                    {{ $pegawaiAktif->links() }}
                                </nav>
                            @endif
                        </div>
                    </div>

                    {{-- TAB RIWAYAT PEGAWAI --}}
                    <div class="tab-pane fade" id="riwayat-pegawai" role="tabpanel" aria-labelledby="riwayat-pegawai-tab">
                        <form id="filter-form-riwayat" action="{{ route('pegawai.index') }}" method="GET">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">
                                <div class="d-flex align-items-center flex-wrap gap-2 flex-grow-1">
                                    <div class="search-group flex-grow-1">
                                        <div class="input-group bg-white">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-search search-icon"></i>
                                            </span>
                                            <input type="text" name="search_riwayat" class="form-control form-control-sm bg-transparent border-0" placeholder="Cari Riwayat Pegawai..." value="{{ request('search_riwayat') }}" />
                                        </div>
                                    </div>
                                    <div>
                                        <select class="form-select form-select-sm w-100" name="filter_status_riwayat">
                                            <option value="">Semua Status Riwayat</option>
                                            <option value="Pensiun" @if(request('filter_status_riwayat') == 'Pensiun') selected @endif>Pensiun</option>
                                            <option value="Pensiun Muda" @if(request('filter_status_riwayat') == 'Pensiun Muda') selected @endif>Pensiun Muda</option>
                                            <option value="Diberhentikan" @if(request('filter_status_riwayat') == 'Diberhentikan') selected @endif>Diberhentikan</option>
                                            <option value="Meninggal Dunia" @if(request('filter_status_riwayat') == 'Meninggal Dunia') selected @endif>Meninggal Dunia</option>
                                            <option value="Kontrak Selesai" @if(request('filter_status_riwayat') == 'Kontrak Selesai') selected @endif>Kontrak Selesai</option>
                                            <option value="Mengundurkan diri" @if(request('filter_status_riwayat') == 'Mengundurkan diri') selected @endif>Mengundurkan Diri</option>
                                            <option value="Mutasi" @if(request('filter_status_riwayat') == 'Mutasi') selected @endif>Mutasi</option>
                                        </select>
                                    </div>
                                    <div>
                                        <a href="{{ route('pegawai.export', ['type' => 'riwayat']) }}" class="btn btn-export btn-sm fw-bold">
                                            <i class="fa-solid fa-file-excel me-2"></i> Export Excel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                        <div class="table-responsive mt-4">
                            <table class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>NIP</th>
                                        <th>Status Kepegawaian</th>
                                        <th>Jabatan Terakhir</th>
                                        <th>Pangkat/Gol</th>
                                        <th>Status Riwayat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pegawaiRiwayat as $index => $pegawai)
                                    <tr>
                                        <td class="text-center">{{ $pegawaiRiwayat->firstItem() + $index }}</td>
                                        <td>{{ $pegawai->nama_lengkap }}</td>
                                        <td class="text-center">{{ $pegawai->nip }}</td>
                                        <td class="text-center">{{ $pegawai->status_kepegawaian }}</td>
                                        <td class="text-center">{{ $pegawai->jabatan_fungsional }}</td>
                                        <td class="text-center">{{ $pegawai->pangkat_golongan }}</td>
                                        <td class="text-center">
                                            @php
                                                $status = $pegawai->status_pegawai;
                                                $badgeClass = 'text-bg-secondary';
                                                if (in_array($status, ['Pensiun', 'Pensiun Muda'])) $badgeClass = 'text-bg-warning';
                                                elseif ($status == 'Diberhentikan') $badgeClass = 'text-bg-danger';
                                                elseif ($status == 'Meninggal Dunia') $badgeClass = 'text-bg-dark';
                                                elseif ($status == 'Kontrak Selesai') $badgeClass = 'text-bg-info';
                                                elseif ($status == 'Mengundurkan diri') $badgeClass = 'text-bg-primary';
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="{{ route('pegawai.show', $pegawai->id) }}" class="btn-aksi btn-lihat" title="Lihat Detail Riwayat">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data riwayat pegawai yang ditemukan.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center flex-wrap mt-3 w-100">
                           <span class="text-muted small mb-2 mb-md-0">
                                Menampilkan {{ $pegawaiRiwayat->firstItem() ?? 0 }} sampai {{ $pegawaiRiwayat->lastItem() ?? 0 }} dari {{ $pegawaiRiwayat->total() }} data
                            </span>
                             @if ($pegawaiRiwayat->hasPages())
                                <nav>
                                    {{ $pegawaiRiwayat->links() }}
                                </nav>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer')
    </div>
</div>

@include('components.konfirmasi-hapus')
@include('components.konfirmasi-berhasil')

<script src="{{ asset('assets/js/layout.js') }}"></script>
<script src="{{ asset('assets/js/daftar-pegawai.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

@if (session('success'))
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const modalBerhasil = document.getElementById("modalBerhasil");
        if (modalBerhasil) {
            const berhasilTitle = document.getElementById("berhasil-title");
            const berhasilSubtitle = document.getElementById("berhasil-subtitle");
            
            if(berhasilTitle) berhasilTitle.textContent = "Berhasil!";
            if(berhasilSubtitle) berhasilSubtitle.textContent = "{{ session('success') }}";

            modalBerhasil.classList.add("show");
            
            const successAudio = new Audio("{{ asset('assets/sounds/success.mp3') }}");
            successAudio.play().catch(e => console.error("Gagal memutar audio:", e));

            setTimeout(() => {
                modalBerhasil.classList.remove("show");
            }, 2000);
        }
    });
</script>
@endif

</body>
</html>