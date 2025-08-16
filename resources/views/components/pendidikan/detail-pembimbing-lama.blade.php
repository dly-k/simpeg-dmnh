{{-- Modal Detail Pembimbing Lama --}}
<div class="modal fade" id="modalDetailPembimbingLama" tabindex="-1" aria-labelledby="modalDetailPembimbingLamaLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailPembimbingLamaLabel">
          <i class="fas fa-info-circle"></i>
          <span id="modalTitleTextDetailPembimbingLama">Detail Pembimbing Lama</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">

        <!-- Detail Grid -->
        <div class="detail-grid-container">
          <div class="detail-item full-width-detail">
            <small>Kegiatan</small>
            <p id="detail_pbl_kegiatan">-</p>
          </div>
          <div class="detail-item">
            <small>Nama</small>
            <p id="detail_pbl_nama">-</p>
          </div>
          <div class="detail-item">
            <small>Tahun Semester</small>
            <p id="detail_pbl_tahun_semester">-</p>
          </div>
          <div class="detail-item">
            <small>Lokasi (PL/KKN)</small>
            <p id="detail_pbl_lokasi">-</p>
          </div>
          <div class="detail-item">
            <small>NIM</small>
            <p id="detail_pbl_nim">-</p>
          </div>
          <div class="detail-item">
            <small>Nama Mahasiswa</small>
            <p id="detail_pbl_nama_mahasiswa">-</p>
          </div>
          <div class="detail-item">
            <small>Departemen</small>
            <p id="detail_pbl_departemen">-</p>
          </div>
          <div class="detail-item">
            <small>Nama Dokumen</small>
            <p id="detail_pbl_nama_dokumen">-</p>
          </div>
        </div>

        <!-- Dokumen -->
        <h6 class="mt-4">Dokumen</h6>
        <div class="document-viewer-container">
          <embed 
            id="detail_pbl_document_viewer" 
            src="" 
            type="application/pdf" 
            width="100%" 
            height="600px" 
          />
        </div>
      </div>

      <!-- Footer -->
      <div class="modal-footer justify-content-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>

    </div>
  </div>
</div>