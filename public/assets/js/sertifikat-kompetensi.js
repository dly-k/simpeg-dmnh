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
});