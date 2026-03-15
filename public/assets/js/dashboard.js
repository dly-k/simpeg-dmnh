document.addEventListener("DOMContentLoaded", () => {

    // =================================
    // ==== AMBIL DATA DARI META TAG ====
    // =================================
    const lineChartMeta = document.querySelector('meta[name="line-chart-data"]');
    const lineChartLabelsMeta = document.querySelector('meta[name="line-chart-labels"]');
    const pieChartMeta = document.querySelector('meta[name="pie-chart-data"]');
    const pendidikanLabelsMeta = document.querySelector('meta[name="pendidikan-labels"]');
    const pendidikanDataMeta = document.querySelector('meta[name="pendidikan-data"]');

    const pangkatLabelsMeta = document.querySelector('meta[name="pangkat-labels"]');
    const pangkatDataMeta = document.querySelector('meta[name="pangkat-data"]');

    const lineChartData = {
        labels: lineChartLabelsMeta ? JSON.parse(lineChartLabelsMeta.content) : [],
        data: lineChartMeta ? JSON.parse(lineChartMeta.content) : []
    };

    const pieChartData = pieChartMeta ? JSON.parse(pieChartMeta.content) : {};

    const pendidikanLabels = pendidikanLabelsMeta ? JSON.parse(pendidikanLabelsMeta.content) : [];
    const pendidikanData = pendidikanDataMeta ? JSON.parse(pendidikanDataMeta.content) : [];

    const pangkatLabels = pangkatLabelsMeta ? JSON.parse(pangkatLabelsMeta.content) : [];
    const pangkatData = pangkatDataMeta ? JSON.parse(pangkatDataMeta.content) : [];

    // =================================
    // ==== ANIMASI HITUNG NAIK ====
    // =================================
    function animateValue(el) {
        const target = parseInt(el.getAttribute("data-value"), 10);
        const duration = 1500;
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
        const finalValue = card.textContent.replace(/\./g,'');
        card.setAttribute('data-value', finalValue);
        card.textContent = '0';
        animateValue(card);
    });

    // =================================
    // ==== LINE CHART ====
    // =================================
    const lineChartEl = document.getElementById('lineChart');

    if (lineChartEl && lineChartData.labels.length) {

        const ctxLine = lineChartEl.getContext('2d');

        const gradient = ctxLine.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, "rgba(54,162,235,0.6)");
        gradient.addColorStop(1, "rgba(54,162,235,0.1)");

        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: lineChartData.labels,
                datasets: [{
                    label: 'Jumlah Submisi',
                    data: lineChartData.data,
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: 'rgba(54,162,235,1)',
                    tension: 0.4,
                    pointBackgroundColor: 'rgba(54,162,235,1)',
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
    // ==== PIE CHART DISTRIBUSI PENDIDIKAN ====
    // =================================
    const pegawaiData = JSON.parse(
        document.querySelector('meta[name="pegawai-pendidikan"]').content
    );

    const pendidikanChartEl = document.getElementById('pendidikanChart');

    if (pendidikanChartEl && pendidikanLabels.length) {

        new Chart(pendidikanChartEl.getContext('2d'), {
            type: 'pie',
            data: {
                labels: pendidikanLabels,
                datasets: [{
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
                }]
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

    // =================================
    // ==== BAR CHART JABATAN ====
    // =================================
    const jabatanLabels = JSON.parse(
        document.querySelector('meta[name="jabatan-labels"]').content
    );

    const lakiData = JSON.parse(
        document.querySelector('meta[name="jabatan-laki"]').content
    );

    const perempuanData = JSON.parse(
        document.querySelector('meta[name="jabatan-perempuan"]').content
    );

    const jabatanCtx = document.getElementById("JabatanChart");

    if (jabatanCtx) {

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
                responsive: true,
                indexAxis: 'y',
                plugins: {
                    legend: { position: 'bottom' },
                    datalabels:{
                        color:'#000',
                        anchor:'end',
                        align:'right',
                        formatter:function(value){
                            return value === 0 ? '' : value;
                        }
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

 // =================================
// ==== BAR CHART PANGKAT DOSEN ====
// =================================
const pangkatCtx = document.getElementById('pangkatChart');

if (pangkatCtx && pangkatLabels.length) {

    new Chart(pangkatCtx, {
        type: 'bar',
        data: {
            labels: pangkatLabels,
            datasets: [{
                label: 'Jumlah Dosen',
                data: pangkatData,
                backgroundColor: '#4f46e5',
                borderRadius: 8,
                barThickness: 40,
                maxBarThickness: 50
            }]
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
    // ==== PIE CHART SUBMISI ====
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
                        '#198754',
                        '#20c997',
                        '#fd7e14',
                        '#6f42c1',
                        '#ffc107',
                        '#0dcaf0'
                    ]
                }]
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

});