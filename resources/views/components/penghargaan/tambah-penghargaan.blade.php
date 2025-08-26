{{-- Modal Tambah Data Penghargaan --}}
<div class="modal fade" id="penghargaanModal" tabindex="-1" aria-labelledby="penghargaanModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="penghargaanModalLabel">
          <i class="fas fa-plus-circle"></i> Tambah Data Penghargaan
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <form id="penghargaanForm">
          <div class="row g-3">

            <div class="col-12">
              <label class="form-label">Pegawai</label>
              <select class="form-select" required>
                <option value="" selected>-- Pilih Pegawai --</option>
                <!-- Opsi pegawai akan dimuat di sini -->
              </select>
            </div>

            <div class="col-12">
              <label class="form-label">Kegiatan</label>
              <select class="form-select" required>
                <option value="" selected>-- Pilih Kegiatan Terkait --</option>
                <!-- Opsi kegiatan akan dimuat di sini -->
              </select>
            </div>

            <div class="col-12">
              <label class="form-label">Nama Penghargaan</label>
              <input type="text" class="form-control" placeholder="Contoh: Satyalancana Karya Satya X Tahun" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Nomor SK</label>
              <input type="text" class="form-control" placeholder="Masukkan nomor SK penghargaan" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Tanggal Perolehan</label>
              <input type="date" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Lingkup</label>
              <select class="form-select" required>
                <option value="" selected>-- Pilih Lingkup --</option>
                <option>Internal</option>
                <option>Nasional</option>
                <option>Internasional</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Negara</label>
              <input type="text" class="form-control" placeholder="Contoh: Indonesia" required>
            </div>

            <div class="col-12">
              <label class="form-label">Instansi Pemberi</label>
              <input type="text" class="form-control" placeholder="Contoh: Presiden Republik Indonesia" required>
            </div>

            <div class="col-12"><hr></div>

            <!-- Dokumen Penghargaan -->
            <div class="col-12">
              <label class="form-label">Jenis Dokumen</label>
              <select class="form-select" required>
                <option value="" selected>-- Pilih Salah Satu --</option>
                <option>Sertifikat</option>
                <option>Piagam</option>
                <option>SK</option>
              </select>
            </div>

            <div class="col-12">
              <div class="upload-area">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small></p>
                <input type="file" hidden required>
              </div>
            </div>

            <!-- Detail Dokumen -->
            <div class="col-12">
              <div class="row g-2">
                <div class="col-md-4">
                  <label class="form-label-sm">Nama Dokumen</label>
                  <input type="text" class="form-control form-control-sm" placeholder="Nama Dokumen" required>
                </div>
                <div class="col-md-4">
                  <label class="form-label-sm">Nomor</label>
                  <input type="text" class="form-control form-control-sm" placeholder="Nomor Dokumen (Jika Ada)">
                </div>
                <div class="col-md-4">
                  <label class="form-label-sm">Tautan</label>
                  <input type="text" class="form-control form-control-sm" placeholder="Tautan (Jika Ada)">
                </div>
              </div>
            </div>

          </div>
        </form>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-success">Simpan</button>
      </div>

    </div>
  </div>
</div>