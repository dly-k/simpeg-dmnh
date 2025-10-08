document.addEventListener("DOMContentLoaded", () => {
  /**
   * Menginisialisasi semua navigasi tab (utama dan sub-tab).
   */
  const initTabs = () => {
    document.getElementById("main-tab-nav")?.addEventListener("click", (e) => {
      const tabButton = e.target.closest("button.nav-link");
      if (!tabButton) return;
      
      document.querySelectorAll("#main-tab-nav .nav-link").forEach(t => t.classList.remove("active"));
      document.querySelectorAll(".main-tab-content").forEach(c => c.style.display = "none");
      
      tabButton.classList.add("active");
      const contentId = `${tabButton.dataset.mainTab}-content`;
      const contentElement = document.getElementById(contentId);
      if (contentElement) contentElement.style.display = "block";
    });

    document.querySelector(".main-content").addEventListener('click', function(e) {
        const subTabButton = e.target.closest('.sub-tab-nav button');
        if (!subTabButton) return;
        const subTabNav = subTabButton.closest('.sub-tab-nav');
        const parentContent = subTabButton.closest('.main-tab-content');
        if (!subTabNav || !parentContent) return;
        subTabNav.querySelectorAll('button').forEach(btn => btn.classList.remove('active'));
        parentContent.querySelectorAll('.sub-tab-content').forEach(c => c.style.display = 'none');
        subTabButton.classList.add('active');
        const contentId = subTabButton.dataset.tab;
        const contentElement = parentContent.querySelector(`#${contentId}`);
        if (contentElement) contentElement.style.display = 'block';
    });
  };

  /**
   * Menginisialisasi Modal Konfirmasi Hapus untuk semua form hapus.
   */
  const initDeleteConfirmation = () => {
    const modalElement = document.getElementById("modalKonfirmasiHapus");
    if (!modalElement) return;

    const btnConfirm = document.getElementById("btnKonfirmasiHapus");
    const btnCancel = document.getElementById("btnBatalHapus");
    let formToSubmit = null;

    const showModal = () => {
        modalElement.style.display = "flex";
        setTimeout(() => modalElement.classList.add('show'), 10);
    };

    const hideModal = () => {
        modalElement.classList.remove('show');
        setTimeout(() => modalElement.style.display = 'none', 200);
    };

    document.body.addEventListener('submit', function(e) {
      if (e.target.matches('.form-hapus-efile, .form-hapus-sk')) {
        e.preventDefault(); 
        formToSubmit = e.target;
        showModal();
      }
    });

    btnConfirm?.addEventListener('click', function() {
      if (formToSubmit) {
        formToSubmit.submit();
      }
    });
    
    btnCancel?.addEventListener('click', hideModal);
    modalElement.addEventListener('click', (event) => {
        if (event.target === modalElement) {
            hideModal();
        }
    });
  };

  /**
   * Menginisialisasi dropdown Kategori -> Jenis Dokumen di dalam modal tambah E-File.
   */
  const initKategoriMapping = () => {
    const jenisDokumenData = {
      biodata: ["Pas Foto", "KTP", "NPWP", "Kartu Pegawai", "Kartu Keluarga"],
      pendidikan: ["Ijazah S1", "Transkrip S1", "Ijazah S2", "Transkrip S2", "Ijazah S3", "Transkrip S3"],
      jf: ["SK Asisten Ahli", "SK Lektor", "SK Lektor Kepala", "SK Guru Besar", "Sertifikasi Dosen"],
      sk: ["SK CPNS", "SK PNS", "SK Kenaikan Gaji Berkala"],
      sp: ["Surat Tugas", "Surat Pernyataan Melaksanakan Tugas (SPMT)"],
      lain: ["Sertifikat Pelatihan", "Penghargaan", "Lain-lain"]
    };

    const kategoriSelect = document.getElementById("kategori");
    const jenisSelect = document.getElementById("jenis-dokumen");

    if (!kategoriSelect || !jenisSelect) return;

    kategoriSelect.addEventListener("change", function () {
      jenisSelect.innerHTML = '<option value="" selected disabled>-- Pilih Jenis Dokumen --</option>';
      const kategori = this.value;
      if (jenisDokumenData[kategori]) {
        jenisDokumenData[kategori].forEach((jenis) => {
          const opt = document.createElement("option");
          opt.value = jenis;
          opt.textContent = jenis;
          jenisSelect.appendChild(opt);
        });
      }
    });
  };
  
  /**
   * Menangani klik pada item file (E-File) untuk membuka file di tab baru.
   */
  const initFileItemClick = () => {
      document.body.addEventListener('click', function(e) {
          const fileItem = e.target.closest('.file-item');
          
          if (!fileItem || e.target.closest('.file-item-actions')) {
              return; 
          }

          const fileUrl = fileItem.dataset.fileUrl;
          if(fileUrl) {
              window.open(fileUrl, '_blank');
          }
      });
  };

  /**
   * Mengaktifkan tab dan sub-tab berdasarkan parameter di URL (untuk filter).
   */
  const restoreTabsFromUrl = () => {
    const params = new URLSearchParams(window.location.search);
    const mainTab = params.get('tab');
    const subTab = params.get('subtab');

    if (mainTab) {
        document.querySelector(`#main-tab-nav .nav-link[data-main-tab="${mainTab}"]`)?.click();
    }
    if (subTab) {
        setTimeout(() => {
            document.querySelector(`.sub-tab-nav button[data-tab="${subTab}"]`)?.click();
        }, 50);
    }
  };

  /**
   * Menangani kemunculan modal sukses, musik, dan navigasi tab setelah form disubmit.
   */
  const handleSuccessFlow = () => {
    const trigger = document.getElementById('success-trigger');
    if (!trigger) return;
    
    const modalBerhasil = document.getElementById('modalBerhasil');
    const titleElement = document.getElementById('berhasil-title');
    const subtitleElement = document.getElementById('berhasil-subtitle');
    const btnSelesai = document.getElementById('btnSelesai');
    
    const title = trigger.dataset.title;
    const message = trigger.dataset.message;
    const activeTab = trigger.dataset.activeTab;
    const activeSubtab = trigger.dataset.activeSubtab;

    const successSound = new Audio('/assets/sounds/Success.mp3');

    const hideSuccessModal = () => {
        if(modalBerhasil) modalBerhasil.classList.remove('show');
    };

    const showSuccessModal = () => {
        if(titleElement) titleElement.textContent = title;
        if(subtitleElement) subtitleElement.textContent = message;
        if(modalBerhasil) modalBerhasil.classList.add('show');
        
        successSound.play().catch(error => console.error("Gagal memutar audio:", error));
        
        setTimeout(hideSuccessModal, 1000);
    };

    const activateTabs = () => {
        if (activeTab) {
            document.querySelector(`#main-tab-nav .nav-link[data-main-tab="${activeTab}"]`)?.click();
        }
        if (activeSubtab) {
            setTimeout(() => {
                document.querySelector(`.sub-tab-nav button[data-tab="${activeSubtab}"]`)?.click();
            }, 100);
        }
    };

    activateTabs();
    showSuccessModal();
    btnSelesai?.addEventListener('click', hideSuccessModal);
  };

  /**
   * Menginisialisasi dan mengelola semua modal form (Tambah & Edit).
   */
  const initFormModals = () => {
    document.body.addEventListener('click', function(e) {
      const addButton = e.target.closest('.btn-tambah');
      const editButton = e.target.closest('.btn-edit');
      
      if (!addButton && !editButton) return;

      const button = addButton || editButton;
      const modalTargetId = button.dataset.bsTarget;
      const modalElement = document.querySelector(modalTargetId);
      if (!modalElement) return;

      const form = modalElement.querySelector('form');
      const title = modalElement.querySelector('.modal-title');
      const methodField = form.querySelector('input[name="_method"]');
      const submitButton = modalElement.querySelector('button[type="submit"]');
      const fileHelpText = form.querySelector('.form-text');

      form.reset();
      form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
      form.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

      if (addButton) {
        title.innerHTML = '<i class="fas fa-plus-circle me-2"></i> Tambah Data';
        form.setAttribute('action', button.dataset.storeUrl);
        if (methodField) methodField.value = 'POST';
        submitButton.className = 'btn btn-success';
        submitButton.textContent = 'Simpan';
        if (fileHelpText) fileHelpText.textContent = 'Tipe file: PDF, JPG, PNG. Maks: 5 MB.';
      } else if (editButton) {
        const itemData = JSON.parse(button.dataset.item || '{}');
        
        title.innerHTML = '<i class="fas fa-edit me-2"></i> Edit Data';
        form.setAttribute('action', button.dataset.updateUrl);
        if (methodField) methodField.value = 'PUT';
        submitButton.className = 'btn btn-warning';
        submitButton.textContent = 'Update';
        if (fileHelpText) fileHelpText.textContent = 'Kosongkan jika tidak ingin mengubah file.';
        
        for (const key in itemData) {
          const input = form.querySelector(`[name="${key}"]`);
          if (input) {
            if (input.type === 'date') {
                 input.value = itemData[key] ? itemData[key].split(' ')[0] : '';
            } else {
                 input.value = itemData[key];
            }
          }
        }
      }
    });
  };
  
  /**
   * Pencarian otomatis saat mengetik atau menekan Enter.
   */
  const initAutoSearch = () => {
    let debounceTimeout;
    
    document.querySelectorAll('form input[name^="search_"]').forEach(input => {
      input.addEventListener('keyup', (e) => {
        if (e.key === 'Enter') {
          input.closest('form').submit();
        }
      });

      input.addEventListener('input', () => {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
          input.closest('form').submit();
        }, 500);
      });
    });
  };
  
  /**
   * Menangani klik tombol "Lihat Detail" untuk semua data Pendidikan.
   */
const initPendidikanDetailModals = () => {
    // Batasi event listener hanya pada container tab Pendidikan
    const pendidikanTabContainer = document.getElementById('pendidikan-content');
    if (!pendidikanTabContainer) return;

    pendidikanTabContainer.addEventListener('click', function(e) {
      const detailButton = e.target.closest('.btn-lihat-detail');
      if (!detailButton) return;
      
      e.preventDefault();
      
      const itemId = detailButton.dataset.id;
      const typeClass = Array.from(detailButton.classList).find(c => c.startsWith('btn-lihat-') && c !== 'btn-lihat-detail');
      if (!typeClass) return;
      
      const type = typeClass.replace('btn-lihat-', '');
      const url = `/pendidikan/${type}/${itemId}`;
      const modalTarget = detailButton.dataset.bsTarget;
      const modalElement = document.querySelector(modalTarget);

      if (!modalElement) {
        console.error(`Modal with target ${modalTarget} not found.`);
        return;
      }

      const modalBody = modalElement.querySelector('.modal-body');
      const detailContainer = modalBody.querySelector('.detail-grid-container');
      const docContainer = modalBody.querySelector('.document-viewer-container');
      const fields = modalElement.querySelectorAll('p[id^="detail_"]');
      
      fields.forEach(field => {
          field.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
      });
      if(docContainer) docContainer.innerHTML = '<div class="text-center p-5"><i class="fas fa-spinner fa-spin fa-2x"></i><p class="mt-2">Memuat dokumen...</p></div>';

      fetch(url)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok.');
            return response.json();
        })
        .then(data => {
            fields.forEach(field => {
                const key = field.id.split('_').slice(2).join('_');
                let value = data[key] || '-';
                if (key === 'nama' && data.pegawai) {
                    value = data.pegawai.nama_lengkap || '-';
                }
                field.textContent = value;
            });
            if (docContainer) {
                if (data.file_path) {
                    docContainer.innerHTML = `<embed src="/storage/${data.file_path}" type="application/pdf" width="100%" height="600px" />`;
                } else {
                    docContainer.innerHTML = '<p class="text-center text-muted p-5">Tidak ada dokumen yang dilampirkan.</p>';
                }
            }
        })
        .catch(error => {
            detailContainer.innerHTML = '<div class="text-center text-danger p-5">Gagal memuat data. Silakan coba lagi nanti.</div>';
            console.error('Error fetching detail:', error);
        });
    });
};

const initSertifikatDetailModal = () => {
  const modalDetail = document.getElementById('modalDetailSertifikatKompetensi');
  if (!modalDetail) return;

  modalDetail.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      
      const setDataText = (id, attribute) => {
          const element = modalDetail.querySelector(`#${id}`);
          if (element) element.textContent = button.getAttribute(attribute) || '-';
      };

      // Mengisi semua data teks seperti sebelumnya
      setDataText('detail_sertifikat_nama', 'data-nama');
      setDataText('detail_sertifikat_kegiatan', 'data-kegiatan');
      setDataText('detail_sertifikat_judul', 'data-judul');
      setDataText('detail_sertifikat_no_reg', 'data-no-reg');
      setDataText('detail_sertifikat_no_sk', 'data-no-sk');
      setDataText('detail_sertifikat_tahun', 'data-tahun');
      setDataText('detail_sertifikat_tmt', 'data-tmt');
      setDataText('detail_sertifikat_tst', 'data-tst');
      setDataText('detail_sertifikat_bidang', 'data-bidang');
      setDataText('detail_sertifikat_lembaga', 'data-lembaga');

      // --- PERBAIKAN DIMULAI DI SINI ---
      const viewer = modalDetail.querySelector('#detail_sertifikat_document_viewer');
      const docUrl = button.getAttribute('data-dokumen');
      const container = modalDetail.querySelector('.document-viewer-container');

      if (viewer && container) {
          if (docUrl) {
              // Jika ada URL, set sumber dari embed dan pastikan elemen terlihat
              viewer.setAttribute('src', docUrl);
              container.style.display = 'block';
          } else {
              // Jika tidak ada URL, sembunyikan embed agar tidak menampilkan error
              container.style.display = 'none';
          }
      }
      // --- PERBAIKAN SELESAI ---
  });

  // Menambahkan event saat modal ditutup untuk membersihkan pratinjau
  modalDetail.addEventListener('hidden.bs.modal', function () {
    const viewer = modalDetail.querySelector('#detail_sertifikat_document_viewer');
    if (viewer) {
      viewer.setAttribute('src', ''); // Mengosongkan sumber agar tidak termuat di latar belakang
    }
  });
};

const initPembicaraDetailModal = () => {
  const observeModal = () => {
    const modalElement = document.getElementById('detailPembicaraModal');
    if (!modalElement) {
      setTimeout(observeModal, 500); // cek ulang tiap 0.5 detik
      return;
    }

    console.log('Modal ditemukan:', modalElement);

    modalElement.addEventListener('show.bs.modal', async (event) => {
      const button = event.relatedTarget;
      const pembicaraId = button.dataset.id;
      const url = `/pembicara/${pembicaraId}/edit`;

      // helper untuk set text di modal
      const setDetailText = (id, text) => {
        const el = modalElement.querySelector(`#${id}`);
        if (el) el.textContent = text || '-';
      };

      // tampilkan loading di awal
      const fields = [
        'nama','kegiatan','capaian','kategori-pembicara',
        'makalah','pertemuan','tanggal','penyelenggara',
        'tingkat','bahasa','litabmas'
      ];
      fields.forEach(f => setDetailText(`detail-${f}`, 'Memuat...'));

      const docListContainer = modalElement.querySelector('#detail-dokumen-list');
      docListContainer.innerHTML = '<p class="text-muted fst-italic col-12">Memuat dokumen...</p>';

      try {
        const response = await fetch(url, { headers: { 'Accept': 'application/json' } });
        if (!response.ok) throw new Error('Gagal mengambil data dari server.');
        const data = await response.json();

        // --- 🔹 Isi semua field teks utama ---
        setDetailText('detail-nama', data.pegawai?.nama_lengkap);
        setDetailText('detail-kegiatan', data.kegiatan === 'lainnya' ? data.kegiatan_lainnya : data.kegiatan);
        setDetailText('detail-capaian', data.kategori_capaian);
        setDetailText('detail-kategori-pembicara', data.kategori_pembicara);
        setDetailText('detail-makalah', data.judul_makalah);
        setDetailText('detail-pertemuan', data.nama_pertemuan);
        setDetailText('detail-tanggal', data.tanggal_pelaksana
          ? new Date(data.tanggal_pelaksana).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })
          : '-');
        setDetailText('detail-penyelenggara', data.penyelenggara);
        setDetailText('detail-tingkat', data.tingkat_pertemuan);
        setDetailText('detail-bahasa', data.bahasa);
        setDetailText('detail-litabmas', data.litabmas || '-');

        // --- 🔹 Render list dokumen ---
        docListContainer.innerHTML = '';
        if (Array.isArray(data.dokumen) && data.dokumen.length > 0) {
          data.dokumen.forEach(doc => {
            const fileButton = doc.file_path
              ? `<a href="/${doc.file_path}" class="btn btn-sm btn-success text-white doc-list-file-button" target="_blank"><i class="fa fa-eye me-1"></i>Lihat</a>`
              : '';

            const jenis = doc.jenis_dokumen
              ? `<div class="doc-list-item"><span class="doc-list-label">Jenis:</span><span class="doc-list-value">${doc.jenis_dokumen}</span></div>` : '';
            const nama = doc.nama_dokumen
              ? `<div class="doc-list-item"><span class="doc-list-label">Nama:</span><span class="doc-list-value">${doc.nama_dokumen}</span></div>` : '';
            const nomor = doc.nomor
              ? `<div class="doc-list-item"><span class="doc-list-label">Nomor:</span><span class="doc-list-value">${doc.nomor}</span></div>` : '';
            const tautan = doc.tautan
              ? `<div class="doc-list-item"><span class="doc-list-label">Tautan:</span><span class="doc-list-value"><a href="${doc.tautan.startsWith('http') ? doc.tautan : '//' + doc.tautan}" target="_blank">Kunjungi Tautan</a></span></div>` : '';

            docListContainer.innerHTML += `
              <div class="col-lg-6 mb-3">
                <div class="detail-doc-list">
                  ${fileButton}
                  ${jenis}
                  ${nama}
                  ${nomor}
                  ${tautan}
                </div>
              </div>`;
          });
        } else {
          docListContainer.innerHTML = '<p class="text-muted fst-italic col-12">Tidak ada dokumen yang terlampir.</p>';
        }

      } catch (err) {
        console.error('Error fetching pembicara detail:', err);
        docListContainer.innerHTML = '<p class="text-danger col-12">Gagal memuat data dokumen.</p>';
      }
    });
  };

  observeModal(); // jalankan observer
};

const initOrasiIlmiahDetailModal = () => {
    const modalDetail = document.getElementById('modalDetailOrasiIlmiah');
    if (!modalDetail) return;

    const setDataText = (id, attribute, button) => {
        const target = modalDetail.querySelector(`#${id}`);
        if (target) {
            target.textContent = button.getAttribute(attribute) || '-';
        }
    };

    modalDetail.addEventListener('show.bs.modal', (event) => {
        const button = event.relatedTarget;
        if (!button) return;

        // Mengisi data utama ke dalam modal
        setDataText('detail_orasi_pegawai', 'data-pegawai', button);
        setDataText('detail_orasi_litabmas', 'data-litabmas', button);
        setDataText('detail_orasi_kategori_pembicara', 'data-kategori', button);
        setDataText('detail_orasi_lingkup', 'data-lingkup', button);
        setDataText('detail_orasi_judul_makalah', 'data-judul', button);
        setDataText('detail_orasi_nama_pertemuan', 'data-pertemuan', button);
        setDataText('detail_orasi_penyelenggara', 'data-penyelenggara', button);
        setDataText('detail_orasi_tanggal_pelaksana', 'data-tanggal', button);
        setDataText('detail_orasi_bahasa', 'data-bahasa', button);
        setDataText('detail_orasi_jenis_dokumen', 'data-jenis-dokumen', button);
        setDataText('detail_orasi_nama_dokumen', 'data-nama-dokumen', button);
        setDataText('detail_orasi_nomor_dokumen', 'data-nomor-dokumen', button);

        // Mengisi tautan
        const tautanElement = modalDetail.querySelector('#detail_orasi_tautan');
        if (tautanElement) {
            const tautan = button.getAttribute('data-tautan');
            tautanElement.innerHTML = tautan ? `<a href="${tautan}" target="_blank">${tautan}</a>` : '-';
        }

        // Menampilkan viewer PDF
        const viewer = modalDetail.querySelector('#detail_orasi_document_viewer');
        if (viewer) {
            const fileSrc = button.getAttribute('data-dokumen-src') || '';
            viewer.setAttribute('src', fileSrc);
            // Sembunyikan viewer jika tidak ada file
            viewer.parentElement.style.display = fileSrc ? 'block' : 'none';
        }
    });

    modalDetail.addEventListener('hidden.bs.modal', () => {
        const viewer = modalDetail.querySelector('#detail_orasi_document_viewer');
        if (viewer) {
          viewer.setAttribute('src', ''); // Hentikan pemuatan PDF saat modal ditutup
        }
    });
  };

  const initPraktisiDetailModal = () => {
    const detailModalElement = document.getElementById("detailPraktisiModal");
    if (!detailModalElement) return;

    // Fungsi bantu
    const formatDate = dateString => dateString ? new Date(dateString).toLocaleDateString("id-ID", { day: "numeric", month: "long", year: "numeric" }) : "-";
    const setDetailText = (id, text) => { const el = detailModalElement.querySelector(`#${id}`); if (el) el.textContent = text || "-"; };
    const updateDokumenDetail = (buttonId, noDataId, filePath) => {
      const btn = detailModalElement.querySelector(`#${buttonId}`);
      const noData = detailModalElement.querySelector(`#${noDataId}`);
      if (btn && noData) {
        if (filePath) {
          // Gunakan URL absolut jika diperlukan
          btn.href = `/storage/${filePath}`;
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
      if (!url) return;

      // Reset tampilan
      const fields = ['nama', 'bidang', 'jenis', 'jabatan', 'instansi', 'divisi', 'deskripsi', 'mulai', 'selesai', 'area', 'kategori'];
      fields.forEach(f => setDetailText(`detail-${f}`, 'Memuat...'));
      updateDokumenDetail("detail-surat-ipb", "nodata-surat-ipb", null);
      updateDokumenDetail("detail-surat-instansi", "nodata-surat-instansi", null);
      updateDokumenDetail("detail-cv", "nodata-cv", null);
      updateDokumenDetail("detail-profil", "nodata-profil", null);
      
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
        .catch(error => { 
            console.error("Error:", error); 
            setDetailText("detail-nama", 'Gagal memuat data.');
        });
    });
  };


  // Panggil semua fungsi inisialisasi
  initTabs();
  initDeleteConfirmation();
  initKategoriMapping();
  initFileItemClick();
  handleSuccessFlow();
  initFormModals();
  restoreTabsFromUrl();
  initAutoSearch();
  initPendidikanDetailModals();
  initSertifikatDetailModal();
  initPembicaraDetailModal();
  initOrasiIlmiahDetailModal();
  initPraktisiDetailModal();
});