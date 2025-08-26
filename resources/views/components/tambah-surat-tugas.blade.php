{{-- Modal Tambah Data Surat Tugas --}}
<div class="modal-backdrop" id="suratTugasModal">
    <div class="modal-content-wrapper">
        <div class="modal-header-custom">
            <h5 id="modalTitle"><i class="fas fa-plus-circle"></i> Tambah Surat Tugas</h5>
        </div>
        <div class="modal-body-custom">
            <form>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Nama Dosen</label>
                        <select class="form-select" required>
                            <option value="" selected>-- Pilih Nama Dosen --</option>
                            <option>Dr. Stone</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Peran</label>
                        <input type="text" class="form-control" placeholder="Masukkan peran (contoh: Narasumber, Pembicara, Moderator)" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Pemohon / Menjadi</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama pemohon atau menjadi" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Mitra / Nama Instansi</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama mitra atau instansi" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No & Tanggal Surat Instansi</label>
                        <input type="text" class="form-control" placeholder="Contoh: 001/INT/2025 - 1 Juni 2025" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No & Tanggal Surat Kadep</label>
                        <input type="text" class="form-control" placeholder="Contoh: 001/INT/2025 - 1 Juni 2025" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Kegiatan</label>
                        <input type="date" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Link Surat Tugas Dekan</label>
                        <input type="text" class="form-control" placeholder="Masukkan link surat tugas dekan" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Lokasi Kegiatan</label>
                        <input type="text" class="form-control" placeholder="Masukkan lokasi kegiatan" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Upload File</label>
                        <div class="upload-area">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Drag & Drop File here<br><small>Ukuran Maksimal 5 MB</small></p>
                            <input type="file" hidden required>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer-custom">
            <button type="button" class="btn btn-secondary" onclick="closeModal('suratTugasModal')">Batal</button>
            <button type="button" class="btn btn-success" id="btnSimpanData">Simpan</button>
        </div>
    </div>
</div>