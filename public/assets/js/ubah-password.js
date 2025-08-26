document.addEventListener("DOMContentLoaded", function () {
  // =========================
  //  Fungsi Bantuan Modal
  // =========================
  function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) modal.classList.add('show');
  }

  function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) modal.classList.remove('show');
  }

  function showSuccessModal(title, subtitle) {
    const berhasilTitle = document.getElementById('berhasil-title');
    const berhasilSubtitle = document.getElementById('berhasil-subtitle');

    if (berhasilTitle) berhasilTitle.textContent = title;
    if (berhasilSubtitle) berhasilSubtitle.textContent = subtitle;

    openModal('modalBerhasil');

    // Putar suara berhasil
    let successAudio = new Audio('/assets/sounds/success.mp3');
    successAudio.play().catch(error => {
      console.warn('Error memutar suara:', error);

      if (error.name === 'NotAllowedError') {
        console.info('Autoplay diblokir. Butuh interaksi pengguna.');
      } else if (error.name === 'NotFoundError') {
        console.error('File audio tidak ditemukan. Periksa path: /assets/sounds/success.mp3');
      }
    });

    // Tutup modal otomatis setelah 3 detik
    setTimeout(() => {
      closeModal('modalBerhasil');
      if (successAudio) {
        successAudio.pause();
        successAudio.currentTime = 0;
      }
    }, 3000);
  }

  // =========================
  //  Event: Tombol Selesai di Modal
  // =========================
  const btnSelesai = document.getElementById('btnSelesai');
  if (btnSelesai) {
    btnSelesai.addEventListener('click', () => {
      closeModal('modalBerhasil');
    });
  }

  // =========================
  //  Validasi Form Ubah Password
  // =========================
  const form = document.getElementById('ubahPasswordForm');
  if (form) {
    const togglePasswordIcons = document.querySelectorAll('.toggle-password');
    const passLamaInput = document.getElementById('password_lama');
    const passBaruInput = document.getElementById('password_baru');
    const konfirmasiInput = document.getElementById('konfirmasi_password_baru');
    const allInputs = [passLamaInput, passBaruInput, konfirmasiInput];

    // Fungsi untuk toggle visibility password
    togglePasswordIcons.forEach(icon => {
      icon.addEventListener('click', function () {
        const passwordField = this.previousElementSibling;
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);

        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
      });
    });

    // Fungsi tampilkan pesan error
    const showError = (input, message) => {
      input.classList.add('is-invalid');
      const errorDiv = input.parentElement.nextElementSibling;
      if (errorDiv) {
        errorDiv.innerHTML = `<i class="fas fa-exclamation-circle me-1"></i> ${message}`;
      }
    };

    // Fungsi bersihkan error
    const clearError = (input) => {
      input.classList.remove('is-invalid');
      const errorDiv = input.parentElement.nextElementSibling;
      if (errorDiv) errorDiv.innerHTML = '';
    };

    // Event Submit Form
    form.addEventListener('submit', function (event) {
      event.preventDefault();
      let isFormValid = true;

      // Bersihkan error sebelumnya
      allInputs.forEach(clearError);

      // Validasi input kosong
      if (!passLamaInput.value.trim()) {
        showError(passLamaInput, 'Password Lama wajib diisi.');
        isFormValid = false;
      }
      if (!passBaruInput.value.trim()) {
        showError(passBaruInput, 'Password Baru wajib diisi.');
        isFormValid = false;
      }
      if (!konfirmasiInput.value.trim()) {
        showError(konfirmasiInput, 'Konfirmasi Password Baru wajib diisi.');
        isFormValid = false;
      }

      // Jika ada error, hentikan proses
      if (!isFormValid) return;

      // Validasi konfirmasi password
      if (passBaruInput.value !== konfirmasiInput.value) {
        showError(konfirmasiInput, 'Password Baru dan Konfirmasi tidak cocok.');
        return;
      }

      // Jika valid, tampilkan modal sukses
      showSuccessModal('Perubahan Berhasil', 'Password Anda telah berhasil diperbarui.');

      // Reset form setelah berhasil
      form.reset();
      allInputs.forEach(clearError);
      togglePasswordIcons.forEach(icon => {
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
        icon.previousElementSibling.setAttribute('type', 'password');
      });
    });

    // Event input & blur
    allInputs.forEach(input => {
      input.addEventListener('input', () => clearError(input));

      input.addEventListener('blur', () => {
        input.setAttribute('type', 'password');
        const icon = input.nextElementSibling;
        if (icon && icon.classList.contains('toggle-password')) {
          icon.classList.remove('fa-eye-slash');
          icon.classList.add('fa-eye');
        }
      });
    });
  }

  // =========================
  //  Responsivitas Form (Tetap di Tengah)
  // =========================
  window.addEventListener('resize', function () {
    const sidebar = document.getElementById('sidebar');
    const formContainer = document.querySelector('.password-form-container');

    if (sidebar && formContainer) {
      if (window.innerWidth >= 992 && sidebar.classList.contains('hidden')) {
        formContainer.style.marginLeft = 'auto';
        formContainer.style.marginRight = 'auto';
      }
    }
  });
});