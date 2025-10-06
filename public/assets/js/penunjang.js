document.addEventListener('DOMContentLoaded', () => {
  // === Global Variables and Initialization ===
  const elements = {
    penunjangModal: document.getElementById('penunjangModal'),
    form: document.getElementById('penunjangForm'),
    saveButton: document.getElementById('simpanPenunjangBtn'),
    modalTitle: document.getElementById('penunjangModalLabel'),
    formMethodInput: document.getElementById('form-method'),
    formEditIdInput: document.getElementById('form-edit-id'),
    csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
    searchInput: document.querySelector('.search-input'),
    filterSemester: document.getElementById('filter-semester'),
    filterLingkup: document.getElementById('filter-lingkup'),
    filterStatus: document.getElementById('filter-status'),
    tableBody: document.getElementById('penunjang-table-body'),
    mainTable: document.querySelector('table[data-user-role]'),
    paginationContainer: document.getElementById('pagination-container'),
    successModal: document.getElementById('modalBerhasil'),
    successTitle: document.getElementById('berhasil-title'),
    successSubtitle: document.getElementById('berhasil-subtitle'),
    detailModal: document.getElementById('penunjangDetailModal'),
    verificationModal: document.getElementById('modalKonfirmasiVerifikasi'),
    deleteModal: document.getElementById('modalKonfirmasiHapus'),
  };

  const userRole = elements.mainTable?.dataset.userRole;
  let penunjangModalInstance = null;
  let dokCounter = 0;
  let anggotaCounter = 0;
  let pegawaiData = [];
  let successModalTimeout = null;
  const successSound = new Audio('/assets/sounds/success.mp3');

  if (elements.penunjangModal) {
    penunjangModalInstance = new bootstrap.Modal(elements.penunjangModal);
  }

  // Parse pegawai data from table dataset
  try {
    const table = document.getElementById('penunjang-table');
    if (table?.dataset.pegawai) {
      pegawaiData = JSON.parse(table.dataset.pegawai);
    }
  } catch (error) {
    console.error('Failed to parse pegawaiData:', error);
  }

  // === Utility Functions ===
  /**
   * Formats a date string to Indonesian locale format (e.g., "1 Jan 2023").
   * @param {string} dateString - The date string to format.
   * @returns {string} Formatted date string or '-' if invalid.
   */
  const formatDate = (dateString) =>
    dateString
      ? new Date(dateString).toLocaleDateString('id-ID', {
          day: 'numeric',
          month: 'short',
          year: 'numeric',
        })
      : '-';

  /**
   * Debounces a function to limit its execution rate.
   * @param {Function} func - The function to debounce.
   * @param {number} delay - The delay in milliseconds.
   * @returns {Function} Debounced function.
   */
  const debounce = (func, delay) => {
    let timeout;
    return (...args) => {
      clearTimeout(timeout);
      timeout = setTimeout(() => func.apply(this, args), delay);
    };
  };

  // === Table and Pagination Rendering ===
  /**
   * Renders the table with the provided data.
   * @param {Array} data - Array of data objects to render.
   * @param {number} startingNumber - The starting number for table rows.
   */
  const renderTable = (data, startingNumber) => {
    elements.tableBody.innerHTML = '';
    if (!data || data.length === 0) {
      elements.tableBody.innerHTML =
        '<tr><td colspan="10" class="text-center">Data tidak ditemukan.</td></tr>';
      return;
    }

    data.forEach((item, index) => {
      const statusIcon = getStatusIcon(item.status);
      const verifikasiButton =
        userRole === 'admin_verifikator'
          ? `<a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi" data-id="${item.id}"><i class="fa fa-check"></i></a>`
          : '';

      const row = `
        <tr>
          <td class="text-center">${startingNumber + index}</td>
          <td class="text-start">${item.kegiatan}</td>
          <td class="text-center">${item.lingkup}</td>
          <td class="text-center">${item.nama_kegiatan}</td>
          <td class="text-center">${item.instansi}</td>
          <td class="text-center">${item.nomor_sk}</td>
          <td class="text-center">${formatDate(item.tmt_mulai)}</td>
          <td class="text-center">${formatDate(item.tmt_selesai)}</td>
          <td class="text-center">${statusIcon}</td>
          <td class="text-center">
            <div class="d-flex gap-2 justify-content-center">
              ${verifikasiButton}
              <a href="#" class="btn-aksi btn-lihat" title="Lihat Detail" data-id="${item.id}" data-bs-toggle="modal" data-bs-target="#penunjangDetailModal"><i class="fa fa-eye"></i></a>
              <a href="#" class="btn-aksi btn-edit" title="Edit Data" data-id="${item.id}"><i class="fa fa-edit"></i></a>
              <a href="#" class="btn-aksi btn-hapus" title="Hapus Data" data-id="${item.id}"><i class="fa fa-trash"></i></a>
            </div>
          </td>
        </tr>
      `;
      elements.tableBody.innerHTML += row;
    });
  };

  /**
   * Generates the status icon based on verification status.
   * @param {string} status - The verification status.
   * @returns {string} HTML for the status icon.
   */
  const getStatusIcon = (status) => {
    switch (status) {
      case 'Sudah Diverifikasi':
        return '<i class="fas fa-check-circle text-success" title="Sudah Diverifikasi"></i>';
      case 'Ditolak':
        return '<i class="fas fa-times-circle text-danger" title="Ditolak"></i>';
      default:
        return '<i class="fas fa-question-circle text-warning" title="Belum Diverifikasi"></i>';
    }
  };

  /**
   * Renders pagination controls.
   * @param {string} html - The pagination HTML string.
   */
  const renderPagination = (html) => {
    let container = elements.paginationContainer;
    if (html && html.trim() !== '') {
      if (!container) {
        container = document.createElement('div');
        container.id = 'pagination-container';
        container.className = 'mt-3 d-flex justify-content-center';
        document.querySelector('.table-responsive').after(container);
        elements.paginationContainer = container;
      }
      container.innerHTML = html;
    } else if (container) {
      container.remove();
      elements.paginationContainer = null;
    }
  };

  // === Data Fetching ===
  /**
   * Fetches data from the server and updates the table.
   * @param {string} url - The URL to fetch data from.
   */
  const fetchData = async (url) => {
    try {
      elements.tableBody.innerHTML =
        '<tr><td colspan="10" class="text-center"><div class="spinner-border spinner-border-sm"></div> Memuat...</td></tr>';

      const response = await fetch(url, {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
      });

      if (!response.ok) throw new Error('Network response was not ok');
      const result = await response.json();

      renderTable(result.data, result.from);
      renderPagination(result.pagination_html);
    } catch (error) {
      console.error('Fetch error:', error);
      elements.tableBody.innerHTML =
        '<tr><td colspan="10" class="text-center text-danger">Gagal memuat data.</td></tr>';
    }
  };

  /**
   * Performs filtering and searching based on input values.
   */
  const performFilterAndSearch = () => {
    const params = new URLSearchParams({
      search: elements.searchInput?.value || '',
      semester: elements.filterSemester?.value || '',
      lingkup: elements.filterLingkup?.value || '',
      status: elements.filterStatus?.value || '',
    });
    const newUrl = `/penunjang?${params.toString()}`;
    history.pushState(null, '', newUrl);
    fetchData(newUrl);
  };

  // === Success Modal ===
  /**
   * Displays the success modal with a title and subtitle.
   * @param {string} title - The title to display.
   * @param {string} subtitle - The subtitle to display.
   */
  const showSuccessModal = (title, subtitle) => {
    if (!elements.successModal || !elements.successTitle || !elements.successSubtitle) return;
    elements.successTitle.textContent = title;
    elements.successSubtitle.textContent = subtitle;
    elements.successModal.classList.add('show');
    document.body.style.overflow = 'hidden';
    successSound.play().catch((error) => console.warn('Failed to play success sound:', error));
    clearTimeout(successModalTimeout);
    successModalTimeout = setTimeout(hideSuccessModal, 1200);
  };

  /**
   * Hides the success modal and restores body overflow.
   */
  const hideSuccessModal = () => {
    if (!elements.successModal) return;
    elements.successModal.classList.remove('show');
    if (!document.querySelector('.modal.show')) {
      document.body.style.overflow = '';
    }
  };

  // === Select2 Initialization ===
  /**
   * Initializes Select2 for kegiatan dropdown.
   */
  const initSelect2Kegiatan = () => {
    $('.select2-kegiatan').select2({
      theme: 'bootstrap-5',
      placeholder: '-- Pilih Kegiatan --',
      dropdownParent: $('#penunjangModal .modal-content'),
      allowClear: true,
      width: '100%',
    });
  };

  /**
   * Initializes Select2 for dosen dropdown.
   */
  const initSelect2Dosen = () => {
    $('.select2-dosen').select2({
      theme: 'bootstrap-5',
      placeholder: '-- Pilih Dosen --',
      dropdownParent: $('#penunjangModal .modal-content'),
      allowClear: true,
      width: '100%',
    });
  };

  // === Form Population for Editing ===
  /**
   * Populates the form with data for editing.
   * @param {Object} data - The data to populate the form.
   */
  const populateEditForm = (data) => {
    const formFields = {
      kegiatan: elements.form.querySelector('[name="kegiatan"]'),
      jenis_kegiatan: elements.form.querySelector('[name="jenis_kegiatan"]'),
      lingkup: elements.form.querySelector('[name="lingkup"]'),
      nama_kegiatan: elements.form.querySelector('[name="nama_kegiatan"]'),
      instansi: elements.form.querySelector('[name="instansi"]'),
      nomor_sk: elements.form.querySelector('[name="nomor_sk"]'),
      tmt_mulai: elements.form.querySelector('[name="tmt_mulai"]'),
      tmt_selesai: elements.form.querySelector('[name="tmt_selesai"]'),
      anggotaList: document.getElementById('anggota-list'),
      dokumenList: document.getElementById('dokumen-list'),
    };

    Object.entries(formFields).forEach(([key, field]) => {
      if (key !== 'anggotaList' && key !== 'dokumenList') {
        field.value = data[key] || '';
      }
    });

    formFields.anggotaList.innerHTML = '';
    anggotaCounter = 0;
    if (data.anggota?.length > 0) {
      data.anggota.forEach((item) => {
        addAnggota(item.pegawai_id, item.peran);
      });
      initSelect2Dosen();
    }

    formFields.dokumenList.innerHTML = '';
    dokCounter = 0;
    if (data.dokumen?.length > 0) {
      formFields.dokumenList.innerHTML =
        '<p class="text-muted small">Untuk mengubah dokumen, upload file baru. Jika tidak, bagian dokumen tidak akan diperbarui.</p>';
      data.dokumen.forEach((item) => {
        const fileUrl = `/storage/${item.file_path.replace('public/', '')}`;
        formFields.dokumenList.innerHTML += `
          <div class="alert alert-secondary p-2 small">
            Dokumen tersimpan: <a href="${fileUrl}" target="_blank">${item.nama_dokumen}</a>
          </div>
        `;
      });
    }
  };

  // === Dynamic Form Fields ===
  /**
   * Adds a new document input row to the form.
   */
  window.addDokumen = () => {
    const list = document.getElementById('dokumen-list');
    if (!list) return;

    const newRow = document.createElement('div');
    newRow.className = 'border rounded p-3 mb-3 dynamic-item';
    newRow.innerHTML = `
      <div class="row g-2">
        <div class="col-12">
          <select class="form-select form-select-sm" name="dokumen[${dokCounter}][jenis]" required>
            <option selected disabled value="">-- Pilih Jenis Dokumen --</option>
            <option>Transkip</option>
            <option>Surat Tugas</option>
            <option>SK</option>
            <option>Sertifikat</option>
            <option>Penyetaraan Ijazah</option>
            <option>Laporan Kegiatan</option>
            <option>Ijazah</option>
            <option>Buku/Bahan Ajar</option>
          </select>
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control form-control-sm" name="dokumen[${dokCounter}][nama]" placeholder="Nama Dokumen" required>
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control form-control-sm" name="dokumen[${dokCounter}][nomor]" placeholder="Nomor">
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control form-control-sm" name="dokumen[${dokCounter}][tautan]" placeholder="Tautan">
        </div>
        <div class="col-12">
          <input type="file" class="form-control form-control-sm" name="dokumen[${dokCounter}][file]" required>
        </div>
      </div>
      <button type="button" class="btn btn-sm btn-outline-danger mt-2 remove-item-btn"><i class="fa fa-trash"></i> Hapus Dokumen</button>
    `;
    list.appendChild(newRow);
    dokCounter++;
  };

  /**
   * Adds a new member input row to the form.
   * @param {string} selectedPegawaiId - The selected pegawai ID.
   * @param {string} peranValue - The role value.
   */
  window.addAnggota = (selectedPegawaiId = '', peranValue = '') => {
    const list = document.getElementById('anggota-list');
    if (!list || !pegawaiData) return;

    const newRow = document.createElement('div');
    newRow.className = 'dynamic-item mb-3 p-3 border rounded';

    const pegawaiOptions = [
      '<option selected disabled value="">-- Pilih Dosen --</option>',
      ...pegawaiData.map(
        (p) =>
          `<option value="${p.id}" ${p.id == selectedPegawaiId ? 'selected' : ''}>${p.nama_lengkap}</option>`
      ),
    ].join('');

    newRow.innerHTML = `
      <div class="mb-2">
        <select class="form-select select2-dosen" name="anggota[${anggotaCounter}][pegawai_id]" required>
          ${pegawaiOptions}
        </select>
      </div>
      <div class="d-flex gap-2">
        <input type="text" class="form-control" name="anggota[${anggotaCounter}][peran]" placeholder="Masukkan Peran" value="${peranValue}" required>
        <button class="btn btn-outline-danger remove-item-btn" type="button">
          <i class="fa fa-trash"></i>
        </button>
      </div>
    `;

    list.appendChild(newRow);
    anggotaCounter++;
    initSelect2Dosen();
  };

  // === Event Listeners ===
  // Search and filter inputs
  elements.searchInput?.addEventListener('keyup', debounce(performFilterAndSearch, 500));
  elements.filterSemester?.addEventListener('change', performFilterAndSearch);
  elements.filterLingkup?.addEventListener('change', performFilterAndSearch);
  elements.filterStatus?.addEventListener('change', performFilterAndSearch);

  // Pagination click handler
  document.body.addEventListener('click', (event) => {
    const link = event.target.closest('#pagination-container a');
    if (link) {
      event.preventDefault();
      const url = link.getAttribute('href');
      if (url && url !== '#') {
        history.pushState(null, '', url);
        fetchData(url);
      }
    }
  });

  // Success modal close button
  document.getElementById('btnSelesai')?.addEventListener('click', () => {
    clearTimeout(successModalTimeout);
    hideSuccessModal();
  });

  // Add and edit button handlers
  document.body.addEventListener('click', async (event) => {
    const editButton = event.target.closest('.btn-edit');
    if (editButton) {
      event.preventDefault();
      const id = editButton.getAttribute('data-id');
      elements.modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Penunjang';
      elements.formMethodInput.value = 'PATCH';
      elements.formEditIdInput.value = id;

      try {
        const response = await fetch(`/penunjang/${id}`);
        if (!response.ok) throw new Error('Data not found');
        const data = await response.json();
        populateEditForm(data);
        penunjangModalInstance.show();
        initSelect2Kegiatan();
        initSelect2Dosen();
      } catch (error) {
        console.error('Failed to fetch data for edit:', error);
        alert('Gagal memuat data untuk diedit.');
      }
    }
  });

  document.querySelector('[data-bs-target="#penunjangModal"]')?.addEventListener('click', () => {
    elements.modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Penunjang';
    initSelect2Kegiatan();
    initSelect2Dosen();
  });

  // Form submission
  elements.saveButton?.addEventListener('click', async () => {
    if (!elements.form.checkValidity()) {
      elements.form.reportValidity();
      return;
    }

    const formData = new FormData(elements.form);
    const isEditMode = elements.formMethodInput.value === 'PATCH';
    const id = elements.formEditIdInput.value;
    const url = isEditMode ? `/penunjang/${id}` : '/penunjang';

    elements.saveButton.disabled = true;
    elements.saveButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menyimpan...';

    try {
      const response = await fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
          'X-CSRF-TOKEN': elements.csrfToken,
          'Accept': 'application/json',
        },
      });

      const result = await response.json();
      if (!response.ok) throw result;

      penunjangModalInstance.hide();
      const successMessage = isEditMode ? 'Data Berhasil Diperbarui' : 'Data Berhasil Disimpan';
      showSuccessModal(successMessage, result.success);
      setTimeout(() => {
        performFilterAndSearch();
      }, 1300);
    } catch (error) {
      console.error('Submission error:', error);
      alert(error.errors ? 'Data tidak valid. Periksa kembali isian Anda.' : `Terjadi kesalahan: ${error.error || 'Gagal menyimpan data'}`);
    } finally {
      elements.saveButton.disabled = false;
      elements.saveButton.innerHTML = 'Simpan';
    }
  });

  // Reset modal on close
  elements.penunjangModal?.addEventListener('hidden.bs.modal', () => {
    elements.form.reset();
    document.getElementById('dokumen-list').innerHTML = '';
    document.getElementById('anggota-list').innerHTML = '';
    dokCounter = 0;
    anggotaCounter = 0;
    elements.modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Penunjang';
    elements.formMethodInput.value = 'POST';
    elements.formEditIdInput.value = '';
  });

  // Remove dynamic items
  document.body.addEventListener('click', (event) => {
    const removeBtn = event.target.closest('.remove-item-btn');
    if (removeBtn) {
      removeBtn.closest('.dynamic-item').remove();
    }
  });

  // === Detail Modal ===
  const detailFields = {
    kegiatan: document.getElementById('detail-kegiatan'),
    jenis_kegiatan: document.getElementById('detail-jenis_kegiatan'),
    lingkup: document.getElementById('detail-lingkup'),
    nama_kegiatan: document.getElementById('detail-nama_kegiatan'),
    instansi: document.getElementById('detail-instansi'),
    nomor_sk: document.getElementById('detail-nomor_sk'),
    tmt_mulai: document.getElementById('detail-tmt_mulai'),
    tmt_selesai: document.getElementById('detail-tmt_selesai'),
    anggotaList: document.getElementById('detail-anggota-list'),
    dokumenList: document.getElementById('detail-dokumen-list'),
  };

  /**
   * Populates the detail modal with data.
   * @param {Object} data - The data to display in the modal.
   */
  const populateDetailModal = (data) => {
    const formatDate = (dateString) =>
      dateString
        ? new Date(dateString).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })
        : '-';

    Object.entries(detailFields).forEach(([key, field]) => {
      if (key !== 'anggotaList' && key !== 'dokumenList') {
        field.textContent = data[key] || '-';
      }
    });

    detailFields.tmt_mulai.textContent = formatDate(data.tmt_mulai);
    detailFields.tmt_selesai.textContent = formatDate(data.tmt_selesai);

    detailFields.anggotaList.innerHTML = '';
    if (data.anggota?.length > 0) {
      data.anggota.forEach((item) => {
        const anggotaWrapper = document.createElement('div');
        anggotaWrapper.className = 'detail-grid-container nested full-width-detail';
        anggotaWrapper.style.marginBottom = '1rem';
        anggotaWrapper.innerHTML = `
          <div class="detail-item"><small>Nama Dosen</small><p>${item.pegawai ? item.pegawai.nama_lengkap : 'N/A'}</p></div>
          <div class="detail-item"><small>Peran</small><p>${item.peran || '-'}</p></div>
        `;
        detailFields.anggotaList.appendChild(anggotaWrapper);
      });
    } else {
      detailFields.anggotaList.innerHTML = '<p class="text-muted fst-italic">Tidak ada anggota.</p>';
    }

    detailFields.dokumenList.innerHTML = '';
    if (data.dokumen?.length > 0) {
      const dokumenGrid = document.createElement('div');
      dokumenGrid.className = 'detail-grid-container nested';
      data.dokumen.forEach((item) => {
        const fileUrl = `/storage/${item.file_path.replace('public/', '')}`;
        dokumenGrid.innerHTML += `
          <div class="detail-item"><small>Jenis Dokumen</small><p>${item.jenis_dokumen || '-'}</p></div>
          <div class="detail-item"><small>Nama Dokumen</small><p>${item.nama_dokumen || '-'}</p></div>
          <div class="detail-item"><small>Nomor</small><p>${item.nomor_dokumen || '-'}</p></div>
          <div class="detail-item"><small>Tautan</small><p>${
            item.tautan ? `<a href="${item.tautan}" target="_blank" rel="noopener noreferrer">${item.tautan}</a>` : '-'
          }</p></div>
          <div class="detail-item full-width-detail">
            <small>File Dokumen</small>
            <div class="file-actions-buttons">
              <a href="${fileUrl}" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-sm"><i class="fas fa-file-alt me-2"></i>Lihat Dokumen</a>
            </div>
          </div>
        `;
      });
      detailFields.dokumenList.appendChild(dokumenGrid);
    } else {
      detailFields.dokumenList.innerHTML = '<p class="text-muted fst-italic">Tidak ada dokumen.</p>';
    }
  };

  elements.detailModal?.addEventListener('show.bs.modal', async (event) => {
    const button = event.relatedTarget;
    if (!button || !button.classList.contains('btn-lihat')) return;

    Object.values(detailFields).forEach((field) => {
      if (field) {
        field.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>';
      }
    });

    const id = button.getAttribute('data-id');
    try {
      const response = await fetch(`/penunjang/${id}`);
      if (!response.ok) throw new Error('Gagal mengambil data dari server.');
      const data = await response.json();
      populateDetailModal(data);
    } catch (error) {
      console.error('Error fetching details:', error);
      detailFields.kegiatan.textContent = 'Gagal memuat data. Silakan coba lagi.';
    }
  });

  // === Verification Modal ===
  /**
   * Initializes the verification modal and its event handlers.
   */
  const initVerificationModal = () => {
    if (!elements.verificationModal) return;

    const btnTerima = document.getElementById('popupBtnTerima');
    const btnTolak = document.getElementById('popupBtnTolak');

    const hideVerifModal = () => {
      elements.verificationModal.classList.remove('show');
      elements.verificationModal.removeAttribute('data-record-id');
    };

    document.body.addEventListener('click', (event) => {
      const btnVerifikasi = event.target.closest('.btn-verifikasi');
      if (btnVerifikasi) {
        event.preventDefault();
        const recordId = btnVerifikasi.getAttribute('data-id');
        elements.verificationModal.setAttribute('data-record-id', recordId);
        elements.verificationModal.classList.add('show');
      }
    });

    const handleVerification = async (newStatus) => {
      const recordId = elements.verificationModal.getAttribute('data-record-id');
      if (!recordId) return;

      const currentBtn = newStatus === 'Sudah Diverifikasi' ? btnTerima : btnTolak;
      const originalBtnText = currentBtn.innerHTML;
      currentBtn.disabled = true;
      currentBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Memproses...';

      try {
        const response = await fetch(`/penunjang/${recordId}/verifikasi`, {
          method: 'PATCH',
          headers: {
            'X-CSRF-TOKEN': elements.csrfToken,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
          },
          body: JSON.stringify({ status: newStatus }),
        });

        const result = await response.json();
        if (!response.ok) throw new Error(result.error || 'Gagal memproses verifikasi.');

        hideVerifModal();
        showSuccessModal('Status Verifikasi Disimpan', result.success);
        setTimeout(() => performFilterAndSearch(), 1300);
      } catch (error) {
        console.error('Verification error:', error);
        alert(error.message);
      } finally {
        currentBtn.disabled = false;
        currentBtn.innerHTML = originalBtnText;
      }
    };

    btnTerima?.addEventListener('click', () => handleVerification('Sudah Diverifikasi'));
    btnTolak?.addEventListener('click', () => handleVerification('Ditolak'));
    document.getElementById('popupBtnKembali')?.addEventListener('click', hideVerifModal);
    elements.verificationModal.addEventListener('click', (e) => {
      if (e.target === elements.verificationModal) hideVerifModal();
    });
  };

  // === Delete Modal ===
  /**
   * Initializes the delete modal and its event handlers.
   */
  const initDeleteModal = () => {
    if (!elements.deleteModal) return;

    const confirmButton = document.getElementById('btnKonfirmasiHapus');

    const hideDeleteModal = () => {
      confirmButton.disabled = false;
      confirmButton.innerHTML = 'Ya, Hapus';
      elements.deleteModal.classList.remove('show');
      if (!document.querySelector('.modal.show')) document.body.style.overflow = '';
      elements.deleteModal.removeAttribute('data-record-id');
    };

    document.body.addEventListener('click', (event) => {
      const btnHapus = event.target.closest('.btn-hapus');
      if (btnHapus) {
        event.preventDefault();
        const recordId = btnHapus.getAttribute('data-id');
        elements.deleteModal.setAttribute('data-record-id', recordId);
        elements.deleteModal.classList.add('show');
        document.body.style.overflow = 'hidden';
      }
    });

    document.getElementById('btnBatalHapus')?.addEventListener('click', hideDeleteModal);
    confirmButton?.addEventListener('click', async () => {
      const recordIdToDelete = elements.deleteModal.getAttribute('data-record-id');
      if (!recordIdToDelete) return;

      confirmButton.disabled = true;
      confirmButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menghapus...';

      try {
        const response = await fetch(`/penunjang/${recordIdToDelete}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': elements.csrfToken,
            'Accept': 'application/json',
          },
        });

        const result = await response.json();
        if (!response.ok) throw new Error(result.error || 'Gagal menghapus data.');

        hideDeleteModal();
        showSuccessModal('Data Berhasil Dihapus', result.success);
        setTimeout(() => performFilterAndSearch(), 1300);
      } catch (error) {
        console.error('Delete error:', error);
        alert(error.message);
        hideDeleteModal();
      }
    });

    window.addEventListener('click', (event) => {
      if (event.target === elements.deleteModal) hideDeleteModal();
    });
  };

  // === Datepicker Enhancement ===
  document.querySelectorAll('input[type="date"]').forEach((el) => {
    el.style.cursor = 'pointer';
    el.addEventListener('click', () => {
      if (el.showPicker) el.showPicker();
    });
  });

  document.querySelector('.btn-export')?.addEventListener('click', (e) => {
  e.preventDefault();

  const params = new URLSearchParams({
    search: elements.searchInput?.value || '',
    semester: elements.filterSemester?.value || '',
    lingkup: elements.filterLingkup?.value || '',
    status: elements.filterStatus?.value || '',
  });

  // Arahkan ke route export dengan parameter
  window.location.href = `/penunjang/export?${params.toString()}`;
});

  // === Initialize Components ===
  initSelect2Kegiatan();
  initSelect2Dosen();
  initVerificationModal();
  initDeleteModal();
  performFilterAndSearch(); // Initial data load
});