@extends('backend.layouts.admin.master')
@section('title', $title)

@section('_styles')
<link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/buttons.bootstrap5.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/select2-bootstrap-5-theme.min.css') }}" />

<style>
    .btn-primary {
        background-color: #0d6efd !important; /* biru Bootstrap 5 */
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

                        <table class="table table-bordered display" id="example" style="width:100%; font-size:11pt!important;">
                            <thead>
                                <tr>
                                    <th class="text-center" width="5%">No</th>
                                    <th class="text-center">Nama Kantor</th>
                                    <th class="text-center">Alamat</th>
                                    <th class="text-center">Telepon</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Jam Operasional</th>
                                    <th class="text-center" width="20%">Aksi</th>
                                </tr>
                            </thead>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('backend.admin.pengaturan.kontak._modal')
</main>
@endsection

@section('_scripts')
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2@11.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/buttons.bootstrap5.min.js') }}"></script>

<script>
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

var table = $('#example').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('pengaturan-kontak.index') }}",
    scrollX: true,
    lengthChange: false,
    pageLength: 10,
    buttons: [
        'pageLength',
        {
            text: '<i class="fa fa-plus-circle"></i> TAMBAH',
            className: 'btn btn-primary', // biru
            attr: {
                'data-bs-toggle': 'modal',
                'data-bs-target': '#fModal',
                'id': 'addBtn'
            }
        },
        {
            text: '<i class="fa fa-sync-alt"></i> RELOAD',
            className: 'btn btn-warning', // kuning
            action: function(e, dt, node, config) {
                dt.ajax.reload(null, false);
            }
        }
    ],
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center', orderable: false, searchable: false },
        { data: 'nama_kantor', name: 'nama_kantor' },
        { data: 'alamat', name: 'alamat' },
        { data: 'telepon', name: 'telepon' },
        { data: 'email', name: 'email' },
        { data: 'jam_operasional', name: 'jam_operasional' },
        { data: 'action', name: 'action', className: 'text-center', orderable: false, searchable: false }
    ],
    dom: 'Bfrtip'
});

// Pindahkan tombol ke atas kiri datatable
table.buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');

// Tambah Kontak
$(document).on('click', '#addBtn', function() {
    $('#fForm')[0].reset();
    $('#id').val('');
    $('#judul-modal').text('Tambah Kontak');
    $('#fModal').modal('show');
});

// Edit Kontak
$(document).on('click', '#editBtn', function() {
    var data = table.row($(this).parents('tr')).data();
    $('#id').val(data.id);
    $('#nama_kantor').val(data.nama_kantor);
    $('#alamat').val(data.alamat);
    $('#telepon').val(data.telepon);
    $('#email').val(data.email);
    $('#jam_operasional').val(data.jam_operasional);
    $('#judul-modal').text('Edit Kontak');
    $('#fModal').modal('show');
});

// Submit Form
$('#submitBtn').on('click', function(e) {
    e.preventDefault();
    $('#submitBtn').prop('disabled', true);
    var formData = $('#fForm').serialize();
    var url = $('#fForm').attr('action');

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        dataType: 'json',
        success: function(response) {
            $('#submitBtn').prop('disabled', false);
            if(response.success === 'yeah'){
                $('#fModal').modal('hide');
                table.ajax.reload(null,false);
                Swal.fire('Sukses!', 'Data kontak berhasil disimpan!', 'success');
                $('#fForm')[0].reset();
            }else{
                Swal.fire('Error!', response.message, 'error');
            }
        },
        error: function(xhr){
            $('#submitBtn').prop('disabled', false);
            if(xhr.status === 422){
                $('.ajax-invalid').remove();
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, messages){
                    let input = $('[name="'+key+'"]');
                    input.after('<span class="ajax-invalid" style="color:red;">'+messages[0]+'</span>');
                });
            }else{
                Swal.fire('Error!', 'Terjadi kesalahan saat menyimpan data.', 'error');
            }
        }
    });
});

// Hapus Kontak
$(document).on('click', '#destroyBtn', function(){
    let id = $(this).data('id');
    Swal.fire({
        title: 'Yakin hapus kontak ini?',
        text: "Data tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result)=>{
        if(result.isConfirmed){
            $.ajax({
                url: '/pengaturan/kontak/destroy/'+id,
                type: 'DELETE',
                data: { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function(){
                    table.ajax.reload(null,false);
                    Swal.fire('Terhapus!', 'Kontak berhasil dihapus.', 'success');
                },
                error: function(){
                    Swal.fire('Error!', 'Gagal menghapus data.', 'error');
                }
            });
        }
    });
});
</script>
@endsection
