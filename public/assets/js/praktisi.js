document.addEventListener("DOMContentLoaded", function () {
  /**
   * ================================================================
   * BAGIAN 1: MODAL NOTIFIKASI SUKSES
   * ================================================================
   */
  function showSuccessModal() {
    const successModalOverlay = document.getElementById("modalBerhasil");
    const closeButton = document.getElementById("btnSelesai");

    if (successModalOverlay && closeButton) {
      successModalOverlay.style.display = "flex";
      successModalOverlay.style.opacity = "1";
      successModalOverlay.style.visibility = "visible";

      const soundUrl = document.body.getAttribute("data-success-sound");
      if (soundUrl) {
        const successAudio = new Audio(soundUrl);
        setTimeout(() => {
          successAudio.play().catch((e) => console.error("Gagal memutar audio:", e));
        }, 150);
      }

      setTimeout(() => {
        successModalOverlay.style.display = "none";
      }, 2000);

      if (!closeButton.dataset.listenerAttached) {
        closeButton.addEventListener("click", function () {
          successModalOverlay.style.display = "none";
        });
        closeButton.dataset.listenerAttached = "true";
      }
    }
  }

  const flashSuccessMeta = document.querySelector('meta[name="flash-success"]');
  if (flashSuccessMeta && flashSuccessMeta.getAttribute("content")) {
    showSuccessModal();
  }

  /**
   * ================================================================
   * BAGIAN 2: MODAL EDIT DATA
   * ================================================================
   */
  const editModalElement = document.getElementById("editPengalamanKerjaModal");

  if (editModalElement) {
    const editPraktisiForm = document.getElementById("editPraktisiForm");

    const setFileText = (elementId, filePath) => {
      const element = document.getElementById(elementId);
      if (element) {
        if (filePath) {
          const fileName = filePath.split("/").pop();
          element.textContent = `File lama: ${fileName}`;
        } else {
          element.textContent = "File lama: Tidak ada";
        }
      }
    };

    editModalElement.addEventListener("show.bs.modal", function (event) {
      const button = event.relatedTarget;
      const url = button.getAttribute("data-url");
      const updateUrl = button.getAttribute("data-update-url");

      editPraktisiForm.setAttribute("action", updateUrl);

      fetch(url)
        .then((response) => {
          if (!response.ok) throw new Error("Respon jaringan bermasalah.");
          return response.json();
        })
        .then((data) => {
          document.getElementById("edit-pegawai_id").value = data.pegawai_id;
          document.getElementById("edit-bidang_usaha").value = data.bidang_usaha;
          document.getElementById("edit-jenis_pekerjaan").value = data.jenis_pekerjaan;
          document.getElementById("edit-jabatan").value = data.jabatan;
          document.getElementById("edit-instansi").value = data.instansi;
          document.getElementById("edit-divisi").value = data.divisi;
          document.getElementById("edit-deskripsi_kerja").value = data.deskripsi_kerja;
          document.getElementById("edit-tmt").value = data.tmt;
          document.getElementById("edit-tst").value = data.tst;
          document.getElementById("edit-area_pekerjaan").value = data.area_pekerjaan;
          document.getElementById("edit-kategori_pekerjaan").value = data.kategori_pekerjaan;

          setFileText("edit-file-surat_ipb", data.surat_ipb);
          setFileText("edit-file-surat_instansi", data.surat_instansi);
          setFileText("edit-file-cv", data.cv);
          setFileText("edit-file-profil_perusahaan", data.profil_perusahaan);
        })
        .catch((error) => {
          console.error("Error:", error);
          alert("Gagal memuat data edit.");
          bootstrap.Modal.getInstance(editModalElement).hide();
        });
    });

    editModalElement.addEventListener("hidden.bs.modal", function () {
      editPraktisiForm.reset();
      editPraktisiForm.setAttribute("action", "#");

      setFileText("edit-file-surat_ipb", null);
      setFileText("edit-file-surat_instansi", null);
      setFileText("edit-file-cv", null);
      setFileText("edit-file-profil_perusahaan", null);
    });
  }

  /**
   * ================================================================
   * BAGIAN 3: MODAL DETAIL DATA
   * ================================================================
   */
  const detailModalElement = document.getElementById("detailPraktisiModal");

  if (detailModalElement) {
    const formatDate = (dateString) => {
      if (!dateString) return "-";
      const options = { day: "numeric", month: "long", year: "numeric" };
      return new Date(dateString).toLocaleDateString("id-ID", options);
    };

    const setDetailText = (elementId, text) => {
      const element = document.getElementById(elementId);
      if (element) element.textContent = text || "-";
    };

    const updateDokumenDetail = (buttonId, noDataId, filePath) => {
      const button = document.getElementById(buttonId);
      const noDataSpan = document.getElementById(noDataId);

      if (button && noDataSpan) {
        if (filePath) {
          button.href = `${window.location.origin}/storage/${filePath}`;
          button.style.display = "inline-block";
          noDataSpan.style.display = "none";
        } else {
          button.style.display = "none";
          noDataSpan.style.display = "inline";
        }
      }
    };

    detailModalElement.addEventListener("show.bs.modal", function (event) {
      const button = event.relatedTarget;
      const url = button.getAttribute("data-url");

      fetch(url)
        .then((response) => {
          if (!response.ok) throw new Error("Gagal mengambil data detail.");
          return response.json();
        })
        .then((data) => {
          setDetailText("detail-nama", data.pegawai ? data.pegawai.nama_lengkap : "Tidak Ditemukan");
          setDetailText("detail-bidang", data.bidang_usaha);
          setDetailText("detail-jenis", data.jenis_pekerjaan);
          setDetailText("detail-jabatan", data.jabatan);
          setDetailText("detail-instansi", data.instansi);
          setDetailText("detail-divisi", data.divisi);
          setDetailText("detail-deskripsi", data.deskripsi_kerja);
          setDetailText("detail-mulai", formatDate(data.tmt));
          setDetailText("detail-selesai", formatDate(data.tst));
          setDetailText("detail-area", data.area_pekerjaan);
          setDetailText("detail-kategori", data.kategori_pekerjaan);

          updateDokumenDetail("detail-surat-ipb", "nodata-surat-ipb", data.surat_ipb);
          updateDokumenDetail("detail-surat-instansi", "nodata-surat-instansi", data.surat_instansi);
          updateDokumenDetail("detail-cv", "nodata-cv", data.cv);
          updateDokumenDetail("detail-profil", "nodata-profil", data.profil_perusahaan);
        })
        .catch((error) => {
          console.error("Error:", error);
          alert("Gagal memuat data detail.");
          bootstrap.Modal.getInstance(detailModalElement).hide();
        });
    });
  }

  /**
   * ================================================================
   * BAGIAN 4: KONFIRMASI HAPUS DATA
   * ================================================================
   */
  const modalKonfirmasiHapus = document.getElementById("modalKonfirmasiHapus");

  if (modalKonfirmasiHapus) {
    const btnKonfirmasiHapus = document.getElementById("btnKonfirmasiHapus");
    const btnBatalHapus = document.getElementById("btnBatalHapus");
    let deleteUrl = null;

    document.body.addEventListener("click", function (event) {
      const deleteButton = event.target.closest(".btn-hapus-data");
      if (deleteButton) {
        event.preventDefault();
        deleteUrl = deleteButton.dataset.url;
        modalKonfirmasiHapus.classList.add("show");
      }
    });

    const hideDeleteModal = () => {
      modalKonfirmasiHapus.classList.remove("show");
      deleteUrl = null;
    };

    btnKonfirmasiHapus.addEventListener("click", function () {
      if (!deleteUrl) return;

      fetch(deleteUrl, {
        method: "DELETE",
        headers: {
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        },
      })
        .then((response) => {
          if (response.ok || response.redirected) {
            window.location.reload();
          } else {
            alert("Gagal menghapus data di server.");
            hideDeleteModal();
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          alert("Tidak dapat terhubung ke server.");
          hideDeleteModal();
        });
    });

    btnBatalHapus.addEventListener("click", hideDeleteModal);
  }

  /**
   * ================================================================
   * BAGIAN 5: KONFIRMASI VERIFIKASI
   * ================================================================
   */
  const modalVerifikasi = document.getElementById("modalKonfirmasiVerifikasi");

  if (modalVerifikasi) {
    const btnTerima = document.getElementById("popupBtnTerima");
    const btnTolak = document.getElementById("popupBtnTolak");
    const btnKembali = document.getElementById("popupBtnKembali");
    let verificationUrl = null;

    document.body.addEventListener("click", function (event) {
      const verifyButton = event.target.closest(".btn-verifikasi");
      if (verifyButton) {
        event.preventDefault();
        verificationUrl = verifyButton.dataset.url;
        modalVerifikasi.classList.add("show");
      }
    });

    const hideVerifyModal = () => {
      modalVerifikasi.classList.remove("show");
      verificationUrl = null;
    };

    const handleVerification = (status) => {
      if (!verificationUrl) return;

      fetch(verificationUrl, {
        method: "PATCH",
        headers: {
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify({ status }),
      })
        .then((response) => {
          if (response.ok || response.redirected) {
            window.location.reload();
          } else {
            alert("Gagal memperbarui status.");
            hideVerifyModal();
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          alert("Tidak dapat terhubung ke server.");
          hideVerifyModal();
        });
    };

    btnTerima.addEventListener("click", () => handleVerification("Sudah Diverifikasi"));
    btnTolak.addEventListener("click", () => handleVerification("Ditolak"));
    btnKembali.addEventListener("click", hideVerifyModal);
  }

  /**
   * ================================================================
   * BAGIAN 6: FILTER DAN PENCARIAN
   * ================================================================
   */
  const searchInput = document.getElementById("searchInput");
  const semesterFilter = document.getElementById("semesterFilter");
  const statusFilter = document.getElementById("statusFilter");

  if (searchInput && semesterFilter && statusFilter) {
    const applyFilters = () => {
      const params = new URLSearchParams();

      if (searchInput.value) params.append("search", searchInput.value);
      if (semesterFilter.value) params.append("semester", semesterFilter.value);
      if (statusFilter.value) params.append("status", statusFilter.value);

      const queryString = params.toString();
      const newUrl = window.location.pathname + (queryString ? "?" + queryString : "");
      window.location.href = newUrl;
    };

    semesterFilter.addEventListener("change", applyFilters);
    statusFilter.addEventListener("change", applyFilters);

    searchInput.addEventListener("keyup", function (event) {
      if (event.key === "Enter") applyFilters();
    });
  }

  /**
   * ================================================================
   * BAGIAN 7: DATE PICKER + ERROR VALIDASI
   * ================================================================
   */
  document.querySelectorAll('input[type="date"]').forEach((el) => {
    el.style.cursor = "pointer";
    el.addEventListener("click", function () {
      this.showPicker && this.showPicker();
    });
  });

  if (document.querySelector("meta[name='csrf-token']")) {
    if (window.LaravelErrors && window.LaravelErrors.length > 0) {
      const errorModalElement = document.getElementById("pengalamanKerjaModal");
      if (errorModalElement) {
        const errorModal = new bootstrap.Modal(errorModalElement);
        errorModal.show();
      }
    }
  }
  
    /**
   * ================================================================
   * BAGIAN 8: TUTUP MODAL JIKA KLIK DI LUAR
   * ================================================================
   */
  function enableOutsideClickClose(modalElement, hideCallback) {
    if (!modalElement) return;
    modalElement.addEventListener("click", function (event) {
      // cek apakah klik tepat di overlay, bukan di dalam konten
      if (event.target === modalElement) {
        hideCallback();
      }
    });
  }

  // Modal custom (bukan bootstrap bawaan)
  if (modalKonfirmasiHapus) {
    enableOutsideClickClose(modalKonfirmasiHapus, () => {
      modalKonfirmasiHapus.classList.remove("show");
    });
  }

  if (modalVerifikasi) {
    enableOutsideClickClose(modalVerifikasi, () => {
      modalVerifikasi.classList.remove("show");
    });
  }

  const successModalOverlay = document.getElementById("modalBerhasil");
  if (successModalOverlay) {
    enableOutsideClickClose(successModalOverlay, () => {
      successModalOverlay.style.display = "none";
    });
  }

  // Modal bootstrap (edit & detail)
  if (editModalElement) {
    enableOutsideClickClose(editModalElement, () => {
      bootstrap.Modal.getInstance(editModalElement)?.hide();
    });
  }

  if (detailModalElement) {
    enableOutsideClickClose(detailModalElement, () => {
      bootstrap.Modal.getInstance(detailModalElement)?.hide();
    });
  }
  /**
   * ================================================================
   * BAGIAN 8: TUTUP MODAL JIKA KLIK DI LUAR
   * ================================================================
   */
  function enableOutsideClickClose(modalElement, hideCallback) {
    if (!modalElement) return;
    modalElement.addEventListener("click", function (event) {
      // cek apakah klik tepat di overlay, bukan di dalam konten
      if (event.target === modalElement) {
        hideCallback();
      }
    });
  }

  // Modal custom (bukan bootstrap bawaan)
  if (modalKonfirmasiHapus) {
    enableOutsideClickClose(modalKonfirmasiHapus, () => {
      modalKonfirmasiHapus.classList.remove("show");
    });
  }

  if (modalVerifikasi) {
    enableOutsideClickClose(modalVerifikasi, () => {
      modalVerifikasi.classList.remove("show");
    });
  }

  // Modal bootstrap (edit & detail)
  if (editModalElement) {
    enableOutsideClickClose(editModalElement, () => {
      bootstrap.Modal.getInstance(editModalElement)?.hide();
    });
  }

  if (detailModalElement) {
    enableOutsideClickClose(detailModalElement, () => {
      bootstrap.Modal.getInstance(detailModalElement)?.hide();
    });
  }
});