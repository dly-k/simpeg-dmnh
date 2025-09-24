{{-- Modal Tambah SK Non PNS --}}
<div class="modal fade" id="tambahNonPnsModal" tabindex="-1" aria-labelledby="tambahNonPnsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="tambahNonPnsModalLabel"><i class="fas fa-plus-circle me-2"></i> Tambah SK Non PNS</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('sk-non-pns.store', $pegawai->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="mb-3">
                <label for="jenis_sk_non_pns" class="form-label">Jenis SK <span class="text-danger">*</span></label>
                <input type="text" id="jenis_sk_non_pns" name="jenis_sk" class="form-control @error('jenis_sk') is-invalid @enderror" value="{{ old('jenis_sk') }}" placeholder="Contoh: SK Pengangkatan Dosen Tetap" required>
                @error('jenis_sk') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nomor_sk_non_pns" class="form-label">Nomor SK <span class="text-danger">*</span></label>
                    <input type="text" id="nomor_sk_non_pns" name="nomor_sk" class="form-control @error('nomor_sk') is-invalid @enderror" value="{{ old('nomor_sk') }}" placeholder="Masukkan nomor SK" required>
                    @error('nomor_sk') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tanggal_sk_non_pns" class="form-label">Tanggal SK <span class="text-danger">*</span></label>
                    <input type="date" id="tanggal_sk_non_pns" name="tanggal_sk" class="form-control @error('tanggal_sk') is-invalid @enderror" value="{{ old('tanggal_sk') }}" required>
                    @error('tanggal_sk') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tanggal_mulai_non_pns" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                    <input type="date" id="tanggal_mulai_non_pns" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai') }}" required>
                    @error('tanggal_mulai') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tanggal_selesai_non_pns" class="form-label">Tanggal Selesai</label>
                    <input type="date" id="tanggal_selesai_non_pns" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai') }}">
                    @error('tanggal_selesai') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
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