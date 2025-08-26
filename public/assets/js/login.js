document.addEventListener("DOMContentLoaded", () => {
  // =================================================
  // Update Tanggal & Waktu
  // =================================================
  const updateDateTime = () => {
    const now = new Date();

    const dateElement = document.getElementById("date");
    const clockElement = document.getElementById("clock");

    if (dateElement) {
      dateElement.textContent = now.toLocaleDateString("id-ID", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
      });
    }

    if (clockElement) {
      clockElement.textContent = now.toLocaleTimeString("id-ID", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        hour12: false,
      });
    }
  };

  // Jalankan setiap 1 detik
  setInterval(updateDateTime, 1000);
  updateDateTime();

  // =================================================
  // Update Tahun Copyright
  // =================================================
  const copyrightYearElement = document.getElementById("copyright-year");
  if (copyrightYearElement) {
    copyrightYearElement.textContent = new Date().getFullYear();
  }
});