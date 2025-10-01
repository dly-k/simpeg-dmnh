document.addEventListener("DOMContentLoaded", () => {

    // =================================================================
    // BAGIAN 1: LOGIKA UNTUK MODAL DETAIL ORASI ILMIAH
    // =================================================================
    const modalDetail = document.getElementById('modalDetailOrasiIlmiah');
    if (modalDetail) {
        modalDetail.addEventListener('show.bs.modal', function (event) {
            let button = event.relatedTarget; // Tombol yang memicu modal

            // Fungsi bantu untuk mengisi teks dengan aman
            const setDataText = (id, attribute) => {
                const element = document.getElementById(id);
                if (element) {
                    element.textContent = button.getAttribute(attribute) || '-';
                }
            };

            // Mengisi data utama
            setDataText('detail_orasi_pegawai', 'data-pegawai');
            setDataText('detail_orasi_litabmas', 'data-litabmas');
            setDataText('detail_orasi_kategori_pembicara', 'data-kategori');
            setDataText('detail_orasi_lingkup', 'data-lingkup');
            setDataText('detail_orasi_judul_makalah', 'data-judul');
            setDataText('detail_orasi_nama_pertemuan', 'data-pertemuan');
            setDataText('detail_orasi_penyelenggara', 'data-penyelenggara');
            setDataText('detail_orasi_tanggal_pelaksana', 'data-tanggal');
            setDataText('detail_orasi_bahasa', 'data-bahasa');

            // Mengisi data dokumen
            setDataText('detail_orasi_jenis_dokumen', 'data-jenis-dokumen');
            setDataText('detail_orasi_nama_dokumen', 'data-nama-dokumen');
            setDataText('detail_orasi_nomor_dokumen', 'data-nomor-dokumen');

            // Mengisi tautan
            const tautanElement = document.getElementById('detail_orasi_tautan');
            if (tautanElement) {
                let tautan = button.getAttribute('data-tautan');
                tautanElement.innerHTML = tautan ? `<a href="${tautan}" target="_blank">${tautan}</a>` : '-';
            }

            // Menampilkan viewer PDF
            const viewer = document.getElementById('detail_orasi_document_viewer');
            if (viewer) {
                let fileSrc = button.getAttribute('data-dokumen-src');
                viewer.setAttribute('src', fileSrc || '');
            }
        });
    }

    // =================================================================
    // BAGIAN 2: LOGIKA UNTUK NOTIFIKASI SUKSES SETELAH SIMPAN/UPDATE DATA
    // =================================================================
    const successMessage = document.querySelector('meta[name="flash-success"]')?.getAttribute('content');
    if (successMessage) {
        const modalBerhasil = document.getElementById('modalBerhasil');
        const sound = new Audio('/assets/sounds/Success.mp3'); // Pastikan path ini benar
        if (modalBerhasil) {
            sound.play();
            modalBerhasil.classList.add('show');
            setTimeout(() => {
                modalBerhasil.classList.remove('show');
                window.location.reload();
            }, 1200);
        }
    }

    // =================================================================
    // BAGIAN 3: PENINGKATAN UX UNTUK INPUT DATEPICKER
    // =================================================================
    document.querySelectorAll('input[type="date"]').forEach((el) => {
        el.style.cursor = "pointer";
        el.addEventListener("click", function () {
            this.showPicker && this.showPicker();
        });
    });

    // =================================================================
    // BAGIAN 4: LOGIKA UNTUK CUSTOM FILE UPLOAD
    // =================================================================
    document.querySelectorAll('.upload-area').forEach(uploadArea => {
        const fileInput = uploadArea.querySelector('input[type="file"]');
        const textElement = uploadArea.querySelector('p');
        const originalTextHTML = textElement.innerHTML;
        const feedbackElement = uploadArea.nextElementSibling;

        uploadArea.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', () => {
            if (fileInput.files.length > 0) handleFile(fileInput.files[0]);
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
                handleFile(e.dataTransfer.files[0]);
            }
        });

        function handleFile(file) {
            const maxSize = 5 * 1024 * 1024; // 5 MB
            if (file.size > maxSize) {
                feedbackElement.textContent = 'Ukuran file tidak boleh lebih dari 5 MB.';
                feedbackElement.style.display = 'block';
                fileInput.value = '';
                textElement.innerHTML = originalTextHTML;
                return;
            }
            if (file.type !== "application/pdf") {
                 feedbackElement.textContent = 'Hanya file dengan format .pdf yang diizinkan.';
                 feedbackElement.style.display = 'block';
                 fileInput.value = '';
                 textElement.innerHTML = originalTextHTML;
                return;
            }
            feedbackElement.style.display = 'none';
            textElement.innerHTML = `<strong>File terpilih:</strong><br>${file.name}`;
        }
    });
    
    // =================================================================
    // BAGIAN 5: LOGIKA UNTUK MODAL EDIT
    // =================================================================
    const modalEdit = document.getElementById('editOrasiIlmiahModal');
    if (modalEdit) {
        modalEdit.addEventListener('show.bs.modal', async (event) => {
            const button = event.relatedTarget;
            const editUrl = button.dataset.editUrl;
            const updateUrl = button.dataset.updateUrl;
            
            const form = document.getElementById('editOrasiIlmiahForm');
            form.setAttribute('action', updateUrl);

            // Reset tampilan upload area ke default sebelum fetch data baru
            const uploadAreaText = form.querySelector('.upload-area p');
            const originalUploadText = "Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small>";
            uploadAreaText.innerHTML = originalUploadText;
            form.querySelector('input[type="file"]').value = ''; // Reset input file

            try {
                const response = await fetch(editUrl);
                if (!response.ok) throw new Error('Gagal mengambil data untuk diedit!');
                
                const data = await response.json();

                // Isi semua field form dengan data dari server
                form.querySelector('#pegawai_id_edit').value = data.pegawai_id;
                form.querySelector('#litabmas_edit').value = data.litabmas;
                form.querySelector('#kategori_pembicara_edit').value = data.kategori_pembicara;
                form.querySelector('#lingkup_edit').value = data.lingkup;
                form.querySelector('#judul_makalah_edit').value = data.judul_makalah;
                form.querySelector('#nama_pertemuan_edit').value = data.nama_pertemuan;
                form.querySelector('#penyelenggara_edit').value = data.penyelenggara;
                form.querySelector('#tanggal_pelaksana_edit').value = data.tanggal_pelaksana;
                form.querySelector('#bahasa_edit').value = data.bahasa;
                form.querySelector('#jenis_dokumen_edit').value = data.jenis_dokumen;
                form.querySelector('#nama_dokumen_edit').value = data.nama_dokumen;
                form.querySelector('#nomor_dokumen_edit').value = data.nomor_dokumen;
                form.querySelector('#tautan_dokumen_edit').value = data.tautan_dokumen;
                
                // Tampilkan nama file yang sudah ada jika ada
                if(data.dokumen) {
                    const fileName = data.dokumen.split('/').pop();
                    uploadAreaText.innerHTML = `File sudah ada: <strong>${fileName}</strong><br><small>Unggah file baru untuk mengganti.</small>`;
                }

            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memuat data. Silakan coba lagi.');
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
            // Cari elemen terdekat yang merupakan tombol hapus dengan atribut data-delete-url
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
    const semesterFilter = document.getElementById('semesterFilter');
    const statusFilter = document.getElementById('statusFilter');
    const tableBody = document.getElementById('orasiIlmiahTableBody');
    const allRows = tableBody.querySelectorAll('tr:not(#noDataFoundRow)');
    const noDataRow = document.getElementById('noDataFoundRow');

    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase();
        const semesterValue = semesterFilter.value;
        const statusValue = statusFilter.value;
        
        // --- AWAL KODE BARU UNTUK UPDATE URL ---
        const params = new URLSearchParams();
        if (searchTerm) params.append('cari', searchTerm);
        if (semesterValue) params.append('semester', semesterValue);
        if (statusValue) params.append('status', statusValue);

        // Membuat URL baru dan memperbarui address bar tanpa reload
        // history.pushState(null, '', `?${params.toString()}`);
        // Kita gunakan replaceState agar tidak memenuhi history browser
        const newUrl = window.location.pathname + (params.toString() ? `?${params.toString()}` : '');
        history.replaceState(null, '', newUrl);
        // --- AKHIR KODE BARU UNTUK UPDATE URL ---

        let visibleRowCount = 0;
        allRows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            const rowTanggal = row.dataset.tanggal;
            const rowStatus = row.dataset.status;

            const searchMatch = rowText.includes(searchTerm);
            const statusMatch = (statusValue === "") || (rowStatus === statusValue);
            
            let semesterMatch = true;
            if (semesterValue) {
                const [filterSemester, filterYear] = semesterValue.split('-');
                const rowDate = new Date(rowTanggal);
                const rowMonth = rowDate.getMonth() + 1;
                const rowYear = rowDate.getFullYear();

                if (filterSemester === 'ganjil') {
                    semesterMatch = (rowMonth >= 1 && rowMonth <= 6) && (rowYear == filterYear);
                } else if (filterSemester === 'genap') {
                    semesterMatch = (rowMonth >= 7 && rowMonth <= 12) && (rowYear == filterYear);
                }
            }
            
            if (searchMatch && statusMatch && semesterMatch) {
                row.style.display = '';
                visibleRowCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        noDataRow.style.display = (visibleRowCount === 0) ? '' : 'none';
    }

    // Fungsi untuk membaca URL saat halaman dimuat dan menerapkan filter
    function applyFiltersFromUrl() {
        const params = new URLSearchParams(window.location.search);
        
        // Set nilai input/select dari parameter URL
        searchInput.value = params.get('cari') || '';
        semesterFilter.value = params.get('semester') || '';
        statusFilter.value = params.get('status') || '';

        // Terapkan filter
        applyFilters();
    }

    // Tambahkan event listener ke setiap elemen filter
    searchInput.addEventListener('input', applyFilters);
    semesterFilter.addEventListener('change', applyFilters);
    statusFilter.addEventListener('change', applyFilters);

    // Jalankan fungsi ini saat halaman pertama kali dimuat
    applyFiltersFromUrl();
});