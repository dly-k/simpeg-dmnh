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
  const detailModalElement = document.getElementById('detailPraktisiModal');

  if (detailModalElement) {
    
    // Helper function untuk memformat tanggal
    const formatDate = (dateString) => {
      if (!dateString) return '-';
      const options = { day: 'numeric', month: 'long', year: 'numeric' };
      return new Date(dateString).toLocaleDateString('id-ID', options);
    };

    // Helper function untuk mengisi teks, dengan fallback jika data kosong
    const setDetailText = (elementId, text) => {
      const element = document.getElementById(elementId);
      if (element) {
        element.textContent = text || '-';
      }
    };
    
    // Helper function untuk mengatur link dokumen
    const setDetailLink = (elementId, filePath) => {
      const element = document.getElementById(elementId);
      if (element) {
        if (filePath) {
          // Asumsi path disimpan relatif dari 'storage'. URL lengkapnya adalah 'storage/path/ke/file'
          element.href = `${window.location.origin}/storage/${filePath}`;
          element.style.display = 'block'; // Tampilkan link
          element.textContent = filePath.split('/').pop(); // Tampilkan nama filenya saja
        } else {
          element.style.display = 'none'; // Sembunyikan jika tidak ada file
        }
      }
    };

    // Event listener utama, dijalankan saat modal detail akan ditampilkan
    detailModalElement.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget; // Tombol mata yang diklik
      const url = button.getAttribute('data-url');

      // Ambil data dari server
      fetch(url)
        .then(response => {
          if (!response.ok) {
            throw new Error('Gagal mengambil data detail.');
          }
          return response.json();
        })
        .then(data => {
          // Isi semua elemen <p> dan <a> di modal detail
          setDetailText('detail-nama', data.pegawai ? data.pegawai.nama_lengkap : 'Tidak Ditemukan');
          setDetailText('detail-bidang', data.bidang_usaha);
          setDetailText('detail-jenis', data.jenis_pekerjaan);
          setDetailText('detail-jabatan', data.jabatan);
          setDetailText('detail-instansi', data.instansi);
          setDetailText('detail-divisi', data.divisi);
          setDetailText('detail-deskripsi', data.deskripsi_kerja);
          setDetailText('detail-mulai', formatDate(data.tmt));
          setDetailText('detail-selesai', formatDate(data.tst));
          setDetailText('detail-area', data.area_pekerjaan);
          setDetailText('detail-kategori', data.kategori_pekerjaan);
          
          // Mengatur link untuk setiap dokumen
          setDetailLink('detail-surat-ipb', data.surat_ipb);
          setDetailLink('detail-surat-instansi', data.surat_instansi);
          setDetailLink('detail-cv', data.cv);
          setDetailLink('detail-profil', data.profil_perusahaan);
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Gagal memuat data detail. Silakan coba lagi.');
          const modal = bootstrap.Modal.getInstance(detailModalElement);
          modal.hide();
        });
    });
  }
});
