// Inisialisasi Modal Bootstrap di awal
let penelitianModalInstance;

document.addEventListener('DOMContentLoaded', function () {
    // Buat instance modal Bootstrap untuk Tambah/Edit
    const penelitianModalEl = document.getElementById('penelitianModal');
    if (penelitianModalEl) {
        penelitianModalInstance = new bootstrap.Modal(penelitianModalEl);
    }

    // === MODAL BERHASIL (SUCCESS MODAL) LOGIC ===
    const modalBerhasil = document.getElementById('modalBerhasil');
    const berhasilTitle = document.getElementById('berhasil-title');
    const berhasilSubtitle = document.getElementById('berhasil-subtitle');
    let successModalTimeout = null;
    const successSound = new Audio('/assets/sounds/success.mp3');

    function showSuccessModal(title, subtitle) {
        if (modalBerhasil && berhasilTitle && berhasilSubtitle) {
            berhasilTitle.textContent = title;
            berhasilSubtitle.textContent = subtitle;
            modalBerhasil.classList.add('show');
            document.body.style.overflow = 'hidden';
            successSound.play().catch(error => console.error('Error playing sound:', error));
            clearTimeout(successModalTimeout);
            successModalTimeout = setTimeout(hideSuccessModal, 1200);
        }
    }

    function hideSuccessModal() {
        if (modalBerhasil) {
            modalBerhasil.classList.remove('show');
            if (!document.querySelector('.modal.show')) {
                document.body.style.overflow = '';
            }
        }
    }
    document.getElementById('btnSelesai')?.addEventListener('click', () => {
        clearTimeout(successModalTimeout);
        hideSuccessModal();
    });

    // === Sidebar, Date, and Time Logic (Tidak berubah) ===
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const toggleSidebarBtn = document.getElementById('toggleSidebar');
    if (toggleSidebarBtn) {
        toggleSidebarBtn.addEventListener('click', () => {
            const isMobile = window.innerWidth <= 991;
            sidebar.classList.toggle(isMobile ? 'show' : 'hidden');
            if (isMobile) overlay.classList.toggle('show');
        });
        overlay?.addEventListener('click', () => {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    }
    (function updateDateTime() {
        const now = new Date();
        const dateEl = document.getElementById('current-date');
        const timeEl = document.getElementById('current-time');
        if(dateEl && timeEl) {
            dateEl.textContent = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            timeEl.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false });
        }
        setTimeout(updateDateTime, 1000);
    })();

    // === Tombol Simpan (di dalam modal) ===
    document.querySelector('#penelitianModal .btn-success')?.addEventListener('click', function() {
        closeModal();
        showSuccessModal('Data Berhasil Disimpan', 'Data penelitian telah berhasil disimpan ke sistem.');
    });

    // === LOGIKA MODAL-MODAL KONFIRMASI (HAPUS & VERIFIKASI) ===
    const verifModal = document.getElementById("modalKonfirmasiVerifikasi");
    const deleteModal = document.getElementById('modalKonfirmasiHapus');
    
    function hideVerifModal() { if (verifModal) verifModal.classList.remove('show'); }
    function hideDeleteModal() {
        if (deleteModal) {
            deleteModal.classList.remove('show');
            if (!document.querySelector('.modal.show')) document.body.style.overflow = '';
        }
    }

    document.addEventListener("click", function (event) {
        const target = event.target.closest('a, button');
        if (!target) return;
        
        if (target.classList.contains("btn-verifikasi")) {
            event.preventDefault();
            verifModal?.classList.add("show");
        }
        if (target.classList.contains('btn-hapus')) {
            event.preventDefault();
            deleteModal?.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
        if (target.id === "popupBtnKembali") hideVerifModal();
        if (target.id === "popupBtnTerima") {
            hideVerifModal();
            showSuccessModal("Data Diverifikasi", "Data penelitian berhasil diverifikasi");
        }
        if (target.id === "popupBtnTolak") {
            hideVerifModal();
            showSuccessModal("Data Ditolak", "Data penelitian telah ditolak");
        }
        if (target.id === 'btnBatalHapus') hideDeleteModal();
        if (target.id === 'btnKonfirmasiHapus') {
            hideDeleteModal();
            showSuccessModal('Data Berhasil Dihapus', 'Data telah berhasil dihapus permanen.');
        }
    });

    window.addEventListener('click', function(event){
        if (event.target === verifModal) hideVerifModal();
        if (event.target === deleteModal) hideDeleteModal();
    });
});

// === Global Modal Functions (UPDATED FOR BOOTSTRAP 5) ===
function openModal() {
    if (!penelitianModalInstance) return;

    const modalTitle = document.getElementById('penelitianModalLabel');
    if (modalTitle) {
        modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Penelitian';
    }

    document.getElementById('penelitianForm')?.reset();
    resetPenulisFields(); // Panggil fungsi reset penulis

    penelitianModalInstance.show();
}

function openEditModal() {
    if (!penelitianModalInstance) return;

    const modalTitle = document.getElementById('penelitianModalLabel');
    if (modalTitle) {
        modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Penelitian';
    }
    
    resetPenulisFields(); // Panggil juga saat edit untuk memulai dengan field default
    // Anda bisa tambahkan logika untuk mengisi data form di sini
    
    penelitianModalInstance.show();
}

function closeModal() {
    if (penelitianModalInstance) {
        penelitianModalInstance.hide();
    }
}

// === FUNGSI PENULIS DINAMIS (GLOBAL SCOPE) ===
function createPenulisInput(listId, isFirst) {
    const isMahasiswa = listId === 'penulis-mahasiswa-list';
    const buttonClass = isFirst ? 'btn-outline-success' : 'btn-outline-danger';
    const buttonIcon = isFirst ? '+' : '-';
    const buttonAction = isFirst ? `addPenulis('${listId}')` : 'this.parentElement.remove()';

    let skInput = `
        <label class="input-group-text">Upload SK</label>
        <input type="file" class="form-control">`;
    if (isMahasiswa) {
        skInput = '';
    }

    return `
    <div class="input-group mb-2">
        <input type="text" class="form-control" placeholder="Nama">
        ${skInput}
        <button class="btn ${buttonClass}" type="button" onclick="${buttonAction}">${buttonIcon}</button>
    </div>`;
}

function resetPenulisFields() {
    document.getElementById('penulis-ipb-list').innerHTML = createPenulisInput('penulis-ipb-list', true);
    document.getElementById('penulis-luar-list').innerHTML = createPenulisInput('penulis-luar-list', true);
    document.getElementById('penulis-mahasiswa-list').innerHTML = createPenulisInput('penulis-mahasiswa-list', true);
}

function addPenulis(listId) {
    const list = document.getElementById(listId);
    if (list) {
        list.insertAdjacentHTML('beforeend', createPenulisInput(listId, false));
    }
}