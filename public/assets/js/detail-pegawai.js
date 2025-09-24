document.addEventListener("DOMContentLoaded", () => {
  /**
   * Menginisialisasi semua navigasi tab (utama dan sub-tab).
   */
  const initTabs = () => {
    // Logika untuk Main Tab (Biodata, Pendidikan, dll)
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

    // Logika umum untuk semua Sub Tab
    document.querySelector(".main-content").addEventListener('click', function(e) {
        const subTabButton = e.target.closest('.sub-tab-nav button');
        if (!subTabButton) return;

        const subTabNav = subTabButton.closest('.sub-tab-nav');
        const parentContent = subTabButton.closest('.main-tab-content');

        if (!subTabNav || !parentContent) return;

        // Nonaktifkan semua tombol di dalam navigasi sub-tab saat ini
        subTabNav.querySelectorAll('button').forEach(btn => btn.classList.remove('active'));
        
        // Sembunyikan semua konten sub-tab di dalam konten tab utama saat ini
        parentContent.querySelectorAll('.sub-tab-content').forEach(c => c.style.display = 'none');
        
        // Aktifkan tombol yang diklik dan tampilkan konten yang sesuai
        subTabButton.classList.add('active');
        const contentId = subTabButton.dataset.tab;
        const contentElement = parentContent.querySelector(`#${contentId}`);
        if (contentElement) contentElement.style.display = 'block';
    });
  };

  /**
   * Menginisialisasi Modal Konfirmasi Hapus untuk semua form E-File.
   */
  const initDeleteConfirmation = () => {
    const modalElement = document.getElementById("modalKonfirmasiHapus");
    if (!modalElement) {
        console.warn("Modal konfirmasi hapus tidak ditemukan.");
        return;
    }

    const btnConfirm = document.getElementById("btnKonfirmasiHapus");
    const btnCancel = document.getElementById("btnBatalHapus");
    const modalSubtitle = modalElement.querySelector('.konfirmasi-hapus-subtitle');
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
      if (e.target.matches('.form-hapus-efile')) {
        e.preventDefault(); 
        formToSubmit = e.target;
        
        const namaDokumen = formToSubmit.querySelector('button[type="submit"]').dataset.nama || 'dokumen ini';
        if (modalSubtitle) modalSubtitle.innerHTML = `Apakah Anda yakin ingin menghapus file <strong>${namaDokumen}</strong>?`;
        
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
          
          if (!fileItem) return;

          // Jangan buka file jika yang diklik adalah tombol aksi (lihat/hapus)
          if (e.target.closest('.file-item-actions')) {
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
    if (!trigger) return; // Keluar jika tidak ada notifikasi sukses

    // Ambil elemen-elemen dari modal sukses
    const modalBerhasil = document.getElementById('modalBerhasil');
    const titleElement = document.getElementById('berhasil-title');
    const subtitleElement = document.getElementById('berhasil-subtitle');
    const btnSelesai = document.getElementById('btnSelesai');
    
    // Ambil data dari elemen pemicu
    const title = trigger.dataset.title;
    const message = trigger.dataset.message;
    const activeTab = trigger.dataset.activeTab;
    const activeSubtab = trigger.dataset.activeSubtab;

    // Siapkan audio
    const successSound = new Audio('/assets/sounds/Success.mp3');

    // Fungsi untuk menampilkan modal
    const showSuccessModal = () => {
        // Set pesan
        if(titleElement) titleElement.textContent = title;
        if(subtitleElement) subtitleElement.textContent = message;

        // Tampilkan modal
        if(modalBerhasil) modalBerhasil.classList.add('show');

        // Putar musik
        successSound.play().catch(error => console.error("Gagal memutar audio:", error));
    };

    // Fungsi untuk menyembunyikan modal
    const hideSuccessModal = () => {
        if(modalBerhasil) modalBerhasil.classList.remove('show');
    };
        setTimeout(() => {
        hideSuccessModal();
    }, 1000); // 1000 milidetik = 1 detik

    // Fungsi untuk mengaktifkan tab yang benar
    const activateTabs = () => {
        if (activeTab) {
            const mainTabButton = document.querySelector(`#main-tab-nav .nav-link[data-main-tab="${activeTab}"]`);
            mainTabButton?.click();
        }
        if (activeSubtab) {
            // Beri sedikit jeda agar konten sub-tab sempat muncul sebelum diklik
            setTimeout(() => {
                const subTabButton = document.querySelector(`.sub-tab-nav button[data-tab="${activeSubtab}"]`);
                subTabButton?.click();
            }, 100);
        }
    };

    // --- EKSEKUSI ALUR ---
    activateTabs();
    showSuccessModal();

    // Tambahkan event listener untuk tombol Selesai
    btnSelesai?.addEventListener('click', hideSuccessModal);
  };

  // Panggil semua fungsi inisialisasi saat halaman dimuat
  initTabs();
  initDeleteConfirmation();
  initKategoriMapping();
  initFileItemClick();
  handleSuccessFlow();
});