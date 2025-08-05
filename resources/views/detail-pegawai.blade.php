<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pegawai - SIKEMAH</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        :root {
            --primary: #049466;
            --primary-light: #e3f7ec;
            --border-color: #bbb;
            --primary-green: #28a745;
            --dark-gray: #343a40;
            --light-text: #6c757d;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #f5f6fa;
        }

        .layout {
            display: flex;
            height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #fff;
            border-right: 1px solid var(--border-color);
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease-in-out;
            z-index: 1001;
            transform: translateX(0);
        }
        .sidebar.hidden { transform: translateX(-100%); }

        .sidebar .brand {
            font-size: 24px;
            font-weight: 700;
            color: #222;
            text-align: center;
            padding: 14.5px 0;
            border-bottom: 1px solid #ccc;
            letter-spacing: 1px;
        }
        .sidebar .brand span { color: var(--primary); }

        .sidebar .menu-wrapper {
            overflow-y: auto;
            flex-grow: 1;
            padding-bottom: 80px;
            max-height: calc(100vh - 66px);
        }

        .menu p {
            font-size: 13px;
            font-weight: 500;
            padding: 0 20px;
            margin: 12px 0 8px;
            color: #888;
        }

        .sidebar .menu a,
        .sidebar .menu button {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            text-decoration: none;
            color: #333;
            font-size: 13px;
            transition: all 0.2s ease-in-out;
            width: 100%;
            background: none;
            border: none;
            text-align: left;
        }
        .sidebar .menu a:hover,
        .sidebar .menu button:hover {
            background-color: var(--primary-light);
            color: var(--primary);
            box-shadow: inset 3px 0 0 var(--primary);
        }
        .sidebar .menu a.active {
            background-color: var(--primary);
            color: #fff;
            font-weight: 600;
            box-shadow: inset 4px 0 0 #034d26;
        }
        .sidebar .menu a i,
        .sidebar .menu button i {
            margin-right: 12px;
            font-size: 16px;
            min-width: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar .submenu a {
            padding: 9px 35px;
            font-size: 12.5px;
        }
        .sidebar .menu a:first-of-type {
            margin-top: 10px;
        }

        .toggle-icon {
            margin-left: auto;
            transition: transform 0.3s;
        }
        .collapsed .toggle-icon { transform: rotate(-90deg); }

        /* Overlay for mobile sidebar */
        .overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.4);
            z-index: 1000;
            display: none;
        }
        .overlay.show { display: block; }

        /* Main Area */
        .main-wrapper {
            flex-grow: 1;
            margin-left: 250px;
            transition: margin-left 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        .sidebar.hidden ~ .main-wrapper {
            margin-left: 0;
        }

        /* Navbar */
        .navbar-custom {
            height: 66px;
            background: #fff;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            flex-shrink: 0;
        }

        .time-date {
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 20px;
            font-weight: 400;
        }
        .time-date div {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .time-date i { color: #4b5563; font-size: 13px; }

        .account {
            display: flex;
            align-items: center;
            font-size: 13px;
            font-weight: 400;
            cursor: pointer;
            margin-left: 10px;
            gap: 6px;
        }
        .account-circle {
            background: orange;
            color: #fff;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 12px;
        }

        /* Title Bar */
        .title-bar {
            background: linear-gradient(to right, #059669, #047857);
            color: white;
            padding: 20px 25px;
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }

        .title-bar h1 {
            font-size: 20px;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
        }
        .title-bar h1 i { font-size: 22px; }

        /* Main Content */
        .main-content {
            padding: 25px;
            background-color: #f5f6fa;
            flex-grow: 1;
            overflow-y: auto;
        }

        a.detail-link i {
            color: gray;
            cursor: pointer;
            transition: color 0.2s;
        }

        a.detail-link:hover i {
            color: black;
        }

        .card { border: none; box-shadow: 0 0.1rem 0.5rem rgba(0,0,0,.075); }
        .form-group label { display: block; margin-bottom: 0.25rem; }
        .form-group .form-text { font-size: 0.75rem; margin-top: -0.2rem; }
        .main-tab-nav .nav-link { border: 1px solid var(--border-color); border-radius: 0; margin-bottom: -1px; color: var(--dark-gray); font-weight: 500; }
        .main-tab-nav .nav-link.active { background-color: var(--primary-green); border-color: var(--primary-green); color: white; }
        .main-tab-nav .nav-link:first-child { border-top-left-radius: .375rem; border-top-right-radius: .375rem; }
        .main-tab-nav .nav-link:last-child { border-bottom-left-radius: .375rem; border-bottom-right-radius: .375rem; }
        .btn-success { background-color: var(--primary-green) !important; border-color: var(--primary-green) !important; }
        
        #pendidikan-sub-tabs .btn, #biodata-sub-tabs .btn {
            font-size: 0.8rem; padding: 0.4rem 0.8rem; background-color: #f8f9fa; color: var(--light-text);
            border: 1px solid var(--border-color); border-radius: 999px;
        }
        #pendidikan-sub-tabs .btn.active, #biodata-sub-tabs .btn.active {
            background-color: var(--dark-gray) !important; color: white !important; border-color: var(--dark-gray) !important;
        }

        .table th { font-weight: 600; background-color: var(--light-gray-bg); }
        .table { text-align: center; vertical-align: middle; }
        .table td, .table th { padding: 0.75rem; }
        .table-hover > tbody > tr:hover {
            background-color: #f8f9fa;
        }

        .btn-aksi {
            width: 32px; height: 32px; border-radius: 6px !important;
            display: inline-flex;
            align-items: center; justify-content: center; padding: 0;
        }
        .btn-lihat { background-color: #17a2b8; border-color: #17a2b8; }
        .btn-lihat-detail { background-color: #0dcaf0; border-color: #0dcaf0; }
        .btn-delete-row { background-color: #dc3545; border-color: #dc3545; }

        .pagination .page-link { font-size: 0.85rem; }
        .pagination .page-item.active .page-link { background-color: var(--primary-green); border-color: var(--primary-green); }
        .main-search-bar { 
            background-color: #e9ecef; 
            padding: 0.75rem; 
            margin-bottom: 1.5rem; 
            border-radius: .375rem;
            flex-grow: 1;
            margin-right: 1rem;
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
        
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
        
        .search-and-actions {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .tab-filters {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .filter-group {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        .filter-dropdown-wrapper {
            position: relative;
            display: inline-block;
        }
        .filter-dropdown {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: .375rem;
            padding: 0.5rem 2.5rem 0.5rem 1rem;
            font-size: 0.9rem;
            font-weight: 500;
            color: #495057;
            cursor: pointer;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            min-width: 150px;
        }
        .filter-dropdown:hover {
            border-color: #a1a1a1;
        }
        .filter-dropdown:focus {
            outline: 0;
            border-color: #059669;
            box-shadow: 0 0 0 0.2rem rgba(5, 150, 105, 0.25);
        }
        .filter-dropdown-wrapper::after {
            content: '\f078'; /* Font Awesome chevron-down */
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            pointer-events: none;
            color: #6c757d;
        }

        /* Footer */
        .footer-custom {
            background: #fff;
            border-top: 1px solid var(--border-color);
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 20px;
            font-size: 12px;
            color: #555;
            flex-shrink: 0;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .time-date { flex-direction: column; gap: 6px; align-items: flex-start; }
            .account span { font-size: 12px; }
            .sidebar .menu a, .sidebar .menu button { font-size: 12.5px; }
        }
    </style>
</head>
<body>

<div class="layout">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="brand">SI<span>KEMAH</span></div>
        <div class="menu-wrapper">
            <div class="menu">
                <a href="/dashboard" aria-label="Dashboard" class="menu-first"><i class="lni lni-grid-alt"></i> Dashboard</a>
                <p>Menu Utama</p>
                <a href="/daftar-pegawai" aria-label="Daftar Pegawai" class="active"><i class="lni lni-users"></i> Daftar Pegawai</a>
                <a href="/surat-tugas" aria-label="Manajemen Surat Tugas"><i class="lni lni-folder"></i> Manajemen Surat Tugas</a>
                <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#editorKegiatan" aria-expanded="true" aria-controls="editorKegiatan">
                    <i class="lni lni-pencil-alt"></i> Editor Kegiatan
                    <i class="lni lni-chevron-down toggle-icon"></i>
                </button>
                <div class="collapse show submenu" id="editorKegiatan">
                    <a href="/pendidikan" aria-label="Pendidikan">Pendidikan</a>
                    <a href="/penelitian" aria-label="Penelitian">Penelitian</a>
                    <a href="/pengabdian" aria-label="Pengabdian">Pengabdian</a>
                    <a href="/penunjang" aria-label="Penunjang">Penunjang</a>
                    <a href="/pelatihan" aria-label="Pelatihan">Pelatihan</a>
                    <a href="/penghargaan" aria-label="Penghargaan">Penghargaan</a>
                    <a href="/sk-non-pns" aria-label="SK Non PNS">SK Non PNS</a>
                </div>
                <a href="/kerjasama" aria-label="Kerjasama"><i class="lni lni-handshake"></i> Kerjasama</a>
                <a href="/master-data" aria-label="Master Data"><i class="lni lni-database"></i> Master Data</a>
            </div>
        </div>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <div class="main-wrapper">
        <!-- Navbar -->
        <div class="navbar-custom">
            <div class="d-flex align-items-center">
                <button class="btn btn-link text-dark me-3" id="toggleSidebar" aria-label="Toggle Sidebar">
                    <i class="lni lni-menu"></i>
                </button>
            </div>
            <div class="d-flex align-items-center">
                <div class="time-date me-2">
                    <div><i class="lni lni-calendar"></i> <span id="current-date"></span></div>
                    <div><i class="lni lni-timer"></i> <span id="current-time"></span></div>
                </div>
                <div class="account">
                    <div class="account-circle">KTU</div>
                    <span>Halo, Ketua TU</span>
                    <i class="lni lni-chevron-down"></i>
                </div>
            </div>
        </div>

        <!-- Title Bar -->
        <div class="title-bar">
            <h1><i class="lni lni-users"></i> <span id="page-title">Detail Pegawai</span></h1>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="search-and-actions">
                <div class="main-search-bar"><input type="text" class="form-control" placeholder="🔍 Cari Data Pegawai"></div>
                <div class="action-buttons">
                    <a href="/daftar-pegawai" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Kembali Ke Daftar</a>
                    <button class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                    <button class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                </div>
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
                                <div class="col-md-6 form-group"><label class="small text-secondary">Tgl. Lahir*</label><input type="date" class="form-control form-control-sm" value="1980-05-25"></div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-4">
                        <div class="nav flex-column nav-pills main-tab-nav" id="main-tab-nav" style="width: 200px; flex-shrink:0;">
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
                                <div class="sub-tab-content" id="efile" style="display: none;"><style>.file-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1rem; }.file-category { width: 100%; margin-bottom: 1.5rem; }.file-category-title { font-weight: 600; margin-bottom: 0.75rem; border-bottom: 1px solid #dee2e6; padding-bottom: 0.5rem;}.file-item { border: 1px solid #dee2e6; border-radius: .375rem; padding: 1rem; text-align: center; }.file-item-icon { font-size: 2.5rem; color: #6c757d; margin-bottom: 0.5rem; }.file-item p { margin-bottom: 0.75rem; font-size: 0.9rem; }.file-item-actions { display: flex; justify-content: center; gap: 0.5rem; }</style><div class="file-category"><p class="file-category-title">Biodata</p><div class="file-grid"><div class="file-item"><div class="file-item-icon"><i class="fas fa-file-alt"></i></div><p>Dokumen</p><div class="file-item-actions"><button class="btn btn-success btn-sm btn-aksi"><i class="fas fa-plus"></i></button><button class="btn btn-info btn-sm btn-aksi text-white"><i class="fas fa-eye"></i></button><button class="btn btn-danger btn-sm btn-aksi"><i class="fas fa-trash"></i></button></div></div><div class="file-item"><div class="file-item-icon"><i class="fas fa-file-alt"></i></div><p>Dokumen</p><div class="file-item-actions"><button class="btn btn-success btn-sm btn-aksi"><i class="fas fa-plus"></i></button><button class="btn btn-info btn-sm btn-aksi text-white"><i class="fas fa-eye"></i></button><button class="btn btn-danger btn-sm btn-aksi"><i class="fas fa-trash"></i></button></div></div><div class="file-item"><div class="file-item-icon"><i class="fas fa-file-alt"></i></div><p>Dokumen</p><div class="file-item-actions"><button class="btn btn-success btn-sm btn-aksi"><i class="fas fa-plus"></i></button><button class="btn btn-info btn-sm btn-aksi text-white"><i class="fas fa-eye"></i></button><button class="btn btn-danger btn-sm btn-aksi"><i class="fas fa-trash"></i></button></div></div><div class="file-item"><div class="file-item-icon"><i class="fas fa-file-alt"></i></div><p>Dokumen</p><div class="file-item-actions"><button class="btn btn-success btn-sm btn-aksi"><i class="fas fa-plus"></i></button><button class="btn btn-info btn-sm btn-aksi text-white"><i class="fas fa-eye"></i></button><button class="btn btn-danger btn-sm btn-aksi"><i class="fas fa-trash"></i></button></div></div></div></div><div class="file-category"><p class="file-category-title">Pendidikan</p><div class="file-grid"><div class="file-item"><div class="file-item-icon"><i class="fas fa-file-alt"></i></div><p>Dokumen</p><div class="file-item-actions"><button class="btn btn-success btn-sm btn-aksi"><i class="fas fa-plus"></i></button><button class="btn btn-info btn-sm btn-aksi text-white"><i class="fas fa-eye"></i></button><button class="btn btn-danger btn-sm btn-aksi"><i class="fas fa-trash"></i></button></div></div></div></div></div>
                            </div>

                            <!-- Pendidikan Content -->
                            <div class="main-tab-content" id="pendidikan-content" style="display: none;">
                                <div id="pendidikan-sub-tabs" class="btn-group flex-wrap gap-2 mb-3">
                                    <button type="button" class="btn active" data-tab="pengajaran-lama">Pengajaran Lama</button>
                                    <button type="button" class="btn" data-tab="pengajaran-luar">Pengajaran Luar IPB</button>
                                    <button type="button" class="btn" data-tab="pengujian-lama">Pengujian Lama</button>
                                    <button type="button" class="btn" data-tab="pembimbing-lama">Pembimbing Lama</button>
                                    <button type="button" class="btn" data-tab="penguji-luar">Penguji Luar IPB</button>
                                    <button type="button" class="btn" data-tab="pembimbing-luar">Pembimbing Luar IPB</button>
                                </div>
                                <div class="tab-filters">
                                    <div class="filter-group">
                                        <div class="filter-dropdown-wrapper">
                                            <select class="filter-dropdown"><option>Semua Semester</option><option>Ganjil 2018/2019</option></select>
                                        </div>
                                    </div>
                                    <div class="input-group input-group-sm" style="width: auto; max-width: 300px;"><span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span><input type="text" class="form-control" placeholder="Cari Data..."></div>
                                </div>
                                
                                <!-- Pengajaran Lama -->
                                <div class="sub-tab-content" id="pengajaran-lama" style="display: block;">
                                    <table class="table table-bordered table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tahun Semester</th>
                                                <th>Mata Kuliah</th>
                                                <th>SKS</th>
                                                <th>Kelas Paralel (Jenis)</th>
                                                <th>Jumlah Pertemuan</th>
                                                <th>Institusi</th>
                                                <th>Program Studi</th>
                                                <th>Dokumen</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <script>
                                                for(let i=1; i<=5; i++){ 
                                                    document.write(`
                                                        <tr>
                                                            <td>${i}</td>
                                                            <td>2018/2019 Ganjil</td>
                                                            <td>Biometrika Hutan</td>
                                                            <td>3 (3-0)</td>
                                                            <td>1 (K)</td>
                                                            <td>K,S, P,O, R,O</td>
                                                            <td>IPB University</td>
                                                            <td>Manajemen Hutan</td>
                                                            <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                            <td>
                                                                <div class="d-flex gap-2 justify-content-center">
                                                                    <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="fas fa-eye"></i></button>
                                                                    <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="fas fa-trash"></i></button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    `);
                                                }
                                            </script>
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <span class="text-muted small">Menampilkan 1 sampai 5 dari 13 data</span>
                                        <nav>
                                            <ul class="pagination pagination-sm mb-0">
                                                <li class="page-item"><a class="page-link" href="#">Sebelumnya</a></li>
                                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                <li class="page-item"><a class="page-link" href="#">Berikutnya</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                                
                                <!-- Pengajaran Luar IPB (updated with new columns) -->
                                <div class="sub-tab-content" id="pengajaran-luar" style="display: none;">
                                    <table class="table table-bordered table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tahun Semester</th>
                                                <th>Mata Kuliah</th>
                                                <th>SKS</th>
                                                <th>Kelas Paralel (Jenis)</th>
                                                <th>Jumlah Pertemuan</th>
                                                <th>Institusi</th>
                                                <th>Program Studi</th>
                                                <th>Dokumen</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <script>
                                                for(let i=1; i<=5; i++){ 
                                                    document.write(`
                                                        <tr>
                                                            <td>${i}</td>
                                                            <td>2018/2019 Ganjil</td>
                                                            <td>Biometrika Hutan</td>
                                                            <td>3 (3-0)</td>
                                                            <td>1 (K)</td>
                                                            <td>K,S, P,O, R,O</td>
                                                            <td>Universitas Indonesia</td>
                                                            <td>Kehutanan</td>
                                                            <td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td>
                                                            <td>
                                                                <div class="d-flex gap-2 justify-content-center">
                                                                    <button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="fas fa-eye"></i></button>
                                                                    <button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="fas fa-trash"></i></button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    `);
                                                }
                                            </script>
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <span class="text-muted small">Menampilkan 1 sampai 5 dari 13 data</span>
                                        <nav>
                                            <ul class="pagination pagination-sm mb-0">
                                                <li class="page-item"><a class="page-link" href="#">Sebelumnya</a></li>
                                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                <li class="page-item"><a class="page-link" href="#">Berikutnya</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>

                                <div class="sub-tab-content" id="pengujian-lama" style="display: none;"><table class="table table-bordered table-hover table-sm"><thead><tr><th>No</th><th>Tahun Semester</th><th>NIM</th><th>Nama Mahasiswa</th><th>Strata</th><th>Departemen</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr></thead><tbody><tr><td>1</td><td>2018/2019 Ganjil</td><td>E14070026</td><td>Alex Ferguso</td><td>S1</td><td>Manajemen Hutan</td><td>Anggota Penguji</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="fas fa-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="fas fa-trash"></i></button></div></td></tr></tbody></table></div>
                                <div class="sub-tab-content" id="pembimbing-lama" style="display: none;"><table class="table table-bordered table-hover table-sm"><thead><tr><th>No</th><th>Tahun Semester</th><th>Kegiatan</th><th>NIM</th><th>Nama Mahasiswa</th><th>Strata</th><th>Departemen</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr></thead><tbody><tr><td>1</td><td>2018/2019 Ganjil</td><td>Membimbing dan ikut membimbing</td><td>E2039383</td><td>Alex Ferguso</td><td>S1</td><td>Manajemen Hutan</td><td>Pembimbing Pendamping</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="fas fa-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="fas fa-trash"></i></button></div></td></tr></tbody></table></div>
                                <div class="sub-tab-content" id="penguji-luar" style="display: none;"><table class="table table-bordered table-hover table-sm"><thead><tr><th>No</th><th>Tahun Semester</th><th>NIM</th><th>Nama Mahasiswa</th><th>Strata</th><th>Universitas</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr></thead><tbody><tr><td>1</td><td>2018/2019 Ganjil</td><td>160648032</td><td>HAQQI ANNAZILLI</td><td>S2</td><td>Universitas Indonesia</td><td>Anggota Penguji</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="fas fa-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="fas fa-trash"></i></button></div></td></tr></tbody></table></div>
                                <div class="sub-tab-content" id="pembimbing-luar" style="display: none;"><table class="table table-bordered table-hover table-sm"><thead><tr><th>No</th><th>Tahun Semester</th><th>NIM</th><th>Nama Mahasiswa</th><th>Strata</th><th>Universitas</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr></thead><tbody><tr><td>1</td><td>2018/2019 Ganjil</td><td>160648032</td><td>HAQQI ANNAZILLI</td><td>S2</td><td>Universitas Indonesia</td><td>Anggota Penguji</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="fas fa-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="fas fa-trash"></i></button></div></td></tr></tbody></table></div>
                            </div>

                            <!-- Penelitian Content -->
                            <div class="main-tab-content" id="penelitian-content" style="display: none;">
                                <div class="tab-filters">
                                    <div class="filter-group">
                                        <div class="filter-dropdown-wrapper">
                                            <select class="filter-dropdown"><option>Semua Tahun</option><option>2021</option></select>
                                        </div>
                                    </div>
                                    <div class="input-group input-group-sm" style="width: auto; max-width: 300px;"><span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span><input type="text" class="form-control" placeholder="Cari Data..."></div>
                                </div>
                                <table class="table table-bordered table-hover table-sm"><thead><tr><th>No</th><th>Judul</th><th>Tanggal Terbit</th><th>Jenis Karya</th><th>Publik</th><th>Dokumen</th><th>Aksi</th></tr></thead><tbody><script>for(let i=1; i<=5; i++){ document.write(`<tr><td>${i}</td><td>Pengaruh Air Terhadap Tumbuh Kembang Leles</td><td>24 Desember 2021</td><td>Karya</td><td>Ya</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="fas fa-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="fas fa-trash"></i></button></div></td></tr>`);}</script></tbody></table>
                                <div class="d-flex justify-content-between align-items-center mt-3"><span class="text-muted small">Menampilkan 1 sampai 5 dari 13 data</span><nav><ul class="pagination pagination-sm mb-0"><li class="page-item"><a class="page-link" href="#">Sebelumnya</a></li><li class="page-item active"><a class="page-link" href="#">1</a></li><li class="page-item"><a class="page-link" href="#">2</a></li><li class="page-item"><a class="page-link" href="#">Berikutnya</a></li></ul></nav></div>
                            </div>

                            <!-- Pengabdian Content -->
                            <div class="main-tab-content" id="pengabdian-content" style="display: none;">
                                <div class="tab-filters">
                                    <div class="filter-group">
                                        <div class="filter-dropdown-wrapper">
                                            <select class="filter-dropdown"><option>Semua Tahun</option><option>2019</option></select>
                                        </div>
                                    </div>
                                    <div class="input-group input-group-sm" style="width: auto; max-width: 300px;"><span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span><input type="text" class="form-control" placeholder="Cari Data..."></div>
                                </div>
                                <table class="table table-bordered table-hover table-sm"><thead><tr><th>No</th><th>Kegiatan</th><th>Afiliasi</th><th>Jenis SKIM</th><th>Lokasi</th><th>Tahun Kegiatan</th><th>Dokumen</th><th>Aksi</th></tr></thead><tbody><script>for(let i=1; i<=4; i++){ document.write(`<tr><td>${i}</td><td>Pengaruh Air Terhadap Tumbuh Kembang Leles</td><td>Dinas Kehutanan DKI Jakarta</td><td>Ipteks Bagi Wilayah</td><td>Hutan Kota Srengseng</td><td>2019</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="fas fa-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="fas fa-trash"></i></button></div></td></tr>`);}</script></tbody></table>
                                <div class="d-flex justify-content-between align-items-center mt-3"><span class="text-muted small">Menampilkan 1 sampai 4 dari 13 data</span><nav><ul class="pagination pagination-sm mb-0"><li class="page-item"><a class="page-link" href="#">Sebelumnya</a></li><li class="page-item active"><a class="page-link" href="#">1</a></li><li class="page-item"><a class="page-link" href="#">2</a></li><li class="page-item"><a class="page-link" href="#">Berikutnya</a></li></ul></nav></div>
                            </div>
                            
                            <!-- Penunjang Content -->
                            <div class="main-tab-content" id="penunjang-content" style="display: none;">
                                <div class="tab-filters">
                                    <div class="filter-group">
                                        <div class="filter-dropdown-wrapper">
                                            <select id="penunjang-filter" class="filter-dropdown">
                                                <option value="panitia-badan" selected>Panitia/Badan</option>
                                                <option value="delegasi">Delegasi</option>
                                                <option value="penghargaan-jasa">Penghargaan/Tanda Jasa</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="input-group input-group-sm" style="width: auto; max-width: 300px;"><span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span><input type="text" class="form-control" placeholder="Cari Data..."></div>
                                </div>
                                <div class="sub-tab-content" id="panitia-badan" style="display: block;">
                                    <table class="table table-bordered table-hover table-sm"><thead><tr><th>No</th><th>Kegiatan</th><th>Lingkup</th><th>Nomor SK</th><th>TMT</th><th>TST</th><th>Dokumen</th><th>Aksi</th></tr></thead><tbody><script>for(let i=1; i<=5; i++){ document.write(`<tr><td>${i}</td><td>Menjadi anggota dalam suatu Panitia/Badan pada perguruan tinggi</td><td>IPB University</td><td>192/IT3/KM/2018</td><td>TGL</td><td>TGL</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="fas fa-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="fas fa-trash"></i></button></div></td></tr>`);}</script></tbody></table>
                                    <div class="d-flex justify-content-between align-items-center mt-3"><span class="text-muted small">Menampilkan 1 sampai 5 dari 13 data</span><nav><ul class="pagination pagination-sm mb-0"><li class="page-item"><a class="page-link" href="#">Sebelumnya</a></li><li class="page-item active"><a class="page-link" href="#">1</a></li><li class="page-item"><a class="page-link" href="#">2</a></li><li class="page-item"><a class="page-link" href="#">Berikutnya</a></li></ul></nav></div>
                                </div>
                                <div class="sub-tab-content" id="delegasi" style="display: none;">
                                    <table class="table table-bordered table-hover table-sm"><thead><tr><th>No</th><th>Nama Kegiatan</th><th>Penyelenggara</th><th>Pegawai</th><th>Posisi</th><th>Tanggal Mulai</th><th>Tanggal Selesai</th><th>Dokumen</th><th>Aksi</th></tr></thead><tbody><script>for(let i=1; i<=6; i++){ document.write(`<tr><td>${i}</td><td>Alex Kurniawan</td><td>IPDN</td><td>Biometrika Hutan</td><td>Magos</td><td>12 Januari 2023</td><td>19 Januari 2023</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="fas fa-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="fas fa-trash"></i></button></div></td></tr>`);}</script></tbody></table>
                                    <div class="d-flex justify-content-between align-items-center mt-3"><span class="text-muted small">Menampilkan 1 sampai 6 dari 13 data</span><nav><ul class="pagination pagination-sm mb-0"><li class="page-item"><a class="page-link" href="#">Sebelumnya</a></li><li class="page-item active"><a class="page-link" href="#">1</a></li><li class="page-item"><a class="page-link" href="#">2</a></li><li class="page-item"><a class="page-link" href="#">Berikutnya</a></li></ul></nav></div>
                                </div>
                                <div class="sub-tab-content" id="penghargaan-jasa" style="display: none;">
                                    <table class="table table-bordered table-hover table-sm"><thead><tr><th>No</th><th>Nama Kegiatan</th><th>Unit</th><th>Nomor</th><th>Penghargaan</th><th>Lingkup</th><th>Tahun</th><th>Dokumen</th><th>Aksi</th></tr></thead><tbody><script>for(let i=1; i<=5; i++){ document.write(`<tr><td>${i}</td><td>Alex Kurniawan</td><td>IPDN</td><td>Biometrika Hutan</td><td>Magos</td><td>Nasional</td><td>19 Januari 2023</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="fas fa-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="fas fa-trash"></i></button></div></td></tr>`);}</script></tbody></table>
                                    <div class="d-flex justify-content-between align-items-center mt-3"><span class="text-muted small">Menampilkan 1 sampai 5 dari 13 data</span><nav><ul class="pagination pagination-sm mb-0"><li class="page-item"><a class="page-link" href="#">Sebelumnya</a></li><li class="page-item active"><a class="page-link" href="#">1</a></li><li class="page-item"><a class="page-link" href="#">2</a></li><li class="page-item"><a class="page-link" href="#">Berikutnya</a></li></ul></nav></div>
                                </div>
                            </div>

                            <!-- Pelatihan Content -->
                            <div class="main-tab-content" id="pelatihan-content" style="display: none;">
                                <div class="tab-filters">
                                    <div class="filter-group">
                                        <div class="filter-dropdown-wrapper">
                                            <select class="filter-dropdown"><option>Semua Tahun</option><option>2022</option></select>
                                        </div>
                                    </div>
                                    <div class="input-group input-group-sm" style="width: auto; max-width: 300px;"><span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span><input type="text" class="form-control" placeholder="Cari Data..."></div>
                                </div>
                                <table class="table table-bordered table-hover table-sm">
                                    <thead><tr><th>No</th><th>Nama Pelatihan</th><th>Penyelenggara</th><th>Tahun</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                    <tbody><script>for(let i=1; i<=3; i++){ document.write(`<tr><td>${i}</td><td>Pelatihan Manajemen Hutan Digital</td><td>Kementerian LHK</td><td>2022</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="fas fa-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="fas fa-trash"></i></button></div></td></tr>`);}</script></tbody>
                                </table>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="text-muted small">Menampilkan 1 sampai 3 dari 3 data</span>
                                    <nav><ul class="pagination pagination-sm mb-0"><li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li><li class="page-item active"><a class="page-link" href="#">1</a></li><li class="page-item"><a class="page-link" href="#">Berikutnya</a></li></ul></nav>
                                </div>
                            </div>
                            
                            <!-- Penghargaan Content -->
                            <div class="main-tab-content" id="penghargaan-content" style="display: none;">
                                <div class="tab-filters">
                                    <div class="filter-group">
                                        <div class="filter-dropdown-wrapper">
                                            <select class="filter-dropdown"><option>Semua Tahun</option><option>2021</option></select>
                                        </div>
                                    </div>
                                    <div class="input-group input-group-sm" style="width: auto; max-width: 300px;"><span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span><input type="text" class="form-control" placeholder="Cari Data..."></div>
                                </div>
                                <table class="table table-bordered table-hover table-sm">
                                    <thead><tr><th>No</th><th>Nama Penghargaan</th><th>Pemberi</th><th>Tahun</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                                    <tbody><script>for(let i=1; i<=2; i++){ document.write(`<tr><td>${i}</td><td>Satyalancana Karya Satya XX</td><td>Presiden RI</td><td>2021</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="fas fa-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="fas fa-trash"></i></button></div></td></tr>`);}</script></tbody>
                                </table>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="text-muted small">Menampilkan 1 sampai 2 dari 2 data</span>
                                    <nav><ul class="pagination pagination-sm mb-0"><li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li><li class="page-item active"><a class="page-link" href="#">1</a></li><li class="page-item"><a class="page-link" href="#">Berikutnya</a></li></ul></nav>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <footer class="footer-custom">
            <span>© 2025 Forest Management — All Rights Reserved</span>
        </footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const toggleSidebarBtn = document.getElementById('toggleSidebar');

    toggleSidebarBtn.addEventListener('click', function () {
        const isMobile = window.innerWidth <= 991;
        if (isMobile) {
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
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', options);
        document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit'
        });
    }
    setInterval(updateDateTime, 1000);
    updateDateTime();

    // Tab functionality
    document.getElementById('main-tab-nav').addEventListener('click', function(e) {
        if (e.target && e.target.matches('button.nav-link')) {
            // Deactivate all tabs
            document.querySelectorAll('.main-tab-nav .nav-link').forEach(tab => tab.classList.remove('active'));
            document.querySelectorAll('.main-tab-content').forEach(content => content.style.display = 'none');
            
            // Activate clicked tab
            e.target.classList.add('active');
            const tabId = e.target.dataset.mainTab;
            const contentEl = document.getElementById(`${tabId}-content`);
            if(contentEl) {
                contentEl.style.display = 'block';
            }
        }
    });

    // Sub-tab functionality
    document.querySelectorAll('#pendidikan-sub-tabs, #biodata-sub-tabs').forEach(tabContainer => {
        tabContainer.addEventListener('click', function(e) {
            if (e.target && e.target.matches('button')) {
                const parentContent = this.closest('.main-tab-content');
                const tabId = e.target.dataset.tab;
                
                // Deactivate all buttons in this tab group
                this.querySelectorAll('button').forEach(btn => btn.classList.remove('active'));
                // Activate clicked button
                e.target.classList.add('active');
                
                // Hide all sub-tab contents in this main tab
                parentContent.querySelectorAll('.sub-tab-content').forEach(content => {
                    content.style.display = 'none';
                });
                
                // Show selected sub-tab content
                const contentEl = document.getElementById(tabId);
                if(contentEl) {
                    contentEl.style.display = 'block';
                }
            }
        });
    });

    // Penunjang filter functionality
    const penunjangFilter = document.getElementById('penunjang-filter');
    if (penunjangFilter) {
        penunjangFilter.addEventListener('change', function() {
            const selectedValue = this.value;
            const parentContent = this.closest('.main-tab-content');
            
            parentContent.querySelectorAll('.sub-tab-content').forEach(tab => {
                tab.style.display = 'none';
            });

            const activeTab = document.getElementById(selectedValue);
            if (activeTab) {
                activeTab.style.display = 'block';
            }
        });
    }
</script>
</body>
</html>