// === Inisialisasi Setelah Halaman Dimuat ===
document.addEventListener('DOMContentLoaded', function () {
    initSidebar();
    startClock();
    initKerjasamaPage();
});

// === Logika Sidebar (Tidak Berubah) ===
function initSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const toggleSidebarBtn = document.getElementById('toggleSidebar');
    toggleSidebarBtn?.addEventListener('click', function () {
        const isMobile = window.innerWidth <= 991;
        sidebar?.classList.toggle(isMobile ? 'show' : 'hidden');
        overlay?.classList.toggle('show', isMobile && sidebar?.classList.contains('show'));
    });
    overlay?.addEventListener('click', function () {
        sidebar?.classList.remove('show');
        overlay?.classList.remove('show');
    });
}

// === Logika Waktu (Tidak Berubah) ===
function startClock() {
    const dateEl = document.getElementById('current-date');
    const timeEl = document.getElementById('current-time');
    function updateTime() {
        if (!dateEl || !timeEl) return;
        const now = new Date();
        const dateOpts = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', timeZone: 'Asia/Jakarta' };
        const timeOpts = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false, timeZone: 'Asia/Jakarta' };
        dateEl.textContent = now.toLocaleDateString('id-ID', dateOpts);
        timeEl.textContent = now.toLocaleTimeString('id-ID', timeOpts).replace(/\./g, ':');
    }
    updateTime();
    setInterval(updateTime, 1000);
}

// === Data & Logika Halaman Kerjasama ===
const kerjasamaData = [
    { id: 'mou001', judul: 'Pengembangan Model Hutan Tanaman Cerdas Iklim', mitra: 'Dinas Kehutanan Provinsi Jawa Barat', noDoc: 'MoU/001/AI/24', tglDoc: '2024-04-10', tmt: '2024-05-01', tst: '2025-05-01', departemen: 'Manajemen Hutan', ketua: 'Dr. Anton Jaya Puspita', anggota: ['Dr. Budi Santoso', 'Ir. Rina Melati, M.Sc.'], lokasi: 'Bogor', dana: 150000000, jenis: 'MoU', dokumen_path: 'assets/pdf/example.pdf' },
    { id: 'loa015', judul: 'Analisis Keanekaragaman Hayati di Cagar Alam', mitra: 'Balai Konservasi Sumber Daya Alam (BKSDA)', noDoc: 'LoA/015/BIO/24', tglDoc: '2024-02-20', tmt: '2024-03-01', tst: '2024-09-01', departemen: 'Konservasi Sumberdaya Hutan', ketua: 'Prof. Dr. Endang Sulistyawati', anggota: ['Ahmad Zulkifli, S.Hut.'], lokasi: 'Gunung Gede Pangrango', dana: 75000000, jenis: 'LoA', dokumen_path: 'assets/pdf/example.pdf' },
    { id: 'spk032', judul: 'Pemanfaatan Limbah Kayu untuk Produk Bernilai Tambah', mitra: 'PT. Kayu Sejahtera', noDoc: 'SPK/032/IND/24', tglDoc: '2024-06-05', tmt: '2024-06-10', tst: '2024-12-10', departemen: 'Teknologi Hasil Hutan', ketua: 'Ir. Heru Purnomo, M.T.', anggota: ['Siti Nurbaya, S.T.', 'Joko Widodo, S.T.'], lokasi: 'Jepara', dana: 250000000, jenis: 'SPK', dokumen_path: 'assets/pdf/example.pdf' }
];

function initKerjasamaPage() {
    renderKerjasamaTable();
    setupUploadArea(); // Inisialisasi fungsi upload
    
    const kerjasamaModalEl = document.getElementById('kerjasamaModal');
    const tableBody = document.getElementById('kerjasamaTableBody');

    // Logika untuk Modal Tambah/Edit menggunakan event Bootstrap
    if (kerjasamaModalEl) {
        kerjasamaModalEl.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const modalTitle = kerjasamaModalEl.querySelector('.modal-title');
            const form = kerjasamaModalEl.querySelector('form');
            
            if (button && button.classList.contains('btn-edit-row')) {
                const itemId = button.dataset.id;
                const itemData = kerjasamaData.find(item => item.id === itemId);
                if (!itemData) return;

                modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Kerjasama';
                form.reset();
                for (const key in itemData) {
                    if (key !== 'anggota') {
                        const input = form.querySelector(`[name="${key}"]`);
                        if (input) input.value = itemData[key];
                    }
                }
                setupAnggotaList(itemData.anggota || []);
            } else {
                modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Kerjasama';
                form.reset();
                setupAnggotaList([]);
            }
            kerjasamaModalEl.querySelector('.upload-area')?.reset();
        });
    }

    // Event Delegation untuk semua aksi di dalam tabel (Lihat Detail, Hapus)
    if (tableBody) {
        tableBody.addEventListener('click', function(e) {
            const targetButton = e.target.closest('button.btn-aksi');
            if (!targetButton) return;

            const itemId = targetButton.dataset.id;
            const itemData = kerjasamaData.find(item => item.id === itemId);
            if (!itemData) return;

            // Logika untuk Tombol LIHAT DETAIL (Versi yang diperbaiki)
            if (targetButton.classList.contains('btn-lihat-detail')) {
                // Mengambil data dari atribut data-* tombol
                const data = targetButton.dataset;

                // Fungsi helper untuk mengisi teks dengan aman
                const setText = (id, value) => {
                    const element = document.getElementById(id);
                    if (element) {
                        element.textContent = value || '-';
                    }
                };
                
                // Memanggil elemen berdasarkan ID yang BENAR dari HTML Modal Detail
                setText('detail_kerjasama_judul', data.judul);
                setText('detail_kerjasama_mitra', data.mitra);
                setText('detail_kerjasama_no_dokumen', data.nodoc);
                setText('detail_kerjasama_tgl_dokumen', data.tgldoc);
                setText('detail_kerjasama_tmt', data.tmt);
                setText('detail_kerjasama_tst', data.tst);
                setText('detail_kerjasama_departemen', data.departemen);
                const ketuaEl = document.getElementById('detail_ketua');
                if (ketuaEl) ketuaEl.textContent = itemData.ketua || '-';

                const anggotaListEl = document.getElementById('detail_anggota_list');
                if (anggotaListEl) {
                    anggotaListEl.innerHTML = '';
                    if (itemData.anggota && itemData.anggota.length > 0) {
                        itemData.anggota.forEach(anggota => {
                            const li = document.createElement('li');
                            li.textContent = anggota;
                            anggotaListEl.appendChild(li);
                        });
                    } else {
                        anggotaListEl.innerHTML = '<li>-</li>';
                    }
                }
                setText('detail_kerjasama_lokasi', data.lokasi);
                setText('detail_kerjasama_dana', data.dana);
                setText('detail_kerjasama_jenis', data.jenis);
                
                const docViewer = document.getElementById('detail_kerjasama_document_viewer');
                if(docViewer) {
                    docViewer.setAttribute('src', data.dokumen_path || '');
                }
            }
            
            // Logika untuk Tombol HAPUS
            if (targetButton.classList.contains('btn-delete-row')) {
                if (confirm(`Apakah Anda yakin ingin menghapus "${itemData.judul}"?`)) {
                    targetButton.closest('tr').remove();
                    console.log('Menghapus item ID:', itemId);
                }
            }
        });
    }

    // Logika untuk Tambah/Hapus Anggota di dalam form modal
    const anggotaListContainer = document.getElementById('anggota-list');
    if (anggotaListContainer) {
        anggotaListContainer.addEventListener('click', function(e) {
            const addButton = e.target.closest('.btn-add-anggota');
            const removeButton = e.target.closest('.btn-remove-anggota');

            if (addButton) {
                const row = addButton.parentElement;
                const input = row.querySelector('input');
                if (input.value.trim() === '') {
                    input.focus();
                    return;
                }
                addButton.outerHTML = '<button class="btn btn-outline-danger btn-remove-anggota" type="button">-</button>';
                anggotaListContainer.insertAdjacentHTML('beforeend', getAnggotaRowHTML('', true));
                anggotaListContainer.lastElementChild.querySelector('input').focus();
            }
            
            if (removeButton) {
                removeButton.parentElement.remove();
            }
        });
    }
}

function renderKerjasamaTable() {
    const tableBody = document.getElementById('kerjasamaTableBody');
    if (!tableBody) return;

    tableBody.innerHTML = kerjasamaData.map((item, index) => {
        const timDetail = `Ketua: ${item.ketua}\nAnggota:\n${item.anggota.map((a, i) => `${i + 1}. ${a}`).join('\n')}`;
        const danaFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.dana);

        return `
        <tr>
            <td class="text-center">${index + 1}</td>
            <td class="text-start" style="min-width: 250px;">${item.judul}</td>
            <td class="text-start" style="min-width: 200px;">${item.mitra}</td>
            <td class="text-center">${item.noDoc}</td>
            <td class="text-center">${new Date(item.tglDoc).toLocaleDateString('id-ID', {day: '2-digit', month: 'short', year: 'numeric'})}</td>
            <td class="text-start" style="min-width: 200px;"><b>Ketua:</b> ${item.ketua}<br><b>Anggota:</b> ${item.anggota.join(', ')}</td>
            <td class="text-center">${item.lokasi}</td>
            <td class="text-end">${danaFormatted}</td>
            <td class="text-center"><span class="badge text-bg-light border">${item.jenis}</span></td>
            <td class="text-center"><a href="${item.dokumen_path || '#'}" target="_blank" class="btn btn-sm btn-info text-white">Lihat</a></td>
            <td class="text-center">
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-aksi btn-lihat-detail" 
                        data-id="${item.id}" 
                        title="Lihat Detail" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalDetailKerjasama"
                        data-judul="${item.judul}"
                        data-mitra="${item.mitra}"
                        data-nodoc="${item.noDoc}"
                        data-tgldoc="${item.tglDoc}"
                        data-tmt="${item.tmt}"
                        data-tst="${item.tst}"
                        data-departemen="${item.departemen}"
                        data-tim="${timDetail}"
                        data-lokasi="${item.lokasi}"
                        data-dana="${danaFormatted}"
                        data-jenis="${item.jenis}"
                        data-dokumen_path="${item.dokumen_path || ''}">
                        <i class="fa fa-eye"></i>
                    </button>
                    <button class="btn btn-aksi btn-edit-row" data-id="${item.id}" title="Edit" data-bs-toggle="modal" data-bs-target="#kerjasamaModal"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-aksi btn-delete-row" data-id="${item.id}" title="Hapus"><i class="fa fa-trash"></i></button>
                </div>
            </td>
        </tr>
        `;
    }).join('');
}

// === Logika Helper: List Anggota & Upload Area ===
function setupAnggotaList(members = []) {
    const listContainer = document.getElementById('anggota-list');
    if (!listContainer) return;
    listContainer.innerHTML = ''; 
    members.forEach(member => {
        listContainer.insertAdjacentHTML('beforeend', getAnggotaRowHTML(member, false));
    });
    listContainer.insertAdjacentHTML('beforeend', getAnggotaRowHTML('', true));
}

function getAnggotaRowHTML(name = '', isAdder = false) {
    return `
        <div class="input-group mb-2">
            <input type="text" class="form-control" placeholder="Nama Anggota" value="${name}">
            ${isAdder 
                ? '<button class="btn btn-outline-success btn-add-anggota" type="button">+</button>' 
                : '<button class="btn btn-outline-danger btn-remove-anggota" type="button">-</button>'}
        </div>
    `;
}

function setupUploadArea() {
    document.querySelectorAll('.upload-area').forEach(uploadArea => {
        const fileInput = uploadArea.querySelector('input[type="file"]');
        const uploadText = uploadArea.querySelector('p');
        if (!fileInput || !uploadText) return;
        const originalText = uploadText.innerHTML;
        uploadArea.addEventListener('click', () => fileInput.click());
        fileInput.addEventListener('change', function () {
            if (this.files.length > 0) {
                uploadText.textContent = this.files[0].name;
            } else {
                uploadText.innerHTML = originalText;
            }
        });
        uploadArea.reset = function() {
            uploadText.innerHTML = originalText;
            fileInput.value = '';
        };
    });
}