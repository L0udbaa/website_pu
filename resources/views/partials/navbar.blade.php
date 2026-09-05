<nav class="navbar admin-navbar navbar-expand bg-white">
    <div class="container-fluid px-3 px-lg-4">

        <button class="sidebar-toggle" type="button"
            data-sidebar-toggle
            aria-controls="adminSidebar"
            aria-expanded="true"
            aria-label="Toggle sidebar">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <form class="d-none d-md-flex ms-3 flex-grow-1" role="search">
            <input
                class="form-control search-input"
                type="search"
                placeholder="Search users, orders, reports"
                aria-label="Search">
        </form>

        <div class="navbar-actions ms-auto">

            {{-- THEME --}}
            <button
                class="icon-button theme-toggle"
                type="button"
                data-theme-toggle
                aria-label="Switch color theme"
                title="Switch color theme">
                <i class="bi bi-moon-stars"
                    data-theme-icon
                    aria-hidden="true"></i>
            </button>


            {{-- ===================================================== --}}
            {{-- NOTIFICATION --}}
            {{-- ===================================================== --}}

            @php
                $unreadCount = Auth::user()
                    ->unreadNotifications()
                    ->count();

                $notifications = Auth::user()
                    ->notifications()
                    ->latest()
                    ->take(5)
                    ->get();
            @endphp

            <div class="dropdown">

                <button
                    class="icon-button position-relative"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    aria-label="Notifications">

                    <i class="bi bi-bell" aria-hidden="true"></i>

                    {{-- JUMLAH NOTIFIKASI BELUM DIBACA --}}
                    @if($unreadCount > 0)
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            style="font-size: 9px; min-width: 18px;">
                            {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                        </span>
                    @endif

                </button>


                {{-- DROPDOWN NOTIFICATION --}}
                <div class="dropdown-menu dropdown-menu-end notification-menu p-0"
                    style="width: 360px; max-width: 90vw;">

                    {{-- HEADER --}}
                    <div class="dropdown-header fw-bold text-body d-flex justify-content-between align-items-center px-3 py-3">

                        <div>
                            <div>Notifications</div>

                            @if($unreadCount > 0)
                                <small class="text-muted fw-normal">
                                    {{ $unreadCount }} belum dibaca
                                </small>
                            @else
                                <small class="text-muted fw-normal">
                                    Semua sudah dibaca
                                </small>
                            @endif
                        </div>

                        @if($unreadCount > 0)
                            <form
                                method="POST"
                                action="{{ route('notifikasi.read-all') }}"
                                class="m-0">

                                @csrf

                                <button
                                    type="submit"
                                    class="btn btn-link btn-sm text-decoration-none p-0">
                                    Tandai semua
                                </button>

                            </form>
                        @endif

                    </div>


                    {{-- DAFTAR NOTIFIKASI --}}
                    <div style="max-height: 400px; overflow-y: auto;">

                        @forelse($notifications as $notification)

                            @php
                                $data = $notification->data;

                                $icon = $data['icon'] ?? 'bi-bell';

                                $jenis = $data['jenis'] ?? 'info';

                                if ($jenis === 'warning') {
                                    $iconClass = 'text-warning';
                                } elseif ($jenis === 'success') {
                                    $iconClass = 'text-success';
                                } else {
                                    $iconClass = 'text-primary';
                                }
                            @endphp


                            <div
                                class="dropdown-item px-3 py-3 border-bottom"
                                style="white-space: normal;">

                                <div class="d-flex gap-3">

                                    {{-- ICON --}}
                                    <div class="flex-shrink-0">

                                        <div
                                            class="d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px;">

                                            <i class="bi {{ $icon }} {{ $iconClass }} fs-5"></i>

                                        </div>

                                    </div>


                                    {{-- ISI NOTIFIKASI --}}
                                    <div class="flex-grow-1">

                                        <div class="d-flex justify-content-between gap-2">

                                            <strong class="small">
                                                {{ $data['judul'] ?? 'Notifikasi' }}
                                            </strong>

                                            {{-- LABEL BARU --}}
                                            @if(is_null($notification->read_at))

                                                <span
                                                    class="badge bg-primary rounded-pill"
                                                    style="font-size: 9px;">
                                                    Baru
                                                </span>

                                            @endif

                                        </div>


                                        {{-- PESAN --}}
                                        <div class="small text-muted mt-1">
                                            {{ $data['pesan'] ?? '' }}
                                        </div>


                                        {{-- WAKTU + AKSI --}}
                                        <div class="d-flex align-items-center gap-2 mt-2">

                                            <small class="text-secondary">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </small>


                                            {{-- LIHAT --}}
                                            @if(!empty($data['url']))

                                                <a
                                                    href="{{ $data['url'] }}"
                                                    class="small text-primary text-decoration-none">
                                                    Lihat
                                                </a>

                                            @endif


                                            {{-- TANDAI DIBACA --}}
                                            @if(is_null($notification->read_at))

                                                <form
                                                    method="POST"
                                                    action="{{ route('notifikasi.read', $notification->id) }}"
                                                    class="d-inline m-0">

                                                    @csrf

                                                    <button
                                                        type="submit"
                                                        class="btn btn-link btn-sm p-0 text-decoration-none">
                                                        Tandai dibaca
                                                    </button>

                                                </form>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @empty

                            {{-- BELUM ADA NOTIFIKASI --}}
                            <div class="text-center px-3 py-5">

                                <i class="bi bi-bell-slash fs-2 text-muted"></i>

                                <p class="mb-0 mt-2 text-muted">
                                    Belum ada notifikasi
                                </p>

                            </div>

                        @endforelse

                    </div>


                    {{-- FOOTER --}}
                    <div class="border-top text-center px-3 py-2">

                        <a
                            href="{{ route('notifikasi.index') }}"
                            class="small text-decoration-none">
                            Lihat semua notifikasi
                        </a>

                    </div>

                </div>
            </div>


            {{-- ===================================================== --}}
            {{-- PROFILE --}}
            {{-- ===================================================== --}}

            <div class="dropdown">

                <button
                    class="profile-button dropdown-toggle"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">

                    <img
                        class="avatar-img avatar-sm"
                        src="{{ asset('assets/images/avatar/avatar.jpg') }}"
                        alt="{{ Auth::user()->username }}">

                    <span class="profile-name d-none d-sm-inline">
                        {{ Auth::user()->username }}
                    </span>

                </button>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li>
                        <a
                            class="dropdown-item"
                            href="{{ route('profile.edit') }}">
                            Profil
                        </a>
                    </li>

                    <li>
                        <a
                            class="dropdown-item"
                            href="{{ route('settings') }}">
                            Pengaturan Akun
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>

                        <form
                            method="POST"
                            action="{{ url('logout') }}">

                            @csrf

                            <button
                                type="submit"
                                class="dropdown-item">
                                Sign out
                            </button>

                        </form>

                    </li>

                </ul>

            </div>

        </div>
    </div>
</nav>