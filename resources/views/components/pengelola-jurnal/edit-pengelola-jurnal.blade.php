<div class="modal fade" id="editPengelolaJurnalModal" tabindex="-1" aria-labelledby="modalEditPengelolaJurnalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form action="#" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="modal-header bg-warning text-dark">
          <h5 class="modal-title" id="modalEditPengelolaJurnalTitle">
            <i class="fas fa-edit me-2"></i> Edit Data Pengelola Jurnal
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">

            <!-- Nama -->
            <div class="col-12">
              <label for="nama" class="form-label">Nama *</label>
              <select name="nama" id="nama" class="form-select">
                <option value="">-- Pilih Nama Pegawai --</option>
                <option value="1" selected>Andi Saputra</option>
                <option value="2">Budi Santoso</option>
                <option value="3">Citra Lestari</option>
              </select>
            </div>

            <!-- Kegiatan -->
            <div class="col-12">
              <label for="kegiatan" class="form-label">Kegiatan *</label>
              <select name="kegiatan" id="kegiatan" class="form-select">
                <option value="">-- Pilih Kegiatan --</option>
                <option value="nasional" selected>Berperan serta aktif dalam pengelolaan jurnal ilmiah (Nasional)</option>
                <option value="internasional">Berperan serta aktif dalam pengelolaan jurnal ilmiah (Internasional)</option>
              </select>
            </div>

            <!-- Media Publikasi -->
            <div class="col-12">
              <label for="media_publikasi" class="form-label">Media Publikasi *</label>
              <input type="text" name="media_publikasi" id="media_publikasi" class="form-control"
                value="Jurnal Teknologi Indonesia">
            </div>

            <!-- Peran -->
            <div class="col-12">
              <label for="peran" class="form-label">Peran *</label>
              <input type="text" name="peran" id="peran" class="form-control"
                value="Editor Utama">
            </div>

            <!-- Nomor SK Penugasan -->
            <div class="col-md-6">
              <label for="no_sk" class="form-label">Nomor SK Penugasan *</label>
              <input type="text" name="no_sk" id="no_sk" class="form-control"
                value="SK-2023-001">
            </div>

            <!-- Tanggal Mulai -->
            <div class="col-md-3">
              <label for="tanggal_mulai" class="form-label">Tanggal Mulai *</label>
              <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control"
                value="2023-01-01">
            </div>

            <!-- Tanggal Selesai -->
            <div class="col-md-3">
              <label for="tanggal_selesai" class="form-label">Tanggal Selesai *</label>
              <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control"
                value="2023-12-31">
            </div>

            <!-- Status -->
            <div class="col-12">
              <label for="status" class="form-label">Status *</label>
              <select name="status" id="status" class="form-select">
                <option value="">-- Pilih Status --</option>
                <option value="Aktif" selected>Aktif</option>
                <option value="Tidak Aktif">Tidak Aktif</option>
              </select>
            </div>

            <!-- Dokumen -->
            <div class="col-12">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="form-label">Dokumen</label>
                <button type="button" class="btn btn-sm btn-success" id="addEditDokumen">
                  <i class="fas fa-plus"></i> Tambah Dokumen
                </button>
              </div>

              <div id="editDokumenWrapper">
                <!-- Dokumen lama (sudah ada) -->
                <div class="dokumen-item border rounded p-3 mb-3 position-relative">
                  <button type="button" class="btn-close position-absolute top-0 end-0 m-2 removeDokumen" aria-label="Close"></button>
                  <div class="row g-2">
                    <div class="col-12">
                      <label class="form-label">Jenis Dokumen</label>
                      <select name="dokumen[0][jenis]" class="form-select">
                        <option value="" disabled>-- Pilih Jenis Dokumen --</option>
                        <option value="SK" selected>SK</option>
                        <option value="Sertifikat">Sertifikat</option>
                        <option value="Surat Tugas">Surat Tugas</option>
                        <option value="Laporan Kegiatan">Laporan Kegiatan</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Nama Dokumen</label>
                      <input type="text" name="dokumen[0][nama]" class="form-control"
                        value="SK Penugasan Jurnal">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Nomor</label>
                      <input type="text" name="dokumen[0][nomor]" class="form-control"
                        value="SK-001/2023">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Tautan</label>
                      <input type="url" name="dokumen[0][tautan]" class="form-control"
                        value="https://example.com/sk-penugasan.pdf">
                    </div>
                    <div class="col-12">
                      <label class="form-label">File <small class="text-muted">(Maksimal Ukuran File 5MB)</small></label>
                      <input type="file" name="dokumen[0][file]" class="form-control file-input"
                        accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.txt">
                      <small class="text-muted">File saat ini: <a href="https://example.com/sk-penugasan.pdf" target="_blank">Lihat</a></small>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>