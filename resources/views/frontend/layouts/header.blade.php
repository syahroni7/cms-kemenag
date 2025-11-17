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
                    @include('components.navbar', ['menu' => $menu])
                    @endforeach
                </ul>

                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

        </div>
    </div>

</header><!-- End Header -->