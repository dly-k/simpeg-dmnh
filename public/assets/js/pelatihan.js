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

  setInterval(updateDateTime, 1000);
  updateDateTime();
});

// === Modal Functions ===
function openModal(modalId) {
  const modal = document.getElementById(modalId);
  if (!modal) return;

  const modalTitle = modal.querySelector('#modalTitle');
  const form = modal.querySelector('form');
  const anggotaList = document.getElementById('anggota-list');

  if (modalTitle) {
    modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Pelatihan';
  }

  if (form) {
    form.reset();
  }

  if (anggotaList) {
    anggotaList.innerHTML = '';
  }

  modal.style.display = 'flex';
}

function openEditModal() {
  const modal = document.getElementById('pelatihanModal');
  if (!modal) return;

  const modalTitle = modal.querySelector('#modalTitle');
  if (modalTitle) {
    modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Pelatihan';
  }

  modal.style.display = 'flex';
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.style.display = 'none';
  }
}

function addAnggota() {
  const list = document.getElementById('anggota-list');
  if (!list) return;

  const newRow = document.createElement('div');
  newRow.className = 'dynamic-row';
  newRow.innerHTML = `
    <button type="button" class="btn-close dynamic-row-close-btn" aria-label="Close" onclick="this.parentElement.remove()"></button>
    <div class="row g-2">
      <div class="col-12">
        <label class="form-label form-label-sm">Nama Anggota</label>
        <input type="text" class="form-control form-control-sm" placeholder="Nama Anggota">
      </div>
      <div class="col-md-6">
        <label class="form-label form-label-sm">Angkatan</label>
        <input type="text" class="form-control form-control-sm" placeholder="Angkatan">
      </div>
      <div class="col-md-6">
        <label class="form-label form-label-sm">Predikat</label>
        <input type="text" class="form-control form-control-sm" placeholder="Predikat">
      </div>
    </div>
  `;
  list.appendChild(newRow);
}

// === Close modal if backdrop is clicked ===
window.addEventListener('click', function (event) {
  if (event.target.classList.contains('modal-backdrop')) {
    closeModal(event.target.id);
  }
});

// --modal detail pelatihan ---
// Ambil elemen-elemen untuk modal Detail Pelatihan
const pelatihanDetailModal = document.getElementById("pelatihanDetailModal");
const openPelatihanDetailBtn = document.getElementById("btnLihatPelatihanDetail");
const closePelatihanDetailBtn = document.getElementById("closePelatihanDetailBtn");

// Pastikan tombol pemicu ada sebelum menambahkan event listener
if (openPelatihanDetailBtn) {
    // Tampilkan modal ketika tombol 'Lihat Detail' diklik
    openPelatihanDetailBtn.onclick = function() {
      pelatihanDetailModal.style.display = "block";
    }
}

// Sembunyikan modal ketika tombol 'Tutup' diklik
closePelatihanDetailBtn.onclick = function() {
  pelatihanDetailModal.style.display = "none";
}

// Sembunyikan modal ketika pengguna mengklik area di luar modal
window.onclick = function(event) {
  if (event.target == pelatihanDetailModal) {
    pelatihanDetailModal.style.display = "none";
  }
}