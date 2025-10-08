{{-- Modal Tambah Data Pengajaran Lama --}}
<div class="modal fade" id="modalTambahEditPengajaranLama" tabindex="-1" aria-labelledby="modalPengajaranLamaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPengajaranLamaLabel">
          <i class="fas fa-plus-circle"></i>
          <span id="modalTitleText">Tambah Pengajaran Lama</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formPengajaranLama" onsubmit="return false;">
          <input type="hidden" id="editPengajaranId" name="id">

          <div class="mb-3">
            <label for="kegiatan" class="form-label">Kegiatan</label>
            <input type="text" class="form-control" id="kegiatan" value="Melaksanakan Perkuliahan/Tutorial/Perkuliahan Praktikum & Membimbing...." readonly disabled>
          </div>

          <div class="mb-3">
            <label for="nama" class="form-label">Nama Dosen</label>
            <select class="form-select form-select-sm" id="nama" name="pegawai_id" required>
              <option selected disabled value="">-- Pilih Salah Satu --</option>
              @foreach($dosenAktif as $dosen)
                <option value="{{ $dosen->id }}">{{ $dosen->nama_lengkap }}</option>
              @endforeach
            </select>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
            <label for="tahun_semester" class="form-label">Tahun Semester</label>
            <select class="form-select" id="tahun_semester" name="tahun_semester" required>
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
            <div class="col-md-6 mb-3">
              <label for="nama_mk" class="form-label">Nama Mata Kuliah</label>
              <input type="text" class="form-control" id="nama_mk" name="nama_mk" placeholder="Masukkan Nama Mata Kuliah" required>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="kode_mk" class="form-label">Kode Mata Kuliah</label>
              <input type="text" class="form-control" id="kode_mk" name="kode_mk" placeholder="Masukkan Kode Mata Kuliah" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">SKS</label>
              <div class="input-group">
                <span class="input-group-text">Perkuliahan</span>
                <input type="number" class="form-control" id="sks_kuliah" name="sks_kuliah" placeholder="0">
                <span class="input-group-text">Praktikum</span>
                <input type="number" class="form-control" id="sks_praktikum" name="sks_praktikum" placeholder="0">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="pengampu" class="form-label">Program Studi Pengampu</label>
              <select class="form-select form-select-sm" id="pengampu" name="pengampu" style="width: 100%;" required>
                <option value="">-- Pilih Program Studi --</option>
                @foreach($programStudi as $prodi)
                    <option value="{{ $prodi }}">{{ $prodi }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label for="jenis" class="form-label">Jenis</label>
              <select class="form-select" id="jenis" name="jenis" required>
                <option selected disabled value="">-- Pilih Salah Satu --</option>
                <option value="K">Kuliah</option>
                <option value="P">Praktikum</option>
              </select>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="kelas_paralel" class="form-label">Kelas Paralel</label>
              <input type="text" class="form-control" id="kelas_paralel" name="kelas_paralel" placeholder="Masukkan Kelas Paralel">
            </div>
            <div class="col-md-6 mb-3">
              <label for="jumlah_pertemuan" class="form-label">Jumlah Pertemuan</label>
              <input type="number" class="form-control" id="jumlah_pertemuan" name="jumlah_pertemuan" placeholder="Masukkan Jumlah Pertemuan" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="upload_file" class="form-label">Unggah Dokumen</label>
            <div class="file-drop-area">
              <i class="fas fa-cloud-upload-alt fa-3x mb-2 text-muted"></i>
              <span class="file-message">Drag & Drop File here</span>
              <span class="text-muted">Ukuran Maksimal 5 MB</span>
              <input class="file-input" type="file" id="upload_file" name="file">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-success" id="btnSimpanPengajaran">
          <span class="btn-text">Simpan</span>
          <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
        </button>
      </div>
    </div>
  </div>
</div>