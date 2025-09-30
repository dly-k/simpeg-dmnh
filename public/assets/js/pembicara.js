document.addEventListener("DOMContentLoaded", function () {
  /**
   * ===================================================================
   * [PENAMBAHAN] Notifikasi Sukses (Modal & Suara)
   * Menangkap pesan flash dari server dan menampilkan modal konfirmasi.
   * ===================================================================
   */
const handleSuccessNotification = () => {
    const successMessage = document.querySelector('meta[name="flash-success"]')?.getAttribute('content');

    if (successMessage) {
      const modalBerhasil = document.getElementById('modalBerhasil');
      if (modalBerhasil) {
        document.getElementById('berhasil-title').textContent = 'Berhasil!';
        document.getElementById('berhasil-subtitle').textContent = successMessage;
        
        modalBerhasil.classList.add('show');

        const successSound = new Audio('/assets/sounds/Success.mp3');
        successSound.play().catch(error => console.error("Gagal memutar suara:", error));

        // [PENAMBAHAN] Sembunyikan modal secara otomatis setelah 1 detik
        setTimeout(() => {
          modalBerhasil.classList.remove('show');
        }, 1000); // 1000 milidetik = 1 detik

        document.getElementById('btnSelesai').addEventListener('click', () => {
          modalBerhasil.classList.remove('show');
        });
      }
    }
  };
  /**
   * ===================================================================
   * Utility: Validasi Ukuran File
   * ===================================================================
   */
  function validateFileSize(input) {
    if (input.files.length > 0) {
      const file = input.files[0];
      if (file.size > 5 * 1024 * 1024) { // 5MB
        alert("Ukuran file maksimal 5MB!");
        input.value = "";
      }
    }
  }

  function initFileValidation(input) {
    input.addEventListener("change", function () {
      validateFileSize(this);
    });
  }

  /**
   * ===================================================================
   * Dynamic Dokumen (Tambah & Hapus)
   * ===================================================================
   */
  function createDokumenItem(index) {
    const item = document.createElement("div");
    item.classList.add("dokumen-item", "border", "rounded", "p-3", "mb-3", "position-relative");
    item.innerHTML = `
      <button type="button" class="btn-close position-absolute top-0 end-0 m-2 removeDokumen" aria-label="Close"></button>
      <div class="row g-2">
        <div class="col-12">
          <label class="form-label">Jenis Dokumen</label>
          <select name="dokumen[${index}][jenis]" class="form-select">
            <option value="" disabled selected>-- Pilih Jenis Dokumen --</option>
            <option value="Transkrip">Transkrip</option>
            <option value="Surat Tugas">Surat Tugas</option>
            <option value="SK">SK</option>
            <option value="Sertifikat">Sertifikat</option>
            <option value="Penyetaraan Ijazah">Penyetaraan Ijazah</option>
            <option value="Laporan Kegiatan">Laporan Kegiatan</option>
            <option value="Ijazah">Ijazah</option>
            <option value="Buku / Bahan Ajar">Buku / Bahan Ajar</option>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label">Nama Dokumen</label>
          <input type="text" name="dokumen[${index}][nama]" class="form-control" placeholder="Nama Dokumen">
        </div>
        <div class="col-md-4">
          <label class="form-label">Nomor</label>
          <input type="text" name="dokumen[${index}][nomor]" class="form-control" placeholder="Nomor">
        </div>
        <div class="col-md-4">
          <label class="form-label">Tautan</label>
          <input type="url" name="dokumen[${index}][tautan]" class="form-control" placeholder="https://...">
        </div>
        <div class="col-12">
          <label class="form-label">File <small class="text-muted">(Maksimal Ukuran File 5MB)</small></label>
          <input type="file" name="dokumen[${index}][file]" class="form-control file-input"
            accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.txt">
        </div>
      </div>
    `;
    initFileValidation(item.querySelector(".file-input"));
    return item;
  }

  function initDokumenHandler(wrapperId, addBtnId) {
    const wrapper = document.getElementById(wrapperId);
    const addBtn = document.getElementById(addBtnId);

    if (!wrapper || !addBtn) return;

    addBtn.addEventListener("click", function () {
      // [PERBAIKAN] Hitung indeks berikutnya berdasarkan item yang sudah ada di wrapper ini saja.
      const nextIndex = wrapper.querySelectorAll(".dokumen-item").length;
      const newItem = createDokumenItem(nextIndex);
      wrapper.appendChild(newItem);
    });

    wrapper.addEventListener("click", function (e) {
      if (e.target.closest(".removeDokumen")) {
        e.target.closest(".dokumen-item").remove();
      }
    });

    wrapper.querySelectorAll(".file-input").forEach(initFileValidation);
  }

  /**
   * ===================================================================
   * Toggle Input "Lainnya"
   * ===================================================================
   */
  function initToggleLainnya(selectId, inputId) {
    const select = document.getElementById(selectId);
    const input = document.getElementById(inputId);

    if (!select || !input) return;

    select.addEventListener("change", function () {
      if (this.value === "lainnya") {
        input.classList.remove("d-none");
        input.required = true;
      } else {
        input.classList.add("d-none");
        input.required = false;
        input.value = "";
      }
    });
  }

  /**
   * ===================================================================
   * Detail Pembicara Modal
   * ===================================================================
   */
  function setDetailText(id, value) {
    const el = document.getElementById(id);
    if (el) el.textContent = value || "-";
  }

  function setDetailFile(linkId, noDataId, url) {
    const link = document.getElementById(linkId);
    const noData = document.getElementById(noDataId);
    if (!link || !noData) return;

    if (url) {
      link.href = url;
      link.style.display = "inline-block";
      noData.style.display = "none";
    } else {
      link.style.display = "none";
      noData.style.display = "inline-block";
    }
  }
  
  document.querySelectorAll(".btn-detail-pembicara").forEach(btn => {
    btn.addEventListener("click", function () {
      setDetailText("detail-nama", this.dataset.nama);
      setDetailText("detail-kegiatan", this.dataset.kegiatan);
      setDetailText("detail-capaian", this.dataset.capaian);
      setDetailText("detail-kategori-pembicara", this.dataset.kategori);
      setDetailText("detail-makalah", this.dataset.makalah);
      setDetailText("detail-pertemuan", this.dataset.pertemuan);
      setDetailText("detail-tanggal", this.dataset.tanggal);
      setDetailText("detail-penyelenggara", this.dataset.penyelenggara);
      setDetailText("detail-tingkat", this.dataset.tingkat);
      setDetailText("detail-bahasa", this.dataset.bahasa);
      setDetailText("detail-litabmas", this.dataset.litabmas);

      setDetailFile("detail-sertifikat", "nodata-sertifikat", this.dataset.sertifikat);
      setDetailFile("detail-sk", "nodata-sk", this.dataset.sk);

      new bootstrap.Modal(document.getElementById("detailPembicaraModal")).show();
    });
  });

  /**
   * ===================================================================
   * Inisialisasi semua fungsi saat halaman dimuat
   * ===================================================================
   */
  handleSuccessNotification();
  initDokumenHandler("dokumenWrapper", "addDokumen");
  initDokumenHandler("editDokumenWrapper", "addEditDokumen");
  initToggleLainnya("kegiatan", "kegiatan_lainnya");
  initToggleLainnya("kategori_capaian", "kategori_capaian_lainnya");
  initToggleLainnya("edit_kegiatan", "edit_kegiatan_lainnya");
  initToggleLainnya("edit_kategori_capaian", "edit_kategori_capaian_lainnya");
});
