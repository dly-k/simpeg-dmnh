document.addEventListener("DOMContentLoaded", () => {
  
  /**
   * == 1. Inisialisasi Sub-Tab ==
   * Mengatur perpindahan antara semua sub-tab (Kepegawaian, Dosen, E-File, dll).
   * Fungsi ini sekarang menjadi satu-satunya pengendali navigasi tab di halaman ini.
   */
  const initSubTabs = () => {
    const subTabContainer = document.querySelector("#biodata-sub-tabs");
    if (!subTabContainer) return;

    subTabContainer.addEventListener("click", (e) => {
      const button = e.target.closest("button");
      if (!button) return;

      // Nonaktifkan semua tombol sub-tab
      subTabContainer.querySelectorAll("button").forEach((btn) => btn.classList.remove("active"));
      
      // Sembunyikan semua konten sub-tab
      document.querySelectorAll(".sub-tab-content").forEach((content) => (content.style.display = "none"));

      // Aktifkan tombol yang diklik
      button.classList.add("active");
      
      // Tampilkan konten sub-tab yang sesuai
      const contentElement = document.querySelector(`#${button.dataset.tab}`);
      if (contentElement) {
        contentElement.style.display = "block";
      }
    });
  };

  /**
   * == 2. Inisialisasi Modal Konfirmasi Hapus untuk E-File ==
   * Mencegat form hapus, menampilkan modal konfirmasi, dan melanjutkan
   * submit jika pengguna setuju.
   */
  const initDeleteConfirmation = () => {
    const modalElement = document.getElementById("modalKonfirmasiHapus");
    if (!modalElement) return;

    const modalHapus = new bootstrap.Modal(modalElement);
    let formToSubmit = null; // Variabel untuk menyimpan form yang akan disubmit

    // Gunakan event delegation untuk menangkap event submit dari form hapus
    document.body.addEventListener('submit', function(e) {
      if (e.target.matches('.form-hapus-efile')) {
        e.preventDefault(); // Hentikan proses submit form asli
        formToSubmit = e.target; // Simpan form yang diklik
        
        // Atur pesan di modal konfirmasi (opsional, jika modalnya generik)
        const modalTitle = modalElement.querySelector('.modal-title');
        if(modalTitle) modalTitle.textContent = 'Konfirmasi Hapus Dokumen';
        
        const modalBody = modalElement.querySelector('.modal-body p');
        if(modalBody) modalBody.textContent = 'Apakah Anda yakin ingin menghapus dokumen ini? Tindakan ini tidak dapat dibatalkan.';

        modalHapus.show(); // Tampilkan modal konfirmasi
      }
    });

    // Tambahkan event listener untuk tombol "Ya, Hapus" di dalam modal
    const btnKonfirmasi = document.getElementById("btnKonfirmasiHapus");
    btnKonfirmasi?.addEventListener('click', function() {
      if (formToSubmit) {
        formToSubmit.submit(); // Lanjutkan proses submit form yang disimpan
      }
    });

    // Tambahkan event listener untuk tombol "Batal"
    const btnBatal = document.getElementById("btnBatalHapus");
    btnBatal?.addEventListener('click', function() {
        formToSubmit = null; // Reset variabel form
        modalHapus.hide();
    });
  };


  // == Jalankan Semua Fungsi Inisialisasi ==
  initSubTabs();
  initDeleteConfirmation();
});