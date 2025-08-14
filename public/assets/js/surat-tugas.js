// === Inisialisasi Setelah Halaman Dimuat ===
document.addEventListener('DOMContentLoaded', function () {
  // Inisialisasi komponen utama
  initSidebar();
  initClock();
  initSuratTugasPage();
  initModalInteractions();
  initUploadArea();

  // [BARU] Logika untuk membuka dropdown "Editor Kegiatan"
  const editorBtn = document.querySelector('button[data-bs-target="#editorKegiatan"]');
  const editorMenu = document.getElementById('editorKegiatan');
  
  if (editorBtn && editorMenu) {
    // Hapus kelas 'collapsed' dari tombol
    editorBtn.classList.remove('collapsed');
    // Set atribut 'aria-expanded' menjadi 'true'
    editorBtn.setAttribute('aria-expanded', 'true');
    // Tambah kelas 'show' ke menu dropdown
    editorMenu.classList.add('show');
  }
});


// === Logika Sidebar ===
function initSidebar() {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const toggleSidebarBtn = document.getElementById('toggleSidebar');
  const body = document.body;

  toggleSidebarBtn?.addEventListener('click', function () {
    const isMobile = window.innerWidth <= 991;
    if (isMobile) {
      sidebar.classList.toggle('show');
      overlay.classList.toggle('show', sidebar.classList.contains('show'));
    } else {
      sidebar.classList.toggle('hidden');
      body.classList.toggle('sidebar-collapsed');
    }
  });

  overlay?.addEventListener('click', function () {
    sidebar.classList.remove('show');
    overlay.classList.remove('show');
  });
}

// === Logika Waktu ===
function initClock() {
  const dateEl = document.getElementById('current-date');
  const timeEl = document.getElementById('current-time');

  function updateDateTime() {
    if (!dateEl || !timeEl) return;
    const now = new Date();
    const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', timeZone: 'Asia/Jakarta' };
    const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', timeZone: 'Asia/Jakarta', hour12: false };
    dateEl.textContent = now.toLocaleDateString('id-ID', dateOptions);
    timeEl.textContent = now.toLocaleTimeString('id-ID', timeOptions);
  }
  updateDateTime();
  setInterval(updateDateTime, 1000);
}

// === Data & Logika Halaman Surat Tugas ===
const dataSuratTugas = [
    { nama: 'Dr. Stone', peran: 'Dosen', sebagai: 'Penelitian', mitra: 'Pt. Lele Berkumis', surat_instansi: '001/INT/2025 - 1 Juni 2025', surat_kadep: '001/INT/2025 - 1 Juni 2025', tgl_kegiatan: '2021-06-20', lokasi: 'Empang Hj Ujang' },
    { nama: 'Joko Anwar S.pd', peran: 'Dosen', sebagai: 'Pengabdian', mitra: 'Desa Cikoneng', surat_instansi: '002/EXT/2025 - 5 Juni 2025', surat_kadep: '002/EXT/2025 - 6 Juni 2025', tgl_kegiatan: '2021-07-25', lokasi: 'Balai Desa' },
    { nama: 'Ria Kodariah, S.Si', peran: 'Dosen', sebagai: 'Narasumber', mitra: 'Universitas Maju Jaya', surat_instansi: '003/UMJ/2025 - 10 Juni 2025', surat_kadep: '003/UMJ/2025 - 11 Juni 2025', tgl_kegiatan: '2021-08-01', lokasi: 'Auditorium Univ' }
];

function initSuratTugasPage() {
  renderTable();
  const tbody = document.getElementById('data-body');

  tbody?.addEventListener('click', function(event) {
    const editBtn = event.target.closest('.btn-edit');
    if (editBtn) {
      event.preventDefault();
      const rowIndex = editBtn.closest('tr').dataset.index;
      const itemData = dataSuratTugas[rowIndex];
      if (itemData) openEditModal(itemData);
    }
  });

  initDeleteConfirmation();
}

function renderTable() {
  const tbody = document.getElementById('data-body');
  if (!tbody) return;

  tbody.innerHTML = dataSuratTugas.map((item, index) => `
    <tr data-index="${index}">
      <td class="text-center">${index + 1}</td>
      <td>${item.nama}</td>
      <td class="text-center">${item.peran}</td>
      <td class="text-center">${item.sebagai}</td>
      <td>${item.mitra}</td>
      <td class="text-center">${item.surat_instansi}</td>
      <td class="text-center">${item.surat_kadep}</td>
      <td class="text-center">${new Date(item.tgl_kegiatan).toLocaleDateString('id-ID', {day:'2-digit', month: 'long', year:'numeric'})}</td>
      <td>${item.lokasi}</td>
      <td class="text-center"><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
      <td class="text-center">
        <div class="d-flex gap-2 justify-content-center">
          <a href="#" class="btn-aksi btn-edit" title="Edit Data"><i class="fa fa-edit"></i></a>
          <a href="#" class="btn-aksi btn-hapus" title="Hapus Data"><i class="fa fa-trash"></i></a>
        </div>
      </td>
    </tr>
  `).join('');
}

// === Fungsi Modal (Tambah/Edit) ===
function openModal(modalId) {
  const modal = document.getElementById(modalId);
  if (!modal) return;
  const modalTitle = modal.querySelector('#modalTitle');
  const form = modal.querySelector('form');

  if (modalTitle) modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Surat Tugas';
  if (form) form.reset();
  
  const uploadArea = modal.querySelector('.upload-area');
  if (uploadArea && typeof uploadArea.reset === 'function') uploadArea.reset();
  
  modal.classList.add('show');
}

function openEditModal(data) {
  const modal = document.getElementById('suratTugasModal');
  if (!modal) return;
  const modalTitle = modal.querySelector('#modalTitle');
  const form = modal.querySelector('form');

  if (modalTitle) modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Surat Tugas';
  
  if (form && data) {
    form.reset();
    for (const key in data) {
      const input = form.querySelector(`[name="${key}"]`);
      if (input) input.value = data[key];
    }
  }
  
  const uploadArea = modal.querySelector('.upload-area');
  if (uploadArea && typeof uploadArea.reset === 'function') uploadArea.reset();
  
  modal.classList.add('show');
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) modal.classList.remove('show');
}

function initModalInteractions() {
  const addEditModal = document.getElementById('suratTugasModal');
  addEditModal?.addEventListener('click', function (event) {
    if (event.target === addEditModal) {
      closeModal(addEditModal.id);
    }
  });
}

// === Logika Modal Konfirmasi Hapus ===
function initDeleteConfirmation() {
    const tableBody = document.getElementById('data-body');
    const modal = document.getElementById('modalKonfirmasiHapus');
    if (!tableBody || !modal) return;

    const btnBatal = document.getElementById('btnBatalHapus');
    const btnKonfirmasi = document.getElementById('btnKonfirmasiHapus');
    let rowToDelete = null;

    tableBody.addEventListener('click', function(event) {
        const deleteButton = event.target.closest('.btn-hapus');
        if (deleteButton) {
            event.preventDefault();
            rowToDelete = deleteButton.closest('tr');
            modal.classList.add('show');
        }
    });

    btnKonfirmasi.addEventListener('click', function() {
        if (rowToDelete) {
            console.log(`Menghapus data baris ke-${parseInt(rowToDelete.dataset.index) + 1}`);
            rowToDelete.remove();
            modal.classList.remove('show');
            rowToDelete = null;
        }
    });

    function hideDeleteModal() {
        modal.classList.remove('show');
        rowToDelete = null;
    }

    btnBatal.addEventListener('click', hideDeleteModal);

    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            hideDeleteModal();
        }
    });
}

// === Fungsi Area Upload ===
function initUploadArea() {
  document.querySelectorAll('.upload-area').forEach(uploadArea => {
    const fileInput = uploadArea.querySelector('input[type="file"]');
    const uploadText = uploadArea.querySelector('p');
    if (!fileInput || !uploadText) return;

    const originalText = uploadText.innerHTML;

    uploadArea.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', function() {
      if (this.files.length > 0) {
        uploadText.textContent = this.files[0].name;
      } else {
        uploadText.innerHTML = originalText;
      }
    });

    uploadArea.reset = function() {
      uploadText.innerHTML = originalText;
      fileInput.value = '';
    };
  });
}