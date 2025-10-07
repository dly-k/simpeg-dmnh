<div class="modal fade" id="pengelolaJurnalModal" tabindex="-1" aria-labelledby="modalPengelolaJurnalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form id="tambahPengelolaJurnalForm" action="{{ route('pengelola-jurnal.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="modalPublikasiTitle">
            <i class="fas fa-plus-circle me-2"></i> Tambah Data Pengelola Jurnal
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">

            <!-- Nama -->
            <div class="col-12">
              <label for="nama" class="form-label">Nama Pegawai</label>
              <select name="nama" id="nama" class="form-select form-select-sm" required>
                <option value="">-- Pilih Nama Pegawai --</option>
                {{-- Loop data pegawai dari controller --}}
                @foreach ($pegawais as $pegawai)
                  <option value="{{ $pegawai->id }}">{{ $pegawai->nama_lengkap }}</option>
                @endforeach
              </select>
            </div>

            <!-- Kegiatan -->
            <div class="col-12">
            <label for="kegiatan" class="form-label">Kegiatan</label>
            <select name="kegiatan" id="kegiatan" class="form-select" required>
                <option value="">-- Pilih Kegiatan --</option>
                <option value="Berperan serta aktif dalam pengelolaan jurnal ilmiah (per tahun): Editor/ dewan penyunting/ dewan redaksi jurnal ilmiah nasional">
                Berperan serta aktif dalam pengelolaan jurnal ilmiah (Nasional)
                </option>
                <option value="Berperan serta aktif dalam pengelolaan jurnal ilmiah (per tahun): Editor/ dewan penyunting/ dewan redaksi jurnal ilmiah internasional">
                Berperan serta aktif dalam pengelolaan jurnal ilmiah (Internasional)
                </option>
            </select>
            </div>

            <!-- Media Publikasi -->
            <div class="col-12">
              <label for="media_publikasi" class="form-label">Media Publikasi</label>
              <input type="text" name="media_publikasi" id="media_publikasi" class="form-control" placeholder="Masukkan media publikasi" required>
            </div>

            <!-- Peran -->
            <div class="col-12">
              <label for="peran" class="form-label">Peran</label>
              <input type="text" name="peran" id="peran" class="form-control" placeholder="Masukkan peran" required>
            </div>

            <!-- Nomor SK Penugasan -->
            <div class="col-md-6">
              <label for="no_sk" class="form-label">Nomor SK Penugasan</label>
              <input type="text" name="no_sk" id="no_sk" class="form-control" placeholder="Masukkan nomor SK" required>
            </div>

            <!-- Tanggal Mulai -->
            <div class="col-md-3">
              <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
              <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
            </div>

            <!-- Tanggal Selesai -->
            <div class="col-md-3">
              <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
              <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" required>
            </div>

            <!-- Status -->
            <div class="col-12">
              <label for="status" class="form-label">Status</label>
              <select name="status" id="status" class="form-select" required>
                <option value="">-- Pilih Status --</option>
                <option value="Aktif">Aktif</option>
                <option value="Tidak Aktif">Tidak Aktif</option>
              </select>
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
                      <select name="dokumen[0][jenis]" class="form-select" required>
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
                      <input type="text" name="dokumen[0][nama]" class="form-control" placeholder="Nama Dokumen" required>
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
                        accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.txt" required>
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