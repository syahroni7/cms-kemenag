@extends('backend.layouts.admin.master')
@section('title', $title)

@section('_styles')
<link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/buttons.bootstrap5.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/select2-bootstrap-5-theme.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/select2-bootstrap-5-theme.rtl.min.css') }}" />

<style>
    .permission-badges .badge {
        font-size: 0.75em;
        margin-bottom: 2px;
    }

    .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }

    .form-check-label {
        font-size: 0.9rem;
    }
</style>
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

                        <table class='table table-bordered display' id="example"
                            style="width:100%; font-size:11pt!important;">
                            <thead>
                                <tr>
                                    <th class="text-center" width="5%">No</th>
                                    <th class="text-center">Level User</th>
                                    <th class="text-center">Izin Akses</th>
                                    <th class="text-center" width="20%">Aksi</th>
                                </tr>
                            </thead>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('backend.admin.users.roles._modal')

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
    $(document).ready(function() {
        // CSRF Token Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // SweetAlert Configuration
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        });

        // DataTable Configuration - TOMBOL TAMBAH DAN RELOAD DIPERTAHANKAN
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
                        'data-bs-title': 'Tambah Level / Peran User',
                        'data-title': 'Tambah Level / Peran User',
                        'type': 'button',
                        'id': 'addBtn',
                        'class': 'btn btn-primary'
                    },
                    action: function(e, dt, node, config) {
                        // Handler akan dihandle oleh event listener di bawah
                    }
                }, {
                    text: '<i class="fa fa-refresh"></i> Reload',
                    attr: {
                        'title': 'Refresh Table',
                        'class': 'btn btn-warning'
                    },
                    action: function(e, dt, node, config) {
                        reloadTable();
                    }
                }
            ],
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                className: 'text-center'
            }, {
                data: 'name',
                name: 'name',
                className: 'text-center'
            }, {
                data: 'role_permissions',
                name: 'role_permissions',
                className: 'permission-badges'
            }, {
                data: 'action',
                name: 'action',
                className: 'text-center'
            }]
        });

        // Initialize buttons
        table.buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');

        // Event Handlers
        function resetForm() {
            $('#fForm')[0].reset();
            $('#id_role').val('');
            $('.edit-state').hide();
            $('#name').prop('disabled', false);
            $('.permission-checkbox').prop('checked', false);
            $('.ajax-invalid').remove();
            $('.is-invalid').removeClass('is-invalid');
            $('#fForm').attr('action', "{{ route('user-roles.store') }}");
            $('#form-method').val('POST');
        }

        function reloadTable() {
            $('#example').block({
                message: 'Loading...'
            });
            table.ajax.reload(null, false);
            setTimeout(function() {
                $('#example').unblock();
            }, 1500);
        }

        function handleSuccess(response) {
            setTimeout(function() {
                $('#submitBtn').prop("disabled", false);
                $('.modalBox').unblock();

                if (response.success) {
                    $('#fModal').modal('hide');
                    reloadTable();
                    Swal.fire('Berhasil!', response.message, 'success');
                } else {
                    Swal.fire('Error!', response.message, 'error');
                }
            }, 200);
        }

        function handleError(xhr) {
            $('#submitBtn').prop("disabled", false);
            $('.modalBox').unblock();

            $('.ajax-invalid').remove();
            $('.is-invalid').removeClass('is-invalid');

            console.log('Error response:', xhr);
            console.log('Error status:', xhr.status);
            console.log('Error response JSON:', xhr.responseJSON);

            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                console.log('Validation errors:', errors);

                $.each(errors, function(field, messages) {
                    const input = $(`[name="${field}"]`);
                    input.addClass('is-invalid');
                    // For array fields like permissions[]
                    if (field.includes('[')) {
                        const baseField = field.split('[')[0];
                        $(`[name^="${baseField}"]`).closest('.form-check').addClass('is-invalid');
                    }
                    input.after(`<span class="ajax-invalid text-danger">${messages[0]}</span>`);
                });

                Swal.fire('Validasi Gagal!', 'Periksa kembali data yang diinput', 'error');
            } else if (xhr.status === 403) {
                Swal.fire('Unauthorized!', 'Anda tidak memiliki akses untuk tindakan ini', 'warning');
            } else {
                Swal.fire('Error!', 'Terjadi kesalahan pada server: ' + (xhr.responseJSON?.message || xhr.statusText), 'error');
            }
        }

        // Edit Button Handler - DENGAN DEBUGGING LENGKAP
        $(document).on("click", "#editBtn", function() {
            resetForm();
            $('.edit-state').show();

            const data = table.row($(this).parents('tr')).data();
            if (!data) return;

            console.log('=== EDIT DATA DEBUG ===');
            console.log('Full data:', data);
            console.log('Permissions data:', data.permissions);
            console.log('Permissions type:', typeof data.permissions);
            console.log('Permissions length:', data.permissions ? data.permissions.length : 0);

            $('#id_role').val(data.id);
            $('#name').val(data.name);
            $('#judul-modal').text('Edit Level / Peran User');

            // Change form action for update
            $('#fForm').attr('action', "{{ route('user-roles.update', ':id') }}".replace(':id', data.id));
            $('#form-method').val('PUT');

            // Reset all checkboxes first
            $('.permission-checkbox').prop('checked', false);

            // Check permissions - DENGAN DEBUGGING DETAIL
            if (data.permissions && data.permissions.length > 0) {
                console.log('=== PROCESSING PERMISSIONS ===');

                data.permissions.forEach((permission, index) => {
                    console.log(`Permission [${index}]:`, permission);
                    console.log(`Permission [${index}] type:`, typeof permission);

                    // Handle different permission formats
                    let permissionId;

                    if (typeof permission === 'object' && permission !== null) {
                        permissionId = permission.id;
                        console.log(`Permission [${index}] as object, ID:`, permissionId);
                    } else if (typeof permission === 'number' || typeof permission === 'string') {
                        permissionId = permission;
                        console.log(`Permission [${index}] as primitive, ID:`, permissionId);
                    } else {
                        console.warn(`Permission [${index}] has unknown format:`, permission);
                        return; // Skip invalid format
                    }

                    // Find and check the checkbox
                    const checkbox = $(`input[name="permissions[]"][value="${permissionId}"]`);

                    if (checkbox.length > 0) {
                        checkbox.prop('checked', true);
                        console.log(`✓ Checked permission ID: ${permissionId}`);
                    } else {
                        console.warn(`✗ Checkbox not found for permission ID: ${permissionId}`);
                    }
                });

                console.log('=== END PROCESSING PERMISSIONS ===');
            } else {
                console.warn('No permissions found or empty permissions array');
            }
        });

        // Add Button Handler - Reset to create mode
        $(document).on("click", "#addBtn", function() {
            resetForm();
            $('#judul-modal').text('Tambah Level / Peran User');
            $('#fForm').attr('action', "{{ route('user-roles.store') }}");
            $('#form-method').val('POST');
        });

        // Submit Form Handler - DENGAN DEBUGGING
        $("#submitBtn").on("click", function(event) {
            event.preventDefault();
            submitForm();
        });

        function submitForm() {
            $('.modalBox').block({
                message: 'Menyimpan data...'
            });
            $('#submitBtn').prop("disabled", true);

            // Debug form data sebelum dikirim
            const formData = new FormData($('#fForm')[0]);
            const formDataObj = {};
            for (let [key, value] of formData.entries()) {
                if (formDataObj[key]) {
                    if (Array.isArray(formDataObj[key])) {
                        formDataObj[key].push(value);
                    } else {
                        formDataObj[key] = [formDataObj[key], value];
                    }
                } else {
                    formDataObj[key] = value;
                }
            }

            console.log('=== FORM DATA TO BE SENT ===');
            console.log('Form data:', formDataObj);
            console.log('Permissions to send:', formDataObj['permissions[]']);
            console.log('Role ID:', $('#id_role').val());
            console.log('Form action:', $('#fForm').attr('action'));
            console.log('Form method:', $('#form-method').val());

            const url = $('#fForm').attr('action');
            const method = $('#form-method').val();

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    handleSuccess(response);
                },
                error: function(xhr) {
                    handleError(xhr);
                }
            });
        }

        // Delete Button Handler
        $(document).on("click", "#destroyBtn", function() {
            event.preventDefault();
            var roleID = $(this).data('role_id');

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
                    var url = "{{ route('user-roles.destroy', ':id') }}";
                    url = url.replace(':id', roleID);
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            if (data.success) {
                                $('#fModal').modal('hide');
                                swalWithBootstrapButtons.fire(
                                    'Dihapus!',
                                    'Data berhasil dihapus',
                                    'success'
                                );
                                reloadTable();
                            } else {
                                Swal.fire('Error!', data.message, 'error');
                            }
                        },
                        error: function(err) {
                            if (err.status == 422) {
                                console.log(err.responseJSON);
                                console.warn(err.responseJSON.errors);
                                $('.ajax-invalid').remove();
                                $.each(err.responseJSON.errors, function(i, error) {
                                    var el = $(document).find('[name="' + i + '"]');
                                    el.after($('<span class="ajax-invalid" style="color: red;">' + error[0] + '</span>'));
                                });
                            } else if (err.status == 403) {
                                Swal.fire('Unauthorized!', 'You are unauthorized to do the action', 'warning');
                            }
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire('Dibatalkan!', 'Data Aman', 'error');
                }
            });
        });

        // Load initial data
        table.ajax.url('/users/roles').load();

        // Window resize handler
        $(window).on('resize', function() {
            table.columns.adjust();
        });

        // Sidebar toggle handler
        $('.toggle-sidebar-btn').on('click', function() {
            setTimeout(function() {
                table.columns.adjust();
            }, 500);
        });
    });
</script>
@endsection