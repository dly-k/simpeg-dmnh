document.addEventListener("DOMContentLoaded", function () {
  
  // ======================================================================
  // BAGIAN 1: AJAX FORM SUBMISSION UNTUK TAMBAH DATA
  // ======================================================================
  const tambahForm = document.getElementById('tambahPengelolaJurnalForm');
  
  // Cek apakah form tambah ada di halaman ini sebelum melanjutkan
  if (tambahForm) {
    const pengelolaJurnalModalElement = document.getElementById('pengelolaJurnalModal');
    const pengelolaJurnalModal = new bootstrap.Modal(pengelolaJurnalModalElement);
    const modalBerhasil = document.getElementById('modalBerhasil');
    const btnSelesai = document.getElementById('btnSelesai');
    const errorMessagesDiv = document.getElementById('tambahErrorMessages');
    const successSound = new Audio('/assets/sounds/Success.mp3'); 

    tambahForm.addEventListener('submit', function (event) {
      event.preventDefault();

      const formData = new FormData(tambahForm);
      const submitButton = tambahForm.querySelector('button[type="submit"]');
      const originalButtonText = submitButton.innerHTML;

      submitButton.disabled = true;
      submitButton.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...`;
      if (errorMessagesDiv) {
        errorMessagesDiv.style.display = 'none';
      }

      fetch(tambahForm.action, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Accept': 'application/json',
        },
        body: formData,
      })
      .then(response => response.json())
      .then(data => {
        if (data.errors) {
          let errorHtml = '<ul>';
          for (const key in data.errors) {
              errorHtml += `<li>${data.errors[key][0]}</li>`;
          }
          errorHtml += '</ul>';
          if (errorMessagesDiv) {
            errorMessagesDiv.innerHTML = errorHtml;
            errorMessagesDiv.style.display = 'block';
          }
        } else if(data.success) {
          pengelolaJurnalModal.hide();
          tambahForm.reset();
          if (modalBerhasil) {
            modalBerhasil.classList.add('show');
          }
          successSound.play();
          setTimeout(() => {
            if (modalBerhasil) {
              modalBerhasil.classList.remove('show');
            }
            window.location.reload(); 
          }, 1000); // 1000 milidetik = 1 detik
          
        } else {
          if (errorMessagesDiv) {
            errorMessagesDiv.innerHTML = 'Terjadi kesalahan tidak terduga.';
            errorMessagesDiv.style.display = 'block';
          }
        }
      })
      .catch(error => {
        console.error('Fetch Error:', error);
        if (errorMessagesDiv) {
          errorMessagesDiv.innerHTML = 'Gagal terhubung ke server. Silakan coba lagi.';
          errorMessagesDiv.style.display = 'block';
        }
      })
      .finally(() => {
        submitButton.disabled = false;
        submitButton.innerHTML = originalButtonText;
      });
    });

    if (btnSelesai) {
      btnSelesai.addEventListener('click', function() {
          if (modalBerhasil) {
            modalBerhasil.classList.remove('show');
          }
          window.location.reload(); 
      });
    }
  }


  // ======================================================================
  // BAGIAN 2: FUNGSI TAMBAH/HAPUS DOKUMEN DINAMIS
  // ======================================================================
  let dokumenIndex = 1; 
  const addDokumenButton = document.getElementById("addDokumen");
  const dokumenWrapper = document.getElementById("dokumenWrapper");

  if (addDokumenButton && dokumenWrapper) {
    addDokumenButton.addEventListener("click", function () {
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
            <input type="file" name="dokumen[${dokumenIndex}][file]" class="form-control file-input" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.txt">
          </div>
        </div>
      `;
      dokumenWrapper.appendChild(newItem);
      dokumenIndex++;
    });

    // Event delegation untuk tombol hapus dokumen
    dokumenWrapper.addEventListener("click", function (e) {
      if (e.target && e.target.classList.contains("removeDokumen")) {
        e.target.closest(".dokumen-item").remove();
      }
    });
  }

  // Logika untuk tambah/hapus dokumen di modal EDIT (jika ada)
  const addEditDokumenButton = document.getElementById('addEditDokumen');
  const editDokumenWrapper = document.getElementById('editDokumenWrapper');

  if (addEditDokumenButton && editDokumenWrapper) {
    addEditDokumenButton.addEventListener('click', function () {
      let index = editDokumenWrapper.querySelectorAll('.dokumen-item').length;
      let item = document.createElement('div');
      item.classList.add('dokumen-item', 'border', 'rounded', 'p-3', 'mb-3', 'position-relative');
      item.innerHTML = `
        <button type="button" class="btn-close position-absolute top-0 end-0 m-2 removeDokumen" aria-label="Close"></button>
        <div class="row g-2">
          <div class="col-12"><label class="form-label">Jenis Dokumen</label><select name="dokumen[${index}][jenis]" class="form-select"><option value="" disabled selected>-- Pilih --</option><option value="SK">SK</option><option value="Sertifikat">Sertifikat</option></select></div>
          <div class="col-md-4"><label class="form-label">Nama Dokumen</label><input type="text" name="dokumen[${index}][nama]" class="form-control" placeholder="Nama Dokumen"></div>
          <div class="col-md-4"><label class="form-label">Nomor</label><input type="text" name="dokumen[${index}][nomor]" class="form-control" placeholder="Nomor"></div>
          <div class="col-md-4"><label class="form-label">Tautan</label><input type="url" name="dokumen[${index}][tautan]" class="form-control" placeholder="https://..."></div>
          <div class="col-12"><label class="form-label">File <small class="text-muted">(Maks. 5MB)</small></label><input type="file" name="dokumen[${index}][file]" class="form-control"></div>
        </div>
      `;
      editDokumenWrapper.appendChild(item);
    });

    editDokumenWrapper.addEventListener("click", function (e) {
      if (e.target && e.target.classList.contains("removeDokumen")) {
        e.target.closest('.dokumen-item').remove();
      }
    });
  }


  // ======================================================================
  // BAGIAN 3: TAMPIL DATA KE MODAL DETAIL
  // ======================================================================
  const detailButtons = document.querySelectorAll(".btn-detail");
  detailButtons.forEach(btn => {
    btn.addEventListener("click", function () {
      document.getElementById("detail-nama").textContent = this.dataset.nama || "-";
      document.getElementById("detail-kegiatan").textContent = this.dataset.kegiatan || "-";
      document.getElementById("detail-media").textContent = this.dataset.media || "-";
      document.getElementById("detail-peran").textContent = this.dataset.peran || "-";
      document.getElementById("detail-no-sk").textContent = this.dataset.noSk || "-";
      document.getElementById("detail-tgl-mulai").textContent = this.dataset.tglMulai || "-";
      document.getElementById("detail-tgl-selesai").textContent = this.dataset.tglSelesai || "-";
      document.getElementById("detail-status").textContent = this.dataset.status || "-";

      const doc1Link = document.getElementById("detail-doc1");
      const noDataDoc1 = document.getElementById("nodata-doc1");
      if (this.dataset.doc1 && doc1Link && noDataDoc1) {
        doc1Link.href = this.dataset.doc1;
        doc1Link.style.display = "inline-block";
        noDataDoc1.style.display = "none";
      } else if(doc1Link && noDataDoc1) {
        doc1Link.style.display = "none";
        noDataDoc1.style.display = "inline";
      }

      const doc2Link = document.getElementById("detail-doc2");
      const noDataDoc2 = document.getElementById("nodata-doc2");
      if (this.dataset.doc2 && doc2Link && noDataDoc2) {
        doc2Link.href = this.dataset.doc2;
        doc2Link.style.display = "inline-block";
        noDataDoc2.style.display = "none";
      } else if (doc2Link && noDataDoc2) {
        doc2Link.style.display = "none";
        noDataDoc2.style.display = "inline";
      }
    });
  });


  // ======================================================================
  // BAGIAN 4: PENINGKATAN UX UNTUK INPUT DATE
  // ======================================================================
  document.querySelectorAll('input[type="date"]').forEach((el) => {
    el.style.cursor = "pointer";
    el.addEventListener("click", function () {
      if (this.showPicker) {
        this.showPicker();
      }
    });
  });

});