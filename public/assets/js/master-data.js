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
  
  // --- Helper to customize and show success modal ---
  function showSuccessModal(title, subtitle) {
      const berhasilTitle = document.getElementById('berhasil-title');
      const berhasilSubtitle = document.getElementById('berhasil-subtitle');
      if(berhasilTitle) berhasilTitle.textContent = title;
      if(berhasilSubtitle) berhasilSubtitle.textContent = subtitle;
      openModal('modalBerhasil');
      
      // NEW: Menutup modal secara otomatis setelah 1 detik
      setTimeout(() => {
          closeModal('modalBerhasil');
      }, 1000); // 1000 milidetik = 1 detik
  }

  // --- Modal Tambah Logic ---
  const btnSimpanTambah = document.querySelector('#tambahDataModal .btn-success');
  if (btnSimpanTambah) {
      btnSimpanTambah.addEventListener('click', function() {
          closeModal('tambahDataModal');
          showSuccessModal('Data Berhasil Disimpan', 'Data pengguna baru telah berhasil ditambahkan ke sistem.');
      });
  }

  // --- Modal Edit Logic ---
  const btnSimpanEdit = document.querySelector('#editDataModal .btn-success');
  if (btnSimpanEdit) {
      btnSimpanEdit.addEventListener('click', function() {
          closeModal('editDataModal');
          showSuccessModal('Data Berhasil Diperbarui', 'Data pengguna telah berhasil diperbarui di sistem.');
      });
  }

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
    btnKonfirmasiHapus.addEventListener('click', function (e) {
      e.stopPropagation();
      if (selectedDeleteIndex !== null) {
        userData.splice(selectedDeleteIndex, 1);
        renderTable();
        closeModal('modalKonfirmasiHapus');
        
        setTimeout(() => {
            showSuccessModal('Data Berhasil Dihapus', 'Data pengguna telah berhasil dihapus dari sistem.');
        }, 150);
        
        selectedDeleteIndex = null;
      }
    });
  }
  
  // --- Modal Berhasil Logic ---
  // Tombol "Selesai" tidak lagi terlalu penting karena modal menutup otomatis,
  // tapi kita biarkan untuk aksesibilitas jika pengguna ingin menutup lebih cepat.
  const btnSelesai = document.getElementById('btnSelesai');
  if(btnSelesai) {
    btnSelesai.addEventListener('click', function() {
      closeModal('modalBerhasil');
    });
  }

  // Tutup semua modal jika klik di luar konten
  document.querySelectorAll('.modal-backdrop, .konfirmasi-hapus-overlay, .modal-berhasil-overlay').forEach(overlay => {
    overlay.addEventListener('click', function (e) {
      if (e.target === overlay) {
        closeModal(overlay.id);
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
      if (!modal.classList.contains('show')) {
        modal.style.display = 'none';
      }
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