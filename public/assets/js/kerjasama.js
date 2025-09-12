(function () {
  document.addEventListener("DOMContentLoaded", function () {
    const kerjasamaModal = document.getElementById("kerjasamaModal");

    // ====================================================
    // Auto buka modal tambah kalau ada error validasi
    // ====================================================
    if (kerjasamaModal && kerjasamaModal.dataset.hasError === "true") {
      new bootstrap.Modal(kerjasamaModal).show();
    }

    // ====================================================
    // Upload Area (drag & drop)
    // ====================================================
    function setupUpload(areaId, inputId) {
      const uploadArea = document.getElementById(areaId);
      const fileInput = document.getElementById(inputId);
      if (!uploadArea || !fileInput) return;

      const icon = uploadArea.querySelector("i");
      const text = uploadArea.querySelector(".upload-text");

      function updateUI(file) {
        if (!file) return;
        const ext = file.name.split(".").pop().toLowerCase();

        icon.className = "fas";
        if (ext === "pdf") icon.classList.add("fa-file-pdf", "text-success");
        else if (["doc", "docx"].includes(ext)) icon.classList.add("fa-file-word", "text-primary");
        else if (["png", "jpg", "jpeg"].includes(ext)) icon.classList.add("fa-file-image", "text-info");
        else icon.classList.add("fa-file", "text-secondary");

        text.innerHTML = `<strong>${file.name}</strong><br><small>File siap diunggah</small>`;
      }

      uploadArea.addEventListener("click", () => fileInput.click());
      uploadArea.addEventListener("dragover", (e) => {
        e.preventDefault();
        uploadArea.classList.add("dragover");
      });
      uploadArea.addEventListener("dragleave", () => uploadArea.classList.remove("dragover"));
      uploadArea.addEventListener("drop", (e) => {
        e.preventDefault();
        uploadArea.classList.remove("dragover");
        if (e.dataTransfer.files.length > 0) {
          fileInput.files = e.dataTransfer.files;
          updateUI(e.dataTransfer.files[0]);
        }
      });
      fileInput.addEventListener("change", () => {
        if (fileInput.files.length > 0) updateUI(fileInput.files[0]);
      });
    }

    document.querySelectorAll(".upload-area").forEach((area) => {
      const input = area.parentElement.querySelector("input[type='file']");
      if (area.id && input?.id) setupUpload(area.id, input.id);
    });

    // ====================================================
    // Reset Validasi hanya untuk Modal Tambah
    // ====================================================
    if (kerjasamaModal) {
      kerjasamaModal.addEventListener("hidden.bs.modal", function () {
        this.querySelectorAll(".is-invalid").forEach((el) => el.classList.remove("is-invalid"));
        this.querySelectorAll(".text-danger").forEach((el) => el.remove());
      });
    }

    // ====================================================
    // Modal Sukses
    // ====================================================
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
      }, 2000);
    }

    function hideSuccessModal() {
      if (!modalBerhasil?.classList.contains("show")) return;
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

    document.getElementById("btnSelesai")?.addEventListener("click", () => {
      clearTimeout(successModalTimeout);
      hideSuccessModal();
    });

    const successMessage = document.querySelector("meta[name='flash-success']")?.content;
    if (successMessage) showSuccessModal("Berhasil!", successMessage);

    // ====================================================
    // Modal Konfirmasi Hapus
    // ====================================================
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
            if (!document.querySelector(".modal.show")) {
              document.body.style.overflow = "";
            }
          },
          { once: true }
        );
      }

      document.body.addEventListener("click", async (e) => {
        const btn = e.target.closest(".btn-hapus");

        if (btn?.dataset.id) {
          e.preventDefault();
          dataToDelete = { id: btn.dataset.id, nama: btn.dataset.nama };
          hapusTitle.textContent = "Apakah Anda Yakin?";
          hapusSubtitle.textContent = `Data untuk ${dataToDelete.nama} akan dihapus permanen`;
          showDeleteModal();
        }

        if (e.target.id === "btnKonfirmasiHapus") {
          e.preventDefault();
          if (!dataToDelete.id) return;

          const csrf = document.querySelector('meta[name="csrf-token"]').content;
          e.target.disabled = true;
          e.target.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menghapus...';

          try {
            const res = await fetch(`/kerjasama/${dataToDelete.id}`, {
              method: "DELETE",
              headers: { "X-CSRF-TOKEN": csrf, Accept: "application/json" },
            });
            const data = await res.json();
            if (!res.ok || !data.success) throw new Error(data.message || "Gagal menghapus");

            hideDeleteModal();
            setTimeout(() => showSuccessModal("Berhasil Dihapus!", data.message, () => location.reload()), 200);
          } catch (err) {
            alert(err.message || "Gagal menghapus data.");
            hideDeleteModal();
          } finally {
            dataToDelete = { id: null, nama: null };
            e.target.disabled = false;
            e.target.innerHTML = "Ya, Hapus";
          }
        }

        if (e.target.id === "btnBatalHapus" || e.target === modalHapus) hideDeleteModal();
      });
    }

    // ====================================================
    // Enhancement Input Date
    // ====================================================
    document.querySelectorAll('input[type="date"]').forEach((el) => {
      el.style.cursor = "pointer";
      el.addEventListener("click", () => el.showPicker && el.showPicker());
    });

    // ====================================================
    // Auto-submit Search dengan Debounce
    // ====================================================
    (function initSearchAutoSubmit() {
      const searchInput = document.getElementById("searchInput");
      const searchForm = document.getElementById("searchForm");
      let typingTimer;

      if (searchInput && searchForm) {
        searchInput.addEventListener("keyup", function (e) {
          if (e.key === "Enter") {
            e.preventDefault();
            return;
          }
          clearTimeout(typingTimer);
          typingTimer = setTimeout(() => searchForm.submit(), 500);
        });
      }
    })();

    // ====================================================
    // Dinamis Ketua & Anggota (Tambah)
    // ====================================================
    let anggotaIndex = document.querySelectorAll("#anggota-list .anggota-item").length;
    let ketuaIndex = document.querySelectorAll("#ketua-list .ketua-item").length;

    const anggotaList = document.getElementById("anggota-list");
    const ketuaList = document.getElementById("ketua-list");

    function updateButtons(listSelector, btnClass) {
      document.querySelectorAll(`${listSelector} ${btnClass}`).forEach((btn, idx) => {
        btn.style.display = idx === 0 ? "none" : "inline-block";
      });
    }

    // Tambah anggota
    document.getElementById("add-anggota-btn")?.addEventListener("click", function () {
      const div = document.createElement("div");
      div.className = "d-flex gap-2 mb-2 anggota-item";
      div.innerHTML = `
        <input type="text" name="anggota[${anggotaIndex}][nama]" class="form-control" placeholder="Nama Anggota">
        <select name="anggota[${anggotaIndex}][departemen]" class="form-select">
          <option selected disabled>-- Pilih Departemen --</option>
          <option value="Manajemen Hutan">Manajemen Hutan</option>
          <option value="Konservasi Sumberdaya Hutan">Konservasi Sumberdaya Hutan</option>
          <option value="Teknologi Hasil Hutan">Teknologi Hasil Hutan</option>
        </select>
        <button type="button" class="btn btn-danger remove-anggota">X</button>`;
      anggotaList.appendChild(div);
      anggotaIndex++;
      updateButtons("#anggota-list", ".remove-anggota");
    });

    anggotaList?.addEventListener("click", (e) => {
      if (e.target.classList.contains("remove-anggota")) {
        e.target.closest(".anggota-item").remove();
        updateButtons("#anggota-list", ".remove-anggota");
      }
    });

    // Tambah ketua
    document.getElementById("add-ketua-btn")?.addEventListener("click", function () {
      const div = document.createElement("div");
      div.className = "mb-2 ketua-item";
      div.innerHTML = `
        <div class="d-flex gap-2">
          <input type="text" name="ketua[${ketuaIndex}][nama]" class="form-control" placeholder="Nama Ketua">
          <select name="ketua[${ketuaIndex}][departemen]" class="form-select">
            <option selected disabled>-- Pilih Departemen --</option>
            <option value="Manajemen Hutan">Manajemen Hutan</option>
            <option value="Konservasi Sumberdaya Hutan">Konservasi Sumberdaya Hutan</option>
            <option value="Teknologi Hasil Hutan">Teknologi Hasil Hutan</option>
          </select>
          <button type="button" class="btn btn-danger remove-ketua">X</button>
        </div>`;
      ketuaList.appendChild(div);
      ketuaIndex++;
      updateButtons("#ketua-list", ".remove-ketua");
    });

    ketuaList?.addEventListener("click", (e) => {
      if (e.target.classList.contains("remove-ketua")) {
        e.target.closest(".ketua-item").remove();
        updateButtons("#ketua-list", ".remove-ketua");
      }
    });

    updateButtons("#anggota-list", ".remove-anggota");
    updateButtons("#ketua-list", ".remove-ketua");

    // ====================================================
    // Dinamis Ketua & Anggota (Edit Modal)
    // ====================================================
    document.querySelectorAll("[id^='editKerjasamaModal-']").forEach((modal) => {
      const anggotaList = modal.querySelector(".anggota-list-edit");
      const ketuaList = modal.querySelector(".ketua-list-edit");
      let anggotaIndex = anggotaList?.querySelectorAll(".anggota-item").length || 0;
      let ketuaIndex = ketuaList?.querySelectorAll(".ketua-item").length || 0;

      modal.querySelector(".add-anggota-btn-edit")?.addEventListener("click", function () {
        const div = document.createElement("div");
        div.className = "d-flex gap-2 mb-2 anggota-item";
        div.innerHTML = `
          <input type="text" name="anggota[${anggotaIndex}][nama]" class="form-control" placeholder="Nama Anggota">
          <select name="anggota[${anggotaIndex}][departemen]" class="form-select">
            <option selected disabled>-- Pilih Departemen --</option>
            <option value="Manajemen Hutan">Manajemen Hutan</option>
            <option value="Konservasi Sumberdaya Hutan">Konservasi Sumberdaya Hutan</option>
            <option value="Teknologi Hasil Hutan">Teknologi Hasil Hutan</option>
          </select>
          <button type="button" class="btn btn-danger remove-anggota">X</button>`;
        anggotaList.appendChild(div);
        anggotaIndex++;
      });

      anggotaList?.addEventListener("click", (e) => {
        if (e.target.classList.contains("remove-anggota")) {
          e.target.closest(".anggota-item").remove();
        }
      });

      modal.querySelector(".add-ketua-btn-edit")?.addEventListener("click", function () {
        const div = document.createElement("div");
        div.className = "mb-2 ketua-item";
        div.innerHTML = `
          <div class="d-flex gap-2">
            <input type="text" name="ketua[${ketuaIndex}][nama]" class="form-control" placeholder="Nama Ketua">
            <select name="ketua[${ketuaIndex}][departemen]" class="form-select">
              <option selected disabled>-- Pilih Departemen --</option>
              <option value="Manajemen Hutan">Manajemen Hutan</option>
              <option value="Konservasi Sumberdaya Hutan">Konservasi Sumberdaya Hutan</option>
              <option value="Teknologi Hasil Hutan">Teknologi Hasil Hutan</option>
            </select>
            <button type="button" class="btn btn-danger remove-ketua">X</button>
          </div>`;
        ketuaList.appendChild(div);
        ketuaIndex++;
      });

      ketuaList?.addEventListener("click", (e) => {
        if (e.target.classList.contains("remove-ketua")) {
          e.target.closest(".ketua-item").remove();
        }
      });
    });

    // ====================================================
    // Format Rupiah (Besaran Dana)
    // ====================================================
    const danaInput = document.getElementById("besaran_dana");
    danaInput?.addEventListener("input", function () {
      let value = this.value.replace(/\D/g, "");
      this.value = value ? new Intl.NumberFormat("id-ID").format(value) : "";
    });

    document.getElementById("kerjasamaForm")?.addEventListener("submit", function () {
      if (danaInput) danaInput.value = danaInput.value.replace(/\./g, "");
    });
  });
})();