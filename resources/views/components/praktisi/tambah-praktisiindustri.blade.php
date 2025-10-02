<div class="modal fade" id="pengalamanKerjaModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form action="{{ route('praktisi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="modalTitle">
            <i class="fas fa-plus-circle me-2"></i> Tambah Praktisi Dunia Industri
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">

            <!-- Nama Pegawai -->
            <div class="col-12">
              <label for="pegawai_id" class="form-label">Nama Pegawai <span class="text-danger">*</span></label>
              <select name="pegawai_id" id="pegawai_id" class="form-select @error('pegawai_id') is-invalid @enderror" required>
                <option value="" selected disabled>-- Pilih Pegawai --</option>
                @foreach($pegawais as $pegawai)
                  <option value="{{ $pegawai->id }}" {{ old('pegawai_id') == $pegawai->id ? 'selected' : '' }}>
                    {{ $pegawai->nama_lengkap }} (NIP: {{ $pegawai->nip }})
                  </option>
                @endforeach
              </select>
              @error('pegawai_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Bidang Usaha -->
            <div class="col-12">
              <label for="bidang_usaha" class="form-label">Bidang Usaha <span class="text-danger">*</span></label>
              <select name="bidang_usaha" id="bidang_usaha" class="form-select @error('bidang_usaha') is-invalid @enderror" required>
                <option value="" disabled selected>-- Pilih Bidang Usaha --</option>
                <option>Pertanian, Kehutanan, dan Perikanan</option>
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
              @error('bidang_usaha') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Jenis Pekerjaan & Jabatan -->
            <div class="col-md-6">
              <label for="jenis_pekerjaan" class="form-label">Jenis Pekerjaan <span class="text-danger">*</span></label>
              <select name="jenis_pekerjaan" id="jenis_pekerjaan" class="form-select @error('jenis_pekerjaan') is-invalid @enderror" required>
                <option value="" disabled selected>-- Pilih Jenis Pekerjaan --</option>
                <option>Peneliti</option>
                <option>Tim Ahli/Konsultan</option>
                <option>Magang</option>
                <option>Tenaga Pengajar / Instruktur / Fasilitator</option>
                <option>Pimpinan / Manajerial</option>
                <option>Pekerja Lepas (Freelancer)</option>
              </select>
              @error('jenis_pekerjaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label for="jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
              <input type="text" name="jabatan" id="jabatan" class="form-control @error('jabatan') is-invalid @enderror" placeholder="Masukkan jabatan" value="{{ old('jabatan') }}" required>
              @error('jabatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Instansi & Divisi -->
            <div class="col-md-6">
              <label for="instansi" class="form-label">Instansi <span class="text-danger">*</span></label>
              <input type="text" name="instansi" id="instansi" class="form-control @error('instansi') is-invalid @enderror" placeholder="Masukkan nama instansi" value="{{ old('instansi') }}" required>
              @error('instansi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label for="divisi" class="form-label">Divisi</label>
              <input type="text" name="divisi" id="divisi" class="form-control @error('divisi') is-invalid @enderror" placeholder="Masukkan divisi (jika ada)" value="{{ old('divisi') }}">
              @error('divisi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Deskripsi Kerja -->
            <div class="col-12">
              <label for="deskripsi_kerja" class="form-label">Deskripsi Kerja</label>
              <textarea name="deskripsi_kerja" id="deskripsi_kerja" class="form-control @error('deskripsi_kerja') is-invalid @enderror" rows="3" placeholder="Tuliskan deskripsi kerja">{{ old('deskripsi_kerja') }}</textarea>
              @error('deskripsi_kerja') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Tanggal -->
            <div class="col-md-6">
              <label for="tmt" class="form-label">Mulai Bekerja (TMT) <span class="text-danger">*</span></label>
              <input type="date" name="tmt" id="tmt" class="form-control @error('tmt') is-invalid @enderror" value="{{ old('tmt') }}" required>
              @error('tmt') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label for="tst" class="form-label">Selesai Bekerja (TST) <span class="text-danger">*</span></label>
              <input type="date" name="tst" id="tst" class="form-control @error('tst') is-invalid @enderror" value="{{ old('tst') }}" required>
              @error('tst') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Area Pekerjaan -->
            <div class="col-md-6">
              <label for="area_pekerjaan" class="form-label">Area Pekerjaan <span class="text-danger">*</span></label>
              <select name="area_pekerjaan" id="area_pekerjaan" class="form-select @error('area_pekerjaan') is-invalid @enderror" required>
                <option value="" disabled selected>-- Pilih Area Pekerjaan --</option>
                <option value="Dalam Negeri" {{ old('area_pekerjaan') == 'Dalam Negeri' ? 'selected' : '' }}>Dalam Negeri</option>
                <option value="Luar Negeri" {{ old('area_pekerjaan') == 'Luar Negeri' ? 'selected' : '' }}>Luar Negeri</option>
              </select>
              @error('area_pekerjaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Kategori Pekerjaan -->
            <div class="col-md-6">
              <label for="kategori_pekerjaan" class="form-label">Kategori Pekerjaan <span class="text-danger">*</span></label>
              <select name="kategori_pekerjaan" id="kategori_pekerjaan" class="form-select @error('kategori_pekerjaan') is-invalid @enderror" required>
                <option value="" disabled selected>-- Pilih Kategori --</option>
                <option>Praktisi Industri</option>
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
              @error('kategori_pekerjaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Upload Dokumen -->
            <div class="col-md-6">
              <label for="surat_ipb" class="form-label">Surat Tugas dari IPB</label>
              <input type="file" name="surat_ipb" id="surat_ipb" class="form-control @error('surat_ipb') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.txt">
              @error('surat_ipb') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label for="surat_instansi" class="form-label">Surat Tugas/Kontrak dari Instansi</label>
              <input type="file" name="surat_instansi" id="surat_instansi" class="form-control @error('surat_instansi') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.txt">
              @error('surat_instansi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label for="cv" class="form-label">CV</label>
              <input type="file" name="cv" id="cv" class="form-control @error('cv') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.txt">
              <small class="text-muted">*Dosen tamu wajib upload CV</small>
              @error('cv') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label for="profil_perusahaan" class="form-label">Profil Perusahaan</label>
              <input type="file" name="profil_perusahaan" id="profil_perusahaan" class="form-control @error('profil_perusahaan') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.txt">
              @error('profil_perusahaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
              <small class="text-muted">
                Maksimal ukuran file: 5 MB. Jenis file: pdf, jpg, jpeg, png, doc, docx, xls, xlsx, txt
              </small>
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
