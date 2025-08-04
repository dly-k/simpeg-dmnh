<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kerjasama - SIKEMAH</title>

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
        .btn-lihat { background-color: #17a2b8; border-color: #17a2b8; }
        .btn-lihat-detail { background-color: #0dcaf0; border-color: #0dcaf0; }
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
        .btn-export {
            background-color: #059669;
            color: white;
            border: none;
        }
        .btn-export:hover {
            background-color: #047857;
            color: white;
        }

        .pagination .page-item.active .page-link { 
            background-color: #059669; 
            border-color: #059669; 
        }
        .filter-bar {
            background-color: white;
            padding: 1rem;
            border-radius: .5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 0.1rem 0.5rem rgba(0,0,0,.075);
            display: flex;
            gap: 1rem;
            align-items: center;
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
            max-width: 800px;
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
        .upload-area {
            border: 2px dashed #dee2e6;
            border-radius: .5rem;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: background-color .2s;
        }
        .upload-area:hover {
            background-color: #f8f9fa;
        }
        .upload-area i {
            font-size: 2rem;
            color: #6c757d;
        }
        .upload-area p {
            margin-top: 1rem;
            color: #6c757d;
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
            <li><a href="/kerjasama" class="menu-item active"><i class="fa fa-handshake"></i> Kerjasama</a></li>
            <li><a href="/master-data" class="menu-item"><i class="fa fa-database"></i> Master Data</a></li>
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
            <h1 class="fs-4 fw-semibold"><i class="fas fa-handshake text-white"></i> Kerjasama</h1>
        </div>

        <div class="content-area">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="filter-bar flex-grow-1">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-0"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control border-0" placeholder="Cari Data...">
                    </div>
                    <select class="form-select" style="width: auto;">
                        <option selected>Jenis Kerjasama</option>
                        <option>MoU</option>
                        <option>LoA</option>
                        <option>SPK</option>
                    </select>
                </div>
                <div class="d-flex gap-2 ms-3">
                    <button class="btn btn-export fw-bold"><i class="fas fa-file-export me-2"></i> Export Excel</button>
                    <button class="btn btn-tambah fw-bold" onclick="openModal('tambahKerjasamaModal')"><i class="fas fa-plus me-2"></i> Tambah Data</button>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th class="text-start">Judul</th>
                                    <th>Mitra/Instansi</th>
                                    <th>No Dokumen</th>
                                    <th>Tgl. Dokumen</th>
                                    <th>Ketua/Anggota Tim</th>
                                    <th>Lokasi</th>
                                    <th>Besaran Dana</th>
                                    <th>Jenis Kerjasama</th>
                                    <th>Dokumen</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <script>
                                    const kerjasamaData = [
                                        { judul: 'Kerja Sama Penelitian AI', mitra: 'Dinas Kehutanan DKI Jakarta', noDoc: 'MoU/001/AI/24', tglDoc: '10 April 2004', ketua: 'Ketua: Anton Jaya Puspita Anggota: Ferdy', lokasi: 'Bogor', dana: 'Rp 10.000.000', jenis: 'MoU' },
                                        { judul: 'Kerja Sama Penelitian AI', mitra: 'Dinas Kehutanan DKI Jakarta', noDoc: 'MoU/001/AI/24', tglDoc: '10 April 2004', ketua: 'Ketua: Anton Jaya Puspita Anggota: Ferdy', lokasi: 'Bogor', dana: 'Rp 10.000.000', jenis: 'LoA' },
                                        { judul: 'Kerja Sama Penelitian AI', mitra: 'Dinas Kehutanan DKI Jakarta', noDoc: 'MoU/001/AI/24', tglDoc: '10 April 2004', ketua: 'Ketua: Anton Jaya Puspita Anggota: Ferdy', lokasi: 'Bogor', dana: 'Rp 10.000.000', jenis: 'SPK' },
                                        { judul: 'Kerja Sama Penelitian AI', mitra: 'Dinas Kehutanan DKI Jakarta', noDoc: 'MoU/001/AI/24', tglDoc: '10 April 2004', ketua: 'Ketua: Anton Jaya Puspita Anggota: Ferdy', lokasi: 'Bogor', dana: 'Rp 10.000.000', jenis: 'MoU' },
                                        { judul: 'Kerja Sama Penelitian AI', mitra: 'Dinas Kehutanan DKI Jakarta', noDoc: 'MoU/001/AI/24', tglDoc: '10 April 2004', ketua: 'Ketua: Anton Jaya Puspita Anggota: Ferdy', lokasi: 'Bogor', dana: 'Rp 10.000.000', jenis: 'MoU' },
                                        { judul: 'Kerja Sama Penelitian AI', mitra: 'Dinas Kehutanan DKI Jakarta', noDoc: 'MoU/001/AI/24', tglDoc: '10 April 2004', ketua: 'Ketua: Anton Jaya Puspita Anggota: Ferdy', lokasi: 'Bogor', dana: 'Rp 10.000.000', jenis: 'MoU' },
                                        { judul: 'Kerja Sama Penelitian AI', mitra: 'Dinas Kehutanan DKI Jakarta', noDoc: 'MoU/001/AI/24', tglDoc: '10 April 2004', ketua: 'Ketua: Anton Jaya Puspita Anggota: Ferdy', lokasi: 'Bogor', dana: 'Rp 10.000.000', jenis: 'MoU' }
                                    ];
                                    kerjasamaData.forEach((item, index) => {
                                        document.write(`
                                            <tr>
                                                <td>${index + 1}</td>
                                                <td class="text-start">${item.judul}</td>
                                                <td>${item.mitra}</td>
                                                <td>${item.noDoc}</td>
                                                <td>${item.tglDoc}</td>
                                                <td>${item.ketua}</td>
                                                <td>${item.lokasi}</td>
                                                <td>${item.dana}</td>
                                                <td>${item.jenis}</td>
                                                <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                <td>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <button class="btn btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="fas fa-eye"></i></button>
                                                        <button class="btn btn-aksi btn-edit-row" title="Edit"><i class="fas fa-pencil-alt"></i></button>
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
                        <span class="text-muted small">Menampilkan 1 sampai 7 dari 13 data</span>
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

<!-- Modal Tambah Kerjasama -->
<div class="modal-backdrop" id="tambahKerjasamaModal">
    <div class="modal-content-wrapper">
        <div class="modal-header-custom">
            <h5><i class="fas fa-plus-circle"></i> Tambah Kerjasama</h5>
        </div>
        <div class="modal-body-custom">
            <form>
                <div class="row g-3">
                    <div class="col-12"><label class="form-label">Judul</label><input type="text" class="form-control" placeholder="Melaksanakan Perkuliahan/Tutorial/Perkuliahan Praktikum & Membimbing...."></div>
                    <div class="col-12"><label class="form-label">Mitra</label><input type="text" class="form-control" placeholder="Melaksanakan Perkuliahan/Tutorial/Perkuliahan Praktikum & Membimbing...."></div>
                    <div class="col-md-6"><label class="form-label">No Dokumen</label><input type="date" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label">Tgl. Dokumen</label><select class="form-select"><option selected>Praktikum</option></select></div>
                    <div class="col-md-6"><label class="form-label">TMT</label><input type="date" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label">TST</label><select class="form-select"><option selected>Praktikum</option></select></div>
                    <div class="col-12"><label class="form-label">Departemen/Program Studi</label><select class="form-select"><option selected>-- Pilih Salah Satu --</option></select></div>
                    <div class="col-12"><label class="form-label">Ketua</label><input type="text" class="form-control" placeholder="Nama"></div>
                    <div class="col-12">
                        <label class="form-label">Anggota</label>
                        <div id="anggota-list">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" placeholder="Nama Anggota">
                                <button class="btn btn-outline-success" type="button" onclick="addAnggota()">+ Tambah</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"><label class="form-label">Lokasi</label><input type="text" class="form-control" placeholder="2020/2021"></div>
                    <div class="col-md-6"><label class="form-label">Besaran Dana</label><input type="text" class="form-control" placeholder="2020/2021"></div>
                    <div class="col-12"><label class="form-label">Jenis Kerjasama</label><select class="form-select"><option selected>-- Pilih Salah Satu --</option></select></div>
                    <div class="col-12">
                        <label class="form-label">Upload File</label>
                        <div class="upload-area" id="uploadArea">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Drag & Drop File here<br><small>Ukuran Maksimal 5 MB</small></p>
                            <input type="file" hidden>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer-custom">
            <button type="button" class="btn btn-danger" onclick="closeModal('tambahKerjasamaModal')">Batal</button>
            <button type="button" class="btn btn-success">Simpan</button>
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

function addAnggota() {
    const list = document.getElementById('anggota-list');
    const newInput = document.createElement('div');
    newInput.className = 'input-group mb-2';
    newInput.innerHTML = `
        <input type="text" class="form-control" placeholder="Nama Anggota">
        <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">-</button>
    `;
    list.appendChild(newInput);
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
