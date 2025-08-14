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

  if (tableBody && modal) {
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

    // Fungsi menutup modal
    const hideModal = () => {
      modal.classList.remove("show");
      rowToDelete = null;
    };

    // Konfirmasi hapus
    btnKonfirmasi.addEventListener("click", () => {
      if (rowToDelete) {
        rowToDelete.remove();
        console.log("Data berhasil dihapus (simulasi).");
      }
      hideModal();
    });

    // Batal hapus
    btnBatal.addEventListener("click", hideModal);

    // Klik luar modal
    modal.addEventListener("click", (event) => {
      if (event.target === modal) hideModal();
    });
  }
});