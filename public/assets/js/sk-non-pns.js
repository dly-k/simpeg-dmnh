// ========================================================================
// == FUNGSI MODAL BERHASIL (GAYA KUSTOM) ==
// ========================================================================
const modalBerhasil = document.getElementById("modalBerhasil");
const berhasilTitle = document.getElementById("berhasil-title");
const berhasilSubtitle = document.getElementById("berhasil-subtitle");
let successModalTimeout = null;
let successAudio = null;

const showSuccessModal = (title, subtitle) => {
  if (!modalBerhasil || !berhasilTitle || !berhasilSubtitle) return;
  berhasilTitle.textContent = title;
  berhasilSubtitle.textContent = subtitle;
  modalBerhasil.style.display = 'flex';
  requestAnimationFrame(() => {
    modalBerhasil.classList.add("show");
  });
  document.body.style.overflow = "hidden";
  successAudio = new Audio("/assets/sounds/success.mp3");
  successAudio.play().catch((err) => console.warn("Audio Gagal:", err));
  clearTimeout(successModalTimeout);
  successModalTimeout = setTimeout(hideSuccessModal, 1300);
};

const hideSuccessModal = () => {
  if (modalBerhasil && modalBerhasil.classList.contains('show')) {
    modalBerhasil.classList.remove("show");
    modalBerhasil.addEventListener('transitionend', () => {
      if (!modalBerhasil.classList.contains('show')) {
        modalBerhasil.style.display = 'none';
        if (!document.querySelector(".konfirmasi-hapus-overlay.show, .modal.show")) {
          document.body.style.overflow = "";
        }
      }
    }, { once: true });
  }
};

document.getElementById("btnSelesai")?.addEventListener("click", () => {
    clearTimeout(successModalTimeout);
    hideSuccessModal();
});


// ========================================================================
// == INISIALISASI HALAMAN SK NON PNS ==
// ========================================================================
document.addEventListener("DOMContentLoaded", () => {
    
    initUploadAreas();
    initSkNonPnsModal();
    initTableActions();

    function initUploadAreas() {
        document.querySelectorAll(".upload-area").forEach((uploadArea) => {
            const fileInput = uploadArea.querySelector('input[type="file"]');
            const uploadText = uploadArea.querySelector("p");
            if (!fileInput || !uploadText) return;
            const originalText = uploadText.innerHTML;
            
            // [PERUBAHAN] Dapatkan elemen feedback
            const feedbackEl = document.getElementById('file-size-feedback-sk');

            uploadArea.addEventListener("click", () => fileInput.click());
            fileInput.addEventListener("change", function() {
                if (this.files.length) {
                    uploadText.textContent = this.files[0].name;
                } else {
                    uploadText.innerHTML = originalText;
                }
                // [PERUBAHAN] Sembunyikan pesan error saat file baru dipilih
                if (feedbackEl) {
                    feedbackEl.style.display = 'none';
                    feedbackEl.textContent = '';
                }
            });
        });
    }

    function initSkNonPnsModal() {
        const modalEl = document.getElementById("skNonPnsModal");
        if (!modalEl) return;
        
        const form = document.getElementById('skNonPnsForm');
        const modalTitle = document.getElementById('skNonPnsModalLabel');
        const editMethodContainer = document.getElementById('editMethod');
        const btnSimpan = document.getElementById('btn-simpan');
        const dokumenLamaContainer = document.getElementById('dokumen-lama-container');
        const dokumenLamaLink = document.getElementById('dokumen-lama-link');
        const dokumenLabel = document.getElementById('dokumen_label');
        const fileInput = document.getElementById('dokumen_sk');
        
        // [PERUBAHAN BARU] Tambahkan event listener untuk validasi saat form disubmit
        form.addEventListener('submit', function(event) {
            const file = fileInput.files[0];
            const feedbackEl = document.getElementById('file-size-feedback-sk');
            
            if (file) { // Hanya validasi jika ada file yang dipilih
                const maxSizeInBytes = 5 * 1024 * 1024; // 5 MB
                if (file.size > maxSizeInBytes) {
                    event.preventDefault(); // Mencegah form untuk submit
                    feedbackEl.textContent = `File terlalu besar! Ukuran maksimal 5 MB. (File Anda: ${(file.size / 1024 / 1024).toFixed(2)} MB)`;
                    feedbackEl.style.display = 'block';
                }
            }
        });

        modalEl.addEventListener('show.bs.modal', async function(event) {
            const button = event.relatedTarget;
            const isEditMode = button && button.classList.contains('btn-edit');
            
            // [PERUBAHAN] Sembunyikan pesan error setiap modal dibuka
            const feedbackEl = document.getElementById('file-size-feedback-sk');
            if (feedbackEl) feedbackEl.style.display = 'none';

            form.reset();
            form.querySelector('.upload-area p').innerHTML = 'Seret & Lepas File di sini atau Klik untuk Pilih File';
            dokumenLamaContainer.style.display = 'none';
            editMethodContainer.innerHTML = '';

            if (isEditMode) {
                btnSimpan.disabled = true;
                modalTitle.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat Data...';
                
                const id = button.dataset.id;
                try {
                    const response = await fetch(`/sk-non-pns/${id}/edit`);
                    if (!response.ok) throw new Error('Gagal memuat data');
                    const data = await response.json();

                    document.getElementById('nama_pegawai').value = data.nama_pegawai || '';
                    document.getElementById('nama_unit').value = data.nama_unit || '';
                    document.getElementById('tanggal_mulai').value = data.tanggal_mulai || '';
                    document.getElementById('tanggal_selesai').value = data.tanggal_selesai || '';
                    document.getElementById('nomor_sk').value = data.nomor_sk || '';
                    document.getElementById('tanggal_sk').value = data.tanggal_sk || '';
                    document.getElementById('jenis_sk').value = data.jenis_sk || '';
                    
                    form.action = `/sk-non-pns/${id}`;
                    editMethodContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                    modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data SK Non PNS';
                    btnSimpan.textContent = 'Simpan Perubahan';
                    dokumenLabel.textContent = 'Unggah Dokumen Baru (Opsional)';
                    fileInput.required = false;

                    if (data.dokumen_path) {
                        dokumenLamaLink.href = `/storage/${data.dokumen_path.replace('public/', '')}`;
                        dokumenLamaContainer.style.display = 'block';
                    }
                } catch (error) {
                    console.error('Error saat fetch data edit:', error);
                    modalTitle.innerHTML = '<i class="fas fa-times-circle"></i> Gagal Memuat Data';
                } finally {
                    btnSimpan.disabled = false;
                }
            } else {
                modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data SK Non PNS';
                form.action = '/sk-non-pns/store';
                btnSimpan.textContent = 'Simpan';
                dokumenLabel.textContent = 'Unggah Dokumen SK (PDF, Maks 5MB)';
                fileInput.required = true;
            }
        });
    }

    function initTableActions() {
        // ... (Fungsi ini tidak perlu diubah)
        const konfirmasiHapusModalEl = document.getElementById("modalKonfirmasiHapus");
        if (!konfirmasiHapusModalEl) return;
        const hapusTitle = document.querySelector("#modalKonfirmasiHapus .konfirmasi-hapus-title");
        const hapusSubtitle = document.querySelector("#modalKonfirmasiHapus .konfirmasi-hapus-subtitle");
        let dataToDelete = { id: null, element: null, nama: null };
        const showDeleteModal = () => {
            konfirmasiHapusModalEl.style.display = 'flex';
            requestAnimationFrame(() => konfirmasiHapusModalEl.classList.add('show'));
            document.body.style.overflow = "hidden";
        };
        const hideDeleteModal = () => {
            if (konfirmasiHapusModalEl.classList.contains('show')) {
                konfirmasiHapusModalEl.classList.remove('show');
                konfirmasiHapusModalEl.addEventListener('transitionend', () => {
                    if (!konfirmasiHapusModalEl.classList.contains('show')) {
                        konfirmasiHapusModalEl.style.display = 'none';
                        if (!document.querySelector(".modal.show, .modal-berhasil-overlay.show")) {
                            document.body.style.overflow = "";
                        }
                    }
                }, { once: true });
            }
        };
        document.body.addEventListener('click', async function(event) {
            const target = event.target;
            const button = target.closest('a, button');
            if (!button) return;
            const detailButton = target.closest(".btn-lihat-detail");
            if (detailButton) {
                event.preventDefault();
                const data = detailButton.dataset;
                const setText = (id, value) => {
                    const el = document.getElementById(id);
                    if (el) el.textContent = value || "-";
                };
                setText("detail_sk_nomor_sk", data.nomor_sk);
                setText("detail_sk_tanggal_sk", data.tanggal_sk);
                setText("detail_sk_pegawai", data.pegawai);
                setText("detail_sk_unit", data.unit);
                setText("detail_sk_jenis_sk", data.jenis_sk);
                setText("detail_sk_tgl_mulai", data.tgl_mulai);
                setText("detail_sk_tgl_selesai", data.tgl_selesai);
                document.getElementById("detail_sk_document_viewer")?.setAttribute("src", data.dokumen_path || "");
            }
            const hapusButton = target.closest(".btn-hapus");
            if (hapusButton && hapusButton.hasAttribute('data-id')) {
                event.preventDefault();
                dataToDelete.id = hapusButton.dataset.id;
                dataToDelete.nama = hapusButton.dataset.nama;
                dataToDelete.element = hapusButton.closest('tr');
                if (hapusTitle) hapusTitle.textContent = `Apakah Anda Yakin?`;
                if (hapusSubtitle) hapusSubtitle.textContent = `Data untuk ${dataToDelete.nama} akan dihapus permanen.`;
                showDeleteModal();
            }
            if (target.matches("#btnKonfirmasiHapus")) {
                event.preventDefault();
                if (!dataToDelete.id) return;
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                target.disabled = true;
                target.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menghapus...';
                try {
                    const response = await fetch(`/sk-non-pns/${dataToDelete.id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                    });
                    const result = await response.json();
                    if (!response.ok || !result.success) throw new Error(result.message);
                    dataToDelete.element.remove();
                    hideDeleteModal();
                    setTimeout(() => showSuccessModal("Berhasil Dihapus!", result.message), 300);
                } catch (error) {
                    console.error('Error saat menghapus data:', error);
                    alert(error.message || 'Gagal menghapus data.');
                    hideDeleteModal();
                } finally {
                    dataToDelete = { id: null, element: null, nama: null };
                    target.disabled = false;
                    target.innerHTML = 'Ya, Hapus';
                }
            }
            if (target.matches("#btnBatalHapus") || target === konfirmasiHapusModalEl) {
                hideDeleteModal();
            }
        });
    }
});