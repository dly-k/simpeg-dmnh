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

  // === PENINGKATAN: Event Delegation untuk elemen dinamis ===
  function setupDynamicInteractions() {
    // 1. Event listener untuk list dokumen
    const dokumenList = document.getElementById('dokumen-list');
    if (dokumenList) {
      dokumenList.addEventListener('click', function(event) {
        // Logika untuk tombol hapus dokumen
        const removeBtn = event.target.closest('.btn-outline-danger');
        if (removeBtn) {
          removeBtn.closest('.border.rounded').remove();
          return; // Hentikan eksekusi agar tidak memicu upload
        }
        
        // Logika untuk upload area
        const uploadArea = event.target.closest('.upload-area');
        if (uploadArea) {
          const fileInput = uploadArea.querySelector('input[type="file"]');
          if (fileInput) fileInput.click();
        }
      });

      // Listener untuk perubahan file input di dalam list dokumen
      dokumenList.addEventListener('change', function(event){
        if(event.target.matches('input[type="file"]')){
          const uploadArea = event.target.closest('.upload-area');
          const p = uploadArea.querySelector('p');
          if (event.target.files.length > 0) {
            p.innerHTML = `<small>${event.target.files[0].name}</small>`;
          }
        }
      });
    }

    // 2. Event listener untuk list anggota
    const anggotaList = document.getElementById('anggota-list');
    if (anggotaList) {
      anggotaList.addEventListener('click', function(event) {
        const removeBtn = event.target.closest('.btn-outline-danger');
        if (removeBtn) {
          removeBtn.closest('.input-group').remove();
        }
      });
    }
  }
  setupDynamicInteractions();


  // === PENINGKATAN: Detail Modal Logic ===
  const penunjangDetailModal = document.getElementById("penunjangDetailModal");
  const openPenunjangDetailBtn = document.getElementById("btnLihatPenunjangDetail");
  const closePenunjangDetailBtn = document.getElementById("closePenunjangDetailBtn");

  if (openPenunjangDetailBtn && penunjangDetailModal) {
    openPenunjangDetailBtn.addEventListener('click', function() {
      penunjangDetailModal.style.display = "block";
    });
  }
  if (closePenunjangDetailBtn && penunjangDetailModal) {
    closePenunjangDetailBtn.addEventListener('click', function() {
      penunjangDetailModal.style.display = "none";
    });
  }
});


// === Global Functions ===

function openModal(modalId) {
  const modal = document.getElementById(modalId);
  if (!modal) return;
  const modalTitle = modal.querySelector('#modalTitle');
  const form = modal.querySelector('form');
  if (modalTitle) {
    modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Penunjang';
  }
  if (form) form.reset();
  
  // Kosongkan list dinamis
  const dokumenList = document.getElementById('dokumen-list');
  const anggotaList = document.getElementById('anggota-list');
  if (dokumenList) dokumenList.innerHTML = '';
  if (anggotaList) anggotaList.innerHTML = '';

  modal.style.display = 'flex';
}

function openEditModal() {
  const modal = document.getElementById('penunjangModal');
  if (!modal) return;
  const modalTitle = modal.querySelector('#modalTitle');
  if (modalTitle) {
    modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Penunjang';
  }
  modal.style.display = 'flex';
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) modal.style.display = 'none';
}

function addDokumen() {
  const list = document.getElementById('dokumen-list');
  if (!list) return;

  const newRow = document.createElement('div');
  newRow.className = 'border rounded p-3 mb-3';
  // PERBAIKAN: Atribut onclick pada tombol hapus dihilangkan
  newRow.innerHTML = `
    <div class="row g-2">
      <div class="col-12"><select class="form-select form-select-sm"><option selected>-- Pilih Jenis Dokumen --</option></select></div>
      <div class="col-md-4"><input type="text" class="form-control form-control-sm" placeholder="Nama Dokumen"></div>
      <div class="col-md-4"><input type="text" class="form-control form-control-sm" placeholder="Nomor"></div>
      <div class="col-md-4"><input type="text" class="form-control form-control-sm" placeholder="Tautan"></div>
      <div class="col-12">
        <div class="upload-area" style="padding: 1rem;">
          <i class="fas fa-cloud-upload-alt"></i>
          <p class="mb-0"><small>Drag & Drop File / Max 5 MB</small></p>
          <input type="file" hidden>
        </div>
      </div>
    </div>
    <button type="button" class="btn btn-sm btn-outline-danger mt-2">
      <i class="fa fa-trash"></i> Hapus Dokumen
    </button>
  `;
  list.appendChild(newRow);
}

function addAnggota() {
  const list = document.getElementById('anggota-list');
  if (!list) return;

  const newRow = document.createElement('div');
  newRow.className = 'input-group mb-2';
  // PERBAIKAN: Atribut onclick pada tombol hapus dihilangkan
  newRow.innerHTML = `
    <input type="text" class="form-control" placeholder="Nama Dosen">
    <select class="form-select"><option selected>-- Pilih Salah Satu Peran --</option></select>
    <button class="btn btn-outline-danger" type="button">
      <i class="fa fa-trash"></i>
    </button>
  `;
  list.appendChild(newRow);
}

// PERBAIKAN: Menggabungkan semua listener klik di luar modal
window.addEventListener('click', function (event) {
  // Untuk modal utama dengan backdrop
  if (event.target.classList.contains('modal-backdrop')) {
    closeModal(event.target.id);
  }
  
  // Untuk modal detail tanpa backdrop
  const penunjangDetailModal = document.getElementById("penunjangDetailModal");
  if (event.target === penunjangDetailModal) {
    penunjangDetailModal.style.display = "none";
  }
});