document.addEventListener("DOMContentLoaded", () => {
    // Fungsi bantu untuk mengisi teks dengan aman
    const setDataText = (id, attribute, element) => {
        const target = document.getElementById(id);
        if (target) {
            target.textContent = element.getAttribute(attribute) || '-';
        }
    };

    // Fungsi bantu untuk menangani unggahan file
    const handleFile = (file, textElement, feedbackElement, originalTextHTML) => {
        const maxSize = 5 * 1024 * 1024; // Maksimal 5 MB
        if (file.size > maxSize) {
            feedbackElement.textContent = 'Ukuran file tidak boleh lebih dari 5 MB.';
            feedbackElement.style.display = 'block';
            textElement.innerHTML = originalTextHTML;
            return false;
        }
        if (file.type !== "application/pdf") {
            feedbackElement.textContent = 'Hanya file dengan format .pdf yang diizinkan.';
            feedbackElement.style.display = 'block';
            textElement.innerHTML = originalTextHTML;
            return false;
        }
        feedbackElement.style.display = 'none';
        textElement.innerHTML = `<strong>File terpilih:</strong><br>${file.name}`;
        return true;
    };

    // Fungsi untuk menambahkan spinner pada tombol
    const addSpinner = (button, text = 'Menyimpan...') => {
        button.disabled = true;
        button.dataset.originalHtml = button.innerHTML;
        button.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>${text}`;
    };

    // Fungsi untuk menghapus spinner dari tombol
    const removeSpinner = (button) => {
        button.disabled = false;
        button.innerHTML = button.dataset.originalHtml;
    };

    // Fungsi untuk menerapkan filter berdasarkan input pencarian dan filter lainnya
    const applyFilters = () => {
        const searchTerm = searchInput.value.toLowerCase();
        const semesterValue = semesterFilter.value;
        const statusValue = statusFilter.value;

        // Memperbarui URL tanpa reload halaman
        const params = new URLSearchParams();
        if (searchTerm) params.append('cari', searchTerm);
        if (semesterValue) params.append('semester', semesterValue);
        if (statusValue) params.append('status', statusValue);
        const newUrl = `${window.location.pathname}${params.toString() ? `?${params.toString()}` : ''}`;
        history.replaceState(null, '', newUrl);

        let visibleRowCount = 0;
        allRows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            const rowTanggal = row.dataset.tanggal;
            const rowStatus = row.dataset.status;

            const searchMatch = rowText.includes(searchTerm);
            const statusMatch = statusValue === "" || rowStatus === statusValue;
            let semesterMatch = true;

            if (semesterValue) {
                const [filterSemester, filterYear] = semesterValue.split('-');
                const rowDate = new Date(rowTanggal);
                const rowMonth = rowDate.getMonth() + 1;
                const rowYear = rowDate.getFullYear();

                if (filterSemester === 'ganjil') {
                    semesterMatch = rowMonth >= 1 && rowMonth <= 6 && rowYear == filterYear;
                } else if (filterSemester === 'genap') {
                    semesterMatch = rowMonth >= 7 && rowMonth <= 12 && rowYear == filterYear;
                }
            }

            row.style.display = searchMatch && statusMatch && semesterMatch ? '' : 'none';
            if (searchMatch && statusMatch && semesterMatch) visibleRowCount++;
        });

        // Tangani baris "Data tidak ditemukan"
        let noDataRow = document.getElementById('noDataFoundRow');
        if (visibleRowCount === 0) {
            if (!noDataRow) {
                noDataRow = document.createElement('tr');
                noDataRow.id = 'noDataFoundRow';
                noDataRow.innerHTML = '<td colspan="12" class="text-center">Data tidak ditemukan.</td>';
                tableBody.appendChild(noDataRow);
            } else {
                noDataRow.innerHTML = '<td colspan="12" class="text-center">Data tidak ditemukan.</td>';
                noDataRow.classList.remove('d-none');
            }
            noDataRow.style.display = '';
        } else {
            if (noDataRow) {
                noDataRow.style.display = 'none';
                noDataRow.classList.add('d-none');
            }
        }
    };

    // Fungsi untuk menerapkan filter dari parameter URL saat halaman dimuat
    const applyFiltersFromUrl = () => {
        const params = new URLSearchParams(window.location.search);
        searchInput.value = params.get('cari') || '';
        semesterFilter.value = params.get('semester') || '';
        statusFilter.value = params.get('status') || '';
        applyFilters();
    };

    // Inisialisasi elemen-elemen DOM
    const modalDetail = document.getElementById('modalDetailOrasiIlmiah');
    const modalBerhasil = document.getElementById('modalBerhasil');
    const modalEdit = document.getElementById('editOrasiIlmiahModal');
    const modalKonfirmasiHapus = document.getElementById('modalKonfirmasiHapus');
    const modalVerifikasi = document.getElementById('modalKonfirmasiVerifikasi');
    const modalTambah = document.getElementById('orasiIlmiahModal');
    const searchInput = document.getElementById('searchInput');
    const semesterFilter = document.getElementById('semesterFilter');
    const statusFilter = document.getElementById('statusFilter');
    const tableBody = document.getElementById('orasiIlmiahTableBody');
    const allRows = tableBody?.querySelectorAll('tr:not(#noDataFoundRow)') || [];
    const noDataRow = document.getElementById('noDataFoundRow');

    // Logika untuk modal detail orasi ilmiah
    if (modalDetail) {
        modalDetail.addEventListener('show.bs.modal', (event) => {
            const button = event.relatedTarget;

            // Mengisi data utama ke dalam modal
            setDataText('detail_orasi_pegawai', 'data-pegawai', button);
            setDataText('detail_orasi_litabmas', 'data-litabmas', button);
            setDataText('detail_orasi_kategori_pembicara', 'data-kategori', button);
            setDataText('detail_orasi_lingkup', 'data-lingkup', button);
            setDataText('detail_orasi_judul_makalah', 'data-judul', button);
            setDataText('detail_orasi_nama_pertemuan', 'data-pertemuan', button);
            setDataText('detail_orasi_penyelenggara', 'data-penyelenggara', button);
            setDataText('detail_orasi_tanggal_pelaksana', 'data-tanggal', button);
            setDataText('detail_orasi_bahasa', 'data-bahasa', button);
            setDataText('detail_orasi_jenis_dokumen', 'data-jenis-dokumen', button);
            setDataText('detail_orasi_nama_dokumen', 'data-nama-dokumen', button);
            setDataText('detail_orasi_nomor_dokumen', 'data-nomor-dokumen', button);

            // Mengisi tautan
            const tautanElement = document.getElementById('detail_orasi_tautan');
            if (tautanElement) {
                const tautan = button.getAttribute('data-tautan');
                tautanElement.innerHTML = tautan ? `<a href="${tautan}" target="_blank">${tautan}</a>` : '-';
            }

            // Menampilkan viewer PDF
            const viewer = document.getElementById('detail_orasi_document_viewer');
            if (viewer) {
                const fileSrc = button.getAttribute('data-dokumen-src') || '';
                viewer.setAttribute('src', fileSrc);
            }
        });
    }

    // Logika untuk notifikasi sukses setelah simpan/update
    const successMessage = document.querySelector('meta[name="flash-success"]')?.getAttribute('content');
    if (successMessage && modalBerhasil) {
        const sound = new Audio('/assets/sounds/Success.mp3');
        sound.play();
        modalBerhasil.classList.add('show');
        setTimeout(() => {
            modalBerhasil.classList.remove('show');
            window.location.reload();
        }, 1200);
    }

    // Peningkatan UX untuk input datepicker
    document.querySelectorAll('input[type="date"]').forEach((el) => {
        el.style.cursor = 'pointer';
        el.addEventListener('click', () => {
            if (el.showPicker) el.showPicker();
        });
    });

    // Logika untuk custom file upload
    document.querySelectorAll('.upload-area').forEach(uploadArea => {
        const fileInput = uploadArea.querySelector('input[type="file"]');
        const textElement = uploadArea.querySelector('p');
        const originalTextHTML = textElement.innerHTML;
        const feedbackElement = uploadArea.nextElementSibling;

        uploadArea.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', () => {
            if (fileInput.files.length > 0) {
                handleFile(fileInput.files[0], textElement, feedbackElement, originalTextHTML);
                fileInput.value = fileInput.files.length > 0 && !handleFile(fileInput.files[0], textElement, feedbackElement, originalTextHTML) ? '' : fileInput.value;
            }
        });

        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.style.borderColor = 'var(--primary)';
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.style.borderColor = 'var(--border-color)';
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.style.borderColor = 'var(--border-color)';
            if (e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                handleFile(e.dataTransfer.files[0], textElement, feedbackElement, originalTextHTML);
                fileInput.value = fileInput.files.length > 0 && !handleFile(e.dataTransfer.files[0], textElement, feedbackElement, originalTextHTML) ? '' : fileInput.value;
            }
        });
    });

    // Logika untuk modal edit
    if (modalEdit) {
        modalEdit.addEventListener('show.bs.modal', async (event) => {
            const button = event.relatedTarget;
            const editUrl = button.dataset.editUrl;
            const updateUrl = button.dataset.updateUrl;
            const form = document.getElementById('editOrasiIlmiahForm');
            form.setAttribute('action', updateUrl);

            // Reset tampilan upload area
            const uploadAreaText = form.querySelector('.upload-area p');
            const originalUploadText = 'Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small>';
            uploadAreaText.innerHTML = originalUploadText;
            form.querySelector('input[type="file"]').value = '';

            try {
                const response = await fetch(editUrl);
                if (!response.ok) throw new Error('Gagal mengambil data untuk diedit!');
                const data = await response.json();

                // Debugging: Log data dari server
                console.log('Data dari server:', data);

                // Mengisi field form dengan data dari server
                form.querySelector('#pegawai_id_edit').value = data.pegawai_id || '';
                form.querySelector('#litabmas_edit').value = data.litabmas || '';
                form.querySelector('#kategori_pembicara_edit').value = data.kategori_pembicara || '';
                form.querySelector('#lingkup_edit').value = data.lingkup || '';
                form.querySelector('#judul_makalah_edit').value = data.judul_makalah || '';
                form.querySelector('#nama_pertemuan_edit').value = data.nama_pertemuan || '';
                form.querySelector('#penyelenggara_edit').value = data.penyelenggara || '';
                form.querySelector('#tanggal_pelaksana_edit').value = data.tanggal_pelaksana || '';
                form.querySelector('#bahasa_edit').value = data.bahasa || '';
                form.querySelector('#jenis_dokumen_edit').value = data.jenis_dokumen || '';
                form.querySelector('#nama_dokumen_edit').value = data.nama_dokumen || '';
                form.querySelector('#nomor_dokumen_edit').value = data.nomor_dokumen || '';
                form.querySelector('#tautan_dokumen_edit').value = data.tautan_dokumen || '';

                // Menampilkan nama file yang sudah ada
                if (data.dokumen) {
                    const fileName = data.dokumen.split('/').pop();
                    uploadAreaText.innerHTML = `File sudah ada: <strong>${fileName}</strong><br><small>Unggah file baru untuk mengganti.</small>`;
                }

                // Set nilai Select2 dan refresh
                $('#pegawai_id_edit').val(data.pegawai_id).trigger('change');
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memuat data. Silakan coba lagi.');
            }
        });
    }

    // Logika untuk modal konfirmasi hapus
    if (modalKonfirmasiHapus) {
        const btnKonfirmasiHapus = document.getElementById('btnKonfirmasiHapus');
        const btnBatalHapus = document.getElementById('btnBatalHapus');
        let deleteUrl = '';

        document.body.addEventListener('click', (e) => {
            const deleteButton = e.target.closest('.btn-hapus[data-delete-url]');
            if (deleteButton) {
                e.preventDefault();
                deleteUrl = deleteButton.dataset.deleteUrl;
                modalKonfirmasiHapus.classList.add('show');
            }
        });

        btnBatalHapus.addEventListener('click', () => {
            modalKonfirmasiHapus.classList.remove('show');
            deleteUrl = '';
        });

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

        window.addEventListener('click', (e) => {
            if (e.target === modalKonfirmasiHapus) {
                modalKonfirmasiHapus.classList.remove('show');
                deleteUrl = '';
            }
        });
    }

    // Logika untuk modal verifikasi
    if (modalVerifikasi) {
        const btnTerima = document.getElementById('popupBtnTerima');
        const btnTolak = document.getElementById('popupBtnTolak');
        const btnKembali = document.getElementById('popupBtnKembali');
        let verifikasiUrl = '';

        document.body.addEventListener('click', (e) => {
            const verifikasiButton = e.target.closest('.btn-verifikasi[data-verifikasi-url]');
            if (verifikasiButton) {
                e.preventDefault();
                verifikasiUrl = verifikasiButton.dataset.verifikasiUrl;
                modalVerifikasi.classList.add('show');
            }
        });

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

        btnTerima.addEventListener('click', () => submitVerifikasiForm('Sudah Diverifikasi'));
        btnTolak.addEventListener('click', () => submitVerifikasiForm('Ditolak'));
        btnKembali.addEventListener('click', () => {
            modalVerifikasi.classList.remove('show');
            verifikasiUrl = '';
        });
    }

    // Logika untuk filter tabel
    if (searchInput && semesterFilter && statusFilter) {
        searchInput.addEventListener('input', applyFilters);
        semesterFilter.addEventListener('change', applyFilters);
        statusFilter.addEventListener('change', applyFilters);
    }

    // Inisialisasi Select2 untuk modal tambah dan edit
    $(document).ready(() => {
        $('#pegawai_id').select2({
            dropdownParent: $('#orasiIlmiahModal'),
            theme: 'bootstrap-5',
            placeholder: '-- Pilih Pegawai --',
            width: '100%'
        });

        $('#pegawai_id_edit').select2({
            dropdownParent: $('#editOrasiIlmiahModal'),
            theme: 'bootstrap-5',
            placeholder: '-- Pilih Pegawai --',
            width: '100%'
        });

        $('#orasiIlmiahModal').on('show.bs.modal', () => {
            $('#pegawai_id').val(null).trigger('change');
        });

        $('#editOrasiIlmiahModal').on('shown.bs.modal', () => {
            $('#pegawai_id_edit').trigger('change');
        });
    });

    // Logika untuk spinner pada tombol simpan di form tambah dan edit
    const formTambah = document.getElementById('orasiIlmiahForm');
    if (formTambah) {
        formTambah.addEventListener('submit', (e) => {
            const btn = formTambah.querySelector('button[type="submit"]');
            if (btn) addSpinner(btn, 'Menyimpan...');
        });
    }

    const formEdit = document.getElementById('editOrasiIlmiahForm');
    if (formEdit) {
        formEdit.addEventListener('submit', (e) => {
            const btn = formEdit.querySelector('button[type="submit"]');
            if (btn) addSpinner(btn, 'Menyimpan...');
        });
    }

    // Fungsi untuk menerapkan filter dengan refresh halaman
    const applyFiltersWithReload = () => {
        const searchTerm = searchInput.value.toLowerCase();
        const semesterValue = semesterFilter.value;
        const statusValue = statusFilter.value;

        const params = new URLSearchParams();
        if (searchTerm) params.append('cari', searchTerm);
        if (semesterValue) params.append('semester', semesterValue);
        if (statusValue) params.append('status', statusValue);
        const newUrl = `${window.location.pathname}${params.toString() ? `?${params.toString()}` : ''}`;
        window.location.href = newUrl;
    };

    if (searchInput && semesterFilter && statusFilter) {
        searchInput.addEventListener('input', applyFiltersWithReload);
        semesterFilter.addEventListener('change', applyFiltersWithReload);
        statusFilter.addEventListener('change', applyFiltersWithReload);
    }

    // Memanggil fungsi untuk menerapkan filter dari URL saat halaman dimuat
    applyFiltersFromUrl();
});