document.addEventListener("DOMContentLoaded", () => {
  // == Pengaturan Global untuk Modal dan Suara ==
  const modalBerhasilEl = document.getElementById("modalBerhasil");
  const berhasilTitle = document.getElementById("berhasil-title");
  const berhasilSubtitle = document.getElementById("berhasil-subtitle");
  let successModalTimeout = null;
  let successAudio = null;

  // == Fungsi untuk Menampilkan Modal Sukses ==
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

  // == Fungsi untuk Menyembunyikan Modal Sukses ==
  const hideSuccessModal = () => {
    modalBerhasilEl?.classList.remove("show");
  };
  document.getElementById("btnSelesai")?.addEventListener("click", hideSuccessModal);


  // == Fungsi untuk Inisialisasi Area Upload File ==
  const setupUploadArea = () => {
    document.querySelectorAll(".upload-area").forEach((uploadArea) => {
      const fileInput = uploadArea.querySelector('input[type="file"]');
      const uploadText = uploadArea.querySelector("p");
      const feedbackEl = document.getElementById('file-size-feedback');

      if (!fileInput || !uploadText || !feedbackEl) return;
      const originalText = uploadText.innerHTML;

      const resetFeedback = () => {
          feedbackEl.textContent = '';
          feedbackEl.style.display = 'none';
      };

      uploadArea.addEventListener("click", () => fileInput.click());
      fileInput.addEventListener("change", function () {
        uploadText.textContent = this.files.length > 0 ? this.files[0].name : originalText;
        resetFeedback();
      });

      uploadArea.reset = () => {
        uploadText.innerHTML = originalText;
        fileInput.value = "";
        resetFeedback();
      };
    });
  };

  // == Fungsi Inisialisasi Modal Tambah/Edit Penghargaan (Logika AJAX) ==
  const initPenghargaanModal = () => {
    const penghargaanModalEl = document.getElementById("penghargaanModal");
    if (!penghargaanModalEl) return;
    const bsModal = new bootstrap.Modal(penghargaanModalEl);
    const form = document.getElementById("penghargaanForm");
    const saveButton = penghargaanModalEl.querySelector(".btn-success");
    const modalTitle = penghargaanModalEl.querySelector(".modal-title");
    const idInput = document.getElementById('penghargaan_id');
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
    penghargaanModalEl.addEventListener("show.bs.modal", (event) => {
      const button = event.relatedTarget;
      const isEditMode = button?.hasAttribute('data-id');
      form.reset();
      penghargaanModalEl.querySelector(".upload-area")?.reset();
      form.querySelector('input[name="_method"]')?.remove();
      hideFileSizeError();

      // [PERUBAHAN] Atur properti 'required' pada input file
      fileInput.required = !isEditMode;

      if (isEditMode) {
        modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Penghargaan';
        const penghargaanId = button.dataset.id;
        idInput.value = penghargaanId;
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'POST';
        form.prepend(methodInput);
        fetch(`/penghargaan/${penghargaanId}/edit`)
          .then(response => {
            if (!response.ok) throw new Error('Data tidak ditemukan');
            return response.json();
          })
          .then(data => {
            form.nama_pegawai.value = data.nama_pegawai;
            form.kegiatan.value = data.kegiatan;
            form.nama_penghargaan.value = data.nama_penghargaan;
            form.nomor_sk.value = data.nomor_sk;
            form.tanggal_perolehan.value = data.tanggal_perolehan;
            form.lingkup.value = data.lingkup;
            form.negara.value = data.negara;
            form.instansi_pemberi.value = data.instansi_pemberi;
            form.jenis_dokumen.value = data.jenis_dokumen;
            form.nama_dokumen.value = data.nama_dokumen;
            form.nomor_dokumen.value = data.nomor_dokumen;
            form.tautan.value = data.tautan;
            penghargaanModalEl.querySelector(".upload-area p").innerHTML = "Pilih file lain jika ingin mengubah dokumen<br><small>Ukuran Maksimal 5 MB (PDF)</small>";
          })
          .catch(error => {
            console.error("Gagal mengambil data untuk diedit:", error);
            alert("Gagal memuat data. Silakan coba lagi.");
            bsModal.hide();
          });
      } else {
        modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Penghargaan';
        idInput.value = '';
      }
    });

    saveButton.addEventListener("click", (event) => {
      event.preventDefault();
      
      // [PERUBAHAN BARU] Validasi form wajib diisi
      if (!form.checkValidity()) {
        form.reportValidity(); // Tampilkan pesan error bawaan browser
        return; // Hentikan eksekusi
      }

      hideFileSizeError();

      if (fileInput.files.length > 0) {
        const file = fileInput.files[0];
        const maxSizeInBytes = 5 * 1024 * 1024;
        if (file.size > maxSizeInBytes) {
          showFileSizeError(`File terlalu besar! Ukuran maksimal 5 MB. Ukuran file Anda ~${(file.size / 1024 / 1024).toFixed(2)} MB`);
          return;
        }
      }

      const penghargaanId = idInput.value;
      const isEditMode = !!penghargaanId;
      const url = isEditMode ? `/penghargaan/${penghargaanId}` : '/penghargaan';
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
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          bsModal.hide();
          showSuccessModal(isEditMode ? "Data Berhasil Diperbarui" : "Data Berhasil Disimpan", data.success);
          setTimeout(() => location.reload(), 1300);
        } else if (data.errors) {
          const errorMessages = Object.values(data.errors).map(msg => `- ${msg}`).join("\n");
          alert("Validasi Gagal:\n" + errorMessages);
        } else {
          throw new Error(data.error || 'Terjadi kesalahan yang tidak diketahui.');
        }
      })
      .catch(error => {
        console.error("Terjadi kesalahan:", error);
        alert("Gagal mengirim data. Silakan cek konsol untuk detail.");
      })
      .finally(() => {
        saveButton.disabled = false;
        saveButton.innerHTML = 'Simpan';
      });
    });
  };

  // == Fungsi Inisialisasi Modal Detail ==
  const initDetailModal = () => {
    document.addEventListener("click", (event) => {
      const detailButton = event.target.closest(".btn-lihat-detail-penghargaan");
      if (!detailButton) return;
      const data = detailButton.dataset;
      const fields = ["pegawai", "kegiatan", "nama_penghargaan", "nomor", "tanggal_perolehan", "lingkup", "negara", "instansi", "jenis_dokumen", "nama_dokumen", "nomor_dokumen", "tautan"];
      fields.forEach((field) => {
        const el = document.getElementById(`detail_penghargaan_${field}`);
        if (el) el.textContent = data[field] || "-";
      });
      document.getElementById("detail_penghargaan_document_viewer")?.setAttribute("src", data.dokumen_path || "");
    });
  };

  // == Fungsi Inisialisasi Modal Konfirmasi Hapus ==
  const initDeleteModal = () => {
    const modalKonfirmasiHapus = document.getElementById("modalKonfirmasiHapus");
    if (!modalKonfirmasiHapus) return;

    let dataToDelete = null;
    const btnKonfirmasi = document.getElementById("btnKonfirmasiHapus");

    const showDeleteModal = () => modalKonfirmasiHapus?.classList.add("show");
    const hideDeleteModal = () => modalKonfirmasiHapus?.classList.remove("show");

    document.body.addEventListener("click", (event) => {
      const hapusButton = event.target.closest(".btn-hapus");
      if (hapusButton) {
        event.preventDefault();
        dataToDelete = { id: hapusButton.dataset.id };
        showDeleteModal();
      }
      if (event.target.matches("#btnBatalHapus") || event.target.closest(".konfirmasi-hapus-overlay:not(.konfirmasi-hapus-box)")) {
        hideDeleteModal();
      }
    });

    btnKonfirmasi?.addEventListener('click', (event) => {
      event.preventDefault();
      if (!dataToDelete || !dataToDelete.id) return;

      const originalButtonText = btnKonfirmasi.innerHTML;
      btnKonfirmasi.disabled = true;
      btnKonfirmasi.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menghapus...';

      fetch(`/penghargaan/${dataToDelete.id}`, {
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
          showSuccessModal("Berhasil Dihapus", "Data penghargaan telah dihapus.");
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

    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && modalKonfirmasiHapus?.classList.contains("show")) {
        hideDeleteModal();
      }
    });
  };

  // == Panggil Semua Fungsi Inisialisasi ==
  setupUploadArea();
  initPenghargaanModal();
  initDetailModal();
  initDeleteModal();
});