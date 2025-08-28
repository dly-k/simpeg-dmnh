{{-- Modal Tambah Data Master Data --}}
<div class="modal-backdrop" id="tambahDataModal">
  <div class="modal-content-wrapper">
    <div class="modal-header-custom">
      <h5><i class="fas fa-plus-circle"></i> Tambah Data Pengguna</h5>
    </div>
    <div class="modal-body-custom">
      <form>
        <div class="mb-3">
          <label class="form-label">Nama Pegawai</label>
          <select class="form-select" required>
            <option value="" selected>-- Pilih Nama Pegawai --</option>
            <option>Dr. Soni Trison, S.Hut, M.Si</option>
            <option>Ria Kodariah, S.Si</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">ID Pengguna</label>
          <input type="text" class="form-control" placeholder="Masukkan ID Pengguna" required>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Hak Akses</label>
            <select class="form-select" required>
              <option value="" selected>-- Pilih Hak Akses --</option>
              <option>Admin</option>
              <option>Administrasi Kepegawaian</option>
            </select>
          </div>
            {{-- SESUDAH --}}
            <div class="col-md-6 mb-3">
              <label class="form-label">Password</label>
              <div class="input-group">
                <input type="password" id="addPassword" class="form-control" placeholder="Masukkan Password" required>
                <span class="input-group-text toggle-password-icon" style="cursor: pointer;">
                  <i class="fa fa-eye-slash"></i>
                </span>
              </div>
            </div>
        </div>
      </form>
    </div>
    <div class="modal-footer-custom">
      <button type="button" class="btn btn-secondary" onclick="closeModal('tambahDataModal')">Batal</button>
      <button type="button" class="btn btn-success">Simpan</button>
    </div>
  </div>
</div>

<div class="modal-backdrop" id="editDataModal">
  <div class="modal-content-wrapper">
    <div class="modal-header-custom">
      <h5><i class="lni lni-pencil-alt"></i> Edit Data Pengguna</h5>
    </div>
    <div class="modal-body-custom">
      <form>
        <div class="mb-3">
          <label class="form-label">Nama Pegawai</label>
          <select id="editNamaPegawai" class="form-select" required>
            <option>Dr. Soni Trison, S.Hut, M.Si</option>
            <option>Ria Kodariah, S.Si</option>
            <option>Meli Surnami</option>
            <option>Saeful Rohim</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">ID Pengguna</label>
          <input id="editIdPengguna" type="text" class="form-control" placeholder="Masukkan ID Pengguna" required>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Hak Akses</label>
            <select id="editHakAkses" class="form-select" required>
              <option>Admin</option>
              <option>Administrasi Kepegawaian</option>
            </select>
          </div>
          {{-- SESUDAH --}}
          <div class="col-md-6 mb-3">
            <label class="form-label">
              Password 
              <small class="text-muted" style="font-size: 70%">(Kosongkan jika tidak diubah)</small>
            </label>
            <div class="input-group">
              <input type="password" id="editPassword" class="form-control" placeholder="Masukkan Password Baru">
              <span class="input-group-text toggle-password-icon" style="cursor: pointer;">
                <i class="fa fa-eye-slash"></i>
              </span>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="modal-footer-custom">
      <button type="button" class="btn btn-secondary" onclick="closeModal('editDataModal')">Batal</button>
      <button type="button" class="btn btn-success">Simpan Perubahan</button>
    </div>
  </div>
</div>