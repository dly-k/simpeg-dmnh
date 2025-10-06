<div class="modal fade" id="pembicaraModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form id="pembicaraForm" action="{{ route('pembicara.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="modalTitle">
            <i class="fas fa-plus-circle me-2"></i> Tambah Data Pembicara
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">

            <!-- Kegiatan -->
            <div class="col-12">
              <label for="kegiatan" class="form-label">Kegiatan</label>
              <select name="kegiatan" id="kegiatan" class="form-select form-select-sm select2-kegiatan" required>
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
              <input type="text" name="kegiatan_lainnya" id="kegiatan_lainnya"
                class="form-control mt-2 d-none" placeholder="Tulis kegiatan lainnya">
            </div>

            <!-- Pegawai -->
            <div class="col-12">
              <label for="pegawai_id" class="form-label">Nama Pegawai</label>
              <select name="pegawai_id" id="pegawai_id" class="form-select form-select-sm select2-pegawai" required>
                <option value="" disabled selected>-- Pilih Pegawai --</option>
                @foreach ($pegawais as $pegawai)
                    <option value="{{ $pegawai->id }}" {{ old('pegawai_id') == $pegawai->id ? 'selected' : '' }}>
                        {{ $pegawai->nama_lengkap }}
                    </option>
                @endforeach
              </select>
            </div>

            <!-- Kategori Capaian Luaran -->
            <div class="col-12">
              <label for="kategori_capaian" class="form-label">Kategori Capaian Luaran</label>
              <select name="kategori_capaian" id="kategori_capaian" class="form-select" required>
                <option value="">-- Pilih kategori capaian --</option>
                <option value="buku">Buku</option>
                <option value="hki">HKI</option>
                <option value="pembicara">Pembicara</option>
                <option value="produk">Produk Teknologi Tepat Guna</option>
                <option value="publikasi">Publikasi</option>
                <option value="visiting">Visiting Scientist</option>
                <option value="lainnya">Lainnya</option>
              </select>
              <input type="text" name="kategori_capaian_lainnya" id="kategori_capaian_lainnya"
                class="form-control mt-2 d-none" placeholder="Tulis capaian lainnya">
            </div>

            <!-- Litabmas -->
            <div class="col-12">
              <label for="litabmas" class="form-label">Litabmas (dari SIMLITABMAS)</label>
              <input type="text" name="litabmas" id="litabmas" class="form-control" placeholder="Masukkan kode/nama litabmas" required>
            </div>

            <!-- Kategori Pembicara -->
            <div class="col-12">
              <label for="kategori_pembicara" class="form-label">Kategori Pembicara</label>
              <select name="kategori_pembicara" id="kategori_pembicara" class="form-select" required>
                <option value="" disabled selected>-- Pilih Kategori --</option>
                <option value="utama">Pembicara Kunci</option>
                <option value="pleno">Pembicara pada Pertemuan Ilmiah</option>
                <option value="paralel">Pembicara/Narasumber pada Pelatihan/Penyuluhan/Ceramah</option>
              </select>
            </div>

            <!-- Judul Makalah -->
            <div class="col-12">
              <label for="judul_makalah" class="form-label">Judul Makalah</label>
              <input type="text" name="judul_makalah" id="judul_makalah" class="form-control" placeholder="Masukkan judul makalah" required>
            </div>

            <!-- Nama Pertemuan -->
            <div class="col-12">
              <label for="nama_pertemuan" class="form-label">Nama Pertemuan Ilmiah</label>
              <input type="text" name="nama_pertemuan" id="nama_pertemuan" class="form-control" placeholder="Masukkan nama pertemuan" required>
            </div>

            <!-- Tingkat Pertemuan -->
            <div class="col-md-6">
              <label for="tingkat_pertemuan" class="form-label">Tingkat Pertemuan</label>
              <select name="tingkat_pertemuan" id="tingkat_pertemuan" class="form-select" required>
                <option value="" disabled selected>-- Pilih Tingkat --</option>
                <option value="lokal">Lokal</option>
                <option value="nasional">Nasional</option>
                <option value="internasional">Internasional</option>
              </select>
            </div>

            <!-- Penyelenggara -->
            <div class="col-md-6">
              <label for="penyelenggara" class="form-label">Penyelenggara</label>
              <input type="text" name="penyelenggara" id="penyelenggara" class="form-control" placeholder="Masukkan penyelenggara" required>
            </div>

            <!-- Tanggal Pelaksana -->
            <div class="col-md-6">
              <label for="tanggal_pelaksana" class="form-label">Tanggal Pelaksana</label>
              <input type="date" name="tanggal_pelaksana" id="tanggal_pelaksana" class="form-control" required>
            </div>

            <!-- Bahasa -->
            <div class="col-md-6">
              <label for="bahasa" class="form-label">Bahasa</label>
              <input type="text" name="bahasa" id="bahasa" class="form-control" placeholder="Bahasa yang digunakan" required>
            </div>

            <!-- No. SK & Tanggal SK -->
            <div class="col-md-6">
              <label for="no_sk" class="form-label">No. SK Penugasan</label>
              <input type="text" name="no_sk" id="no_sk" class="form-control" placeholder="Masukkan nomor SK" required>
            </div>
            <div class="col-md-6">
              <label for="tanggal_sk" class="form-label">Tanggal SK Penugasan</label>
              <input type="date" name="tanggal_sk" id="tanggal_sk" class="form-control" required>
            </div>

            <!-- Dokumen -->
            <div class="col-12">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="form-label">Unggah Dokumen</label>
                <button type="button" class="btn btn-sm btn-success" id="addDokumen">
                  <i class="fas fa-plus"></i> Tambah Dokumen
                </button>
              </div>

              <div id="dokumenWrapper">
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
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
