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
      
      // Simpan fungsi reset pada elemen untuk dipanggil nanti
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
    modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data SK Non PNS';
  }
  if (form) {
    form.reset();
  }

  // TEMPLATE: Reset area upload jika ada
  const uploadArea = modal.querySelector('.upload-area');
  if (uploadArea && typeof uploadArea.reset === 'function') {
    uploadArea.reset();
  }

  modal.style.display = 'flex';
}

function openEditModal() {
  const modal = document.getElementById('skNonPnsModal');
  if (!modal) return;
  const modalTitle = modal.querySelector('#modalTitle');
  if (modalTitle) {
    modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data SK Non PNS';
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