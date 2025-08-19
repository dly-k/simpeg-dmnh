document.addEventListener('DOMContentLoaded', function () {
  // === LOGIKA MODAL BERHASIL (SUCCESS MODAL) ===
  const modalBerhasil = document.getElementById('modalBerhasil');
  const berhasilTitle = document.getElementById('berhasil-title');
  const berhasilSubtitle = document.getElementById('berhasil-subtitle');
  let successModalTimeout = null;
  // Tambahkan instance Audio untuk suara sukses
  const successSound = new Audio('/assets/sounds/success.mp3');

  function showSuccessModal(title, subtitle) {
    if (modalBerhasil && berhasilTitle && berhasilSubtitle) {
      berhasilTitle.textContent = title;
      berhasilSubtitle.textContent = subtitle;
      modalBerhasil.classList.add('show'); // Gunakan class untuk menampilkan
      
      // Putar suara sukses
      successSound.play().catch(error => {
        console.log('Gagal memutar suara sukses:', error);
      });

      clearTimeout(successModalTimeout);
      successModalTimeout = setTimeout(hideSuccessModal, 1200); // Durasi 1.2 detik
    }
  }
  
  function hideSuccessModal() {
    modalBerhasil?.classList.remove('show');
  }

  // Listener untuk tombol 'Selesai' di modal berhasil
  document.getElementById('btnSelesai')?.addEventListener('click', () => {
    clearTimeout(successModalTimeout);
    hideSuccessModal();
  });

  // === Sidebar Logic ===
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const toggleSidebarBtn = document.getElementById('toggleSidebar');

  if (toggleSidebarBtn && sidebar && overlay) {
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

  // === Date and Time Logic ===
  function updateDateTime() {
    const now = new Date();
    const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false, timeZone: 'Asia/Jakarta' };
    const dateEl = document.getElementById('current-date');
    const timeEl = document.getElementById('current-time');
    if (dateEl && timeEl) {
      dateEl.textContent = now.toLocaleDateString('id-ID', dateOptions);
      timeEl.textContent = now.toLocaleTimeString('id-ID', timeOptions);
    }
  }
  updateDateTime();
  setInterval(updateDateTime, 1000);
  
  // === [BARU] Tombol Simpan Logic ===
  const simpanBtn = document.querySelector('#penunjangModal .btn-success');
  if (simpanBtn) {
    simpanBtn.addEventListener('click', function() {
      closeModal('penunjangModal');
      showSuccessModal('Data Berhasil Disimpan', 'Data penunjang telah berhasil disimpan ke sistem.');
    });
  }

  // === Dynamic Interactions ===
  function setupDynamicInteractions() {
    const dokumenList = document.getElementById('dokumen-list');
    if (dokumenList) {
      dokumenList.addEventListener('click', function(event) {
        const removeBtn = event.target.closest('.btn-outline-danger');
        if (removeBtn) {
          removeBtn.closest('.border.rounded').remove();
          return;
        }
        
        const uploadArea = event.target.closest('.upload-area');
        if (uploadArea) {
          const fileInput = uploadArea.querySelector('input[type="file"]');
          if (fileInput) fileInput.click();
        }
      });

      dokumenList.addEventListener('change', function(event){
        if(event.target.matches('input[type="file"]')){
          const uploadArea = event.target.closest('.upload-area');
          const p = uploadArea.querySelector('p');
          if (event.target.files.length > 0) {
            p.innerHTML = `<small>${event.target.files[0].name}</small>`;
          }
        }
      });
    }

    const anggotaList = document.getElementById('anggota-list');
    if (anggotaList) {
      anggotaList.addEventListener('click', function(event) {
        const removeBtn = event.target.closest('.btn-outline-danger');
        if (removeBtn) {
          removeBtn.closest('.input-group').remove();
        }
      });
    }
  }
  setupDynamicInteractions();

  // === Detail Modal Logic ===
  const penunjangDetailModal = document.getElementById("penunjangDetailModal");
  const closePenunjangDetailBtn = document.getElementById("closePenunjangDetailBtn");

  document.addEventListener('click', function(event) {
    if (event.target.closest('#btnLihatPenunjangDetail')) {
      if (penunjangDetailModal) penunjangDetailModal.style.display = "block";
    }
  });

  if (closePenunjangDetailBtn) {
    closePenunjangDetailBtn.addEventListener('click', function() {
      if (penunjangDetailModal) penunjangDetailModal.style.display = "none";
    });
  }

  // === Verifikasi Confirmation Modal Logic ===
  const verifModal = document.getElementById('modalKonfirmasiVerifikasi');
  const btnTerima = document.getElementById('popupBtnTerima');
  const btnTolak = document.getElementById('popupBtnTolak');
  const btnKembali = document.getElementById('popupBtnKembali');
  
  // Debugging untuk memastikan modal ditemukan
  console.log('verifModal:', verifModal);
  console.log('btnTerima:', btnTerima);
  console.log('btnTolak:', btnTolak);
  console.log('btnKembali:', btnKembali);

  function hideVerifModal() {
    if (verifModal) {
      console.log('Menyembunyikan modal verifikasi');
      verifModal.classList.remove('show'); // Gunakan kelas show untuk menyembunyikan
    } else {
      console.log('Modal verifikasi tidak ditemukan saat mencoba menyembunyikan');
    }
  }

  document.addEventListener('click', function(event) {
    if (event.target.closest('.btn-verifikasi')) {
      console.log('Tombol verifikasi diklik!');
      event.preventDefault();
      if (verifModal) {
        console.log('Menampilkan modal verifikasi');
        verifModal.classList.add('show'); // Gunakan kelas show untuk menampilkan
        console.log('Style display saat ini:', verifModal.style.display);
        console.log('Computed style:', window.getComputedStyle(verifModal).display);
      } else {
        console.log('Modal verifikasi tidak ditemukan!');
      }
    }
  });
  
  if (verifModal) {
    verifModal.addEventListener('click', (e) => {
      if (e.target === verifModal) {
        console.log('Klik di luar modal, menyembunyikan');
        hideVerifModal();
      }
    });
  }
  
  if (btnTerima) {
    btnTerima.addEventListener('click', function() {
      console.log('Tombol Terima diklik');
      hideVerifModal();
      showSuccessModal('Status Verifikasi Disimpan', 'Perubahan status verifikasi telah berhasil disimpan.');
    });
  }
  
  if (btnTolak) {
    btnTolak.addEventListener('click', function() {
      console.log('Tombol Tolak diklik');
      hideVerifModal();
      showSuccessModal('Status Verifikasi Disimpan', 'Perubahan status verifikasi telah berhasil disimpan.');
    });
  }
  
  if (btnKembali) {
    btnKembali.addEventListener('click', function() {
      console.log('Tombol Kembali diklik');
      hideVerifModal();
    });
  }

  // === Delete Confirmation Modal Logic ===
  const deleteModal = document.getElementById('modalKonfirmasiHapus');
  const btnBatalHapus = document.getElementById('btnBatalHapus');
  const btnKonfirmasiHapus = document.getElementById('btnKonfirmasiHapus');
  let dataToDelete = null;

  function hideDeleteModal() {
    if(deleteModal) deleteModal.style.display = 'none';
  }

  document.addEventListener('click', function(event) {
    if (event.target.closest('.btn-hapus')) {
      event.preventDefault();
      const row = event.target.closest('tr');
      dataToDelete = {
        id: row.querySelector('td:first-child').textContent,
        title: row.querySelector('td:nth-child(2)').textContent
      };
      if (deleteModal) deleteModal.style.display = 'flex';
    }
  });

  if (deleteModal) {
    deleteModal.addEventListener('click', (e) => {
      if (e.target === deleteModal) hideDeleteModal();
    });
  }

  if (btnBatalHapus) {
    btnBatalHapus.addEventListener('click', hideDeleteModal);
  }

  if (btnKonfirmasiHapus) {
    btnKonfirmasiHapus.addEventListener('click', function() {
      if (dataToDelete) {
        console.log('Menghapus data:', dataToDelete);
      }
      hideDeleteModal();
      showSuccessModal('Data Berhasil Dihapus', 'Data yang dipilih telah berhasil dihapus secara permanen.');
    });
  }
});

// === Global Functions ===
function openModal(modalId) {
  const modal = document.getElementById(modalId);
  if (!modal) return;
  const modalTitle = modal.querySelector('#modalTitle');
  const form = modal.querySelector('form');
  if (modalTitle) {
    modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Penunjang';
  }
  if (form) form.reset();
  
  const dokumenList = document.getElementById('dokumen-list');
  const anggotaList = document.getElementById('anggota-list');
  if (dokumenList) dokumenList.innerHTML = '';
  if (anggotaList) anggotaList.innerHTML = '';

  modal.style.display = 'flex';
}

function openEditModal() {
  const modal = document.getElementById('penunjangModal');
  if (!modal) return;
  const modalTitle = modal.querySelector('#modalTitle');
  if (modalTitle) {
    modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Data Penunjang';
  }
  modal.style.display = 'flex';
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) modal.style.display = 'none';
}

function addDokumen() {
  const list = document.getElementById('dokumen-list');
  if (!list) return;

  const newRow = document.createElement('div');
  newRow.className = 'border rounded p-3 mb-3';
  newRow.innerHTML = `
    <div class="row g-2">
      <div class="col-12"><select class="form-select form-select-sm"><option selected>-- Pilih Jenis Dokumen --</option></select></div>
      <div class="col-md-4"><input type="text" class="form-control form-control-sm" placeholder="Nama Dokumen"></div>
      <div class="col-md-4"><input type="text" class="form-control form-control-sm" placeholder="Nomor"></div>
      <div class="col-md-4"><input type="text" class="form-control form-control-sm" placeholder="Tautan"></div>
      <div class="col-12">
        <div class="upload-area" style="padding: 1rem;">
          <i class="fas fa-cloud-upload-alt"></i>
          <p class="mb-0"><small>Drag & Drop File / Max 5 MB</small></p>
          <input type="file" hidden>
        </div>
      </div>
    </div>
    <button type="button" class="btn btn-sm btn-outline-danger mt-2">
      <i class="fa fa-trash"></i> Hapus Dokumen
    </button>
  `;
  list.appendChild(newRow);
}

function addAnggota() {
  const list = document.getElementById('anggota-list');
  if (!list) return;

  const newRow = document.createElement('div');
  newRow.className = 'input-group mb-2';
  newRow.innerHTML = `
    <input type="text" class="form-control" placeholder="Nama Dosen">
    <select class="form-select"><option selected>-- Pilih Salah Satu Peran --</option></select>
    <button class="btn btn-outline-danger" type="button">
      <i class="fa fa-trash"></i>
    </button>
  `;
  list.appendChild(newRow);
}

window.addEventListener('click', function (event) {
  if (event.target.classList.contains('modal-backdrop')) {
    closeModal(event.target.id);
  }
  
  const penunjangDetailModal = document.getElementById("penunjangDetailModal");
  if (event.target === penunjangDetailModal) {
    penunjangDetailModal.style.display = "none";
  }

  const deleteModal = document.getElementById("modalKonfirmasiHapus");
  if (event.target === deleteModal) {
    deleteModal.style.display = "none";
  }
});