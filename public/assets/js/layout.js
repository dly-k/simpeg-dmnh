document.addEventListener('DOMContentLoaded', () => {
  initSidebar();
  initClock(); 

  // =================================================
  // Buka Panel Editor Kegiatan secara default
  // =================================================
  const editorButton = document.querySelector('[data-bs-target="#editorKegiatan"]');
  const editorPanel = document.getElementById("editorKegiatan");

  if (editorButton && editorPanel) {
    editorButton.classList.remove("collapsed");    
    editorButton.setAttribute("aria-expanded", "true"); 
    editorPanel.classList.add("show");              
  }
});

// =================================================
// Fungsi: Inisialisasi Sidebar
// =================================================
function initSidebar() {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const toggleSidebarBtn = document.getElementById('toggleSidebar');
  const body = document.body;

  // Fungsi bantu: Tutup sidebar pada mode mobile
  const closeMobileSidebar = () => {
    sidebar.classList.remove('show');
    overlay.classList.remove('show');
  };

  // -------------------------------------------------
  // Event: Klik tombol toggle sidebar
  // -------------------------------------------------
  toggleSidebarBtn?.addEventListener('click', (event) => {
    event.stopPropagation();

    const isMobile = window.innerWidth <= 991;

    if (isMobile) {
      // Tampilkan atau sembunyikan sidebar & overlay pada mobile
      sidebar.classList.toggle('show');
      overlay.classList.toggle('show', sidebar.classList.contains('show'));
    } else {
      // Mode desktop: hanya sembunyikan sidebar (collapse)
      sidebar.classList.toggle('hidden');
      body.classList.toggle('sidebar-collapsed');
    }
  });

  // -------------------------------------------------
  // Event: Klik di luar sidebar → tutup (mode mobile)
  // -------------------------------------------------
  document.addEventListener('click', (event) => {
    const isMobile = window.innerWidth <= 991;
    const isSidebarShown = isMobile && sidebar.classList.contains('show');
    const isClickOutside = !sidebar.contains(event.target);

    if (isSidebarShown && isClickOutside) {
      closeMobileSidebar();
    }
  });
}

// =================================================
// Fungsi: Inisialisasi Jam & Tanggal di Navbar
// =================================================
function initClock() {
  const dateEl = document.getElementById('current-date');
  const timeEl = document.getElementById('current-time');

  // Fungsi untuk memperbarui tanggal & waktu setiap detik
  function updateDateTime() {
    if (!dateEl || !timeEl) return;

    const now = new Date();

    const dateOptions = {
      weekday: 'long', 
      year: 'numeric',
      month: 'long',    
      day: 'numeric', 
      timeZone: 'Asia/Jakarta',
    };

    const timeOptions = {
      hour: '2-digit',  
      minute: '2-digit', 
      second: '2-digit',  
      timeZone: 'Asia/Jakarta',
      hour12: false,    
    };

    // Set text untuk elemen tanggal & waktu
    dateEl.textContent = now.toLocaleDateString('id-ID', dateOptions);
    timeEl.textContent = now.toLocaleTimeString('id-ID', timeOptions);
  }

  updateDateTime();            
  setInterval(updateDateTime, 1000); 
}