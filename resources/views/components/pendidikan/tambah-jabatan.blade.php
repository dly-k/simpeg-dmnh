{{-- Modal Form Jabatan (untuk Tambah & Edit) --}}
<div class="modal fade" id="jabatanModal" tabindex="-1" aria-labelledby="jabatanModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="jabatanModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="jabatanForm" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" id="jabatanMethodField">
        <div class="modal-body">
            <div class="mb-3">
                <label for="jabatan_nama_jabatan" class="form-label">Nama Jabatan <span class="text-danger">*</span></label>
                <select id="jabatan_nama_jabatan" name="nama_jabatan" class="form-select" required>
                    <option value="" selected disabled>-- Pilih Jabatan --</option>
                    <option value="Asisten Ahli">Asisten Ahli</option>
                    <option value="Lektor">Lektor</option>
                    <option value="Lektor Kepala">Lektor Kepala</option>
                    <option value="Guru Besar">Guru Besar</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="jabatan_jenis_sk" class="form-label">Jenis SK <span class="text-danger">*</span></label>
                <input type="text" id="jabatan_jenis_sk" name="jenis_sk" class="form-control" required>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="jabatan_nomor_sk" class="form-label">Nomor SK <span class="text-danger">*</span></label>
                    <input type="text" id="jabatan_nomor_sk" name="nomor_sk" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="jabatan_tanggal_sk" class="form-label">Tanggal SK <span class="text-danger">*</span></label>
                    <input type="date" id="jabatan_tanggal_sk" name="tanggal_sk" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="jabatan_tmt_jabatan" class="form-label">TMT Jabatan <span class="text-danger">*</span></label>
                    <input type="date" id="jabatan_tmt_jabatan" name="tmt_jabatan" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
              <label for="jabatan_dokumen" class="form-label">Upload File <span class="text-muted">(Opsional)</span></label>
              <input type="file" name="dokumen" id="jabatan_dokumen" class="form-control">
              <div class="form-text" id="jabatanFileHelp"></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" id="jabatanSubmitButton"></button>
        </div>
      </form>
    </div>
  </div>
</div>