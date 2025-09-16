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
      setTimeout(() => {
        if (isEditMode) {
          updateTableRow(result.data);
        } else {
          addTableRow(result.data);
        }
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

  // == FUNGSI UNTUK MEMPERBARUI & MENAMBAH BARIS TABEL ==
  const updateTableRow = (data) => {
    const row = document.querySelector(`.btn-edit[data-id="${data.id}"]`)?.closest('tr');
    if (!row) return;
    const tmtMulai = new Date(data.tmt_mulai).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
    const tmtSelesai = new Date(data.tmt_selesai).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
    row.cells[1].innerText = data.kegiatan;
    row.cells[2].innerText = data.lingkup;
    row.cells[3].innerText = data.nama_kegiatan;
    row.cells[4].innerText = data.instansi;
    row.cells[5].innerText = data.nomor_sk;
    row.cells[6].innerText = tmtMulai;
    row.cells[7].innerText = tmtSelesai;
  };
  const addTableRow = (data) => {
    const tableBody = document.getElementById('penunjang-table-body');
    if (!tableBody) return;
    const noDataRow = tableBody.querySelector('td[colspan="10"]');
    if (noDataRow) noDataRow.parentElement.remove();
    const allRows = tableBody.querySelectorAll('tr');
    allRows.forEach((row, index) => {
      row.cells[0].textContent = index + 2;
    });
    const tmtMulai = new Date(data.tmt_mulai).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
    const tmtSelesai = new Date(data.tmt_selesai).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
    const newRow = tableBody.insertRow(0);
    newRow.innerHTML = `
      <td class="text-center">1</td>
      <td class="text-start">${data.kegiatan}</td>
      <td class="text-center">${data.lingkup}</td>
      <td class="text-center">${data.nama_kegiatan}</td>
      <td class="text-center">${data.instansi}</td>
      <td class="text-center">${data.nomor_sk}</td>
      <td class="text-center">${tmtMulai}</td>
      <td class="text-center">${tmtSelesai}</td>
      <td class="text-center"><i class="fas fa-question-circle text-warning" title="Belum Diverifikasi"></i></td>
      <td class="text-center">
        <div class="d-flex gap-2 justify-content-center">
          <a href="#" class="btn-aksi btn-verifikasi" title="Verifikasi" data-id="${data.id}"><i class="fa fa-check"></i></a>
          <a href="#" class="btn-aksi btn-lihat" title="Lihat Detail" data-id="${data.id}" data-bs-toggle="modal" data-bs-target="#penunjangDetailModal"><i class="fa fa-eye"></i></a>
          <a href="#" class="btn-aksi btn-edit" title="Edit Data" data-id="${data.id}"><i class="fa fa-edit"></i></a>
          <a href="#" class="btn-aksi btn-hapus" title="Hapus Data" data-id="${data.id}"><i class="fa fa-trash"></i></a>
        </div>
      </td>
    `;
  };

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
    const updateUIVerification = (id, newStatus) => {
        const row = document.querySelector(`.btn-verifikasi[data-id="${id}"]`)?.closest('tr');
        if (!row) return;
        const statusCell = row.cells[8];
        let newIcon = '';
        if (newStatus === 'Sudah Diverifikasi') {
            newIcon = '<i class="fas fa-check-circle text-success" title="Sudah Diverifikasi"></i>';
        } else if (newStatus === 'Ditolak') {
            newIcon = '<i class="fas fa-times-circle text-danger" title="Ditolak"></i>';
        } else {
            newIcon = '<i class="fas fa-question-circle text-warning" title="Belum Diverifikasi"></i>';
        }
        statusCell.innerHTML = newIcon;
    };
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
        const originalBtnText = newStatus === 'Sudah Diverifikasi' ? btnTerima.innerHTML : btnTolak.innerHTML;
        const loadingSpinner = '<span class="spinner-border spinner-border-sm"></span> Memproses...';
        if (newStatus === 'Sudah Diverifikasi') {
          btnTerima.disabled = true;
          btnTerima.innerHTML = loadingSpinner;
        } else {
          btnTolak.disabled = true;
          btnTolak.innerHTML = loadingSpinner;
        }
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
                updateUIVerification(recordId, result.new_status);
            }, 1300);
        } catch (error) {
            console.error("Verification error:", error);
            alert(error.message);
        } finally {
            if (newStatus === 'Sudah Diverifikasi') {
              btnTerima.disabled = false;
              btnTerima.innerHTML = originalBtnText;
            } else {
              btnTolak.disabled = false;
              btnTolak.innerHTML = originalBtnText;
            }
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
      if (!recordIdToDelete) {
        console.error("Gagal menghapus: Tidak ada ID yang ditemukan di modal.");
        hideDeleteModal();
        return;
      }
      const tableRowToDelete = document.querySelector(`.btn-hapus[data-id="${recordIdToDelete}"]`)?.closest('tr');
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
          if (tableRowToDelete) {
              tableRowToDelete.remove();
          }
        }, 1300);
      } catch (error) {
        console.error("Delete error:", error);
        alert(error.message);
        hideDeleteModal();
      }
    });
    window.addEventListener("click", (event) => { if (event.target === deleteModal) hideDeleteModal(); });
  };
  
  // Inisialisasi semua fungsi modal di akhir script
  initVerificationModal();
  initDeleteModal();
});