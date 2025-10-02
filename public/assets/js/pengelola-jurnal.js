document.addEventListener("DOMContentLoaded", function () {
  
  // ======================================================================
  // BAGIAN 1: AJAX FORM SUBMISSION UNTUK TAMBAH DATA
  // ======================================================================
  const tambahForm = document.getElementById('tambahPengelolaJurnalForm');
  if (tambahForm) {
    const pengelolaJurnalModalElement = document.getElementById('pengelolaJurnalModal');
    const pengelolaJurnalModal = new bootstrap.Modal(pengelolaJurnalModalElement);
    const modalBerhasil = document.getElementById('modalBerhasil');
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
          }, 1000);
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
  }

  // ======================================================================
  // BAGIAN 2: LOGIKA UNTUK FITUR EDIT DATA
  // ======================================================================
  const editModalElement = document.getElementById('editPengelolaJurnalModal');
  if (editModalElement) {
    const editModal = new bootstrap.Modal(editModalElement);
    const editForm = document.getElementById('editPengelolaJurnalForm');
    const editDokumenWrapper = document.getElementById('editDokumenWrapper');
    const addEditDokumenBtn = document.getElementById('addEditDokumen');
    const editErrorMessages = document.getElementById('editErrorMessages');
    let newDocIndex = 0;

    document.querySelectorAll('.btn-edit').forEach(button => {
      button.addEventListener('click', function() {
        const jurnalId = this.dataset.id;
        const updateUrl = this.dataset.updateUrl;
        const editUrl = `/pengelola-jurnal/${jurnalId}/edit`;

        editForm.action = updateUrl;
        editForm.reset();
        editDokumenWrapper.innerHTML = '';
        newDocIndex = 0;
        if(editErrorMessages) editErrorMessages.style.display = 'none';

        fetch(editUrl)
          .then(response => response.json())
          .then(data => {
            document.getElementById('edit_nama').value = data.pegawai_id;
            document.getElementById('edit_kegiatan').value = data.kegiatan;
            document.getElementById('edit_media_publikasi').value = data.media_publikasi;
            document.getElementById('edit_peran').value = data.peran;
            document.getElementById('edit_no_sk').value = data.no_sk;
            document.getElementById('edit_tanggal_mulai').value = data.tanggal_mulai;
            document.getElementById('edit_tanggal_selesai').value = data.tanggal_selesai;
            document.getElementById('edit_status').value = data.status;

            data.dokumen.forEach((doc, index) => {
              const docItem = createExistingDokumenItem(doc, index);
              editDokumenWrapper.appendChild(docItem);
            });
          })
          .catch(error => {
            console.error('Error fetching data:', error);
            alert('Gagal memuat data untuk diedit.');
          });
      });
    });

    editForm.addEventListener('submit', function(event) {
      event.preventDefault();
      const formData = new FormData(editForm);
      const submitButton = editForm.querySelector('button[type="submit"]');
      const originalButtonText = submitButton.innerHTML;

      submitButton.disabled = true;
      submitButton.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...`;
      if(editErrorMessages) editErrorMessages.style.display = 'none';

      fetch(editForm.action, {
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
              editErrorMessages.innerHTML = errorHtml;
              editErrorMessages.style.display = 'block';
          } else if (data.success) {
              editModal.hide();
              const modalBerhasil = document.getElementById('modalBerhasil');
              modalBerhasil.classList.add('show');
              new Audio('/assets/sounds/Success.mp3').play();
              setTimeout(() => {
                  modalBerhasil.classList.remove('show');
                  window.location.reload();
              }, 1000);
          }
      })
      .catch(error => console.error('Error:', error))
      .finally(() => {
        submitButton.disabled = false;
        submitButton.innerHTML = originalButtonText;
      });
    });
    
    function createExistingDokumenItem(doc, index) {
      const item = document.createElement('div');
      item.classList.add('dokumen-item', 'border', 'rounded', 'p-3', 'mb-3', 'position-relative');
      let fileLink = doc.path_file ? `<small class="text-muted mt-1 d-block">File saat ini: <a href="/storage/${doc.path_file}" target="_blank">Lihat</a></small>` : '';

      item.innerHTML = `
        <input type="hidden" name="dokumen[${index}][id]" value="${doc.id}">
        <button type="button" class="btn-close position-absolute top-0 end-0 m-2 removeDokumen" aria-label="Close"></button>
        <div class="row g-2">
          <div class="col-12"><label class="form-label">Jenis Dokumen</label><select name="dokumen[${index}][jenis]" class="form-select"><option value="Transkrip">Transkrip</option><option value="Surat Tugas">Surat Tugas</option><option value="SK">SK</option><option value="Sertifikat">Sertifikat</option><option value="Penyetaraan Ijazah">Penyetaraan Ijazah</option><option value="Laporan Kegiatan">Laporan Kegiatan</option><option value="Ijazah">Ijazah</option><option value="Buku / Bahan Ajar">Buku / Bahan Ajar</option></select></div>
          <div class="col-md-4"><label class="form-label">Nama Dokumen</label><input type="text" name="dokumen[${index}][nama]" value="${doc.nama_dokumen || ''}" class="form-control"></div>
          <div class="col-md-4"><label class="form-label">Nomor</label><input type="text" name="dokumen[${index}][nomor]" value="${doc.nomor_dokumen || ''}" class="form-control"></div>
          <div class="col-md-4"><label class="form-label">Tautan</label><input type="url" name="dokumen[${index}][tautan]" value="${doc.tautan_dokumen || ''}" class="form-control"></div>
          <div class="col-12"><label class="form-label">Ganti File</label><input type="file" name="dokumen[${index}][file]" class="form-control">${fileLink}</div>
        </div>
      `;
      item.querySelector(`select[name="dokumen[${index}][jenis]"]`).value = doc.jenis_dokumen;
      item.querySelector('.removeDokumen').addEventListener('click', () => item.remove());
      return item;
    }

    if(addEditDokumenBtn) {
        addEditDokumenBtn.addEventListener('click', function() {
            const item = createNewDokumenItem(newDocIndex);
            editDokumenWrapper.appendChild(item);
            newDocIndex++;
        });
    }

    function createNewDokumenItem(index) {
        const item = document.createElement('div');
        item.classList.add('dokumen-item', 'border', 'rounded', 'p-3', 'mb-3', 'position-relative', 'bg-light');
        item.innerHTML = `
          <button type="button" class="btn-close position-absolute top-0 end-0 m-2 removeDokumen" aria-label="Close"></button>
          <small class="text-success fw-bold">Dokumen Baru</small>
          <div class="row g-2 mt-1">
            <div class="col-12"><label class="form-label">Jenis Dokumen</label><select name="new_dokumen[${index}][jenis]" class="form-select"><option value="">--Pilih--</option><option value="Transkrip">Transkrip</option><option value="Surat Tugas">Surat Tugas</option><option value="SK">SK</option><option value="Sertifikat">Sertifikat</option><option value="Penyetaraan Ijazah">Penyetaraan Ijazah</option><option value="Laporan Kegiatan">Laporan Kegiatan</option><option value="Ijazah">Ijazah</option><option value="Buku / Bahan Ajar">Buku / Bahan Ajar</option></select></div>
            <div class="col-md-4"><label class="form-label">Nama Dokumen</label><input type="text" name="new_dokumen[${index}][nama]" class="form-control"></div>
            <div class="col-md-4"><label class="form-label">Nomor</label><input type="text" name="new_dokumen[${index}][nomor]" class="form-control"></div>
            <div class="col-md-4"><label class="form-label">Tautan</label><input type="url" name="new_dokumen[${index}][tautan]" class="form-control"></div>
            <div class="col-12"><label class="form-label">File</label><input type="file" name="new_dokumen[${index}][file]" class="form-control"></div>
          </div>
        `;
        item.querySelector('.removeDokumen').addEventListener('click', () => item.remove());
        return item;
    }
  }

  // ======================================================================
  // BAGIAN 3: FUNGSI TAMBAH/HAPUS DOKUMEN DINAMIS (MODAL TAMBAH)
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
          <div class="col-md-4"><label class="form-label">Nama Dokumen</label><input type="text" name="dokumen[${dokumenIndex}][nama]" class="form-control" placeholder="Nama Dokumen"></div>
          <div class="col-md-4"><label class="form-label">Nomor</label><input type="text" name="dokumen[${dokumenIndex}][nomor]" class="form-control" placeholder="Nomor"></div>
          <div class="col-md-4"><label class="form-label">Tautan</label><input type="url" name="dokumen[${dokumenIndex}][tautan]" class="form-control" placeholder="https://..."></div>
          <div class="col-12"><label class="form-label">File <small class="text-muted">(Maksimal 5MB)</small></label><input type="file" name="dokumen[${dokumenIndex}][file]" class="form-control"></div>
        </div>
      `;
      dokumenWrapper.appendChild(newItem);
      dokumenIndex++;
    });

    dokumenWrapper.addEventListener("click", function (e) {
      if (e.target && e.target.classList.contains("removeDokumen")) {
        e.target.closest(".dokumen-item").remove();
      }
    });
  }

  // ======================================================================
  // BAGIAN 4: TAMPIL DATA KE MODAL DETAIL
  // ======================================================================
  const detailButtons = document.querySelectorAll(".btn-detail");
const detailDokumenList = document.getElementById("detail-dokumen-list");

detailButtons.forEach(btn => {
  btn.addEventListener("click", function () {
    // 1. Isi data utama (tidak berubah)
    document.getElementById("detail-nama").textContent = this.dataset.nama || "-";
    document.getElementById("detail-kegiatan").textContent = this.dataset.kegiatan || "-";
    document.getElementById("detail-media").textContent = this.dataset.media || "-";
    document.getElementById("detail-peran").textContent = this.dataset.peran || "-";
    document.getElementById("detail-no-sk").textContent = this.dataset.noSk || "-";
    document.getElementById("detail-tgl-mulai").textContent = this.dataset.tglMulai || "-";
    document.getElementById("detail-tgl-selesai").textContent = this.dataset.tglSelesai || "-";
    document.getElementById("detail-status").textContent = this.dataset.status || "-";

    // 2. Kosongkan daftar dokumen sebelum diisi
    if (detailDokumenList) {
      detailDokumenList.innerHTML = '';
    }

    // 3. Ambil dan parse data dokumen dari atribut data-
    const dokumenData = JSON.parse(this.dataset.dokumen || '[]');

    // 4. Bangun daftar dokumen secara dinamis
    if (dokumenData.length > 0) {
      dokumenData.forEach(doc => {
        // Siapkan tombol berdasarkan data yang ada (file atau tautan)
        let tombolAksi = '<span class="text-muted fst-italic">Tidak ada file atau tautan</span>';
        if (doc.path_file) {
          tombolAksi = `<a href="/storage/${doc.path_file}" class="btn btn-sm btn-success text-white mt-1" target="_blank"><i class="fa fa-eye me-1"></i> Lihat File</a>`;
        } else if (doc.tautan_dokumen) {
          tombolAksi = `<a href="${doc.tautan_dokumen}" class="btn btn-sm btn-info text-white mt-1" target="_blank"><i class="fa fa-link me-1"></i> Lihat Tautan</a>`;
        }
        
        const docItemHTML = `
          <div class="col-md-6">
            <div class="detail-doc">
              <span>${doc.nama_dokumen || doc.jenis_dokumen}</span>
              <small class="text-muted d-block">No: ${doc.nomor_dokumen || '-'}</small>
              ${tombolAksi}
            </div>
          </div>
        `;
        if (detailDokumenList) {
          detailDokumenList.innerHTML += docItemHTML;
        }
      });
    } else {
      // Tampilkan pesan jika tidak ada dokumen
      const noDocHTML = `
        <div class="col-12">
          <p class="text-muted fst-italic">Tidak ada dokumen yang dilampirkan.</p>
        </div>
      `;
      if (detailDokumenList) {
        detailDokumenList.innerHTML = noDocHTML;
      }
    }
  });
});

  // ======================================================================
  // BAGIAN 5: PENINGKATAN UX UNTUK INPUT DATE
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