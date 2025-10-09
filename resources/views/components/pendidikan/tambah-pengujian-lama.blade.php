{{-- Modal Tambah Data Pengujian Lama --}}
<div class="modal fade" id="modalPengujianLama" tabindex="-1" aria-labelledby="modalPengujianLamaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPengujianLamaLabel">
          <i class="fas fa-plus-circle"></i>
          <span id="modalTitleTextPengujianLama">Tambah Kegiatan Pengujian Lama</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formPengujianLama" onsubmit="return false;">
          <input type="hidden" id="editPengujianLamaId" name="id">
          
          <div class="mb-3">
            <label for="pjl_kegiatan" class="form-label">Kegiatan</label>
            <select class="form-select" id="pjl_kegiatan" name="kegiatan">
              <option selected disabled value="">-- Pilih Salah Satu --</option>
              <option value="Ketua Penguji">Bertugas sebagai penguji pada Ujian Akhir/Profesi (setiap mahasiswa): Ketua penguji</option>
              <option value="Anggota Penguji">Bertugas sebagai penguji pada Ujian Akhir/Profesi (setiap mahasiswa): Anggota penguji</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="pjl_nama" class="form-label">Nama Dosen</label>
            <select class="form-select form-select-sm" id="pjl_nama" name="pegawai_id">
              <option selected disabled value="">-- Pilih Salah Satu --</option>
               @foreach($dosenAktif as $dosen)
                <option value="{{ $dosen->id }}">{{ $dosen->nama_lengkap }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
          <label for="tahun_semester" class="form-label">Tahun Semester</label>
            <select class="form-select form-select-sm" id="pjl_tahun_semester" name="tahun_semester" required>
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
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="pjl_nim" class="form-label">NIM</label>
              <input type="text" class="form-control" id="pjl_nim" name="nim" placeholder="Masukkan NIM Mahasiswa">
            </div>
            <div class="col-md-6 mb-3">
              <label for="pjl_nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
              <input type="text" class="form-control" id="pjl_nama_mahasiswa" name="nama_mahasiswa" placeholder="Masukkan Nama Mahasiswa">
            </div>
          </div>
          <div class="mb-3">
            <label for="pjl_departemen" class="form-label">Departemen</label>
            <select class="form-select form-select-sm" id="pjl_departemen" name="departemen" required>
              <option selected disabled value="">-- Pilih Salah Satu--</option>
              @foreach($programStudi as $prodi)
                <option value="{{ $prodi }}">{{ $prodi }}</option>
              @endforeach
            </select>
          </div>
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
        <button type="button" class="btn btn-success" id="btnSimpanPengujianLama">Simpan</button>
      </div>
    </div>
  </div>
</div>