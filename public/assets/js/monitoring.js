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

document.addEventListener('DOMContentLoaded', function() {
    const modalEditJabatan = document.getElementById('modalEditJabatan');
    
    if (modalEditJabatan) {
        modalEditJabatan.addEventListener('show.bs.modal', function(event) {
            // Tombol yang diklik
            const button = event.relatedTarget;
            
            // Ambil data-item (pastikan parsing aman)
            const dataRaw = button.getAttribute('data-item');
            const data = JSON.parse(dataRaw);
            
            // 1. SET ACTION FORM (Ini yang menyebabkan MethodNotAllowed)
            const form = document.getElementById('formEditJabatan');
            form.action = data.update_url; 

            // 2. Isi data biodata ke input modal
            document.getElementById('edit_nama').value = data.nama_lengkap;
            document.getElementById('edit_jabatan_sekarang').value = data.jabatan_fungsional;
            document.getElementById('edit_pensiun').value = data.pensiun;

            // 3. Logika Jabatan Tujuan
            const hierarchy = ["Tenaga Pengajar", "Asisten Ahli", "Lektor", "Lektor Kepala", "Guru Besar"];
            const selectTujuan = document.getElementById('edit_jabatan_tujuan');
            
            if (data.jabatan_tujuan) {
                selectTujuan.value = data.jabatan_tujuan;
            } else {
                const currentIdx = hierarchy.indexOf(data.jabatan_fungsional);
                const nextLevel = hierarchy[currentIdx + 1] || hierarchy[hierarchy.length - 1];
                selectTujuan.value = nextLevel;
            }
        });
    }
});