<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pegawai - SIKEMAH</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #049466;
            --primary-light: #e3f7ec;
            --border-color: #dee2e6;
            --dark-gray: #343a40;
            --light-text: #6c757d;
        }
        body { font-family: 'Poppins', sans-serif; margin: 0; background-color: #f5f6fa; }
        .layout { display: flex; min-height: 100vh; }
        .sidebar {
            width: 250px; height: 100vh; background-color: #fff; border-right: 1px solid var(--border-color);
            position: fixed; top: 0; left: 0; display: flex; flex-direction: column;
            transition: transform 0.3s ease-in-out; z-index: 1001; transform: translateX(0);
        }
        .sidebar.hidden { transform: translateX(-100%); }
        .sidebar .brand { font-size: 24px; font-weight: 700; text-align: center; padding: 14.5px 0; border-bottom: 1px solid #ccc; letter-spacing: 1px; color: #222; }
        .sidebar .brand span { color: var(--primary); }
        .sidebar .menu-wrapper { overflow-y: auto; flex-grow: 1; }
        .menu p { font-size: 13px; font-weight: 500; padding: 0 20px; margin: 12px 0 8px; color: #888; }
        .sidebar .menu a, .sidebar .menu button {
            display: flex; align-items: center; padding: 12px 20px; text-decoration: none;
            color: #333; font-size: 13px; transition: all 0.2s ease-in-out;
            width: 100%; background: none; border: none; text-align: left;
        }
        .sidebar .menu a:hover, .sidebar .menu button:hover { background-color: var(--primary-light); color: var(--primary); box-shadow: inset 3px 0 0 var(--primary); }
        .sidebar .menu a.active { background-color: var(--primary); color: #fff; font-weight: 600; box-shadow: inset 4px 0 0 #034d26; }
        .sidebar .menu a i, .sidebar .menu button i { margin-right: 12px; font-size: 16px; min-width: 20px; display: flex; align-items: center; justify-content: center; }
        .sidebar .submenu a { padding: 9px 35px; font-size: 12.5px; }
        .toggle-icon { margin-left: auto; transition: transform 0.3s; }
        .collapsed .toggle-icon { transform: rotate(-90deg); }
        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); z-index: 1000; display: none; }
        .overlay.show { display: block; }
        .main-wrapper { flex-grow: 1; margin-left: 250px; transition: margin-left 0.3s ease-in-out; display: flex; flex-direction: column; min-height: 100vh; }
        .sidebar.hidden ~ .main-wrapper { margin-left: 0; }
        .navbar-custom { height: 66px; background: #fff; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; padding: 0 20px; flex-shrink: 0; }
        .time-date { font-size: 13px; display: flex; align-items: center; gap: 20px; font-weight: 400; }
        .time-date div { display: flex; align-items: center; gap: 6px; }
        .account { display: flex; align-items: center; font-size: 13px; font-weight: 400; cursor: pointer; margin-left: 10px; gap: 6px; }
        .icon-circle { background: var(--primary); color: white; border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; }
        .dropdown-menu { margin-top: 5px !important; padding: 0; overflow: hidden; border-radius: 0.375rem; }
        .dropdown-item { padding: 10px 16px; font-size: 13px; }
        .dropdown-item i { min-width: 24px; text-align: center; }
        .dropdown-divider { margin: 0; }
        .dropdown-item-danger { color: #dc3545; }
        .dropdown-item-danger:hover, .dropdown-item-danger:focus { color: #fff; background-color: #dc3545; }
        .title-bar { background: linear-gradient(to right, #059669, #047857); color: white; padding: 20px 25px; flex-shrink: 0; }
        .title-bar h1 { font-size: 20px; margin: 0; display: flex; align-items: center; gap: 12px; font-weight: 600; }
        .main-content { padding: 25px; background-color: #f5f6fa; flex-grow: 1; }
        .card { border: none; box-shadow: 0 0.1rem 0.5rem rgba(0,0,0,.075); border-radius: .5rem; }
        .form-group label { display: block; margin-bottom: 0.25rem; font-weight: 500; }
        .main-tab-nav .nav-link { border: 1px solid var(--border-color); border-radius: 0; margin-bottom: -1px; color: var(--dark-gray); font-weight: 100; }
        .main-tab-nav .nav-link.active { background-color: var(--primary); border-color: var(--primary); color: white; }
        .main-tab-nav .nav-link:first-child { border-top-left-radius: .375rem; border-top-right-radius: .375rem; }
        .main-tab-nav .nav-link:last-child { border-bottom-left-radius: .375rem; border-bottom-right-radius: .375rem; }
        .btn-success { background-color: var(--primary) !important; border-color: var(--primary) !important; }
        #pendidikan-sub-tabs .btn, #biodata-sub-tabs .btn { font-size: 0.8rem; padding: 0.4rem 0.8rem; background-color: #f8f9fa; color: var(--light-text); border: 1px solid var(--border-color); border-radius: 999px; }
        #pendidikan-sub-tabs .btn.active, #biodata-sub-tabs .btn.active { background-color: var(--dark-gray) !important; color: white !important; border-color: var(--dark-gray) !important; }
        .table th { font-weight: 600; background-color: #f8f9fa; font-size: 13.5px; }
        .table { text-align: center; vertical-align: middle; font-size: 13.5px; }
        .table td, .table th { padding: 0.85rem; }
        .table-hover > tbody > tr:hover { background-color: var(--primary-light); }
        .btn-aksi { width: 32px; height: 32px; border-radius: 6px !important; display: inline-flex; align-items: center; justify-content: center; padding: 0; transition: all 0.2s ease-in-out; }
        .btn-aksi:hover { transform: scale(1.15); filter: brightness(1.1); box-shadow: 0 2px 8px rgba(0,0,0,0.2); }
        .btn-lihat { background-color: #17a2b8; border-color: #17a2b8; }
        .btn-lihat-detail { background-color: #0dcaf0; border-color: #0dcaf0; }
        .btn-delete-row { background-color: #dc3545; border-color: #dc3545; }
        .pagination .page-link { font-size: 0.85rem; color: var(--primary); }
        .pagination .page-item.active .page-link { background-color: var(--primary); border-color: var(--primary); }
        .search-filter-container { margin-bottom: 1.5rem; }
        .search-filter-row { display: flex; flex-wrap: wrap; gap: 1rem; align-items: center; }
        .search-box { flex: 1; min-width: 250px; }
        .btn-tambah-container { margin-left: auto; }
        .tab-filters { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem; }
        .filter-dropdown-wrapper { position: relative; }
        .filter-dropdown { -webkit-appearance: none; -moz-appearance: none; appearance: none; background-color: #fff; border: 1px solid var(--border-color); border-radius: .375rem; padding: 0.5rem 2.5rem 0.5rem 1rem; font-size: 0.9rem; font-weight: 500; color: #495057; cursor: pointer; min-width: 150px; }
        .filter-dropdown-wrapper::after { content: '\e909'; font-family: 'LineIcons'; position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none; color: var(--light-text); }
        .footer-custom { background: #fff; border-top: 1px solid var(--border-color); height: 45px; display: flex; align-items: center; justify-content: flex-end; padding: 0 20px; font-size: 12px; color: #555; flex-shrink: 0; }
        body {
    overflow: hidden; /* Mencegah scroll di body */
    height: 100vh;
    display: flex;
    flex-direction: column;
}

.efile-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }
    .efile-header h4 {
        font-weight: 600;
        color: var(--dark-gray);
        margin: 0;
    }
    .file-category-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--dark-gray);
    }
    .file-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }
    .file-item {
        background-color: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 1rem;
        text-align: center;
        position: relative;
        transition: all 0.2s ease-in-out;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .file-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .file-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 4px;
        color: #fff;
        text-transform: uppercase;
    }
    .badge-asli { background-color: #28a745; } /* Green */
    .badge-legalisir { background-color: #0d6efd; } /* Blue */
    .badge-scan { background-color: #ffc107; color: #212529 !important; } /* Yellow */

    .file-item-icon {
        font-size: 4rem;
        color: var(--light-text);
        margin-bottom: 0.5rem;
        line-height: 1;
    }
    .file-item p {
        font-weight: 500;
        color: var(--dark-gray);
        margin-bottom: 1rem;
    }
    .file-item p span {
        font-weight: 400;
        color: var(--light-text);
    }
    .file-item-actions {
        display: flex;
        gap: 0.5rem;
    }
    .file-item-actions .btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        font-size: 0.8rem;
    }
        .layout {
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        /* Header sticky */
        .navbar-custom {
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        /* Konten utama yang discroll */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .main-content {
            flex: 1;
            overflow-y: auto;
            padding: 25px;
            background-color: #f5f6fa;
        }

        /* Footer sticky */
        .footer-custom {
            position: sticky;
            bottom: 0;
            z-index: 1020;
        }

        /* Penyesuaian untuk sidebar */
        .sidebar {
            height: 100vh;
            overflow-y: auto;
        }

        /* Penyesuaian untuk mobile */
        @media (max-width: 991px) {
            .main-content {
                padding: 15px;
            }
            
            .navbar-custom,
            .footer-custom {
                position: fixed;
                width: 100%;
            }
            
            .navbar-custom {
                top: 0;
            }
            
            .footer-custom {
                bottom: 0;
            }
            
            .main-content {
                padding-bottom: 60px; /* Sesuaikan dengan tinggi footer */
                padding-top: 70px; /* Sesuaikan dengan tinggi header */
            }
        }
                @media (max-width: 991px) {
                    .sidebar { transform: translateX(-100%); }
                    .sidebar.show { transform: translateX(0); }
                    .main-wrapper { margin-left: 0; }
                    .time-date { flex-direction: column; gap: 6px; align-items: flex-start; }
                    .search-filter-row, .tab-filters { flex-direction: column; align-items: stretch; }
                    .btn-tambah-container { margin-left: 0; }
                }
    </style>
</head>
<body>

<div class="layout">
    <div class="sidebar" id="sidebar">
        <div class="brand">SI<span>KEMAH</span></div>
        <div class="menu-wrapper">
            <div class="menu">
                <a href="/dashboard"><i class="lni lni-grid-alt"></i> Dashboard</a>
                <p>Menu Utama</p>
                <a href="/daftar-pegawai" class="active"><i class="lni lni-users"></i> Daftar Pegawai</a>
                <a href="/surat-tugas"><i class="lni lni-folder"></i> Manajemen Surat Tugas</a>
                <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#editorKegiatan" aria-expanded="true">
                    <i class="lni lni-pencil-alt"></i> Editor Kegiatan <i class="lni lni-chevron-down toggle-icon"></i>
                </button>
                <div class="collapse show submenu" id="editorKegiatan">
                    <a href="/pendidikan">Pendidikan</a><a href="/penelitian">Penelitian</a><a href="/pengabdian">Pengabdian</a>
                    <a href="/penunjang">Penunjang</a><a href="/pelatihan">Pelatihan</a><a href="/penghargaan">Penghargaan</a><a href="/sk-non-pns">SK Non PNS</a>
                </div>
                <a href="/kerjasama"><i class="lni lni-handshake"></i> Kerjasama</a>
                <a href="/master-data"><i class="lni lni-database"></i> Master Data</a>
            </div>
        </div>
    </div>

    <div class="overlay" id="overlay"></div>

    <div class="main-wrapper">
        <nav class="navbar-custom">
            <button class="btn btn-link text-dark me-3" id="toggleSidebar" aria-label="Toggle Sidebar">
                <i class="lni lni-menu"></i>
            </button>
            <div class="d-flex align-items-center">
                <div class="time-date me-3">
                    <div><i class="lni lni-calendar"></i> <span id="current-date"></span></div>
                    <div><i class="lni lni-timer"></i> <span id="current-time"></span></div>
                </div>
                <div class="dropdown">
                    <a href="#" class="account text-decoration-none text-dark" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="icon-circle"><i class="lni lni-user"></i></span>
                        <span class="d-none d-sm-inline">Halo, Ketua TU</span><i class="lni lni-chevron-down ms-1"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li><a class="dropdown-item d-flex align-items-center" href="/ubah-password"><i class="lni lni-key me-2"></i> Ubah Password</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item d-flex align-items-center dropdown-item-danger" href="/logout"><i class="lni lni-exit me-2"></i> Keluar</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="title-bar">
            <h1><i class="lni lni-users"></i> Detail Pegawai</h1>
        </div>

        <div class="main-content">
            <div class="search-filter-container">
                <div class="search-filter-row">
                    <div class="search-box">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="lni lni-search-alt"></i></span>
                            <input type="text" class="form-control border-start-0" placeholder="Cari Data Pegawai...">
                        </div>
                    </div>
                    <div class="btn-tambah-container">
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="/daftar-pegawai" class="btn btn-outline-secondary"><i class="lni lni-arrow-left me-2"></i>Kembali</a>
                            <button class="btn btn-success"><i class="lni lni-save me-2"></i>Simpan</button>
                            <button class="btn btn-danger"><i class="lni lni-trash-can me-2"></i>Hapus</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-md-row gap-4 mb-5">
                        <div class="text-center flex-shrink-0">
                            <div style="width: 120px; height: 120px; background-color: #e9ecef;" class="rounded-circle mb-2 mx-auto d-flex align-items-center justify-content-center">
                                <i class="lni lni-user" style="font-size: 3rem; color: var(--light-text);"></i>
                            </div>
                            <button class="btn btn-success btn-sm w-100">Edit</button>
                        </div>
                        <div class="flex-grow-1">
                            <div class="row g-3">
                                <div class="col-md-6 form-group"><label class="small text-secondary">NIP*</label><input type="text" class="form-control form-control-sm" value="3212302291827320009"></div>
                                <div class="col-md-6 form-group"><label class="small text-secondary">Agama*</label><select class="form-select form-select-sm"><option selected>Islam</option><option>Kristen</option></select></div>
                                <div class="col-md-6 form-group"><label class="small text-secondary">Nama Lengkap*</label><small class="form-text text-muted">termasuk gelar jika ada</small><input type="text" class="form-control form-control-sm" value="Alex Ferguso"></div>
                                <div class="col-md-6 form-group"><label class="small text-secondary">Status Pernikahan*</label><select class="form-select form-select-sm"><option>--Pilih Salah Satu--</option><option>Menikah</option></select></div>
                                <div class="col-md-6 form-group">
                                    <label class="small text-secondary">Jenis Kelamin*</label>
                                    <div>
                                        <div class="form-check form-check-inline pt-1">
                                            <input class="form-check-input" type="radio" name="jk" id="lk" checked>
                                            <label class="form-check-label" for="lk" style="font-weight: normal;">Laki-laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jk" id="pr">
                                            <label class="form-check-label" for="pr" style="font-weight: normal;">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group"><label class="small text-secondary">Pendidikan Terakhir*</label><select class="form-select form-select-sm"><option>S1</option><option>S2</option><option selected>S3</option></select></div>
                                <div class="col-md-6 form-group"><label class="small text-secondary">Tempat Lahir*</label><input type="text" class="form-control form-control-sm" value="Jakarta"></div>
                                <div class="col-md-6 form-group"><label class="small text-secondary">Bidang Ilmu*</label><input type="text" class="form-control form-control-sm" placeholder="Contoh: Ilmu Pengelolaan Hutan"></div>
                                <div class="col-md-6 form-group"><label class="small text-secondary">Tgl. Lahir*</label><input type="date" class="form-control form-control-sm" value="1980-05-25"></div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-lg-row gap-4">
                        <div class="nav flex-column nav-pills main-tab-nav" id="main-tab-nav" style="min-width: 220px; flex-shrink:0;">
                            <button class="nav-link text-start active" data-main-tab="biodata">Biodata</button>
                            <button class="nav-link text-start" data-main-tab="pendidikan">Pelaksanaan Pendidikan</button>
                            <button class="nav-link text-start" data-main-tab="penelitian">Pelaksanaan Penelitian</button>
                            <button class="nav-link text-start" data-main-tab="pengabdian">Pelaksanaan Pengabdian</button>
                            <button class="nav-link text-start" data-main-tab="penunjang">Penunjang</button>
                            <button class="nav-link text-start" data-main-tab="pelatihan">Pelatihan</button>
                            <button class="nav-link text-start" data-main-tab="penghargaan">Penghargaan</button>
                        </div>
                        
                        <div class="flex-grow-1">
                            <!-- Biodata Content -->
                            <div class="main-tab-content" id="biodata-content" style="display: block;">
                                <div id="biodata-sub-tabs" class="btn-group flex-wrap gap-2 mb-4">
                                    <button type="button" class="btn active" data-tab="kepegawaian">Kepegawaian</button>
                                    <button type="button" class="btn" data-tab="dosen">Dosen</button>
                                    <button type="button" class="btn" data-tab="domisili">Alamat Domisili & Kontak</button>
                                    <button type="button" class="btn" data-tab="kependudukan">Kependudukan</button>
                                    <button type="button" class="btn" data-tab="efile">E-File</button>
                                </div>
                                <div class="sub-tab-content" id="kepegawaian" style="display: block;"><div class="row g-3"><div class="col-md-6 form-group"><label class="small text-secondary">Status Kepegawaian</label><select class="form-select form-select-sm"><option selected>Dosen PNS</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">Status Pegawai</label><select class="form-select form-select-sm"><option selected>Aktif</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">Unit Kerja</label><select class="form-select form-select-sm"><option selected>Fakultas Kehutanan dan Lingkungan</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">Divisi</label><select class="form-select form-select-sm"><option selected>Departemen Manajemen Hutan</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">Nomor Arsip Berkas Kepegawaian</label><input type="text" class="form-control form-control-sm"></div><div class="col-md-6 form-group"><label class="small text-secondary">Jabatan Fungsional</label><select class="form-select form-select-sm"><option>--Pilih Salah Satu--</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">Pangkat/Golongan</label><select class="form-select form-select-sm"><option selected>Penata III/c</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">TMT Pangkat Terakhir</label><input type="text" class="form-control form-control-sm" placeholder="mm/dd/yyyy"></div><div class="col-md-6 form-group"><label class="small text-secondary">Jabatan Struktural (jika ada)</label><input type="text" class="form-control form-control-sm"></div><div class="col-md-6 form-group"><label class="small text-secondary">Periode Jabatan Struktural (TMT s/d TST)</label><input type="text" class="form-control form-control-sm" placeholder="mm/dd/yyyy"></div><div class="col-md-6 form-group"><label class="small text-secondary">ID Finger Print</label><input type="text" class="form-control form-control-sm"></div><div class="col-md-6 form-group"><label class="small text-secondary">NPWP</label><input type="text" class="form-control form-control-sm"></div><div class="col-md-6 form-group"><label class="small text-secondary">Nama Bank</label><input type="text" class="form-control form-control-sm"></div><div class="col-md-6 form-group"><label class="small text-secondary">No Rekening</label><input type="text" class="form-control form-control-sm"></div></div></div>
                                <div class="sub-tab-content" id="dosen" style="display: none;"><div class="row g-3"><div class="col-md-6 form-group"><label class="small text-secondary">NUPTK</label><input type="text" class="form-control form-control-sm" placeholder="Contoh: 23071959"></div><div class="col-md-6 form-group"><label class="small text-secondary">SINTA ID</label><input type="text" class="form-control form-control-sm" placeholder="Opsional"></div><div class="col-md-6 form-group"><label class="small text-secondary">NIDN</label><input type="text" class="form-control form-control-sm"></div><div class="col-md-6 form-group"><label class="small text-secondary">Scopus ID</label><input type="text" class="form-control form-control-sm" placeholder="Opsional"></div><div class="col-md-6 form-group"><label class="small text-secondary">No. Sertifikasi Dosen</label><input type="text" class="form-control form-control-sm" placeholder="SERDOS-0123-00123"></div><div class="col-md-6 form-group"><label class="small text-secondary">Orchid ID</label><input type="text" class="form-control form-control-sm" placeholder="Opsional"></div><div class="col-md-6 form-group"><label class="small text-secondary">Tgl. Sertifikasi Dosen</label><input type="text" class="form-control form-control-sm" placeholder="mm/dd/yyyy"></div><div class="col-md-6 form-group"><label class="small text-secondary">Google Scholar ID</label><input type="text" class="form-control form-control-sm" placeholder="Opsional"></div></div></div>
                                <div class="sub-tab-content" id="domisili" style="display: none;"><div class="row g-3"><div class="col-md-6 form-group"><label class="small text-secondary">Provinsi</label><select class="form-select form-select-sm"><option selected>Jawa Barat</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">Alamat</label><textarea class="form-control form-control-sm">JL. Lodaya</textarea></div><div class="col-md-6 form-group"><label class="small text-secondary">Kota</label><select class="form-select form-select-sm"><option selected>Bandung</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">Kode Pos</label><input type="text" class="form-control form-control-sm" value="10021"></div><div class="col-md-6 form-group"><label class="small text-secondary">Kecamatan</label><select class="form-select form-select-sm"><option selected>Bandung Tengah</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">No. Telepon/HP</label><input type="text" class="form-control form-control-sm" value="081239128991"></div><div class="col-md-6 form-group"><label class="small text-secondary">Kelurahan</label><select class="form-select form-select-sm"><option selected>Ciawi</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">Email Pribadi / Institusi</label><input type="text" class="form-control form-control-sm" value="aexyifshsi@gmail.com"></div></div></div>
                                <div class="sub-tab-content" id="kependudukan" style="display: none;"><div class="row g-3"><div class="col-md-6 form-group"><label class="small text-secondary">Nomor KTP</label><input type="text" class="form-control form-control-sm" value="31862908812645811"></div><div class="col-md-6 form-group"><label class="small text-secondary">Kecamatan</label><select class="form-select form-select-sm"><option selected>Talang Ubi</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">Nomor KK</label><input type="text" class="form-control form-control-sm" value="8011447152211029"></div><div class="col-md-6 form-group"><label class="small text-secondary">Kelurahan</label><select class="form-select form-select-sm"><option selected>Talang Ubi Barat</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">Warga Negara</label><select class="form-select form-select-sm"><option>--Pilih Salah Satu--</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">Alamat</label><textarea class="form-control form-control-sm">Jl Pendopo</textarea></div><div class="col-md-6 form-group"><label class="small text-secondary">Provinsi</label><select class="form-select form-select-sm"><option selected>Sumatera Selatan</option></select></div><div class="col-md-6 form-group"><label class="small text-secondary">Kode Pos</label><input type="text" class="form-control form-control-sm" value="01984"></div><div class="col-md-6 form-group"><label class="small text-secondary">Kabupaten/Kota</label><select class="form-select form-select-sm"><option selected>Sumatera Selatan</option></select></div></div></div>
                                <div class="sub-tab-content" id="efile" style="display: none;">
                                    <div class="efile-header">
                                        <h4>Dokumen</h4>
                                        <button class="btn btn-success"><i class="lni lni-plus me-1"></i> Tambah</button>
                                    </div>

                                    <div class="file-category">
                                        <p class="file-category-title">Biodata</p>
                                        <div class="file-grid">
                                            <div class="file-item">
                                                <span class="file-badge badge-asli">Asli</span>
                                                <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                                <p>Dokumen <span class="d-block">(2020)</span></p>
                                                <div class="file-item-actions">
                                                    <button class="btn btn-sm btn-success"><i class="lni lni-download me-1"></i> Unduh</button>
                                                    <button class="btn btn-sm btn-danger"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                                </div>
                                            </div>
                                            <div class="file-item">
                                                <span class="file-badge badge-asli">Asli</span>
                                                <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                                <p>Dokumen <span class="d-block">(2020)</span></p>
                                                <div class="file-item-actions">
                                                    <button class="btn btn-sm btn-success"><i class="lni lni-download me-1"></i> Unduh</button>
                                                    <button class="btn btn-sm btn-danger"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                                </div>
                                            </div>
                                            <div class="file-item">
                                                <span class="file-badge badge-legalisir">Legalisir</span>
                                                <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                                <p>Dokumen <span class="d-block">(2020)</span></p>
                                                <div class="file-item-actions">
                                                    <button class="btn btn-sm btn-success"><i class="lni lni-download me-1"></i> Unduh</button>
                                                    <button class="btn btn-sm btn-danger"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                                </div>
                                            </div>
                                            <div class="file-item">
                                                <span class="file-badge badge-scan">Scan</span>
                                                <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                                <p>Dokumen <span class="d-block">(2020)</span></p>
                                                <div class="file-item-actions">
                                                    <button class="btn btn-sm btn-success"><i class="lni lni-download me-1"></i> Unduh</button>
                                                    <button class="btn btn-sm btn-danger"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="file-category">
                                        <p class="file-category-title">Pendidikan</p>
                                        <div class="file-grid">
                                            <div class="file-item">
                                                <span class="file-badge badge-legalisir">Legalisir</span>
                                                <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                                <p>Dokumen <span class="d-block">(2020)</span></p>
                                                <div class="file-item-actions">
                                                    <button class="btn btn-sm btn-success"><i class="lni lni-download me-1"></i> Unduh</button>
                                                    <button class="btn btn-sm btn-danger"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                                </div>
                                            </div>
                                            <div class="file-item">
                                                <span class="file-badge badge-asli">Asli</span>
                                                <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                                <p>Dokumen <span class="d-block">(2020)</span></p>
                                                <div class="file-item-actions">
                                                    <button class="btn btn-sm btn-success"><i class="lni lni-download me-1"></i> Unduh</button>
                                                    <button class="btn btn-sm btn-danger"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                                </div>
                                            </div>
                                            <div class="file-item">
                                                <span class="file-badge badge-scan">Scan</span>
                                                <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                                <p>Dokumen <span class="d-block">(2020)</span></p>
                                                <div class="file-item-actions">
                                                    <button class="btn btn-sm btn-success"><i class="lni lni-download me-1"></i> Unduh</button>
                                                    <button class="btn btn-sm btn-danger"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                                </div>
                                            </div>
                                            <div class="file-item">
                                                <span class="file-badge badge-asli">Asli</span>
                                                <div class="file-item-icon"><i class="lni lni-files"></i></div>
                                                <p>Dokumen <span class="d-block">(2020)</span></p>
                                                <div class="file-item-actions">
                                                    <button class="btn btn-sm btn-success"><i class="lni lni-download me-1"></i> Unduh</button>
                                                    <button class="btn btn-sm btn-danger"><i class="lni lni-trash-can me-1"></i> Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="main-tab-content" id="pendidikan-content" style="display: none;">
                                <div id="pendidikan-sub-tabs" class="btn-group flex-wrap gap-2 mb-3">
                                    <button type="button" class="btn active" data-tab="pengajaran-lama">Pengajaran Lama</button>
                                    <button type="button" class="btn" data-tab="pengajaran-luar">Pengajaran Luar</button>
                                    <button type="button" class="btn" data-tab="pengujian-lama">Pengujian Lama</button>
                                    <button type="button" class="btn" data-tab="pembimbing-lama">Pembimbing Lama</button>
                                    <button type="button" class="btn" data-tab="penguji-luar">Penguji Luar</button>
                                    <button type="button" class="btn" data-tab="pembimbing-luar">Pembimbing Luar</button>
                                </div>
                                
                                <div class="tab-filters">
                                    <div class="filter-dropdown-wrapper"><select class="filter-dropdown"><option>Semua Semester</option></select></div>
                                    <div class="input-group" style="width: auto; max-width: 300px;"><span class="input-group-text bg-white"><i class="lni lni-search-alt text-muted"></i></span><input type="text" class="form-control" placeholder="Cari Data..."></div>
                                </div>
                                
                                <div class="sub-tab-content" id="pengajaran-lama" style="display: block;">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tahun Semester</th>
                                                    <th>Kode MK</th>
                                                    <th>Mata Kuliah</th>
                                                    <th>SKS</th>
                                                    <th>Kelas Paralel (Jenis)</th>
                                                    <th>Jumlah Pertemuan</th>
                                                    <th>Dokumen</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>2023/2024 Ganjil</td>
                                                    <td>MNH211</td>
                                                    <td>Biometrika Hutan</td>
                                                    <td>3 (3-0)</td>
                                                    <td>1 (K)</td>
                                                    <td>K,S,P,O,R,O</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>2023/2024 Genap</td>
                                                    <td>MNH215</td>
                                                    <td>Silvikultur Intensif</td>
                                                    <td>2 (2-0)</td>
                                                    <td>2 (K)</td>
                                                    <td>K,S,P,O</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>2022/2023 Ganjil</td>
                                                    <td>THH301</td>
                                                    <td>Teknologi Hasil Hutan</td>
                                                    <td>3 (2-1)</td>
                                                    <td>1 (P)</td>
                                                    <td>K,S,P</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>2022/2023 Genap</td>
                                                    <td>MNH310</td>
                                                    <td>Ekologi Hutan</td>
                                                    <td>3 (3-0)</td>
                                                    <td>3 (K)</td>
                                                    <td>K,S,P,O,R</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>2021/2022 Ganjil</td>
                                                    <td>MNH401</td>
                                                    <td>Manajemen Hutan</td>
                                                    <td>3 (3-0)</td>
                                                    <td>1 (K)</td>
                                                    <td>K,S,P,O,R,O</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="sub-tab-content" id="pengajaran-luar" style="display: none;">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tahun Semester</th>
                                                    <th>Kode MK</th>
                                                    <th>Mata Kuliah</th>
                                                    <th>Jumlah Pertemuan</th>
                                                    <th>Institusi</th>
                                                    <th>Program Studi</th>
                                                    <th>Dokumen</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>2023/2024 Ganjil</td>
                                                    <td>SKL401</td>
                                                    <td>Silvikultur Intensif</td>
                                                    <td>K,S, P,O, R,O</td>
                                                    <td>Universitas Gadjah Mada</td>
                                                    <td>Kehutanan</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>2023/2024 Genap</td>
                                                    <td>EKL302</td>
                                                    <td>Ekologi Hutan</td>
                                                    <td>K,S, P,O, R,O</td>
                                                    <td>Universitas Hasanuddin</td>
                                                    <td>Manajemen Hutan</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>2022/2023 Ganjil</td>
                                                    <td>THT501</td>
                                                    <td>Teknologi Hasil Hutan</td>
                                                    <td>K,S, P,O, R,O</td>
                                                    <td>Institut Pertanian Bogor</td>
                                                    <td>Teknologi Hasil Hutan</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>2022/2023 Genap</td>
                                                    <td>MNH212</td>
                                                    <td>Biometrika Hutan</td>
                                                    <td>K,S, P,O, R,O</td>
                                                    <td>Universitas Mulawarman</td>
                                                    <td>Kehutanan</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>2021/2022 Ganjil</td>
                                                    <td>ILH403</td>
                                                    <td>Ilmu Lingkungan Hutan</td>
                                                    <td>K,S, P,O, R,O</td>
                                                    <td>Universitas Brawijaya</td>
                                                    <td>Kehutanan</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="sub-tab-content" id="pengujian-lama" style="display: none;">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tahun Semester</th>
                                                    <th>NIM</th>
                                                    <th>Nama Mahasiswa</th>
                                                    <th>Strata</th>
                                                    <th>Departemen</th>
                                                    <th>Status</th>
                                                    <th>Dokumen</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>2023/2024 Genap</td>
                                                    <td>H2417001</td>
                                                    <td>Andi Wijaya</td>
                                                    <td>S2</td>
                                                    <td>Manajemen Hutan</td>
                                                    <td>Anggota Penguji</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>2023/2024 Ganjil</td>
                                                    <td>H2417002</td>
                                                    <td>Budi Santoso</td>
                                                    <td>S2</td>
                                                    <td>Teknologi Hasil Hutan</td>
                                                    <td>Anggota Penguji</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>2022/2023 Genap</td>
                                                    <td>H2317003</td>
                                                    <td>Citra Dewi</td>
                                                    <td>S3</td>
                                                    <td>Ilmu Kehutanan</td>
                                                    <td>Anggota Penguji</td>
                                                    <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="sub-tab-content" id="pembimbing-lama" style="display: none;">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-sm">
                                            <thead><tr><th>No</th><th>Tahun Semester</th><th>Kegiatan</th><th>Nim</th><th>Nama Mahasiswa</th><th>Strata</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                            <tbody>
                                                <tr><td>1</td><td>2020/2021 Genap</td><td>Membimbing dan ikut membimbing.. </td><td>E2039383</td><td>Alex Feruso</td><td>S1</td><td>Pembimbing Pendamping</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>
                                                <tr><td>2</td><td>2020/2021 Genap</td><td>Membimbing dan ikut membimbing.. </td><td>E2039383</td><td>Alex Feruso</td><td>S1</td><td>Pembimbing Pendamping</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>
                                                <tr><td>3</td><td>2020/2021 Genap</td><td>Membimbing dan ikut membimbing.. </td><td>E2039383</td><td>Alex Feruso</td><td>S1</td><td>Pembimbing Pendamping</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="sub-tab-content" id="penguji-luar" style="display: none;">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tahun Semester</th>
                                                    <th>NIM</th>
                                                    <th>Nama Mahasiswa</th>
                                                    <th>Strata</th>
                                                    <th>Universitas</th>
                                                    <th>Status</th>
                                                    <th>Dokumen</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <script>
                                                    for(let i=1; i<=10; i++){ 
                                                        document.write(`
                                                        <tr>
                                                            <td class="text-center">${i}</td>
                                                            <td>2018/2019 Ganjil</td>
                                                            <td class="text-center">160648032</td>
                                                            <td class="text-center">HAQQI ANNAZILLI</td>
                                                            <td>S1</td>
                                                            <td>IPB University</td>
                                                            <td>Anggota Penguji</td>
                                                            <td class="text-center"><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                            <td class="text-center">
                                                                <div class="d-flex gap-2 justify-content-center">
                                                                    <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button>
                                                                    <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="lni lni-trash-can"></i></button>
                                                                </div>
                                                            </td>
                                                        </tr>`);
                                                    }
                                                </script>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="sub-tab-content" id="pembimbing-luar" style="display: none;">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tahun Semester</th>
                                                    <th>NIM</th>
                                                    <th>Nama Mahasiswa</th>
                                                    <th>Strata</th>
                                                    <th>Universitas</th>
                                                    <th>Status</th>
                                                    <th>Dokumen</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <script>
                                                    for(let i=1; i<=10; i++){ 
                                                        document.write(`
                                                        <tr>
                                                            <td class="text-center">${i}</td>
                                                            <td>2018/2019 Ganjil</td>
                                                            <td class="text-center">160648032</td>
                                                            <td class="text-center">HAQQI ANNAZILLI</td>
                                                            <td>S2</td>
                                                            <td>IPB University</td>
                                                            <td>Pembimbing</td>
                                                            <td class="text-center"><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                            <td class="text-center">
                                                                <div class="d-flex gap-2 justify-content-center">
                                                                    <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button>
                                                                    <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="lni lni-trash-can"></i></button>
                                                                </div>
                                                            </td>
                                                        </tr>`);
                                                    }
                                                </script>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="main-tab-content" id="penelitian-content" style="display: none;">
                               <div class="tab-filters">
                                    <div class="filter-dropdown-wrapper"><select class="filter-dropdown"><option>Semua Tahun</option></select></div>
                                    <div class="input-group" style="width: auto; max-width: 300px;"><span class="input-group-text bg-white"><i class="lni lni-search-alt text-muted"></i></span><input type="text" class="form-control" placeholder="Cari Data..."></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-sm">
                                        <thead><tr><th>No</th><th>Judul</th><th>Tgl. Terbit</th><th>Jenis</th><th>Publik</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                        <tbody>
                                            <script>for(let i=1; i<=5; i++){ document.write(`<tr><td>${i}</td><td>Pengaruh Air Terhadap Tumbuh Kembang Leles</td><td>24 Desember 2021</td><td>Karya</td><td>Ya</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>`);}</script>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="main-tab-content" id="pengabdian-content" style="display: none;">
                                <div class="tab-filters">
                                    <div class="filter-dropdown-wrapper"><select class="filter-dropdown"><option>Semua Tahun</option></select></div>
                                    <div class="input-group" style="width: auto; max-width: 300px;"><span class="input-group-text bg-white"><i class="lni lni-search-alt text-muted"></i></span><input type="text" class="form-control" placeholder="Cari Data..."></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-sm">
                                        <thead><tr><th>No</th><th>Judul</th><th>Lokasi</th><th>Tgl. Pelaksanaan</th><th>Dana</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                        <tbody>
                                            <tr><td>1</td><td>Penyuluhan Pengelolaan Hutan Lestari</td><td>Desa Cibodas, Bogor</td><td>15-17 Agustus 2022</td><td>Rp 5.000.000</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="main-tab-content" id="penunjang-content" style="display: none;">
                                <div class="tab-filters">
                                    <div class="filter-dropdown-wrapper"><select class="filter-dropdown" id="penunjang-filter"><option value="organisasi">Organisasi</option><option value="jabatan">Jabatan</option><option value="penghargaan">Penghargaan</option></select></div>
                                    <div class="input-group" style="width: auto; max-width: 300px;"><span class="input-group-text bg-white"><i class="lni lni-search-alt text-muted"></i></span><input type="text" class="form-control" placeholder="Cari Data..."></div>
                                </div>
                                
                                <div class="sub-tab-content" id="organisasi">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-sm">
                                            <thead><tr><th>No</th><th>Nama Organisasi</th><th>Jabatan</th><th>Periode</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                            <tbody>
                                                <tr><td>1</td><td>Ikatan Sarjana Kehutanan Indonesia</td><td>Anggota</td><td>2020-2025</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="sub-tab-content" id="jabatan" style="display: none;">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-sm">
                                            <thead><tr><th>No</th><th>Jabatan</th><th>Unit Kerja</th><th>Periode</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                            <tbody>
                                                <tr><td>1</td><td>Ketua Program Studi</td><td>Manajemen Hutan</td><td>2018-2022</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="main-tab-content" id="pelatihan-content" style="display: none;">
                                <div class="tab-filters">
                                    <div class="filter-dropdown-wrapper"><select class="filter-dropdown"><option>Semua Tahun</option></select></div>
                                    <div class="input-group" style="width: auto; max-width: 300px;"><span class="input-group-text bg-white"><i class="lni lni-search-alt text-muted"></i></span><input type="text" class="form-control" placeholder="Cari Data..."></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-sm">
                                        <thead><tr><th>No</th><th>Nama Pelatihan</th><th>Penyelenggara</th><th>Tgl. Pelaksanaan</th><th>Lokasi</th><th>Sertifikat</th><th>Aksi</th></tr></thead>
                                        <tbody>
                                            <tr><td>1</td><td>Pelatihan Manajemen Hutan Berkelanjutan</td><td>Kementerian Lingkungan Hidup</td><td>10-12 Januari 2023</td><td>Bogor</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="main-tab-content" id="penghargaan-content" style="display: none;">
                                <div class="tab-filters">
                                    <div class="filter-dropdown-wrapper"><select class="filter-dropdown"><option>Semua Tahun</option></select></div>
                                    <div class="input-group" style="width: auto; max-width: 300px;"><span class="input-group-text bg-white"><i class="lni lni-search-alt text-muted"></i></span><input type="text" class="form-control" placeholder="Cari Data..."></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-sm">
                                        <thead><tr><th>No</th><th>Nama Penghargaan</th><th>Pemberi</th><th>Tahun</th><th>Keterangan</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                        <tbody>
                                            <tr><td>1</td><td>Dosen Berprestasi</td><td>IPB University</td><td>2021</td><td>Juara 2 Tingkat Fakultas</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="lni lni-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="lni lni-trash-can"></i></button></div></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        
        <footer class="footer-custom">
            <span>© 2025 Forest Management — All Rights Reserved</span>
        </footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const toggleSidebarBtn = document.getElementById('toggleSidebar');
        toggleSidebarBtn.addEventListener('click', function () {
            if (window.innerWidth <= 991) {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show', sidebar.classList.contains('show'));
            } else {
                sidebar.classList.toggle('hidden');
            }
        });
        overlay.addEventListener('click', function () {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
        function updateDateTime() {
            const now = new Date();
            document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }).replace(/\./g, ':');
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();
        document.getElementById('main-tab-nav').addEventListener('click', function(e) {
            if (e.target.matches('button.nav-link')) {
                document.querySelectorAll('.main-tab-nav .nav-link').forEach(tab => tab.classList.remove('active'));
                document.querySelectorAll('.main-tab-content').forEach(content => content.style.display = 'none');
                e.target.classList.add('active');
                const contentEl = document.getElementById(`${e.target.dataset.mainTab}-content`);
                if(contentEl) contentEl.style.display = 'block';
            }
        });
        document.querySelectorAll('#pendidikan-sub-tabs, #biodata-sub-tabs').forEach(tabContainer => {
            tabContainer.addEventListener('click', function(e) {
                if (e.target.matches('button')) {
                    const parentContent = this.closest('.main-tab-content');
                    this.querySelectorAll('button').forEach(btn => btn.classList.remove('active'));
                    e.target.classList.add('active');
                    parentContent.querySelectorAll('.sub-tab-content').forEach(content => content.style.display = 'none');
                    const contentEl = parentContent.querySelector(`#${e.target.dataset.tab}`);
                    if(contentEl) contentEl.style.display = 'block';
                }
            });
        });
        const penunjangFilter = document.getElementById('penunjang-filter');
        if (penunjangFilter) {
            penunjangFilter.addEventListener('change', function() {
                const parentContent = this.closest('.main-tab-content');
                parentContent.querySelectorAll('.sub-tab-content').forEach(tab => tab.style.display = 'none');
                const activeTab = document.getElementById(this.value);
                if (activeTab) activeTab.style.display = 'block';
            });
        }
    });
</script>
</body>
</html>