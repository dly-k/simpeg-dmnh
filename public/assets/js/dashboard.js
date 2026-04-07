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
    const metaPendidikan = document.querySelector('meta[name="pegawai-pendidikan"]');
    const dataPegawaiPendidikan = metaPendidikan ? JSON.parse(metaPendidikan.content) : {};

    const ctxPendidikan = document.getElementById('pendidikanChart');

    if (ctxPendidikan && pendidikanLabels.length > 0) {

        const colors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'];

        const chartPendidikan = new Chart(ctxPendidikan, {
            type: 'pie',
            plugins: typeof ChartDataLabels !== 'undefined' ? [ChartDataLabels] : [],
            data: {
                labels: pendidikanLabels,
                datasets: [{
                    data: pendidikanData,
                    backgroundColor: colors,
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { usePointStyle: true, padding: 15 }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                return `${label}: ${value} orang`;
                            }
                        }
                    },

                    datalabels: {
                        color: '#ffffff',
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        formatter: (value, ctx) => {
                            let sum = 0;
                            let dataArr = ctx.chart.data.datasets[0].data;

                            dataArr.forEach(data => {
                                sum += Number(data);
                            });

                            let percentage = (value * 100 / sum).toFixed(1) + "%";

                            return value > 0 ? percentage : '';
                        }
                    }
                },

                onClick: (event, elements) => {
                    if (elements.length > 0) {
                        const index = elements[0].index;
                        const jenjang = pendidikanLabels[index];
                        const listNama = dataPegawaiPendidikan[jenjang] || [];

                        // Update Judul Modal
                        document.getElementById('labelJenjangTerpilih').innerText = jenjang;

                        // Build List
                        let html = '';
                        listNama.forEach((nama, i) => {
                            html += `
                                <div class="list-group-item d-flex justify-content-between align-items-center border-0 mb-1 rounded py-2 px-3">
                                    <div class="text-dark fw-medium">
                                        <i class="fas fa-user-circle text-primary opacity-50 me-2"></i> ${nama}
                                    </div>
                                    <span class="badge bg-light text-muted border fst-italic">#${i + 1}</span>
                                </div>`;
                        });

                        document.getElementById('listPegawaiPendidikan').innerHTML =
                            html || '<div class="p-3 text-center">Data kosong</div>';

                        // Tampilkan Modal
                        const myModal = new bootstrap.Modal(document.getElementById('modalPendidikanAuto'));
                        myModal.show();
                    }
                }
            }
        });
    }

    // ======================
    // ==== BAR JABATAN ====
    // =====================
    const metaJabatan = document.querySelector('meta[name="pegawai-jabatan-gender"]');
    const dataJabatanGender = metaJabatan ? JSON.parse(metaJabatan.content) : {};

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
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' },
                    // Menampilkan angka di ujung batang
                    datalabels: {
                        anchor: 'end',
                        align: 'right',
                        color: '#5a5c69',
                        font: { weight: 'bold', size: 11 },
                        formatter: (v) => v === 0 ? '' : v // Sembunyikan jika nilainya 0
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grace: '20%' // Ruang bernapas ekstra di kanan agar angka tidak terpotong
                    }
                },
                // DETEKSI KLIK PADA GRAFIK UNTUK BUKA MODAL
                onClick: (event, elements) => {
                    if (elements.length > 0) {
                        const index = elements[0].index;
                        const labelJabatan = jabatanLabels[index];
                        const detailData = dataJabatanGender[labelJabatan] || {};

                        // 1. Update Judul Modal
                        document.getElementById('labelJabatanTerpilih').innerText = labelJabatan;

                        // 2. Fungsi Helper untuk Build List Modal (ANGKA DI DEPAN)
                        const buildListHtml = (names) => {
                            if (!names || names.length === 0) return '<div class="p-4 text-center text-muted">Tidak ada data</div>';
                            return names.map((nama, i) => `
                                <div class="list-group-item d-flex justify-content-start align-items-center border-0 mb-1 rounded py-2 px-3">
                                    <div class="fw-bold text-secondary me-3" style="min-width: 20px;">${i + 1}.</div>
                                    <div class="text-dark fw-medium">
                                        <i class="fas fa-user-circle opacity-50 me-2 text-primary"></i> ${nama}
                                    </div>
                                </div>`).join('');
                        };

                        // 3. Masukkan Data ke Tab
                        const lakiList = detailData['Laki-laki'] || [];
                        const perempList = detailData['Perempuan'] || [];

                        document.getElementById('cnt-laki').innerText = lakiList.length;
                        document.getElementById('cnt-perempuan').innerText = perempList.length;
                        document.getElementById('list-laki').innerHTML = buildListHtml(lakiList);
                        document.getElementById('list-perempuan').innerHTML = buildListHtml(perempList);

                        // 4. Tampilkan Modal
                        const modal = new bootstrap.Modal(document.getElementById('modalJabatanAuto'));
                        modal.show();
                    }
                }
            },
            // Menyalakan plugin agar datalabels bisa berfungsi
            plugins: typeof ChartDataLabels !== 'undefined' ? [ChartDataLabels] : [] 
        });
    }

    // =======================
    // ==== BAR PANGKAT ====
    // =======================
    const metaPangkat = document.querySelector('meta[name="pegawai-pangkat"]');
    const dataPegawaiPangkat = metaPangkat ? JSON.parse(metaPangkat.content) : {};

    const pangkatCtx = document.getElementById('pangkatChart');

    if (pangkatCtx && typeof pangkatLabels !== 'undefined' && pangkatLabels.length > 0) {

        const generateColors = (total) => {
            const colors = [];
            for (let i = 0; i < total; i++) {
                const hue = Math.floor((360 / total) * i); 
                colors.push(`hsl(${hue}, 70%, 60%)`);
            }
            return colors;
        };

        // 🔥 KUNCI: Kita simpan array warnanya di dalam variabel agar bisa dipanggil saat diklik
        const bgColors = generateColors(pangkatLabels.length);

        const pangkatChart = new Chart(pangkatCtx, {
            type: 'bar',
            plugins: typeof ChartDataLabels !== 'undefined' ? [ChartDataLabels] : [],
            data: {
                labels: pangkatLabels,
                datasets: [
                    {
                        label: 'Jumlah Dosen',
                        data: pangkatData,
                        backgroundColor: bgColors, // Pakai variabel warna yang sudah disimpan
                        borderRadius: 8,
                        barThickness: 40,
                        maxBarThickness: 50
                    }
                ]
            },
            options: {
                responsive: true,
                // 🔥 AGAR GRAFIKNYA PANJANG (TIDAK BANTET), INI HARUS FALSE
                maintainAspectRatio: false, 
                
                layout: { padding: { top: 35 } },
                plugins: {
                    legend: { display: false },
                    datalabels: {
                        anchor: 'end',
                        align: 'top', 
                        color: '#5a5c69',
                        font: { weight: 'bold', size: 11 },
                        formatter: (v) => v === 0 ? '' : v 
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    },
                    x: {
                        grid: { display: false }
                    }
                },
                onClick: (event, elements) => {
                    if (elements.length > 0) {
                        const index = elements[0].index;
                        const labelPangkat = pangkatLabels[index];
                        const listNama = dataPegawaiPangkat[labelPangkat] || [];
                        
                        // 🔥 AMBIL WARNA DARI BATANG YANG DIKLIK
                        const warnaBatang = bgColors[index];

                        // 1. Update Judul Modal & UBAH WARNANYA
                        const titleEl = document.getElementById('labelPangkatTerpilih');
                        titleEl.innerText = labelPangkat;
                        titleEl.classList.remove('text-info'); // Hapus warna biru bawaan
                        titleEl.style.color = warnaBatang; // Ganti dengan warna batang grafik

                        // 2. Build List Modal (Ikon User juga diubah warnanya)
                        const buildListHtml = (names) => {
                            if (!names || names.length === 0) return '<div class="p-4 text-center text-muted">Tidak ada data</div>';
                            return names.map((nama, i) => `
                                <div class="list-group-item d-flex justify-content-start align-items-center border-0 mb-1 rounded py-2 px-3">
                                    <div class="fw-bold text-secondary me-3" style="min-width: 20px;">${i + 1}.</div>
                                    <div class="text-dark fw-medium">
                                        <i class="fas fa-user-circle opacity-50 me-2" style="color: ${warnaBatang};"></i> ${nama}
                                    </div>
                                </div>`).join('');
                        };

                        document.getElementById('listPegawaiPangkat').innerHTML = buildListHtml(listNama);

                        const modal = new bootstrap.Modal(document.getElementById('modalPangkatAuto'));
                        modal.show();
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