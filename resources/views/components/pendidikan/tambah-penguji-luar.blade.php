  {{-- Penguji Luar IPB --}}
  <div class="modal fade" id="modalPengujiLuar" tabindex="-1" aria-labelledby="modalPengujiLuarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalPengujiLuarLabel">
            <i class="fas fa-plus-circle"></i>
            <span id="modalTitleTextPengujiLuar">Tambah Kegiatan Penguji Luar IPB</span>
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formPengujiLuar" onsubmit="return false;">
            <input type="hidden" id="editPengujiLuarId" name="id">

            <div class="mb-3">
              <label for="pjl_kegiatan" class="form-label">Kegiatan</label>
              <select class="form-select" id="pjl_kegiatan" name="kegiatan">
                  <option selected disabled value="">-- Pilih Salah Satu --</option>
                  <option value="Ujian Akhir">Ujian Akhir</option>
                  <option value="Ujian Disertasi">Ujian Disertasi</option>
              </select>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                  <label for="pjl_nama" class="form-label">Nama</label>
                  <select class="form-select" id="pjl_nama" name="nama">
                    <option selected disabled value="">-- Pilih Salah Satu --</option>
                    <option value="Nama Dosen">Nama Dosen</option>
                  </select>
              </div>
              <div class="col-md-6">
                  <label for="pjl_status" class="form-label">Status</label>
                  <select class="form-select" id="pjl_status" name="status">
                    <option selected disabled value="">-- Pilih Salah Satu --</option>
                    <option value="Ketua Penguji">Ketua Penguji</option>
                    <option value="Anggota Penguji">Anggota Penguji</option>
                  </select>
              </div>
            </div>

            <div class="mb-3">
              <label for="pjl_tahun_semester_luar" class="form-label">Tahun Semester</label>
              <input type="text" class="form-control" id="pjl_tahun_semester_luar" name="tahun_semester" placeholder="Contoh: 2020/2021">
            </div>
            
            <div class="mb-3">
              <label for="pjl_nim_luar" class="form-label">NIM</label>
              <input type="text" class="form-control" id="pjl_nim_luar" name="nim" placeholder="Masukkan NIM Mahasiswa">
            </div>

            <div class="mb-3">
              <label for="pjl_nama_mahasiswa_luar" class="form-label">Nama Mahasiswa</label>
              <input type="text" class="form-control" id="pjl_nama_mahasiswa_luar" name="nama_mahasiswa" placeholder="Masukkan Nama Mahasiswa">
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="pjl_universitas" class="form-label">Universitas</label>
                <input type="text" class="form-control" id="pjl_universitas" name="universitas" placeholder="Nama Universitas">
              </div>
              <div class="col-md-6">
                <label for="pjl_strata_luar" class="form-label">Strata</label>
                <select class="form-select" id="pjl_strata_luar" name="strata">
                  <option selected disabled value="">-- Pilih Salah Satu --</option>
                  <option value="S1">S1</option>
                  <option value="S2">S2</option>
                  <option value="S3">S3</option>
                </select>
              </div>
            </div>

            <div class="mb-3">
              <label for="pjl_program_studi" class="form-label">Program Studi</label>
              <input type="text" class="form-control" id="pjl_program_studi" name="program_studi" placeholder="Nama Program Studi">
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="pjl_is_insidental" class="form-label">Insidental</label>
                <select class="form-select" id="pjl_is_insidental" name="is_insidental">
                  <option selected disabled value="">-- Pilih Salah Satu --</option>
                  <option value="Ya">Ya</option>
                  <option value="Tidak">Tidak</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="pjl_is_lebih_satu_semester" class="form-label">Lebih Dari 1 Semester</label>
                <select class="form-select" id="pjl_is_lebih_satu_semester" name="is_lebih_satu_semester">
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
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" id="btnBatalPengujiLuar" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-success" id="btnSimpanPengujiLuar">Simpan</button>
        </div>
      </div>
    </div>
  </div>