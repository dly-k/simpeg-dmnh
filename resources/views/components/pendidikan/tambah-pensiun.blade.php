{{-- Modal Form Pensiun (untuk Tambah & Edit) --}}
<div class="modal fade" id="pensiunModal" tabindex="-1" aria-labelledby="pensiunModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pensiunModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="pensiunForm" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" id="pensiunMethodField">
        <div class="modal-body">
            <div class="mb-3">
                <label for="pensiun_jenis_pensiun" class="form-label">Jenis Pensiun <span class="text-danger">*</span></label>
                <input type="text" id="pensiun_jenis_pensiun" name="jenis_pensiun" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="pensiun_nomor_sk" class="form-label">Nomor SK <span class="text-danger">*</span></label>
                <input type="text" id="pensiun_nomor_sk" name="nomor_sk" class="form-control" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="pensiun_tanggal_sk" class="form-label">Tanggal SK <span class="text-danger">*</span></label>
                    <input type="date" id="pensiun_tanggal_sk" name="tanggal_sk" class="form-control" required>
                </div>
                 <div class="col-md-6 mb-3">
                    <label for="pensiun_tmt_pensiun" class="form-label">TMT Pensiun <span class="text-danger">*</span></label>
                    <input type="date" id="pensiun_tmt_pensiun" name="tmt_pensiun" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
              <label for="pensiun_dokumen" class="form-label">Upload File <span class="text-muted">(Opsional)</span></label>
              <input type="file" name="dokumen" id="pensiun_dokumen" class="form-control">
              <div class="form-text" id="pensiunFileHelp"></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" id="pensiunSubmitButton"></button>
        </div>
      </form>
    </div>
  </div>
</div>