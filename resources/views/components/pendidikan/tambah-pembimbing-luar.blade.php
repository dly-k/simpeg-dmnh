{{-- Modal Tambah Data Pembimbing Luar IPB --}}
<div class="modal fade" id="modalPembimbingLuar" tabindex="-1" aria-labelledby="modalPembimbingLuarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalPembimbingLuarLabel">
          <i class="fas fa-plus-circle"></i>
          <span id="modalTitleTextPembimbingLuar">Tambah Kegiatan Pembimbing Luar IPB</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <form id="formPembimbingLuar" onsubmit="return false;">
          <input type="hidden" id="editPembimbingLuarId" name="id">

          <div class="mb-3">
            <label for="pbl_kegiatan_luar" class="form-label">Kegiatan</label>
            <select class="form-select" id="pbl_kegiatan_luar" name="kegiatan">
              <option selected disabled value="">-- Pilih Salah Satu --</option>
              <option value="Membimbing Disertasi">Membimbing Disertasi</option>
              <option value="Membimbing Tesis">Membimbing Tesis</option>
            </select>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="pbl_nama_luar" class="form-label">Nama</label>
              <select class="form-select" id="pbl_nama_luar" name="nama">
                <option selected disabled value="">-- Pilih Salah Satu --</option>
                <option value="Nama Dosen">Nama Dosen</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="pbl_status_luar" class="form-label">Status</label>
              <select class="form-select" id="pbl_status_luar" name="status">
                <option selected disabled value="">-- Pilih Salah Satu --</option>
                <option value="Pembimbing Utama">Pembimbing Utama</option>
                <option value="Pembimbing Pendamping">Pembimbing Pendamping</option>
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label for="pbl_tahun_semester_luar" class="form-label">Tahun Semester</label>
            <input type="text" class="form-control" id="pbl_tahun_semester_luar" name="tahun_semester" placeholder="Contoh: 2020/2021">
          </div>

          <div class="mb-3">
            <label for="pbl_nim_luar" class="form-label">NIM</label>
            <input type="text" class="form-control" id="pbl_nim_luar" name="nim" placeholder="Masukkan NIM Mahasiswa">
          </div>

          <div class="mb-3">
            <label for="pbl_nama_mahasiswa_luar" class="form-label">Nama Mahasiswa</label>
            <input type="text" class="form-control" id="pbl_nama_mahasiswa_luar" name="nama_mahasiswa" placeholder="Masukkan Nama Mahasiswa">
          </div>

          <div class="mb-3">
            <label for="pbl_universitas_luar" class="form-label">Universitas</label>
            <input type="text" class="form-control" id="pbl_universitas_luar" name="universitas" placeholder="Nama Universitas">
          </div>

          <div class="mb-3">
            <label for="pbl_program_studi_luar" class="form-label">Program Studi</label>
            <input type="text" class="form-control" id="pbl_program_studi_luar" name="program_studi" placeholder="Nama Program Studi">
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="pbl_is_insidental_luar" class="form-label">Insidental</label>
              <select class="form-select" id="pbl_is_insidental_luar" name="is_insidental">
                <option selected disabled value="">-- Pilih Salah Satu --</option>
                <option value="Ya">Ya</option>
                <option value="Tidak">Tidak</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="pbl_is_lebih_satu_semester_luar" class="form-label">Lebih Dari 1 Semester</label>
              <select class="form-select" id="pbl_is_lebih_satu_semester_luar" name="is_lebih_satu_semester">
                <option selected disabled value="">-- Pilih Salah Satu --</option>
                <option value="Ya">Ya</option>
                <option value="Tidak">Tidak</option>
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Upload File</label>
            <div class="file-drop-area">
              <i class="fas fa-cloud-upload-alt fa-3x mb-2 text-muted"></i>
              <span class="file-message">Drag & Drop File here</span>
              <span class="text-muted">Ukuran Maksimal 5 MB</span>
              <input class="file-input" type="file" name="file">
            </div>
          </div>

        </form>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btnBatalPembimbingLuar" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-success" id="btnSimpanPembimbingLuar">Simpan</button>
      </div>

    </div>
  </div>
</div>