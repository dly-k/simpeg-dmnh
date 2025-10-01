<div class="modal fade" id="editSertifikatKompetensiModal" tabindex="-1" aria-labelledby="editSertifikatKompetensiTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form action="#" method="POST" enctype="multipart/form-data">
        <div class="modal-header bg-warning text-dark">
          <h5 class="modal-title" id="editSertifikatKompetensiTitle">
            <i class="fas fa-edit me-2"></i> Edit Sertifikat Kompetensi
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">

            <!-- Nama -->
            <div class="col-12">
              <label for="Edit_Nama" class="form-label">Nama *</label>
              <select name="Nama" id="Edit_Nama" class="form-select">
                <option value="">-- Pilih Nama Pegawai --</option>
                <option value="pegawai1" selected>Pegawai 1</option>
                <option value="pegawai2">Pegawai 2</option>
                <option value="pegawai3">Pegawai 3</option>
              </select>
            </div>

            <!-- Kegiatan -->
            <div class="col-12">
              <label for="Edit_Kegiatan" class="form-label">Kegiatan *</label>
              <select name="Kegiatan" id="Edit_Kegiatan" class="form-select">
                <option value="">-- Pilih Kegiatan --</option>
                <option value="nasional">Memperoleh sertifikat profesi: Bereputasi tingkat Nasional</option>
                <option value="internasional" selected>Memperoleh sertifikat profesi: Bereputasi tingkat Internasional</option>
                <option value="kompetensi">Memperoleh sertifikat Kompetensi</option>
              </select>
            </div>

            <!-- Judul Kegiatan -->
            <div class="col-12">
              <label for="Edit_Judul_Kegiatan" class="form-label">Judul Kegiatan *</label>
              <input type="text" name="Judul_Kegiatan" id="Edit_Judul_Kegiatan" class="form-control" 
                     value="Workshop Data Science 2024">
            </div>

            <!-- Nomor Registrasi Pendidik -->
            <div class="col-md-6">
              <label for="Edit_Nomor_Registrasi_Pendidik" class="form-label">Nomor Registrasi Pendidik</label>
              <input type="text" name="Nomor_Registrasi_Pendidik" id="Edit_Nomor_Registrasi_Pendidik" 
                     class="form-control" value="123456">
            </div>

            <!-- Nomor SK Sertifikasi -->
            <div class="col-md-6">
              <label for="Edit_Nomor_SK_Sertifikasi" class="form-label">Nomor SK Sertifikasi *</label>
              <input type="text" name="Nomor_SK_Sertifikasi" id="Edit_Nomor_SK_Sertifikasi" 
                     class="form-control" value="19900-999-0001">
            </div>

            <!-- Tahun Sertifikasi -->
            <div class="col-md-6">
              <label for="Edit_Tahun_Sertifikasi" class="form-label">Tahun Sertifikasi *</label>
              <input type="number" name="Tahun_Sertifikasi" id="Edit_Tahun_Sertifikasi" 
                     class="form-control" value="2024" min="1900" max="2099" step="1">
            </div>

            <!-- TMT Sertifikasi -->
            <div class="col-md-6">
              <label for="Edit_TMT_Sertifikasi" class="form-label">TMT Sertifikasi *</label>
              <input type="date" name="TMT_Sertifikasi" id="Edit_TMT_Sertifikasi" 
                     class="form-control" value="2024-01-15">
            </div>

            <!-- TST Sertifikasi -->
            <div class="col-md-6">
              <label for="Edit_TST_Sertifikasi" class="form-label">TST Sertifikasi</label>
              <input type="date" name="TST_Sertifikasi" id="Edit_TST_Sertifikasi" 
                     class="form-control" value="2026-01-15">
            </div>

            <!-- Bidang Studi -->
            <div class="col-md-6">
              <label for="Edit_Bidang_Studi" class="form-label">Bidang Studi *</label>
              <input type="text" name="Bidang_Studi" id="Edit_Bidang_Studi" 
                     class="form-control" value="Teknik Informatika">
            </div>

            <!-- Lembaga Sertifikasi -->
            <div class="col-12">
              <label for="Edit_Lembaga_Sertifikasi" class="form-label">Lembaga Sertifikasi *</label>
              <select name="Lembaga_Sertifikasi" id="Edit_Lembaga_Sertifikasi" 
                      class="form-select" onchange="toggleLainnyaEdit(this)">
                <option value="">-- Pilih Lembaga Sertifikasi --</option>
                <option value="bpsdm">Badan Pengembangan SDM</option>
                <option value="bsnp">Badan Standar Nasional Pendidikan</option>
                <option value="bnspt" selected>Badan Nasional Sertifikasi Profesi</option>
                <option value="kemdikbud">Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi</option>
                <option value="lainnya">Lainnya</option>
              </select>
              <input type="text" name="Lembaga_Sertifikasi_Lainnya" 
                     id="Edit_Lembaga_Sertifikasi_Lainnya" 
                     class="form-control mt-2" 
                     placeholder="Masukkan lembaga sertifikasi lainnya" 
                     style="display:none;">
            </div>

            <!-- Dokumen -->
            <div class="col-12">
              <label class="form-label">Unggah Dokumen (kosongkan jika tidak diubah)</label>
              <div class="upload-area">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small></p>
                <input type="file" name="dokumen" hidden accept=".pdf">
              </div>
              <small class="text-muted">Dokumen saat ini: <a href="#">Lihat Dokumen.pdf</a></small>
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>