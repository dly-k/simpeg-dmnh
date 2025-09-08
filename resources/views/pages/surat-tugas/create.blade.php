<!-- Modal Tambah Data Surat Tugas -->
<div class="modal fade" id="suratTugasModal" data-show="{{ $errors->any() ? 'true' : 'false' }}" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header-custom">
        <h5 class="modal-title" id="modalTitle">
          <i class="fas fa-plus-circle"></i> Tambah Surat Tugas
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body-custom">
        <form action="{{ route('surat-tugas.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row g-3">

            <!-- Nama Dosen -->
            <div class="col-12">
              <label class="form-label">Nama Dosen</label>
              <input type="text" name="nama_dosen" class="form-control" placeholder="Masukkan Nama Dosen" value="{{ old('nama_dosen') }}">
              @error('nama_dosen')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <!-- Peran -->
            <div class="col-12">
              <label class="form-label">Peran</label>
              <input type="text" name="peran" class="form-control" placeholder="Masukkan peran (contoh: Narasumber, Pembicara, Moderator)" value="{{ old('peran') }}">
              @error('peran')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <!-- Pemohon / Menjadi -->
            <div class="col-12">
              <label class="form-label">Pemohon / Menjadi</label>
              <input type="text" name="diminta_sebagai" class="form-control" placeholder="Masukkan nama pemohon atau menjadi" value="{{ old('diminta_sebagai') }}">
              @error('diminta_sebagai')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <!-- Mitra / Instansi -->
            <div class="col-12">
              <label class="form-label">Mitra / Nama Instansi</label>
              <input type="text" name="mitra_instansi" class="form-control" placeholder="Masukkan nama mitra atau instansi" value="{{ old('mitra_instansi') }}">
              @error('mitra_instansi')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <!-- No & Tanggal Surat Instansi -->
            <div class="col-md-6">
              <label class="form-label">No Surat Instansi</label>
              <input type="text" name="no_surat_instansi" class="form-control" placeholder="Contoh: AT3.F5/KP.05.01/2020" value="{{ old('no_surat_instansi') }}">
              @error('no_surat_instansi')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label">Tanggal Surat Instansi</label>
              <input type="date" name="tgl_surat_instansi" class="form-control" value="{{ old('tgl_surat_instansi') }}">
              @error('tgl_surat_instansi')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <!-- No & Tanggal Surat Kadep -->
            <div class="col-md-6">
              <label class="form-label">No Surat Kadep</label>
              <input type="text" name="no_surat_kadep" class="form-control" placeholder="Contoh: AT3.F5/KP.05.01/2020" value="{{ old('no_surat_kadep') }}">
              @error('no_surat_kadep')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label">Tanggal Surat Kadep</label>
              <input type="date" name="tgl_surat_kadep" class="form-control" value="{{ old('tgl_surat_kadep') }}">
              @error('tgl_surat_kadep')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <!-- Tanggal Kegiatan -->
            <div class="col-md-6">
              <label class="form-label">Tanggal Kegiatan</label>
              <input type="date" name="tgl_kegiatan" class="form-control" value="{{ old('tgl_kegiatan') }}">
              @error('tgl_kegiatan')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <!-- Lokasi -->
            <div class="col-md-6">
              <label class="form-label">Lokasi Kegiatan</label>
              <input type="text" name="lokasi" class="form-control" placeholder="Masukkan lokasi kegiatan" value="{{ old('lokasi') }}">
              @error('lokasi')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <!-- Upload File -->
            <div class="col-12">
              <label class="form-label">Unggah Dokumen</label>
              <div class="upload-area" id="uploadArea">
                <i class="fas fa-cloud-upload-alt default-icon"></i>
                <p class="upload-text">Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small></p>
              </div>
              <input type="file" name="dokumen" id="dokumen" accept=".pdf,.doc,.docx" class="hidden-input">
              @error('dokumen')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

          </div>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer-custom">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success" id="btnSimpanData">Simpan</button>
      </div>

        </form>
    </div>
  </div>
</div>

