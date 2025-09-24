{{-- Modal Tambah Data Jabatan --}}
<div class="modal fade" id="tambahJabatanModal" tabindex="-1" aria-labelledby="tambahJabatanModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="tambahJabatanModalLabel"><i class="fas fa-plus-circle me-2"></i> Tambah Data Jabatan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('jabatan.store', $pegawai->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            
            <div class="mb-3">
                <label for="nama_jabatan" class="form-label">Nama Jabatan <span class="text-danger">*</span></label>
                <select id="nama_jabatan" name="nama_jabatan" class="form-select @error('nama_jabatan') is-invalid @enderror" required>
                    <option value="" selected disabled>-- Pilih Jabatan --</option>
                    <option value="Asisten Ahli" {{ old('nama_jabatan') == 'Asisten Ahli' ? 'selected' : '' }}>Asisten Ahli</option>
                    <option value="Lektor" {{ old('nama_jabatan') == 'Lektor' ? 'selected' : '' }}>Lektor</option>
                    <option value="Lektor Kepala" {{ old('nama_jabatan') == 'Lektor Kepala' ? 'selected' : '' }}>Lektor Kepala</option>
                    <option value="Guru Besar" {{ old('nama_jabatan') == 'Guru Besar' ? 'selected' : '' }}>Guru Besar</option>
                </select>
                @error('nama_jabatan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
            
            <div class="mb-3">
                <label for="jenis_sk" class="form-label">Jenis SK <span class="text-danger">*</span></label>
                <input type="text" id="jenis_sk" name="jenis_sk" class="form-control @error('jenis_sk') is-invalid @enderror" value="{{ old('jenis_sk') }}" placeholder="Masukkan jenis SK" required>
                @error('jenis_sk') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="nomor_sk_jabatan" class="form-label">Nomor SK <span class="text-danger">*</span></label>
                    <input type="text" id="nomor_sk_jabatan" name="nomor_sk" class="form-control @error('nomor_sk') is-invalid @enderror" value="{{ old('nomor_sk') }}" placeholder="Masukkan nomor SK" required>
                    @error('nomor_sk') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="tanggal_sk_jabatan" class="form-label">Tanggal SK <span class="text-danger">*</span></label>
                    <input type="date" id="tanggal_sk_jabatan" name="tanggal_sk" class="form-control @error('tanggal_sk') is-invalid @enderror" value="{{ old('tanggal_sk') }}" required>
                    @error('tanggal_sk') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="tmt_jabatan" class="form-label">TMT Jabatan <span class="text-danger">*</span></label>
                    <input type="date" id="tmt_jabatan" name="tmt_jabatan" class="form-control @error('tmt_jabatan') is-invalid @enderror" value="{{ old('tmt_jabatan') }}" required>
                    @error('tmt_jabatan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Upload File <span class="text-muted">(Opsional)</span></label>
              <input type="file" name="dokumen" class="form-control @error('dokumen') is-invalid @enderror">
              @error('dokumen') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
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