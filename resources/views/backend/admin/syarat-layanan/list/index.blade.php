@extends('backend.layouts.admin.master')
@section('title', $title)


@section('_styles')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/buttons.bootstrap5.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-5-theme.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-5-theme.rtl.min.css') }}" />
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
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $title }}</h5>

                            <table class='table table-bordered display' id="example" style="width:100%; font-size:11pt!important;">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Unit Pengolah</th>
                                        <th class="text-center">Nama Layanan</th>
                                        <th class="text-center">Syarat Layanan</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('admin.syarat-layanan.list._modal')

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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });



        $('.select2').select2({
            theme: 'bootstrap-5',
            dropdownParent: $("#fModal"),
        });

        $('.select2-search').select2({
            theme: 'bootstrap-5',
            dropdownParent: $("#fModal"),
            ajax: {
                url: "/syarat-layanan/master/search",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function(data, params) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.id_master_syarat_layanan,
                            }
                        })
                    };
                },
                cache: true
            },
            placeholder: 'Cari Item Syarat Layanan',
            minimumInputLength: 5,
            "language": {
                "noResults": function(res, data) {
                    // console.log(res, data);
                    return "Tidak ditemukan <a class='btn btn-sm btn-danger add-new-syarat'>Tambahkan</a>";
                }
            },
            escapeMarkup: function(markup) {
                // console.log('markup');
                // console.log(markup);
                return markup;
            }
        });

        $(document).on('click', '.add-new-syarat', function(e) {
            console.log('add new syarat clicked');
            var syaratName = $('.select2-search__field').val();
            console.log('data');
            console.log(syaratName);
            var id_layanan = $('#id_layanan').val();

            $.ajax({
                type: 'PUT',
                url: `/syarat-layanan/list/add/${id_layanan}/`,
                data: {
                    syarat_name: syaratName
                },
                dataType: 'json', // let's set the expected response format
                success: function(data) {
                    setTimeout(function() {
                        console.log(data);
                        if (!data.success) {
                            Swal.fire(
                                'Error!', data.message, 'error'
                            );
                        }

                        jsonTbl.ajax.reload(null, false);
                        table.ajax.reload(null, false);
                        $('#jsonTbl').unblock();
                    }, 100);

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
                            'Unauthorized!',
                            'You are unauthorized to do the action',
                            'warning'
                        );

                    }
                }
            });
        });




        var table = $('#example').DataTable({
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
            ajax: '/syarat-layanan/list' + '?id_unit_pengolah_filter=' + id_unit_pengolah_filter,
            iDisplayLength: 10,
            initComplete: function(settings, json) {
                console.log(json)

                table.buttons().container()
                    .appendTo('#example_wrapper .col-md-6:eq(0)');

                $(json.html_filter).appendTo('#example_wrapper .col-md-6:eq(0) .dt-buttons');

                $('.select2-filter').select2({
                    theme: 'bootstrap-5',
                });

                // $(document).on('change', '#id_unit_pengolah_filter', function(e) {
                $(document).on('select2:select', '.id_unit_pengolah_filter', function(e) {
                    console.log('data filter')

                    id_unit_pengolah_filter = $(this).val();
                    console.log('id_unit_pengolah_filter')
                    console.log(id_unit_pengolah_filter)
                    table.ajax.url('/syarat-layanan/list' + '?id_unit_pengolah_filter=' +
                        id_unit_pengolah_filter).load(false);
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
                data: 'unit.name',
                name: 'unit.name'
            }, {
                data: 'name',
                name: 'name',
                className: 'fw-bold fs-6'
            }, {
                data: 'syarat_layanan',
                name: 'syarat_layanan',
            }, {
                data: 'action',
                name: 'action',
                className: 'text-center'
            }, ]
        });

        // pageLength: 5,
        var jsonTbl = $('#jsonTbl').DataTable({
            paging: false,
            orderable: false,
            sort: false,
            order: false,
            lengthChange: false,
            responsive: false,
            search: false,
            searching: false,
            autoWidth: false,
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                className: 'text-center',
                sWidth: '5%',
                width: '5%',
            }, {
                data: 'name',
                name: 'name'
            }, {
                data: 'id_master_syarat_layanan',
                name: 'id_master_syarat_layanan',
                render: function(data, type, row) {
                    return '<button type="button" id="removeItem" class="badge bg-danger delete-btn" style="cursor:pointer;"><i class="bi bi-trash-fill"></i></button>';
                },
                className: 'text-center',
                sWidth: '5%',
                width: '5%',
            }]
        });

        $(document).on('select2:select', '#search-syarat', function(e) {
            var data = $(this).select2('data')[0];
            console.log(data);

            var arrSyarat = jsonTbl
                .column(2)
                .data();

            console.log(arrSyarat);
            console.log(arrSyarat);

            var id_master_syarat_layanan = data.id;
            var id_layanan = $('#id_layanan').val();

            if (data && (jQuery.inArray(parseInt(id_master_syarat_layanan), arrSyarat) === -1)) {

                $('#jsonTbl').block({
                    message: `Loading...`
                });

                $.ajax({
                    type: 'PUT',
                    url: `/syarat-layanan/list/put/${id_layanan}/${id_master_syarat_layanan}`,
                    dataType: 'json', // let's set the expected response format
                    success: function(data) {
                        setTimeout(function() {
                            console.log(data);
                            if (!data.success) {
                                Swal.fire(
                                    'Error!', data.message, 'error'
                                );
                            }

                            jsonTbl.ajax.reload(null, false);
                            table.ajax.reload(null, false);
                            $('#jsonTbl').unblock();
                        }, 100);

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
                                'Unauthorized!',
                                'You are unauthorized to do the action',
                                'warning'
                            );

                        }
                    }
                });

            } else {
                alert('Data Sudah Ada');
            }
            $(this).val(null).trigger('change');


            // Algoritma Lama
            // var rowCount = jsonTbl.data().count()
            // var idX = rowCount + 1;

            // arrSyarat = [];
            // if (rowCount > 0) {
            //     var arrSyarat = jsonTbl
            //         .column(2)
            //         .data();
            // } else {
            //     var arrSyarat = jsonTbl
            //         .column(2)
            //         .data();
            // }

            // console.log('data.id');
            // console.log(data.id);
            // console.log('arrSyarat');
            // console.log(arrSyarat);

            // // if (data && (jQuery.inArray(parseInt(data.id), arrSyarat) === -1)) {
            // if (data && (jQuery.inArray(data.id, arrSyarat) === -1)) {

            //     jsonTbl.rows.add([{
            //         'DT_RowIndex': idX,
            //         'name': data.text,
            //         'id_master_syarat_layanan': data.id
            //     }]).draw(false);

            // } else {
            //     alert('Data Sudah Ada');
            // }

            // $(this).val(null).trigger('change');


            // var arrSyarat = jsonTbl
            //     .column(2)
            //     .data();

            // var arrayIDSyarat = arrSyarat.join(', ');
            // $('#array_id_master_syarat_layanan').val(arrayIDSyarat);
        });




        $(document).ready(function() {
            $('#id_unit_pengolah').prop('disabled', true);
            $('#id_jenis_layanan').prop('disabled', true);
            $('#id_output_layanan').prop('disabled', true);

            // table.ajax.url('/syarat-layanan/list').load();

            // table.buttons().container()
            //     .appendTo('#example_wrapper .col-md-6:eq(0)');

            $('.toggle-sidebar-btn').on('click', function() {
                setTimeout(function() {
                    table.columns.adjust();
                }, 500);
            });

            $(window).on('resize', function() {
                setTimeout(function() {
                    table.columns.adjust();
                }, 500);
            });


            $(document).on("click", "#addBtn", function() {
                $('.edit-state').hide();
                $('#id_layanan').val('');
                $('#fForm')[0].reset();
                var title = $(this).data('title');
                $("#judul-modal").html(title);
                $('#nama').prop('disabled', false);
            });

            $(document).on("click", "#editBtn", function() {
                $('.edit-state').show();
                var title = $(this).data('title');
                $("#judul-modal").html(title);
                var data = table.row($(this).parents('tr')).data();
                console.log(data);
                console.log(title);
                $("#id_layanan").val(data.id_layanan);
                $('#name').val(data.name);

                $('#id_unit_pengolah').val(data.id_unit_pengolah).trigger('change');
                $('#id_jenis_layanan').val(data.id_jenis_layanan).trigger('change');
                $('#id_output_layanan').val(data.id_output_layanan).trigger('change');
                $('#lama_layanan').val(data.lama_layanan);
                $('#biaya_layanan').val(data.biaya_layanan);


                // Algoritma Lama
                // jsonTbl.clear().draw();
                // $.each(data.syarat, function(i, item) {
                //     idX = i + 1;
                //     jsonTbl.rows.add([{
                //         'DT_RowIndex': idX,
                //         'name': item.name,
                //         'id_master_syarat_layanan': item.id_master_syarat_layanan
                //     }]).draw(false);
                // });

                // Algoritma Baru
                jsonTbl.ajax.url('/syarat-layanan/list/fetch/' + data.id_layanan).load();


            });

            $(document).on('click', '.delete-btn', function(e) {


                var data = jsonTbl.row($(this).parents('tr')).data();
                console.log(data);

                if (data.hasOwnProperty('pivot')) {
                    var id_layanan = data.pivot.id_layanan;
                    var id_master_syarat_layanan = data.pivot.id_master_syarat_layanan;

                    $('#jsonTbl').block({
                        message: `Loading...`
                    });

                    $.ajax({
                        type: 'DELETE',
                        url: `/syarat-layanan/list/destroy/${id_layanan}/${id_master_syarat_layanan}`,
                        dataType: 'json', // let's set the expected response format
                        success: function(data) {
                            setTimeout(function() {
                                console.log(data);
                                if (data.success) {
                                    // Swal.fire(
                                    //     'Selamat!', 'Data sukses di update!',
                                    //     'success'
                                    // );
                                } else {
                                    Swal.fire(
                                        'Error!', data.message, 'error'
                                    );
                                }

                                jsonTbl.ajax.reload(null, false);
                                table.ajax.reload(null, false);
                                $('#jsonTbl').unblock();
                            }, 100);

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
                                    'Unauthorized!',
                                    'You are unauthorized to do the action',
                                    'warning'
                                );

                            }
                        }
                    });

                } else {
                    jsonTbl
                        .row($(this).parents('tr'))
                        .remove()
                        .draw(false);
                }

                // Algoritma Lama
                // jsonTbl
                //     .row($(this).parents('tr'))
                //     .remove()
                //     .draw(false);

                // let i = 1;

                // jsonTbl.cells(null, 0, {
                //     search: 'applied',
                //     order: 'applied'
                // }).every(function(cell) {
                //     this.data(i++);
                // });

                // console.log('nijalankok');

                // var arrSyarat = jsonTbl
                //     .column(2)
                //     .data();

                // var arrayIDSyarat = arrSyarat.join(', ');
                // $('#array_id_master_syarat_layanan').val(arrayIDSyarat);

                // Algoritma Baru


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
                            if (data.success == 'yeah') {
                                $('#fModal').modal('hide');
                                table.ajax.reload(null, false);
                                Swal.fire(
                                    'Great!', 'Data sukses di update!', 'success'
                                );
                            } else {
                                Swal.fire(
                                    'Error!', data.message, 'error'
                                );
                            }
                            $('#fForm')[0].reset();
                            $('#id_layanan').val('');
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


        });
    </script>
@endsection
