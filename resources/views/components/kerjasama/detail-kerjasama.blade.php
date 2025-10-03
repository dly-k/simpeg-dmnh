<div class="modal fade" id="modalDetailKerjasama{{ $kerjasama->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      
      {{-- Header hijau --}}
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title"><i class="fas fa-info-circle"></i> Detail Kerjasama</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">

        <div class="detail-grid-container">
          <div class="detail-item full-width-detail"><small>Judul</small><p>{{ $kerjasama->judul }}</p></div>
          <div class="detail-item"><small>Mitra/Instansi</small><p>{{ $kerjasama->mitra }}</p></div>
          <div class="detail-item"><small>No Surat</small>
            <p>
              @if($kerjasama->no_surat_mitra) Mitra: {{ $kerjasama->no_surat_mitra }}<br>@endif
              @if($kerjasama->no_surat_departemen) Dept: {{ $kerjasama->no_surat_departemen }}@endif
            </p>
          </div>
          <div class="detail-item"><small>Tgl. Dokumen</small><p>{{ $kerjasama->tgl_dokumen?->format('d M Y') }}</p></div>
          <div class="detail-item"><small>Departemen PJ</small><p>{{ $kerjasama->departemen_penanggung_jawab }}</p></div>
          <div class="detail-item"><small>TMT</small><p>{{ $kerjasama->tmt?->format('d M Y') }}</p></div>
          <div class="detail-item"><small>TST</small><p>{{ $kerjasama->tst?->format('d M Y') }}</p></div>

          {{-- Ketua Tim --}}
          <div class="detail-item full-width-detail">
            <small>Ketua Tim</small>
            <ul class="list-unstyled mb-0 ps-2">
              @foreach($kerjasama->tim->where('jabatan','ketua') as $ketua)
                <li class="d-flex justify-content-between align-items-center mb-2">
                  <span>{{ $loop->iteration }}. {{ $ketua->nama }}</span>
                  @if($ketua->departemen)
                    <span class="badge badge-dept">{{ $ketua->departemen }}</span>
                  @endif
                </li>
              @endforeach
            </ul>
          </div>

          {{-- Anggota Tim --}}
          <div class="detail-item full-width-detail">
            <small>Anggota Tim</small>
            <ul class="list-unstyled mb-0 ps-2">
              @foreach($kerjasama->tim->where('jabatan','anggota') as $anggota)
                <li class="d-flex justify-content-between align-items-center mb-2">
                  <span>{{ $loop->iteration }}. {{ $anggota->nama }}</span>
                  @if($anggota->departemen)
                    <span class="badge badge-dept">{{ $anggota->departemen }}</span>
                  @endif
                </li>
              @endforeach
            </ul>
          </div>

          <div class="detail-item"><small>Lokasi</small><p>{{ $kerjasama->lokasi }}</p></div>
          <div class="detail-item"><small>Besaran Dana</small><p>Rp {{ number_format($kerjasama->besaran_dana ?? 0, 0, ',', '.') }}</p></div>
          <div class="detail-item"><small>Jenis Kerjasama</small><p>{{ $kerjasama->jenis_kerjasama }}</p></div>
          <div class="detail-item"><small>Jenis Usulan</small><p>{{ $kerjasama->jenis_usulan }}</p></div>
        </div>

        {{-- File Terlampir --}}
        <div class="file-actions-container mt-3">
          <h6 class="file-actions-title">File Terlampir</h6>
          <div class="file-actions-buttons">
            @if($kerjasama->file_dokumen)
              <a href="{{ asset('storage/'.$kerjasama->file_dokumen) }}" target="_blank" class="btn-lihat_document">
                <i class="fas fa-file-alt me-2"></i> Lihat Dokumen
              </a>
            @endif
            @if($kerjasama->file_laporan)
              <a href="{{ asset('storage/'.$kerjasama->file_laporan) }}" target="_blank" class="btn-lihat_laporan">
                <i class="fas fa-file-invoice me-2"></i> Lihat Laporan
              </a>
            @endif
          </div>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>