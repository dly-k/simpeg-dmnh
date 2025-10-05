document.addEventListener("DOMContentLoaded", () => {
  // ===== Modal Hapus =====
  const modalHapus = document.getElementById("modalKonfirmasiHapus");
  const btnKonfirmasiHapus = document.getElementById("btnKonfirmasiHapus");
  const btnBatalHapus = document.getElementById("btnBatalHapus");
  const hapusForm = document.getElementById("hapusForm"); // Pastikan ada form global

  let actionUrl = "";

  // Semua tombol delete di tabel
  document.querySelectorAll(".trigger-hapus").forEach(btn => {
    btn.addEventListener("click", function(e) {
      e.preventDefault();
      const id = this.dataset.id;
      const nama = this.dataset.nama;

      // Set URL form delete
      actionUrl = `/master-data/${id}`; // sesuaikan route destroy

      // Update teks modal
      modalHapus.querySelector(".konfirmasi-hapus-subtitle").textContent =
        `Data "${nama}" akan dihapus permanen dari sistem.`;

      // Tampilkan modal
      modalHapus.style.display = "flex";
      requestAnimationFrame(() => modalHapus.classList.add("show"));
    });
  });

  // Tombol batal hapus
  btnBatalHapus.addEventListener("click", () => {
    modalHapus.classList.remove("show");
    modalHapus.addEventListener(
      "transitionend",
      () => {
        modalHapus.style.display = "none";
      },
      { once: true }
    );
  });

  // Tombol konfirmasi hapus dengan spinner
  btnKonfirmasiHapus.addEventListener("click", () => {
    if (hapusForm) {
      btnKonfirmasiHapus.disabled = true;
      btnKonfirmasiHapus.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Menghapus...`;

      hapusForm.action = actionUrl;
      hapusForm.submit();
    }
  });

  // Tutup modal jika klik di overlay
  modalHapus.addEventListener("click", (e) => {
    if (e.target === modalHapus) {
      modalHapus.classList.remove("show");
      modalHapus.addEventListener(
        "transitionend",
        () => {
          modalHapus.style.display = "none";
        },
        { once: true }
      );
    }
  });

  // ===== Modal Berhasil =====
  window.showSuccessModal = (title, subtitle) => {
    const berhasilTitle = document.getElementById("berhasil-title");
    const berhasilSubtitle = document.getElementById("berhasil-subtitle");
    let successAudio = null;

    if (berhasilTitle) berhasilTitle.textContent = title;
    if (berhasilSubtitle) berhasilSubtitle.textContent = subtitle;

    window.openModal("modalBerhasil");

    successAudio = new Audio("/assets/sounds/Success.mp3");
    successAudio.play().catch((error) => {
      console.warn("Error memutar audio:", error);
    });

    setTimeout(() => {
      window.closeModal("modalBerhasil");
      if (successAudio) {
        successAudio.pause();
        successAudio.currentTime = 0;
      }
    }, 2000);
  };

  const initSuccessModal = () => {
    const btnSelesai = document.getElementById("btnSelesai");
    if (btnSelesai) {
      btnSelesai.addEventListener("click", () => window.closeModal("modalBerhasil"));
    }

    const successMessage = document.body.getAttribute("data-success");
    if (successMessage) {
      window.showSuccessModal("Berhasil", successMessage);
    }
  };

  // ===== Fungsi Open/Close Modal (Global) =====
  window.openModal = (modalId) => {
    const modal = document.getElementById(modalId);
    if (modal) {
      modal.style.display = "flex";
      modal.style.zIndex = "9999";
      requestAnimationFrame(() => modal.classList.add("show"));
    }
  };

  window.closeModal = (modalId) => {
    const modal = document.getElementById(modalId);
    if (modal) {
      modal.classList.remove("show");
      modal.addEventListener(
        "transitionend",
        () => {
          if (!modal.classList.contains("show")) {
            modal.style.display = "none";
          }
        },
        { once: true }
      );
    }
  };

  // ===== Toggle Password Visibility =====
  document.querySelectorAll(".toggle-password-icon").forEach((toggle) => {
    toggle.addEventListener("click", () => {
      const passwordInput = toggle.previousElementSibling;
      const icon = toggle.querySelector("i");

      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      } else {
        passwordInput.type = "password";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      }
    });
  });

  // ===== Tutup Modal dengan Klik Overlay =====
  document.querySelectorAll(".modal-backdrop, .konfirmasi-hapus-overlay, .modal-berhasil-overlay").forEach((overlay) => {
    overlay.addEventListener("click", (e) => {
      if (e.target === overlay) window.closeModal(overlay.id);
    });
  });

  // ===== Tombol Save dengan Spinner (Tambah/Edit) =====
  document.querySelectorAll(".btn-save-spinner").forEach(btn => {
    btn.addEventListener("click", (e) => {
      const form = btn.closest("form");
      if (!form) return;

      btn.disabled = true;
      btn.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Menyimpan...`;

      form.submit();
    });
  });

  // ===== Inisialisasi =====
  initSuccessModal();
});