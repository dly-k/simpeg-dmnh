{{-- CONTOH: detail-kerjasama.blade.php dengan data terisi lengkap --}}

{{-- Modal Detail Kerjasama --}}
<div class="modal fade" id="modalDetailKerjasama" tabindex="-1" aria-labelledby="modalDetailKerjasamaLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailKerjasamaLabel"><i class="fas fa-info-circle"></i> Detail Kerjasama</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="detail-grid-container">
          <div class="detail-item full-width-detail"><small>Judul</small><p>Pengembangan Model Ekowisata Berbasis Masyarakat di Kawasan Hutan Lindung Gunung Halimun Salak</p></div>
          <div class="detail-item"><small>Mitra/Instansi</small><p>Balai Taman Nasional Gunung Halimun Salak</p></div>
          <div class="detail-item"><small>Nomor Surat</small><p>112/BTN-GHS/VIII/2024 & 25/DEK-FAHUTAN/SPK/VIII/2024</p></div>
          <div class="detail-item"><small>Tgl. Dokumen</small><p>15 Agustus 2024</p></div>
          <div class="detail-item"><small>Departemen Penanggung Jawab</small><p>Konservasi Sumberdaya Hutan</p></div>
          <div class="detail-item"><small>TMT</small><p>20 Agustus 2024</p></div>
          <div class="detail-item"><small>TST</small><p>20 Agustus 2025</p></div>
          
          <div class="detail-item full-width-detail">
              <small>Ketua Tim</small>
              <ul id="detail_ketua_list" class="list-unstyled mb-0 ps-2">
                  <li>Dr. Ir. Rina Puspitasari, M.Si. - Konservasi Sumberdaya Hutan</li>
              </ul>
          </div>
          <div class="detail-item full-width-detail">
              <small>Anggota Tim</small>
              <ul id="detail_anggota_list" class="list-unstyled mb-0 ps-2">
                  <li>Prof. Dr. Bambang Yudoyono, M.Hut. - Manajemen Hutan</li>
                  <li>Siti Fatimah, S.Hut., M.Sc. - Konservasi Sumberdaya Hutan</li>
                  <li>Agus Setiawan, S.T., M.T. - Teknologi Hasil Hutan</li>
              </ul>
          </div>

          <div class="detail-item"><small>Lokasi</small><p>Bogor, Jawa Barat</p></div>
          <div class="detail-item"><small>Besaran Dana</small><p>Rp 150.000.000</p></div>
          <div class="detail-item"><small>Jenis Kerjasama</small><p>SPK (Surat Perjanjian Kerjasama)</p></div>
          <div class="detail-item"><small>Jenis Usulan</small><p>Baru</p></div>
        </div>

        {{-- Ubah bagian ini di file detail-kerjasama.blade.php --}}
        <div class="file-actions-container">
            <h6 class="file-actions-title">File Terlampir</h6>
            <div class="file-actions-buttons">
                <a id="btn_lihat_dokumen" href="#" target="_blank" class="btn btn-primary">
                    <i class="fas fa-file-alt me-2"></i>Lihat Dokumen
                </a>
                <a id="btn_lihat_laporan" href="#" target="_blank" class="btn btn-info">
                    <i class="fas fa-file-invoice me-2"></i>Lihat Laporan
                </a>
            </div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>