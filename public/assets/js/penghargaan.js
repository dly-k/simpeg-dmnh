document.addEventListener('DOMContentLoaded', function () {
    // === 1. LOGIKA INTI: MODAL BERHASIL (SUCCESS MODAL) ===
    const modalBerhasil = document.getElementById('modalBerhasil');
    const berhasilTitle = document.getElementById('berhasil-title');
    const berhasilSubtitle = document.getElementById('berhasil-subtitle');
    let successModalTimeout = null;
    let successAudio = null; // Variabel untuk menyimpan instance audio

    function showSuccessModal(title, subtitle) {
        if (modalBerhasil && berhasilTitle && berhasilSubtitle) {
            berhasilTitle.textContent = title;
            berhasilSubtitle.textContent = subtitle;
            modalBerhasil.classList.add('show');
            const overlay = modalBerhasil.querySelector('.modal-berhasil-overlay');
            if (overlay) overlay.classList.add('show');
            
            // Putar musik sukses
            successAudio = new Audio('/assets/sounds/success.mp3'); // Pastikan path file audio benar
            successAudio.play().catch(error => {
                console.log('Error memutar suara:', error);
                if (error.name === 'NotAllowedError') {
                    console.log('Autoplay diblokir oleh browser. Butuh interaksi pengguna terlebih dahulu.');
                } else if (error.name === 'NotFoundError') {
                    console.log('File audio tidak ditemukan. Periksa path: /assets/sounds/success.mp3');
                }
            });
            
            clearTimeout(successModalTimeout);
            successModalTimeout = setTimeout(hideSuccessModal, 1200); // Durasi 1.2 detik
        }
    }
    
    function hideSuccessModal() {
        if (modalBerhasil) modalBerhasil.classList.remove('show');
        const overlay = modalBerhasil.querySelector('.modal-berhasil-overlay');
        if (overlay) overlay.classList.remove('show');
        if (successAudio) {
            successAudio.pause(); // Hentikan audio
            successAudio.currentTime = 0; // Reset audio ke awal
        }
    }
    document.getElementById('btnSelesai')?.addEventListener('click', () => {
        clearTimeout(successModalTimeout);
        hideSuccessModal();
    });

    // === 2. LOGIKA STANDAR: SIDEBAR & JAM ===
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

    function updateDateTime() {
        const now = new Date();
        const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false, timeZone: 'Asia/Jakarta' };
        document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', dateOptions);
        document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID', timeOptions);
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);

    // === 3. LOGIKA SPESIFIK HALAMAN PENGHARGAAN ===
    
    // Konfigurasi area upload file
    function setupUploadArea() {
        document.querySelectorAll('.upload-area').forEach(uploadArea => {
            const fileInput = uploadArea.querySelector('input[type="file"]');
            const uploadText = uploadArea.querySelector('p');
            if (!fileInput || !uploadText) return;
            const originalText = uploadText.innerHTML;
            uploadArea.addEventListener('click', () => fileInput.click());
            fileInput.addEventListener('change', function () {
                if (this.files.length > 0) uploadText.textContent = this.files[0].name;
            });
            uploadArea.reset = function() {
                uploadText.innerHTML = originalText;
                fileInput.value = '';
            };
        });
    }
    setupUploadArea();

    // Logika untuk Modal Tambah/Edit menggunakan Bootstrap
    const penghargaanModalEl = document.getElementById('penghargaanModal');
    if (penghargaanModalEl) {
        const bsModal = new bootstrap.Modal(penghargaanModalEl);
        
        penghargaanModalEl.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const modalTitle = penghargaanModalEl.querySelector('.modal-title');
            const isEditMode = button && button.classList.contains('btn-edit');

            modalTitle.innerHTML = isEditMode
                ? '<i class="fas fa-edit"></i> Edit Data Penghargaan'
                : '<i class="fas fa-plus-circle"></i> Tambah Data Penghargaan';
            
            if (!isEditMode) {
                document.getElementById('penghargaanForm')?.reset();
                penghargaanModalEl.querySelector('.upload-area')?.reset();
            }
        });
        
        // Aksi untuk tombol Simpan
        penghargaanModalEl.querySelector('.btn-success')?.addEventListener('click', () => {
            bsModal.hide();
            showSuccessModal('Data Berhasil Disimpan', 'Data penghargaan telah berhasil disimpan.');
        });
    }

    // Logika untuk Modal Detail
    document.addEventListener('click', function(event) {
        const detailButton = event.target.closest('.btn-lihat-detail-penghargaan');
        if (detailButton) {
            const data = detailButton.dataset;
            document.getElementById('detail_penghargaan_pegawai').textContent = data.pegawai || '-';
            document.getElementById('detail_penghargaan_kegiatan').textContent = data.kegiatan || '-';
            document.getElementById('detail_penghargaan_nama_penghargaan').textContent = data.nama_penghargaan || '-';
            document.getElementById('detail_penghargaan_nomor').textContent = data.nomor || '-';
            document.getElementById('detail_penghargaan_tanggal_perolehan').textContent = data.tanggal_perolehan || '-';
            document.getElementById('detail_penghargaan_lingkup').textContent = data.lingkup || '-';
            document.getElementById('detail_penghargaan_negara').textContent = data.negara || '-';
            document.getElementById('detail_penghargaan_instansi').textContent = data.instansi || '-';
            document.getElementById('detail_penghargaan_jenis_dokumen').textContent = data.jenis_dokumen || '-';
            document.getElementById('detail_penghargaan_nama_dokumen').textContent = data.nama_dokumen || '-';
            document.getElementById('detail_penghargaan_nomor_dokumen').textContent = data.nomor_dokumen || '-';
            document.getElementById('detail_penghargaan_tautan').textContent = data.tautan || '-';
            document.getElementById('detail_penghargaan_document_viewer')?.setAttribute('src', data.dokumen_path || '');
        }
    });

    // Logika untuk Modal Konfirmasi Hapus
    const modalKonfirmasiHapus = document.getElementById('modalKonfirmasiHapus');
    let dataToDelete = null;

    const showDeleteModal = () => {
        if (modalKonfirmasiHapus) {
            modalKonfirmasiHapus.classList.add('show');
            const overlay = modalKonfirmasiHapus.querySelector('.konfirmasi-hapus-overlay');
            if (overlay) overlay.classList.add('show');
        }
    };

    const hideDeleteModal = () => {
        if (modalKonfirmasiHapus) modalKonfirmasiHapus.classList.remove('show');
        const overlay = modalKonfirmasiHapus.querySelector('.konfirmasi-hapus-overlay');
        if (overlay) overlay.classList.remove('show');
    };

    document.body.addEventListener('click', function(event) {
        const target = event.target;

        // Tombol hapus pada baris tabel
        if (target.closest('.btn-hapus')) {
            event.preventDefault();
            console.log('Tombol Hapus diklik'); // Untuk debugging
            const row = target.closest('tr');
            dataToDelete = {
                element: row,
                nama: row?.querySelector('td:nth-child(2)')?.textContent.trim()
            };
            showDeleteModal();
        }

        // Tombol "Ya, Hapus"
        if (target.matches('#btnKonfirmasiHapus')) {
            event.preventDefault();
            event.stopPropagation();
            if (dataToDelete) {
                console.log('Menghapus data:', dataToDelete.nama);
                dataToDelete.element?.remove(); // Hapus baris untuk demo
                hideDeleteModal();
                showSuccessModal('Data Berhasil Dihapus', `Data penghargaan "${dataToDelete.nama}" telah berhasil dihapus.`);
            }
        }
        
        // Tombol "Batal"
        if (target.matches('#btnBatalHapus')) {
            hideDeleteModal();
        }
    });
    
    // Klik di luar area modal hapus
    modalKonfirmasiHapus?.addEventListener('click', (e) => {
        if (e.target === modalKonfirmasiHapus) hideDeleteModal();
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modalKonfirmasiHapus?.classList.contains('show')) {
            hideDeleteModal();
        }
    });
});