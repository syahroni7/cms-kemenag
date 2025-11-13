<!-- ======= Header ======= -->
<header id="header" class="header position-relative">

    <div class="container-fluid container-xl position-relative">

        <div class="top-row d-flex align-items-center justify-content-between">
            <a href="/" class="logo d-flex align-items-end">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <img src="blogy-assets/img/logo-cms-kemenag.png" alt="Logo Kemenag Lebak">
                <!-- <h1 class="sitename">Blogy</h1><span>.</span> -->
            </a>

            <div class="d-flex align-items-center">
                <div class="social-links">
                    <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                </div>

                <form class="search-form ms-4">
                    <input type="text" placeholder="Search..." class="form-control">
                    <button type="submit" class="btn"><i class="bi bi-search"></i></button>
                </form>
            </div>
        </div>

    </div>

    <div class="nav-wrap">
        <div class="container d-flex justify-content-center position-relative">
            <nav id="navmenu" class="navmenu">
                <ul>
                    @foreach ($menus as $menu)
                    @if ($menu->children->count() > 0)
                    {{-- Dropdown Menu --}}
                    <li class="dropdown">
                        <a href="#">
                            @if ($menu->icon)
                            <i class="{{ $menu->icon }}"></i>
                            @endif
                            <span>{{ $menu->name }}</span>
                            <i class="bi bi-chevron-down toggle-dropdown"></i>
                        </a>
                        <ul class="menu-list">
                            @foreach ($menu->children as $child)
                            <li>
                                <a href="{{ $child->url ?? '#' }}">
                                    @if ($child->icon)
                                    <i class="{{ $child->icon }}"></i>
                                    @endif
                                    <span>{{ $child->name }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @else
                    {{-- Menu tanpa submenu --}}
                    <li>
                        <a href="{{ $menu->url ?? '#' }}">
                            @if ($menu->icon)
                            <i class="{{ $menu->icon }}"></i>
                            @endif
                            <span>{{ $menu->name }}</span>
                        </a>
                    </li>
                    @endif
                    @endforeach
                </ul>

                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

        </div>
    </div>

</header><!-- End Header -->