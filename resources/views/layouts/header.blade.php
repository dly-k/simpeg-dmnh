<div class="navbar-custom">

    <div class="d-flex align-items-center">
        <button class="btn btn-link text-dark me-2" id="toggleSidebar" aria-label="Toggle Sidebar">
            <i class="lni lni-menu"></i>
        </button>
    </div>

    <div class="d-flex align-items-center">

        {{-- Tampilan Tanggal dan Waktu --}}
        <div class="time-date me-2">
            <div>
                <i class="lni lni-calendar"></i>
                <span id="current-date"></span>
            </div>
            <div>
                <i class="lni lni-timer"></i>
                <span id="current-time"></span>
            </div>
        </div>

        {{-- Icon Notifikasi --}}
        @if(auth()->check() && auth()->user()->role === 'admin_verifikator')
        <div class="dropdown me-1">
            <a href="#" 
            class="text-dark text-decoration-none d-flex align-items-center" 
            role="button" 
            data-bs-toggle="dropdown">

                <div class="position-relative d-flex align-items-center">
                    <i class="lni lni-alarm fs-5"></i>

                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="badge bg-danger notif-badge">
                            {{ auth()->user()->unreadNotifications->count() > 99 ? '99+' : auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </div>
            </a>

            <ul class="dropdown-menu dropdown-menu-end p-2 shadow" style="width: 350px; max-height: 400px; overflow-y: auto;">
                <li>
                    <div class="dropdown-header border-bottom pb-2">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="text-dark fw-bold mb-0">Notifikasi Terbaru</h6>
                            <span class="badge bg-primary">
                                {{ auth()->user()->unreadNotifications->count() }} Baru
                            </span>
                        </div>
                        
                        {{-- Tombol Read All --}}
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <form action="{{ route('notifikasi.readAll') }}" method="POST" class="m-0 d-grid">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-success" style="font-size: 0.75rem; padding: 4px;">
                                    <i class="lni lni-checkmark-circle"></i> Tandai Semua Dibaca
                                </button>
                            </form>
                        @endif
                    </div>
                </li>
                
                @forelse(auth()->user()->unreadNotifications as $notification)
                    <li>
                        <a class="dropdown-item py-2 border-bottom text-wrap"
                        href="{{ route('notifikasi.read', $notification->id) }}">
                            
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="text-primary fw-bold">
                                    {{ $notification->data['kategori'] ?? 'Sistem' }}
                                </small>
                                <small class="text-muted" style="font-size: 0.7rem;">
                                    {{ $notification->created_at->diffForHumans() }}
                                </small>
                            </div>
                            
                            <p class="mb-0 text-dark fw-semibold" style="font-size: 0.85rem;">
                                {{ $notification->data['pesan'] ?? 'Ada submisi baru.' }}
                            </p>
                            
                            <p class="mb-0 text-muted" style="font-size: 0.75rem;">
                                <i class="lni lni-files me-1"></i> 
                                {{ $notification->data['keterangan'] ?? '' }}
                            </p>

                        </a>
                    </li>
                @empty
                    <li>
                        <div class="dropdown-item text-center text-muted py-4">
                            <i class="lni lni-alarm fs-4 mb-2 text-light"></i>
                            <p class="mb-0">Belum ada notifikasi baru</p>
                        </div>
                    </li>
                @endforelse
            </ul>
        </div>
        @endif

        {{-- Dropdown Akun Pengguna --}}
        <div class="dropdown">
            <a href="#" class="account text-decoration-none text-dark" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="icon-circle">
                    <i class="lni lni-user"></i>
                </span>
                <span class="user-name">
                    Halo, {{ Auth::user()->pegawai->nama_lengkap ?? 'Pengguna' }}
                </span>
                <i class="lni lni-chevron-down"></i>
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="/ubah-password">
                        <i class="lni lni-key me-2"></i>
                        Ubah Password
                    </a>
                </li>

                <li><hr class="dropdown-divider"></li>

                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item d-flex align-items-center dropdown-item-danger">
                            <i class="lni lni-exit me-2"></i>
                            Keluar
                        </button>
                    </form>
                </li>
            </ul>

        </div>

    </div>

</div>