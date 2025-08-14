document.addEventListener('DOMContentLoaded', () => {

  /* =================================================
     1. Sidebar & Overlay
  ================================================= */
  const initSidebarToggle = () => {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const toggleSidebarBtn = document.getElementById('toggleSidebar');

    if (!toggleSidebarBtn || !sidebar || !overlay) return;

    toggleSidebarBtn.addEventListener('click', () => {
      const isMobile = window.innerWidth <= 991;

      if (isMobile) {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show', sidebar.classList.contains('show'));
      } else {
        sidebar.classList.toggle('hidden');
      }
    });

    overlay.addEventListener('click', () => {
      sidebar.classList.remove('show');
      overlay.classList.remove('show');
    });
  };

  /* =================================================
     2. Date & Time
  ================================================= */
  const initDateTime = () => {
    const dateEl = document.getElementById('current-date');
    const timeEl = document.getElementById('current-time');

    if (!dateEl && !timeEl) return;

    const updateDateTime = () => {
      const now = new Date();

      if (dateEl) {
        dateEl.textContent = now.toLocaleDateString('id-ID', {
          weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
        });
      }

      if (timeEl) {
        timeEl.textContent = now
          .toLocaleTimeString('id-ID', {
            hour: '2-digit', minute: '2-digit', second: '2-digit'
          })
          .replace(/\./g, ':');
      }
    };

    updateDateTime();
    setInterval(updateDateTime, 1000);
  };

  /* =================================================
     3. Main Tabs
  ================================================= */
  const initMainTabs = () => {
    const mainTabNav = document.getElementById('main-tab-nav');
    if (!mainTabNav) return;

    mainTabNav.addEventListener('click', (e) => {
      if (!e.target.matches('button.nav-link')) return;

      document.querySelectorAll('.main-tab-nav .nav-link').forEach(tab => tab.classList.remove('active'));
      document.querySelectorAll('.main-tab-content').forEach(content => content.style.display = 'none');

      e.target.classList.add('active');
      const contentEl = document.getElementById(`${e.target.dataset.mainTab}-content`);
      if (contentEl) contentEl.style.display = 'block';
    });
  };

  /* =================================================
     4. Sub-tabs
  ================================================= */
  const initSubTabs = () => {
    ['#pendidikan-sub-tabs', '#biodata-sub-tabs'].forEach(selector => {
      const tabContainer = document.querySelector(selector);
      if (!tabContainer) return;

      tabContainer.addEventListener('click', (e) => {
        if (!e.target.matches('button')) return;

        const parentContent = e.target.closest('.main-tab-content');
        if (!parentContent) return;

        tabContainer.querySelectorAll('button').forEach(btn => btn.classList.remove('active'));
        e.target.classList.add('active');

        parentContent.querySelectorAll('.sub-tab-content').forEach(content => content.style.display = 'none');
        const contentEl = parentContent.querySelector(`#${e.target.dataset.tab}`);
        if (contentEl) contentEl.style.display = 'block';
      });
    });
  };

  /* =================================================
     5. Filter Penunjang
  ================================================= */
  const initPenunjangFilter = () => {
    const penunjangFilter = document.getElementById('penunjang-filter');
    if (!penunjangFilter) return;

    penunjangFilter.addEventListener('change', function () {
      const parentContent = this.closest('.main-tab-content');
      if (!parentContent) return;

      parentContent.querySelectorAll('.sub-tab-content').forEach(tab => tab.style.display = 'none');
      const activeTab = document.getElementById(this.value);
      if (activeTab) activeTab.style.display = 'block';
    });
  };

  /* =================================================
     6. File Click & Download
  ================================================= */
  const initFileActions = () => {
    document.querySelectorAll('.file-item').forEach(card => {
      card.addEventListener('click', (e) => {
        if (e.target.closest('.btn-unduh') || e.target.closest('.btn-hapus')) return;
        const fileUrl = card.getAttribute('data-file');
        if (fileUrl) window.open(fileUrl, '_blank');
      });
    });

    document.querySelectorAll('.btn-unduh').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        const fileUrl = btn.getAttribute('data-file');
        if (!fileUrl) return;

        const link = document.createElement('a');
        link.href = fileUrl;
        link.download = fileUrl.split('/').pop();
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
      });
    });
  };

  /* =================================================
     7. Modal Hapus (File & Tabel)
  ================================================= */
  const initDeleteModal = () => {
    let itemToDelete = null;
    const modalElement = document.getElementById('modalKonfirmasiHapus');
    const modalHapus = modalElement ? new bootstrap.Modal(modalElement) : null;

    if (!modalElement) return;

    // Hapus file
    document.querySelectorAll('.btn-hapusfile').forEach(button => {
      button.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        itemToDelete = button.closest('.file-item');
        modalHapus?.show();
      });
    });

    // Delegasi hapus di tabel
    document.addEventListener('click', (e) => {
      const hapusBtn = e.target.closest('.btn-hapus');
      if (!hapusBtn) return;

      e.preventDefault();
      e.stopPropagation();
      itemToDelete = hapusBtn.closest('tr');
      modalHapus?.show();
    });

    // Konfirmasi hapus
    document.getElementById('btnKonfirmasiHapus')?.addEventListener('click', () => {
      if (itemToDelete) {
        itemToDelete.remove();
        itemToDelete = null;
      }
      modalHapus?.hide();
    });

    // Batal hapus
    document.getElementById('btnBatalHapus')?.addEventListener('click', () => {
      modalHapus?.hide();
      itemToDelete = null;
    });
  };

  /* =================================================
     8. Kategori -> Jenis Dokumen Mapping
  ================================================= */
  const initKategoriMapping = () => {
    const jenisDokumenData = {
      biodata: [
        "Pas Foto", "KTP", "NPWP", "Kartu Pegawai (Karpeg)", "Kartu Keluarga (KK)",
        "KTP Suami/Istri", "BPJS Pribadi", "BPJS Suami/Istri", "BPJS Anak 1", "BPJS Anak 2",
        "KP4 (Keterangan Tanggungan Keluarga)", "Akta Kelahiran", "Buku Nikah", "Kartu Suami/Istri", "Paspor"
      ],
      pendidikan: [
        "Ijazah SD", "Ijazah SMP", "Ijazah S1", "Transkrip Nilai S1", "Ijazah S2", "Transkrip Nilai S2",
        "Ijazah S3", "Transkrip Nilai S3", "Penyetaraan Ijazah S1", "Penyetaraan Ijazah S2",
        "Penyetaraan Ijazah S3", "Ijazah Profesi", "Transkrip Profesi", "Ijazah D3", "Transkrip Nilai D3",
        "Ijazah D4", "Transkrip Nilai D4", "Ijazah SLTA (SMA/SMK/MA)", "Surat Tugas Belajar",
        "Surat Penyesuaian Ijazah", "Surat Tanda Lulus Ujian Pencantuman Gelar"
      ],
      jf: [
        "SK Asisten Ahli", "SK Lektor", "SK Lektor Kepala", "SK Guru Besar",
        "PAK Terakhir (Penetapan Angka Kredit)", "PAK Integrasi", "PAK Konversi", "SK Inpassing Jabfung",
        "Sertifikasi Dosen", "Sertifikat TOEP (Test of English Proficiency)",
        "Sertifikat TKDA (Tes Kemampuan Dasar Akademik)", "Surat Pernyataan Menduduki Jabatan",
        "SK Pembebasan Sementara dari Jabfung", "SK Pemberhentian dari Jabfung", "SK Penugasan Jabfung",
        "SK Perpanjangan Jabfung", "BAP Sumpah Jabatan Fungsional Dosen"
      ],
      sk: [
        "SK CPNS", "SK PNS", "SK PPPK", "SK Calon Dosen Tetap", "SK Dosen Tetap", "SK Pegawai Tetap",
        "SK Jabatan Fungsional Terakhir", "SK Kenaikan Gaji Berkala", "SK Penugasan",
        "SK Perpanjangan Penugasan", "SK Tugas Belajar", "SK Pemberian Tunjangan Tugas Belajar",
        "SK Perbaikan Data Kepegawaian", "SK Pemberhentian", "SK Pensiun"
      ],
      sp: [
        "Surat Tugas Khusus", "STTPL", "Sertifikat Sertifikasi Dosen",
        "Surat Pernyataan Melaksanakan Tugas (SPMT)", "Surat Pernyataan Menduduki Jabatan",
        "Berita Acara Sumpah PNS", "Berita Acara Sumpah Dosen Tetap", "Berita Acara Sumpah Jabfung",
        "Berita Acara Pelantikan", "Surat Keterangan Dosen Tetap", "Surat Keterangan Aktif Mengajar",
        "Perjanjian Kerja", "Surat Pencantuman Gelar", "Surat Usulan Pengaktifan Kembali",
        "SK Perjanjian Beasiswa"
      ],
      lain: [
        "Asuransi Komersil", "Rekening Bank", "Sertifikat Pelatihan Tridharma",
        "Sertifikat Uji Kompetensi Jabfung", "Satyalencana Karya Satya",
        "Analisis Kepegawaian Pertama", "Analisis Kepegawaian Muda", "Analisis Kepegawaian Madya",
        "SK Pembimbing Skripsi/Tesis/Disertasi", "Surat Tugas Reviewer Jurnal", "Surat Tugas Mengajar"
      ]
    };

    const kategoriSelect = document.getElementById("kategori");
    const jenisSelect = document.getElementById("jenis-dokumen");

    if (!kategoriSelect || !jenisSelect) return;

    kategoriSelect.addEventListener("change", function () {
      const kategori = this.value;
      jenisSelect.innerHTML = '<option value="" selected disabled>-- Pilih Jenis Dokumen --</option>';

      if (jenisDokumenData[kategori]) {
        jenisDokumenData[kategori].forEach(jenis => {
          const opt = document.createElement("option");
          opt.value = jenis.toLowerCase().replace(/\s+/g, "-");
          opt.textContent = jenis;
          jenisSelect.appendChild(opt);
        });
      }
    });
  };

  /* =================================================
     Jalankan Semua Modul
  ================================================= */
  initSidebarToggle();
  initDateTime();
  initMainTabs();
  initSubTabs();
  initPenunjangFilter();
  initFileActions();
  initDeleteModal();
  initKategoriMapping();

});