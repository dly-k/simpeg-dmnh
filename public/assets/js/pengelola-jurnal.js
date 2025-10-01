document.addEventListener("DOMContentLoaded", function () {
  let dokumenIndex = 1; // mulai dari 1 karena [0] sudah ada

  // tombol tambah dokumen
  document.getElementById("addDokumen").addEventListener("click", function () {
    let wrapper = document.getElementById("dokumenWrapper");

    let newItem = document.createElement("div");
    newItem.classList.add("dokumen-item", "border", "rounded", "p-3", "mb-3", "position-relative");

    newItem.innerHTML = `
      <button type="button" class="btn-close position-absolute top-0 end-0 m-2 removeDokumen" aria-label="Close"></button>
      <div class="row g-2">
        <div class="col-12">
          <label class="form-label">Jenis Dokumen</label>
          <select name="dokumen[${dokumenIndex}][jenis]" class="form-select">
            <option value="" disabled selected>-- Pilih Jenis Dokumen --</option>
            <option value="Transkrip">Transkrip</option>
            <option value="Surat Tugas">Surat Tugas</option>
            <option value="SK">SK</option>
            <option value="Sertifikat">Sertifikat</option>
            <option value="Penyetaraan Ijazah">Penyetaraan Ijazah</option>
            <option value="Laporan Kegiatan">Laporan Kegiatan</option>
            <option value="Ijazah">Ijazah</option>
            <option value="Buku / Bahan Ajar">Buku / Bahan Ajar</option>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label">Nama Dokumen</label>
          <input type="text" name="dokumen[${dokumenIndex}][nama]" class="form-control" placeholder="Nama Dokumen">
        </div>
        <div class="col-md-4">
          <label class="form-label">Nomor</label>
          <input type="text" name="dokumen[${dokumenIndex}][nomor]" class="form-control" placeholder="Nomor">
        </div>
        <div class="col-md-4">
          <label class="form-label">Tautan</label>
          <input type="url" name="dokumen[${dokumenIndex}][tautan]" class="form-control" placeholder="https://...">
        </div>
        <div class="col-12">
          <label class="form-label">File <small class="text-muted">(Maksimal Ukuran File 5MB)</small></label>
          <input type="file" name="dokumen[${dokumenIndex}][file]" class="form-control file-input"
            accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.txt">
        </div>
      </div>
    `;

    wrapper.appendChild(newItem);
    dokumenIndex++;
  });

  // hapus dokumen (pakai event delegation)
  document.getElementById("dokumenWrapper").addEventListener("click", function (e) {
    if (e.target.classList.contains("removeDokumen")) {
      e.target.closest(".dokumen-item").remove();
    }
  });
});

  // script untuk tambah dokumen di modal edit
  document.getElementById('addEditDokumen').addEventListener('click', function () {
    let wrapper = document.getElementById('editDokumenWrapper');
    let index = wrapper.querySelectorAll('.dokumen-item').length;

    let item = document.createElement('div');
    item.classList.add('dokumen-item', 'border', 'rounded', 'p-3', 'mb-3', 'position-relative');
    item.innerHTML = `
      <button type="button" class="btn-close position-absolute top-0 end-0 m-2 removeDokumen" aria-label="Close"></button>
      <div class="row g-2">
        <div class="col-12">
          <label class="form-label">Jenis Dokumen</label>
          <select name="dokumen[${index}][jenis]" class="form-select">
            <option value="" disabled selected>-- Pilih Jenis Dokumen --</option>
            <option value="SK">SK</option>
            <option value="Sertifikat">Sertifikat</option>
            <option value="Surat Tugas">Surat Tugas</option>
            <option value="Laporan Kegiatan">Laporan Kegiatan</option>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label">Nama Dokumen</label>
          <input type="text" name="dokumen[${index}][nama]" class="form-control" placeholder="Nama Dokumen">
        </div>
        <div class="col-md-4">
          <label class="form-label">Nomor</label>
          <input type="text" name="dokumen[${index}][nomor]" class="form-control" placeholder="Nomor">
        </div>
        <div class="col-md-4">
          <label class="form-label">Tautan</label>
          <input type="url" name="dokumen[${index}][tautan]" class="form-control" placeholder="https://...">
        </div>
        <div class="col-12">
          <label class="form-label">File <small class="text-muted">(Maksimal Ukuran File 5MB)</small></label>
          <input type="file" name="dokumen[${index}][file]" class="form-control file-input"
            accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.txt">
        </div>
      </div>
    `;

    wrapper.appendChild(item);

    // remove button
    item.querySelector('.removeDokumen').addEventListener('click', function () {
      item.remove();
    });
  });

  // aktifkan removeDokumen di dokumen lama
  document.querySelectorAll('#editDokumenWrapper .removeDokumen').forEach(btn => {
    btn.addEventListener('click', function () {
      btn.closest('.dokumen-item').remove();
    });
  });

// == Peningkatan Datepicker ==
document.querySelectorAll('input[type="date"]').forEach((el) => {
    el.style.cursor = "pointer";
    el.addEventListener("click", function () {
    this.showPicker && this.showPicker();
    });
});


document.addEventListener("DOMContentLoaded", function () {
  const detailButtons = document.querySelectorAll(".btn-detail");

  detailButtons.forEach(btn => {
    btn.addEventListener("click", function () {
      // isi data ke modal
      document.getElementById("detail-nama").textContent = this.dataset.nama || "-";
      document.getElementById("detail-kegiatan").textContent = this.dataset.kegiatan || "-";
      document.getElementById("detail-media").textContent = this.dataset.media || "-";
      document.getElementById("detail-peran").textContent = this.dataset.peran || "-";
      document.getElementById("detail-no-sk").textContent = this.dataset.noSk || "-";
      document.getElementById("detail-tgl-mulai").textContent = this.dataset.tglMulai || "-";
      document.getElementById("detail-tgl-selesai").textContent = this.dataset.tglSelesai || "-";
      document.getElementById("detail-status").textContent = this.dataset.status || "-";

      // dokumen 1
      if (this.dataset.doc1) {
        document.getElementById("detail-doc1").href = this.dataset.doc1;
        document.getElementById("detail-doc1").style.display = "inline-block";
        document.getElementById("nodata-doc1").style.display = "none";
      } else {
        document.getElementById("detail-doc1").style.display = "none";
        document.getElementById("nodata-doc1").style.display = "inline";
      }

      // dokumen 2
      if (this.dataset.doc2) {
        document.getElementById("detail-doc2").href = this.dataset.doc2;
        document.getElementById("detail-doc2").style.display = "inline-block";
        document.getElementById("nodata-doc2").style.display = "none";
      } else {
        document.getElementById("detail-doc2").style.display = "none";
        document.getElementById("nodata-doc2").style.display = "inline";
      }
    });
  });
});