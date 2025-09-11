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

    // Logika untuk Sub Tab (Kepegawaian, E-File, dll)
    document.getElementById("biodata-sub-tabs")?.addEventListener("click", (e) => {
        const subTabButton = e.target.closest("button");
        if (!subTabButton) return;

        const parentContent = subTabButton.closest(".main-tab-content");
        document.querySelectorAll("#biodata-sub-tabs button").forEach(btn => btn.classList.remove("active"));
        parentContent.querySelectorAll(".sub-tab-content").forEach(c => c.style.display = "none");
        
        subTabButton.classList.add("active");
        const contentId = subTabButton.dataset.tab;
        const contentElement = parentContent.querySelector(`#${contentId}`);
        if(contentElement) contentElement.style.display = "block";
    });
  };

  /**
   * Menginisialisasi Modal Konfirmasi Hapus untuk semua form E-File.
   * PERBAIKAN: Menggunakan kontrol manual untuk modal kustom.
   */
  const initDeleteConfirmation = () => {
    const modalElement = document.getElementById("modalKonfirmasiHapus");
    if (!modalElement) {
        console.warn("Modal konfirmasi hapus tidak ditemukan.");
        return;
    }

    const btnConfirm = document.getElementById("btnKonfirmasiHapus");
    const btnCancel = document.getElementById("btnBatalHapus"); // Target tombol Batal
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
    
    // PERBAIKAN DI SINI: Tambahkan event listener untuk tombol Batal
    btnCancel?.addEventListener('click', function() {
        hideModal();
    });

    // Event listener untuk menutup modal jika klik di area overlay
    modalElement.addEventListener('click', function(event) {
        if (event.target === modalElement) {
            hideModal();
        }
    });
  };

  /**
   * Menginisialisasi dropdown Kategori -> Jenis Dokumen di dalam modal tambah.
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
   * Menangani klik pada item file untuk membuka file di tab baru.
   */
  const initFileItemClick = () => {
      document.body.addEventListener('click', function(e) {
          const fileItem = e.target.closest('.file-item');
          
          if (!fileItem) return;

          if (e.target.closest('.file-item-actions')) {
              return; 
          }

          const fileUrl = fileItem.dataset.fileUrl;
          if(fileUrl) {
              window.open(fileUrl, '_blank');
          }
      });
  };

  // Panggil semua fungsi inisialisasi
  initTabs();
  initDeleteConfirmation();
  initKategoriMapping();
  initFileItemClick();
});