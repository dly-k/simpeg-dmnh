document.addEventListener("DOMContentLoaded", () => {
  // == Pembaruan Tanggal dan Waktu ==
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
        timeZone: "Asia/Jakarta"
      });
    }

    if (clockElement) {
      clockElement.textContent = now.toLocaleTimeString("id-ID", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        hour12: false,
        timeZone: "Asia/Jakarta"
      });
    }
  };

  // Jalankan pembaruan pertama dan atur interval setiap 1 detik
  updateDateTime();
  setInterval(updateDateTime, 1000);

  // == Pembaruan Tahun Copyright ==
  const updateCopyrightYear = () => {
    const copyrightYearElement = document.getElementById("copyright-year");
    if (copyrightYearElement) {
      copyrightYearElement.textContent = new Date().getFullYear();
    }
  };

  // Jalankan pembaruan tahun copyright
  updateCopyrightYear();
});