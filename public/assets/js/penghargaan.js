(function () {
  document.addEventListener("DOMContentLoaded", function () {
    // == Pengaturan Global untuk Modal dan Suara ==
    const modalBerhasilEl = document.getElementById("modalBerhasil");
    const berhasilTitle = document.getElementById("berhasil-title");
    const berhasilSubtitle = document.getElementById("berhasil-subtitle");
    let successModalTimeout = null;

    function showSuccessModal(title, subtitle, callback = null) {
      if (!modalBerhasilEl || !berhasilTitle || !berhasilSubtitle) return;

      berhasilTitle.textContent = title;
      berhasilSubtitle.textContent = subtitle;
      modalBerhasilEl.style.display = "flex";
      modalBerhasilEl.classList.add("show");
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
        modalBerhasilEl.addEventListener(
          "transitionend",
          () => {
            if (!modalBerhasilEl.classList.contains("show")) {
              modalBerhasilEl.style.display = "none";
              if (!document.querySelector(".modal.show, .konfirmasi-hapus-overlay.show")) {
                document.body.style.overflow = "";
              }
            }
          },
          { once: true }
        );
      }
    }

    document.getElementById("btnSelesai")?.addEventListener("click", () => {
      clearTimeout(successModalTimeout);
      hideSuccessModal();
    });

    // == Inisialisasi Area Unggah (Klik + Drag & Drop + Icon Update) ==
    function initUploadAreas() {
      document.querySelectorAll(".upload-area").forEach((uploadArea) => {
        const fileInput = uploadArea.querySelector('input[type="file"]');
        const uploadText = uploadArea.querySelector("p");
        const uploadIcon = uploadArea.querySelector("i");
        const feedbackEl = document.getElementById("file-size-feedback");

        if (!fileInput || !uploadText || !uploadIcon || !feedbackEl) return;

        const originalText = uploadText.innerHTML;
        const originalIconClass = uploadIcon.className;

        // Klik untuk membuka dialog file
        uploadArea.addEventListener("click", () => fileInput.click());

        // Fungsi untuk menampilkan file yang dipilih
        function handleFiles(files) {
          if (files.length > 0) {
            const file = files[0];

            // Validasi ukuran (max 5 MB)
            if (file.size > 5 * 1024 * 1024) {
              feedbackEl.textContent = "Ukuran file melebihi 5 MB!";
              feedbackEl.style.display = "block";
              fileInput.value = "";
              uploadText.innerHTML = originalText;
              uploadIcon.className = originalIconClass;
              return;
            } else {
              feedbackEl.textContent = "";
              feedbackEl.style.display = "none";
            }

            // Tampilkan nama file dan ubah ikon
            fileInput.files = files;
            uploadText.textContent = file.name;
            uploadIcon.className = "fas fa-file-pdf text-success";
          } else {
            uploadText.innerHTML = originalText;
            uploadIcon.className = originalIconClass;
          }
        }

        // Event input file biasa
        fileInput.addEventListener("change", function () {
          handleFiles(this.files);
        });

        // Event Drag & Drop
        uploadArea.addEventListener("dragover", (e) => {
          e.preventDefault();
          uploadArea.classList.add("drag-over");
        });

        uploadArea.addEventListener("dragleave", () => {
          uploadArea.classList.remove("drag-over");
        });

        uploadArea.addEventListener("drop", (e) => {
          e.preventDefault();
          uploadArea.classList.remove("drag-over");
          const files = e.dataTransfer.files;
          handleFiles(files);
        });

        // Fungsi reset area unggah
        uploadArea.reset = () => {
          uploadText.innerHTML = originalText;
          uploadIcon.className = originalIconClass;
          fileInput.value = "";
          feedbackEl.textContent = "";
          feedbackEl.style.display = "none";
        };
      });
    }

    // == Inisialisasi Modal Penghargaan ==
    function initPenghargaanModal() {
      const penghargaanModalEl = document.getElementById("penghargaanModal");
      if (!penghargaanModalEl) return;

      const bsModal = new bootstrap.Modal(penghargaanModalEl);
      const form = document.getElementById("penghargaanForm");
      const saveButton = penghargaanModalEl.querySelector(".btn-success");
      const modalTitle = penghargaanModalEl.querySelector(".modal-title");
      const idInput = document.getElementById("penghargaan_id");
      const fileInput = form.dokumen;
      const fileSizeFeedbackEl = document.getElementById("file-size-feedback");

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

      penghargaanModalEl.addEventListener("show.bs.modal", async (event) => {
        const button = event.relatedTarget;
        const isEditMode = button?.hasAttribute("data-id");

        form.reset();
        penghargaanModalEl.querySelector(".upload-area")?.reset();
        form.querySelector('input[name="_method"]')?.remove();
        hideFileSizeError();

        fileInput.required = !isEditMode;

        if (isEditMode) {
          modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Penghargaan';
          const penghargaanId = button.dataset.id;
          idInput.value = penghargaanId;

          const methodInput = document.createElement("input");
          methodInput.type = "hidden";
          methodInput.name = "_method";
          methodInput.value = "POST";
          form.prepend(methodInput);

          try {
            const response = await fetch(`/penghargaan/${penghargaanId}/edit`);
            if (!response.ok) throw new Error("Gagal memuat data");
            const data = await response.json();
            
            // ==========================================================
            // == PERUBAHAN UTAMA ADA DI SINI ==
            form.pegawai_id.value = data.pegawai_id || "";
            // ==========================================================

            form.kegiatan.value = data.kegiatan || "";
            form.nama_penghargaan.value = data.nama_penghargaan || "";
            form.nomor_sk.value = data.nomor_sk || "";
            form.tanggal_perolehan.value = data.tanggal_perolehan || "";
            form.lingkup.value = data.lingkup || "";
            form.negara.value = data.negara || "";
            form.instansi_pemberi.value = data.instansi_pemberi || "";
            form.jenis_dokumen.value = data.jenis_dokumen || "";
            form.nama_dokumen.value = data.nama_dokumen || "";
            form.nomor_dokumen.value = data.nomor_dokumen || "";
            form.tautan.value = data.tautan || "";
            penghargaanModalEl.querySelector(".upload-area p").innerHTML =
              "Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small>";
          } catch (error) {
            console.error("Gagal memuat data edit:", error);
            alert("Gagal memuat data. Silakan coba lagi.");
            bsModal.hide();
          }
        } else {
          modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Penghargaan';
          idInput.value = "";
        }
      });

      saveButton.addEventListener("click", async (event) => {
        event.preventDefault();
        if (!form.checkValidity()) {
          form.reportValidity();
          return;
        }

        hideFileSizeError();

        if (fileInput.files.length > 0) {
          const file = fileInput.files[0];
          const maxSizeInBytes = 5 * 1024 * 1024; // 5 MB
          if (file.size > maxSizeInBytes) {
            showFileSizeError(
              `File terlalu besar! Maksimal 5 MB. File Anda ~${(file.size / 1024 / 1024).toFixed(2)} MB`
            );
            return;
          }
        }

        const penghargaanId = idInput.value;
        const isEditMode = !!penghargaanId;
        const url = isEditMode ? `/penghargaan/${penghargaanId}` : "/penghargaan";
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

          if (data.success) {
            bsModal.hide();
            showSuccessModal(
              isEditMode ? "Data Berhasil Diperbarui" : "Data Berhasil Disimpan",
              data.success,
              () => location.reload()
            );
          } else if (data.errors) {
            const errorMessages = Object.values(data.errors).map((msg) => `- ${msg}`).join("\n");
            alert(`Validasi Gagal:\n${errorMessages}`);
          } else {
            throw new Error(data.error || "Terjadi kesalahan yang tidak diketahui.");
          }
        } catch (error) {
          console.error("Gagal mengirim data:", error);
          alert("Gagal mengirim data. Silakan cek konsol untuk detail.");
        } finally {
          saveButton.disabled = false;
          saveButton.innerHTML = "Simpan";
        }
      });
    }

    function initDetailModal() {
      document.addEventListener("click", (event) => {
        const detailButton = event.target.closest(".btn-lihat-detail-penghargaan");
        if (!detailButton) return;

        const data = detailButton.dataset;
        const fields = [
          "pegawai",
          "kegiatan",
          "nama_penghargaan",
          "nomor",
          "tanggal_perolehan",
          "lingkup",
          "negara",
          "instansi",
          "jenis_dokumen",
          "nama_dokumen",
          "nomor_dokumen",
          "tautan",
        ];

        fields.forEach((field) => {
          const el = document.getElementById(`detail_penghargaan_${field}`);
          if (el) el.textContent = data[field] || "-";
        });
        document.getElementById("detail_penghargaan_document_viewer")?.setAttribute("src", data.dokumen_path || "");
      });
    }

    function initDeleteModal() {
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
          modalKonfirmasiHapus.addEventListener(
            "transitionend",
            () => {
              if (!modalKonfirmasiHapus.classList.contains("show")) {
                modalKonfirmasiHapus.style.display = "none";
                if (!document.querySelector(".modal.show, .modal-berhasil-overlay.show")) {
                  document.body.style.overflow = "";
                }
              }
            },
            { once: true }
          );
        }
      }

      document.body.addEventListener("click", async (event) => {
        const target = event.target;
        const hapusButton = target.closest(".btn-hapus");

        if (hapusButton && hapusButton.hasAttribute("data-id")) {
          event.preventDefault();
          dataToDelete.id = hapusButton.dataset.id;
          dataToDelete.nama = hapusButton.dataset.nama;
          hapusTitle.textContent = "Apakah Anda Yakin?";
          hapusSubtitle.textContent = `Data untuk ${dataToDelete.nama} akan dihapus permanen.`;
          showDeleteModal();
        }

        if (target.matches("#btnKonfirmasiHapus")) {
          event.preventDefault();
          if (!dataToDelete.id) return;

          const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
          btnKonfirmasi.disabled = true;
          btnKonfirmasi.innerHTML =
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menghapus...';

          try {
            const response = await fetch(`/penghargaan/${dataToDelete.id}`, {
              method: "DELETE",
              headers: {
                "X-CSRF-TOKEN": csrfToken,
                Accept: "application/json",
              },
            });
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

        if (target.matches("#btnBatalHapus") || target.closest(".konfirmasi-hapus-overlay:not(.konfirmasi-hapus-box)")) {
          hideDeleteModal();
        }
      });

      document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && modalKonfirmasiHapus.classList.contains("show")) {
          hideDeleteModal();
        }
      });
    }

    function initDateInputs() {
      document.querySelectorAll('input[type="date"]').forEach((el) => {
        el.style.cursor = "pointer";
        el.addEventListener("click", function () {
          this.showPicker && this.showPicker();
        });
      });
    }

    // == Auto-submit Search dengan Debounce ==
    function initSearchAutoSubmit() {
      const searchInput = document.getElementById("searchInput");
      const searchForm = document.getElementById("searchForm");
      let typingTimer;

      if (searchInput && searchForm) {
        searchInput.addEventListener("keyup", function () {
          clearTimeout(typingTimer);
          typingTimer = setTimeout(() => {
            searchForm.submit();
          }, 500); // delay 500ms biar gak spam
        });
      }
    }

    window.addEventListener("pageshow", function (event) {
      if (event.persisted || (performance?.navigation?.type === 1)) {
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput) {
          searchInput.value = "";
        }

        const cleanUrl = location.origin + location.pathname;
        window.location.href = cleanUrl;
      }
    });

    // == Panggil semua fungsi ==
    initSearchAutoSubmit()
    initUploadAreas();
    initPenghargaanModal();
    initDetailModal();
    initDeleteModal();
    initDateInputs();
  });
})();