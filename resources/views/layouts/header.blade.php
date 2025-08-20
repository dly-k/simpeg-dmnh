{{-- resources/views/layouts/header.blade.php --}}

<div class="navbar-custom">
    {{-- Tombol untuk menampilkan/menyembunyikan sidebar di mode mobile --}}
    <div class="d-flex align-items-center">
        <button class="btn btn-link text-dark me-3" id="toggleSidebar" aria-label="Toggle Sidebar">
            <i class="lni lni-menu"></i>
        </button>
    </div>

    <div class="d-flex align-items-center">
        {{-- Tampilan Tanggal dan Waktu --}}
        <div class="time-date me-2">
            <div><i class="lni lni-calendar"></i> <span id="current-date"></span></div>
            <div><i class="lni lni-timer"></i> <span id="current-time"></span></div>
        </div>

        {{-- Dropdown Akun Pengguna --}}
        <div class="dropdown">
            <a href="#" class="account text-decoration-none text-dark" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="icon-circle"><i class="lni lni-user"></i></span>
                {{-- Nama pengguna bisa dibuat dinamis sesuai sesi login --}}
                <span>Halo, Ketua TU</span> 
                <i class="lni lni-chevron-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="/ubah-password">
                        <i class="lni lni-key me-2"></i> Ubah Password
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item d-flex align-items-center dropdown-item-danger" href="/logout">
                        <i class="lni lni-exit me-2"></i> Keluar
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>