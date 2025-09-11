document.addEventListener("DOMContentLoaded", () => {
  /**
   * Modul untuk menangani Modal Konfirmasi Hapus.
   * Mencegat form hapus, menampilkan modal yang benar, dan mengirimkan form jika dikonfirmasi.
   */
  const initDeleteConfirmation = () => {
    const tableCard = document.querySelector(".table-card");
    const modalKonfirmasi = document.getElementById("modalKonfirmasiHapus");

    // Hentikan eksekusi jika elemen-elemen penting tidak ditemukan di halaman.
    if (!tableCard || !modalKonfirmasi) {
      console.warn("Elemen untuk modal konfirmasi hapus tidak ditemukan.");
      return;
    }

    const modalSubtitle = modalKonfirmasi.querySelector('.konfirmasi-hapus-subtitle');
    const btnKonfirmasi = document.getElementById("btnKonfirmasiHapus");
    const btnBatal = document.getElementById("btnBatalHapus");

    // Pastikan semua elemen di dalam modal juga ada.
    if (!modalSubtitle || !btnKonfirmasi || !btnBatal) {
        console.error("Struktur di dalam modal konfirmasi hapus tidak lengkap (subtitle/tombol).");
        return;
    }

    let formToSubmit = null; // Variabel untuk menyimpan form yang akan di-submit.

    // Fungsi untuk menampilkan modal.
    const showModal = () => {
      modalKonfirmasi.style.display = 'flex'; // Gunakan flex untuk memusatkan.
      setTimeout(() => modalKonfirmasi.classList.add('show'), 10); // Tambahkan class untuk animasi fade-in.
    };

    // Fungsi untuk menyembunyikan modal.
    const hideModal = () => {
      modalKonfirmasi.classList.remove('show');
      setTimeout(() => {
        modalKonfirmasi.style.display = 'none';
      }, 200); // Sesuaikan durasi dengan transisi CSS Anda.
      formToSubmit = null; // Reset form setelah modal ditutup.
    };

    // Gunakan event delegation pada tabel untuk mencegat event 'submit'.
    tableCard.addEventListener("submit", (event) => {
      const form = event.target.closest(".form-hapus");
      if (form) {
        event.preventDefault(); // Mencegah form dikirim secara langsung.
        formToSubmit = form;

        // Ambil nama pegawai dari atribut 'data-nama' pada tombol.
        const namaPegawai = form.querySelector('button[type="submit"]').dataset.nama || 'data ini';
        
        // Ubah teks di modal secara dinamis.
        modalSubtitle.innerHTML = `Data untuk <strong>${namaPegawai}</strong> akan dihapus permanen.`;
        
        showModal();
      }
    });

    // Event listener untuk tombol "Ya, Hapus".
    btnKonfirmasi.addEventListener("click", () => {
      if (formToSubmit) {
        formToSubmit.submit(); // Kirim form yang telah disimpan.
      }
    });

    // Event listener untuk tombol "Batal" dan klik di luar area modal.
    btnBatal.addEventListener("click", hideModal);
    modalKonfirmasi.addEventListener("click", (event) => {
      if (event.target === modalKonfirmasi) {
        hideModal();
      }
    });
  };

  /**
   * Modul untuk mengontrol tampilan tombol "Tambah Data" berdasarkan tab yang aktif.
   */
  const initTabControls = () => {
    const pegawaiAktifTab = document.getElementById("pegawai-aktif-tab");
    const riwayatPegawaiTab = document.getElementById("riwayat-pegawai-tab");
    const btnTambah = document.getElementById("btn-tambah-pegawai");

    if (pegawaiAktifTab && riwayatPegawaiTab && btnTambah) {
      pegawaiAktifTab.addEventListener("click", () => {
        btnTambah.style.display = "inline-flex";
      });
      
      riwayatPegawaiTab.addEventListener("click", () => {
        btnTambah.style.display = "none";
      });
    }
  };

  // Panggil semua fungsi inisialisasi saat halaman selesai dimuat.
  initDeleteConfirmation();
  initTabControls();
});

