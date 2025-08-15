document.addEventListener("DOMContentLoaded", function () {
  
  // =================================================
  // === BAGIAN 1: LOGIKA SIDEBAR DAN TAMPILAN UMUM ===
  // =================================================

  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("overlay");
  const toggleSidebarBtn = document.getElementById("toggleSidebar");
  const body = document.body;

  if (toggleSidebarBtn && sidebar && overlay && body) {
    toggleSidebarBtn.addEventListener("click", function () {
      const isMobile = window.innerWidth <= 991;
      if (isMobile) {
        sidebar.classList.toggle("show");
        overlay.classList.toggle("show");
      } else {
        sidebar.classList.toggle("hidden");
        body.classList.toggle("sidebar-collapsed");
      }
    });

    overlay.addEventListener("click", function () {
      sidebar.classList.remove("show");
      overlay.classList.remove("show");
    });
  }

  function updateDateTime() {
    const now = new Date();
    const dateEl = document.getElementById("current-date");
    const timeEl = document.getElementById("current-time");

    if (dateEl && timeEl) {
      dateEl.textContent = now.toLocaleDateString("id-ID", {
        weekday: "long", year: "numeric", month: "long", day: "numeric"
      });
      timeEl.textContent = now.toLocaleTimeString("id-ID", {
        hour: "2-digit", minute: "2-digit", second: "2-digit", hour12: false
      });
    }
  }
  setInterval(updateDateTime, 1000);
  updateDateTime();

  // =========================================================
  // === BAGIAN 2: LOGIKA SPESIFIK HALAMAN UBAH PASSWORD ===
  // =========================================================

  // --- Fungsi Bantuan untuk Modal Berhasil ---
  function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
      modal.classList.add('show');
    }
  }

  function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
      modal.classList.remove('show');
    }
  }
  
  function showSuccessModal(title, subtitle) {
      const berhasilTitle = document.getElementById('berhasil-title');
      const berhasilSubtitle = document.getElementById('berhasil-subtitle');
      if (berhasilTitle) berhasilTitle.textContent = title;
      if (berhasilSubtitle) berhasilSubtitle.textContent = subtitle;
      
      openModal('modalBerhasil');
      
      setTimeout(() => {
          closeModal('modalBerhasil');
      }, 1000); // Otomatis menutup setelah 1 detik
  }

  // Listener untuk tombol Selesai di modal
  const btnSelesai = document.getElementById('btnSelesai');
  if (btnSelesai) {
      btnSelesai.addEventListener('click', () => closeModal('modalBerhasil'));
  }


  const form = document.getElementById('ubahPasswordForm');
  if (form) {
    const togglePasswordIcons = document.querySelectorAll('.toggle-password');
    togglePasswordIcons.forEach(icon => {
      icon.addEventListener('click', function () {
        const passwordField = this.previousElementSibling;
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
      });
    });

    const passLamaInput = document.getElementById('password_lama');
    const passBaruInput = document.getElementById('password_baru');
    const konfirmasiInput = document.getElementById('konfirmasi_password_baru');
    const allInputs = [passLamaInput, passBaruInput, konfirmasiInput];

    const showError = (input, message) => {
      input.classList.add('is-invalid');
      const errorDiv = input.parentElement.nextElementSibling;
      errorDiv.innerHTML = `<i class="fas fa-exclamation-circle me-1"></i> ${message}`;
    };

    const clearError = (input) => {
      input.classList.remove('is-invalid');
      const errorDiv = input.parentElement.nextElementSibling;
      errorDiv.innerHTML = '';
    };

    form.addEventListener('submit', function(event) {
      event.preventDefault();
      let isFormValid = true;
      allInputs.forEach(clearError);

      if (passLamaInput.value.trim() === '') {
        showError(passLamaInput, 'Password Lama wajib diisi.');
        isFormValid = false;
      }
      if (passBaruInput.value.trim() === '') {
        showError(passBaruInput, 'Password Baru wajib diisi.');
        isFormValid = false;
      }
      if (konfirmasiInput.value.trim() === '') {
        showError(konfirmasiInput, 'Konfirmasi Password Baru wajib diisi.');
        isFormValid = false;
      }

      if (!isFormValid) return;

      if (passBaruInput.value !== konfirmasiInput.value) {
        showError(konfirmasiInput, 'Password Baru dan Konfirmasi tidak cocok.');
        isFormValid = false;
      }

      if (isFormValid) {
        // DIUBAH: Mengganti alert() dengan modal sukses
        showSuccessModal('Peru Berhasil', 'Password Anda telah berhasil diperbarui.');
        
        // Logika reset form tetap dijalankan
        form.reset();
        allInputs.forEach(clearError);
        togglePasswordIcons.forEach(icon => {
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
            icon.previousElementSibling.setAttribute('type', 'password');
        });
      }
    });

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
});