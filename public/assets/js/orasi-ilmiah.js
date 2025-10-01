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
});