// ==========================
// Inisialisasi Setelah Halaman Dimuat
// ==========================
document.addEventListener('DOMContentLoaded', () => {
  initSidebar();
  initClock();
  initSuratTugasPage();
  initModalInteractions();
  initUploadArea();
  initDeleteConfirmation();
  initSuccessModal();

  // [BARU] Buka dropdown "Editor Kegiatan" secara otomatis
  const editorBtn = document.querySelector('button[data-bs-target="#editorKegiatan"]');
  const editorMenu = document.getElementById('editorKegiatan');

  if (editorBtn && editorMenu) {
    editorBtn.classList.remove('collapsed');
    editorBtn.setAttribute('aria-expanded', 'true');
    editorMenu.classList.add('show');
  }
});

// ==========================
// Sidebar
// ==========================
function initSidebar() {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const toggleSidebarBtn = document.getElementById('toggleSidebar');
  const body = document.body;

  // Fungsi bantuan untuk menutup sidebar di mobile
  const closeMobileSidebar = () => {
    sidebar.classList.remove('show');
    overlay.classList.remove('show');
  };

  // 1. Listener untuk tombol toggle
  toggleSidebarBtn?.addEventListener('click', (event) => {
    // Mencegah klik ini memicu listener pada 'document'
    event.stopPropagation();

    const isMobile = window.innerWidth <= 991;

    if (isMobile) {
      sidebar.classList.toggle('show');
      overlay.classList.toggle('show', sidebar.classList.contains('show'));
    } else {
      sidebar.classList.toggle('hidden');
      body.classList.toggle('sidebar-collapsed');
    }
  });

  // 2. (BARU) Listener global untuk klik di luar sidebar
  document.addEventListener('click', (event) => {
    const isMobile = window.innerWidth <= 991;
    const isSidebarShown = isMobile && sidebar.classList.contains('show');
    // Cek jika target klik BUKAN bagian dari elemen sidebar
    const isClickOutside = !sidebar.contains(event.target);

    // Jika sidebar tampil di mobile dan klik terjadi di luar, tutup sidebar
    if (isSidebarShown && isClickOutside) {
      closeMobileSidebar();
    }
  });

  // Listener untuk overlay kini tidak diperlukan lagi dan bisa dihapus
  // karena sudah ditangani oleh listener 'document' di atas.
  /*
  overlay?.addEventListener('click', () => {
    sidebar.classList.remove('show');
    overlay.classList.remove('show');
  });
  */
}



// ==========================
// Waktu & Tanggal
// ==========================
function initClock() {
  const dateEl = document.getElementById('current-date');
  const timeEl = document.getElementById('current-time');

  function updateDateTime() {
    if (!dateEl || !timeEl) return;

    const now = new Date();
    const dateOptions = {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      timeZone: 'Asia/Jakarta',
    };
    const timeOptions = {
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit',
      timeZone: 'Asia/Jakarta',
      hour12: false,
    };

    dateEl.textContent = now.toLocaleDateString('id-ID', dateOptions);
    timeEl.textContent = now.toLocaleTimeString('id-ID', timeOptions);
  }

  updateDateTime();
  setInterval(updateDateTime, 1000);
}

// ==========================
// Data Surat Tugas
// ==========================
const dataSuratTugas = [
  {
    nama: 'Dr. Stone',
    peran: 'Dosen',
    sebagai: 'Penelitian',
    mitra: 'Pt. Lele Berkumis',
    surat_instansi: '001/INT/2025 - 1 Juni 2025',
    surat_kadep: '001/INT/2025 - 1 Juni 2025',
    tgl_kegiatan: '2021-06-20',
    lokasi: 'Empang Hj Ujang',
  },
  {
    nama: 'Joko Anwar S.pd',
    peran: 'Dosen',
    sebagai: 'Pengabdian',
    mitra: 'Desa Cikoneng',
    surat_instansi: '002/EXT/2025 - 5 Juni 2025',
    surat_kadep: '002/EXT/2025 - 6 Juni 2025',
    tgl_kegiatan: '2021-07-25',
    lokasi: 'Balai Desa',
  },
  {
    nama: 'Budi Setiawan, S.Si',
    peran: 'Dosen',
    sebagai: 'Narasumber',
    mitra: 'Universitas Maju Jaya',
    surat_instansi: '003/UMJ/2025 - 10 Juni 2025',
    surat_kadep: '003/UMJ/2025 - 11 Juni 2025',
    tgl_kegiatan: '2021-08-01',
    lokasi: 'Auditorium Kencana Sakti',
  },
];

// ==========================
// Halaman Surat Tugas
// ==========================
function initSuratTugasPage() {
  renderTable();

  const tbody = document.getElementById('data-body');
  tbody?.addEventListener('click', (event) => {
    const editBtn = event.target.closest('.btn-edit');
    if (editBtn) {
      event.preventDefault();
      const rowIndex = editBtn.closest('tr').dataset.index;
      const itemData = dataSuratTugas[rowIndex];
      if (itemData) openEditModal(itemData);
    }
  });
}

function renderTable() {
  const tbody = document.getElementById('data-body');
  if (!tbody) return;

  tbody.innerHTML = dataSuratTugas
    .map(
      (item, index) => `
    <tr data-index="${index}">
      <td class="text-center">${index + 1}</td>
      <td>${item.nama}</td>
      <td class="text-center">${item.peran}</td>
      <td class="text-center">${item.sebagai}</td>
      <td>${item.mitra}</td>
      <td class="text-center">${item.surat_instansi}</td>
      <td class="text-center">${item.surat_kadep}</td>
      <td class="text-center">${new Date(item.tgl_kegiatan).toLocaleDateString(
        'id-ID',
        { day: '2-digit', month: 'long', year: 'numeric' }
      )}</td>
      <td>${item.lokasi}</td>
      <td class="text-center">
        <button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button>
      </td>
      <td class="text-center">
        <div class="d-flex gap-2 justify-content-center">
          <a href="#" class="btn-aksi btn-edit" title="Edit Data">
            <i class="fa fa-edit"></i>
          </a>
          <a href="#" class="btn-aksi btn-hapus" title="Hapus Data">
            <i class="fa fa-trash"></i>
          </a>
        </div>
      </td>
    </tr>
  `
    )
    .join('');
}

// ==========================
// Modal Tambah / Edit
// ==========================
function openModal(modalId) {
  const modal = document.getElementById(modalId);
  if (!modal) return;

  const modalTitle = modal.querySelector('#modalTitle');
  const form = modal.querySelector('form');

  if (modalTitle) modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Surat Tugas';
  if (form) form.reset();

  const uploadArea = modal.querySelector('.upload-area');
  if (uploadArea?.reset) uploadArea.reset();

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
  if (uploadArea?.reset) uploadArea.reset();

  modal.classList.add('show');
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  modal?.classList.remove('show');
}

function initModalInteractions() {
  const addEditModal = document.getElementById('suratTugasModal');
  addEditModal?.addEventListener('click', (event) => {
    if (event.target === addEditModal) {
      closeModal(addEditModal.id);
    }
  });

  const btnSimpan = document.getElementById('btnSimpanData');
  btnSimpan?.addEventListener('click', () => {
    console.log('Data disimpan/diupdate.');
    closeModal('suratTugasModal');
    showSuccessModal('Data Berhasil Disimpan', 'Data Anda Berhasil Disimpan Pada Sistem');
  });
}

// ==========================
// Modal Konfirmasi Hapus
// ==========================
function initDeleteConfirmation() {
  const tableBody = document.getElementById('data-body');
  const modal = document.getElementById('modalKonfirmasiHapus');
  if (!tableBody || !modal) return;

  const btnBatal = document.getElementById('btnBatalHapus');
  const btnKonfirmasi = document.getElementById('btnKonfirmasiHapus');
  let rowToDelete = null;

  tableBody.addEventListener('click', (event) => {
    const deleteButton = event.target.closest('.btn-hapus');
    if (deleteButton) {
      event.preventDefault();
      rowToDelete = deleteButton.closest('tr');
      modal.classList.add('show');
    }
  });

  btnKonfirmasi.addEventListener('click', () => {
    if (rowToDelete) {
      console.log(`Menghapus data baris ke-${parseInt(rowToDelete.dataset.index) + 1}`);
      rowToDelete.remove();
      hideDeleteModal();
      showSuccessModal('Data Berhasil Dihapus', 'Data yang dipilih telah berhasil dihapus dari sistem.');
      rowToDelete = null;
    }
  });

  function hideDeleteModal() {
    modal.classList.remove('show');
    rowToDelete = null;
  }

  btnBatal.addEventListener('click', hideDeleteModal);
  modal.addEventListener('click', (event) => {
    if (event.target === modal) hideDeleteModal();
  });
}

// ==========================
// Modal Sukses
// ==========================
let successModalTimer;
let successAudio = null; // Variabel untuk menyimpan instance audio

function hideSuccessModal() {
  const modal = document.getElementById('modalBerhasil');
  modal?.classList.remove('show');
  if (successModalTimer) clearTimeout(successModalTimer);
  if (successAudio) {
    successAudio.pause(); // Hentikan audio
    successAudio.currentTime = 0; // Reset audio ke awal
  }
}

function showSuccessModal(title, subtitle) {
  const modal = document.getElementById('modalBerhasil');
  const titleEl = document.getElementById('berhasil-title');
  const subtitleEl = document.getElementById('berhasil-subtitle');

  if (!modal || !titleEl || !subtitleEl) return;

  clearTimeout(successModalTimer);

  titleEl.textContent = title;
  subtitleEl.textContent = subtitle;
  modal.classList.add('show');

  // Putar musik berhasil
  successAudio = new Audio('/assets/sounds/success.mp3'); // Pastikan path file audio benar
  successAudio.play().catch(error => {
    console.log('Error memutar suara:', error);
    if (error.name === 'NotAllowedError') {
      console.log('Autoplay diblokir oleh browser. Butuh interaksi pengguna terlebih dahulu.');
    } else if (error.name === 'NotFoundError') {
      console.log('File audio tidak ditemukan. Periksa path: /assets/sounds/success.mp3');
    }
  });

  successModalTimer = setTimeout(hideSuccessModal, 1000);
}

function initSuccessModal() {
  const modal = document.getElementById('modalBerhasil');
  const btnSelesai = document.getElementById('btnSelesai');
  if (!modal || !btnSelesai) return;

  btnSelesai.addEventListener('click', hideSuccessModal);
  modal.addEventListener('click', (event) => {
    if (event.target === modal) hideSuccessModal();
  });
}

// ==========================
// Area Upload
// ==========================
function initUploadArea() {
  document.querySelectorAll('.upload-area').forEach((uploadArea) => {
    const fileInput = uploadArea.querySelector('input[type="file"]');
    const uploadText = uploadArea.querySelector('p');
    if (!fileInput || !uploadText) return;

    const originalText = uploadText.innerHTML;

    uploadArea.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', function () {
      uploadText.textContent = this.files.length > 0 ? this.files[0].name : originalText;
    });

    uploadArea.reset = function () {
      uploadText.innerHTML = originalText;
      fileInput.value = '';
    };
  });
}