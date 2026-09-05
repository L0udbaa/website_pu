<aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
    <div class="sidebar-header">
        <a class="brand-mark" href="#" aria-label="Monitoring Progres Kementerian Pekerjaan Umum">
            <img class="" width="60" src="{{ asset('logo-pupr.png') }}" alt="Logo Kementerian Pekerjaan Umum">
            <span class="brand-copy">
            <span class="brand-title">KEMENTERIAN PEKERJAAN UMUM</span>
                <span class="brand-subtitle">Monitoring Progres</span>
            </span>
        </a>
    </div>

    <nav class="sidebar-nav">
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"
            @if (request()->routeIs('dashboard')) aria-current="page" @endif>
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
            alt="{{ auth()->user()->nama }}">
        <strong>{{ auth()->user()->nama }}</strong>
        <small>{{ ucfirst(auth()->user()->role) }} Account</small>
    </div>
</aside>
