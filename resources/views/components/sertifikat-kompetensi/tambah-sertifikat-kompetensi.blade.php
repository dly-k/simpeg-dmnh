<div class="modal fade" id="sertifikatKompetensiModal" tabindex="-1" aria-labelledby="sertifikatKompetensiTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form action="#" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="sertifikatKompetensiTitle">
            <i class="fas fa-plus-circle me-2"></i> Tambah Sertifikat Kompetensi
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">

            <!-- Nama (Dropdown) -->
            <div class="col-12">
              <label for="Nama" class="form-label">Nama *</label>
              <select name="Nama" id="Nama" class="form-select">
                <option value="">-- Pilih Nama Pegawai --</option>
                <option value="pegawai1">Pegawai 1</option>
                <option value="pegawai2">Pegawai 2</option>
                <option value="pegawai3">Pegawai 3</option>
              </select>
            </div>

            <!-- Kegiatan (Dropdown) -->
            <div class="col-12">
              <label for="Kegiatan" class="form-label">Kegiatan *</label>
              <select name="Kegiatan" id="Kegiatan" class="form-select">
                <option value="">-- Pilih Kegiatan --</option>
                <option value="nasional">Memperoleh sertifikat profesi: Bereputasi tingkat Nasional</option>
                <option value="internasional">Memperoleh sertifikat profesi: Bereputasi tingkat Internasional</option>
                <option value="kompetensi">Memperoleh sertifikat Kompetensi</option>
              </select>
            </div>

            <!-- Judul Kegiatan -->
            <div class="col-12">
              <label for="Judul_Kegiatan" class="form-label">Judul Kegiatan *</label>
              <input type="text" name="Judul_Kegiatan" id="Judul_Kegiatan" class="form-control" placeholder="Masukkan judul kegiatan">
            </div>

            <!-- Nomor Registrasi Pendidik -->
            <div class="col-md-6">
              <label for="Nomor_Registrasi_Pendidik" class="form-label">Nomor Registrasi Pendidik</label>
              <input type="text" name="Nomor_Registrasi_Pendidik" id="Nomor_Registrasi_Pendidik" class="form-control" placeholder="Ketik hanya angka">
            </div>

            <!-- Nomor SK Sertifikasi -->
            <div class="col-md-6">
              <label for="Nomor_SK_Sertifikasi" class="form-label">Nomor SK Sertifikasi *</label>
              <input type="text" name="Nomor_SK_Sertifikasi" id="Nomor_SK_Sertifikasi" class="form-control" placeholder="Contoh: 19900-999-0001">
            </div>

            <!-- Tahun Sertifikasi -->
            <div class="col-md-6">
            <label for="Tahun_Sertifikasi" class="form-label">Tahun Sertifikasi *</label>
            <input type="number" name="Tahun_Sertifikasi" id="Tahun_Sertifikasi" class="form-control" 
                    placeholder="Contoh: 2025" min="1900" max="2099" step="1">
            </div>

            <!-- TMT Sertifikasi -->
            <div class="col-md-6">
              <label for="TMT_Sertifikasi" class="form-label">TMT Sertifikasi *</label>
              <input type="date" name="TMT_Sertifikasi" id="TMT_Sertifikasi" class="form-control">
            </div>

            <!-- TST Sertifikasi -->
            <div class="col-md-6">
              <label for="TST_Sertifikasi" class="form-label">TST Sertifikasi</label>
              <input type="date" name="TST_Sertifikasi" id="TST_Sertifikasi" class="form-control">
            </div>

            <!-- Bidang Studi -->
            <div class="col-md-6">
              <label for="Bidang_Studi" class="form-label">Bidang Studi *</label>
              <input type="text" name="Bidang_Studi" id="Bidang_Studi" class="form-control" placeholder="Masukkan bidang studi">
            </div>

            <!-- Lembaga Sertifikasi (Dropdown + Input jika Lainnya) -->
            <div class="col-12">
              <label for="Lembaga_Sertifikasi" class="form-label">Lembaga Sertifikasi *</label>
              <select name="Lembaga_Sertifikasi" id="Lembaga_Sertifikasi" class="form-select">
                <option value="">-- Pilih Lembaga Sertifikasi --</option>
                <option value="bpsdm">Badan Pengembangan SDM</option>
                <option value="bsnp">Badan Standar Nasional Pendidikan</option>
                <option value="bnspt">Badan Nasional Sertifikasi Profesi</option>
                <option value="kemdikbud">Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi</option>
                <option value="lainnya">Lainnya</option>
              </select>
              <!-- Input tambahan kalau pilih "Lainnya" -->
              <input type="text" name="Lembaga_Sertifikasi_Lainnya" id="Lembaga_Sertifikasi_Lainnya" class="form-control mt-2" placeholder="Masukkan lembaga sertifikasi lainnya" style="display:none;">
            </div>

            <!-- Dokumen -->
            <div class="col-12">
              <label class="form-label">Unggah Dokumen</label>
              <div class="upload-area">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small></p>
                <input type="file" name="dokumen" hidden accept=".pdf">
              </div>
              <span id="file-size-feedback" class="text-danger mt-1 d-block" style="display: none;"></span>
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>