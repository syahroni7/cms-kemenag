@extends('backend.layouts.admin.master')
@section('title', 'CMS Kemenag Lebak')


@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">

    @endsection


@section('content')

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>{{ $title }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">{{ $br1 }}</a></li>
                    <li class="breadcrumb-item active">{{ $br2 }}</li>
                </ol>
            </nav>
        </div>
        <section class="section dashboard">

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card m-0">

                        <div class="card-body mb-0 pb-0">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <h5 class="card-title">
                                {{ $greeting }} <strong>{{ Auth::user()->name }}</strong>, {{ __('Anda telah Login!') }}.
                                Ubah Profil Anda <a href="{{ route('profile.index') }}">Disini</a>
                            </h5>




                        </div>
                    </div>
                </div>
            </div>

        </section>
    </main>

@endsection


@section('_scripts')

    <script type="text/javascript" src="https://github.com/niklasvh/html2canvas/releases/download/0.5.0-alpha1/html2canvas.js"></script>

    <script>
        //convert table to image            
        function convertToImage() {
            var resultDiv = document.getElementById("result");
            html2canvas(document.getElementById("myTable"), {
                scale: 4,
                dpi: 600,
                onrendered: function(canvas) {
                    var img = canvas.toDataURL("image/png");
                    result.innerHTML = '<a download="Rekapitulasi Hasil.png" href="' + img + '">test</a>';
                }
            });
        }
        //click event
        var convertBtn = document.getElementById("convert");
        convertBtn.addEventListener('click', convertToImage);
    </script>
    {{-- <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script> --}}

    {{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}



@endsection
