document.addEventListener("DOMContentLoaded", () => {
  /* =========================
     Modal Konfirmasi Hapus
  ========================== */
  const tableCard = document.querySelector(".table-card");
  const modal = document.getElementById("modalKonfirmasiHapus");

  const modalBerhasil = document.getElementById("modalBerhasil");
  const berhasilTitle = document.getElementById("berhasil-title");
  const berhasilSubtitle = document.getElementById("berhasil-subtitle");
  const btnSelesai = document.getElementById("btnSelesai");
  let successAudio = null;

  if (tableCard && modal && modalBerhasil) {
    const btnBatal = document.getElementById("btnBatalHapus");
    const btnKonfirmasi = document.getElementById("btnKonfirmasiHapus");
    let rowToDelete = null;

    // Delegasi event untuk tombol hapus
    tableCard.addEventListener("click", (event) => {
      const deleteButton = event.target.closest(".btn-hapus");
      if (deleteButton) {
        event.preventDefault();
        rowToDelete = deleteButton.closest("tr");
        modal.classList.add("show");
      }
    });

    const hideConfirmationModal = () => {
      modal.classList.remove("show");
      rowToDelete = null;
    };

    const showSuccessModal = () => {
      berhasilTitle.textContent = "Data Berhasil Dihapus";
      berhasilSubtitle.textContent = "Data pegawai telah berhasil dihapus dari sistem.";
      modalBerhasil.classList.add("show");

      successAudio = new Audio('/assets/sounds/success.mp3');
      successAudio.play().catch(error => console.log("Audio error:", error));

      setTimeout(() => hideSuccessModal(), 1000);
    };

    const hideSuccessModal = () => {
      modalBerhasil.classList.remove("show");
      if (successAudio) {
        successAudio.pause();
        successAudio.currentTime = 0;
      }
    };

    btnKonfirmasi.addEventListener("click", () => {
      if (rowToDelete) {
        rowToDelete.remove();
        hideConfirmationModal();
        showSuccessModal();
      }
    });

    btnBatal.addEventListener("click", hideConfirmationModal);

    modal.addEventListener("click", (event) => {
      if (event.target === modal) hideConfirmationModal();
    });

    btnSelesai?.addEventListener("click", hideSuccessModal);
    modalBerhasil?.addEventListener("click", (event) => {
      if (event.target === modalBerhasil) hideSuccessModal();
    });
  }

  /* =========================
     Tampilkan/Sembunyikan Tombol Tambah Data
  ========================== */
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
});