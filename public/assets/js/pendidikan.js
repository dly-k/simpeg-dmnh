document.addEventListener("DOMContentLoaded", () => {
  // == FUNGSI UNTUK MENGINGAT TAB AKTIF ==
  const tabs = document.querySelectorAll('#pendidikanTab .nav-link');
  const activeTabTarget = localStorage.getItem('activePendidikanTab');
  
  if (activeTabTarget) {
    const tabElement = document.querySelector(`#pendidikanTab button[data-bs-target="${activeTabTarget}"]`);
    if (tabElement) {
      new bootstrap.Tab(tabElement).show();
    }
  }

  tabs.forEach(tab => {
    tab.addEventListener('shown.bs.tab', event => {
      localStorage.setItem('activePendidikanTab', event.target.getAttribute('data-bs-target'));
    });
  });

  // KODE BARU UNTUK TOMBOL SELESAI PADA MODAL KUSTOM
  const modalBerhasil = document.getElementById("modalBerhasil");
  const btnSelesai = document.getElementById("btnSelesai");

  if (btnSelesai && modalBerhasil) {
    btnSelesai.addEventListener('click', () => {
      modalBerhasil.classList.remove("show");
    });
  }

  // == FUNGSI BANTUAN MODAL ==
  const getModalInstance = (modalId) => {
    const modalElement = document.getElementById(modalId);
    return modalElement ? bootstrap.Modal.getOrCreateInstance(modalElement) : null;
  };

  // FUNGSI BARU UNTUK MENAMPILKAN MODAL KUSTOM
const showSuccessModal = (message) => {
  const modalBerhasil = document.getElementById("modalBerhasil");
  const berhasilSubtitle = document.getElementById("berhasil-subtitle");

  // Update pesan subtitle sesuai respons dari server
  if (berhasilSubtitle) {
    berhasilSubtitle.textContent = message;
  }

  // Tampilkan modal dengan menambahkan class 'show'
  if (modalBerhasil) {
    modalBerhasil.classList.add("show");
    
    // --- TAMBAHKAN BARIS INI UNTUK MEMUTAR MUSIK ---
    document.getElementById('success-sound')?.play();
  }
};
  
  // == KONFIGURASI FORM UNTUK TAMBAH & EDIT ==
  const formConfigs = {
    'pengajaran-lama': { 
      modalId: "modalTambahEditPengajaranLama", formId: "formPengajaranLama", btnId: "btnSimpanPengajaran", 
      url: "/pendidikan/pengajaran-lama", title: "Pengajaran Lama" 
    },
    'pengajaran-luar': { 
      modalId: "modalPengajaranLuar", formId: "formPengajaranLuar", btnId: "btnSimpanPengajaranLuar", 
      url: "/pendidikan/pengajaran-luar", title: "Pengajaran Luar IPB"
    },
    'pengujian-lama': { 
      modalId: "modalPengujianLama", formId: "formPengujianLama", btnId: "btnSimpanPengujianLama", 
      url: "/pendidikan/pengujian-lama", title: "Pengujian Lama"
    },
    'pembimbing-lama': { 
      modalId: "modalPembimbingLama", formId: "formPembimbingLama", btnId: "btnSimpanPembimbingLama", 
      url: "/pendidikan/pembimbing-lama", title: "Pembimbing Lama"
    },
    'penguji-luar': { 
      modalId: "modalPengujiLuar", formId: "formPengujiLuar", btnId: "btnSimpanPengujiLuar", 
      url: "/pendidikan/penguji-luar", title: "Penguji Luar IPB"
    },
    'pembimbing-luar': { 
      modalId: "modalPembimbingLuar", formId: "formPembimbingLuar", btnId: "btnSimpanPembimbingLuar", 
      url: "/pendidikan/pembimbing-luar", title: "Pembimbing Luar IPB"
    },
  };

  // FUNGSI UNTUK MERESET FILE INPUT
  const resetFileInput = (form) => {
      const fileInput = form.querySelector('.file-input');
      if (fileInput) {
          const fileDropArea = fileInput.closest('.file-drop-area');
          const fileMessage = fileDropArea.querySelector('.file-message');
          fileInput.value = ''; // Hapus file yang dipilih
          fileMessage.textContent = 'Drag & Drop File here';
          fileDropArea.classList.remove('file-selected');
      }
  };

  // FUNGSI UNTUK MENANGANI OPEN MODAL (TAMBAH DATA)
  Object.keys(formConfigs).forEach(key => {
    const config = formConfigs[key];
    const btnTambah = document.getElementById(`btnTambah${config.title.replace(/\s+/g, '')}`);
    btnTambah?.addEventListener('click', () => {
      const form = document.getElementById(config.formId);
      form.reset(); // Reset semua field form
      form.querySelector('input[name="id"]').value = ''; // Pastikan ID kosong
      resetFileInput(form); // Reset tampilan file input
      
      const modalTitle = document.querySelector(`#${config.modalId} .modal-title span`);
      if (modalTitle) modalTitle.textContent = `Tambah ${config.title}`;
    });
  });

  // FUNGSI UNTUK MENANGANI OPEN MODAL (EDIT DATA)
  document.body.addEventListener('click', async (e) => {
    const editButton = e.target.closest('.btn-edit');
    if (!editButton) return;

    const key = Object.keys(formConfigs).find(k => editButton.classList.contains(`btn-edit-${k.replace('_','-')}`));
    if (!key) return;

    const config = formConfigs[key];
    const id = editButton.dataset.id;
    const form = document.getElementById(config.formId);
    
    try {
        const response = await fetch(`${config.url}/${id}/edit`);
        if (!response.ok) throw new Error('Gagal memuat data untuk diedit.');
        const data = await response.json();

        // Populate form
        form.reset();
        resetFileInput(form);
        Object.keys(data).forEach(fieldName => {
            const field = form.querySelector(`[name="${fieldName}"]`);
            if (field) {
                field.value = data[fieldName];
            }
        });
        
        const modalTitle = document.querySelector(`#${config.modalId} .modal-title span`);
        if (modalTitle) modalTitle.textContent = `Edit ${config.title}`;

        getModalInstance(config.modalId).show();

    } catch (error) {
        console.error('Edit Error:', error);
        alert(error.message);
    }
  });


  // == FUNGSI SUBMIT FORM DENGAN AJAX (UNTUK CREATE & UPDATE) ==
  const handleFormSubmit = async (config) => {
      const form = document.getElementById(config.formId);
      const saveButton = document.getElementById(config.btnId);
      if (!form || !saveButton) return;

      const formData = new FormData(form);
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      const originalButtonText = saveButton.innerHTML;
      
      const id = formData.get('id');
      const isUpdate = !!id;
      const url = isUpdate ? `${config.url}/${id}` : config.url;
      
      saveButton.disabled = true;
      saveButton.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Menyimpan...`;

      try {
          const response = await fetch(url, {
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
                // Tunggu modal benar-benar tertutup sebelum menampilkan notifikasi
                document.getElementById(config.modalId).addEventListener('hidden.bs.modal', () => {
                    showSuccessModal(data.success);
                    // Simpan tab aktif dan reload halaman
                    const activeTab = document.querySelector('#pendidikanTab .nav-link.active');
                    if (activeTab) {
                      localStorage.setItem('activePendidikanTab', activeTab.getAttribute('data-bs-target'));
                    }
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

  // Daftarkan event listener untuk semua tombol simpan
  Object.values(formConfigs).forEach((config) => {
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

  const fillElement = (id, value) => {
    const element = document.getElementById(id);
    if (element) element.textContent = value || '-';
  };
  
  const fillDocumentViewer = (id, path) => {
    const viewer = document.getElementById(id);
    if (viewer) {
        if (path) {
            const relativePath = path.includes('/storage/') ? path.split('/storage/')[1] : path;
            viewer.src = `/dokumen/preview/${relativePath}`;
        } else {
            viewer.src = '';
        }
    }
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
        const kegiatanText = data.kegiatan || 'Melaksanakan perkuliahan/tutorial dan membimbing, menguji serta menyelenggarakan pendidikan di laboratorium.';
        fillElement('detail_pl_kegiatan', kegiatanText);
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