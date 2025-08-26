{{-- Modal Tambah Data Penelitian --}}
<div class="modal fade" id="penelitianModal" tabindex="-1" aria-labelledby="penelitianModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="penelitianModalLabel">
          <i class="fas fa-plus-circle"></i> Tambah Data Penelitian
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <form id="penelitianForm">
          <div class="row g-3">

            <div class="col-12">
              <label class="form-label">Judul</label>
              <input type="text" class="form-control" name="judul" placeholder="Judul Penelitian" required>
            </div>

            <div class="col-12">
              <label class="form-label">Jenis Karya</label>
              <select class="form-select" name="jenisKarya" required>
                <option value="" selected>-- Pilih Salah Satu --</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Volume/Issue</label>
              <input type="text" class="form-control" name="volume" placeholder="Contoh: 12/1">
            </div>

            <div class="col-md-6">
              <label class="form-label">Jumlah Halaman</label>
              <input type="number" class="form-control" name="jumlahHalaman" placeholder="Contoh: 10">
            </div>

            <div class="col-md-6">
              <label class="form-label">Tanggal Terbit</label>
              <input type="date" class="form-control" name="tanggalTerbit">
            </div>

            <div class="col-md-6">
              <label class="form-label">Publik</label>
              <select class="form-select" name="publik" required>
                <option value="" selected>-- Pilih Salah Satu --</option>
                <option value="Ya">Ya</option>
                <option value="Tidak">Tidak</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">ISBN</label>
              <input type="text" class="form-control" name="isbn" placeholder="Masukkan ISBN">
            </div>

            <div class="col-md-6">
              <label class="form-label">ISSN</label>
              <input type="text" class="form-control" name="issn" placeholder="Masukkan ISSN">
            </div>

            <div class="col-md-6">
              <label class="form-label">DOI</label>
              <input type="text" class="form-control" name="doi" placeholder="Masukkan DOI">
            </div>

            <div class="col-md-6">
              <label class="form-label">URL</label>
              <input type="text" class="form-control" name="url" placeholder="https://example.com">
            </div>

            <div class="col-12">
              <label class="form-label">Dokumen Terkait</label>
              <div class="upload-area">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small></p>
                <input type="file" name="dokumen" hidden>
              </div>
            </div>

            <!-- Penulis -->
            <div class="col-12">
              <label class="form-label">Penulis IPB</label>
              <div id="penulis-ipb-list"></div>
            </div>

            <div class="col-12">
              <label class="form-label">Penulis Luar IPB</label>
              <div id="penulis-luar-list"></div>
            </div>

            <div class="col-12">
              <label class="form-label">Penulis Mahasiswa</label>
              <div id="penulis-mahasiswa-list"></div>
            </div>

          </div>
        </form>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-success">Simpan</button>
      </div>

    </div>
  </div>
</div>