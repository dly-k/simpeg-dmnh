{{-- Modal Tambah Data Pembimbing Lama --}}
<div class="modal fade" id="modalPembimbingLama" tabindex="-1" aria-labelledby="modalPembimbingLamaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPembimbingLamaLabel">
          <i class="fas fa-plus-circle"></i>
          <span id="modalTitleTextPembimbingLama">Tambah Kegiatan Pembimbing Lama</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formPembimbingLama" onsubmit="return false;">
          <input type="hidden" id="editPembimbingLamaId" name="id">

        <div class="mb-3">
          <label for="pbl_kegiatan" class="form-label">Kegiatan</label>
          <select class="form-select" id="pbl_kegiatan" name="kegiatan" required>
            <option selected disabled value="">-- Pilih Salah Satu --</option>
            <option value="Membimbing seminar mahasiswa (setiap semester)">
              Membimbing seminar mahasiswa (setiap semester)
            </option>
            <option value="Membimbing KKN, Praktik Kerja Nyata, Praktik Kerja Lapangan (setiap semester)">
              Membimbing KKN, Praktik Kerja Nyata, Praktik Kerja Lapangan (setiap semester)
            </option>
            <option value="Membimbing disertasi – Pembimbing Utama per orang (setiap mahasiswa)">
              Membimbing disertasi – Pembimbing Utama per orang (setiap mahasiswa)
            </option>
            <option value="Membimbing tesis – Pembimbing Utama per orang (setiap mahasiswa)">
              Membimbing tesis – Pembimbing Utama per orang (setiap mahasiswa)
            </option>
            <option value="Membimbing skripsi – Pembimbing Utama per orang (setiap mahasiswa)">
              Membimbing skripsi – Pembimbing Utama per orang (setiap mahasiswa)
            </option>
            <option value="Membimbing laporan akhir studi – Pembimbing Utama per orang (setiap mahasiswa)">
              Membimbing laporan akhir studi – Pembimbing Utama per orang (setiap mahasiswa)
            </option>
            <option value="Membimbing disertasi – Pembimbing Pendamping/Pembantu per orang (setiap mahasiswa)">
              Membimbing disertasi – Pembimbing Pendamping/Pembantu per orang (setiap mahasiswa)
            </option>
            <option value="Membimbing tesis – Pembimbing Pendamping/Pembantu per orang (setiap mahasiswa)">
              Membimbing tesis – Pembimbing Pendamping/Pembantu per orang (setiap mahasiswa)
            </option>
            <option value="Membimbing skripsi – Pembimbing Pendamping/Pembantu per orang (setiap mahasiswa)">
              Membimbing skripsi – Pembimbing Pendamping/Pembantu per orang (setiap mahasiswa)
            </option>
            <option value="Membimbing laporan akhir studi – Pembimbing Pendamping/Pembantu per orang (setiap mahasiswa)">
              Membimbing laporan akhir studi – Pembimbing Pendamping/Pembantu per orang (setiap mahasiswa)
            </option>
            <option value="Membina kegiatan mahasiswa di bidang akademik dan kemahasiswaan, termasuk membimbing mahasiswa menghasilkan produk saintifik (setiap semester)">
                Membina kegiatan mahasiswa di bidang akademik dan kemahasiswaan (setiap semester)
            </option>
          </select>
        </div>

          <div class="mb-3">
            <label for="pbl_nama" class="form-label">Nama Dosen</label>
            <select class="form-select form-select-sm" id="pbl_nama" name="pegawai_id">
              <option selected disabled value="">-- Pilih Salah Satu --</option>
              @foreach($dosenAktif as $dosen)
                <option value="{{ $dosen->id }}">{{ $dosen->nama_lengkap }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="pbla_tahun_semester" class="form-label">Tahun Semester</label>
            <select class="form-select form-select-sm" id="pbla_tahun_semester" name="tahun_semester" required>
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

          <!-- NIM & Nama sejajar -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="pbl_nim" class="form-label">NIM</label>
              <input type="text" class="form-control" id="pbl_nim" name="nim" placeholder="Masukkan NIM Mahasiswa">
            </div>
            <div class="col-md-6 mb-3">
              <label for="pbl_nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
              <input type="text" class="form-control" id="pbl_nama_mahasiswa" name="nama_mahasiswa" placeholder="Masukkan Nama Mahasiswa">
            </div>
          </div>

          <!-- Departemen & Lokasi sejajar -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="pbl_departemen" class="form-label">Departemen</label>
              <select class="form-select form-select-sm" id="pbl_departemen" name="departemen" required>
                  <option selected disabled value="">-- Pilih Salah Satu--</option>
                  @foreach($programStudi as $prodi)
                    <option value="{{ $prodi }}">{{ $prodi }}</option>
                  @endforeach
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label for="pbl_lokasi" class="form-label">Lokasi (PL/KKN)</label>
              <input type="text" class="form-control" id="pbl_lokasi" name="lokasi" placeholder="Masukkan Lokasi PL/KKN">
            </div>
          </div>

          <div class="mb-3">
            <label for="pbl_nama_dokumen" class="form-label">Nama Dokumen</label>
            <input type="text" class="form-control" id="pbl_nama_dokumen" name="nama_dokumen" placeholder="Contoh: Surat Tugas">
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-success" id="btnSimpanPembimbingLama">Simpan</button>
      </div>
    </div>
  </div>
</div>