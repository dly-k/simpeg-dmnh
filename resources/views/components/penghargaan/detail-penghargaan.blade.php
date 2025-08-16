{{-- Modal Detail Penghargaan --}}
<div class="modal fade" id="modalDetailPenghargaan" tabindex="-1" aria-labelledby="modalDetailPenghargaanLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailPenghargaanLabel">
          <i class="fas fa-info-circle"></i>
          <span>Detail Penghargaan</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">

        <!-- Informasi Penghargaan -->
        <div class="detail-grid-container">
          <div class="detail-item">
            <small>Pegawai</small>
            <p id="detail_penghargaan_pegawai">-</p>
          </div>
          <div class="detail-item">
            <small>Kegiatan</small>
            <p id="detail_penghargaan_kegiatan">-</p>
          </div>
          <div class="detail-item">
            <small>Nama Penghargaan</small>
            <p id="detail_penghargaan_nama_penghargaan">-</p>
          </div>
          <div class="detail-item">
            <small>Nomor</small>
            <p id="detail_penghargaan_nomor">-</p>
          </div>
          <div class="detail-item">
            <small>Tanggal Perolehan</small>
            <p id="detail_penghargaan_tanggal_perolehan">-</p>
          </div>
          <div class="detail-item">
            <small>Lingkup</small>
            <p id="detail_penghargaan_lingkup">-</p>
          </div>
          <div class="detail-item">
            <small>Negara</small>
            <p id="detail_penghargaan_negara">-</p>
          </div>
          <div class="detail-item">
            <small>Instansi</small>
            <p id="detail_penghargaan_instansi">-</p>
          </div>
        </div>

        <!-- Dokumen -->
        <h6 class="mt-4">Dokumen</h6>
        <div class="detail-grid-container">
          <div class="detail-item">
            <small>Jenis Dokumen</small>
            <p id="detail_penghargaan_jenis_dokumen">-</p>
          </div>
          <div class="detail-item">
            <small>Nama Dokumen</small>
            <p id="detail_penghargaan_nama_dokumen">-</p>
          </div>
          <div class="detail-item">
            <small>Nomor Dokumen</small>
            <p id="detail_penghargaan_nomor_dokumen">-</p>
          </div>
          <div class="detail-item">
            <small>Tautan</small>
            <p id="detail_penghargaan_tautan">-</p>
          </div>
        </div>

        <!-- Viewer -->
        <div class="document-viewer-container mt-4">
          <embed id="detail_penghargaan_document_viewer" src="" type="application/pdf" width="100%" height="600px" />
        </div>
      </div>

      <!-- Footer -->
      <div class="modal-footer justify-content-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>

    </div>
  </div>
</div>