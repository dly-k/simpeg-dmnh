{{-- Modal Tambah Data Pengabdian --}}
<div class="modal fade" id="pengabdianModal" tabindex="-1" aria-labelledby="pengabdianModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="pengabdianModalLabel">
          <i class="fas fa-plus-circle"></i> Tambah Data Pengabdian
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="pengabdianForm" enctype="multipart/form-data" novalidate>
          @csrf
          <input type="hidden" id="form-method" name="_method" value="POST">
          <input type="hidden" id="form-edit-id" value="">

          <div class="row g-3">
            <div class="col-12">
              <label class="form-label">Kegiatan</label>
              <select name="kegiatan" class="form-select" required>
                <option value="" selected disabled>-- Pilih Kegiatan --</option>
                <option>Membuat atau menulis karya pengabdian kepada masyarakat yang tidak dipublikasikan (per karya)</option>
                <option>Memberikan pelayanan kepada masyarakat: Menjabat sebagai Pengurus Organisasi Sosial Kemasyarakatan</option>
                <option>Memberikan pelayanan kepada masyarakat: Berdasarkan penugasan dari lembaga perguruan tinggi</option>
                <option>Memberikan pelayanan kepada masyarakat: Berdasarkan fungsi atau jabatan</option>
                <option>Memberikan pelayanan kepada masyarakat: Berdasarkan bidang keahlian</option>
                <option>Melaksanakan pengembangan hasil pendidikan dan penelitian untuk masyarakat/industri</option>
                <option>Melaksanakan pembimbingan & pengembangan hasil penelitian: Masyarakat terbatas (industri/perusahaan tertentu)</option>
                <option>Melaksanakan pembimbingan & pengembangan hasil penelitian: Masyarakat luas tingkat provinsi (industri/daerah/BUMD/UMKM)</option>
                <option>Melaksanakan pembimbingan & pengembangan hasil penelitian: Tingkat nasional (industri/perusahaan nasional/BUMN)</option>
                <option>Melaksanakan pembimbingan & pengembangan hasil penelitian: Tingkat internasional (industri/perusahaan multinasional)</option>
                <option>Hasil kegiatan pengabdian yang dipublikasikan dalam jurnal/berkala pengabdian (teknologi tepat guna, per karya)</option>
              </select>
            </div>

            <div class="col-12">
              <label class="form-label">Nama Kegiatan</label>
              <input type="text" name="nama_kegiatan" class="form-control" placeholder="Masukkan Nama Kegiatan" required>
            </div>

            {{-- Afiliasi - Lokasi - Jenis Pengabdian --}}
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label">Afiliasi Non PT</label>
                <input type="text" name="afiliasi_non_pt" class="form-control" placeholder="Contoh: Dinas Kehutanan">
              </div>
              <div class="col-md-4">
                <label class="form-label">Lokasi Kegiatan</label>
                <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Desa Cibanteng" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Jenis Pengabdian</label>
                <select name="jenis_pengabdian" class="form-select" required>
                  <option value="" selected disabled>-- Pilih Jenis --</option>
                  <option>Biomedik</option>
                  <option>Hibah HI-LINK</option>
                  <option>Ipteks</option>
                  <option>Ipteks Bagi Inovasi Kreativitas Kampus</option>
                  <option>Ipteks Bagi Kewirausahaan</option>
                  <option>Iptek Bagi Masyarakat</option>
                  <option>Iptek Bagi Produk Ekspor</option>
                  <option>Iptek Bagi Wilayah</option>
                  <option>Iptek Bagi Wilayah Antara PT-CSR/PT-PEMDA-CSR</option>
                  <option>Kerjasama Luar Negeri dan Publikasi Internasional</option>
                  <option>KKN Pembelajaran Pemberdayaan Masyarakat</option>
                  <option>Mobil Listrik Nasional</option>
                  <option>MP3EI</option>
                  <option>Pendidikan Magister Doktor Sarjana Unggul</option>
                  <option>Penelitian Disertasi Doktor</option>
                  <option>Penelitian Dosen Pemula</option>
                  <option>Penelitian Fundamental</option>
                  <option>Penelitian Hibah Bersaing</option>
                  <option>Penelitian Kerjasama Antar Perguruan Tinggi</option>
                  <option>Penelitian Kompetensi</option>
                  <option>Penelitian Srategis Nasional</option>
                  <option>Penelitian Tim Pascasarjana</option>
                  <option>Penelitian Unggulan Perguruan Tinggi</option>
                  <option>Penelitian Unggulan Strategis Nasional</option>
                  <option>Riset Andalan Perguruan Tinggi dan Industri</option>
                </select>
              </div>
            </div>

            {{-- Tahun --}}
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label">Tahun Usulan</label>
                <input type="number" name="tahun_usulan" class="form-control" placeholder="Usulan" min="1900" max="2100">
              </div>
              <div class="col-md-4">
                <label class="form-label">Tahun Kegiatan</label>
                <input type="number" name="tahun_kegiatan" class="form-control" placeholder="Kegiatan" min="1900" max="2100">
              </div>
              <div class="col-md-4">
                <label class="form-label">Tahun Pelaksanaan</label>
                <input type="number" name="tahun_pelaksanaan" class="form-control" placeholder="Pelaksanaan" min="1900" max="2100">
              </div>
            </div>

            <div class="col-md-6">
              <label class="form-label">Terhitung Mulai Tgl</label>
              <input type="date" name="tgl_mulai" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Terhitung Sampai Tgl</label>
              <input type="date" name="tgl_selesai" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Lama Kegiatan</label>
              <input type="text" name="lama_kegiatan" class="form-control" placeholder="Contoh: 6 Bulan">
            </div>
            <div class="col-md-6">
              <label class="form-label">In Kind</label>
              <input type="text" name="in_kind" class="form-control" placeholder="Deskripsi In Kind">
            </div>

            <div class="col-md-6">
              <label class="form-label">No SK Penugasan</label>
              <input type="text" name="no_sk_penugasan" class="form-control" placeholder="Nomor SK">
            </div>
            <div class="col-md-6">
              <label class="form-label">Tanggal SK Penugasan</label>
              <input type="date" name="tgl_sk_penugasan" class="form-control">
            </div>

            <div class="col-12">
              <label class="form-label">Litabmas</label>
              <input type="text" name="litabmas" class="form-control" placeholder="Keterangan Litabmas">
            </div>

            {{-- Dana --}}
            <div class="col-12">
              <label class="form-label">Dana</label>
              <div class="row g-2">
                <div class="col-md-4">
                  <input type="number" name="dana_dikti" class="form-control" placeholder="DIKTI">
                </div>
                <div class="col-md-4">
                  <input type="number" name="dana_pt" class="form-control" placeholder="Perguruan Tinggi">
                </div>
                <div class="col-md-4">
                  <input type="number" name="dana_institusi_lain" class="form-control" placeholder="Institusi Lain">
                </div>
              </div>
            </div>
          </div>

          <hr class="my-4">

          {{-- Anggota --}}
          <div class="mb-3">
            <label class="form-label"><strong>Anggota</strong></label>
            <div class="d-grid gap-2">
              <button type="button" class="btn btn-outline-success" onclick="addAnggota('dosen')">+ Tambah Dosen</button>
              <div id="dosen-list"></div>

              <button type="button" class="btn btn-outline-success" onclick="addAnggota('mahasiswa')">+ Tambah Mahasiswa</button>
              <div id="mahasiswa-list"></div>

              <button type="button" class="btn btn-outline-success" onclick="addAnggota('kolaborator')">+ Tambah Kolaborator</button>
              <div id="kolaborator-list"></div>
            </div>
          </div>

          <hr class="my-4">

          {{-- Dokumen --}}
          <div class="mb-3">
            <label class="form-label"><strong>Jenis Dokumen</strong></label>
            <select name="jenis_dokumen" class="form-select" required>
              <option value="" selected disabled>-- Pilih Jenis Dokumen --</option>
              <option>Transkip</option>
              <option>Surat Tugas</option>
              <option>SK</option>
              <option>Sertifikat</option>
              <option>Penyetaraan Ijazah</option>
              <option>Laporan Kegiatan</option>
              <option>Ijazah</option>
              <option>Buku/Bahan Ajar</option>
            </select>
          </div>

          <div class="upload-area text-center p-3 border border-2 rounded">
            <i class="fas fa-cloud-upload-alt"></i>
            <p class="mb-1">Drag & Drop File di sini</p>
            <small class="text-muted">Ukuran Maksimal 5 MB</small>
            <input type="file" name="dokumen_file" hidden required>
          </div>

        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-success" id="simpanPengabdianBtn">Simpan</button>
      </div>

    </div>
  </div>
</div>