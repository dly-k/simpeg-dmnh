// === Inisialisasi Setelah Halaman Dimuat ===
document.addEventListener('DOMContentLoaded', function () {
  // Inisialisasi komponen utama
  initSidebar();
  initClock();
  initSuratTugasPage();
  initModalInteractions();
  initUploadArea(); // BARU: Inisialisasi area upload

  // Inisialisasi menu editor (jika ada)
  const editorBtn = document.querySelector('[data-bs-target="#editorKegiatan"]');
  const editorMenu = document.getElementById('editorKegiatan');
  if (editorBtn && editorMenu) {
    editorBtn.classList.remove('collapsed');
    editorBtn.setAttribute('aria-expanded', 'true');
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
    const deleteBtn = event.target.closest('.btn-hapus');
    
    if (editBtn) {
      event.preventDefault();
      const rowIndex = editBtn.closest('tr').dataset.index;
      const itemData = dataSuratTugas[rowIndex];
      if (itemData) openEditModal(itemData);
    }
    
    if (deleteBtn) {
      event.preventDefault();
      if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        const row = deleteBtn.closest('tr');
        console.log('Menghapus data di baris:', parseInt(row.dataset.index) + 1);
        row.remove();
      }
    }
  });
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

// === Fungsi Modal ===
function openModal(modalId) {
  const modal = document.getElementById(modalId);
  if (!modal) return;
  const modalTitle = modal.querySelector('#modalTitle');
  const form = modal.querySelector('form');

  if (modalTitle) modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Surat Tugas';
  if (form) form.reset();
  
  // PENYESUAIAN: Reset area upload
  const uploadArea = modal.querySelector('.upload-area');
  if (uploadArea && typeof uploadArea.reset === 'function') {
    uploadArea.reset();
  }
  
  modal.style.display = 'flex';
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
  
  // PENYESUAIAN: Reset area upload
  const uploadArea = modal.querySelector('.upload-area');
  if (uploadArea && typeof uploadArea.reset === 'function') {
    uploadArea.reset();
  }
  
  modal.style.display = 'flex';
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) modal.style.display = 'none';
}

function initModalInteractions() {
  window.addEventListener('click', function (event) {
    if (event.target.classList.contains('modal-backdrop')) {
      closeModal(event.target.id);
    }
  });
}

// BARU: Fungsi untuk menangani semua area upload
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

    // Buat fungsi reset yang bisa dipanggil dari luar
    uploadArea.reset = function() {
      uploadText.innerHTML = originalText;
      fileInput.value = ''; // Penting untuk membersihkan file yang sudah dipilih
    };
  });
}