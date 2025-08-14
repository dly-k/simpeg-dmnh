document.addEventListener('DOMContentLoaded', function () {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const toggleSidebarBtn = document.getElementById('toggleSidebar');

  // Sidebar toggle
  if (toggleSidebarBtn && sidebar && overlay) {
    toggleSidebarBtn.addEventListener('click', function () {
      const isMobile = window.innerWidth <= 991;
      if (isMobile) {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show', sidebar.classList.contains('show'));
      } else {
        sidebar.classList.toggle('hidden');
      }
    });

    overlay.addEventListener('click', function () {
      sidebar.classList.remove('show');
      overlay.classList.remove('show');
    });
  }

  // Tanggal dan waktu sekarang
  function updateDateTime() {
    const now = new Date();
    const dateEl = document.getElementById('current-date');
    const timeEl = document.getElementById('current-time');

    if (dateEl) {
      dateEl.textContent = now.toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
    }

    if (timeEl) {
      timeEl.textContent = now.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
      }).replace(/\./g, ':');
    }
  }

  updateDateTime();
  setInterval(updateDateTime, 1000);

  // Tab utama
  const mainTabNav = document.getElementById('main-tab-nav');
  if (mainTabNav) {
    mainTabNav.addEventListener('click', function (e) {
      if (e.target.matches('button.nav-link')) {
        // Reset semua tab & konten
        document.querySelectorAll('.main-tab-nav .nav-link').forEach(tab => tab.classList.remove('active'));
        document.querySelectorAll('.main-tab-content').forEach(content => content.style.display = 'none');

        // Aktifkan tab yg diklik
        e.target.classList.add('active');
        const contentEl = document.getElementById(`${e.target.dataset.mainTab}-content`);
        if (contentEl) contentEl.style.display = 'block';
      }
    });
  }

  // Sub-tab (pendidikan & biodata)
  ['#pendidikan-sub-tabs', '#biodata-sub-tabs'].forEach(selector => {
    const tabContainer = document.querySelector(selector);
    if (tabContainer) {
      tabContainer.addEventListener('click', function (e) {
        if (e.target.matches('button')) {
          const parentContent = this.closest('.main-tab-content');
          if (!parentContent) return;

          // Nonaktifkan semua tombol tab
          this.querySelectorAll('button').forEach(btn => btn.classList.remove('active'));
          e.target.classList.add('active');

          // Sembunyikan semua konten
          parentContent.querySelectorAll('.sub-tab-content').forEach(content => content.style.display = 'none');

          // Tampilkan konten sesuai tab yang diklik
          const contentEl = parentContent.querySelector(`#${e.target.dataset.tab}`);
          if (contentEl) contentEl.style.display = 'block';
        }
      });
    }
  });

  // Filter penunjang
  const penunjangFilter = document.getElementById('penunjang-filter');
  if (penunjangFilter) {
    penunjangFilter.addEventListener('change', function () {
      const parentContent = this.closest('.main-tab-content');
      if (!parentContent) return;

      parentContent.querySelectorAll('.sub-tab-content').forEach(tab => tab.style.display = 'none');
      const activeTab = document.getElementById(this.value);
      if (activeTab) activeTab.style.display = 'block';
    });
  }
});

document.querySelectorAll('.file-item').forEach(card => {
    card.addEventListener('click', (e) => {
        // Kalau klik tombol unduh atau hapus → jangan buka PDF
        if (e.target.closest('.btn-unduh') || e.target.closest('.btn-hapus')) {
            return;
        }
        const fileUrl = card.getAttribute('data-file');
        if (fileUrl) {
            window.open(fileUrl, '_blank');
        }
    });
});

// Aksi download langsung untuk tombol unduh
document.querySelectorAll('.btn-unduh').forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.stopPropagation(); // cegah klik card
        const fileUrl = btn.getAttribute('data-file');
        if (fileUrl) {
            const link = document.createElement('a');
            link.href = fileUrl;
            link.download = fileUrl.split('/').pop(); // nama file dari URL
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    });
});

// Hapus card
document.querySelectorAll('.btn-hapus').forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.stopPropagation(); // cegah klik card
        const card = btn.closest('.file-item');

        // Konfirmasi sebelum hapus
        const konfirmasi = confirm("Apakah Anda yakin ingin menghapus dokumen ini?");
        if (konfirmasi && card) {
            card.remove();
            // Kalau mau, bisa tambah AJAX call ke server untuk hapus file juga
            console.log("File dihapus:", card.getAttribute('data-file'));
        }
    });
});