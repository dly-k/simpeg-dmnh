document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("overlay");
  const toggleSidebarBtn = document.getElementById("toggleSidebar");
  const body = document.body;

  // Toggle Sidebar
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

  // Overlay Click
  if (overlay) {
    overlay.addEventListener("click", function () {
      sidebar.classList.remove("show");
      overlay.classList.remove("show");
    });
  }

  // Expand Editor Kegiatan (default terbuka)
  const editorBtn = document.querySelector('[data-bs-target="#editorKegiatan"]');
  const editorMenu = document.getElementById("editorKegiatan");
  if (editorBtn && editorMenu) {
    editorBtn.classList.remove("collapsed");
    editorBtn.setAttribute("aria-expanded", "true");
    editorMenu.classList.add("show");
  }

  // Update Date and Time
  function updateDateTime() {
    const now = new Date();
    const dateEl = document.getElementById("current-date");
    const timeEl = document.getElementById("current-time");

    if (dateEl && timeEl) {
      dateEl.textContent = now.toLocaleDateString("id-ID", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric"
      });
      timeEl.textContent = now.toLocaleTimeString("id-ID", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        hour12: false
      });
    }
  }
  setInterval(updateDateTime, 1000);
  updateDateTime();

  // Bar Chart: Jenis Kegiatan
  const jenisChartEl = document.getElementById("jenisChart");
  if (jenisChartEl) {
    const ctxJenis = jenisChartEl.getContext("2d");

    new Chart(ctxJenis, {
      type: "bar",
      data: {
        labels: ["Pendidikan", "Penelitian", "Pengabdian", "Penunjang"],
        datasets: [{
          label: "Jumlah",
          data: [88, 25, 12, 10],
          backgroundColor: "#059669",
          borderRadius: 5
        }]
      },
      options: {
        responsive: true,
        plugins: {
          tooltip: {
            callbacks: {
              label: function (context) {
                return " Jumlah: " + context.parsed.y;
              }
            }
          },
          legend: { display: false }
        },
        onClick: function (e, elements) {
          if (elements.length > 0) {
            const index = elements[0].index;
            const label = elements[0].chart.data.labels[index];
            alert("Klik pada: " + label);
          }
        },
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  }

  // Line Chart: Kegiatan per Bulan
  const bulanChartEl = document.getElementById("bulanChart");
  if (bulanChartEl) {
    const ctxBulan = bulanChartEl.getContext("2d");

    const gradient = ctxBulan.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, "#05966999");
    gradient.addColorStop(1, "#05966911");

    new Chart(ctxBulan, {
      type: "line",
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul"],
        datasets: [{
          label: "Kegiatan",
          data: [2, 10, 8, 18, 17, 20, 22],
          fill: true,
          backgroundColor: gradient,
          borderColor: "#059669",
          tension: 0.4,
          pointBackgroundColor: "#059669",
          pointRadius: 5
        }]
      },
      options: {
        responsive: true,
        plugins: {
          tooltip: {
            callbacks: {
              label: function (context) {
                return " Kegiatan: " + context.parsed.y;
              }
            }
          },
          legend: { display: false }
        },
        onClick: function (e, elements) {
          if (elements.length > 0) {
            const index = elements[0].index;
            const label = elements[0].chart.data.labels[index];
            alert("Klik pada bulan: " + label);
          }
        },
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  }
});