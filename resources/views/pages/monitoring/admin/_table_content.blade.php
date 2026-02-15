{{-- Fitur Cari --}}
<div class="search-group mb-4">
    <div class="input-group bg-white shadow-sm" style="max-width: 400px; border-radius: 8px; overflow: hidden;">
        <span class="input-group-text bg-light border-0"><i class="fas fa-search"></i></span>
        <input type="text" class="form-control border-0" placeholder="Cari Nama atau NIP..." />
    </div>
</div>

<div class="table-responsive">
    <table class="table table-hover table-bordered align-middle text-center">
        <thead class="table-light small fw-bold">
            <tr>
                <th>No</th>
                <th class="text-start">Nama & NIP</th>
                <th>Usia</th>
                <th>Jabatan Terakhir</th>
                <th>Jabatan Tujuan</th>
                <th>Estimasi Pensiun</th>
                <th>Progres Berkas</th>
                <th>Nilai Konversi</th>
                <th>Status Nilai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- PERBAIKAN: Ganti $data menjadi $pegawais agar sinkron dengan index.blade.php --}}
            @forelse($pegawais as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="text-start">
                    <div class="fw-bold">{{ $p->nama_lengkap }}</div>
                    <small class="text-muted">{{ $p->nip ?? '-' }}</small>
                </td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal_lahir)->age }} Thn</td>
                
                <td class="small">
                    {{ $p->jabatan_fungsional ?? '-' }} 
                    <br><span class="text-muted">({{ $p->pangkat_golongan ?? '-' }})</span>
                </td>
                
                <td class="small fw-bold text-primary">
                    {{ $p->jabatan_tujuan ?? 'Belum Diatur' }}
                    @if($p->pangkat_golongan_tujuan)
                        <br><span class="text-secondary small">({{ $p->pangkat_golongan_tujuan }})</span>
                    @endif
                </td>

                <td class="small text-danger">
                    @php
                        $tglPensiun = $p->estimasi_pensiun_manual 
                            ? \Carbon\Carbon::parse($p->estimasi_pensiun_manual) 
                            : \Carbon\Carbon::parse($p->tanggal_lahir)->addYears(65);
                    @endphp
                    {{ $tglPensiun->isoFormat('D MMM YYYY') }}
                </td>

                {{-- Progres Berkas - Menghapus karakter \ agar progress bar muncul --}}
                <td class="text-center">
                    <div class="d-flex align-items-center gap-2">
                        <div class="progress flex-grow-1" style="height: 8px; background-color: #eee;">
                            <div class="progress-bar {{ $p->progres_persen == 100 ? 'bg-success' : 'bg-primary' }}" 
                                 role="progressbar" 
                                 style="width: {{ $p->progres_persen }}%" 
                                 aria-valuenow="{{ $p->progres_persen }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>
                        <small class="fw-bold text-navy">
                            {{ $p->total_verified ?? 0 }}/{{ $p->total_syarat ?? 0 }}
                        </small>
                    </div>
                </td>
                
                <td class="text-center">
                    @php
                        $totalKUM = ($p->ak_lama ?? 0) + ($p->ak_baru ?? 0);
                    @endphp
                    <span class="badge bg-light text-dark border">{{ number_format($totalKUM, 2) }}</span>
                </td>
                
                <td class="text-center">
                    @php
                        $thresholds = [
                            'Asisten Ahli (III/b)' => 150,
                            'Lektor (III/c)'       => 200,
                            'Lektor (III/d)'       => 300,
                            'Lektor Kepala (IV/a)' => 400,
                            'Lektor Kepala (IV/b)' => 550,
                            'Lektor Kepala (IV/c)' => 700,
                            'Guru Besar (IV/d)'    => 850,
                            'Guru Besar (IV/e)'    => 1050,
                        ];
                        $targetKUM = $thresholds[$p->jabatan_tujuan] ?? 0;
                        $isMemenuhi = ($totalKUM >= $targetKUM && $targetKUM > 0);
                    @endphp

                    @if($isMemenuhi)
                        <span class="badge rounded-pill bg-success px-3">Memenuhi</span>
                    @else
                        <span class="badge rounded-pill bg-warning text-dark px-3">Belum Memenuhi</span>
                    @endif
                </td>

                <td>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('monitoring.admin.detail', $p->id) }}" class="btn-aksi btn-lihat" title="Detail">
                            <i class="fa fa-eye"></i>
                        </a>
                        <button type="button" class="btn-aksi btn-edit" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $p->id }}">
                            <i class="fa fa-edit"></i>
                        </button>
                    </div>

                    <div class="modal fade text-start" id="modalEdit{{ $p->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header bg-light">
                                    <h5 class="modal-title fw-bold">Setting Target Kenaikan: {{ $p->nama_lengkap }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('monitoring.admin.updateTarget', $p->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="p-3 bg-light rounded mb-3 text-center">
                                            <small class="text-muted d-block">Kondisi Saat Ini:</small>
                                            <strong class="text-navy">{{ $p->jabatan_fungsional ?? '-' }} ({{ $p->pangkat_golongan ?? '-' }})</strong>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-bold text-primary">Target Kenaikan (Jabatan & Golongan)</label>
                                            <select name="jabatan_tujuan" class="form-select border-primary" required>
                                                @php
                                                    $hierarchy = [
                                                        ['jab' => 'Asisten Ahli', 'gol' => 'III/b', 'kum' => 150],
                                                        ['jab' => 'Lektor', 'gol' => 'III/c', 'kum' => 200],
                                                        ['jab' => 'Lektor', 'gol' => 'III/d', 'kum' => 300],
                                                        ['jab' => 'Lektor Kepala', 'gol' => 'IV/a', 'kum' => 400],
                                                        ['jab' => 'Lektor Kepala', 'gol' => 'IV/b', 'kum' => 550],
                                                        ['jab' => 'Lektor Kepala', 'gol' => 'IV/c', 'kum' => 700],
                                                        ['jab' => 'Guru Besar', 'gol' => 'IV/d', 'kum' => 850],
                                                        ['jab' => 'Guru Besar', 'gol' => 'IV/e', 'kum' => 1050],
                                                    ];
                                                    $currentIndex = -1;
                                                    foreach ($hierarchy as $idx => $h) {
                                                        if ($h['jab'] == $p->jabatan_fungsional && $h['gol'] == $p->pangkat_golongan) {
                                                            $currentIndex = $idx;
                                                            break;
                                                        }
                                                    }
                                                    $availableOptions = [];
                                                    if ($currentIndex !== -1) {
                                                        if (isset($hierarchy[$currentIndex + 1])) $availableOptions[] = $hierarchy[$currentIndex + 1];
                                                        if (isset($hierarchy[$currentIndex + 2])) $availableOptions[] = $hierarchy[$currentIndex + 2];
                                                    } else {
                                                        $availableOptions = $hierarchy;
                                                    }
                                                @endphp

                                                <option value="" disabled {{ !$p->jabatan_tujuan ? 'selected' : '' }}>-- Pilih Target --</option>
                                                @foreach($availableOptions as $opt)
                                                    @php $val = $opt['jab'] . " (" . $opt['gol'] . ")"; @endphp
                                                    <option value="{{ $val }}" {{ $p->jabatan_tujuan == $val ? 'selected' : '' }}>
                                                        {{ $val }} - Min. {{ $opt['kum'] }} KUM
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">*Pilihan dibatasi satu tingkat di atas posisi saat ini.</small>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Update Estimasi Pensiun</label>
                                            <input type="date" name="estimasi_pensiun_manual" class="form-control" 
                                                value="{{ $p->estimasi_pensiun_manual ?? $tglPensiun->format('Y-m-d') }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="submit" class="btn btn-primary w-100 fw-bold">Simpan Perubahan Target</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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