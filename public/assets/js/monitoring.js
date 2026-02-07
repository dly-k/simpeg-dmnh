/* public/assets/js/monitoring.js */

$(document).ready(function() {
    console.log("Monitoring Module Initialized");

    // Efek hover pada baris tabel
    $('.table-monitoring tbody tr').hover(function() {
        $(this).addClass('bg-light');
    }, function() {
        $(this).removeClass('bg-light');
    });

    // Inisialisasi tooltip jika ada
    $('[data-toggle="tooltip"]').tooltip();
});