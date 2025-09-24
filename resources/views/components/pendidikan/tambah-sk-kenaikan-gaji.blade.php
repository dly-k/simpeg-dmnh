{{-- Modal Form Kenaikan Gaji Berkala (untuk Tambah & Edit) --}}
<div class="modal fade" id="gajiBerkalaModal" tabindex="-1" aria-labelledby="gajiBerkalaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="gajiBerkalaModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="gajiBerkalaForm" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" id="gajiBerkalaMethodField">
        <div class="modal-body">
            <div class="mb-3">
                <label for="gaji_berkala_golongan" class="form-label">Golongan <span class="text-danger">*</span></label>
                <select id="gaji_berkala_golongan" name="golongan" class="form-select" required>
                    <option value="" selected disabled>-- Pilih Golongan --</option>
                    <option value="III/a">III/a</option><option value="III/b">III/b</option><option value="III/c">III/c</option>
                </select>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="gaji_berkala_nomor_sk" class="form-label">Nomor SK <span class="text-danger">*</span></label>
                    <input type="text" id="gaji_berkala_nomor_sk" name="nomor_sk" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="gaji_berkala_tanggal_sk" class="form-label">Tanggal SK <span class="text-danger">*</span></label>
                    <input type="date" id="gaji_berkala_tanggal_sk" name="tanggal_sk" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="gaji_berkala_tmt_gaji" class="form-label">TMT Gaji <span class="text-danger">*</span></label>
                    <input type="date" id="gaji_berkala_tmt_gaji" name="tmt_gaji" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="gaji_berkala_gaji_pokok" class="form-label">Gaji Pokok <span class="text-danger">*</span></label>
                    <input type="number" id="gaji_berkala_gaji_pokok" name="gaji_pokok" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
              <label for="gaji_berkala_dokumen" class="form-label">Upload File <span class="text-muted">(Opsional)</span></label>
              <input type="file" name="dokumen" id="gaji_berkala_dokumen" class="form-control">
              <div class="form-text" id="gajiBerkalaFileHelp"></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" id="gajiBerkalaSubmitButton"></button>
        </div>
      </form>
    </div>
  </div>
</div>