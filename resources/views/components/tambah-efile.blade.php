<div class="modal fade" id="tambahDokumenModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Dokumen E-File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <form id="formTambahEfile" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kategori" class="form-label small fw-bold">Kategori Dokumen <span class="text-danger">*</span></label>
                        <select id="kategori" name="kategori" class="form-select form-select-sm" required>
                            <option value="" selected disabled>-- Pilih Kategori --</option>
                            <option value="biodata">Biodata</option>
                            <option value="pendidikan">Pendidikan</option>
                            <option value="jf">Jabatan Fungsional</option>
                            <option value="sk">Surat Keputusan Kepangkatan</option>
                            <option value="sp">Surat Penting</option>
                            <option value="lain">Lain-lain</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="keaslian" class="form-label small fw-bold">Keaslian Dokumen <span class="text-danger">*</span></label>
                        <select id="keaslian" name="keaslian" class="form-select form-select-sm" required>
                            <option value="" selected disabled>-- Pilih Salah Satu --</option>
                            <option value="Asli">Asli</option>
                            <option value="Legalisir">Legalisir</option>
                            <option value="Scan">Scan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Dokumen <span class="text-danger">*</span></label>
                        <input type="text" name="nama_dokumen" class="form-control form-control-sm" placeholder="Contoh: Ijazah S3" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Metode Dokumen <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metode" id="metodeFile" value="file" checked onclick="switchInput('file')">
                                <label class="form-check-label small" for="metodeFile">Unggah PDF</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metode" id="metodeLink" value="link" onclick="switchInput('link')">
                                <label class="form-check-label small" for="metodeLink">Tautan (Link)</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_dokumen" class="form-label small fw-bold">Tanggal Dokumen <span class="text-danger">*</span></label>
                        {{-- Pastikan ada atribut name="tanggal_dokumen" --}}
                        <input type="date" id="tanggal_dokumen" name="tanggal_dokumen" class="form-control form-control-sm" required>
                    </div>

                    <div id="input-file-div" class="mb-3">
                        <label class="form-label small fw-bold">Pilih Dokumen</label>
                        <input type="file" name="dokumen" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png">
                    </div>

                    <div id="input-link-div" class="mb-3" style="display: none;">
                        <label class="form-label small fw-bold">Alamat URL (Google Drive/Cloud)</label>
                        <input type="url" name="link_url" class="form-control form-control-sm" placeholder="https://drive.google.com/...">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-sm px-4">Simpan Ke E-File</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function switchInput(type) {
        document.getElementById('input-file-div').style.display = (type === 'file') ? 'block' : 'none';
        document.getElementById('input-link-div').style.display = (type === 'link') ? 'block' : 'none';
    }
</script>