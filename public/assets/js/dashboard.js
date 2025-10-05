document.addEventListener("DOMContentLoaded", () => {

    // =================================
    // ==== AMBIL DATA DARI META TAG ====
    // =================================
    const lineChartMeta = document.querySelector('meta[name="line-chart-data"]');
    const lineChartLabelsMeta = document.querySelector('meta[name="line-chart-labels"]');
    const pieChartMeta = document.querySelector('meta[name="pie-chart-data"]');

    const lineChartData = {
        labels: lineChartLabelsMeta ? JSON.parse(lineChartLabelsMeta.content) : [],
        data: lineChartMeta ? JSON.parse(lineChartMeta.content) : []
    };

    const pieChartData = pieChartMeta ? JSON.parse(pieChartMeta.content) : {};

    // =================================
    // ==== ANIMASI HITUNG NAIK ====
    // =================================
    function animateValue(el) {
        const target = parseInt(el.getAttribute("data-value"), 10);
        const duration = 1500; // Durasi animasi dalam ms
        let startTimestamp = null;

        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const currentValue = Math.floor(progress * target);

            el.textContent = currentValue.toLocaleString('id-ID');

            if (progress < 1) {
                window.requestAnimationFrame(step);
            } else {
                el.textContent = target.toLocaleString('id-ID');
            }
        };
        window.requestAnimationFrame(step);
    }

    document.querySelectorAll('.card-value').forEach(card => {
        const finalValue = card.textContent.replace(/\./g,''); // hapus titik ribuan jika ada
        card.setAttribute('data-value', finalValue);
        card.textContent = '0';
        animateValue(card);
    });

    // =================================
    // ==== LINE CHART ====
    // =================================
    const lineChartEl = document.getElementById('lineChart');
    if (lineChartEl && lineChartData.labels.length && lineChartData.data.length) {
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

    // =================================
    // ==== PIE CHART ====
    // =================================
    const pieChartEl = document.getElementById('pieChart');
    if (pieChartEl && Object.keys(pieChartData).length) {
        new Chart(pieChartEl.getContext('2d'), {
            type: 'pie',
            data: {
                labels: Object.keys(pieChartData),
                datasets: [{
                    label: 'Jumlah Submisi',
                    data: Object.values(pieChartData),
                    backgroundColor: [
                        '#198754', // Pendidikan
                        '#20c997', // Penelitian
                        '#fd7e14', // Pengabdian
                        '#6f42c1', // Penghargaan
                        '#ffc107', // Pelatihan
                        '#0dcaf0'  // Penunjang
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top' } }
            }
        });
    }

});