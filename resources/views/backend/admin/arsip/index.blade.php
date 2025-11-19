@extends('backend.layouts.admin.master')
@section('title', $title)


@section('_styles')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/buttons.bootstrap5.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-5-theme.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-5-theme.rtl.min.css') }}" />

    {{-- File Pond --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/filepond/filepond.css') }}">

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

                            <table class='table table-bordered display' id="example" style="width:100%; font-size:11pt!important;">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">No Registrasi</th>
                                        <th class="text-center">Nama Layanan</th>
                                        <th class="text-center">Perihal</th>
                                        <th class="text-center">Pemohon</th>
                                        <th class="text-center">Alamat</th>
                                        <th class="text-center">Arsip Masuk</th>
                                        <th class="text-center">Arsip Keluar</th>
                                        <th class="text-center">Status</th>
                                        {{-- <th class="text-center">Aksi</th> --}}
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('admin.arsip._modal')

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

    {{-- File Pond --}}
    <script src="{{ asset('assets/js/filepond/filepond.js') }}"></script>
    <script src="{{ asset('assets/js/filepond/validate-filepond.js') }}"></script>



    <script>
        // Register the plugin
        FilePond.registerPlugin(FilePondPluginFileValidateType);

        // Get a reference to the file input element
        const inputElement = document.querySelector('input[name="data_file[]"]');
        // Create a FilePond instance
        const pond = FilePond.create(inputElement, {
            acceptedFileTypes: ['application/pdf'],
        });

        FilePond.setOptions({
            server: {
                process: {
                    url: '/upload-file/upload',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                revert: {
                    url: '/upload-file/destroy/1',
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        '_method': 'DELETE'
                    }
                }
            },
            onaddfilestart: (file) => {
                isLoadingCheck();
            },
            onprocessfile: (files) => {
                isLoadingCheck();
            }
        });

        function isLoadingCheck() {
            var isLoading = pond.getFiles().filter(x => x.status !== 5).length !== 0;
            if (isLoading) {
                $('#submitBtn').attr("disabled", "disabled");
            } else {
                $('#submitBtn').removeAttr("disabled");
            }
        }


        // Global Variabel
        var id_pelayanan = null;
        var id_arsip = null;
        var arsip_masuk_url = null;
        var arsip_keluar_url = null;
        // Cloudinary Widget

        var widgetMasuk = cloudinary.createUploadWidget({
            cloudName: 'dwzc7p9dj', // Cloud name dari Cloudinary
            uploadPreset: 'arsip_masuk',
            theme: 'minimal',
            multiple: true,
            max_file_size: 10048576,
            background: "white"
        }, (error, result) => {
            if (!error && result && result.event === "success") {
                console.log('Info Arsip Masuk: ', result.info);
                var arsip_masuk_url = result.info.secure_url;
                console.log('arsip_masuk_url');
                console.log(arsip_masuk_url);
                $('#arsip_masuk_url').val(arsip_masuk_url);
                console.log('val');
                console.log($('#arsip_masuk_url').val());
                console.log('hide masuk');

                $('.upload_widget_opener_masuk').hide();
                $('.masuk-img').show();
                $('#arsip-masuk-src').attr("src", arsip_masuk_url);

            }
        });

        // document.getElementById("upload_widget_opener_masuk").addEventListener("click", function() {
        //     widgetMasuk.open();
        // }, false);



        var widgetKeluar = cloudinary.createUploadWidget({
            cloudName: 'kemenaglebak',
            uploadPreset: 'arsip_keluar',
            theme: 'minimal',
            multiple: true,
            max_file_size: 10048576,
            background: "white"
        }, (error, result) => {
            if (!error && result && result.event === "success") {
                console.log('Info Arsip Keluar: ', result.info);
                var arsip_keluar_url = result.info.secure_url;
                console.log('arsip_keluar_url');
                console.log(arsip_keluar_url);
                $('#arsip_keluar_url').val(arsip_keluar_url);
                console.log('val');
                console.log($('#arsip_keluar_url').val());
                console.log('hide keluar');

                $('.upload_widget_opener_keluar').hide();
                $('.keluar-img').show();
                $('#arsip-keluar-src').attr("src", arsip_keluar_url);
            }
        });

        // document.getElementById("upload_widget_opener_keluar").addEventListener("click", function() {
        //     widgetKeluar.open();
        // }, false);





        // End of cloudinary widget



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
                    data: 'no_registrasi',
                    name: 'no_registrasi'
                }, {
                    data: 'layanan.name',
                    name: 'layanan.name'
                }, {
                    data: 'perihal',
                    name: 'perihal'
                }, {
                    data: 'pemohon_nama',
                    name: 'pemohon_nama'
                }, {
                    data: 'pemohon_alamat',
                    name: 'pemohon_alamat'
                }, {
                    data: 'box_arsip_masuk',
                    name: 'box_arsip_masuk'
                }, {
                    data: 'box_arsip_keluar',
                    name: 'box_arsip_keluar'
                }, {
                    data: 'status_pelayanan',
                    name: 'status_pelayanan'
                },


                // {
                //     data: 'action',
                //     name: 'action',
                //     className: 'text-center'
                // }, 

                // {
                //     data: 'arsip.arsip_masuk_url',
                //     name: 'arsip.arsip_masuk_url',
                //     // sDefaultContent: '-',
                //     className: 'text-center',
                //     render: function(data, type, row) {
                //         if (row.arsip) {
                //             if (row.arsip.arsip_masuk_url) {
                //                 return '<a href="' + row.arsip.arsip_masuk_url + '" target="_blank" class="badge bg-primary" type="button" >lihat</a>';
                //             } else {
                //                 return '<button id="upload_arsip_masuk" class="badge bg-secondary" type="button" data-bs-toggle="modal" data-bs-target="#fModal" data-title="Edit Data Item Layanan"><i class="bi bi-cloud-upload"></i></button>';
                //             }

                //         } else {
                //             return '<button id="upload_arsip_masuk" class="badge bg-secondary" type="button" data-bs-toggle="modal" data-bs-target="#fModal" data-title="Edit Data Item Layanan"><i class="bi bi-cloud-upload"></i></button>';
                //         }
                //     },
                // },

                // {
                //     data: 'arsip.arsip_keluar_url',
                //     name: 'arsip.arsip_keluar_url',
                //     // sDefaultContent: '-',
                //     className: 'text-center',
                //     render: function(data, type, row) {
                //         if (row.arsip) {
                //             if (row.arsip.arsip_keluar_url) {
                //                 return '<a href="' + row.arsip.arsip_keluar_url + '" target="_blank" class="badge bg-primary" type="button">lihat</a>';
                //             } else {
                //                 return '<button id="upload_arsip_keluar" class="badge bg-secondary upload-arsip-keluar" type="button" data-bs-toggle="modal" data-bs-target="#fModal" data-title="Edit Data Item Layanan"><i class="bi bi-cloud-upload"></i></button>';
                //             }
                //         } else {
                //             return '<button id="upload_arsip_keluar" class="badge bg-secondary upload-arsip-keluar" type="button" data-bs-toggle="modal" data-bs-target="#fModal" data-title="Edit Data Item Layanan"><i class="bi bi-cloud-upload"></i></button>';
                //         }
                //     },
                // },
            ]
        });

        $(document).on("click", ".menu-status", function() {

            // New Algorithm
            var status = $(this).data('status_pelayanan');

            $('body').block({
                message: `Loading...`
            });

            setTimeout(function() {
                $('body').unblock();
                $('.html-status').html(ucwords(status));

                $('li a.menu-status').removeClass('active')

                $('.menu-' + status).addClass('active');
                table.ajax.url('/arsip-pelayanan/').load();
            }, 500);


        });

        function ucwords(str) {
            return (str + '').replace(/^([a-z])|\s+([a-z])/g, function($1) {
                return $1.toUpperCase();
            });
        }


        $(document).ready(function() {



            $(document).on("click", ".cetak-bukti-button", function() {
                var cetakBuktiLink = $(this).data('cetak_bukti_link');
                var fileName = $(this).data('file_name');
                $('#cetak-bukti-link').attr('src', cetakBuktiLink);
                $('.cetak-title').html(fileName);
            });

            table.ajax.url('/arsip-pelayanan').load();

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

            $(document).on("click", "#upload_arsip_masuk", function(e) {
                pond.removeFiles();
                var title = $(this).data('title');
                $("#judul-modal").html('Upload Arsip Masuk');
                $('.arsip-masuk-box').show();
                $('.arsip-keluar-box').hide();
                var data = table.row($(this).parents('tr')).data();
                console.log(data);
                $('#search_id_pelayanan').val(data.id_pelayanan);
                $('#search_no_registrasi').val(data.no_registrasi);
                $('#search_id_layanan').val(data.id_layanan).trigger('change');
                $('#search_perihal').val(data.perihal);

                $('#tipe_upload').val('dokumen_masuk_url');

            });

            $(document).on("click", "#upload_arsip_keluar", function(e) {
                pond.removeFiles();
                var title = $(this).data('title');
                $("#judul-modal").html('Upload Arsip Keluar');
                $('.arsip-masuk-box').hide();
                $('.arsip-keluar-box').show();
                var data = table.row($(this).parents('tr')).data();
                console.log(data);
                $('#search_id_pelayanan').val(data.id_pelayanan);
                $('#search_no_registrasi').val(data.no_registrasi);
                $('#search_id_layanan').val(data.id_layanan).trigger('change');
                $('#search_perihal').val(data.perihal);

                $('#tipe_upload').val('dokumen_keluar_url');

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
                                if (!(typeof socket === "undefined")) {
                                    socket.emit('sendSummaryToServer', data.summary);
                                }
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
                var idJenisLayanan = $(this).data('id_jenis_layanan');

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
                        var url = "{{ route('jenis-layanan.destroy', ':id') }}";
                        url = url.replace(':id', idJenisLayanan);
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
