<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="index.html">{{\Setting::getSetting()->app_name}}</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ route('home') }}"><figure class="avatar avatar-sm mr-2">
            <img src="{{ asset('/img/'.\Setting::getSetting()->logo) }}" alt="...">
          </figure></a>
    </div>
    <ul class="sidebar-menu">
        {{-- <li class="menu-header">Dashboard</li> --}}
        <li>
            <a class="nav-link {{ request()->routeIs('home') == 'home' ? 'text-primary' : '' }}" href="{{ route('home') }}"><i class="fas fa-tachometer-alt">
                </i> <span>Dashboard</span>
            </a>
        </li>
        
        
        {{-- menu untuk permission user --}}
        <li>
            <a class="nav-link {{ request()->routeIs('u.siswa.show') == 'u.siswa.show' ? 'text-primary' : '' }}" href="{{ route('u.siswa.show', Auth::user()->id) }}">
                <i class="fas fa-user-ninja    "></i>
                 <span>Profile</span></a>
        </li>
        
        <li>
            <a class="nav-link {{ request()->routeIs('u.pembayaran.create') == 'u.pembayaran.create' ? 'text-primary' : '' }}" href="{{ route('u.pembayaran.create') }}">
                <i class="fas fa-user-ninja    "></i>
                 <span>Pembayaran</span></a>
        </li>
        <li>
            <a class="nav-link {{ request()->routeIs('u.pembayaran.index') == 'u.pembayaran.index' ? 'text-primary' : '' }}" href="{{ route('u.pembayaran.index') }}">
                <i class="fas fa-file-invoice    "></i>
                 <span>Riwayat Pembayaran</span></a>
        </li>
        <li>
            <a class="nav-link {{ request()->routeIs('u.gantiPassword') == 'u.gantiPassword' ? 'text-primary' : '' }}" href="{{ route('u.gantiPassword') }}">
                <i class="fas fa-key    "></i>
                 <span>Ganti Password</span></a>
        </li>
    </ul>

</aside>