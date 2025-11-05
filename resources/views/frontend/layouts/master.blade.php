<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $meta_description ?? 'Portal resmi berita dan informasi Instansi Pemerintah.' }}">
    <meta name="keywords" content="{{ $meta_keywords ?? 'berita pemerintah, informasi publik, instansi, portal resmi' }}">
    <meta name="author" content="Instansi Pemerintah">

    <title>{{ $title ?? 'Portal Berita Instansi Pemerintah' }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
        }
        header {
            background: #005b96;
            color: white;
        }
        footer {
            background: #003d73;
            color: white;
            padding: 20px 0;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.25rem;
        }
        .news-card {
            transition: transform 0.3s ease;
        }
        .news-card:hover {
            transform: translateY(-5px);
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- ===== Header / Navbar ===== -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark container py-3">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fa-solid fa-landmark me-2"></i> Instansi Pemerintah
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a href="{{ url('/') }}" class="nav-link">Beranda</a></li>
                    <li class="nav-item"><a href="{{ url('/berita') }}" class="nav-link">Berita</a></li>
                    <li class="nav-item"><a href="{{ url('/profil') }}" class="nav-link">Profil</a></li>
                    <li class="nav-item"><a href="{{ url('/kontak') }}" class="nav-link">Kontak</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- ===== Main Content ===== -->
    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- ===== Footer ===== -->
    <footer class="text-center mt-5">
        <div class="container">
            <p class="mb-1">© {{ date('Y') }} Instansi Pemerintah. Semua Hak Dilindungi.</p>
            <small>
                <a href="{{ url('/') }}" class="text-white text-decoration-none me-3">Beranda</a>
                <a href="{{ url('/tentang') }}" class="text-white text-decoration-none me-3">Tentang</a>
                <a href="{{ url('/kebijakan-privasi') }}" class="text-white text-decoration-none">Privasi</a>
            </small>
        </div>
    </footer>

    <!-- ===== Scripts ===== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
