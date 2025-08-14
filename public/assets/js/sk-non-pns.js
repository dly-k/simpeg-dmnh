document.addEventListener('DOMContentLoaded', function () {

    // === 1. LOGIKA INTI: MODAL BERHASIL (SUCCESS MODAL) ===
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
            successModalTimeout = setTimeout(hideSuccessModal, 1200); // Durasi 1.2 detik
        }
    }
    
    function hideSuccessModal() {
        modalBerhasil?.classList.remove('show');
    }
    document.getElementById('btnSelesai')?.addEventListener('click', () => {
        clearTimeout(successModalTimeout);
        hideSuccessModal();
    });

    // === 2. LOGIKA STANDAR: SIDEBAR, JAM, UPLOAD ===
    function setupStandardUI() {
        // Sidebar
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const toggleSidebarBtn = document.getElementById('toggleSidebar');
        if (toggleSidebarBtn && sidebar && overlay) {
            toggleSidebarBtn.addEventListener('click', () => {
                const isMobile = window.innerWidth <= 991;
                sidebar.classList.toggle(isMobile ? 'show' : 'hidden');
                if (isMobile) overlay.classList.toggle('show', sidebar.classList.contains('show'));
            });
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
        }
        // Jam & Tanggal
        function updateDateTime() {
            const now = new Date();
            const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false, timeZone: 'Asia/Jakarta' };
            document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', dateOptions);
            document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID', timeOptions).replace(/\./g, ':');
        }
        updateDateTime();
        setInterval(updateDateTime, 1000);
        // Area Upload File
        document.querySelectorAll('.upload-area').forEach(uploadArea => {
            const fileInput = uploadArea.querySelector('input[type="file"]');
            const uploadText = uploadArea.querySelector('p');
            if (!fileInput || !uploadText) return;
            const originalText = uploadText.innerHTML;
            uploadArea.addEventListener('click', () => fileInput.click());
            fileInput.addEventListener('change', function () {
                if (this.files.length > 0) uploadText.textContent = this.files[0].name;
            });
            uploadArea.reset = () => {
                uploadText.innerHTML = originalText;
                fileInput.value = '';
            };
        });
    }
    setupStandardUI();

    // === 3. LOGIKA SPESIFIK HALAMAN SK NON PNS ===
    
    // Konfigurasi Modal Tambah/Edit
    const skNonPnsModalEl = document.getElementById('skNonPnsModal');
    if (skNonPnsModalEl) {
        const bsModal = new bootstrap.Modal(skNonPnsModalEl);
        
        skNonPnsModalEl.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const modalTitle = skNonPnsModalEl.querySelector('.modal-title');
            const isEditMode = button && button.classList.contains('btn-edit');

            modalTitle.innerHTML = isEditMode
                ? '<i class="fas fa-edit"></i> Edit Data SK Non PNS'
                : '<i class="fas fa-plus-circle"></i> Tambah Data SK Non PNS';

            if (!isEditMode) {
                document.getElementById('skNonPnsForm')?.reset();
                skNonPnsModalEl.querySelector('.upload-area')?.reset();
            }
        });

        // [BARU] Aksi untuk tombol Simpan
        skNonPnsModalEl.querySelector('.btn-success')?.addEventListener('click', () => {
            bsModal.hide();
            showSuccessModal('Data Berhasil Disimpan', 'Data SK Non PNS telah berhasil disimpan.');
        });
    }

    // Konfigurasi Modal Detail dan Hapus menggunakan Event Delegation
    const modalKonfirmasiHapus = document.getElementById('modalKonfirmasiHapus');
    let dataToDelete = null;

    const hideDeleteModal = () => {
        if (modalKonfirmasiHapus) modalKonfirmasiHapus.classList.remove('show');
    };

    document.body.addEventListener('click', function(event) {
        const target = event.target;
        
        // Tombol Lihat Detail
        const detailButton = target.closest('.btn-lihat-detail-sk');
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
            document.getElementById('detail_sk_document_viewer')?.setAttribute('src', data.dokumen_path || '');
        }

        // Tombol Hapus pada baris tabel
        if (target.closest('.btn-hapus')) {
            event.preventDefault();
            const row = target.closest('tr');
            dataToDelete = {
                element: row,
                nama: row?.querySelector('td:nth-child(2)')?.textContent.trim()
            };
            if (modalKonfirmasiHapus) modalKonfirmasiHapus.classList.add('show');
        }

        // Tombol "Ya, Hapus" di modal konfirmasi
        if (target.matches('#btnKonfirmasiHapus')) {
            event.preventDefault();
            event.stopPropagation();
            if (dataToDelete) {
                console.log('Menghapus data:', dataToDelete.nama);
                dataToDelete.element?.remove(); // Hapus baris untuk demo
                hideDeleteModal();
                showSuccessModal('Data Berhasil Dihapus', `Data SK Non PNS telah berhasil dihapus.`);
            }
        }

        // Tombol "Batal" di modal hapus
        if (target.matches('#btnBatalHapus')) {
            hideDeleteModal();
        }
    });
    
    // Klik di luar area untuk menutup modal hapus
    modalKonfirmasiHapus?.addEventListener('click', (e) => {
        if (e.target === modalKonfirmasiHapus) hideDeleteModal();
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modalKonfirmasiHapus?.classList.contains('show')) {
            hideDeleteModal();
        }
    });
});