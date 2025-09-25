<div class="sidebar" id="sidebar">
    {{-- Brand --}}
    <div class="brand">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="logo">
        <span class="text-jarak">SI</span><span>KEMAH</span>
    </div>

    {{-- Menu Wrapper --}}
    <div class="menu-wrapper">
        <div class="menu">
            {{-- Dashboard --}}
            <a href="/dashboard" aria-label="Dashboard" class="{{ Request::is('dashboard') ? 'active' : '' }}">
                <i class="lni lni-grid-alt"></i> Dashboard
            </a>

            <p>Menu Utama</p>

            {{-- Daftar Pegawai --}}
            <a href="/daftar-pegawai" class="{{ Request::is('daftar-pegawai*') ? 'active' : '' }}">
                <i class="lni lni-users"></i> Daftar Pegawai
            </a>

            {{-- Manajemen Surat Tugas --}}
            <a href="/surat-tugas" class="{{ Request::is('surat-tugas*') ? 'active' : '' }}">
                <i class="lni lni-folder"></i> Manajemen Surat Tugas
            </a>

            {{-- Editor --}}
            @php
                $editorRoutes = ['pelatihan*', 'penghargaan*', 'praktisi-dunia-industri*'];
                $isEditorActive = Request::is(...$editorRoutes);
            @endphp

            <button class="{{ $isEditorActive ? 'active' : 'collapsed' }}"
                    data-bs-toggle="collapse"
                    data-bs-target="#editor"
                    aria-expanded="{{ $isEditorActive ? 'true' : 'false' }}"
                    aria-controls="editor">
                <i class="lni lni-write"></i> Editor
                <i class="lni lni-chevron-down toggle-icon"></i>
            </button>

            <div class="collapse submenu {{ $isEditorActive ? 'show' : '' }}" id="editor">
                <a href="/pelatihan" class="{{ Request::is('pelatihan*') ? 'active' : '' }}">Diklat</a>
                <a href="/penghargaan" class="{{ Request::is('penghargaan*') ? 'active' : '' }}">Penghargaan</a>
                <a href="/praktisi-dunia-industri" class="{{ Request::is('praktisi-dunia-industri*') ? 'active' : '' }}">
                    Praktisi Dunia Industri
                </a>
            </div>

            {{-- Editor Kegiatan --}}
            @php
                $editorKegiatanRoutes = [
                    'bahan-ajar*', 'pembicara*', 'pengabdian*', 'organisasi-profesi*', 'pembimbingan*',
                    'penunjang*', 'orasi-ilmiah*', 'sertifikat-kompetensi*', 'pendidikan*',
                    'pengelola-jurnal*', 'penelitian*', 'kekayaan-intelektual*'
                ];
                $isEditorKegiatanActive = Request::is(...$editorKegiatanRoutes);
            @endphp

            <button class="{{ $isEditorKegiatanActive ? 'active' : 'collapsed' }}"
                    data-bs-toggle="collapse"
                    data-bs-target="#editorKegiatan"
                    aria-expanded="{{ $isEditorKegiatanActive ? 'true' : 'false' }}"
                    aria-controls="editorKegiatan">
                <i class="lni lni-pencil-alt"></i> Editor Kegiatan
                <i class="lni lni-chevron-down toggle-icon"></i>
            </button>

            <div class="collapse submenu {{ $isEditorKegiatanActive ? 'show' : '' }}" id="editorKegiatan">
                <a href="/bahan-ajar" class="{{ Request::is('bahan-ajar*') ? 'active' : '' }}">Bahan Ajar</a>
                <a href="/pembicara" class="{{ Request::is('pembicara*') ? 'active' : '' }}">Pembicara</a>
                <a href="/pengabdian" class="{{ Request::is('pengabdian*') ? 'active' : '' }}">Pengabdian</a>
                <a href="/organisasi-profesi" class="{{ Request::is('organisasi-profesi*') ? 'active' : '' }}">
                    Organisasi Profesi
                </a>
                <a href="/pembimbingan" class="{{ Request::is('pembimbingan*') ? 'active' : '' }}">Pembimbingan</a>
                <a href="/penunjang" class="{{ Request::is('penunjang*') ? 'active' : '' }}">Penunjang</a>
                <a href="/orasi-ilmiah" class="{{ Request::is('orasi-ilmiah*') ? 'active' : '' }}">Orasi Ilmiah</a>
                <a href="/sertifikat-kompetensi" class="{{ Request::is('sertifikat-kompetensi*') ? 'active' : '' }}">
                    Sertifikat Kompetensi
                </a>
                <a href="/pendidikan" class="{{ Request::is('pendidikan*') ? 'active' : '' }}">Akademik</a>
                <a href="/pengelola-jurnal" class="{{ Request::is('pengelola-jurnal*') ? 'active' : '' }}">
                    Pengelola Jurnal
                </a>
                <a href="/penelitian" class="{{ Request::is('penelitian*') ? 'active' : '' }}">Penelitian</a>
                <a href="/kekayaan-intelektual" class="{{ Request::is('kekayaan-intelektual*') ? 'active' : '' }}">
                    Kekayaan Intelektual
                </a>
            </div>

            {{-- Kerjasama --}}
            <a href="/kerjasama" class="{{ Request::is('kerjasama*') ? 'active' : '' }}">
                <i class="lni lni-handshake"></i> Kerjasama
            </a>

            {{-- Master Data --}}
            <a href="/master-data" class="{{ Request::is('master-data*') ? 'active' : '' }}">
                <i class="lni lni-database"></i> Master Data
            </a>
        </div>
    </div>
</div>