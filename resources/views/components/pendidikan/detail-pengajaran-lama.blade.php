{{-- Modal Detail Pengajaran Lama --}}
<div class="modal fade" id="modalDetailPengajaranLama" tabindex="-1" aria-labelledby="modalDetailPengajaranLamaLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailPengajaranLamaLabel">
          <i class="fas fa-info-circle"></i>
          <span id="modalTitleTextDetailPengajaranLama">Detail Pengajaran Lama</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <div class="detail-grid-container">

          <div class="detail-item full-width-detail">
            <small>Kegiatan</small>
            <p id="detail_pl_kegiatan">-</p>
          </div>

          <div class="detail-item">
            <small>Nama</small>
            <p id="detail_pl_nama">-</p>
          </div>

          <div class="detail-item">
            <small>Tahun Semester</small>
            <p id="detail_pl_tahun_semester">-</p>
          </div>

          <div class="detail-item">
            <small>Kode Mata Kuliah</small>
            <p id="detail_pl_kode_mk">-</p>
          </div>

          <div class="detail-item">
            <small>Nama Mata Kuliah</small>
            <p id="detail_pl_nama_mk">-</p>
          </div>

          <div class="detail-item">
            <small>Pengampu</small>
            <p id="detail_pl_pengampu">-</p>
          </div>

          <div class="detail-item">
            <small>SKS Perkuliahan</small>
            <p id="detail_pl_sks_kuliah">-</p>
          </div>

          <div class="detail-item">
            <small>SKS Praktikum</small>
            <p id="detail_pl_sks_praktikum">-</p>
          </div>

          <div class="detail-item">
            <small>Jenis</small>
            <p id="detail_pl_jenis">-</p>
          </div>

          <div class="detail-item">
            <small>Kelas Paralel</small>
            <p id="detail_pl_kelas_paralel">-</p>
          </div>

          <div class="detail-item">
            <small>Jumlah Pertemuan</small>
            <p id="detail_pl_jumlah_pertemuan">-</p>
          </div>

        </div>

        <!-- Dokumen -->
        <h6 class="mt-4">Dokumen</h6>
        <div class="document-viewer-container">
          <embed id="detail_pl_document_viewer" src="" type="application/pdf" width="100%" height="600px" />
        </div>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer justify-content-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>

    </div>
  </div>
</div>