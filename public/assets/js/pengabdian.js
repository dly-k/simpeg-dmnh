document.addEventListener('DOMContentLoaded', function () {
  // === Sidebar Logic ===
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const toggleSidebarBtn = document.getElementById('toggleSidebar');

  if (toggleSidebarBtn && sidebar && overlay) {
    toggleSidebarBtn.addEventListener('click', function () {
      const isMobile = window.innerWidth <= 991;

      if (isMobile) {
        // Logika untuk Mobile (tampilkan overlay)
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show', sidebar.classList.contains('show'));
      } else {
        // Logika untuk Desktop (toggle sidebar)
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
    modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Pengabdian';
  }

  if (form) {
    form.reset();
  }

  // Clear dynamic lists
  const dosenList = document.getElementById('dosen-list');
  const mahasiswaList = document.getElementById('mahasiswa-list');
  const kolaboratorList = document.getElementById('kolaborator-list');

  if (dosenList) dosenList.innerHTML = '';
  if (mahasiswaList) mahasiswaList.innerHTML = '';
  if (kolaboratorList) kolaboratorList.innerHTML = '';

  modal.style.display = 'flex';
}

function openEditModal() {
  const modal = document.getElementById('pengabdianModal');
  if (!modal) return;

  const modalTitle = modal.querySelector('#modalTitle');
  if (modalTitle) {
    modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Pengabdian';
  }

  // Di sini kamu bisa isi form dengan data yang ada (belum diterapkan)
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

  switch (type) {
    case 'dosen':
      container = document.getElementById('dosen-list');
      content = `
        <div class="dynamic-row">
          <div class="row g-2">
            <div class="col-12"><input type="text" class="form-control form-control-sm" placeholder="Nama Dosen"></div>
            <div class="col-md-6"><select class="form-select form-select-sm"><option selected>Jabatan</option></select></div>
            <div class="col-md-6"><select class="form-select form-select-sm"><option selected>Aktif</option></select></div>
          </div>
          <button class="btn btn-sm dynamic-row-close-btn" type="button" onclick="this.parentElement.remove()">
            <i class="fa fa-times"></i>
          </button>
        </div>`;
      break;

    case 'mahasiswa':
      container = document.getElementById('mahasiswa-list');
      content = `
        <div class="dynamic-row">
          <div class="row g-2">
            <div class="col-md-6"><select class="form-select form-select-sm"><option selected>Strata</option></select></div>
            <div class="col-md-6"><input type="text" class="form-control form-control-sm" placeholder="Nama Mahasiswa"></div>
            <div class="col-md-6"><select class="form-select form-select-sm"><option selected>Jabatan</option></select></div>
            <div class="col-md-6"><select class="form-select form-select-sm"><option selected>Aktif</option></select></div>
          </div>
          <button class="btn btn-sm dynamic-row-close-btn" type="button" onclick="this.parentElement.remove()">
            <i class="fa fa-times"></i>
          </button>
        </div>`;
      break;

    case 'kolaborator':
    default:
      container = document.getElementById('kolaborator-list');
      content = `
        <div class="dynamic-row">
          <div class="row g-2">
            <div class="col-12"><input type="text" class="form-control form-control-sm" placeholder="Nama Kolaborator"></div>
            <div class="col-md-6"><select class="form-select form-select-sm"><option selected>Jabatan</option></select></div>
            <div class="col-md-6"><select class="form-select form-select-sm"><option selected>Aktif</option></select></div>
          </div>
          <button class="btn btn-sm dynamic-row-close-btn" type="button" onclick="this.parentElement.remove()">
            <i class="fa fa-times"></i>
          </button>
        </div>`;
      break;
  }

  if (container) {
    container.insertAdjacentHTML('beforeend', content);
  }
}

// === Close Modal When Clicking on Backdrop ===
window.onclick = function (event) {
  if (event.target.classList.contains('modal-backdrop')) {
    closeModal(event.target.id);
  }
};

// DETAIL MODAL
// Ambil elemen-elemen untuk modal Detail Pengabdian dengan nama baru
const pengabdianDetailModal = document.getElementById("pengabdianDetailModal");
const openPengabdianDetailBtn = document.getElementById("btnLihatPengabdian");
const closePengabdianDetailBtn = document.getElementById("closePengabdianDetailBtn");

// Pastikan elemen tombol ada sebelum menambahkan event listener
if (openPengabdianDetailBtn) {
    // Tampilkan modal ketika tombol 'Lihat Detail' diklik
    openPengabdianDetailBtn.onclick = function() {
      pengabdianDetailModal.style.display = "block";
    }
}

// Sembunyikan modal ketika tombol 'Tutup' diklik
closePengabdianDetailBtn.onclick = function() {
  pengabdianDetailModal.style.display = "none";
}

// Sembunyikan modal ketika pengguna mengklik area di luar modal
window.onclick = function(event) {
  if (event.target == pengabdianDetailModal) {
    pengabdianDetailModal.style.display = "none";
  }
}