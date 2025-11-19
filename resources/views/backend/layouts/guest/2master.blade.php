<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    
    @include('layouts.admin.css')
    @yield('css')
</head>

<body class="homepage-v4">


    <!-- Navigation -->
    @include('layouts.admin.header')

    <!-- Navigation -->

    <!-- Main layout -->
    <main class="pt-4">

        @yield('content')

    </main>
    <!-- Main layout -->

    <!-- Footer -->
    @include('layouts.admin.footer')
    <!-- Footer -->

    <!-- SCRIPTS -->

    @include('layouts.admin.js')
    @yield('js')


</body>

</html>
