// === Inisialisasi Setelah Halaman Dimuat ===
document.addEventListener('DOMContentLoaded', function () {
  initSidebar();
  startClock();
  initKerjasamaPage();
  initModalInteractions();
});

// === Logika Sidebar ===
function initSidebar() {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const toggleSidebarBtn = document.getElementById('toggleSidebar');

  toggleSidebarBtn?.addEventListener('click', function () {
    const isMobile = window.innerWidth <= 991;
    sidebar?.classList.toggle(isMobile ? 'show' : 'hidden');
    overlay?.classList.toggle('show', isMobile && sidebar?.classList.contains('show'));
  });

  overlay?.addEventListener('click', function () {
    sidebar?.classList.remove('show');
    overlay?.classList.remove('show');
  });
}

// === Logika Waktu ===
function startClock() {
  const dateEl = document.getElementById('current-date');
  const timeEl = document.getElementById('current-time');

  function updateTime() {
    if (!dateEl || !timeEl) return;
    const now = new Date();
    const dateOpts = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', timeZone: 'Asia/Jakarta' };
    const timeOpts = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false, timeZone: 'Asia/Jakarta' };
    dateEl.textContent = now.toLocaleDateString('id-ID', dateOpts);
    timeEl.textContent = now.toLocaleTimeString('id-ID', timeOpts);
  }
  updateTime();
  setInterval(updateTime, 1000);
}

// === Data & Logika Halaman Kerjasama ===
// PENINGKATAN: Menambahkan `id` unik untuk setiap item data
const kerjasamaData = [
    { id: 'mou001', judul: 'Pengembangan Model Hutan Tanaman Cerdas Iklim', mitra: 'Dinas Kehutanan Provinsi Jawa Barat', noDoc: 'MoU/001/AI/24', tglDoc: '2024-04-10', tmt: '2024-05-01', tst: '2025-05-01', departemen: 'Manajemen Hutan', ketua: 'Dr. Anton Jaya Puspita', anggota: ['Dr. Budi Santoso', 'Ir. Rina Melati, M.Sc.'], lokasi: 'Bogor', dana: '150000000', jenis: 'MoU' },
    { id: 'loa015', judul: 'Analisis Keanekaragaman Hayati di Cagar Alam', mitra: 'Balai Konservasi Sumber Daya Alam (BKSDA)', noDoc: 'LoA/015/BIO/24', tglDoc: '2024-02-20', tmt: '2024-03-01', tst: '2024-09-01', departemen: 'Konservasi Sumberdaya Hutan', ketua: 'Prof. Dr. Endang Sulistyawati', anggota: ['Ahmad Zulkifli, S.Hut.'], lokasi: 'Gunung Gede Pangrango', dana: '75000000', jenis: 'LoA' },
    { id: 'spk032', judul: 'Pemanfaatan Limbah Kayu untuk Produk Bernilai Tambah', mitra: 'PT. Kayu Sejahtera', noDoc: 'SPK/032/IND/24', tglDoc: '2024-06-05', tmt: '2024-06-10', tst: '2024-12-10', departemen: 'Teknologi Hasil Hutan', ketua: 'Ir. Heru Purnomo, M.T.', anggota: ['Siti Nurbaya, S.T.', 'Joko Widodo, S.T.'], lokasi: 'Jepara', dana: '250000000', jenis: 'SPK' }
];

function initKerjasamaPage() {
  renderKerjasamaTable();
  const tableBody = document.getElementById('kerjasamaTableBody');
  
  // PENINGKATAN: Event Delegation untuk Aksi Tabel
  tableBody?.addEventListener('click', function(e) {
    const editBtn = e.target.closest('.btn-edit-row');
    const deleteBtn = e.target.closest('.btn-delete-row');
    
    if (editBtn) {
      const itemId = editBtn.dataset.id;
      const itemData = kerjasamaData.find(item => item.id === itemId);
      if (itemData) openEditModal(itemData);
    }
    
    if (deleteBtn) {
      if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        const row = deleteBtn.closest('tr');
        console.log('Menghapus item ID:', deleteBtn.dataset.id);
        row.remove();
      }
    }
  });
}

function renderKerjasamaTable() {
  const tableBody = document.getElementById('kerjasamaTableBody');
  if (!tableBody) return;

  // PENINGKATAN: Menggunakan `data-id` untuk tombol aksi, bukan inline onclick
  tableBody.innerHTML = kerjasamaData.map((item, index) => `
    <tr>
      <td>${index + 1}</td>
      <td class="text-start" style="min-width: 250px;">${item.judul}</td>
      <td style="min-width: 200px;">${item.mitra}</td>
      <td>${item.noDoc}</td>
      <td>${new Date(item.tglDoc).toLocaleDateString('id-ID', {day: '2-digit', month: 'short', year: 'numeric'})}</td>
      <td class="text-start" style="min-width: 250px;"><b>Ketua:</b> ${item.ketua}<br><b>Anggota:</b> ${item.anggota.join(', ')}</td>
      <td>${item.lokasi}</td>
      <td class="text-end">${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.dana)}</td>
      <td><span class="badge text-bg-light border">${item.jenis}</span></td>
      <td class="text-center"><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
      <td>
        <div class="d-flex gap-2 justify-content-center">
          <button class="btn btn-aksi btn-lihat-detail" data-id="${item.id}" title="Lihat Detail"><i class="fa fa-eye"></i></button>
          <button class="btn btn-aksi btn-edit-row" data-id="${item.id}" title="Edit"><i class="fa fa-edit"></i></button>
          <button class="btn btn-aksi btn-delete-row" data-id="${item.id}" title="Hapus"><i class="fa fa-trash"></i></button>
        </div>
      </td>
    </tr>
  `).join('');
}

// === Logika Modal & Interaksinya ===
function initModalInteractions() {
  const kerjasamaModalEl = document.getElementById('kerjasamaModal');
  
  // PERBAIKAN: Menggunakan addEventListener untuk klik di luar modal
  window.addEventListener('click', function(e) {
    if (e.target === kerjasamaModalEl) closeModal();
  });
  
  // PENINGKATAN: Event Delegation untuk List Anggota
  const anggotaListContainer = document.getElementById('anggota-list');
  anggotaListContainer?.addEventListener('click', function(e) {
    const addButton = e.target.closest('.btn-add-anggota');
    const removeButton = e.target.closest('.btn-remove-anggota');

    if (addButton) {
      const row = addButton.parentElement;
      const input = row.querySelector('input');
      if (input.value.trim() === '') {
        input.focus();
        return;
      }
      addButton.outerHTML = '<button class="btn btn-outline-danger btn-remove-anggota" type="button">-</button>';
      anggotaListContainer.insertAdjacentHTML('beforeend', getAnggotaRowHTML('', true));
      anggotaListContainer.lastElementChild.querySelector('input').focus();
    }
    
    if (removeButton) {
      removeButton.parentElement.remove();
    }
  });
  
  // BARU: Inisialisasi untuk semua area upload file
  setupUploadArea();
}

const kerjasamaModalEl = document.getElementById('kerjasamaModal');
function openModal() {
  const form = kerjasamaModalEl?.querySelector('form');
  kerjasamaModalEl.querySelector('#modalTitle').innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Kerjasama';
  form?.reset();
  setupAnggotaList([]);
  
  // BARU: Reset area upload saat modal dibuka
  const uploadArea = kerjasamaModalEl.querySelector('.upload-area');
  if (uploadArea && typeof uploadArea.reset === 'function') {
      uploadArea.reset();
  }
  
  kerjasamaModalEl.style.display = 'flex';
}

function openEditModal(data) {
  const form = kerjasamaModalEl?.querySelector('form');
  kerjasamaModalEl.querySelector('#modalTitle').innerHTML = '<i class="lni lni-pencil-alt"></i> Edit Kerjasama';
  form?.reset();
  
  for (const key in data) {
    if (key !== 'anggota') {
      const input = form.querySelector(`[name="${key}"]`);
      if (input) input.value = data[key];
    }
  }
  setupAnggotaList(data.anggota || []);
  
  const uploadArea = kerjasamaModalEl.querySelector('.upload-area');
  if (uploadArea && typeof uploadArea.reset === 'function') {
      uploadArea.reset();
  }
  
  kerjasamaModalEl.style.display = 'flex';
}

function closeModal() {
  if (kerjasamaModalEl) kerjasamaModalEl.style.display = 'none';
}

// === Logika List Anggota (Refactored) ===
function setupAnggotaList(members = []) {
  const listContainer = document.getElementById('anggota-list');
  if (!listContainer) return;
  listContainer.innerHTML = ''; 
  members.forEach(member => {
    listContainer.insertAdjacentHTML('beforeend', getAnggotaRowHTML(member, false));
  });
  listContainer.insertAdjacentHTML('beforeend', getAnggotaRowHTML('', true));
}

function getAnggotaRowHTML(name = '', isAdder = false) {
  return `
    <div class="input-group mb-2">
      <input type="text" class="form-control" placeholder="Nama Anggota" value="${name}">
      ${isAdder
        ? '<button class="btn btn-outline-success btn-add-anggota" type="button">+</button>'
        : '<button class="btn btn-outline-danger btn-remove-anggota" type="button">-</button>'}
    </div>
  `;
}

// BARU: Fungsi untuk menangani upload area
function setupUploadArea() {
    document.querySelectorAll('.upload-area').forEach(uploadArea => {
        const fileInput = uploadArea.querySelector('input[type="file"]');
        const uploadText = uploadArea.querySelector('p');
        if (!fileInput || !uploadText) return;

        const originalText = uploadText.innerHTML;

        uploadArea.addEventListener('click', () => fileInput.click());
        fileInput.addEventListener('change', function () {
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