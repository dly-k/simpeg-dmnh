document.addEventListener("DOMContentLoaded", () => {
    // Fungsi bantu untuk menambahkan spinner pada tombol
    const addSpinner = (button, text = 'Menyimpan...') => {
        button.disabled = true;
        button.dataset.originalHtml = button.innerHTML;
        button.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>${text}`;
    };

    // Fungsi bantu untuk menghapus spinner dari tombol
    const removeSpinner = (button) => {
        button.disabled = false;
        button.innerHTML = button.dataset.originalHtml;
    };

    // === BAGIAN 1: LOGIKA UNTUK INPUT "LAINNYA" PADA LEMBAGA SERTIFIKASI ===
    // Mengatur input "Lainnya" untuk menampilkan/menyembunyikan field tambahan
    const setupLainnyaListener = (selectId, inputId) => {
        const selectElement = document.getElementById(selectId);
        if (selectElement) {
            selectElement.addEventListener('change', function() {
                const lainnyaInput = document.getElementById(inputId);
                if (lainnyaInput) {
                    lainnyaInput.style.display = this.value === 'lainnya' ? 'block' : 'none';
                    if (this.value !== 'lainnya') lainnyaInput.value = '';
                }
            });
        }
    };
    setupLainnyaListener('Lembaga_Sertifikasi', 'Lembaga_Sertifikasi_Lainnya');
    setupLainnyaListener('Edit_Lembaga_Sertifikasi', 'Edit_Lembaga_Sertifikasi_Lainnya');

    // === BAGIAN 2: PENINGKATAN UX UNTUK INPUT DATEPICKER ===
    // Menambahkan interaksi UX untuk input tanggal agar lebih mudah digunakan
    document.querySelectorAll('input[type="date"]').forEach((el) => {
        el.style.cursor = "pointer";
        el.addEventListener("click", function () {
            if (this.showPicker) this.showPicker();
        });
    });

    // === BAGIAN 3: LOGIKA UNTUK CUSTOM FILE UPLOAD ===
    // Menangani unggahan file dengan validasi ukuran dan format
    document.querySelectorAll('.upload-area').forEach(uploadArea => {
        const fileInput = uploadArea.querySelector('input[type="file"]');
        const textElement = uploadArea.querySelector('p');
        const originalTextHTML = textElement.innerHTML;
        const feedbackElement = uploadArea.nextElementSibling;

        // Klik area unggah untuk memicu input file
        uploadArea.addEventListener('click', () => fileInput.click());

        // Menangani perubahan file yang dipilih
        fileInput.addEventListener('change', () => {
            if (fileInput.files.length > 0) handleFile(fileInput.files[0]);
        });

        // Efek visual saat drag over
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.style.borderColor = 'var(--primary)';
        });

        // Mengembalikan warna border saat drag leave
        uploadArea.addEventListener('dragleave', () => {
            uploadArea.style.borderColor = 'var(--border-color)';
        });

        // Menangani drop file
        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.style.borderColor = 'var(--border-color)';
            if (e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                handleFile(e.dataTransfer.files[0]);
            }
        });

        // Fungsi untuk memvalidasi dan menampilkan file yang diunggah
        function handleFile(file) {
            const maxSize = 5 * 1024 * 1024; // Maksimal 5 MB
            let error = '';
            if (file.size > maxSize) {
                error = 'Ukuran file tidak boleh lebih dari 5 MB.';
            } else if (file.type !== "application/pdf") {
                error = 'Hanya file dengan format .pdf yang diizinkan.';
            }

            if (feedbackElement) {
                feedbackElement.textContent = error;
                feedbackElement.style.display = error ? 'block' : 'none';
            }

            // Mengosongkan input jika ada error
            if (error) {
                fileInput.value = '';
                textElement.innerHTML = originalTextHTML;
            } else {
                textElement.innerHTML = `<strong>File terpilih:</strong><br>${file.name}`;
            }
        }
    });

    // === BAGIAN 4: LOGIKA UNTUK NOTIFIKASI SUKSES ===
    // Menampilkan notifikasi sukses setelah simpan/update
    const successMessage = document.querySelector('meta[name="flash-success"]')?.getAttribute('content');
    if (successMessage) {
        const modalBerhasil = document.getElementById('modalBerhasil');
        if (modalBerhasil) {
            new Audio('/assets/sounds/Success.mp3').play();
            modalBerhasil.classList.add('show');
            setTimeout(() => {
                modalBerhasil.classList.remove('show');
                window.location.reload();
            }, 1200);
        }
    }

    // === BAGIAN 5: LOGIKA UNTUK MODAL EDIT ===
    // Mengisi form edit dengan data dari server
    const modalEdit = document.getElementById('editSertifikatKompetensiModal');
    if (modalEdit) {
        modalEdit.addEventListener('show.bs.modal', async (event) => {
            const button = event.relatedTarget;
            const form = document.getElementById('editSertifikatForm');
            const editUrl = button.dataset.editUrl;
            form.action = button.dataset.updateUrl;

            // Reset form sebelum mengisi data baru
            form.reset();
            form.querySelector('.upload-area p').innerHTML = "Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small>";
            form.querySelector('#lembaga_sertifikasi_lainnya_edit').style.display = 'none';

            // Debugging: Log URL yang akan di-fetch
            console.log('Mengambil data dari:', editUrl);

            try {
                const response = await fetch(editUrl, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP Error: ${response.status} - ${response.statusText}`);
                }

                const data = await response.json();
                console.log('Data dari server:', data); // Debugging: Log data yang diterima

                // Validasi data JSON
                if (!data || typeof data !== 'object') {
                    throw new Error('Data dari server tidak valid atau kosong.');
                }

                // Mengisi semua field form dengan data dari server
                form.querySelector('#pegawai_id_edit').value = data.pegawai_id || '';
                form.querySelector('#kegiatan_edit').value = data.kegiatan || '';
                form.querySelector('#judul_kegiatan_edit').value = data.judul_kegiatan || '';
                form.querySelector('#no_reg_pendidik_edit').value = data.no_reg_pendidik || '';
                form.querySelector('#no_sk_sertifikasi_edit').value = data.no_sk_sertifikasi || '';
                form.querySelector('#tahun_sertifikasi_edit').value = data.tahun_sertifikasi || '';
                form.querySelector('#tmt_sertifikasi_edit').value = data.tmt_sertifikasi || '';
                form.querySelector('#tst_sertifikasi_edit').value = data.tst_sertifikasi || '';
                form.querySelector('#bidang_studi_edit').value = data.bidang_studi || '';

                // Logika untuk lembaga sertifikasi
                const lembagaSelect = form.querySelector('#lembaga_sertifikasi_edit');
                const lembagaLainnya = form.querySelector('#lembaga_sertifikasi_lainnya_edit');
                const optionExists = [...lembagaSelect.options].some(opt => opt.value === data.lembaga_sertifikasi);

                if (optionExists) {
                    lembagaSelect.value = data.lembaga_sertifikasi || '';
                } else {
                    lembagaSelect.value = 'lainnya';
                    lembagaLainnya.style.display = 'block';
                    lembagaLainnya.value = data.lembaga_sertifikasi || '';
                }

                // Menampilkan nama file yang sudah ada
                if (data.dokumen) {
                    const fileName = data.dokumen.split('/').pop();
                    form.querySelector('.upload-area p').innerHTML = `File sudah ada: <strong>${fileName}</strong><br><small>Unggah baru untuk mengganti.</small>`;
                }

                // Set nilai Select2 untuk pegawai_id_edit
                const pegawaiId = button.dataset.pegawaiId || data.pegawai_id;
                if (pegawaiId) {
                    $('#pegawai_id_edit').val(pegawaiId).trigger('change.select2');
                } else {
                    $('#pegawai_id_edit').val(null).trigger('change.select2');
                }

            } catch (error) {
                console.error('Gagal memuat data edit:', error);
                let errorMessage = 'Terjadi kesalahan saat memuat data. Silakan coba lagi.';
                if (error.message.includes('404')) {
                    errorMessage = 'Data tidak ditemukan di server.';
                } else if (error.message.includes('500')) {
                    errorMessage = 'Terjadi kesalahan di server. Silakan hubungi administrator.';
                } else if (error.message.includes('network')) {
                    errorMessage = 'Gagal terhubung ke server. Periksa koneksi internet Anda.';
                }
                alert(errorMessage);
            }
        });

        // Menambahkan spinner pada tombol simpan di form edit
        const formEdit = document.getElementById('editSertifikatForm');
        if (formEdit) {
            formEdit.addEventListener('submit', (e) => {
                const btn = formEdit.querySelector('button[type="submit"]');
                if (btn) addSpinner(btn, 'Menyimpan...');
            });
        }
    }

    // === BAGIAN 6: LOGIKA UNTUK MODAL DETAIL ===
    // Mengisi data detail sertifikat ke dalam modal
    const modalDetail = document.getElementById('modalDetailSertifikatKompetensi');
    if (modalDetail) {
        modalDetail.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const setDataText = (id, attribute) => {
                const element = modalDetail.querySelector(`#${id}`);
                if (element) element.textContent = button.getAttribute(attribute) || '-';
            };

            setDataText('detail_sertifikat_nama', 'data-nama');
            setDataText('detail_sertifikat_kegiatan', 'data-kegiatan');
            setDataText('detail_sertifikat_judul', 'data-judul');
            setDataText('detail_sertifikat_no_reg', 'data-no-reg');
            setDataText('detail_sertifikat_no_sk', 'data-no-sk');
            setDataText('detail_sertifikat_tahun', 'data-tahun');
            setDataText('detail_sertifikat_tmt', 'data-tmt');
            setDataText('detail_sertifikat_tst', 'data-tst');
            setDataText('detail_sertifikat_bidang', 'data-bidang');
            setDataText('detail_sertifikat_lembaga', 'data-lembaga');

            const viewer = modalDetail.querySelector('#detail_sertifikat_document_viewer');
            if (viewer) {
                viewer.src = button.getAttribute('data-dokumen') || '';
            }
        });
    }

    // === BAGIAN 7: LOGIKA UNTUK MODAL KONFIRMASI HAPUS ===
    // Menangani aksi hapus dengan modal konfirmasi
    const modalKonfirmasiHapus = document.getElementById('modalKonfirmasiHapus');
    if (modalKonfirmasiHapus) {
        const btnKonfirmasiHapus = document.getElementById('btnKonfirmasiHapus');
        const btnBatalHapus = document.getElementById('btnBatalHapus');
        let deleteUrl = '';

        // Menangkap klik tombol hapus menggunakan event delegation
        document.body.addEventListener('click', function(e) {
            const deleteButton = e.target.closest('.btn-hapus[data-delete-url]');
            if (deleteButton) {
                e.preventDefault();
                deleteUrl = deleteButton.dataset.deleteUrl;
                modalKonfirmasiHapus.classList.add('show');
            }
        });

        // Menutup modal saat tombol batal diklik
        btnBatalHapus.addEventListener('click', () => {
            modalKonfirmasiHapus.classList.remove('show');
            deleteUrl = '';
        });

        // Menutup modal saat klik di luar modal
        modalKonfirmasiHapus.addEventListener('click', (e) => {
            if (e.target === modalKonfirmasiHapus) {
                modalKonfirmasiHapus.classList.remove('show');
                deleteUrl = '';
            }
        });

        // Mengirim request hapus saat tombol konfirmasi diklik
        btnKonfirmasiHapus.addEventListener('click', () => {
            if (deleteUrl) {
                addSpinner(btnKonfirmasiHapus, 'Menghapus...');
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteUrl;

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                form.innerHTML = `
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="${csrfToken}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    // === BAGIAN 8: LOGIKA UNTUK MODAL VERIFIKASI ===
    // Menangani verifikasi data dengan modal konfirmasi
    const modalVerifikasi = document.getElementById('modalKonfirmasiVerifikasi');
    if (modalVerifikasi) {
        const btnTerima = document.getElementById('popupBtnTerima');
        const btnTolak = document.getElementById('popupBtnTolak');
        const btnKembali = document.getElementById('popupBtnKembali');
        let verifikasiUrl = '';

        // Menangkap klik tombol verifikasi menggunakan event delegation
        document.body.addEventListener('click', function(e) {
            const verifikasiButton = e.target.closest('.btn-verifikasi[data-verifikasi-url]');
            if (verifikasiButton) {
                e.preventDefault();
                verifikasiUrl = verifikasiButton.dataset.verifikasiUrl;
                modalVerifikasi.classList.add('show');
            }
        });

        // Fungsi untuk mengirim form verifikasi
        const submitVerifikasiForm = (status) => {
            if (verifikasiUrl) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = verifikasiUrl;
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                form.innerHTML = `
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <input type="hidden" name="status" value="${status}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        };

        // Event listener untuk tombol verifikasi
        btnTerima.addEventListener('click', () => submitVerifikasiForm('Sudah Diverifikasi'));
        btnTolak.addEventListener('click', () => submitVerifikasiForm('Ditolak'));
        btnKembali.addEventListener('click', () => {
            modalVerifikasi.classList.remove('show');
            verifikasiUrl = '';
        });
    }

    // === BAGIAN 9: LOGIKA UNTUK FILTER TABEL ===
    // Menangani filter tabel berdasarkan pencarian, tahun, dan status
    const searchInput = document.getElementById('searchInput');
    const tahunFilter = document.getElementById('tahunFilter');
    const statusFilter = document.getElementById('statusFilter');
    const tableBody = document.getElementById('kompetensiTableBody');

    if (searchInput && tahunFilter && statusFilter && tableBody) {
        const allRows = tableBody.querySelectorAll('tr:not(#noDataFoundRow)');

        // Fungsi untuk memastikan baris "Data tidak ditemukan" ada
        function ensureNoDataRow() {
            let noDataRow = document.getElementById('noDataFoundRow');
            if (!noDataRow) {
                noDataRow = document.createElement('tr');
                noDataRow.id = 'noDataFoundRow';
                noDataRow.innerHTML = '<td colspan="9" class="text-center text-muted">Data tidak ditemukan</td>';
                tableBody.appendChild(noDataRow);
            }
            noDataRow.classList.remove('d-none'); // Hapus d-none untuk memastikan terlihat
            return noDataRow;
        }

        // Fungsi untuk menerapkan filter tanpa refresh (untuk pencarian)
        function applyFilters() {
            const searchTerm = searchInput.value.toLowerCase();
            const tahunValue = tahunFilter.value;
            const statusValue = statusFilter.value;

            const params = new URLSearchParams();
            if (searchTerm) params.append('cari', searchTerm);
            if (tahunValue) params.append('tahun', tahunValue);
            if (statusValue) params.append('status', statusValue);
            const newUrl = window.location.pathname + (params.toString() ? `?${params.toString()}` : '');
            history.replaceState(null, '', newUrl);

            let visibleRowCount = 0;
            allRows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                const rowTahun = row.dataset.tahun;
                const rowStatus = row.dataset.status;

                const searchMatch = rowText.includes(searchTerm);
                const tahunMatch = tahunValue === '' || rowTahun === tahunValue;
                const statusMatch = statusValue === '' || rowStatus === statusValue;

                if (searchMatch && tahunMatch && statusMatch) {
                    row.style.display = '';
                    visibleRowCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            const noDataRow = ensureNoDataRow();
            noDataRow.style.display = visibleRowCount === 0 ? '' : 'none';
        }

        // Fungsi untuk menerapkan filter dengan refresh halaman (untuk dropdown)
        function applyFiltersWithReload() {
            const searchTerm = searchInput.value.toLowerCase();
            const tahunValue = tahunFilter.value;
            const statusValue = statusFilter.value;

            const params = new URLSearchParams();
            if (searchTerm) params.append('cari', searchTerm);
            if (tahunValue) params.append('tahun', tahunValue);
            if (statusValue) params.append('status', statusValue);
            const newUrl = `${window.location.pathname}${params.toString() ? `?${params.toString()}` : ''}`;
            window.location.href = newUrl;
        }

        // Fungsi untuk menerapkan filter dari parameter URL saat halaman dimuat
        function applyFiltersFromUrl() {
            const params = new URLSearchParams(window.location.search);
            searchInput.value = params.get('cari') || '';
            tahunFilter.value = params.get('tahun') || '';
            statusFilter.value = params.get('status') || '';
            applyFilters();
        }

        // Event listener untuk filter
        searchInput.addEventListener('input', applyFilters); // Filter pencarian tanpa refresh
        tahunFilter.addEventListener('change', applyFiltersWithReload); // Refresh saat dropdown tahun berubah
        statusFilter.addEventListener('change', applyFiltersWithReload); // Refresh saat dropdown status berubah

        // Terapkan filter dari URL saat halaman dimuat
        applyFiltersFromUrl();
    }

    // === BAGIAN 10: LOGIKA UNTUK FORM TAMBAH ===
    // Menambahkan spinner pada tombol simpan di form tambah
    const formTambah = document.getElementById('sertifikatKompetensiForm');
    if (formTambah) {
        formTambah.addEventListener('submit', (e) => {
            const btn = formTambah.querySelector('button[type="submit"]');
            if (btn) addSpinner(btn, 'Menyimpan...');
        });
    }

    // === BAGIAN 11: INISIALISASI SELECT2 UNTUK MODAL TAMBAH DAN EDIT ===
    // Menggunakan jQuery untuk mengelola Select2 pada modal
    $(document).ready(function () {
        // --- SELECT2 UNTUK MODAL TAMBAH ---
        const tambahModal = $('#sertifikatKompetensiModal');
        const tambahSelect = $('#Nama');

        tambahSelect.select2({
            dropdownParent: tambahModal,
            placeholder: '-- Pilih Pegawai --',
            theme: 'bootstrap-5',
            allowClear: true,
            width: '100%'
        });

        // Reset form dan Select2 saat modal tambah ditutup
        tambahModal.on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
            tambahSelect.val(null).trigger('change');
            $('#Lembaga_Sertifikasi_Lainnya').hide().val('');
        });

        // --- SELECT2 UNTUK MODAL EDIT ---
        const editModal = $('#editSertifikatKompetensiModal');
        const editSelect = $('#pegawai_id_edit');

        editSelect.select2({
            dropdownParent: editModal,
            placeholder: '-- Pilih Pegawai --',
            theme: 'bootstrap-5',
            allowClear: true,
            width: '100%'
        });

        // Set nilai Select2 saat modal edit ditampilkan
        editModal.on('shown.bs.modal', function (e) {
            const button = $(e.relatedTarget);
            const pegawaiId = button.data('pegawai-id');
            if (pegawaiId) {
                editSelect.val(pegawaiId).trigger('change.select2');
            } else {
                editSelect.val(null).trigger('change.select2');
            }
        });
    });
});