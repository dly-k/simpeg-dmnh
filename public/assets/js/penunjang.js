document.addEventListener("DOMContentLoaded", () => {
  // == Inisialisasi Modal ==
  let penunjangModalInstance;
  const penunjangModalEl = document.getElementById("penunjangModal");
  if (penunjangModalEl) {
    penunjangModalInstance = new bootstrap.Modal(penunjangModalEl);
  }

  // == Modal Berhasil ==
  const modalBerhasil = document.getElementById("modalBerhasil");
  const berhasilTitle = document.getElementById("berhasil-title");
  const berhasilSubtitle = document.getElementById("berhasil-subtitle");
  let successModalTimeout = null;
  const successSound = new Audio("/assets/sounds/success.mp3");

  const showSuccessModal = (title, subtitle) => {
    if (!modalBerhasil || !berhasilTitle || !berhasilSubtitle) return;

    berhasilTitle.textContent = title;
    berhasilSubtitle.textContent = subtitle;
    modalBerhasil.classList.add("show");
    document.body.style.overflow = "hidden";

    successSound.play().catch((error) => console.warn("Gagal memutar audio sukses:", error));

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

  // == Tombol Simpan Modal Penunjang ==
  document.querySelector("#penunjangModal .btn-success")?.addEventListener("click", () => {
    closeModal();
    showSuccessModal("Data Berhasil Disimpan", "Data penunjang telah berhasil disimpan ke sistem.");
  });

  // == Inisialisasi Interaksi Dinamis ==
  const setupDynamicInteractions = () => {
    const dokumenList = document.getElementById("dokumen-list");
    if (dokumenList) {
      dokumenList.addEventListener("click", (event) => {
        const removeBtn = event.target.closest(".btn-outline-danger");
        if (removeBtn) {
          removeBtn.closest(".border.rounded").remove();
          return;
        }

        const uploadArea = event.target.closest(".upload-area");
        if (uploadArea) {
          const fileInput = uploadArea.querySelector('input[type="file"]');
          if (fileInput) fileInput.click();
        }
      });

      dokumenList.addEventListener("change", (event) => {
        if (event.target.matches('input[type="file"]')) {
          const uploadArea = event.target.closest(".upload-area");
          const p = uploadArea.querySelector("p");
          if (p && event.target.files.length > 0) {
            p.innerHTML = `<small>${event.target.files[0].name}</small>`;
          }
        }
      });
    }

    const anggotaList = document.getElementById("anggota-list");
    if (anggotaList) {
      anggotaList.addEventListener("click", (event) => {
        const removeBtn = event.target.closest(".btn-outline-danger");
        if (removeBtn) {
          removeBtn.closest(".input-group").remove();
        }
      });
    }
  };

  // == Modal Konfirmasi Verifikasi ==
  const initVerificationModal = () => {
    const verifModal = document.getElementById("modalKonfirmasiVerifikasi");
    const hideVerifModal = () => verifModal?.classList.remove("show");

    document.addEventListener("click", (event) => {
      if (event.target.closest(".btn-verifikasi")) {
        event.preventDefault();
        verifModal?.classList.add("show");
      }
    });

    verifModal?.addEventListener("click", (e) => {
      if (e.target === verifModal) hideVerifModal();
    });

    document.getElementById("popupBtnTerima")?.addEventListener("click", () => {
      hideVerifModal();
      showSuccessModal("Status Verifikasi Disimpan", "Perubahan status verifikasi telah berhasil disimpan.");
    });

    document.getElementById("popupBtnTolak")?.addEventListener("click", () => {
      hideVerifModal();
      showSuccessModal("Status Verifikasi Disimpan", "Perubahan status verifikasi telah berhasil disimpan.");
    });

    document.getElementById("popupBtnKembali")?.addEventListener("click", hideVerifModal);
  };

  // == Modal Konfirmasi Hapus ==
  const initDeleteModal = () => {
    const deleteModal = document.getElementById("modalKonfirmasiHapus");
    let dataToDelete = null;

    const hideDeleteModal = () => {
      if (deleteModal) {
        deleteModal.classList.remove("show");
        if (!document.querySelector(".modal.show")) document.body.style.overflow = "";
      }
    };

    document.addEventListener("click", (event) => {
      const btnHapus = event.target.closest(".btn-hapus");
      if (btnHapus) {
        event.preventDefault();
        const row = btnHapus.closest("tr");
        if (row) {
          dataToDelete = {
            id: row.cells[0].textContent,
            title: row.cells[1].textContent
          };
          deleteModal?.classList.add("show");
          document.body.style.overflow = "hidden";
        }
      }
    });

    document.getElementById("btnBatalHapus")?.addEventListener("click", hideDeleteModal);

    document.getElementById("btnKonfirmasiHapus")?.addEventListener("click", () => {
      if (dataToDelete) {
        console.log("Menghapus data:", dataToDelete);
      }
      hideDeleteModal();
      showSuccessModal("Data Berhasil Dihapus", "Data yang dipilih telah berhasil dihapus secara permanen.");
    });

    window.addEventListener("click", (event) => {
      if (event.target === deleteModal) hideDeleteModal();
      if (event.target === verifModal) hideVerifModal();
    });
  };

  // == Fungsi Modal Penunjang ==
  window.openModal = () => {
    if (!penunjangModalInstance) return;

    const modalTitle = document.getElementById("penunjangModalLabel");
    if (modalTitle) {
      modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Penunjang';
    }

    const form = document.getElementById("penunjangForm");
    if (form) form.reset();

    const dokumenList = document.getElementById("dokumen-list");
    const anggotaList = document.getElementById("anggota-list");
    if (dokumenList) dokumenList.innerHTML = "";
    if (anggotaList) anggotaList.innerHTML = "";

    penunjangModalInstance.show();
  };

  window.openEditModal = () => {
    if (!penunjangModalInstance) return;

    const modalTitle = document.getElementById("penunjangModalLabel");
    if (modalTitle) {
      modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Penunjang';
    }

    penunjangModalInstance.show();
  };

  const closeModal = () => {
    if (penunjangModalInstance) penunjangModalInstance.hide();
  };

  // == Fungsi Dokumen dan Anggota Dinamis ==
  window.addDokumen = () => {
    const list = document.getElementById("dokumen-list");
    if (!list) return;

    const newRow = document.createElement("div");
    newRow.className = "border rounded p-3 mb-3";
    newRow.innerHTML = `
      <div class="row g-2">
        <div class="col-12">
          <select class="form-select form-select-sm">
            <option selected>-- Pilih Jenis Dokumen --</option>
          </select>
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control form-control-sm" placeholder="Nama Dokumen">
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control form-control-sm" placeholder="Nomor">
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control form-control-sm" placeholder="Tautan">
        </div>
        <div class="col-12">
          <div class="upload-area" style="padding: 1rem;">
            <i class="fas fa-cloud-upload-alt"></i>
            <p class="mb-0"><small>Drag & Drop File / Max 5 MB</small></p>
            <input type="file" hidden>
          </div>
        </div>
      </div>
      <button type="button" class="btn btn-sm btn-outline-danger mt-2">
        <i class="fa fa-trash"></i> Hapus Dokumen
      </button>
    `;
    list.appendChild(newRow);
  };

  window.addAnggota = () => {
    const list = document.getElementById("anggota-list");
    if (!list) return;

    const newRow = document.createElement("div");
    newRow.className = "input-group mb-2";
    newRow.innerHTML = `
      <input type="text" class="form-control" placeholder="Nama Dosen">
      <select class="form-select">
        <option selected>-- Pilih Salah Satu Peran --</option>
      </select>
      <button class="btn btn-outline-danger" type="button">
        <i class="fa fa-trash"></i>
      </button>
    `;
    list.appendChild(newRow);
  };

  // == Inisialisasi Semua ==
  setupDynamicInteractions();
  initVerificationModal();
  initDeleteModal();
});