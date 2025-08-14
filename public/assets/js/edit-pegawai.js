document.addEventListener("DOMContentLoaded", () => {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("overlay");
  const toggleSidebarBtn = document.getElementById("toggleSidebar");

  /* =========================
     Sidebar Toggle
  ========================== */
  if (toggleSidebarBtn && sidebar && overlay) {
    toggleSidebarBtn.addEventListener("click", () => {
      const isMobile = window.innerWidth <= 991;
      if (isMobile) {
        sidebar.classList.toggle("show");
        overlay.classList.toggle("show", sidebar.classList.contains("show"));
      } else {
        sidebar.classList.toggle("hidden");
      }
    });

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

    if (dateEl) {
      dateEl.textContent = now.toLocaleDateString("id-ID", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
      });
    }

    if (timeEl) {
      timeEl.textContent = now
        .toLocaleTimeString("id-ID", {
          hour: "2-digit",
          minute: "2-digit",
          second: "2-digit",
        })
        .replace(/\./g, ":");
    }
  };

  updateDateTime();
  setInterval(updateDateTime, 1000);

  /* =========================
     Main Tabs Navigation
  ========================== */
  const mainTabNav = document.getElementById("main-tab-nav");
  if (mainTabNav) {
    mainTabNav.addEventListener("click", (e) => {
      if (e.target.matches("button.nav-link")) {
        // Reset semua tab
        document
          .querySelectorAll(".main-tab-nav .nav-link")
          .forEach((tab) => tab.classList.remove("active"));

        document
          .querySelectorAll(".main-tab-content")
          .forEach((content) => (content.style.display = "none"));

        // Aktifkan tab yang diklik
        e.target.classList.add("active");
        const contentEl = document.getElementById(
          `${e.target.dataset.mainTab}-content`
        );
        if (contentEl) contentEl.style.display = "block";
      }
    });
  }

  /* =========================
     Sub Tabs (Biodata & lainnya)
  ========================== */
  const subTabSelectors = ["#biodata-sub-tabs"];
  subTabSelectors.forEach((selector) => {
    const tabContainer = document.querySelector(selector);
    if (tabContainer) {
      tabContainer.addEventListener("click", (e) => {
        if (e.target.matches("button")) {
          const parentContent = tabContainer.closest(".main-tab-content");
          if (!parentContent) return;

          // Reset semua sub-tab
          tabContainer
            .querySelectorAll("button")
            .forEach((btn) => btn.classList.remove("active"));
          e.target.classList.add("active");

          parentContent
            .querySelectorAll(".sub-tab-content")
            .forEach((content) => (content.style.display = "none"));

          // Tampilkan konten sesuai sub-tab
          const contentEl = parentContent.querySelector(
            `#${e.target.dataset.tab}`
          );
          if (contentEl) contentEl.style.display = "block";
        }
      });
    }
  });
});