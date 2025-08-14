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


    // === 2. LOGIKA STANDAR: SIDEBAR & JAM ===
    function setupStandardUI() {
        // Sidebar
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const toggleSidebarBtn = document.getElementById('toggleSidebar');
        if (toggleSidebarBtn && sidebar && overlay) {
            toggleSidebarBtn.addEventListener('click', () => {
                sidebar.classList.toggle(window.innerWidth <= 991 ? 'show' : 'hidden');
                if (window.innerWidth <= 991) overlay.classList.toggle('show', sidebar.classList.contains('show'));
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
    }
    setupStandardUI();

    // === 3. LOGIKA SPESIFIK HALAMAN PELATIHAN ===
    
    // Inisialisasi semua fungsi spesifik
    setupPelatihanModals();
    setupDelegatedEventListeners();
    setupUploadArea();
    
    // Konfigurasi Modal Tambah/Edit (Bootstrap 5)
    function setupPelatihanModals() {
        const pelatihanModalEl = document.getElementById('pelatihanModal');
        if (!pelatihanModalEl) return;
        
        const modalTitle = pelatihanModalEl.querySelector('.modal-title');
        const pelatihanForm = document.getElementById('pelatihanForm');
        const bsModal = new bootstrap.Modal(pelatihanModalEl);

        pelatihanModalEl.addEventListener('show.bs.modal', (event) => {
            const button = event.relatedTarget;
            const isEditMode = button && button.classList.contains('btn-edit');
            
            modalTitle.innerHTML = isEditMode 
                ? '<i class="fas fa-edit"></i> Edit Data Pelatihan' 
                : '<i class="fas fa-plus-circle"></i> Tambah Data Pelatihan';

            if (!isEditMode) {
                pelatihanForm?.reset();
                document.getElementById('anggota-list').innerHTML = '';
                pelatihanModalEl.querySelector('.upload-area')?.reset();
            }
        });

        // Aksi untuk tombol Simpan Data
        pelatihanModalEl.querySelector('.btn-success')?.addEventListener('click', () => {
            bsModal.hide();
            showSuccessModal('Data Berhasil Disimpan', 'Data pelatihan telah berhasil disimpan ke sistem.');
        });
    }

    // Mengelola semua klik pada tombol aksi dalam satu listener
    function setupDelegatedEventListeners() {
        const modalKonfirmasiHapus = document.getElementById('modalKonfirmasiHapus');
        let dataToDelete = null;

        const hideDeleteModal = () => {
            if (modalKonfirmasiHapus) modalKonfirmasiHapus.style.display = 'none';
        };

        document.body.addEventListener('click', function(event) {
            const target = event.target;

            // Tombol Hapus pada baris tabel
            if (target.closest('.btn-hapus')) {
                event.preventDefault();
                const row = target.closest('tr');
                dataToDelete = {
                    element: row,
                    nama: row?.querySelector('td:nth-child(2)')?.textContent.trim()
                };
                if (modalKonfirmasiHapus) modalKonfirmasiHapus.style.display = 'flex';
            }
            
            // Tombol "Ya, Hapus" di dalam modal konfirmasi
            if (target.matches('#btnKonfirmasiHapus')) {
                event.preventDefault();
                event.stopPropagation(); // FIX: Mencegah modal muncul lagi

                if (dataToDelete) {
                    console.log('Menghapus data:', dataToDelete.nama);
                    dataToDelete.element?.remove(); 
                    hideDeleteModal();
                    showSuccessModal('Data Berhasil Dihapus', `Data "${dataToDelete.nama}" telah berhasil dihapus.`);
                }
            }
            
            // Tombol "Batal" di modal hapus
            if (target.matches('#btnBatalHapus')) {
                hideDeleteModal();
            }

            // Tombol lihat detail
            const detailButton = target.closest('.btn-lihat-detail-pelatihan');
            if (detailButton) {
                // [FIX] Mengembalikan semua baris kode untuk menampilkan data detail
                const data = detailButton.dataset;
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
                document.getElementById('detail_pelatihan_document_viewer')?.setAttribute('src', data.dokumen_path || '');
            }

            // Hapus anggota dari list dinamis
            if (target.closest('.dynamic-row-close-btn')) {
                target.closest('.dynamic-row').remove();
            }

            // Klik area upload
            if (target.closest('.upload-area')) {
                target.closest('.upload-area').querySelector('input[type="file"]')?.click();
            }
        });

        // Klik di luar area modal untuk menutup
        modalKonfirmasiHapus?.addEventListener('click', (e) => {
            if (e.target === modalKonfirmasiHapus) hideDeleteModal();
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modalKonfirmasiHapus?.style.display === 'flex') {
                hideDeleteModal();
            }
        });
    }

    // Konfigurasi area upload file
    function setupUploadArea() {
        document.querySelectorAll('.upload-area').forEach(uploadArea => {
            const fileInput = uploadArea.querySelector('input[type="file"]');
            const uploadText = uploadArea.querySelector('p');
            if (!fileInput || !uploadText) return;
            const originalText = uploadText.innerHTML;
            
            fileInput.addEventListener('change', function () {
                if (this.files.length > 0) uploadText.textContent = this.files[0].name;
            });
            
            uploadArea.reset = () => {
                uploadText.innerHTML = originalText;
                fileInput.value = '';
            };
        });
    }
});

// === 4. FUNGSI GLOBAL: DIPANGGIL DARI HTML (onclick) ===
function addAnggota() {
    const list = document.getElementById('anggota-list');
    if (!list) return;
    const newRow = document.createElement('div');
    newRow.className = 'dynamic-row position-relative border rounded p-3 pt-4 mb-2';
    newRow.innerHTML = `
        <button type="button" class="btn-close dynamic-row-close-btn position-absolute top-0 end-0 p-2" aria-label="Close"></button>
        <div class="row g-2">
            <div class="col-12"><label class="form-label form-label-sm">Nama Anggota</label><input type="text" class="form-control form-control-sm" placeholder="Nama Anggota"></div>
            <div class="col-md-6"><label class="form-label form-label-sm">Angkatan</label><input type="text" class="form-control form-control-sm" placeholder="Angkatan"></div>
            <div class="col-md-6"><label class="form-label form-label-sm">Predikat</label><input type="text" class="form-control form-control-sm" placeholder="Predikat"></div>
        </div>
    `;
    list.appendChild(newRow);
}