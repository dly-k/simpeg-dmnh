document.addEventListener("DOMContentLoaded", function () {
  /**
   * ===================================================================
   * Utility: Spinner Button Handler
   * ===================================================================
   */
  function setButtonLoading(button, isLoading, loadingText = "Memproses...") {
    if (!button) return;
    if (isLoading) {
      if (!button.dataset.originalHtml) button.dataset.originalHtml = button.innerHTML;
      button.disabled = true;
      button.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> ${loadingText}`;
    } else {
      button.disabled = false;
      if (button.dataset.originalHtml) {
        button.innerHTML = button.dataset.originalHtml;
        delete button.dataset.originalHtml;
      }
    }
  }

  /**
   * ===================================================================
   * Notifikasi Sukses (Modal & Suara)
   * ===================================================================
   */
  const handleSuccessNotification = (message, autoHideDelay = 1500) => {
    const successMessage = message || document.querySelector('meta[name="flash-success"]')?.getAttribute('content');
    if (!successMessage) return;
    const modalBerhasil = document.getElementById('modalBerhasil');
    if (!modalBerhasil) return;
    const titleEl = document.getElementById('berhasil-title');
    const subEl = document.getElementById('berhasil-subtitle');
    if (titleEl) titleEl.textContent = 'Berhasil!';
    if (subEl) subEl.textContent = successMessage;
    modalBerhasil.classList.add('show');
    try { new Audio('/assets/sounds/Success.mp3').play().catch(e => {}); } catch (e) {}
    if (autoHideDelay) {
      setTimeout(() => modalBerhasil.classList.remove('show'), autoHideDelay);
    }
    document.getElementById('btnSelesai')?.addEventListener('click', () => modalBerhasil.classList.remove('show'));
  };

  /**
   * ===================================================================
   * Hapus Data (Modal Konfirmasi)
   * ===================================================================
   */
  const hapusModal = document.getElementById('modalKonfirmasiHapus');
  if (hapusModal) {
    let formToDelete = null;
    document.body.addEventListener('click', function (event) {
      const deleteBtn = event.target.closest('.btn-hapus-data');
      if (deleteBtn) {
        event.preventDefault();
        formToDelete = deleteBtn.closest('form');
        hapusModal.classList.add('show');
      }
    });

    document.getElementById('btnKonfirmasiHapus')?.addEventListener('click', function () {
      if (formToDelete) {
        setButtonLoading(this, true, 'Menghapus...');
        formToDelete.submit();
      }
    });

    document.getElementById('btnBatalHapus')?.addEventListener('click', () => hapusModal.classList.remove('show'));
    hapusModal.addEventListener('click', e => { if (e.target === hapusModal) hapusModal.classList.remove('show'); });
  }

  /**
   * ===================================================================
   * Verifikasi (Modal + AJAX)
   * ===================================================================
   */
  const verifikasiModal = document.getElementById('modalKonfirmasiVerifikasi');
  if (verifikasiModal) {
    let currentVerifikasiId = null;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    document.body.addEventListener('click', function (event) {
      const verifikasiBtn = event.target.closest('.btn-verifikasi');
      if (verifikasiBtn) {
        currentVerifikasiId = verifikasiBtn.dataset.id;
        verifikasiModal.classList.add('show');
      }
    });

    verifikasiModal.addEventListener('click', function (event) {
      const actionBtn = event.target.closest('.btn-popup');
      if (!actionBtn) {
        if (event.target === verifikasiModal) verifikasiModal.classList.remove('show');
        return;
      }
      if (actionBtn.id === 'popupBtnKembali') {
        verifikasiModal.classList.remove('show');
        return;
      }
      let status = actionBtn.id === 'popupBtnTerima' ? 'sudah_diverifikasi' : (actionBtn.id === 'popupBtnTolak' ? 'ditolak' : '');
      if (status && currentVerifikasiId) {
        setButtonLoading(actionBtn, true, 'Memproses...');
        fetch(`/pembicara/${currentVerifikasiId}/verifikasi`, {
          method: 'PATCH',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
          body: JSON.stringify({ status })
        })
        .then(resp => resp.json().then(data => ({ ok: resp.ok, data })))
        .then(({ ok, data }) => {
          if (ok && data.success) {
            handleSuccessNotification(data.message);
            setTimeout(() => window.location.reload(), 1400);
          } else {
            throw new Error(data.message || 'Gagal memproses verifikasi.');
          }
        })
        .catch(err => alert('Error: ' + err.message))
        .finally(() => {
          setButtonLoading(actionBtn, false);
          verifikasiModal.classList.remove('show');
        });
      }
    });
  }

  /**
   * ===================================================================
   * Edit Data (AJAX Fetch & Form Population)
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
        if (!form || !wrapper) return;

        // Reset form
        form.reset();
        wrapper.innerHTML = '';
        const deletedInput = document.getElementById('deleted_dokumen_ids');
        if (deletedInput) deletedInput.value = '';
        form.action = `/pembicara/${id}`;

        try {
            const resp = await fetch(`/pembicara/${id}/edit`);
            if (!resp.ok) throw new Error('Gagal mengambil data untuk diedit');
            const data = await resp.json();

            // Isi field form
            Object.keys(data).forEach(key => {
                const field = form.querySelector(`[name="${key}"][id^="edit_"]`);
                if (field) field.value = data[key];
            });

            // Render dokumen yang sudah ada
            if (Array.isArray(data.dokumen)) {
                data.dokumen.forEach(doc => wrapper.appendChild(createExistingDokumenItem(doc)));
            }
        } catch (err) {
            alert('Terjadi kesalahan saat memuat data. Silakan coba lagi.');
            bootstrap.Modal.getInstance(editModal)?.hide();
        }
    });
    
    // Spinner on submit
    const editForm = document.getElementById('editPembicaraForm');
    editForm?.addEventListener('submit', function () {
      const btn = editForm.querySelector('button[type="submit"]');
      setButtonLoading(btn, true, 'Menyimpan...');
    });
  }
  
  function createExistingDokumenItem(doc) {
      const item = document.createElement('div');
      item.className = 'dokumen-item border rounded p-3 mb-3 position-relative bg-light';
      item.dataset.id = doc.id;
      const jenisOptions = ['Transkrip','Surat Tugas','SK','Sertifikat','Penyetaraan Ijazah','Laporan Kegiatan','Ijazah','Buku / Bahan Ajar'];
      const optionsHtml = jenisOptions.map(opt => `<option value="${opt}" ${doc.jenis_dokumen === opt ? 'selected' : ''}>${opt}</option>`).join('');
      item.innerHTML = `
        <button type="button" class="btn-close position-absolute top-0 end-0 m-2 removeExistingDokumen" aria-label="Hapus Dokumen Ini"></button>
        <div class="row g-2">
            <div class="col-12"><label class="form-label">Jenis</label><select name="existing_dokumen[${doc.id}][jenis_dokumen]" class="form-select">${optionsHtml}</select></div>
            <div class="col-md-4"><label class="form-label">Nama</label><input type="text" name="existing_dokumen[${doc.id}][nama_dokumen]" class="form-control" value="${doc.nama_dokumen || ''}"></div>
            <div class="col-md-4"><label class="form-label">Nomor</label><input type="text" name="existing_dokumen[${doc.id}][nomor]" class="form-control" value="${doc.nomor || ''}"></div>
            <div class="col-md-4"><label class="form-label">Tautan</label><input type="url" name="existing_dokumen[${doc.id}][tautan]" class="form-control" value="${doc.tautan || ''}"></div>
            <div class="col-12 mt-2"><div class="alert alert-secondary p-2"><a href="/${doc.file_path}" target="_blank">Lihat File Tersimpan</a><small class="d-block text-muted">File tidak dapat diubah.</small></div></div>
        </div>`;
      return item;
  }
  
  document.getElementById('editDokumenWrapper')?.addEventListener('click', function (e) {
      if (!e.target.classList.contains('removeExistingDokumen')) return;
      const item = e.target.closest('.dokumen-item');
      const docId = item?.dataset.id;
      if (docId) {
          const hiddenInput = document.getElementById('deleted_dokumen_ids');
          const currentIds = hiddenInput.value ? hiddenInput.value.split(',') : [];
          if (!currentIds.includes(docId)) currentIds.push(docId);
          hiddenInput.value = currentIds.join(',');
          item.remove();
      }
  });


  /**
   * ===================================================================
   * [PERBAIKAN] Detail Data (Modal)
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

        // Reset state
        const fields = ['nama','kegiatan','capaian','kategori-pembicara','makalah','pertemuan','tanggal','penyelenggara','tingkat','bahasa','litabmas'];
        fields.forEach(f => setDetailText(`detail-${f}`, 'Memuat...'));
        const docListContainer = document.getElementById('detail-dokumen-list');
        docListContainer.innerHTML = '<p class="text-muted fst-italic col-12">Memuat dokumen...</p>';

        try {
            const resp = await fetch(`/pembicara/${id}/edit`);
            if (!resp.ok) throw new Error('Data tidak ditemukan');
            const data = await resp.json();

            // Isi field teks
            setDetailText('detail-nama', data.pegawai ? data.pegawai.nama_lengkap : 'N/A');
            setDetailText('detail-kegiatan', data.kegiatan === 'lainnya' ? data.kegiatan_lainnya : (data.kegiatan || '-').replace(/_/g, ' '));
            setDetailText('detail-capaian', data.kategori_capaian || '-');
            setDetailText('detail-kategori-pembicara', data.kategori_pembicara || '-');
            setDetailText('detail-makalah', data.judul_makalah || '-');
            setDetailText('detail-pertemuan', data.nama_pertemuan || '-');
            setDetailText('detail-tanggal', data.tanggal_pelaksana ? new Date(data.tanggal_pelaksana).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : '-');
            setDetailText('detail-penyelenggara', data.penyelenggara || '-');
            setDetailText('detail-tingkat', data.tingkat_pertemuan || '-');
            setDetailText('detail-bahasa', data.bahasa || '-');
            setDetailText('detail-litabmas', data.litabmas || '-');

            // Render dokumen dengan detail lengkap
            docListContainer.innerHTML = '';
            if (Array.isArray(data.dokumen) && data.dokumen.length > 0) {
            data.dokumen.forEach(doc => {
                // Daftar item
                const jenisHtml = doc.jenis_dokumen ? `<div class="doc-list-item"><span class="doc-list-label">Jenis:</span><span class="doc-list-value">${doc.jenis_dokumen}</span></div>` : '';
                const namaHtml = doc.nama_dokumen ? `<div class="doc-list-item"><span class="doc-list-label">Nama:</span><span class="doc-list-value">${doc.nama_dokumen}</span></div>` : '';
                const nomorHtml = doc.nomor ? `<div class="doc-list-item"><span class="doc-list-label">Nomor:</span><span class="doc-list-value">${doc.nomor}</span></div>` : '';
                const tautanHtml = doc.tautan ? `<div class="doc-list-item"><span class="doc-list-label">Tautan:</span><span class="doc-list-value"><a href="${doc.tautan.startsWith('http') ? doc.tautan : '//' + doc.tautan}" target="_blank">Kunjungi Tautan</a></span></div>` : '';
                
                // Tombol Lihat File
                const fileButtonHtml = doc.file_path ? `<a href="/${doc.file_path}" class="btn btn-sm btn-success text-white doc-list-file-button" target="_blank"><i class="fa fa-eye me-1"></i>Lihat</a>` : '';

                const docHtml = `
                    <div class="col-lg-6 mb-3">
                        <div class="detail-doc-list">
                            ${fileButtonHtml}
                            ${jenisHtml}
                            ${namaHtml}
                            ${nomorHtml}
                            ${tautanHtml}
                        </div>
                    </div>`;
                docListContainer.innerHTML += docHtml;
            });
        }  else {
                docListContainer.innerHTML = '<p class="text-muted fst-italic col-12">Tidak ada dokumen yang terlampir.</p>';
            }

        } catch (err) {
            console.error('Error fetching details:', err);
            docListContainer.innerHTML = '<p class="text-danger col-12">Gagal memuat detail data.</p>';
        }
    });
  }

  /**
   * ===================================================================
   * Dokumen Dinamis (Tambah & Edit Forms)
   * ===================================================================
   */
  function createDokumenItem(index) {
    const item = document.createElement('div');
    item.className = 'dokumen-item border rounded p-3 mb-3 position-relative';
    item.innerHTML = `
      <button type="button" class="btn-close position-absolute top-0 end-0 m-2 removeDokumen" aria-label="Close"></button>
      <div class="row g-2">
        <div class="col-12"><label class="form-label">Jenis Dokumen</label><select name="dokumen[${index}][jenis]" class="form-select"><option value="" disabled selected>-- Pilih Jenis --</option><option>Transkrip</option><option>Surat Tugas</option><option>SK</option><option>Sertifikat</option><option>Penyetaraan Ijazah</option><option>Laporan Kegiatan</option><option>Ijazah</option><option>Buku / Bahan Ajar</option></select></div>
        <div class="col-md-4"><label class="form-label">Nama Dokumen</label><input type="text" name="dokumen[${index}][nama]" class="form-control"></div>
        <div class="col-md-4"><label class="form-label">Nomor</label><input type="text" name="dokumen[${index}][nomor]" class="form-control"></div>
        <div class="col-md-4"><label class="form-label">Tautan</label><input type="url" name="dokumen[${index}][tautan]" class="form-control" placeholder="https://..."></div>
        <div class="col-12"><label class="form-label">File</label><input type="file" name="dokumen[${index}][file]" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.txt" required></div>
      </div>`;
    item.querySelector('input[type="file"]').addEventListener('change', (e) => {
        if (e.target.files[0] && e.target.files[0].size > 5 * 1024 * 1024) {
            alert('Ukuran file maksimal 5MB!');
            e.target.value = '';
        }
    });
    return item;
  }

  function initDokumenHandler(wrapperId, addBtnId) {
    const wrapper = document.getElementById(wrapperId);
    const addBtn = document.getElementById(addBtnId);
    if (!wrapper || !addBtn) return;
    addBtn.addEventListener('click', () => wrapper.appendChild(createDokumenItem(wrapper.children.length)));
    wrapper.addEventListener('click', (e) => e.target.classList.contains('removeDokumen') && e.target.closest('.dokumen-item')?.remove());
  }

  /**
   * ===================================================================
   * Filter form auto-submit
   * ===================================================================
   */
  const filterForm = document.getElementById('filterForm');
  if (filterForm) {
      let debounceTimeout;
      filterForm.querySelector('.search-input')?.addEventListener('input', () => {
          clearTimeout(debounceTimeout);
          debounceTimeout = setTimeout(() => filterForm.submit(), 500);
      });
      filterForm.querySelectorAll('.filter-select').forEach(sel => sel.addEventListener('change', () => filterForm.submit()));
  }

  /**
   * ===================================================================
   * jQuery (Select2 + Modal Reset)
   * ===================================================================
   */
  if (typeof $ !== 'undefined' && typeof $.fn.select2 !== 'undefined') {
    $(document).ready(function () {
      $('.select2-tambah').select2({ theme: 'bootstrap-5', placeholder: '-- Pilih --', dropdownParent: $('#pembicaraModal'), allowClear: true });
      $('.select2-edit').select2({ theme: 'bootstrap-5', placeholder: '-- Pilih --', dropdownParent: $('#editPembicaraModal'), allowClear: true });

      // Reset on close
      $('#pembicaraModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('.select2-tambah').val(null).trigger('change');
        $('#dokumenWrapper').html(createDokumenItem(0).innerHTML); // Reset to one item
      });
    });
  }

  /**
   * ===================================================================
   * Inisialisasi Akhir
   * ===================================================================
   */
  handleSuccessNotification();
  initDokumenHandler('dokumenWrapper', 'addDokumen');
  initDokumenHandler('editDokumenWrapper', 'addEditDokumen');
  
  // Spinner untuk form tambah
  const tambahForm = document.getElementById('pembicaraForm');
  tambahForm?.addEventListener('submit', function() {
    const btn = tambahForm.querySelector('button[type="submit"]');
    setButtonLoading(btn, true, 'Menyimpan...');
  });
});