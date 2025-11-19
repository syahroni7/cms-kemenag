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
                                        <th class="text-center" width="5%">No</th>
                                        <th class="text-center">Nama Unit Pengolah</th>
                                        <th class="text-center" width="20%">Aksi</th>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('admin.unit-pengolah._modal')

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


    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        var table = $('#example').DataTable({
            orderable: false,
            sort: false,
            order: false,
            lengthChange: false,
            responsive: false,
            scrollX: true,
            autoWidth: false,
            lengthMenu: [
                [10, 25, 50, -1],
                ['10 rows', '25 rows', '50 rows', 'Show all']
            ],
            iDisplayLength: 50,
            buttons: [
                'pageLength', {
                    text: '<i class="fa fa-plus-circle"></i> Tambah',
                    attr: {
                        'title': 'Import Data',
                        'data-bs-original-title': 'Import Data',
                        'data-bs-target': '#fModal',
                        'data-bs-toggle': 'modal',
                        'data-bs-backdrop': 'static',
                        'data-bs-keyboard': 'false',
                        'data-bs-title': 'Tambah Unit Pengolah',
                        'data-title': 'Tambah Unit Pengolah',
                        'type': 'button',
                        'id': 'addBtn',
                        'class': 'btn btn-primary'
                    },
                    action: function(e, dt, node, config) {
                        // alert('Button activated');
                    }
                }, {
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
                data: 'name',
                name: 'name'
            }, {
                data: 'action',
                name: 'action',
                className: 'text-center'
            }, ]
        });


        $(document).ready(function() {
            table.ajax.url('/unit-pengolah').load();

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
                $('#id_unit_pengolah').val('');
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
                $("#id_unit_pengolah").val(data.id_unit_pengolah);
                $('#name').val(data.name);

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
                            $('#id_unit_pengolah').val('');
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
                var idUnitPengolah = $(this).data('id_unit_pengolah');

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
                        var url = "{{ route('unit-pengolah.destroy', ':id') }}";
                        url = url.replace(':id', idUnitPengolah);
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
