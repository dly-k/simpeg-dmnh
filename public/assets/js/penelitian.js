// === Inisialisasi Setelah Halaman Dimuat ===
document.addEventListener('DOMContentLoaded', function () {
    initSidebar();
    startClock();
    initPenelitianPage(); // Panggil fungsi utama untuk halaman penelitian
});

// === Logika Sidebar ===
function initSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const toggleSidebarBtn = document.getElementById('toggleSidebar');

    if (!sidebar || !overlay || !toggleSidebarBtn) return;

    toggleSidebarBtn.addEventListener('click', function () {
        const isMobile = window.innerWidth <= 991;
        if (isMobile) {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show', sidebar.classList.contains('show'));
        } else {
            sidebar.classList.toggle('hidden');
        }
    });

    overlay.addEventListener('click', function () {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
    });
}

// === Logika Waktu ===
function startClock() {
    const dateEl = document.getElementById('current-date');
    const timeEl = document.getElementById('current-time');

    if (!dateEl || !timeEl) return;

    function update() {
        const now = new Date();
        const dateOptions = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        const timeOptions = {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        };

        dateEl.textContent = now.toLocaleDateString('id-ID', dateOptions);
        timeEl.textContent = now.toLocaleTimeString('id-ID', timeOptions);
    }

    update();
    setInterval(update, 1000);
}

// =======================================================
// ===     FUNGSI UTAMA UNTUK SEMUA AKSI HALAMAN PENELITIAN     ===
// =======================================================
function initPenelitianPage() {
    // --- LOGIKA UNTUK MODAL BERHASIL (AUTO-HIDE) ---
    const modalBerhasil = document.getElementById('modalBerhasil');
    const berhasilTitle = document.getElementById('berhasil-title');
    const berhasilSubtitle = document.getElementById('berhasil-subtitle');
    let timeoutId = null;
    let successAudio = null; // Variabel untuk menyimpan instance audio

    const hideModalBerhasil = () => {
        modalBerhasil?.classList.remove('show');
        if (successAudio) {
            successAudio.pause(); // Hentikan audio
            successAudio.currentTime = 0; // Reset audio ke awal
        }
    };

    const showModalBerhasil = (title, subtitle) => {
        if (modalBerhasil && berhasilTitle && berhasilSubtitle) {
            berhasilTitle.textContent = title;
            berhasilSubtitle.textContent = subtitle;
            modalBerhasil.classList.add('show');
            clearTimeout(timeoutId);
            // Putar musik berhasil
            successAudio = new Audio('/assets/sounds/success.mp3'); // Pastikan path file audio benar
            successAudio.play().catch(error => {
                console.log('Error memutar suara:', error);
                if (error.name === 'NotAllowedError') {
                    console.log('Autoplay diblokir oleh browser. Butuh interaksi pengguna terlebih dahulu.');
                } else if (error.name === 'NotFoundError') {
                    console.log('File audio tidak ditemukan. Periksa path: /assets/sounds/success.mp3');
                }
            });
            timeoutId = setTimeout(hideModalBerhasil, 1000);
        }
    };
    modalBerhasil?.querySelector('#btnSelesai')?.addEventListener('click', () => {
        clearTimeout(timeoutId);
        hideModalBerhasil();
    });

    // --- Inisialisasi semua logika spesifik halaman ---
    setupUploadArea();
    setupSaveLogic(showModalBerhasil);
    setupDeleteModalLogic(showModalBerhasil);
    setupVerificationModalLogic(showModalBerhasil);

    // --- Logika untuk Modal Detail ---
    const detailModal = document.getElementById("detailModal");
    const closeModalBtn = document.getElementById("tutupBtn");
    const tableBody = document.querySelector('.table tbody');

    tableBody?.addEventListener('click', function (event) {
        const openModalBtn = event.target.closest('#btnLihatDetail');
        if (openModalBtn) {
            detailModal.style.display = "block";
        }
    });
    closeModalBtn?.addEventListener('click', () => detailModal.style.display = "none");
    window.addEventListener('click', (event) => {
        if (event.target == detailModal) {
            detailModal.style.display = "none";
        }
    });

    // --- LOGIKA MENUTUP MODAL TAMBAH/EDIT SAAT KLIK DI LUAR ---
    const penelitianModal = document.getElementById('penelitianModal');
    penelitianModal?.addEventListener('click', function (event) {
        if (event.target === penelitianModal) {
            closeModal('penelitianModal');
        }
    });
}

// === Logika Modal Konfirmasi Verifikasi ===
function setupVerificationModalLogic(showSuccessModalCallback) {
    const modalKonfirmasi = document.getElementById('modalKonfirmasiVerifikasi');
    const tableBody = document.querySelector('.table tbody');
    const btnTerima = document.getElementById('popupBtnTerima');
    const btnTolak = document.getElementById('popupBtnTolak');
    const btnKembali = document.getElementById('popupBtnKembali');
    let dataIdUntukAksi = null;

    const showModal = () => modalKonfirmasi?.classList.add('show');
    const hideModal = () => modalKonfirmasi?.classList.remove('show');

    // Listener untuk membuka modal konfirmasi
    tableBody?.addEventListener('click', function (event) {
        const verifikasiButton = event.target.closest('.btn-verifikasi');
        if (verifikasiButton) {
            event.preventDefault();
            dataIdUntukAksi = verifikasiButton.dataset.id;
            showModal();
        }
    });

    // Fungsi yang akan dijalankan untuk tombol Terima dan Tolak
    const handleVerifikasi = (action) => {
        console.log(`Aksi "${action}" untuk ID: ${dataIdUntukAksi}`);
        hideModal(); // Tutup modal konfirmasi
        showSuccessModalCallback('Status Verifikasi Disimpan', 'Perubahan status verifikasi telah berhasil disimpan.');
    };

    // Listener untuk tombol "Terima"
    btnTerima?.addEventListener('click', () => handleVerifikasi('Diterima'));

    // Listener untuk tombol "Tolak"
    btnTolak?.addEventListener('click', () => handleVerifikasi('Ditolak'));

    // Listener untuk tombol "Kembali" dan klik di luar area
    btnKembali?.addEventListener('click', hideModal);
    modalKonfirmasi?.addEventListener('click', function (event) {
        if (event.target === modalKonfirmasi) {
            hideModal();
        }
    });
}

// === Logika Tombol Simpan (Add/Edit) ===
function setupSaveLogic(showSuccessModalCallback) {
    const penelitianModal = document.getElementById('penelitianModal');
    const saveButton = penelitianModal?.querySelector('.btn-success');

    saveButton?.addEventListener('click', function () {
        closeModal('penelitianModal');
        showSuccessModalCallback('Data Berhasil Disimpan', 'Perubahan Anda telah sukses disimpan ke dalam sistem.');
    });
}

// === Logika Upload File ===
function setupUploadArea() {
    const uploadArea = document.querySelector('.upload-area');
    if (!uploadArea) return;

    const fileInput = uploadArea.querySelector('input[type="file"]');
    const uploadText = uploadArea.querySelector('p');
    const originalText = uploadText.innerHTML;

    uploadArea.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', function () {
        if (this.files.length > 0) {
            uploadText.textContent = this.files[0].name;
        }
    });

    uploadArea.resetText = () => {
        uploadText.innerHTML = originalText;
    };
}

// === Logika Modal Tambah/Edit ===
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;

    const modalTitle = modal.querySelector('#modalTitle');
    const form = modal.querySelector('form');

    if (modalTitle) modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Penelitian';
    if (form) form.reset();

    const uploadArea = modal.querySelector('.upload-area');
    if (uploadArea && typeof uploadArea.resetText === 'function') uploadArea.resetText();

    resetPenulisFields();
    modal.classList.add('show');
}

function openEditModal() {
    const modal = document.getElementById('penelitianModal');
    if (!modal) return;

    const modalTitle = modal.querySelector('#modalTitle');
    if (modalTitle) modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Penelitian';

    modal.classList.add('show');
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) modal.classList.remove('show');
}

// === Reset Field Penulis ===
function resetPenulisFields() {
    document.getElementById('penulis-ipb-list').innerHTML = createDefaultPenulisInput('penulis-ipb-list');
    document.getElementById('penulis-luar-list').innerHTML = createDefaultPenulisInput('penulis-luar-list');
    document.getElementById('penulis-mahasiswa-list').innerHTML = createDefaultPenulisInput('penulis-mahasiswa-list');
}

// === Template Default Field ===
function createDefaultPenulisInput(listId) {
    if (listId === 'penulis-mahasiswa-list') {
        return `
        <div class="input-group mb-2">
            <input type="text" class="form-control" placeholder="Nama">
            <button class="btn btn-outline-success" type="button" onclick="addPenulis('${listId}')">+ Tambah</button>
        </div>`;
    }

    return `
    <div class="input-group mb-2">
        <input type="text" class="form-control" placeholder="Nama">
        <label class="input-group-text">Upload SK</label>
        <input type="file" class="form-control">
        <button class="btn btn-outline-success" type="button" onclick="addPenulis('${listId}')">+ Tambah</button>
    </div>`;
}

// === Logika Penulis Dinamis ===
let penulisCounter = 0;

function addPenulis(listId) {
    penulisCounter++;
    const list = document.getElementById(listId);
    if (!list) return;

    const newInput = document.createElement('div');
    newInput.className = 'input-group mb-2';

    let inputFields = `<input type="text" class="form-control" placeholder="Nama">`;

    if (listId !== 'penulis-mahasiswa-list') {
        inputFields += `
        <label class="input-group-text" for="upload-sk-${penulisCounter}">Upload SK</label>
        <input type="file" class="form-control" id="upload-sk-${penulisCounter}">`;
    }

    inputFields += `<button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">-</button>`;
    newInput.innerHTML = inputFields;

    list.appendChild(newInput);
}

// === Logika Modal Konfirmasi Hapus ===
function setupDeleteModalLogic(showSuccessModalCallback) {
    const hapusModal = document.getElementById('modalKonfirmasiHapus');
    if (!hapusModal) return;

    const btnBatalHapus = document.getElementById('btnBatalHapus');
    const btnKonfirmasiHapus = document.getElementById('btnKonfirmasiHapus');
    let dataIdUntukHapus = null;

    const showDeleteModal = () => hapusModal.classList.add('show');
    const hideDeleteModal = () => hapusModal.classList.remove('show');

    document.addEventListener('click', function (event) {
        if (event.target.closest('.btn-hapus')) {
            event.preventDefault();
            dataIdUntukHapus = event.target.closest('tr').querySelector('td:first-child').textContent;
            showDeleteModal();
        }
    });

    btnBatalHapus?.addEventListener('click', hideDeleteModal);
    hapusModal.addEventListener('click', function (e) {
        if (e.target === hapusModal) {
            hideDeleteModal();
        }
    });

    btnKonfirmasiHapus?.addEventListener('click', function () {
        console.log('Menghapus data dengan ID:', dataIdUntukHapus);
        hideDeleteModal();
        showSuccessModalCallback('Data Berhasil Dihapus', 'Data yang dipilih telah berhasil dihapus secara permanen.');
    });
}