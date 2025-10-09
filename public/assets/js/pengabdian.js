document.addEventListener("DOMContentLoaded", () => {
    // == Inisialisasi Elemen dan Variabel Global ==
    const pengabdianModalEl = document.getElementById("pengabdianModal");
    const pengabdianModalInstance = pengabdianModalEl ? new bootstrap.Modal(pengabdianModalEl) : null;
    const detailModalEl = document.getElementById('pengabdianDetailModal');
    const detailContentEl = document.getElementById('detail-content');
    const modalBerhasilEl = document.getElementById("modalBerhasil");
    const berhasilTitle = document.getElementById("berhasil-title");
    const berhasilSubtitle = document.getElementById("berhasil-subtitle");
    const confirmDeleteModalEl = document.getElementById("modalKonfirmasiHapus");
    const confirmDeleteBtn = document.getElementById("btnKonfirmasiHapus");
    const cancelDeleteBtn = document.getElementById("btnBatalHapus");
    const verifModalEl = document.getElementById("modalKonfirmasiVerifikasi");
    const verifTerimaBtn = document.getElementById("popupBtnTerima");
    const verifTolakBtn = document.getElementById("popupBtnTolak");
    const verifKembaliBtn = document.getElementById("popupBtnKembali");
    const form = document.getElementById('pengabdianForm');
    const simpanBtn = document.getElementById('simpanPengabdianBtn');
    const modalTitle = document.getElementById("pengabdianModalLabel");
    const formMethodInput = document.getElementById('form-method');
    const formEditIdInput = document.getElementById('form-edit-id');
    const successSound = new Audio("/assets/sounds/success.mp3");
    let recordIdToDelete = null;
    let dosenCounter = 0, mahasiswaCounter = 0, kolaboratorCounter = 0;
    const pegawaiMeta = document.querySelector('meta[name="pegawai-data"]');
    const pegawaiData = pegawaiMeta ? JSON.parse(pegawaiMeta.content) : [];

    // == Fungsi Utilitas ==
    const setButtonLoading = (button, isLoading, loadingText = "Memproses...") => {
        if (!button) return;
        if (isLoading) {
            if (!button.dataset.originalHtml) button.dataset.originalHtml = button.innerHTML;
            button.disabled = true;
            button.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> ${loadingText}`;
        } else {
            button.disabled = false;
            if (button.dataset.originalHtml) {
                button.innerHTML = button.dataset.originalHtml;
                delete button.dataset.originalHtml;
            }
        }
    };

    const showSuccessModal = (title, subtitle) => {
        if (!modalBerhasilEl) return;
        berhasilTitle.textContent = title;
        berhasilSubtitle.textContent = subtitle;
        modalBerhasilEl.classList.add('show');
        document.body.style.overflow = 'hidden';
        successSound.play().catch(err => console.error("Gagal memutar audio:", err));
        setTimeout(hideSuccessModal, 1200);
    };

    const hideSuccessModal = () => {
        if (modalBerhasilEl) modalBerhasilEl.classList.remove('show');
        if (!document.querySelector('.modal.show, .konfirmasi-hapus-overlay.show, .verifikasi-overlay.show')) {
            document.body.style.overflow = '';
        }
    };

    const showConfirmDeleteModal = () => confirmDeleteModalEl?.classList.add('show');
    const hideConfirmDeleteModal = () => confirmDeleteModalEl?.classList.remove('show');

    const showVerifModal = () => verifModalEl?.classList.add('show');
    const hideVerifModal = () => {
        if (verifModalEl) {
            verifModalEl.classList.remove('show');
            verifModalEl.removeAttribute('data-record-id');
        }
    };

    // == Event Listener untuk Modal Kustom ==
    const setupModalListeners = () => {
        document.getElementById("btnSelesai")?.addEventListener("click", hideSuccessModal, { once: true });
        cancelDeleteBtn?.addEventListener('click', hideConfirmDeleteModal);
        confirmDeleteModalEl?.addEventListener('click', e => {
            if (e.target === confirmDeleteModalEl) hideConfirmDeleteModal();
        });
        verifKembaliBtn?.addEventListener('click', hideVerifModal);
        verifModalEl?.addEventListener('click', e => {
            if (e.target === verifModalEl) hideVerifModal();
        });
    };

    // == Event Delegation untuk Tombol Aksi ==
    const setupActionButtons = () => {
        document.body.addEventListener('click', async (event) => {
            const target = event.target;

            const editButton = target.closest('.btn-edit');
            if (editButton) {
                event.preventDefault();
                const id = editButton.getAttribute('data-id');
                resetModal();
                modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Pengabdian';
                formMethodInput.value = 'PATCH';
                formEditIdInput.value = id;
                try {
                    const response = await fetch(`/pengabdian/${id}/edit`);
                    if (!response.ok) throw new Error('Gagal memuat data untuk diedit.');
                    const data = await response.json();
                    populateEditForm(data);
                    pengabdianModalInstance.show();
                } catch (error) {
                    alert(error.message);
                }
            }

            const deleteButton = target.closest('.btn-hapus');
            if (deleteButton) {
                event.preventDefault();
                recordIdToDelete = deleteButton.getAttribute('data-id');
                showConfirmDeleteModal();
            }

            const verifButton = target.closest('.btn-verifikasi');
            if (verifButton) {
                event.preventDefault();
                const id = verifButton.getAttribute('data-id');
                verifModalEl.setAttribute('data-record-id', id);
                showVerifModal();
            }

            if (target.closest('.dynamic-row-close-btn')) {
                target.closest('.dynamic-row').remove();
            }
        });
    };

    // == Logika Aksi AJAX ==
    const setupAjaxActions = () => {
        confirmDeleteBtn?.addEventListener('click', async () => {
            if (!recordIdToDelete) return;
            setButtonLoading(confirmDeleteBtn, true, 'Menghapus...');
            try {
                const response = await fetch(`/pengabdian/${recordIdToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                });
                const result = await response.json();
                if (!response.ok) throw new Error(result.error || 'Gagal menghapus data.');
                hideConfirmDeleteModal();
                showSuccessModal("Data Berhasil Dihapus", result.success);
                setTimeout(() => location.reload(), 1300);
            } catch (error) {
                alert(error.message);
            } finally {
                setButtonLoading(confirmDeleteBtn, false);
            }
        });

        simpanBtn?.addEventListener('click', async () => {
            const isEditMode = formEditIdInput.value !== '';
            const id = formEditIdInput.value;
            const url = isEditMode ? `/pengabdian/${id}` : '/pengabdian';
            const formData = new FormData(form);
            setButtonLoading(simpanBtn, true, 'Menyimpan...');
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                });
                const result = await response.json();
                if (!response.ok) {
                    if (response.status === 422) {
                        alert('Data tidak valid. Periksa kembali semua isian Anda.');
                    } else {
                        throw new Error(result.error || 'Gagal menyimpan data.');
                    }
                } else {
                    pengabdianModalInstance.hide();
                    showSuccessModal(result.success, isEditMode ? "Data telah berhasil diperbarui." : "Data telah berhasil disimpan.");
                    setTimeout(() => location.reload(), 1300);
                }
            } catch (error) {
                console.error('Submission error:', error);
                alert('Terjadi kesalahan: ' + error.message);
            } finally {
                setButtonLoading(simpanBtn, false);
                simpanBtn.innerHTML = isEditMode ? 'Update' : 'Simpan';
            }
        });

        const handleVerification = async (newStatus) => {
            const recordId = verifModalEl.getAttribute('data-record-id');
            if (!recordId) return;
            const btn = newStatus === 'Sudah Diverifikasi' ? verifTerimaBtn : verifTolakBtn;
            setButtonLoading(btn, true);
            try {
                const response = await fetch(`/pengabdian/${recordId}/verifikasi`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ status: newStatus }),
                });
                const result = await response.json();
                if (!response.ok) throw new Error(result.error || 'Gagal memproses verifikasi.');
                hideVerifModal();
                showSuccessModal("Status Verifikasi Disimpan", result.success);
                setTimeout(() => location.reload(), 1300);
            } catch (error) {
                alert(error.message);
            } finally {
                setButtonLoading(btn, false);
            }
        };

        verifTerimaBtn?.addEventListener('click', () => handleVerification('Sudah Diverifikasi'));
        verifTolakBtn?.addEventListener('click', () => handleVerification('Ditolak'));
    };

    // == Pengelolaan Modal Detail ==
    const setupDetailModal = () => {
        detailModalEl?.addEventListener('show.bs.modal', async (event) => {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            detailContentEl.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
            try {
                const response = await fetch(`/pengabdian/${id}`);
                if (!response.ok) throw new Error('Gagal mengambil data detail.');
                const data = await response.json();
                populateDetailModal(data);
            } catch (error) {
                detailContentEl.innerHTML = `<p class="text-center text-danger">${error.message}</p>`;
            }
        });
    };

    // == Pengelolaan Upload Area ==
    const initUploadArea = () => {
        document.querySelectorAll(".upload-area").forEach((uploadArea) => {
            const fileInput = uploadArea.querySelector('input[type="file"]');
            const uploadText = uploadArea.querySelector("p");
            if (!fileInput || !uploadText) return;
            const originalHTML = uploadText.innerHTML;

            uploadArea.addEventListener("click", () => fileInput.click());
            fileInput.addEventListener("change", () => {
                if (fileInput.files.length > 0) {
                    uploadText.textContent = fileInput.files[0].name;
                }
            });

            uploadArea.reset = () => {
                uploadText.innerHTML = originalHTML;
                fileInput.value = "";
            };
        });
    };

    // == Pengelolaan Form Edit ==
    const populateEditForm = (data) => {
        form.querySelector('[name="kegiatan"]').value = data.kegiatan || '';
        form.querySelector('[name="nama_kegiatan"]').value = data.nama_kegiatan || '';
        form.querySelector('[name="afiliasi_non_pt"]').value = data.afiliasi_non_pt || '';
        form.querySelector('[name="lokasi"]').value = data.lokasi || '';
        form.querySelector('[name="jenis_pengabdian"]').value = data.jenis_pengabdian || '';
        form.querySelector('[name="tahun_usulan"]').value = data.tahun_usulan || '';
        form.querySelector('[name="tahun_kegiatan"]').value = data.tahun_kegiatan || '';
        form.querySelector('[name="tahun_pelaksanaan"]').value = data.tahun_pelaksanaan || '';
        form.querySelector('[name="tgl_mulai"]').value = data.tgl_mulai || '';
        form.querySelector('[name="tgl_selesai"]').value = data.tgl_selesai || '';
        form.querySelector('[name="lama_kegiatan"]').value = data.lama_kegiatan || '';
        form.querySelector('[name="in_kind"]').value = data.in_kind || '';
        form.querySelector('[name="no_sk_penugasan"]').value = data.no_sk_penugasan || '';
        form.querySelector('[name="tgl_sk_penugasan"]').value = data.tgl_sk_penugasan || '';
        form.querySelector('[name="litabmas"]').value = data.litabmas || '';
        form.querySelector('[name="dana_dikti"]').value = data.dana_dikti || '';
        form.querySelector('[name="dana_pt"]').value = data.dana_pt || '';
        form.querySelector('[name="dana_institusi_lain"]').value = data.dana_institusi_lain || '';
        if (data.dokumen && data.dokumen.length > 0) {
            const doc = data.dokumen[0];
            form.querySelector('[name="jenis_dokumen"]').value = doc.jenis_dokumen || '';
            const uploadAreaP = form.querySelector('.upload-area p');
            uploadAreaP.innerHTML = `File tersimpan: ${doc.nama_file}<br><small>Upload file baru untuk mengganti</small>`;
        }
        data.anggota.forEach(anggota => addAnggota(anggota.jenis, anggota));
    };

    // == Pengelolaan Modal Detail ==
    const populateDetailModal = (data) => {
        const formatDate = (dateString) => dateString ? new Date(dateString).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : '-';
        const formatCurrency = (number) => number ? new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number) : '-';
        const dosen = data.anggota.filter(a => a.jenis === 'dosen');
        const mahasiswa = data.anggota.filter(a => a.jenis === 'mahasiswa');
        let dosenHtml = '<p class="fst-italic text-muted">Tidak ada anggota dosen.</p>';
        if (dosen.length > 0) {
            dosenHtml = dosen.map(d => `
                <div class="detail-grid-container nested full-width-detail">
                    <div class="detail-item"><small>Nama Dosen</small><p>${d.pegawai ? d.pegawai.nama_lengkap : 'N/A'}</p></div>
                    <div class="detail-item"><small>Jabatan</small><p>${d.jabatan || '-'}</p></div>
                    <div class="detail-item"><small>Status</small><p>${d.status_aktif || '-'}</p></div>
                </div>`).join('');
        }
        let mahasiswaHtml = '<p class="fst-italic text-muted">Tidak ada anggota mahasiswa.</p>';
        if (mahasiswa.length > 0) {
            mahasiswaHtml = mahasiswa.map(m => `
                <div class="detail-grid-container nested full-width-detail">
                    <div class="detail-item"><small>Nama Mahasiswa</small><p>${m.nama || '-'}</p></div>
                    <div class="detail-item"><small>Jabatan</small><p>${m.jabatan || '-'}</p></div>
                    <div class="detail-item"><small>Status</small><p>${m.status_aktif || '-'}</p></div>
                </div>`).join('');
        }
        let dokumenHtml = '<p class="fst-italic text-muted">Tidak ada dokumen.</p>';
        if (data.dokumen && data.dokumen.length > 0) {
            const doc = data.dokumen[0];
            const fileUrl = doc.file_path.startsWith('http') ? doc.file_path : `/storage/${doc.file_path}`;
            dokumenHtml = `
                <div class="detail-grid-container nested full-width-detail">
                    <div class="detail-item"><small>Jenis Dokumen</small><p>${doc.jenis_dokumen || '-'}</p></div>
                    <div class="detail-item"><small>Nama File</small><p>${doc.nama_file || '-'}</p></div>
                    <div class="detail-item"><small>File Dokumen</small><div class="file-actions-buttons"><a href="${fileUrl}" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-file-alt me-2"></i>Lihat Dokumen</a></div></div>
                </div>`;
        }
        detailContentEl.innerHTML = `
            <div class="detail-item full-width-detail"><small>Judul Kegiatan</small><p>${data.nama_kegiatan || '-'}</p></div>
            <div class="detail-item"><small>Afiliasi Non-PT</small><p>${data.afiliasi_non_pt || '-'}</p></div>
            <div class="detail-item"><small>Jenis Pengabdian</small><p>${data.jenis_pengabdian || '-'}</p></div>
            <div class="detail-item"><small>Lama Kegiatan</small><p>${data.lama_kegiatan || '-'}</p></div>
            <div class="detail-item"><small>Tahun Pelaksanaan</small><p>${data.tahun_pelaksanaan || '-'}</p></div>
            <div class="detail-item"><small>No. SK Penugasan</small><p>${data.no_sk_penugasan || '-'}</p></div>
            <div class="detail-item"><small>Tanggal SK</small><p>${formatDate(data.tgl_sk_penugasan)}</p></div>
            <div class="detail-item"><small>Dana DIKTI</small><p>${formatCurrency(data.dana_dikti)}</p></div>
            <div class="detail-item"><small>Dana PT</small><p>${formatCurrency(data.dana_pt)}</p></div>
            <div class="detail-item"><small>Dana Lain</small><p>${formatCurrency(data.dana_institusi_lain)}</p></div>
            <div class="detail-item full-width-detail detail-section-header"><h5>Anggota Dosen</h5></div>${dosenHtml}
            <div class="detail-item full-width-detail detail-section-header"><h5>Anggota Mahasiswa</h5></div>${mahasiswaHtml}
            <div class="detail-item full-width-detail detail-section-header"><h5>Dokumen</h5></div>${dokumenHtml}`;
    };

    // == Pengelolaan Anggota Dinamis ==
    window.addAnggota = (type, data = null) => {
        const listId = `${type}-list`;
        const container = document.getElementById(listId);
        if (!container) return;
        const newRow = document.createElement('div');
        newRow.className = 'dynamic-row position-relative';
        let content = '';

        switch (type) {
            case "dosen":
                let pegawaiOptions = '<option selected disabled value="">-- Pilih Dosen --</option>';
                if (pegawaiData) {
                    pegawaiOptions += pegawaiData.map(p => `<option value="${p.id}">${p.nama_lengkap}</option>`).join('');
                }
                content = `
                    <div class="row g-2">
                        <div class="col-12 position-relative">
                            <select class="form-select form-select-sm dosen-select" name="dosen[${dosenCounter}][pegawai_id]" required>
                                ${pegawaiOptions}
                            </select>
                            <button type="button" class="btn btn-sm dynamic-row-close-btn" style="position:absolute; top:5px; right:5px; z-index:1100;">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <div class="col-md-6">
                            <select class="form-select form-select-sm" name="dosen[${dosenCounter}][jabatan]">
                                <option>Ketua</option>
                                <option>Anggota</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-select form-select-sm" name="dosen[${dosenCounter}][status_aktif]">
                                <option>Ya</option>
                                <option>Aktif</option>
                            </select>
                        </div>
                    </div>`;
                newRow.innerHTML = content;
                const selectEl = newRow.querySelector('.dosen-select');
                if (selectEl) {
                    $(selectEl).select2({
                        theme: 'bootstrap-5',
                        placeholder: '-- Pilih Dosen --',
                        allowClear: true,
                        width: '100%',
                        dropdownParent: $('#pengabdianModal .modal-content')
                    });
                }
                if (data) {
                    newRow.querySelector('[name*="[pegawai_id]"]').value = data.pegawai_id;
                    newRow.querySelector('[name*="[jabatan]"]').value = data.jabatan;
                    newRow.querySelector('[name*="[status_aktif]"]').value = data.status_aktif;
                    $(newRow.querySelector('.dosen-select')).trigger('change');
                }
                dosenCounter++;
                break;
            case "mahasiswa":
                content = `
                    <div class="row g-2">
                        <div class="col-md-6">
                            <select class="form-select form-select-sm" name="mahasiswa[${mahasiswaCounter}][strata]">
                                <option selected disabled value="">-- Strata --</option>
                                <option>D1</option><option>D2</option><option>D3</option><option>D4</option>
                                <option>S1</option><option>Profesi</option><option>S2</option><option>S3</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control form-control-sm" name="mahasiswa[${mahasiswaCounter}][nama]" placeholder="Nama Mahasiswa">
                        </div>
                        <div class="col-md-6">
                            <select class="form-select form-select-sm" name="mahasiswa[${mahasiswaCounter}][jabatan]">
                                <option>Ketua</option><option selected>Anggota</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-select form-select-sm" name="mahasiswa[${mahasiswaCounter}][status_aktif]">
                                <option>Ya</option><option selected>Aktif</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-sm dynamic-row-close-btn" style="position:absolute; top:5px; right:5px; z-index:1100;">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>`;
                newRow.innerHTML = content;
                if (data) {
                    newRow.querySelector('[name*="[strata]"]').value = data.strata;
                    newRow.querySelector('[name*="[nama]"]').value = data.nama;
                    newRow.querySelector('[name*="[jabatan]"]').value = data.jabatan;
                    newRow.querySelector('[name*="[status_aktif]"]').value = data.status_aktif;
                }
                mahasiswaCounter++;
                break;
            case "kolaborator":
                content = `
                    <div class="row g-2">
                        <div class="col-12">
                            <input type="text" class="form-control form-control-sm" name="kolaborator[${kolaboratorCounter}][nama]" placeholder="Nama Kolaborator">
                        </div>
                        <div class="col-md-6">
                            <select class="form-select form-select-sm" name="kolaborator[${kolaboratorCounter}][jabatan]">
                                <option>Ketua</option><option selected>Anggota</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-select form-select-sm" name="kolaborator[${kolaboratorCounter}][status_aktif]">
                                <option>Ya</option><option selected>Aktif</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-sm dynamic-row-close-btn" style="position:absolute; top:5px; right:5px; z-index:1100;">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>`;
                newRow.innerHTML = content;
                if (data) {
                    newRow.querySelector('[name*="[nama]"]').value = data.nama;
                    newRow.querySelector('[name*="[jabatan]"]').value = data.jabatan;
                    newRow.querySelector('[name*="[status_aktif]"]').value = data.status_aktif;
                }
                kolaboratorCounter++;
                break;
        }
        container.appendChild(newRow);
    };

    // == Pengelolaan Modal Tambah ==
    window.openModal = () => {
        if (!pengabdianModalInstance) return;
        resetModal();
        modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Pengabdian';
        pengabdianModalInstance.show();
    };

    const resetModal = () => {
        form.reset();
        formMethodInput.value = 'POST';
        formEditIdInput.value = '';
        document.querySelectorAll(".upload-area").forEach(area => area.reset());
        document.getElementById('dosen-list').innerHTML = '';
        document.getElementById('mahasiswa-list').innerHTML = '';
        document.getElementById('kolaborator-list').innerHTML = '';
        dosenCounter = 0;
        mahasiswaCounter = 0;
        kolaboratorCounter = 0;
    };

    pengabdianModalEl?.addEventListener('hidden.bs.modal', resetModal);

    // == Pengelolaan Filter Form ==
    const setupFilterForm = () => {
        const filterForm = document.getElementById('filter-form');
        if (!filterForm) return;
        const debounce = (func, delay) => {
            let timeoutId;
            const cancel = () => clearTimeout(timeoutId);
            const debounced = (...args) => {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(() => func.apply(this, args), delay);
            };
            debounced.cancel = cancel;
            return debounced;
        };

        const debouncedSubmit = debounce(() => filterForm.submit(), 500);

        filterForm.querySelectorAll('.filter-select').forEach(select => {
            select.addEventListener('change', () => filterForm.submit());
        });

        const searchInput = filterForm.querySelector('.search-input');
        if (searchInput) {
            searchInput.addEventListener('keyup', (event) => {
                if (event.key === 'Enter') {
                    debouncedSubmit.cancel?.();
                    filterForm.submit();
                } else {
                    debouncedSubmit();
                }
            });
        }
    };

    // == Peningkatan Datepicker ==
    const enhanceDatepickers = () => {
        document.querySelectorAll('input[type="date"]').forEach((el) => {
            el.style.cursor = "pointer";
            el.addEventListener("click", function () {
                this.showPicker && this.showPicker();
            });
        });
    };

    // == Inisialisasi ==
    const initialize = () => {
        initUploadArea();
        setupModalListeners();
        setupActionButtons();
        setupAjaxActions();
        setupDetailModal();
        setupFilterForm();
        enhanceDatepickers();
    };

    // Jalankan inisialisasi
    initialize();
});