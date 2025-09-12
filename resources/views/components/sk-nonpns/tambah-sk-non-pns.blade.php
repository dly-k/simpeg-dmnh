<div class="modal fade" id="skNonPnsModal" tabindex="-1" aria-labelledby="skNonPnsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="skNonPnsModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="skNonPnsForm" method="POST" action="" enctype="multipart/form-data">
        @csrf
        <div id="editMethod"></div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label">Nama Pegawai</label>
              {{-- PERUBAHAN DARI INPUT MENJADI SELECT --}}
              <select class="form-select" id="pegawai_id" name="pegawai_id" required>
                <option value="" selected>-- Pilih Pegawai --</option>
                {{-- Controller akan mengirim variabel $pegawai yang akan di-loop di sini --}}
                @if(isset($pegawai))
                  @foreach($pegawai as $p)
                    <option value="{{ $p->id }}">{{ $p->nama_lengkap }}</option>
                  @endforeach
                @endif
              </select>
            </div>
            <div class="col-12">
              <label class="form-label">Unit</label>
              <input type="text" class="form-control" id="nama_unit" name="nama_unit" value="Departemen Manajemen Hutan" readonly required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Tanggal Mulai</label>
              <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Tanggal Selesai</label>
              <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
            </div>
            <div class="col-12">
              <label class="form-label">Nomor SK</label>
              <input type="text" class="form-control" id="nomor_sk" name="nomor_sk" placeholder="Masukkan Nomor SK" required>
            </div>
            <div class="col-12">
              <label class="form-label">Tanggal SK</label>
              <input type="date" class="form-control" id="tanggal_sk" name="tanggal_sk" required>
            </div>
            <div class="col-12">
              <label class="form-label">Jenis SK</label>
              <select class="form-select" id="jenis_sk" name="jenis_sk" required>
                <option value="" selected>-- Pilih Jenis SK --</option>
                <option value="Presiden">Presiden</option>
                <option value="Mendikbud">Menteri Pendidikan dan Kebudayaan (Mendikbud)</option>
                <option value="Mendiknas">Menteri Pendidikan Nasional (Mendiknas)</option>
                <option value="Ristekdikti">Menteri Riset, Teknologi, dan Pendidikan Tinggi (Ristekdikti)</option>
                <option value="MWA">Majelis Wali Amanat (MWA)</option>
                <option value="DGB">Dewan Guru Besar (DGB)</option>
                <option value="Rektor">Rektor IPB</option>
                <option value="Dekan">Dekan</option>
                <option value="Wakil Dekan">Wakil Dekan</option>
                <option value="Ketua Departemen">Ketua Departemen</option>
                <option value="Kepala Biro">Kepala Biro</option>
                <option value="Kepala Kantor">Kepala Kantor</option>
                <option value="Kepala Unit">Kepala Unit</option>
              </select>
            </div>

            <div class="col-12">
              <label class="form-label" id="dokumen_label">Unggah Dokumen SK</label>
              <div class="upload-area" data-target="#dokumen_sk">
                <i class="fas fa-cloud-upload-alt default-icon"></i>
                <i class="fas fa-file text-success file-icon d-none"></i>
                <p class="upload-text">Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small></p>
                <p class="file-name d-none"></p>
              </div>
              <input type="file" id="dokumen_sk" name="dokumen_sk" hidden accept=".pdf">
              <div id="file-size-feedback-sk" class="text-danger mt-1" style="display: none;"></div>
              <div id="dokumen-lama-container" class="mt-2" style="display: none;">
                <small>Dokumen saat ini: <a href="#" id="dokumen-lama-link" target="_blank">Lihat Dokumen</a></small>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success" id="btn-simpan"></button>
        </div>
      </form>
    </div>
  </div>
</div>