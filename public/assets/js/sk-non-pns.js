document.addEventListener('DOMContentLoaded', function () {

    // === 1. HELPER: Modal Bootstrap Handler ===
    function showBootstrapModal(elementId) {
        const el = document.getElementById(elementId);
        if (el) {
            const modal = new bootstrap.Modal(el);
            modal.show();
            return modal;
        }
        return null;
    }

    function hideBootstrapModal(modalInstance) {
        if (modalInstance) modalInstance.hide();
    }

    // === 2. HELPER: Modal Berhasil (Success) ===
    const modalBerhasil = document.getElementById('modalBerhasil');
    const berhasilTitle = document.getElementById('berhasil-title');
    const berhasilSubtitle = document.getElementById('berhasil-subtitle');
    let successModalTimeout = null;
    let successAudio = null;

    function showSuccessModal(title, subtitle) {
        if (!modalBerhasil || !berhasilTitle || !berhasilSubtitle) return;

        berhasilTitle.textContent = title;
        berhasilSubtitle.textContent = subtitle;
        modalBerhasil.classList.add('show');

        // Audio sukses
        if (successAudio) {
            successAudio.pause();
            successAudio.currentTime = 0;
        }
        successAudio = new Audio('/assets/sounds/success.mp3');
        successAudio.play().catch(err => console.warn('Gagal memutar audio:', err));

        clearTimeout(successModalTimeout);
        successModalTimeout = setTimeout(hideSuccessModal, 1200);
    }

    function hideSuccessModal() {
        modalBerhasil?.classList.remove('show');
        if (successAudio) {
            successAudio.pause();
            successAudio.currentTime = 0;
        }
    }

    document.getElementById('btnSelesai')?.addEventListener('click', () => {
        clearTimeout(successModalTimeout);
        hideSuccessModal();
    });

    // === 3. HELPER: Upload Area ===
    function initUploadAreas() {
        document.querySelectorAll('.upload-area').forEach(uploadArea => {
            const fileInput = uploadArea.querySelector('input[type="file"]');
            const uploadText = uploadArea.querySelector('p');
            if (!fileInput || !uploadText) return;

            const originalText = uploadText.innerHTML;
            uploadArea.addEventListener('click', () => fileInput.click());
            fileInput.addEventListener('change', function () {
                uploadText.textContent = this.files.length ? this.files[0].name : originalText;
            });

            uploadArea.reset = () => {
                uploadText.innerHTML = originalText;
                fileInput.value = '';
            };
        });
    }
    initUploadAreas();

    // === 4. Modal SK Non PNS (Tambah/Edit) ===
    const skNonPnsModalEl = document.getElementById('skNonPnsModal');
    if (skNonPnsModalEl) {
        const bsModal = new bootstrap.Modal(skNonPnsModalEl);

        skNonPnsModalEl.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const modalTitle = skNonPnsModalEl.querySelector('.modal-title');
            const isEditMode = button?.classList.contains('btn-edit');

            modalTitle.innerHTML = isEditMode
                ? '<i class="fas fa-edit"></i> Edit Data SK Non PNS'
                : '<i class="fas fa-plus-circle"></i> Tambah Data SK Non PNS';

            if (!isEditMode) {
                document.getElementById('skNonPnsForm')?.reset();
                skNonPnsModalEl.querySelector('.upload-area')?.reset();
            }
        });

        skNonPnsModalEl.querySelector('.btn-success')?.addEventListener('click', () => {
            bsModal.hide();
            showSuccessModal('Data Berhasil Disimpan', 'Data SK Non PNS telah berhasil disimpan.');
        });
    }

    // === 5. Modal Konfirmasi Hapus ===
    const modalKonfirmasiHapusEl = document.getElementById('modalKonfirmasiHapus');
    let dataToDelete = null;
    let bsDeleteModal = modalKonfirmasiHapusEl ? new bootstrap.Modal(modalKonfirmasiHapusEl) : null;

    document.body.addEventListener('click', function (event) {
        const target = event.target;

        // Tombol Lihat Detail
        const detailButton = target.closest('.btn-lihat-detail-sk');
        if (detailButton) {
            event.preventDefault();
            const data = detailButton.dataset;
            const setText = (id, value) => {
                const el = document.getElementById(id);
                if (el) el.textContent = value || '-';
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

        // Tombol Hapus
        if (target.closest('.btn-hapus')) {
            event.preventDefault();
            const row = target.closest('tr');
            dataToDelete = {
                element: row,
                nama: row?.querySelector('td:nth-child(2)')?.textContent.trim()
            };
            bsDeleteModal?.show();
        }

        // Konfirmasi Hapus
        if (target.matches('#btnKonfirmasiHapus')) {
            event.preventDefault();
            if (dataToDelete) {
                dataToDelete.element?.remove();
                bsDeleteModal?.hide();
                showSuccessModal('Data Berhasil Dihapus', `Data "${dataToDelete.nama}" telah berhasil dihapus.`);
            }
        }

        // Batal Hapus
        if (target.matches('#btnBatalHapus')) {
            bsDeleteModal?.hide();
        }
    });
});