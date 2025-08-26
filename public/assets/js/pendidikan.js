document.addEventListener("DOMContentLoaded", () => {
  // == Fungsi Bantuan untuk Modal dan Notifikasi ==
  const openModal = (modalId) => {
    const modal = document.getElementById(modalId);
    if (modal) modal.classList.add("show");
  };

  const closeModal = (modalId) => {
    const modal = document.getElementById(modalId);
    if (modal) modal.classList.remove("show");
  };

  const showSuccessModal = (title, subtitle) => {
    const berhasilTitle = document.getElementById("berhasil-title");
    const berhasilSubtitle = document.getElementById("berhasil-subtitle");
    const modalBerhasil = document.getElementById("modalBerhasil");
    if (!modalBerhasil) return;

    if (berhasilTitle) berhasilTitle.textContent = title;
    if (berhasilSubtitle) berhasilSubtitle.textContent = subtitle;

    modalBerhasil.classList.add("show");

    const successAudio = new Audio("/assets/sounds/success.mp3");
    successAudio.play().catch((error) => {
      console.warn("Error memutar audio:", error.message);
      if (error.name === "NotAllowedError") {
        console.warn("Autoplay diblokir oleh browser. Butuh interaksi pengguna.");
      } else if (error.name === "NotFoundError") {
        console.warn("File audio tidak ditemukan: /assets/sounds/success.mp3");
      }
    });

    setTimeout(() => {
      modalBerhasil.classList.remove("show");
      if (successAudio) {
        successAudio.pause();
        successAudio.currentTime = 0;
      }
    }, 1000);
  };

  const initSuccessModal = () => {
    const btnSelesai = document.getElementById("btnSelesai");
    if (btnSelesai) {
      btnSelesai.addEventListener("click", () => {
        closeModal("modalBerhasil");
        if (successAudio) {
          successAudio.pause();
          successAudio.currentTime = 0;
        }
      });
    }
  };

  // == Modal Konfirmasi Hapus ==
  const initDeleteModal = () => {
    const tabContent = document.getElementById("pendidikanTabContent");
    const deleteModal = document.getElementById("modalKonfirmasiHapus");
    if (!tabContent || !deleteModal) return;

    const btnBatal = document.getElementById("btnBatalHapus");
    const btnKonfirmasi = document.getElementById("btnKonfirmasiHapus");
    let rowToDelete = null;

    tabContent.addEventListener("click", (event) => {
      const deleteButton = event.target.closest(".btn-hapus");
      if (deleteButton) {
        event.preventDefault();
        rowToDelete = deleteButton.closest("tr");
        openModal("modalKonfirmasiHapus");
      }
    });

    const hideDeleteModal = () => {
      closeModal("modalKonfirmasiHapus");
      rowToDelete = null;
    };

    btnKonfirmasi.addEventListener("click", () => {
      if (rowToDelete) {
        rowToDelete.remove();
        showSuccessModal("Data Berhasil Dihapus", "Data yang dipilih telah dihapus dari sistem.");
      }
      hideDeleteModal();
    });

    btnBatal.addEventListener("click", hideDeleteModal);
    deleteModal.addEventListener("click", (event) => {
      if (event.target === deleteModal) hideDeleteModal();
    });
  };

  // == Modal Konfirmasi Verifikasi ==
  const initVerificationModal = () => {
    const popupOverlay = document.getElementById("modalKonfirmasiVerifikasi");
    if (!popupOverlay) return;

    const btnKembali = document.getElementById("popupBtnKembali");
    const btnTerima = document.getElementById("popupBtnTerima");
    const btnTolak = document.getElementById("popupBtnTolak");
    let currentDataId = null;

    document.addEventListener("click", (event) => {
      const konfirmasiButton = event.target.closest(".btn-konfirmasi-pendidikan");
      if (konfirmasiButton) {
        event.preventDefault();
        currentDataId = konfirmasiButton.dataset.id;
        openModal("modalKonfirmasiVerifikasi");
      }
    });

    const hidePopup = () => {
      currentDataId = null;
      closeModal("modalKonfirmasiVerifikasi");
    };

    const handleVerification = () => {
      if (currentDataId) {
        showSuccessModal("Status Verifikasi Disimpan", "Perubahan status verifikasi telah berhasil disimpan.");
      }
      hidePopup();
    };

    btnKembali.addEventListener("click", hidePopup);
    btnTerima.addEventListener("click", handleVerification);
    btnTolak.addEventListener("click", handleVerification);
    popupOverlay.addEventListener("click", (event) => {
      if (event.target === popupOverlay) hidePopup();
    });
  };

  // == Inisialisasi Form dan Modal ==
  const initForms = () => {
    const modals = [
      {
        modalId: "modalTambahEditPengajaranLama",
        btnId: "btnSimpanPengajaran",
        tableSelector: "#pengajaran-lama .table tbody",
        formId: "formPengajaranLama",
        editIdField: "editPengajaranId",
        titleId: "modalTitleText",
        fields: [
          { id: "nama", key: "nama" },
          { id: "tahun_semester", key: "tahun_semester" },
          { id: "kode_mk", key: "kode_mk" },
          { id: "nama_mk", key: "nama_mk" },
          { id: "sks_kuliah", key: "sks_kuliah" },
          { id: "sks_praktikum", key: "sks_praktikum" },
          { id: "kelas_paralel", key: "kelas_paralel" },
          { id: "jumlah_pertemuan", key: "jumlah_pertemuan" }
        ],
        addBtnId: "btnTambahPengajaranLama",
        addTitle: "Tambah Pengajaran Lama",
        editTitle: "Edit Pengajaran Lama"
      },
      {
        modalId: "modalPengajaranLuar",
        btnId: "btnSimpanPengajaranLuar",
        tableSelector: "#pengajaran-luar .table tbody",
        formId: "formPengajaranLuar",
        editIdField: "editPengajaranLuarId",
        titleId: "modalTitleTextPengajaranLuar",
        fields: [
          { id: "pl_nama", key: "nama" },
          { id: "pl_tahun_semester", key: "tahun_semester" },
          { id: "pl_kode_mk", key: "kode_mk" },
          { id: "pl_nama_mk", key: "nama_mk" },
          { id: "pl_sks_kuliah", key: "sks_kuliah" },
          { id: "pl_sks_praktikum", key: "sks_praktikum" },
          { id: "pl_universitas", key: "universitas" },
          { id: "pl_strata", key: "strata" },
          { id: "pl_program_studi", key: "program_studi" },
          { id: "pl_jenis", key: "jenis" },
          { id: "pl_kelas_paralel", key: "kelas_paralel" },
          { id: "pl_jumlah_pertemuan", key: "jumlah_pertemuan" },
          { id: "pl_is_insidental", key: "is_insidental" },
          { id: "pl_is_lebih_satu_semester", key: "is_lebih_satu_semester" }
        ],
        addBtnId: "btnTambahPengajaranLuar",
        addTitle: "Tambah Kegiatan Pengajaran Luar IPB",
        editTitle: "Edit Kegiatan Pengajaran Luar IPB"
      },
      {
        modalId: "modalPengujianLama",
        btnId: "btnSimpanPengujianLama",
        tableSelector: "#pengujian-lama .table tbody",
        formId: "formPengujianLama",
        editIdField: "editPengujianLamaId",
        titleId: "modalTitleTextPengujianLama",
        fields: [
          { id: "pjl_kegiatan", key: "kegiatan" },
          { id: "pjl_nama", key: "nama" },
          { id: "pjl_strata", key: "strata" },
          { id: "pjl_tahun_semester", key: "tahun_semester" },
          { id: "pjl_nim", key: "nim" },
          { id: "pjl_nama_mahasiswa", key: "nama_mahasiswa" },
          { id: "pjl_departemen", key: "departemen" }
        ],
        addBtnId: "btnTambahPengujianLama",
        addTitle: "Tambah Kegiatan Pengujian Lama",
        editTitle: "Edit Kegiatan Pengujian Lama"
      },
      {
        modalId: "modalPembimbingLama",
        btnId: "btnSimpanPembimbingLama",
        tableSelector: "#pembimbing-lama .table tbody",
        formId: "formPembimbingLama",
        editIdField: "editPembimbingLamaId",
        titleId: "modalTitleTextPembimbingLama",
        fields: [
          { id: "pbl_kegiatan", key: "kegiatan" },
          { id: "pbl_nama", key: "nama" },
          { id: "pbl_tahun_semester", key: "tahun_semester" },
          { id: "pbl_nim", key: "nim" },
          { id: "pbl_nama_mahasiswa", key: "nama_mahasiswa" },
          { id: "pbl_departemen", key: "departemen" },
          { id: "pbl_lokasi", key: "lokasi" },
          { id: "pbl_nama_dokumen", key: "nama_dokumen" }
        ],
        addBtnId: "btnTambahPembimbingLama",
        addTitle: "Tambah Kegiatan Pembimbing Lama",
        editTitle: "Edit Kegiatan Pembimbing Lama"
      },
      {
        modalId: "modalPengujiLuar",
        btnId: "btnSimpanPengujiLuar",
        tableSelector: "#penguji-luar .table tbody",
        formId: "formPengujiLuar",
        editIdField: "editPengujiLuarId",
        titleId: "modalTitleTextPengujiLuar",
        fields: [
          { id: "pjl_kegiatan", key: "kegiatan" },
          { id: "pjl_nama", key: "nama" },
          { id: "pjl_status", key: "status" },
          { id: "pjl_tahun_semester_luar", key: "tahun_semester" },
          { id: "pjl_nim_luar", key: "nim" },
          { id: "pjl_nama_mahasiswa_luar", key: "nama_mahasiswa" },
          { id: "pjl_universitas", key: "universitas" },
          { id: "pjl_strata_luar", key: "strata" },
          { id: "pjl_program_studi", key: "program_studi" },
          { id: "pjl_is_insidental", key: "is_insidental" },
          { id: "pjl_is_lebih_satu_semester", key: "is_lebih_satu_semester" }
        ],
        addBtnId: "btnTambahPengujiLuar",
        addTitle: "Tambah Kegiatan Penguji Luar IPB",
        editTitle: "Edit Kegiatan Penguji Luar IPB"
      },
      {
        modalId: "modalPembimbingLuar",
        btnId: "btnSimpanPembimbingLuar",
        tableSelector: "#pembimbing-luar .table tbody",
        formId: "formPembimbingLuar",
        editIdField: "editPembimbingLuarId",
        titleId: "modalTitleTextPembimbingLuar",
        fields: [
          { id: "pbl_kegiatan_luar", key: "kegiatan" },
          { id: "pbl_nama_luar", key: "nama" },
          { id: "pbl_status_luar", key: "status" },
          { id: "pbl_tahun_semester_luar", key: "tahun_semester" },
          { id: "pbl_nim_luar", key: "nim" },
          { id: "pbl_nama_mahasiswa_luar", key: "nama_mahasiswa" },
          { id: "pbl_universitas_luar", key: "universitas" },
          { id: "pbl_program_studi_luar", key: "program_studi" },
          { id: "pbl_is_insidental_luar", key: "is_insidental" },
          { id: "pbl_is_lebih_satu_semester_luar", key: "is_lebih_satu_semester" }
        ],
        addBtnId: "btnTambahPembimbingLuar",
        addTitle: "Tambah Kegiatan Pembimbing Luar IPB",
        editTitle: "Edit Kegiatan Pembimbing Luar IPB"
      }
    ];

    modals.forEach((modalConfig) => {
      const modalElement = document.getElementById(modalConfig.modalId);
      if (!modalElement) return;

      const modalTitleText = modalElement.querySelector(`#${modalConfig.titleId}`);
      const form = document.getElementById(modalConfig.formId);
      const editIdField = document.getElementById(modalConfig.editIdField);
      const tableBody = document.querySelector(modalConfig.tableSelector);

      // Tombol Tambah
      document.getElementById(modalConfig.addBtnId)?.addEventListener("click", () => {
        modalTitleText.textContent = modalConfig.addTitle;
        form.reset();
        editIdField.value = "";
      });

      // Tombol Edit
      if (tableBody) {
        tableBody.addEventListener("click", (event) => {
          const editButton = event.target.closest(`.btn-edit${modalConfig.modalId.includes("PengajaranLama") ? "" : modalConfig.modalId.includes("PengajaranLuar") ? "-pengajaran-luar" : modalConfig.modalId.includes("PengujianLama") ? "-pengujian-lama" : modalConfig.modalId.includes("PembimbingLama") ? "-pembimbing-lama" : modalConfig.modalId.includes("PengujiLuar") ? "-penguji-luar" : "-pembimbing-luar"}`);
          if (editButton) {
            modalTitleText.textContent = modalConfig.editTitle;
            const data = editButton.dataset;
            editIdField.value = data.id || "";
            modalConfig.fields.forEach((field) => {
              const fieldElement = document.getElementById(field.id);
              if (fieldElement) fieldElement.value = data[field.key] || "";
            });
          }
        });
      }

      // Tombol Simpan
      const saveButton = document.getElementById(modalConfig.btnId);
      if (saveButton && modalElement) {
        saveButton.addEventListener("click", () => {
          const bootstrapModal = bootstrap.Modal.getInstance(modalElement);
          if (bootstrapModal) bootstrapModal.hide();
          showSuccessModal("Data Berhasil Disimpan", "Perubahan Anda telah berhasil disimpan ke dalam sistem.");
        });
      }
    });
  };

  // == Inisialisasi Modal Detail ==
  const initDetailModals = () => {
    const detailConfigs = [
      {
        tableSelector: "#pengajaran-lama .table tbody",
        btnClass: ".btn-lihat-detail",
        fields: [
          { id: "detail_pl_kegiatan", key: "kegiatan" },
          { id: "detail_pl_nama", key: "nama" },
          { id: "detail_pl_tahun_semester", key: "tahun_semester" },
          { id: "detail_pl_kode_mk", key: "kode_mk" },
          { id: "detail_pl_nama_mk", key: "nama_mk" },
          { id: "detail_pl_pengampu", key: "pengampu" },
          { id: "detail_pl_sks_kuliah", key: "sks_kuliah" },
          { id: "detail_pl_sks_praktikum", key: "sks_praktikum" },
          { id: "detail_pl_jenis", key: "jenis" },
          { id: "detail_pl_kelas_paralel", key: "kelas_paralel" },
          { id: "detail_pl_jumlah_pertemuan", key: "jumlah_pertemuan" },
          { id: "detail_pl_document_viewer", key: "dokumen_path", isSrc: true }
        ]
      },
      {
        tableSelector: "#pengajaran-luar .table tbody",
        btnClass: ".btn-lihat-detail",
        fields: [
          { id: "detail_pluar_nama", key: "nama" },
          { id: "detail_pluar_tahun_semester", key: "tahun_semester" },
          { id: "detail_pluar_universitas", key: "universitas" },
          { id: "detail_pluar_kode_mk", key: "kode_mk" },
          { id: "detail_pluar_nama_mk", key: "nama_mk" },
          { id: "detail_pluar_program_studi", key: "program_studi" },
          { id: "detail_pluar_sks_kuliah", key: "sks_kuliah" },
          { id: "detail_pluar_sks_praktikum", key: "sks_praktikum" },
          { id: "detail_pluar_jenis", key: "jenis" },
          { id: "detail_pluar_kelas_paralel", key: "kelas_paralel" },
          { id: "detail_pluar_jumlah_pertemuan", key: "jumlah_pertemuan" },
          { id: "detail_pluar_insidental", key: "is_insidental" },
          { id: "detail_pluar_lebih_satu_semester", key: "is_lebih_satu_semester" },
          { id: "detail_pluar_document_viewer", key: "dokumen_path", isSrc: true }
        ]
      },
      {
        tableSelector: "#pengujian-lama .table tbody",
        btnClass: ".btn-lihat-detail-pengujian",
        fields: [
          { id: "detail_pjl_kegiatan", key: "kegiatan" },
          { id: "detail_pjl_nama", key: "nama" },
          { id: "detail_pjl_tahun_semester", key: "tahun_semester" },
          { id: "detail_pjl_nim", key: "nim" },
          { id: "detail_pjl_nama_mahasiswa", key: "nama_mahasiswa" },
          { id: "detail_pjl_departemen", key: "departemen" },
          { id: "detail_pjl_document_viewer", key: "dokumen_path", isSrc: true }
        ]
      },
      {
        tableSelector: "#pembimbing-lama .table tbody",
        btnClass: ".btn-lihat-detail-pembimbing",
        fields: [
          { id: "detail_pbl_kegiatan", key: "kegiatan" },
          { id: "detail_pbl_nama", key: "nama" },
          { id: "detail_pbl_tahun_semester", key: "tahun_semester" },
          { id: "detail_pbl_lokasi", key: "lokasi" },
          { id: "detail_pbl_nim", key: "nim" },
          { id: "detail_pbl_nama_mahasiswa", key: "nama_mahasiswa" },
          { id: "detail_pbl_departemen", key: "departemen" },
          { id: "detail_pbl_nama_dokumen", key: "nama_dokumen" },
          { id: "detail_pbl_document_viewer", key: "dokumen_path", isSrc: true }
        ]
      },
      {
        tableSelector: "#penguji-luar .table tbody",
        btnClass: ".btn-lihat-detail-penguji-luar",
        fields: [
          { id: "detail_pjl_luar_kegiatan", key: "kegiatan" },
          { id: "detail_pjl_luar_nama", key: "nama" },
          { id: "detail_pjl_luar_status", key: "status" },
          { id: "detail_pjl_luar_tahun_semester", key: "tahun_semester" },
          { id: "detail_pjl_luar_nim", key: "nim" },
          { id: "detail_pjl_luar_nama_mahasiswa", key: "nama_mahasiswa" },
          { id: "detail_pjl_luar_universitas", key: "universitas" },
          { id: "detail_pjl_luar_program_studi", key: "program_studi" },
          { id: "detail_pjl_luar_insidental", key: "is_insidental" },
          { id: "detail_pjl_luar_lebih_satu_semester", key: "is_lebih_satu_semester" },
          { id: "detail_pjl_luar_document_viewer", key: "dokumen_path", isSrc: true }
        ]
      },
      {
        tableSelector: "#pembimbing-luar .table tbody",
        btnClass: ".btn-lihat-detail-pembimbing-luar",
        fields: [
          { id: "detail_pbl_luar_kegiatan", key: "kegiatan" },
          { id: "detail_pbl_luar_nama", key: "nama" },
          { id: "detail_pbl_luar_status", key: "status" },
          { id: "detail_pbl_luar_tahun_semester", key: "tahun_semester" },
          { id: "detail_pbl_luar_nim", key: "nim" },
          { id: "detail_pbl_luar_nama_mahasiswa", key: "nama_mahasiswa" },
          { id: "detail_pbl_luar_universitas", key: "universitas" },
          { id: "detail_pbl_luar_program_studi", key: "program_studi" },
          { id: "detail_pbl_luar_insidental", key: "is_insidental" },
          { id: "detail_pbl_luar_lebih_satu_semester", key: "is_lebih_satu_semester" },
          { id: "detail_pbl_luar_document_viewer", key: "dokumen_path", isSrc: true }
        ]
      }
    ];

    detailConfigs.forEach((config) => {
      const tableBody = document.querySelector(config.tableSelector);
      if (tableBody) {
        tableBody.addEventListener("click", (event) => {
          const detailButton = event.target.closest(config.btnClass);
          if (detailButton) {
            const data = detailButton.dataset;
            config.fields.forEach((field) => {
              const element = document.getElementById(field.id);
              if (element) {
                if (field.isSrc) {
                  element.setAttribute("src", data[field.key] || "");
                } else {
                  element.textContent = data[field.key] || "-";
                }
              }
            });
          }
        });
      }
    });
  };

  // == Inisialisasi Semua ==
  initSuccessModal();
  initDeleteModal();
  initVerificationModal();
  initForms();
  initDetailModals();
});