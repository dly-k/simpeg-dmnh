document.addEventListener("DOMContentLoaded", () => {
  // == Inisialisasi Sidebar ==
  const initSidebar = () => {
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");
    const toggleSidebarBtn = document.getElementById("toggleSidebar");
    const body = document.body;

    const closeMobileSidebar = () => {
      sidebar.classList.remove("show");
      overlay.classList.remove("show");
    };

    // Event: Klik tombol toggle sidebar
    toggleSidebarBtn?.addEventListener("click", (event) => {
      event.stopPropagation();
      const isMobile = window.innerWidth <= 991;

      if (isMobile) {
        // Toggle sidebar dan overlay pada mode mobile
        sidebar.classList.toggle("show");
        overlay.classList.toggle("show", sidebar.classList.contains("show"));
      } else {
        // Toggle sidebar pada mode desktop
        sidebar.classList.toggle("hidden");
        body.classList.toggle("sidebar-collapsed");
      }
    });

    // Event: Klik di luar sidebar pada mode mobile
    document.addEventListener("click", (event) => {
      const isMobile = window.innerWidth <= 991;
      const isSidebarShown = isMobile && sidebar.classList.contains("show");
      const isClickOutside = !sidebar.contains(event.target);

      if (isSidebarShown && isClickOutside) {
        closeMobileSidebar();
      }
    });
  };

  // == Inisialisasi Jam dan Tanggal ==
  const initClock = () => {
    const dateEl = document.getElementById("current-date");
    const timeEl = document.getElementById("current-time");
    const updateDateTime = () => {
      if (!dateEl || !timeEl) return;

      const now = new Date();

      const dateOptions = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
        timeZone: "Asia/Jakarta"
      };

      const timeOptions = {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        timeZone: "Asia/Jakarta",
        hour12: false
      };

      dateEl.textContent = now.toLocaleDateString("id-ID", dateOptions);
      timeEl.textContent = now.toLocaleTimeString("id-ID", timeOptions);
    };

    updateDateTime();
    setInterval(updateDateTime, 1000);
  };

  // == Inisialisasi Panel Editor & Editor Kegiatan ==
  const initEditorPanels = () => {
    const panels = [
      { button: '[data-bs-target="#editor"]', panel: "editor" },
      { button: '[data-bs-target="#editorKegiatan"]', panel: "editorKegiatan" }
    ];

    panels.forEach(({ button, panel }) => {
      const btnEl = document.querySelector(button);
      const panelEl = document.getElementById(panel);

      if (btnEl && panelEl) {
        btnEl.classList.remove("collapsed");
        btnEl.setAttribute("aria-expanded", "true");
        panelEl.classList.add("show");
      }
    });
  };

  // == Jalankan Inisialisasi ==
  initSidebar();
  initClock();
  initEditorPanels();
});