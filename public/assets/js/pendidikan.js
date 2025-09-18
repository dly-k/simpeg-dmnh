document.addEventListener("DOMContentLoaded", () => {
  // == FUNGSI UNTUK MENGINGAT TAB AKTIF ==
  const tabs = document.querySelectorAll('#pendidikanTab .nav-link');
  const activeTabTarget = localStorage.getItem('activePendidikanTab');
  
  if (activeTabTarget) {
    const tabElement = document.querySelector(`#pendidikanTab button[data-bs-target="${activeTabTarget}"]`);
    if (tabElement) {
      new bootstrap.Tab(tabElement).show();
    }
    localStorage.removeItem('activePendidikanTab');
  }

  tabs.forEach(tab => {
    tab.addEventListener('shown.bs.tab', event => {
      localStorage.setItem('activePendidikanTab', event.target.getAttribute('data-bs-target'));
    });
  });

  // == FUNGSI BANTUAN MODAL (MENGGUNAKAN API BOOTSTRAP YANG BENAR) ==
  const getModalInstance = (modalId) => {
    const modalElement = document.getElementById(modalId);
    return modalElement ? bootstrap.Modal.getOrCreateInstance(modalElement) : null;
  };

  const showSuccessModal = (title, subtitle) => {
    const berhasilTitle = document.getElementById("berhasil-title");
    const berhasilSubtitle = document.getElementById("berhasil-subtitle");
    if (berhasilTitle) berhasilTitle.textContent = title;
    if (berhasilSubtitle) berhasilSubtitle.textContent = subtitle;

    const successModal = getModalInstance("modalBerhasil");
    if (successModal) {
      successModal.show();
      setTimeout(() => {
        successModal.hide();
      }, 1500); // Modal sukses akan hilang setelah 1.5 detik
    }
  };
  
  // == KONFIGURASI FORM ==
  const formConfigs = [
    { modalId: "modalTambahEditPengajaranLama", formId: "formPengajaranLama", btnId: "btnSimpanPengajaran", postUrl: "/pendidikan/pengajaran-lama" },
    { modalId: "modalPengajaranLuar", formId: "formPengajaranLuar", btnId: "btnSimpanPengajaranLuar", postUrl: "/pendidikan/pengajaran-luar" },
    { modalId: "modalPengujianLama", formId: "formPengujianLama", btnId: "btnSimpanPengujianLama", postUrl: "/pendidikan/pengujian-lama" },
    { modalId: "modalPembimbingLama", formId: "formPembimbingLama", btnId: "btnSimpanPembimbingLama", postUrl: "/pendidikan/pembimbing-lama" },
    { modalId: "modalPengujiLuar", formId: "formPengujiLuar", btnId: "btnSimpanPengujiLuar", postUrl: "/pendidikan/penguji-luar" },
    { modalId: "modalPembimbingLuar", formId: "formPembimbingLuar", btnId: "btnSimpanPembimbingLuar", postUrl: "/pendidikan/pembimbing-luar" },
  ];

  // == FUNGSI SUBMIT FORM DENGAN AJAX ==
  const handleFormSubmit = async (config) => {
      const form = document.getElementById(config.formId);
      const saveButton = document.getElementById(config.btnId);
      if (!form || !saveButton) return;

      const formData = new FormData(form);
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      const originalButtonText = saveButton.innerHTML;
      
      saveButton.disabled = true;
      saveButton.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Menyimpan...`;

      try {
          const response = await fetch(config.postUrl, {
              method: 'POST',
              headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
              body: formData,
          });
          const data = await response.json();

          if (!response.ok) {
              if (response.status === 422 && data.errors) {
                  let errorMessages = "Periksa kembali isian Anda:\n";
                  Object.values(data.errors).forEach(errs => errorMessages += `- ${errs.join('\n- ')}\n`);
                  alert(errorMessages);
              } else {
                  throw new Error(data.message || 'Terjadi kesalahan pada server.');
              }
          } else {
              const formModal = getModalInstance(config.modalId);
              if (formModal) {
                formModal.hide();
                // Tunggu modal form tertutup, baru tampilkan notifikasi sukses
                document.getElementById(config.modalId).addEventListener('hidden.bs.modal', () => {
                    showSuccessModal("Data Berhasil Disimpan", data.success);
                    // Siapkan untuk refresh halaman
                    const activeTabTarget = document.querySelector('#pendidikanTab .nav-link.active').getAttribute('data-bs-target');
                    localStorage.setItem('activePendidikanTab', activeTabTarget);
                    setTimeout(() => { location.reload(); }, 1600);
                }, { once: true });
              }
          }
      } catch (error) {
          console.error('Submit Error:', error);
          alert('Gagal menyimpan data. Pastikan semua isian valid dan coba lagi.');
      } finally {
          saveButton.disabled = false;
          saveButton.innerHTML = originalButtonText;
      }
  };

  // Inisialisasi event listener untuk semua tombol simpan
  formConfigs.forEach((config) => {
    const saveButton = document.getElementById(config.btnId);
    saveButton?.addEventListener("click", () => handleFormSubmit(config));
  });

  // == SCRIPT UNTUK PENANDA FILE INPUT ==
  document.querySelectorAll('.file-input').forEach(inputElement => {
    inputElement.addEventListener('change', function() {
      const fileDropArea = this.closest('.file-drop-area');
      const fileMessage = fileDropArea.querySelector('.file-message');
      if (this.files.length > 0) {
        fileMessage.textContent = this.files[0].name;
        fileDropArea.classList.add('file-selected');
      } else {
        fileMessage.textContent = 'Drag & Drop File here';
        fileDropArea.classList.remove('file-selected');
      }
    });
  });
});