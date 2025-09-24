{{-- Modal Form Jabatan Saat Ini (untuk Tambah & Edit) --}}
<div class="modal fade" id="jabatanSaatIniModal" tabindex="-1" aria-labelledby="jabatanSaatIniModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="jabatanSaatIniModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="jabatanSaatIniForm" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" id="jabatanSaatIniMethodField">
        <div class="modal-body">
            <div class="mb-3">
                <label for="jabatan_saat_ini_nama_jabatan" class="form-label">Nama Jabatan <span class="text-danger">*</span></label>
                <input type="text" id="jabatan_saat_ini_nama_jabatan" name="nama_jabatan" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="jabatan_saat_ini_jenis_jabatan" class="form-label">Jenis Jabatan <span class="text-danger">*</span></label>
                <select id="jabatan_saat_ini_jenis_jabatan" name="jenis_jabatan" class="form-select" required>
                    <option value="" selected disabled>-- Pilih Jenis --</option>
                    <option value="Fungsional">Fungsional</option>
                    <option value="Struktural">Struktural</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="jabatan_saat_ini_nomor_sk" class="form-label">Nomor SK <span class="text-danger">*</span></label>
                <input type="text" id="jabatan_saat_ini_nomor_sk" name="nomor_sk" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="jabatan_saat_ini_dokumen" class="form-label">Upload File <span class="text-muted">(Opsional)</span></label>
              <input type="file" name="dokumen" id="jabatan_saat_ini_dokumen" class="form-control">
              <div class="form-text" id="jabatanSaatIniFileHelp"></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" id="jabatanSaatIniSubmitButton"></button>
        </div>
      </form>
    </div>
  </div>
</div>