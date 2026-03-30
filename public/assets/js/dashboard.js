document.addEventListener("DOMContentLoaded", () => {

    // =================================
    // ==== HELPER AMBIL META (AMAN) ====
    // =================================
    function getMeta(name, defaultValue = []) {
        const el = document.querySelector(`meta[name="${name}"]`);
        if (!el) return defaultValue;

        try {
            return JSON.parse(el.content);
        } catch (e) {
            return defaultValue;
        }
    }

    // =================================
    // ==== AMBIL DATA ====
    // =================================
    const lineChartLabels = getMeta("line-chart-labels");
    const lineChartDatasets = getMeta("line-chart-datasets");

    const pieChartData = getMeta("pie-chart-data", {});
    const pendidikanLabels = getMeta("pendidikan-labels");
    const pendidikanData = getMeta("pendidikan-data");

    const pangkatLabels = getMeta("pangkat-labels");
    const pangkatData = getMeta("pangkat-data");

    const jabatanLabels = getMeta("jabatan-labels");
    const lakiData = getMeta("jabatan-laki");
    const perempuanData = getMeta("jabatan-perempuan");

    // =================================
    // ==== ANIMASI ANGKA ====
    // =================================
    function animateValue(el) {
        const target = parseInt(el.getAttribute("data-value"), 10) || 0;
        const duration = 1500;
        let startTimestamp = null;

        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const currentValue = Math.floor(progress * target);

            el.textContent = currentValue.toLocaleString('id-ID');

            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                el.textContent = target.toLocaleString('id-ID');
            }
        };

        requestAnimationFrame(step);
    }

    document.querySelectorAll('.card-value').forEach(card => {
        const finalValue = card.textContent.replace(/\./g,'') || 0;
        card.setAttribute('data-value', finalValue);
        card.textContent = '0';
        animateValue(card);
    });

    // =================================
    // ==== LINE CHART (FIX UTAMA) ====
    // =================================
    const lineChartEl = document.getElementById('lineChart');

    if (lineChartEl && lineChartLabels.length && lineChartDatasets.length) {

        const ctx = lineChartEl.getContext('2d');

        const colors = ['#3b82f6','#10b981','#f59e0b','#ef4444'];

        const datasets = lineChartDatasets.map((ds, i) => ({
            label: ds.label,
            data: ds.data,
            fill: false,
            borderColor: colors[i % colors.length],
            backgroundColor: colors[i % colors.length],
            tension: 0.4,
            pointRadius: 4
        }));

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: lineChartLabels,
                datasets: datasets
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: { size: 10 }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    }

    // =================================
    // ==== PIE PENDIDIKAN ====
    // =================================
    const pegawaiData = JSON.parse(
        document.querySelector('meta[name="pegawai-pendidikan"]').content
    );
    const pendidikanChartEl = document.getElementById('pendidikanChart');

    // Pastikan elemen dan data tersedia
    if (pendidikanChartEl && pendidikanLabels.length > 0) {
        const ctx = pendidikanChartEl.getContext('2d');

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: pendidikanLabels,
                datasets: [
                    {
                        data: pendidikanData,
                        backgroundColor: [
                            '#4e73df',
                            '#1cc88a',
                            '#36b9cc',
                            '#f6c23e',
                            '#e74a3b'
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    }

    // ======================
    // ==== BAR JABATAN ====
    // =====================
    const jabatanCtx = document.getElementById("JabatanChart");

    if (jabatanCtx && jabatanLabels.length) {

        new Chart(jabatanCtx, {
            type: 'bar',
            data: {
                labels: jabatanLabels,
                datasets: [
                    {
                        label: 'Laki-laki',
                        data: lakiData,
                        backgroundColor: '#3b82f6'
                    },
                    {
                        label: 'Perempuan',
                        data: perempuanData,
                        backgroundColor: '#ec4899'
                    }
                ]
            },
            options: {
                indexAxis: 'y',
                plugins: {
                    legend: { position: 'bottom' },
                    datalabels: {
                        anchor: 'end',
                        align: 'right',
                        formatter: (v) => v === 0 ? '' : v
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grace: '20%'
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    }

    // =======================
    // ==== BAR PANGKAT ====
    // =======================
    const pangkatCtx = document.getElementById('pangkatChart');

    if (pangkatCtx && pangkatLabels.length > 0) {

    // Fungsi generate warna random
    const generateColors = (total) => {
        const colors = [];
        for (let i = 0; i < total; i++) {
        const hue = Math.floor((360 / total) * i); // biar merata
        colors.push(`hsl(${hue}, 70%, 60%)`);
        }
        return colors;
    };

    const pangkatChart = new Chart(pangkatCtx, {
        type: 'bar',
        data: {
        labels: pangkatLabels,
        datasets: [
            {
            label: 'Jumlah Dosen',
            data: pangkatData,
            backgroundColor: generateColors(pangkatLabels.length),
            borderRadius: 8,
            barThickness: 40,
            maxBarThickness: 50
            }
        ]
        },
        options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 1.2,
        plugins: {
            legend: {
            display: false
            }
        },
        scales: {
            y: {
            beginAtZero: true,
            ticks: {
                stepSize: 1
            }
            },
            x: {
            grid: {
                display: false
            }
            }
        }
        }
    });
    }

    // =================================
    // ==== PIE SUBMISI ====
    // =================================
    const pieChartEl = document.getElementById('pieChart');

    if (pieChartEl && Object.keys(pieChartData).length) {
        new Chart(pieChartEl, {
            type: 'pie',
            data: {
                labels: Object.keys(pieChartData),
                datasets: [{
                    data: Object.values(pieChartData)
                }]
            }
        });
    }

});