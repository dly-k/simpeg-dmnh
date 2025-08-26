document.addEventListener('DOMContentLoaded', () => {
  initSuratTugasPage();
  initModalInteractions();
  initUploadArea();
  initDeleteConfirmation();
  initSuccessModal();
});

// =================================================
// Data Dummy: Surat Tugas
// =================================================
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

// =================================================
// Inisialisasi Halaman Surat Tugas
// =================================================
function initSuratTugasPage() {
  renderTable();

  // Event: Klik tombol edit pada tabel
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

// Render tabel dari dataSuratTugas
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

// =================================================
// Modal Tambah / Edit Data Surat Tugas
// =================================================

// Buka modal tambah data
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

// Buka modal edit data dan isi form dengan data yang dipilih
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

// Tutup modal
function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  modal?.classList.remove('show');
}

// Event interaksi modal tambah/edit
function initModalInteractions() {
  const addEditModal = document.getElementById('suratTugasModal');

  // Tutup modal jika klik di luar konten
  addEditModal?.addEventListener('click', (event) => {
    if (event.target === addEditModal) {
      closeModal(addEditModal.id);
    }
  });

  // Event klik tombol simpan
  const btnSimpan = document.getElementById('btnSimpanData');
  btnSimpan?.addEventListener('click', () => {
    console.log('Data disimpan/diupdate.');
    closeModal('suratTugasModal');
    showSuccessModal('Data Berhasil Disimpan', 'Data Anda Berhasil Disimpan Pada Sistem');
  });
}

// =================================================
// Modal Konfirmasi Hapus Data
// =================================================
function initDeleteConfirmation() {
  const tableBody = document.getElementById('data-body');
  const modal = document.getElementById('modalKonfirmasiHapus');
  if (!tableBody || !modal) return;

  const btnBatal = document.getElementById('btnBatalHapus');
  const btnKonfirmasi = document.getElementById('btnKonfirmasiHapus');
  let rowToDelete = null;

  // Event: Klik tombol hapus
  tableBody.addEventListener('click', (event) => {
    const deleteButton = event.target.closest('.btn-hapus');
    if (deleteButton) {
      event.preventDefault();
      rowToDelete = deleteButton.closest('tr');
      modal.classList.add('show');
    }
  });

  // Event: Konfirmasi hapus
  btnKonfirmasi.addEventListener('click', () => {
    if (rowToDelete) {
      console.log(`Menghapus data baris ke-${parseInt(rowToDelete.dataset.index) + 1}`);
      rowToDelete.remove();
      hideDeleteModal();
      showSuccessModal('Data Berhasil Dihapus', 'Data yang dipilih telah berhasil dihapus dari sistem.');
      rowToDelete = null;
    }
  });

  // Tutup modal konfirmasi
  function hideDeleteModal() {
    modal.classList.remove('show');
    rowToDelete = null;
  }

  btnBatal.addEventListener('click', hideDeleteModal);
  modal.addEventListener('click', (event) => {
    if (event.target === modal) hideDeleteModal();
  });
}

// =================================================
// Modal Sukses
// =================================================
let successModalTimer;
let successAudio = null; // Simpan instance audio

// Sembunyikan modal sukses
function hideSuccessModal() {
  const modal = document.getElementById('modalBerhasil');
  modal?.classList.remove('show');
  if (successModalTimer) clearTimeout(successModalTimer);
  if (successAudio) {
    successAudio.pause();
    successAudio.currentTime = 0;
  }
}

// Tampilkan modal sukses
function showSuccessModal(title, subtitle) {
  const modal = document.getElementById('modalBerhasil');
  const titleEl = document.getElementById('berhasil-title');
  const subtitleEl = document.getElementById('berhasil-subtitle');

  if (!modal || !titleEl || !subtitleEl) return;

  clearTimeout(successModalTimer);

  titleEl.textContent = title;
  subtitleEl.textContent = subtitle;
  modal.classList.add('show');

  successAudio = new Audio('/assets/sounds/success.mp3');
  successAudio.play().catch(error => {
    console.log('Error memutar suara:', error);
  });

  successModalTimer = setTimeout(hideSuccessModal, 1000);
}

// Event interaksi modal sukses
function initSuccessModal() {
  const modal = document.getElementById('modalBerhasil');
  const btnSelesai = document.getElementById('btnSelesai');
  if (!modal || !btnSelesai) return;

  btnSelesai.addEventListener('click', hideSuccessModal);
  modal.addEventListener('click', (event) => {
    if (event.target === modal) hideSuccessModal();
  });
}

// =================================================
// Area Upload File
// =================================================
function initUploadArea() {
  document.querySelectorAll('.upload-area').forEach((uploadArea) => {
    const fileInput = uploadArea.querySelector('input[type="file"]');
    const uploadText = uploadArea.querySelector('p');
    if (!fileInput || !uploadText) return;

    const originalText = uploadText.innerHTML;

    // Event: Klik area upload → buka file picker
    uploadArea.addEventListener('click', () => fileInput.click());

    // Event: File dipilih → tampilkan nama file
    fileInput.addEventListener('change', function () {
      uploadText.textContent = this.files.length > 0 ? this.files[0].name : originalText;
    });

    // Tambahkan fungsi reset untuk mengembalikan tampilan default
    uploadArea.reset = function () {
      uploadText.innerHTML = originalText;
      fileInput.value = '';
    };
  });
}