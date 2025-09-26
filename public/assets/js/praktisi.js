// public/assets/js/praktisi.js

document.addEventListener('DOMContentLoaded', function () {
  // Cek apakah ada pesan sukses dari session melalui meta tag
  const flashSuccessMeta = document.querySelector('meta[name="flash-success"]');
  
  if (flashSuccessMeta && flashSuccessMeta.getAttribute('content')) {
    // Ambil elemen modal kustom Anda
    const successModalOverlay = document.getElementById('modalBerhasil');
    // Ambil tombol 'Selesai' di dalam modal
    const closeButton = document.getElementById('btnSelesai');

    // Pastikan kedua elemen tersebut ada
    if (successModalOverlay && closeButton) {
      
      // TAMPILKAN MODAL
      // Alih-alih menggunakan perintah Bootstrap, kita ubah properti CSS-nya secara manual
      // Asumsi: modal Anda disembunyikan dengan 'display: none' dan ditampilkan dengan 'display: flex'
      successModalOverlay.style.display = 'flex';

      // SEMBUNYIKAN MODAL SAAT TOMBOL 'SELESAI' DIKLIK
      // Kita tambahkan event listener ke tombol tersebut
      closeButton.addEventListener('click', function() {
        successModalOverlay.style.display = 'none';
      });
    }
  }
});