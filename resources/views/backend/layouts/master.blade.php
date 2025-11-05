<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>@yield('title') | CMS Berita Instansi</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>
    @include('backend.layouts.sidebar')

    <div class="container mt-4">
        @yield('content')
    </div>
</body>
</html>
