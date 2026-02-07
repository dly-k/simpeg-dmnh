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
                <th>Estimasi Pensiun</th> {{-- Pindah ke sini --}}
                <th>Progres Berkas</th>
                <th>Nilai Konversi</th>
                <th>Status Nilai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $p)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                    <div class="fw-bold">{{ $p->nama_lengkap }}</div>
                    <small class="text-muted">{{ $p->nip ?? '-' }}</small>
                </td>
                <td class="text-center">{{ \Carbon\Carbon::parse($p->tanggal_lahir)->age }} Thn</td>
                
                {{-- Perbaikan Variabel ke jabatan_fungsional --}}
                <td class="text-center small">{{ $p->jabatan_fungsional ?? '-' }}</td>
                
                <td class="text-center small fw-bold text-primary">Lektor Kepala</td>

                {{-- Estimasi Pensiun (Posisi Baru) --}}
                <td class="text-center small text-danger">
                    {{ \Carbon\Carbon::parse($p->tanggal_lahir)->addYears(65)->isoFormat('D MMM YYYY') }}
                </td>

                {{-- Progres Berkas --}}
                <td class="text-center">
                    <div class="progress" style="height: 8px; width: 80px; margin: 0 auto;">
                        <div class="progress-bar bg-success" style="width: 0%"></div>
                    </div>
                    <small class="text-muted" style="font-size: 0.65rem;">0 / 12 Berkas</small>
                </td>
                
                {{-- Nilai Konversi --}}
                <td class="text-center">
                    <span class="badge bg-light text-dark border">100.00</span>
                </td>
                
                {{-- Status Nilai --}}
                <td class="text-center">
                    @if(\Carbon\Carbon::parse($p->tanggal_lahir)->age < 65)
                        <span class="badge rounded-pill bg-success px-3">Memenuhi</span>
                    @else
                        <span class="badge rounded-pill bg-warning text-dark px-3">Belum Memenuhi</span>
                    @endif
                </td>
                
                <td class="text-center">
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('monitoring.admin.detail', $p->id) }}" class="btn-aksi btn-lihat" title="Detail Verifikasi">
                            <i class="fa fa-eye"></i>
                        </a>
                        <button class="btn-aksi btn-edit" title="Ubah Jabatan Tujuan">
                            <i class="fa fa-edit"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center py-4 text-muted">Kosong</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>