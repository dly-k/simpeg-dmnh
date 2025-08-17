 {{-- Pengajaran Lama --}}
    <div class="modal fade" id="modalTambahEditPengajaranLama" tabindex="-1" aria-labelledby="modalPengajaranLamaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalPengajaranLamaLabel">
            {{-- Menambahkan ikon. Anda bisa menggunakan fa-info-circle atau fa-exclamation-circle --}}
            <i class="fas fa-plus-circle"></i>
            {{-- Membungkus teks judul dengan span agar mudah diubah oleh JS --}}
            <span id="modalTitleText">Tambah Pengajaran Lama</span>
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formPengajaranLama">
            {{-- Hidden input untuk menyimpan ID saat mode edit --}}
            <input type="hidden" id="editPengajaranId" name="id">

            <div class="mb-3">
              <label for="kegiatan" class="form-label">Kegiatan</label>
              <input type="text" class="form-control" id="kegiatan" value="Melaksanakan Perkuliahan/Tutorial/Perkuliahan Praktikum & Membimbing...." readonly disabled>
            </div>

            <div class="mb-3">
              <label for="nama" class="form-label">Nama</label>
              <select class="form-select" id="nama" name="nama">
                <option selected disabled value="">-- Pilih Salah Satu --</option>
                {{-- Anda bisa mengisi opsi ini dari database --}}
                <option value="Alex Kurniawan">Alex Kurniawan</option>
                <option value="Budi Santoso">Budi Santoso</option>
              </select>
            </div>
            
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="tahun_semester" class="form-label">Tahun Semester</label>
                <input type="text" class="form-control" id="tahun_semester" name="tahun_semester" placeholder="Contoh: 2020/2021">
              </div>
              <div class="col-md-6 mb-3">
                <label for="nama_mk" class="form-label">Nama Mata Kuliah</label>
                <input type="text" class="form-control" id="nama_mk" name="nama_mk" placeholder="Masukkan Nama Mata Kuliah">
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="kode_mk" class="form-label">Kode Mata Kuliah</label>
                <input type="text" class="form-control" id="kode_mk" name="kode_mk" placeholder="Masukkan Kode Mata Kuliah">
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
                <label for="pengampu" class="form-label">Pengampu</label>
                <select class="form-select" id="pengampu" name="pengampu">
                  <option selected disabled value="">-- Pilih Salah Satu --</option>
                  <option value="1">Pilihan 1</option>
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label for="jenis" class="form-label">Jenis</label>
                <select class="form-select" id="jenis" name="jenis">
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
                <input type="number" class="form-control" id="jumlah_pertemuan" name="jumlah_pertemuan" placeholder="Masukkan Jumlah Pertemuan">
              </div>
            </div>

            <div class="mb-3">
              <label for="upload_file" class="form-label">Upload File</label>
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
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-success" id="btnSimpanPengajaran">Simpan</button>
        </div>
      </div>
    </div>
    </div>