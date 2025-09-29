<div class="modal fade" id="editPembicaraModal" tabindex="-1" aria-labelledby="modalTitleEdit" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form action="#" method="POST" enctype="multipart/form-data">
        <div class="modal-header bg-warning text-dark">
          <h5 class="modal-title" id="modalTitleEdit">
            <i class="fas fa-edit me-2"></i> Edit Data Pembicara
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">

            <!-- Kegiatan -->
            <div class="col-12">
              <label for="edit_kegiatan" class="form-label">Kegiatan *</label>
              <select name="kegiatan" id="edit_kegiatan" class="form-select">
                <option value="">-- Pilih Kegiatan --</option>
                <option value="jadwal_nasional">
                  Memberi latihan/penyuluhan/penataran/ceramah pada masyarakat: Terjadwal/Terprogram, kurang dari 1 semester (≥1 bulan), Tingkat Nasional
                </option>
                <option value="jadwal_lokal">
                  Memberi latihan/penyuluhan/penataran/ceramah pada masyarakat: Terjadwal/Terprogram, kurang dari 1 semester (≥1 bulan), Tingkat Lokal
                </option>
                <option value="jadwal_internasional">
                  Memberi latihan/penyuluhan/penataran/ceramah pada masyarakat: Terjadwal/Terprogram, kurang dari 1 semester (≥1 bulan), Tingkat Internasional
                </option>
                <option value="insidental">
                  Memberi latihan/penyuluhan/penataran/ceramah pada masyarakat: Insidental (tiap kegiatan/program)
                </option>
                <option value="insidental_nasional">
                  Memberi latihan/penyuluhan/penataran/ceramah pada masyarakat: Insidental, Tingkat Nasional
                </option>
                <option value="insidental_lokal">
                  Memberi latihan/penyuluhan/penataran/ceramah pada masyarakat: Insidental, Tingkat Lokal
                </option>
                <option value="insidental_internasional">
                  Memberi latihan/penyuluhan/penataran/ceramah pada masyarakat: Insidental, Tingkat Internasional
                </option>
                <option value="jadwal_nasional_semester">
                  Memberi latihan/penyuluhan/penataran/ceramah pada masyarakat: Terjadwal/Terprogram, ≥1 semester, Tingkat Nasional
                </option>
                <option value="jadwal_lokal_semester">
                  Memberi latihan/penyuluhan/penataran/ceramah pada masyarakat: Terjadwal/Terprogram, ≥1 semester, Tingkat Lokal
                </option>
                <option value="jadwal_internasional_semester">
                  Memberi latihan/penyuluhan/penataran/ceramah pada masyarakat: Terjadwal/Terprogram, ≥1 semester, Tingkat Internasional
                </option>
                <option value="lainnya">Lainnya</option>
              </select>
              <input type="text" name="kegiatan_lainnya" id="edit_kegiatan_lainnya"
                class="form-control mt-2 d-none" placeholder="Tulis kegiatan lainnya">
            </div>

            <!-- Pegawai -->
            <div class="col-12">
              <label for="edit_pegawai_id" class="form-label">Pegawai *</label>
              <select name="pegawai_id" id="edit_pegawai_id" class="form-select">
                <option value="" disabled selected>-- Pilih Pegawai --</option>
              </select>
            </div>

            <!-- Kategori Capaian Luaran -->
            <div class="col-12">
              <label for="edit_kategori_capaian" class="form-label">Kategori Capaian Luaran</label>
              <select name="kategori_capaian" id="edit_kategori_capaian" class="form-select">
                <option value="">-- Pilih kategori capaian --</option>
                <option value="buku">Buku</option>
                <option value="hki">HKI</option>
                <option value="pembicara">Pembicara</option>
                <option value="produk">Produk Teknologi Tepat Guna</option>
                <option value="publikasi">Publikasi</option>
                <option value="visiting">Visiting Scientist</option>
                <option value="lainnya">Lainnya</option>
              </select>
              <input type="text" name="kategori_capaian_lainnya" id="edit_kategori_capaian_lainnya"
                class="form-control mt-2 d-none" placeholder="Tulis capaian lainnya">
            </div>

            <!-- Litabmas -->
            <div class="col-12">
              <label for="edit_litabmas" class="form-label">Litabmas (dari SIMLITABMAS)</label>
              <input type="text" name="litabmas" id="edit_litabmas" class="form-control" placeholder="Masukkan kode/nama litabmas">
            </div>

            <!-- Kategori Pembicara -->
            <div class="col-12">
              <label for="edit_kategori_pembicara" class="form-label">Kategori Pembicara *</label>
              <select name="kategori_pembicara" id="edit_kategori_pembicara" class="form-select">
                <option value="" disabled selected>-- Pilih Kategori --</option>
                <option value="utama">Pembicara Kunci</option>
                <option value="pleno">Pembicara pada Pertemuan Ilmiah</option>
                <option value="paralel">Pembicara/Narasumber pada Pelatihan/Penyuluhan/Ceramah</option>
              </select>
            </div>

            <!-- Judul Makalah -->
            <div class="col-12">
              <label for="edit_judul_makalah" class="form-label">Judul Makalah *</label>
              <input type="text" name="judul_makalah" id="edit_judul_makalah" class="form-control" placeholder="Masukkan judul makalah">
            </div>

            <!-- Nama Pertemuan -->
            <div class="col-12">
              <label for="edit_nama_pertemuan" class="form-label">Nama Pertemuan Ilmiah *</label>
              <input type="text" name="nama_pertemuan" id="edit_nama_pertemuan" class="form-control" placeholder="Masukkan nama pertemuan">
            </div>

            <!-- Tingkat Pertemuan -->
            <div class="col-md-6">
              <label for="edit_tingkat_pertemuan" class="form-label">Tingkat Pertemuan</label>
              <select name="tingkat_pertemuan" id="edit_tingkat_pertemuan" class="form-select">
                <option value="" disabled selected>-- Pilih Tingkat --</option>
                <option value="lokal">Lokal</option>
                <option value="nasional">Nasional</option>
                <option value="internasional">Internasional</option>
              </select>
            </div>

            <!-- Penyelenggara -->
            <div class="col-md-6">
              <label for="edit_penyelenggara" class="form-label">Penyelenggara *</label>
              <input type="text" name="penyelenggara" id="edit_penyelenggara" class="form-control" placeholder="Masukkan penyelenggara">
            </div>

            <!-- Tanggal Pelaksana -->
            <div class="col-md-6">
              <label for="edit_tanggal_pelaksana" class="form-label">Tanggal Pelaksana *</label>
              <input type="date" name="tanggal_pelaksana" id="edit_tanggal_pelaksana" class="form-control">
            </div>

            <!-- Bahasa -->
            <div class="col-md-6">
              <label for="edit_bahasa" class="form-label">Bahasa</label>
              <input type="text" name="bahasa" id="edit_bahasa" class="form-control" placeholder="Bahasa yang digunakan">
            </div>

            <!-- No. SK & Tanggal SK -->
            <div class="col-md-6">
              <label for="edit_no_sk" class="form-label">No. SK Penugasan</label>
              <input type="text" name="no_sk" id="edit_no_sk" class="form-control" placeholder="Masukkan nomor SK">
            </div>
            <div class="col-md-6">
              <label for="edit_tanggal_sk" class="form-label">Tanggal SK Penugasan</label>
              <input type="date" name="tanggal_sk" id="edit_tanggal_sk" class="form-control">
            </div>

            <!-- Dokumen -->
            <div class="col-12">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="form-label">Unggah Dokumen</label>
                <button type="button" class="btn btn-sm btn-success" id="addEditDokumen">
                  <i class="fas fa-plus"></i> Tambah Dokumen
                </button>
              </div>

              <div id="editDokumenWrapper">
                <div class="dokumen-item border rounded p-3 mb-3 position-relative">
                  <button type="button" class="btn-close position-absolute top-0 end-0 m-2 removeDokumen" aria-label="Close"></button>
                  <div class="row g-2">
                    <div class="col-12">
                      <label class="form-label">Jenis Dokumen</label>
                      <select name="dokumen[0][jenis]" class="form-select">
                        <option value="" disabled selected>-- Pilih Jenis Dokumen --</option>
                        <option value="Transkrip">Transkrip</option>
                        <option value="Surat Tugas">Surat Tugas</option>
                        <option value="SK">SK</option>
                        <option value="Sertifikat">Sertifikat</option>
                        <option value="Penyetaraan Ijazah">Penyetaraan Ijazah</option>
                        <option value="Laporan Kegiatan">Laporan Kegiatan</option>
                        <option value="Ijazah">Ijazah</option>
                        <option value="Buku / Bahan Ajar">Buku / Bahan Ajar</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Nama Dokumen</label>
                      <input type="text" name="dokumen[0][nama]" class="form-control" placeholder="Nama Dokumen">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Nomor</label>
                      <input type="text" name="dokumen[0][nomor]" class="form-control" placeholder="Nomor">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Tautan</label>
                      <input type="url" name="dokumen[0][tautan]" class="form-control" placeholder="https://...">
                    </div>
                    <div class="col-12">
                      <label class="form-label">File <small class="text-muted">(Maksimal Ukuran File 5MB)</small></label>
                      <input type="file" name="dokumen[0][file]" class="form-control file-input"
                        accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.txt">
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>