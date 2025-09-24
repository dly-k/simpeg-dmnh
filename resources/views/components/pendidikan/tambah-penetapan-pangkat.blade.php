{{-- Modal Tambah Data Penetapan Pangkat --}}
<div class="modal fade" id="tambahPangkatModal" tabindex="-1" aria-labelledby="tambahPangkatModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="tambahPangkatModalLabel">
          <i class="fas fa-plus-circle me-2"></i> Tambah Data Penetapan Pangkat
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('pangkat.store', $pegawai->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="golongan" class="form-label">Golongan <span class="text-danger">*</span></label>
                    <select id="golongan" name="golongan" class="form-select @error('golongan') is-invalid @enderror" required>
                        <option value="" selected disabled>-- Pilih Golongan --</option>
                        <option value="III/a" {{ old('golongan') == 'III/a' ? 'selected' : '' }}>III/a</option>
                        <option value="III/b" {{ old('golongan') == 'III/b' ? 'selected' : '' }}>III/b</option>
                        <option value="III/c" {{ old('golongan') == 'III/c' ? 'selected' : '' }}>III/c</option>
                        <option value="III/d" {{ old('golongan') == 'III/d' ? 'selected' : '' }}>III/d</option>
                        <option value="IV/a" {{ old('golongan') == 'IV/a' ? 'selected' : '' }}>IV/a</option>
                        <option value="IV/b" {{ old('golongan') == 'IV/b' ? 'selected' : '' }}>IV/b</option>
                        <option value="IV/c" {{ old('golongan') == 'IV/c' ? 'selected' : '' }}>IV/c</option>
                    </select>
                    @error('golongan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                 <div class="col-md-6 mb-3">
                    <label for="nomor_bkn" class="form-label">Persetujuan BKN <span class="text-danger">*</span></label>
                    <input type="text" id="nomor_bkn" name="nomor_bkn" class="form-control @error('nomor_bkn') is-invalid @enderror" value="{{ old('nomor_bkn') }}" placeholder="Masukkan nomor persetujuan BKN" required>
                    @error('nomor_bkn') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tanggal_bkn" class="form-label">Tanggal BKN <span class="text-danger">*</span></label>
                    <input type="date" id="tanggal_bkn" name="tanggal_bkn" class="form-control @error('tanggal_bkn') is-invalid @enderror" value="{{ old('tanggal_bkn') }}" required>
                    @error('tanggal_bkn') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nomor_sk" class="form-label">Nomor SK <span class="text-danger">*</span></label>
                    <input type="text" id="nomor_sk" name="nomor_sk" class="form-control @error('nomor_sk') is-invalid @enderror" value="{{ old('nomor_sk') }}" placeholder="Masukkan nomor SK" required>
                    @error('nomor_sk') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tanggal_sk" class="form-label">Tanggal SK <span class="text-danger">*</span></label>
                    <input type="date" id="tanggal_sk" name="tanggal_sk" class="form-control @error('tanggal_sk') is-invalid @enderror" value="{{ old('tanggal_sk') }}" required>
                    @error('tanggal_sk') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tmt_pangkat" class="form-label">TMT Pangkat <span class="text-danger">*</span></label>
                    <input type="date" id="tmt_pangkat" name="tmt_pangkat" class="form-control @error('tmt_pangkat') is-invalid @enderror" value="{{ old('tmt_pangkat') }}" required>
                    @error('tmt_pangkat') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
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