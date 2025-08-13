document.addEventListener('DOMContentLoaded', function () {
    // === Sidebar Logic (Tidak Berubah) ===
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

    // === Date and Time Logic (Tidak Berubah) ===
    function updateDateTime() {
        const now = new Date();
        const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false, timeZone: 'Asia/Jakarta' };
        const dateEl = document.getElementById('current-date');
        const timeEl = document.getElementById('current-time');
        if (dateEl && timeEl) {
            dateEl.textContent = now.toLocaleDateString('id-ID', dateOptions);
            timeEl.textContent = now.toLocaleTimeString('id-ID', timeOptions);
        }
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);

    // === File Upload Logic (Tidak Berubah) ===
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

    // =================================================================
    // === LOGIKA BARU MENGGUNAKAN EVENT LISTENER BOOTSTRAP ===
    // =================================================================

    // 1. Logika untuk Modal Tambah/Edit Penghargaan
    const penghargaanModal = document.getElementById('penghargaanModal');
    if (penghargaanModal) {
        penghargaanModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Tombol yang diklik
            const modalTitle = penghargaanModal.querySelector('.modal-title');
            const penghargaanForm = document.getElementById('penghargaanForm');

            // Cek apakah tombol Edit yang diklik
            if (button && button.classList.contains('btn-edit')) {
                modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Penghargaan';
                // Di sini Anda bisa menambahkan kode untuk mengisi form dengan data dari tombol edit
                // Contoh: document.querySelector('#penghargaanModal input[...]).value = button.dataset.nama;
            } else { // Jika bukan, berarti tombol Tambah
                modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Penghargaan';
                // Kosongkan form saat menambah data baru
                if (penghargaanForm) {
                    penghargaanForm.reset();
                }
                // Reset juga area upload
                const uploadArea = penghargaanModal.querySelector('.upload-area');
                if (uploadArea && typeof uploadArea.reset === 'function') {
                    uploadArea.reset();
                }
            }
        });
    }

    // 2. Logika untuk Modal Detail Penghargaan
    const tableBody = document.querySelector('#penghargaan-table-body'); 
    if (tableBody) {
        tableBody.addEventListener('click', function(event) {
            const detailButton = event.target.closest('.btn-lihat-detail-penghargaan');
            
            if (detailButton) {
                const data = detailButton.dataset;
                // Mengisi data utama
                document.getElementById('detail_penghargaan_pegawai').textContent = data.pegawai || '-';
                document.getElementById('detail_penghargaan_kegiatan').textContent = data.kegiatan || '-';
                document.getElementById('detail_penghargaan_nama_penghargaan').textContent = data.nama_penghargaan || '-';
                document.getElementById('detail_penghargaan_nomor').textContent = data.nomor || '-';
                document.getElementById('detail_penghargaan_tanggal_perolehan').textContent = data.tanggal_perolehan || '-';
                document.getElementById('detail_penghargaan_lingkup').textContent = data.lingkup || '-';
                document.getElementById('detail_penghargaan_negara').textContent = data.negara || '-';
                document.getElementById('detail_penghargaan_instansi').textContent = data.instansi || '-';

                // Mengisi data dokumen
                document.getElementById('detail_penghargaan_jenis_dokumen').textContent = data.jenis_dokumen || '-';
                document.getElementById('detail_penghargaan_nama_dokumen').textContent = data.nama_dokumen || '-';
                document.getElementById('detail_penghargaan_nomor_dokumen').textContent = data.nomor_dokumen || '-';
                document.getElementById('detail_penghargaan_tautan').textContent = data.tautan || '-';

                // Memperbarui viewer dokumen
                const docViewer = document.getElementById('detail_penghargaan_document_viewer');
                if (docViewer) {
                    docViewer.setAttribute('src', data.dokumen_path || '');
                }
            }
        });
    }

    // === 3. Logika untuk Modal Konfirmasi Hapus ===
    const modalKonfirmasiHapus = document.getElementById('modalKonfirmasiHapus');
    const btnKonfirmasiHapus = document.getElementById('btnKonfirmasiHapus');
    const btnBatalHapus = document.getElementById('btnBatalHapus');
    let dataToDelete = null;

    // Fungsi untuk menampilkan modal hapus
    function showDeleteModal() {
        if (modalKonfirmasiHapus) {
            modalKonfirmasiHapus.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    // Fungsi untuk menyembunyikan modal hapus
    function hideDeleteModal() {
        if (modalKonfirmasiHapus) {
            modalKonfirmasiHapus.style.display = 'none';
            document.body.style.overflow = '';
        }
    }

    // Event delegation untuk tombol hapus
    document.addEventListener('click', function(event) {
        const deleteButton = event.target.closest('.btn-hapus');
        if (deleteButton) {
            event.preventDefault();
            // Simpan data yang akan dihapus
            const row = deleteButton.closest('tr');
            dataToDelete = {
                id: deleteButton.dataset.id || row?.querySelector('td:first-child')?.textContent,
                nama: deleteButton.dataset.nama || row?.querySelector('td:nth-child(2)')?.textContent,
                element: row
            };
            // Tampilkan modal konfirmasi
            showDeleteModal();
        }
    });

    // Handler untuk tombol konfirmasi hapus
    if (btnKonfirmasiHapus) {
        btnKonfirmasiHapus.addEventListener('click', function() {
            if (dataToDelete) {
                // Lakukan penghapusan data (AJAX atau lainnya)
                console.log('Menghapus data:', dataToDelete);
                
                // Contoh AJAX call:
                /*
                fetch(`/api/penghargaan/${dataToDelete.id}`, {
                    method: 'DELETE'
                })
                .then(response => {
                    if (response.ok) {
                        // Hapus baris dari tabel jika sukses
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