@extends('backend.layouts.admin.master')
@section('title', 'Laporan Pelayanan Publik- SIPINTU Kemenag Online')


@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">

    <link href="{{ asset('niceadmin/vendor/boxicons/css/boxicons.min.css') }} " rel="stylesheet">
    <link href="{{ asset('niceadmin/vendor/quill/quill.snow.css') }} " rel="stylesheet">
    <link href="{{ asset('niceadmin/vendor/quill/quill.bubble.css') }} " rel="stylesheet">
    <link href="{{ asset('niceadmin/vendor/remixicon/remixicon.css') }} " rel="stylesheet">


    <link href="{{ asset('niceadmin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">


    <style>
        .responsive-iframe {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 100%;
        }

        .bukti-daftar {
            min-height: 700px !important;
        }

        .modal-print {
            min-height: 700px !important;
        }
    </style>
@endsection

@section('content')

    <style>
        .responsive-iframe {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 100%;
        }

        .bukti-daftar {
            min-height: 700px !important;
        }

        .modal-print {
            min-height: 700px !important;
        }
    </style>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>{{ $title }} - {{ $br1 }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">{{ $title }}</a></li>
                    <li class="breadcrumb-item">{{ $br1 }}</li>
                    <li class="breadcrumb-item active">{{ $br2 }}</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section profile">
            <div class="row">
                <div class="col-xl-12">


                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title m-0 p-0">{{ $title }} {{ $br1 }}</h5>
                        </div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif


                            <table class='table table-bordered display' id="example" style="width:100%; font-size:11pt!important;">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="5%">No</th>
                                        <th class="text-center" width="30%">Judul Laporan Pelayanan Publik</th>
                                        <th class="text-center">Waktu</th>
                                        <th class="text-center" width="20%">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php $i=1 @endphp
                                    @foreach ($range as $key => $item)
                                        <tr>
                                            <td class="text-center">{{ $i++ }}</td>
                                            <td class="">
                                                REKAPITULASI PELAYANAN SIPINTU ONLINE
                                                PERIODE {{ strtoupper($item['title']) }}
                                            </td>
                                            <td class="text-center">
                                                {{ strtoupper($item['title']) }}
                                            </td>
                                            <td class="text-center">
                                                <div class="badge bg-secondary me-1 text-start">
                                                    <a id="string_url" href="javascript:void(0)" style="font-size:smaller;" class="text-white cetak-bukti-button" data-bs-toggle="modal" data-bs-target="#ExtralargeModal" data-cetak_bukti_link="/laporan-layanan/create/{{ $item['year_month'] }}" data-file_name="Laporan Bulanan SIPINTU ONLINE Periode {{ $item['title'] }}">
                                                        DOWNLOAD
                                                    </a>

                                                </div>
                                                <div class="badge bg-primary me-1 text-start">
                                                    <a id="string_url" href="javascript:void(0)" style="font-size:smaller;" class="text-white cetak-bukti-button-sm" data-bs-toggle="modal" data-bs-target="#ExtralargeModal" data-cetak_bukti_link="/laporan-layanan/create-sm/{{ $item['year_month'] }}" data-file_name="Laporan SURAT MASUK SIPINTU ONLINE Periode {{ $item['title'] }}">
                                                        SURAT MASUK
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>



                </div>
            </div>
        </section>

        @include('admin.report.layanan._modal')

    </main>


@endsection


@section('_scripts')

    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script type="text/javascript" language="javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" language="javascript" src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>
    <script type="text/javascript" language="javascript" src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script type="text/javascript" language="javascript" src="{{ asset('js/buttons.bootstrap5.min.js') }}"></script>
    <script type="text/javascript" language="javascript" src="{{ asset('js/jszip.min.js') }}"></script>
    <script type="text/javascript" language="javascript" src="{{ asset('js/pdfmake.min.js') }}"></script>
    <script type="text/javascript" language="javascript" src="{{ asset('js/vfs_fonts.js') }}"></script>
    <script type="text/javascript" language="javascript" src="{{ asset('js/buttons.html5.min.js') }}"></script>
    <script type="text/javascript" language="javascript" src="{{ asset('js/buttons.print.min.js') }}"></script>
    <script type="text/javascript" language="javascript" src="{{ asset('js/buttons.colVis.min.js') }}"></script>
    <script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript"></script>

    <script>
        $(document).ready(function() {



            $(document).on("click", ".cetak-bukti-button", function() {
                console.log('jancok');
                var cetakBuktiLink = $(this).data('cetak_bukti_link');
                var fileName = $(this).data('file_name');
                $('#cetak-bukti-link').attr('src', cetakBuktiLink);
                $('.cetak-title').html(fileName);
            });

            $(document).on("click", ".cetak-bukti-button-sm", function() {
                console.log('jancok');
                var cetakBuktiLink = $(this).data('cetak_bukti_link');
                var fileName = $(this).data('file_name');
                $('#cetak-bukti-link').attr('src', cetakBuktiLink);
                $('.cetak-title').html(fileName);
            });

        });

        $(document).on("click", ".cetak-bukti-button", function() {
            console.log('jancok');
            var cetakBuktiLink = $(this).data('cetak_bukti_link');
            var fileName = $(this).data('file_name');
            $('#cetak-bukti-link').attr('src', cetakBuktiLink);
            $('.cetak-title').html(fileName);
        });

        $(document).on("click", ".cetak-bukti-button-sm", function() {
            console.log('jancok');
            var cetakBuktiLink = $(this).data('cetak_bukti_link');
            var fileName = $(this).data('file_name');
            $('#cetak-bukti-link').attr('src', cetakBuktiLink);
            $('.cetak-title').html(fileName);
        });
    </script>
@endsection
