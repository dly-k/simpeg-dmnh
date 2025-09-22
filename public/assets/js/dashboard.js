document.addEventListener("DOMContentLoaded", () => {
    // ==== LINE CHART ====
    const lineChartEl = document.getElementById('lineChart');
    if (lineChartEl && typeof lineChartData !== 'undefined') {
        const ctxLine = lineChartEl.getContext('2d');
        const gradient = ctxLine.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, "rgba(54, 162, 235, 0.6)");
        gradient.addColorStop(1, "rgba(54, 162, 235, 0.1)");

        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: lineChartData.labels,
                datasets: [{
                    label: 'Jumlah Submisi',
                    data: lineChartData.data,
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    tension: 0.4,
                    pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    }

    // ==== PIE CHART ====
    const pieChartEl = document.getElementById('pieChart');
    if (pieChartEl && typeof pieChartData !== 'undefined') {
        new Chart(pieChartEl.getContext('2d'), {
            type: 'pie',
            data: {
                labels: Object.keys(pieChartData),
                datasets: [{
                    label: 'Jumlah Submisi',
                    data: Object.values(pieChartData),
                    backgroundColor: [
                        '#198754', // Pendidikan (Hijau)
                        '#20c997', // Penelitian (Teal)
                        '#fd7e14', // Pengabdian (Oranye)
                        '#6f42c1', // Penghargaan (Ungu)
                        '#ffc107', // Pelatihan (Kuning)
                        '#0dcaf0'  // Penunjang (Biru Langit)
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
    }
});