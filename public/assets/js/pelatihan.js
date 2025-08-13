// Menunggu seluruh konten halaman dimuat sebelum menjalankan skrip
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

    // === Logic untuk Hapus Anggota (Tidak Berubah) ===
    const anggotaListContainer = document.getElementById('anggota-list');
    if (anggotaListContainer) {
        anggotaListContainer.addEventListener('click', function(event) {
            if (event.target.closest('.dynamic-row-close-btn')) {
                event.target.closest('.dynamic-row').remove();
            }
        });
    }

    // === Logic untuk Area Upload File (Tidak Berubah) ===
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

    // === Logic untuk Modal Tambah/Edit Pelatihan (Tidak Berubah) ===
    const pelatihanModal = document.getElementById('pelatihanModal');
    if (pelatihanModal) {
        const modalTitle = pelatihanModal.querySelector('.modal-title');
        const pelatihanForm = document.getElementById('pelatihanForm');

        pelatihanModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;

            if (button && button.classList.contains('btn-edit')) {
                modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Pelatihan';
            } else {
                modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Pelatihan';
                
                if (pelatihanForm) {
                    pelatihanForm.reset();
                }
                
                const anggotaList = document.getElementById('anggota-list');
                if (anggotaList) {
                    anggotaList.innerHTML = '';
                }

                const uploadArea = pelatihanModal.querySelector('.upload-area');
                if (uploadArea && typeof uploadArea.reset === 'function') {
                    uploadArea.reset();
                }
            }
        });
    }

    // === Logic untuk Modal Detail (Tidak Berubah) ===
    document.addEventListener('click', function(event) {
        const detailButton = event.target.closest('.btn-lihat-detail-pelatihan');
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
            if (docViewer) {
                docViewer.setAttribute('src', data.dokumen_path || '');
            }
        }
    });

    // === Logic untuk Modal Konfirmasi Hapus (Yang Diperbarui) ===
    const modalKonfirmasiHapus = document.getElementById('modalKonfirmasiHapus');
    const btnKonfirmasiHapus = document.getElementById('btnKonfirmasiHapus');
    const btnBatalHapus = document.getElementById('btnBatalHapus');
    let dataToDelete = null;

// Fungsi untuk menampilkan modal
function showDeleteModal() {
    const modal = document.getElementById('modalKonfirmasiHapus');
    if (modal) {
        modal.style.display = 'flex'; // Ubah ke flex
        document.body.style.overflow = 'hidden';
    }
}

// Fungsi untuk menyembunyikan modal
function hideDeleteModal() {
    const modal = document.getElementById('modalKonfirmasiHapus');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
}

// Event listener untuk tombol hapus
document.addEventListener('click', function(e) {
    if (e.target.closest('.btn-hapus')) {
        e.preventDefault();
        showDeleteModal();
    }
});

// Event listener untuk tombol batal
document.getElementById('btnBatalHapus')?.addEventListener('click', hideDeleteModal);

// Event listener untuk klik di luar modal
document.getElementById('modalKonfirmasiHapus')?.addEventListener('click', function(e) {
    if (e.target === this) {
        hideDeleteModal();
    }
});

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
                fetch(`/api/pelatihan/${dataToDelete.id}`, {
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
        if (event.key === 'Escape' && modalKonfirmasiHapus.style.display === 'block') {
            hideDeleteModal();
        }
    });
});

// === Fungsi Global yang Masih Diperlukan ===
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