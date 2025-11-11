<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Google tag (gtag.js) -->


    <title>@yield('title')</title>
    <!-- Meta Dasar -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SIPINTU | PTSP Kemenag Lebak</title>
    <meta name="description" content="SIPINTU adalah Sistem Pelayanan Terpadu Satu Pintu Kementerian Agama Kabupaten Lebak. Ajukan layanan secara mudah, transparan, dan akuntabel.">
    <meta name="keywords" content="SIPINTU, PTSP Kemenag, Kementerian Agama Lebak, pelayanan publik, layanan online, Kemenag Lebak, sistem terpadu, pelayanan agama, Lebak">
    <meta name="author" content="Kementerian Agama Kabupaten Lebak">

    <!-- Meta Sosial (Open Graph untuk Facebook, WhatsApp, LinkedIn) -->
    <meta property="og:title" content="SIPINTU | PTSP Kemenag Lebak">
    <meta property="og:description" content="Ajukan layanan secara mudah, transparan, dan akuntabel melalui Sistem Pelayanan Terpadu Satu Pintu Kemenag Lebak.">
    <meta property="og:image" content="https://example.com/assets/img/og-image.jpg"> <!-- Ganti URL dengan gambar share -->
    <meta property="og:url" content="https://ptspkemenaglebak.my.id"> <!-- Ganti dengan URL asli -->
    <meta property="og:type" content="website">

    <!-- Meta Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="SIPINTU | PTSP Kemenag Lebak">
    <meta name="twitter:description" content="Layanan publik digital Kemenag Lebak berbasis transparansi dan kemudahan akses.">
    <meta name="twitter:image" content="https://example.com/assets/img/og-image.jpg"> <!-- Ganti dengan gambar valid -->

    <!-- Robots -->
    <meta name="robots" content="index, follow">

    <!-- Favicons -->
    <link href="{{ asset('bizland-assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('bizland-assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">


    @include('frontend.layouts.styles')

    @yield('_styles')

</head>

<body class="index-page">

    @include('frontend.layouts.header')

    <main id="main">

        @yield('content')

    </main><!-- End #main -->

    @include('frontend.layouts.footer')
    @include('frontend.layouts.scripts')


    @yield('_scripts')

</body>

</html>