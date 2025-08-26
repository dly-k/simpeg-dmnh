document.addEventListener("DOMContentLoaded", () => {
  // == Inisialisasi Modal Bootstrap ==
  let penelitianModalInstance;
  const penelitianModalEl = document.getElementById("penelitianModal");
  if (penelitianModalEl) {
    penelitianModalInstance = new bootstrap.Modal(penelitianModalEl);
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

  // == Tombol Simpan Modal Penelitian ==
  document.querySelector("#penelitianModal .btn-success")?.addEventListener("click", () => {
    closeModal();
    showSuccessModal("Data Berhasil Disimpan", "Data penelitian telah berhasil disimpan ke sistem.");
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

  // Event Delegation untuk Tombol
  document.addEventListener("click", (event) => {
    const target = event.target.closest("a, button");
    if (!target) return;

    if (target.classList.contains("btn-verifikasi")) {
      event.preventDefault();
      verifModal?.classList.add("show");
    }

    if (target.classList.contains("btn-hapus")) {
      event.preventDefault();
      deleteModal?.classList.add("show");
      document.body.style.overflow = "hidden";
    }

    if (target.id === "popupBtnKembali") hideVerifModal();
    if (target.id === "popupBtnTerima") {
      hideVerifModal();
      showSuccessModal("Data Diverifikasi", "Data penelitian berhasil diverifikasi");
    }
    if (target.id === "popupBtnTolak") {
      hideVerifModal();
      showSuccessModal("Data Ditolak", "Data penelitian telah ditolak");
    }
    if (target.id === "btnBatalHapus") hideDeleteModal();
    if (target.id === "btnKonfirmasiHapus") {
      hideDeleteModal();
      showSuccessModal("Data Berhasil Dihapus", "Data telah berhasil dihapus permanen.");
    }
  });

  // Tutup Modal saat Klik Overlay
  window.addEventListener("click", (event) => {
    if (event.target === verifModal) hideVerifModal();
    if (event.target === deleteModal) hideDeleteModal();
  });

  // == Fungsi Modal Penelitian ==
  window.openModal = () => {
    if (!penelitianModalInstance) return;

    const modalTitle = document.getElementById("penelitianModalLabel");
    if (modalTitle) {
      modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Penelitian';
    }

    document.getElementById("penelitianForm")?.reset();
    resetPenulisFields();
    penelitianModalInstance.show();
  };

  window.openEditModal = () => {
    if (!penelitianModalInstance) return;

    const modalTitle = document.getElementById("penelitianModalLabel");
    if (modalTitle) {
      modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Penelitian';
    }

    resetPenulisFields();
    penelitianModalInstance.show();
  };

  const closeModal = () => {
    if (penelitianModalInstance) penelitianModalInstance.hide();
  };

  // == Fungsi Penulis Dinamis ==
  window.createPenulisInput = (listId, isFirst) => {
    const isMahasiswa = listId === "penulis-mahasiswa-list";
    const buttonClass = isFirst ? "btn-outline-success" : "btn-outline-danger";
    const buttonIcon = isFirst ? "+" : "-";
    const buttonAction = isFirst ? `addPenulis('${listId}')` : "this.parentElement.remove()";

    const skInput = isMahasiswa
      ? ""
      : `
        <label class="input-group-text">Upload SK</label>
        <input type="file" class="form-control">`;

    return `
      <div class="input-group mb-2">
        <input type="text" class="form-control" placeholder="Nama">
        ${skInput}
        <button class="btn ${buttonClass}" type="button" onclick="${buttonAction}">${buttonIcon}</button>
      </div>`;
  };

  window.resetPenulisFields = () => {
    document.getElementById("penulis-ipb-list").innerHTML = createPenulisInput("penulis-ipb-list", true);
    document.getElementById("penulis-luar-list").innerHTML = createPenulisInput("penulis-luar-list", true);
    document.getElementById("penulis-mahasiswa-list").innerHTML = createPenulisInput("penulis-mahasiswa-list", true);
  };

  window.addPenulis = (listId) => {
    const list = document.getElementById(listId);
    if (list) {
      list.insertAdjacentHTML("beforeend", createPenulisInput(listId, false));
    }
  };
});