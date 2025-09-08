(function () {
  document.addEventListener("DOMContentLoaded", function () {
    // == Inisialisasi Area Unggah ==
    function initUploadAreas() {
      document.querySelectorAll(".upload-area").forEach((area) => {
        const inputSel = area.getAttribute("data-target");
        const fileInput = inputSel
          ? document.querySelector(inputSel)
          : area.querySelector('input[type="file"]');
        if (!fileInput) return;

        const defaultIcon = area.querySelector(".default-icon");
        const fileIcon    = area.querySelector(".file-icon");
        const uploadText  = area.querySelector(".upload-text");
        const fileName    = area.querySelector(".file-name");
        const feedbackEl  = document.getElementById("file-size-feedback-sk");

        function resetUploadArea() {
          if (feedbackEl) {
            feedbackEl.style.display = "none";
            feedbackEl.textContent = "";
          }
          fileInput.value = "";
          defaultIcon?.classList.remove("d-none");
          if (fileIcon) {
            fileIcon.classList.add("d-none");
            fileIcon.className = "file-icon"; // reset class ke default
          }
          uploadText?.classList.remove("d-none");
          if (fileName) {
            fileName.classList.add("d-none");
            fileName.textContent = "";
          }
        }

        // Set awal
        resetUploadArea();

        // Klik area → buka file dialog
        area.addEventListener("click", () => fileInput.click());

        // === Drag & Drop ===
        area.addEventListener("dragover", (e) => {
          e.preventDefault();
          area.classList.add("drag-over");
        });

        area.addEventListener("dragleave", () => {
          area.classList.remove("drag-over");
        });

        area.addEventListener("drop", (e) => {
          e.preventDefault();
          area.classList.remove("drag-over");

          if (e.dataTransfer.files && e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            fileInput.dispatchEvent(new Event("change", { bubbles: true }));
          }
        });

        // Perubahan file → ganti ikon jadi PDF hijau
        fileInput.addEventListener("change", function () {
          if (this.files && this.files.length) {
            defaultIcon?.classList.add("d-none");

            if (fileIcon) {
              fileIcon.classList.remove("d-none");
              fileIcon.className = "file-icon fas fa-file-pdf text-success"; // ubah ke PDF hijau
            }

            uploadText?.classList.add("d-none");
            if (fileName) {
              fileName.classList.remove("d-none");
              fileName.textContent = this.files[0].name;
            }
          } else {
            resetUploadArea();
          }
        });

        // Reset saat modal ditutup
        const modalEl = area.closest(".modal");
        if (modalEl) {
          modalEl.addEventListener("hidden.bs.modal", resetUploadArea);
        }
      });
    }

    // == Inisialisasi Modal SK Non PNS ==
    function initSkNonPnsModal() {
      const modalEl = document.getElementById("skNonPnsModal");
      if (!modalEl) return;

      const form = document.getElementById("skNonPnsForm");
      const modalTitle = document.getElementById("skNonPnsModalLabel");
      const editMethodContainer = document.getElementById("editMethod");
      const btnSimpan = document.getElementById("btn-simpan");
      const dokumenLamaContainer = document.getElementById("dokumen-lama-container");
      const dokumenLamaLink = document.getElementById("dokumen-lama-link");
      const dokumenLabel = document.getElementById("dokumen_label");
      const fileInput = document.getElementById("dokumen_sk");

      // Validasi ukuran file saat submit
      form.addEventListener("submit", function (event) {
        const file = fileInput.files[0];
        const feedbackEl = document.getElementById("file-size-feedback-sk");
        if (file) {
          const maxSizeInBytes = 5 * 1024 * 1024; // 5 MB
          if (file.size > maxSizeInBytes) {
            event.preventDefault();
            feedbackEl.textContent = `File terlalu besar! Maksimal 5 MB. (Ukuran: ${(file.size / 1024 / 1024).toFixed(2)} MB)`;
            feedbackEl.style.display = "block";
          }
        }
      });

      // Menangani event saat modal dibuka
      modalEl.addEventListener("show.bs.modal", async function (event) {
        const button = event.relatedTarget;
        const isEditMode = button && button.classList.contains("btn-edit");

        const feedbackEl = document.getElementById("file-size-feedback-sk");
        if (feedbackEl) feedbackEl.style.display = "none";

        form.reset();
        dokumenLamaContainer.style.display = "none";
        editMethodContainer.innerHTML = "";

        if (isEditMode) {
          const id = button.dataset.id;

          try {
            const response = await fetch(`/sk-non-pns/${id}/edit`);
            if (!response.ok) throw new Error("Gagal memuat data");
            const data = await response.json();

            document.getElementById("nama_pegawai").value = data.nama_pegawai || "";
            document.getElementById("nama_unit").value = data.nama_unit || "";
            document.getElementById("tanggal_mulai").value = data.tanggal_mulai || "";
            document.getElementById("tanggal_selesai").value = data.tanggal_selesai || "";
            document.getElementById("nomor_sk").value = data.nomor_sk || "";
            document.getElementById("tanggal_sk").value = data.tanggal_sk || "";
            document.getElementById("jenis_sk").value = data.jenis_sk || "";

            form.action = `/sk-non-pns/${id}`;
            editMethodContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data SK Non PNS';
            btnSimpan.textContent = "Simpan Perubahan";
            dokumenLabel.textContent = "Unggah Dokumen Baru (Opsional)";
            fileInput.required = false;

            if (data.dokumen_path) {
              dokumenLamaLink.href = `/storage/${data.dokumen_path.replace("public/", "")}`;
              dokumenLamaContainer.style.display = "block";
            }
          } catch (error) {
            console.error("Gagal memuat data edit:", error);
            modalTitle.innerHTML = '<i class="fas fa-times-circle"></i> Gagal Memuat Data';
          }
        } else {
          modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data SK Non PNS';
          form.action = "/sk-non-pns/store";
          btnSimpan.textContent = "Simpan";
          dokumenLabel.textContent = "Unggah Dokumen";
          fileInput.required = true;
        }
      });
    }

    // == Modal Sukses ==
    const modalBerhasil = document.getElementById("modalBerhasil");
    const berhasilTitle = document.getElementById("berhasil-title");
    const berhasilSubtitle = document.getElementById("berhasil-subtitle");
    let successModalTimeout = null;

    function showSuccessModal(title, subtitle, callback = null) {
      if (!modalBerhasil || !berhasilTitle || !berhasilSubtitle) return;

      berhasilTitle.textContent = title;
      berhasilSubtitle.textContent = subtitle;
      modalBerhasil.style.display = "flex";
      requestAnimationFrame(() => modalBerhasil.classList.add("show"));
      document.body.style.overflow = "hidden";

      const successAudio = new Audio("/assets/sounds/success.mp3");
      successAudio.play().catch((err) => console.warn("Gagal memutar audio:", err));

      clearTimeout(successModalTimeout);
      successModalTimeout = setTimeout(() => {
        hideSuccessModal();
        if (typeof callback === "function") callback();
      }, 2000);
    }

    function hideSuccessModal() {
      if (modalBerhasil?.classList.contains("show")) {
        modalBerhasil.classList.remove("show");
        modalBerhasil.addEventListener(
          "transitionend",
          () => {
            if (!modalBerhasil.classList.contains("show")) {
              modalBerhasil.style.display = "none";
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

    modalBerhasil?.addEventListener("click", function (event) {
      if (event.target === modalBerhasil) {
        hideSuccessModal();
      }
    });

    // == Inisialisasi Flash Success ==
    function initFlashSuccess() {
      const metaSuccess = document.querySelector('meta[name="flash-success"]');
      if (metaSuccess && metaSuccess.content) {
        showSuccessModal("Berhasil!", metaSuccess.content);
      }
    }

    // == Inisialisasi Aksi Tabel ==
    function initTableActions() {
      const konfirmasiHapusModalEl = document.getElementById("modalKonfirmasiHapus");
      if (!konfirmasiHapusModalEl) return;

      const hapusTitle = konfirmasiHapusModalEl.querySelector(".konfirmasi-hapus-title");
      const hapusSubtitle = konfirmasiHapusModalEl.querySelector(".konfirmasi-hapus-subtitle");
      let dataToDelete = { id: null, element: null, nama: null };

      function showDeleteModal() {
        konfirmasiHapusModalEl.style.display = "flex";
        requestAnimationFrame(() => konfirmasiHapusModalEl.classList.add("show"));
        document.body.style.overflow = "hidden";
      }

      function hideDeleteModal() {
        if (konfirmasiHapusModalEl.classList.contains("show")) {
          konfirmasiHapusModalEl.classList.remove("show");
          konfirmasiHapusModalEl.addEventListener(
            "transitionend",
            () => {
              if (!konfirmasiHapusModalEl.classList.contains("show")) {
                konfirmasiHapusModalEl.style.display = "none";
                if (!document.querySelector(".modal.show, .modal-berhasil-overlay.show")) {
                  document.body.style.overflow = "";
                }
              }
            },
            { once: true }
          );
        }
      }

      document.body.addEventListener("click", async function (event) {
        const target = event.target;
        const button = target.closest("a, button");

        if (button) {
          const detailButton = target.closest(".btn-lihat-detail");
          if (detailButton) {
            event.preventDefault();
            const data = detailButton.dataset;
            const setText = (id, value) => {
              const el = document.getElementById(id);
              if (el) el.textContent = value || "-";
            };
            setText("detail_sk_nomor_sk", data.nomor_sk);
            setText("detail_sk_tanggal_sk", data.tanggal_sk);
            setText("detail_sk_pegawai", data.pegawai);
            setText("detail_sk_unit", data.unit);
            setText("detail_sk_jenis_sk", data.jenis_sk);
            setText("detail_sk_tgl_mulai", data.tgl_mulai);
            setText("detail_sk_tgl_selesai", data.tgl_selesai);
            document.getElementById("detail_sk_document_viewer")?.setAttribute("src", data.dokumen_path || "");
          }

          const hapusButton = target.closest(".btn-hapus");
          if (hapusButton && hapusButton.hasAttribute("data-id")) {
            event.preventDefault();
            dataToDelete.id = hapusButton.dataset.id;
            dataToDelete.nama = hapusButton.dataset.nama;
            dataToDelete.element = hapusButton.closest("tr");
            hapusTitle.textContent = "Apakah Anda Yakin?";
            hapusSubtitle.textContent = `Data untuk ${dataToDelete.nama} akan dihapus permanen.`;
            showDeleteModal();
          }

          if (target.matches("#btnKonfirmasiHapus")) {
            event.preventDefault();
            if (!dataToDelete.id) return;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            target.disabled = true;
            target.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menghapus...';

            try {
              const response = await fetch(`/sk-non-pns/${dataToDelete.id}`, {
                method: "DELETE",
                headers: { "X-CSRF-TOKEN": csrfToken, Accept: "application/json" },
              });
              const result = await response.json();
              if (!response.ok || !result.success) throw new Error(result.message || "Gagal menghapus");

              hideDeleteModal();
              setTimeout(() => {
                showSuccessModal("Berhasil Dihapus!", result.message);
                setTimeout(() => location.reload(), 1000);
              }, 300);
            } catch (error) {
              console.error("Gagal menghapus data:", error);
              alert(error.message || "Gagal menghapus data.");
              hideDeleteModal();
            } finally {
              dataToDelete = { id: null, element: null, nama: null };
              target.disabled = false;
              target.innerHTML = "Ya, Hapus";
            }
          }

          if (target.matches("#btnBatalHapus")) {
            hideDeleteModal();
          }
        }
      });

      document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && konfirmasiHapusModalEl.classList.contains("show")) {
          hideDeleteModal();
        }
      });

      konfirmasiHapusModalEl.addEventListener("click", function (event) {
        if (event.target === konfirmasiHapusModalEl) {
          hideDeleteModal();
        }
      });
    }

    // == Peningkatan Input Tanggal ==
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

    // Reset search saat reload/back
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

    // == Inisialisasi Fungsi Utama ==
    initSearchAutoSubmit()
    initUploadAreas();
    initSkNonPnsModal();
    initTableActions();
    initFlashSuccess();
    initDateInputs();
  });
})();