document.addEventListener("DOMContentLoaded", function () {
    function updateDateTime() {
        const now = new Date();
        document.getElementById('date').textContent = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        document.getElementById('clock').textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false });
    }

    setInterval(updateDateTime, 1000);
    updateDateTime();
    document.getElementById('copyright-year').textContent = new Date().getFullYear();
});