document.addEventListener("DOMContentLoaded", () => {
    // =================================
    // ==== ANIMASI HITUNG NAIK ====
    // =================================

    /**
     * Fungsi untuk membuat animasi angka menghitung dari 0 ke nilai target.
     * @param {HTMLElement} el - Elemen yang berisi angka.
     */
    function animateValue(el) {
        const target = parseInt(el.getAttribute("data-value"), 10);
        const duration = 1500; // Durasi animasi dalam milidetik
        let startTimestamp = null;

        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const currentValue = Math.floor(progress * target);
            
            // Menggunakan toLocaleString('id-ID') untuk format ribuan dengan titik
            el.textContent = currentValue.toLocaleString('id-ID');

            if (progress < 1) {
                window.requestAnimationFrame(step);
            } else {
                // Memastikan nilai akhir sesuai target dan terformat
                el.textContent = target.toLocaleString('id-ID');
            }
        };
        window.requestAnimationFrame(step);
    }

    // Terapkan animasi ke semua elemen .card-value
    document.querySelectorAll('.card-value').forEach(card => {
        // Simpan nilai asli di atribut data dan mulai dari 0
        const finalValue = card.textContent;
        card.setAttribute('data-value', finalValue);
        card.textContent = '0';
        // Panggil fungsi animasi
        animateValue(card);
    });


    // =================================
    // ==== LINE CHART ====
    // =================================
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

    // =================================
    // ==== PIE CHART ====
    // =================================
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