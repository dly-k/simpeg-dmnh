{{-- Modal Tambah Data Pembimbing Luar IPB --}}
<div class="modal fade" id="modalPembimbingLuar" tabindex="-1" aria-labelledby="modalPembimbingLuarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPembimbingLuarLabel">
          <i class="fas fa-plus-circle"></i>
          <span id="modalTitleTextPembimbingLuar">Tambah Kegiatan Pembimbing Luar IPB</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="formPembimbingLuar" onsubmit="return false;">
          <input type="hidden" id="editPembimbingLuarId" name="id">
          
          <!-- Pilihan Kegiatan -->
          <div class="mb-3">
            <label for="pbl_kegiatan_luar" class="form-label">Kegiatan</label>
            <select class="form-select" id="pbl_kegiatan_luar" name="kegiatan">
              <option selected disabled value="">-- Pilih --</option>
              <option value="Membimbing disertasi – Pembimbing Utama per orang (setiap mahasiswa)">Disertasi - Utama</option>
              <option value="Membimbing tesis – Pembimbing Utama per orang (setiap mahasiswa)">Tesis - Utama</option>
              <option value="Membimbing skripsi – Pembimbing Utama per orang (setiap mahasiswa)">Skripsi - Utama</option>
              <option value="Membimbing laporan akhir studi – Pembimbing Utama per orang (setiap mahasiswa)">Laporan Akhir - Utama</option>
              <option value="Membimbing disertasi – Pembimbing Pendamping/Pembantu per orang (setiap mahasiswa)">Disertasi - Pendamping</option>
              <option value="Membimbing tesis – Pembimbing Pendamping/Pembantu per orang (setiap mahasiswa)">Tesis - Pendamping</option>
              <option value="Membimbing skripsi – Pembimbing Pendamping/Pembantu per orang (setiap mahasiswa)">Skripsi - Pendamping</option>
              <option value="Membimbing laporan akhir studi – Pembimbing Pendamping/Pembantu per orang (setiap mahasiswa)">Laporan Akhir - Pendamping</option>
            </select>
          </div>

          <!-- Nama Dosen -->
          <div class="mb-3">
            <label for="pbl_nama_luar" class="form-label">Nama Dosen</label>
            <select class="form-select" id="pbl_nama_luar" name="pegawai_id">
              <option selected disabled value="">-- Pilih Salah Satu --</option>
              @foreach($dosenAktif as $dosen)
                <option value="{{ $dosen->id }}">{{ $dosen->nama_lengkap }}</option>
              @endforeach
            </select>
          </div>

          <!-- Tahun Semester -->
          <div class="mb-3">
            <label for="pbl_tahun_semester_luar" class="form-label">Tahun Semester</label>
            <select class="form-select form-select-sm" id="pbl_tahun_semester" name="tahun_semester" required>
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

          <!-- NIM dan Nama Mahasiswa sejajar -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="pbl_nim_luar" class="form-label">NIM</label>
              <input type="text" class="form-control" id="pbl_nim_luar" name="nim" placeholder="Masukkan NIM Mahasiswa">
            </div>
            <div class="col-md-6">
              <label for="pbl_nama_mahasiswa_luar" class="form-label">Nama Mahasiswa</label>
              <input type="text" class="form-control" id="pbl_nama_mahasiswa_luar" name="nama_mahasiswa" placeholder="Masukkan Nama Mahasiswa">
            </div>
          </div>

          <!-- Universitas dan Program Studi sejajar -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="pbl_universitas_luar" class="form-label">Universitas</label>
              <input type="text" class="form-control" id="pbl_universitas_luar" name="universitas" placeholder="Nama Universitas">
            </div>
            <div class="col-md-6">
              <label for="pbl_program_studi_luar" class="form-label">Program Studi</label>
              <input type="text" class="form-control" id="pbl_program_studi_luar" name="program_studi" placeholder="Nama Program Studi">
            </div>
          </div>

          <!-- Insidental dan Lebih dari 1 Semester sejajar -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="pbl_is_insidental_luar" class="form-label">Insidental</label>
              <select class="form-select" id="pbl_is_insidental_luar" name="is_insidental">
                <option selected disabled value="">-- Pilih --</option>
                <option value="Ya">Ya</option>
                <option value="Tidak">Tidak</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="pbl_is_lebih_satu_semester_luar" class="form-label">Lebih Dari 1 Semester</label>
              <select class="form-select" id="pbl_is_lebih_satu_semester_luar" name="is_lebih_satu_semester">
                <option selected disabled value="">-- Pilih --</option>
                <option value="Ya">Ya</option>
                <option value="Tidak">Tidak</option>
              </select>
            </div>
          </div>

          <!-- Upload Dokumen -->
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
        <button type="button" class="btn btn-success" id="btnSimpanPembimbingLuar">Simpan</button>
      </div>
    </div>
  </div>
</div>