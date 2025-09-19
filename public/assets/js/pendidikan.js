document.addEventListener("DOMContentLoaded", () => {
  // == FUNGSI UNTUK MENGINGAT TAB AKTIF ==
  const tabs = document.querySelectorAll('#pendidikanTab .nav-link');
  const activeTabTarget = localStorage.getItem('activePendidikanTab');
  
  if (activeTabTarget) {
    const tabElement = document.querySelector(`#pendidikanTab button[data-bs-target="${activeTabTarget}"]`);
    if (tabElement) {
      new bootstrap.Tab(tabElement).show();
    }
    localStorage.removeItem('activePendidikanTab');
  }

  tabs.forEach(tab => {
    tab.addEventListener('shown.bs.tab', event => {
      localStorage.setItem('activePendidikanTab', event.target.getAttribute('data-bs-target'));
    });
  });

  // == FUNGSI BANTUAN MODAL ==
  const getModalInstance = (modalId) => {
    const modalElement = document.getElementById(modalId);
    return modalElement ? bootstrap.Modal.getOrCreateInstance(modalElement) : null;
  };

  const showSuccessModal = (title, subtitle) => {
    const berhasilTitle = document.getElementById("berhasil-title");
    const berhasilSubtitle = document.getElementById("berhasil-subtitle");
    const modalBerhasil = document.getElementById("modalBerhasil");
    if (berhasilTitle) berhasilTitle.textContent = title;
    if (berhasilSubtitle) berhasilSubtitle.textContent = subtitle;

    if (modalBerhasil) {
      modalBerhasil.classList.add("show");
      setTimeout(() => {
        modalBerhasil.classList.remove("show");
      }, 1500);
    }
  };
  
  // == KONFIGURASI FORM ==
  const formConfigs = [
    { modalId: "modalTambahEditPengajaranLama", formId: "formPengajaranLama", btnId: "btnSimpanPengajaran", postUrl: "/pendidikan/pengajaran-lama" },
    { modalId: "modalPengajaranLuar", formId: "formPengajaranLuar", btnId: "btnSimpanPengajaranLuar", postUrl: "/pendidikan/pengajaran-luar" },
    { modalId: "modalPengujianLama", formId: "formPengujianLama", btnId: "btnSimpanPengujianLama", postUrl: "/pendidikan/pengujian-lama" },
    { modalId: "modalPembimbingLama", formId: "formPembimbingLama", btnId: "btnSimpanPembimbingLama", postUrl: "/pendidikan/pembimbing-lama" },
    { modalId: "modalPengujiLuar", formId: "formPengujiLuar", btnId: "btnSimpanPengujiLuar", postUrl: "/pendidikan/penguji-luar" },
    { modalId: "modalPembimbingLuar", formId: "formPembimbingLuar", btnId: "btnSimpanPembimbingLuar", postUrl: "/pendidikan/pembimbing-luar" },
  ];

  // == FUNGSI SUBMIT FORM DENGAN AJAX ==
  const handleFormSubmit = async (config) => {
      const form = document.getElementById(config.formId);
      const saveButton = document.getElementById(config.btnId);
      if (!form || !saveButton) return;

      const formData = new FormData(form);
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      const originalButtonText = saveButton.innerHTML;
      
      saveButton.disabled = true;
      saveButton.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Menyimpan...`;

      try {
          const response = await fetch(config.postUrl, {
              method: 'POST',
              headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
              body: formData,
          });
          const data = await response.json();

          if (!response.ok) {
              if (response.status === 422 && data.errors) {
                  let errorMessages = "Periksa kembali isian Anda:\n";
                  Object.values(data.errors).forEach(errs => errorMessages += `- ${errs.join('\n- ')}\n`);
                  alert(errorMessages);
              } else {
                  throw new Error(data.message || 'Terjadi kesalahan pada server.');
              }
          } else {
              const formModal = getModalInstance(config.modalId);
              if (formModal) {
                formModal.hide();
                document.getElementById(config.modalId).addEventListener('hidden.bs.modal', () => {
                    showSuccessModal("Data Berhasil Disimpan", data.success);
                    const activeTabTarget = document.querySelector('#pendidikanTab .nav-link.active').getAttribute('data-bs-target');
                    localStorage.setItem('activePendidikanTab', activeTabTarget);
                    setTimeout(() => { location.reload(); }, 1600);
                }, { once: true });
              }
          }
      } catch (error) {
          console.error('Submit Error:', error);
          alert('Gagal menyimpan data. Pastikan semua isian valid dan coba lagi.');
      } finally {
          saveButton.disabled = false;
          saveButton.innerHTML = originalButtonText;
      }
  };

  formConfigs.forEach((config) => {
    const saveButton = document.getElementById(config.btnId);
    saveButton?.addEventListener("click", () => handleFormSubmit(config));
  });

  // == SCRIPT UNTUK PENANDA FILE INPUT ==
  document.querySelectorAll('.file-input').forEach(inputElement => {
    inputElement.addEventListener('change', function() {
      const fileDropArea = this.closest('.file-drop-area');
      const fileMessage = fileDropArea.querySelector('.file-message');
      if (this.files.length > 0) {
        fileMessage.textContent = this.files[0].name;
        fileDropArea.classList.add('file-selected');
      } else {
        fileMessage.textContent = 'Drag & Drop File here';
        fileDropArea.classList.remove('file-selected');
      }
    });
  });

  // ===============================================
  // == FUNGSI UNTUK MENAMPILKAN DETAIL DATA ==
  // ===============================================

  // Fungsi bantuan untuk mengisi elemen HTML
  const fillElement = (id, value) => {
    const element = document.getElementById(id);
    if (element) element.textContent = value || '-';
  };
  
  const fillDocumentViewer = (id, path) => {
    const viewer = document.getElementById(id);
    if (viewer) viewer.src = path ? `/storage/${path}` : '';
  };

  const handleViewDetail = async (button, url, fillFunction) => {
    const id = button.getAttribute('data-id');
    if (!id) return;

    try {
      const response = await fetch(`${url}/${id}`);
      if (!response.ok) throw new Error('Gagal mengambil data.');
      
      const data = await response.json();
      fillFunction(data);

    } catch (error) {
      console.error('Error fetching detail:', error);
      alert('Tidak dapat memuat detail data.');
    }
  };

  // Fungsi untuk mereset/membersihkan modal
  const resetPengajaranLamaModal = () => {
    const fields = ['kegiatan', 'nama', 'tahun_semester', 'kode_mk', 'nama_mk', 'pengampu', 'sks_kuliah', 'sks_praktikum', 'jenis', 'kelas_paralel', 'jumlah_pertemuan'];
    fields.forEach(field => fillElement(`detail_pl_${field}`, 'Memuat...'));
    fillDocumentViewer('detail_pl_document_viewer', '');
  };

  const resetPengajaranLuarModal = () => {
    const fields = ['nama', 'tahun_semester', 'universitas', 'kode_mk', 'nama_mk', 'program_studi', 'sks_kuliah', 'sks_praktikum', 'jenis', 'kelas_paralel', 'jumlah_pertemuan', 'insidental', 'lebih_satu_semester'];
    fields.forEach(field => fillElement(`detail_pluar_${field}`, 'Memuat...'));
    fillDocumentViewer('detail_pluar_document_viewer', '');
  };

  const resetPengujianLamaModal = () => {
    const fields = ['kegiatan', 'nama', 'tahun_semester', 'nim', 'nama_mahasiswa', 'departemen'];
    fields.forEach(field => fillElement(`detail_pjl_${field}`, 'Memuat...'));
    fillDocumentViewer('detail_pjl_document_viewer', '');
  };

  const resetPembimbingLamaModal = () => {
    const fields = ['kegiatan', 'nama', 'tahun_semester', 'lokasi', 'nim', 'nama_mahasiswa', 'departemen', 'nama_dokumen'];
    fields.forEach(field => fillElement(`detail_pbl_${field}`, 'Memuat...'));
    fillDocumentViewer('detail_pbl_document_viewer', '');
  };

  const resetPengujiLuarModal = () => {
    const fields = ['kegiatan', 'nama', 'status', 'tahun_semester', 'nim', 'nama_mahasiswa', 'universitas', 'program_studi', 'insidental', 'lebih_satu_semester'];
    fields.forEach(field => fillElement(`detail_pjl_luar_${field}`, 'Memuat...'));
    fillDocumentViewer('detail_pjl_luar_document_viewer', '');
  };

  const resetPembimbingLuarModal = () => {
    const fields = ['kegiatan', 'nama', 'status', 'tahun_semester', 'nim', 'nama_mahasiswa', 'universitas', 'program_studi', 'insidental', 'lebih_satu_semester'];
    fields.forEach(field => fillElement(`detail_pbl_luar_${field}`, 'Memuat...'));
    fillDocumentViewer('detail_pbl_luar_document_viewer', '');
  };

  // 1. Pengajaran Lama
  document.querySelectorAll('.btn-lihat-pengajaran-lama').forEach(button => {
    button.addEventListener('click', () => {
      resetPengajaranLamaModal();
      handleViewDetail(button, '/pendidikan/pengajaran-lama', data => {
        fillElement('detail_pl_kegiatan', data.kegiatan);
        fillElement('detail_pl_nama', data.pegawai?.nama_lengkap);
        fillElement('detail_pl_tahun_semester', data.tahun_semester);
        fillElement('detail_pl_kode_mk', data.kode_mk);
        fillElement('detail_pl_nama_mk', data.nama_mk);
        fillElement('detail_pl_pengampu', data.pengampu);
        fillElement('detail_pl_sks_kuliah', data.sks_kuliah);
        fillElement('detail_pl_sks_praktikum', data.sks_praktikum);
        fillElement('detail_pl_jenis', data.jenis);
        fillElement('detail_pl_kelas_paralel', data.kelas_paralel);
        fillElement('detail_pl_jumlah_pertemuan', data.jumlah_pertemuan);
        fillDocumentViewer('detail_pl_document_viewer', data.file_path);
      });
    });
  });

  // 2. Pengajaran Luar
  document.querySelectorAll('.btn-lihat-pengajaran-luar').forEach(button => {
    button.addEventListener('click', () => {
      resetPengajaranLuarModal();
      handleViewDetail(button, '/pendidikan/pengajaran-luar', data => {
        fillElement('detail_pluar_nama', data.pegawai?.nama_lengkap);
        fillElement('detail_pluar_tahun_semester', data.tahun_semester);
        fillElement('detail_pluar_universitas', data.universitas);
        fillElement('detail_pluar_kode_mk', data.kode_mk);
        fillElement('detail_pluar_nama_mk', data.nama_mk);
        fillElement('detail_pluar_program_studi', data.program_studi);
        fillElement('detail_pluar_sks_kuliah', data.sks_kuliah);
        fillElement('detail_pluar_sks_praktikum', data.sks_praktikum);
        fillElement('detail_pluar_jenis', data.jenis);
        fillElement('detail_pluar_kelas_paralel', data.kelas_paralel);
        fillElement('detail_pluar_jumlah_pertemuan', data.jumlah_pertemuan);
        fillElement('detail_pluar_insidental', data.is_insidental);
        fillElement('detail_pluar_lebih_satu_semester', data.is_lebih_satu_semester);
        fillDocumentViewer('detail_pluar_document_viewer', data.file_path);
      });
    });
  });

  // 3. Pengujian Lama
  document.querySelectorAll('.btn-lihat-pengujian-lama').forEach(button => {
    button.addEventListener('click', () => {
      resetPengujianLamaModal();
      handleViewDetail(button, '/pendidikan/pengujian-lama', data => {
          fillElement('detail_pjl_kegiatan', data.kegiatan);
          fillElement('detail_pjl_nama', data.pegawai?.nama_lengkap);
          fillElement('detail_pjl_tahun_semester', data.tahun_semester);
          fillElement('detail_pjl_nim', data.nim);
          fillElement('detail_pjl_nama_mahasiswa', data.nama_mahasiswa);
          fillElement('detail_pjl_departemen', data.departemen);
          fillDocumentViewer('detail_pjl_document_viewer', data.file_path);
      });
    });
  });

  // 4. Pembimbing Lama
  document.querySelectorAll('.btn-lihat-pembimbing-lama').forEach(button => {
    button.addEventListener('click', () => {
      resetPembimbingLamaModal();
      handleViewDetail(button, '/pendidikan/pembimbing-lama', data => {
          fillElement('detail_pbl_kegiatan', data.kegiatan);
          fillElement('detail_pbl_nama', data.pegawai?.nama_lengkap);
          fillElement('detail_pbl_tahun_semester', data.tahun_semester);
          fillElement('detail_pbl_lokasi', data.lokasi);
          fillElement('detail_pbl_nim', data.nim);
          fillElement('detail_pbl_nama_mahasiswa', data.nama_mahasiswa);
          fillElement('detail_pbl_departemen', data.departemen);
          fillElement('detail_pbl_nama_dokumen', data.nama_dokumen);
          fillDocumentViewer('detail_pbl_document_viewer', data.file_path);
      });
    });
  });

  // 5. Penguji Luar
  document.querySelectorAll('.btn-lihat-penguji-luar').forEach(button => {
    button.addEventListener('click', () => {
      resetPengujiLuarModal();
      handleViewDetail(button, '/pendidikan/penguji-luar', data => {
          fillElement('detail_pjl_luar_kegiatan', data.kegiatan);
          fillElement('detail_pjl_luar_nama', data.pegawai?.nama_lengkap);
          fillElement('detail_pjl_luar_status', data.status);
          fillElement('detail_pjl_luar_tahun_semester', data.tahun_semester);
          fillElement('detail_pjl_luar_nim', data.nim);
          fillElement('detail_pjl_luar_nama_mahasiswa', data.nama_mahasiswa);
          fillElement('detail_pjl_luar_universitas', data.universitas);
          fillElement('detail_pjl_luar_program_studi', data.program_studi);
          fillElement('detail_pjl_luar_insidental', data.is_insidental);
          fillElement('detail_pjl_luar_lebih_satu_semester', data.is_lebih_satu_semester);
          fillDocumentViewer('detail_pjl_luar_document_viewer', data.file_path);
      });
    });
  });

  // 6. Pembimbing Luar
  document.querySelectorAll('.btn-lihat-pembimbing-luar').forEach(button => {
    button.addEventListener('click', () => {
      resetPembimbingLuarModal();
      handleViewDetail(button, '/pendidikan/pembimbing-luar', data => {
          fillElement('detail_pbl_luar_kegiatan', data.kegiatan);
          fillElement('detail_pbl_luar_nama', data.pegawai?.nama_lengkap);
          fillElement('detail_pbl_luar_status', data.status);
          fillElement('detail_pbl_luar_tahun_semester', data.tahun_semester);
          fillElement('detail_pbl_luar_nim', data.nim);
          fillElement('detail_pbl_luar_nama_mahasiswa', data.nama_mahasiswa);
          fillElement('detail_pbl_luar_universitas', data.universitas);
          fillElement('detail_pbl_luar_program_studi', data.program_studi);
          fillElement('detail_pbl_luar_insidental', data.is_insidental);
          fillElement('detail_pbl_luar_lebih_satu_semester', data.is_lebih_satu_semester);
          fillDocumentViewer('detail_pbl_luar_document_viewer', data.file_path);
      });
    });
  });
});