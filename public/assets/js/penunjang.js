document.addEventListener("DOMContentLoaded", () => {
  // == Inisialisasi & Variabel Global ==
  let penunjangModalInstance;
  const penunjangModalEl = document.getElementById("penunjangModal");
  if (penunjangModalEl) {
    penunjangModalInstance = new bootstrap.Modal(penunjangModalEl);
  }
  const form = document.getElementById('penunjangForm');
  const simpanBtn = document.getElementById('simpanPenunjangBtn');
  const modalTitle = document.getElementById("penunjangModalLabel");
  const formMethodInput = document.getElementById('form-method');
  const formEditIdInput = document.getElementById('form-edit-id');
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
  
  const searchInput = document.querySelector('.search-input');
  const filterSemester = document.getElementById('filter-semester');
  const filterLingkup = document.getElementById('filter-lingkup');
  const filterStatus = document.getElementById('filter-status');
  const tableBody = document.getElementById('penunjang-table-body');
  const mainTable = document.querySelector('table[data-user-role]');
  const paginationContainer = document.getElementById('pagination-container');
  
  // Ambil user role dari data attribute
  const userRole = mainTable.dataset.userRole;

  // == FUNGSI UNTUK MERENDER KONTEN ==
  const renderTable = (data, startingNumber) => {
    tableBody.innerHTML = '';
    if (!data || data.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="10" class="text-center">Data tidak ditemukan.</td></tr>';
        return;
    }

    data.forEach((item, index) => {
        const tmtMulai = new Date(item.tmt_mulai).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
        const tmtSelesai = new Date(item.tmt_selesai).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
        
        let statusIcon = '<i class="fas fa-question-circle text-warning" title="Belum Diverifikasi"></i>';
        if(item.status === 'Sudah Diverifikasi') {
            statusIcon = '<i class="fas fa-check-circle text-success" title="Sudah Diverifikasi"></i>';
        } else if (item.status === 'Ditolak') {
            statusIcon = '<i class="fas fa-times-circle text-danger" title="Ditolak"></i>';
        }
        
        let verifikasiButton = '';
        if (userRole === 'admin_verifikator') {
            verifikasiButton = `<a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi" data-id="${item.id}"><i class="fa fa-check"></i></a>`;
        }

        const row = `
            <tr>
                <td class="text-center">${startingNumber + index}</td>
                <td class="text-start">${item.kegiatan}</td>
                <td class="text-center">${item.lingkup}</td>
                <td class="text-center">${item.nama_kegiatan}</td>
                <td class="text-center">${item.instansi}</td>
                <td class="text-center">${item.nomor_sk}</td>
                <td class="text-center">${tmtMulai}</td>
                <td class="text-center">${tmtSelesai}</td>
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
        tableBody.innerHTML += row;
    });
  };

const renderPagination = (html) => {
    // Cari dulu container yang ada
    let container = document.getElementById('pagination-container');

    // Cek apakah ada HTML pagination yang dikirim dari server
    if (html && html.trim() !== '') {
      // Jika container belum ada, buat baru
      if (!container) {
        container = document.createElement('div');
        container.id = 'pagination-container';
        container.className = 'mt-3 d-flex justify-content-center';
        // Tambahkan setelah div table-responsive
        document.querySelector('.table-responsive').after(container);
      }
      container.innerHTML = html;
    } else {
      // Jika tidak ada HTML pagination, dan containernya ada, hapus
      if (container) {
        container.remove();
      }
    }
  };
  
  // == FUNGSI PENGAMBIL DATA UTAMA ==
  const fetchData = async (url) => {
    try {
        tableBody.innerHTML = '<tr><td colspan="10" class="text-center"><div class="spinner-border spinner-border-sm"></div> Memuat...</td></tr>';
        
        const response = await fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });
        if (!response.ok) throw new Error('Network response was not ok');
        
        const result = await response.json();
        
        renderTable(result.data, result.from);
        renderPagination(result.pagination_html); 
    } catch (error) {
        console.error('Fetch error:', error);
        tableBody.innerHTML = '<tr><td colspan="10" class="text-center text-danger">Gagal memuat data.</td></tr>';
    }
  };

  const performFilterAndSearch = () => {
    const params = new URLSearchParams({
        search: searchInput?.value || '',
        semester: filterSemester?.value || '',
        lingkup: filterLingkup?.value || '',
        status: filterStatus?.value || '',
    });
    const newUrl = `/penunjang?${params.toString()}`;
    history.pushState(null, '', newUrl);
    fetchData(newUrl);
  };

  const debounce = (func, delay) => {
    let timeout;
    return (...args) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), delay);
    };
  };

  // == EVENT LISTENERS ==
  searchInput?.addEventListener('keyup', debounce(performFilterAndSearch, 500));
  filterSemester?.addEventListener('change', performFilterAndSearch);
  filterLingkup?.addEventListener('change', performFilterAndSearch);
  filterStatus?.addEventListener('change', performFilterAndSearch);

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
  
  // == Modal Berhasil ==
  const modalBerhasil = document.getElementById("modalBerhasil");
  const berhasilTitle = document.getElementById("berhasil-title");
  const berhasilSubtitle = document.getElementById("berhasil-subtitle");
  let successModalTimeout = null;
  const successSound = new Audio("/assets/sounds/success.mp3");

  const showSuccessModal = (title, subtitle) => {
    if (!modalBerhasil || !berhasilTitle || !berhasilSubtitle) return;
    berhasilTitle.textContent = title;
    berhasilSubtitle.textContent = subtitle;
    modalBerhasil.classList.add("show");
    document.body.style.overflow = "hidden";
    successSound.play().catch((error) => console.warn("Gagal memutar audio sukses:", error));
    clearTimeout(successModalTimeout);
    successModalTimeout = setTimeout(hideSuccessModal, 1200);
  };

  const hideSuccessModal = () => {
    if (modalBerhasil) {
      modalBerhasil.classList.remove("show");
      if (!document.querySelector(".modal.show")) {
        document.body.style.overflow = "";
      }
    }
  };

  document.getElementById("btnSelesai")?.addEventListener("click", () => {
    clearTimeout(successModalTimeout);
    hideSuccessModal();
  });

  // == FUNGSI UNTUK MENGISI FORM EDIT ==
  const populateEditForm = (data) => {
    form.querySelector('[name="kegiatan"]').value = data.kegiatan;
    form.querySelector('[name="jenis_kegiatan"]').value = data.jenis_kegiatan;
    form.querySelector('[name="lingkup"]').value = data.lingkup;
    form.querySelector('[name="nama_kegiatan"]').value = data.nama_kegiatan;
    form.querySelector('[name="instansi"]').value = data.instansi;
    form.querySelector('[name="nomor_sk"]').value = data.nomor_sk;
    form.querySelector('[name="tmt_mulai"]').value = data.tmt_mulai;
    form.querySelector('[name="tmt_selesai"]').value = data.tmt_selesai;
    const anggotaList = document.getElementById('anggota-list');
    anggotaList.innerHTML = '';
    anggotaCounter = 0;
    if (data.anggota && data.anggota.length > 0) {
      data.anggota.forEach(item => {
        addAnggota(item.pegawai_id, item.peran);
      });
    }
    const dokumenList = document.getElementById('dokumen-list');
    dokumenList.innerHTML = '';
    dokCounter = 0;
    if (data.dokumen && data.dokumen.length > 0) {
      dokumenList.innerHTML = '<p class="text-muted small">Untuk mengubah dokumen, upload file baru. Jika tidak, bagian dokumen tidak akan diperbarui.</p>'
      data.dokumen.forEach(item => {
        const fileUrl = `/storage/${item.file_path.replace('public/', '')}`;
        dokumenList.innerHTML += `
        <div class="alert alert-secondary p-2 small">
          Dokumen tersimpan: <a href="${fileUrl}" target="_blank">${item.nama_dokumen}</a>
        </div>
        `;
      });
    }
  };

  // == EVENT LISTENER UNTUK TOMBOL TAMBAH & EDIT ==
  document.body.addEventListener('click', async (event) => {
    const editButton = event.target.closest('.btn-edit');
    if (editButton) {
      event.preventDefault();
      const id = editButton.getAttribute('data-id');
      modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Penunjang';
      formMethodInput.value = 'PATCH';
      formEditIdInput.value = id;
      try {
        const response = await fetch(`/penunjang/${id}`);
        if (!response.ok) throw new Error('Data not found');
        const data = await response.json();
        populateEditForm(data);
        penunjangModalInstance.show();
      } catch (error) {
        console.error('Failed to fetch data for edit:', error);
        alert('Gagal memuat data untuk diedit.');
      }
    }
  });

  const btnTambah = document.querySelector('[data-bs-target="#penunjangModal"]');
  btnTambah?.addEventListener('click', () => {
    modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Penunjang';
  });

  // == PROSES SUBMIT FORM (TAMBAH & EDIT) ==
  simpanBtn?.addEventListener('click', async () => {
    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }
    const formData = new FormData(form);
    const isEditMode = formMethodInput.value === 'PATCH';
    const id = formEditIdInput.value;
    const url = isEditMode ? `/penunjang/${id}` : '/penunjang';
    simpanBtn.disabled = true;
    simpanBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menyimpan...';
    try {
      const response = await fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json',
        },
      });
      const result = await response.json();
      if (!response.ok) throw result;
      penunjangModalInstance.hide();
      const successMessage = isEditMode ? 'Data Berhasil Diperbarui' : 'Data Berhasil Disimpan';
      showSuccessModal(successMessage, result.success);

      if (result.semesterOptions) {
          updateSemesterDropdown(result.semesterOptions);
      }
      
      setTimeout(() => {
        performFilterAndSearch();
      }, 1300);
    } catch (error) {
      console.error('Submission error:', error);
      if (error.errors) {
        alert('Data tidak valid. Periksa kembali isian Anda.');
      } else {
        alert('Terjadi kesalahan: ' + (error.error || 'Gagal menyimpan data'));
      }
    } finally {
      simpanBtn.disabled = false;
      simpanBtn.innerHTML = 'Simpan';
    }
  });

  // == RESET MODAL KETIKA DITUTUP ==
  penunjangModalEl?.addEventListener('hidden.bs.modal', () => {
    form.reset();
    document.getElementById('dokumen-list').innerHTML = '';
    document.getElementById('anggota-list').innerHTML = '';
    dokCounter = 0;
    anggotaCounter = 0;
    modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Penunjang';
    formMethodInput.value = 'POST';
    formEditIdInput.value = '';
  });

  // == DYNAMIC FORM FIELD FUNCTIONS ==
  let dokCounter = 0;
  window.addDokumen = () => {
    const list = document.getElementById("dokumen-list");
    if (!list) return;
    const newRow = document.createElement("div");
    newRow.className = "border rounded p-3 mb-3 dynamic-item";
    newRow.innerHTML = `
      <div class="row g-2">
        <div class="col-12"><select class="form-select form-select-sm" name="dokumen[${dokCounter}][jenis]" required><option selected disabled value="">-- Pilih Jenis Dokumen --</option><option>Transkip</option><option>Surat Tugas</option><option>SK</option><option>Sertifikat</option><option>Penyetaraan Ijazah</option><option>Laporan Kegiatan</option><option>Ijazah</option><option>Buku/Bahan Ajar</option></select></div>
        <div class="col-md-4"><input type="text" class="form-control form-control-sm" name="dokumen[${dokCounter}][nama]" placeholder="Nama Dokumen" required></div>
        <div class="col-md-4"><input type="text" class="form-control form-control-sm" name="dokumen[${dokCounter}][nomor]" placeholder="Nomor"></div>
        <div class="col-md-4"><input type="text" class="form-control form-control-sm" name="dokumen[${dokCounter}][tautan]" placeholder="Tautan"></div>
        <div class="col-12"><input type="file" class="form-control form-control-sm" name="dokumen[${dokCounter}][file]" required></div>
      </div>
      <button type="button" class="btn btn-sm btn-outline-danger mt-2 remove-item-btn"><i class="fa fa-trash"></i> Hapus Dokumen</button>
    `;
    list.appendChild(newRow);
    dokCounter++;
  };
  let anggotaCounter = 0;
  window.addAnggota = (selectedPegawaiId = '', peranValue = '') => {
    const list = document.getElementById("anggota-list");
    if (!list || typeof pegawaiData === 'undefined') return;
    const newRow = document.createElement("div");
    newRow.className = "input-group mb-2 dynamic-item";
    let pegawaiOptions = '<option selected disabled value="">-- Pilih Dosen --</option>';
    pegawaiData.forEach(p => {
      const isSelected = p.id == selectedPegawaiId ? 'selected' : '';
      pegawaiOptions += `<option value="${p.id}" ${isSelected}>${p.nama_lengkap}</option>`;
    });
    newRow.innerHTML = `
      <select class="form-select" name="anggota[${anggotaCounter}][pegawai_id]" required>${pegawaiOptions}</select>
      <input type="text" class="form-control" name="anggota[${anggotaCounter}][peran]" placeholder="Masukkan Peran" value="${peranValue}" required>
      <button class="btn btn-outline-danger remove-item-btn" type="button"><i class="fa fa-trash"></i></button>
    `;
    list.appendChild(newRow);
    anggotaCounter++;
  };
  document.body.addEventListener('click', function(event) {
    const removeBtn = event.target.closest('.remove-item-btn');
    if (removeBtn) {
      removeBtn.closest('.dynamic-item').remove();
    }
  });

  // == DETAIL MODAL LOGIC ==
  const detailModalEl = document.getElementById('penunjangDetailModal');
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
  const populateDetailModal = (data) => {
    const formatDate = (dateString) => new Date(dateString).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    detailFields.kegiatan.textContent = data.kegiatan || '-';
    detailFields.jenis_kegiatan.textContent = data.jenis_kegiatan || '-';
    detailFields.lingkup.textContent = data.lingkup || '-';
    detailFields.nama_kegiatan.textContent = data.nama_kegiatan || '-';
    detailFields.instansi.textContent = data.instansi || '-';
    detailFields.nomor_sk.textContent = data.nomor_sk || '-';
    detailFields.tmt_mulai.textContent = data.tmt_mulai ? formatDate(data.tmt_mulai) : '-';
    detailFields.tmt_selesai.textContent = data.tmt_selesai ? formatDate(data.tmt_selesai) : '-';
    detailFields.anggotaList.innerHTML = '';
    if (data.anggota && data.anggota.length > 0) {
      data.anggota.forEach(item => {
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
    if (data.dokumen && data.dokumen.length > 0) {
      const dokumenGrid = document.createElement('div');
      dokumenGrid.className = 'detail-grid-container nested';
      data.dokumen.forEach(item => {
        const fileUrl = `/storage/${item.file_path.replace('public/', '')}`;
        dokumenGrid.innerHTML += `
          <div class="detail-item"><small>Jenis Dokumen</small><p>${item.jenis_dokumen || '-'}</p></div>
          <div class="detail-item"><small>Nama Dokumen</small><p>${item.nama_dokumen || '-'}</p></div>
          <div class="detail-item"><small>Nomor</small><p>${item.nomor_dokumen || '-'}</p></div>
          <div class="detail-item"><small>Tautan</small><p>${item.tautan ? `<a href="${item.tautan}" target="_blank" rel="noopener noreferrer">${item.tautan}</a>` : '-'}</p></div>
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
  detailModalEl?.addEventListener('show.bs.modal', async (event) => {
    const button = event.relatedTarget;
    if (!button || !button.classList.contains('btn-lihat')) return;
    Object.values(detailFields).forEach(field => {
        if (field) field.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>';
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

  // == MODAL KONFIRMASI (Verifikasi & Hapus) ==
  const initVerificationModal = () => {
    const verifModal = document.getElementById("modalKonfirmasiVerifikasi");
    if (!verifModal) return;
    const btnTerima = document.getElementById("popupBtnTerima");
    const btnTolak = document.getElementById("popupBtnTolak");
    const hideVerifModal = () => {
        verifModal.classList.remove("show");
        verifModal.removeAttribute('data-record-id');
    };
    document.body.addEventListener("click", (event) => {
      const btnVerifikasi = event.target.closest(".btn-verifikasi");
      if (btnVerifikasi) {
        event.preventDefault();
        const recordId = btnVerifikasi.getAttribute("data-id");
        verifModal.setAttribute('data-record-id', recordId);
        verifModal.classList.add("show");
      }
    });
    const handleVerification = async (newStatus) => {
        const recordId = verifModal.getAttribute('data-record-id');
        if (!recordId) return;
        let currentBtn;
        let originalBtnText;
        if (newStatus === 'Sudah Diverifikasi') {
          currentBtn = btnTerima;
        } else {
          currentBtn = btnTolak;
        }
        originalBtnText = currentBtn.innerHTML;
        currentBtn.disabled = true;
        currentBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Memproses...';
        try {
            const response = await fetch(`/penunjang/${recordId}/verifikasi`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ status: newStatus }),
            });
            const result = await response.json();
            if (!response.ok) throw new Error(result.error || 'Gagal memproses verifikasi.');
            hideVerifModal();
            showSuccessModal("Status Verifikasi Disimpan", result.success);
            setTimeout(() => {
                performFilterAndSearch();
            }, 1300);
        } catch (error) {
            console.error("Verification error:", error);
            alert(error.message);
        } finally {
            currentBtn.disabled = false;
            currentBtn.innerHTML = originalBtnText;
        }
    };
    btnTerima?.addEventListener("click", () => handleVerification('Sudah Diverifikasi'));
    btnTolak?.addEventListener("click", () => handleVerification('Ditolak'));
    document.getElementById("popupBtnKembali")?.addEventListener("click", hideVerifModal);
    verifModal.addEventListener("click", (e) => { if (e.target === verifModal) hideVerifModal(); });
  };

  const initDeleteModal = () => {
    const deleteModal = document.getElementById("modalKonfirmasiHapus");
    if (!deleteModal) return;
    const confirmButton = document.getElementById("btnKonfirmasiHapus");
    const hideDeleteModal = () => {
      confirmButton.disabled = false;
      confirmButton.innerHTML = 'Ya, Hapus';
      deleteModal.classList.remove("show");
      if (!document.querySelector(".modal.show")) document.body.style.overflow = "";
      deleteModal.removeAttribute('data-record-id'); 
    };
    document.body.addEventListener("click", (event) => {
      const btnHapus = event.target.closest(".btn-hapus");
      if (btnHapus) {
        event.preventDefault();
        const recordId = btnHapus.getAttribute("data-id");
        deleteModal.setAttribute('data-record-id', recordId);
        deleteModal.classList.add("show");
        document.body.style.overflow = "hidden";
      }
    });
    document.getElementById("btnBatalHapus")?.addEventListener("click", hideDeleteModal);
    confirmButton?.addEventListener("click", async () => {
      const recordIdToDelete = deleteModal.getAttribute('data-record-id');
      if (!recordIdToDelete) return;
      confirmButton.disabled = true;
      confirmButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menghapus...';
      try {
        const response = await fetch(`/penunjang/${recordIdToDelete}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
          },
        });
        const result = await response.json();
        if (!response.ok) throw new Error(result.error || 'Gagal menghapus data.');
        hideDeleteModal();
        showSuccessModal("Data Berhasil Dihapus", result.success);
        setTimeout(() => {
          performFilterAndSearch();
        }, 1300);
      } catch (error) {
        console.error("Delete error:", error);
        alert(error.message);
        hideDeleteModal();
      }
    });
    window.addEventListener("click", (event) => { if (event.target === deleteModal) hideDeleteModal(); });
  };

      // == Peningkatan Datepicker ==
    document.querySelectorAll('input[type="date"]').forEach((el) => {
      el.style.cursor = "pointer";
      el.addEventListener("click", function () {
        this.showPicker && this.showPicker();
      });
    });

    const table = document.getElementById("penunjang-table");
    let pegawaiData = [];

    if (table) {
        try {
            pegawaiData = JSON.parse(table.dataset.pegawai);
        } catch (err) {
            console.error("Gagal parsing pegawaiData:", err);
        }
    }

    console.log("Pegawai dari table:", pegawaiData);

  
  // Inisialisasi semua fungsi modal di akhir script
  initVerificationModal();
  initDeleteModal();
});