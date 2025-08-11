// SIDEBAR
document.addEventListener('DOMContentLoaded', function () {
  // === Sidebar Logic ===
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

  // === Date and Time Logic ===
  function updateDateTime() {
    const now = new Date();
    const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const timeOptions = {
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit',
      hour12: false,
      timeZone: 'Asia/Jakarta'
    };

    const dateEl = document.getElementById('current-date');
    const timeEl = document.getElementById('current-time');

    if (dateEl) {
      dateEl.textContent = now.toLocaleDateString('id-ID', dateOptions);
    }

    if (timeEl) {
      timeEl.textContent = now.toLocaleTimeString('id-ID', timeOptions);
    }
  }

  updateDateTime(); // initial load
  setInterval(updateDateTime, 1000); // update every second
});

// Pengajaran Lama Form
document.addEventListener('DOMContentLoaded', function () {

    const modalPengajaranLama = new bootstrap.Modal(document.getElementById('modalTambahEditPengajaranLama'));
    // **DIUBAH**: Target ke span yang berisi teks judul, bukan H5 lagi
    const modalTitleText = document.getElementById('modalTitleText'); 
    const formPengajaran = document.getElementById('formPengajaranLama');
    const editIdField = document.getElementById('editPengajaranId');

    // 1. Logika untuk Tombol "Tambah Data"
    const btnTambah = document.getElementById('btnTambahPengajaranLama');
    if(btnTambah) {
        btnTambah.addEventListener('click', function () {
            // Ubah judul modal
            modalLabel.textContent = 'Tambah Pengajaran Lama';
            
            // Kosongkan form
            formPengajaran.reset();
            editIdField.value = ''; // Pastikan hidden ID kosong
        });
    }

    // 2. Logika untuk semua tombol "Edit" di dalam tabel
    const tableBody = document.querySelector('#pengajaran-lama .table tbody');
    if (tableBody) {
        tableBody.addEventListener('click', function(event) {
            // Menggunakan event delegation untuk menangkap klik pada tombol edit
            const editButton = event.target.closest('.btn-edit-pengajaran');
            
            if (editButton) {
                // Ubah judul modal
                modalLabel.textContent = 'Edit Pengajaran Lama';

                // Ambil data dari atribut `data-*` pada tombol
                const data = editButton.dataset;

                // Isi form dengan data yang ada
                editIdField.value = data.id; // Set hidden ID
                document.getElementById('nama').value = data.nama;
                document.getElementById('tahun_semester').value = data.tahun_semester;
                document.getElementById('kode_mk').value = data.kode_mk;
                document.getElementById('nama_mk').value = data.nama_mk;
                document.getElementById('sks_kuliah').value = data.sks_kuliah;
                document.getElementById('sks_praktikum').value = data.sks_praktikum;
                document.getElementById('kelas_paralel').value = data.kelas_paralel;
                document.getElementById('jumlah_pertemuan').value = data.jumlah_pertemuan;

                // Anda mungkin perlu menambahkan logika lain untuk select box 'pengampu' dan 'jenis'
            }
        });
    }

});

// Pengajaran Luar IPB Form
document.addEventListener('DOMContentLoaded', function () {

    const modalElement = document.getElementById('modalPengajaranLuar');
    if (!modalElement) {
        return; // Keluar jika modal tidak ada di halaman ini
    }

    const modalPengajaranLuar = new bootstrap.Modal(modalElement);
    const modalTitleText = document.getElementById('modalTitleTextPengajaranLuar');
    const formPengajaran = document.getElementById('formPengajaranLuar');
    const editIdField = document.getElementById('editPengajaranLuarId');

    // 1. Logika untuk Tombol "Tambah Data"
    const btnTambah = document.getElementById('btnTambahPengajaranLuar');
    if (btnTambah) {
        btnTambah.addEventListener('click', function () {
            modalTitleText.textContent = 'Tambah Kegiatan Pengajaran Luar IPB';
            if (formPengajaran) formPengajaran.reset();
            if (editIdField) editIdField.value = '';
        });
    }

    // 2. Logika untuk semua tombol "Edit" di dalam tabel
    const tableBody = document.querySelector('#pengajaran-luar .table tbody');
    if (tableBody) {
        tableBody.addEventListener('click', function(event) {
            const editButton = event.target.closest('.btn-edit-pengajaran-luar');
            
            if (editButton) {
                modalTitleText.textContent = 'Edit Kegiatan Pengajaran Luar IPB';
                const data = editButton.dataset;

                // Isi form dengan data yang ada
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

// Pengujian Lama Form
document.addEventListener('DOMContentLoaded', function () {

    const modalElement = document.getElementById('modalPengujianLama');
    if (!modalElement) {
        return; // Keluar jika modal tidak ada di halaman ini
    }

    const modalPengujianLama = new bootstrap.Modal(modalElement);
    const modalTitleText = document.getElementById('modalTitleTextPengujianLama');
    const formPengujian = document.getElementById('formPengujianLama');
    const editIdField = document.getElementById('editPengujianLamaId');

    // 1. Logika untuk Tombol "Tambah Data"
    const btnTambah = document.getElementById('btnTambahPengujianLama');
    if (btnTambah) {
        btnTambah.addEventListener('click', function () {
            modalTitleText.textContent = 'Tambah Kegiatan Pengujian Lama';
            if (formPengujian) formPengujian.reset();
            if (editIdField) editIdField.value = '';
        });
    }

    // 2. Logika untuk semua tombol "Edit" di dalam tabel
    const tableBody = document.querySelector('#pengujian-lama .table tbody');
    if (tableBody) {
        tableBody.addEventListener('click', function(event) {
            const editButton = event.target.closest('.btn-edit-pengujian-lama');
            
            if (editButton) {
                modalTitleText.textContent = 'Edit Kegiatan Pengujian Lama';
                const data = editButton.dataset;

                // Isi form dengan data yang ada
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

// Pembimbing Lama Form
document.addEventListener('DOMContentLoaded', function () {

    const modalElement = document.getElementById('modalPembimbingLama');
    if (!modalElement) {
        return; // Keluar jika modal tidak ada di halaman ini
    }

    const modalPembimbingLama = new bootstrap.Modal(modalElement);
    const modalTitleText = document.getElementById('modalTitleTextPembimbingLama');
    const formPembimbing = document.getElementById('formPembimbingLama');
    const editIdField = document.getElementById('editPembimbingLamaId');

    // 1. Logika untuk Tombol "Tambah Data"
    const btnTambah = document.getElementById('btnTambahPembimbingLama');
    if (btnTambah) {
        btnTambah.addEventListener('click', function () {
            modalTitleText.textContent = 'Tambah Kegiatan Pembimbing Lama';
            if (formPembimbing) formPembimbing.reset();
            if (editIdField) editIdField.value = '';
        });
    }

    // 2. Logika untuk semua tombol "Edit" di dalam tabel
    const tableBody = document.querySelector('#pembimbing-lama .table tbody');
    if (tableBody) {
        tableBody.addEventListener('click', function(event) {
            const editButton = event.target.closest('.btn-edit-pembimbing-lama');
            
            if (editButton) {
                modalTitleText.textContent = 'Edit Kegiatan Pembimbing Lama';
                const data = editButton.dataset;

                // Isi form dengan data yang ada
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

// Penguji Luar IPB Form
document.addEventListener('DOMContentLoaded', function () {

    const modalElement = document.getElementById('modalPengujiLuar');
    if (!modalElement) {
        return; // Keluar jika modal tidak ada di halaman ini
    }

    const modalPengujiLuar = new bootstrap.Modal(modalElement);
    const modalTitleText = document.getElementById('modalTitleTextPengujiLuar');
    const formPenguji = document.getElementById('formPengujiLuar');
    const editIdField = document.getElementById('editPengujiLuarId');

    // 1. Logika untuk Tombol "Tambah Data"
    const btnTambah = document.getElementById('btnTambahPengujiLuar');
    if (btnTambah) {
        btnTambah.addEventListener('click', function () {
            modalTitleText.textContent = 'Tambah Kegiatan Penguji Luar IPB';
            if (formPenguji) formPenguji.reset();
            if (editIdField) editIdField.value = '';
        });
    }

    // 2. Logika untuk semua tombol "Edit" di dalam tabel
    const tableBody = document.querySelector('#penguji-luar .table tbody');
    if (tableBody) {
        tableBody.addEventListener('click', function(event) {
            const editButton = event.target.closest('.btn-edit-penguji-luar');
            
            if (editButton) {
                modalTitleText.textContent = 'Edit Kegiatan Penguji Luar IPB';
                const data = editButton.dataset;

                // Isi form dengan data yang ada
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

// Pembimbing Luar IPB Form
document.addEventListener('DOMContentLoaded', function () {

    const modalElement = document.getElementById('modalPembimbingLuar');
    if (!modalElement) {
        return; // Keluar jika modal tidak ada di halaman ini
    }

    const modalPembimbingLuar = new bootstrap.Modal(modalElement);
    const modalTitleText = document.getElementById('modalTitleTextPembimbingLuar');
    const formPembimbing = document.getElementById('formPembimbingLuar');
    const editIdField = document.getElementById('editPembimbingLuarId');

    // 1. Logika untuk Tombol "Tambah Data"
    const btnTambah = document.getElementById('btnTambahPembimbingLuar');
    if (btnTambah) {
        btnTambah.addEventListener('click', function () {
            modalTitleText.textContent = 'Tambah Kegiatan Pembimbing Luar IPB';
            if (formPembimbing) formPembimbing.reset();
            if (editIdField) editIdField.value = '';
        });
    }

    // 2. Logika untuk semua tombol "Edit" di dalam tabel
    const tableBody = document.querySelector('#pembimbing-luar .table tbody');
    if (tableBody) {
        tableBody.addEventListener('click', function(event) {
            const editButton = event.target.closest('.btn-edit-pembimbing-luar');
            
            if (editButton) {
                modalTitleText.textContent = 'Edit Kegiatan Pembimbing Luar IPB';
                const data = editButton.dataset;

                // Isi form dengan data yang ada
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

// Modal Detail Pengajaran Lama
document.addEventListener('DOMContentLoaded', function () {

    const modalElement = document.getElementById('modalDetailPengajaranLama');
    if (!modalElement) {
        return;
    }

    // Menggunakan event delegation pada tabel untuk menangkap klik tombol detail
    const tableBody = document.querySelector('#pengajaran-lama .table tbody');
    if (tableBody) {
        tableBody.addEventListener('click', function(event) {
            const detailButton = event.target.closest('.btn-lihat-detail');
            
            if (detailButton) {
                const data = detailButton.dataset;

                // Mengisi setiap elemen 'p' di modal dengan data dari tombol
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

                // Memperbarui sumber dokumen pada elemen <embed>
                const docViewer = document.getElementById('detail_pl_document_viewer');
                if (data.dokumen_path) {
                    docViewer.setAttribute('src', data.dokumen_path);
                } else {
                    // Jika tidak ada path, kosongkan viewer
                    docViewer.setAttribute('src', '');
                }
            }
        });
    }
});

// Modal Detail Pengajaran Luar
document.addEventListener('DOMContentLoaded', function () {

    const modalElement = document.getElementById('modalDetailPengajaranLuar');
    if (!modalElement) {
        return;
    }

    // Menggunakan event delegation pada tabel untuk menangkap klik tombol detail
    const tableBody = document.querySelector('#pengajaran-luar .table tbody');
    if (tableBody) {
        tableBody.addEventListener('click', function(event) {
            const detailButton = event.target.closest('.btn-lihat-detail');
            
            if (detailButton) {
                const data = detailButton.dataset;

                // Mengisi setiap elemen di modal detail
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

                // Memperbarui viewer dokumen
                const docViewer = document.getElementById('detail_pluar_document_viewer');
                if (data.dokumen_path) {
                    docViewer.setAttribute('src', data.dokumen_path);
                } else {
                    docViewer.setAttribute('src', '');
                }
            }
        });
    }
});

// Modal Detail Pengujian Lama
document.addEventListener('DOMContentLoaded', function () {

    const modalElement = document.getElementById('modalDetailPengujianLama');
    if (!modalElement) {
        return;
    }

    // Menggunakan event delegation pada tabel untuk menangkap klik tombol detail
    const tableBody = document.querySelector('#pengujian-lama .table tbody');
    if (tableBody) {
        tableBody.addEventListener('click', function(event) {
            const detailButton = event.target.closest('.btn-lihat-detail-pengujian');
            
            if (detailButton) {
                const data = detailButton.dataset;

                // Mengisi setiap elemen di modal detail
                document.getElementById('detail_pjl_kegiatan').textContent = data.kegiatan || '-';
                document.getElementById('detail_pjl_nama').textContent = data.nama || '-';
                document.getElementById('detail_pjl_tahun_semester').textContent = data.tahun_semester || '-';
                document.getElementById('detail_pjl_nim').textContent = data.nim || '-';
                document.getElementById('detail_pjl_nama_mahasiswa').textContent = data.nama_mahasiswa || '-';
                document.getElementById('detail_pjl_departemen').textContent = data.departemen || '-';

                // Memperbarui viewer dokumen
                const docViewer = document.getElementById('detail_pjl_document_viewer');
                if (data.dokumen_path) {
                    docViewer.setAttribute('src', data.dokumen_path);
                } else {
                    docViewer.setAttribute('src', '');
                }
            }
        });
    }
});

// Modal Detail Pembimbing Lama
document.addEventListener('DOMContentLoaded', function () {

    const modalElement = document.getElementById('modalDetailPembimbingLama');
    if (!modalElement) {
        return;
    }

    // Menggunakan event delegation pada tabel untuk menangkap klik tombol detail
    const tableBody = document.querySelector('#pembimbing-lama .table tbody');
    if (tableBody) {
        tableBody.addEventListener('click', function(event) {
            const detailButton = event.target.closest('.btn-lihat-detail-pembimbing');
            
            if (detailButton) {
                const data = detailButton.dataset;

                // Mengisi setiap elemen di modal detail
                document.getElementById('detail_pbl_kegiatan').textContent = data.kegiatan || '-';
                document.getElementById('detail_pbl_nama').textContent = data.nama || '-';
                document.getElementById('detail_pbl_tahun_semester').textContent = data.tahun_semester || '-';
                document.getElementById('detail_pbl_lokasi').textContent = data.lokasi || '-';
                document.getElementById('detail_pbl_nim').textContent = data.nim || '-';
                document.getElementById('detail_pbl_nama_mahasiswa').textContent = data.nama_mahasiswa || '-';
                document.getElementById('detail_pbl_departemen').textContent = data.departemen || '-';
                document.getElementById('detail_pbl_nama_dokumen').textContent = data.nama_dokumen || '-';

                // Memperbarui viewer dokumen
                const docViewer = document.getElementById('detail_pbl_document_viewer');
                if (data.dokumen_path) {
                    docViewer.setAttribute('src', data.dokumen_path);
                } else {
                    docViewer.setAttribute('src', '');
                }
            }
        });
    }
});

// Modal Detail Penguji Luar
document.addEventListener('DOMContentLoaded', function () {

    const modalElement = document.getElementById('modalDetailPengujiLuar');
    if (!modalElement) {
        return;
    }

    // Menggunakan event delegation pada tabel untuk menangkap klik tombol detail
    const tableBody = document.querySelector('#penguji-luar .table tbody');
    if (tableBody) {
        tableBody.addEventListener('click', function(event) {
            const detailButton = event.target.closest('.btn-lihat-detail-penguji-luar');
            
            if (detailButton) {
                const data = detailButton.dataset;

                // Mengisi setiap elemen di modal detail
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

                // Memperbarui viewer dokumen
                const docViewer = document.getElementById('detail_pjl_luar_document_viewer');
                if (data.dokumen_path) {
                    docViewer.setAttribute('src', data.dokumen_path);
                } else {
                    docViewer.setAttribute('src', '');
                }
            }
        });
    }
});

// Modal Detail Pembimbing Luar
document.addEventListener('DOMContentLoaded', function () {

    const modalElement = document.getElementById('modalDetailPembimbingLuar');
    if (!modalElement) {
        return;
    }

    // Menggunakan event delegation pada tabel untuk menangkap klik tombol detail
    const tableBody = document.querySelector('#pembimbing-luar .table tbody');
    if (tableBody) {
        tableBody.addEventListener('click', function(event) {
            const detailButton = event.target.closest('.btn-lihat-detail-pembimbing-luar');
            
            if (detailButton) {
                const data = detailButton.dataset;

                // Mengisi setiap elemen di modal detail
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

                // Memperbarui viewer dokumen
                const docViewer = document.getElementById('detail_pbl_luar_document_viewer');
                if (data.dokumen_path) {
                    docViewer.setAttribute('src', data.dokumen_path);
                } else {
                    docViewer.setAttribute('src', '');
                }
            }
        });
    }
});

// Logika untuk Konfirmasi Pendidikan
// Logika untuk Konfirmasi Pendidikan (Judul Statis)
document.addEventListener('DOMContentLoaded', function () {

    const popupOverlay = document.getElementById('modalKonfirmasiPendidikan');
    if (!popupOverlay) return; 

    // Elemen judul tidak perlu diubah, jadi tidak perlu didefinisikan di sini
    const btnKembali = document.getElementById('popupBtnKembali');
    const btnTerima = document.getElementById('popupBtnTerima');
    const btnTolak = document.getElementById('popupBtnTolak');
    
    let currentDataId = null;

    document.addEventListener('click', function(event) {
        const konfirmasiButton = event.target.closest('.btn-konfirmasi-pendidikan');
        if (konfirmasiButton) {
            event.preventDefault();
            
            // 2 baris kode untuk mengubah judul dinamis telah dihapus dari sini

            currentDataId = konfirmasiButton.dataset.id;
            popupOverlay.style.display = 'flex';
        }
    });

    function hidePopup() {
        currentDataId = null;
        popupOverlay.style.display = 'none';
    }

    btnKembali.addEventListener('click', hidePopup);

    btnTerima.addEventListener('click', function() {
        if (currentDataId) {
            console.log(`Aksi 'Terima' untuk ID: ${currentDataId}`);
        }
        hidePopup();
    });

    btnTolak.addEventListener('click', function() {
        if (currentDataId) {
            console.log(`Aksi 'Tolak' untuk ID: ${currentDataId}`);
        }
        hidePopup();
    });

    popupOverlay.addEventListener('click', function(event) {
        if (event.target === popupOverlay) {
            hidePopup();
        }
    });
});