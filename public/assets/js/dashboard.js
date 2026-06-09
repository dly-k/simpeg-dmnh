document.addEventListener("DOMContentLoaded", () => {

    // =================================
    // ==== HELPER AMBIL META INSTAN ===
    // =================================
    function getMeta(name, defaultValue = []) {
        const el = document.querySelector(`meta[name="${name}"]`);
        if (!el) return defaultValue;
        try { return JSON.parse(el.content); } 
        catch (e) { return defaultValue; }
    }

    const lineChartLabels = getMeta("line-chart-labels");
    const lineChartDatasets = getMeta("line-chart-datasets");
    const pieChartData = getMeta("pie-chart-data", {});
    
    const pendidikanLabels = getMeta("pendidikan-labels");
    const pendidikanDosen = getMeta("pendidikan-dosen");
    const pendidikanTendik = getMeta("pendidikan-tendik");
    const dataPegawaiPendidikan = getMeta("pegawai-pendidikan", {});

    const pangkatLabels = getMeta("pangkat-labels");
    const dataPegawaiPangkat = getMeta("pegawai-pangkat", {});

    const jabatanLabels = getMeta("jabatan-labels");
    const lakiData = getMeta("jabatan-laki");
    const perempuanData = getMeta("jabatan-perempuan");
    const dataJabatanGender = getMeta("pegawai-jabatan-gender", {});

    // Perhatikan: Mengambil data detail umur yang sudah dipisah
    const dataUmurDosen = getMeta("pegawai-umur-dosen", {});
    const dataUmurTendik = getMeta("pegawai-umur-tendik", {});

    // =================================
    // ==== ANIMASI ANGKA KARTU ========
    // =================================
    document.querySelectorAll('.card-value').forEach(card => {
        const target = parseInt(card.textContent.replace(/\./g,''), 10) || 0;
        card.textContent = '0';
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / 1500, 1);
            card.textContent = Math.floor(progress * target).toLocaleString('id-ID');
            if (progress < 1) requestAnimationFrame(step);
            else card.textContent = target.toLocaleString('id-ID');
        };
        requestAnimationFrame(step);
    });

    // =================================
    // ==== 1. LINE CHART TREN =========
    // =================================
    const lineChartEl = document.getElementById('lineChart');
    if (lineChartEl && lineChartLabels.length && lineChartDatasets.length) {
        new Chart(lineChartEl.getContext('2d'), {
            type: 'line', data: { labels: lineChartLabels, datasets: lineChartDatasets.map((ds, i) => ({...ds, fill: false, borderColor: ['#3b82f6','#10b981','#f59e0b','#ef4444'][i%4], tension: 0.4})) },
            options: { responsive: true, plugins: { legend: { position: 'bottom', labels: { usePointStyle: true } } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
        });
    }

    // =================================
    // ==== PIE PENDIDIKAN ====
    // =================================
    const ctxPendidikan = document.getElementById('pendidikanChart');
    if (ctxPendidikan && pendidikanLabels.length > 0) {
        const pendidikanTotal = pendidikanLabels.map((_, i) => (pendidikanDosen[i] || 0) + (pendidikanTendik[i] || 0));
        const colors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#fd7e14', '#6610f2'];

        new Chart(ctxPendidikan, {
            type: 'pie', 
            plugins: typeof ChartDataLabels !== 'undefined' ? [ChartDataLabels] : [],
            data: {
                labels: pendidikanLabels,
                datasets: [{
                    data: pendidikanTotal,
                    backgroundColor: colors.slice(0, pendidikanLabels.length),
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'right', labels: { usePointStyle: true, padding: 15 } },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let total = context.raw || 0;
                                let index = context.dataIndex;
                                let jmlDosen = pendidikanDosen[index] || 0;
                                let jmlTendik = pendidikanTendik[index] || 0;
                                let sum = 0;
                                context.chart.data.datasets[0].data.forEach(d => sum += Number(d));
                                let percentage = sum > 0 ? (total * 100 / sum).toFixed(1) + "%" : "0%";
                                return ` Total: ${total} orang | Dosen: ${jmlDosen}, Tendik: ${jmlTendik}`;
                            }
                        }
                    },
                    datalabels: {
                        color: '#ffffff',
                        font: { weight: 'bold', size: 13 },
                        formatter: (value, ctx) => {
                            let sum = 0;
                            ctx.chart.data.datasets[0].data.forEach(d => sum += Number(d));
                            let percentage = (value * 100 / sum).toFixed(1) + "%";
                            return value > 0 ? `${value} (${percentage})` : '';
                        }
                    }
                },
                onClick: (event, elements) => {
                    if (elements.length > 0) {
                        const index = elements[0].index;
                        const jenjang = pendidikanLabels[index];
                        const listNama = dataPegawaiPendidikan[jenjang] || [];

                        document.getElementById('labelJenjangTerpilih').innerText = jenjang;

                        let listDosen = [];
                        let listTendik = [];

                        listNama.forEach(p => {
                            let nama = typeof p === 'object' ? p.nama : p;
                            let kategori = typeof p === 'object' ? p.kategori : '';
                            if (kategori === 'Dosen') listDosen.push(nama);
                            else listTendik.push(nama);
                        });

                        const buildListHtml = (names, color) => {
                            if (!names.length) return '<div class="p-4 text-center text-muted italic">Tidak ada data</div>';
                            return names.map((n, i) => `
                                <div class="list-group-item d-flex justify-content-start align-items-center border-0 mb-1 rounded bg-white py-2 px-3">
                                    <div class="fw-bold text-secondary me-3" style="min-width: 20px;">${i + 1}.</div>
                                    <div class="text-dark fw-medium"><i class="fas fa-user-circle opacity-50 me-2 text-${color}"></i> ${n}</div>
                                </div>`).join('');
                        };

                        document.getElementById('cnt-pend-dosen').innerText = listDosen.length;
                        document.getElementById('cnt-pend-tendik').innerText = listTendik.length;
                        document.getElementById('list-pend-dosen').innerHTML = buildListHtml(listDosen, 'primary');
                        document.getElementById('list-pend-tendik').innerHTML = buildListHtml(listTendik, 'secondary');

                        if(typeof bootstrap !== 'undefined') {
                            const tabDosen = new bootstrap.Tab(document.getElementById('tab-dosen'));
                            tabDosen.show();
                        }

                        const myModal = new bootstrap.Modal(document.getElementById('modalPendidikanAuto'));
                        myModal.show();
                    }
                }
            }
        });
    }
    
    // =================================
    // ==== 3. BAR CHART JABATAN =======
    // =================================
    const jabatanCtx = document.getElementById("JabatanChart");
    if (jabatanCtx && jabatanLabels.length) {
        new Chart(jabatanCtx, {
            type: 'bar', plugins: typeof ChartDataLabels !== 'undefined' ? [ChartDataLabels] : [],
            data: { labels: jabatanLabels, datasets: [{ label: 'Laki-laki', data: lakiData, backgroundColor: '#3b82f6' }, { label: 'Perempuan', data: perempuanData, backgroundColor: '#ec4899' }] },
            options: {
                indexAxis: 'y', responsive: true, maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' }, datalabels: { anchor: 'end', align: 'right', color: '#5a5c69', font: { weight: 'bold', size: 11 }, formatter: v => v === 0 ? '' : v } },
                scales: { x: { beginAtZero: true, grace: '20%' } },
                onClick: (event, elements) => {
                    if (elements.length > 0) {
                        const labelJabatan = jabatanLabels[elements[0].index];
                        const detailData = dataJabatanGender[labelJabatan] || {};
                        document.getElementById('labelJabatanTerpilih').innerText = labelJabatan;

                        const build = (names) => (!names || names.length === 0) ? '<div class="p-4 text-center text-muted">Tidak ada data</div>' : names.map((n, i) => `<div class="list-group-item d-flex align-items-center border-0 mb-1 rounded py-2 px-3"><div class="fw-bold text-secondary me-3">${i+1}.</div><div class="text-dark fw-medium"><i class="fas fa-user-circle opacity-50 me-2 text-primary"></i>${n}</div></div>`).join('');
                        
                        const lakiList = detailData['Laki-laki'] || [];
                        const perempList = detailData['Perempuan'] || [];
                        document.getElementById('cnt-laki').innerText = lakiList.length;
                        document.getElementById('cnt-perempuan').innerText = perempList.length;
                        document.getElementById('list-laki').innerHTML = build(lakiList);
                        document.getElementById('list-perempuan').innerHTML = build(perempList);

                        new bootstrap.Modal(document.getElementById('modalJabatanAuto')).show();
                    }
                }
            }
        });
    }

    // =================================
    // ==== 4. BAR CHART PANGKAT =======
    // =================================
    const ctxPangkatGabungan = document.getElementById('pangkatGabunganChart');
    if (ctxPangkatGabungan) {
        const dosenLabels = getMeta("pangkat-dosen-labels"); const dosenValues = getMeta("pangkat-dosen-values");
        const tendikLabels = getMeta("pangkat-tendik-labels"); const tendikValues = getMeta("pangkat-tendik-values");
        const allLabels = [...new Set([...dosenLabels, ...tendikLabels])].sort();
        const mappedDosen = allLabels.map(l => dosenLabels.indexOf(l) !== -1 ? dosenValues[dosenLabels.indexOf(l)] : 0);
        const mappedTendik = allLabels.map(l => tendikLabels.indexOf(l) !== -1 ? tendikValues[tendikLabels.indexOf(l)] : 0);

        new Chart(ctxPangkatGabungan, {
            type: 'bar', plugins: typeof ChartDataLabels !== 'undefined' ? [ChartDataLabels] : [],
            data: { labels: allLabels, datasets: [{ label: 'Dosen', data: mappedDosen, backgroundColor: '#0d6efd', borderRadius: 4, maxBarThickness: 25 }, { label: 'Tendik', data: mappedTendik, backgroundColor: '#6c757d', borderRadius: 4, maxBarThickness: 25 }] },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { datalabels: { color: '#fff', font: { weight: 'bold', size: 10 }, formatter: v => v > 0 ? v : '' } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } }, x: { grid: { display: false } } },
                onClick: (event, elements) => {
                    if (elements.length > 0) {
                        const labelPangkat = allLabels[elements[0].index];
                        const listPegawai = dataPegawaiPangkat[labelPangkat] || [];
                        document.getElementById('labelPangkatTerpilih').innerText = labelPangkat;

                        let listDosen = [], listTendik = [];
                        listPegawai.forEach(p => { p.kategori === 'Dosen' ? listDosen.push(p.nama) : listTendik.push(p.nama); });

                        const build = (names) => names.length === 0 ? '<div class="p-3 text-center text-muted">Tidak ada data</div>' : names.map((n, i) => `<div class="list-group-item px-3 py-2 border-0 mb-1 bg-white rounded shadow-sm"><span class="fw-bold text-secondary me-2">${i+1}.</span><i class="fas fa-id-badge text-warning opacity-50 me-2"></i>${n}</div>`).join('');
                        
                        document.getElementById('cnt-pangkat-dosen').innerText = listDosen.length;
                        document.getElementById('cnt-pangkat-tendik').innerText = listTendik.length;
                        document.getElementById('list-pangkat-dosen').innerHTML = build(listDosen);
                        document.getElementById('list-pangkat-tendik').innerHTML = build(listTendik);

                        new bootstrap.Modal(document.getElementById('modalPangkatAuto')).show();
                    }
                }
            }
        });
    }

    // ============================================
    // ==== 5. DOUGHNUT UMUR DOSEN & TENDIK =======
    // ============================================
    const renderUmurModal = (labelUmur, kategori) => {
        document.getElementById('labelUmurTerpilih').innerText = labelUmur + ` (${kategori.toUpperCase()})`;
        
        let listPegawai = [];
        if (kategori === 'dosen') {
            listPegawai = dataUmurDosen[labelUmur] || [];
        } else {
            listPegawai = dataUmurTendik[labelUmur] || [];
        }

        const buildList = (arr) => arr.length === 0 ? '<div class="p-4 text-center text-muted">Tidak ada data di kategori ini</div>' : arr.map((p, i) => `
            <div class="list-group-item d-flex justify-content-between align-items-center px-3 py-2 border-0 mb-1 bg-white rounded shadow-sm">
                <div>
                    <span class="fw-bold text-secondary me-2" style="min-width: 20px; display: inline-block;">${i+1}.</span> 
                    <span class="fw-medium text-dark"><i class="fas fa-user-circle text-danger opacity-50 me-1"></i> ${p.nama}</span><br>
                    <small class="text-muted ms-4 pl-1"><i class="fas fa-calendar-alt"></i> Lahir: ${p.tgl_lahir}</small>
                </div>
                <span class="badge bg-light text-dark border">${p.umur} Thn</span>
            </div>`).join('');

        if (kategori === 'tendik') {
            let pns = [], non = [], thl = [];
            listPegawai.forEach(p => {
                if (p.sub_kategori === 'PNS') pns.push(p);
                else if (p.sub_kategori === 'THL') thl.push(p);
                else non.push(p);
            });

            document.getElementById('modalUmurBody').innerHTML = `
                <ul class="nav nav-tabs nav-justified bg-white" role="tablist">
                    <li class="nav-item"><button class="nav-link active fw-bold text-primary py-3 border-0" data-bs-toggle="tab" data-bs-target="#u-pns">PNS (${pns.length})</button></li>
                    <li class="nav-item"><button class="nav-link fw-bold text-warning py-3 border-0" data-bs-toggle="tab" data-bs-target="#u-non">Non PNS (${non.length})</button></li>
                    <li class="nav-item"><button class="nav-link fw-bold text-secondary py-3 border-0" data-bs-toggle="tab" data-bs-target="#u-thl">THL (${thl.length})</button></li>
                </ul>
                <div class="tab-content p-3 bg-light">
                    <div class="tab-pane fade show active" id="u-pns"><div class="list-group shadow-sm">${buildList(pns)}</div></div>
                    <div class="tab-pane fade" id="u-non"><div class="list-group shadow-sm">${buildList(non)}</div></div>
                    <div class="tab-pane fade" id="u-thl"><div class="list-group shadow-sm">${buildList(thl)}</div></div>
                </div>
            `;
        } else {
            document.getElementById('modalUmurBody').innerHTML = `<div class="p-3"><div class="list-group shadow-sm">${buildList(listPegawai)}</div></div>`;
        }

        new bootstrap.Modal(document.getElementById('modalUmurAuto')).show();
    };

    // Chart Umur Dosen
    const ctxAgeDosen = document.getElementById('ageDosenChart');
    if (ctxAgeDosen) {
        const labels = getMeta("umur-dosen-labels"); const values = getMeta("umur-dosen-values");
        new Chart(ctxAgeDosen, {
            type: 'doughnut', plugins: typeof ChartDataLabels !== 'undefined' ? [ChartDataLabels] : [],
            data: { labels: labels, datasets: [{ data: values, backgroundColor: ['#1cc88a','#36b9cc','#f6c23e','#fd7e14','#e74a3b'], borderWidth: 2, borderColor: '#fff' }] },
            options: {
                responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'right' }, datalabels: { color: '#fff', font: { weight: 'bold', size: 11 }, formatter: v => v > 0 ? v + " Org" : '' } },
                onClick: (e, el) => { if (el.length > 0) renderUmurModal(labels[el[0].index], 'dosen'); }
            }
        });
    }

    // Chart Umur Tendik
    const ctxAgeTendik = document.getElementById('ageTendikChart');
    if (ctxAgeTendik) {
        const labels = getMeta("umur-tendik-labels"); const values = getMeta("umur-tendik-values");
        new Chart(ctxAgeTendik, {
            type: 'doughnut', plugins: typeof ChartDataLabels !== 'undefined' ? [ChartDataLabels] : [],
            data: { labels: labels, datasets: [{ data: values, backgroundColor: ['#4e73df','#1cc88a','#36b9cc','#f6c23e','#fd7e14','#e74a3b'], borderWidth: 2, borderColor: '#fff' }] },
            options: {
                responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'right' }, datalabels: { color: '#fff', font: { weight: 'bold', size: 11 }, formatter: v => v > 0 ? v + " Org" : '' } },
                onClick: (e, el) => { if (el.length > 0) renderUmurModal(labels[el[0].index], 'tendik'); }
            }
        });
    }

    // ========================================================
    // ==== OBAT ANTI HANCUR SAAT KLIK HAMBURGER MENU =========
    // ========================================================
    const mainWrapper = document.querySelector('.main-wrapper') || document.querySelector('.layout');
    if (mainWrapper) {
        // Deteksi jika animasi buka-tutup sidebar selesai
        mainWrapper.addEventListener('transitionend', function(e) {
            if (e.propertyName === 'width' || e.propertyName === 'margin-left' || e.propertyName === 'padding-left') {
                // Paksa grafik untuk menggambar ulang mengikuti lebar baru
                window.dispatchEvent(new Event('resize'));
            }
        });
    }

    // Backup: Jika elemen hamburger bisa diklik, paksa resize dalam 300ms
    document.addEventListener('click', function(e) {
        if (e.target.closest('.hamburger') || e.target.closest('.lni-menu') || e.target.closest('.toggle-btn')) {
            setTimeout(() => window.dispatchEvent(new Event('resize')), 300);
            setTimeout(() => window.dispatchEvent(new Event('resize')), 400); // Trigger ganda untuk jaga-jaga
        }
    });

});