{{-- Modal Detail Kerjasama --}}
<div class="modal fade" id="modalDetailKerjasama" tabindex="-1" aria-labelledby="modalDetailKerjasamaLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailKerjasamaLabel"><i class="fas fa-info-circle"></i> Detail Kerjasama</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="detail-grid-container">
          <div class="detail-item full-width-detail"><small>Judul</small><p id="detail_kerjasama_judul">-</p></div>
          <div class="detail-item"><small>Mitra/Instansi</small><p id="detail_kerjasama_mitra">-</p></div>
          <div class="detail-item"><small>No Dokumen</small><p id="detail_kerjasama_no_dokumen">-</p></div>
          <div class="detail-item"><small>Tgl. Dokumen</small><p id="detail_kerjasama_tgl_dokumen">-</p></div>
          <div class="detail-item"><small>TMT</small><p id="detail_kerjasama_tmt">-</p></div>
          <div class="detail-item"><small>TST</small><p id="detail_kerjasama_tst">-</p></div>
          <div class="detail-item"><small>Departemen/Prodi</small><p id="detail_kerjasama_departemen">-</p></div>
          <div class="detail-item full-width-detail">
              <small>Ketua Tim</small>
              <p id="detail_ketua" class="fw">-</p>
          </div>
          <div class="detail-item full-width-detail">
              <small>Anggota Tim</small>
              <ul id="detail_anggota_list" class="list-unstyled mb-0 ps-2">
                  </ul>
          </div>
          <div class="detail-item"><small>Lokasi</small><p id="detail_kerjasama_lokasi">-</p></div>
          <div class="detail-item"><small>Besaran Dana</small><p id="detail_kerjasama_dana">-</p></div>
          <div class="detail-item"><small>Jenis Kerjasama</small><p id="detail_kerjasama_jenis">-</p></div>
        </div>
        <h6 class="mt-4">Dokumen</h6>
        <div class="document-viewer-container">
          <embed id="detail_kerjasama_document_viewer" src="" type="application/pdf" width="100%" height="600px" />
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>