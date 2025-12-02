@extends('backend.layouts.admin.master')
@section('title', $title)

@section('_styles')
<link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/buttons.bootstrap5.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/select2-bootstrap-5-theme.min.css') }}" />

<style>
    .btn-primary {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
        color: #fff !important;
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

                        <table class="table table-bordered display" id="menuTable"
                            style="width:100%; font-size:11pt!important;">
                            <thead>
                                <tr>
                                    <th class="text-center">Nama Menu</th>
                                    <th class="text-center">Icon</th>
                                    <th class="text-center">URL</th>
                                    <th class="text-center">Parent</th>
                                    <th class="text-center">Order</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- MODAL TAMBAH / EDIT MENU --}}
    @include('backend.admin.pengaturan.menu._modal')

</main>
@endsection



@section('_scripts')
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2@11.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/buttons.bootstrap5.min.js') }}"></script>


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('#menuTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('pengaturan-menu.index') }}",
        scrollX: true,
        lengthChange: false,
        pageLength: 10,
        buttons: [
            'pageLength',
            {
                text: '<i class="fa fa-plus-circle"></i> TAMBAH MENU',
                className: 'btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#menuModal',
                    'id': 'addMenuBtn'
                }
            },
            {
                text: '<i class="fa fa-sort"></i> URUTKAN MENU (DRAG & DROP)',
                className: 'btn btn-info',
                action: function() {
                    window.location.href = "{{ route('pengaturan-menu.sort') }}";
                }
            },
            {
                text: '<i class="fa fa-sync-alt"></i> RELOAD',
                className: 'btn btn-warning',
                action: function(e, dt, node, config) {
                    dt.ajax.reload(null, false);
                }
            }
        ],
        columns: [{
                data: 'name',
                name: 'name'
            },
            {
                data: 'icon',
                name: 'icon',
                className: 'text-center'
            },
            {
                data: 'url',
                name: 'url'
            },
            {
                data: 'parent_name',
                name: 'parent_name'
            },
            {
                data: 'order',
                name: 'order',
                className: 'text-center'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ],
        dom: 'Bfrtip'
    });

    table.buttons().container().appendTo('#menuTable_wrapper .col-md-6:eq(0)');


    // ====================================================
    // TAMBAH MENU
    // ====================================================
    $(document).on('click', '#addMenuBtn', function() {
        $('#menuForm')[0].reset();
        $('#menu_id').val('');
        $('#modalTitle').text('Tambah Menu');
    });


    // ====================================================
    // EDIT MENU
    // ====================================================
    // Saat membuka modal edit (di event editMenuBtn)
    $(document).on('click', '.editMenuBtn', function() {
        let data = table.row($(this).parents('tr')).data();

        $('#menu_id').val(data.id);
        $('#name').val(data.name);
        $('#icon').val(data.icon);
        $('#url').val(data.url);
        $('#parent_id').val(data.parent_id);
        $('#order').val(data.order);

        // Update preview icon
        updateIconPreview(data.icon);

        $('#modalTitle').text('Edit Menu');
        $('#menuModal').modal('show');
    });

    // Update preview icon saat input icon berubah manual
    $('#icon').on('input', function() {
        let iconClass = $(this).val();
        updateIconPreview(iconClass);
    });

    // Fungsi untuk update preview icon
    function updateIconPreview(iconClass) {
        if (iconClass && iconClass.trim() !== '') {
            $('#iconPreview').html('<i class="' + iconClass + '"></i>');
        } else {
            $('#iconPreview').html(''); // kosongkan preview
        }
    }

    // ====================================================
    // SUBMIT FORM
    // ====================================================
    $('#saveMenuBtn').on('click', function(e) {
        e.preventDefault();

        let formData = new FormData($('#menuForm')[0]);
        $('#saveMenuBtn').prop('disabled', true);

        $.ajax({
            type: 'POST',
            url: $('#menuForm').attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#saveMenuBtn').prop('disabled', false);
                if (response.success === true) {
                    $('#menuModal').modal('hide');
                    table.ajax.reload(null, false);
                    Swal.fire('Sukses!', 'Menu berhasil disimpan!', 'success');
                } else {
                    Swal.fire('Error!', response.message, 'error');
                }
            },
            error: function(xhr) {
                $('#saveMenuBtn').prop('disabled', false);
                Swal.fire('Error!', 'Terjadi kesalahan saat menyimpan!', 'error');
            }
        });
    });


    // ====================================================
    // HAPUS MENU
    // ====================================================
    $(document).on('click', '.deleteMenuBtn', function() {
        let id = $(this).data('id');

        let deleteUrlTemplate = "{{ route('pengaturan-menu.destroy', ':id') }}";
        let url = deleteUrlTemplate.replace(':id', id);

        Swal.fire({
            title: 'Hapus menu ini?',
            text: "Tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((res) => {
            if (res.isConfirmed) {
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    success: function() {
                        table.ajax.reload(null, false);
                        Swal.fire('Terhapus!', 'Menu berhasil dihapus.', 'success');
                    },
                    error: function(xhr) {
                        let msg = 'Gagal menghapus menu!';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire('Error!', msg, 'error');
                    }
                });
            }
        });
    });
</script>

@endsection