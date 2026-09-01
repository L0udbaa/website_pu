<aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
    <div class="sidebar-header">
        <a class="brand-mark" href="#" aria-label="Monitoring Progres PUPR">
            <img class="" width="60" src="{{ asset('logo-pupr.png') }}" alt="">
            <span class="brand-copy">
                <span class="brand-title">PUPR</span>
                <span class="brand-subtitle">Monitoring Progres</span>
            </span>
        </a>
    </div>

    <nav class="sidebar-nav">
        <a class="nav-link active" href="#" aria-current="page">
            <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
            <span class="nav-text">Dashboard</span>
        </a>
        <a class="nav-link {{ request()->routeIs('kegiatan.*') ? 'active' : '' }}" href="{{ route('kegiatan.index') }}">
            <span class="nav-icon"><i class="bi bi-diagram-3" aria-hidden="true"></i></span>
            <span class="nav-text">Kegiatan</span>
        </a>
        <a class="nav-link {{ request()->routeIs('progres-fisik.*') ? 'active' : '' }}"
            href="{{ route('progres-fisik.index') }}">
            <span class="nav-icon"><i class="bi bi-tools" aria-hidden="true"></i></span>
            <span class="nav-text">Progres Fisik</span>
        </a>
        <a class="nav-link" href="{{ route('progres-keuangan.index') }}">
            <span class="nav-icon"><i class="bi bi-cash-coin" aria-hidden="true"></i></span>
            <span class="nav-text">Progres Keuangan</span>
        </a>
        <a class="nav-link" href="{{ route('rekapitulasi.index') }}">
            <span class="nav-icon"><i class="bi bi-clipboard-data" aria-hidden="true"></i></span>
            <span class="nav-text">Rekap Progres</span>
        </a>
    </nav>

    <div class="sidebar-user">
        <img class="avatar-img avatar-md sidebar-user-avatar" src="{{ asset('assets/images/avatar/avatar.jpg') }}"
            alt="User">
        <strong>User</strong>
        <small>Active Workspace</small>
    </div>

    <div class="sidebar-footer">
        <span class="status-dot"></span>
        <span class="sidebar-footer-text">System running smoothly</span>
    </div>
</aside>
