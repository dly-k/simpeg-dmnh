{{-- Tambah Kerjasama --}}
<div class="modal fade" id="kerjasamaModal" tabindex="-1" aria-labelledby="kerjasamaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="kerjasamaModalLabel"><i class="fas fa-plus-circle"></i> Tambah Kerjasama</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="kerjasamaForm">
          <div class="row g-3">
            <div class="col-12"><label class="form-label">Judul</label><input type="text" class="form-control" name="judul" placeholder="Judul Kerjasama"></div>
            <div class="col-12"><label class="form-label">Mitra</label><input type="text" class="form-control" name="mitra" placeholder="Nama Mitra atau Instansi"></div>
            <div class="col-md-6"><label class="form-label">No Dokumen</label><input type="text" class="form-control" name="noDoc" placeholder="Nomor Dokumen"></div>
            <div class="col-md-6"><label class="form-label">Tgl. Dokumen</label><input type="date" name="tglDoc" class="form-control"></div>
            <div class="col-md-6"><label class="form-label">TMT (Tanggal Mulai Efektif)</label><input type="date" class="form-control" name="tmt"></div>
            <div class="col-md-6"><label class="form-label">TST (Tanggal Selesai Efektif)</label><input type="date" class="form-control" name="tst"></div>
            <div class="col-12"><label class="form-label">Departemen/Program Studi</label><select class="form-select" name="departemen"><option selected>-- Pilih Salah Satu --</option><option>Manajemen Hutan</option><option>Konservasi Sumberdaya Hutan</option><option>Teknologi Hasil Hutan</option></select></div>
            <div class="col-12"><label class="form-label">Ketua</label><input type="text" class="form-control" name="ketua" placeholder="Nama Ketua Tim"></div>
            <div class="col-12">
              <label class="form-label">Anggota Tim (jika ada)</label>
              <div id="anggota-list">
                </div>
            </div>
            <div class="col-md-6"><label class="form-label">Lokasi</label><input type="text" name="lokasi" class="form-control" placeholder="Lokasi Kegiatan"></div>
            <div class="col-md-6"><label class="form-label">Besaran Dana</label><input type="number" name="dana" class="form-control" placeholder="Contoh: 10000000"></div>
            <div class="col-12"><label class="form-label">Jenis Kerjasama</label><select class="form-select" name="jenis"><option selected>-- Pilih Salah Satu --</option><option>MoU</option><option>LoA</option><option>SPK</option></select></div>
            <div class="col-12">
              <label class="form-label">Upload File</label>
              <div class="upload-area" id="uploadArea">
                <i class="lni lni-cloud-upload"></i>
                <p>Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small></p>
                <input type="file" hidden>
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