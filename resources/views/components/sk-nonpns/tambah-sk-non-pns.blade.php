  <!--Edit & Tambah modal-->  
  <div class="modal fade" id="skNonPnsModal" tabindex="-1" aria-labelledby="skNonPnsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="skNonPnsModalLabel"><i class="fas fa-plus-circle"></i> Tambah Data SK Non PNS</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="skNonPnsForm">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label">Pegawai</label>
              <select class="form-select">
                  <option selected>-- Pilih Pegawai --</option>
                  </select>
            </div>
            <div class="col-12">
              <label class="form-label">Unit</label>
              <select class="form-select">
                  <option selected>-- Pilih Unit --</option>
                  </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Tanggal Mulai</label>
              <input type="date" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Tanggal Selesai</label>
              <input type="date" class="form-control">
            </div>
            <div class="col-12">
              <label class="form-label">Nomor SK</label>
              <input type="text" class="form-control" placeholder="Masukkan Nomor SK">
            </div>
            <div class="col-12">
              <label class="form-label">Tanggal SK</label>
              <input type="date" class="form-control">
            </div>
            <div class="col-12">
              <label class="form-label">Jenis SK</label>
              <select class="form-select">
                  <option selected>-- Pilih Jenis SK --</option>
                  <option>Tenaga Kependidikan</option>
                  <option>Dosen</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label">Unggah Dokumen SK</label>
              <div class="upload-area">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small></p>
                <input type="file" hidden>
              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-success">Simpan</button>
      </div>
      
    </div>
  </div>
</div>