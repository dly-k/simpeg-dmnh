<div class="modal fade" id="editPengalamanKerjaModal" tabindex="-1" aria-labelledby="editModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">

      <form id="editPraktisiForm" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Header -->
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title" id="editModalTitle">
            <i class="fas fa-edit me-2"></i> Edit Praktisi Dunia Industri
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Body -->
        <div class="modal-body">
          <div class="row g-3">

            <!-- Nama Pegawai -->
            <div class="col-12">
              <label for="edit-pegawai_id" class="form-label">Nama Pegawai <span class="text-danger">*</span></label>
              <select name="pegawai_id" id="edit-pegawai_id" class="form-select form-select-sm select2" required>
                <option value="" disabled selected>-- Pilih Pegawai --</option>
                @foreach($pegawais as $pegawai)
                  <option value="{{ $pegawai->id }}" {{ old('pegawai_id') == $pegawai->id ? 'selected' : '' }}>
                    {{ $pegawai->nama_lengkap }} (NIP: {{ $pegawai->nip }})
                  </option>
                @endforeach
              </select>
            </div>

            <!-- Bidang Usaha -->
            <div class="col-12">
              <label for="edit-bidang_usaha" class="form-label">Bidang Usaha <span class="text-danger">*</span></label>
              <select name="bidang_usaha" id="edit-bidang_usaha" class="form-select form-select-sm select2" required>
                <option value="" disabled selected>-- Pilih Bidang Usaha --</option>
                @php
                  $bidangUsahaList = [
                    'Pertanian, Kehutanan, dan Perikanan',
                    'Pertambangan dan Penggalian',
                    'Industri Pengolahan',
                    'Pengadaan Listrik, Gas, Uap/Air Panas, dan Udara Dingin',
                    'Pengelolaan Air, Limbah, Daur Ulang Sampah, dan Remediasi',
                    'Konstruksi',
                    'Perdagangan Besar dan Eceran, Reparasi & Perawatan Kendaraan Bermotor',
                    'Pengangkutan dan Pergudangan',
                    'Penyediaan Akomodasi serta Makan dan Minum',
                    'Informasi dan Komunikasi',
                    'Aktivitas Keuangan dan Asuransi',
                    'Real Estat',
                    'Aktivitas Profesional, Ilmiah, dan Teknis',
                    'Penyewaan, Outsourcing, Agen Perjalanan, & Penunjang Usaha',
                    'Administrasi Pemerintahan, Pertahanan, dan Jaminan Sosial Wajib',
                    'Pendidikan',
                    'Aktivitas Kesehatan Manusia dan Sosial',
                    'Kesenian, Hiburan, dan Rekreasi',
                    'Aktivitas Jasa Lainnya'
                  ];
                @endphp
                @foreach($bidangUsahaList as $bidang)
                  <option value="{{ $bidang }}" {{ old('bidang_usaha') == $bidang ? 'selected' : '' }}>
                    {{ $bidang }}
                  </option>
                @endforeach
              </select>
            </div>

            <!-- Jenis Pekerjaan & Jabatan -->
            <div class="col-md-6">
              <label for="edit-jenis_pekerjaan" class="form-label">Jenis Pekerjaan <span class="text-danger">*</span></label>
              <select name="jenis_pekerjaan" id="edit-jenis_pekerjaan" class="form-select" required>
                <option value="" disabled selected>-- Pilih Jenis Pekerjaan --</option>
                @php
                  $jenisPekerjaanList = [
                    'Peneliti', 'Tim Ahli/Konsultan', 'Magang',
                    'Tenaga Pengajar / Instruktur / Fasilitator', 
                    'Pimpinan / Manajerial', 'Pekerja Lepas (Freelancer)'
                  ];
                @endphp
                @foreach($jenisPekerjaanList as $jenis)
                  <option value="{{ $jenis }}" {{ old('jenis_pekerjaan') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label for="edit-jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
              <input type="text" name="jabatan" id="edit-jabatan" class="form-control" value="{{ old('jabatan') }}" required>
            </div>

            <!-- Instansi & Divisi -->
            <div class="col-md-6">
              <label for="edit-instansi" class="form-label">Instansi <span class="text-danger">*</span></label>
              <input type="text" name="instansi" id="edit-instansi" class="form-control" value="{{ old('instansi') }}" required>
            </div>
            <div class="col-md-6">
              <label for="edit-divisi" class="form-label">Divisi</label>
              <input type="text" name="divisi" id="edit-divisi" class="form-control" value="{{ old('divisi') }}">
            </div>

            <!-- Deskripsi -->
            <div class="col-12">
              <label for="edit-deskripsi_kerja" class="form-label">Deskripsi Kerja</label>
              <textarea name="deskripsi_kerja" id="edit-deskripsi_kerja" class="form-control" rows="3">{{ old('deskripsi_kerja') }}</textarea>
            </div>

            <!-- TMT & TST -->
            <div class="col-md-6">
              <label for="edit-tmt" class="form-label">Mulai Bekerja (TMT) <span class="text-danger">*</span></label>
              <input type="date" name="tmt" id="edit-tmt" class="form-control" value="{{ old('tmt') }}" required>
            </div>
            <div class="col-md-6">
              <label for="edit-tst" class="form-label">Selesai Bekerja (TST) <span class="text-danger">*</span></label>
              <input type="date" name="tst" id="edit-tst" class="form-control" value="{{ old('tst') }}" required>
            </div>

            <!-- Area & Kategori -->
            <div class="col-md-6">
              <label for="edit-area_pekerjaan" class="form-label">Area Pekerjaan <span class="text-danger">*</span></label>
              <select name="area_pekerjaan" id="edit-area_pekerjaan" class="form-select" required>
                <option value="" disabled selected>-- Pilih Area Pekerjaan --</option>
                <option value="Dalam Negeri" {{ old('area_pekerjaan') == 'Dalam Negeri' ? 'selected' : '' }}>Dalam Negeri</option>
                <option value="Luar Negeri" {{ old('area_pekerjaan') == 'Luar Negeri' ? 'selected' : '' }}>Luar Negeri</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="edit-kategori_pekerjaan" class="form-label">Kategori Pekerjaan <span class="text-danger">*</span></label>
              <select name="kategori_pekerjaan" id="edit-kategori_pekerjaan" class="form-select" required>
                <option value="" disabled selected>-- Pilih Kategori --</option>
                @php
                  $kategoriList = [
                    'Praktisi Industri','Multinasional','Teknologi Global Forbes 100',
                    'Start Up Teknologi Dalam Negeri','Start Up Teknologi Luar Negeri','Nirlaba Nasional',
                    'Nirlaba Internasional','Organisasi Multilateral','Kementerian / Lembaga Pemerintah',
                    'BUMN / BUMD','Pendiri / Pasangan Pendiri','Perusahaan Swasta Skala Kecil',
                    'Perusahaan Swasta Skala Menengah ke Atas'
                  ];
                @endphp
                @foreach($kategoriList as $kategori)
                  <option value="{{ $kategori }}" {{ old('kategori_pekerjaan') == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                @endforeach
              </select>
            </div>

            <!-- Dokumen -->
            <div class="col-12">
              <div class="card border shadow-none">
                <div class="card-header">
                  <h6 class="mb-0">Unggah Dokumen 
                    <small>(Kosongkan jika tidak ingin mengubah, maks 5 MB)</small>
                  </h6>
                </div>
                <div class="card-body">
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label for="edit-surat_ipb" class="form-label">Surat Tugas dari IPB</label>
                      <input type="file" name="surat_ipb" id="edit-surat_ipb" class="form-control"
                             accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.txt">
                    </div>
                    <div class="col-md-6">
                      <label for="edit-surat_instansi" class="form-label">Surat Tugas/Kontrak dari Instansi</label>
                      <input type="file" name="surat_instansi" id="edit-surat_instansi" class="form-control"
                             accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.txt">
                    </div>
                    <div class="col-md-6">
                      <label for="edit-cv" class="form-label">CV</label>
                      <input type="file" name="cv" id="edit-cv" class="form-control"
                             accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.txt">
                    </div>
                    <div class="col-md-6">
                      <label for="edit-profil_perusahaan" class="form-label">Profil Perusahaan</label>
                      <input type="file" name="profil_perusahaan" id="edit-profil_perusahaan" class="form-control"
                             accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.txt">
                    </div>
                  </div>
                </div>
              </div>
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