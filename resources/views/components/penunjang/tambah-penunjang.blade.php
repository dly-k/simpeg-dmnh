{{-- Modal Tambah Data Penunjang --}}
<div class="modal fade" id="penunjangModal" tabindex="-1" aria-labelledby="penunjangModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="penunjangModalLabel"><i class="fas fa-plus-circle"></i> Tambah Data Penunjang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="penunjangForm" enctype="multipart/form-data" novalidate>
          @csrf
          <input type="hidden" id="form-method" name="_method" value="POST">
          <input type="hidden" id="form-edit-id">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label">Kegiatan</label>
              <select name="kegiatan" class="form-select form-select-sm select2-kegiatan" required>
                <option selected disabled value="">-- Pilih Kegiatan --</option>
                <option>Mewakili Perguruan Tinggi/Lembaga Pemerintah duduk dalam Panitia Antar Lembaga</option>
                <option>Menjadi Reviewer: Proposal Penelitian/Pengembangan Institusi</option>
                <option>Menjadi Reviewer: Majalah/Jurnal/Konferensi Ilmiah</option>
                <option>Menjadi Reviewer: Buku</option>
                <option>Menjadi anggota panitia/badan pada lembaga pemerintah: Panitia Pusat, sebagai Ketua/Wakil Ketua</option>
                <option>Menjadi anggota panitia/badan pada lembaga pemerintah: Panitia Pusat, sebagai Anggota</option>
                <option>Menjadi anggota panitia/badan pada lembaga pemerintah: Panitia Daerah, sebagai Ketua/Wakil Ketua</option>
                <option>Menjadi anggota panitia/badan pada lembaga pemerintah: Panitia Daerah, sebagai Anggota</option>
                <option>Menjadi anggota delegasi Nasional ke pertemuan Internasional: Sebagai Anggota Delegasi</option>
                <option>Menjadi anggota delegasi Nasional ke pertemuan Internasional: Sebagai Ketua Delegasi</option>
                <option>Ketua merangkap anggota dalam tim perencana kemitraan program studi dengan mitra kelas dunia</option>
                <option>Wakil Ketua merangkap anggota dalam tim perencana kemitraan program studi dengan mitra kelas dunia</option>
                <option>Sekretaris merangkap anggota dalam tim perencana kemitraan program studi dengan mitra kelas dunia</option>
                <option>Anggota dalam tim perencana kemitraan program studi dengan mitra kelas dunia</option>
                <option>Ketua merangkap anggota dalam tim peningkatan mutu program studi untuk meraih akreditasi tingkat internasional</option>
                <option>Wakil Ketua merangkap anggota dalam tim peningkatan mutu program studi untuk meraih akreditasi tingkat internasional</option>
                <option>Sekretaris merangkap anggota dalam tim peningkatan mutu program studi untuk meraih akreditasi tingkat internasional</option>
                <option>Anggota dalam tim peningkatan mutu program studi untuk meraih akreditasi tingkat internasional</option>
                <option>Menjadi Ketua atau Wakil Ketua dalam panitia/badan di perguruan tinggi yang merangkap sebagai anggota (dihitung per tahun)</option>
                <option>Menjadi Anggota dalam panitia/badan di perguruan tinggi (dihitung per tahun)</option>
                <option>Keanggotaan dalam tim penilai jabatan akademik dosen (tiap semester)</option>
                <option>Berperan serta aktif dalam pertemuan ilmiah tingkat internasional, nasional, atau regional sebagai Ketua (per kegiatan)</option>
                <option>Berperan serta aktif dalam pertemuan ilmiah tingkat internasional, nasional, atau regional sebagai Anggota atau Peserta (per kegiatan)</option>
                <option>Berperan serta aktif dalam pertemuan ilmiah di lingkungan perguruan tinggi sebagai Ketua (per kegiatan)</option>
                <option>Berperan serta aktif dalam pertemuan ilmiah di lingkungan perguruan tinggi sebagai Anggota atau Peserta (per kegiatan)</option>
              </select>
            </div>

            <div class="col-12">
              <label class="form-label">Jenis Kegiatan Penunjang Lainnya</label>
              <select name="jenis_kegiatan" class="form-select" required>
                <option selected disabled value="">-- Pilih Jenis Kegiatan --</option>
                <option>Panitia/badan pada Perguruan Tinggi</option>
                <option>Panitia/badan pada Lembaga Pemerintah</option>
                <option>Delegasi Nasional ke Pertemuan Internasional</option>
                <option>Panitia pada Pertemuan Ilmiah</option>
                <option>Tim Penilai Jabatan Akademik Dosen</option>
                <option>Panitia Lainnya</option>
                <option>Sebagai Anggota</option>
              </select>
            </div>

            <div class="col-12">
              <label class="form-label">Lingkup</label>
              <select name="lingkup" class="form-select" required>
                <option selected disabled value="">-- Pilih Lingkup --</option>
                <option>Internasional</option>
                <option>Lokal</option>
                <option>Nasional</option>
              </select>
            </div>

            <div class="col-12"><label class="form-label">Nama Kegiatan</label><input type="text" name="nama_kegiatan" class="form-control" placeholder="Masukkan Nama Kegiatan" required></div>
            <div class="col-12"><label class="form-label">Instansi</label><input type="text" name="instansi" class="form-control" placeholder="Masukkan Nama Instansi" required></div>
            <div class="col-12"><label class="form-label">Nomor SK</label><input type="text" name="nomor_sk" class="form-control" placeholder="Masukkan Nomor SK" required></div>
            <div class="col-md-6"><label class="form-label">Terhitung Mulai Tanggal</label><input type="date" name="tmt_mulai" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Terhitung Sampai Tanggal</label><input type="date" name="tmt_selesai" class="form-control" required></div>

            <div class="col-12">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="form-label mb-0">Dokumen</label>
                <button type="button" class="btn btn-sm btn-success" onclick="addDokumen()">+ Tambah Dokumen</button>
              </div>
              <div id="dokumen-list"></div>
            </div>
            
            <div class="col-12">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="form-label mb-0">Anggota Kegiatan</label>
                <button type="button" class="btn btn-sm btn-success" onclick="addAnggota()">+ Tambah Anggota</button>
              </div>
              <div id="anggota-list"></div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-success" id="simpanPenunjangBtn">Simpan</button>
      </div>
    </div>
  </div>
</div>