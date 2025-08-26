{{-- Modal Tambah Data Kerjasama --}}
<div class="modal fade" id="kerjasamaModal" tabindex="-1" aria-labelledby="kerjasamaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="kerjasamaModalLabel">
          <i class="fas fa-plus-circle"></i> Tambah Kerjasama
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <form id="kerjasamaForm">
          <div class="row g-3">

            <div class="col-12">
              <label class="form-label">Judul</label>
              <input type="text" class="form-control" name="judul" placeholder="Judul Kerjasama" required>
            </div>

            <div class="col-12">
              <label class="form-label">Mitra</label>
              <input type="text" class="form-control" name="mitra" placeholder="Nama Mitra atau Instansi" required>
            </div>

            <!-- Nomor Dokumen -->
            <div class="col-md-6">
              <label class="form-label">No Surat Mitra</label>
              <input type="text" class="form-control" name="no_surat_mitra" placeholder="Nomor Dokumen dari Mitra">
            </div>
            <div class="col-md-6">
              <label class="form-label">No Surat Departemen</label>
              <input type="text" class="form-control" name="no_surat_departemen" placeholder="Nomor Dokumen dari Departemen">
            </div>

            <div class="col-md-6">
              <label class="form-label">Tgl. Dokumen</label>
              <input type="date" name="tglDoc" class="form-control">
            </div>

            <div class="col-md-6">
              <label class="form-label">Departemen Penanggung Jawab</label>
              <select class="form-select" name="departemen_pj">
                <option selected>-- Pilih Salah Satu --</option>
                <option>Manajemen Hutan</option>
                <option>Konservasi Sumberdaya Hutan</option>
                <option>Teknologi Hasil Hutan</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">TMT (Terhitung Mulai Tanggal)</label>
              <input type="date" class="form-control" name="tmt">
            </div>

            <div class="col-md-6">
              <label class="form-label">TST (Terhitung Selesai Tanggal)</label>
              <input type="date" class="form-control" name="tst">
            </div>

            <!-- Ketua Tim Dinamis -->
            <div class="col-12">
              <label class="form-label">Ketua Tim</label>
              <div id="ketua-list">
                {{-- Input ketua akan ditambahkan lewat JavaScript --}}
              </div>
              <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-ketua-btn">+ Tambah Ketua</button>
            </div>

            <!-- Anggota Tim Dinamis -->
            <div class="col-12">
              <label class="form-label">Anggota Tim (jika ada)</label>
              <div id="anggota-list">
                {{-- Input anggota akan ditambahkan lewat JavaScript --}}
              </div>
              <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-anggota-btn">+ Tambah Anggota</button>
            </div>

            <div class="col-md-6">
              <label class="form-label">Lokasi</label>
              <input type="text" name="lokasi" class="form-control" placeholder="Lokasi Kegiatan">
            </div>

            <div class="col-md-6">
              <label class="form-label">Besaran Dana</label>
              <input type="number" name="dana" class="form-control" placeholder="Contoh: 10000000">
            </div>

            <div class="col-md-6">
              <label class="form-label">Jenis Kerjasama</label>
              <select class="form-select" name="jenis">
                <option selected>-- Pilih Salah Satu --</option>
                <option>MoU</option>
                <option>LoA</option>
                <option>SPK</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Jenis Usulan</label>
              <select class="form-select" name="jenis_usulan">
                <option selected>-- Pilih Salah Satu --</option>
                <option>Baru</option>
                <option>Perpanjangan</option>
              </select>
            </div>

            <!-- Upload Dokumen -->
            <div class="col-12">
              <label class="form-label">Upload Dokumen Kerjasama</label>
              <div class="upload-area" id="uploadAreaDokumen">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Seret & Lepas File Dokumen di sini<br><small>Ukuran Maksimal 5 MB</small></p>
                <input type="file" name="dokumen_kerjasama" hidden>
              </div>
            </div>

            <div class="col-12">
              <label class="form-label">Upload Laporan Kerjasama (opsional)</label>
              <div class="upload-area" id="uploadAreaLaporan">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Seret & Lepas File Laporan di sini<br><small>Ukuran Maksimal 5 MB</small></p>
                <input type="file" name="laporan_kerjasama" hidden>
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