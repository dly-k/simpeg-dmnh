document.addEventListener("DOMContentLoaded", () => {
  // == Variabel Global ==
  const modalBerhasil = document.getElementById("modalBerhasil");
  const berhasilTitle = document.getElementById("berhasil-title");
  const berhasilSubtitle = document.getElementById("berhasil-subtitle");
  const modalKonfirmasiHapus = document.getElementById("modalKonfirmasiHapus");
  const bsModal = modalKonfirmasiHapus ? new bootstrap.Modal(modalKonfirmasiHapus) : null;
  let successAudio = null;
  let successModalTimeout = null;

  // == Modal Berhasil ==
  const showSuccessModal = (title, subtitle) => {
    if (!modalBerhasil) return;

    berhasilTitle.textContent = title;
    berhasilSubtitle.textContent = subtitle;
    modalBerhasil.classList.add("show");
    bsModal?.hide();

    successAudio = new Audio("/assets/sounds/success.mp3");
    successAudio.play().catch((error) => {
      console.warn("Error memutar audio:", error.message);
    });

    clearTimeout(successModalTimeout);
    successModalTimeout = setTimeout(hideSuccessModal, 1200);
  };

  const hideSuccessModal = () => {
    modalBerhasil?.classList.remove("show");
    if (successAudio) {
      successAudio.pause();
      successAudio.currentTime = 0;
    }
    bsModal?.hide();
    document.getElementById("overlay")?.classList.remove("show");
  };

  // == Inisialisasi Modal Pelatihan ==
  const setupPelatihanModals = () => {
    const pelatihanModalEl = document.getElementById("pelatihanModal");
    if (!pelatihanModalEl) return;

    const modalTitle = pelatihanModalEl.querySelector(".modal-title");
    const pelatihanForm = document.getElementById("pelatihanForm");
    const bsPelatihanModal = new bootstrap.Modal(pelatihanModalEl);
    const anggotaList = document.getElementById("anggota-list");

    // Reset form
    const resetForm = () => {
      pelatihanForm.reset();
      anggotaList.innerHTML = "";
      pelatihanModalEl.querySelectorAll(".upload-area").forEach((ua) => ua.reset?.());
      document.getElementById("posisi-lainnya-input").classList.remove("show");
      document.getElementById("posisi-lainnya-input").value = "";
    };

    pelatihanModalEl.addEventListener("show.bs.modal", (event) => {
      const button = event.relatedTarget;
      const isEditMode = button?.classList.contains("btn-edit");
      modalTitle.innerHTML = isEditMode
        ? '<i class="fas fa-edit"></i> Edit Data Pelatihan'
        : '<i class="fas fa-plus-circle"></i> Tambah Data Pelatihan';

      if (!isEditMode) resetForm();
    });

    pelatihanModalEl.querySelector(".btn-success")?.addEventListener("click", () => {
      // proses simpan data (misal AJAX)
      console.log("Data form:", Object.fromEntries(new FormData(pelatihanForm)));

      bsPelatihanModal.hide();
      showSuccessModal("Data Berhasil Disimpan", "Data pelatihan telah berhasil disimpan ke sistem.");
      resetForm();
    });

    pelatihanModalEl.addEventListener("hidden.bs.modal", resetForm);
  };

  // == Delegasi Event untuk Tombol ==
  const setupDelegatedEventListeners = () => {
    let dataToDelete = null;

    document.body.addEventListener("click", (event) => {
      const target = event.target;

      if (target.closest(".btn-hapus")) {
        event.preventDefault();
        const row = target.closest("tr");
        dataToDelete = {
          element: row,
          nama: row?.querySelector("td:nth-child(2)")?.textContent.trim()
        };
        bsModal?.show();
      }

      if (target.matches("#btnKonfirmasiHapus")) {
        event.preventDefault();
        if (dataToDelete) {
          dataToDelete.element?.remove();
          bsModal?.hide();
          showSuccessModal("Data Berhasil Dihapus", `Data "${dataToDelete.nama}" telah berhasil dihapus.`);
        }
      }

      if (target.matches("#btnBatalHapus")) {
        bsModal?.hide();
      }

      if (target.matches("#btnSelesai")) {
        hideSuccessModal();
      }

      if (target.closest(".btn-lihat-detail-pelatihan")) {
        const data = target.closest(".btn-lihat-detail-pelatihan").dataset;
        const setText = (id, value) => {
          const el = document.getElementById(id);
          if (el) el.textContent = value || "-";
        };

        setText("detail_pelatihan_nama", data.nama_pelatihan);
        setText("detail_pelatihan_posisi", data.posisi);
        setText("detail_pelatihan_kota", data.kota);
        setText("detail_pelatihan_lokasi", data.lokasi);
        setText("detail_pelatihan_penyelenggara", data.penyelenggara);
        setText("detail_pelatihan_jenis_diklat", data.jenis_diklat);
        setText("detail_pelatihan_tgl_mulai", data.tgl_mulai);
        setText("detail_pelatihan_tgl_selesai", data.tgl_selesai);
        setText("detail_pelatihan_lingkup", data.lingkup);
        setText("detail_pelatihan_jam", data.jam);
        setText("detail_pelatihan_hari", data.hari);
        setText("detail_pelatihan_struktural", data.struktural);
        setText("detail_pelatihan_sertifikasi", data.sertifikasi);

        document.getElementById("detail_pelatihan_document_viewer")?.setAttribute("src", data.dokumen_path || "");
      }

      if (target.closest(".dynamic-row-close-btn")) {
        target.closest(".dynamic-row")?.remove();
      }

      if (target.closest(".upload-area")) {
        target.closest(".upload-area").querySelector('input[type="file"]')?.click();
      }
    });
  };

  // == Inisialisasi Upload Area ==
  const setupUploadArea = () => {
    document.querySelectorAll(".upload-area").forEach((uploadArea) => {
      const fileInput = uploadArea.querySelector('input[type="file"]');
      const uploadText = uploadArea.querySelector("p");
      if (!fileInput || !uploadText) return;

      const originalText = uploadText.innerHTML;

      fileInput.addEventListener("change", function () {
        uploadText.textContent = this.files.length > 0 ? this.files[0].name : originalText;
      });

      uploadArea.reset = () => {
        uploadText.innerHTML = originalText;
        fileInput.value = "";
      };
    });
  };

  // == Toggle Posisi Lainnya ==
  const setupPosisiLainnya = () => {
    const posisiSelect = document.getElementById("posisi-pelatihan-select");
    const posisiLainnyaInput = document.getElementById("posisi-lainnya-input");
    if (!posisiSelect || !posisiLainnyaInput) return;

    posisiSelect.addEventListener("change", function () {
      if (this.value === "Lainnya") {
        posisiLainnyaInput.classList.add("show");
      } else {
        posisiLainnyaInput.classList.remove("show");
        posisiLainnyaInput.value = "";
      }
    });
  };

  // == Fungsi Global: Tambah Anggota ==
  window.addAnggota = () => {
    const list = document.getElementById("anggota-list");
    if (!list) return;

    const newRow = document.createElement("div");
    newRow.className = "dynamic-row position-relative border rounded p-3 pt-4 mb-2";
    newRow.innerHTML = `
      <button type="button" class="btn-close dynamic-row-close-btn position-absolute top-0 end-0 p-2" aria-label="Close"></button>
      <div class="row g-2">
        <div class="col-12">
          <label class="form-label form-label-sm">Nama Anggota</label>
          <input type="text" class="form-control form-control-sm" placeholder="Nama Anggota">
        </div>
        <div class="col-md-6">
          <label class="form-label form-label-sm">Angkatan</label>
          <input type="text" class="form-control form-control-sm" placeholder="Angkatan">
        </div>
        <div class="col-md-6">
          <label class="form-label form-label-sm">Predikat</label>
          <input type="text" class="form-control form-control-sm" placeholder="Predikat">
        </div>
      </div>
    `;
    list.appendChild(newRow);
  };

  // == Inisialisasi Semua ==
  setupPelatihanModals();
  setupDelegatedEventListeners();
  setupUploadArea();
  setupPosisiLainnya();
});