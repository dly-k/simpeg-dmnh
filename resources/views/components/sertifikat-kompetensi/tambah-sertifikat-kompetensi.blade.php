<div class="modal fade" id="sertifikatKompetensiModal" tabindex="-1" aria-labelledby="sertifikatKompetensiTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form id="sertifikatKompetensiForm" action="{{ route('sertifikat-kompetensi.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="sertifikatKompetensiTitle">
            <i class="fas fa-plus-circle me-2"></i> Tambah Sertifikat Kompetensi
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">

            <div class="col-12">
                <label for="Nama" class="form-label">Nama Pegawai</label>
                <select name="pegawai_id" id="Nama" class="form-select form-select-sm" required>
                    <option value="">-- Pilih Nama Pegawai --</option>
                    @foreach($pegawais as $pegawai)
                        <option value="{{ $pegawai->id }}">{{ $pegawai->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12">
              <label for="Kegiatan" class="form-label">Kegiatan</label>
              <select name="kegiatan" id="Kegiatan" class="form-select" required>
                <option value="">-- Pilih Kegiatan --</option>
                <option value="nasional">Memperoleh sertifikat profesi: Bereputasi tingkat Nasional</option>
                <option value="internasional">Memperoleh sertifikat profesi: Bereputasi tingkat Internasional</option>
                <option value="kompetensi">Memperoleh sertifikat Kompetensi</option>
              </select>
            </div>

            <div class="col-12">
              <label for="Judul_Kegiatan" class="form-label">Judul Kegiatan</label>
              <input type="text" name="judul_kegiatan" id="Judul_Kegiatan" class="form-control" placeholder="Masukkan judul kegiatan" required>
            </div>

            <div class="col-md-6">
              <label for="Nomor_Registrasi_Pendidik" class="form-label">Nomor Registrasi Pendidik</label>
              {{-- Diperbaiki: name="no_reg_pendidik" --}}
              <input type="text" name="no_reg_pendidik" id="Nomor_Registrasi_Pendidik" class="form-control" placeholder="Ketik hanya angka">
            </div>

            <div class="col-md-6">
              <label for="Nomor_SK_Sertifikasi" class="form-label">Nomor SK Sertifikasi</label>
              {{-- Diperbaiki: name="no_sk_sertifikasi" --}}
              <input type="text" name="no_sk_sertifikasi" id="Nomor_SK_Sertifikasi" class="form-control" placeholder="Contoh: 19900-999-0001" required>
            </div>

            <div class="col-md-6">
            <label for="Tahun_Sertifikasi" class="form-label">Tahun Sertifikasi</label>
            <input type="number" name="tahun_sertifikasi" id="Tahun_Sertifikasi" class="form-control" 
                    placeholder="Contoh: 2025" min="1900" max="2099" step="1" required>
            </div>

            <div class="col-md-6">
              <label for="TMT_Sertifikasi" class="form-label">TMT Sertifikasi</label>
              <input type="date" name="tmt_sertifikasi" id="TMT_Sertifikasi" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label for="TST_Sertifikasi" class="form-label">TST Sertifikasi</label>
              <input type="date" name="tst_sertifikasi" id="TST_Sertifikasi" class="form-control">
            </div>

            <div class="col-md-6">
              <label for="Bidang_Studi" class="form-label">Bidang Studi</label>
              <input type="text" name="bidang_studi" id="Bidang_Studi" class="form-control" placeholder="Masukkan bidang studi" required>
            </div>

            <div class="col-12">
              <label for="Lembaga_Sertifikasi" class="form-label">Lembaga Sertifikasi</label>
              <select name="lembaga_sertifikasi" id="Lembaga_Sertifikasi" class="form-select" required>
                <option value="">-- Pilih Lembaga Sertifikasi --</option>
                <option value="bpsdm">Badan Pengembangan SDM</option>
                <option value="bsnp">Badan Standar Nasional Pendidikan</option>
                <option value="bnspt">Badan Nasional Sertifikasi Profesi</option>
                <option value="kemdikbud">Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi</option>
                <option value="lainnya">Lainnya</option>
              </select>
              <input type="text" name="lembaga_sertifikasi_lainnya" id="Lembaga_Sertifikasi_Lainnya" class="form-control mt-2" placeholder="Masukkan lembaga sertifikasi lainnya" style="display:none;">
            </div>

            <div class="col-12">
              <label class="form-label">Unggah Dokumen</label>
              <div class="upload-area">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small></p>
                <input type="file" name="dokumen" hidden accept=".pdf">
              </div>
              <span id="file-size-feedback" class="text-danger mt-1 d-block d-none"></span>
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