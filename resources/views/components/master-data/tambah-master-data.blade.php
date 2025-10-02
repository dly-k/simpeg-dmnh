<div class="modal-backdrop" id="tambahDataModal">
  <div class="modal-content-wrapper">
    <div class="modal-header-custom">
      <h5><i class="fas fa-plus-circle"></i> Tambah Data Pengguna</h5>
    </div>
    <div class="modal-body-custom">
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <form action="{{ route('master-data.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label">Nama Pegawai</label>
          <select class="form-select @error('pegawai_id') is-invalid @enderror" name="pegawai_id" required>
            <option value="" disabled selected>-- Pilih Nama Pegawai --</option>
            @foreach ($pegawais as $pegawai)
                <option value="{{ $pegawai->id }}" {{ old('pegawai_id') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->nama_lengkap }}</option>
            @endforeach
          </select>
          @error('pegawai_id')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">ID Pengguna</label>
          <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="Masukkan ID Pengguna" required>
          @error('username')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Hak Akses</label>
            <select class="form-select @error('role') is-invalid @enderror" name="role" required>
              <option value="" disabled selected>-- Pilih Hak Akses --</option>
              <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
              <option value="admin_verifikator" {{ old('role') == 'admin_verifikator' ? 'selected' : '' }}>Admin dan Verifikator</option>
              <option value="tata_usaha" {{ old('role') == 'tata_usaha' ? 'selected' : '' }}>Tata Usaha</option>
            </select>
            @error('role')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-6 mb-3">
              <label class="form-label">Password</label>
              <div class="input-group">
                  <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan Password" required>
                  <span class="input-group-text toggle-password-icon" style="cursor: pointer;">
                      <i class="fa fa-eye-slash"></i>
                  </span>
              </div>
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
        </div>
        <div class="modal-footer-custom">
          <button type="button" class="btn btn-secondary" onclick="closeModal('tambahDataModal')">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>