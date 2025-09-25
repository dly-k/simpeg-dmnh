document.addEventListener("DOMContentLoaded", () => {
  /**
   * Menginisialisasi semua navigasi tab (utama dan sub-tab).
   */
  const initTabs = () => {
    document.getElementById("main-tab-nav")?.addEventListener("click", (e) => {
      const tabButton = e.target.closest("button.nav-link");
      if (!tabButton) return;
      
      document.querySelectorAll("#main-tab-nav .nav-link").forEach(t => t.classList.remove("active"));
      document.querySelectorAll(".main-tab-content").forEach(c => c.style.display = "none");
      
      tabButton.classList.add("active");
      const contentId = `${tabButton.dataset.mainTab}-content`;
      const contentElement = document.getElementById(contentId);
      if (contentElement) contentElement.style.display = "block";
    });

    document.querySelector(".main-content").addEventListener('click', function(e) {
        const subTabButton = e.target.closest('.sub-tab-nav button');
        if (!subTabButton) return;
        const subTabNav = subTabButton.closest('.sub-tab-nav');
        const parentContent = subTabButton.closest('.main-tab-content');
        if (!subTabNav || !parentContent) return;
        subTabNav.querySelectorAll('button').forEach(btn => btn.classList.remove('active'));
        parentContent.querySelectorAll('.sub-tab-content').forEach(c => c.style.display = 'none');
        subTabButton.classList.add('active');
        const contentId = subTabButton.dataset.tab;
        const contentElement = parentContent.querySelector(`#${contentId}`);
        if (contentElement) contentElement.style.display = 'block';
    });
  };

  /**
   * Menginisialisasi Modal Konfirmasi Hapus untuk semua form hapus.
   */
  const initDeleteConfirmation = () => {
    const modalElement = document.getElementById("modalKonfirmasiHapus");
    if (!modalElement) return;

    const btnConfirm = document.getElementById("btnKonfirmasiHapus");
    const btnCancel = document.getElementById("btnBatalHapus");
    let formToSubmit = null;

    const showModal = () => {
        modalElement.style.display = "flex";
        setTimeout(() => modalElement.classList.add('show'), 10);
    };

    const hideModal = () => {
        modalElement.classList.remove('show');
        setTimeout(() => modalElement.style.display = 'none', 200);
    };

    document.body.addEventListener('submit', function(e) {
      if (e.target.matches('.form-hapus-efile, .form-hapus-sk')) {
        e.preventDefault(); 
        formToSubmit = e.target;
        showModal();
      }
    });

    btnConfirm?.addEventListener('click', function() {
      if (formToSubmit) {
        formToSubmit.submit();
      }
    });
    
    btnCancel?.addEventListener('click', hideModal);
    modalElement.addEventListener('click', (event) => {
        if (event.target === modalElement) {
            hideModal();
        }
    });
  };

  /**
   * Menginisialisasi dropdown Kategori -> Jenis Dokumen di dalam modal tambah E-File.
   */
  const initKategoriMapping = () => {
    // ... (Kode tidak berubah, sudah benar)
  };
  
  /**
   * Menangani klik pada item file (E-File) untuk membuka file di tab baru.
   */
  const initFileItemClick = () => {
      // ... (Kode tidak berubah, sudah benar)
  };

  /**
   * Mengaktifkan tab dan sub-tab berdasarkan parameter di URL (untuk filter).
   */
  const restoreTabsFromUrl = () => {
    // ... (Kode tidak berubah, sudah benar)
  };

  /**
   * Menangani kemunculan modal sukses, musik, dan navigasi tab setelah form disubmit.
   */
  const handleSuccessFlow = () => {
    // ... (Kode tidak berubah, sudah benar)
  };

  /**
   * Menginisialisasi dan mengelola semua modal form (Tambah & Edit).
   */
  const initFormModals = () => {
    // ... (Kode tidak berubah, sudah benar)
  };
  
  /**
   * Pencarian otomatis saat mengetik atau menekan Enter.
   */
  const initAutoSearch = () => {
    // ... (Kode tidak berubah, sudah benar)
  };
  
  /**
   * PERBAIKAN DI SINI: Menangani klik tombol "Lihat Detail" untuk semua data Pendidikan.
   */
const initPendidikanDetailModals = () => {
    document.body.addEventListener('click', function(e) {
      const detailButton = e.target.closest('.btn-lihat-detail');
      if (!detailButton) return;
      
      e.preventDefault();
      
      const itemId = detailButton.dataset.id;
      const typeClass = Array.from(detailButton.classList).find(c => c.startsWith('btn-lihat-') && c !== 'btn-lihat-detail');
      if (!typeClass) return;
      const type = typeClass.replace('btn-lihat-', '');

      const url = `/pendidikan/${type}/${itemId}`;
      const modalTarget = detailButton.dataset.bsTarget;
      const modalElement = document.querySelector(modalTarget);
      if (!modalElement) {
        console.error(`Modal with target ${modalTarget} not found.`);
        return;
      }

      const modalBody = modalElement.querySelector('.modal-body');
      const detailContainer = modalBody.querySelector('.detail-grid-container');
      const docContainer = modalBody.querySelector('.document-viewer-container');
      
      // Mengambil semua elemen <p> yang akan diisi
      const fields = modalElement.querySelectorAll('p[id^="detail_"]');

      // 1. Set semua elemen ke status "loading" tanpa menghapus strukturnya
      fields.forEach(field => {
          field.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
      });
      if(docContainer) docContainer.innerHTML = '<div class="text-center p-5"><i class="fas fa-spinner fa-spin fa-2x"></i><p class="mt-2">Memuat dokumen...</p></div>';

      // 2. Lakukan fetch untuk mendapatkan data
      fetch(url)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok.');
            return response.json();
        })
        .then(data => {
            // 3. Isi elemen-elemen yang sudah ada dengan data yang diterima
            fields.forEach(field => {
                const key = field.id.split('_').slice(2).join('_');
                let value = data[key] || '-';
                
                if (key === 'nama' && data.pegawai) {
                    value = data.pegawai.nama_lengkap || '-';
                }
                
                field.textContent = value;
            });

            // 4. Isi kontainer dokumen
            if (docContainer) {
                if (data.file_path) {
                    docContainer.innerHTML = `<embed src="/storage/${data.file_path}" type="application/pdf" width="100%" height="600px" />`;
                } else {
                    docContainer.innerHTML = '<p class="text-center text-muted p-5">Tidak ada dokumen yang dilampirkan.</p>';
                }
            }
        })
        .catch(error => {
            // Jika gagal, tampilkan pesan error di kontainer utama
            detailContainer.innerHTML = '<div class="text-center text-danger p-5">Gagal memuat data. Silakan coba lagi nanti.</div>';
            console.error('Error fetching detail:', error);
        });
    });
  };

  // Panggil semua fungsi inisialisasi
  initTabs();
  initDeleteConfirmation();
  initKategoriMapping();
  initFileItemClick();
  handleSuccessFlow();
  initFormModals();
  restoreTabsFromUrl();
  initAutoSearch();
  initPendidikanDetailModals();
});