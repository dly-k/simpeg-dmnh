{{-- Modal Detail Pelatihan --}}
<div class="modal fade" id="modalDetailPelatihan" tabindex="-1" aria-labelledby="modalDetailPelatihanLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailPelatihanLabel">
          <i class="fas fa-info-circle"></i>
          <span>Detail Pelatihan</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
        <div class="detail-grid-container">
          <div class="detail-item">
            <small>Nama Pelatihan</small>
            <p id="detail_pelatihan_nama">-</p>
          </div>
          <div class="detail-item">
            <small>Posisi Pelatihan</small>
            <p id="detail_pelatihan_posisi">-</p>
          </div>
          <div class="detail-item">
            <small>Kota/Kabupaten</small>
            <p id="detail_pelatihan_kota">-</p>
          </div>
          <div class="detail-item">
            <small>Lokasi</small>
            <p id="detail_pelatihan_lokasi">-</p>
          </div>
          <div class="detail-item">
            <small>Penyelenggara</small>
            <p id="detail_pelatihan_penyelenggara">-</p>
          </div>
          <div class="detail-item">
            <small>Jenis Diklat</small>
            <p id="detail_pelatihan_jenis_diklat">-</p>
          </div>
          <div class="detail-item">
            <small>Tanggal Mulai</small>
            <p id="detail_pelatihan_tgl_mulai">-</p>
          </div>
          <div class="detail-item">
            <small>Tanggal Selesai</small>
            <p id="detail_pelatihan_tgl_selesai">-</p>
          </div>
          <div class="detail-item">
            <small>Lingkup</small>
            <p id="detail_pelatihan_lingkup">-</p>
          </div>
          <div class="detail-item">
            <small>Jumlah Jam</small>
            <p id="detail_pelatihan_jam">-</p>
          </div>
          <div class="detail-item">
            <small>Jumlah Hari</small>
            <p id="detail_pelatihan_hari">-</p>
          </div>
          <div class="detail-item">
            <small>Struktural</small>
            <p id="detail_pelatihan_struktural">-</p>
          </div>
          <div class="detail-item">
            <small>Sertifikasi</small>
            <p id="detail_pelatihan_sertifikasi">-</p>
          </div>
        </div>

        <h6 class="mt-4">Dokumen</h6>
        <div class="document-viewer-container">
          <embed 
            id="detail_pelatihan_document_viewer" 
            src="" 
            type="application/pdf" 
            width="100%" 
            height="600px" 
          />
        </div>
      </div>
      
      <div class="modal-footer justify-content-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
      
    </div>
  </div>
</div>