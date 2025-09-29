<!-- Modal Detail Pembicara -->
<div class="modal fade" id="detailPembicaraModal" tabindex="-1" aria-labelledby="detailModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="detailModalTitle">
          <i class="fas fa-info-circle"></i> Detail Pembicara
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">

        <!-- Card Data -->
        <div class="detail-card mb-3">
          <div class="detail-grid">
            <div>
              <span>Nama</span>
              <p id="detail-nama">-</p>
            </div>
            <div>
              <span>Kegiatan</span>
              <p id="detail-kegiatan">-</p>
            </div>
            <div>
              <span>Kategori Capaian</span>
              <p id="detail-capaian">-</p>
            </div>
            <div>
              <span>Kategori Pembicara</span>
              <p id="detail-kategori-pembicara">-</p>
            </div>
            <div>
              <span>Judul Makalah</span>
              <p id="detail-makalah">-</p>
            </div>
            <div>
              <span>Nama Pertemuan</span>
              <p id="detail-pertemuan">-</p>
            </div>
            <div>
              <span>Tanggal Pelaksanaan</span>
              <p id="detail-tanggal">-</p>
            </div>
            <div>
              <span>Penyelenggara</span>
              <p id="detail-penyelenggara">-</p>
            </div>
            <div>
              <span>Tingkat Pertemuan</span>
              <p id="detail-tingkat">-</p>
            </div>
            <div>
              <span>Bahasa</span>
              <p id="detail-bahasa">-</p>
            </div>
            <div>
              <span>Litabmas</span>
              <p id="detail-litabmas">-</p>
            </div>
          </div>
        </div>

        <!-- Dokumen -->
        <h6 class="fw-bold mt-3">Dokumen Terlampir</h6>
        <div class="row g-3" id="detail-dokumen-list">
          <!-- Contoh dokumen -->
          <div class="col-md-6">
            <div class="detail-doc">
              <span>File Sertifikat</span>
              <a href="#" id="detail-sertifikat" class="btn btn-sm btn-success text-white mt-1" target="_blank" style="display:none;">
                <i class="fa fa-eye me-1"></i> Lihat File
              </a>
              <span id="nodata-sertifikat" class="text-muted fst-italic">Tidak ada file</span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="detail-doc">
              <span>File SK/Surat Tugas</span>
              <a href="#" id="detail-sk" class="btn btn-sm btn-success text-white mt-1" target="_blank" style="display:none;">
                <i class="fa fa-eye me-1"></i> Lihat File
              </a>
              <span id="nodata-sk" class="text-muted fst-italic">Tidak ada file</span>
            </div>
          </div>
        </div>

      </div>

      <!-- Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>

    </div>
  </div>
</div>