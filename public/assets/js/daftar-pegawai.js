document.addEventListener("DOMContentLoaded", () => {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("overlay");
  const toggleSidebarBtn = document.getElementById("toggleSidebar");
  const body = document.body;

  /* =========================
     Sidebar Toggle
  ========================== */
  if (toggleSidebarBtn) {
    toggleSidebarBtn.addEventListener("click", () => {
      const isMobile = window.innerWidth <= 991;
      if (isMobile) {
        sidebar.classList.toggle("show");
        overlay.classList.toggle("show", sidebar.classList.contains("show"));
      } else {
        sidebar.classList.toggle("hidden");
        body.classList.toggle("sidebar-collapsed");
      }
    });
  }

  /* =========================
     Default Open: Editor Kegiatan
  ========================== */
  const editorBtn = document.querySelector('[data-bs-target="#editorKegiatan"]');
  const editorMenu = document.getElementById("editorKegiatan");

  if (editorBtn && editorMenu) {
    editorBtn.classList.remove("collapsed");
    editorBtn.setAttribute("aria-expanded", "true");
    editorMenu.classList.add("show");
  }

  /* =========================
     Overlay Click to Close Sidebar
  ========================== */
  if (overlay) {
    overlay.addEventListener("click", () => {
      sidebar.classList.remove("show");
      overlay.classList.remove("show");
    });
  }

  /* =========================
     Update Date & Time
  ========================== */
  const updateDateTime = () => {
    const now = new Date();
    const dateEl = document.getElementById("current-date");
    const timeEl = document.getElementById("current-time");

    if (dateEl && timeEl) {
      dateEl.textContent = now.toLocaleDateString("id-ID", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
      });
      timeEl.textContent = now.toLocaleTimeString("id-ID", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
      });
    }
  };

  setInterval(updateDateTime, 1000);
  updateDateTime();

  /* =========================
     Modal Konfirmasi Hapus
  ========================== */
  const tableBody = document.querySelector("table tbody");
  const modal = document.getElementById("modalKonfirmasiHapus");
  
  // Get success modal elements
  const modalBerhasil = document.getElementById("modalBerhasil");
  const berhasilTitle = document.getElementById("berhasil-title");
  const berhasilSubtitle = document.getElementById("berhasil-subtitle");
  const btnSelesai = document.getElementById("btnSelesai");
  let successAudio = null; // Variabel untuk menyimpan instance audio

  if (tableBody && modal && modalBerhasil) {
    const btnBatal = document.getElementById("btnBatalHapus");
    const btnKonfirmasi = document.getElementById("btnKonfirmasiHapus");
    let rowToDelete = null;

    // Delegasi event untuk tombol hapus
    tableBody.addEventListener("click", (event) => {
      const deleteButton = event.target.closest(".btn-hapus");
      if (deleteButton) {
        event.preventDefault();
        rowToDelete = deleteButton.closest("tr");
        modal.classList.add("show");
      }
    });

    // Fungsi menutup modal konfirmasi
    const hideConfirmationModal = () => {
      modal.classList.remove("show");
      rowToDelete = null;
    };

    // Fungsi menampilkan modal berhasil
    const showSuccessModal = () => {
      berhasilTitle.textContent = "Data Berhasil Dihapus";
      berhasilSubtitle.textContent = "Data pegawai telah berhasil dihapus dari sistem.";
      modalBerhasil.classList.add("show");

      // Putar musik berhasil
      successAudio = new Audio('/assets/sounds/success.mp3'); // Pastikan path file audio benar
      successAudio.play().catch(error => {
        console.log('Error memutar suara:', error);
        if (error.name === 'NotAllowedError') {
          console.log('Autoplay diblokir oleh browser. Butuh interaksi pengguna terlebih dahulu.');
        } else if (error.name === 'NotFoundError') {
          console.log('File audio tidak ditemukan. Periksa path: /assets/sounds/success.mp3');
        }
      });

      // Sembunyikan modal setelah 1 detik
      setTimeout(() => {
        hideSuccessModal();
      }, 1000);
    };

    // Fungsi menutup modal berhasil
    const hideSuccessModal = () => {
      modalBerhasil.classList.remove("show");
      if (successAudio) {
        successAudio.pause(); // Hentikan audio
        successAudio.currentTime = 0; // Reset audio ke awal
      }
    };

    // Konfirmasi hapus
    btnKonfirmasi.addEventListener("click", () => {
      if (rowToDelete) {
        rowToDelete.remove();
        console.log("Data berhasil dihapus (simulasi).");
        hideConfirmationModal(); // Sembunyikan modal konfirmasi dulu
        showSuccessModal(); // Tampilkan modal berhasil
      } else {
        hideConfirmationModal();
      }
    });
    
    // Batal hapus
    btnBatal.addEventListener("click", hideConfirmationModal);

    // Klik luar modal konfirmasi
    modal.addEventListener("click", (event) => {
      if (event.target === modal) hideConfirmationModal();
    });

    // Tombol selesai pada modal berhasil
    if (btnSelesai) {
      btnSelesai.addEventListener("click", hideSuccessModal);
    }

    // Klik luar modal berhasil
    modalBerhasil?.addEventListener("click", (event) => {
      if (event.target === modalBerhasil) hideSuccessModal();
    });
  }
});