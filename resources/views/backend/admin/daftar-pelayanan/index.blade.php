@extends('backend.layouts.admin.master')
@section('title', $title)


@section('_styles')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/buttons.bootstrap5.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-5-theme.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-5-theme.rtl.min.css') }}" />

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

        .modal-body {
            min-height: 700px !important;
        }
    </style>
@endsection


@section('content')

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>{!! $title !!} - {!! $html_status !!}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">{!! $br1 !!}</a></li>
                    <li class="breadcrumb-item">{!! $br2 !!}</li>
                    <li class="breadcrumb-item active">{!! $html_status !!}</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{!! $title !!} {!! $html_status !!}</h5>

                            <div class="alert alert-primary">
                                <div class="row" id="filter_wrapper">

                                </div>
                            </div>


                            <table class='table table-bordered display' id="example" style="width:100%; font-size:11pt!important;">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Dibuat</th>
                                        <th class="text-center">No Registrasi</th>
                                        <th class="text-center">Unit Pengolah</th>
                                        <th class="text-center">Nama Layanan</th>
                                        <th class="text-center">Perihal</th>
                                        <th class="text-center">Kelengkapan</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('admin.daftar-pelayanan._modal')

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



    <script>
        var id_unit_pengolah_filter = 0;
        var id_layanan_filter = 0;
        var status = '{{ $status }}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.select2').select2({
            theme: 'bootstrap-5',
            dropdownParent: $("#fModal"),
        });


        var table = $('#example').DataTable({
            processing: true,
            orderable: false,
            sort: false,
            order: false,
            lengthChange: false,
            responsive: false,
            scrollX: true,
            autoWidth: false,
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, -1],
                ['10 rows', '25 rows', '50 rows', 'Show all']
            ],
            iDisplayLength: 50,
            ajax: '/daftar-pelayanan/list/' + status + '?id_unit_pengolah_filter=' + id_unit_pengolah_filter + '&id_layanan_filter=' + id_layanan_filter,
            initComplete: function(settings, json) {
                console.log(json)

                table.buttons().container()
                    .appendTo('#example_wrapper .col-md-6:eq(0)');

                // $(json.html_filter).appendTo('#example_wrapper .col-md-6:eq(0) .dt-buttons');
                $(json.html_filter).appendTo('#filter_wrapper');

                $('.select2-filter').select2({
                    theme: 'bootstrap-5',
                });

                // $(document).on('change', '#id_unit_pengolah_filter', function(e) {
                $(document).on('select2:select', '.id_unit_pengolah_filter', function(e) {
                    console.log('data filter')

                    id_unit_pengolah_filter = $(this).val();
                    id_layanan_filter = $('.id_layanan_filter').val();


                    console.log('id_unit_pengolah_filter')
                    console.log(id_unit_pengolah_filter)
                    table.ajax.url('/daftar-pelayanan/list/' + status + '?id_unit_pengolah_filter=' + id_unit_pengolah_filter + '&id_layanan_filter=' + id_layanan_filter).load(false);
                    fetchDaftarLayanan(id_unit_pengolah_filter);
                });

                $(document).on('select2:select', '.id_layanan_filter', function(e) {
                    console.log('data filter')

                    id_unit_pengolah_filter = $('.id_unit_pengolah_filter').val();
                    id_layanan_filter = $(this).val();

                    table.ajax.url('/daftar-pelayanan/list/' + status + '?id_unit_pengolah_filter=' + id_unit_pengolah_filter + '&id_layanan_filter=' + id_layanan_filter).load(false);
                });

                //     console.log('json')
                //     console.log(json)
                // $(json.html_filter).appendTo(".dt-buttons"); //example is our table id
                // $(".dataTables_filter label").addClass("pull-right");
                // $(document).on('change', '#usulan-status', function(e) {
                //     status = $(this).val();
                //     console.log('status');

                // });
            },
            buttons: [
                'pageLength',
                {
                    text: '<i class="fa fa-refresh"></i>  Reload',
                    attr: {
                        'title': 'Refresh Table',
                        'class': 'btn btn-warning'
                    },
                    action: function(e, dt, node, config) {
                        dt.ajax.reload(null, false);
                        $('#example').block({
                            message: `Loading...`
                        });
                        setTimeout(function() {
                            $('#example').unblock();
                        }, 1500);
                    }
                }
            ],
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                className: 'text-center'
            }, {
                data: 'created_at',
                name: 'created_at'
            }, {
                data: 'no_registrasi',
                name: 'no_registrasi'
            }, {
                data: 'unit.name',
                name: 'unit.name'
            }, {
                data: 'layanan.name',
                name: 'layanan.name'
            }, {
                data: 'pelayanan_perihal',
                name: 'pelayanan_perihal',
            }, {
                data: 'kelengkapan_syarat',
                name: 'kelengkapan_syarat'
            }, {
                data: 'status_pelayanan',
                name: 'status_pelayanan'
            }, {
                data: 'action',
                name: 'action',
                className: 'text-center'
            }, ]
        });

        $(document).on("click", ".menu-status", function() {

            // New Algorithm
            status = $(this).data('status_pelayanan');

            $('body').block({
                message: `Loading...`
            });

            setTimeout(function() {
                $('body').unblock();
                $('.html-status').html(ucwords(status));

                $('li a.menu-status').removeClass('active')

                $('.menu-' + status).addClass('active');
                table.ajax.url('/daftar-pelayanan/list/' + status + '?id_unit_pengolah_filter=' + id_unit_pengolah_filter).load();
            }, 500);


        });

        function ucwords(str) {
            return (str + '').replace(/^([a-z])|\s+([a-z])/g, function($1) {
                return $1.toUpperCase();
            });
        }


        function fetchDaftarLayanan(id_unit_pengolah) {

            $('.box-daftar-pelayanan').block({
                message: '',
            });

            setTimeout(function() {
                $.ajax({
                    url: '/daftar-pelayanan/collect/' + id_unit_pengolah,
                    method: 'get'
                }).done(function(res) {
                    console.log('res');
                    console.log(res);


                    var htmlData = '';

                    if (res.data.length > 0) {
                        htmlData += ``;
                        htmlData += `<option value="0">Semua Pelayanan</option>`;
                        $.each(res.data, function(key, item) {
                            // htmlData += `<li>${item.name}</li>`;
                            htmlData += `<option value="${item.id_layanan}">${item.name}</option>`;
                        });
                        htmlData += ``;
                    } else {
                        // htmlData += '.:: Belum ada Data Syarat ::.';
                        htmlData += `<option value="">Belum Ada Data Syarat</option>`;
                    }

                    $('#id_layanan_filter').html(htmlData);
                    $('.box-daftar-pelayanan').fadeIn("slow");
                    $('.box-daftar-pelayanan').unblock();
                });

            }, 300)
        }

        $(document).ready(function() {



            $(document).on("click", "#cetak-bukti-button", function() {
                var cetakBuktiLink = $(this).data('cetak_bukti_link');
                $('#cetak-bukti-link').attr('src', cetakBuktiLink);
            });

            // table.ajax.url('/daftar-pelayanan/list/{{ $status }}' + '?id_unit_pengolah_filter=' + id_unit_pengolah_filter).load();

            table.buttons().container()
                .appendTo('#example_wrapper .col-md-6:eq(0)');

            $('.toggle-sidebar-btn').on('click', function() {
                setTimeout(function() {
                    table.columns.adjust();
                }, 500);
            });

            $(window).on('resize', function() {
                table.columns.adjust();
            });


            $(document).on("click", "#addBtn", function() {
                $('.edit-state').hide();
                $('#id_jenis_layanan').val('');
                $('#fForm')[0].reset();
                var title = $(this).data('title');
                $("#judul-modal").html(title);
                $('#nama').prop('disabled', false);
            });

            $(document).on("click", "#editBtn", function(e) {
                e.preventDefault();
                $('.edit-state').show();
                var title = $(this).data('title');
                $("#judul-modal").html(title);
                var data = table.row($(this).parents('tr')).data();
                console.log(data);
                $('#fForm')[0].reset();
                $('#id_layanan').val('');

                $('.modalBox').block({
                    message: ``
                });

                setTimeout(function() {

                    $.ajax({
                        type: 'GET',
                        url: '/daftar-pelayanan/fetch/' + data.id_pelayanan,
                        dataType: 'json', // let's set the expected response format
                        success: function(data) {
                            console.log('data');
                            console.log(data);
                            if (data.success) {
                                var item = data.data;
                                $('#search_id_pelayanan').val(item.id_pelayanan).trigger(
                                    'change');
                                $('#search_id_layanan').val(item.id_layanan).trigger(
                                    'change');
                                $('#search_no_registrasi').val(item.no_registrasi);
                                console.log('item.no_registrasi');
                                console.log(item.no_registrasi);
                                $('#search_perihal').val(item.perihal);
                                $('#search_pemohon_no_surat').val(item
                                    .pemohon_no_surat);
                                $('#search_pemohon_tanggal_surat').val(item
                                    .pemohon_tanggal_surat);
                                $('#search_pemohon_nama').val(item.pemohon_nama);
                                $('#search_pemohon_alamat').val(item.pemohon_alamat);
                                $('#search_pemohon_no_hp').val(item.pemohon_no_hp);
                                $('#search_pengirim_nama').val(item.pengirim_nama);
                                $('#search_kelengkapan_syarat').val(item
                                        .kelengkapan_syarat)
                                    .trigger('change');
                                $('#search_status_pelayanan').val(item.status_pelayanan)
                                    .trigger(
                                        'change');
                                $('#search_catatan').val(item.catatan);

                            } else {
                                Swal.fire(
                                    'Error!', data.message, 'error'
                                );
                            }

                        },
                        error: function(err) {
                            if (err.status ==
                                422
                            ) { // when status code is 422, it's a validation issue
                                console.log(err.responseJSON);
                                // you can loop through the errors object and show it to the user
                                console.warn(err.responseJSON.errors);
                                // display errors on each form field
                                $('.ajax-invalid').remove();
                                $.each(err.responseJSON.errors, function(i, error) {
                                    var el = $(document).find('[name="' + i +
                                        '"]');
                                    el.after($('<span class="ajax-invalid" style="color: red;">' +
                                        error[0] + '</span>'));
                                });
                            } else if (err.status == 403) {
                                Swal.fire(
                                    'Unauthorized!',
                                    'You are unauthorized to do the action',
                                    'warning'
                                );

                            }
                        }
                    });



                    $('.modalBox').unblock();
                }, 1500);


            });


            $("#submitBtn").on("click", function(event) {
                event.preventDefault();

                $('.modalBox').block({
                    message: null
                });

                $('#submitBtn').prop("disabled", true);

                var formdata = $("#fForm")
                    .serialize(); // here $(this) refere to the form its submitting
                console.log(formdata);

                url = $('#fForm').attr('action');
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formdata, // here $(this) refers to the ajax object not form
                    dataType: 'json', // let's set the expected response format
                    success: function(data) {
                        setTimeout(function() {
                            $('#submitBtn').prop("disabled", false);
                            $('.modalBox').unblock();
                            console.log(data);
                            if (data.success) {
                                $('#fModal').modal('hide');
                                table.ajax.reload(null, false);
                                Swal.fire(
                                    'Great!', 'Data sukses di update!', 'success'
                                );
                                // if (!(typeof socket === "undefined")) {
                                socket.emit('sendSummaryToServer', data.summary);
                                // }
                            } else {
                                Swal.fire(
                                    'Error!', data.message, 'error'
                                );
                            }
                            $('#fForm')[0].reset();
                            $('#id_jenis_layanan').val('');
                        }, 200);

                    },
                    error: function(err) {
                        if (err.status ==
                            422) { // when status code is 422, it's a validation issue
                            console.log(err.responseJSON);
                            // you can loop through the errors object and show it to the user
                            console.warn(err.responseJSON.errors);
                            // display errors on each form field
                            $('.ajax-invalid').remove();
                            $.each(err.responseJSON.errors, function(i, error) {
                                var el = $(document).find('[name="' + i + '"]');
                                el.after($('<span class="ajax-invalid" style="color: red;">' +
                                    error[0] + '</span>'));
                            });
                        } else if (err.status == 403) {
                            Swal.fire(
                                'Unauthorized!', 'You are unauthorized to do the action',
                                'warning'
                            );

                        }
                    }
                });
            });


            $(document).on("click", "#destroyBtn", function() {
                event.preventDefault();
                var idPelayanan = $(this).data('id_pelayanan');

                swalWithBootstrapButtons.fire({
                    title: 'Apakah anda yakin akan melakukan penghapusan data?',
                    text: "Anda tidak dapat mengembalikan file yang sudah dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Tidak, batalkan!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = "{{ route('daftar-pelayanan.destroy', ':id') }}";
                        url = url.replace(':id', idPelayanan);
                        $.ajax({
                            type: 'DELETE',
                            url: url,
                            dataType: 'json', // let's set the expected response format
                            success: function(data) {
                                console.log(data);
                                if (data.success) {
                                    $('#fModal').modal('hide');
                                    swalWithBootstrapButtons.fire(
                                        'Dihapus!',
                                        'Data berhasil dihapus',
                                        'success'
                                    )
                                } else {
                                    Swal.fire(
                                        'Error!', data.message, 'error'
                                    );
                                }
                                table.ajax.reload(null, false);
                            },
                            error: function(err) {
                                if (err.status ==
                                    422
                                ) { // when status code is 422, it's a validation issue
                                    console.log(err.responseJSON);
                                    // you can loop through the errors object and show it to the user
                                    console.warn(err.responseJSON.errors);
                                    // display errors on each form field
                                    $('.ajax-invalid').remove();
                                    $.each(err.responseJSON.errors, function(i, error) {
                                        var el = $(document).find('[name="' +
                                            i + '"]');
                                        el.after($('<span class="ajax-invalid" style="color: red;">' +
                                            error[0] + '</span>'));
                                    });
                                } else if (err.status == 403) {
                                    Swal.fire(
                                        'Unauthorized!',
                                        'You are unauthorized to do the action',
                                        'warning'
                                    );
                                }
                            }
                        });
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Dibatalkan!', 'Data Aman', 'error'
                        )
                    }
                });

            });


        });
    </script>
@endsection
