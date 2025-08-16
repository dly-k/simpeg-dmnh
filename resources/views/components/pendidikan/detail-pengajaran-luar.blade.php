{{-- Modal Detail Pengajaran Luar --}}
<div class="modal fade" id="modalDetailPengajaranLuar" tabindex="-1" aria-labelledby="modalDetailPengajaranLuarLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailPengajaranLuarLabel">
          <i class="fas fa-info-circle"></i>
          <span id="modalTitleTextDetailPengajaranLuar">Detail Pengajaran Luar IPB</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <div class="detail-grid-container">

          <div class="detail-item">
            <small>Nama</small>
            <p id="detail_pluar_nama">-</p>
          </div>

          <div class="detail-item">
            <small>Tahun Semester</small>
            <p id="detail_pluar_tahun_semester">-</p>
          </div>

          <div class="detail-item">
            <small>Universitas</small>
            <p id="detail_pluar_universitas">-</p>
          </div>

          <div class="detail-item">
            <small>Kode Mata Kuliah</small>
            <p id="detail_pluar_kode_mk">-</p>
          </div>

          <div class="detail-item">
            <small>Nama Mata Kuliah</small>
            <p id="detail_pluar_nama_mk">-</p>
          </div>

          <div class="detail-item">
            <small>Program Studi</small>
            <p id="detail_pluar_program_studi">-</p>
          </div>

          <div class="detail-item">
            <small>SKS Perkuliahan</small>
            <p id="detail_pluar_sks_kuliah">-</p>
          </div>

          <div class="detail-item">
            <small>SKS Praktikum</small>
            <p id="detail_pluar_sks_praktikum">-</p>
          </div>

          <div class="detail-item">
            <small>Jenis</small>
            <p id="detail_pluar_jenis">-</p>
          </div>

          <div class="detail-item">
            <small>Kelas Paralel</small>
            <p id="detail_pluar_kelas_paralel">-</p>
          </div>

          <div class="detail-item">
            <small>Jumlah Pertemuan</small>
            <p id="detail_pluar_jumlah_pertemuan">-</p>
          </div>

          <div class="detail-item">
            <small>Insidental</small>
            <p id="detail_pluar_insidental">-</p>
          </div>

          <div class="detail-item">
            <small>Lebih Dari 1 Semester</small>
            <p id="detail_pluar_lebih_satu_semester">-</p>
          </div>

        </div>

        <!-- Dokumen -->
        <h6 class="mt-4">Dokumen</h6>
        <div class="document-viewer-container">
          <embed id="detail_pluar_document_viewer" src="" type="application/pdf" width="100%" height="600px" />
        </div>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer justify-content-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>

    </div>
  </div>
</div>