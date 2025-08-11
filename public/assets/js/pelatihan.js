document.addEventListener('DOMContentLoaded', function () {
    // === Sidebar Logic ===
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const toggleSidebarBtn = document.getElementById('toggleSidebar');

    if (toggleSidebarBtn && sidebar && overlay) {
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

    // === Date and Time Logic ===
    function updateDateTime() {
        const now = new Date();
        const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false, timeZone: 'Asia/Jakarta' };

        const dateEl = document.getElementById('current-date');
        const timeEl = document.getElementById('current-time');

        if (dateEl && timeEl) {
            dateEl.textContent = now.toLocaleDateString('id-ID', dateOptions);
            timeEl.textContent = now.toLocaleTimeString('id-ID', timeOptions).replace(/\./g, ':');
        }
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);

    // === Event Delegation untuk Hapus Anggota ===
    const anggotaList = document.getElementById('anggota-list');
    if (anggotaList) {
        anggotaList.addEventListener('click', function(event) {
            if (event.target.closest('.dynamic-row-close-btn')) {
                event.target.closest('.dynamic-row').remove();
            }
        });
    }

    // === File Upload Logic ===
    function setupUploadArea() {
        document.querySelectorAll('.upload-area').forEach(uploadArea => {
            const fileInput = uploadArea.querySelector('input[type="file"]');
            const uploadText = uploadArea.querySelector('p');
            if (!fileInput || !uploadText) return;
            const originalText = uploadText.innerHTML;
            uploadArea.addEventListener('click', function () { fileInput.click(); });
            fileInput.addEventListener('change', function () {
                if (this.files.length > 0) {
                    uploadText.textContent = this.files[0].name;
                }
            });
            uploadArea.reset = function() {
                uploadText.innerHTML = originalText;
                fileInput.value = '';
            };
        });
    }
    setupUploadArea();

    // ================================================================= //
    // === BLOK BARU: Logika untuk Modal Detail (Sistem Bootstrap 5) === //
    // ================================================================= //
    
    // Logika ini hanya akan berjalan jika menemukan tombol dengan kelas .btn-lihat-detail-pelatihan
    // dan tidak akan mengganggu fungsi openModal() atau openEditModal() Anda.
    document.addEventListener('click', function(event) {
        const detailButton = event.target.closest('.btn-lihat-detail-pelatihan');
        if (detailButton) {
            // Kita tidak perlu membuka modal secara manual karena atribut
            // data-bs-toggle="modal" di HTML sudah menanganinya.
            // Kita hanya perlu mengisi datanya.
            
            const data = detailButton.dataset;

            // Mengisi setiap elemen di modal detail
            document.getElementById('detail_pelatihan_nama').textContent = data.nama_pelatihan || '-';
            document.getElementById('detail_pelatihan_posisi').textContent = data.posisi || '-';
            document.getElementById('detail_pelatihan_kota').textContent = data.kota || '-';
            document.getElementById('detail_pelatihan_lokasi').textContent = data.lokasi || '-';
            document.getElementById('detail_pelatihan_penyelenggara').textContent = data.penyelenggara || '-';
            document.getElementById('detail_pelatihan_jenis_diklat').textContent = data.jenis_diklat || '-';
            document.getElementById('detail_pelatihan_tgl_mulai').textContent = data.tgl_mulai || '-';
            document.getElementById('detail_pelatihan_tgl_selesai').textContent = data.tgl_selesai || '-';
            document.getElementById('detail_pelatihan_lingkup').textContent = data.lingkup || '-';
            document.getElementById('detail_pelatihan_jam').textContent = data.jam || '-';
            document.getElementById('detail_pelatihan_hari').textContent = data.hari || '-';
            document.getElementById('detail_pelatihan_struktural').textContent = data.struktural || '-';
            document.getElementById('detail_pelatihan_sertifikasi').textContent = data.sertifikasi || '-';

            // Memperbarui viewer dokumen untuk menampilkan PDF
            const docViewer = document.getElementById('detail_pelatihan_document_viewer');
            if (docViewer) {
                if (data.dokumen_path) {
                    docViewer.setAttribute('src', data.dokumen_path);
                } else {
                    docViewer.setAttribute('src', '');
                }
            }
        }
    });

    // ================================================================= //
    // === AKHIR BLOK BARU                                           === //
    // ================================================================= //
});


// === Global Modal Functions (Milik Anda - Tidak Diubah) ===

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    const modalTitle = modal.querySelector('#modalTitle');
    const form = modal.querySelector('form');
    const anggotaList = document.getElementById('anggota-list');
    if (modalTitle) {
        modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Pelatihan';
    }
    if (form) {
        form.reset();
    }
    if (anggotaList) {
        anggotaList.innerHTML = '';
    }
    const uploadArea = modal.querySelector('.upload-area');
    if (uploadArea && typeof uploadArea.reset === 'function') {
        uploadArea.reset();
    }
    modal.style.display = 'flex';
}

function openEditModal() {
    const modal = document.getElementById('pelatihanModal');
    if (!modal) return;
    const modalTitle = modal.querySelector('#modalTitle');
    if (modalTitle) {
        modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Pelatihan';
    }
    modal.style.display = 'flex';
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
    }
}

function addAnggota() {
    const list = document.getElementById('anggota-list');
    if (!list) return;
    const newRow = document.createElement('div');
    newRow.className = 'dynamic-row';
    newRow.innerHTML = `
        <button type="button" class="btn-close dynamic-row-close-btn" aria-label="Close"></button>
        <div class="row g-2">
            <div class="col-12"><label class="form-label form-label-sm">Nama Anggota</label><input type="text" class="form-control form-control-sm" placeholder="Nama Anggota"></div>
            <div class="col-md-6"><label class="form-label form-label-sm">Angkatan</label><input type="text" class="form-control form-control-sm" placeholder="Angkatan"></div>
            <div class="col-md-6"><label class="form-label form-label-sm">Predikat</label><input type="text" class="form-control form-control-sm" placeholder="Predikat"></div>
        </div>
    `;
    list.appendChild(newRow);
}

window.addEventListener('click', function (event) {
    if (event.target.classList.contains('modal-backdrop')) {
        closeModal(event.target.id);
    }
    const pelatihanDetailModal = document.getElementById("pelatihanDetailModal");
    if (event.target === pelatihanDetailModal) {
        pelatihanDetailModal.style.display = "none";
    }
});