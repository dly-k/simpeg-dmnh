<div class="modal-backdrop" id="tambahDataModal">
  <div class="modal-content-wrapper">
    <div class="modal-header-custom">
      <h5><i class="fas fa-plus-circle"></i> Tambah Data Pengguna</h5>
    </div>
    <div class="modal-body-custom">
      <form action="{{ route('master-data.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label">Nama Pegawai</label>
          <select class="form-select" name="pegawai_id" required>
            <option value="" disabled selected>-- Pilih Nama Pegawai --</option>
            @foreach ($pegawais as $pegawai)
                <option value="{{ $pegawai->id }}">{{ $pegawai->nama_lengkap }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">ID Pengguna</label>
          <input type="text" class="form-control" name="username" placeholder="Masukkan ID Pengguna" required>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Hak Akses</label>
            <select class="form-select" name="role" required>
              <option value="" disabled selected>-- Pilih Hak Akses --</option>
              <option value="admin">Admin</option>
              <option value="admin_verifikator">Admin dan Verifikator</option>
              <option value="tata_usaha">Tata Usaha</option>
            </select>
          </div>
          <div class="col-md-6 mb-3">
              <label class="form-label">Password</label>
              <div class="input-group">
                  <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                  <span class="input-group-text toggle-password-icon" style="cursor: pointer;">
                      <i class="fa fa-eye-slash"></i>
                  </span>
              </div>
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