document.addEventListener("DOMContentLoaded", () => {
  // == Modal Berhasil ==
  const modalBerhasil = document.getElementById("modalBerhasil");
  const berhasilTitle = document.getElementById("berhasil-title");
  const berhasilSubtitle = document.getElementById("berhasil-subtitle");
  let successModalTimeout = null;
  let successAudio = null;

  const showSuccessModal = (title, subtitle) => {
    if (!modalBerhasil || !berhasilTitle || !berhasilSubtitle) return;

    berhasilTitle.textContent = title;
    berhasilSubtitle.textContent = subtitle;
    modalBerhasil.classList.add("show");
    modalBerhasil.querySelector(".modal-berhasil-overlay")?.classList.add("show");

    successAudio = new Audio("/assets/sounds/success.mp3");
    successAudio.play().catch((error) => {
      console.warn("Gagal memutar audio:", error);
      if (error.name === "NotAllowedError") {
        console.warn("Autoplay diblokir oleh browser.");
      } else if (error.name === "NotFoundError") {
        console.warn("File audio tidak ditemukan: /assets/sounds/success.mp3");
      }
    });

    clearTimeout(successModalTimeout);
    successModalTimeout = setTimeout(hideSuccessModal, 1200);
  };

  const hideSuccessModal = () => {
    modalBerhasil?.classList.remove("show");
    modalBerhasil?.querySelector(".modal-berhasil-overlay")?.classList.remove("show");

    if (successAudio) {
      successAudio.pause();
      successAudio.currentTime = 0;
    }
  };

  // Tombol Selesai Modal Berhasil
  document.getElementById("btnSelesai")?.addEventListener("click", () => {
    clearTimeout(successModalTimeout);
    hideSuccessModal();
  });

  // == Inisialisasi Upload Area ==
  const setupUploadArea = () => {
    document.querySelectorAll(".upload-area").forEach((uploadArea) => {
      const fileInput = uploadArea.querySelector('input[type="file"]');
      const uploadText = uploadArea.querySelector("p");
      if (!fileInput || !uploadText) return;

      const originalText = uploadText.innerHTML;

      uploadArea.addEventListener("click", () => fileInput.click());
      fileInput.addEventListener("change", function () {
        uploadText.textContent = this.files.length > 0 ? this.files[0].name : originalText;
      });

      uploadArea.reset = function () {
        uploadText.innerHTML = originalText;
        fileInput.value = "";
      };
    });
  };

  // == Modal Tambah/Edit Penghargaan ==
  const initPenghargaanModal = () => {
    const penghargaanModalEl = document.getElementById("penghargaanModal");
    if (!penghargaanModalEl) return;

    const bsModal = new bootstrap.Modal(penghargaanModalEl);

    penghargaanModalEl.addEventListener("show.bs.modal", (event) => {
      const button = event.relatedTarget;
      const modalTitle = penghargaanModalEl.querySelector(".modal-title");
      const isEditMode = button?.classList.contains("btn-edit");

      modalTitle.innerHTML = isEditMode
        ? '<i class="fas fa-edit"></i> Edit Data Penghargaan'
        : '<i class="fas fa-plus-circle"></i> Tambah Data Penghargaan';

      if (!isEditMode) {
        document.getElementById("penghargaanForm")?.reset();
        penghargaanModalEl.querySelector(".upload-area")?.reset();
      }
    });

    penghargaanModalEl.querySelector(".btn-success")?.addEventListener("click", () => {
      bsModal.hide();
      showSuccessModal("Data Berhasil Disimpan", "Data penghargaan telah berhasil disimpan.");
    });
  };

  // == Modal Detail Penghargaan ==
  const initDetailModal = () => {
    document.addEventListener("click", (event) => {
      const detailButton = event.target.closest(".btn-lihat-detail-penghargaan");
      if (!detailButton) return;

      const data = detailButton.dataset;
      const detailFields = [
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
        "tautan"
      ];

      detailFields.forEach((field) => {
        const el = document.getElementById(`detail_penghargaan_${field}`);
        if (el) el.textContent = data[field] || "-";
      });

      document.getElementById("detail_penghargaan_document_viewer")?.setAttribute("src", data.dokumen_path || "");
    });
  };

  // == Modal Konfirmasi Hapus ==
  const initDeleteModal = () => {
    const modalKonfirmasiHapus = document.getElementById("modalKonfirmasiHapus");
    let dataToDelete = null;

    const showDeleteModal = () => {
      modalKonfirmasiHapus?.classList.add("show");
      modalKonfirmasiHapus?.querySelector(".konfirmasi-hapus-overlay")?.classList.add("show");
    };

    const hideDeleteModal = () => {
      modalKonfirmasiHapus?.classList.remove("show");
      modalKonfirmasiHapus?.querySelector(".konfirmasi-hapus-overlay")?.classList.remove("show");
    };

    document.body.addEventListener("click", (event) => {
      const target = event.target;

      if (target.closest(".btn-hapus")) {
        event.preventDefault();
        const row = target.closest("tr");
        dataToDelete = {
          element: row,
          nama: row?.querySelector("td:nth-child(2)")?.textContent.trim()
        };
        showDeleteModal();
      }

      if (target.matches("#btnKonfirmasiHapus")) {
        event.preventDefault();
        if (dataToDelete) {
          dataToDelete.element?.remove();
          hideDeleteModal();
          showSuccessModal("Data Berhasil Dihapus", `Data penghargaan "${dataToDelete.nama}" telah berhasil dihapus.`);
        }
      }

      if (target.matches("#btnBatalHapus")) {
        hideDeleteModal();
      }
    });

    modalKonfirmasiHapus?.addEventListener("click", (e) => {
      if (e.target === modalKonfirmasiHapus) hideDeleteModal();
    });

    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && modalKonfirmasiHapus?.classList.contains("show")) {
        hideDeleteModal();
      }
    });
  };

  // == Inisialisasi Semua ==
  setupUploadArea();
  initPenghargaanModal();
  initDetailModal();
  initDeleteModal();
});