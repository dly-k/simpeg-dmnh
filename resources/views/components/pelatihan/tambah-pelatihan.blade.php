{{-- Modal Tambah Pelatihan --}}
<div class="modal fade" id="pelatihanModal" tabindex="-1" aria-labelledby="pelatihanModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="pelatihanModalLabel">
          <i class="fas fa-plus-circle"></i> Tambah Data Pelatihan
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
        <form id="pelatihanForm">
          <div class="row g-3">

            <div class="col-12">
              <label class="form-label">Nama Pelatihan</label>
              <input type="text" class="form-control" placeholder="Masukkan nama kegiatan pelatihan">
            </div>

            <div class="col-12">
              <label class="form-label">Posisi Pelatihan</label>
              <select class="form-select">
                <option selected>-- Pilih Posisi --</option>
                <option value="Peserta">Peserta</option>
                <option value="Pembicara">Pembicara</option>
                <option value="Panitia">Panitia</option>
              </select>
            </div>

            <div class="col-12">
              <label class="form-label">Kota/Kabupaten</label>
              <input type="text" class="form-control" placeholder="Contoh: Bogor">
            </div>

            <div class="col-12">
              <label class="form-label">Lokasi</label>
              <input type="text" class="form-control" placeholder="Contoh: Kampus IPB Dramaga">
            </div>

            <div class="col-12">
              <label class="form-label">Penyelenggara</label>
              <input type="text" class="form-control" placeholder="Contoh: Fakultas Kehutanan IPB">
            </div>

            <div class="col-md-6">
              <label class="form-label">Tanggal Mulai</label>
              <input type="date" class="form-control">
            </div>

            <div class="col-md-6">
              <label class="form-label">Tanggal Selesai</label>
              <input type="date" class="form-control">
            </div>

            <div class="col-md-6">
              <label class="form-label">Jumlah Jam</label>
              <input type="number" class="form-control" placeholder="Contoh: 8">
            </div>

            <div class="col-md-6">
              <label class="form-label">Jumlah Hari</label>
              <input type="number" class="form-control" placeholder="Contoh: 3">
            </div>

            <div class="col-md-6">
              <label class="form-label">Jenis Diklat</label>
              <input type="text" class="form-control" placeholder="Contoh: Teknis, Fungsional">
            </div>

            <div class="col-md-6">
              <label class="form-label">Lingkup</label>
              <input type="text" class="form-control" placeholder="Contoh: Internal, Nasional, Internasional">
            </div>

            <div class="col-md-6">
              <label class="form-label">Struktural</label>
              <select class="form-select">
                <option selected>-- Pilih --</option>
                <option value="Ya">Ya</option>
                <option value="Tidak">Tidak</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Sertifikasi</label>
              <select class="form-select">
                <option selected>-- Pilih --</option>
                <option value="Ya">Ya</option>
                <option value="Tidak">Tidak</option>
              </select>
            </div>
            
            <div class="col-12">
              <hr>
              <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="form-label mb-0 fw-bold">Anggota Kegiatan</label>
                <button type="button" class="btn btn-sm btn-primary" onclick="addAnggota()">+ Tambah Anggota</button>
              </div>
              <div id="anggota-list" class="vstack gap-2"></div>
            </div>

            <div class="col-12">
              <hr>
              <label class="form-label fw-bold">Dokumen Pendukung</label>
            </div>

            <div class="col-12">
              <label class="form-label">Jenis Dokumen</label>
              <select class="form-select">
                <option selected>-- Pilih Jenis Dokumen --</option>
                <option value="Sertifikat">Sertifikat</option>
                <option value="Surat Tugas">Surat Tugas</option>
                <option value="Lainnya">Lainnya</option>
              </select>
            </div>
            
            <div class="col-12">
              <label class="form-label">Unggah File</label>
              <div class="upload-area">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>
                  Seret & Lepas File di sini<br>
                  <small>Ukuran Maksimal 5 MB, Format: PDF, JPG, PNG</small>
                </p>
                <input type="file" hidden>
              </div>
            </div>
            
            <div class="col-12">
              <div class="row g-2" id="dokumen-info">
                <div class="col-md-4">
                  <label class="form-label">Nama Dokumen</label>
                  <input type="text" class="form-control" placeholder="Contoh: Sertifikat Pelatihan GIS">
                </div>
                <div class="col-md-4">
                  <label class="form-label">Nomor Dokumen</label>
                  <input type="text" class="form-control" placeholder="Jika ada">
                </div>
                <div class="col-md-4">
                  <label class="form-label">Tautan Dokumen</label>
                  <input type="text" class="form-control" placeholder="Jika ada (Google Drive, dll.)">
                </div>
              </div>
            </div>

          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-success">Simpan Data</button>
      </div>
      
    </div>
  </div>
</div>