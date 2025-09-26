// public/assets/js/praktisi.js

document.addEventListener('DOMContentLoaded', function () {
  
  // Cek sinyal sukses dari server melalui meta tag
  const flashSuccessMeta = document.querySelector('meta[name="flash-success"]');
  
  if (flashSuccessMeta && flashSuccessMeta.getAttribute('content')) {
    
    // Cari elemen-elemen dari modal kustom Anda
    const successModalOverlay = document.getElementById('modalBerhasil');
    const closeButton = document.getElementById('btnSelesai');

    // Pastikan elemen modal dan tombolnya ada di halaman
    if (successModalOverlay && closeButton) {
      
      // 1. TAMPILKAN MODAL SECARA MANUAL
      // Langsung mengubah style CSS untuk membuatnya terlihat
      successModalOverlay.style.display = 'flex';
      successModalOverlay.style.opacity = '1';
      successModalOverlay.style.visibility = 'visible';

      // 2. PUTAR SUARA (setelah jeda singkat agar sinkron)
      const soundUrl = document.body.getAttribute('data-success-sound');
      if (soundUrl) {
        const successAudio = new Audio(soundUrl);
        setTimeout(() => {
          successAudio.play().catch(e => console.error("Gagal memutar audio:", e));
        }, 150);
      }

      // 3. SEMBUNYIKAN OTOMATIS SETELAH 4 DETIK
      setTimeout(() => {
        successModalOverlay.style.display = 'none';
      }, 4000);

      // 4. SEMBUNYIKAN JIKA TOMBOL "SELESAI" DIKLIK
      // Ini agar pengguna bisa menutupnya lebih cepat jika mau
      closeButton.addEventListener('click', function() {
        successModalOverlay.style.display = 'none';
      });
    }
  }

  // Kode untuk modal detail (jika ada) bisa ditambahkan di bawah sini
  // ...
});