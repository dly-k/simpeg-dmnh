document.addEventListener("DOMContentLoaded", () => {
  // == Data Awal Pengguna ==
  const userData = [
    { name: "Samsul Bahri", user: "SamsulAja", role: "Admin" },
    { name: "Dimas Anggara, S.Si", user: "DimsDim", role: "Admin" },
    { name: "Bunga Puspita", user: "Bunge", role: "Administrasi Kepegawaian" },
    { name: "Rahmi Anggraeni", user: "RahmiRahmi", role: "Administrasi Kepegawaian" }
  ];

  let selectedDeleteIndex = null;

  // == Fungsi Render Tabel ==
  const renderTable = () => {
    const tableBody = document.getElementById("userDataBody");
    if (!tableBody) return;

    tableBody.innerHTML = userData
      .map(
        (item, index) => `
          <tr>
            <td>${index + 1}</td>
            <td class="text-start">${item.name}</td>
            <td>${item.user}</td>
            <td>••••••••••</td>
            <td>${item.role}</td>
            <td>
              <div class="d-flex gap-2 justify-content-center">
                <button 
                  class="btn btn-aksi btn-edit-row" 
                  title="Edit" 
                  onclick="openEditModal('${item.name}', '${item.user}', '${item.role}')"
                >
                  <i class="fa fa-edit"></i>
                </button>
                <button 
                  class="btn btn-aksi btn-delete-row" 
                  title="Hapus" 
                  data-index="${index}"
                >
                  <i class="fa fa-trash"></i>
                </button>
              </div>
            </td>
          </tr>`
      )
      .join("");

    // Binding event untuk tombol hapus
    document.querySelectorAll(".btn-delete-row").forEach((btn) => {
      btn.addEventListener("click", () => {
        selectedDeleteIndex = parseInt(btn.getAttribute("data-index"));
        window.openModal("modalKonfirmasiHapus");
      });
    });
  };

  // == Fungsi Modal Berhasil ==
  const showSuccessModal = (title, subtitle) => {
    const berhasilTitle = document.getElementById("berhasil-title");
    const berhasilSubtitle = document.getElementById("berhasil-subtitle");
    let successAudio = null;

    if (berhasilTitle) berhasilTitle.textContent = title;
    if (berhasilSubtitle) berhasilSubtitle.textContent = subtitle;

    window.openModal("modalBerhasil");

    successAudio = new Audio("/assets/sounds/success.mp3");
    successAudio.play().catch((error) => {
      console.warn("Error memutar audio:", error);
    });

    setTimeout(() => {
      window.closeModal("modalBerhasil");
      if (successAudio) {
        successAudio.pause();
        successAudio.currentTime = 0;
      }
    }, 1000);
  };

  // == Fungsi Modal dengan Animasi (Global) ==
  window.openModal = (modalId) => {
    const modal = document.getElementById(modalId);
    if (modal) {
      modal.style.display = "flex";
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

            // Reset otomatis saat modal ditutup
            if (modalId === "tambahDataModal") resetTambahModal();
            if (modalId === "editDataModal") resetEditModal();
          }
        },
        { once: true }
      );
    }
  };

  // == Fungsi Edit Modal ==
  window.openEditModal = (nama, user, role) => {
    const namaField = document.getElementById("editNamaPegawai");
    const userField = document.getElementById("editIdPengguna");
    const roleField = document.getElementById("editHakAkses");

    if (namaField) namaField.value = nama;
    if (userField) userField.value = user;
    if (roleField) roleField.value = role;

    window.openModal("editDataModal");
  };

  // == Toggle Password Visibility ==
  const initPasswordToggle = () => {
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
  };

  // == Reset Tambah Data ==
  const resetTambahModal = () => {
    const form = document.querySelector("#tambahDataModal form");
    if (form) form.reset();

    const passwordInput = document.querySelector("#tambahDataModal input[type='password'], #tambahDataModal input[name='password']");
    const icon = document.querySelector("#tambahDataModal .toggle-password-icon i");

    if (passwordInput) passwordInput.type = "password";
    if (icon) {
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
    }
  };

  // == Reset Edit Data ==
  const resetEditModal = () => {
    const form = document.querySelector("#editDataModal form");
    if (form) form.reset();

    const passwordInput = document.querySelector("#editDataModal input[type='password'], #editDataModal input[name='password']");
    const icon = document.querySelector("#editDataModal .toggle-password-icon i");

    if (passwordInput) passwordInput.type = "password";
    if (icon) {
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
    }
  };

  // == Modal Tambah Data ==
  const initTambahModal = () => {
    const btnSimpanTambah = document.querySelector("#tambahDataModal .btn-success");
    if (btnSimpanTambah) {
      btnSimpanTambah.addEventListener("click", () => {
        window.closeModal("tambahDataModal");
        showSuccessModal("Data Berhasil Disimpan", "Data pengguna baru telah berhasil ditambahkan ke sistem.");
      });
    }
  };

  // == Modal Edit Data ==
  const initEditModal = () => {
    const btnSimpanEdit = document.querySelector("#editDataModal .btn-success");
    if (btnSimpanEdit) {
      btnSimpanEdit.addEventListener("click", () => {
        window.closeModal("editDataModal");
        showSuccessModal("Data Berhasil Diperbarui", "Data pengguna telah berhasil diperbarui di sistem.");
      });
    }
  };

  // == Modal Hapus Data ==
  const initDeleteModal = () => {
    const btnBatalHapus = document.getElementById("btnBatalHapus");
    const btnKonfirmasiHapus = document.getElementById("btnKonfirmasiHapus");

    if (btnBatalHapus) {
      btnBatalHapus.addEventListener("click", () => {
        window.closeModal("modalKonfirmasiHapus");
        selectedDeleteIndex = null;
      });
    }

    if (btnKonfirmasiHapus) {
      btnKonfirmasiHapus.addEventListener("click", (e) => {
        e.stopPropagation();
        if (selectedDeleteIndex !== null) {
          userData.splice(selectedDeleteIndex, 1);
          renderTable();
          window.closeModal("modalKonfirmasiHapus");
          setTimeout(() => {
            showSuccessModal("Data Berhasil Dihapus", "Data pengguna telah berhasil dihapus dari sistem.");
          }, 150);
          selectedDeleteIndex = null;
        }
      });
    }
  };

  // == Modal Berhasil ==
  const initSuccessModal = () => {
    const btnSelesai = document.getElementById("btnSelesai");
    if (btnSelesai) {
      btnSelesai.addEventListener("click", () => window.closeModal("modalBerhasil"));
    }
  };

  // == Tutup Modal dengan Klik Overlay ==
  const initOverlayClose = () => {
    document.querySelectorAll(".modal-backdrop, .konfirmasi-hapus-overlay, .modal-berhasil-overlay").forEach((overlay) => {
      overlay.addEventListener("click", (e) => {
        if (e.target === overlay) window.closeModal(overlay.id);
      });
    });
  };

  // == Inisialisasi ==
  renderTable();
  initTambahModal();
  initEditModal();
  initDeleteModal();
  initSuccessModal();
  initOverlayClose();
  initPasswordToggle();
});