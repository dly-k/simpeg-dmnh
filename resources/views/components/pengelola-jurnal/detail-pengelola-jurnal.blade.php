<!-- Modal Detail Pengelola Jurnal -->
<div class="modal fade" id="detailPengelolaJurnalModal" tabindex="-1" aria-labelledby="detailPengelolaJurnalTitle" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="detailPengelolaJurnalTitle">
          <i class="fas fa-info-circle"></i> Detail Pengelola Jurnal
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">

        <!-- Card Data -->
        <div class="detail-card mb-3">
          <div class="detail-grid">
            <div>
              <span>Nama Pegawai</span>
              <p id="detail-nama">-</p>
            </div>
            <div>
              <span>Kegiatan</span>
              <p id="detail-kegiatan">-</p>
            </div>
            <div>
              <span>Media Publikasi</span>
              <p id="detail-media">-</p>
            </div>
            <div>
              <span>Peran</span>
              <p id="detail-peran">-</p>
            </div>
            <div>
              <span>Nomor SK</span>
              <p id="detail-no-sk">-</p>
            </div>
            <div>
              <span>Tanggal Mulai</span>
              <p id="detail-tgl-mulai">-</p>
            </div>
            <div>
              <span>Tanggal Selesai</span>
              <p id="detail-tgl-selesai">-</p>
            </div>
            <div>
              <span>Status</span>
              <p id="detail-status">-</p>
            </div>
          </div>
        </div>

        <!-- Dokumen -->
        <h6 class="fw-bold mt-3">Dokumen Terlampir</h6>
        <div class="row g-3" id="detail-dokumen-list">
          </div>

      </div>

      <!-- Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>

    </div>
  </div>
</div>