<div class="modal fade" id="editPengalamanKerjaModal" tabindex="-1" aria-labelledby="editModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">

      <form id="editPraktisiForm" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title" id="editModalTitle">
            <i class="fas fa-edit me-2"></i> Edit Praktisi Dunia Industri
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">

            <div class="col-12">
              <label for="edit-pegawai_id" class="form-label">Nama Pegawai <span class="text-danger">*</span></label>
              <select name="pegawai_id" id="edit-pegawai_id" class="form-select" required>
                <option value="" disabled>-- Pilih Pegawai --</option>
                @foreach($pegawais as $pegawai)
                  <option value="{{ $pegawai->id }}">
                    {{ $pegawai->nama_lengkap }} (NIP: {{ $pegawai->nip }})
                  </option>
                @endforeach
              </select>
            </div>

            <div class="col-12">
              <label for="edit-bidang_usaha" class="form-label">Bidang Usaha <span class="text-danger">*</span></label>
              <select name="bidang_usaha" id="edit-bidang_usaha" class="form-select" required>
                <option value="" disabled>-- Pilih Bidang Usaha --</option>
                <option value="Pertanian, Kehutanan, dan Perikanan">Pertanian, Kehutanan, dan Perikanan</option>
                <option value="Pertambangan dan Penggalian">Pertambangan dan Penggalian</option>
                <option value="Industri Pengolahan">Industri Pengolahan</option>
                <option value="Pengadaan Listrik, Gas, Uap/Air Panas, dan Udara Dingin">Pengadaan Listrik, Gas, Uap/Air Panas, dan Udara Dingin</option>
                <option value="Pengelolaan Air, Limbah, Daur Ulang Sampah, dan Remediasi">Pengelolaan Air, Limbah, Daur Ulang Sampah, dan Remediasi</option>
                <option value="Konstruksi">Konstruksi</option>
                <option value="Perdagangan Besar dan Eceran, Reparasi & Perawatan Kendaraan Bermotor">Perdagangan Besar dan Eceran, Reparasi & Perawatan Kendaraan Bermotor</option>
                <option value="Pengangkutan dan Pergudangan">Pengangkutan dan Pergudangan</option>
                <option value="Penyediaan Akomodasi serta Makan dan Minum">Penyediaan Akomodasi serta Makan dan Minum</option>
                <option value="Informasi dan Komunikasi">Informasi dan Komunikasi</option>
                <option value="Aktivitas Keuangan dan Asuransi">Aktivitas Keuangan dan Asuransi</option>
                <option value="Real Estat">Real Estat</option>
                <option value="Aktivitas Profesional, Ilmiah, dan Teknis">Aktivitas Profesional, Ilmiah, dan Teknis</option>
                <option value="Penyewaan, Outsourcing, Agen Perjalanan, & Penunjang Usaha">Penyewaan, Outsourcing, Agen Perjalanan, & Penunjang Usaha</option>
                <option value="Administrasi Pemerintahan, Pertahanan, dan Jaminan Sosial Wajib">Administrasi Pemerintahan, Pertahanan, dan Jaminan Sosial Wajib</option>
                <option value="Pendidikan">Pendidikan</option>
                <option value="Aktivitas Kesehatan Manusia dan Sosial">Aktivitas Kesehatan Manusia dan Sosial</option>
                <option value="Kesenian, Hiburan, dan Rekreasi">Kesenian, Hiburan, dan Rekreasi</option>
                <option value="Aktivitas Jasa Lainnya">Aktivitas Jasa Lainnya</option>
                <option value="Aktivitas Rumah Tangga: Pekerja, Produksi Barang & Jasa untuk Kebutuhan Sendiri">Aktivitas Rumah Tangga: Pekerja, Produksi Barang & Jasa untuk Kebutuhan Sendiri</option>
                <option value="Aktivitas Badan Internasional dan Ekstra Internasional">Aktivitas Badan Internasional dan Ekstra Internasional</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="edit-jenis_pekerjaan" class="form-label">Jenis Pekerjaan <span class="text-danger">*</span></label>
              <select name="jenis_pekerjaan" id="edit-jenis_pekerjaan" class="form-select" required>
                <option value="" disabled>-- Pilih Jenis Pekerjaan --</option>
                <option value="Peneliti">Peneliti</option>
                <option value="Tim Ahli/Konsultan">Tim Ahli/Konsultan</option>
                <option value="Magang">Magang</option>
                <option value="Tenaga Pengajar / Instruktur / Fasilitator">Tenaga Pengajar / Instruktur / Fasilitator</option>
                <option value="Pimpinan / Manajerial">Pimpinan / Manajerial</option>
                <option value="Pekerja Lepas (Freelancer)">Pekerja Lepas (Freelancer)</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="edit-jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
              <input type="text" name="jabatan" id="edit-jabatan" class="form-control" placeholder="Masukkan jabatan" required>
            </div>

            <div class="col-md-6">
              <label for="edit-instansi" class="form-label">Instansi <span class="text-danger">*</span></label>
              <input type="text" name="instansi" id="edit-instansi" class="form-control" placeholder="Masukkan nama instansi" required>
            </div>
            <div class="col-md-6">
              <label for="edit-divisi" class="form-label">Divisi</label>
              <input type="text" name="divisi" id="edit-divisi" class="form-control" placeholder="Masukkan divisi (jika ada)">
            </div>

            <div class="col-12">
              <label for="edit-deskripsi_kerja" class="form-label">Deskripsi Kerja</label>
              <textarea name="deskripsi_kerja" id="edit-deskripsi_kerja" class="form-control" rows="3" placeholder="Tuliskan deskripsi kerja"></textarea>
            </div>

            <div class="col-md-6">
              <label for="edit-tmt" class="form-label">Mulai Bekerja (TMT) <span class="text-danger">*</span></label>
              <input type="date" name="tmt" id="edit-tmt" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="edit-tst" class="form-label">Selesai Bekerja (TST) <span class="text-danger">*</span></label>
              <input type="date" name="tst" id="edit-tst" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label for="edit-area_pekerjaan" class="form-label">Area Pekerjaan <span class="text-danger">*</span></label>
              <select name="area_pekerjaan" id="edit-area_pekerjaan" class="form-select" required>
                <option value="" disabled>-- Pilih Area Pekerjaan --</option>
                <option value="Dalam Negeri">Dalam Negeri</option>
                <option value="Luar Negeri">Luar Negeri</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="edit-kategori_pekerjaan" class="form-label">Kategori Pekerjaan <span class="text-danger">*</span></label>
              <select name="kategori_pekerjaan" id="edit-kategori_pekerjaan" class="form-select" required>
                <option value="" disabled>-- Pilih Kategori --</option>
                <option value="Praktisi Industri">Praktisi Industri</option>
                <option value="Multinasional">Multinasional</option>
                <option value="Teknologi Global Forbes 100">Teknologi Global Forbes 100</option>
                <option value="Start Up Teknologi Dalam Negeri">Start Up Teknologi Dalam Negeri</option>
                <option value="Start Up Teknologi Luar Negeri">Start Up Teknologi Luar Negeri</option>
                <option value="Nirlaba Nasional">Nirlaba Nasional</option>
                <option value="Nirlaba Internasional">Nirlaba Internasional</option>
                <option value="Organisasi Multilateral">Organisasi Multilateral</option>
                <option value="Kementerian / Lembaga Pemerintah">Kementerian / Lembaga Pemerintah</option>
                <option value="BUMN / BUMD">BUMN / BUMD</option>
                <option value="Pendiri / Pasangan Pendiri">Pendiri / Pasangan Pendiri</option>
                <option value="Perusahaan Swasta Skala Kecil">Perusahaan Swasta Skala Kecil</option>
                <option value="Perusahaan Swasta Skala Menengah ke Atas">Perusahaan Swasta Skala Menengah ke Atas</option>
              </select>
            </div>

            <div class="col-12 mt-4">
                <p class="fw-bold mb-1">Ubah Dokumen (Opsional)</p>
                <small class="text-muted d-block mb-3">Kosongkan jika tidak ingin mengubah file yang sudah ada.</small>
            </div>
            <div class="col-md-6">
              <label for="edit-surat_ipb" class="form-label">Surat Tugas dari IPB</label>
              <input type="file" name="surat_ipb" id="edit-surat_ipb" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.txt">
              <small class="text-muted" id="edit-file-surat_ipb"></small>
            </div>
            <div class="col-md-6">
              <label for="edit-surat_instansi" class="form-label">Surat Tugas/Kontrak dari Instansi</label>
              <input type="file" name="surat_instansi" id="edit-surat_instansi" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.txt">
              <small class="text-muted" id="edit-file-surat_instansi"></small>
            </div>
            <div class="col-md-6">
              <label for="edit-cv" class="form-label">CV</label>
              <input type="file" name="cv" id="edit-cv" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.txt">
              <small class="text-muted" id="edit-file-cv"></small>
            </div>
            <div class="col-md-6">
              <label for="edit-profil_perusahaan" class="form-label">Profil Perusahaan</label>
              <input type="file" name="profil_perusahaan" id="edit-profil_perusahaan" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.txt">
              <small class="text-muted" id="edit-file-profil_perusahaan"></small>
            </div>

            <div class="col-12">
              <small class="text-muted">
                Maksimal ukuran file: 2 MB. Jenis file: pdf, jpg, jpeg, png, doc, docx, xls, xlsx, txt
              </small>
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>