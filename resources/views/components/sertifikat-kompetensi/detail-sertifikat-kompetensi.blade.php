{{-- Modal Detail Sertifikat Kompetensi --}}
<div class="modal fade" id="modalDetailSertifikatKompetensi" tabindex="-1" aria-labelledby="modalDetailSertifikatKompetensiLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="modalDetailSertifikatKompetensiLabel">
          <i class="fas fa-info-circle"></i>
          <span>Detail Sertifikat Kompetensi</span>
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">
        <div class="detail-grid-container">
          <div class="detail-item">
            <small>Nama Pegawai</small>
            <p id="detail_sertifikat_nama">-</p>
          </div>
          <div class="detail-item">
            <small>Kegiatan</small>
            <p id="detail_sertifikat_kegiatan">-</p>
          </div>
          <div class="detail-item">
            <small>Judul Kegiatan</small>
            <p id="detail_sertifikat_judul">-</p>
          </div>
          <div class="detail-item">
            <small>Nomor Registrasi Pendidik</small>
            <p id="detail_sertifikat_no_reg">-</p>
          </div>
          <div class="detail-item">
            <small>Nomor SK Sertifikasi</small>
            <p id="detail_sertifikat_no_sk">-</p>
          </div>
          <div class="detail-item">
            <small>Tahun Sertifikasi</small>
            <p id="detail_sertifikat_tahun">-</p>
          </div>
          <div class="detail-item">
            <small>TMT Sertifikasi</small>
            <p id="detail_sertifikat_tmt">-</p>
          </div>
          <div class="detail-item">
            <small>TST Sertifikasi</small>
            <p id="detail_sertifikat_tst">-</p>
          </div>
          <div class="detail-item">
            <small>Bidang Studi</small>
            <p id="detail_sertifikat_bidang">-</p>
          </div>
          <div class="detail-item">
            <small>Lembaga Sertifikasi</small>
            <p id="detail_sertifikat_lembaga">-</p>
          </div>
        </div>

        <!-- Dokumen -->
        <h6 class="mt-4">Dokumen</h6>
        
        <!-- Viewer -->
        <div class="document-viewer-container mt-4">
          <embed id="detail_sertifikat_document_viewer" src="" type="application/pdf" width="100%" height="600px" />
        </div>
      </div>

      <!-- Footer -->
      <div class="modal-footer justify-content-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>

    </div>
  </div>
</div>
