document.addEventListener("DOMContentLoaded", () => {
  // == Data Jenis Dokumen ==
  const jenisDokumenData = {
    biodata: [
      "Pas Foto", "KTP", "NPWP", "Kartu Pegawai (Karpeg)", "Kartu Keluarga (KK)",
      "KTP Suami/Istri", "BPJS Pribadi", "BPJS Suami/Istri", "BPJS Anak 1", "BPJS Anak 2",
      "KP4 (Keterangan Tanggungan Keluarga)", "Akta Kelahiran", "Buku Nikah", "Kartu Suami/Istri", "Paspor"
    ],
    pendidikan: [
      "Ijazah SD", "Ijazah SMP", "Ijazah S1", "Transkrip Nilai S1", "Ijazah S2", "Transkrip Nilai S2",
      "Ijazah S3", "Transkrip Nilai S3", "Penyetaraan Ijazah S1", "Penyetaraan Ijazah S2", "Penyetaraan Ijazah S3",
      "Ijazah Profesi", "Transkrip Profesi", "Ijazah D3", "Transkrip Nilai D3", "Ijazah D4", "Transkrip Nilai D4",
      "Ijazah SLTA (SMA/SMK/MA)", "Surat Tugas Belajar", "Surat Penyesuaian Ijazah", "Surat Tanda Lulus Ujian Pencantuman Gelar"
    ],
    jf: [
      "SK Asisten Ahli", "SK Lektor", "SK Lektor Kepala", "SK Guru Besar", "PAK Terakhir (Penetapan Angka Kredit)",
      "PAK Integrasi", "PAK Konversi", "SK Inpassing Jabfung", "Sertifikasi Dosen",
      "Sertifikat TOEP (Test of English Proficiency)", "Sertifikat TKDA (Tes Kemampuan Dasar Akademik)",
      "Surat Pernyataan Menduduki Jabatan", "SK Pembebasan Sementara dari Jabfung",
      "SK Pemberhentian dari Jabfung", "SK Penugasan Jabfung", "SK Perpanjangan Jabfung",
      "BAP Sumpah Jabatan Fungsional Dosen"
    ],
    sk: [
      "SK CPNS", "SK PNS", "SK PPPK", "SK Calon Dosen Tetap", "SK Dosen Tetap", "SK Pegawai Tetap",
      "SK Jabatan Fungsional Terakhir", "SK Kenaikan Gaji Berkala", "SK Penugasan", "SK Perpanjangan Penugasan",
      "SK Tugas Belajar", "SK Pemberian Tunjangan Tugas Belajar", "SK Perbaikan Data Kepegawaian",
      "SK Pemberhentian", "SK Pensiun"
    ],
    sp: [
      "Surat Tugas Khusus", "STTPL", "Sertifikat Sertifikasi Dosen", "Surat Pernyataan Melaksanakan Tugas (SPMT)",
      "Surat Pernyataan Menduduki Jabatan", "Berita Acara Sumpah PNS", "Berita Acara Sumpah Dosen Tetap",
      "Berita Acara Sumpah Jabfung", "Berita Acara Pelantikan", "Surat Keterangan Dosen Tetap",
      "Surat Keterangan Aktif Mengajar", "Perjanjian Kerja", "Surat Pencantuman Gelar",
      "Surat Usulan Pengaktifan Kembali", "SK Perjanjian Beasiswa"
    ],
    lain: [
      "Asuransi Komersil", "Rekening Bank", "Sertifikat Pelatihan Tridharma", "Sertifikat Uji Kompetensi Jabfung",
      "Satyalencana Karya Satya", "Analisis Kepegawaian Pertama", "Analisis Kepegawaian Muda",
      "Analisis Kepegawaian Madya", "SK Pembimbing Skripsi/Tesis/Disertasi",
      "Surat Tugas Reviewer Jurnal", "Surat Tugas Mengajar"
    ]
  };

  // == Tab Utama ==
  const initMainTabs = () => {
    const mainTabNav = document.getElementById("main-tab-nav");
    if (!mainTabNav) return;

    mainTabNav.addEventListener("click", (e) => {
      if (e.target.matches("button.nav-link")) {
        document.querySelectorAll(".main-tab-nav .nav-link").forEach((tab) => tab.classList.remove("active"));
        document.querySelectorAll(".main-tab-content").forEach((content) => (content.style.display = "none"));

        e.target.classList.add("active");
        const contentEl = document.getElementById(`${e.target.dataset.mainTab}-content`);
        if (contentEl) contentEl.style.display = "block";
      }
    });
  };

  // == Sub-Tab Biodata ==
  const initBiodataSubTabs = () => {
    const biodataTabs = document.querySelector("#biodata-sub-tabs");
    if (!biodataTabs) return;

    biodataTabs.addEventListener("click", (e) => {
      if (e.target.matches("button")) {
        const parentContent = biodataTabs.closest(".main-tab-content");
        if (!parentContent) return;

        biodataTabs.querySelectorAll("button").forEach((btn) => btn.classList.remove("active"));
        e.target.classList.add("active");

        parentContent.querySelectorAll(".sub-tab-content").forEach((content) => (content.style.display = "none"));
        const contentEl = parentContent.querySelector(`#${e.target.dataset.tab}`);
        if (contentEl) contentEl.style.display = "block";
      }
    });
  };

  // == Dokumen Dinamis ==
  const updateNomor = () => {
    document.querySelectorAll("#dokumen-wrapper .dokumen-item").forEach((item, index) => {
      const nomor = item.querySelector(".nomor-dokumen");
      const btnHapus = item.querySelector(".btn-hapus");
      if (nomor) nomor.textContent = `No. ${index + 1}`;
      if (btnHapus) btnHapus.style.display = index === 0 ? "none" : "block";
    });
  };

  const initDynamicDokumen = () => {
    const addBtn = document.getElementById("add-dokumen");
    const dokumenWrapper = document.getElementById("dokumen-wrapper");
    if (!addBtn || !dokumenWrapper) return;

    addBtn.addEventListener("click", () => {
      const clone = dokumenWrapper.firstElementChild.cloneNode(true);
      clone.querySelectorAll("input, select").forEach((el) => {
        if (el.tagName.toLowerCase() === "select") {
          el.selectedIndex = 0;
        } else {
          el.value = "";
        }
      });
      dokumenWrapper.appendChild(clone);
      updateNomor();
    });

    dokumenWrapper.addEventListener("click", (e) => {
      if (e.target.classList.contains("btn-hapus")) {
        if (dokumenWrapper.querySelectorAll(".dokumen-item").length > 1) {
          e.target.closest(".dokumen-item").remove();
          updateNomor();
        } else {
          alert("Minimal 1 dokumen harus ada.");
        }
      }
    });
  };

  // == Drag & Drop File ==
  const initDragAndDrop = () => {
    document.addEventListener("dragover", (e) => {
      if (e.target.classList.contains("upload-box")) {
        e.preventDefault();
        e.target.classList.add("dragover");
      }
    });

    document.addEventListener("dragleave", (e) => {
      if (e.target.classList.contains("upload-box")) {
        e.target.classList.remove("dragover");
      }
    });

    document.addEventListener("drop", (e) => {
      if (e.target.classList.contains("upload-box")) {
        e.preventDefault();
        e.target.classList.remove("dragover");
        const fileInput = e.target.querySelector('input[type="file"]');
        if (fileInput) fileInput.files = e.dataTransfer.files;
      }
    });
  };

  // == Kategori dan Jenis Dokumen ==
  const initKategoriJenisDokumen = () => {
    const kategoriSelect = document.getElementById("kategori");
    const jenisSelect = document.getElementById("jenis-dokumen");
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

  // == Inisialisasi Semua ==
  initMainTabs();
  initBiodataSubTabs();
  initDynamicDokumen();
  initDragAndDrop();
  initKategoriJenisDokumen();
  updateNomor();
});