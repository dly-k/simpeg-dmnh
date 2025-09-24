{{-- Modal Tambah SK Kenaikan Gaji Berkala --}}
<div class="modal fade" id="tambahGajiBerkalaModal" tabindex="-1" aria-labelledby="tambahGajiBerkalaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="tambahGajiBerkalaModalLabel"><i class="fas fa-plus-circle me-2"></i> Tambah SK Kenaikan Gaji Berkala</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('gaji-berkala.store', $pegawai->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="mb-3">
                <label for="golongan_gaji" class="form-label">Golongan <span class="text-danger">*</span></label>
                <select id="golongan_gaji" name="golongan" class="form-select @error('golongan') is-invalid @enderror" required>
                    <option value="" selected disabled>-- Pilih Golongan --</option>
                    <option value="III/a" {{ old('golongan') == 'III/a' ? 'selected' : '' }}>III/a</option>
                    <option value="III/b" {{ old('golongan') == 'III/b' ? 'selected' : '' }}>III/b</option>
                    <option value="III/c" {{ old('golongan') == 'III/c' ? 'selected' : '' }}>III/c</option>
                </select>
                @error('golongan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nomor_sk_gaji" class="form-label">Nomor SK <span class="text-danger">*</span></label>
                    <input type="text" id="nomor_sk_gaji" name="nomor_sk" class="form-control @error('nomor_sk') is-invalid @enderror" value="{{ old('nomor_sk') }}" placeholder="Masukkan nomor SK" required>
                    @error('nomor_sk') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tanggal_sk_gaji" class="form-label">Tanggal SK <span class="text-danger">*</span></label>
                    <input type="date" id="tanggal_sk_gaji" name="tanggal_sk" class="form-control @error('tanggal_sk') is-invalid @enderror" value="{{ old('tanggal_sk') }}" required>
                    @error('tanggal_sk') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tmt_gaji" class="form-label">TMT Gaji <span class="text-danger">*</span></label>
                    <input type="date" id="tmt_gaji" name="tmt_gaji" class="form-control @error('tmt_gaji') is-invalid @enderror" value="{{ old('tmt_gaji') }}" required>
                    @error('tmt_gaji') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="gaji_pokok" class="form-label">Gaji Pokok <span class="text-danger">*</span></label>
                    <input type="number" id="gaji_pokok" name="gaji_pokok" class="form-control @error('gaji_pokok') is-invalid @enderror" value="{{ old('gaji_pokok') }}" placeholder="Contoh: 5000000" required>
                    @error('gaji_pokok') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
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