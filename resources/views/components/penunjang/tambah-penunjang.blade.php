{{-- Tambah Data Penunjang --}}
  <div class="modal-backdrop" id="penunjangModal">
        <div class="modal-content-wrapper">
            <div class="modal-header-custom">
                <h5 id="modalTitle"><i class="fas fa-plus-circle"></i> Tambah Data Penunjang</h5>
            </div>
            <div class="modal-body-custom">
                <form id="penunjangForm">
                    <div class="row g-3">
                        <div class="col-12"><label class="form-label">Kegiatan</label><input type="text" class="form-control" placeholder="Lorem Ipsum"></div>
                        <div class="col-12"><label class="form-label">Jenis Kegiatan Penunjang Lainnya</label><input type="text" class="form-control" placeholder="Lorem Ipsum"></div>
                        <div class="col-12"><label class="form-label">Lingkup</label><input type="text" class="form-control" placeholder="Lorem Ipsum"></div>
                        <div class="col-12"><label class="form-label">Nama Kegiatan</label><input type="text" class="form-control" placeholder="Lorem Ipsum"></div>
                        <div class="col-12"><label class="form-label">Instansi</label><input type="text" class="form-control" placeholder="Lorem Ipsum"></div>
                        <div class="col-12"><label class="form-label">Nomor SK</label><input type="text" class="form-control" placeholder="Melaksanakan Perkuliahan/Tutorial/Perkuliahan Praktikum & Membimbing...."></div>
                        <div class="col-md-6"><label class="form-label">Terhitung Mulai Tanggal</label><input type="date" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Terhitung Sampai Tanggal</label><input type="date" class="form-control"></div>
                        
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0">Dokumen</label>
                                <button type="button" class="btn btn-sm btn-primary" onclick="addDokumen()">+ Tambah Dokumen</button>
                            </div>
                            <div id="dokumen-list">
                                </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0">Anggota Kegiatan</label>
                                <button type="button" class="btn btn-sm btn-primary" onclick="addAnggota()">+ Tambah Anggota</button>
                            </div>
                            <div id="anggota-list">
                                </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn btn-secondary" onclick="closeModal('penunjangModal')">Batal</button>
                <button type="button" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>