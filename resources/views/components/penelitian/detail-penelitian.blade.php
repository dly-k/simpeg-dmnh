<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel"><i class="fas fa-info-circle"></i> Detail Penelitian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="detail-grid-container">

          <div class="detail-item full-width-detail">
            <small>Judul</small>
            <p id="detail-judul">-</p>
          </div>
          
          <div class="detail-item"><small>Jenis Karya</small><p id="detail-jenis_karya">-</p></div>
          <div class="detail-item"><small>Volume/Issue</small><p id="detail-volume">-</p></div>
          <div class="detail-item"><small>Jumlah Halaman</small><p id="detail-jumlah_halaman">-</p></div>
          
          <div class="detail-item"><small>Tanggal Terbit</small><p id="detail-tanggal_terbit">-</p></div>
          <div class="detail-item"><small>Publik</small><p id="detail-publik">-</p></div>
          <div class="detail-item"><small>URL</small><p id="detail-url">-</p></div>

          <div class="detail-item"><small>ISBN</small><p id="detail-isbn">-</p></div>
          <div class="detail-item"><small>ISSN</small><p id="detail-issn">-</p></div>
          <div class="detail-item"><small>DOI</small><p id="detail-doi">-</p></div>
          
          <div class="detail-item full-width-detail detail-section-header">
            <h5><i class="fas fa-file-alt me-2"></i>Dokumen</h5>
          </div>
          <div class="detail-item">
            <small>File Dokumen</small>
            <div id="detail-dokumen" class="mt-2">-</div>
          </div>
          
          {{-- Bagian Penulis akan diisi secara dinamis oleh JavaScript --}}
          <div id="detail-penulis-ipb-section" class="detail-item full-width-detail detail-section-header d-none">
            <h5><i class="fas fa-user-tie me-2"></i>Penulis Internal (Pegawai)</h5>
          </div>
          <div id="detail-penulis-ipb-list" class="full-width-detail"></div>

          <div id="detail-penulis-luar-section" class="detail-item full-width-detail detail-section-header d-none">
            <h5><i class="fas fa-user-friends me-2"></i>Penulis Luar</h5>
          </div>
          <div id="detail-penulis-luar-list" class="full-width-detail"></div>
          
          <div id="detail-penulis-mahasiswa-section" class="detail-item full-width-detail detail-section-header d-none">
            <h5><i class="fas fa-user-graduate me-2"></i>Penulis Mahasiswa</h5>
          </div>
          <div id="detail-penulis-mahasiswa-list" class="full-width-detail"></div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>

    </div>
  </div>
</div>