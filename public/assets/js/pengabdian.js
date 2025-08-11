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
    const dateOptions = {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    };
    const timeOptions = {
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit',
      hour12: false,
      timeZone: 'Asia/Jakarta'
    };

    const dateEl = document.getElementById('current-date');
    const timeEl = document.getElementById('current-time');

    if (dateEl && timeEl) {
      dateEl.textContent = now.toLocaleDateString('id-ID', dateOptions);
      timeEl.textContent = now.toLocaleTimeString('id-ID', timeOptions);
    }
  }

  updateDateTime();
  setInterval(updateDateTime, 1000);

  // === Dynamic Member Remove Logic (Event Delegation) ===
  function setupDynamicListRemovals() {
    const lists = ['dosen-list', 'mahasiswa-list', 'kolaborator-list'];
    lists.forEach(listId => {
      const listContainer = document.getElementById(listId);
      if (listContainer) {
        listContainer.addEventListener('click', function(event) {
          if (event.target.closest('.dynamic-row-close-btn')) {
            event.target.closest('.dynamic-row').remove();
          }
        });
      }
    });
  }
  setupDynamicListRemovals();
  
  // === File Upload Logic ===
  function setupUploadArea() {
    // Menangani semua .upload-area di halaman
    document.querySelectorAll('.upload-area').forEach(uploadArea => {
        const fileInput = uploadArea.querySelector('input[type="file"]');
        const uploadText = uploadArea.querySelector('p');
        
        if (!fileInput || !uploadText) return;

        const originalText = uploadText.innerHTML;

        uploadArea.addEventListener('click', function () {
            fileInput.click();
        });

        fileInput.addEventListener('change', function () {
            if (this.files.length > 0) {
                uploadText.textContent = this.files[0].name;
            } else {
                uploadText.innerHTML = originalText;
            }
        });

        // Menyimpan fungsi reset pada elemen untuk dipanggil nanti
        uploadArea.reset = function() {
            uploadText.innerHTML = originalText;
        }
    });
  }
  setupUploadArea();


  // === DETAIL MODAL Logic ===
  const pengabdianDetailModal = document.getElementById("pengabdianDetailModal");
  const openPengabdianDetailBtn = document.getElementById("btnLihatPengabdian");
  const closePengabdianDetailBtn = document.getElementById("closePengabdianDetailBtn");

  if (openPengabdianDetailBtn && pengabdianDetailModal) {
    openPengabdianDetailBtn.addEventListener('click', function() {
      pengabdianDetailModal.style.display = "block";
    });
  }

  if (closePengabdianDetailBtn && pengabdianDetailModal) {
    closePengabdianDetailBtn.addEventListener('click', function() {
      pengabdianDetailModal.style.display = "none";
    });
  }
});


// === Modal Logic (Global Functions) ===
function openModal(modalId) {
  const modal = document.getElementById(modalId);
  if (!modal) return;

  const modalTitle = modal.querySelector('#modalTitle');
  const form = modal.querySelector('form');

  if (modalTitle) {
    modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Pengabdian';
  }

  if (form) {
    form.reset();
  }

  // Clear dynamic lists
  ['dosen-list', 'mahasiswa-list', 'kolaborator-list'].forEach(id => {
    const list = document.getElementById(id);
    if(list) list.innerHTML = '';
  });

  // Reset upload area text
  const uploadArea = modal.querySelector('.upload-area');
  if (uploadArea && typeof uploadArea.reset === 'function') {
      uploadArea.reset();
  }

  modal.style.display = 'flex';
}

function openEditModal() {
  const modal = document.getElementById('pengabdianModal');
  if (!modal) return;

  const modalTitle = modal.querySelector('#modalTitle');
  if (modalTitle) {
    modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Pengabdian';
  }

  modal.style.display = 'flex';
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.style.display = 'none';
  }
}

// === Dynamic Member Add Logic ===
function addAnggota(type) {
  let container, content;
  
  const removeButton = `
    <button class="btn btn-sm dynamic-row-close-btn" type="button">
      <i class="fa fa-times"></i>
    </button>`;

  switch (type) {
    case 'dosen':
      container = document.getElementById('dosen-list');
      content = `<div class="dynamic-row"><div class="row g-2"><div class="col-12"><input type="text" class="form-control form-control-sm" placeholder="Nama Dosen"></div><div class="col-md-6"><select class="form-select form-select-sm"><option selected>Jabatan</option></select></div><div class="col-md-6"><select class="form-select form-select-sm"><option selected>Aktif</option></select></div></div>${removeButton}</div>`;
      break;
    case 'mahasiswa':
      container = document.getElementById('mahasiswa-list');
      content = `<div class="dynamic-row"><div class="row g-2"><div class="col-md-6"><select class="form-select form-select-sm"><option selected>Strata</option></select></div><div class="col-md-6"><input type="text" class="form-control form-control-sm" placeholder="Nama Mahasiswa"></div><div class="col-md-6"><select class="form-select form-select-sm"><option selected>Jabatan</option></select></div><div class="col-md-6"><select class="form-select form-select-sm"><option selected>Aktif</option></select></div></div>${removeButton}</div>`;
      break;
    case 'kolaborator':
    default:
      container = document.getElementById('kolaborator-list');
      content = `<div class="dynamic-row"><div class="row g-2"><div class="col-12"><input type="text" class="form-control form-control-sm" placeholder="Nama Kolaborator"></div><div class="col-md-6"><select class="form-select form-select-sm"><option selected>Jabatan</option></select></div><div class="col-md-6"><select class="form-select form-select-sm"><option selected>Aktif</option></select></div></div>${removeButton}</div>`;
      break;
  }

  if (container) {
    container.insertAdjacentHTML('beforeend', content);
  }
}

// === Close Modals on Click Outside ===
window.addEventListener('click', function (event) {
  if (event.target.classList.contains('modal-backdrop')) {
    closeModal(event.target.id);
  }
  
  const pengabdianDetailModal = document.getElementById("pengabdianDetailModal");
  if (event.target === pengabdianDetailModal) {
    pengabdianDetailModal.style.display = "none";
  }
});