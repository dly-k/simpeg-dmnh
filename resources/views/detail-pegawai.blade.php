<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pegawai - SIKEMAH</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-green: #28a745;
            --secondary-green: #218838;
            --dark-gray: #343a40;
            --light-gray-bg: #f8f9fa;
            --light-text: #6c757d;
            --border-color: #dee2e6;
            --info-blue: #0dcaf0;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: var(--light-gray-bg);
            font-size: 0.9rem;
        }
        .sidebar { width: 250px; height: 100vh; position: fixed; top: 0; left: 0; }
        .sidebar .nav-link.active { color: var(--primary-green) !important; background-color: #e9f5ee; border-left: 3px solid var(--primary-green); }
        .sidebar .nav-link { border-left: 3px solid transparent; }
        .main-content { margin-left: 250px; width: calc(100% - 250px); }
        .header { font-size: 0.85rem; }
        .card { border: none; box-shadow: 0 0.1rem 0.5rem rgba(0,0,0,.075); }
        .form-group label { display: block; margin-bottom: 0.25rem; }
        .form-group .form-text { font-size: 0.75rem; margin-top: -0.2rem; }
        .main-tab-nav .nav-link { border: 1px solid var(--border-color); border-radius: 0; margin-bottom: -1px; color: var(--dark-gray); font-weight: 500; }
        .main-tab-nav .nav-link.active { background-color: var(--primary-green); border-color: var(--primary-green); color: white; }
        .main-tab-nav .nav-link:first-child { border-top-left-radius: .375rem; border-top-right-radius: .375rem; }
        .main-tab-nav .nav-link:last-child { border-bottom-left-radius: .375rem; border-bottom-right-radius: .375rem; }
        .btn-success { background-color: var(--primary-green) !important; border-color: var(--primary-green) !important; }
        
        #pendidikan-sub-tabs .btn {
            font-size: 0.8rem; padding: 0.4rem 0.8rem; background-color: #f8f9fa; color: var(--light-text);
            border: 1px solid var(--border-color); border-radius: 999px;
        }
        #pendidikan-sub-tabs .btn.active {
            background-color: var(--dark-gray) !important; color: white !important; border-color: var(--dark-gray) !important;
        }

        .table th { font-weight: 600; background-color: var(--light-gray-bg); }
        
        /* [PERUBAHAN] Mengubah radius border tombol aksi */
        .btn-aksi {
            width: 32px; height: 32px; border-radius: 6px !important; /* Tidak lagi bulat sempurna */
            display: inline-flex;
            align-items: center; justify-content: center; padding: 0;
        }
        .btn-lihat { background-color: #17a2b8; border-color: #17a2b8; }
        .btn-lihat-detail { background-color: var(--info-blue); border-color: var(--info-blue); } /* Gaya untuk tombol lihat detail */
        .btn-edit-row { background-color: #ffc107; border-color: #ffc107; }
        .btn-delete-row { background-color: #dc3545; border-color: #dc3545; }

        .pagination .page-link { font-size: 0.85rem; }
        .pagination .page-item.active .page-link { background-color: var(--primary-green); border-color: var(--primary-green); }
        .main-search-bar { background-color: #e9ecef; padding: 0.75rem; margin-bottom: 1.5rem; border-radius: .375rem; }
    </style>
</head>
<body>

<div class="d-flex">
    <aside class="sidebar bg-white d-flex flex-column">
        <div class="p-3 border-bottom fs-4 fw-bold text-success">SIKEMAH</div>
        <ul class="nav flex-column p-2">
            <li class="nav-item"><a class="nav-link text-secondary" href="#"><i class="fas fa-tachometer-alt fa-fw me-2"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link active" href="#"><i class="fas fa-users fa-fw me-2"></i> Daftar Pegawai</a></li>
            </ul>
    </aside>

    <div class="main-content">
        <header class="header bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
            <div><i class="fas fa-bars fs-5"></i></div>
            <div class="text-secondary">
                <span>Selasa, 29 Juli 2025</span><span class="mx-2">09:45:23</span><span>KTU Halo, Ketua TU</span>
            </div>
        </header>

        <main class="p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="fs-4 fw-semibold"><i class="fas fa-users text-success"></i> Detail Pegawai</h1>
                <div>
                    <a href="#" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Kembali Ke Daftar</a>
                    <button class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                    <button class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                </div>
            </div>

            <div class="main-search-bar">
                <input type="text" class="form-control" placeholder="🔍 Cari Data Pegawai">
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <div class="d-flex gap-4 mb-5">
                        <div class="text-center flex-shrink-0">
                            <div style="width: 120px; height: 120px; background-color: #e9ecef;" class="rounded-circle mb-2"></div>
                            <button class="btn btn-success btn-sm w-100">Edit</button>
                        </div>
                        <div class="flex-grow-1">
                            <div class="row g-3">
                                <div class="col-md-6 form-group"><label class="small text-secondary">NIP*</label><input type="text" class="form-control form-control-sm" value="3212302291827320009"></div>
                                <div class="col-md-6 form-group"><label class="small text-secondary">Agama*</label><select class="form-select form-select-sm"><option selected>Islam</option><option>Kristen</option></select></div>
                                <div class="col-md-6 form-group"><label class="small text-secondary">Nama Lengkap*</label><small class="form-text text-muted">termasuk gelar jika ada</small><input type="text" class="form-control form-control-sm" value="Alex Ferguso"></div>
                                <div class="col-md-6 form-group"><label class="small text-secondary">Status Pernikahan*</label><select class="form-select form-select-sm"><option>--Pilih Salah Satu--</option><option>Menikah</option></select></div>
                                <div class="col-md-6 form-group"><label class="small text-secondary">Jenis Kelamin*</label><div><div class="form-check form-check-inline pt-1"><input class="form-check-input" type="radio" name="jk" id="lk" checked><label class="form-check-label" for="lk">Laki-laki</label></div><div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="jk" id="pr"><label class="form-check-label" for="pr">Perempuan</label></div></div></div>
                                <div class="col-md-6 form-group"><label class="small text-secondary">Pendidikan Terakhir*</label><select class="form-select form-select-sm"><option>S1</option><option>S2</option><option selected>S3</option></select></div>
                                <div class="col-md-6 form-group"><label class="small text-secondary">Tempat Lahir*</label><input type="text" class="form-control form-control-sm" value="Jakarta"></div>
                                <div class="col-md-6 form-group"><label class="small text-secondary">Bidang Ilmu*</label><input type="text" class="form-control form-control-sm" placeholder="Contoh: Ilmu Pengelolaan Hutan"></div>
                                <div class="col-md-6 form-group"><label class="small text-secondary">Tgl. Lahir*</label><div class="input-group input-group-sm"><input type="text" class="form-control" placeholder="mm/dd/yyyy"><span class="input-group-text"><i class="fas fa-calendar"></i></span></div></div>
                            </div>
                        </div>
                    </div>

<div class="d-flex gap-4">
    <div class="nav flex-column nav-pills main-tab-nav" id="main-tab-nav" style="width: 200px; flex-shrink:0;">
        <button class="nav-link text-start" data-main-tab="biodata">Biodata</button>
        <button class="nav-link text-start active" data-main-tab="pendidikan">Pelaksanaan Pendidikan</button>
        <button class="nav-link text-start" data-main-tab="penelitian">Pelaksanaan Penelitian</button>
        <button class="nav-link text-start" data-main-tab="pengabdian">Pelaksanaan Pegabdian</button>
        <button class="nav-link text-start" data-main-tab="penunjang">Penunjang</button>
        <button class="nav-link text-start" data-main-tab="pelatihan">Pelatihan</button>
        <button class="nav-link text-start" data-main-tab="penghargaan">Penghargaan</button>
    </div>
    
    <div class="flex-grow-1">
        <div class="main-tab-content" id="biodata-content" style="display: none;"><p class="text-muted">Konten untuk Biodata.</p></div>
        <div class="main-tab-content" id="penelitian-content" style="display: none;"><p class="text-muted">Konten untuk Pelaksanaan Penelitian.</p></div>
        <div class="main-tab-content" id="pendidikan-content" style="display: block;">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <select class="form-select form-select-sm" style="width: auto;"><option>Semester Genap 2024/2025</option></select>
                <div id="pendidikan-sub-tabs" class="btn-group flex-wrap gap-2">
                    <button type="button" class="btn active" data-tab="pengajaran-luar">Pengajaran Luar IPB</button>
                    <button type="button" class="btn" data-tab="pengujian-lama">Pengujian Lama</button>
                    <button type="button" class="btn" data-tab="pembimbing-lama">Pembimbing Lama</button>
                    <button type="button" class="btn" data-tab="penguji-luar">Penguji Luar IPB</button>
                    <button type="button" class="btn" data-tab="pembimbing-luar">Pembimbing Luar IPB</button>
                </div>
                <div class="input-group input-group-sm" style="width: auto;"><span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span><input type="text" class="form-control" placeholder="Cari Data..."></div>
            </div>

            <div class="sub-tab-content" id="pengajaran-luar" style="display: block;">
                <table class="table table-bordered table-sm align-middle text-center">
                    <thead><tr><th>No</th><th>Tahun Semester</th><th>Mata Kuliah</th><th>SKS</th><th>Kelas Paralel (Jenis)</th><th>Jumlah Pertemuan</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                    <tbody>
                        <script>for(let i=1; i<=5; i++){ document.write(`<tr><td>${i}</td><td>2018/2019 Ganjil</td><td>Biometrika Hutan</td><td>3 (3-0)</td><td>1 (K)</td><td>K,S, P,O, R,O</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="fas fa-eye"></i></button> <button class="btn btn-sm text-white btn-aksi btn-edit-row" title="Edit"><i class="fas fa-pencil-alt"></i></button> <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="fas fa-trash"></i></button></td></tr>`);}</script>
                    </tbody>
                </table>
                <div class="d-flex justify-content-between align-items-center mt-3"><span class="text-muted small">Menampilkan 1 sampai 10 dari 13 data</span><nav><ul class="pagination pagination-sm mb-0"><li class="page-item"><a class="page-link" href="#">Sebelumnya</a></li><li class="page-item active"><a class="page-link" href="#">1</a></li><li class="page-item"><a class="page-link" href="#">2</a></li><li class="page-item"><a class="page-link" href="#">Berikutnya</a></li></ul></nav></div>
            </div>
            
            <div class="sub-tab-content" id="pengujian-lama" style="display: none;">
                <table class="table table-bordered table-sm align-middle">
                    <thead><tr><th>No</th><th>Tahun Semester</th><th>NIM</th><th>Nama Mahasiswa</th><th>Strata</th><th>Departemen</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                    <tbody><tr><td>1</td><td>2018/2019 Ganjil</td><td>E14070026</td><td>Alex Ferguso</td><td>S1</td><td>Manajemen Hutan</td><td>Anggota Penguji</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="fas fa-eye"></i></button> <button class="btn btn-sm text-white btn-aksi btn-edit-row" title="Edit"><i class="fas fa-pencil-alt"></i></button> <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="fas fa-trash"></i></button></td></tr></tbody>
                </table>
            </div>
            
            <div class="sub-tab-content" id="pembimbing-lama" style="display: none;">
                <table class="table table-bordered table-sm align-middle">
                    <thead><tr><th>No</th><th>Tahun Semester</th><th>Kegiatan</th><th>NIM</th><th>Nama Mahasiswa</th><th>Strata</th><th>Departemen</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                    <tbody><tr><td>1</td><td>2018/2019 Ganjil</td><td>Membimbing dan ikut membimbing</td><td>E2039383</td><td>Alex Ferguso</td><td>S1</td><td>Manajemen Hutan</td><td>Pembimbing Pendamping</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="fas fa-eye"></i></button> <button class="btn btn-sm text-white btn-aksi btn-edit-row" title="Edit"><i class="fas fa-pencil-alt"></i></button> <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="fas fa-trash"></i></button></td></tr></tbody>
                </table>
            </div>

            <div class="sub-tab-content" id="penguji-luar" style="display: none;">
                <table class="table table-bordered table-sm align-middle">
                    <thead><tr><th>No</th><th>Tahun Semester</th><th>NIM</th><th>Nama Mahasiswa</th><th>Strata</th><th>Universitas</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                    <tbody><tr><td>1</td><td>2018/2019 Ganjil</td><td>160648032</td><td>HAQQI ANNAZILLI</td><td>S2</td><td>Universitas Indonesia</td><td>Anggota Penguji</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="fas fa-eye"></i></button> <button class="btn btn-sm text-white btn-aksi btn-edit-row" title="Edit"><i class="fas fa-pencil-alt"></i></button> <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="fas fa-trash"></i></button></td></tr></tbody>
                </table>
            </div>
            
            <div class="sub-tab-content" id="pembimbing-luar" style="display: none;">
                 <table class="table table-bordered table-sm align-middle">
                    <thead><tr><th>No</th><th>Tahun Semester</th><th>NIM</th><th>Nama Mahasiswa</th><th>Strata</th><th>Universitas</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                    <tbody><tr><td>1</td><td>2018/2019 Ganjil</td><td>160648032</td><td>HAQQI ANNAZILLI</td><td>S2</td><td>Universitas Indonesia</td><td>Anggota Penguji</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="fas fa-eye"></i></button> <button class="btn btn-sm text-white btn-aksi btn-edit-row" title="Edit"><i class="fas fa-pencil-alt"></i></button> <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="fas fa-trash"></i></button></td></tr></tbody>
                </table>
            </div>
        </div>
    </div>
</div> 
                </div>
            </div>
            <footer class="text-center py-4 small text-secondary">© 2025 Forest Management - All Rights Reserved</footer>
        </main>
    </div>
</div>

<script>
// JavaScript sama seperti sebelumnya, tidak perlu diubah
document.addEventListener('DOMContentLoaded', function () {
    const setupTabs = (containerId, buttonSelector, contentClass) => {
        const container = document.getElementById(containerId);
        if (!container) return;
        container.addEventListener('click', function (e) {
            const button = e.target.closest(buttonSelector);
            if (!button) return;
            container.querySelectorAll(buttonSelector).forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            document.querySelectorAll(contentClass).forEach(content => content.style.display = 'none');
            const tabId = button.dataset.mainTab || button.dataset.tab;
            const contentId = contentClass === '.main-tab-content' ? `${tabId}-content` : tabId;
            const contentEl = document.getElementById(contentId);
            if (contentEl) contentEl.style.display = 'block';
        });
    };
    setupTabs('main-tab-nav', '.nav-link', '.main-tab-content');
    setupTabs('pendidikan-sub-tabs', 'button', '.sub-tab-content');
});
</script>

</body>
</html>