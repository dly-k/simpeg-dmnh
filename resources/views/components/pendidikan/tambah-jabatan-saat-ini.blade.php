{{-- Modal Tambah Data Jabatan Saat Ini --}}
<div class="modal fade" id="tambahJabatanSaatIniModal" tabindex="-1" aria-labelledby="tambahJabatanSaatIniModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="tambahJabatanSaatIniModalLabel"><i class="fas fa-plus-circle me-2"></i> Tambah Jabatan Saat Ini</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('jabatan-saat-ini.store', $pegawai->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="mb-3">
                <label for="nama_jabatan_saat_ini" class="form-label">Nama Jabatan <span class="text-danger">*</span></label>
                <input type="text" id="nama_jabatan_saat_ini" name="nama_jabatan" class="form-control @error('nama_jabatan') is-invalid @enderror" value="{{ old('nama_jabatan') }}" placeholder="Contoh: Guru Besar" required>
                @error('nama_jabatan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
            
            <div class="mb-3">
                <label for="jenis_jabatan" class="form-label">Jenis Jabatan <span class="text-danger">*</span></label>
                <select id="jenis_jabatan" name="jenis_jabatan" class="form-select @error('jenis_jabatan') is-invalid @enderror" required>
                    <option value="" selected disabled>-- Pilih Jenis --</option>
                    <option value="Fungsional" {{ old('jenis_jabatan') == 'Fungsional' ? 'selected' : '' }}>Fungsional</option>
                    <option value="Struktural" {{ old('jenis_jabatan') == 'Struktural' ? 'selected' : '' }}>Struktural</option>
                </select>
                @error('jenis_jabatan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="nomor_sk_saat_ini" class="form-label">Nomor SK <span class="text-danger">*</span></label>
                <input type="text" id="nomor_sk_saat_ini" name="nomor_sk" class="form-control @error('nomor_sk') is-invalid @enderror" value="{{ old('nomor_sk') }}" placeholder="Masukkan nomor SK" required>
                @error('nomor_sk') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
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