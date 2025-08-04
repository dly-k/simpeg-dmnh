<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pegawai - SIKEMAH</title>

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

    a.detail-link i {
      color: gray;
      cursor: pointer;
      transition: color 0.2s;
    }

    a.detail-link:hover i {
      color: black;
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
      transition: background-color 0.2s ease;
    }
    .menu-item:hover { background-color: #f0fdf4; color: #059669; }
    .menu-item.active {
      background-color: #d1fae5;
      color: #059669;
      font-weight: 600;
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

        :root {
            --primary-green: #28a745;
            --secondary-green: #218838;
            --dark-gray: #343a40;
            --light-gray-bg: #f8f9fa;
            --light-text: #6c757d;
            --border-color: #dee2e6;
            --info-blue: #0dcaf0;
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
        .btn-lihat-detail { background-color: var(--info-blue); border-color: var(--info-blue); }
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
          <li>
              <a href="/dashboard" class="menu-item">
                  <i class="fa fa-chart-bar"></i> Dashboard
              </a>
          </li>
          <li>
              <!-- Tag yang diperbaiki dan kelas 'active' ditambahkan agar sesuai dengan konteks halaman -->
              <a href="/daftar-pegawai" class="menu-item active">
                  <i class="fa fa-users"></i> Daftar Pegawai
              </a>
          </li>
          <li>
              <a href="/surat-tugas" class="menu-item">
                  <i class="fa fa-envelope"></i> Manajemen Surat Tugas
              </a>
          </li>
          <li>
              <!-- Diubah menjadi tautan ke halaman editor umum -->
              <a href="/editor" class="menu-item">
                  <i class="fa fa-edit"></i> Editor Kegiatan
              </a>
          </li>
          <ul style="margin-left: 20px;">
              <!-- Semua item sub-menu sekarang menjadi tautan -->
              <li><a href="/pendidikan" class="menu-item">🎓 Pendidikan</a></li>
              <li><a href="/penelitian" class="menu-item">🔬 Penelitian</a></li>
              <li><a href="/pengabdian" class="menu-item">🤝 Pengabdian</a></li>
              <li><a href="/penunjang" class="menu-item">📎 Penunjang</a></li>
              <li><a href="/pelatihan" class="menu-item">📚 Pelatihan</a></li>
              <li><a href="/penghargaan" class="menu-item">🏅 Penghargaan</a></li>
              <li><a href="/sk-non-pns" class="menu-item">📄 SK Non PNS</a></li>
          </ul>
          <li>
              <!-- Diubah menjadi tautan -->
              <a href="/kerjasama" class="menu-item">
                  <i class="fa fa-handshake"></i> Kerjasama
              </a>
          </li>

          <li>
            <a href="/master-data" class="menu-item">
                <i class="fa fa-database"></i> Master Data
            </a>
        </li>
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
            <h1 class="fs-4 fw-semibold"><i class="fas fa-users text-white"></i> Detail Pegawai</h1>
        </div>

        <div class="content-area">
            <div class="search-and-actions">
                <div class="main-search-bar"><input type="text" class="form-control" placeholder="🔍 Cari Data Pegawai"></div>
                <div class="action-buttons">
                    <a href="#" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Kembali Ke Daftar</a>
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
                                    <button type="button" class="btn active" data-tab="pengajaran-luar">Pengajaran Luar IPB</button>
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
                                <div class="sub-tab-content" id="pengajaran-luar" style="display: block;"><table class="table table-bordered table-hover table-sm"><thead><tr><th>No</th><th>Tahun Semester</th><th>Mata Kuliah</th><th>SKS</th><th>Kelas Paralel (Jenis)</th><th>Jumlah Pertemuan</th><th>Dokumen</th><th>Aksi</th></tr></thead><tbody><script>for(let i=1; i<=5; i++){ document.write(`<tr><td>${i}</td><td>2018/2019 Ganjil</td><td>Biometrika Hutan</td><td>3 (3-0)</td><td>1 (K)</td><td>K,S, P,O, R,O</td><td><button class="btn btn-sm text-white px-3 btn-lihat">Lihat</button></td><td><div class="d-flex gap-2 justify-content-center"><button class="btn btn-sm text-white btn-aksi btn-lihat-detail" title="Lihat Detail"><i class="fas fa-eye"></i></button><button class="btn btn-sm text-white btn-aksi btn-delete-row" title="Hapus"><i class="fas fa-trash"></i></button></div></td></tr>`);}</script></tbody></table><div class="d-flex justify-content-between align-items-center mt-3"><span class="text-muted small">Menampilkan 1 sampai 5 dari 13 data</span><nav><ul class="pagination pagination-sm mb-0"><li class="page-item"><a class="page-link" href="#">Sebelumnya</a></li><li class="page-item active"><a class="page-link" href="#">1</a></li><li class="page-item"><a class="page-link" href="#">2</a></li><li class="page-item"><a class="page-link" href="#">Berikutnya</a></li></ul></nav></div></div>
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
        
        <div class="footer">
            © 2025 Forest Management - All Rights Reserved
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

    // Generic tab functionality for buttons
    const setupTabs = (containerId, buttonSelector, contentClass) => {
        const container = document.getElementById(containerId);
        if (!container) return;

        const parentContentArea = container.closest('.main-tab-content') || document;

        container.addEventListener('click', function (e) {
            const button = e.target.closest(buttonSelector);
            if (!button || button.classList.contains('active')) return;

            container.querySelectorAll(buttonSelector).forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            const contentElements = parentContentArea.querySelectorAll(contentClass);
            contentElements.forEach(content => {
                content.style.display = 'none';
            });
            
            const tabId = button.dataset.mainTab || button.dataset.tab;
            let contentEl;
            if (contentClass === '.main-tab-content') {
                 contentEl = document.getElementById(`${tabId}-content`);
            } else {
                 contentEl = parentContentArea.querySelector(`#${tabId}`);
            }
            
            if (contentEl) {
                contentEl.style.display = 'block';
            }
        });
    };

    // Initialize all button-based tab systems
    setupTabs('main-tab-nav', '.nav-link', '.main-tab-content');
    setupTabs('pendidikan-sub-tabs', 'button', '.sub-tab-content');
    setupTabs('biodata-sub-tabs', 'button', '.sub-tab-content');
    
    // Specific handler for Penunjang dropdown filter
    const penunjangFilter = document.getElementById('penunjang-filter');
    if (penunjangFilter) {
        penunjangFilter.addEventListener('change', function() {
            const selectedValue = this.value;
            const parentContentArea = this.closest('.main-tab-content');
            
            parentContentArea.querySelectorAll('.sub-tab-content').forEach(tab => {
                tab.style.display = 'none';
            });

            const activeTab = parentContentArea.querySelector(`#${selectedValue}`);
            if (activeTab) {
                activeTab.style.display = 'block';
            }
        });
    }
});
</script>

</body>
</html>
