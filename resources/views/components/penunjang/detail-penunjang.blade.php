<div class="modal fade" id="penunjangDetailModal" tabindex="-1" aria-labelledby="penunjangDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="penunjangDetailLabel"><i class="fas fa-info-circle"></i> Detail Penunjang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="detail-grid-container">
          {{-- Berikan ID unik untuk setiap elemen p --}}
          <div class="detail-item full-width-detail"><small>Kegiatan</small><p id="detail-kegiatan">-</p></div>
          <div class="detail-item full-width-detail"><small>Jenis Kegiatan</small><p id="detail-jenis_kegiatan">-</p></div>
          <div class="detail-item"><small>Lingkup</small><p id="detail-lingkup">-</p></div>
          <div class="detail-item"><small>Nama Kegiatan</small><p id="detail-nama_kegiatan">-</p></div>
          <div class="detail-item"><small>Instansi</small><p id="detail-instansi">-</p></div>
          <div class="detail-item"><small>Nomor SK</small><p id="detail-nomor_sk">-</p></div>
          <div class="detail-item"><small>TMT</small><p id="detail-tmt_mulai">-</p></div>
          <div class="detail-item"><small>TST</small><p id="detail-tmt_selesai">-</p></div>

          {{-- Kontainer untuk Anggota --}}
          <div class="detail-item full-width-detail detail-section-header"><h5><i class="fas fa-users"></i> Anggota</h5></div>
          <div id="detail-anggota-list" class="full-width-detail">
             {{-- Anggota akan diisi oleh JavaScript --}}
          </div>

          {{-- Kontainer untuk Dokumen --}}
          <div class="detail-item full-width-detail detail-section-header"><h5><i class="fas fa-file-alt"></i> Dokumen</h5></div>
          <div id="detail-dokumen-list" class="full-width-detail">
            {{-- Dokumen akan diisi oleh JavaScript --}}
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>