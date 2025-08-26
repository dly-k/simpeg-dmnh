{{-- Modal Tambah Data E-file --}}
<div class="modal fade" id="tambahDokumenModal" tabindex="-1" aria-labelledby="tambahDokumenLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="tambahDokumenLabel">
          <i class="fas fa-plus-circle me-2"></i> Tambah Data Pengguna
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <form>

          <!-- Kategori -->
          <div class="mb-3">
            <label class="form-label">Kategori <span class="text-danger">*</span></label>
            <select id="kategori" class="form-select" required>
              <option value="" selected disabled>-- Pilih Kategori --</option>
              <option value="biodata">Biodata</option>
              <option value="pendidikan">Pendidikan</option>
              <option value="jf">Jabatan Fungsional</option>
              <option value="sk">Surat Keputusan Kepangkatan</option>
              <option value="sp">Surat Penting</option>
              <option value="lain">Dokumen Pendukung Lainnya</option>
            </select>
          </div>

          <!-- Jenis Dokumen -->
          <div class="mb-3">
            <label class="form-label">Jenis Dokumen <span class="text-danger">*</span></label>
            <select id="jenis-dokumen" class="form-select" required>
              <option value="" selected disabled>-- Pilih Jenis Dokumen --</option>
              <!-- Opsi jenis dokumen akan dimuat di sini -->
            </select>
          </div>

          <!-- Keaslian Dokumen -->
          <div class="mb-3">
            <label class="form-label">Keaslian Dokumen <span class="text-danger">*</span></label>
            <select class="form-select" required>
              <option value="" selected disabled>-- Pilih Salah Satu --</option>
              <option value="asli">Asli</option>
              <option value="legalisir">Legalisir</option>
              <option value="scan">Scan</option>
            </select>
          </div>

          <!-- Tanggal Pembuatan -->
          <div class="mb-3">
            <label class="form-label">Tanggal Pembuatan <span class="text-danger">*</span></label>
            <input type="date" class="form-control" required>
          </div>

          <!-- Upload File -->
          <div class="mb-3">
            <label class="form-label">Upload File <span class="text-danger">*</span></label>
            <div class="border p-4 text-center rounded" style="border-style: dashed;">
              <input type="file" class="form-control" id="uploadFileInput" style="display: none;" required>
              <label for="uploadFileInput" style="cursor: pointer;">
                <i class="fa fa-cloud-upload-alt fa-2x text-secondary mb-2"></i>
                <p>Drag & Drop file di sini<br><small>Ukuran Maksimal 5 MB</small></p>
              </label>
            </div>
          </div>

        </form>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-hapusFile" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-simpan">Simpan</button>
      </div>

    </div>
  </div>
</div>