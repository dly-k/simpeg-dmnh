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

            @php
                $editorRoutes = ['pendidikan*', 'penelitian*', 'pengabdian*', 'penunjang*', 'pelatihan*', 'penghargaan*', 'sk-non-pns*'];
                $isEditorActive = Request::is(...$editorRoutes);
            @endphp

            {{-- Editor Kegiatan (Dropdown) --}}
            <button class="{{ $isEditorActive ? 'active' : 'collapsed' }}"
                    data-bs-toggle="collapse"
                    data-bs-target="#editorKegiatan"
                    aria-expanded="{{ $isEditorActive ? 'true' : 'false' }}"
                    aria-controls="editorKegiatan">
                <i class="lni lni-pencil-alt"></i> Editor Kegiatan
                <i class="lni lni-chevron-down toggle-icon"></i>
            </button>

            {{-- Submenu Editor Kegiatan --}}
            <div class="collapse submenu {{ $isEditorActive ? 'show' : '' }}" id="editorKegiatan">
                <a href="/pendidikan" class="{{ Request::is('pendidikan*') ? 'active' : '' }}">Pendidikan</a>
                <a href="/penelitian" class="{{ Request::is('penelitian*') ? 'active' : '' }}">Penelitian</a>
                <a href="/pengabdian" class="{{ Request::is('pengabdian*') ? 'active' : '' }}">Pengabdian</a>
                <a href="/penunjang" class="{{ Request::is('penunjang*') ? 'active' : '' }}">Penunjang</a>
                <a href="/pelatihan" class="{{ Request::is('pelatihan*') ? 'active' : '' }}">Pelatihan</a>
                <a href="/penghargaan" class="{{ Request::is('penghargaan*') ? 'active' : '' }}">Penghargaan</a>
                <a href="/sk-non-pns" class="{{ Request::is('sk-non-pns*') ? 'active' : '' }}">SK Non PNS</a>
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