// public/assets/js/praktisi.js

document.addEventListener('DOMContentLoaded', function () {
  
  /**
   * =================================================================
   * BAGIAN 1: LOGIKA UNTUK MODAL NOTIFIKASI SUKSES
   * =================================================================
   */
  const flashSuccessMeta = document.querySelector('meta[name="flash-success"]');
  
  if (flashSuccessMeta && flashSuccessMeta.getAttribute('content')) {
    const successModalOverlay = document.getElementById('modalBerhasil');
    const closeButton = document.getElementById('btnSelesai');

    if (successModalOverlay && closeButton) {
      // ✅ Tambahkan visibility & opacity agar muncul
      successModalOverlay.style.display = 'flex';
      successModalOverlay.style.opacity = '1';
      successModalOverlay.style.visibility = 'visible';

      const soundUrl = document.body.getAttribute('data-success-sound');
      if (soundUrl) {
        const successAudio = new Audio(soundUrl);
        setTimeout(() => {
          successAudio.play().catch(e => console.error("Gagal memutar audio:", e));
        }, 150);
      }

      setTimeout(() => {
        successModalOverlay.style.display = 'none';
      }, 1000);

      closeButton.addEventListener('click', function() {
        successModalOverlay.style.display = 'none';
      });
    }
  }

  /**
   * =================================================================
   * BAGIAN 2: LOGIKA UNTUK MODAL EDIT DATA
   * =================================================================
   */
  const editModalElement = document.getElementById('editPengalamanKerjaModal');
  
  if (editModalElement) {
    const editPraktisiForm = document.getElementById('editPraktisiForm');

    const setFileText = (elementId, filePath) => {
      const element = document.getElementById(elementId);
      if (element) {
        if (filePath) {
          const fileName = filePath.split('/').pop();
          element.textContent = `File lama: ${fileName}`;
        } else {
          element.textContent = 'File lama: Tidak ada';
        }
      }
    };
    
    editModalElement.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      const url = button.getAttribute('data-url');
      const updateUrl = button.getAttribute('data-update-url');

      editPraktisiForm.setAttribute('action', updateUrl);

      fetch(url)
        .then(response => {
          if (!response.ok) {
            throw new Error('Respon jaringan bermasalah saat mengambil data.');
          }
          return response.json();
        })
        .then(data => {
          // Mengisi dropdown pegawai berdasarkan ID
          document.getElementById('edit-pegawai_id').value = data.pegawai_id;

          // Mengisi sisa form
          document.getElementById('edit-bidang_usaha').value = data.bidang_usaha;
          document.getElementById('edit-jenis_pekerjaan').value = data.jenis_pekerjaan;
          document.getElementById('edit-jabatan').value = data.jabatan;
          document.getElementById('edit-instansi').value = data.instansi;
          document.getElementById('edit-divisi').value = data.divisi;
          document.getElementById('edit-deskripsi_kerja').value = data.deskripsi_kerja;
          document.getElementById('edit-tmt').value = data.tmt;
          document.getElementById('edit-tst').value = data.tst;
          document.getElementById('edit-area_pekerjaan').value = data.area_pekerjaan;
          document.getElementById('edit-kategori_pekerjaan').value = data.kategori_pekerjaan;

          // Menampilkan nama file yang sudah pernah di-upload
          setFileText('edit-file-surat_ipb', data.surat_ipb);
          setFileText('edit-file-surat_instansi', data.surat_instansi);
          setFileText('edit-file-cv', data.cv);
          setFileText('edit-file-profil_perusahaan', data.profil_perusahaan);
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Gagal memuat data untuk diedit. Silakan coba lagi.');
          const modal = bootstrap.Modal.getInstance(editModalElement);
          modal.hide();
        });
    });

    editModalElement.addEventListener('hidden.bs.modal', function() {
      editPraktisiForm.reset();
      editPraktisiForm.setAttribute('action', '#');
      
      setFileText('edit-file-surat_ipb', null);
      setFileText('edit-file-surat_instansi', null);
      setFileText('edit-file-cv', null);
      setFileText('edit-file-profil_perusahaan', null);
    });
  }
});
