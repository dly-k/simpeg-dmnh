{{-- Modal Detail Praktisi Dunia Industri --}}
<div class="modal fade" id="detailPraktisiModal" tabindex="-1" aria-labelledby="detailPraktisiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="detailPraktisiModalLabel">
          <i class="fas fa-info-circle"></i>
          <span>Detail Praktisi Dunia Industri</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">

        <div class="detail-grid-container">
          <div class="detail-item">
            <small>Nama Pegawai</small>
            <p id="detail-nama">-</p>
          </div>
          <div class="detail-item">
            <small>Bidang Usaha</small>
            <p id="detail-bidang">-</p>
          </div>
          <div class="detail-item">
            <small>Jenis Pekerjaan</small>
            <p id="detail-jenis">-</p>
          </div>
          <div class="detail-item">
            <small>Jabatan</small>
            <p id="detail-jabatan">-</p>
          </div>
          <div class="detail-item">
            <small>Instansi</small>
            <p id="detail-instansi">-</p>
          </div>
          <div class="detail-item">
            <small>Divisi</small>
            <p id="detail-divisi">-</p>
          </div>
          <div class="detail-item">
            <small>Tanggal Mulai (TMT)</small>
            <p id="detail-mulai">-</p>
          </div>
          <div class="detail-item">
            <small>Tanggal Selesai (TST)</small>
            <p id="detail-selesai">-</p>
          </div>
          <div class="detail-item">
            <small>Area Pekerjaan</small>
            <p id="detail-area">-</p>
          </div>
          <div class="detail-item">
            <small>Kategori Pekerjaan</small>
            <p id="detail-kategori">-</p>
          </div>
          <div class="detail-item detail-item-full">
            <small>Deskripsi Kerja</small>
            <p id="detail-deskripsi">-</p>
          </div>
        </div>

        <h6 class="mt-4">Dokumen Terlampir</h6>
        <div class="detail-grid-container">
          <div class="detail-item">
            <small>Surat IPB</small>
            {{-- Tombol Aksi untuk Dokumen --}}
            <a href="#" id="detail-surat-ipb" class="btn btn-sm btn-success" target="_blank" style="display: none;">Lihat Dokumen</a>
            <p id="nodata-surat-ipb" class="text-muted fst-italic">Tidak ada</p>
          </div>
          <div class="detail-item">
            <small>Surat Instansi</small>
            {{-- Tombol Aksi untuk Dokumen --}}
            <a href="#" id="detail-surat-instansi" class="btn btn-sm btn-success" target="_blank" style="display: none;">Lihat Dokumen</a>
            <p id="nodata-surat-instansi" class="text-muted fst-italic">Tidak ada</p>
          </div>
          <div class="detail-item">
            <small>CV</small>
            {{-- Tombol Aksi untuk Dokumen --}}
            <a href="#" id="detail-cv" class="btn btn-sm btn-success" target="_blank" style="display: none;">Lihat Dokumen</a>
            <p id="nodata-cv" class="text-muted fst-italic">Tidak ada</p>
          </div>
          <div class="detail-item">
            <small>Profil Perusahaan</small>
            {{-- Tombol Aksi untuk Dokumen --}}
            <a href="#" id="detail-profil" class="btn btn-sm btn-success" target="_blank" style="display: none;">Lihat Dokumen</a>
            <p id="nodata-profil" class="text-muted fst-italic">Tidak ada</p>
          </div>
        </div>
      </div>

      <div class="modal-footer justify-content-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>

    </div>
  </div>
</div>