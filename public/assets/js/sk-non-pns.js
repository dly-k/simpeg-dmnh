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

// === Modal Functions ===
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

  modal.style.display = 'flex';
}

function openEditModal() {
  const modal = document.getElementById('skNonPnsModal');
  if (!modal) return;

  const modalTitle = modal.querySelector('#modalTitle');

  if (modalTitle) {
    modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data SK Non PNS';
  }

  // Di sini Anda dapat menambahkan logika untuk mengisi data edit jika diperlukan

  modal.style.display = 'flex';
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.style.display = 'none';
  }
}

// === Close modal when clicking backdrop ===
window.onclick = function (event) {
  if (event.target.classList.contains('modal-backdrop')) {
    closeModal(event.target.id);
  }
};