document.addEventListener("DOMContentLoaded", () => {
  // == Modal Konfirmasi Hapus ==
  const tableCard = document.querySelector(".table-card");
  const modalKonfirmasi = document.getElementById("modalKonfirmasiHapus");
  const modalBerhasil = document.getElementById("modalBerhasil");
  const berhasilTitle = document.getElementById("berhasil-title");
  const berhasilSubtitle = document.getElementById("berhasil-subtitle");
  const btnSelesai = document.getElementById("btnSelesai");

  // Inisialisasi variabel untuk menyimpan baris yang akan dihapus dan audio sukses
  let rowToDelete = null;
  let successAudio = null;

  // Validasi keberadaan elemen yang diperlukan untuk modal
  if (tableCard && modalKonfirmasi && modalBerhasil) {
    const btnBatal = document.getElementById("btnBatalHapus");
    const btnKonfirmasi = document.getElementById("btnKonfirmasiHapus");

    const hideConfirmationModal = () => {
      modalKonfirmasi.classList.remove("show");
      rowToDelete = null;
    };

    const showSuccessModal = () => {
      berhasilTitle.textContent = "Data Berhasil Dihapus";
      berhasilSubtitle.textContent = "Data pegawai telah berhasil dihapus dari sistem.";
      modalBerhasil.classList.add("show");

      // Putar audio sukses, tangani error jika gagal
      successAudio = new Audio("/assets/sounds/success.mp3");
      successAudio.play().catch((error) => console.error("Error memutar audio:", error));

      // Sembunyikan modal sukses setelah 1 detik
      setTimeout(hideSuccessModal, 1000);
    };

    const hideSuccessModal = () => {
      modalBerhasil.classList.remove("show");
      if (successAudio) {
        successAudio.pause();
        successAudio.currentTime = 0;
      }
    };

    // Delegasi event untuk tombol hapus di tabel
    tableCard.addEventListener("click", (event) => {
      const deleteButton = event.target.closest(".btn-hapus");
      if (deleteButton) {
        event.preventDefault();
        rowToDelete = deleteButton.closest("tr");
        modalKonfirmasi.classList.add("show");
      }
    });

    // Event listener untuk tombol konfirmasi hapus
    btnKonfirmasi.addEventListener("click", () => {
      if (rowToDelete) {
        rowToDelete.remove();
        hideConfirmationModal();
        showSuccessModal();
      }
    });

    // Event listener untuk tombol batal
    btnBatal.addEventListener("click", hideConfirmationModal);

    // Tutup modal konfirmasi saat klik di luar modal
    modalKonfirmasi.addEventListener("click", (event) => {
      if (event.target === modalKonfirmasi) hideConfirmationModal();
    });

    // Tutup modal sukses saat klik tombol selesai atau di luar modal
    btnSelesai?.addEventListener("click", hideSuccessModal);
    modalBerhasil?.addEventListener("click", (event) => {
      if (event.target === modalBerhasil) hideSuccessModal();
    });
  }

  // == Kontrol Tampilan Tombol Tambah Data ==
  const pegawaiAktifTab = document.getElementById("pegawai-aktif-tab");
  const riwayatPegawaiTab = document.getElementById("riwayat-pegawai-tab");
  const btnTambah = document.getElementById("btn-tambah-pegawai");

  // Validasi keberadaan elemen untuk tab dan tombol
  if (pegawaiAktifTab && riwayatPegawaiTab && btnTambah) {
    pegawaiAktifTab.addEventListener("click", () => {
      btnTambah.style.display = "inline-flex";
    });
    
    riwayatPegawaiTab.addEventListener("click", () => {
      btnTambah.style.display = "none";
    });
  }
});