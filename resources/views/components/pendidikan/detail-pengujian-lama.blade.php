{{-- Modal Detail Pengujian Lama --}}
<div class="modal fade" id="modalDetailPengujianLama" tabindex="-1" aria-labelledby="modalDetailPengujianLamaLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailPengujianLamaLabel">
          <i class="fas fa-info-circle"></i>
          <span id="modalTitleTextDetailPengujianLama">Detail Pengujian Lama</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">

        <!-- Informasi Pengujian Lama -->
        <div class="detail-grid-container">
          <div class="detail-item full-width-detail">
            <small>Kegiatan</small>
            <p id="detail_pjl_kegiatan">-</p>
          </div>
          <div class="detail-item">
            <small>Nama Dosen</small>
            <p id="detail_pjl_nama">-</p>
          </div>
          <div class="detail-item">
            <small>Tahun Semester</small>
            <p id="detail_pjl_tahun_semester">-</p>
          </div>
          <div class="detail-item">
            <small>NIM</small>
            <p id="detail_pjl_nim">-</p>
          </div>
          <div class="detail-item">
            <small>Nama Mahasiswa</small>
            <p id="detail_pjl_nama_mahasiswa">-</p>
          </div>
          <div class="detail-item">
            <small>Departemen</small>
            <p id="detail_pjl_departemen">-</p>
          </div>
        </div>

        <!-- Dokumen -->
        <h6 class="mt-4">Dokumen</h6>
        <div class="document-viewer-container">
          <embed id="detail_pjl_document_viewer" src="" type="application/pdf" width="100%" height="600px" />
        </div>
      </div>

      <!-- Footer -->
      <div class="modal-footer justify-content-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>

    </div>
  </div>
</div>