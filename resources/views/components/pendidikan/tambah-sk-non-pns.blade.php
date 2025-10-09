{{-- Modal Form SK Non PNS (untuk Tambah & Edit) --}}
<div class="modal fade" id="nonPnsModal" tabindex="-1" aria-labelledby="nonPnsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="nonPnsModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="nonPnsForm" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" id="nonPnsMethodField">
        <div class="modal-body">
            <div class="mb-3">
                <label for="non_pns_jenis_sk" class="form-label">Jenis SK <span class="text-danger">*</span></label>
                <input type="text" id="non_pns_jenis_sk" name="jenis_sk" class="form-control" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="non_pns_nomor_sk" class="form-label">Nomor SK <span class="text-danger">*</span></label>
                    <input type="text" id="non_pns_nomor_sk" name="nomor_sk" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="non_pns_tanggal_sk" class="form-label">Tanggal SK <span class="text-danger">*</span></label>
                    <input type="date" id="non_pns_tanggal_sk" name="tanggal_sk" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="non_pns_tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                    <input type="date" id="non_pns_tanggal_mulai" name="tanggal_mulai" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="non_pns_tanggal_selesai" class="form-label">Tanggal Selesai</label>
                    <input type="date" id="non_pns_tanggal_selesai" name="tanggal_selesai" class="form-control">
                </div>
            </div>
            <div class="mb-3">
              <label for="non_pns_dokumen" class="form-label">Unggah Dokumen <span class="text-muted">(Opsional)</span></label>
              <input type="file" name="dokumen" id="non_pns_dokumen" class="form-control">
              <div class="form-text" id="nonPnsFileHelp"></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" id="nonPnsSubmitButton"></button>
        </div>
      </form>
    </div>
  </div>
</div>