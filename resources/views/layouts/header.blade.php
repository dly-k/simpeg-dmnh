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

            <ul class="dropdown-menu dropdown-menu-end p-0 shadow-lg" style="width: 400px; max-height: 500px; overflow-y: auto; border-radius: 12px;">
                {{-- Header Panel --}}
                <li>
                    <div class="px-4 py-3 border-bottom d-flex justify-content-between align-items-center bg-white" style="border-radius: 12px 12px 0 0;">
                        <span class="fw-bold text-dark" style="font-size: 0.95rem;">Notifikasi Terbaru</span>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="rounded-pill px-3 py-1" style="font-size:0.72rem; font-weight:600; background:#f3f4f6; color:#374151; border:1px solid #d1d5db;">
                                {{ auth()->user()->unreadNotifications->count() }} Baru
                            </span>
                        @endif
                    </div>
                </li>

                {{-- Tombol Tandai Semua --}}
                @if(auth()->user()->unreadNotifications->count() > 0)
                <li>
                    <div class="px-3 py-2 border-bottom">
                        <form action="{{ route('notifikasi.readAll') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit"
                                class="w-100 border rounded fw-semibold py-2"
                                style="font-size: 0.82rem; cursor:pointer; background:#fff; color:#16a34a; border-color:#16a34a !important; transition: all 0.2s;"
                                onmouseover="this.style.background='#f0fdf4'"
                                onmouseout="this.style.background='#fff'">
                                <i class="fas fa-check-circle me-1"></i> Tandai Semua Dibaca
                            </button>
                        </form>
                    </div>
                </li>
                @endif
                
                @forelse(auth()->user()->unreadNotifications as $notification)
                    @php
                        $pesan   = $notification->data['pesan'] ?? 'Ada notifikasi baru.';
                        $ket     = $notification->data['keterangan'] ?? '';
                        $isPending = str_contains(strtolower($pesan), 'tertunda') || str_contains(strtolower($pesan), '30 hari');
                        $badgeBg     = $isPending ? '#fef3c7' : '#dbeafe';
                        $badgeColor  = $isPending ? '#92400e' : '#1e40af';
                        $badgeBorder = $isPending ? '#fcd34d' : '#93c5fd';
                        $badgeLabel  = $isPending ? 'Tertunda >30 Hari' : 'Submisi Masuk';
                    @endphp
                    <li>
                        <a class="text-decoration-none d-block px-4 py-3 border-bottom"
                           href="{{ route('notifikasi.read', $notification->id) }}"
                           style="background:#fff; transition: background 0.15s;"
                           onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='#fff'">

                            {{-- Baris 1: Badge + Timestamp --}}
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="rounded-pill px-2 py-1" style="font-size:0.68rem; font-weight:600; background:{{ $badgeBg }}; color:{{ $badgeColor }}; border:1px solid {{ $badgeBorder }};">
                                    {{ $badgeLabel }}
                                </span>
                                <small class="text-muted" style="font-size:0.7rem;">
                                    {{ $notification->created_at->diffForHumans() }}
                                </small>
                            </div>

                            {{-- Baris 2: Icon + Judul & Deskripsi --}}
                            <div class="d-flex align-items-start gap-3">
                                <div class="flex-shrink-0 d-flex align-items-center justify-content-center rounded" style="width:36px; height:36px; background:#f3f4f6; margin-top:2px;">
                                    <i class="fas fa-envelope" style="font-size:0.85rem; color:#6b7280;"></i>
                                </div>
                                <div class="flex-grow-1" style="min-width:0;">
                                    <p class="mb-1 fw-semibold text-dark text-wrap" style="font-size:0.85rem; line-height:1.4;">
                                        {{ $pesan }}
                                    </p>
                                    @if($ket)
                                    <p class="mb-0 text-wrap" style="font-size:0.75rem; color:#6b7280; line-height:1.3;">
                                        {{ $ket }}
                                    </p>
                                    @endif
                                </div>
                            </div>

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