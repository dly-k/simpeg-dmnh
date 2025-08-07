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
            <button class="btn btn-aksi btn-delete-row" title="Hapus">
              <i class="fa fa-trash"></i>
            </button>
          </div>
        </td>
      </tr>
    `).join('');
  }

  renderTable();
});

// --- Modal Functions ---
function openModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.style.display = 'flex';
  }
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.style.display = 'none';
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

// --- Close modal if backdrop clicked ---
window.onclick = function (event) {
  if (event.target.classList.contains('modal-backdrop')) {
    closeModal(event.target.id);
  }
};