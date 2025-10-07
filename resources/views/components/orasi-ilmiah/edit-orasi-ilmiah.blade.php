<div class="modal fade" id="editOrasiIlmiahModal" tabindex="-1" aria-labelledby="modalEditOrasiTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form id="editOrasiIlmiahForm" action="#" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
        <!-- Header -->
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title" id="modalEditOrasiTitle">
            <i class="fas fa-edit me-2"></i> Edit Data Orasi Ilmiah
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Body -->
        <div class="modal-body">
          <div class="row g-3">

            <!-- Pegawai -->
            {{-- Gunakan kode yang dinamis ini --}}
            <div class="col-12">
                <label for="pegawai_id_edit" class="form-label">Nama Pegawai</label>
                <select name="pegawai_id" id="pegawai_id_edit" class="form-select form-select-sm" required>
                    <option value="" disabled>-- Pilih Pegawai --</option>
                    {{-- Loop data pegawai aktif dari controller --}}
                    @foreach($pegawais as $pegawai)
                        <option value="{{ $pegawai->id }}">{{ $pegawai->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Litabmas -->
            <div class="col-12">
              <label for="litabmas_edit" class="form-label">Litabmas</label>
              <input type="text" name="litabmas" id="litabmas_edit" class="form-control" value="LIT-2025-001">
            </div>

            <!-- Kategori Pembicara & Lingkup -->
            <div class="col-md-6">
              <label for="kategori_pembicara_edit" class="form-label">Kategori Pembicara</label>
              <select name="kategori_pembicara" id="kategori_pembicara_edit" class="form-select" required>
                <option value="" disabled>-- Pilih Kategori --</option>
                <option value="utama">Pembicara pada pertemuan Ilmiah</option>
                <option value="pleno">Pembicara kunci</option>
                <option value="paralel">Pembicara/narasumber pada pelatihan/penyuluhan/ceramah</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="lingkup_edit" class="form-label">Lingkup</label>
              <select name="lingkup" id="lingkup_edit" class="form-select" required>
                <option value="" disabled>-- Pilih Lingkup --</option>
                <option value="lokal">Lokal</option>
                <option value="nasional" selected>Nasional</option>
                <option value="internasional">Internasional</option>
              </select>
            </div>

            <!-- Judul Makalah -->
            <div class="col-12">
              <label for="judul_makalah_edit" class="form-label">Judul Makalah</label>
              <input type="text" name="judul_makalah" id="judul_makalah_edit" class="form-control" value="Pengaruh AI terhadap Pendidikan di Indonesia" required>
            </div>

            <!-- Nama Pertemuan & Penyelenggara sejajar -->
            <div class="col-md-6">
              <label for="nama_pertemuan_edit" class="form-label">Nama Pertemuan Ilmiah</label>
              <input type="text" name="nama_pertemuan" id="nama_pertemuan_edit" class="form-control" value="Seminar Nasional Teknologi Informasi" required>
            </div>
            <div class="col-md-6">
              <label for="penyelenggara_edit" class="form-label">Penyelenggara *</label>
              <input type="text" name="penyelenggara" id="penyelenggara_edit" class="form-control" value="Universitas ABC" required>
            </div>

            <!-- Tanggal & Bahasa sejajar -->
            <div class="col-md-6">
              <label for="tanggal_pelaksana_edit" class="form-label">Tanggal Pelaksanaan *</label>
              <input type="date" name="tanggal_pelaksana" id="tanggal_pelaksana_edit" class="form-control" value="2025-10-01" required>
            </div>
            <div class="col-md-6">
              <label for="bahasa_edit" class="form-label">Bahasa</label>
              <input type="text" name="bahasa" id="bahasa_edit" class="form-control" value="Indonesia">
            </div>

            <!-- ================== UNGGAH DOKUMEN ================== -->
            <hr class="mt-4 my-1">

            <!-- Jenis Dokumen -->
            <div class="col-12">
              <label for="jenis_dokumen_edit" class="form-label">Jenis Dokumen</label>
              <select name="jenis_dokumen" id="jenis_dokumen_edit" class="form-select" required>
                <option value="" disabled>-- Pilih Jenis Dokumen --</option>
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
                <p>File sudah ada: <strong>sertifikat-ai.pdf</strong><br><small>Ukuran Maksimal 5 MB</small></p>
                <input type="file" name="dokumen" hidden accept=".pdf">
              </div>
            </div>

            <!-- Nama Dokumen / Nomor / Tautan -->
            <div class="col-md-4">
              <label for="nama_dokumen_edit" class="form-label">Nama Dokumen</label>
              <input type="text" name="nama_dokumen" id="nama_dokumen_edit" class="form-control" value="Sertifikat AI Nasional">
            </div>
            <div class="col-md-4">
              <label for="nomor_dokumen_edit" class="form-label">Nomor</label>
              <input type="text" name="nomor_dokumen" id="nomor_dokumen_edit" class="form-control" value="123/ABC/2025">
            </div>
            <div class="col-md-4">
              <label for="tautan_dokumen_edit" class="form-label">Tautan</label>
              <input type="url" name="tautan_dokumen" id="tautan_dokumen_edit" class="form-control" value="https://drive.google.com/sertifikatAI">
            </div>
            <!-- ==================================================== -->

          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success text-white">Simpan Perubahan</button>
        </div>

      </form>
    </div>
  </div>
</div>