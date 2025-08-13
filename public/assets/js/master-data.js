document.addEventListener('DOMContentLoaded', function () {
  // --- Sidebar Logic ---
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

  // --- Date & Time Update ---
  function updateDateTime() {
    const now = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };

    const dateEl = document.getElementById('current-date');
    const timeEl = document.getElementById('current-time');

    if (dateEl && timeEl) {
      dateEl.textContent = now.toLocaleDateString('id-ID', options);
      timeEl.textContent = now.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
      });
    }
  }

  setInterval(updateDateTime, 1000);
  updateDateTime();

  // --- Table Rendering ---
  const userData = [
    { name: 'Dr. Soni Trison, S.Hut, M.Si', user: 'Kadep_soni', role: 'Admin' },
    { name: 'Ria Kodariah, S.Si', user: 'Kadep_ria', role: 'Admin' },
    { name: 'Meli Surnami', user: 'Staff_meli', role: 'Administrasi Kepegawaian' },
    { name: 'Saeful Rohim', user: 'Staff_saeful', role: 'Administrasi Kepegawaian' }
  ];

  let selectedDeleteIndex = null;

  function renderTable() {
    const tableBody = document.getElementById('userDataBody');
    if (!tableBody) return;

    tableBody.innerHTML = userData.map((item, index) => `
      <tr>
        <td>${index + 1}</td>
        <td class="text-start">${item.name}</td>
        <td>${item.user}</td>
        <td>••••••••••</td>
        <td>${item.role}</td>
        <td>
          <div class="d-flex gap-2 justify-content-center">
            <button class="btn btn-aksi btn-edit-row" title="Edit" onclick="openEditModal('${item.name}', '${item.user}', '${item.role}')">
              <i class="fa fa-edit"></i>
            </button>
            <button class="btn btn-aksi btn-delete-row" title="Hapus" data-index="${index}">
              <i class="fa fa-trash"></i>
            </button>
          </div>
        </td>
      </tr>
    `).join('');

    // Event tombol hapus → buka modal
    document.querySelectorAll('.btn-delete-row').forEach(btn => {
      btn.addEventListener('click', function () {
        selectedDeleteIndex = parseInt(this.getAttribute('data-index'));
        openModal('modalKonfirmasiHapus');
      });
    });
  }

  renderTable();

  // --- Modal Hapus Logic ---
  const btnBatalHapus = document.getElementById('btnBatalHapus');
  const btnKonfirmasiHapus = document.getElementById('btnKonfirmasiHapus');

  if (btnBatalHapus) {
    btnBatalHapus.addEventListener('click', function () {
      closeModal('modalKonfirmasiHapus');
      selectedDeleteIndex = null;
    });
  }

  if (btnKonfirmasiHapus) {
    btnKonfirmasiHapus.addEventListener('click', function () {
      if (selectedDeleteIndex !== null) {
        userData.splice(selectedDeleteIndex, 1);
        renderTable();
        closeModal('modalKonfirmasiHapus');
        selectedDeleteIndex = null;
      }
    });
  }

  // Tutup semua modal jika klik di luar konten
  document.querySelectorAll('.modal-backdrop, .konfirmasi-hapus-overlay').forEach(modal => {
    modal.addEventListener('click', function (e) {
      if (e.target === modal) {
        closeModal(modal.id);
      }
    });
  });
});

// --- Modal Functions with animation ---
function openModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.style.display = 'flex';
    requestAnimationFrame(() => modal.classList.add('show'));
  }
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.classList.remove('show');
    modal.addEventListener('transitionend', () => {
      modal.style.display = 'none';
    }, { once: true });
  }
}

function openEditModal(nama, user, role) {
  const namaField = document.getElementById('editNamaPegawai');
  const userField = document.getElementById('editIdPengguna');
  const roleField = document.getElementById('editHakAkses');

  if (namaField) namaField.value = nama;
  if (userField) userField.value = user;
  if (roleField) roleField.value = role;

  openModal('editDataModal');
}
