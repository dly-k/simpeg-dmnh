document.addEventListener('DOMContentLoaded', function () {
  // === MODAL BERHASIL (SUCCESS MODAL) LOGIC ===
  const modalBerhasil = document.getElementById('modalBerhasil');
  const berhasilTitle = document.getElementById('berhasil-title');
  const berhasilSubtitle = document.getElementById('berhasil-subtitle');
  let successModalTimeout = null;

  const successSound = new Audio('assets/sounds/success.mp3'); // Pastikan path ini benar
  successSound.preload = 'auto';
  successSound.volume = 0.5;

  function showSuccessModal(title, subtitle) {
    if (modalBerhasil && berhasilTitle && berhasilSubtitle) {
      berhasilTitle.textContent = title;
      berhasilSubtitle.textContent = subtitle;
      modalBerhasil.classList.add('show');
      document.body.style.overflow = 'hidden'; // Nonaktifkan scroll

      if (typeof successSound.play === 'function') {
        successSound.play().catch(error => {
          console.error('Error playing success sound:', error);
        });
      }

      clearTimeout(successModalTimeout);
      successModalTimeout = setTimeout(() => {
        hideSuccessModal();
      }, 1200);
    }
  }
  
  function hideSuccessModal() {
    if (modalBerhasil) {
      modalBerhasil.classList.remove('show');
      document.body.style.overflow = ''; // Aktifkan kembali scroll
    }
  }

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

  // === Date and Time ===
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

  // === Dynamic Member Remove ===
  ['dosen-list', 'mahasiswa-list', 'kolaborator-list'].forEach(listId => {
    const listContainer = document.getElementById(listId);
    if (listContainer) {
      listContainer.addEventListener('click', function(event) {
        if (event.target.closest('.dynamic-row-close-btn')) {
          event.target.closest('.dynamic-row').remove();
        }
      });
    }
  });

  // === File Upload ===
  document.querySelectorAll('.upload-area').forEach(uploadArea => {
    const fileInput = uploadArea.querySelector('input[type="file"]');
    const uploadText = uploadArea.querySelector('p');
    if (!fileInput || !uploadText) return;

    const originalText = uploadText.innerHTML;

    uploadArea.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', function () {
      uploadText.textContent = this.files.length > 0 ? this.files[0].name : originalText;
    });

    uploadArea.reset = () => {
      uploadText.innerHTML = originalText;
      fileInput.value = '';
    };
  });

  // === Tombol Simpan (Tambah/Edit) ===
  const simpanBtn = document.querySelector('#pengabdianModal .btn-success');
  if (simpanBtn) {
    simpanBtn.addEventListener('click', function() {
      closeModal('pengabdianModal');
      showSuccessModal('Data Berhasil Disimpan', 'Data pengabdian telah berhasil disimpan ke sistem.');
    });
  }

  // === DETAIL MODAL ===
  const pengabdianDetailModal = document.getElementById("pengabdianDetailModal");
  const closePengabdianDetailBtn = document.getElementById("closePengabdianDetailBtn");

  document.addEventListener('click', function(event) {
    if (event.target.closest('.btn-lihat[data-bs-target="#pengabdianDetailModal"]')) {
      if (pengabdianDetailModal) pengabdianDetailModal.style.display = "block";
    }
  });

  closePengabdianDetailBtn?.addEventListener('click', () => {
    if (pengabdianDetailModal) pengabdianDetailModal.style.display = "none";
  });

  /* ===============================
     KONFIRMASI VERIFIKASI MODAL
     =============================== */
  const verifModal = document.getElementById("modalKonfirmasiVerifikasi");
  const btnTerima = document.getElementById("popupBtnTerima");
  const btnTolak = document.getElementById("popupBtnTolak");
  const btnKembali = document.getElementById("popupBtnKembali");

  document.addEventListener("click", function (event) {
    if (event.target.closest(".btn-verifikasi")) {
      event.preventDefault();
      verifModal.classList.add("show");
    }
  });

  btnKembali?.addEventListener("click", function () {
    verifModal.classList.remove("show");
  });

  btnTerima?.addEventListener("click", function () {
    verifModal.classList.remove("show");
    showSuccessModal("Data Diverifikasi", "Data pengabdian berhasil diverifikasi");
  });

  btnTolak?.addEventListener("click", function () {
    verifModal.classList.remove("show");
    showSuccessModal("Data Ditolak", "Data pengabdian telah ditolak");
  });

  verifModal?.addEventListener("click", function (event) {
    if (event.target === verifModal) {
      verifModal.classList.remove("show");
    }
  });

  // === Delete Confirmation Modal (FIXED) ===
  const deleteModal = document.getElementById('modalKonfirmasiHapus');
  const btnBatalHapus = document.getElementById('btnBatalHapus');
  const btnKonfirmasiHapus = document.getElementById('btnKonfirmasiHapus');
  let dataToDelete = null;

  document.addEventListener('click', function(event) {
    const hapusButton = event.target.closest('.btn-hapus');
    if (hapusButton) {
      event.preventDefault(); // Mencegah aksi default link
      dataToDelete = hapusButton.closest('tr').querySelector('td:first-child').textContent;
      if (deleteModal) {
        deleteModal.classList.add('show');
        document.body.style.overflow = 'hidden'; // Nonaktifkan scroll
      }
    }
  });
  
  function hideDeleteModal() {
    if (deleteModal) {
      deleteModal.classList.remove('show');
      // Hanya aktifkan scroll jika tidak ada modal lain yang terbuka
      if (!document.querySelector('.modal-berhasil-overlay.show')) {
        document.body.style.overflow = '';
      }
    }
  }

  btnBatalHapus?.addEventListener('click', hideDeleteModal);

  btnKonfirmasiHapus?.addEventListener('click', function() {
    if (dataToDelete) {
      console.log(`Data dengan ID ${dataToDelete} akan dihapus`);
    }
    hideDeleteModal();
    showSuccessModal('Data Berhasil Dihapus', 'Data yang dipilih telah berhasil dihapus secara permanen.');
  });
});

// === Modal Functions (Global Scope & FIXED) ===
function openModal(modalId) {
  const modal = document.getElementById(modalId);
  if (!modal) return;

  const modalTitle = modal.querySelector('#modalTitle');
  const form = modal.querySelector('form');

  if (modalTitle) {
    modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Pengabdian';
  }

  form?.reset();

  document.querySelectorAll('.upload-area').forEach(uploadArea => {
    if (typeof uploadArea.reset === 'function') {
      uploadArea.reset();
    }
  });
  
  ['dosen-list', 'mahasiswa-list', 'kolaborator-list'].forEach(id => {
    const list = document.getElementById(id);
    if(list) list.innerHTML = '';
  });

  modal.style.display = 'flex';
  document.body.style.overflow = 'hidden'; // Nonaktifkan scroll
}

function openEditModal() {
  const modal = document.getElementById('pengabdianModal');
  if (!modal) return;

  const modalTitle = modal.querySelector('#modalTitle');
  if (modalTitle) {
    modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Pengabdian';
  }
  
  modal.style.display = 'flex';
  document.body.style.overflow = 'hidden'; // Nonaktifkan scroll
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.style.display = 'none';
    document.body.style.overflow = ''; // Aktifkan kembali scroll
  }
}

// === Dynamic Member Add ===
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

  if (container) container.insertAdjacentHTML('beforeend', content);
}


window.addEventListener('click', function (event) {
  const pengabdianDetailModal = document.getElementById("pengabdianDetailModal");
  if (event.target === pengabdianDetailModal) {
    pengabdianDetailModal.style.display = "none";
  }

  const deleteModal = document.getElementById("modalKonfirmasiHapus");
  if (event.target === deleteModal) {
    hideDeleteModal(); // Gunakan fungsi agar scroll diaktifkan kembali
  }

  const pengabdianModal = document.getElementById("pengabdianModal");
  if (event.target === pengabdianModal) {
    closeModal("pengabdianModal");
  }
});