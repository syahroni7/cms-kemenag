<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        {{-- ================= Beranda Utama ================= --}}
        @can('menu-dashboard')
            <li class="nav-heading">Beranda Utama</li>

            @can('page-dashboard')
                <li class="nav-item">
                    <a class="nav-link {{ request()->segment(1) == 'home' ? '' : 'collapsed' }}" href="/dashboard">
                        <i class="bi bi-grid"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            @endcan
        @endcan

        {{-- ================= Kelola Data Utama ================= --}}
        @can('menu-main')
            <li class="nav-heading">Kelola Data Utama</li>

            @can('page-main-permission')
                <li class="nav-item">
                    <a class="nav-link {{ request()->segment(1) == 'permissions' ? '' : 'collapsed' }}" href="{{ route('permissions.index') }}">
                        <i class="bi bi-credit-card-2-front"></i>
                        <span>Kelola Izin Akses</span>
                    </a>
                </li>
            @endcan

            {{-- Kelola Pengguna --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->segment(1) == 'users' ? '' : 'collapsed' }}"
                   data-bs-target="#users-nav" data-bs-toggle="collapse"
                   href="#" aria-expanded="{{ request()->segment(1) == 'users' ? 'true' : 'false' }}">
                    <i class="bi bi-person"></i>
                    <span>Kelola Pengguna</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="users-nav" class="nav-content collapse {{ request()->segment(1) == 'users' ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('user-data.index') }}" class="{{ request()->segment(2) == 'data' ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span>Daftar Pengguna</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user-roles.index') }}" class="{{ request()->segment(2) == 'roles' ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span>Daftar Peran</span>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Kelola Unit Pengolah --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->segment(1) == 'unit-pengolah' ? '' : 'collapsed' }}" href="{{ route('unit-pengolah.index') }}">
                    <i class="bi bi-file-person"></i>
                    <span>Kelola Unit Pengolah</span>
                </a>
            </li>
        @endcan

        {{-- ================= Kelola Website ================= --}}
        @can('menu-pengaturan')
            <li class="nav-heading">Kelola Website</li>

            @can('page-pengaturan-list')
                <li class="nav-item">
                    <a class="nav-link {{ request()->segment(1) == 'pengaturan' ? '' : 'collapsed' }}"
                       data-bs-target="#pengaturan-nav" data-bs-toggle="collapse"
                       href="#" aria-expanded="{{ request()->segment(1) == 'pengaturan' ? 'true' : 'false' }}">
                        <i class="bi bi-receipt-cutoff"></i>
                        <span>Pengaturan Web</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="pengaturan-nav" class="nav-content collapse {{ request()->segment(1) == 'pengaturan' ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ route('pengaturan-logo.index') }}" class="{{ request()->segment(2) == 'logo' ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span>Logo</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pengaturan-menu.index') }}" class="{{ request()->segment(2) == 'menus' ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span>Navbar</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pengaturan-kontak.index') }}" class="{{ request()->segment(2) == 'kontak' ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span>Kontak</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user-roles.index') }}" class="{{ request()->segment(2) == 'roles' ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span>Footer</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('page-disposisi-master')
                <li class="nav-item">
                    <a class="nav-link {{ (request()->segment(1) == 'disposisi' && request()->segment(2) == 'master') ? '' : 'collapsed' }}" href="{{ route('disposisi-master.index') }}">
                        <i class="bi bi-mailbox"></i>
                        <span>Master Disposisi</span>
                    </a>
                </li>
            @endcan
        @endcan

        {{-- ================= Kelola Pelayanan ================= --}}
        @can('menu-pelayanan')
            <li class="nav-heading">Kelola Pelayanan</li>

            @can('page-pelayanan-input')
                <li class="nav-item">
                    <a class="nav-link {{ (request()->segment(1) == 'daftar-pelayanan' && request()->segment(2) == 'create') ? '' : 'collapsed' }}" href="{{ route('daftar-pelayanan.create') }}">
                        <i class="bi bi-pencil-square"></i>
                        <span>Input / Lacak Pelayanan</span>
                    </a>
                </li>
            @endcan

            @can('page-pelayanan-list')
                <li class="nav-item">
                    <a class="nav-link {{ (request()->segment(1) == 'daftar-pelayanan' && request()->segment(2) == 'list') ? '' : 'collapsed' }}"
                       data-bs-target="#pelayanan-nav" data-bs-toggle="collapse" href="#" aria-expanded="true">
                        <i class="bi bi-receipt-cutoff"></i>
                        <span>Daftar Pelayanan</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="pelayanan-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
                        @foreach ($statusPelayanan as $status)
                            @php
                                $isActive = request()->segment(3) == strtolower($status['name']);
                                $linkStatus = $isActive ? 'javascript:void(0)' : route('daftar-pelayanan.index', strtolower($status['name']));
                            @endphp
                            <li>
                                <a href="{{ $linkStatus }}" class="menu-status menu-{{ $status['name'] }} {{ $isActive ? 'active' : '' }}" data-status_pelayanan="{{ $status['name'] }}">
                                    <i class="bi bi-circle"></i>
                                    <span style="width: 100% !important">
                                        {{ ucfirst($status['name']) }}
                                        <div class="float-end">
                                            <span class="badge total-{{ $status['name'] }} bg-{{ $status['color'] }}">{{ $status['total'] }}</span>
                                        </div>
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endcan
        @endcan

        {{-- ================= Kelola Arsip Layanan ================= --}}
        @can('menu-arsip')
            <li class="nav-heading">Kelola Arsip Layanan</li>
            @can('page-arsip-pelayanan')
                <li class="nav-item">
                    <a class="nav-link {{ request()->segment(1) == 'arsip-pelayanan' ? '' : 'collapsed' }}" href="{{ route('arsip-pelayanan.index') }}">
                        <i class="bi bi-arrow-down-square"></i>
                        <span>Arsip Pelayanan</span>
                    </a>
                </li>
            @endcan
        @endcan

        {{-- ================= Kelola Master Layanan ================= --}}
        @can('menu-layanan')
            <li class="nav-heading">Kelola Master Layanan</li>

            @can('page-layanan-jenis')
                <li class="nav-item">
                    <a class="nav-link {{ request()->segment(1) == 'jenis-layanan' ? '' : 'collapsed' }}" href="{{ route('jenis-layanan.index') }}">
                        <i class="bi bi-window-dock"></i>
                        <span>Jenis Layanan</span>
                    </a>
                </li>
            @endcan

            @can('page-layanan-output')
                <li class="nav-item">
                    <a class="nav-link {{ request()->segment(1) == 'output-layanan' ? '' : 'collapsed' }}" href="{{ route('output-layanan.index') }}">
                        <i class="bi bi-wallet"></i>
                        <span>Output Layanan</span>
                    </a>
                </li>
            @endcan

            @can('page-layanan-daftar')
                <li class="nav-item">
                    <a class="nav-link {{ request()->segment(1) == 'daftar-layanan' ? '' : 'collapsed' }}" href="{{ route('daftar-layanan.index') }}">
                        <i class="bi bi-vr"></i>
                        <span>Daftar Layanan</span>
                    </a>
                </li>
            @endcan

            @can('page-layanan-syarat-master')
                <li class="nav-item">
                    <a class="nav-link {{ request()->segment(1) == 'syarat-layanan' ? '' : 'collapsed' }}"
                       data-bs-target="#syarat-nav" data-bs-toggle="collapse"
                       href="#" aria-expanded="{{ request()->segment(1) == 'syarat-layanan' ? 'true' : 'false' }}">
                        <i class="bi bi-view-stacked"></i>
                        <span>Kelola Syarat</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="syarat-nav" class="nav-content collapse {{ request()->segment(1) == 'syarat-layanan' ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ route('syarat-layanan-master.index') }}" class="{{ request()->segment(2) == 'master' ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span>Master Syarat</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('syarat-layanan-list.index') }}" class="{{ request()->segment(2) == 'list' ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span>Daftar Syarat</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
        @endcan

        {{-- ================= Kelola Laporan ================= --}}
        @can('menu-report')
            <li class="nav-heading">Kelola Laporan</li>
            @can('page-report-layanan')
                <li class="nav-item">
                    <a class="nav-link {{ request()->segment(1) == 'laporan-layanan' ? '' : 'collapsed' }}" href="{{ route('laporan-layanan.index', 'layanan') }}">
                        <i class="bi bi-book"></i>
                        <span>Laporan Layanan</span>
                    </a>
                </li>
            @endcan
        @endcan

    </ul>
</aside>
