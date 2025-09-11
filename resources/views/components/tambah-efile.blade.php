{{-- Modal Tambah Data E-file --}}
<div class="modal fade" id="tambahDokumenModal" tabindex="-1" aria-labelledby="tambahDokumenLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="tambahDokumenLabel">
          <i class="fas fa-plus-circle me-2"></i> Tambah Dokumen E-File
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      {{-- Form mengarah ke route efile.store --}}
      <form action="{{ route('efile.store', $pegawai->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="mb-3">
              <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
              <select id="kategori" name="kategori" class="form-select" required>
                <option value="" selected disabled>-- Pilih Kategori --</option>
                <option value="biodata">Biodata</option>
                <option value="pendidikan">Pendidikan</option>
                <option value="jf">Jabatan Fungsional</option>
                <option value="sk">Surat Keputusan Kepangkatan</option>
                <option value="sp">Surat Penting</option>
                <option value="lain">Dokumen Pendukung Lainnya</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="jenis-dokumen" class="form-label">Jenis Dokumen <span class="text-danger">*</span></label>
              <select id="jenis-dokumen" name="nama_dokumen" class="form-select" required>
                <option value="" selected disabled>-- Pilih Kategori terlebih dahulu --</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="keaslian" class="form-label">Keaslian Dokumen <span class="text-danger">*</span></label>
              <select id="keaslian" name="keaslian" class="form-select" required>
                <option value="" selected disabled>-- Pilih Salah Satu --</option>
                <option value="Asli">Asli</option>
                <option value="Legalisir">Legalisir</option>
                <option value="Scan">Scan</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="tanggal_dokumen" class="form-label">Tanggal Dokumen <span class="text-danger">*</span></label>
              <input type="date" id="tanggal_dokumen" name="tanggal_dokumen" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Upload File <span class="text-danger">*</span></label>
              <input type="file" name="dokumen" class="form-control" required>
              <div class="form-text">Tipe file yang diizinkan: PDF, JPG, PNG. Ukuran maksimal: 5 MB.</div>
            </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
