<div class="modal fade" id="penghargaanModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Tambah Data Penghargaan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="penghargaanForm" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" id="penghargaan_id" name="penghargaan_id">

          <div class="row g-3">
            <div class="col-12">
              <label class="form-label">Nama Pegawai</label>
              <select id="pegawai_id" name="pegawai_id" class="form-select form-select-sm" required>
                <option value="" selected>-- Pilih Pegawai --</option>
                @if(isset($pegawai))
                  @foreach($pegawai as $p)
                    <option value="{{ $p->id }}">{{ $p->nama_lengkap }}</option>
                  @endforeach
                @endif
              </select>
            </div>
            <div class="col-12">
              <label class="form-label">Kegiatan</label>
              <select name="kegiatan" class="form-select" required>
                <option value="" selected>-- Pilih Kegiatan Terkait --</option>
                <option>Mendapat tanda jasa/penghargaan: Tingkat Nasional, tiap tanda jasa/penghargaan</option>
                <option>Mendapat tanda jasa/penghargaan: Tingkat Internasional, tiap tanda jasa/penghargaan</option>
                <option>Mendapat tanda jasa/penghargaan: Tingkat Daerah/Lokal, tiap tanda jasa/penghargaan</option>
                <option>Mendapat tanda jasa/penghargaan: Penghargaan/tanda jasa Satya Lencana 30 tahun</option>
                <option>Mendapat tanda jasa/penghargaan: Penghargaan/tanda jasa Satya Lencana 20 tahun</option>
                <option>Mendapat tanda jasa/penghargaan: Penghargaan/tanda jasa Satya Lencana 10 tahun</option>
                <option>Mempunyai prestasi di bidang olahraga/humaniora: Tingkat Nasional, tiap piagam/medali</option>
                <option>Mempunyai prestasi di bidang olahraga/humaniora: Tingkat Internasional, tiap piagam/medali</option>
                <option>Mempunyai prestasi di bidang olahraga/humaniora: Tingkat Daerah, tiap piagam/medali</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label">Nama Penghargaan</label>
              <input type="text" name="nama_penghargaan" class="form-control" placeholder="Contoh: Satyalancana Karya Satya X Tahun" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Nomor SK</label>
              <input type="text" name="nomor_sk" class="form-control" placeholder="Masukkan nomor SK penghargaan" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Tanggal Perolehan</label>
              <input type="date" name="tanggal_perolehan" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Lingkup</label>
              <select name="lingkup" class="form-select" required>
                <option value="" selected>-- Pilih Lingkup --</option>
                <option>Lokal</option>
                <option>Nasional</option>
                <option>Internasional</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Negara</label>
              <input type="text" name="negara" class="form-control" placeholder="Contoh: Indonesia" required>
            </div>
            <div class="col-12">
              <label class="form-label">Instansi Pemberi</label>
              <input type="text" name="instansi_pemberi" class="form-control" placeholder="Contoh: Presiden Republik Indonesia" required>
            </div>
            <div class="col-12"><hr class="divider-light"></div>
            <div class="col-12">
              <label class="form-label">Jenis Dokumen</label>
              <select name="jenis_dokumen" class="form-select" required>
                <option value="" selected>-- Pilih Salah Satu --</option>
                <option>Transkrip</option>
                <option>Surat Tugas</option>
                <option>SK</option>
                <option>Sertifikat</option>
                <option>Penyetaraan Ijazah</option>
                <option>Laporan Kegiatan</option>
                <option>Ijazah</option>
                <option>Buku / Bahan Ajar</option>
              </select>
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
            <div class="col-12">
              <div class="row g-2">
                <div class="col-md-4">
                  <label class="form-label-sm mb-1">Nama Dokumen</label>
                  <input type="text" name="nama_dokumen" class="form-control form-control-sm" placeholder="Nama Dokumen" required>
                </div>
                <div class="col-md-4">
                  <label class="form-label-sm mb-1">Nomor</label>
                  <input type="text" name="nomor_dokumen" class="form-control form-control-sm" placeholder="Nomor Dokumen (Jika Ada)">
                </div>
                <div class="col-md-4">
                  <label class="form-label-sm mb-1">Tautan</label>
                  <input type="url" name="tautan" class="form-control form-control-sm" placeholder="https://... (Jika Ada)">
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-success">Simpan</button>
      </div>
    </div>
  </div>
</div>