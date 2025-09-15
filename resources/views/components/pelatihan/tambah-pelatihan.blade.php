{{-- Modal Tambah & Edit Pelatihan --}}
<div class="modal fade" id="pelatihanModal" tabindex="-1" aria-labelledby="pelatihanModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="pelatihanModalLabel">
          <i class="fas fa-plus-circle"></i> Tambah Data Pelatihan
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="pelatihanForm" novalidate>
          @csrf
          <input type="hidden" id="pelatihan_id" name="id">

          <div class="row g-3">
            <div class="col-12">
              <label class="form-label">Nama Pegawai</label>
              <select class="form-select" name="pegawai_id" required>
                <option value="" selected disabled>-- Pilih Pegawai --</option>
                @foreach($pegawais as $pegawai)
                  <option value="{{ $pegawai->id }}">{{ $pegawai->nama_lengkap }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-12">
              <label class="form-label">Nama Pelatihan</label>
              <input type="text" class="form-control" name="nama_kegiatan" placeholder="Masukkan nama kegiatan pelatihan" required>
            </div>

            <div class="col-12">
              <label class="form-label">Posisi Pelatihan</label>
              <select class="form-select" id="posisi-pelatihan-select" name="posisi" required>
                <option value="" selected disabled>-- Pilih Posisi --</option>
                <option value="Peserta">Peserta</option>
                <option value="Pembicara">Pembicara</option>
                <option value="Panitia">Panitia</option>
                <option value="Lainnya">Lainnya...</option>
              </select>
              <input type="text" class="form-control mt-2 posisi-lainnya" id="posisi-lainnya-input" name="posisi_lainnya" placeholder="Sebutkan posisi lainnya">
            </div>

            <div class="col-md-6">
              <label class="form-label">Kota/Kabupaten</label>
              <input type="text" class="form-control" name="kota" placeholder="Contoh: Bogor">
            </div>

            <div class="col-md-6">
              <label class="form-label">Lokasi</label>
              <input type="text" class="form-control" name="lokasi" placeholder="Contoh: Kampus IPB Dramaga">
            </div>

            <div class="col-12">
              <label class="form-label">Penyelenggara</label>
              <input type="text" class="form-control" name="penyelenggara" placeholder="Contoh: Fakultas Kehutanan IPB" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Tanggal Mulai</label>
              <input type="date" class="form-control" name="tgl_mulai" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Tanggal Selesai</label>
              <input type="date" class="form-control" name="tgl_selesai" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Jumlah Jam</label>
              <input type="number" class="form-control" name="jumlah_jam" placeholder="Contoh: 8">
            </div>

            <div class="col-md-6">
              <label class="form-label">Jumlah Hari</label>
              <input type="number" class="form-control" name="jumlah_hari" placeholder="Contoh: 3">
            </div>

            <div class="col-md-6">
              <label class="form-label">Jenis Diklat</label>
              <input type="text" class="form-control" name="jenis_diklat" placeholder="Contoh: Teknis, Fungsional">
            </div>

            <div class="col-md-6">
              <label class="form-label">Lingkup</label>
              <input type="text" class="form-control" name="lingkup" placeholder="Contoh: Internal, Nasional, Internasional">
            </div>

            <div class="col-md-6">
              <label class="form-label">Struktural</label>
              <select class="form-select" name="struktural">
                <option value="Tidak" selected>Tidak</option>
                <option value="Ya">Ya</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Sertifikasi</label>
              <select class="form-select" name="sertifikasi">
                <option value="Tidak" selected>Tidak</option>
                <option value="Ya">Ya</option>
              </select>
            </div>

            <div class="col-12"><hr class="divider-light"></div>

            <div class="col-12">
              <label class="form-label">Jenis Dokumen</label>
              <select class="form-select" name="jenis_dokumen" required>
                <option value="" selected disabled>-- Pilih Jenis Dokumen --</option>
                <option>Transkrip</option>
                <option>Surat Tugas</option>
                <option>SK</option>
                <option>Sertifikat</option>
                <option>Penyetaraan Ijazah</option>
                <option>Laporan Kegiatan</option>
                <option>Ijazah</option>
                <option>Buku / Bahan Ajar</option>
              </select>
            </div>

            <div class="col-12">
              <label class="form-label">Unggah Dokumen</label>
              <div class="upload-area">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>
                  Seret & Lepas File di sini<br>
                  <small>Ukuran Maksimal 5 MB</small>
                </p>
                <input type="file" name="dokumen" hidden>
              </div>
              <div id="file-size-feedback" class="invalid-feedback d-block mt-2"></div>
            </div>

            <div class="col-12">
              <div class="row g-2" id="dokumen-info">
                <div class="col-md-4">
                  <label class="form-label">Nama Dokumen</label>
                  <input type="text" class="form-control" name="nama_dokumen" placeholder="Contoh: Sertifikat Pelatihan GIS" required>
                </div>
                <div class="col-md-4">
                  <label class="form-label">Nomor Dokumen</label>
                  <input type="text" class="form-control" name="nomor_dokumen" placeholder="Jika ada">
                </div>
                <div class="col-md-4">
                  <label class="form-label">Tautan Dokumen</label>
                  <input type="url" class="form-control" name="tautan_dokumen" placeholder="Jika ada (Google Drive, dll.)">
                </div>
              </div>
            </div>

          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-success">Simpan</button>
      </div>

    </div>
  </div>
</div>