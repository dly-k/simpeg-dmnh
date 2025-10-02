<div class="modal-backdrop" id="editDataModal-{{ $user->id }}">
  <div class="modal-content-wrapper">
    <div class="modal-header-custom">
      <h5><i class="fas fa-edit"></i> Edit Data Pengguna</h5>
    </div>
    <div class="modal-body-custom">
      <form action="{{ route('master-data.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
          <label class="form-label">Nama Pegawai</label>
          {{-- Nama pegawai tidak bisa diubah, jadi ditampilkan sebagai teks biasa --}}
          <input type="text" class="form-control" value="{{ $user->pegawai->nama_lengkap ?? 'N/A' }}" readonly>
        </div>
        <div class="mb-3">
          <label class="form-label">ID Pengguna</label>
          <input type="text" class="form-control" name="username" value="{{ $user->username }}" placeholder="Masukkan ID Pengguna" required>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Hak Akses</label>
            <select class="form-select" name="role" required>
              <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
              <option value="admin_verifikator" {{ $user->role == 'admin_verifikator' ? 'selected' : '' }}>Admin dan Verifikator</option>
              <option value="tata_usaha" {{ $user->role == 'tata_usaha' ? 'selected' : '' }}>Tata Usaha</option>
            </select>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">
              Password 
              <small class="text-muted">(Kosongkan jika tidak diubah)</small>
            </label>
            <div class="input-group">
                <input type="password" name="password" class="form-control" placeholder="Masukkan Password Baru">
                <span class="input-group-text toggle-password-icon" style="cursor: pointer;">
                    <i class="fa fa-eye-slash"></i>
                </span>
            </div>
          </div>
        </div>
        <div class="modal-footer-custom">
          <button type="button" class="btn btn-secondary" onclick="closeModal('editDataModal-{{ $user->id }}')">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>