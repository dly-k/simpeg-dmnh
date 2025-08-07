document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("overlay");
  const toggleSidebarBtn = document.getElementById("toggleSidebar");
  const body = document.body;

  if (toggleSidebarBtn) {
    toggleSidebarBtn.addEventListener("click", function () {
      const isMobile = window.innerWidth <= 991;

      if (isMobile) {
        sidebar.classList.toggle("show");
        overlay.classList.toggle("show", sidebar.classList.contains("show"));
      } else {
        sidebar.classList.toggle("hidden");
        body.classList.toggle("sidebar-collapsed");
      }
    });
  }

  const editorBtn = document.querySelector('[data-bs-target="#editorKegiatan"]');
  const editorMenu = document.getElementById("editorKegiatan");

  if (editorBtn && editorMenu) {
    editorBtn.classList.remove("collapsed");
    editorBtn.setAttribute("aria-expanded", "true");
    editorMenu.classList.add("show");
  }

  if (overlay) {
    overlay.addEventListener("click", function () {
      sidebar.classList.remove("show");
      overlay.classList.remove("show");
    });
  }

  function updateDateTime() {
    const now = new Date();
    const options = { weekday: "long", year: "numeric", month: "long", day: "numeric" };
    const dateEl = document.getElementById("current-date");
    const timeEl = document.getElementById("current-time");

    if (dateEl && timeEl) {
      dateEl.textContent = now.toLocaleDateString("id-ID", options);
      timeEl.textContent = now.toLocaleTimeString("id-ID", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
      });
    }
  }

  setInterval(updateDateTime, 1000);
  updateDateTime();

  // Modal: Tambah
  window.openModal = function (modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;

    modal.querySelector("#modalTitle").innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Data Pegawai';
    modal.querySelector("form").reset();
    modal.style.display = "flex";
  };

  // Modal: Edit
  window.openEditModal = function (data) {
    const modal = document.getElementById("pegawaiModal");
    if (!modal) return;

    modal.querySelector("#modalTitle").innerHTML = '<i class="fas fa-edit"></i> Edit Data Pegawai';
    const form = modal.querySelector("form");

    form.querySelector('[name="name"]').value = data.name;
    form.querySelector('[name="nip"]').value = data.nip;
    form.querySelector('[name="status_kepegawaian"]').value = data.status_kepegawaian;
    form.querySelector('[name="jabatan_fungsional"]').value = data.jabatan_fungsional;
    form.querySelector('[name="jabatan_struktural"]').value = data.jabatan_struktural;
    form.querySelector('[name="pangkat"]').value = data.pangkat;
    form.querySelector('[name="status_pegawai"]').value = data.status_pegawai;

    modal.style.display = "flex";
  };

  // Modal: Close
  window.closeModal = function (modalId) {
    const modal = document.getElementById(modalId);
    if (modal) modal.style.display = "none";
  };

  // Click outside modal to close
  window.onclick = function (event) {
    if (event.target.classList.contains("modal-backdrop")) {
      closeModal(event.target.id);
    }
  };
});