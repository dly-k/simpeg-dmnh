document.addEventListener("DOMContentLoaded", function () {
  /**
   * ===================================================================
   * Notifikasi Sukses (Modal & Suara)
   * ===================================================================
   */
  const handleSuccessNotification = () => {
    const successMessage = document.querySelector('meta[name="flash-success"]')?.getAttribute('content');
    if (successMessage) {
      const modalBerhasil = document.getElementById('modalBerhasil');
      if (modalBerhasil) {
        document.getElementById('berhasil-title').textContent = 'Berhasil!';
        document.getElementById('berhasil-subtitle').textContent = successMessage;
        modalBerhasil.classList.add('show');
        const successSound = new Audio('/assets/sounds/Success.mp3');
        successSound.play().catch(error => console.error("Gagal memutar suara:", error));
        setTimeout(() => {
          modalBerhasil.classList.remove('show');
        }, 1000);
        document.getElementById('btnSelesai').addEventListener('click', () => {
          modalBerhasil.classList.remove('show');
        });
      }
    }
  };

  /**
   * ===================================================================
   * Logika untuk Fitur Edit Data
   * ===================================================================
   */
  const editModal = document.getElementById('editPembicaraModal');
  if (editModal) {
    editModal.addEventListener('show.bs.modal', async function (event) {
      const button = event.relatedTarget;
      const id = button.dataset.id;
      const form = document.getElementById('editPembicaraForm');
      const wrapper = document.getElementById('editDokumenWrapper');
      form.reset();
      wrapper.innerHTML = '';
      document.getElementById('deleted_dokumen_ids').value = '';
      form.action = `/pembicara/${id}`;

      try {
        const response = await fetch(`/pembicara/${id}/edit`);
        if (!response.ok) throw new Error('Gagal mengambil data untuk diedit');
        const data = await response.json();
        for (const key in data) {
          const field = form.querySelector(`[name="${key}"][id^="edit_"]`);
          if (field) {
            field.value = data[key];
          }
        }
        if (data.dokumen && data.dokumen.length > 0) {
          data.dokumen.forEach(doc => {
            const existingDocItem = createExistingDokumenItem(doc);
            wrapper.appendChild(existingDocItem);
          });
        }
      } catch (error) {
        console.error('Error fetching data for edit:', error);
        alert('Terjadi kesalahan saat memuat data. Silakan coba lagi.');
        bootstrap.Modal.getInstance(editModal).hide();
      }
    });
  }
  
  function createExistingDokumenItem(doc) {
    const item = document.createElement("div");
    item.classList.add("dokumen-item", "border", "rounded", "p-3", "mb-3", "position-relative", "bg-light");
    item.dataset.id = doc.id;

    const docName = doc.nama_dokumen || '';
    const docNomor = doc.nomor || '';
    const docTautan = doc.tautan || '';
    
    const jenisOptions = ['Transkrip', 'Surat Tugas', 'SK', 'Sertifikat', 'Penyetaraan Ijazah', 'Laporan Kegiatan', 'Ijazah', 'Buku / Bahan Ajar'];
    const optionsHtml = jenisOptions.map(opt => 
      `<option value="${opt}" ${doc.jenis_dokumen === opt ? 'selected' : ''}>${opt}</option>`
    ).join('');

    item.innerHTML = `
        <button type="button" class="btn-close position-absolute top-0 end-0 m-2 removeExistingDokumen" aria-label="Close" title="Hapus Dokumen Ini"></button>
        <div class="row g-2">
            <div class="col-12">
                <label class="form-label">Jenis Dokumen</label>
                <select name="existing_dokumen[${doc.id}][jenis_dokumen]" class="form-select">
                    <option value="">-- Pilih Jenis Dokumen --</option>
                    ${optionsHtml}
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Nama Dokumen</label>
                <input type="text" name="existing_dokumen[${doc.id}][nama_dokumen]" class="form-control" placeholder="Nama Dokumen" value="${docName}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Nomor</label>
                <input type="text" name="existing_dokumen[${doc.id}][nomor]" class="form-control" placeholder="Nomor" value="${docNomor}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Tautan</label>
                <input type="url" name="existing_dokumen[${doc.id}][tautan]" class="form-control" placeholder="https://" value="${docTautan}">
            </div>
            <div class="col-12 mt-2">
                <label class="form-label">File Tersimpan</label>
                <div class="alert alert-secondary p-2">
                  <a href="/${doc.file_path}" target="_blank" class="text-primary fw-bold">${docName || 'Lihat File'}</a>
                  <small class="d-block text-muted">File tidak dapat diubah. Untuk mengganti, hapus dokumen ini dan unggah yang baru.</small>
                </div>
            </div>
        </div>
    `;
    return item;
  }
  
  document.getElementById('editDokumenWrapper').addEventListener('click', function(e) {
      if (e.target.classList.contains('removeExistingDokumen')) {
          const item = e.target.closest('.dokumen-item');
          const docId = item.dataset.id;
          const hiddenInput = document.getElementById('deleted_dokumen_ids');
          const currentIds = hiddenInput.value ? hiddenInput.value.split(',') : [];
          if (!currentIds.includes(docId)) {
              currentIds.push(docId);
              hiddenInput.value = currentIds.join(',');
          }
          item.remove();
      }
  });

  /**
   * ===================================================================
   * Utility & Dynamic Dokumen
   * ===================================================================
   */
  function validateFileSize(input) {
    if (input.files.length > 0) {
      const file = input.files[0];
      if (file.size > 5 * 1024 * 1024) {
        alert("Ukuran file maksimal 5MB!");
        input.value = "";
      }
    }
  }

  function initFileValidation(input) {
    input.addEventListener("change", function () {
      validateFileSize(this);
    });
  }

  function createDokumenItem(index) {
    const item = document.createElement("div");
    item.classList.add("dokumen-item", "border", "rounded", "p-3", "mb-3", "position-relative");
    item.innerHTML = `
      <button type="button" class="btn-close position-absolute top-0 end-0 m-2 removeDokumen" aria-label="Close"></button>
      <div class="row g-2">
        <div class="col-12"><label class="form-label">Jenis Dokumen (Baru)</label><select name="dokumen[${index}][jenis]" class="form-select"><option value="" disabled selected>-- Pilih Jenis --</option><option value="Transkrip">Transkrip</option><option value="Surat Tugas">Surat Tugas</option><option value="SK">SK</option><option value="Sertifikat">Sertifikat</option><option value="Penyetaraan Ijazah">Penyetaraan Ijazah</option><option value="Laporan Kegiatan">Laporan Kegiatan</option><option value="Ijazah">Ijazah</option><option value="Buku / Bahan Ajar">Buku / Bahan Ajar</option></select></div>
        <div class="col-md-4"><label class="form-label">Nama Dokumen</label><input type="text" name="dokumen[${index}][nama]" class="form-control" placeholder="Nama Dokumen"></div>
        <div class="col-md-4"><label class="form-label">Nomor</label><input type="text" name="dokumen[${index}][nomor]" class="form-control" placeholder="Nomor"></div>
        <div class="col-md-4"><label class="form-label">Tautan</label><input type="url" name="dokumen[${index}][tautan]" class="form-control" placeholder="https://..."></div>
        <div class="col-12"><label class="form-label">File <small class="text-muted">(Wajib diisi untuk dokumen baru)</small></label><input type="file" name="dokumen[${index}][file]" class="form-control file-input" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.txt" required></div>
      </div>
    `;
    initFileValidation(item.querySelector(".file-input"));
    return item;
  }

  function initDokumenHandler(wrapperId, addBtnId) {
    const wrapper = document.getElementById(wrapperId);
    const addBtn = document.getElementById(addBtnId);
    if (!wrapper || !addBtn) return;
    addBtn.addEventListener("click", function () {
      const nextIndex = wrapper.querySelectorAll(".dokumen-item").length;
      const newItem = createDokumenItem(nextIndex);
      wrapper.appendChild(newItem);
    });
    wrapper.addEventListener("click", function (e) {
      if (e.target.closest(".removeDokumen")) {
        e.target.closest(".dokumen-item").remove();
      }
    });
    wrapper.querySelectorAll(".file-input").forEach(initFileValidation);
  }

  function initToggleLainnya(selectId, inputId) {
    const select = document.getElementById(selectId);
    const input = document.getElementById(inputId);
    if (!select || !input) return;
    select.addEventListener("change", function () {
      if (this.value === "lainnya") {
        input.classList.remove("d-none");
        input.required = true;
      } else {
        input.classList.add("d-none");
        input.required = false;
        input.value = "";
      }
    });
  }

  /**
   * ===================================================================
   * Detail Modal & Inisialisasi
   * ===================================================================
   */
  function setDetailText(id, value) {
    const el = document.getElementById(id);
    if (el) el.textContent = value || "-";
  }

  function setDetailFile(linkId, noDataId, url) {
    const link = document.getElementById(linkId);
    const noData = document.getElementById(noDataId);
    if (!link || !noData) return;
    if (url) {
      link.href = url;
      link.style.display = "inline-block";
      noData.style.display = "none";
    } else {
      link.style.display = "none";
      noData.style.display = "inline-block";
    }
  }
  
  document.querySelectorAll(".btn-detail-pembicara").forEach(btn => {
    btn.addEventListener("click", function () {
      setDetailText("detail-nama", this.dataset.nama);
      setDetailText("detail-kegiatan", this.dataset.kegiatan);
      setDetailText("detail-capaian", this.dataset.capaian);
      setDetailText("detail-kategori-pembicara", this.dataset.kategori);
      setDetailText("detail-makalah", this.dataset.makalah);
      setDetailText("detail-pertemuan", this.dataset.pertemuan);
      setDetailText("detail-tanggal", this.dataset.tanggal);
      setDetailText("detail-penyelenggara", this.dataset.penyelenggara);
      setDetailText("detail-tingkat", this.dataset.tingkat);
      setDetailText("detail-bahasa", this.dataset.bahasa);
      setDetailText("detail-litabmas", this.dataset.litabmas);
      setDetailFile("detail-sertifikat", "nodata-sertifikat", this.dataset.sertifikat);
      setDetailFile("detail-sk", "nodata-sk", this.dataset.sk);
      new bootstrap.Modal(document.getElementById("detailPembicaraModal")).show();
    });
  });

  handleSuccessNotification();
  initDokumenHandler("dokumenWrapper", "addDokumen");
  initDokumenHandler("editDokumenWrapper", "addEditDokumen");
  initToggleLainnya("kegiatan", "kegiatan_lainnya");
  initToggleLainnya("kategori_capaian", "kategori_capaian_lainnya");
  initToggleLainnya("edit_kegiatan", "edit_kegiatan_lainnya");
  initToggleLainnya("edit_kategori_capaian", "edit_kategori_capaian_lainnya");
});