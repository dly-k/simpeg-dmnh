document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("overlay");
  const toggleSidebarBtn = document.getElementById("toggleSidebar");
  const body = document.body;

  if (toggleSidebarBtn) {
    toggleSidebarBtn.addEventListener("click", function () {
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

  // [BARU] Logika untuk membuka dropdown "Editor Kegiatan" secara default
  const editorBtn = document.querySelector('[data-bs-target="#editorKegiatan"]');
  const editorMenu = document.getElementById("editorKegiatan");

  if (editorBtn && editorMenu) {
    // Hapus kelas 'collapsed' dari tombol agar ikon panah tidak berputar
    editorBtn.classList.remove("collapsed");
    // Atur atribut bahwa dropdown sekarang 'expanded' (terbuka)
    editorBtn.setAttribute("aria-expanded", "true");
    // Tambahkan kelas 'show' ke menu dropdown agar terlihat
    editorMenu.classList.add("show");
  }


  if (overlay) {
    overlay.addEventListener("click", function () {
      sidebar.classList.remove("show");
      overlay.classList.remove("show");
    });
  }

  function updateDateTime() {
    const now = new Date();
    const options = { weekday: "long", year: "numeric", month: "long", day: "numeric" };
    const dateEl = document.getElementById("current-date");
    const timeEl = document.getElementById("current-time");

    if (dateEl && timeEl) {
      dateEl.textContent = now.toLocaleDateString("id-ID", options);
      timeEl.textContent = now.toLocaleTimeString("id-ID", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
      });
    }
  }

  setInterval(updateDateTime, 1000);
  updateDateTime();

  // Logika untuk Modal Konfirmasi Hapus
  const tableBody = document.querySelector("table tbody");
  const modal = document.getElementById("modalKonfirmasiHapus");
  
  if (tableBody && modal) {
    const btnBatal = document.getElementById("btnBatalHapus");
    const btnKonfirmasi = document.getElementById("btnKonfirmasiHapus");
    let rowToDelete = null;

    // Event delegation untuk semua tombol hapus di dalam tabel
    tableBody.addEventListener("click", function(event) {
        const deleteButton = event.target.closest('.btn-hapus');
        if (deleteButton) {
            event.preventDefault();
            // Simpan baris yang akan dihapus
            rowToDelete = deleteButton.closest('tr');
            // Tampilkan modal
            modal.classList.add('show');
        }
    });

    // Fungsi untuk menyembunyikan modal
    const hideModal = () => {
        modal.classList.remove('show');
        rowToDelete = null; // Reset variabel
    };

    // Tombol konfirmasi di dalam modal
    btnKonfirmasi.addEventListener('click', function() {
        if (rowToDelete) {
            rowToDelete.remove(); // Hapus baris dari tabel
            console.log("Data berhasil dihapus (simulasi).");
        }
        hideModal();
    });

    // Tombol batal di dalam modal
    btnBatal.addEventListener('click', hideModal);

    // Klik di luar area modal untuk menutup
    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            hideModal();
        }
    });
  }
});