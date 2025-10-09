{{-- Modal Detail Penguji Luar --}}
<div class="modal fade" id="modalDetailPengujiLuar" tabindex="-1" aria-labelledby="modalDetailPengujiLuarLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailPengujiLuarLabel">
          <i class="fas fa-info-circle"></i>
          <span id="modalTitleTextDetailPengujiLuar">Detail Penguji Luar IPB</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">

        <!-- Informasi Penguji Luar -->
        <div class="detail-grid-container">
          <div class="detail-item full-width-detail">
            <small>Kegiatan</small>
            <p id="detail_pjl_luar_kegiatan">-</p>
          </div>
          <div class="detail-item">
            <small>Nama Dosen</small>
            <p id="detail_pjl_luar_nama">-</p>
          </div>
          <div class="detail-item">
            <small>Tahun Semester</small>
            <p id="detail_pjl_luar_tahun_semester">-</p>
          </div>
          <div class="detail-item">
            <small>NIM</small>
            <p id="detail_pjl_luar_nim">-</p>
          </div>
          <div class="detail-item">
            <small>Nama Mahasiswa</small>
            <p id="detail_pjl_luar_nama_mahasiswa">-</p>
          </div>
          <div class="detail-item">
            <small>Universitas</small>
            <p id="detail_pjl_luar_universitas">-</p>
          </div>
          <div class="detail-item">
            <small>Program Studi</small>
            <p id="detail_pjl_luar_program_studi">-</p>
          </div>
          <div class="detail-item">
            <small>Insidental</small>
            <p id="detail_pjl_luar_insidental">-</p>
          </div>
          <div class="detail-item">
            <small>Lebih Dari 1 Semester</small>
            <p id="detail_pjl_luar_lebih_satu_semester">-</p>
          </div>
        </div>

        <!-- Dokumen -->
        <h6 class="mt-4">Dokumen</h6>
        <div class="document-viewer-container">
          <embed id="detail_pjl_luar_document_viewer" src="" type="application/pdf" width="100%" height="600px" />
        </div>
      </div>

      <!-- Footer -->
      <div class="modal-footer justify-content-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>

    </div>
  </div>
</div>