{{-- Modal Detail Orasi Ilmiah --}}
<div class="modal fade" id="modalDetailOrasiIlmiah" tabindex="-1" aria-labelledby="modalDetailOrasiIlmiahLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailOrasiIlmiahLabel">
          <i class="fas fa-info-circle"></i>
          <span>Detail Orasi Ilmiah</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">

        <!-- Informasi Orasi Ilmiah -->
        <div class="detail-grid-container">
          <div class="detail-item">
            <small>Pegawai</small>
            <p id="detail_orasi_pegawai">-</p>
          </div>
          <div class="detail-item">
            <small>Litabmas</small>
            <p id="detail_orasi_litabmas">-</p>
          </div>
          <div class="detail-item">
            <small>Kategori Pembicara</small>
            <p id="detail_orasi_kategori_pembicara">-</p>
          </div>
          <div class="detail-item">
            <small>Lingkup</small>
            <p id="detail_orasi_lingkup">-</p>
          </div>
          <div class="detail-item">
            <small>Judul Makalah</small>
            <p id="detail_orasi_judul_makalah">-</p>
          </div>
          <div class="detail-item">
            <small>Nama Pertemuan</small>
            <p id="detail_orasi_nama_pertemuan">-</p>
          </div>
          <div class="detail-item">
            <small>Penyelenggara</small>
            <p id="detail_orasi_penyelenggara">-</p>
          </div>
          <div class="detail-item">
            <small>Tanggal Pelaksanaan</small>
            <p id="detail_orasi_tanggal_pelaksana">-</p>
          </div>
          <div class="detail-item">
            <small>Bahasa</small>
            <p id="detail_orasi_bahasa">-</p>
          </div>
        </div>

        <!-- Dokumen -->
        <h6 class="mt-4">Dokumen</h6>
        <div class="detail-grid-container">
          <div class="detail-item">
            <small>Jenis Dokumen</small>
            <p id="detail_orasi_jenis_dokumen">-</p>
          </div>
          <div class="detail-item">
            <small>Nama Dokumen</small>
            <p id="detail_orasi_nama_dokumen">-</p>
          </div>
          <div class="detail-item">
            <small>Nomor Dokumen</small>
            <p id="detail_orasi_nomor_dokumen">-</p>
          </div>
          <div class="detail-item">
            <small>Tautan</small>
            <p id="detail_orasi_tautan">-</p>
          </div>
        </div>

        <!-- Viewer -->
        <div class="document-viewer-container mt-4">
          <embed id="detail_orasi_document_viewer" src="" type="application/pdf" width="100%" height="600px" />
        </div>
      </div>

      <!-- Footer -->
      <div class="modal-footer justify-content-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>

    </div>
  </div>
</div>