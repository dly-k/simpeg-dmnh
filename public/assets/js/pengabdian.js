document.addEventListener("DOMContentLoaded", () => {
  // == Inisialisasi Modal Bootstrap ==
  let pengabdianModalInstance;
  const pengabdianModalEl = document.getElementById("pengabdianModal");
  if (pengabdianModalEl) {
    pengabdianModalInstance = new bootstrap.Modal(pengabdianModalEl);
  }

  // == Modal Berhasil ==
  const modalBerhasil = document.getElementById("modalBerhasil");
  const berhasilTitle = document.getElementById("berhasil-title");
  const berhasilSubtitle = document.getElementById("berhasil-subtitle");
  let successModalTimeout = null;
  const successSound = new Audio("assets/sounds/success.mp3");

  const showSuccessModal = (title, subtitle) => {
    if (!modalBerhasil || !berhasilTitle || !berhasilSubtitle) return;

    berhasilTitle.textContent = title;
    berhasilSubtitle.textContent = subtitle;
    modalBerhasil.classList.add("show");
    document.body.style.overflow = "hidden";

    successSound.play().catch((error) => console.error("Error memutar audio:", error));

    clearTimeout(successModalTimeout);
    successModalTimeout = setTimeout(hideSuccessModal, 1200);
  };

  const hideSuccessModal = () => {
    if (modalBerhasil) {
      modalBerhasil.classList.remove("show");
      if (!document.querySelector(".modal.show")) {
        document.body.style.overflow = "";
      }
    }
  };

  // Tombol Selesai Modal Berhasil
  document.getElementById("btnSelesai")?.addEventListener("click", () => {
    clearTimeout(successModalTimeout);
    hideSuccessModal();
  });

  // == Inisialisasi Upload Area ==
  const initUploadArea = () => {
    document.querySelectorAll(".upload-area").forEach((uploadArea) => {
      const fileInput = uploadArea.querySelector('input[type="file"]');
      const uploadText = uploadArea.querySelector("p");
      if (!fileInput || !uploadText) return;

      const originalText = uploadText.innerHTML;

      uploadArea.addEventListener("click", () => fileInput.click());
      fileInput.addEventListener("change", () => {
        uploadText.textContent = fileInput.files.length > 0 ? fileInput.files[0].name : originalText;
      });

      uploadArea.reset = () => {
        uploadText.innerHTML = originalText;
        fileInput.value = "";
      };
    });
  };

  // == Tombol Simpan Modal Pengabdian ==
  document.querySelector("#pengabdianModal .btn-success")?.addEventListener("click", () => {
    closeModal();
    showSuccessModal("Data Berhasil Disimpan", "Data pengabdian telah berhasil disimpan ke sistem.");
  });

  // == Modal Konfirmasi Verifikasi dan Hapus ==
  const verifModal = document.getElementById("modalKonfirmasiVerifikasi");
  const deleteModal = document.getElementById("modalKonfirmasiHapus");
  const hideVerifModal = () => {
    if (verifModal) verifModal.classList.remove("show");
  };

  const hideDeleteModal = () => {
    if (deleteModal) {
      deleteModal.classList.remove("show");
      if (!document.querySelector(".modal.show")) document.body.style.overflow = "";
    }
  };

  // == Event Delegation untuk Tombol ==
  document.addEventListener("click", (event) => {
    const target = event.target;

    // Tombol Verifikasi
    if (target.closest(".btn-verifikasi")) {
      event.preventDefault();
      verifModal?.classList.add("show");
    }

    // Tombol Hapus
    if (target.closest(".btn-hapus")) {
      event.preventDefault();
      deleteModal?.classList.add("show");
      document.body.style.overflow = "hidden";
    }

    // Tombol di dalam Modal Verifikasi
    if (target.closest("#popupBtnKembali")) hideVerifModal();
    if (target.closest("#popupBtnTerima")) {
      hideVerifModal();
      showSuccessModal("Data Diverifikasi", "Data pengabdian berhasil diverifikasi");
    }
    if (target.closest("#popupBtnTolak")) {
      hideVerifModal();
      showSuccessModal("Data Ditolak", "Data pengabdian telah ditolak");
    }

    // Tombol di dalam Modal Hapus
    if (target.closest("#btnBatalHapus")) hideDeleteModal();
    if (target.closest("#btnKonfirmasiHapus")) {
      hideDeleteModal();
      showSuccessModal("Data Berhasil Dihapus", "Data telah berhasil dihapus permanen.");
    }

    // Tombol Hapus Anggota Dinamis
    if (target.closest(".dynamic-row-close-btn")) {
      target.closest(".dynamic-row").remove();
    }
  });

  // Tutup Modal saat Klik Overlay
  window.addEventListener("click", (event) => {
    if (event.target === verifModal) hideVerifModal();
    if (event.target === deleteModal) hideDeleteModal();
  });

  // == Fungsi Modal Pengabdian ==
  window.openModal = () => {
    if (!pengabdianModalInstance) return;

    const modalTitle = document.getElementById("pengabdianModalLabel");
    if (modalTitle) {
      modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Pengabdian';
    }

    document.getElementById("pengabdianForm")?.reset();
    document.querySelectorAll(".upload-area").forEach((area) => area.reset?.());
    ["dosen-list", "mahasiswa-list", "kolaborator-list"].forEach((id) => {
      const list = document.getElementById(id);
      if (list) list.innerHTML = "";
    });

    pengabdianModalInstance.show();
  };

  window.openEditModal = () => {
    if (!pengabdianModalInstance) return;

    const modalTitle = document.getElementById("pengabdianModalLabel");
    if (modalTitle) {
      modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Pengabdian';
    }

    pengabdianModalInstance.show();
  };

  const closeModal = () => {
    if (pengabdianModalInstance) pengabdianModalInstance.hide();
  };

  // == Fungsi Anggota Dinamis ==
  window.addAnggota = (type) => {
    const listId = `${type}-list`;
    const container = document.getElementById(listId);
    if (!container) return;

    const removeButton = `<button class="btn btn-sm dynamic-row-close-btn" type="button"><i class="fa fa-times"></i></button>`;
    let content = "";

    switch (type) {
      case "dosen":
        content = `
          <div class="dynamic-row">
            <div class="row g-2">
              <div class="col-12">
                <input type="text" class="form-control form-control-sm" placeholder="Nama Dosen">
              </div>
              <div class="col-md-6">
                <select class="form-select form-select-sm">
                  <option selected>Jabatan</option>
                </select>
              </div>
              <div class="col-md-6">
                <select class="form-select form-select-sm">
                  <option selected>Aktif</option>
                </select>
              </div>
            </div>
            ${removeButton}
          </div>`;
        break;
      case "mahasiswa":
        content = `
          <div class="dynamic-row">
            <div class="row g-2">
              <div class="col-md-6">
                <select class="form-select form-select-sm">
                  <option selected>Strata</option>
                </select>
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control form-control-sm" placeholder="Nama Mahasiswa">
              </div>
              <div class="col-md-6">
                <select class="form-select form-select-sm">
                  <option selected>Jabatan</option>
                </select>
              </div>
              <div class="col-md-6">
                <select class="form-select form-select-sm">
                  <option selected>Aktif</option>
                </select>
              </div>
            </div>
            ${removeButton}
          </div>`;
        break;
      case "kolaborator":
        content = `
          <div class="dynamic-row">
            <div class="row g-2">
              <div class="col-12">
                <input type="text" class="form-control form-control-sm" placeholder="Nama Kolaborator">
              </div>
              <div class="col-md-6">
                <select class="form-select form-select-sm">
                  <option selected>Jabatan</option>
                </select>
              </div>
              <div class="col-md-6">
                <select class="form-select form-select-sm">
                  <option selected>Aktif</option>
                </select>
              </div>
            </div>
            ${removeButton}
          </div>`;
        break;
    }

    container.insertAdjacentHTML("beforeend", content);
  };

  // == Inisialisasi Semua ==
  initUploadArea();
});