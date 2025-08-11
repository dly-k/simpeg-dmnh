document.addEventListener('DOMContentLoaded', function () {
  // === Sidebar Logic ===
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const toggleSidebarBtn = document.getElementById('toggleSidebar');

  if (toggleSidebarBtn && sidebar && overlay) {
    toggleSidebarBtn.addEventListener('click', function () {
      const isMobile = window.innerWidth <= 991;
      if (isMobile) {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show', sidebar.classList.contains('show'));
      } else {
        sidebar.classList.toggle('hidden');
      }
    });

    overlay.addEventListener('click', function () {
      sidebar.classList.remove('show');
      overlay.classList.remove('show');
    });
  }

  // === Date and Time Logic ===
  function updateDateTime() {
    const now = new Date();
    const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false, timeZone: 'Asia/Jakarta' };
    const dateEl = document.getElementById('current-date');
    const timeEl = document.getElementById('current-time');
    if (dateEl && timeEl) {
      dateEl.textContent = now.toLocaleDateString('id-ID', dateOptions);
      timeEl.textContent = now.toLocaleTimeString('id-ID', timeOptions);
    }
  }
  updateDateTime();
  setInterval(updateDateTime, 1000);

  // === TEMPLATE: Event Delegation untuk Item Dinamis ===
  // Ganti '#dynamic-list-container' dengan ID kontainer list Anda
  const dynamicList = document.getElementById('dynamic-list-container'); 
  if (dynamicList) {
    dynamicList.addEventListener('click', function(event) {
      // Ganti '.remove-button' dengan class tombol hapus Anda
      if (event.target.closest('.remove-button')) {
        // Ganti '.dynamic-item' dengan class item yang ingin dihapus
        event.target.closest('.dynamic-item').remove();
      }
    });
  }

  // === TEMPLATE: File Upload Logic ===
  function setupUploadArea() {
    document.querySelectorAll('.upload-area').forEach(uploadArea => {
      const fileInput = uploadArea.querySelector('input[type="file"]');
      const uploadText = uploadArea.querySelector('p');
      if (!fileInput || !uploadText) return;

      const originalText = uploadText.innerHTML;

      uploadArea.addEventListener('click', () => fileInput.click());
      fileInput.addEventListener('change', function () {
        if (this.files.length > 0) {
          uploadText.textContent = this.files[0].name;
        }
      });
      
      uploadArea.reset = function() {
        uploadText.innerHTML = originalText;
        fileInput.value = '';
      };
    });
  }
  setupUploadArea();

  // === TEMPLATE: Detail Modal Logic ===
  // Ganti dengan ID elemen modal detail Anda
  const detailModal = document.getElementById("detailModal"); 
  const openDetailBtn = document.getElementById("btnLihatDetail");
  const closeDetailBtn = document.getElementById("closeDetailBtn");

  if (openDetailBtn && detailModal) {
    openDetailBtn.addEventListener('click', () => {
      detailModal.style.display = "block";
    });
  }
  if (closeDetailBtn && detailModal) {
    closeDetailBtn.addEventListener('click', () => {
      detailModal.style.display = "none";
    });
  }
});

// === Global Modal Functions ===

function openModal(modalId) {
  const modal = document.getElementById(modalId);
  if (!modal) return;
  const modalTitle = modal.querySelector('#modalTitle');
  const form = modal.querySelector('form');

  if (modalTitle) {
    modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Penghargaan';
  }
  if (form) {
    form.reset();
  }

  // TEMPLATE: Reset elemen-elemen dinamis saat modal dibuka
  const dynamicList = document.getElementById('dynamic-list-container');
  if (dynamicList) dynamicList.innerHTML = '';
  
  const uploadArea = modal.querySelector('.upload-area');
  if (uploadArea && typeof uploadArea.reset === 'function') {
    uploadArea.reset();
  }

  modal.style.display = 'flex';
}

function openEditModal(modalId) { // Ganti nama modal jika perlu
  const modal = document.getElementById(modalId);
  if (!modal) return;
  const modalTitle = modal.querySelector('#modalTitle');
  if (modalTitle) {
    modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Penghargaan';
  }
  modal.style.display = 'flex';
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.style.display = 'none';
  }
}

// === PERBAIKAN: Listener Klik di Luar Modal ===
window.addEventListener('click', function (event) {
  // Untuk modal utama dengan backdrop
  if (event.target.classList.contains('modal-backdrop')) {
    closeModal(event.target.id);
  }

  // TEMPLATE: Untuk modal detail tanpa backdrop (ganti ID jika perlu)
  const detailModal = document.getElementById("detailModal");
  if (event.target === detailModal) {
    detailModal.style.display = "none";
  }
});

// Logika untuk Modal Detail Penghargaan
document.addEventListener('DOMContentLoaded', function () {
    // Gunakan selector yang lebih umum ke <tbody> tabel penghargaan Anda
    const tableBody = document.querySelector('#penghargaan-table-body'); 
    if (!tableBody) return;

    tableBody.addEventListener('click', function(event) {
        const detailButton = event.target.closest('.btn-lihat-detail-penghargaan');
        
        if (detailButton) {
            const data = detailButton.dataset;

            // Mengisi data utama
            document.getElementById('detail_penghargaan_pegawai').textContent = data.pegawai || '-';
            document.getElementById('detail_penghargaan_kegiatan').textContent = data.kegiatan || '-';
            document.getElementById('detail_penghargaan_nama_penghargaan').textContent = data.nama_penghargaan || '-';
            document.getElementById('detail_penghargaan_nomor').textContent = data.nomor || '-';
            document.getElementById('detail_penghargaan_tanggal_perolehan').textContent = data.tanggal_perolehan || '-';
            document.getElementById('detail_penghargaan_lingkup').textContent = data.lingkup || '-';
            document.getElementById('detail_penghargaan_negara').textContent = data.negara || '-';
            document.getElementById('detail_penghargaan_instansi').textContent = data.instansi || '-';

            // Mengisi data dokumen
            document.getElementById('detail_penghargaan_jenis_dokumen').textContent = data.jenis_dokumen || '-';
            document.getElementById('detail_penghargaan_nama_dokumen').textContent = data.nama_dokumen || '-';
            document.getElementById('detail_penghargaan_nomor_dokumen').textContent = data.nomor_dokumen || '-';
            document.getElementById('detail_penghargaan_tautan').textContent = data.tautan || '-';

            // Memperbarui viewer dokumen
            const docViewer = document.getElementById('detail_penghargaan_document_viewer');
            if (docViewer && data.dokumen_path) {
                docViewer.setAttribute('src', data.dokumen_path);
            } else if (docViewer) {
                docViewer.setAttribute('src', '');
            }
        }
    });
});