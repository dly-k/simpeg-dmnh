document.addEventListener('DOMContentLoaded', function () {
    
    // === Logic untuk Sidebar (Tidak Berubah) ===
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

    // === Logic untuk Jam & Tanggal (Tidak Berubah) ===
    function updateDateTime() {
        const now = new Date();
        const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false, timeZone: 'Asia/Jakarta' };
        const dateEl = document.getElementById('current-date');
        const timeEl = document.getElementById('current-time');
        if (dateEl && timeEl) {
            dateEl.textContent = now.toLocaleDateString('id-ID', dateOptions);
            // Mengganti titik dengan titik dua untuk format waktu
            timeEl.textContent = now.toLocaleTimeString('id-ID', timeOptions).replace(/\./g, ':');
        }
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);

    // === Logic untuk Area Upload File (Tidak Berubah) ===
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
                }
            });
            uploadArea.reset = function() {
                uploadText.innerHTML = originalText;
                fileInput.value = '';
            };
        });
    }
    setupUploadArea();


    // =======================================================
    // ===       LOGIKA UNTUK SEMUA MODAL DI HALAMAN INI     ===
    // =======================================================

    // 1. Logika untuk Modal Tambah/Edit SK Non PNS
    const skNonPnsModal = document.getElementById('skNonPnsModal');
    if (skNonPnsModal) {
        skNonPnsModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Tombol yang diklik
            const modalTitle = skNonPnsModal.querySelector('.modal-title');
            const skNonPnsForm = document.getElementById('skNonPnsForm');

            // Cek apakah tombol Edit yang diklik
            if (button && button.classList.contains('btn-edit')) {
                modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data SK Non PNS';
                // Di sini Anda bisa menambahkan kode untuk mengisi form dengan data yang ada
            } else { // Jika bukan, berarti tombol Tambah
                modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data SK Non PNS';
                // Kosongkan form saat menambah data baru
                if (skNonPnsForm) {
                    skNonPnsForm.reset();
                }
                // Reset juga area upload
                const uploadArea = skNonPnsModal.querySelector('.upload-area');
                if (uploadArea && typeof uploadArea.reset === 'function') {
                    uploadArea.reset();
                }
            }
        });
    }

    // 2. Logika untuk Modal Detail SK Non PNS (menggunakan event delegation)
    document.body.addEventListener('click', function(event) {
        const detailButton = event.target.closest('.btn-lihat-detail-sk');
        
        if (detailButton) {
            event.preventDefault(); 
            const data = detailButton.dataset;
            const setText = (id, value) => {
                const element = document.getElementById(id);
                if (element) {
                    element.textContent = value || '-';
                }
            };
            
            setText('detail_sk_nama_kegiatan', data.nama_kegiatan);
            setText('detail_sk_unit', data.unit);
            setText('detail_sk_jenis_sk', data.jenis_sk);
            setText('detail_sk_nomor_sk', data.nomor_sk);
            setText('detail_sk_tanggal_sk', data.tanggal_sk);
            setText('detail_sk_pegawai', data.pegawai);
            setText('detail_sk_tgl_mulai', data.tgl_mulai);
            setText('detail_sk_tgl_selesai', data.tgl_selesai);
            
            const docViewer = document.getElementById('detail_sk_document_viewer');
            if (docViewer) {
                docViewer.setAttribute('src', data.dokumen_path || '');
            }
        }
    });

});

// FUNGSI LAMA (openModal, openEditModal, closeModal, window.addEventListener) SUDAH DIHAPUS
// KARENA SUDAH TIDAK DIPERLUKAN LAGI SETELAH MIGRASI KE SISTEM BOOTSTRAP.