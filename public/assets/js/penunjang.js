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
});

// === Modal Logic ===
function openModal(modalId) {
  const modal = document.getElementById(modalId);
  if (!modal) return;

  const modalTitle = modal.querySelector('#modalTitle');
  const form = modal.querySelector('form');

  if (modalTitle) {
    modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Penunjang';
  }

  if (form) {
    form.reset();
  }

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

  // Di sini kamu bisa menambahkan pengisian data jika diperlukan

  modal.style.display = 'flex';
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.style.display = 'none';
  }
}

// === Tambah Dokumen Dinamis ===
function addDokumen() {
  const list = document.getElementById('dokumen-list');
  if (!list) return;

  const newRow = document.createElement('div');
  newRow.className = 'border rounded p-3 mb-3';
  newRow.innerHTML = `
    <div class="row g-2">
      <div class="col-12">
        <select class="form-select form-select-sm">
          <option selected>-- Pilih Jenis Dokumen --</option>
        </select>
      </div>
      <div class="col-md-4">
        <input type="text" class="form-control form-control-sm" placeholder="Nama Dokumen">
      </div>
      <div class="col-md-4">
        <input type="text" class="form-control form-control-sm" placeholder="Nomor">
      </div>
      <div class="col-md-4">
        <input type="text" class="form-control form-control-sm" placeholder="Tautan">
      </div>
      <div class="col-12">
        <div class="upload-area" style="padding: 1rem;">
          <i class="fas fa-cloud-upload-alt"></i>
          <p class="mb-0"><small>Drag & Drop File / Max 5 MB</small></p>
          <input type="file" hidden>
        </div>
      </div>
    </div>
    <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="this.parentElement.remove()">
      <i class="fa fa-trash"></i> Hapus Dokumen
    </button>
  `;
  list.appendChild(newRow);
}

// === Tambah Anggota Dinamis ===
function addAnggota() {
  const list = document.getElementById('anggota-list');
  if (!list) return;

  const newRow = document.createElement('div');
  newRow.className = 'input-group mb-2';
  newRow.innerHTML = `
    <input type="text" class="form-control" placeholder="Nama Dosen">
    <select class="form-select">
      <option selected>-- Pilih Salah Satu Peran --</option>
    </select>
    <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">
      <i class="fa fa-trash"></i>
    </button>
  `;
  list.appendChild(newRow);
}

// === Tutup modal jika backdrop diklik ===
window.onclick = function (event) {
  if (event.target.classList.contains('modal-backdrop')) {
    closeModal(event.target.id);
  }
};