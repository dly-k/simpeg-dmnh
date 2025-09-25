<!-- Modal Edit Data Praktisi Dunia Industri -->
<div class="modal fade" id="editPengalamanKerjaModal" tabindex="-1" aria-labelledby="editModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title" id="editModalTitle">
          <i class="fas fa-edit me-2"></i> Edit Praktisi Dunia Industri
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">
        <form action="#" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id" value="123"> <!-- ID data dari database -->

          <div class="row g-3">

            <!-- Nama -->
            <div class="col-12">
              <label class="form-label">Nama</label>
              <input type="text" name="nama" class="form-control" value="John Doe">
            </div>

            <!-- Bidang Usaha -->
            <div class="col-12">
              <label class="form-label">Bidang Usaha</label>
              <select name="bidang_usaha" class="form-select">
                <option value="">-- Pilih Bidang Usaha --</option>
                <option selected>Pertanian, Kehutanan, dan Perikanan</option>
                <option>Pertambangan dan Penggalian</option>
                <option>Industri Pengolahan</option>
                <option>Pengadaan Listrik, Gas, Uap/Air Panas, dan Udara Dingin</option>
                <option>Pengelolaan Air, Limbah, Daur Ulang Sampah, dan Remediasi</option>
                <option>Konstruksi</option>
                <option>Perdagangan Besar dan Eceran, Reparasi & Perawatan Kendaraan Bermotor</option>
                <option>Pengangkutan dan Pergudangan</option>
                <option>Penyediaan Akomodasi serta Makan dan Minum</option>
                <option>Informasi dan Komunikasi</option>
                <option>Aktivitas Keuangan dan Asuransi</option>
                <option>Real Estat</option>
                <option>Aktivitas Profesional, Ilmiah, dan Teknis</option>
                <option>Penyewaan, Outsourcing, Agen Perjalanan, & Penunjang Usaha</option>
                <option>Administrasi Pemerintahan, Pertahanan, dan Jaminan Sosial Wajib</option>
                <option>Pendidikan</option>
                <option>Aktivitas Kesehatan Manusia dan Sosial</option>
                <option>Kesenian, Hiburan, dan Rekreasi</option>
                <option>Aktivitas Jasa Lainnya</option>
                <option>Aktivitas Rumah Tangga: Pekerja, Produksi Barang & Jasa untuk Kebutuhan Sendiri</option>
                <option>Aktivitas Badan Internasional dan Ekstra Internasional</option>
              </select>
            </div>

            <!-- Jenis Pekerjaan & Jabatan -->
            <div class="col-md-6">
              <label class="form-label">Jenis Pekerjaan</label>
              <select name="jenis_pekerjaan" class="form-select">
                <option value="">-- Pilih Jenis Pekerjaan --</option>
                <option selected>Peneliti</option>
                <option>Tim Ahli/Konsultan</option>
                <option>Magang</option>
                <option>Tenaga Pengajar / Instruktur / Fasilitator</option>
                <option>Pimpinan / Manajerial</option>
                <option>Pekerja Lepas (Freelancer)</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Jabatan</label>
              <input type="text" name="jabatan" class="form-control" value="Manager Riset">
            </div>

            <!-- Instansi & Divisi -->
            <div class="col-md-6">
              <label class="form-label">Instansi</label>
              <input type="text" name="instansi" class="form-control" value="PT Kehutanan Sejahtera">
            </div>
            <div class="col-md-6">
              <label class="form-label">Divisi</label>
              <input type="text" name="divisi" class="form-control" value="Litbang">
            </div>

            <!-- Deskripsi Kerja -->
            <div class="col-12">
              <label class="form-label">Deskripsi Kerja</label>
              <textarea name="deskripsi_kerja" class="form-control" rows="3">Mengelola riset dan inovasi di bidang kehutanan.</textarea>
            </div>

            <!-- Tanggal Mulai & Selesai -->
            <div class="col-md-6">
              <label class="form-label">Mulai Bekerja</label>
              <input type="date" name="mulai_bekerja" class="form-control" value="2020-01-01">
            </div>
            <div class="col-md-6">
              <label class="form-label">Selesai Bekerja</label>
              <input type="date" name="selesai_bekerja" class="form-control" value="2023-12-31">
            </div>

            <!-- Area Pekerjaan -->
            <div class="col-12">
              <label class="form-label">Area Pekerjaan</label>
              <select name="area_pekerjaan" class="form-select">
                <option value="">-- Pilih Area Pekerjaan --</option>
                <option selected>Dalam Negeri</option>
                <option>Luar Negeri</option>
              </select>
            </div>

            <!-- Kategori Pekerjaan -->
            <div class="col-12">
              <label class="form-label">Kategori Pekerjaan</label>
              <select name="kategori_pekerjaan" class="form-select">
                <option value="">-- Pilih Kategori --</option>
                <option selected>Praktisi Industri</option>
                <option>Multinasional</option>
                <option>Teknologi Global Forbes 100</option>
                <option>Start Up Teknologi Dalam Negeri</option>
                <option>Start Up Teknologi Luar Negeri</option>
                <option>Nirlaba Nasional</option>
                <option>Nirlaba Internasional</option>
                <option>Organisasi Multilateral</option>
                <option>Kementerian / Lembaga Pemerintah</option>
                <option>BUMN / BUMD</option>
                <option>Pendiri / Pasangan Pendiri</option>
                <option>Perusahaan Swasta Skala Kecil</option>
                <option>Perusahaan Swasta Skala Menengah ke Atas</option>
              </select>
            </div>

            <!-- Upload Dokumen -->
            <div class="col-md-6">
              <label class="form-label">Surat Tugas dari IPB</label>
              <input type="file" name="surat_ipb" class="form-control">
              <small class="text-muted">File lama: surat_ipb.pdf</small>
            </div>

            <div class="col-md-6">
              <label class="form-label">Surat Tugas/Kontrak dari Instansi Lain</label>
              <input type="file" name="surat_instansi" class="form-control">
              <small class="text-muted">File lama: surat_instansi.pdf</small>
            </div>

            <div class="col-md-6">
              <label class="form-label">CV</label>
              <input type="file" name="cv" class="form-control">
              <small class="text-muted">File lama: cv.pdf</small>
            </div>

            <div class="col-md-6">
              <label class="form-label">Profil Perusahaan</label>
              <input type="file" name="profil_perusahaan" class="form-control">
              <small class="text-muted">File lama: profil_perusahaan.pdf</small>
            </div>

          </div>
      </div>

      <!-- Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
      </div>

        </form>
    </div>
  </div>
</div>