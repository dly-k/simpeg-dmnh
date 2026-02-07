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
            @forelse($data as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="text-start">
                    <div class="fw-bold">{{ $p->nama_lengkap }}</div>
                    <small class="text-muted">{{ $p->nip ?? '-' }}</small>
                </td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal_lahir)->age }} Thn</td>
                <td class="small">{{ $p->jabatan_fungsional ?? '-' }}</td>
                <td class="small fw-bold text-primary">{{ $p->jabatan_tujuan ?? 'Belum Set' }}</td>
                
                <td class="small text-danger">
                    @php
                        $tglPensiun = $p->estimasi_pensiun_manual 
                            ? \Carbon\Carbon::parse($p->estimasi_pensiun_manual) 
                            : \Carbon\Carbon::parse($p->tanggal_lahir)->addYears(65);
                    @endphp
                    {{ $tglPensiun->isoFormat('D MMM YYYY') }}
                </td>

                <td>
                    <div class="progress" style="height: 8px; width: 80px; margin: 0 auto;">
                        <div class="progress-bar bg-success" style="width: 0%"></div>
                    </div>
                    <small class="text-muted" style="font-size: 0.65rem;">0 / 12 Berkas</small>
                </td>
                
                <td>
                    <span class="badge bg-light text-dark border">0.00</span>
                </td>
                
                <td>
                    @if(\Carbon\Carbon::parse($p->tanggal_lahir)->age < 65)
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
                        
                        {{-- Tombol Edit Mengarah ke Modal ID Spesifik --}}
                        <button type="button" class="btn-aksi btn-edit" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $p->id }}">
                            <i class="fa fa-edit"></i>
                        </button>
                    </div>

                    {{-- Modal di dalam Loop: Pastikan ID Unik --}}
                    <div class="modal fade text-start" id="modalEdit{{ $p->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">Ubah Target: {{ $p->nama_lengkap }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('monitoring.admin.updateTarget', $p->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Jabatan Terakhir</label>
                                            <input type="text" class="form-control bg-light" value="{{ $p->jabatan_fungsional ?? '-' }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold text-primary">Jabatan Tujuan</label>
                                            <select name="jabatan_tujuan" class="form-select border-primary" required>
                                                @php
                                                    $hierarchy = ["Asisten Ahli", "Lektor", "Lektor Kepala", "Guru Besar"];
                                                    $currentIdx = array_search($p->jabatan_fungsional, $hierarchy);
                                                    $suggested = ($currentIdx !== false && isset($hierarchy[$currentIdx + 1])) ? $hierarchy[$currentIdx + 1] : "Asisten Ahli";
                                                @endphp
                                                @foreach($hierarchy as $jab)
                                                    <option value="{{ $jab }}" {{ ($p->jabatan_tujuan ?? $suggested) == $jab ? 'selected' : '' }}>{{ $jab }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Estimasi Pensiun</label>
                                            <input type="date" name="estimasi_pensiun_manual" class="form-control" 
                                                value="{{ $p->estimasi_pensiun_manual ?? $tglPensiun->format('Y-m-d') }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
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