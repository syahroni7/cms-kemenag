<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        @can('menu-dashboard')
            <li class="nav-heading">Beranda utama</li>
            @can('page-dashboard')
                <li class="nav-item"> <a class="nav-link @if (request()->segment(1) == 'home') @else collapsed @endif" href="/home">
                        <i class="bi bi-grid"></i>
                        <span>Dashboard</span> </a>
                </li>
            @endcan
        @endcan


        @can('menu-main')
            <li class="nav-heading">Kelola Data Utama</li>
            @can('page-main-permission')
                {{-- Kelola Izin Akses --}}
                <li class="nav-item"><a class="nav-link @if (request()->segment(1) == 'permissions') @else collapsed @endif" href="{{ route('permissions.index') }}"><i class="bi bi-credit-card-2-front"></i><span>Kelola Izin
                            Akses</span></a></li>
            @endcan

            {{-- Kelola Pengguna --}}
            <li class="nav-item">
                <a class="nav-link @if (request()->segment(1) == 'users') @else collapsed @endif" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#" aria-expanded="@if (request()->segment(1) == 'users') true @else false @endif">
                    <i class="bi bi-person"></i><span>Kelola Pengguna</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav" class="nav-content collapse @if (request()->segment(1) == 'users') show @endif" data-bs-parent="#sidebar-nav" style="">
                    <li>
                        <a href="{{ route('user-data.index') }}" class="@if (request()->segment(2) == 'data') active @endif">
                            <i class="bi bi-circle"></i><span>Daftar Pengguna</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user-roles.index') }}" class="@if (request()->segment(2) == 'roles') active @endif">
                            <i class="bi bi-circle"></i><span>Daftar Peran</span>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Kelola Unit Pengolah --}}
            <li class="nav-item"><a class="nav-link @if (request()->segment(1) == 'unit-pengolah') @else collapsed @endif" href="{{ route('unit-pengolah.index') }}"><i class="bi bi-file-person"></i><span>Kelola Unit
                        Pengolah</span></a></li>
        @endcan



        {{-- @can('menu-disposisi')
            <li class="nav-heading">Kelola Disposisi</li>

            @can('page-disposisi-list')
                <li class="nav-item">
                    <a class="nav-link pe-0 @if (request()->segment(1) == 'disposisi' && request()->segment(2) == 'list') @else collapsed @endif" href="{{ route('disposisi-list.index', 'baru') }}"><i class="bi bi-list-task"></i>
                        <span style="width: 100% !important">
                            Daftar Disposisi
                        </span>
                    </a>
                </li>
            @endcan

            @can('page-disposisi-master')
                <li class="nav-item">
                    <a class="nav-link @if (request()->segment(1) == 'disposisi' && request()->segment(2) == 'master') @else collapsed @endif" href="{{ route('disposisi-master.index', 'selesai') }}"><i class="bi bi-mailbox"></i>
                        <span>Master Disposisi</span>
                    </a>
                </li>
            @endcan


        @endcan --}}

        @can('menu-disposisi')
            <li class="nav-heading">Kelola Disposisi</li>

            @can('page-disposisi-list')
                {{-- Daftar Pelayanan --}}
                <li class="nav-item">
                    <a class="nav-link @if (request()->segment(1) == 'disposisi' && request()->segment(2) == 'list') @else collapsed @endif" data-bs-target="#disposisi-nav" data-bs-toggle="collapse" href="#" aria-expanded="true">
                        <i class="bi bi-receipt-cutoff"></i><span>Daftar Disposisi</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="disposisi-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav" style="">

                        <li>
                            @if (request()->segment(1) == 'disposisi' && request()->segment(2) == 'list')
                                @php $linkDisposisi = 'javascript:void(0)' @endphp
                            @else
                                @php $linkDisposisi = trim(route('disposisi-list.index', strtolower('baru'))) @endphp
                            @endif

                            <a href="{{ $linkDisposisi }}" class="disposisi-status disposisi-baru @if (request()->segment(3) == strtolower('baru')) active @endif" data-status_disposisi="baru">
                                <i class="bi bi-circle"></i>
                                <span style="width: 100% !important">
                                    Baru
                                    <div class="float-end">
                                        <span class="badge total-disposisi bg-danger">-</span>
                                    </div>
                                </span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ $linkDisposisi }}" class="disposisi-status disposisi-selesai @if (request()->segment(3) == strtolower('selesai')) active @endif" data-status_disposisi="selesai">
                                <i class="bi bi-circle"></i>
                                <span style="width: 100% !important">
                                    Selesai
                                </span>
                            </a>
                        </li>

                    </ul>
                </li>
            @endcan

            @can('page-disposisi-master')
                <li class="nav-item">
                    <a class="nav-link @if (request()->segment(1) == 'disposisi' && request()->segment(2) == 'master') @else collapsed @endif" href="{{ route('disposisi-master.index') }}"><i class="bi bi-mailbox"></i>
                        <span>Master Disposisi</span>
                    </a>
                </li>
            @endcan


        @endcan

        @can('menu-pelayanan')
            <li class="nav-heading">Kelola Pelayanan</li>

            @can('page-pelayanan-input')
                <li class="nav-item"><a class="nav-link @if (request()->segment(1) == 'daftar-pelayanan' && request()->segment(2) == 'create') @else collapsed @endif" href="{{ route('daftar-pelayanan.create') }}"><i class="bi bi-pencil-square"></i><span>Input / Lacak Pelayanan</span></a></li>
            @endcan

            @can('page-pelayanan-list')
                {{-- Daftar Pelayanan --}}
                <li class="nav-item">
                    <a class="nav-link @if (request()->segment(1) == 'daftar-pelayanan' && request()->segment(2) == 'list') @else collapsed @endif" data-bs-target="#pelayanan-nav" data-bs-toggle="collapse" href="#" aria-expanded="true">
                        <i class="bi bi-receipt-cutoff"></i><span>Daftar Pelayanan</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="pelayanan-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav" style="">

                        @foreach ($statusPelayanan as $key => $status)
                            <li>
                                @if (request()->segment(1) == 'daftar-pelayanan' && request()->segment(2) == 'list')
                                    @php $linkStatus = 'javascript:void(0)' @endphp
                                @else
                                    @php $linkStatus = trim(route('daftar-pelayanan.index', strtolower($status['name']))) @endphp
                                @endif

                                <a href="{{ $linkStatus }}" class="menu-status menu-{{ $status['name'] }} @if (request()->segment(3) == strtolower($status['name'])) active @endif " data-status_pelayanan="{{ $status['name'] }}">
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

        @can('menu-arsip')
            <li class="nav-heading">Kelola Arsip Layanan</li>
            @can('page-arsip-pelayanan')
                <li class="nav-item"><a class="nav-link @if (request()->segment(1) == 'arsip-pelayanan') @else collapsed @endif" href="{{ route('arsip-pelayanan.index') }}"><i class="bi bi-arrow-down-square"></i><span>Arsip Pelayanan</span></a></li>
            @endcan
        @endcan










        @can('menu-layanan')
            <li class="nav-heading">Kelola Master Layanan</li>
            {{-- Kelola Jenis Layanan --}}
            @can('page-layanan-jenis')
                <li class="nav-item"> <a class="nav-link @if (request()->segment(1) == 'jenis-layanan') @else collapsed @endif" href="{{ route('jenis-layanan.index') }}"> <i class="bi bi-window-dock"></i> <span>Jenis Layanan</span></a></li>
            @endcan

            {{-- Kelola Output Layanan --}}
            @can('page-layanan-output')
                <li class="nav-item"> <a class="nav-link @if (request()->segment(1) == 'output-layanan') @else collapsed @endif" href="{{ route('output-layanan.index') }}"> <i class="bi bi-wallet"></i> <span>Output Layanan</span></a></li>
            @endcan

            {{-- Kelola Daftar Layanan --}}
            @can('page-layanan-daftar')
                <li class="nav-item"> <a class="nav-link @if (request()->segment(1) == 'daftar-layanan') @else collapsed @endif" href="{{ route('daftar-layanan.index') }}"> <i class="bi bi-vr"></i> <span>Daftar Layanan</span> </a></li>
            @endcan

            @can('page-layanan-syarat-master')
                {{-- Kelola Syarat Layanan --}}
                <li class="nav-item">
                    <a class="nav-link @if (request()->segment(1) == 'syarat-layanan') @else collapsed @endif" data-bs-target="#syarat-nav" data-bs-toggle="collapse" href="#" aria-expanded="@if (request()->segment(1) == 'syarat-layanan') true @else false @endif">
                        <i class="bi bi-view-stacked"></i><span>Kelola Syarat</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="syarat-nav" class="nav-content collapse @if (request()->segment(1) == 'syarat-layanan') show @endif" data-bs-parent="#sidebar-nav" style="">
                        <li>
                            <a href="{{ route('syarat-layanan-master.index') }}" class="@if (request()->segment(2) == 'master') active @endif">
                                <i class="bi bi-circle"></i><span>Master Syarat</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('syarat-layanan-list.index') }}" class="@if (request()->segment(2) == 'list') active @endif">
                                <i class="bi bi-circle"></i><span>Daftar Syarat</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
        @endcan

        @can('menu-report')
            <li class="nav-heading">Kelola Laporan</li>
            {{-- Kelola Jenis Layanan --}}
            @can('page-report-layanan')
                <li class="nav-item"> <a class="nav-link @if (request()->segment(1) == 'laporan-layanan') @else collapsed @endif" href="{{ route('laporan-layanan.index', 'layanan') }}"> <i class="bi bi-book"></i> <span>Laporan Layanan</span></a></li>
            @endcan
        @endcan







    </ul>
</aside>
