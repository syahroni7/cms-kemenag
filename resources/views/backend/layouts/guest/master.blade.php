<!DOCTYPE HTML>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>
    <meta name="robots" content="noindex, nofollow">
    <meta content="" name="description">
    <meta content="" name="keywords">


    @include('backend.layouts.guest.styles')

    @yield('_styles')

</head>

<body class="d-flex flex-column min-vh-100">
    <div class="preloader">
        <div class="loader">
            <img src="{{ asset('assets/images/logo/loader.png') }}" width="85px" alt="">
        </div>
    </div>


    @yield('content')

    @include('backend.layouts.guest.footer')

    @include('backend.layouts.guest.scripts')

    <script>
        $(document).ready(function() {
            $('.preloader').addClass('out');
        });
    </script>

    @yield('_scripts')

    <script>
        $.fn.dataTable.ext.errMode = 'none';


        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success px-3 mx-3',
                cancelButton: 'btn btn-danger px-3 mx-3'
            },
            buttonsStyling: false
        });


        $(document).ajaxError(function(event, jqxhr, settings, exception) {

            if (exception == 'Unauthorized') {

                // Prompt user if they'd like to be redirected to the login page
                // bootbox.confirm("Your session has expired. Would you like to be redirected to the login page?", function(result) {
                //     if (result) {
                //         window.location = '/login';
                //     }
                // });

                Swal.fire({
                    title: 'Sesi anda sudah kadaluwarsa, sistem akan mengarahkan anda ke halaman login?',
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: 'Oke',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        window.location = '/login';
                    }
                })

            }
        });
    </script>

</body>

</html>