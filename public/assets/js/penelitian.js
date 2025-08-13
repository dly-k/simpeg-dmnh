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
    // Inisialisasi fungsi lain yang spesifik untuk halaman ini
    setupUploadArea();

    // --- LOGIKA BARU UNTUK MODAL KONFIRMASI ---
    const modalKonfirmasi = document.getElementById('modalKonfirmasiPenelitian');
    const tableBody = document.querySelector('.table tbody'); // Ambil body tabel
    const btnTerima = document.getElementById('popupBtnTerima');
    const btnKembali = document.getElementById('popupBtnKembali');
    let dataIdUntukAksi = null; // Variabel untuk menyimpan ID data

    const showModal = () => modalKonfirmasi?.classList.add('show');
    const hideModal = () => modalKonfirmasi?.classList.remove('show');

    // Event delegation untuk semua tombol di tabel
    tableBody?.addEventListener('click', function (event) {
        const verifikasiButton = event.target.closest('.btn-verifikasi');
        
        if (verifikasiButton) {
            event.preventDefault();
            dataIdUntukAksi = verifikasiButton.dataset.id;
            console.log("Membuka konfirmasi untuk ID:", dataIdUntukAksi);
            showModal();
        }
    });

    // Fungsi untuk tombol di dalam popup
    btnTerima?.addEventListener('click', function() {
        console.log(`Aksi "Verifikasi" DITERIMA untuk ID: ${dataIdUntukAksi}`);
        // Jalankan logika verifikasi di sini...
        hideModal();
    });

    btnKembali?.addEventListener('click', hideModal);

    // Tutup popup saat area gelap di klik
    modalKonfirmasi?.addEventListener('click', function(event) {
        if (event.target === modalKonfirmasi) {
            hideModal();
        }
    });

    // --- Logika untuk Modal Detail ---
    const detailModal = document.getElementById("detailModal");
    const closeModalBtn = document.getElementById("tutupBtn");

    // Karena tombol buka detail ada banyak di tabel, gunakan event delegation
    tableBody?.addEventListener('click', function(event){
        const openModalBtn = event.target.closest('#btnLihatDetail');
        if(openModalBtn){
            detailModal.style.display = "block";
        }
    });
    closeModalBtn?.addEventListener('click', () => detailModal.style.display = "none");
    window.addEventListener('click', (event) => {
        if (event.target == detailModal) {
            detailModal.style.display = "none";
        }
    });
}

// === Logika Upload File ===
function setupUploadArea() {
    const uploadArea = document.querySelector('.upload-area');
    if (!uploadArea) return;

    const fileInput = uploadArea.querySelector('input[type="file"]');
    const uploadText = uploadArea.querySelector('p');
    const originalText = uploadText.innerHTML; // Simpan teks asli

    // 1. Buka dialog file saat area diklik
    uploadArea.addEventListener('click', function () {
        fileInput.click();
    });

    // 2. Tampilkan nama file setelah dipilih
    fileInput.addEventListener('change', function () {
        if (this.files.length > 0) {
            uploadText.textContent = this.files[0].name;
        }
    });

    // Simpan fungsi untuk mereset teks ke elemen itu sendiri
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

    if (modalTitle) {
        modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Penelitian';
    }

    if (form) {
        form.reset();
    }

    // Reset tampilan area upload
    const uploadArea = modal.querySelector('.upload-area');
    if (uploadArea && typeof uploadArea.resetText === 'function') {
        uploadArea.resetText();
    }

    // Reset dynamic fields
    resetPenulisFields();

    modal.style.display = 'flex';
}

function openEditModal() {
    const modal = document.getElementById('penelitianModal');
    if (!modal) return;

    const modalTitle = modal.querySelector('#modalTitle');
    if (modalTitle) {
        modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Penelitian';
    }

    modal.style.display = 'flex';
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
    }
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

// === Hapus Confirmation Modal Logic ===
const hapusModal = document.getElementById('modalKonfirmasiHapus');
const btnBatalHapus = document.getElementById('btnBatalHapus');
const btnKonfirmasiHapus = document.getElementById('btnKonfirmasiHapus');
let dataIdUntukHapus = null;

// Event delegation untuk tombol hapus
document.addEventListener('click', function(event) {
  if (event.target.closest('.btn-hapus')) {
    event.preventDefault();
    dataIdUntukHapus = event.target.closest('tr').querySelector('td:first-child').textContent;
    if (hapusModal) hapusModal.style.display = 'flex';
  }
});

// Close modal when clicking outside
if (hapusModal) {
  hapusModal.addEventListener('click', function(e) {
    if (e.target === hapusModal) {
      hapusModal.style.display = 'none';
    }
  });
}

// Button handlers
if (btnBatalHapus) {
  btnBatalHapus.addEventListener('click', function() {
    hapusModal.style.display = 'none';
  });
}

if (btnKonfirmasiHapus) {
  btnKonfirmasiHapus.addEventListener('click', function() {
    // Logika hapus data disini
    console.log('Menghapus data dengan ID:', dataIdUntukHapus);
    alert(`Data dengan ID ${dataIdUntukHapus} berhasil dihapus`);
    hapusModal.style.display = 'none';
    
    // Tambahkan logika AJAX atau lainnya untuk menghapus data
    // Contoh:
    // fetch(`/api/penelitian/${dataIdUntukHapus}`, {
    //   method: 'DELETE'
    // }).then(response => {
    //   if(response.ok) {
    //     location.reload();
    //   }
    // });
  });
}
