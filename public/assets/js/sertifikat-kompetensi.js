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
});