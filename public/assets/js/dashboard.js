document.addEventListener("DOMContentLoaded", () => {
  // == Bar Chart: Jenis Kegiatan ==
  const jenisChartElement = document.getElementById("jenisChart");

  if (jenisChartElement) {
    const ctxJenis = jenisChartElement.getContext("2d");

    new Chart(ctxJenis, {
      type: "bar",
      data: {
        labels: ["Pendidikan", "Penelitian", "Pengabdian", "Penunjang"],
        datasets: [
          {
            label: "Jumlah",
            data: [88, 25, 12, 10],
            backgroundColor: "#059669",
            borderRadius: 5,
          },
        ],
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: (context) => `Jumlah: ${context.parsed.y}`,
            },
          },
        },
        // Event handler untuk klik pada bar
        onClick: (event, elements) => {
          if (elements.length > 0) {
            const index = elements[0].index;
            const label = elements[0].dataset.chart.data.labels[index];
            alert(`Klik pada: ${label}`);
          }
        },
        scales: {
          y: { beginAtZero: true },
        },
      },
    });
  }

  // == Line Chart: Kegiatan per Bulan ==
  const bulanChartElement = document.getElementById("bulanChart");

  if (bulanChartElement) {
    const ctxBulan = bulanChartElement.getContext("2d");

    const gradient = ctxBulan.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, "#05966999");
    gradient.addColorStop(1, "#05966911");

    new Chart(ctxBulan, {
      type: "line",
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul"],
        datasets: [
          {
            label: "Kegiatan",
            data: [2, 10, 8, 18, 17, 20, 22],
            fill: true,
            backgroundColor: gradient,
            borderColor: "#059669",
            tension: 0.4,
            pointBackgroundColor: "#059669",
            pointRadius: 5,
          },
        ],
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: (context) => `Kegiatan: ${context.parsed.y}`,
            },
          },
        },
        // Event handler untuk klik pada titik di chart
        onClick: (event, elements) => {
          if (elements.length > 0) {
            const index = elements[0].index;
            const label = elements[0].dataset.chart.data.labels[index];
            alert(`Klik pada bulan: ${label}`);
          }
        },
        scales: {
          y: { beginAtZero: true },
        },
      },
    });
  }
});