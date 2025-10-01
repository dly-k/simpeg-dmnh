// assets/js/sertifikat-kompetensi.js (Dengan Perbaikan Error)

document.addEventListener("DOMContentLoaded", () => {

    // ... (BAGIAN 1 & 2 tetap sama) ...
    // BAGIAN 1: LOGIKA UNTUK INPUT "LAINNYA" PADA LEMBAGA SERTIFIKASI
    const setupLainnyaListener = (selectId, inputId) => {
        const selectElement = document.getElementById(selectId);
        if (selectElement) {
            selectElement.addEventListener('change', function() {
                const lainnyaInput = document.getElementById(inputId);
                if (lainnyaInput) {
                    lainnyaInput.style.display = (this.value === 'lainnya') ? 'block' : 'none';
                    if (this.value !== 'lainnya') lainnyaInput.value = '';
                }
            });
        }
    };
    setupLainnyaListener('Lembaga_Sertifikasi', 'Lembaga_Sertifikasi_Lainnya');
    setupLainnyaListener('Edit_Lembaga_Sertifikasi', 'Edit_Lembaga_Sertifikasi_Lainnya');

    // BAGIAN 2: PENINGKATAN UX UNTUK INPUT DATEPICKER
    document.querySelectorAll('input[type="date"]').forEach((el) => {
        el.style.cursor = "pointer";
        el.addEventListener("click", function () {
            this.showPicker && this.showPicker();
        });
    });


    // BAGIAN 3: LOGIKA UNTUK CUSTOM FILE UPLOAD
    document.querySelectorAll('.upload-area').forEach(uploadArea => {
        const fileInput = uploadArea.querySelector('input[type="file"]');
        const textElement = uploadArea.querySelector('p');
        const originalTextHTML = textElement.innerHTML;
        const feedbackElement = uploadArea.nextElementSibling;

        uploadArea.addEventListener('click', () => fileInput.click());
        fileInput.addEventListener('change', () => { if (fileInput.files.length > 0) handleFile(fileInput.files[0]); });
        uploadArea.addEventListener('dragover', (e) => { e.preventDefault(); uploadArea.style.borderColor = 'var(--primary)'; });
        uploadArea.addEventListener('dragleave', () => { uploadArea.style.borderColor = 'var(--border-color)'; });
        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.style.borderColor = 'var(--border-color)';
            if (e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                handleFile(e.dataTransfer.files[0]);
            }
        });

        // --- FUNGSI DIPERBAIKI DI SINI ---
        function handleFile(file) {
            const maxSize = 5 * 1024 * 1024;
            let error = '';
            if (file.size > maxSize) error = 'Ukuran file tidak boleh lebih dari 5 MB.';
            else if (file.type !== "application/pdf") error = 'Hanya file dengan format .pdf yang diizinkan.';

            if (feedbackElement) {
                feedbackElement.textContent = error;
                feedbackElement.style.display = error ? 'block' : 'none';
            }
            
            // Perbaikan: Hanya set value jika ada error
            if (error) {
                fileInput.value = ''; // Mengosongkan input jika error
            }

            if (!error) {
                textElement.innerHTML = `<strong>File terpilih:</strong><br>${file.name}`;
            } else {
                textElement.innerHTML = originalTextHTML;
            }
        }
    });

    // BAGIAN 4: LOGIKA UNTUK NOTIFIKASI SUKSES
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
    const modalEdit = document.getElementById('editSertifikatKompetensiModal');
    if (modalEdit) {
        modalEdit.addEventListener('show.bs.modal', async (event) => {
            const button = event.relatedTarget;
            const form = document.getElementById('editSertifikatForm');
            form.action = button.dataset.updateUrl;

            // Reset form sebelum fetch data baru
            form.reset();
            form.querySelector('.upload-area p').innerHTML = "Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small>";
            form.querySelector('#lembaga_sertifikasi_lainnya_edit').style.display = 'none';

            try {
                const response = await fetch(button.dataset.editUrl);
                const data = await response.json();

                // Isi semua field form
                form.querySelector('#pegawai_id_edit').value = data.pegawai_id;
                form.querySelector('#kegiatan_edit').value = data.kegiatan;
                form.querySelector('#judul_kegiatan_edit').value = data.judul_kegiatan;
                form.querySelector('#no_reg_pendidik_edit').value = data.no_reg_pendidik;
                form.querySelector('#no_sk_sertifikasi_edit').value = data.no_sk_sertifikasi;
                form.querySelector('#tahun_sertifikasi_edit').value = data.tahun_sertifikasi;
                form.querySelector('#tmt_sertifikasi_edit').value = data.tmt_sertifikasi;
                form.querySelector('#tst_sertifikasi_edit').value = data.tst_sertifikasi;
                form.querySelector('#bidang_studi_edit').value = data.bidang_studi;

                // Logika pintar untuk lembaga sertifikasi
                const lembagaSelect = form.querySelector('#lembaga_sertifikasi_edit');
                const lembagaLainnya = form.querySelector('#lembaga_sertifikasi_lainnya_edit');
                const optionExists = [...lembagaSelect.options].some(opt => opt.value === data.lembaga_sertifikasi);

                if (optionExists) {
                    lembagaSelect.value = data.lembaga_sertifikasi;
                } else {
                    lembagaSelect.value = 'lainnya';
                    lembagaLainnya.style.display = 'block';
                    lembagaLainnya.value = data.lembaga_sertifikasi;
                }

                if (data.dokumen) {
                    const fileName = data.dokumen.split('/').pop();
                    form.querySelector('.upload-area p').innerHTML = `File sudah ada: <strong>${fileName}</strong><br><small>Unggah baru untuk mengganti.</small>`;
                }

            } catch (error) {
                console.error('Gagal memuat data edit:', error);
            }
        });
    }
    const modalDetail = document.getElementById('modalDetailSertifikatKompetensi');
    if (modalDetail) {
        modalDetail.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const setDataText = (id, attribute) => {
                const element = modalDetail.querySelector(`#${id}`);
                if(element) element.textContent = button.getAttribute(attribute) || '-';
            }

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
                viewer.src = button.getAttribute('data-dokumen') || "";
            }
        });
    }
    const modalKonfirmasiHapus = document.getElementById('modalKonfirmasiHapus');
    if (modalKonfirmasiHapus) {
        const btnKonfirmasiHapus = document.getElementById('btnKonfirmasiHapus');
        const btnBatalHapus = document.getElementById('btnBatalHapus');
        let deleteUrl = '';

        // Gunakan event delegation untuk menangkap klik pada semua tombol hapus
        document.body.addEventListener('click', function(e) {
            const deleteButton = e.target.closest('.btn-hapus[data-delete-url]');
            
            if (deleteButton) {
                e.preventDefault();
                deleteUrl = deleteButton.dataset.deleteUrl;
                modalKonfirmasiHapus.classList.add('show');
            }
        });

        // Saat tombol "Batal" di modal diklik
        btnBatalHapus.addEventListener('click', () => {
            modalKonfirmasiHapus.classList.remove('show');
            deleteUrl = '';
        });

        // Saat tombol "Ya, Hapus" di modal diklik
        btnKonfirmasiHapus.addEventListener('click', () => {
            if (deleteUrl) {
                // Buat form dinamis untuk mengirim request DELETE
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteUrl;

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;

                form.appendChild(methodInput);
                form.appendChild(csrfInput);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
    const modalVerifikasi = document.getElementById('modalKonfirmasiVerifikasi');
    if (modalVerifikasi) {
        const btnTerima = document.getElementById('popupBtnTerima');
        const btnTolak = document.getElementById('popupBtnTolak');
        const btnKembali = document.getElementById('popupBtnKembali');
        let verifikasiUrl = '';

        // Event delegation untuk semua tombol verifikasi
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
                
                // Input untuk method PATCH
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PATCH';
                form.appendChild(methodInput);

                // Input untuk CSRF Token
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                form.appendChild(csrfInput);

                // Input untuk status verifikasi
                const statusInput = document.createElement('input');
                statusInput.type = 'hidden';
                statusInput.name = 'status';
                statusInput.value = status;
                form.appendChild(statusInput);

                document.body.appendChild(form);
                form.submit();
            }
        };
        
        // Event listener untuk tombol di dalam modal
        btnTerima.addEventListener('click', () => {
            submitVerifikasiForm('Sudah Diverifikasi');
        });

        btnTolak.addEventListener('click', () => {
            submitVerifikasiForm('Ditolak');
        });

        btnKembali.addEventListener('click', () => {
            modalVerifikasi.classList.remove('show');
            verifikasiUrl = '';
        });
    }
    const searchInput = document.getElementById('searchInput');
    const tahunFilter = document.getElementById('tahunFilter');
    const statusFilter = document.getElementById('statusFilter');
    const tableBody = document.getElementById('kompetensiTableBody');
    const noDataRow = document.getElementById('noDataFoundRow');
    
    // Pastikan elemen filter ada sebelum melanjutkan
    if (searchInput && tahunFilter && statusFilter && tableBody) {
        const allRows = tableBody.querySelectorAll('tr:not(#noDataFoundRow)');

        function applyFilters() {
            const searchTerm = searchInput.value.toLowerCase();
            const tahunValue = tahunFilter.value;
            const statusValue = statusFilter.value;
            
            // Update URL dengan parameter filter
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
                const tahunMatch = (tahunValue === "") || (rowTahun === tahunValue);
                const statusMatch = (statusValue === "") || (rowStatus === statusValue);
                
                if (searchMatch && tahunMatch && statusMatch) {
                    row.style.display = '';
                    visibleRowCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            noDataRow.style.display = (visibleRowCount === 0) ? '' : 'none';
        }

        // Fungsi untuk menerapkan filter dari URL saat halaman dimuat
        function applyFiltersFromUrl() {
            const params = new URLSearchParams(window.location.search);
            searchInput.value = params.get('cari') || '';
            tahunFilter.value = params.get('tahun') || '';
            statusFilter.value = params.get('status') || '';
            applyFilters();
        }

        searchInput.addEventListener('input', applyFilters);
        tahunFilter.addEventListener('change', applyFilters);
        statusFilter.addEventListener('change', applyFilters);

        // Terapkan filter dari URL saat halaman pertama kali dibuka
        applyFiltersFromUrl();
    }
});