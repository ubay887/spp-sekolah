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
        
        {{-- <li class="menu-header">Starter</li> --}}
        <li class="nav-item dropdown {{ (request()->segment(1) == 'kelulusan' || request()->segment(1) == 'kenaikanKelas' || request()->segment(1) == 'kelas' ||  request()->segment(1) == 'siswa'   ) ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-user-graduate    "></i>
                <span>Manajemen Siswa</span></a>
            <ul class="dropdown-menu" style="display: none;">
                <li>
                    <a class="nav-link {{ request()->routeIs('siswa.index') == 'siswa.index' ? 'text-info' : '' }}" href="{{ route('siswa.index') }}">
                        Data Siswa
                    </a>
                </li>
                
                <li>
                    <a class="nav-link {{ request()->routeIs('kelas.index') == 'kelas.index' ? 'text-info' : '' }}" href="{{ route('kelas.index') }}">
                        Kelas
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ request()->routeIs('kelulusan.index') == 'kelulusan.index' ? 'text-primary' : '' }}" href="{{ route('kelulusan.index') }}">
                        <span>Kelulusan</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ request()->routeIs('kenaikanKelas.index') == 'kenaikanKelas.index' ? 'text-primary' : '' }}" href="{{ route('kenaikanKelas.index') }}"> 
                        <span>Pindah Kelas</span>
                    </a>
                </li>
                
            </ul>
        </li>
        <li class="nav-item dropdown {{ (request()->segment(1) == 'users' || request()->segment(1) == 'roles' || request()->segment(1) == 'pegawai' ) ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-user-tie    "></i>
                <span>Manajemen User</span></a>
            <ul class="dropdown-menu" style="display: none;">
                <li>
                    <a class="nav-link {{ request()->routeIs('users.index') == 'users.index' ? 'text-info' : '' }}" href="{{ route('users.index') }}">
                        Users
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ request()->routeIs('roles.index') == 'roles.index' ? 'text-info' : '' }}" href="{{ route('roles.index') }}">
                        Roles & Permissions
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ request()->routeIs('pegawai.index') == 'pegawai.index' ? 'text-info' : '' }}" href="{{ route('pegawai.index') }}">
                        Pegawai
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item dropdown {{ (request()->segment(1) == 'pembayaran' || request()->segment(1) == 'jenispembayaran' || request()->segment(1) == 'tahunajaran') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-file-invoice    "></i>
                <span>Pembayaran</span></a>
            <ul class="dropdown-menu" style="display: none;">
                <li>
                    <a class="nav-link {{ request()->routeIs('pembayaran.create') == 'pembayaran.create' ? 'text-info' : '' }}" href="{{ route('pembayaran.create') }}">
                        Transaksi Pembayaran
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ request()->routeIs('pembayaran.index') == 'pembayaran.index' ? 'text-info' : '' }}" href="{{ route('pembayaran.index') }}">
                        Data Pembayaran
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ request()->routeIs('jenispembayaran.index') == 'jenispembayaran.index' ? 'text-info' : '' }}" href="{{ route('jenispembayaran.index') }}">
                        Jenis Pembayaran
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ request()->routeIs('tahunajaran.index') == 'tahunajaran.index' ? 'text-info' : '' }}" href="{{ route('tahunajaran.index') }}">
                        Tahun Pelajaran
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item dropdown {{ (request()->segment(1) == 'laporan') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-columns    "></i>
                <span>Laporan</span></a>
            <ul class="dropdown-menu" style="display: none;">
                <li>
                    <a class="nav-link {{ request()->routeIs('laporan.pembayaran') == 'laporan.pembayaran' ? 'text-info' : '' }}" href="{{ route('laporan.pembayaran') }}">
                        Laporan Pembayaran
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ request()->routeIs('laporan.tagihan') == 'laporan.tagihan' ? 'text-info' : '' }}" href="{{ route('laporan.tagihan') }}">
                        Laporan Tagihan
                    </a>
                </li>
            </ul>
        </li>
        
        
        <li>
            <a class="nav-link {{ request()->routeIs('setting.index') == 'setting.index' ? 'text-primary' : '' }}" href="{{ route('setting.index') }}">
                <i class="fas fa-cog    "></i> 
                <span>Settings</span>
            </a>
        </li>
        <li>
            <a class="nav-link {{ request()->routeIs('profile.show') == 'profile.show' ? 'text-primary' : '' }}" href="{{ route('profile.show', Auth::user()->id) }}">
                <i class="fas fa-user-ninja    "></i>
                 <span>Profile</span></a>
        </li>

        
    </ul>

</aside>