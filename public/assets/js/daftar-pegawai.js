document.addEventListener("DOMContentLoaded", () => {
  // ... (kode sidebar, date & time tidak berubah) ...

  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("overlay");
  const toggleSidebarBtn = document.getElementById("toggleSidebar");
  const body = document.body;

// ==========================
// Sidebar
// ==========================
function initSidebar() {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const toggleSidebarBtn = document.getElementById('toggleSidebar');
  const body = document.body;

  toggleSidebarBtn?.addEventListener('click', () => {
    const isMobile = window.innerWidth <= 991;

    if (isMobile) {
      sidebar.classList.toggle('show');
      overlay.classList.toggle('show', sidebar.classList.contains('show'));
    } else {
      sidebar.classList.toggle('hidden');
      body.classList.toggle('sidebar-collapsed');
    }
  });

  overlay?.addEventListener('click', () => {
    sidebar.classList.remove('show');
    overlay.classList.remove('show');
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
  // --- PERUBAHAN DIMULAI DI SINI ---
  const tableCard = document.querySelector(".table-card"); // Targetkan container induk
  const modal = document.getElementById("modalKonfirmasiHapus");
  
  // Get success modal elements
  const modalBerhasil = document.getElementById("modalBerhasil");
  const berhasilTitle = document.getElementById("berhasil-title");
  const berhasilSubtitle = document.getElementById("berhasil-subtitle");
  const btnSelesai = document.getElementById("btnSelesai");
  let successAudio = null;

  if (tableCard && modal && modalBerhasil) { // Periksa keberadaan tableCard
    const btnBatal = document.getElementById("btnBatalHapus");
    const btnKonfirmasi = document.getElementById("btnKonfirmasiHapus");
    let rowToDelete = null;

    // Delegasi event dari .table-card untuk menangkap klik pada .btn-hapus di kedua tabel
    tableCard.addEventListener("click", (event) => {
      const deleteButton = event.target.closest(".btn-hapus");
      if (deleteButton) {
        event.preventDefault();
        rowToDelete = deleteButton.closest("tr");
        modal.classList.add("show");
      }
    });
    // --- PERUBAHAN SELESAI DI SINI ---

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
      successAudio = new Audio('/assets/sounds/success.mp3');
      successAudio.play().catch(error => {
        console.log('Error memutar suara:', error);
        if (error.name === 'NotAllowedError') {
          console.log('Autoplay diblokir oleh browser. Butuh interaksi pengguna terlebih dahulu.');
        } else if (error.name === 'NotFoundError') {
          console.log('File audio tidak ditemukan. Periksa path: /assets/sounds/success.mp3');
        }
      });

      setTimeout(() => {
        hideSuccessModal();
      }, 1000);
    };

    // Fungsi menutup modal berhasil
    const hideSuccessModal = () => {
      modalBerhasil.classList.remove("show");
      if (successAudio) {
        successAudio.pause();
        successAudio.currentTime = 0;
      }
    };

    // Konfirmasi hapus
    btnKonfirmasi.addEventListener("click", () => {
      if (rowToDelete) {
        rowToDelete.remove();
        console.log("Data berhasil dihapus (simulasi).");
        hideConfirmationModal();
        showSuccessModal();
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
  const pegawaiAktifTab = document.getElementById('pegawai-aktif-tab');
  const riwayatPegawaiTab = document.getElementById('riwayat-pegawai-tab');
  const btnTambah = document.getElementById('btn-tambah-pegawai');

  if (pegawaiAktifTab && riwayatPegawaiTab && btnTambah) {
    // Event listener untuk tab Pegawai Aktif
    pegawaiAktifTab.addEventListener('click', () => {
      btnTambah.style.display = 'inline-flex'; // Tampilkan kembali tombol
    });

    // Event listener untuk tab Riwayat Pegawai
    riwayatPegawaiTab.addEventListener('click', () => {
      btnTambah.style.display = 'none'; // Sembunyikan tombol
    });
  }

});