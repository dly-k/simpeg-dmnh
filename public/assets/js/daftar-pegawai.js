document.addEventListener("DOMContentLoaded", () => {
  /**
   * Modul untuk menangani Modal Konfirmasi Hapus.
   */
  const initDeleteConfirmation = () => {
    const tableCard = document.querySelector(".table-card");
    const modalKonfirmasi = document.getElementById("modalKonfirmasiHapus");
    if (!tableCard || !modalKonfirmasi) return;

    const modalSubtitle = modalKonfirmasi.querySelector('.konfirmasi-hapus-subtitle');
    const btnKonfirmasi = document.getElementById("btnKonfirmasiHapus");
    const btnBatal = document.getElementById("btnBatalHapus");
    if (!modalSubtitle || !btnKonfirmasi || !btnBatal) return;

    let formToSubmit = null;

    const showModal = () => {
      modalKonfirmasi.style.display = 'flex';
      setTimeout(() => modalKonfirmasi.classList.add('show'), 10);
    };
    const hideModal = () => {
      modalKonfirmasi.classList.remove('show');
      setTimeout(() => { modalKonfirmasi.style.display = 'none'; }, 200);
      formToSubmit = null;
    };

    tableCard.addEventListener("submit", (event) => {
      const form = event.target.closest(".form-hapus");
      if (form) {
        event.preventDefault();
        formToSubmit = form;
        const namaPegawai = form.querySelector('button[type="submit"]').dataset.nama || 'data ini';
        modalSubtitle.innerHTML = `Data untuk <strong>${namaPegawai}</strong> akan dihapus permanen.`;
        showModal();
      }
    });

    btnKonfirmasi.addEventListener("click", () => {
      if (formToSubmit) formToSubmit.submit();
    });
    btnBatal.addEventListener("click", hideModal);
    modalKonfirmasi.addEventListener("click", (event) => {
      if (event.target === modalKonfirmasi) hideModal();
    });
  };

  /**
   * Logika untuk mengontrol tombol "Tambah Data".
   */
  const initTabAndButtonLogic = () => {
    const pegawaiTabContainer = document.getElementById('pegawaiTab');
    const btnTambah = document.getElementById('btn-tambah-pegawai');
    if (!pegawaiTabContainer || !btnTambah) return;

    const updateTambahButtonVisibility = () => {
      const activeTab = pegawaiTabContainer.querySelector('.nav-link.active');
      if (activeTab && activeTab.id === 'riwayat-pegawai-tab') {
        btnTambah.style.display = 'none';
      } else {
        btnTambah.style.display = 'inline-flex';
      }
    };

    pegawaiTabContainer.addEventListener('shown.bs.tab', () => {
      updateTambahButtonVisibility();
    });

    updateTambahButtonVisibility();
  };


  /**
   * Inisialisasi filter pencarian dan dropdown.
   */
  const initFilters = () => {
    const inputs = [
      document.querySelector('input[name="search_aktif"]'),
      document.querySelector('select[name="filter_kepegawaian_aktif"]'),
      document.querySelector('input[name="search_riwayat"]'),
      document.querySelector('select[name="filter_status_riwayat"]')
    ];
    let debounceTimeout;

    const submitForm = (form) => {
      const activeTabId = document.querySelector('.nav-pills .nav-link.active').id;
      let tabName = activeTabId.replace('-tab', '');
      
      let tabInput = form.querySelector('input[name="tab"]');
      if (!tabInput) {
        tabInput = document.createElement('input');
        tabInput.type = 'hidden';
        tabInput.name = 'tab';
        form.appendChild(tabInput);
      }
      tabInput.value = tabName;
      
      form.submit();
    };

    inputs.forEach(input => {
      if (input) {
        if (input.tagName.toLowerCase() === 'select') {
          input.addEventListener('change', () => {
            submitForm(input.closest('form'));
          });
        } else {
          input.addEventListener('keyup', () => {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => {
              submitForm(input.closest('form'));
            }, 500);
          });
        }
      }
    });
  };

  /**
   * Mengaktifkan tab yang benar saat halaman dimuat.
   */
  const setActiveTabFromUrl = () => {
    const params = new URLSearchParams(window.location.search);
    const tabName = params.get('tab');
    if (tabName) {
      const tabElement = document.getElementById(`${tabName}-tab`);
      if (tabElement) {
        const tab = new bootstrap.Tab(tabElement);
        tab.show();
      }
    }
  };

  /**
   * Memperbarui link ekspor agar dinamis.
   */
  const updateExportLinks = () => {
    const params = new URLSearchParams(window.location.search);

    // Update link untuk ekspor data aktif
    const exportAktifLink = document.querySelector('a[href*="export?type=aktif"]');
    if (exportAktifLink) {
        const newParams = new URLSearchParams({ type: 'aktif' });
        if (params.has('search_aktif') && params.get('search_aktif')) {
            newParams.set('search_aktif', params.get('search_aktif'));
        }
        if (params.has('filter_kepegawaian_aktif') && params.get('filter_kepegawaian_aktif')) {
            newParams.set('filter_kepegawaian_aktif', params.get('filter_kepegawaian_aktif'));
        }
        exportAktifLink.href = `${exportAktifLink.pathname}?${newParams.toString()}`;
    }

    // Update link untuk ekspor data riwayat
    const exportRiwayatLink = document.querySelector('a[href*="export?type=riwayat"]');
    if (exportRiwayatLink) {
        const newParams = new URLSearchParams({ type: 'riwayat' });
        if (params.has('search_riwayat') && params.get('search_riwayat')) {
            newParams.set('search_riwayat', params.get('search_riwayat'));
        }
        if (params.has('filter_status_riwayat') && params.get('filter_status_riwayat')) {
            newParams.set('filter_status_riwayat', params.get('filter_status_riwayat'));
        }
        exportRiwayatLink.href = `${exportRiwayatLink.pathname}?${newParams.toString()}`;
    }
  };


  // Panggil semua fungsi inisialisasi
  initDeleteConfirmation();
  initTabAndButtonLogic();
  initFilters();
  setActiveTabFromUrl();
  updateExportLinks(); 
});