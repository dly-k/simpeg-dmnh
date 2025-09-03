document.addEventListener("DOMContentLoaded", () => {
  // == Pengaturan Global untuk Modal dan Notifikasi ==
  const modalBerhasilEl = document.getElementById("modalBerhasil");
  const berhasilTitle = document.getElementById("berhasil-title");
  const berhasilSubtitle = document.getElementById("berhasil-subtitle");
  let successModalTimeout = null;
  let successAudio = null;

  const showSuccessModal = (title, subtitle) => {
    if (!modalBerhasilEl) return;
    berhasilTitle.textContent = title;
    berhasilSubtitle.textContent = subtitle;
    modalBerhasilEl.classList.add("show");
    if (!successAudio) {
      successAudio = new Audio("/assets/sounds/success.mp3");
    }
    successAudio.play().catch(() => console.warn("Gagal memutar audio notifikasi."));
    clearTimeout(successModalTimeout);
    successModalTimeout = setTimeout(hideSuccessModal, 1200);
  };

  const hideSuccessModal = () => {
    modalBerhasilEl?.classList.remove("show");
  };
  document.getElementById("btnSelesai")?.addEventListener("click", hideSuccessModal);

  // == Fungsi Inisialisasi Modal Tambah/Edit Pelatihan ==
  const initPelatihanModal = () => {
    const pelatihanModalEl = document.getElementById("pelatihanModal");
    if (!pelatihanModalEl) return;
    const bsModal = new bootstrap.Modal(pelatihanModalEl);
    const form = document.getElementById("pelatihanForm");
    const saveButton = pelatihanModalEl.querySelector(".btn-success");
    const modalTitle = pelatihanModalEl.querySelector(".modal-title");
    const idInput = document.getElementById('pelatihan_id');
    const fileInput = form.dokumen;
    const fileSizeFeedbackEl = document.getElementById('file-size-feedback');
    const showFileSizeError = (message) => {
        if (fileSizeFeedbackEl) {
            fileSizeFeedbackEl.textContent = message;
            fileSizeFeedbackEl.style.display = 'block';
        }
    };
    const hideFileSizeError = () => {
        if (fileSizeFeedbackEl) {
            fileSizeFeedbackEl.textContent = '';
            fileSizeFeedbackEl.style.display = 'none';
        }
    };
    pelatihanModalEl.addEventListener("show.bs.modal", (event) => {
      const button = event.relatedTarget;
      const isEditMode = button?.classList.contains('btn-edit');
      form.reset();
      pelatihanModalEl.querySelector(".upload-area")?.reset();
      form.querySelector('input[name="_method"]')?.remove();
      hideFileSizeError();
      document.getElementById("posisi-lainnya-input").classList.remove("show");
      fileInput.required = !isEditMode;
      if (isEditMode) {
        modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Pelatihan';
        const pelatihanId = button.dataset.id;
        idInput.value = pelatihanId;
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.prepend(methodInput);
        fetch(`/pelatihan/${pelatihanId}/edit`)
          .then(response => {
            if (!response.ok) throw new Error('Data tidak ditemukan');
            return response.json();
          })
          .then(data => {
            for (const key in data) {
              if (Object.hasOwnProperty.call(data, key)) {
                const field = form.elements[key];
                if (field) {
                  if (field.type === 'date') {
                    field.value = data[key].split('T')[0]; 
                  } else if (key === 'struktural' || key === 'sertifikasi') {
                    field.value = data[key] ? 'Ya' : 'Tidak';
                  } else {
                    field.value = data[key];
                  }
                }
              }
            }
            if (data.posisi === 'Lainnya') {
                document.getElementById('posisi-lainnya-input').classList.add('show');
                form.posisi_lainnya.value = data.posisi_lainnya;
            }
            pelatihanModalEl.querySelector(".upload-area p").innerHTML = "Pilih file lain jika ingin mengubah<br><small>Maks 5 MB</small>";
          })
          .catch(error => {
            console.error("Gagal mengambil data untuk diedit:", error);
            alert("Gagal memuat data. Silakan coba lagi.");
            bsModal.hide();
          });
      } else {
        modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Pelatihan';
        idInput.value = '';
      }
    });
    saveButton.addEventListener("click", (event) => {
      event.preventDefault();
      if (!form.checkValidity()) {
        form.reportValidity();
        return;
      }
      hideFileSizeError();
      if (fileInput.files.length > 0) {
        const file = fileInput.files[0];
        const maxSizeInBytes = 5 * 1024 * 1024;
        if (file.size > maxSizeInBytes) {
          showFileSizeError(`File terlalu besar! Maksimal 5 MB. Ukuran file Anda ~${(file.size / 1024 / 1024).toFixed(2)} MB`);
          return;
        }
      }
      const pelatihanId = idInput.value;
      const isEditMode = !!pelatihanId;
      const url = isEditMode ? `/pelatihan/${pelatihanId}` : '/pelatihan';
      const formData = new FormData(form);
      saveButton.disabled = true;
      saveButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';
      fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Accept': 'application/json',
        },
      })
      .then(response => {
        if (!response.ok) {
           return response.json().then(err => { throw err; });
        }
        return response.json();
      })
      .then(data => {
        if (data.success) {
          bsModal.hide();
          showSuccessModal(isEditMode ? "Data Berhasil Diperbarui" : "Data Berhasil Disimpan", data.success);
          setTimeout(() => location.reload(), 1300);
        }
      })
      .catch(error => {
        console.error("Terjadi kesalahan:", error);
        if (error.errors) {
            const errorMessages = Object.values(error.errors).map(msg => `- ${msg}`).join("\n");
            alert("Validasi Gagal:\n" + errorMessages);
        } else {
            alert("Gagal mengirim data. Silakan cek konsol untuk detail.");
        }
      })
      .finally(() => {
        saveButton.disabled = false;
        saveButton.innerHTML = 'Simpan';
      });
    });
  };

  // == Inisialisasi semua Event Listener Global di satu tempat ==
  const initGlobalEventListeners = () => {
    const overlay = document.querySelector(".konfirmasi-hapus-overlay");
    if (!overlay) return;
    const btnKonfirmasi = document.getElementById("btnKonfirmasiHapus");
    let dataToDelete = null;
    const showDeleteModal = () => overlay.classList.add("show");
    const hideDeleteModal = () => overlay.classList.remove("show");
    document.body.addEventListener("click", (event) => {
      const target = event.target;
      const hapusButton = target.closest(".btn-hapus");
      const detailButton = target.closest(".btn-lihat-detail-pelatihan");
      if (hapusButton) {
        event.preventDefault();
        dataToDelete = { id: hapusButton.dataset.id };
        showDeleteModal();
      }
      if (target.matches("#btnBatalHapus") || target.matches(".konfirmasi-hapus-overlay")) {
        hideDeleteModal();
      }
      if (detailButton) {
        const data = detailButton.dataset;
        document.getElementById("detail_pelatihan_nama").textContent = data.nama_pelatihan || "-";
        document.getElementById("detail_pelatihan_posisi").textContent = data.posisi || "-";
        document.getElementById("detail_pelatihan_kota").textContent = data.kota || "-";
        document.getElementById("detail_pelatihan_lokasi").textContent = data.lokasi || "-";
        document.getElementById("detail_pelatihan_penyelenggara").textContent = data.penyelenggara || "-";
        document.getElementById("detail_pelatihan_jenis_diklat").textContent = data.jenis_diklat || "-";
        document.getElementById("detail_pelatihan_tgl_mulai").textContent = data.tgl_mulai || "-";
        document.getElementById("detail_pelatihan_tgl_selesai").textContent = data.tgl_selesai || "-";
        document.getElementById("detail_pelatihan_lingkup").textContent = data.lingkup || "-";
        document.getElementById("detail_pelatihan_jam").textContent = data.jam || "-";
        document.getElementById("detail_pelatihan_hari").textContent = data.hari || "-";
        document.getElementById("detail_pelatihan_struktural").textContent = data.struktural || "-";
        document.getElementById("detail_pelatihan_sertifikasi").textContent = data.sertifikasi || "-";
        document.getElementById("detail_pelatihan_document_viewer")?.setAttribute("src", data.dokumen_path || "");
      }
    });
    btnKonfirmasi?.addEventListener('click', (event) => {
      event.preventDefault();
      if (!dataToDelete || !dataToDelete.id) return;
      const originalButtonText = btnKonfirmasi.innerHTML;
      btnKonfirmasi.disabled = true;
      btnKonfirmasi.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menghapus...';
      fetch(`/pelatihan/${dataToDelete.id}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Accept': 'application/json',
        },
      })
      .then(response => {
        if (!response.ok) throw new Error('Gagal menghapus data di server.');
        return response.json();
      })
      .then(data => {
        if (data.success) {
          hideDeleteModal();
          showSuccessModal("Berhasil Dihapus", "Data pelatihan telah dihapus.");
          setTimeout(() => location.reload(), 1300);
        } else {
          throw new Error(data.error || 'Terjadi kesalahan.');
        }
      })
      .catch(error => {
        console.error("Gagal menghapus data:", error);
        alert("Gagal menghapus data. Silakan coba lagi.");
        hideDeleteModal();
      })
      .finally(() => {
        btnKonfirmasi.disabled = false;
        btnKonfirmasi.innerHTML = originalButtonText;
        dataToDelete = null;
      });
    });
  };

  // == [KUNCI PERBAIKAN] Fungsi Utilitas untuk Area Unggah ==
  const setupUploadArea = () => {
    document.querySelectorAll(".upload-area").forEach((uploadArea) => {
      const fileInput = uploadArea.querySelector('input[type="file"]');
      const uploadText = uploadArea.querySelector("p");
      if (!fileInput || !uploadText) return;
      
      const originalText = uploadText.innerHTML;

      // MENAMBAHKAN EVENT LISTENER PADA DIV, BUKAN HANYA DI BODY
      uploadArea.addEventListener("click", () => {
        fileInput.click();
      });
      
      fileInput.addEventListener("change", function () {
        if (this.files.length > 0) {
            uploadText.textContent = this.files[0].name;
        } else {
            uploadText.innerHTML = originalText;
        }
      });
      
      uploadArea.reset = () => {
        uploadText.innerHTML = originalText;
        fileInput.value = "";
      };
    });
  };
  
  // == Fungsi Utilitas Lainnya ==
  const setupPosisiLainnya = () => {
    const posisiSelect = document.getElementById("posisi-pelatihan-select");
    const posisiLainnyaInput = document.getElementById("posisi-lainnya-input");
    if (!posisiSelect || !posisiLainnyaInput) return;
    posisiSelect.addEventListener("change", function () {
      posisiLainnyaInput.classList.toggle("show", this.value === "Lainnya");
      if(this.value !== "Lainnya") posisiLainnyaInput.value = "";
    });
  };

  // == Panggil Semua Fungsi Inisialisasi ==
  initPelatihanModal();
  initGlobalEventListeners();
  setupPosisiLainnya();
  setupUploadArea(); // Pastikan fungsi ini dipanggil
});