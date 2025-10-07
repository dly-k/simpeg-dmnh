<div class="modal fade" id="editSertifikatKompetensiModal" tabindex="-1" aria-labelledby="editSertifikatKompetensiTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form id="editSertifikatForm" action="#" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-header bg-warning text-dark">
          <h5 class="modal-title" id="editSertifikatKompetensiTitle"><i class="fas fa-edit me-2"></i> Edit Sertifikat Kompetensi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            {{-- Dropdown Nama dinamis --}}
            <div class="col-12">
              <label for="pegawai_id_edit" class="form-label">Nama Pegawai</label>
              <select name="pegawai_id" id="pegawai_id_edit" class="form-select form-select-sm" required>
                <option value="">-- Pilih Pegawai --</option>
                @foreach($pegawais as $pegawai)
                  <option value="{{ $pegawai->id }}">{{ $pegawai->nama_lengkap }}</option>
                @endforeach
              </select>
            </div>
            {{-- Sesuaikan ID dan name agar snake_case --}}
            <div class="col-12">
              <label for="kegiatan_edit" class="form-label">Kegiatan</label>
              <select name="kegiatan" id="kegiatan_edit" class="form-select" required>
                <option value="">-- Pilih Kegiatan --</option>
                <option value="nasional">Memperoleh sertifikat profesi: Bereputasi tingkat Nasional</option>
                <option value="internasional">Memperoleh sertifikat profesi: Bereputasi tingkat Internasional</option>
                <option value="kompetensi">Memperoleh sertifikat Kompetensi</option>
              </select>
            </div>
            <div class="col-12">
              <label for="judul_kegiatan_edit" class="form-label">Judul Kegiatan</label>
              <input type="text" name="judul_kegiatan" id="judul_kegiatan_edit" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="no_reg_pendidik_edit" class="form-label">Nomor Registrasi Pendidik</label>
              <input type="text" name="no_reg_pendidik" id="no_reg_pendidik_edit" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="no_sk_sertifikasi_edit" class="form-label">Nomor SK Sertifikasi</label>
              <input type="text" name="no_sk_sertifikasi" id="no_sk_sertifikasi_edit" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="tahun_sertifikasi_edit" class="form-label">Tahun Sertifikasi</label>
              <input type="number" name="tahun_sertifikasi" id="tahun_sertifikasi_edit" class="form-control" min="1900" max="2099" required>
            </div>
            <div class="col-md-6">
              <label for="tmt_sertifikasi_edit" class="form-label">TMT Sertifikasi</label>
              <input type="date" name="tmt_sertifikasi" id="tmt_sertifikasi_edit" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="tst_sertifikasi_edit" class="form-label">TST Sertifikasi</label>
              <input type="date" name="tst_sertifikasi" id="tst_sertifikasi_edit" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="bidang_studi_edit" class="form-label">Bidang Studi</label>
              <input type="text" name="bidang_studi" id="bidang_studi_edit" class="form-control" required>
            </div>
            <div class="col-12">
              <label for="lembaga_sertifikasi_edit" class="form-label">Lembaga Sertifikasi</label>
              <select name="lembaga_sertifikasi" id="lembaga_sertifikasi_edit" class="form-select" required>
                <option value="">-- Pilih Lembaga --</option>
                <option value="bpsdm">Badan Pengembangan SDM</option>
                <option value="bsnp">Badan Standar Nasional Pendidikan</option>
                <option value="bnspt">Badan Nasional Sertifikasi Profesi</option>
                <option value="kemdikbud">Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi</option>
                <option value="lainnya">Lainnya</option>
              </select>
              <input type="text" name="lembaga_sertifikasi_lainnya" id="lembaga_sertifikasi_lainnya_edit" class="form-control mt-2 d-none">
            </div>
            <div class="col-12">
              <label class="form-label">Unggah Dokumen (kosongkan jika tidak diubah)</label>
              <div class="upload-area">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small></p>
                <input type="file" name="dokumen" hidden accept=".pdf">
              </div>
              <span class="text-danger mt-1 d-block d-none"></span>
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