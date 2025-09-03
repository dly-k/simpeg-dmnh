<div class="modal fade" id="skNonPnsModal" tabindex="-1" aria-labelledby="skNonPnsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="skNonPnsModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="skNonPnsForm" method="POST" action="" enctype="multipart/form-data">
        @csrf
        <div id="editMethod"></div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label">Nama Pegawai</label>
              <input type="text" class="form-control" id="nama_pegawai" name="nama_pegawai" placeholder="Masukkan nama pegawai" required>
            </div>
            <div class="col-12">
              <label class="form-label">Nama Unit</label>
              <input type="text" class="form-control" id="nama_unit" name="nama_unit" placeholder="Masukkan nama unit" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Tanggal Mulai</label>
              <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Tanggal Selesai</label>
              <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
            </div>
            <div class="col-12">
              <label class="form-label">Nomor SK</label>
              <input type="text" class="form-control" id="nomor_sk" name="nomor_sk" placeholder="Masukkan Nomor SK" required>
            </div>
            <div class="col-12">
              <label class="form-label">Tanggal SK</label>
              <input type="date" class="form-control" id="tanggal_sk" name="tanggal_sk" required>
            </div>
            <div class="col-12">
              <label class="form-label">Jenis SK</label>
              <select class="form-select" id="jenis_sk" name="jenis_sk" required>
                <option value="" selected>-- Pilih Jenis SK --</option>
                <option value="Tenaga Kependidikan">Tenaga Kependidikan</option>
                <option value="Dosen">Dosen</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label" id="dokumen_label"></label>
              <div class="upload-area">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Seret & Lepas File di sini atau Klik untuk Pilih File</p>
                <input type="file" id="dokumen_sk" name="dokumen_sk" hidden accept=".pdf">
              </div>
              <div id="file-size-feedback-sk" class="text-danger mt-1" style="display: none;"></div>
              <div id="dokumen-lama-container" class="mt-2" style="display: none;">
                <small>Dokumen saat ini: <a href="#" id="dokumen-lama-link" target="_blank">Lihat Dokumen</a></small>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success" id="btn-simpan"></button>
        </div>
      </form>
    </div>
  </div>
</div>