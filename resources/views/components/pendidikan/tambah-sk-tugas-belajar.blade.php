{{-- Modal Form Tugas Belajar (untuk Tambah & Edit) --}}
<div class="modal fade" id="tugasBelajarModal" tabindex="-1" aria-labelledby="tugasBelajarModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tugasBelajarModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="tugasBelajarForm" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" id="tugasBelajarMethodField">
        <div class="modal-body">
            <div class="mb-3">
                <label for="tugas_belajar_jenis_tugas_belajar" class="form-label">Jenis Tugas Belajar <span class="text-danger">*</span></label>
                <input type="text" id="tugas_belajar_jenis_tugas_belajar" name="jenis_tugas_belajar" class="form-control" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tugas_belajar_nomor_sk" class="form-label">Nomor SK <span class="text-danger">*</span></label>
                    <input type="text" id="tugas_belajar_nomor_sk" name="nomor_sk" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tugas_belajar_tanggal_sk" class="form-label">Tanggal SK <span class="text-danger">*</span></label>
                    <input type="date" id="tugas_belajar_tanggal_sk" name="tanggal_sk" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tugas_belajar_tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                    <input type="date" id="tugas_belajar_tanggal_mulai" name="tanggal_mulai" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tugas_belajar_tanggal_selesai" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                    <input type="date" id="tugas_belajar_tanggal_selesai" name="tanggal_selesai" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
              <label for="tugas_belajar_dokumen" class="form-label">Upload File <span class="text-muted">(Opsional)</span></label>
              <input type="file" name="dokumen" id="tugas_belajar_dokumen" class="form-control">
              <div class="form-text" id="tugasBelajarFileHelp"></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" id="tugasBelajarSubmitButton"></button>
        </div>
      </form>
    </div>
  </div>
</div>