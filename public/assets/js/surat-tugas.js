document.addEventListener('DOMContentLoaded', function () {
  // === Sidebar Toggle ===
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const toggleSidebarBtn = document.getElementById('toggleSidebar');
  const body = document.body;

  if (toggleSidebarBtn && sidebar && overlay) {
    toggleSidebarBtn.addEventListener('click', function () {
      const isMobile = window.innerWidth <= 991;
      if (isMobile) {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show', sidebar.classList.contains('show'));
      } else {
        sidebar.classList.toggle('hidden');
        body.classList.toggle('sidebar-collapsed');
      }
    });

    overlay.addEventListener('click', function () {
      sidebar.classList.remove('show');
      overlay.classList.remove('show');
    });
  }

  // === Auto Expand Editor Menu ===
  const editorBtn = document.querySelector('[data-bs-target="#editorKegiatan"]');
  const editorMenu = document.getElementById('editorKegiatan');
  if (editorBtn && editorMenu) {
    editorBtn.classList.remove('collapsed');
    editorBtn.setAttribute('aria-expanded', 'true');
    editorMenu.classList.add('show');
  }

  // === Date and Time Display ===
  function updateDateTime() {
    const now = new Date();
    const dateEl = document.getElementById('current-date');
    const timeEl = document.getElementById('current-time');

    const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit' };

    if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', dateOptions);
    if (timeEl) timeEl.textContent = now.toLocaleTimeString('id-ID', timeOptions);
  }

  updateDateTime();
  setInterval(updateDateTime, 1000);

  // === Load Static Table Data ===
  const data = [
    {
      nama: 'Dr. Stone',
      peran: 'Dosen',
      sebagai: 'Penelitian',
      mitra: 'Pt. Lele Berkumis',
      surat_instansi: '001/INT/2025 - 1 Juni 2025',
      surat_kadep: '001/INT/2025 - 1 Juni 2025',
      tgl_kegiatan: '20 Juni 2021',
      lokasi: 'Empang Hj Ujang'
    },
    {
      nama: 'Joko Anwar S.pd',
      peran: 'Dosen',
      sebagai: 'Pengabdian',
      mitra: 'Desa Cikoneng',
      surat_instansi: '002/EXT/2025 - 5 Juni 2025',
      surat_kadep: '002/EXT/2025 - 6 Juni 2025',
      tgl_kegiatan: '25 Juli 2021',
      lokasi: 'Balai Desa'
    },
    {
      nama: 'Ria Kodariah, S.Si',
      peran: 'Dosen',
      sebagai: 'Narasumber',
      mitra: 'Universitas Maju Jaya',
      surat_instansi: '003/UMJ/2025 - 10 Juni 2025',
      surat_kadep: '003/UMJ/2025 - 11 Juni 2025',
      tgl_kegiatan: '1 Agustus 2021',
      lokasi: 'Auditorium Univ'
    }
  ];

  const tbody = document.getElementById('data-body');

  if (tbody) {
    data.forEach((item, index) => {
      tbody.innerHTML += `
        <tr>
          <td class="text-center">${index + 1}</td>
          <td>${item.nama}</td>
          <td class="text-center">${item.peran}</td>
          <td class="text-center">${item.sebagai}</td>
          <td>${item.mitra}</td>
          <td class="text-center">${item.surat_instansi}</td>
          <td class="text-center">${item.surat_kadep}</td>
          <td class="text-center">${item.tgl_kegiatan}</td>
          <td>${item.lokasi}</td>
          <td class="text-center">
            <button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button>
          </td>
          <td class="text-center">
            <div class="d-flex gap-2 justify-content-center">
              <a href="#" class="btn-aksi btn-edit" title="Edit Data" onclick="openEditModal()">
                <i class="fa fa-edit"></i>
              </a>
              <a href="#" class="btn-aksi btn-hapus" title="Hapus Data">
                <i class="fa fa-trash"></i>
              </a>
            </div>
          </td>
        </tr>
      `;
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
    modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Surat Tugas';
  }
  if (form) {
    form.reset();
  }
  modal.style.display = 'flex';
}

function openEditModal() {
  const modal = document.getElementById('suratTugasModal');
  if (!modal) return;

  const modalTitle = modal.querySelector('#modalTitle');
  if (modalTitle) {
    modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Surat Tugas';
  }
  modal.style.display = 'flex';
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.style.display = 'none';
  }
}

// === Close Modal via Backdrop Click ===
window.onclick = function (event) {
  if (event.target.classList.contains('modal-backdrop')) {
    closeModal(event.target.id);
  }
};