<!-- Modal Detail Praktisi Dunia Industri -->
<div class="modal fade" id="detailPraktisiModal" tabindex="-1" aria-labelledby="detailModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="detailModalTitle">
          <i class="fas fa-eye me-2"></i> Detail Praktisi Dunia Industri
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">
        <div class="row g-3">

          <!-- Nama -->
          <div class="col-12">
            <label class="form-label fw-bold">Nama</label>
            <p id="detail-nama">-</p>
          </div>

          <!-- Bidang Usaha -->
          <div class="col-12">
            <label class="form-label fw-bold">Bidang Usaha</label>
            <p id="detail-bidang">-</p>
          </div>

          <!-- Jenis Pekerjaan & Jabatan -->
          <div class="col-md-6">
            <label class="form-label fw-bold">Jenis Pekerjaan</label>
            <p id="detail-jenis">-</p>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Jabatan</label>
            <p id="detail-jabatan">-</p>
          </div>

          <!-- Instansi & Divisi -->
          <div class="col-md-6">
            <label class="form-label fw-bold">Instansi</label>
            <p id="detail-instansi">-</p>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Divisi</label>
            <p id="detail-divisi">-</p>
          </div>

          <!-- Deskripsi Kerja -->
          <div class="col-12">
            <label class="form-label fw-bold">Deskripsi Kerja</label>
            <p id="detail-deskripsi">-</p>
          </div>

          <!-- Tanggal Mulai & Selesai -->
          <div class="col-md-6">
            <label class="form-label fw-bold">Mulai Bekerja</label>
            <p id="detail-mulai">-</p>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Selesai Bekerja</label>
            <p id="detail-selesai">-</p>
          </div>

          <!-- Area & Kategori -->
          <div class="col-md-6">
            <label class="form-label fw-bold">Area Pekerjaan</label>
            <p id="detail-area">-</p>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Kategori Pekerjaan</label>
            <p id="detail-kategori">-</p>
          </div>

          <!-- Dokumen -->
          {{-- Ganti bagian Dokumen yang lama dengan ini --}}
          <div class="col-12">
              <label class="form-label fw-bold mb-3">Dokumen Terlampir</label>
              <div class="row g-3">
                  {{-- Surat Tugas dari IPB --}}
                  <div class="col-md-6">
                      <small class="text-muted d-block">Surat Tugas dari IPB</small>
                      <a href="#" id="detail-surat-ipb" class="btn btn-sm btn-info text-white" target="_blank" style="display: none;">
                          <i class="fa fa-eye me-1"></i> Lihat File
                      </a>
                      <span id="nodata-surat-ipb" class="text-muted fst-italic">Tidak ada file</span>
                  </div>

                  {{-- Surat Tugas dari Instansi --}}
                  <div class="col-md-6">
                      <small class="text-muted d-block">Surat Tugas dari Instansi</small>
                      <a href="#" id="detail-surat-instansi" class="btn btn-sm btn-info text-white" target="_blank" style="display: none;">
                          <i class="fa fa-eye me-1"></i> Lihat File
                      </a>
                      <span id="nodata-surat-instansi" class="text-muted fst-italic">Tidak ada file</span>
                  </div>

                  {{-- Curriculum Vitae (CV) --}}
                  <div class="col-md-6">
                      <small class="text-muted d-block">Curriculum Vitae (CV)</small>
                      <a href="#" id="detail-cv" class="btn btn-sm btn-info text-white" target="_blank" style="display: none;">
                          <i class="fa fa-eye me-1"></i> Lihat File
                      </a>
                      <span id="nodata-cv" class="text-muted fst-italic">Tidak ada file</span>
                  </div>

                  {{-- Profil Perusahaan --}}
                  <div class="col-md-6">
                      <small class="text-muted d-block">Profil Perusahaan</small>
                      <a href="#" id="detail-profil" class="btn btn-sm btn-info text-white" target="_blank" style="display: none;">
                          <i class="fa fa-eye me-1"></i> Lihat File
                      </a>
                      <span id="nodata-profil" class="text-muted fst-italic">Tidak ada file</span>
                  </div>
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