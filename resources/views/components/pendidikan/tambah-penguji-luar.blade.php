{{-- Modal Tambah Data Penguji Luar IPB --}}
<div class="modal fade" id="modalPengujiLuar" tabindex="-1" aria-labelledby="modalPengujiLuarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
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

          {{-- Kegiatan --}}
          <div class="mb-3">
            <label for="pjl_kegiatan" class="form-label">Kegiatan</label>
            <select class="form-select" id="pjl_kegiatan" name="kegiatan">
              <option selected disabled value="">-- Pilih --</option>
              <option value="Bertugas sebagai penguji pada Ujian Akhir/Profesi (setiap mahasiswa)">Ujian Akhir/Profesi</option>
              <option value="Bertugas sebagai penguji pada Ujian Disertasi (setiap mahasiswa)">Ujian Disertasi</option>
            </select>
          </div>

          {{-- Nama Dosen (Select2) --}}
          <div class="mb-3">
            <label for="pjl_nama" class="form-label">Nama Dosen</label>
            <select class="form-select select2 form-select-sm" id="pjl_nama" name="pegawai_id" style="width: 100%;">
              <option selected disabled value="">-- Pilih Salah Satu --</option>
              @foreach($dosenAktif as $dosen)
                <option value="{{ $dosen->id }}">{{ $dosen->nama_lengkap }}</option>
              @endforeach
            </select>
          </div>

          {{-- Tahun Semester (Select2) --}}
          <div class="mb-3">
            <label for="tahun_semester" class="form-label">Tahun Semester</label>
            <select class="form-select select2 form-select-sm" id="tahun_semester" name="tahun_semester" style="width: 100%;" required>
              @php
                $tahunSekarang = date('Y');
                for ($i = $tahunSekarang; $i >= 2015; $i--) {
                    $next = $i + 1;
                    echo "<option value='{$i}/{$next} Ganjil'>{$i}/{$next} Ganjil</option>";
                    echo "<option value='{$i}/{$next} Genap'>{$i}/{$next} Genap</option>";
                }
              @endphp
            </select>
          </div>

          {{-- NIM dan Nama Mahasiswa sejajar --}}
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="pjl_nim_luar" class="form-label">NIM</label>
              <input type="text" class="form-control" id="pjl_nim_luar" name="nim" placeholder="Masukkan NIM Mahasiswa">
            </div>
            <div class="col-md-6">
              <label for="pjl_nama_mahasiswa_luar" class="form-label">Nama Mahasiswa</label>
              <input type="text" class="form-control" id="pjl_nama_mahasiswa_luar" name="nama_mahasiswa" placeholder="Masukkan Nama Mahasiswa">
            </div>
          </div>

          {{-- Universitas & Strata --}}
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="pjl_universitas" class="form-label">Universitas</label>
              <input type="text" class="form-control" id="pjl_universitas" name="universitas" placeholder="Nama Universitas">
            </div>
            <div class="col-md-6">
              <label for="pjl_strata_luar" class="form-label">Strata</label>
              <select class="form-select" id="pjl_strata_luar" name="strata">
                <option selected disabled value="">-- Pilih --</option>
                <option value="D1">Diploma I</option>
                <option value="D2">Diploma II</option>
                <option value="D3">Diploma III</option>
                <option value="D4">Sarjana Terapan</option>
                <option value="S1">Sarjana</option>
                <option value="Profesi">Program Profesi</option>
                <option value="S2">Magister</option>
                <option value="S3">Doktor</option>
              </select>
            </div>
          </div>

          {{-- Program Studi --}}
          <div class="mb-3">
            <label for="pjl_program_studi" class="form-label">Program Studi</label>
            <input type="text" class="form-control" id="pjl_program_studi" name="program_studi" placeholder="Nama Program Studi">
          </div>

          {{-- Insidental & Lebih Dari 1 Semester --}}
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="pjl_is_insidental" class="form-label">Insidental</label>
              <select class="form-select" id="pjl_is_insidental" name="is_insidental">
                <option selected disabled value="">-- Pilih --</option>
                <option value="Ya">Ya</option>
                <option value="Tidak">Tidak</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="pjl_is_lebih_satu_semester" class="form-label">Lebih Dari 1 Semester</label>
              <select class="form-select" id="pjl_is_lebih_satu_semester" name="is_lebih_satu_semester">
                <option selected disabled value="">-- Pilih --</option>
                <option value="Ya">Ya</option>
                <option value="Tidak">Tidak</option>
              </select>
            </div>
          </div>

          {{-- Upload File --}}
          <div class="mb-3">
            <label class="form-label">Unggah Dokumen</label>
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-success" id="btnSimpanPengujiLuar">Simpan</button>
      </div>
    </div>
  </div>
</div>