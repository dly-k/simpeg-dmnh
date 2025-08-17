  {{-- Detail Tambah Master Data --}}
  <div class="modal-backdrop" id="tambahDataModal">
    <div class="modal-content-wrapper">
      <div class="modal-header-custom">
        <h5><i class="fas fa-plus-circle"></i> Tambah Data Pengguna</h5>
      </div>
      <div class="modal-body-custom">
        <form>
          <div class="mb-3"><label class="form-label">Nama Pegawai</label><select class="form-select"><option selected>-- Pilih Salah Satu --</option><option>Dr. Soni Trison, S.Hut, M.Si</option><option>Ria Kodariah, S.Si</option></select></div>
          <div class="mb-3"><label class="form-label">ID Pengguna</label><input type="text" class="form-control"></div>
          <div class="row">
            <div class="col-md-6 mb-3"><label class="form-label">Hak Akses</label><select class="form-select"><option selected>-- Pilih Salah Satu --</option><option>Admin</option><option>Administrasi Kepegawaian</option></select></div>
            <div class="col-md-6 mb-3"><label class="form-label">Password</label><input type="password" class="form-control"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer-custom">
        <button type="button" class="btn btn-danger" onclick="closeModal('tambahDataModal')">Batal</button>
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
            <select id="editNamaPegawai" class="form-select">
              <option>Dr. Soni Trison, S.Hut, M.Si</option>
              <option>Ria Kodariah, S.Si</option>
              <option>Meli Surnami</option>
              <option>Saeful Rohim</option>
            </select>
          </div>
          <div class="mb-3"><label class="form-label">ID Pengguna</label><input id="editIdPengguna" type="text" class="form-control"></div>
          <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Hak Akses</label>
                <select id="editHakAkses" class="form-select">
                    <option>Admin</option>
                    <option>Administrasi Kepegawaian</option>
                </select>
            </div>
            <div class="col-md-6 mb-3"><label class="form-label">Password <small class="text-muted" style="font-size: 70%">(Kosongkan jika tidak diubah)</small></label><input type="password" class="form-control"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer-custom">
        <button type="button" class="btn btn-danger" onclick="closeModal('editDataModal')">Batal</button>
        <button type="button" class="btn btn-success">Simpan Perubahan</button>
      </div>
    </div>
  </div>

  <footer class="footer-custom">
    <span>© 2025 Forest Management — All Rights Reserved</span>
  </footer>