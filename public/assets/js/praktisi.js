document.addEventListener("DOMContentLoaded", function () {
  // == Modal Notifikasi Sukses ==
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
        setTimeout(() => successAudio.play().catch(e => console.error("Gagal memutar audio:", e)), 150);
      }

      setTimeout(() => successModalOverlay.style.display = "none", 2000);

      if (!closeButton.dataset.listenerAttached) {
        closeButton.addEventListener("click", () => successModalOverlay.style.display = "none");
        closeButton.dataset.listenerAttached = "true";
      }
    }
  }

  const flashSuccessMeta = document.querySelector('meta[name="flash-success"]');
  if (flashSuccessMeta && flashSuccessMeta.getAttribute("content")) showSuccessModal();

   // == Select2 ==
  const selectsInModal = {
    "#pegawai_id": "-- Pilih Pegawai --",
    "#bidang_usaha": "-- Pilih Bidang Usaha --"
  };

  Object.entries(selectsInModal).forEach(([selector, placeholderText]) => {
    const el = $(selector);
    if (el.length) {
      el.select2({
        theme: "bootstrap-5",
        placeholder: placeholderText,
        dropdownParent: $("#pengalamanKerjaModal .modal-content"),
        allowClear: true,
        width: '100%'
      });
    }
  });

  const selectsInEditModal = {
    "#edit-pegawai_id": "-- Pilih Pegawai --",
    "#edit-bidang_usaha": "-- Pilih Bidang Usaha --"
  };

  Object.entries(selectsInEditModal).forEach(([selector, placeholderText]) => {
    const el = $(selector);
    if (el.length) {
      el.select2({
        theme: "bootstrap-5",
        placeholder: placeholderText,
        dropdownParent: $("#editPengalamanKerjaModal .modal-content"),
        allowClear: true,
        width: '100%'
      });
    }
  });

  // == Modal Tambah ==
  const tambahModalElement = $("#pengalamanKerjaModal");
  if (tambahModalElement.length) {
    const tambahForm = tambahModalElement.find("form");
    const submitBtn = tambahForm.find('button[type="submit"]');

    tambahForm.on("submit", function () {
      const originalText = submitBtn.html();
      submitBtn.prop("disabled", true)
        .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...');
      setTimeout(() => submitBtn.html(originalText).prop("disabled", false), 3000); // fallback
    });

    tambahModalElement.on("hidden.bs.modal", function () {
      $(this).find("form")[0].reset();
      Object.keys(selectsInModal).forEach(selector => {
        const el = $(selector);
        if (el.length) el.val(null).trigger("change");
      });
    });
  }

  // == Modal Edit ==
  const editModalElement = document.getElementById("editPengalamanKerjaModal");
  if (editModalElement) {
    const editPraktisiForm = document.getElementById("editPraktisiForm");
    const editSubmitBtn = editPraktisiForm.querySelector('button[type="submit"]');

    editPraktisiForm.addEventListener("submit", function () {
      const originalText = editSubmitBtn.innerHTML;
      editSubmitBtn.disabled = true;
      editSubmitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';
      setTimeout(() => {
        editSubmitBtn.innerHTML = originalText;
        editSubmitBtn.disabled = false;
      }, 3000); // fallback
    });

    const setFileText = (elementId, filePath) => {
      const element = document.getElementById(elementId);
      if (element)
        element.textContent = filePath
          ? `File lama: ${filePath.split("/").pop()}`
          : "File lama: Tidak ada";
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
          [
            "jenis_pekerjaan",
            "jabatan",
            "instansi",
            "divisi",
            "deskripsi_kerja",
            "tmt",
            "tst",
            "area_pekerjaan",
            "kategori_pekerjaan",
          ].forEach(
            (id) => (document.getElementById(`edit-${id}`).value = data[id])
          );

          const pegawaiSelect = $("#edit-pegawai_id");
          const bidangSelect = $("#edit-bidang_usaha");
          pegawaiSelect.val(data.pegawai_id).trigger("change");
          bidangSelect.val(data.bidang_usaha).trigger("change");

          ["surat_ipb", "surat_instansi", "cv", "profil_perusahaan"].forEach(
            (file) => setFileText(`edit-file-${file}`, data[file])
          );
        })
        .catch((error) => {
          console.error("Error:", error);
          alert("Gagal memuat data edit.");
          bootstrap.Modal.getInstance(editModalElement).hide();
        });
    });
  }

  // == Modal Detail Data ==
  const detailModalElement = document.getElementById("detailPraktisiModal");
  if (detailModalElement) {
    const formatDate = dateString => dateString ? new Date(dateString).toLocaleDateString("id-ID", { day: "numeric", month: "long", year: "numeric" }) : "-";
    const setDetailText = (id, text) => { const el = document.getElementById(id); if (el) el.textContent = text || "-"; };
    const updateDokumenDetail = (buttonId, noDataId, filePath) => {
      const btn = document.getElementById(buttonId);
      const noData = document.getElementById(noDataId);
      if (btn && noData) {
        if (filePath) {
          btn.href = `${window.location.origin}/storage/${filePath}`;
          btn.style.display = "inline-block";
          noData.style.display = "none";
        } else {
          btn.style.display = "none";
          noData.style.display = "inline";
        }
      }
    };

    detailModalElement.addEventListener("show.bs.modal", function (event) {
      const button = event.relatedTarget;
      const url = button.getAttribute("data-url");

      fetch(url)
        .then(response => { if (!response.ok) throw new Error("Gagal mengambil data detail."); return response.json(); })
        .then(data => {
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
        .catch(error => { console.error("Error:", error); alert("Gagal memuat data detail."); bootstrap.Modal.getInstance(detailModalElement).hide(); });
    });
  }

  // == Modal Konfirmasi Hapus ==
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

      const originalText = btnKonfirmasiHapus.innerHTML;
      btnKonfirmasiHapus.disabled = true;
      btnKonfirmasiHapus.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menghapus...';

      fetch(deleteUrl, {
        method: "DELETE",
        headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content") }
      })
        .then(async response => {
          if (response.ok || response.redirected) {
            window.location.reload();
          } else {
            const text = await response.text();
            console.error("Server Response:", text);
            alert("Gagal menghapus data di server. Periksa log server atau koneksi.");
            btnKonfirmasiHapus.innerHTML = originalText;
            btnKonfirmasiHapus.disabled = false;
            hideDeleteModal();
          }
        })
        .catch(error => {
          console.error("Error:", error);
          alert("Tidak dapat terhubung ke server.");
          btnKonfirmasiHapus.innerHTML = originalText;
          btnKonfirmasiHapus.disabled = false;
          hideDeleteModal();
        });
    });

    btnBatalHapus.addEventListener("click", hideDeleteModal);
  }

  // == Modal Konfirmasi Verifikasi ==
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

    const hideVerifyModal = () => { modalVerifikasi.classList.remove("show"); verificationUrl = null; };
    const handleVerification = (status) => {
      if (!verificationUrl) return;
      fetch(verificationUrl, {
        method: "PATCH",
        headers: {
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
          "Content-Type": "application/json",
          Accept: "application/json"
        },
        body: JSON.stringify({ status })
      })
        .then(response => {
          if (response.ok || response.redirected) window.location.reload();
          else { alert("Gagal memperbarui status."); hideVerifyModal(); }
        })
        .catch(error => { console.error("Error:", error); alert("Tidak dapat terhubung ke server."); hideVerifyModal(); });
    };

    btnTerima.addEventListener("click", () => handleVerification("Sudah Diverifikasi"));
    btnTolak.addEventListener("click", () => handleVerification("Ditolak"));
    btnKembali.addEventListener("click", hideVerifyModal);
  }

  // == Filter dan Pendarian =
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
      window.location.href = window.location.pathname + (queryString ? "?" + queryString : "");
    };

    semesterFilter.addEventListener("change", applyFilters);
    statusFilter.addEventListener("change", applyFilters);
    searchInput.addEventListener("keyup", event => { if (event.key === "Enter") applyFilters(); });
  }

  // == Date Picker ==
  document.querySelectorAll('input[type="date"]').forEach(el => { el.style.cursor = "pointer"; el.addEventListener("click", () => el.showPicker && el.showPicker()); });

  if (document.querySelector("meta[name='csrf-token']") && window.LaravelErrors && window.LaravelErrors.length > 0) {
    const errorModalElement = document.getElementById("pengalamanKerjaModal");
    if (errorModalElement) new bootstrap.Modal(errorModalElement).show();
  }

  // == Tutup Modal ==
  function enableOutsideClickClose(modalElement, hideCallback) {
    if (!modalElement) return;
    modalElement.addEventListener("click", event => { if (event.target === modalElement) hideCallback(); });
  }

  if (modalKonfirmasiHapus) enableOutsideClickClose(modalKonfirmasiHapus, () => modalKonfirmasiHapus.classList.remove("show"));
  if (modalVerifikasi) enableOutsideClickClose(modalVerifikasi, () => modalVerifikasi.classList.remove("show"));
  if (document.getElementById("modalBerhasil")) enableOutsideClickClose(document.getElementById("modalBerhasil"), () => document.getElementById("modalBerhasil").style.display = "none");
  if (editModalElement) enableOutsideClickClose(editModalElement, () => bootstrap.Modal.getInstance(editModalElement)?.hide());
  if (detailModalElement) enableOutsideClickClose(detailModalElement, () => bootstrap.Modal.getInstance(detailModalElement)?.hide());
});