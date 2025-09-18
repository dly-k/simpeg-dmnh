{{-- Modal Tambah Data Pembimbing Lama --}}
<div class="modal fade" id="modalPembimbingLama" tabindex="-1" aria-labelledby="modalPembimbingLamaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
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
            <select class="form-select" id="pbl_kegiatan" name="kegiatan">
              <option selected disabled value="">-- Pilih Salah Satu --</option>
              <option value="Membimbing dan ikut membimbing dalam menghasilkan disertasi">Membimbing dan ikut membimbing dalam menghasilkan disertasi</option>
              <option value="Kegiatan Lain">Kegiatan Lain</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="pbl_nama" class="form-label">Nama Dosen</label>
            <select class="form-select" id="pbl_nama" name="pegawai_id">
              <option selected disabled value="">-- Pilih Salah Satu --</option>
              @foreach($dosenAktif as $dosen)
                <option value="{{ $dosen->id }}">{{ $dosen->nama_lengkap }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="pbl_tahun_semester" class="form-label">Tahun Semester</label>
            <input type="text" class="form-control" id="pbl_tahun_semester" name="tahun_semester" placeholder="Contoh: 2020/2021">
          </div>
          <div class="mb-3">
            <label for="pbl_nim" class="form-label">NIM</label>
            <input type="text" class="form-control" id="pbl_nim" name="nim" placeholder="Masukkan NIM Mahasiswa">
          </div>
          <div class="mb-3">
            <label for="pbl_nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
            <input type="text" class="form-control" id="pbl_nama_mahasiswa" name="nama_mahasiswa" placeholder="Masukkan Nama Mahasiswa">
          </div>
          <div class="mb-3">
            <label for="pbl_departemen" class="form-label">Departemen</label>
            <select class="form-select" id="pbl_departemen" name="departemen"><option selected disabled value="">-- Pilih --</option><option value="Manajemen Hutan">Manajemen Hutan</option><option value="Teknologi Hasil Hutan">Teknologi Hasil Hutan</option></select>
          </div>
          <div class="mb-3">
            <label for="pbl_lokasi" class="form-label">Lokasi (PL/KKN)</label>
            <input type="text" class="form-control" id="pbl_lokasi" name="lokasi" placeholder="Masukkan Lokasi PL/KKN">
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