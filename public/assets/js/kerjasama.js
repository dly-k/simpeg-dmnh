// === Inisialisasi Setelah Halaman Dimuat ===
document.addEventListener('DOMContentLoaded', function() {
    // 1. Logika Inti: Modal Berhasil (Success Modal)
    const modalBerhasil = document.getElementById('modalBerhasil');
    const berhasilTitle = document.getElementById('berhasil-title');
    const berhasilSubtitle = document.getElementById('berhasil-subtitle');
    let successModalTimeout = null;

    function showSuccessModal(title, subtitle) {
        if (modalBerhasil && berhasilTitle && berhasilSubtitle) {
            berhasilTitle.textContent = title;
            berhasilSubtitle.textContent = subtitle;
            modalBerhasil.classList.add('show');
            clearTimeout(successModalTimeout);
            successModalTimeout = setTimeout(hideSuccessModal, 1200);
        }
    }
    
    function hideSuccessModal() {
        modalBerhasil?.classList.remove('show');
    }

    document.getElementById('btnSelesai')?.addEventListener('click', () => {
        clearTimeout(successModalTimeout);
        hideSuccessModal();
    });

    // 2. Inisialisasi fungsi-fungsi utama halaman
    initSidebar();
    startClock();
    initKerjasamaPage(showSuccessModal); 
    initDeleteModal(showSuccessModal); // Pastikan `showSuccessModal` diteruskan ke fungsi ini
});

// === Logika Sidebar (Tidak Berubah) ===
function initSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const toggleSidebarBtn = document.getElementById('toggleSidebar');

    if (toggleSidebarBtn && sidebar && overlay) {
        toggleSidebarBtn.addEventListener('click', function() {
            const isMobile = window.innerWidth <= 991;
            if (isMobile) {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show', sidebar.classList.contains('show'));
            } else {
                sidebar.classList.toggle('hidden');
            }
        });
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    }
}

// === Logika Jam & Tanggal (Tidak Berubah) ===
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
    { id: 'mou002', judul: 'Pengembangan Teknologi Irigasi Hemat Air', mitra: 'Balai Besar Pengembangan Irigasi Nasional', noDoc: 'MoU/002/TI/24', tglDoc: '2024-06-12', tmt: '2024-07-01', tst: '2025-07-01', departemen: 'Teknik Pertanian', ketua: 'Prof. Sri Wahyuni', anggota: ['Dr. Adi Nugroho', 'Ir. Ratna Dewi, M.Eng.'], lokasi: 'Yogyakarta', dana: 200000000, jenis: 'MoU', dokumen_path: 'assets/pdf/irigasi.pdf' },
    { id: 'mou003', judul: 'Riset Inovasi Pupuk Organik Berbasis Limbah Pertanian', mitra: 'PT Pupuk Nusantara', noDoc: 'MoU/003/PO/24', tglDoc: '2024-03-20', tmt: '2024-04-01', tst: '2025-04-01', departemen: 'Agroteknologi', ketua: 'Dr. Hendri Kusuma', anggota: ['Ir. Lestari Anggraeni, M.Sc.', 'Dr. Surya Wijaya'], lokasi: 'Surabaya', dana: 175000000, jenis: 'MoU', dokumen_path: 'assets/pdf/pupuk.pdf' }
];

function initKerjasamaPage(showSuccessModal) {
    renderKerjasamaTable();
    setupUploadArea();
    
    const kerjasamaModalEl = document.getElementById('kerjasamaModal');
    const tableBody = document.getElementById('kerjasamaTableBody');
    if (!kerjasamaModalEl) return;
    const bsModal = new bootstrap.Modal(kerjasamaModalEl);

    // Logika untuk Modal Tambah/Edit
    kerjasamaModalEl.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const modalTitle = kerjasamaModalEl.querySelector('.modal-title');
        const form = kerjasamaModalEl.querySelector('form');
        if (button && button.classList.contains('btn-edit-row')) {
            const itemId = button.dataset.id;
            const itemData = kerjasamaData.find(item => item.id === itemId);
            if (itemData) {
                modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Kerjasama';
                form.reset();
                for (const key in itemData) {
                    if (key !== 'anggota') {
                        const input = form.querySelector(`[name="${key}"]`);
                        if (input) input.value = itemData[key];
                    }
                }
                setupAnggotaList(itemData.anggota || []);
            }
        } else {
            modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Kerjasama';
            form.reset();
            setupAnggotaList([]);
        }
    });

    // Logika untuk tombol Simpan
    const saveButton = kerjasamaModalEl.querySelector('.btn-success');
    if (saveButton) {
        saveButton.addEventListener('click', function() {
            bsModal.hide();
            showSuccessModal('Data Berhasil Disimpan', 'Data kerjasama telah berhasil disimpan.');
        });
    }

    // Event Delegation untuk tabel
    if (tableBody) {
        tableBody.addEventListener('click', function(e) {
             const targetButton = e.target.closest('button.btn-aksi');
            if (!targetButton) return;
            const itemId = targetButton.dataset.id;
            const itemData = kerjasamaData.find(item => item.id === itemId);
            if (!itemData) return;
            if (targetButton.classList.contains('btn-lihat-detail')) fillDetailModal(itemData);
            if (targetButton.classList.contains('btn-delete-row')) {
                e.preventDefault();
                window.showDeleteModal(itemData, targetButton.closest('tr'));
            }
        });
    }

    // Logika Tambah/Hapus Anggota
    const anggotaListContainer = document.getElementById('anggota-list');
    if (anggotaListContainer) {
        anggotaListContainer.addEventListener('click', function(e) {
            if (e.target.closest('.btn-add-anggota')) addAnggotaRow(e.target.closest('.btn-add-anggota'));
            if (e.target.closest('.btn-remove-anggota')) e.target.closest('.btn-remove-anggota').parentElement.remove();
        });
    }
}

// ==========================================================
// === FUNGSI INI YANG DIPERBAIKI SECARA SPESIFIK ===
// ==========================================================
function initDeleteModal(showSuccessModal) { 
    const modal = document.getElementById('modalKonfirmasiHapus');
    const btnKonfirmasi = document.getElementById('btnKonfirmasiHapus');
    const btnBatal = document.getElementById('btnBatalHapus');
    let currentItemToDelete = null;
    let currentRowElement = null;

    // Menjadikan fungsi global agar bisa dipanggil dari listener lain
    window.showDeleteModal = function(itemData, rowElement) {
        currentItemToDelete = itemData;
        currentRowElement = rowElement;
        if (modal) {
            modal.style.display = 'flex';
            requestAnimationFrame(() => modal.classList.add('show'));
            document.body.style.overflow = 'hidden';
        }
    };

    function hideDeleteModal() {
        if (modal) {
            modal.classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }, 300);
        }
        currentItemToDelete = null;
        currentRowElement = null;
    }

    if (btnKonfirmasi) {
        // INI BAGIAN UTAMA PERBAIKANNYA
        btnKonfirmasi.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            if (currentItemToDelete && currentRowElement) {
                // 1. Lakukan aksi (contoh: hapus baris dari tabel)
                currentRowElement.remove();
                // 2. Tutup modal konfirmasi
                hideDeleteModal();
                // 3. Panggil modal berhasil yang sudah kita siapkan
                showSuccessModal('Data Berhasil Dihapus', `Data kerjasama telah berhasil dihapus.`);
            }
        });
    }

    // Listener lainnya (tidak berubah)
    if (btnBatal) btnBatal.addEventListener('click', hideDeleteModal);
    if (modal) modal.addEventListener('click', (e) => { if (e.target === modal) hideDeleteModal(); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && modal?.classList.contains('show')) hideDeleteModal(); });
}

// === Fungsi Helper (Tidak Ada Perubahan) ===
function renderKerjasamaTable() {
    const tableBody = document.getElementById('kerjasamaTableBody');
    if (!tableBody) return;
    tableBody.innerHTML = kerjasamaData.map((item, index) => {
        const danaFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.dana);
        return `
        <tr>
            <td class="text-center">${index + 1}</td>
            <td class="text-start" style="min-width: 250px;">${item.judul}</td>
            <td class="text-start">${item.mitra}</td>
            <td class="text-center">${item.noDoc}</td>
            <td class="text-center">${formatDate(item.tglDoc)}</td>
            <td class="text-start"><b>Ketua:</b> ${item.ketua}<br><b>Anggota:</b> ${item.anggota.join(', ')}</td>
            <td class="text-center">${item.lokasi}</td>
            <td class="text-end">${danaFormatted}</td>
            <td class="text-center"><span class="badge text-bg-light border">${item.jenis}</span></td>
            <td class="text-center"><a href="${item.dokumen_path || '#'}" target="_blank" class="btn btn-sm btn-info text-white">Lihat</a></td>
            <td class="text-center">
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-aksi btn-lihat-detail" data-id="${item.id}" data-bs-toggle="modal" data-bs-target="#modalDetailKerjasama"><i class="fa fa-eye"></i></button>
                    <button class="btn btn-aksi btn-edit-row" data-id="${item.id}" data-bs-toggle="modal" data-bs-target="#kerjasamaModal"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-aksi btn-delete-row" data-id="${item.id}"><i class="fa fa-trash"></i></button>
                </div>
            </td>
        </tr>`;
    }).join('');
}
function fillDetailModal(itemData) {
    const setText = (id, value) => document.getElementById(id) ? document.getElementById(id).textContent = value || '-' : null;
    const danaFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(itemData.dana);
    setText('detail_kerjasama_judul', itemData.judul);
    setText('detail_kerjasama_mitra', itemData.mitra);
    setText('detail_kerjasama_no_dokumen', itemData.noDoc);
    setText('detail_kerjasama_tgl_dokumen', formatDate(itemData.tglDoc));
    setText('detail_kerjasama_tmt', formatDate(itemData.tmt));
    setText('detail_kerjasama_tst', formatDate(itemData.tst));
    setText('detail_kerjasama_departemen', itemData.departemen);
    setText('detail_ketua', itemData.ketua);
    const anggotaListEl = document.getElementById('detail_anggota_list');
    if (anggotaListEl) {
        anggotaListEl.innerHTML = itemData.anggota?.length > 0 ? itemData.anggota.map(a => `<li>${a}</li>`).join('') : '<li>-</li>';
    }
    setText('detail_kerjasama_lokasi', itemData.lokasi);
    setText('detail_kerjasama_dana', danaFormatted);
    setText('detail_kerjasama_jenis', itemData.jenis);
    document.getElementById('detail_kerjasama_document_viewer')?.setAttribute('src', itemData.dokumen_path || '');
}
function setupAnggotaList(members = []) {
    const listContainer = document.getElementById('anggota-list');
    if (!listContainer) return;
    listContainer.innerHTML = '';
    members.forEach(member => listContainer.appendChild(createAnggotaRow(member, false)));
    listContainer.appendChild(createAnggotaRow('', true));
}
function createAnggotaRow(name = '', isAdder = false) {
    const row = document.createElement('div');
    row.className = 'input-group mb-2';
    row.innerHTML = `<input type="text" class="form-control" placeholder="Nama Anggota" value="${name}"><button class="btn ${isAdder ? 'btn-outline-success btn-add-anggota' : 'btn-outline-danger btn-remove-anggota'}" type="button">${isAdder ? '+' : '-'}</button>`;
    return row;
}
function addAnggotaRow(addButton) {
    const row = addButton.parentElement;
    const input = row.querySelector('input');
    if (input.value.trim() === '') {
        input.focus();
        return;
    }
    addButton.outerHTML = '<button class="btn btn-outline-danger btn-remove-anggota" type="button">-</button>';
    const listContainer = document.getElementById('anggota-list');
    if (listContainer) {
        listContainer.appendChild(createAnggotaRow('', true));
        listContainer.lastElementChild.querySelector('input').focus();
    }
}
function setupUploadArea() {
    document.querySelectorAll('.upload-area').forEach(uploadArea => {
        const fileInput = uploadArea.querySelector('input[type="file"]');
        const uploadText = uploadArea.querySelector('p');
        if (!fileInput || !uploadText) return;
        const originalText = uploadText.innerHTML;
        uploadArea.addEventListener('click', () => fileInput.click());
        fileInput.addEventListener('change', function() { uploadText.textContent = this.files.length > 0 ? this.files[0].name : originalText; });
        uploadArea.reset = () => { uploadText.innerHTML = originalText; fileInput.value = ''; };
    });
}
function formatDate(dateString) {
    if (!dateString) return '-';
    return new Date(dateString).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
}