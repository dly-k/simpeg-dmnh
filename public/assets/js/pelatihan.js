document.addEventListener('DOMContentLoaded', function () {
    // === 1. LOGIKA INTI: MODAL BERHASIL (SUCCESS MODAL) ===
    const modalBerhasil = document.getElementById('modalBerhasil');
    const berhasilTitle = document.getElementById('berhasil-title');
    const berhasilSubtitle = document.getElementById('berhasil-subtitle');
    const modalKonfirmasiHapus = document.getElementById('modalKonfirmasiHapus');
    const bsModal = new bootstrap.Modal(modalKonfirmasiHapus); // Inisialisasi Bootstrap Modal

    let successAudio = null; // Deklarasi variabel global untuk audio

    function showSuccessModal(title, subtitle) {
        if (modalBerhasil && berhasilTitle && berhasilSubtitle) {
            console.log('Menampilkan modal berhasil:', title, subtitle);
            berhasilTitle.textContent = title;
            berhasilSubtitle.textContent = subtitle;
            modalBerhasil.classList.add('show');
            bsModal.hide(); // Pastikan modal konfirmasi disembunyikan
            console.log('Modal Berhasil ditampilkan, classList:', modalBerhasil.classList);

            // Inisialisasi dan putar suara
            successAudio = new Audio('/assets/sounds/Success.mp3'); // Pastikan path benar
            successAudio.play().catch(error => {
                console.log('Error memutar suara:', error);
                if (error.name === 'NotAllowedError') {
                    console.log('Autoplay diblokir oleh browser. Butuh interaksi pengguna terlebih dahulu.');
                } else if (error.name === 'NotFoundError') {
                    console.log('File audio tidak ditemukan. Periksa path: /assets/sounds/success.mp3');
                } else {
                    console.log('Error lain:', error.message);
                }
            });

            // Tutup modal secara otomatis setelah 1 detik
            setTimeout(() => {
                console.log('Menutup modal berhasil setelah 1 detik');
                modalBerhasil.classList.remove('show');
                if (successAudio) {
                    successAudio.pause(); // Hentikan suara
                    successAudio.currentTime = 0; // Reset ke awal
                }
                bsModal.hide(); // Pastikan modal konfirmasi tetap disembunyikan
                const sidebarOverlay = document.getElementById('overlay');
                if (sidebarOverlay) sidebarOverlay.classList.remove('show');
            }, 1000);
        }
    }

    function hideSuccessModal() {
        if (modalBerhasil) {
            console.log('Menyembunyikan modal berhasil (manual), classList sebelum:', modalBerhasil.classList);
            modalBerhasil.classList.remove('show');
            if (successAudio) {
                successAudio.pause(); // Hentikan suara
                successAudio.currentTime = 0; // Reset ke awal
            }
            bsModal.hide(); // Pastikan modal konfirmasi disembunyikan
            const sidebarOverlay = document.getElementById('overlay');
            if (sidebarOverlay) sidebarOverlay.classList.remove('show');
        }
    }

    // === 2. LOGIKA STANDAR: SIDEBAR & JAM ===
    function setupStandardUI() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const toggleSidebarBtn = document.getElementById('toggleSidebar');
        if (toggleSidebarBtn && sidebar && overlay) {
            toggleSidebarBtn.addEventListener('click', () => {
                sidebar.classList.toggle(window.innerWidth <= 991 ? 'show' : 'hidden');
                overlay.classList.toggle('show', window.innerWidth <= 991 && sidebar.classList.contains('show'));
            });
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
        }
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
    function setupPelatihanModals() {
        const pelatihanModalEl = document.getElementById('pelatihanModal');
        if (!pelatihanModalEl) return;

        const modalTitle = pelatihanModalEl.querySelector('.modal-title');
        const pelatihanForm = document.getElementById('pelatihanForm');
        const bsPelatihanModal = new bootstrap.Modal(pelatihanModalEl);

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

        pelatihanModalEl.querySelector('.btn-success')?.addEventListener('click', () => {
            bsPelatihanModal.hide();
            showSuccessModal('Data Berhasil Disimpan', 'Data pelatihan telah berhasil disimpan ke sistem.');
        });
    }

    function setupDelegatedEventListeners() {
        let dataToDelete = null;

        document.body.addEventListener('click', function (event) {
            const target = event.target;

            // Tombol Hapus pada baris tabel
            if (target.closest('.btn-hapus')) {
                event.preventDefault();
                const row = target.closest('tr');
                dataToDelete = {
                    element: row,
                    nama: row?.querySelector('td:nth-child(2)')?.textContent.trim()
                };
                if (modalKonfirmasiHapus) {
                    console.log('Menampilkan modal konfirmasi hapus untuk:', dataToDelete.nama);
                    bsModal.show();
                }
            }

            // Tombol "Ya, Hapus" di dalam modal konfirmasi
            if (target.matches('#btnKonfirmasiHapus')) {
                event.preventDefault();
                event.stopPropagation();
                if (dataToDelete && modalKonfirmasiHapus) {
                    console.log('Menghapus data:', dataToDelete.nama);
                    dataToDelete.element?.remove();
                    bsModal.hide();
                    showSuccessModal('Data Berhasil Dihapus', `Data "${dataToDelete.nama}" telah berhasil dihapus.`);
                }
            }

            // Tombol "Batal" di modal hapus
            if (target.matches('#btnBatalHapus')) {
                if (modalKonfirmasiHapus) {
                    bsModal.hide();
                }
            }

            // Tombol "Selesai" di modal berhasil
            if (target.matches('#btnSelesai')) {
                hideSuccessModal();
            }

            // Tombol lihat detail
            const detailButton = target.closest('.btn-lihat-detail-pelatihan');
            if (detailButton) {
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
                const docViewer = document.getElementById('detail_pelatihan_document_viewer');
                if (docViewer) docViewer.setAttribute('src', data.dokumen_path || '');
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
    }

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

    // Inisialisasi semua fungsi spesifik
    setupPelatihanModals();
    setupDelegatedEventListeners();
    setupUploadArea();
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