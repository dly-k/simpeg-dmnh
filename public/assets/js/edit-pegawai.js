document.addEventListener("DOMContentLoaded", () => {
  // == Inisialisasi Tab Utama ==
  const initMainTabs = () => {
    const mainTabNav = document.getElementById("main-tab-nav");
    if (!mainTabNav) return;

    mainTabNav.addEventListener("click", (e) => {
      const tab = e.target.closest("button.nav-link");
      if (!tab) return;

      // Nonaktifkan semua tab dan sembunyikan konten
      document.querySelectorAll(".main-tab-nav .nav-link").forEach((t) => t.classList.remove("active"));
      document.querySelectorAll(".main-tab-content").forEach((c) => (c.style.display = "none"));

      // Aktifkan tab yang diklik dan tampilkan konten terkait
      tab.classList.add("active");
      const contentEl = document.getElementById(`${tab.dataset.mainTab}-content`);
      if (contentEl) contentEl.style.display = "block";
    });
  };

  // == Inisialisasi Sub-Tab ==
  const initSubTabs = () => {
    const subTabSelectors = ["#biodata-sub-tabs"];
    subTabSelectors.forEach((selector) => {
      const tabContainer = document.querySelector(selector);
      if (!tabContainer) return;

      tabContainer.addEventListener("click", (e) => {
        const button = e.target.closest("button");
        if (!button) return;

        const parentContent = tabContainer.closest(".main-tab-content");
        if (!parentContent) return;

        // Nonaktifkan semua tombol sub-tab dan sembunyikan konten
        tabContainer.querySelectorAll("button").forEach((btn) => btn.classList.remove("active"));
        parentContent.querySelectorAll(".sub-tab-content").forEach((c) => (c.style.display = "none"));

        // Aktifkan tombol yang diklik dan tampilkan konten terkait
        button.classList.add("active");
        const contentEl = parentContent.querySelector(`#${button.dataset.tab}`);
        if (contentEl) contentEl.style.display = "block";
      });
    });
  };

  // == Jalankan Inisialisasi ==
  initMainTabs();
  initSubTabs();
});