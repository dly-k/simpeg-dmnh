// =======================================================
// ===     INISIALISASI UTAMA & LOGIKA UMUM HALAMAN    ===
// =======================================================
document.addEventListener('DOMContentLoaded', function () {
  // === Inisialisasi Sidebar ===
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const toggleSidebarBtn = document.getElementById('toggleSidebar');
  const body = document.body;

  if (toggleSidebarBtn && sidebar && overlay) {
    toggleSidebarBtn.addEventListener('click', function () {
      const isMobile = window.innerWidth <= 991;
      if (isMobile) {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show', sidebar.classList.contains('show'));
      } else {
        sidebar.classList.toggle('hidden');
        body.classList.toggle('sidebar-collapsed');
      }
    });

    overlay.addEventListener('click', function () {
      sidebar.classList.remove('show');
      overlay.classList.remove('show');
    });
  }

  // === Inisialisasi Waktu & Tanggal ===
  function updateDateTime() {
    const now = new Date();
    const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const timeOptions = {
      hour: '2-digit', minute: '2-digit', second: '2-digit',
      hour12: false, timeZone: 'Asia/Jakarta'
    };
    const dateEl = document.getElementById('current-date');
    const timeEl = document.getElementById('current-time');
    if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', dateOptions);
    if (timeEl) timeEl.textContent = now.toLocaleTimeString('id-ID', timeOptions);
  }
  updateDateTime();
  setInterval(updateDateTime, 1000);

  // =================================================================
  // ===     FUNGSI BANTUAN UNTUK MODAL & NOTIFIKASI SUKSES        ===
  // =================================================================
  
  // --- Fungsi untuk membuka modal dengan animasi ---
  function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
      modal.classList.add('show');
    }
  }

  // --- Fungsi untuk menutup modal dengan animasi ---
  function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
      modal.classList.remove('show');
    }
  }
  
  // --- Fungsi untuk menampilkan notifikasi sukses ---
  function showSuccessModal(title, subtitle) {
      const berhasilTitle = document.getElementById('berhasil-title');
      const berhasilSubtitle = document.getElementById('berhasil-subtitle');
      if (berhasilTitle) berhasilTitle.textContent = title;
      if (berhasilSubtitle) berhasilSubtitle.textContent = subtitle;
      
      const modalBerhasil = document.getElementById('modalBerhasil');
      if (modalBerhasil) {
          modalBerhasil.classList.add('show');
          // Menutup otomatis setelah 1 detik
          setTimeout(() => {
              modalBerhasil.classList.remove('show');
          }, 1000);
      }
  }

  // --- Event Listener untuk tombol 'Selesai' di modal sukses ---
  const btnSelesai = document.getElementById('btnSelesai');
  if (btnSelesai) {
      btnSelesai.addEventListener('click', function() {
          closeModal('modalBerhasil');
      });
  }


  // === Logika Modal Konfirmasi Hapus (berlaku untuk semua tab) ===
  const tabContent = document.getElementById('pendidikanTabContent');
  const deleteModal = document.getElementById('modalKonfirmasiHapus');
  if (tabContent && deleteModal) {
      const btnBatal = document.getElementById('btnBatalHapus');
      const btnKonfirmasi = document.getElementById('btnKonfirmasiHapus');
      let rowToDelete = null;

      tabContent.addEventListener('click', function(event) {
          const deleteButton = event.target.closest('.btn-hapus');
          if (deleteButton) {
              event.preventDefault();
              rowToDelete = deleteButton.closest('tr');
              openModal('modalKonfirmasiHapus');
          }
      });

      const hideDeleteModal = () => {
          closeModal('modalKonfirmasiHapus');
          rowToDelete = null;
      };
      
      btnKonfirmasi.addEventListener('click', function() {
          if (rowToDelete) {
              rowToDelete.remove();
              showSuccessModal('Data Berhasil Dihapus', 'Data yang dipilih telah dihapus dari sistem.');
          }
          hideDeleteModal();
      });

      btnBatal.addEventListener('click', hideDeleteModal);
      deleteModal.addEventListener('click', function(event) {
          if (event.target === deleteModal) {
              hideDeleteModal();
          }
      });
  }

  // === Logika Modal Konfirmasi Verifikasi dengan Animasi ===
  const popupOverlay = document.getElementById('modalKonfirmasiPendidikan');
  if (popupOverlay) {
      const btnKembali = document.getElementById('popupBtnKembali');
      const btnTerima = document.getElementById('popupBtnTerima');
      const btnTolak = document.getElementById('popupBtnTolak');
      let currentDataId = null;

      document.addEventListener('click', function(event) {
          const konfirmasiButton = event.target.closest('.btn-konfirmasi-pendidikan');
          if (konfirmasiButton) {
              event.preventDefault();
              currentDataId = konfirmasiButton.dataset.id;
              openModal('modalKonfirmasiPendidikan');
          }
      });

      const hidePopup = () => {
          currentDataId = null;
          closeModal('modalKonfirmasiPendidikan');
      };

      const handleVerification = () => {
          if (currentDataId) {
              showSuccessModal('Status Verifikasi Disimpan', 'Perubahan status verifikasi telah berhasil disimpan.');
          }
          hidePopup();
      };

      btnKembali.addEventListener('click', hidePopup);
      btnTerima.addEventListener('click', handleVerification);
      btnTolak.addEventListener('click', handleVerification);
      
      popupOverlay.addEventListener('click', function(event) {
          if (event.target === popupOverlay) {
              hidePopup();
          }
      });
  }
});

// =======================================================
// ===      LOGIKA SPESIFIK UNTUK TIAP FORM & MODAL    ===
// =======================================================

// --- Form Pengajaran Lama ---
document.addEventListener('DOMContentLoaded', function () {
    const modalElement = document.getElementById('modalTambahEditPengajaranLama');
    if (!modalElement) return;

    const modalTitleText = modalElement.querySelector('#modalTitleText');
    const form = document.getElementById('formPengajaranLama');
    const editIdField = document.getElementById('editPengajaranId');
    const tableBody = document.querySelector('#pengajaran-lama .table tbody');

    document.getElementById('btnTambahPengajaranLama')?.addEventListener('click', function () {
        modalTitleText.textContent = 'Tambah Pengajaran Lama';
        form.reset();
        editIdField.value = '';
    });

    if (tableBody) {
        tableBody.addEventListener('click', function (event) {
            const editButton = event.target.closest('.btn-edit');
            if (editButton) {
                modalTitleText.textContent = 'Edit Pengajaran Lama';
                const data = editButton.dataset;
                editIdField.value = data.id;
                form.querySelector('#nama').value = data.nama;
                form.querySelector('#tahun_semester').value = data.tahun_semester;
                form.querySelector('#kode_mk').value = data.kode_mk;
                form.querySelector('#nama_mk').value = data.nama_mk;
                form.querySelector('#sks_kuliah').value = data.sks_kuliah;
                form.querySelector('#sks_praktikum').value = data.sks_praktikum;
                form.querySelector('#kelas_paralel').value = data.kelas_paralel;
                form.querySelector('#jumlah_pertemuan').value = data.jumlah_pertemuan;
            }
        });
    }
});

// --- Form Pengajaran Luar ---
document.addEventListener('DOMContentLoaded', function () {
    const modalElement = document.getElementById('modalPengajaranLuar');
    if (!modalElement) return;

    const modalTitleText = modalElement.querySelector('#modalTitleTextPengajaranLuar');
    const form = document.getElementById('formPengajaranLuar');
    const editIdField = document.getElementById('editPengajaranLuarId');
    const tableBody = document.querySelector('#pengajaran-luar .table tbody');

    document.getElementById('btnTambahPengajaranLuar')?.addEventListener('click', function () {
        modalTitleText.textContent = 'Tambah Kegiatan Pengajaran Luar IPB';
        form.reset();
        editIdField.value = '';
    });

    if (tableBody) {
        tableBody.addEventListener('click', function(event) {
            const editButton = event.target.closest('.btn-edit-pengajaran-luar');
            if (editButton) {
                modalTitleText.textContent = 'Edit Kegiatan Pengajaran Luar IPB';
                const data = editButton.dataset;
                editIdField.value = data.id || '';
                document.getElementById('pl_nama').value = data.nama || '';
                document.getElementById('pl_tahun_semester').value = data.tahun_semester || '';
                document.getElementById('pl_kode_mk').value = data.kode_mk || '';
                document.getElementById('pl_nama_mk').value = data.nama_mk || '';
                document.getElementById('pl_sks_kuliah').value = data.sks_kuliah || '';
                document.getElementById('pl_sks_praktikum').value = data.sks_praktikum || '';
                document.getElementById('pl_universitas').value = data.universitas || '';
                document.getElementById('pl_strata').value = data.strata || '';
                document.getElementById('pl_program_studi').value = data.program_studi || '';
                document.getElementById('pl_jenis').value = data.jenis || '';
                document.getElementById('pl_kelas_paralel').value = data.kelas_paralel || '';
                document.getElementById('pl_jumlah_pertemuan').value = data.jumlah_pertemuan || '';
                document.getElementById('pl_is_insidental').value = data.is_insidental || '';
                document.getElementById('pl_is_lebih_satu_semester').value = data.is_lebih_satu_semester || '';
            }
        });
    }
});

// --- Form Pengujian Lama ---
document.addEventListener('DOMContentLoaded', function () {
    const modalElement = document.getElementById('modalPengujianLama');
    if (!modalElement) return;
    
    const modalTitleText = modalElement.querySelector('#modalTitleTextPengujianLama');
    const form = document.getElementById('formPengujianLama');
    const editIdField = document.getElementById('editPengujianLamaId');
    const tableBody = document.querySelector('#pengujian-lama .table tbody');

    document.getElementById('btnTambahPengujianLama')?.addEventListener('click', function () {
        modalTitleText.textContent = 'Tambah Kegiatan Pengujian Lama';
        form.reset();
        editIdField.value = '';
    });

    if (tableBody) {
        tableBody.addEventListener('click', function(event) {
            const editButton = event.target.closest('.btn-edit-pengujian-lama');
            if (editButton) {
                modalTitleText.textContent = 'Edit Kegiatan Pengujian Lama';
                const data = editButton.dataset;
                editIdField.value = data.id || '';
                document.getElementById('pjl_kegiatan').value = data.kegiatan || '';
                document.getElementById('pjl_nama').value = data.nama || '';
                document.getElementById('pjl_strata').value = data.strata || '';
                document.getElementById('pjl_tahun_semester').value = data.tahun_semester || '';
                document.getElementById('pjl_nim').value = data.nim || '';
                document.getElementById('pjl_nama_mahasiswa').value = data.nama_mahasiswa || '';
                document.getElementById('pjl_departemen').value = data.departemen || '';
            }
        });
    }
});

// --- Form Pembimbing Lama ---
document.addEventListener('DOMContentLoaded', function () {
    const modalElement = document.getElementById('modalPembimbingLama');
    if (!modalElement) return;

    const modalTitleText = modalElement.querySelector('#modalTitleTextPembimbingLama');
    const form = document.getElementById('formPembimbingLama');
    const editIdField = document.getElementById('editPembimbingLamaId');
    const tableBody = document.querySelector('#pembimbing-lama .table tbody');

    document.getElementById('btnTambahPembimbingLama')?.addEventListener('click', function () {
        modalTitleText.textContent = 'Tambah Kegiatan Pembimbing Lama';
        form.reset();
        editIdField.value = '';
    });

    if (tableBody) {
        tableBody.addEventListener('click', function(event) {
            const editButton = event.target.closest('.btn-edit-pembimbing-lama');
            if (editButton) {
                modalTitleText.textContent = 'Edit Kegiatan Pembimbing Lama';
                const data = editButton.dataset;
                editIdField.value = data.id || '';
                document.getElementById('pbl_kegiatan').value = data.kegiatan || '';
                document.getElementById('pbl_nama').value = data.nama || '';
                document.getElementById('pbl_tahun_semester').value = data.tahun_semester || '';
                document.getElementById('pbl_nim').value = data.nim || '';
                document.getElementById('pbl_nama_mahasiswa').value = data.nama_mahasiswa || '';
                document.getElementById('pbl_departemen').value = data.departemen || '';
                document.getElementById('pbl_lokasi').value = data.lokasi || '';
                document.getElementById('pbl_nama_dokumen').value = data.nama_dokumen || '';
            }
        });
    }
});

// --- Form Penguji Luar IPB ---
document.addEventListener('DOMContentLoaded', function () {
    const modalElement = document.getElementById('modalPengujiLuar');
    if (!modalElement) return;

    const modalTitleText = modalElement.querySelector('#modalTitleTextPengujiLuar');
    const form = document.getElementById('formPengujiLuar');
    const editIdField = document.getElementById('editPengujiLuarId');
    const tableBody = document.querySelector('#penguji-luar .table tbody');

    document.getElementById('btnTambahPengujiLuar')?.addEventListener('click', function () {
        modalTitleText.textContent = 'Tambah Kegiatan Penguji Luar IPB';
        form.reset();
        editIdField.value = '';
    });

    if (tableBody) {
        tableBody.addEventListener('click', function(event) {
            const editButton = event.target.closest('.btn-edit-penguji-luar');
            if (editButton) {
                modalTitleText.textContent = 'Edit Kegiatan Penguji Luar IPB';
                const data = editButton.dataset;
                editIdField.value = data.id || '';
                document.getElementById('pjl_kegiatan').value = data.kegiatan || '';
                document.getElementById('pjl_nama').value = data.nama || '';
                document.getElementById('pjl_status').value = data.status || '';
                document.getElementById('pjl_tahun_semester_luar').value = data.tahun_semester || '';
                document.getElementById('pjl_nim_luar').value = data.nim || '';
                document.getElementById('pjl_nama_mahasiswa_luar').value = data.nama_mahasiswa || '';
                document.getElementById('pjl_universitas').value = data.universitas || '';
                document.getElementById('pjl_strata_luar').value = data.strata || '';
                document.getElementById('pjl_program_studi').value = data.program_studi || '';
                document.getElementById('pjl_is_insidental').value = data.is_insidental || '';
                document.getElementById('pjl_is_lebih_satu_semester').value = data.is_lebih_satu_semester || '';
            }
        });
    }
});

// --- Form Pembimbing Luar IPB ---
document.addEventListener('DOMContentLoaded', function () {
    const modalElement = document.getElementById('modalPembimbingLuar');
    if (!modalElement) return;
    
    const modalTitleText = modalElement.querySelector('#modalTitleTextPembimbingLuar');
    const form = document.getElementById('formPembimbingLuar');
    const editIdField = document.getElementById('editPembimbingLuarId');
    const tableBody = document.querySelector('#pembimbing-luar .table tbody');

    document.getElementById('btnTambahPembimbingLuar')?.addEventListener('click', function () {
        modalTitleText.textContent = 'Tambah Kegiatan Pembimbing Luar IPB';
        form.reset();
        editIdField.value = '';
    });

    if (tableBody) {
        tableBody.addEventListener('click', function(event) {
            const editButton = event.target.closest('.btn-edit-pembimbing-luar');
            if (editButton) {
                modalTitleText.textContent = 'Edit Kegiatan Pembimbing Luar IPB';
                const data = editButton.dataset;
                editIdField.value = data.id || '';
                document.getElementById('pbl_kegiatan_luar').value = data.kegiatan || '';
                document.getElementById('pbl_nama_luar').value = data.nama || '';
                document.getElementById('pbl_status_luar').value = data.status || '';
                document.getElementById('pbl_tahun_semester_luar').value = data.tahun_semester || '';
                document.getElementById('pbl_nim_luar').value = data.nim || '';
                document.getElementById('pbl_nama_mahasiswa_luar').value = data.nama_mahasiswa || '';
                document.getElementById('pbl_universitas_luar').value = data.universitas || '';
                document.getElementById('pbl_program_studi_luar').value = data.program_studi || '';
                document.getElementById('pbl_is_insidental_luar').value = data.is_insidental || '';
                document.getElementById('pbl_is_lebih_satu_semester_luar').value = data.is_lebih_satu_semester || '';
            }
        });
    }
});

// =======================================================
// ===     LOGIKA DETAIL MODAL (TIDAK PERLU DIUBAH)    ===
// =======================================================

// --- [DIPERBAIKI] Modal Detail Pengajaran Lama ---
document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('#pengajaran-lama .table tbody');
    if (tableBody) {
        tableBody.addEventListener('click', function(event) {
            const detailButton = event.target.closest('.btn-lihat-detail');
            if (detailButton) {
                const data = detailButton.dataset;
                document.getElementById('detail_pl_kegiatan').textContent = data.kegiatan || '-';
                document.getElementById('detail_pl_nama').textContent = data.nama || '-';
                document.getElementById('detail_pl_tahun_semester').textContent = data.tahun_semester || '-';
                document.getElementById('detail_pl_kode_mk').textContent = data.kode_mk || '-';
                document.getElementById('detail_pl_nama_mk').textContent = data.nama_mk || '-';
                document.getElementById('detail_pl_pengampu').textContent = data.pengampu || '-';
                document.getElementById('detail_pl_sks_kuliah').textContent = data.sks_kuliah || '-';
                document.getElementById('detail_pl_sks_praktikum').textContent = data.sks_praktikum || '-';
                document.getElementById('detail_pl_jenis').textContent = data.jenis || '-';
                document.getElementById('detail_pl_kelas_paralel').textContent = data.kelas_paralel || '-';
                document.getElementById('detail_pl_jumlah_pertemuan').textContent = data.jumlah_pertemuan || '-';
                document.getElementById('detail_pl_document_viewer').setAttribute('src', data.dokumen_path || '');
            }
        });
    }
});

// --- Modal Detail Pengajaran Luar ---
document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('#pengajaran-luar .table tbody');
    if (tableBody) {
        tableBody.addEventListener('click', function(event) {
            const detailButton = event.target.closest('.btn-lihat-detail');
            if (detailButton) {
                const data = detailButton.dataset;
                document.getElementById('detail_pluar_nama').textContent = data.nama || '-';
                document.getElementById('detail_pluar_tahun_semester').textContent = data.tahun_semester || '-';
                document.getElementById('detail_pluar_universitas').textContent = data.universitas || '-';
                document.getElementById('detail_pluar_kode_mk').textContent = data.kode_mk || '-';
                document.getElementById('detail_pluar_nama_mk').textContent = data.nama_mk || '-';
                document.getElementById('detail_pluar_program_studi').textContent = data.program_studi || '-';
                document.getElementById('detail_pluar_sks_kuliah').textContent = data.sks_kuliah || '-';
                document.getElementById('detail_pluar_sks_praktikum').textContent = data.sks_praktikum || '-';
                document.getElementById('detail_pluar_jenis').textContent = data.jenis || '-';
                document.getElementById('detail_pluar_kelas_paralel').textContent = data.kelas_paralel || '-';
                document.getElementById('detail_pluar_jumlah_pertemuan').textContent = data.jumlah_pertemuan || '-';
                document.getElementById('detail_pluar_insidental').textContent = data.is_insidental || '-';
                document.getElementById('detail_pluar_lebih_satu_semester').textContent = data.is_lebih_satu_semester || '-';
                document.getElementById('detail_pluar_document_viewer').setAttribute('src', data.dokumen_path || '');
            }
        });
    }
});

// --- Modal Detail Pengujian Lama ---
document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('#pengujian-lama .table tbody');
    if (tableBody) {
        tableBody.addEventListener('click', function(event) {
            const detailButton = event.target.closest('.btn-lihat-detail-pengujian');
            if (detailButton) {
                const data = detailButton.dataset;
                document.getElementById('detail_pjl_kegiatan').textContent = data.kegiatan || '-';
                document.getElementById('detail_pjl_nama').textContent = data.nama || '-';
                document.getElementById('detail_pjl_tahun_semester').textContent = data.tahun_semester || '-';
                document.getElementById('detail_pjl_nim').textContent = data.nim || '-';
                document.getElementById('detail_pjl_nama_mahasiswa').textContent = data.nama_mahasiswa || '-';
                document.getElementById('detail_pjl_departemen').textContent = data.departemen || '-';
                document.getElementById('detail_pjl_document_viewer').setAttribute('src', data.dokumen_path || '');
            }
        });
    }
});

// --- Modal Detail Pembimbing Lama ---
document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('#pembimbing-lama .table tbody');
    if (tableBody) {
        tableBody.addEventListener('click', function(event) {
            const detailButton = event.target.closest('.btn-lihat-detail-pembimbing');
            if (detailButton) {
                const data = detailButton.dataset;
                document.getElementById('detail_pbl_kegiatan').textContent = data.kegiatan || '-';
                document.getElementById('detail_pbl_nama').textContent = data.nama || '-';
                document.getElementById('detail_pbl_tahun_semester').textContent = data.tahun_semester || '-';
                document.getElementById('detail_pbl_lokasi').textContent = data.lokasi || '-';
                document.getElementById('detail_pbl_nim').textContent = data.nim || '-';
                document.getElementById('detail_pbl_nama_mahasiswa').textContent = data.nama_mahasiswa || '-';
                document.getElementById('detail_pbl_departemen').textContent = data.departemen || '-';
                document.getElementById('detail_pbl_nama_dokumen').textContent = data.nama_dokumen || '-';
                document.getElementById('detail_pbl_document_viewer').setAttribute('src', data.dokumen_path || '');
            }
        });
    }
});

// --- Modal Detail Penguji Luar ---
document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('#penguji-luar .table tbody');
    if (tableBody) {
        tableBody.addEventListener('click', function(event) {
            const detailButton = event.target.closest('.btn-lihat-detail-penguji-luar');
            if (detailButton) {
                const data = detailButton.dataset;
                document.getElementById('detail_pjl_luar_kegiatan').textContent = data.kegiatan || '-';
                document.getElementById('detail_pjl_luar_nama').textContent = data.nama || '-';
                document.getElementById('detail_pjl_luar_status').textContent = data.status || '-';
                document.getElementById('detail_pjl_luar_tahun_semester').textContent = data.tahun_semester || '-';
                document.getElementById('detail_pjl_luar_nim').textContent = data.nim || '-';
                document.getElementById('detail_pjl_luar_nama_mahasiswa').textContent = data.nama_mahasiswa || '-';
                document.getElementById('detail_pjl_luar_universitas').textContent = data.universitas || '-';
                document.getElementById('detail_pjl_luar_program_studi').textContent = data.program_studi || '-';
                document.getElementById('detail_pjl_luar_insidental').textContent = data.is_insidental || '-';
                document.getElementById('detail_pjl_luar_lebih_satu_semester').textContent = data.is_lebih_satu_semester || '-';
                document.getElementById('detail_pjl_luar_document_viewer').setAttribute('src', data.dokumen_path || '');
            }
        });
    }
});

// --- Modal Detail Pembimbing Luar ---
document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('#pembimbing-luar .table tbody');
    if (tableBody) {
        tableBody.addEventListener('click', function(event) {
            const detailButton = event.target.closest('.btn-lihat-detail-pembimbing-luar');
            if (detailButton) {
                const data = detailButton.dataset;
                document.getElementById('detail_pbl_luar_kegiatan').textContent = data.kegiatan || '-';
                document.getElementById('detail_pbl_luar_nama').textContent = data.nama || '-';
                document.getElementById('detail_pbl_luar_status').textContent = data.status || '-';
                document.getElementById('detail_pbl_luar_tahun_semester').textContent = data.tahun_semester || '-';
                document.getElementById('detail_pbl_luar_nim').textContent = data.nim || '-';
                document.getElementById('detail_pbl_luar_nama_mahasiswa').textContent = data.nama_mahasiswa || '-';
                document.getElementById('detail_pbl_luar_universitas').textContent = data.universitas || '-';
                document.getElementById('detail_pbl_luar_program_studi').textContent = data.program_studi || '-';
                document.getElementById('detail_pbl_luar_insidental').textContent = data.is_insidental || '-';
                document.getElementById('detail_pbl_luar_lebih_satu_semester').textContent = data.is_lebih_satu_semester || '-';
                document.getElementById('detail_pbl_luar_document_viewer').setAttribute('src', data.dokumen_path || '');
            }
        });
    }
});


// =====================================================================
// === LOGIKA PENYIMPANAN MODAL & NOTIFIKASI SUKSES (FUNGSI BARU) ===
// =====================================================================
document.addEventListener('DOMContentLoaded', function() {
    // Daftar semua modal form dan tombol simpannya
    const modals = [
        { modalId: 'modalTambahEditPengajaranLama', btnId: 'btnSimpanPengajaran' },
        { modalId: 'modalPengajaranLuar', btnId: 'btnSimpanPengajaranLuar' },
        { modalId: 'modalPengujianLama', btnId: 'btnSimpanPengujianLama' },
        { modalId: 'modalPembimbingLama', btnId: 'btnSimpanPembimbingLama' },
        { modalId: 'modalPengujiLuar', btnId: 'btnSimpanPengujiLuar' },
        { modalId: 'modalPembimbingLuar', btnId: 'btnSimpanPembimbingLuar' }
    ];

    // --- Fungsi untuk menampilkan notifikasi sukses ---
    function showSuccessModal(title, subtitle) {
        const berhasilTitle = document.getElementById('berhasil-title');
        const berhasilSubtitle = document.getElementById('berhasil-subtitle');
        if (berhasilTitle) berhasilTitle.textContent = title;
        if (berhasilSubtitle) berhasilSubtitle.textContent = subtitle;
        
        const modalBerhasil = document.getElementById('modalBerhasil');
        if (modalBerhasil) {
            modalBerhasil.classList.add('show');
            setTimeout(() => {
                modalBerhasil.classList.remove('show');
            }, 1000);
        }
    }

    modals.forEach(item => {
        const saveButton = document.getElementById(item.btnId);
        const modalElement = document.getElementById(item.modalId);
        
        if (saveButton && modalElement) {
            saveButton.addEventListener('click', function() {
                // NOTE: Di sini Anda akan menambahkan logika AJAX untuk mengirim data ke server
                
                // Tutup modal form menggunakan API Bootstrap
                const bootstrapModal = bootstrap.Modal.getInstance(modalElement);
                if (bootstrapModal) {
                    bootstrapModal.hide();
                }
                
                // Tampilkan notifikasi sukses
                showSuccessModal('Data Berhasil Disimpan', 'Perubahan Anda telah berhasil disimpan ke dalam sistem.');
            });
        }
    });
});