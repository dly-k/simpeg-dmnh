document.addEventListener('DOMContentLoaded', function () {
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

  // === Dynamic Interactions ===
  function setupDynamicInteractions() {
    // Dokumen List
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

    // Anggota List
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
      if (penunjangDetailModal) {
        penunjangDetailModal.style.display = "block";
      }
    }
  });

  if (closePenunjangDetailBtn && penunjangDetailModal) {
    closePenunjangDetailBtn.addEventListener('click', function() {
      penunjangDetailModal.style.display = "none";
    });
  }

  // === Verifikasi Confirmation Modal Logic ===
  const verifModal = document.getElementById('modalKonfirmasiPenunjang');
  const btnTerima = document.getElementById('popupBtnTerima');
  const btnTolak = document.getElementById('popupBtnTolak');
  const btnKembali = document.getElementById('popupBtnKembali');
  
  document.addEventListener('click', function(event) {
    if (event.target.closest('.btn-verifikasi')) {
      event.preventDefault();
      if (verifModal) verifModal.style.display = 'flex';
    }
  });
  
  if (verifModal) {
    verifModal.addEventListener('click', function(e) {
      if (e.target === verifModal) {
        verifModal.style.display = 'none';
      }
    });
  }
  
  if (btnTerima) {
    btnTerima.addEventListener('click', function() {
      alert('Data telah diverifikasi (Diterima)');
      if (verifModal) verifModal.style.display = 'none';
    });
  }
  
  if (btnTolak) {
    btnTolak.addEventListener('click', function() {
      alert('Data telah ditolak');
      if (verifModal) verifModal.style.display = 'none';
    });
  }
  
  if (btnKembali) {
    btnKembali.addEventListener('click', function() {
      if (verifModal) verifModal.style.display = 'none';
    });
  }

  // === Delete Confirmation Modal Logic ===
  const deleteModal = document.getElementById('modalKonfirmasiHapus');
  const btnBatalHapus = document.getElementById('btnBatalHapus');
  const btnKonfirmasiHapus = document.getElementById('btnKonfirmasiHapus');
  let dataToDelete = null;

  document.addEventListener('click', function(event) {
    if (event.target.closest('.btn-hapus')) {
      event.preventDefault();
      // Get the row data to be deleted
      const row = event.target.closest('tr');
      dataToDelete = {
        id: row.querySelector('td:first-child').textContent,
        title: row.querySelector('td:nth-child(2)').textContent
      };
      if (deleteModal) deleteModal.style.display = 'flex';
    }
  });

  if (deleteModal) {
    deleteModal.addEventListener('click', function(e) {
      if (e.target === deleteModal) {
        deleteModal.style.display = 'none';
      }
    });
  }

  if (btnBatalHapus) {
    btnBatalHapus.addEventListener('click', function() {
      if (deleteModal) deleteModal.style.display = 'none';
    });
  }

  if (btnKonfirmasiHapus) {
    btnKonfirmasiHapus.addEventListener('click', function() {
      if (dataToDelete) {
        // Here you would typically make an AJAX call to delete the data
        console.log('Deleting data:', dataToDelete);
        alert(`Data "${dataToDelete.title}" (ID: ${dataToDelete.id}) berhasil dihapus`);
        
        // Example AJAX call:
        /* 
        fetch(`/api/penunjang/${dataToDelete.id}`, {
          method: 'DELETE'
        })
        .then(response => {
          if(response.ok) {
            location.reload();
          } else {
            alert('Gagal menghapus data');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Terjadi kesalahan saat menghapus data');
        });
        */
      }
      if (deleteModal) deleteModal.style.display = 'none';
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