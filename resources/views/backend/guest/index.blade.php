@extends('backend.layouts.guest.master')
@section('title', 'Beranda PTSP Kemenag Lebak')


@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">

<link href="{{ asset('niceadmin/vendor/boxicons/css/boxicons.min.css') }} " rel="stylesheet">
<link href="{{ asset('niceadmin/vendor/quill/quill.snow.css') }} " rel="stylesheet">
<link href="{{ asset('niceadmin/vendor/quill/quill.bubble.css') }} " rel="stylesheet">
<link href="{{ asset('niceadmin/vendor/remixicon/remixicon.css') }} " rel="stylesheet">


<link href="{{ asset('niceadmin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">


<style>


</style>
@endsection





@section('content')

<main id="main" class="main m-0">
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

        <div class="alert alert-warning alert-dismissible fade" role="alert" style="display: none">
            <h5 style="font-weight: bolder;">Pengumuman update PTSP versi terbaru!</h5>
            <h6 style="font-weight: bolder;"># 14 - 18 November 2022</h6>
            <ol>
                <li>Fitur untuk penyelesaian Pelayanan hanya dapat dilakukan setelah melakukan upload dokumen hasil
                    pelayanan</li>
                <li>Fitur Kelola Pengguna. Digunakan untuk Monitoring, Control dan Evaluasi sehingga lebih diperketat
                    melalui sistem kontrol pengguna oleh Pimpinan</li>
                <li>Perbaikan dan Penambahan pada fitur upload multiple File</li>
            </ol>

            <h6 style="font-weight: bolder;"># 07 - 11 November 2022</h6>
            <ol>
                <li>Penambahan Fitur Force Reset Password</li>
                <li>Penambahan Fitur Force Set Nomor HP</li>
                <li>Penambahan Fitur Integrasi pada Whatsapp</li>
                <li>Penambahan Modul Profil dengan fitur update data profil dan foto</li>
            </ol>

            <h6 style="font-weight: bolder;"># 01 - 04 November 2022</h6>
            <ol>
                <li>Fitur Upload Multiple File dengan batasan format PDF</li>
                <li>Perbaikan Fitur Arsip untuk menampilkan File Arsip dari Fitur Multiple File Upload</li>
                <li>Penambahan Pie Chart dan Ringkasan Pelayanan per unit pada Dashboard</li>
            </ol>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>



        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">

                {{-- Berdasarkan Status --}}
                <div class="row box-layanan">
                    <div class="col-12">
                        <h5 class="card-title">
                            <span>Berdasarkan Status</span>
                        </h5>
                    </div>
                    @foreach ($summaryPelayanan as $key => $status)
                    <!-- Item Card -->
                    <div class="col-xxl-3 col-xs-3 col-xxs-3 col-md-12">
                        <div class="card info-card sales-card m-0">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">{{ $status['name'] }} <span>| Total</span></h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-envelope-open"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><span id="countJemaah">{{ $status['total'] }}</span></h6>
                                        <span class="text-{{ $status['color'] }} small pt-1 fw-bold">Total {{
                                            $status['name'] }}</span>
                                        {{-- <span class="text-muted small pt-2 ps-1">Jemaah</span> --}}

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Jemaah Card -->
                    @endforeach




                </div>
                {{-- End of Berdasarkan Status --}}

                {{-- Berdasarkan Unit Pengolah --}}
                @if ($type != 'MINIMAL')

                <div class="row">
                    <div class="col-12">
                        <h5 class="card-title">
                            <span>Berdasarkan Unit Pengolah</span>
                        </h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <!-- Website Traffic -->
                        <div class="card m-0">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body pb-0">
                                <h5 class="card-title">Tabel Pelayanan <span></span></h5>
                                <div class="table-responsive">

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Unit Pengolah</th>
                                                <th scope="col" class="text-center">Baru</th>
                                                <th scope="col" class="text-center">Proses</th>
                                                <th scope="col" class="text-center">Selesai</th>
                                                <th scope="col" class="text-center">Total</th>
                                            </tr>
                                        </thead>


                                        <tbody>
                                            @foreach ($totalByUnit as $key => $item)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td class="">{{ $item['name'] }}</td>
                                                <td class="text-center">{{ $item['Baru'] }}</td>
                                                <td class="text-center">{{ $item['Proses'] }}</td>
                                                <td class="text-center">{{ $item['Selesai'] }}</td>
                                                <td class="text-center"
                                                    style="font-weight: bolder; @if ($item['value'] == 0) color:red; @else color:black; @endif">
                                                    {{ $item['value'] }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div><!-- End Website Traffic -->
                    </div>

                    <div class="col-md-12 mt-2">
                        <!-- Website Traffic -->
                        <div class="card m-0">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body pb-0">
                                <h5 class="card-title">Chart Pelayanan <span></span></h5>

                                <div id="trafficChart" style="min-height: 350px;" class="echart"></div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                                echarts.init(document.querySelector("#trafficChart")).setOption({
                                                    tooltip: {
                                                        trigger: 'item'
                                                    },
                                                    legend: {
                                                        top: '5%',
                                                        left: 'center',
                                                        position: 'center'
                                                    },
                                                    series: [{
                                                        name: 'Total Pelayanan',
                                                        type: 'pie',
                                                        radius: ['40%', '70%'],
                                                        avoidLabelOverlap: true,
                                                        label: {
                                                            show: false,
                                                            position: 'center'
                                                        },
                                                        emphasis: {
                                                            label: {
                                                                show: true,
                                                                fontSize: '18',
                                                                fontWeight: 'bold'
                                                            }
                                                        },
                                                        labelLine: {
                                                            show: false
                                                        },
                                                        data: @json($totalByUnit)
                                                    }]
                                                });
                                            });
                                </script>

                            </div>
                        </div><!-- End Website Traffic -->
                    </div>


                </div>
                @endif

                {{-- End of Berdasarkan Unit Pengolah --}}


                {{-- Berdasarkan Timeline --}}
                @if ($type != 'MINIMAL')
                <div class="row">
                    <div class="col-12">
                        <h5 class="card-title">
                            <span>Berdasarkan Timeline</span>
                        </h5>
                    </div>
                </div>

                <div class="row">


                    <div class="col-lg-12">
                        <!-- Reports -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card m-0">

                                    <div class="filter">
                                        <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                                class="bi bi-three-dots"></i></a>
                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                            <li class="dropdown-header text-start">
                                                <h6>Filter</h6>
                                            </li>

                                            <li><a class="dropdown-item" href="#">Today</a></li>
                                            <li><a class="dropdown-item" href="#">This Month</a></li>
                                            <li><a class="dropdown-item" href="#">This Year</a></li>
                                        </ul>
                                    </div>

                                    <div class="card-body">
                                        <h5 class="card-title">Laporan <span>/ Mingguan</span> <span
                                                class="badge bg-primary text-white update-mingguan"
                                                style="font-size: 7pt !important; cursor:pointer;">update</span></h5>

                                        <!-- Line Chart -->
                                        <div id="reportsChart"></div>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", () => {
                                                        var chartMingguan = new ApexCharts(document.querySelector("#reportsChart"), {
                                                            series: @json($dataWeekly['series']),
                                                            chart: {
                                                                height: 350,
                                                                type: 'area',
                                                                zoom: {
                                                                    type: 'x',
                                                                    enabled: true,
                                                                    autoScaleYaxis: true
                                                                },
                                                                toolbar: {
                                                                    autoSelected: 'zoom'
                                                                }
                                                            },
                                                            markers: {
                                                                size: 4
                                                            },
                                                            colors: ['#4154f1', '#2eca6a', '#ff771d'],
                                                            fill: {
                                                                type: "gradient",
                                                                gradient: {
                                                                    shadeIntensity: 1,
                                                                    opacityFrom: 0.3,
                                                                    opacityTo: 0.4,
                                                                    stops: [0, 90, 100]
                                                                }
                                                            },
                                                            dataLabels: {
                                                                enabled: false
                                                            },
                                                            stroke: {
                                                                curve: 'smooth',
                                                                width: 2
                                                            },
                                                            xaxis: {
                                                                type: 'datetime',
                                                                categories: @json($dataWeekly['categories'])
                                                            },
                                                            tooltip: {
                                                                x: {
                                                                    // format: 'dd/MM/yy HH:mm'
                                                                    // format: 'dd-MM-YYYY HH:mm'
                                                                    format: "dd MMM yyyy"
                                                                },
                                                            }
                                                        });

                                                        chartMingguan.render();

                                                        $(document).on('click', '.update-mingguan', function(e) {

                                                            console.log('update mingguan triggered');
                                                            $.getJSON('/summary-run/weekly', function(response) {
                                                                // chartMingguan.updateSeries(response.series)
                                                                chartMingguan.updateOptions({
                                                                    series: response.series,
                                                                    xaxis: {
                                                                        categories: response.categories
                                                                    },
                                                                });
                                                                chartMingguan.updateSeries(response.series)
                                                            });
                                                        });
                                                    });
                                        </script>
                                        <!-- End Line Chart -->

                                    </div>

                                </div>
                            </div><!-- End Reports -->
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <!-- Reports -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card m-0">

                                    <div class="filter">
                                        <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                                class="bi bi-three-dots"></i></a>
                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                            <li class="dropdown-header text-start">
                                                <h6>Filter</h6>
                                            </li>

                                            <li><a class="dropdown-item" href="#">Today</a></li>
                                            <li><a class="dropdown-item" href="#">This Month</a></li>
                                            <li><a class="dropdown-item" href="#">This Year</a></li>
                                        </ul>
                                    </div>

                                    <div class="card-body">
                                        <h5 class="card-title">Laporan <span>/ Harian</span><span
                                                class="badge bg-primary text-white update-harian"
                                                style="font-size: 7pt !important; cursor:pointer;">update</span></h5>

                                        <!-- Line Chart -->
                                        <div id="dailyChart"></div>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", () => {
                                                        var chartHarian = new ApexCharts(document.querySelector("#dailyChart"), {
                                                            series: @json($dataDaily['series']),
                                                            chart: {
                                                                type: 'area',
                                                                stacked: false,
                                                                height: 350,
                                                                zoom: {
                                                                    type: 'x',
                                                                    enabled: true,
                                                                    autoScaleYaxis: true
                                                                },
                                                                toolbar: {
                                                                    autoSelected: 'zoom'
                                                                }
                                                            },
                                                            dataLabels: {
                                                                enabled: false
                                                            },
                                                            markers: {
                                                                size: 0,
                                                            },
                                                            // title: {
                                                            //     text: 'Total Pelayanan per Hari',
                                                            //     align: 'left'
                                                            // },
                                                            fill: {
                                                                type: 'gradient',
                                                                gradient: {
                                                                    shadeIntensity: 1,
                                                                    inverseColors: false,
                                                                    opacityFrom: 0.5,
                                                                    opacityTo: 0,
                                                                    stops: [0, 90, 100]
                                                                },
                                                            },
                                                            dataLabels: {
                                                                enabled: false
                                                            },
                                                            stroke: {
                                                                curve: 'smooth',
                                                                width: 2
                                                            },
                                                            xaxis: {
                                                                type: 'datetime',
                                                                categories: @json($dataDaily['categories'])
                                                            },
                                                            tooltip: {
                                                                x: {
                                                                    format: "dd MMM yyyy"
                                                                },
                                                            }
                                                        });

                                                        chartHarian.render();

                                                        $(document).on('click', '.update-harian', function(e) {

                                                            console.log('update harian triggered');
                                                            $.getJSON('/summary-run/daily', function(response) {
                                                                chartHarian.updateOptions({
                                                                    series: response.series,
                                                                    xaxis: {
                                                                        categories: response.categories
                                                                    },
                                                                });
                                                                chartHarian.updateSeries(response.series)
                                                            });
                                                        });
                                                    });
                                        </script>
                                        <!-- End Line Chart -->

                                    </div>

                                </div>
                            </div><!-- End Reports -->
                        </div>
                    </div>


                </div>
                @endif
                {{-- End Berdasarkan Timeline --}}


                {{-- Baris Rekapitulasi --}}
                @if ($type != 'MINIMAL')

                <div class="row">
                    <div class="col-12">
                        <h5 class="card-title">
                            <span>Rekapitulasi Layanan per Unit</span>
                        </h5>
                    </div>
                </div>

                <div class="row justify-content-start">
                    <div class="col-md-12">
                        <div class="card m-0">
                            <div class="card-body pb-0">
                                <h5 class="card-title">Tabel Rekapitulasi <span></span></h5>
                                <div class="table-responsive">


                                    <table class="table table-bordered" id="myTable">

                                        @foreach ($fixData as $key => $item)
                                        @if ($key == 'header')
                                        <thead>
                                            <tr>
                                                @foreach ($item as $k => $sub)
                                                @if ($k == 0)
                                                <th scope="col">{{ $sub }}</th>
                                                @else
                                                <th scope="col" class="text-center">{{ $sub }}</th>
                                                @endif
                                                @endforeach
                                            </tr>
                                        </thead>
                                        @endif

                                        @if ($key != 'header')
                                        <tbody>
                                            <tr>
                                                @foreach ($item as $k => $sub)
                                                @if ($k == 0)
                                                @if ($sub == 'Total')
                                                <td class="text-right text-end fw-bold" scope="col">Total Perbulan</td>
                                                @else
                                                <td scope="col">{{ $sub }}</td>
                                                @endif
                                                @else
                                                @if ($key == 'Total')
                                                <td scope="col" class="text-end fw-bold">{{ $sub }}</td>
                                                @else
                                                <td scope="col" class="text-end">{{ $sub }}</td>
                                                @endif
                                                @endif
                                                @endforeach
                                            </tr>
                                        </tbody>
                                        @endif
                                        @endforeach

                                        {{-- <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Unit Pengolah</th>
                                                <th scope="col">Daftar Pelayanan</th>
                                                <th scope="col" class="text-center">Jumlah Layanan</th>
                                            </tr>
                                        </thead>


                                        <tbody>
                                            @php
                                            $counter = 1;
                                            $sum = 0;
                                            @endphp
                                            @foreach ($daftarpelayanangrouped as $unit => $pelayanan)
                                            @php $sumeach = 0; @endphp
                                            @foreach ($pelayanan as $k => $item)
                                            <tr
                                                style="@if ($item->total == 0) background-color:red!important; border-color:red!important; @endif">
                                                <td class="text-center">{{ $counter }}</td>
                                                <td>{{ $unit }}</td>
                                                <td>{{ $item->layanan }}</td>
                                                <td class="text-center">{{ $item->total }}</td>
                                            </tr>
                                            @php
                                            $counter++;
                                            $sum += $item->total;
                                            $sumeach += $item->total;
                                            @endphp
                                            @endforeach
                                            <tr
                                                style="@if ($item->total == 0) background-color:green!important; border-color:green!important; @endif">
                                                <td class="text-end text-right fw-bold" colspan="3">Total Layanan {{
                                                    $unit }}</td>
                                                <td class="text-center fw-bold">{{ $sumeach }}</td>
                                            </tr>
                                            @php $sumeach = 0; @endphp
                                            @endforeach
                                            <tr>
                                                <td class="text-end text-right fw-bolder" colspan="3">Total Semua</td>
                                                <td class="text-center fw-bolder">{{ $sum }}</td>
                                            </tr>
                                        </tbody> --}}
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-start">
                    <div class="col-md-4">
                        <div class="card m-0">
                            <div class="card-body pb-0">
                                <div id="result">
                                    <!-- Result will appear be here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                {{-- End of Baris Rekapitulasi --}}








                {{-- Baris Ringkasan Pelayanan --}}

                @if ($type != 'MINIMAL')
                <div class="row">
                    <div class="col-12">
                        <h5 class="card-title">
                            <span>Rekapitulasi Pelayanan Publik</span>
                        </h5>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card m-0">
                            <div class="card-body pb-0">
                                <h5 class="card-title">Ringkasan Pelayanan <span></span></h5>
                                <div class="table-responsive">

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Unit Pengolah</th>
                                                <th scope="col">Daftar Pelayanan</th>
                                                <th scope="col" class="text-center">Jumlah Layanan</th>
                                            </tr>
                                        </thead>


                                        <tbody>
                                            @php
                                            $counter = 1;
                                            $sum = 0;
                                            @endphp
                                            @foreach ($daftarpelayanangrouped as $unit => $pelayanan)
                                            @php $sumeach = 0; @endphp
                                            @foreach ($pelayanan as $k => $item)
                                            <tr
                                                style="@if ($item->total == 0) background-color:red!important; border-color:red!important; @endif">
                                                <td class="text-center">{{ $counter }}</td>
                                                <td>{{ $unit }}</td>
                                                <td>{{ $item->layanan }}</td>
                                                <td class="text-center">{{ $item->total }}</td>
                                            </tr>
                                            @php
                                            $counter++;
                                            $sum += $item->total;
                                            $sumeach += $item->total;
                                            @endphp
                                            @endforeach
                                            <tr style="background-color:green!important; border-color:green!important;">
                                                <td class="text-end text-right fw-bold" colspan="3">Total Layanan {{
                                                    $unit }}</td>
                                                <td class="text-center fw-bold">{{ $sumeach }}</td>
                                            </tr>
                                            @php $sumeach = 0; @endphp
                                            @endforeach
                                            <tr>
                                                <td class="text-end text-right fw-bolder" colspan="3">Total Semua</td>
                                                <td class="text-center fw-bolder">{{ $sum }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                @endif
                {{-- End of Baris Tabel Pelayanan --}}












            </div><!-- End Left side columns -->


        </div>





    </section>
</main>

@endsection


@section('_scripts')

<script type="text/javascript"
    src="https://github.com/niklasvh/html2canvas/releases/download/0.5.0-alpha1/html2canvas.js"></script>

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
{{-- <script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script> --}}

{{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}



@endsection