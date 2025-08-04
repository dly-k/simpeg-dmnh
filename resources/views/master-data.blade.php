<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Data - SIKEMAH</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7fafc;
            margin: 0;
        }

        .layout {
          display: flex;
          height: 100vh;
        }

        .sidebar {
          width: 250px;
          background: white;
          padding: 20px;
          box-shadow: 2px 0 5px rgba(0,0,0,0.1);
          overflow-y: auto;
        }
        .sidebar ul { list-style: none; padding-left: 0; }
        .sidebar li { margin-bottom: 10px; }
        .menu-item {
          display: flex;
          align-items: center;
          gap: 10px;
          padding: 10px;
          border-radius: 8px;
          color: #2d3748;
          text-decoration: none;
          cursor: pointer;
          transition: background-color 0.2s ease, color 0.2s ease;
        }
        .menu-item:hover { background-color: #f0fdf4; color: #059669; }
        .menu-item.active {
          background-color: #059669;
          color: white;
          font-weight: 600;
        }
        .menu-item.active i {
            color: white;
        }

        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        .header {
            background: white;
            display: flex;
            justify-content: space-between;
            padding: 15px 30px;
            border-bottom: 1px solid #e2e8f0;
            align-items: center;
        }

        .title-bar {
            background: linear-gradient(to right, #059669, #047857);
            color: white;
            padding: 20px 30px;
        }

        .title-bar h1 {
            font-size: 24px;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .content-area {
            padding: 20px 30px;
            flex: 1;
            overflow-y: auto;
        }
        
        .footer {
            text-align: right;
            font-size: 12px;
            color: #a0aec0;
            padding: 10px 30px;
        }

        .card { 
            border: none; 
            box-shadow: 0 0.1rem 0.5rem rgba(0,0,0,.075); 
            border-radius: .5rem;
        }
        
        .table {
            text-align: center;
            vertical-align: middle;
        }
        .table th { 
            font-weight: 600; 
            background-color: #f8f9fa; 
        }
        .table td, .table th { 
            padding: 1rem; 
        }
        .table-hover > tbody > tr:hover {
            background-color: #f8f9fa;
        }

        .btn-aksi {
            width: 32px; height: 32px; border-radius: 6px !important;
            display: inline-flex;
            align-items: center; justify-content: center; padding: 0;
            color: white;
        }
        .btn-edit-row { background-color: #ffc107; border-color: #ffc107; }
        .btn-delete-row { background-color: #dc3545; border-color: #dc3545; }
        
        .btn-tambah {
            background-color: #2d3748;
            color: white;
            border: none;
        }
        .btn-tambah:hover {
            background-color: #4a5568;
            color: white;
        }

        .pagination .page-item.active .page-link { 
            background-color: #059669; 
            border-color: #059669; 
        }
        
        /* Modal Styles */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0,0,0,0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1050;
            padding: 1rem;
        }
        .modal-content-wrapper {
            background-color: #fff;
            border-radius: .5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,.5);
            width: 100%;
            max-width: 600px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
        }
        .modal-header-custom {
            background: linear-gradient(to right, #059669, #047857);
            color: white;
            padding: 1.25rem;
            border-top-left-radius: .5rem;
            border-top-right-radius: .5rem;
        }
        .modal-header-custom h5 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .modal-body-custom {
            padding: 1.5rem;
            overflow-y: auto;
        }
        .modal-footer-custom {
            padding: 1rem;
            display: flex;
            justify-content: flex-end;
            gap: .5rem;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>

<div class="layout">
    <div class="sidebar">
        <h1 style="font-weight: 700;">
            <span style="color: #000;">SI</span><span style="color: #059669;">KEMAH</span>
        </h1>
        <hr/>
        <p style="font-weight: 600; margin-top: 30px;">Menu Utama</p>
        <ul>
            <li><a href="/dashboard" class="menu-item"><i class="fa fa-chart-bar"></i> Dashboard</a></li>
            <li><a href="/daftar-pegawai" class="menu-item"><i class="fa fa-users"></i> Daftar Pegawai</a></li>
            <li><a href="/surat-tugas" class="menu-item"><i class="fa fa-envelope"></i> Manajemen Surat Tugas</a></li>
            <li><a href="/editor" class="menu-item"><i class="fa fa-edit"></i> Editor Kegiatan</a></li>
            <ul style="margin-left: 20px;">
                <li><a href="/pendidikan" class="menu-item">🎓 Pendidikan</a></li>
                <li><a href="/penelitian" class="menu-item">🔬 Penelitian</a></li>
                <li><a href="/pengabdian" class="menu-item">🤝 Pengabdian</a></li>
                <li><a href="/penunjang" class="menu-item">📎 Penunjang</a></li>
                <li><a href="/pelatihan" class="menu-item">📚 Pelatihan</a></li>
                <li><a href="/penghargaan" class="menu-item">🏅 Penghargaan</a></li>
                <li><a href="/sk-non-pns" class="menu-item">📄 SK Non PNS</a></li>
            </ul>
            <li><a href="/kerjasama" class="menu-item"><i class="fa fa-handshake"></i> Kerjasama</a></li>
            <li><a href="/master-data" class="menu-item active"><i class="fa fa-database"></i> Master Data</a></li>
        </ul>
    </div>

    <div class="main">
        <div class="header">
            <div style="display: flex; align-items: center; gap: 20px;">
                <div style="display: flex; align-items: center; gap: 8px;"><i class="fa-solid fa-calendar-days" style="color: #4b5563;"></i><span id="current-date"></span></div>
                <div style="display: flex; align-items: center; gap: 8px;"><i class="fa-solid fa-clock" style="color: #4b5563;"></i><strong id="current-time"></strong></div>
            </div>
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="background-color: orange; width: 40px; height: 40px; border-radius: 50%; display: flex; justify-content: center; align-items: center; color: white; font-weight: bold;">KTU</div>
                <div>Halo, Ketua TU</div>
            </div>
        </div>

        <div class="title-bar">
            <h1 class="fs-4 fw-semibold"><i class="fas fa-database text-white"></i> Master Data</h1>
        </div>

        <div class="content-area">
            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-tambah fw-bold" onclick="openModal('tambahDataModal')"><i class="fas fa-plus me-2"></i> Tambah Data</button>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th class="text-start">Nama Pegawai</th>
                                    <th>ID Pengguna</th>
                                    <th>Password</th>
                                    <th>Hak Akses</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <script>
                                    const data = [
                                        { name: 'Dr. Soni Trison, S.Hut, M.Si', user: 'Kadep_soni', role: 'Admin' },
                                        { name: 'Ria Kodariah, S.Si', user: 'Kadep_ria', role: 'Admin' },
                                        { name: 'Meli Surnami', user: 'Staff_meli', role: 'Administrasi Kepegawaian' },
                                        { name: 'Saeful Rohim', user: 'Staff_saeful', role: 'Administrasi Kepegawaian' }
                                    ];
                                    data.forEach((item, index) => {
                                        document.write(`
                                            <tr>
                                                <td>${index + 1}</td>
                                                <td class="text-start">${item.name}</td>
                                                <td>${item.user}</td>
                                                <td>••••••••••</td>
                                                <td>${item.role}</td>
                                                <td>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <button class="btn btn-aksi btn-edit-row" title="Edit" onclick="openEditModal('${item.name}', '${item.user}', '${item.role}')"><i class="fas fa-pencil-alt"></i></button>
                                                        <button class="btn btn-aksi btn-delete-row" title="Hapus"><i class="fas fa-trash"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        `);
                                    });
                                </script>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="text-muted small">Menampilkan 1 sampai 4 dari 13 data</span>
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">Berikutnya</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer">
            © 2025 Forest Management - All Rights Reserved
        </div>
    </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal-backdrop" id="tambahDataModal">
    <div class="modal-content-wrapper">
        <div class="modal-header-custom">
            <h5><i class="fas fa-plus-circle"></i> Tambah Data Pengguna</h5>
        </div>
        <div class="modal-body-custom">
            <form>
                <div class="mb-3"><label class="form-label">Nama Pegawai</label><select class="form-select"><option selected>-- Pilih Salah Satu --</option><option>Dr. Soni Trison, S.Hut, M.Si</option><option>Ria Kodariah, S.Si</option></select></div>
                <div class="mb-3"><label class="form-label">ID Pengguna</label><input type="text" class="form-control"></div>
                <div class="row">
                    <div class="col-md-6 mb-3"><label class="form-label">Hak Akses</label><select class="form-select"><option selected>-- Pilih Salah Satu --</option><option>Admin</option><option>Administrasi Kepegawaian</option></select></div>
                    <div class="col-md-6 mb-3"><label class="form-label">Password</label><input type="password" class="form-control"></div>
                </div>
            </form>
        </div>
        <div class="modal-footer-custom">
            <button type="button" class="btn btn-danger" onclick="closeModal('tambahDataModal')">Batal</button>
            <button type="button" class="btn btn-success">Simpan</button>
        </div>
    </div>
</div>

<!-- Modal Edit Data -->
<div class="modal-backdrop" id="editDataModal">
    <div class="modal-content-wrapper">
        <div class="modal-header-custom">
            <h5><i class="fas fa-edit"></i> Edit Data Pengguna</h5>
        </div>
        <div class="modal-body-custom">
            <form>
                <div class="mb-3"><label class="form-label">Nama Pegawai</label><select id="editNamaPegawai" class="form-select"><option>Dr. Soni Trison, S.Hut, M.Si</option><option>Ria Kodariah, S.Si</option></select></div>
                <div class="mb-3"><label class="form-label">ID Pengguna</label><input id="editIdPengguna" type="text" class="form-control"></div>
                <div class="row">
                    <div class="col-md-6 mb-3"><label class="form-label">Hak Akses</label><select id="editHakAkses" class="form-select"><option>Admin</option><option>Administrasi Kepegawaian</option></select></div>
                    <div class="col-md-6 mb-3"><label class="form-label">Password (Kosongkan jika tidak diubah)</label><input type="password" class="form-control"></div>
                </div>
            </form>
        </div>
        <div class="modal-footer-custom">
            <button type="button" class="btn btn-danger" onclick="closeModal('editDataModal')">Batal</button>
            <button type="button" class="btn btn-success">Simpan Perubahan</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Update date and time
    function updateClock() {
        const now = new Date();
        const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', dateOptions);
        document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID', { hour12: false });
    }
    setInterval(updateClock, 1000);
    updateClock();
});

// Modal Functions
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'flex';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
    }
}

function openEditModal(nama, user, role) {
    document.getElementById('editNamaPegawai').value = nama;
    document.getElementById('editIdPengguna').value = user;
    document.getElementById('editHakAkses').value = role;
    openModal('editDataModal');
}

// Close modal if backdrop is clicked
window.onclick = function(event) {
    if (event.target.classList.contains('modal-backdrop')) {
        closeModal(event.target.id);
    }
}
</script>

</body>
</html>
