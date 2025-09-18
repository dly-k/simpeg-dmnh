<div class="modal fade" id="penelitianModal" tabindex="-1" aria-labelledby="penelitianModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="penelitianModalLabel"><i class="fas fa-plus-circle"></i> Tambah Data Penelitian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="penelitianForm" action="{{ route('penelitian.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div id="form-method-placeholder"></div> 
          <div class="row g-3">
            <div class="col-12"><label class="form-label">Judul</label><input type="text" class="form-control" name="judul" placeholder="Judul Penelitian" required></div>
            <div class="col-12">
              <label class="form-label">Jenis Karya</label>
              <select class="form-select" name="jenis_karya" required>
                <option value="" selected disabled>-- Pilih Salah Satu --</option>
                <option value="Buku Monograf">Buku Monograf</option>
                <option value="Buku Referensi">Buku Referensi</option>
                <option value="Book Chapter Tingkat Internasional">Book Chapter Tingkat Internasional</option>
                <option value="Jurnal Internasional Bereputasi">Jurnal Internasional Bereputasi</option>
                <option value="Jurnal Nasional Terakreditasi">Jurnal Nasional Terakreditasi</option>
                <option value="Prosiding Internasional Terindeks WoS/Scopus">Prosiding Internasional Terindeks WoS/Scopus</option>
                <option value="Paten Sederhana">Paten Sederhana</option>
              </select>
            </div>
            <div class="col-md-6"><label class="form-label">Volume/Issue</label><input type="text" class="form-control" name="volume" placeholder="Contoh: 12/1"></div>
            <div class="col-md-6"><label class="form-label">Jumlah Halaman</label><input type="number" class="form-control" name="jumlah_halaman" placeholder="Contoh: 10"></div>
            <div class="col-md-6"><label class="form-label">Tanggal Terbit</label><input type="date" class="form-control" name="tanggal_terbit"></div>
            <div class="col-md-6">
              <label class="form-label">Publik</label>
              <select class="form-select" name="publik" required>
                <option value="Ya">Ya</option><option value="Tidak" selected>Tidak</option>
              </select>
            </div>
            <div class="col-md-6"><label class="form-label">ISBN</label><input type="text" class="form-control" name="isbn" placeholder="Masukkan ISBN"></div>
            <div class="col-md-6"><label class="form-label">ISSN</label><input type="text" class="form-control" name="issn" placeholder="Masukkan ISSN"></div>
            <div class="col-md-6"><label class="form-label">DOI</label><input type="text" class="form-control" name="doi" placeholder="Masukkan DOI"></div>
            <div class="col-md-6"><label class="form-label">URL</label><input type="url" class="form-control" name="url" placeholder="https://example.com"></div>
            <div class="col-12">
              <label class="form-label">Dokumen Terkait (PDF/DOC, Max 5MB)</label>
              <input type="file" class="form-control" name="dokumen">
            </div>

            <div class="col-12 mt-4"><h6 class="border-bottom pb-2">Data Penulis</h6></div>
            <div class="col-12"><label class="form-label">Penulis Internal (Pegawai)</label><div id="penulis-ipb-list"></div></div>
            <div class="col-12"><label class="form-label">Penulis Luar</label><div id="penulis-luar-list"></div></div>
            <div class="col-12"><label class="form-label">Penulis Mahasiswa</label><div id="penulis-mahasiswa-list"></div></div>
          </div>
          <div class="modal-footer mt-3">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">Simpan Data</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>