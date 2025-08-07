// === Inisialisasi Setelah Halaman Dimuat ===
document.addEventListener('DOMContentLoaded', function () {
  initSidebar();
  startClock();
  renderKerjasamaTable();
});

// === Logika Sidebar ===
function initSidebar() {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const toggleSidebarBtn = document.getElementById('toggleSidebar');

  toggleSidebarBtn?.addEventListener('click', function () {
    const isMobile = window.innerWidth <= 991;
    sidebar?.classList.toggle(isMobile ? 'show' : 'hidden');
    if (isMobile && sidebar?.classList.contains('show')) {
      overlay?.classList.add('show');
    } else {
      overlay?.classList.remove('show');
    }
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
    const now = new Date();
    const dateOpts = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const timeOpts = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
    dateEl.textContent = now.toLocaleDateString('id-ID', dateOpts);
    timeEl.textContent = now.toLocaleTimeString('id-ID', timeOpts);
  }

  updateTime();
  setInterval(updateTime, 1000);
}

// === Tabel Kerjasama ===
function renderKerjasamaTable() {
  const tableBody = document.getElementById('kerjasamaTableBody');
  if (!tableBody) return;

  const kerjasamaData = [
    {
      judul: 'Pengembangan Model Hutan Tanaman Cerdas Iklim',
      mitra: 'Dinas Kehutanan Provinsi Jawa Barat',
      noDoc: 'MoU/001/AI/24', tglDoc: '2024-04-10',
      tmt: '2024-05-01', tst: '2025-05-01',
      departemen: 'Manajemen Hutan',
      ketua: 'Dr. Anton Jaya Puspita',
      anggota: ['Dr. Budi Santoso', 'Ir. Rina Melati, M.Sc.'],
      lokasi: 'Bogor', dana: '150000000', jenis: 'MoU'
    },
    {
      judul: 'Analisis Keanekaragaman Hayati di Cagar Alam',
      mitra: 'Balai Konservasi Sumber Daya Alam (BKSDA)',
      noDoc: 'LoA/015/BIO/24', tglDoc: '2024-02-20',
      tmt: '2024-03-01', tst: '2024-09-01',
      departemen: 'Konservasi Sumberdaya Hutan',
      ketua: 'Prof. Dr. Endang Sulistyawati',
      anggota: ['Ahmad Zulkifli, S.Hut.'],
      lokasi: 'Gunung Gede Pangrango', dana: '75000000', jenis: 'LoA'
    },
    {
      judul: 'Pemanfaatan Limbah Kayu untuk Produk Bernilai Tambah',
      mitra: 'PT. Kayu Sejahtera',
      noDoc: 'SPK/032/IND/24', tglDoc: '2024-06-05',
      tmt: '2024-06-10', tst: '2024-12-10',
      departemen: 'Teknologi Hasil Hutan',
      ketua: 'Ir. Heru Purnomo, M.T.',
      anggota: ['Siti Nurbaya, S.T.', 'Joko Widodo, S.T.'],
      lokasi: 'Jepara', dana: '250000000', jenis: 'SPK'
    }
  ];

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
      <td class="text-center">
        <button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button>
      </td>
      <td>
        <div class="d-flex gap-2 justify-content-center">
          <button class="btn btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="fa fa-eye"></i></button>
          <button class="btn btn-aksi btn-edit-row" title="Edit" onclick='openEditModal(${JSON.stringify(item)})'><i class="fa fa-edit"></i></button>
          <button class="btn btn-aksi btn-delete-row" title="Hapus"><i class="fa fa-trash"></i></button>
        </div>
      </td>
    </tr>
  `).join('');
}

// === Modal Kerjasama ===
const kerjasamaModalEl = document.getElementById('kerjasamaModal');

function openModal() {
  const form = kerjasamaModalEl.querySelector('form');
  kerjasamaModalEl.querySelector('#modalTitle').innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Kerjasama';
  form.reset();
  setupAnggotaList([]);
  kerjasamaModalEl.style.display = 'flex';
}

function openEditModal(data) {
  const form = kerjasamaModalEl.querySelector('form');
  kerjasamaModalEl.querySelector('#modalTitle').innerHTML = '<i class="lni lni-pencil-alt"></i> Edit Kerjasama';

  for (const key in data) {
    if (key !== 'anggota') {
      const input = form.querySelector(`[name="${key}"]`);
      if (input) input.value = data[key];
    }
  }

  setupAnggotaList(data.anggota || []);
  kerjasamaModalEl.style.display = 'flex';
}

function closeModal() {
  if (kerjasamaModalEl) kerjasamaModalEl.style.display = 'none';
}

window.onclick = function(e) {
  if (e.target === kerjasamaModalEl) closeModal();
}

// === Anggota List ===
function setupAnggotaList(members = []) {
  const listContainer = document.getElementById('anggota-list');
  listContainer.innerHTML = '';
  members.forEach(member => createAnggotaRow(listContainer, member));
  createAnggotaRow(listContainer, '', true);
}

function createAnggotaRow(container, name, isAdder = false) {
  const row = document.createElement('div');
  row.className = 'input-group mb-2';

  row.innerHTML = `
    <input type="text" class="form-control" placeholder="Nama Anggota" value="${name}">
    ${isAdder
      ? '<button class="btn btn-outline-success" type="button" onclick="addNewAnggotaField(this)">+</button>'
      : '<button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">-</button>'}
  `;

  container.appendChild(row);
}

function addNewAnggotaField(addButton) {
  const row = addButton.parentElement;
  const input = row.querySelector('input');
  if (input.value.trim() === '') {
    input.focus();
    return;
  }
  addButton.outerHTML = '<button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">-</button>';
  createAnggotaRow(document.getElementById('anggota-list'), '', true);
  document.getElementById('anggota-list').lastElementChild.querySelector('input').focus();
}