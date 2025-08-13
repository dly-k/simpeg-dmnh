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
            const button = event.relatedTarget;
            const modalTitle = skNonPnsModal.querySelector('.modal-title');
            const skNonPnsForm = document.getElementById('skNonPnsForm');

            if (button && button.classList.contains('btn-edit')) {
                modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data SK Non PNS';
                // Isi form dengan data yang ada
            } else {
                modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data SK Non PNS';
                if (skNonPnsForm) skNonPnsForm.reset();
                const uploadArea = skNonPnsModal.querySelector('.upload-area');
                if (uploadArea && typeof uploadArea.reset === 'function') {
                    uploadArea.reset();
                }
            }
        });
    }

    // 2. Logika untuk Modal Detail SK Non PNS
    document.body.addEventListener('click', function(event) {
        const detailButton = event.target.closest('.btn-lihat-detail-sk');
        
        if (detailButton) {
            event.preventDefault(); 
            const data = detailButton.dataset;
            const setText = (id, value) => {
                const element = document.getElementById(id);
                if (element) element.textContent = value || '-';
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
            if (docViewer) docViewer.setAttribute('src', data.dokumen_path || '');
        }
    });

    // 3. Logika untuk Modal Konfirmasi Hapus
    const modalKonfirmasiHapus = document.getElementById('modalKonfirmasiHapus');
    const btnKonfirmasiHapus = document.getElementById('btnKonfirmasiHapus');
    const btnBatalHapus = document.getElementById('btnBatalHapus');
    let dataToDelete = null;

// Fungsi untuk menampilkan modal
function showDeleteModal() {
    if (modalKonfirmasiHapus) {
        modalKonfirmasiHapus.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
}

// Fungsi untuk menyembunyikan modal
function hideDeleteModal() {
    if (modalKonfirmasiHapus) {
        modalKonfirmasiHapus.classList.remove('show');
        document.body.style.overflow = '';
    }
}


    // Event delegation untuk tombol hapus
    document.addEventListener('click', function(event) {
        const deleteButton = event.target.closest('.btn-hapus');
        if (deleteButton) {
            event.preventDefault();
            const row = deleteButton.closest('tr');
            dataToDelete = {
                id: deleteButton.dataset.id || row?.querySelector('td:first-child')?.textContent,
                nama: deleteButton.dataset.nama || row?.querySelector('td:nth-child(2)')?.textContent,
                element: row
            };
            showDeleteModal();
        }
    });

    // Handler untuk tombol konfirmasi hapus
    if (btnKonfirmasiHapus) {
        btnKonfirmasiHapus.addEventListener('click', function() {
            if (dataToDelete) {
                // Contoh AJAX call (uncomment untuk digunakan):
                /*
                fetch(`/api/sk-non-pns/${dataToDelete.id}`, {
                    method: 'DELETE'
                })
                .then(response => {
                    if (response.ok) {
                        dataToDelete.element?.remove();
                        alert(`Data "${dataToDelete.nama}" berhasil dihapus`);
                    } else {
                        alert('Gagal menghapus data');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus data');
                });
                */
                
                // Untuk demo langsung hapus elemen
                dataToDelete.element?.remove();
                alert(`Data "${dataToDelete.nama}" berhasil dihapus`);
            }
            hideDeleteModal();
        });
    }

    // Handler untuk tombol batal
    if (btnBatalHapus) {
        btnBatalHapus.addEventListener('click', hideDeleteModal);
    }

    // Tutup modal ketika klik di luar area modal
    modalKonfirmasiHapus?.addEventListener('click', function(event) {
        if (event.target === modalKonfirmasiHapus) {
            hideDeleteModal();
        }
    });

    // Tutup modal ketika tekan tombol ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && modalKonfirmasiHapus.style.display === 'flex') {
            hideDeleteModal();
        }
    });
});