// === Inisialisasi & Event Listener Utama ===
document.addEventListener('DOMContentLoaded', function () {
  setupSidebar();
  startDateTimeUpdater();
  setupUploadArea(); // Panggil fungsi untuk upload area
});

// === Logika Sidebar ===
function setupSidebar() {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const toggleSidebarBtn = document.getElementById('toggleSidebar');

  if (!sidebar || !overlay || !toggleSidebarBtn) return;

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

// === Logika Waktu & Tanggal ===
function startDateTimeUpdater() {
  const dateEl = document.getElementById('current-date');
  const timeEl = document.getElementById('current-time');

  if (!dateEl || !timeEl) return;

  function update() {
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
      hour12: false
    };

    dateEl.textContent = now.toLocaleDateString('id-ID', dateOptions);
    timeEl.textContent = now.toLocaleTimeString('id-ID', timeOptions);
  }

  update();
  setInterval(update, 1000);
}

// === Logika Upload File (BARU) ===
function setupUploadArea() {
  const uploadArea = document.querySelector('.upload-area');
  if (!uploadArea) return;

  const fileInput = uploadArea.querySelector('input[type="file"]');
  const uploadText = uploadArea.querySelector('p');
  const originalText = uploadText.innerHTML; // Simpan teks asli

  // 1. Buka dialog file saat area diklik
  uploadArea.addEventListener('click', function () {
    fileInput.click();
  });

  // 2. Tampilkan nama file setelah dipilih
  fileInput.addEventListener('change', function () {
    if (this.files.length > 0) {
      // Ganti teks dengan nama file yang dipilih
      uploadText.textContent = this.files[0].name;
    }
  });

  // Simpan fungsi untuk mereset teks ke elemen itu sendiri
  uploadArea.resetText = () => {
    uploadText.innerHTML = originalText;
  };
}


// === Logika Modal ===
function openModal(modalId) {
  const modal = document.getElementById(modalId);
  if (!modal) return;

  const modalTitle = modal.querySelector('#modalTitle');
  const form = modal.querySelector('form');

  if (modalTitle) {
    modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Penelitian';
  }

  if (form) {
    form.reset();
  }

  // Reset tampilan area upload
  const uploadArea = modal.querySelector('.upload-area');
  if (uploadArea && typeof uploadArea.resetText === 'function') {
    uploadArea.resetText(); // Reset teks area upload ke default
  }

  // Reset dynamic fields
  resetPenulisFields();

  modal.style.display = 'flex';
}

function openEditModal() {
  const modal = document.getElementById('penelitianModal');
  if (!modal) return;

  const modalTitle = modal.querySelector('#modalTitle');
  if (modalTitle) {
    modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Penelitian';
  }

  modal.style.display = 'flex';
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.style.display = 'none';
  }
}

// === Reset Field Penulis ===
function resetPenulisFields() {
  document.getElementById('penulis-ipb-list').innerHTML = createDefaultPenulisInput('penulis-ipb-list');
  document.getElementById('penulis-luar-list').innerHTML = createDefaultPenulisInput('penulis-luar-list');
  document.getElementById('penulis-mahasiswa-list').innerHTML = createDefaultPenulisInput('penulis-mahasiswa-list');
}

// === Template Default Field ===
function createDefaultPenulisInput(listId) {
  if (listId === 'penulis-mahasiswa-list') {
    return `
      <div class="input-group mb-2">
        <input type="text" class="form-control" placeholder="Nama">
        <button class="btn btn-outline-success" type="button" onclick="addPenulis('${listId}')">+ Tambah</button>
      </div>`;
  }

  return `
    <div class="input-group mb-2">
      <input type="text" class="form-control" placeholder="Nama">
      <label class="input-group-text">Upload SK</label>
      <input type="file" class="form-control">
      <button class="btn btn-outline-success" type="button" onclick="addPenulis('${listId}')">+ Tambah</button>
    </div>`;
}

// === Logika Penulis Dinamis ===
let penulisCounter = 0;

function addPenulis(listId) {
  penulisCounter++;
  const list = document.getElementById(listId);
  if (!list) return;

  const newInput = document.createElement('div');
  newInput.className = 'input-group mb-2';

  let inputFields = `<input type="text" class="form-control" placeholder="Nama">`;

  if (listId !== 'penulis-mahasiswa-list') {
    inputFields += `
      <label class="input-group-text" for="upload-sk-${penulisCounter}">Upload SK</label>
      <input type="file" class="form-control" id="upload-sk-${penulisCounter}">`;
  }

  inputFields += `<button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">-</button>`;
  newInput.innerHTML = inputFields;

  list.appendChild(newInput);
}

// === Tutup Modal saat Klik Luar Modal ===
window.onclick = function (event) {
  if (event.target.classList.contains('modal-backdrop')) {
    closeModal(event.target.id);
  }
};

//-modal detail
// Ambil elemen-elemen yang diperlukan
const detailModal = document.getElementById("detailModal");
const openModalBtn = document.getElementById("btnLihatDetail");
const closeModalBtn = document.getElementById("tutupBtn");

// Tampilkan modal ketika tombol 'Lihat Detail' diklik
if (openModalBtn) {
  openModalBtn.onclick = function() {
    detailModal.style.display = "block";
  }
}

// Sembunyikan modal ketika tombol 'Tutup' diklik
if (closeModalBtn) {
  closeModalBtn.onclick = function() {
    detailModal.style.display = "none";
  }
}

// Sembunyikan modal ketika pengguna mengklik area di luar modal
window.addEventListener('click', function(event) {
  if (event.target == detailModal) {
    detailModal.style.display = "none";
  }
});