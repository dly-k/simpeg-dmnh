<!-- Modal Edit Data -->
<div class="modal fade" id="editDataModal-{{ $user->id }}" tabindex="-1" aria-labelledby="editDataLabel-{{ $user->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="editDataLabel-{{ $user->id }}">
          <i class="fas fa-edit"></i> Edit Data Pengguna
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">
        <form action="{{ route('master-data.update', $user) }}" method="POST">
          @csrf
          @method('PUT')

          <!-- Nama Pegawai (Readonly) -->
          <div class="mb-3">
            <label class="form-label">Nama Pegawai</label>
            <input type="text" class="form-control" value="{{ $user->pegawai->nama_lengkap ?? 'N/A' }}" readonly>
          </div>

          <!-- ID Pengguna -->
          <div class="mb-3">
            <label class="form-label">ID Pengguna</label>
            <input 
              type="text" 
              class="form-control" 
              name="username" 
              value="{{ $user->username }}" 
              placeholder="Masukkan ID Pengguna" 
              required>
          </div>

          <div class="row">
            <!-- Hak Akses -->
            <div class="col-md-6 mb-3">
              <label class="form-label">Hak Akses</label>
              <select class="form-select" name="role" required>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="admin_verifikator" {{ $user->role == 'admin_verifikator' ? 'selected' : '' }}>Admin & Verifikator</option>
                <option value="tata_usaha" {{ $user->role == 'tata_usaha' ? 'selected' : '' }}>Tata Usaha</option>
              </select>
            </div>

            <!-- Password -->
            <div class="col-md-6 mb-3">
              <label class="form-label">
                Password <small class="text-muted">(Kosongkan jika tidak diubah)</small>
              </label>
              <div class="input-group">
                <input 
                  type="password" 
                  name="password" 
                  class="form-control" 
                  placeholder="Masukkan Password Baru">
                <span class="input-group-text toggle-password-icon" style="cursor: pointer;">
                  <i class="fa fa-eye-slash"></i>
                </span>
              </div>
            </div>
          </div>

          <!-- Footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success btn-save-spinner">Simpan Perubahan</button>
          </div>

        </form>
      </div>

    </div>
  </div>
</div>