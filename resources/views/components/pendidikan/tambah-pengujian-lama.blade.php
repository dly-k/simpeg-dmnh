{{-- Modal Tambah Data Pengujian Lama --}}
<div class="modal fade" id="modalPengujianLama" tabindex="-1" aria-labelledby="modalPengujianLamaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
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
              <option selected disabled value="">Bertugas sebagai penguji pada Ujian Akhir/Profesi (Setiap Mahasiswa): Ketua Penguji</option>
              <option value="Ketua Penguji">Ketua Penguji</option>
              <option value="Anggota Penguji">Anggota Penguji</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="pjl_nama" class="form-label">Nama Dosen</label>
            <select class="form-select" id="pjl_nama" name="pegawai_id">
              <option selected disabled value="">-- Pilih Salah Satu --</option>
               @foreach($dosenAktif as $dosen)
                <option value="{{ $dosen->id }}">{{ $dosen->nama_lengkap }}</option>
              @endforeach
            </select>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="pjl_strata" class="form-label">Strata</label>
              <select class="form-select" id="pjl_strata" name="strata"><option selected disabled value="">-- Pilih --</option><option value="S1">S1</option><option value="S2">S2</option><option value="S3">S3</option></select>
            </div>
            <div class="col-md-6">
              <label for="pjl_tahun_semester" class="form-label">Tahun Semester</label>
              <input type="text" class="form-control" id="pjl_tahun_semester" name="tahun_semester" placeholder="Contoh: 2020/2021">
            </div>
          </div>
          <div class="mb-3">
            <label for="pjl_nim" class="form-label">NIM</label>
            <input type="text" class="form-control" id="pjl_nim" name="nim" placeholder="Masukkan NIM Mahasiswa">
          </div>
          <div class="mb-3">
            <label for="pjl_nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
            <input type="text" class="form-control" id="pjl_nama_mahasiswa" name="nama_mahasiswa" placeholder="Masukkan Nama Mahasiswa">
          </div>
          <div class="mb-3">
            <label for="pjl_departemen" class="form-label">Departemen</label>
            <select class="form-select" id="pjl_departemen" name="departemen"><option selected disabled value="">-- Pilih --</option><option value="Manajemen Hutan">Manajemen Hutan</option><option value="Teknologi Hasil Hutan">Teknologi Hasil Hutan</option></select>
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
        <button type="button" class="btn btn-success" id="btnSimpanPengujianLama">Simpan</button>
      </div>
    </div>
  </div>
</div>