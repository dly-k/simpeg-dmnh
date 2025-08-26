// Inisialisasi Modal Bootstrap di awal
let pengabdianModalInstance;

document.addEventListener('DOMContentLoaded', function () {
    // Buat instance modal Bootstrap untuk Tambah/Edit
    const pengabdianModalEl = document.getElementById('pengabdianModal');
    if (pengabdianModalEl) {
        pengabdianModalInstance = new bootstrap.Modal(pengabdianModalEl);
    }

    // === MODAL BERHASIL (SUCCESS MODAL) LOGIC ===
    const modalBerhasil = document.getElementById('modalBerhasil');
    const berhasilTitle = document.getElementById('berhasil-title');
    const berhasilSubtitle = document.getElementById('berhasil-subtitle');
    let successModalTimeout = null;
    const successSound = new Audio('assets/sounds/success.mp3');

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
            sidebar.classList.toggle(window.innerWidth <= 991 ? 'show' : 'hidden');
            if (window.innerWidth <= 991) overlay.classList.toggle('show');
        });
        overlay.addEventListener('click', () => {
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

    // === Dynamic Member & File Upload Logic (Tidak berubah) ===
    document.body.addEventListener('click', function(event) {
        if (event.target.closest('.dynamic-row-close-btn')) {
            event.target.closest('.dynamic-row').remove();
        }
    });
    document.querySelectorAll('.upload-area').forEach(uploadArea => {
        const fileInput = uploadArea.querySelector('input[type="file"]');
        const uploadText = uploadArea.querySelector('p');
        const originalText = uploadText.innerHTML;
        uploadArea.addEventListener('click', () => fileInput.click());
        fileInput.addEventListener('change', () => {
            uploadText.textContent = fileInput.files.length > 0 ? fileInput.files[0].name : originalText;
        });
        uploadArea.reset = () => {
            uploadText.innerHTML = originalText;
            fileInput.value = '';
        };
    });

    // === Tombol Simpan (di dalam modal) ===
    document.querySelector('#pengabdianModal .btn-success')?.addEventListener('click', function() {
        closeModal();
        showSuccessModal('Data Berhasil Disimpan', 'Data pengabdian telah berhasil disimpan ke sistem.');
    });

    // === LOGIKA MODAL-MODAL KONFIRMASI ===
    const verifModal = document.getElementById("modalKonfirmasiVerifikasi");
    const deleteModal = document.getElementById('modalKonfirmasiHapus');

    // Fungsi untuk menyembunyikan modal konfirmasi
    function hideVerifModal() { if (verifModal) verifModal.classList.remove('show'); }
    function hideDeleteModal() {
        if (deleteModal) {
            deleteModal.classList.remove('show');
            if (!document.querySelector('.modal.show')) document.body.style.overflow = '';
        }
    }

    // Event listener utama untuk tombol di seluruh halaman
    document.addEventListener("click", function (event) {
        const target = event.target;
        // Tombol Verifikasi
        if (target.closest(".btn-verifikasi")) {
            event.preventDefault();
            verifModal?.classList.add("show");
        }
        // Tombol Hapus
        if (target.closest('.btn-hapus')) {
            event.preventDefault();
            deleteModal?.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
        // Tombol di dalam popup Verifikasi
        if (target.closest("#popupBtnKembali")) hideVerifModal();
        if (target.closest("#popupBtnTerima")) {
            hideVerifModal();
            showSuccessModal("Data Diverifikasi", "Data pengabdian berhasil diverifikasi");
        }
        if (target.closest("#popupBtnTolak")) {
            hideVerifModal();
            showSuccessModal("Data Ditolak", "Data pengabdian telah ditolak");
        }
        // Tombol di dalam popup Hapus
        if (target.closest('#btnBatalHapus')) hideDeleteModal();
        if (target.closest('#btnKonfirmasiHapus')) {
            hideDeleteModal();
            showSuccessModal('Data Berhasil Dihapus', 'Data telah berhasil dihapus permanen.');
        }
    });

    // Menutup modal konfirmasi jika klik di luar area konten
    window.addEventListener('click', function(event){
        if (event.target === verifModal) hideVerifModal();
        if (event.target === deleteModal) hideDeleteModal();
    });
});

// === Global Modal Functions (UPDATED FOR BOOTSTRAP 5) ===
function openModal() {
    if (!pengabdianModalInstance) return;

    const modalTitle = document.getElementById('pengabdianModalLabel');
    if (modalTitle) {
        modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Pengabdian';
    }

    // Reset Form, Upload Area, dan List Dinamis
    document.getElementById('pengabdianForm')?.reset();
    document.querySelectorAll('.upload-area').forEach(area => area.reset?.());
    ['dosen-list', 'mahasiswa-list', 'kolaborator-list'].forEach(id => {
        const list = document.getElementById(id);
        if (list) list.innerHTML = '';
    });

    pengabdianModalInstance.show();
}

function openEditModal() {
    if (!pengabdianModalInstance) return;

    const modalTitle = document.getElementById('pengabdianModalLabel');
    if (modalTitle) {
        modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Pengabdian';
    }
    // Note: Anda bisa menambahkan logika untuk mengisi data form di sini
    
    pengabdianModalInstance.show();
}

function closeModal() {
    if (pengabdianModalInstance) {
        pengabdianModalInstance.hide();
    }
}

// === Dynamic Member Add Function (Tidak berubah) ===
function addAnggota(type) {
    const listId = `${type}-list`;
    const container = document.getElementById(listId);
    if (!container) return;

    const removeButton = `<button class="btn btn-sm dynamic-row-close-btn" type="button"><i class="fa fa-times"></i></button>`;
    let content = '';

    switch (type) {
        case 'dosen':
            content = `<div class="dynamic-row"><div class="row g-2"><div class="col-12"><input type="text" class="form-control form-control-sm" placeholder="Nama Dosen"></div><div class="col-md-6"><select class="form-select form-select-sm"><option selected>Jabatan</option></select></div><div class="col-md-6"><select class="form-select form-select-sm"><option selected>Aktif</option></select></div></div>${removeButton}</div>`;
            break;
        case 'mahasiswa':
            content = `<div class="dynamic-row"><div class="row g-2"><div class="col-md-6"><select class="form-select form-select-sm"><option selected>Strata</option></select></div><div class="col-md-6"><input type="text" class="form-control form-control-sm" placeholder="Nama Mahasiswa"></div><div class="col-md-6"><select class="form-select form-select-sm"><option selected>Jabatan</option></select></div><div class="col-md-6"><select class="form-select form-select-sm"><option selected>Aktif</option></select></div></div>${removeButton}</div>`;
            break;
        case 'kolaborator':
            content = `<div class="dynamic-row"><div class="row g-2"><div class="col-12"><input type="text" class="form-control form-control-sm" placeholder="Nama Kolaborator"></div><div class="col-md-6"><select class="form-select form-select-sm"><option selected>Jabatan</option></select></div><div class="col-md-6"><select class="form-select form-select-sm"><option selected>Aktif</option></select></div></div>${removeButton}</div>`;
            break;
    }
    container.insertAdjacentHTML('beforeend', content);
}