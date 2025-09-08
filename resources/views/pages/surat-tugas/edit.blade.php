<!-- Modal Edit Data Surat Tugas -->
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalTitle{{ $item->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header-custom">
        <h5 class="modal-title" id="editModalTitle{{ $item->id }}">
          <i class="fas fa-edit"></i> Edit Surat Tugas
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body-custom">
        <form action="{{ route('surat-tugas.update', $item->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="row g-3">
            <!-- Nama Dosen -->
            <div class="col-12">
              <label class="form-label">Nama Dosen</label>
              <input type="text" name="nama_dosen" class="form-control" value="{{ $item->nama_dosen }}">
            </div>

            <!-- Peran -->
            <div class="col-12">
              <label class="form-label">Peran</label>
              <input type="text" name="peran" class="form-control" value="{{ $item->peran }}">
            </div>

            <!-- Diminta Sebagai -->
            <div class="col-12">
              <label class="form-label">Pemohon / Menjadi</label>
              <input type="text" name="diminta_sebagai" class="form-control" value="{{ $item->diminta_sebagai }}">
            </div>

            <!-- Mitra / Instansi -->
            <div class="col-12">
              <label class="form-label">Mitra / Nama Instansi</label>
              <input type="text" name="mitra_instansi" class="form-control" value="{{ $item->mitra_instansi }}">
            </div>

            <!-- No & Tgl Surat Instansi -->
            <div class="col-md-6">
              <label class="form-label">No Surat Instansi</label>
              <input type="text" name="no_surat_instansi" class="form-control" value="{{ $item->no_surat_instansi }}">
            </div>
            <div class="col-md-6">
              <label class="form-label">Tanggal Surat Instansi</label>
              <input type="date" name="tgl_surat_instansi" class="form-control" value="{{ optional($item->tgl_surat_instansi)->format('Y-m-d') ?? $item->tgl_surat_instansi }}">
            </div>

            <!-- No & Tgl Surat Kadep -->
            <div class="col-md-6">
              <label class="form-label">No Surat Kadep</label>
              <input type="text" name="no_surat_kadep" class="form-control" value="{{ $item->no_surat_kadep }}">
            </div>
            <div class="col-md-6">
              <label class="form-label">Tanggal Surat Kadep</label>
              <input type="date" name="tgl_surat_kadep" class="form-control" value="{{ optional($item->tgl_surat_kadep)->format('Y-m-d') ?? $item->tgl_surat_kadep }}">
            </div>

            <!-- Tgl Kegiatan -->
            <div class="col-md-6">
              <label class="form-label">Tanggal Kegiatan</label>
              <input type="date" name="tgl_kegiatan" class="form-control" value="{{ optional($item->tgl_kegiatan)->format('Y-m-d') ?? $item->tgl_kegiatan }}">
            </div>

            <!-- Lokasi -->
            <div class="col-md-6">
              <label class="form-label">Lokasi Kegiatan</label>
              <input type="text" name="lokasi" class="form-control" value="{{ $item->lokasi }}">
            </div>

            <!-- Upload File -->
            <div class="col-12">
              <label class="form-label">Unggah Dokumen Baru (Opsional)</label>
              <div class="upload-area" id="uploadAreaEdit{{ $item->id }}">
                @if ($item->dokumen)
                  <i class="fas fa-cloud-upload-alt default-icon"></i>
                  <p class="upload-text">
                    Seret & Lepas File di sini<br>
                    <small>Ukuran Maksimal 5 MB</small>
                  </p>
                @endif
              </div>
              @if ($item->dokumen)
                <div class="mt-2">
                  <small>
                    Dokumen saat ini: <a href="{{ asset('storage/' . $item->dokumen) }}" target="_blank">Lihat Dokumen</a>
                  </small>
                </div>
              @endif
              <input type="file" name="dokumen" id="dokumenEdit{{ $item->id }}" accept=".pdf,.doc,.docx" class="hidden-input">
            </div>
          </div>
      </div>

      <div class="modal-footer-custom">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
      </div>
        </form>
    </div>
  </div>
</div>