<div class="modal fade" id="orasiIlmiahModal" tabindex="-1" aria-labelledby="modalOrasiTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form action="#" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Header -->
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalOrasiTitle">
            <i class="fas fa-plus-circle me-2"></i> Tambah Data Orasi Ilmiah
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Body -->
        <div class="modal-body">
          <div class="row g-3">

            <!-- Pegawai -->
            <div class="col-12">
              <label for="pegawai_id" class="form-label">Pegawai *</label>
              <select name="pegawai_id" id="pegawai_id" class="form-select" required>
                <option value="" disabled selected>-- Pilih Pegawai --</option>
              </select>
            </div>

            <!-- Litabmas -->
            <div class="col-12">
              <label for="litabmas" class="form-label">Litabmas</label>
              <input type="text" name="litabmas" id="litabmas" class="form-control" placeholder="Masukkan kode/nama litabmas">
            </div>

            <!-- Kategori Pembicara & Lingkup -->
            <div class="col-md-6">
              <label for="kategori_pembicara" class="form-label">Kategori Pembicara *</label>
              <select name="kategori_pembicara" id="kategori_pembicara" class="form-select" required>
                <option value="" disabled selected>-- Pilih Kategori --</option>
                <option value="utama">Pembicara pada pertemuan Ilmiah</option>
                <option value="pleno">Pembicara kunci</option>
                <option value="paralel">Pembicara/narasumber pada pelatihan/penyuluhan/ceramah</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="lingkup" class="form-label">Lingkup *</label>
              <select name="lingkup" id="lingkup" class="form-select" required>
                <option value="" disabled selected>-- Pilih Lingkup --</option>
                <option value="lokal">Lokal</option>
                <option value="nasional">Nasional</option>
                <option value="internasional">Internasional</option>
              </select>
            </div>

            <!-- Judul Makalah -->
            <div class="col-12">
              <label for="judul_makalah" class="form-label">Judul Makalah *</label>
              <input type="text" name="judul_makalah" id="judul_makalah" class="form-control" placeholder="Masukkan judul makalah" required>
            </div>

            <!-- Nama Pertemuan & Penyelenggara sejajar -->
            <div class="col-md-6">
              <label for="nama_pertemuan" class="form-label">Nama Pertemuan Ilmiah *</label>
              <input type="text" name="nama_pertemuan" id="nama_pertemuan" class="form-control" placeholder="Masukkan nama pertemuan" required>
            </div>
            <div class="col-md-6">
              <label for="penyelenggara" class="form-label">Penyelenggara *</label>
              <input type="text" name="penyelenggara" id="penyelenggara" class="form-control" placeholder="Masukkan penyelenggara" required>
            </div>

            <!-- Tanggal & Bahasa sejajar -->
            <div class="col-md-6">
              <label for="tanggal_pelaksana" class="form-label">Tanggal Pelaksanaan *</label>
              <input type="date" name="tanggal_pelaksana" id="tanggal_pelaksana" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="bahasa" class="form-label">Bahasa</label>
              <input type="text" name="bahasa" id="bahasa" class="form-control" placeholder="Bahasa yang digunakan">
            </div>

            <!-- ================== UNGGAH DOKUMEN ================== -->
            <hr class="mt-4 my-1">

            <!-- Jenis Dokumen -->
            <div class="col-12">
              <label for="jenis_dokumen" class="form-label">Jenis Dokumen *</label>
              <select name="jenis_dokumen" id="jenis_dokumen" class="form-select" required>
                <option value="" disabled selected>-- Pilih Jenis Dokumen --</option>
                <option value="sertifikat">Transkrip</option>
                <option value="makalah">Surat Tugas</option>
                <option value="sk">SK</option>
                <option value="sertifikat">Sertifikat</option>
                <option value="penyetaraan">Penyetaraan</option>
                <option value="sertifikat ijazah">Sertifikat Ijazah</option>
                <option value="laporan-kegiatan">Laporan Kegiatan</option>
                <option value="ijazah">Ijazah</option>
                <option value="bahan-ajar">Buku / Bahan Ajar</option>
              </select>
            </div>

            <!-- Upload File -->
            <div class="col-12">
            <label class="form-label">Unggah Dokumen</label>
              <div class="upload-area">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small></p>
                <input type="file" name="dokumen" hidden accept=".pdf">
              </div>
               <span id="file-size-feedback" class="text-danger mt-1 d-block" style="display: none;"></span>
            </div>

            <!-- Nama Dokumen / Nomor / Tautan -->
            <div class="col-md-4">
              <label for="nama_dokumen" class="form-label">Nama Dokumen</label>
              <input type="text" name="nama_dokumen" id="nama_dokumen" class="form-control" placeholder="Contoh: Sertifikat Pelatihan GIS">
            </div>
            <div class="col-md-4">
              <label for="nomor_dokumen" class="form-label">Nomor</label>
              <input type="text" name="nomor_dokumen" id="nomor_dokumen" class="form-control" placeholder="Jika ada">
            </div>
            <div class="col-md-4">
              <label for="tautan_dokumen" class="form-label">Tautan</label>
              <input type="url" name="tautan_dokumen" id="tautan_dokumen" class="form-control" placeholder="Jika ada (Google Drive, dll)">
            </div>
            <!-- ==================================================== -->

          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>

      </form>
    </div>
  </div>
</div>