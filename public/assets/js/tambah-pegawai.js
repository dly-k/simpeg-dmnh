document.addEventListener('DOMContentLoaded', function () {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const toggleSidebarBtn = document.getElementById('toggleSidebar');

  /* ==============================
   *  SIDEBAR TOGGLE
   * ============================== */
  if (toggleSidebarBtn && sidebar && overlay) {
    toggleSidebarBtn.addEventListener('click', function () {
      const isMobile = window.innerWidth <= 991;
      if (isMobile) {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show', sidebar.classList.contains('show'));
      } else {
        sidebar.classList.toggle('hidden');
      }
    });

    overlay.addEventListener('click', function () {
      sidebar.classList.remove('show');
      overlay.classList.remove('show');
    });
  }

  /* ==============================
   *  TANGGAL & JAM REALTIME
   * ============================== */
  function updateDateTime() {
    const now = new Date();
    const dateEl = document.getElementById('current-date');
    const timeEl = document.getElementById('current-time');

    if (dateEl) {
      dateEl.textContent = now.toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
    }

    if (timeEl) {
      timeEl.textContent = now.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
      }).replace(/\./g, ':');
    }
  }
  updateDateTime();
  setInterval(updateDateTime, 1000);

  /* ==============================
   *  TAB UTAMA
   * ============================== */
  const mainTabNav = document.getElementById('main-tab-nav');
  if (mainTabNav) {
    mainTabNav.addEventListener('click', function (e) {
      if (e.target.matches('button.nav-link')) {
        document.querySelectorAll('.main-tab-nav .nav-link').forEach(tab => tab.classList.remove('active'));
        document.querySelectorAll('.main-tab-content').forEach(content => content.style.display = 'none');

        e.target.classList.add('active');
        const contentEl = document.getElementById(`${e.target.dataset.mainTab}-content`);
        if (contentEl) contentEl.style.display = 'block';
      }
    });
  }

  /* =================
   *  SUB-TAB BIODATA
   * ================= */
  const biodataTabs = document.querySelector('#biodata-sub-tabs');
  if (biodataTabs) {
    biodataTabs.addEventListener('click', function (e) {
      if (e.target.matches('button')) {
        const parentContent = this.closest('.main-tab-content');
        if (!parentContent) return;

        this.querySelectorAll('button').forEach(btn => btn.classList.remove('active'));
        e.target.classList.add('active');

        parentContent.querySelectorAll('.sub-tab-content').forEach(content => content.style.display = 'none');
        const contentEl = parentContent.querySelector(`#${e.target.dataset.tab}`);
        if (contentEl) contentEl.style.display = 'block';
      }
    });
  }

  /* ==============================
   *  E-FILE: NOMOR, TAMBAH, HAPUS
   * ============================== */
  function updateNomor() {
    document.querySelectorAll('#dokumen-wrapper .dokumen-item').forEach((item, index) => {
      const nomor = item.querySelector('.nomor-dokumen');
      const btnHapus = item.querySelector('.btn-hapus');
      if (nomor) nomor.textContent = `No. ${index + 1}`;
      if (btnHapus) btnHapus.style.display = (index === 0) ? 'none' : 'block';
    });
  }

  const addBtn = document.getElementById('add-dokumen');
  const dokumenWrapper = document.getElementById('dokumen-wrapper');

  if (addBtn && dokumenWrapper) {
    addBtn.addEventListener('click', function () {
      const clone = dokumenWrapper.firstElementChild.cloneNode(true);
      clone.querySelectorAll('input, select').forEach(el => {
        if (el.tagName.toLowerCase() === 'select') {
          el.selectedIndex = 0;
        } else {
          el.value = '';
        }
      });
      dokumenWrapper.appendChild(clone);
      updateNomor();
    });

    dokumenWrapper.addEventListener('click', function (e) {
      if (e.target.classList.contains('btn-hapus')) {
        if (dokumenWrapper.querySelectorAll('.dokumen-item').length > 1) {
          e.target.closest('.dokumen-item').remove();
          updateNomor();
        } else {
          alert("Minimal 1 dokumen harus ada.");
        }
      }
    });
  }

  /* ==============================
   *  DRAG & DROP FILE
   * ============================== */
  document.addEventListener('dragover', function (e) {
    if (e.target.classList.contains('upload-box')) {
      e.preventDefault();
      e.target.classList.add('dragover');
    }
  });

  document.addEventListener('dragleave', function (e) {
    if (e.target.classList.contains('upload-box')) {
      e.target.classList.remove('dragover');
    }
  });

  document.addEventListener('drop', function (e) {
    if (e.target.classList.contains('upload-box')) {
      e.preventDefault();
      e.target.classList.remove('dragover');
      const fileInput = e.target.querySelector('input[type="file"]');
      if (fileInput) fileInput.files = e.dataTransfer.files;
    }
  });

  /* ==============================
   *  KATEGORI → JENIS DOKUMEN
   * ============================== */
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

  const kategoriSelect = document.getElementById("kategori");
  const jenisSelect = document.getElementById("jenis-dokumen");

  if (kategoriSelect && jenisSelect) {
    kategoriSelect.addEventListener("change", function () {
      const kategori = this.value;
      jenisSelect.innerHTML = `<option value="" selected disabled>-- Pilih Jenis Dokumen --</option>`;

      if (jenisDokumenData[kategori]) {
        jenisDokumenData[kategori].forEach(jenis => {
          const option = document.createElement("option");
          option.textContent = jenis;
          option.value = jenis;
          jenisSelect.appendChild(option);
        });
      }
    });
  }

  updateNomor();
});