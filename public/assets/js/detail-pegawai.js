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
    if (!modalElement) {
        console.warn("Modal konfirmasi hapus tidak ditemukan.");
        return;
    }

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
    
    btnCancel?.addEventListener('click', function() {
        hideModal();
    });

    modalElement.addEventListener('click', function(event) {
        if (event.target === modalElement) {
            hideModal();
        }
    });
  };

  /**
   * Menginisialisasi dropdown Kategori -> Jenis Dokumen di dalam modal tambah E-File.
   */
  const initKategoriMapping = () => {
    const jenisDokumenData = {
      biodata: ["Pas Foto", "KTP", "NPWP", "Kartu Pegawai", "Kartu Keluarga"],
      pendidikan: ["Ijazah S1", "Transkrip S1", "Ijazah S2", "Transkrip S2", "Ijazah S3", "Transkrip S3"],
      jf: ["SK Asisten Ahli", "SK Lektor", "SK Lektor Kepala", "SK Guru Besar", "Sertifikasi Dosen"],
      sk: ["SK CPNS", "SK PNS", "SK Kenaikan Gaji Berkala"],
      sp: ["Surat Tugas", "Surat Pernyataan Melaksanakan Tugas (SPMT)"],
      lain: ["Sertifikat Pelatihan", "Penghargaan", "Lain-lain"]
    };

    const kategoriSelect = document.getElementById("kategori");
    const jenisSelect = document.getElementById("jenis-dokumen");

    if (!kategoriSelect || !jenisSelect) return;

    kategoriSelect.addEventListener("change", function () {
      jenisSelect.innerHTML = '<option value="" selected disabled>-- Pilih Jenis Dokumen --</option>';
      const kategori = this.value;
      if (jenisDokumenData[kategori]) {
        jenisDokumenData[kategori].forEach((jenis) => {
          const opt = document.createElement("option");
          opt.value = jenis;
          opt.textContent = jenis;
          jenisSelect.appendChild(opt);
        });
      }
    });
  };
  
  /**
   * Menangani klik pada item file (E-File) untuk membuka file di tab baru.
   */
  const initFileItemClick = () => {
      document.body.addEventListener('click', function(e) {
          const fileItem = e.target.closest('.file-item');
          
          if (!fileItem || e.target.closest('.file-item-actions')) {
              return; 
          }

          const fileUrl = fileItem.dataset.fileUrl;
          if(fileUrl) {
              window.open(fileUrl, '_blank');
          }
      });
  };

  /**
   * Menangani kemunculan modal sukses, musik, dan navigasi tab setelah form disubmit.
   */
  const handleSuccessFlow = () => {
    const trigger = document.getElementById('success-trigger');
    if (!trigger) return;
    
    const modalBerhasil = document.getElementById('modalBerhasil');
    const titleElement = document.getElementById('berhasil-title');
    const subtitleElement = document.getElementById('berhasil-subtitle');
    const btnSelesai = document.getElementById('btnSelesai');
    
    const title = trigger.dataset.title;
    const message = trigger.dataset.message;
    const activeTab = trigger.dataset.activeTab;
    const activeSubtab = trigger.dataset.activeSubtab;

    const successSound = new Audio('/assets/sounds/Success.mp3');

    const hideSuccessModal = () => {
        if(modalBerhasil) modalBerhasil.classList.remove('show');
    };

    const showSuccessModal = () => {
        if(titleElement) titleElement.textContent = title;
        if(subtitleElement) subtitleElement.textContent = message;
        if(modalBerhasil) modalBerhasil.classList.add('show');
        
        successSound.play().catch(error => console.error("Gagal memutar audio:", error));
        
        setTimeout(hideSuccessModal, 1000);
    };

    const activateTabs = () => {
        if (activeTab) {
            document.querySelector(`#main-tab-nav .nav-link[data-main-tab="${activeTab}"]`)?.click();
        }
        if (activeSubtab) {
            setTimeout(() => {
                document.querySelector(`.sub-tab-nav button[data-tab="${activeSubtab}"]`)?.click();
            }, 100);
        }
    };

    activateTabs();
    showSuccessModal();
    btnSelesai?.addEventListener('click', hideSuccessModal);
  };

  /**
   * Menginisialisasi dan mengelola semua modal form (Tambah & Edit).
   */
  const initFormModals = () => {
    document.body.addEventListener('click', function(e) {
      const addButton = e.target.closest('.btn-tambah');
      const editButton = e.target.closest('.btn-edit');
      
      if (!addButton && !editButton) return;

      const button = addButton || editButton;
      const modalTargetId = button.dataset.bsTarget;
      const modalElement = document.querySelector(modalTargetId);
      if (!modalElement) return;

      const form = modalElement.querySelector('form');
      const title = modalElement.querySelector('.modal-title');
      const methodField = form.querySelector('input[name="_method"]');
      const submitButton = modalElement.querySelector('button[type="submit"]');
      const fileHelpText = form.querySelector('.form-text');

      // 1. Reset form setiap kali modal dibuka
      form.reset();
      form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
      form.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

      if (addButton) {
        // 2. KONFIGURASI UNTUK MODE TAMBAH
        title.innerHTML = '<i class="fas fa-plus-circle me-2"></i> Tambah Data';
        form.setAttribute('action', button.dataset.storeUrl);
        if (methodField) methodField.value = 'POST';
        submitButton.className = 'btn btn-success';
        submitButton.textContent = 'Simpan';
        if (fileHelpText) fileHelpText.textContent = 'Tipe file: PDF, JPG, PNG. Maks: 5 MB.';
      } else if (editButton) {
        // 3. KONFIGURASI UNTUK MODE EDIT
        const itemData = JSON.parse(button.dataset.item || '{}');
        
        title.innerHTML = '<i class="fas fa-edit me-2"></i> Edit Data';
        form.setAttribute('action', button.dataset.updateUrl);
        if (methodField) methodField.value = 'PUT';
        submitButton.className = 'btn btn-warning';
        submitButton.textContent = 'Update';
        if (fileHelpText) fileHelpText.textContent = 'Kosongkan jika tidak ingin mengubah file.';
        
        // Isi setiap field di dalam form berdasarkan data
        for (const key in itemData) {
          const input = form.querySelector(`[name="${key}"]`);
          if (input) {
            // Menangani input tanggal secara khusus
            if (input.type === 'date') {
                 input.value = itemData[key] ? itemData[key].split(' ')[0] : '';
            } else {
                 input.value = itemData[key];
            }
          }
        }
      }
    });
  };

  // Panggil semua fungsi inisialisasi
  initTabs();
  initDeleteConfirmation();
  initKategoriMapping();
  initFileItemClick();
  handleSuccessFlow();
  initFormModals();
});