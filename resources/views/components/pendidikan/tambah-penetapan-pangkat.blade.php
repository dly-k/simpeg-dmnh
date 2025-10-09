{{-- Modal Form Penetapan Pangkat (untuk Tambah & Edit) --}}
<div class="modal fade" id="pangkatModal" tabindex="-1" aria-labelledby="pangkatModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pangkatModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="pangkatForm" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" id="pangkatMethodField">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="pangkat_golongan" class="form-label">Golongan <span class="text-danger">*</span></label>
                    <select id="pangkat_golongan" name="golongan" class="form-select" required>
                        <option value="" selected disabled>-- Pilih Golongan --</option>
                        <option value="III/a">III/a</option><option value="III/b">III/b</option><option value="III/c">III/c</option><option value="III/d">III/d</option>
                        <option value="IV/a">IV/a</option><option value="IV/b">IV/b</option><option value="IV/c">IV/c</option>
                    </select>
                </div>
                 <div class="col-md-6 mb-3">
                    <label for="pangkat_nomor_bkn" class="form-label">Persetujuan BKN <span class="text-danger">*</span></label>
                    <input type="text" id="pangkat_nomor_bkn" name="nomor_bkn" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="pangkat_tanggal_bkn" class="form-label">Tanggal BKN <span class="text-danger">*</span></label>
                    <input type="date" id="pangkat_tanggal_bkn" name="tanggal_bkn" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="pangkat_nomor_sk" class="form-label">Nomor SK <span class="text-danger">*</span></label>
                    <input type="text" id="pangkat_nomor_sk" name="nomor_sk" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="pangkat_tanggal_sk" class="form-label">Tanggal SK <span class="text-danger">*</span></label>
                    <input type="date" id="pangkat_tanggal_sk" name="tanggal_sk" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="pangkat_tmt_pangkat" class="form-label">TMT Pangkat <span class="text-danger">*</span></label>
                    <input type="date" id="pangkat_tmt_pangkat" name="tmt_pangkat" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
              <label for="pangkat_dokumen" class="form-label">Unggah Dokumen <span class="text-muted">(Opsional)</span></label>
              <input type="file" name="dokumen" id="pangkat_dokumen" class="form-control">
              <div class="form-text" id="pangkatFileHelp"></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" id="pangkatSubmitButton"></button>
        </div>
      </form>
    </div>
  </div>
</div>