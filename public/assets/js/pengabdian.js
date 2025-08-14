document.addEventListener('DOMContentLoaded', function () {
  // === MODAL BERHASIL (SUCCESS MODAL) LOGIC ===
  const modalBerhasil = document.getElementById('modalBerhasil');
  const berhasilTitle = document.getElementById('berhasil-title');
  const berhasilSubtitle = document.getElementById('berhasil-subtitle');
  let successModalTimeout = null;

  function showSuccessModal(title, subtitle) {
    if (modalBerhasil && berhasilTitle && berhasilSubtitle) {
      berhasilTitle.textContent = title;
      berhasilSubtitle.textContent = subtitle;
      modalBerhasil.classList.add('show'); // Gunakan class 'show' untuk menampilkan
      
      clearTimeout(successModalTimeout);
      successModalTimeout = setTimeout(() => {
        hideSuccessModal();
      }, 1200); // Durasi 1.2 detik
    }
  }
  
  function hideSuccessModal() {
    modalBerhasil?.classList.remove('show');
  }

  // Listener untuk tombol 'Selesai' di modal berhasil
  document.getElementById('btnSelesai')?.addEventListener('click', () => {
    clearTimeout(successModalTimeout);
    hideSuccessModal();
  });


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

        uploadArea.reset = function() {
            uploadText.innerHTML = originalText;
        }
    });
  }
  setupUploadArea();
  
  // === [BARU] Tombol Simpan Logic ===
  const simpanBtn = document.querySelector('#pengabdianModal .btn-success');
  if (simpanBtn) {
    simpanBtn.addEventListener('click', function() {
      closeModal('pengabdianModal');
      showSuccessModal('Data Berhasil Disimpan', 'Data pengabdian telah berhasil disimpan ke sistem.');
    });
  }


  // === DETAIL MODAL Logic ===
  const pengabdianDetailModal = document.getElementById("pengabdianDetailModal");
  const closePengabdianDetailBtn = document.getElementById("closePengabdianDetailBtn");

  document.addEventListener('click', function(event) {
    if (event.target.closest('#btnLihatPengabdian')) {
      if (pengabdianDetailModal) {
        pengabdianDetailModal.style.display = "block";
      }
    }
  });

  if (closePengabdianDetailBtn && pengabdianDetailModal) {
    closePengabdianDetailBtn.addEventListener('click', function() {
      pengabdianDetailModal.style.display = "none";
    });
  }

  // === Verifikasi Confirmation Modal Logic ===
  const verifModal = document.getElementById('modalKonfirmasiPengabdian');
  const btnTerima = document.getElementById('popupBtnTerima');
  const btnTolak = document.getElementById('popupBtnTolak');
  const btnKembali = document.getElementById('popupBtnKembali');
  
  document.addEventListener('click', function(event) {
    if (event.target.closest('.btn-verifikasi')) {
      event.preventDefault();
      if (verifModal) verifModal.style.display = 'flex';
    }
  });
  
  function hideVerifModal() {
    if (verifModal) verifModal.style.display = 'none';
  }

  if (verifModal) {
    verifModal.addEventListener('click', (e) => {
      if (e.target === verifModal) hideVerifModal();
    });
  }
  
  if (btnTerima) {
    btnTerima.addEventListener('click', function() {
      hideVerifModal();
      showSuccessModal('Status Verifikasi Disimpan', 'Perubahan status verifikasi telah berhasil disimpan.');
    });
  }
  
  if (btnTolak) {
    btnTolak.addEventListener('click', function() {
      hideVerifModal();
      showSuccessModal('Status Verifikasi Disimpan', 'Perubahan status verifikasi telah berhasil disimpan.');
    });
  }
  
  if (btnKembali) {
    btnKembali.addEventListener('click', hideVerifModal);
  }

  // === Delete Confirmation Modal Logic ===
  const deleteModal = document.getElementById('modalKonfirmasiHapus');
  const btnBatalHapus = document.getElementById('btnBatalHapus');
  const btnKonfirmasiHapus = document.getElementById('btnKonfirmasiHapus');
  let dataToDelete = null;

  document.addEventListener('click', function(event) {
    if (event.target.closest('.btn-hapus')) {
      event.preventDefault();
      dataToDelete = event.target.closest('tr').querySelector('td:first-child').textContent;
      if (deleteModal) deleteModal.style.display = 'flex';
    }
  });
  
  function hideDeleteModal() {
    if (deleteModal) deleteModal.style.display = 'none';
  }

  if (deleteModal) {
    deleteModal.addEventListener('click', (e) => {
      if (e.target === deleteModal) hideDeleteModal();
    });
  }

  if (btnBatalHapus) {
    btnBatalHapus.addEventListener('click', hideDeleteModal);
  }

  if (btnKonfirmasiHapus) {
    btnKonfirmasiHapus.addEventListener('click', function() {
      if (dataToDelete) {
        console.log(`Data dengan ID ${dataToDelete} akan dihapus`);
      }
      hideDeleteModal();
      showSuccessModal('Data Berhasil Dihapus', 'Data yang dipilih telah berhasil dihapus secara permanen.');
    });
  }
});

// === Modal Functions ===
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

  ['dosen-list', 'mahasiswa-list', 'kolaborator-list'].forEach(id => {
    const list = document.getElementById(id);
    if(list) list.innerHTML = '';
  });

  document.querySelectorAll('.upload-area').forEach(uploadArea => {
    if (uploadArea && typeof uploadArea.reset === 'function') {
      uploadArea.reset();
    }
  });

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

// === Dynamic Member Add Function ===
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

  const deleteModal = document.getElementById("modalKonfirmasiHapus");
  if (event.target === deleteModal) {
    deleteModal.style.display = "none";
  }
});