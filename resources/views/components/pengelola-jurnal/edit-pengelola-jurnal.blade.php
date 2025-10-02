<div class="modal fade" id="editPengelolaJurnalModal" tabindex="-1" aria-labelledby="modalEditPengelolaJurnalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form id="editPengelolaJurnalForm" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header bg-warning text-dark">
          <h5 class="modal-title" id="modalEditPengelolaJurnalTitle"><i class="fas fa-edit me-2"></i> Edit Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="editErrorMessages" class="alert alert-danger" style="display: none;"></div>
          <div class="row g-3">
            <div class="col-12">
              <label for="edit_nama" class="form-label">Nama *</label>
              <select name="nama" id="edit_nama" class="form-select">
                <option value="">-- Pilih Nama Pegawai --</option>
                {{-- Loop data pegawai dari controller --}}
                @foreach ($pegawais as $pegawai)
                  <option value="{{ $pegawai->id }}">{{ $pegawai->nama_lengkap }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12">
              <label for="edit_kegiatan" class="form-label">Kegiatan *</label>
              <select name="kegiatan" id="edit_kegiatan" class="form-select">
                  <option value="">-- Pilih Kegiatan --</option>
                  <option value="Berperan serta aktif dalam pengelolaan jurnal ilmiah (per tahun): Editor/ dewan penyunting/ dewan redaksi jurnal ilmiah nasional">Berperan serta aktif dalam pengelolaan jurnal ilmiah (Nasional)</option>
                  <option value="Berperan serta aktif dalam pengelolaan jurnal ilmiah (per tahun): Editor/ dewan penyunting/ dewan redaksi jurnal ilmiah internasional">Berperan serta aktif dalam pengelolaan jurnal ilmiah (Internasional)</option>
              </select>
            </div>
            <div class="col-12"><label for="edit_media_publikasi" class="form-label">Media Publikasi *</label><input type="text" name="media_publikasi" id="edit_media_publikasi" class="form-control"></div>
            <div class="col-12"><label for="edit_peran" class="form-label">Peran *</label><input type="text" name="peran" id="edit_peran" class="form-control"></div>
            <div class="col-md-6"><label for="edit_no_sk" class="form-label">Nomor SK Penugasan *</label><input type="text" name="no_sk" id="edit_no_sk" class="form-control"></div>
            <div class="col-md-3"><label for="edit_tanggal_mulai" class="form-label">Tanggal Mulai *</label><input type="date" name="tanggal_mulai" id="edit_tanggal_mulai" class="form-control"></div>
            <div class="col-md-3"><label for="edit_tanggal_selesai" class="form-label">Tanggal Selesai *</label><input type="date" name="tanggal_selesai" id="edit_tanggal_selesai" class="form-control"></div>
            <div class="col-12"><label for="edit_status" class="form-label">Status *</label><select name="status" id="edit_status" class="form-select"><option value="">-- Pilih Status --</option><option value="Aktif">Aktif</option><option value="Tidak Aktif">Tidak Aktif</option></select></div>
            
            <div class="col-12">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="form-label">Dokumen</label>
                <button type="button" class="btn btn-sm btn-success" id="addEditDokumen"><i class="fas fa-plus"></i> Tambah Dokumen</button>
              </div>
              <div id="editDokumenWrapper"></div>
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