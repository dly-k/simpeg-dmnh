{{-- Modal Tambah Data Pengabdian --}}
<div class="modal fade" id="pengabdianModal" tabindex="-1" aria-labelledby="pengabdianModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="pengabdianModalLabel">
          <i class="fas fa-plus-circle"></i> Tambah Data Pengabdian
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <form id="pengabdianForm">
          <div class="row">

            {{-- Kolom Kiri --}}
            <div class="col-md-7">
              <div class="row g-3">

                <div class="col-12">
                  <label class="form-label">Kegiatan</label>
                  <input type="text" class="form-control" placeholder="Masukkan kegiatan" required>
                </div>

                <div class="col-12">
                  <label class="form-label">Nama Kegiatan</label>
                  <select class="form-select" required>
                    <option value="" selected>-- Pilih Salah Satu --</option>
                  </select>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Afiliasi Non PT</label>
                  <input type="text" class="form-control" placeholder="Contoh: Dinas Kehutanan">
                </div>

                <div class="col-md-6">
                  <label class="form-label">Jenis Pengabdian</label>
                  <select class="form-select" required>
                    <option value="" selected>-- Pilih Salah Satu --</option>
                  </select>
                </div>

                <div class="col-12">
                  <label class="form-label">Tahun</label>
                  <div class="d-flex gap-2">
                    <input type="number" class="form-control" placeholder="Usulan">
                    <input type="number" class="form-control" placeholder="Kegiatan">
                    <input type="number" class="form-control" placeholder="Pelaksanaan">
                  </div>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Terhitung Mulai Tgl</label>
                  <input type="date" class="form-control">
                </div>

                <div class="col-md-6">
                  <label class="form-label">Terhitung Sampai Tgl</label>
                  <input type="date" class="form-control">
                </div>

                <div class="col-12">
                  <label class="form-label">Lama Kegiatan</label>
                  <input type="text" class="form-control" placeholder="Contoh: 6 Bulan">
                </div>

                <div class="col-12">
                  <label class="form-label">In Kind</label>
                  <input type="text" class="form-control" placeholder="Deskripsi In Kind">
                </div>

                <div class="col-12">
                  <label class="form-label">No SK Penugasan</label>
                  <input type="text" class="form-control" placeholder="Nomor SK">
                </div>

                <div class="col-12">
                  <label class="form-label">Tanggal SK Penugasan</label>
                  <input type="date" class="form-control">
                </div>

                <div class="col-12">
                  <label class="form-label">Litabmas</label>
                  <input type="text" class="form-control" placeholder="Keterangan Litabmas">
                </div>

                <div class="col-12">
                  <label class="form-label">Dana</label>
                  <div class="row g-2">
                    <div class="col-md-4"><input type="number" class="form-control" placeholder="DIKTI"></div>
                    <div class="col-md-4"><input type="number" class="form-control" placeholder="Perguruan Tinggi"></div>
                    <div class="col-md-4"><input type="number" class="form-control" placeholder="Institusi Lain"></div>
                  </div>
                </div>

              </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="col-md-5">
              <div class="d-grid gap-2 mb-3">
                <button type="button" class="btn btn-outline-primary" onclick="addAnggota('dosen')">+ Tambah Dosen</button>
                <div id="dosen-list"></div>

                <button type="button" class="btn btn-outline-primary mt-2" onclick="addAnggota('mahasiswa')">+ Tambah Mahasiswa</button>
                <div id="mahasiswa-list"></div>

                <button type="button" class="btn btn-outline-primary mt-2" onclick="addAnggota('kolaborator')">+ Tambah Kolaborator</button>
                <div id="kolaborator-list"></div>
              </div>

              <hr>

              <div class="mb-3">
                <label class="form-label">Jenis Dokumen</label>
                <select class="form-select" required>
                  <option value="" selected>-- Pilih Salah Satu --</option>
                </select>
              </div>

              <div class="upload-area">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Drag & Drop File here<br><small>Ukuran Maksimal 5 MB</small></p>
                <input type="file" hidden required>
              </div>
            </div>

          </div>
        </form>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-success">Simpan</button>
      </div>

    </div>
  </div>
</div>