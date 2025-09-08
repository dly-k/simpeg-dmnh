(function () {
  document.addEventListener("DOMContentLoaded", function () {
    // == Reset Query String (Search & Filter) saat Reload ==
    const url = new URL(window.location);
    let hasQuery = false;

    // daftar parameter yang mau direset
    ["q", "semester"].forEach((param) => {
      if (url.searchParams.has(param)) {
        url.searchParams.delete(param);
        hasQuery = true;
      }
    });

    if (hasQuery) {
      window.history.replaceState({}, document.title, url.pathname);
    }

    // == Inisialisasi Area Unggah ==
    function initUploadArea(areaId, inputId) {
      const area = document.getElementById(areaId);
      const input = document.getElementById(inputId);
      if (!area || !input) return;

      const defaultHTML = area.innerHTML;

      area.addEventListener("click", () => input.click());

      area.addEventListener("dragover", (e) => {
        e.preventDefault();
        area.classList.add("dragover");
      });

      area.addEventListener("dragleave", () =>
        area.classList.remove("dragover")
      );

      area.addEventListener("drop", (e) => {
        e.preventDefault();
        area.classList.remove("dragover");
        if (e.dataTransfer.files.length) {
          input.files = e.dataTransfer.files;
          displayFileName(area, e.dataTransfer.files[0]);
        }
      });

      input.addEventListener("change", function () {
        if (this.files.length) {
          displayFileName(area, this.files[0]);
        }
      });

      function displayFileName(element, file) {
        element.innerHTML = `
          <i class="fas fa-file-pdf text-success"></i>
          <p>${file.name}</p>
        `;
      }

      document
        .getElementById("suratTugasModal")
        ?.addEventListener("hidden.bs.modal", () => {
          area.innerHTML = defaultHTML;
          input.value = "";
        });
    }

    initUploadArea("uploadArea", "dokumen");
    document.querySelectorAll("[id^='uploadAreaEdit']").forEach((area) => {
      const idSuffix = area.id.replace("uploadAreaEdit", "");
      initUploadArea(`uploadAreaEdit${idSuffix}`, `dokumenEdit${idSuffix}`);
    });

    // == Modal Create: Buka Otomatis dan Reset ==
    const modalCreate = document.getElementById("suratTugasModal");
    if (modalCreate) {
      modalCreate.addEventListener("hidden.bs.modal", function () {
        setTimeout(() => {
          const form = modalCreate.querySelector("form");
          if (form) {
            form.querySelectorAll("input, textarea, select").forEach((el) => {
              if (el.type !== "hidden" && el.type !== "file") el.value = "";
              if (el.type === "file") el.value = null;
            });
            modalCreate
              .querySelectorAll(".text-danger")
              .forEach((el) => (el.innerText = ""));
          }
        }, 200);
      });

      if (modalCreate.dataset.show === "true") {
        new bootstrap.Modal(modalCreate).show();
      }
    }

    // == Modal Sukses ==
    const modalBerhasil = document.getElementById("modalBerhasil");
    const berhasilTitle = document.getElementById("berhasil-title");
    const berhasilSubtitle = document.getElementById("berhasil-subtitle");
    let successModalTimeout = null;

    function showSuccessModal(title, subtitle, callback = null) {
      if (!modalBerhasil) return;
      berhasilTitle.textContent = title;
      berhasilSubtitle.textContent = subtitle;
      modalBerhasil.style.display = "flex";
      requestAnimationFrame(() => modalBerhasil.classList.add("show"));
      document.body.style.overflow = "hidden";

      const successAudio = new Audio("/assets/sounds/success.mp3");
      successAudio.play().catch(() => {});

      clearTimeout(successModalTimeout);
      successModalTimeout = setTimeout(() => {
        hideSuccessModal();
        if (typeof callback === "function") callback();
      }, 1500);
    }

    function hideSuccessModal() {
      if (modalBerhasil?.classList.contains("show")) {
        modalBerhasil.classList.remove("show");
        modalBerhasil.addEventListener(
          "transitionend",
          () => {
            if (!modalBerhasil.classList.contains("show")) {
              modalBerhasil.style.display = "none";
              if (!document.querySelector(".modal.show")) {
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

    const successMessage = document.querySelector(
      "meta[name='flash-success']"
    )?.content;
    if (successMessage) showSuccessModal("Berhasil!", successMessage);

    // == Modal Konfirmasi Hapus ==
    const modalHapus = document.getElementById("modalKonfirmasiHapus");
    if (modalHapus) {
      const hapusTitle = modalHapus.querySelector(".konfirmasi-hapus-title");
      const hapusSubtitle = modalHapus.querySelector(".konfirmasi-hapus-subtitle");
      let dataToDelete = { id: null, nama: null };

      function showDeleteModal() {
        modalHapus.style.display = "flex";
        requestAnimationFrame(() => modalHapus.classList.add("show"));
        document.body.style.overflow = "hidden";
      }

      function hideDeleteModal() {
        modalHapus.classList.remove("show");
        modalHapus.addEventListener(
          "transitionend",
          () => {
            modalHapus.style.display = "none";
            if (!document.querySelector(".modal.show"))
              document.body.style.overflow = "";
          },
          { once: true }
        );
      }

      document.body.addEventListener("click", async (e) => {
        const btn = e.target.closest(".btn-hapus");

        if (btn?.dataset.id) {
          e.preventDefault();
          dataToDelete.id = btn.dataset.id;
          dataToDelete.nama = btn.dataset.nama;
          hapusTitle.textContent = "Apakah Anda Yakin?";
          hapusSubtitle.textContent = `Data untuk ${dataToDelete.nama} akan dihapus permanen`;
          showDeleteModal();
        }

        if (e.target.id === "btnKonfirmasiHapus") {
          e.preventDefault();
          if (!dataToDelete.id) return;

          const csrf = document.querySelector('meta[name="csrf-token"]').content;
          e.target.disabled = true;
          e.target.innerHTML =
            '<span class="spinner-border spinner-border-sm"></span> Menghapus...';

          try {
            const res = await fetch(`/surat-tugas/${dataToDelete.id}`, {
              method: "DELETE",
              headers: { "X-CSRF-TOKEN": csrf, Accept: "application/json" },
            });
            const data = await res.json();
            if (!res.ok || !data.success)
              throw new Error(data.message || "Gagal menghapus");

            hideDeleteModal();
            setTimeout(
              () =>
                showSuccessModal(
                  "Berhasil Dihapus!",
                  data.message,
                  () => location.reload()
                ),
              200
            );
          } catch (err) {
            alert(err.message || "Gagal menghapus data.");
            hideDeleteModal();
          } finally {
            dataToDelete = { id: null, nama: null };
            e.target.disabled = false;
            e.target.innerHTML = "Ya, Hapus";
          }
        }

        if (e.target.id === "btnBatalHapus" || e.target === modalHapus) {
          hideDeleteModal();
        }
      });
    }

    // == Peningkatan Datepicker ==
    document.querySelectorAll('input[type="date"]').forEach((el) => {
      el.style.cursor = "pointer";
      el.addEventListener("click", function () {
        this.showPicker && this.showPicker();
      });
    });

        // == Auto-submit Search dengan Debounce ==
    function initSearchAutoSubmit() {
      const searchInput = document.getElementById("searchInput");
      const searchForm = document.getElementById("searchForm");
      let typingTimer;

      if (searchInput && searchForm) {
        searchInput.addEventListener("keyup", function (e) {
          // cegah submit langsung pakai Enter
          if (e.key === "Enter") {
            e.preventDefault();
            return;
          }

          clearTimeout(typingTimer);
          typingTimer = setTimeout(() => {
            searchForm.submit();
          }, 500); // delay 500ms biar gak spam
        });
      }
    }

    // panggil fungsi search
    initSearchAutoSubmit();
    
  });
})();