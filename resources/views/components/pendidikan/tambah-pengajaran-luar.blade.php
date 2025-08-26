{{-- Modal Tambah Data Pengajaran Luar --}}
<div class="modal fade" id="modalPengajaranLuar" tabindex="-1" aria-labelledby="modalPengajaranLuarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalPengajaranLuarLabel">
          <i class="fas fa-plus-circle"></i>
          <span id="modalTitleTextPengajaranLuar">Tambah Kegiatan Pengajaran Luar IPB</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <form id="formPengajaranLuar" onsubmit="return false;">
          <input type="hidden" id="editPengajaranLuarId" name="id">

          <div class="mb-3">
            <label for="pl_nama" class="form-label">Nama</label>
            <select class="form-select" id="pl_nama" name="nama">
              <option selected disabled value="">-- Pilih Salah Satu --</option>
              <option value="Alex Kurniawan">Alex Kurniawan</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="pl_tahun_semester" class="form-label">Tahun Semester</label>
            <input type="text" class="form-control" id="pl_tahun_semester" name="tahun_semester" placeholder="Contoh: 2020/2021">
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="pl_kode_mk" class="form-label">Kode Mata Kuliah</label>
              <input type="text" class="form-control" id="pl_kode_mk" name="kode_mk">
            </div>
            <div class="col-md-6">
              <label for="pl_nama_mk" class="form-label">Nama Mata Kuliah</label>
              <input type="text" class="form-control" id="pl_nama_mk" name="nama_mk">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">SKS</label>
            <div class="row">
              <div class="col-md-6">
                <input type="number" class="form-control" id="pl_sks_kuliah" name="sks_kuliah" placeholder="Perkuliahan">
              </div>
              <div class="col-md-6">
                <input type="number" class="form-control" id="pl_sks_praktikum" name="sks_praktikum" placeholder="Praktikum">
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="pl_universitas" class="form-label">Universitas</label>
            <input type="text" class="form-control" id="pl_universitas" name="universitas" placeholder="Masukkan Universitas Kegiatan Anda">
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="pl_strata" class="form-label">Strata</label>
              <select class="form-select" id="pl_strata" name="strata">
                <option selected disabled value="">-- Pilih Salah Satu --</option>
                <option value="S1">S1</option>
                <option value="S2">S2</option>
                <option value="S3">S3</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="pl_program_studi" class="form-label">Program Studi</label>
              <input type="text" class="form-control" id="pl_program_studi" name="program_studi">
            </div>
          </div>

          <div class="mb-3">
            <label for="pl_jenis" class="form-label">Jenis</label>
            <select class="form-select" id="pl_jenis" name="jenis">
              <option selected disabled value="">-- Pilih Salah Satu --</option>
              <option value="K">Kuliah</option>
              <option value="P">Praktikum</option>
            </select>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="pl_kelas_paralel" class="form-label">Kelas Paralel</label>
              <input type="text" class="form-control" id="pl_kelas_paralel" name="kelas_paralel">
            </div>
            <div class="col-md-6">
              <label for="pl_jumlah_pertemuan" class="form-label">Jumlah Pertemuan</label>
              <input type="number" class="form-control" id="pl_jumlah_pertemuan" name="jumlah_pertemuan">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="pl_is_insidental" class="form-label">Insidental</label>
              <select class="form-select" id="pl_is_insidental" name="is_insidental">
                <option selected disabled value="">-- Pilih Salah Satu --</option>
                <option value="Ya">Ya</option>
                <option value="Tidak">Tidak</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="pl_is_lebih_satu_semester" class="form-label">Lebih Dari 1 Semester</label>
              <select class="form-select" id="pl_is_lebih_satu_semester" name="is_lebih_satu_semester">
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
        <button type="button" class="btn btn-secondary" id="btnBatalPengajaranLuar" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-success" id="btnSimpanPengajaranLuar">Simpan</button>
      </div>

    </div>
  </div>
</div>