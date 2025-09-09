document.addEventListener("DOMContentLoaded", () => {
  const jenisDokumenData = {
      biodata: ["Pas Foto", "KTP", "NPWP", "Kartu Pegawai (Karpeg)", "Kartu Keluarga (KK)"],
      pendidikan: ["Ijazah S1", "Transkrip Nilai S1", "Ijazah S2", "Transkrip Nilai S2", "Ijazah S3", "Transkrip Nilai S3"],
      jf: ["SK Asisten Ahli", "SK Lektor", "SK Lektor Kepala", "SK Guru Besar", "Sertifikasi Dosen"],
      sk: ["SK CPNS", "SK PNS", "SK Kenaikan Gaji Berkala"],
      sp: ["Surat Tugas Khusus", "Surat Pernyataan Melaksanakan Tugas (SPMT)"],
      lain: ["Sertifikat Pelatihan", "Penghargaan", "Lain-lain"]
  };

  /**
   * Mengatur perpindahan antara semua sub-tab.
   */
  const initSubTabs = () => {
    const subTabContainer = document.querySelector("#biodata-sub-tabs");
    const biodataSaveButton = document.querySelector("#btn-simpan-biodata");

    if (!subTabContainer) return;

    subTabContainer.addEventListener("click", (e) => {
      const button = e.target.closest("button");
      if (!button) return;

      subTabContainer.querySelectorAll("button").forEach((btn) => btn.classList.remove("active"));
      document.querySelectorAll(".sub-tab-content").forEach((content) => (content.style.display = "none"));

      button.classList.add("active");
      const contentElement = document.querySelector(`#${button.dataset.tab}`);
      if (contentElement) {
        contentElement.style.display = "block";
      }

      // Sembunyikan/tampilkan tombol simpan utama
      if (biodataSaveButton) {
        biodataSaveButton.style.display = (button.dataset.tab === 'efile') ? 'none' : 'block';
      }
    });
  };

  /**
   * Mengatur modal konfirmasi hapus untuk E-File.
   */
  const initDeleteConfirmation = () => {
    const modalElement = document.getElementById("modalKonfirmasiHapus");
    if (!modalElement) return;

    const modalHapus = new bootstrap.Modal(modalElement);
    let formToSubmit = null;

    document.body.addEventListener('submit', function(e) {
      if (e.target.matches('.form-hapus-efile')) {
        e.preventDefault();
        formToSubmit = e.target;
        modalHapus.show();
      }
    });

    document.getElementById("btnKonfirmasiHapus")?.addEventListener('click', () => {
      if (formToSubmit) formToSubmit.submit();
    });

    document.getElementById("btnBatalHapus")?.addEventListener('click', () => {
        formToSubmit = null;
        modalHapus.hide();
    });
  };

  /**
   * Mengisi dropdown 'Jenis Dokumen' berdasarkan 'Kategori' yang dipilih di modal.
   */
  const initKategoriJenisDokumen = () => {
    const kategoriSelect = document.getElementById("kategori_dokumen");
    const jenisSelect = document.getElementById("nama_dokumen");
    if (!kategoriSelect || !jenisSelect) return;

    kategoriSelect.addEventListener("change", () => {
      const kategori = kategoriSelect.value;
      jenisSelect.innerHTML = `<option value="" selected disabled>-- Pilih Jenis Dokumen --</option>`;
      if (jenisDokumenData[kategori]) {
        jenisDokumenData[kategori].forEach((jenis) => {
          const option = document.createElement("option");
          option.textContent = jenis;
          option.value = jenis;
          jenisSelect.appendChild(option);
        });
      }
    });
  };

  // Jalankan semua fungsi
  initSubTabs();
  initDeleteConfirmation();
  initKategoriJenisDokumen();
});