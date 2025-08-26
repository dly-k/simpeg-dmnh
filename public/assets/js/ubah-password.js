document.addEventListener("DOMContentLoaded", () => {
  // == Fungsi Bantuan Modal ==
  const openModal = (modalId) => {
    const modal = document.getElementById(modalId);
    if (modal) modal.classList.add("show");
  };

  const closeModal = (modalId) => {
    const modal = document.getElementById(modalId);
    if (modal) modal.classList.remove("show");
  };

  const showSuccessModal = (title, subtitle) => {
    const berhasilTitle = document.getElementById("berhasil-title");
    const berhasilSubtitle = document.getElementById("berhasil-subtitle");

    if (berhasilTitle) berhasilTitle.textContent = title;
    if (berhasilSubtitle) berhasilSubtitle.textContent = subtitle;

    openModal("modalBerhasil");

    const successAudio = new Audio("/assets/sounds/success.mp3");
    successAudio.play().catch((error) => {
      console.warn("Error memutar suara:", error);
      if (error.name === "NotAllowedError") {
        console.info("Autoplay diblokir. Butuh interaksi pengguna.");
      } else if (error.name === "NotFoundError") {
        console.error("File audio tidak ditemukan: /assets/sounds/success.mp3");
      }
    });

    setTimeout(() => {
      closeModal("modalBerhasil");
      if (successAudio) {
        successAudio.pause();
        successAudio.currentTime = 0;
      }
    }, 3000);
  };

  // == Event: Tombol Selesai Modal ==
  const initSuccessModalButton = () => {
    const btnSelesai = document.getElementById("btnSelesai");
    if (btnSelesai) {
      btnSelesai.addEventListener("click", () => closeModal("modalBerhasil"));
    }
  };

  // == Validasi Form Ubah Password ==
  const initPasswordForm = () => {
    const form = document.getElementById("ubahPasswordForm");
    if (!form) return;

    const togglePasswordIcons = document.querySelectorAll(".toggle-password");
    const passLamaInput = document.getElementById("password_lama");
    const passBaruInput = document.getElementById("password_baru");
    const konfirmasiInput = document.getElementById("konfirmasi_password_baru");
    const allInputs = [passLamaInput, passBaruInput, konfirmasiInput];

    togglePasswordIcons.forEach((icon) => {
      icon.addEventListener("click", () => {
        const passwordField = icon.previousElementSibling;
        const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
        passwordField.setAttribute("type", type);
        icon.classList.toggle("fa-eye");
        icon.classList.toggle("fa-eye-slash");
      });
    });

    const showError = (input, message) => {
      input.classList.add("is-invalid");
      const errorDiv = input.parentElement.nextElementSibling;
      if (errorDiv) {
        errorDiv.innerHTML = `<i class="fas fa-exclamation-circle me-1"></i> ${message}`;
      }
    };

    const clearError = (input) => {
      input.classList.remove("is-invalid");
      const errorDiv = input.parentElement.nextElementSibling;
      if (errorDiv) errorDiv.innerHTML = "";
    };

    form.addEventListener("submit", (event) => {
      event.preventDefault();
      let isFormValid = true;

      allInputs.forEach(clearError);

      if (!passLamaInput.value.trim()) {
        showError(passLamaInput, "Password Lama wajib diisi.");
        isFormValid = false;
      }
      if (!passBaruInput.value.trim()) {
        showError(passBaruInput, "Password Baru wajib diisi.");
        isFormValid = false;
      }
      if (!konfirmasiInput.value.trim()) {
        showError(konfirmasiInput, "Konfirmasi Password Baru wajib diisi.");
        isFormValid = false;
      }

      if (!isFormValid) return;

      if (passBaruInput.value !== konfirmasiInput.value) {
        showError(konfirmasiInput, "Password Baru dan Konfirmasi tidak cocok.");
        return;
      }

      showSuccessModal("Perubahan Berhasil", "Password Anda telah berhasil diperbarui.");

      form.reset();
      allInputs.forEach(clearError);
      togglePasswordIcons.forEach((icon) => {
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
        icon.previousElementSibling.setAttribute("type", "password");
      });
    });

    allInputs.forEach((input) => {
      input.addEventListener("input", () => clearError(input));
      input.addEventListener("blur", () => {
        input.setAttribute("type", "password");
        const icon = input.nextElementSibling;
        if (icon && icon.classList.contains("toggle-password")) {
          icon.classList.remove("fa-eye-slash");
          icon.classList.add("fa-eye");
        }
      });
    });
  };

  // == Responsivitas Form ==
  const initFormResponsiveness = () => {
    window.addEventListener("resize", () => {
      const sidebar = document.getElementById("sidebar");
      const formContainer = document.querySelector(".password-form-container");

      if (sidebar && formContainer) {
        if (window.innerWidth >= 992 && sidebar.classList.contains("hidden")) {
          formContainer.style.marginLeft = "auto";
          formContainer.style.marginRight = "auto";
        }
      }
    });
  };

  // == Inisialisasi Semua ==
  initSuccessModalButton();
  initPasswordForm();
  initFormResponsiveness();
});