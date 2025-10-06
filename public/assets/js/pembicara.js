document.addEventListener("DOMContentLoaded", function () {
  /**
   * ===================================================================
   * Utility: Spinner Button Handler
   * -------------------------------------------------------------------
   * Mengganti teks tombol dan menambahkan spinner saat operasi sedang
   * berlangsung. Menyimpan teks asli pada data attribute untuk restore.
   * ===================================================================
   */
  function setButtonLoading(button, isLoading, loadingText = "") {
    if (!button) return;
    if (isLoading) {
      // simpan isi lama jika belum tersimpan
      if (!button.dataset.originalHtml) button.dataset.originalHtml = button.innerHTML;
      button.disabled = true;
      button.setAttribute('aria-busy', 'true');
      button.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> ${loadingText}`;
    } else {
      button.disabled = false;
      button.removeAttribute('aria-busy');
      if (button.dataset.originalHtml) {
        button.innerHTML = button.dataset.originalHtml;
        delete button.dataset.originalHtml;
      }
    }
  }

  /**
   * ===================================================================
   * Notifikasi Sukses (Modal & Suara)
   * -------------------------------------------------------------------
   * Menampilkan modal sukses jika meta flash-success tersedia atau
   * jika dipanggil secara eksplisit. Auto-hide opsional.
   * ===================================================================
   */
  const handleSuccessNotification = (message, autoHideDelay = null) => {
    const successMessage = message || document.querySelector('meta[name="flash-success"]')?.getAttribute('content');
    if (!successMessage) return;

    const modalBerhasil = document.getElementById('modalBerhasil');
    if (!modalBerhasil) return;

    const titleEl = document.getElementById('berhasil-title');
    const subEl = document.getElementById('berhasil-subtitle');
    if (titleEl) titleEl.textContent = 'Berhasil!';
    if (subEl) subEl.textContent = successMessage;

    modalBerhasil.classList.add('show');

    // Suara (jika tersedia)
    try {
      const successSound = new Audio('/assets/sounds/Success.mp3');
      successSound.play().catch(err => {/* non-blocking */});
    } catch (e) { /* ignore */ }

    if (autoHideDelay) {
      setTimeout(() => modalBerhasil.classList.remove('show'), autoHideDelay);
    }

    const btnSelesai = document.getElementById('btnSelesai');
    if (btnSelesai) btnSelesai.addEventListener('click', () => modalBerhasil.classList.remove('show'));
  };

  /**
   * ===================================================================
   * Hapus Data (Modal Konfirmasi + Spinner)
   * -------------------------------------------------------------------
   */
  const hapusModal = document.getElementById('modalKonfirmasiHapus');
  let formToDelete = null;
  let lastDeleteTrigger = null; // tombol yang memicu modal (untuk spinner)

  document.body.addEventListener('click', function (event) {
    const deleteBtn = event.target.closest('.btn-hapus-data');
    if (!deleteBtn) return;

    event.preventDefault();
    formToDelete = deleteBtn.closest('form');
    lastDeleteTrigger = deleteBtn;

    if (hapusModal) hapusModal.classList.add('show');
  });

  if (hapusModal) {
    const btnKonfirmasi = document.getElementById('btnKonfirmasiHapus');
    const btnBatal = document.getElementById('btnBatalHapus');

    if (btnKonfirmasi) {
      btnKonfirmasi.addEventListener('click', function () {
        if (!formToDelete) {
          hapusModal.classList.remove('show');
          return;
        }

        // set spinner pada tombol konfirmasi
        setButtonLoading(btnKonfirmasi, true, 'Menghapus...');
        formToDelete.submit();
      });
    }

    if (btnBatal) {
      btnBatal.addEventListener('click', function () {
        formToDelete = null;
        hapusModal.classList.remove('show');
      });
    }

    // Klik overlay untuk menutup
    hapusModal.addEventListener('click', function (e) {
      if (e.target === hapusModal) {
        formToDelete = null;
        hapusModal.classList.remove('show');
      }
    });
  }

  /**
   * ===================================================================
   * Verifikasi (Modal + AJAX PATCH + Spinner)
   * -------------------------------------------------------------------
   */
  const verifikasiModal = document.getElementById('modalKonfirmasiVerifikasi');
  const csrfMeta = document.querySelector('meta[name="csrf-token"]');
  const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';
  let currentVerifikasiId = null;

  document.body.addEventListener('click', function (event) {
    const verifikasiBtn = event.target.closest('.btn-verifikasi');
    if (!verifikasiBtn) return;

    currentVerifikasiId = verifikasiBtn.dataset.id;
    if (verifikasiModal) verifikasiModal.classList.add('show');
  });

  if (verifikasiModal) {
    verifikasiModal.addEventListener('click', function (event) {
      const target = event.target;
      const actionBtn = target.closest('.btn-popup');

      // Tutup saat klik di overlay
      if (!actionBtn && (target === verifikasiModal || target.classList.contains('konfirmasi-hapus-overlay'))) {
        verifikasiModal.classList.remove('show');
        return;
      }

      if (!actionBtn) return;

      if (actionBtn.id === 'popupBtnKembali') {
        verifikasiModal.classList.remove('show');
        return;
      }

      let status = '';
      if (actionBtn.id === 'popupBtnTerima') status = 'sudah_diverifikasi';
      else if (actionBtn.id === 'popupBtnTolak') status = 'ditolak';

      if (!status || !currentVerifikasiId) return;

      setButtonLoading(actionBtn, true, 'Memproses...');
      processVerification(currentVerifikasiId, status)
        .finally(() => setButtonLoading(actionBtn, false));
    });
  }

  async function processVerification(id, status) {
    try {
      const resp = await fetch(`/pembicara/${id}/verifikasi`, {
        method: 'PATCH',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ status: status })
      });

      const result = await resp.json();

      if (resp.ok && result.success) {
        handleSuccessNotification(result.message);
        // reload setelah success agar state konsisten
        setTimeout(() => window.location.reload(), 1400);
      } else {
        throw new Error(result.message || 'Gagal memproses verifikasi.');
      }
    } catch (err) {
      console.error(err);
      alert('Error: ' + (err.message || err));
    } finally {
      if (verifikasiModal) verifikasiModal.classList.remove('show');
    }
  }

  /**
   * ===================================================================
   * Edit Data (Ambil data via AJAX lalu isi form Edit)
   * - juga menambahkan spinner pada tombol submit Edit
   * ===================================================================
   */
  const editModal = document.getElementById('editPembicaraModal');
  if (editModal) {
    editModal.addEventListener('show.bs.modal', async function (event) {
      const trigger = event.relatedTarget;
      if (!trigger) return;

      const id = trigger.dataset.id;
      const form = document.getElementById('editPembicaraForm');
      const wrapper = document.getElementById('editDokumenWrapper');

      if (!form) return;

      // Reset state form
      form.reset();
      if (wrapper) wrapper.innerHTML = '';
      const deletedInput = document.getElementById('deleted_dokumen_ids');
      if (deletedInput) deletedInput.value = '';
      form.action = `/pembicara/${id}`;

      try {
        const resp = await fetch(`/pembicara/${id}/edit`);
        if (!resp.ok) throw new Error('Gagal mengambil data untuk diedit');
        const data = await resp.json();

        // Map data ke field form (asumsi nama input di-backend sesuai key)
        for (const key in data) {
          const selector = `[name="${key}"][id^="edit_"]`;
          const field = form.querySelector(selector);
          if (field) field.value = data[key];
        }

        // Jika ada dokumen, render sebagai existing items
        if (Array.isArray(data.dokumen) && data.dokumen.length) {
          data.dokumen.forEach(doc => {
            if (wrapper) wrapper.appendChild(createExistingDokumenItem(doc));
          });
        }

      } catch (err) {
        console.error('Error fetching data for edit:', err);
        alert('Terjadi kesalahan saat memuat data. Silakan coba lagi.');
        try { bootstrap.Modal.getInstance(editModal).hide(); } catch (e) { /* ignore */ }
      }
    });

    // Spinner pada submit Edit
    const editForm = document.getElementById('editPembicaraForm');
    if (editForm) {
      const editSubmitBtn = editForm.querySelector('button[type="submit"]');
      if (editSubmitBtn) {
        editForm.addEventListener('submit', function () {
          setButtonLoading(editSubmitBtn, true, 'Menyimpan...');
        });
      }
    }
  }

  function createExistingDokumenItem(doc) {
    const item = document.createElement('div');
    item.className = 'dokumen-item border rounded p-3 mb-3 position-relative bg-light';
    item.dataset.id = doc.id;

    const docName = doc.nama_dokumen || '';
    const docNomor = doc.nomor || '';
    const docTautan = doc.tautan || '';

    const jenisOptions = ['Transkrip','Surat Tugas','SK','Sertifikat','Penyetaraan Ijazah','Laporan Kegiatan','Ijazah','Buku / Bahan Ajar'];
    const optionsHtml = jenisOptions.map(opt => `<option value="${opt}" ${doc.jenis_dokumen === opt ? 'selected' : ''}>${opt}</option>`).join('');

    item.innerHTML = `
      <button type="button" class="btn-close position-absolute top-0 end-0 m-2 removeExistingDokumen" aria-label="Close" title="Hapus Dokumen Ini"></button>
      <div class="row g-2">
        <div class="col-12">
          <label class="form-label">Jenis Dokumen</label>
          <select name="existing_dokumen[${doc.id}][jenis_dokumen]" class="form-select">
            <option value="">-- Pilih Jenis Dokumen --</option>
            ${optionsHtml}
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label">Nama Dokumen</label>
          <input type="text" name="existing_dokumen[${doc.id}][nama_dokumen]" class="form-control" placeholder="Nama Dokumen" value="${docName}">
        </div>
        <div class="col-md-4">
          <label class="form-label">Nomor</label>
          <input type="text" name="existing_dokumen[${doc.id}][nomor]" class="form-control" placeholder="Nomor" value="${docNomor}">
        </div>
        <div class="col-md-4">
          <label class="form-label">Tautan</label>
          <input type="url" name="existing_dokumen[${doc.id}][tautan]" class="form-control" placeholder="https://" value="${docTautan}">
        </div>
        <div class="col-12 mt-2">
          <label class="form-label">File Tersimpan</label>
          <div class="alert alert-secondary p-2">
            <a href="/${doc.file_path}" target="_blank" class="text-primary fw-bold">${docName || 'Lihat File'}</a>
            <small class="d-block text-muted">File tidak dapat diubah dari sini. Hapus dokumen untuk mengganti file.</small>
          </div>
        </div>
      </div>
    `;

    return item;
  }

  // Handler untuk menghapus existing dokumen pada form edit
  const editDokumenWrapper = document.getElementById('editDokumenWrapper');
  if (editDokumenWrapper) {
    editDokumenWrapper.addEventListener('click', function (e) {
      if (!e.target.classList.contains('removeExistingDokumen')) return;
      const item = e.target.closest('.dokumen-item');
      if (!item) return;
      const docId = item.dataset.id;
      const hiddenInput = document.getElementById('deleted_dokumen_ids');
      const currentIds = hiddenInput && hiddenInput.value ? hiddenInput.value.split(',') : [];

      if (!currentIds.includes(docId)) {
        currentIds.push(docId);
        if (hiddenInput) hiddenInput.value = currentIds.join(',');
      }

      item.remove();
    });
  }

  /**
   * ===================================================================
   * Detail Data (Modal) -- Menampilkan detail pembicara + dokumen
   * ===================================================================
   */
  const detailModal = document.getElementById('detailPembicaraModal');
  if (detailModal) {
    detailModal.addEventListener('show.bs.modal', async function (event) {
      const trigger = event.relatedTarget;
      if (!trigger) return;
      const id = trigger.dataset.id;

      const setDetailText = (elementId, text) => {
        const el = document.getElementById(elementId);
        if (el) el.textContent = text || '-';
      };

      const fields = ['nama','kegiatan','capaian','kategori-pembicara','makalah','pertemuan','tanggal','penyelenggara','tingkat','bahasa','litabmas'];
      fields.forEach(f => setDetailText(`detail-${f}`, 'Memuat data...'));

      const dokumenList = document.getElementById('detail-dokumen-list');
      if (dokumenList) dokumenList.innerHTML = '<p class="text-muted">Memuat dokumen...</p>';

      try {
        const resp = await fetch(`/pembicara/${id}/edit`);
        if (!resp.ok) throw new Error('Data tidak ditemukan');
        const data = await resp.json();

        setDetailText('detail-nama', data.pegawai ? data.pegawai.nama_lengkap : 'N/A');
        setDetailText('detail-kegiatan', data.kegiatan === 'lainnya' ? data.kegiatan_lainnya : (data.kegiatan || '-').replace(/_/g, ' '));
        setDetailText('detail-capaian', data.kategori_capaian || '-');
        setDetailText('detail-kategori-pembicara', data.kategori_pembicara || '-');
        setDetailText('detail-makalah', data.judul_makalah || '-');
        setDetailText('detail-pertemuan', data.nama_pertemuan || '-');
        setDetailText('detail-tanggal', data.tanggal_pelaksana || '-');
        setDetailText('detail-penyelenggara', data.penyelenggara || '-');
        setDetailText('detail-tingkat', data.tingkat_pertemuan || '-');
        setDetailText('detail-bahasa', data.bahasa || '-');
        setDetailText('detail-litabmas', data.litabmas || '-');

        if (dokumenList) dokumenList.innerHTML = '';
        if (Array.isArray(data.dokumen) && data.dokumen.length) {
          data.dokumen.forEach(doc => {
            const col = document.createElement('div');
            col.className = 'col-md-6';
            col.innerHTML = `
              <div class="detail-doc mb-3">
                <div><strong>${doc.nama_dokumen || doc.jenis_dokumen || 'Dokumen'}</strong></div>
                <a href="/${doc.file_path}" class="btn btn-sm btn-success mt-1" target="_blank"><i class="fa fa-eye me-1"></i> Lihat File</a>
              </div>
            `;
            if (dokumenList) dokumenList.appendChild(col);
          });
        } else {
          if (dokumenList) dokumenList.innerHTML = '<div class="col-12"><p class="text-muted fst-italic">Tidak ada dokumen terlampir.</p></div>';
        }

      } catch (err) {
        console.error('Error fetching details:', err);
        if (dokumenList) dokumenList.innerHTML = '<p class="text-danger">Gagal memuat data.</p>';
      }
    });
  }

  /**
   * ===================================================================
   * Utility: Validasi file (max 5MB) + inisialisasi handler file inputs
   * ===================================================================
   */
  function validateFileSize(input) {
    if (!input || !input.files || !input.files.length) return;
    const file = input.files[0];
    const maxBytes = 5 * 1024 * 1024; // 5MB
    if (file.size > maxBytes) {
      alert('Ukuran file maksimal 5MB!');
      input.value = '';
    }
  }

  function initFileValidation(input) {
    if (!input) return;
    input.addEventListener('change', function () { validateFileSize(this); });
  }

  /**
   * ===================================================================
   * Dokumen Dinamis (Tambah & Edit)
   * - createDokumenItem(index)
   * - initDokumenHandler(wrapperId, addBtnId)
   * ===================================================================
   */
  function createDokumenItem(index) {
    const item = document.createElement('div');
    item.className = 'dokumen-item border rounded p-3 mb-3 position-relative';

    item.innerHTML = `
      <button type="button" class="btn-close position-absolute top-0 end-0 m-2 removeDokumen" aria-label="Close"></button>
      <div class="row g-2">
        <div class="col-12">
          <label class="form-label">Jenis Dokumen (Baru)</label>
          <select name="dokumen[${index}][jenis]" class="form-select">
            <option value="" disabled selected>-- Pilih Jenis --</option>
            <option value="Transkrip">Transkrip</option>
            <option value="Surat Tugas">Surat Tugas</option>
            <option value="SK">SK</option>
            <option value="Sertifikat">Sertifikat</option>
            <option value="Penyetaraan Ijazah">Penyetaraan Ijazah</option>
            <option value="Laporan Kegiatan">Laporan Kegiatan</option>
            <option value="Ijazah">Ijazah</option>
            <option value="Buku / Bahan Ajar">Buku / Bahan Ajar</option>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label">Nama Dokumen</label>
          <input type="text" name="dokumen[${index}][nama]" class="form-control" placeholder="Nama Dokumen">
        </div>
        <div class="col-md-4">
          <label class="form-label">Nomor</label>
          <input type="text" name="dokumen[${index}][nomor]" class="form-control" placeholder="Nomor">
        </div>
        <div class="col-md-4">
          <label class="form-label">Tautan</label>
          <input type="url" name="dokumen[${index}][tautan]" class="form-control" placeholder="https://...">
        </div>
        <div class="col-12">
          <label class="form-label">File <small class="text-muted">(Wajib untuk dokumen baru)</small></label>
          <input type="file" name="dokumen[${index}][file]" class="form-control file-input" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.txt" required>
        </div>
      </div>
    `;

    const fileInput = item.querySelector('.file-input');
    if (fileInput) initFileValidation(fileInput);

    return item;
  }

  function initDokumenHandler(wrapperId, addBtnId) {
    const wrapper = document.getElementById(wrapperId);
    const addBtn = document.getElementById(addBtnId);
    if (!wrapper || !addBtn) return;

    addBtn.addEventListener('click', function () {
      const nextIndex = wrapper.querySelectorAll('.dokumen-item').length;
      const newItem = createDokumenItem(nextIndex);
      wrapper.appendChild(newItem);
    });

    wrapper.addEventListener('click', function (e) {
      const rem = e.target.closest('.removeDokumen');
      if (rem) {
        const docItem = rem.closest('.dokumen-item');
        if (docItem) docItem.remove();
      }
    });

    // Inisialisasi validasi untuk file-input yang sudah ada
    wrapper.querySelectorAll('.file-input').forEach(initFileValidation);
  }

  /**
   * ===================================================================
   * Toggle "Lainnya" untuk beberapa select
   * - selectId: id elemen select
   * - inputId: id elemen input yang muncul saat memilih "lainnya"
   * ===================================================================
   */
  function initToggleLainnya(selectId, inputId) {
    const select = document.getElementById(selectId);
    const input = document.getElementById(inputId);
    if (!select || !input) return;

    select.addEventListener('change', function () {
      if (this.value === 'lainnya') {
        input.classList.remove('d-none');
        input.required = true;
        input.focus();
      } else {
        input.classList.add('d-none');
        input.required = false;
        input.value = '';
      }
    });
  }

  /**
   * ===================================================================
   * Filter form: debounce search dan auto-submit untuk select
   * ===================================================================
   */
  const filterForm = document.getElementById('filterForm');
  if (filterForm) {
    const searchInput = filterForm.querySelector('.search-input');
    const selectFilters = filterForm.querySelectorAll('.filter-select');
    let debounceTimeout = null;

    if (searchInput) {
      searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => filterForm.submit(), 500);
      });
    }

    selectFilters.forEach(function (sel) {
      sel.addEventListener('change', function () { filterForm.submit(); });
    });
  }

  /**
   * ===================================================================
   * Peningkatan Datepicker (native) -- klik menampilkan picker bila tersedia
   * ===================================================================
   */
  document.querySelectorAll('input[type="date"]').forEach((el) => {
    el.style.cursor = 'pointer';
    el.addEventListener('click', function () {
      if (typeof this.showPicker === 'function') this.showPicker();
    });
  });

  /**
   * ===================================================================
   * Inisialisasi jQuery (Select2 + modal reset behavior)
   * ===================================================================
   */
  if (typeof $ !== 'undefined' && typeof $.fn.select2 !== 'undefined') {
    $(document).ready(function () {
      // Init select2 untuk modal TAMBAH
      const selectsPembicaraModal = {
        '#kegiatan': '-- Pilih Kegiatan --',
        '#pegawai_id': '-- Pilih Pegawai --'
      };
      Object.entries(selectsPembicaraModal).forEach(([selector, placeholderText]) => {
        const el = $(selector);
        if (el.length) {
          el.select2({ theme: 'bootstrap-5', placeholder: placeholderText, dropdownParent: $('#pembicaraModal .modal-content'), allowClear: true, width: '100%' });
        }
      });

      // Init select2 untuk modal EDIT
      const selectsEditPembicaraModal = {
        '#edit_kegiatan': '-- Pilih Kegiatan --',
        '#edit_pegawai_id': '-- Pilih Pegawai --'
      };
      Object.entries(selectsEditPembicaraModal).forEach(([selector, placeholderText]) => {
        const el = $(selector);
        if (el.length) {
          el.select2({ theme: 'bootstrap-5', placeholder: placeholderText, dropdownParent: $('#editPembicaraModal .modal-content'), allowClear: true, width: '100%' });
        }
      });

      // Toggle "Lainnya" (TAMBAH)
      $('#kegiatan').on('change', function () { if ($(this).val() === 'lainnya') { $('#kegiatan_lainnya').removeClass('d-none').focus(); } else { $('#kegiatan_lainnya').addClass('d-none').val(''); } });
      $('#kategori_capaian').on('change', function () { if ($(this).val() === 'lainnya') { $('#kategori_capaian_lainnya').removeClass('d-none').focus(); } else { $('#kategori_capaian_lainnya').addClass('d-none').val(''); } });

      // Toggle "Lainnya" (EDIT)
      $('#edit_kegiatan').on('change', function () { if ($(this).val() === 'lainnya') { $('#edit_kegiatan_lainnya').removeClass('d-none').focus(); } else { $('#edit_kegiatan_lainnya').addClass('d-none').val(''); } });
      $('#edit_kategori_capaian').on('change', function () { if ($(this).val() === 'lainnya') { $('#edit_kategori_capaian_lainnya').removeClass('d-none').focus(); } else { $('#edit_kategori_capaian_lainnya').addClass('d-none').val(''); } });

      // Reset form saat modal TAMBAH ditutup
      $('#pembicaraModal').on('hidden.bs.modal', function () {
        const form = $(this).find('form')[0];
        if (form) form.reset();

        // Reset select2
        $('#kegiatan, #pegawai_id').val(null).trigger('change');

        // Reset field "lainnya"
        $('#kegiatan_lainnya, #kategori_capaian_lainnya').addClass('d-none').val('');

        // Hapus dokumen tambahan kecuali yang pertama
        $('#dokumenWrapper .dokumen-item').not(':first').remove();

        // Reset dokumen pertama
        $('#dokumenWrapper .dokumen-item:first').find('input, select').val('');
      });

      // Set value lama saat modal EDIT dibuka (trigger shown setelah data diisi)
      $('#editPembicaraModal').on('shown.bs.modal', function () {
        const kegiatanVal = $('#edit_kegiatan').data('value');
        const pegawaiVal = $('#edit_pegawai_id').data('value');
        if (kegiatanVal) $('#edit_kegiatan').val(kegiatanVal).trigger('change');
        if (pegawaiVal) $('#edit_pegawai_id').val(pegawaiVal).trigger('change');
      });
    });
  }

  /**
   * ===================================================================
   * Tambah Data: spinner pada tombol submit form tambah
   * - Form: #pembicaraForm
   * ===================================================================
   */
  const tambahForm = document.getElementById('pembicaraForm');
  if (tambahForm) {
    const tambahSubmitBtn = tambahForm.querySelector('button[type="submit"]');
    if (tambahSubmitBtn) {
      tambahForm.addEventListener('submit', function () {
        setButtonLoading(tambahSubmitBtn, true, 'Menyimpan...');
      });
    }
  }

  /**
   * ===================================================================
   * Inisialisasi akhir saat halaman dimuat
   * ===================================================================
   */
  handleSuccessNotification(null, 1500);
  initDokumenHandler('dokumenWrapper', 'addDokumen');
  initDokumenHandler('editDokumenWrapper', 'addEditDokumen');
  initToggleLainnya('kegiatan', 'kegiatan_lainnya');
  initToggleLainnya('kategori_capaian', 'kategori_capaian_lainnya');
  initToggleLainnya('edit_kegiatan', 'edit_kegiatan_lainnya');
  initToggleLainnya('edit_kategori_capaian', 'edit_kategori_capaian_lainnya');

});