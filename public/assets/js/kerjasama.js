document.addEventListener('DOMContentLoaded', function () {
  const modalBerhasil = document.getElementById('modalBerhasil');
  const berhasilTitle = document.getElementById('berhasil-title');
  const berhasilSubtitle = document.getElementById('berhasil-subtitle');
  let successModalTimeout = null;
  let successAudio = null;

  function showSuccessModal(title, subtitle) {
    if (modalBerhasil && berhasilTitle && berhasilSubtitle) {
      berhasilTitle.textContent = title;
      berhasilSubtitle.textContent = subtitle;
      modalBerhasil.classList.add('show');

      successAudio = new Audio('/assets/sounds/success.mp3');
      successAudio.play().catch(error => console.log('Error memutar suara:', error));

      clearTimeout(successModalTimeout);
      successModalTimeout = setTimeout(hideSuccessModal, 1200);
    }
  }

  function hideSuccessModal() {
    modalBerhasil?.classList.remove('show');
    if (successAudio) {
      successAudio.pause();
      successAudio.currentTime = 0;
    }
  }

  document.getElementById('btnSelesai')?.addEventListener('click', () => {
    clearTimeout(successModalTimeout);
    hideSuccessModal();
  });

  initKerjasamaPage(showSuccessModal);
  initDeleteModal(showSuccessModal);
});


// ==========================================================
// === Data Dummy Kerjasama (Contoh)
// ==========================================================
const kerjasamaData = [
  {
    id: 'mou001',
    judul: 'Pengembangan Model Ekowisata Berbasis Masyarakat di Kawasan Hutan Lindung Gunung Halimun Salak',
    mitra: 'Balai Taman Nasional Gunung Halimun Salak',
    no_surat_mitra: '112/BTN-GHS/VIII/2024',
    no_surat_departemen: '25/DEK-FAHUTAN/SPK/VIII/2024',
    tglDoc: '2024-08-15',
    tmt: '2024-08-20',
    tst: '2025-08-20',
    departemen_pj: 'Konservasi Sumberdaya Hutan',
    ketua: [
      { nama: 'Dr. Ir. Rina Puspitasari, M.Si.', departemen: 'Konservasi Sumberdaya Hutan' }
    ],
    anggota: [
      { nama: 'Prof. Dr. Bambang Yudoyono, M.Hut.', departemen: 'Manajemen Hutan' },
      { nama: 'Siti Fatimah, S.Hut., M.Sc.', departemen: 'Konservasi Sumberdaya Hutan' },
      { nama: 'Agus Setiawan, S.T., M.T.', departemen: 'Teknologi Hasil Hutan' }
    ],
    lokasi: 'Bogor, Jawa Barat',
    dana: 150000000,
    jenis: 'SPK',
    jenis_usulan: 'Baru',
    dokumen_path: 'assets/pdf/example.pdf',
    laporan_path: 'assets/pdf/laporan-ekowisata-q1.pdf'
  },
  {
    id: 'mou002',
    judul: 'Riset Inovasi Pupuk Organik Berbasis Limbah Kelapa Sawit',
    mitra: 'PT Sawit Makmur Persada',
    no_surat_mitra: '089/SMP-RND/VII/2024',
    no_surat_departemen: '19/DEK-FAHUTAN/SPK/VII/2024',
    tglDoc: '2024-07-01',
    tmt: '2024-07-10',
    tst: '2026-07-10',
    departemen_pj: 'Teknologi Hasil Hutan',
    ketua: [
      { nama: 'Dr. Hendri Kusuma, S.T.P., M.P.', departemen: 'Teknologi Hasil Hutan' }
    ],
    anggota: [
      { nama: 'Ir. Lestari Anggraeni, M.Sc.', departemen: 'Manajemen Hutan' }
    ],
    lokasi: 'Riau',
    dana: 250000000,
    jenis: 'MoU',
    jenis_usulan: 'Baru',
    dokumen_path: 'assets/pdf/pupuk.pdf',
    laporan_path: null
  }
];


// ==========================================================
// === Init Halaman Kerjasama
// ==========================================================
function initKerjasamaPage(showSuccessModal) {
  renderKerjasamaTable();

  const kerjasamaModalEl = document.getElementById('kerjasamaModal');
  const tableBody = document.getElementById('kerjasamaTableBody');
  if (!kerjasamaModalEl) return;

  const bsModal = new bootstrap.Modal(kerjasamaModalEl);

  // Event show modal (edit/tambah)
  kerjasamaModalEl.addEventListener('show.bs.modal', function (event) {
    // ... logika edit/tambah
  });

  // Simpan data
  const saveButton = kerjasamaModalEl.querySelector('.btn-success');
  if (saveButton) {
    saveButton.addEventListener('click', function () {
      bsModal.hide();
      showSuccessModal('Data Berhasil Disimpan', 'Data kerjasama telah berhasil disimpan.');
    });
  }

  // Aksi pada tabel
  if (tableBody) {
    tableBody.addEventListener('click', function (e) {
      const targetButton = e.target.closest('button.btn-aksi');
      if (!targetButton) return;

      const itemId = targetButton.dataset.id;
      const itemData = kerjasamaData.find(item => item.id === itemId);
      if (!itemData) return;

      if (targetButton.classList.contains('btn-lihat-detail')) {
        fillDetailModal(itemData);
      }

      if (targetButton.classList.contains('btn-delete-row')) {
        e.preventDefault();
        window.showDeleteModal(itemData, targetButton.closest('tr'));
      }
    });
  }
}


// ==========================================================
// === Init Modal Hapus Data
// ==========================================================
function initDeleteModal(showSuccessModal) {
  const modal = document.getElementById('modalKonfirmasiHapus');
  const btnKonfirmasi = document.getElementById('btnKonfirmasiHapus');
  const btnBatal = document.getElementById('btnBatalHapus');

  let currentItemToDelete = null;
  let currentRowElement = null;

  window.showDeleteModal = function (itemData, rowElement) {
    currentItemToDelete = itemData;
    currentRowElement = rowElement;
    if (modal) {
      modal.style.display = 'flex';
      requestAnimationFrame(() => modal.classList.add('show'));
      document.body.style.overflow = 'hidden';
    }
  };

  function hideDeleteModal() {
    if (modal) {
      modal.classList.remove('show');
      setTimeout(() => {
        modal.style.display = 'none';
        document.body.style.overflow = '';
      }, 300);
    }
    currentItemToDelete = null;
    currentRowElement = null;
  }

  if (btnKonfirmasi) {
    btnKonfirmasi.addEventListener('click', function (event) {
      event.preventDefault();
      event.stopPropagation();

      if (currentItemToDelete && currentRowElement) {
        currentRowElement.remove();
        hideDeleteModal();
        showSuccessModal('Data Berhasil Dihapus', `Data kerjasama telah berhasil dihapus.`);
      }
    });
  }

  if (btnBatal) btnBatal.addEventListener('click', hideDeleteModal);
  if (modal) modal.addEventListener('click', e => { if (e.target === modal) hideDeleteModal(); });
  document.addEventListener('keydown', e => { if (e.key === 'Escape' && modal?.classList.contains('show')) hideDeleteModal(); });
}


// ==========================================================
// === Render Tabel Kerjasama
// ==========================================================
function renderKerjasamaTable() {
  const tableBody = document.getElementById('kerjasamaTableBody');
  if (!tableBody) return;

  tableBody.innerHTML = kerjasamaData.map((item, index) => {
    const danaFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.dana);
    const ketuaNames = item.ketua.map(k => k.nama).join(', ');
    const anggotaNames = item.anggota.map(a => a.nama).join(', ');

    return `
      <tr>
        <td class="text-center">${index + 1}</td>
        <td class="text-start" style="min-width: 250px;">${item.judul}</td>
        <td class="text-start">${item.mitra}</td>
        <td class="text-start"><b>Mitra:</b> ${item.no_surat_mitra}<br><b>Dept:</b> ${item.no_surat_departemen}</td>
        <td class="text-center">${formatDate(item.tmt)}</td>
        <td class="text-center">${formatDate(item.tst)}</td>
        <td class="text-start"><b>Ketua:</b> ${ketuaNames}<br><b>Anggota:</b> ${anggotaNames}</td>
        <td class="text-center">${item.lokasi}</td>
        <td class="text-end">${danaFormatted}</td>
        <td class="text-center"><span class="badge text-bg-light border">${item.jenis}</span></td>
        <td class="text-center"><a href="${item.dokumen_path || '#'}" target="_blank" class="btn btn-sm btn-lihat-detail text-white">Lihat</a></td>
        <td class="text-center">
          <div class="d-flex gap-2 justify-content-center">
            <button class="btn btn-aksi btn-lihat-detail" data-id="${item.id}" data-bs-toggle="modal" data-bs-target="#modalDetailKerjasama"><i class="fa fa-eye"></i></button>
            <button class="btn btn-aksi btn-edit-row" data-id="${item.id}" data-bs-toggle="modal" data-bs-target="#kerjasamaModal"><i class="fa fa-edit"></i></button>
            <button class="btn btn-aksi btn-delete-row" data-id="${item.id}"><i class="fa fa-trash"></i></button>
          </div>
        </td>
      </tr>`;
  }).join('');
}

// ==========================================================
// === Isi Modal Detail Kerjasama
// ==========================================================
function fillDetailModal(itemData) {
  const setText = (id, value) => {
    const el = document.getElementById(id);
    if (el) el.textContent = value || '-';
  };

  const danaFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(itemData.dana);
  const nomorSuratGabungan = `${itemData.no_surat_mitra} & ${itemData.no_surat_departemen}`;

  setText('detail_kerjasama_judul', itemData.judul);
  setText('detail_kerjasama_mitra', itemData.mitra);
  setText('detail_kerjasama_nomor_surat', nomorSuratGabungan);
  setText('detail_kerjasama_tgl_dokumen', formatDate(itemData.tglDoc));
  setText('detail_kerjasama_departemen_pj', itemData.departemen_pj);
  setText('detail_kerjasama_tmt', formatDate(itemData.tmt));
  setText('detail_kerjasama_tst', formatDate(itemData.tst));
  setText('detail_kerjasama_lokasi', itemData.lokasi);
  setText('detail_kerjasama_dana', danaFormatted);
  setText('detail_kerjasama_jenis', itemData.jenis);
  setText('detail_kerjasama_jenis_usulan', itemData.jenis_usulan);

  // Ketua
  const ketuaListEl = document.getElementById('detail_ketua_list');
  if (ketuaListEl) {
    ketuaListEl.innerHTML = itemData.ketua?.length > 0
      ? itemData.ketua.map(k => `
          <li class="personil-item-detail">
            <span class="personil-nama">${k.nama}</span>
            <span class="personil-departemen">${k.departemen}</span>
          </li>`).join('')
      : '<li>-</li>';
  }

  // Anggota
  const anggotaListEl = document.getElementById('detail_anggota_list');
  if (anggotaListEl) {
    anggotaListEl.innerHTML = itemData.anggota?.length > 0
      ? itemData.anggota.map(a => `
          <li class="personil-item-detail">
            <span class="personil-nama">${a.nama}</span>
            <span class="personil-departemen">${a.departemen}</span>
          </li>`).join('')
      : '<li>-</li>';
  }

  // Dokumen & laporan
  const btnDokumen = document.getElementById('btn_lihat_dokumen');
  const btnLaporan = document.getElementById('btn_lihat_laporan');

  if (btnDokumen) btnDokumen.href = itemData.dokumen_path || '#';
  if (btnLaporan) {
    if (itemData.laporan_path) {
      btnLaporan.href = itemData.laporan_path;
      btnLaporan.style.display = 'inline-block';
    } else {
      btnLaporan.style.display = 'none';
    }
  }
}


// ==========================================================
// === Helper: Format Tanggal
// ==========================================================
function formatDate(dateString) {
  if (!dateString) return '-';
  return new Date(dateString).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
}


// ==========================================================
// === Form Personil (Tambah/Hapus Ketua & Anggota)
// ==========================================================
document.addEventListener('DOMContentLoaded', function () {
  function addPersonil(containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;

    const personilItem = document.createElement('div');
    personilItem.className = 'personil-item d-flex gap-2 mb-2';

    const namaInput = document.createElement('input');
    namaInput.type = 'text';
    namaInput.className = 'form-control';
    namaInput.placeholder = 'Nama Lengkap';

    const depSelect = document.createElement('select');
    depSelect.className = 'form-select';
    depSelect.innerHTML = `
      <option selected>-- Pilih Departemen --</option>
      <option>Manajemen Hutan</option>
      <option>Konservasi Sumberdaya Hutan</option>
      <option>Teknologi Hasil Hutan</option>
    `;

    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.className = 'btn btn-danger btn-remove-personil';
    removeBtn.innerHTML = '<i class="fa fa-times"></i>';

    personilItem.appendChild(namaInput);
    personilItem.appendChild(depSelect);
    personilItem.appendChild(removeBtn);

    container.appendChild(personilItem);
  }

  document.getElementById('add-ketua-btn')?.addEventListener('click', () => addPersonil('ketua-list'));
  document.getElementById('add-anggota-btn')?.addEventListener('click', () => addPersonil('anggota-list'));

  const modalBody = document.querySelector('#kerjasamaModal .modal-body');
  if (modalBody) {
    modalBody.addEventListener('click', function (e) {
      if (e.target.closest('.btn-remove-personil')) {
        e.target.closest('.personil-item').remove();
      }
    });
  }
});