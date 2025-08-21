  <div class="modal-backdrop" id="penelitianModal">
    <div class="modal-content-wrapper">
      <div class="modal-header-custom">
        <h5 id="modalTitle"><i class="fas fa-plus-circle"></i> Tambah Data Penelitian</h5>
      </div>
      <div class="modal-body-custom">
        <form id="penelitianForm">
          <div class="row g-3">
            <div class="col-12"><label class="form-label">Judul</label><input type="text" class="form-control" name="judul" placeholder="Judul Penelitian"></div>
            <div class="col-12"><label class="form-label">Jenis Karya</label><select class="form-select" name="jenisKarya"><option selected>-- Pilih Salah Satu --</option></select></div>
            <div class="col-md-6"><label class="form-label">Volume/Issue</label><input type="text" class="form-control" name="volume" placeholder="2020/2021"></div>
            <div class="col-md-6"><label class="form-label">Jumlah Halaman</label><select class="form-select" name="jumlahHalaman"><option selected>-- Pilih Salah Satu --</option></select></div>
            <div class="col-md-6"><label class="form-label">Tanggal Terbit</label><input type="date" class="form-control" name="tanggalTerbit"></div>
            <div class="col-md-6"><label class="form-label">Publik</label><select class="form-select" name="publik"><option selected>-- Pilih Salah Satu --</option><option value="Ya">Ya</option><option value="Tidak">Tidak</option></select></div>
            <div class="col-md-6"><label class="form-label">ISBN</label><input type="text" class="form-control" name="isbn" placeholder="Masukkan ISBN Anda"></div>
            <div class="col-md-6"><label class="form-label">ISSN</label><input type="text" class="form-control" name="issn" placeholder="Masukkan ISSN Anda"></div>
            <div class="col-md-6"><label class="form-label">DOI</label><input type="text" class="form-control" name="doi" placeholder="2020/2021"></div>
            <div class="col-md-6"><label class="form-label">URL</label><input type="text" class="form-control" name="url" placeholder="2020/2021"></div>

            <div class="col-12">
              <label class="form-label">Dokumen Terkait</label>
              <div class="upload-area">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small></p>
                <input type="file" hidden>
              </div>
            </div>

            <div class="col-12">
              <label class="form-label">Penulis IPB</label>
              <div id="penulis-ipb-list">
                <div class="input-group mb-2">
                  <input type="text" class="form-control" placeholder="Nama">
                  <label class="input-group-text">Upload SK</label>
                  <input type="file" class="form-control">
                  <button class="btn btn-outline-success" type="button" onclick="addPenulis('penulis-ipb-list')">+ Tambah</button>
                </div>
              </div>
            </div>
            
            <div class="col-12">
              <label class="form-label">Penulis Luar IPB</label>
              <div id="penulis-luar-list">
                <div class="input-group mb-2">
                  <input type="text" class="form-control" placeholder="Nama">
                  <label class="input-group-text">Upload SK</label>
                  <input type="file" class="form-control">
                  <button class="btn btn-outline-success" type="button" onclick="addPenulis('penulis-luar-list')">+ Tambah</button>
                </div>
              </div>
            </div>
            
            <div class="col-12">
              <label class="form-label">Penulis Mahasiswa</label>
              <div id="penulis-mahasiswa-list">
                <div class="input-group mb-2">
                  <input type="text" class="form-control" placeholder="Nama">
                  <button class="btn btn-outline-success" type="button" onclick="addPenulis('penulis-mahasiswa-list')">+ Tambah</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer-custom">
        <button type="button" class="btn btn-secondary" onclick="closeModal('penelitianModal')">Batal</button>
        <button type="button" class="btn btn-success">Simpan</button>
      </div>
    </div>
  </div>

  <footer class="footer-custom">
    <span>© 2025 Forest Management — All Rights Reserved</span>
  </footer>