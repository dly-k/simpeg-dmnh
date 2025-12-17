(function () {
  document.addEventListener("DOMContentLoaded", function () {
    // == Pengaturan Global untuk Modal dan Notifikasi ==
    const modalBerhasilEl = document.getElementById("modalBerhasil");
    const berhasilTitle = document.getElementById("berhasil-title");
    const berhasilSubtitle = document.getElementById("berhasil-subtitle");
    let successModalTimeout = null;

    function showSuccessModal(title, subtitle, callback = null) {
      if (!modalBerhasilEl || !berhasilTitle || !berhasilSubtitle) return;
      berhasilTitle.textContent = title;
      berhasilSubtitle.textContent = subtitle;
      modalBerhasilEl.style.display = "flex";
      requestAnimationFrame(() => modalBerhasilEl.classList.add("show"));
      document.body.style.overflow = "hidden";
      const successAudio = new Audio("/assets/sounds/success.mp3");
      successAudio.play().catch((err) => console.warn("Gagal memutar audio:", err));
      clearTimeout(successModalTimeout);
      successModalTimeout = setTimeout(() => {
        hideSuccessModal();
        if (typeof callback === "function") callback();
      }, 1200);
    }

    function hideSuccessModal() {
      if (modalBerhasilEl?.classList.contains("show")) {
        modalBerhasilEl.classList.remove("show");
        modalBerhasilEl.addEventListener("transitionend", () => {
            if (!modalBerhasilEl.classList.contains("show")) {
              modalBerhasilEl.style.display = "none";
              if (!document.querySelector(".modal.show, .konfirmasi-hapus-overlay.show")) {
                document.body.style.overflow = "";
              }
            }
          },{ once: true });
      }
    }

    document.getElementById("btnSelesai")?.addEventListener("click", () => {
      clearTimeout(successModalTimeout);
      hideSuccessModal();
    });

    function initUploadAreas() {
      document.querySelectorAll(".upload-area").forEach((uploadArea) => {
        const fileInput = uploadArea.querySelector('input[type="file"]');
        const uploadText = uploadArea.querySelector("p");
        const uploadIcon = uploadArea.querySelector("i");
        const feedbackEl = document.getElementById("file-size-feedback");
        if (!fileInput || !uploadText || !uploadIcon) return;
        const originalText = uploadText.innerHTML;
        const originalIconClass = uploadIcon.className;
        uploadArea.addEventListener("click", () => fileInput.click());
        function handleFiles(files) {
          if (files.length > 0) {
            const file = files[0];
            const fileName = file.name.toLowerCase();
            uploadText.textContent = file.name;
            if (fileName.endsWith(".pdf")) {
              uploadIcon.className = "fas fa-file-pdf text-success";
            } else if (fileName.endsWith(".doc") || fileName.endsWith(".docx")) {
              uploadIcon.className = "fas fa-file-word text-success";
            } else if (fileName.endsWith(".jpg") || fileName.endsWith(".jpeg") || fileName.endsWith(".png")) {
              uploadIcon.className = "fas fa-file-image text-success";
            } else {
              uploadIcon.className = "fas fa-file text-success";
            }
            if (feedbackEl) {
              feedbackEl.textContent = "";
              feedbackEl.style.display = "none";
            }
          } else {
            resetUpload();
          }
        }
        function resetUpload() {
          uploadText.innerHTML = originalText;
          uploadIcon.className = originalIconClass;
          fileInput.value = "";
          if (feedbackEl) {
            feedbackEl.textContent = "";
            feedbackEl.style.display = "none";
          }
        }
        fileInput.addEventListener("change", function () { handleFiles(this.files); });
        uploadArea.addEventListener("dragover", (e) => { e.preventDefault(); uploadArea.classList.add("drag-over"); });
        uploadArea.addEventListener("dragleave", () => { uploadArea.classList.remove("drag-over"); });
        uploadArea.addEventListener("drop", (e) => { e.preventDefault(); uploadArea.classList.remove("drag-over"); handleFiles(e.dataTransfer.files); });
        uploadArea.reset = resetUpload;
      });
    }

    function initPelatihanModal() {
    const pelatihanModalEl = document.getElementById("pelatihanModal");
    if (!pelatihanModalEl) return;
    const bsModal = new bootstrap.Modal(pelatihanModalEl);
    const form = document.getElementById("pelatihanForm");
    const saveButton = pelatihanModalEl.querySelector(".btn-success");
    const modalTitle = pelatihanModalEl.querySelector(".modal-title");
    const idInput = document.getElementById("pelatihan_id");
    const fileInput = form.dokumen;
    const fileSizeFeedbackEl = document.getElementById("file-size-feedback");

    // === Inisialisasi Select2 untuk nama pegawai ===
    const pegawaiSelect = $("#pegawai-select");
    if (pegawaiSelect.length) {
      pegawaiSelect.select2({
        theme: "bootstrap-5",
        placeholder: "-- Pilih Pegawai --",
        dropdownParent: $("#pelatihanModal .modal-content"),
      });
    }

    function showFileSizeError(message) {
      if (fileSizeFeedbackEl) {
        fileSizeFeedbackEl.textContent = message;
        fileSizeFeedbackEl.style.display = "block";
      }
    }

    function hideFileSizeError() {
      if (fileSizeFeedbackEl) {
        fileSizeFeedbackEl.textContent = "";
        fileSizeFeedbackEl.style.display = "none";
      }
    }

    // === Saat modal ditampilkan ===
    pelatihanModalEl.addEventListener("show.bs.modal", async (event) => {
      const button = event.relatedTarget;
      const isEditMode = button?.classList.contains("btn-edit");

      // 🔹 Tambahkan baris ini
      if (isEditMode) {
        saveButton.textContent = "Simpan Perubahan";
      } else {
        saveButton.textContent = "Simpan";
      }

      // Reset form dan upload area
      form.reset();
      pelatihanModalEl.querySelector(".upload-area")?.reset();
      form.querySelector('input[name="_method"]')?.remove();
      hideFileSizeError();
      $("#posisi-lainnya-input").removeClass("show");
      pegawaiSelect.val(null).trigger("change");

      fileInput.required = !isEditMode;

      if (isEditMode) {
        modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Diklat';
        const pelatihanId = button.dataset.id;
        idInput.value = pelatihanId;

        const methodInput = document.createElement("input");
        methodInput.type = "hidden";
        methodInput.name = "_method";
        methodInput.value = "PUT";
        form.prepend(methodInput);

        try {
          const response = await fetch(`/pelatihan/${pelatihanId}/edit`);
          if (!response.ok) throw new Error("Gagal memuat data");
          const data = await response.json();

          // Isi semua field termasuk Select2
          for (const key in data) {
            if (Object.hasOwnProperty.call(data, key)) {
              const field = form.elements[key];
              if (field) {
                if (field.type === "date") {
                  field.value = data[key] ? data[key].split("T")[0] : "";
                } else if (key === "struktural" || key === "sertifikasi") {
                  field.value = data[key] ? "Ya" : "Tidak";
                } else {
                  field.value = data[key];
                }
              }
            }
          }

          // Set Select2 old value
          if (data.pegawai_id) {
            pegawaiSelect.val(data.pegawai_id).trigger("change");
          }

          if (data.posisi === "Lainnya") {
            $("#posisi-lainnya-input").addClass("show");
            form.posisi_lainnya.value = data.posisi_lainnya || "";
          }

          pelatihanModalEl.querySelector(".upload-area p").innerHTML =
            "Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small>";
        } catch (error) {
          console.error("Gagal memuat data edit:", error);
          alert("Gagal memuat data. Silakan coba lagi.");
          bsModal.hide();
        }
      } else {
        modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Diklat';
        idInput.value = "";
      }
    });

    // === Saat modal ditutup ===
    pelatihanModalEl.addEventListener("hidden.bs.modal", () => {
      form.reset();
      pegawaiSelect.val(null).trigger("change");
      $("#posisi-lainnya-input").hide().val("");
    });

    // === Tombol Simpan ===
    saveButton.addEventListener("click", async (event) => {
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
      const url = isEditMode ? `/pelatihan/${pelatihanId}` : "/pelatihan";
      const formData = new FormData(form);

      saveButton.disabled = true;
      saveButton.innerHTML =
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';

      try {
        const response = await fetch(url, {
          method: "POST",
          body: formData,
          headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            Accept: "application/json",
          },
        });

        const data = await response.json();
        if (!response.ok) throw new Error(data.message || "Gagal menyimpan data");

        if (data.success) {
          bsModal.hide();
          showSuccessModal(
            isEditMode ? "Data Berhasil Diperbarui" : "Data Berhasil Disimpan",
            data.success,
            () => location.reload()
          );
        } else if (data.errors) {
          const errorMessages = Object.values(data.errors)
            .map((msg) => `- ${msg}`)
            .join("\n");
          alert(`Validasi Gagal:\n${errorMessages}`);
        } else {
          throw new Error(data.message || "Terjadi kesalahan yang tidak diketahui.");
        }
      } catch (error) {
        console.error("Gagal mengirim data:", error);
        alert(error.message || "Gagal mengirim data. Silakan cek konsol untuk detail.");
      } finally {
        saveButton.disabled = false;
        saveButton.innerHTML = "Simpan";
      }
    });
  }

    function initGlobalEventListeners() {
      const modalKonfirmasiHapus = document.getElementById("modalKonfirmasiHapus");
      if (!modalKonfirmasiHapus) return;
      const hapusTitle = modalKonfirmasiHapus.querySelector(".konfirmasi-hapus-title");
      const hapusSubtitle = modalKonfirmasiHapus.querySelector(".konfirmasi-hapus-subtitle");
      let dataToDelete = { id: null, nama: null };
      const btnKonfirmasi = document.getElementById("btnKonfirmasiHapus");
      function showDeleteModal() {
        modalKonfirmasiHapus.style.display = "flex";
        requestAnimationFrame(() => modalKonfirmasiHapus.classList.add("show"));
        document.body.style.overflow = "hidden";
      }
      function hideDeleteModal() {
        if (modalKonfirmasiHapus.classList.contains("show")) {
          modalKonfirmasiHapus.classList.remove("show");
          modalKonfirmasiHapus.addEventListener("transitionend",() => {
              if (!modalKonfirmasiHapus.classList.contains("show")) {
                modalKonfirmasiHapus.style.display = "none";
                if (!document.querySelector(".modal.show, .konfirmasi-hapus-overlay.show")) {
                  document.body.style.overflow = "";
                }
              }
            },{ once: true });
        }
      }
      document.body.addEventListener("click", async (event) => {
        const target = event.target;
        const detailButton = target.closest(".btn-lihat-detail-pelatihan");
        const hapusButton = target.closest(".btn-hapus");
        if (detailButton) {
          event.preventDefault();
          const data = detailButton.dataset;
          const fields = ["pegawai", "nama_kegiatan", "posisi", "kota", "lokasi", "penyelenggara", "jenis_diklat", "tgl_mulai", "tgl_selesai", "lingkup", "jam", "hari", "struktural", "sertifikasi","jenis_dokumen",
            "nama_dokumen",
            "nomor_dokumen",
            "tautan"];
          fields.forEach((field) => {
            const el = document.getElementById(`detail_pelatihan_${field}`);
            if (el) {
                // 2. Logika khusus untuk membuat Link bisa diklik
                if (field === 'tautan' && data[field] && data[field] !== '-') {
                    el.innerHTML = `<a href="${data[field]}" target="_blank" class="text-primary text-decoration-underline">${data[field]}</a>`;
                } else {
                    el.textContent = data[field] || "-";
                }
            }
          });
          
          document.getElementById("detail_pelatihan_document_viewer")?.setAttribute("src", data.dokumen_path || "");
        }
        if (hapusButton && hapusButton.hasAttribute("data-id")) {
          event.preventDefault();
          dataToDelete.id = hapusButton.dataset.id;
          dataToDelete.nama = hapusButton.dataset.nama || "data ini";
          hapusTitle.textContent = "Apakah Anda Yakin?";
          hapusSubtitle.textContent = `Data milik ${dataToDelete.nama} akan dihapus permanen.`;
          showDeleteModal();
        }
        if (target.matches("#btnKonfirmasiHapus")) {
          event.preventDefault();
          if (!dataToDelete || !dataToDelete.id) return;
          const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
          btnKonfirmasi.disabled = true;
          btnKonfirmasi.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menghapus...';
          try {
            const response = await fetch(`/pelatihan/${dataToDelete.id}`, { method: "DELETE", headers: { "X-CSRF-TOKEN": csrfToken, Accept: "application/json" } });
            const result = await response.json();
            if (!response.ok || !result.success) throw new Error(result.message || "Gagal menghapus");
            hideDeleteModal();
            showSuccessModal("Berhasil Dihapus!", result.message, () => location.reload());
          } catch (error) {
            console.error("Gagal menghapus data:", error);
            alert(error.message || "Gagal menghapus data.");
            hideDeleteModal();
          } finally {
            dataToDelete = { id: null, nama: null };
            btnKonfirmasi.disabled = false;
            btnKonfirmasi.innerHTML = "Ya, Hapus";
          }
        }
        if (target.matches("#btnBatalHapus") || target.matches(".konfirmasi-hapus-overlay:not(.konfirmasi-hapus-box)")) {
          hideDeleteModal();
        }
      });
      document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && modalKonfirmasiHapus.classList.contains("show")) {
          hideDeleteModal();
        }
      });
    }

    function initPosisiLainnya() {
      const posisiSelect = document.getElementById("posisi-pelatihan-select");
      const posisiLainnyaInput = document.getElementById("posisi-lainnya-input");
      if (!posisiSelect || !posisiLainnyaInput) return;
      posisiSelect.addEventListener("change", function () {
        posisiLainnyaInput.classList.toggle("show", this.value === "Lainnya");
        if (this.value !== "Lainnya") posisiLainnyaInput.value = "";
      });
    }

    function initDateInputs() {
      document.querySelectorAll('input[type="date"]').forEach((el) => {
        el.style.cursor = "pointer";
        el.addEventListener("click", function () { this.showPicker && this.showPicker(); });
      });
    }

    function initSearchAutoSubmit() {
      const searchInput = document.getElementById("searchInput");
      const searchForm = document.getElementById("searchForm");
      let typingTimer;
      if (searchInput && searchForm) {
        searchInput.addEventListener("keyup", function () {
          clearTimeout(typingTimer);
          typingTimer = setTimeout(() => { searchForm.submit(); }, 500);
        });
      }
    }
    
    // Panggil semua fungsi inisialisasi
    initSearchAutoSubmit();
    initUploadAreas();
    initPelatihanModal();
    initGlobalEventListeners();
    initPosisiLainnya();
    initDateInputs();
  });
})();