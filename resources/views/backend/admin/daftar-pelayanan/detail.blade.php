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
        *:focus {
            outline: 0px;
        }

        .aksi-disposisi {
            text-transform: capitalize;
        }

        .disp-name {
            line-height: 10pt !important;
        }

        .select2 {
            width: 100% !important;
        }

        .dashboard .activity .activity-item .activite-label {
            color: #888;
            position: relative;
            flex-shrink: 0;
            flex-grow: 0;
            min-width: 90px !important;
            text-align: right !important;
        }

        .responsive-iframe {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 100%;
        }

        .modal-print {
            min-height: 700px !important;
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
        <section class="section dashboard">

            <div class="form-box">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="accordion card" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <h5 class="card-title m-0 p-0"> <i class="bi bi-card-checklist"></i> Detail Pelayanan Publik
                                        </h5>
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <form class="row g-3 mt-2" id="sForm">
                                            {{ csrf_field() }}
                                            <div class="col-md-6">
                                                <label for="search_no_registrasi" class="form-label fw-bold">No Registrasi</label>
                                                <input class="form-control" name="search_no_registrasi" id="search_no_registrasi" type="text" value="" placeholder="No Registrasi" disabled>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="search_id_layanan" class="form-label fw-bold">Nama Layanan</label>
                                                <select name="search_id_layanan" id="search_id_layanan" class="form-control select2" disabled="true" width="100%">
                                                    <option selected="">Pilih Layanan</option>
                                                    @foreach ($daftar_layanan as $layanan)
                                                        <option value="{{ $layanan->id_layanan }}">{{ $layanan->unit->name . ' - ' . $layanan->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="search_pemohon_no_surat" class="form-label fw-bold">Perihal</label>
                                                <input class="form-control" name="search_perihal" id="search_perihal" type="text" value="" placeholder="Perihal" disabled>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="search_pemohon_no_surat" class="form-label fw-bold">No. Surat
                                                    Permohonan</label>
                                                <input class="form-control" name="search_pemohon_no_surat" id="search_pemohon_no_surat" type="text" placeholder="Nomor Surat" value="" disabled>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="search_pemohon_tanggal_surat" class="form-label fw-bold">Tanggal Surat
                                                    Permohonan</label>
                                                <input type="date" class="form-control" name="search_pemohon_tanggal_surat" id="search_pemohon_tanggal_surat" placeholder="Tanggal Surat" disabled>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="search_pemohon_nama" class="form-label fw-bold">Nama Pemohon</label>
                                                <input class="form-control" name="search_pemohon_nama" id="search_pemohon_nama" type="text" placeholder="Nama Pemohon" value="" disabled>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="search_pemohon_alamat" class="form-label fw-bold">Alamat
                                                    Pemohon</label>
                                                <input class="form-control" name="search_pemohon_alamat" id="search_pemohon_alamat" type="text" placeholder="Alamat Pemohon" value="" disabled>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="search_pemohon_no_hp" class="form-label fw-bold">No. HP
                                                    Pemohon</label>
                                                <input class="form-control" name="search_pemohon_no_hp" id="search_pemohon_no_hp" type="text" placeholder="Nomor HP Pemohon" value="" disabled>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="search_pengirim_nama" class="form-label fw-bold">Nama Pengirim</label>
                                                <input class="form-control" name="search_pengirim_nama" id="search_pengirim_nama" type="text" placeholder="Nama Pengirim" value="" disabled>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="search_kelengkapan_syarat" class="form-label fw-bold">Kelengkapan
                                                    Syarat</label>
                                                <select name="search_kelengkapan_syarat" id="search_kelengkapan_syarat" class="form-control select2" disabled="false" width="100%">
                                                    <option selected="">-- Pilih Kelengkapan Syarat --</option>
                                                    <option value="Sudah Lengkap">Sudah Lengkap</option>
                                                    <option value="Belum Lengkap">Belum Lengkap</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="search_status_pelayanan" class="form-label fw-bold">Status
                                                    Pelayanan</label>
                                                <select name="search_status_pelayanan" id="search_status_pelayanan" class="form-control select2" disabled="true" width="100%">
                                                    <option selected="">-- Pilih Status Layanan --</option>
                                                    <option value="Baru">Baru</option>
                                                    <option value="Proses">Proses</option>
                                                    <option value="Selesai">Selesai</option>
                                                    <option value="Ambil">Ambil</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label for="search_catatan" class="form-label fw-bold">Catatan</label>
                                                <textarea class="form-control" style="height: 100px" name="search_catatan" id="search_catatan" disabled="true"></textarea>
                                            </div>

                                            <div class="card-footer">
                                                {{-- <button type="button" class="btn btn-primary float-end">Detail</button> --}}
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion card" id="accordion2">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne2">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                        <h5 class="card-title m-0 p-0"> <i class="bi bi-archive"></i> Arsip Pelayanan
                                        </h5>
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingOne2" data-bs-parent="#accordion2">
                                    <div class="accordion-body">
                                        <form class="row g-3 mt-2" id="aForm">
                                            <div class="col-12">
                                                <label for="search_catatan" class="form-label fw-bold">Arsip Masuk</label>
                                                <div class="arsip-masuk-output">
                                                    -
                                                </div>

                                                <div class="arsip-masuk-box-upload">
                                                    <span id="upload_arsip_masuk" class="badge bg-primary me-1 text-start upload-arsip-masuk" type="button" data-bs-toggle="modal" data-bs-target="#fModal" data-title="Edit Data Item Layanan"><i class="bi bi-archive"></i> Upload</span>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label for="search_catatan" class="form-label fw-bold">Arsip Keluar</label>
                                                <div class="arsip-keluar-box-upload">
                                                    <span id="upload_arsip_keluar" class="badge bg-primary me-1 text-start upload-arsip-keluar" type="button" data-bs-toggle="modal" data-bs-target="#fModal" data-title="Edit Data Item Layanan"><i class="bi bi-archive"></i> Upload</span>
                                                </div>
                                                <div class="arsip-keluar-output">
                                                    -
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label for="search_catatan" class="form-label fw-bold text-danger">Arsip Lama</label>
                                                <div class="arsip-lama-box">
                                                    -
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="col-lg-5">



                        <div class="accordion card" id="accordion3">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne3">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                        <h5 class="card-title m-0 p-0"> <i class="bi bi-mailbox"></i> Riwayat Disposisi
                                        </h5>
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingOne3" data-bs-parent="#accordion3">
                                    <div class="accordion-body">
                                        <div class="activity mt-3 disposisi-box">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card lembar-disposisi" style="display: none">
                            <div class="card-header">
                                <h5 class="card-title m-0 p-0"> <i class="bi bi-mailbox"></i> Lembaran Disposisi
                                </h5>
                            </div>
                            <div class="card-body">

                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    Kosongkan Data Pegawai jika permohonan ingin ditunda / arsip!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                                <form class="row g-3 mt-2 needs-validation" novalidate id="dForm" method="post" action="{{ route('disposisi-list.store') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                    <input type="hidden" name="id_pelayanan" id="id_pelayanan" value="">
                                    <input type="hidden" name="id_disposisi_parent" id="id_disposisi_parent" value="">
                                    <input type="hidden" name="urutan_disposisi" id="urutan_disposisi" value="">

                                    <div class="col-md-12 form-group">
                                        <label for="id_recipient" class="form-label fw-bold">Nama Pejabat / Pegawai</label>
                                        <select name="id_recipient" id="id_recipient" class="form-control select2 custom-select">
                                            <option selected value="">Pilih Pejabat</option>
                                            @foreach ($pegawai as $item)
                                                <option value="{{ $item->id }}">{{ $item->name . ' - ' . $item->jabatan }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label for="id_aksi_disposisi" class="form-label fw-bold">Instruksi Disposisi</label>
                                        <select name="id_aksi_disposisi" id="id_aksi_disposisi" class="form-control select2 custom-select">
                                            <option selected value="">-- Pilih Disposisi --</option>
                                            @foreach ($aksi as $item)
                                                <option value="{{ $item->id_aksi_disposisi }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <label for="catatan" class="form-label fw-bold">Catatan / Keterangan</label>
                                        <textarea class="form-control" style="height: 100px" name="keterangan" id="keterangan"></textarea>
                                    </div>

                                    <hr />
                                    <button type="button" id="saveDisposisiBtn" class="btn btn-primary float-end m-0">Disposisikan</button>

                                    {{-- <div class="card-footer">

                                    </div> --}}
                                </form>

                            </div>

                        </div>



                    </div>
                </div>

            </div>

            {{-- </div> --}}
        </section>

        @include('admin.daftar-pelayanan._fmodal')

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


        $(document).on("click", ".upload-arsip-masuk", function(e) {
            pond.removeFiles();
            var title = $(this).data('title');
            $("#judul-modal").html('Upload Arsip Masuk');
            $('.arsip-masuk-box').show();
            $('.arsip-keluar-box').hide();
            console.log('GlobalData');
            console.log(globalData);
            $('#modal_id_pelayanan').val(globalData.id_pelayanan);
            $('#modal_no_registrasi').val(globalData.no_registrasi);
            $('#modal_id_layanan').val(globalData.id_layanan).trigger('change');
            $('#modal_perihal').val(globalData.perihal);

            $('#tipe_upload').val('dokumen_masuk_url');

        });

        $(document).on("click", ".upload-arsip-keluar", function(e) {
            pond.removeFiles();
            var title = $(this).data('title');
            $("#judul-modal").html('Upload Arsip Keluar');
            $('.arsip-masuk-box').hide();
            $('.arsip-keluar-box').show();
            console.log('GlobalData');
            console.log(globalData);
            $('#modal_id_pelayanan').val(globalData.id_pelayanan);
            $('#modal_no_registrasi').val(globalData.no_registrasi);
            $('#modal_id_layanan').val(globalData.id_layanan).trigger('change');
            $('#modal_perihal').val(globalData.perihal);

            $('#tipe_upload').val('dokumen_keluar_url');

        });

        var globalData = null;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function searchData(id_pelayanan) {
            // $('body').block({
            //     message: `Loading...`
            // });

            setTimeout(function() {

                $.ajax({
                    type: 'GET',
                    url: '/daftar-pelayanan/detail/' + id_pelayanan,
                    dataType: 'json', // let's set the expected response format
                    success: function(data) {
                        console.log('data');
                        console.log(data);
                        if (data.success) {

                            var item = data.data;
                            globalData = item;

                            $('#search_id_layanan').val(item.id_layanan).trigger('change');
                            $('#search_no_registrasi').val(item.no_registrasi);
                            $('#search_perihal').val(item.perihal);
                            $('#search_pemohon_no_surat').val(item.pemohon_no_surat);
                            $('#search_pemohon_tanggal_surat').val(item.pemohon_tanggal_surat);
                            $('#search_pemohon_nama').val(item.pemohon_nama);
                            $('#search_pemohon_alamat').val(item.pemohon_alamat);
                            $('#search_pemohon_no_hp').val(item.pemohon_no_hp);
                            $('#search_pengirim_nama').val(item.pengirim_nama);
                            $('#search_kelengkapan_syarat').val(item.kelengkapan_syarat)
                                .trigger('change');
                            $('#search_status_pelayanan').val(item.status_pelayanan)
                                .trigger(
                                    'change');
                            $('#search_catatan').val(item.catatan);




                            let boxmasuk = $('.arsip-masuk-output');
                            let masukUpload = $('.arsip-masuk-box-upload');

                            boxmasuk.empty();
                            var htmlmasuk = '';
                            if (item.arsip.dokumen_masuk_url) {
                                $.each(item.arsip.dokumen_masuk_url, function(key, item) {
                                    var item_url_secure = item.file_url.replace("http:", "https:");
                                    htmlmasuk += `<div class="badge bg-secondary me-1 text-start">
                                                        <a id="string_url"  href="javascript:void(0)" style="font-size:smaller;" class="text-white cetak-bukti-button" data-bs-toggle="modal" data-bs-target="#ExtralargeModal" data-cetak_bukti_link="https://docs.google.com/gview?embedded=true&url=${item_url_secure}" data-file_name="${item.filename}">
                                                            ${item.filename}
                                                        </a>
                                                </div>`
                                    // target="_blank"
                                });
                                if (item.status_pelayanan != 'Selesai') {
                                    htmlmasuk += `<span id="upload_arsip_masuk" class="badge bg-primary me-1 text-start upload-arsip-masuk" type="button" data-bs-toggle="modal" data-bs-target="#fModal" data-title="Edit Data Item Layanan"><i class="bi bi-folder-plus"></i> Tambah</span>`;
                                }

                                boxmasuk.append(htmlmasuk);
                                boxmasuk.show();
                                masukUpload.hide();
                            } else {
                                boxmasuk.append('-');
                                boxmasuk.hide();
                                masukUpload.show();

                            }

                            var boxkeluar = $('.arsip-keluar-output');
                            let keluarUpload = $('.arsip-keluar-box-upload');
                            boxkeluar.empty();
                            var htmlkeluar = '';
                            if (item.arsip.dokumen_keluar_url) {
                                $.each(item.arsip.dokumen_keluar_url, function(key, item) {
                                    var item_url_secure = item.file_url.replace("http:", "https:");
                                    htmlkeluar += `<div class="badge bg-secondary me-1 text-start">
                                                        <a id="string_url"  href="javascript:void(0)" style="font-size:smaller;" class="text-white cetak-bukti-button" data-bs-toggle="modal" data-bs-target="#ExtralargeModal" data-cetak_bukti_link="https://docs.google.com/gview?embedded=true&url=${item_url_secure}" data-file_name="${item.filename}">
                                                            ${item.filename}
                                                        </a>
                                                </div>`
                                    // target="_blank"
                                });

                                boxkeluar.append(htmlkeluar);
                                boxkeluar.show();
                                keluarUpload.hide();
                            } else {
                                boxkeluar.append('-');
                                boxkeluar.hide();
                                keluarUpload.show();
                            }


                            //
                            let boxlama = $('.arsip-lama-box');
                            if (item.arsip.arsip_masuk_url) {
                                boxlama.empty();
                                var arsipHTML = `<a href="${item.arsip.arsip_masuk_url}"  class="badge bg-primary" type="button" >Lihat Dokumen</a>`;
                                boxlama.append(arsipHTML);
                            }


                            // target="_blank"


                            // if (item.arsip.arsip_keluar_url) {
                            //     let arsipBox = $('.arsip-keluar-box');
                            //     arsipBox.empty();
                            //     var arsipHTML = `<a href="${item.arsip.arsip_keluar_url}" target="_blank" class="badge bg-primary" type="button" >Lihat Dokumen</a>`;
                            //     arsipBox.append(arsipHTML);
                            // }

                            let box = $('.disposisi-box');

                            var dHtml = '';
                            var urutan_disposisi = 0;
                            var countDisp = item.disposisi.length;
                            $.each(item.disposisi, function(i, item) {
                                urutan_disposisi++;
                                var date = item.created_at_short.substring(0, 11);
                                var time = item.created_at_short.substring(11, 20);
                                if (item.id_disposisi_parent == null) {

                                    dHtml += `<div class="activity-item d-flex">
                                            <div class="activite-label">${date} <br /> ${time}</div>
                                            <i class="bi bi-circle-fill activity-badge text-muted align-self-start"></i>
                                            <div class="activity-content">
                                                <div class="disp-name">
                                                    <span>${item.sender ? item.sender.name : 'Publik'} </span><br><span class="text-muted" style="font-size:smaller;"> ${item.sender ? item.sender.jabatan : 'Masyarakat'}</span><br>
                                                </div>
                                                <span>[${item.aksi_disposisi}]</span>
                                                
                                            </div>
                                        </div>`;
                                    if (countDisp == 1) {
                                        dHtml += `<div class="activity-item d-flex">
                                            <div class="activite-label">-</div>
                                            <i class="bi bi-circle-fill activity-badge text-muted align-self-start"></i>
                                            <div class="activity-content">
                                                <div class="disp-name">
                                                    <span>${item.recipient.name} </span><br><span class="text-muted" style="font-size:smaller;"> ${item.recipient.jabatan}</span><br>
                                                </div>
                                                <span class="aksi-disposisi">-</span>
                                            </div>
                                        </div>`;
                                    }
                                    // <span class="aksi-disposisi">[${item.aksi_disposisi.replace("_", " ")}]</span>
                                } else {
                                    dHtml += `<div class="activity-item d-flex">
                                            <div class="activite-label">${date} <br /> ${time}</div>
                                            <i class="bi bi-circle-fill activity-badge text-muted align-self-start"></i>
                                            <div class="activity-content">
                                                <div class="disp-name">
                                                    <span>${item.sender.name} </span><br><span class="text-muted" style="font-size:smaller;"> ${item.sender.jabatan}</span><br>
                                                </div>
                                                <div class="disp-name mt-1">
                                                    <span>[${item.aksi_disposisi}]</span><br>
                                                    <span class="text-muted" style="font-size:smaller;">${item.keterangan == null ? '' : item.keterangan}</span>
                                                </div>
                                                
                                            </div>
                                        </div>`;
                                    if (i + 1 == countDisp) {
                                        if (item.recipient) {
                                            // Do Nothing
                                            dHtml += `<div class="activity-item d-flex">
                                                        <div class="activite-label">-</div>
                                                        <i class="bi bi-circle-fill activity-badge text-muted align-self-start"></i>
                                                        <div class="activity-content">
                                                            <div class="disp-name">
                                                                <span>${item.recipient.name} </span><br><span class="text-muted" style="font-size:smaller;"> ${item.recipient.jabatan}</span><br>
                                                            </div>
                                                            <span class="aksi-disposisi">-</span>
                                                        </div>
                                                    </div>`;
                                        }
                                    }
                                }

                            });

                            box.empty();
                            box.append(dHtml);


                            // Lembar Disposisi
                            var primary = data.primary;
                            if (primary.bisa_disposisi) {
                                $('.lembar-disposisi').show();
                                $('#id_disposisi_parent').val(primary.disposisiCurr.id_disposisi);
                                $('#id_pelayanan').val(item.id_pelayanan);
                                $('#urutan_disposisi').val(urutan_disposisi + 1);
                            } else {
                                $('.lembar-disposisi').hide();
                            }

                        } else {
                            Swal.fire(
                                'Error!', data.message, 'error'
                            );
                        }

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

                // $('body').unblock();
                $('#inputSection').removeClass('show');
                $('#searchSection2').fadeIn("slow");
            }, 1500);
        }

        $('.select2').select2({
            theme: 'bootstrap-5',
        });

        $(document).ready(function() {

            $(document).on("click", ".cetak-bukti-button", function() {
                var cetakBuktiLink = $(this).data('cetak_bukti_link');
                var fileName = $(this).data('file_name');
                $('#cetak-bukti-link').attr('src', cetakBuktiLink);
                $('.cetak-title').html(fileName);
            });

            searchData('{{ $id_pelayanan }}');

            function fetchSyarat(id_layanan) {

                // $('.template-syarat').block({
                //     message: '',
                // });

                setTimeout(function() {
                    $.ajax({
                        url: '/syarat-layanan/list/fetch/' + id_layanan,
                        method: 'get'
                    }).done(function(res) {
                        console.log('res');
                        console.log(res);



                        var htmlData = `<ol>`;
                        $.each(res.data, function(key, item) {
                            htmlData += `<li>${item.name}</li>`
                        });

                        htmlData += `</ol>`;

                        $('#message-syarat').html(htmlData);
                        $('.template-syarat').fadeIn("slow");
                        $('.template-syarat').unblock();
                    });

                }, 300)
            }

            $('#dForm').validate({
                lang: 'id', // or whatever language option you have.
                ignore: [],
                rules: {
                    id_aksi_disposisi: {
                        required: true,
                    },
                },
                errorElement: 'div',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            $("select").on("select2:close", function(e) {
                console.log('masuk validasi select2');
                console.log($(this).val());
                console.log($(this).valid());
            });

            $("#saveDisposisiBtn").on("click", function(event) {
                event.preventDefault();
                console.log($("#dForm").valid());

                if ($("#dForm").valid()) {

                    $('#dForm').block({
                        message: `Loading...`
                    });

                    setTimeout(function() {

                        var formdata = $("#dForm")
                            .serialize(); // here $(this) refere to the form its submitting
                        console.log(formdata);
                        url = $('#dForm').attr('action');

                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: formdata, // here $(this) refers to the ajax object not form
                            dataType: 'json', // let's set the expected response format
                            success: function(data) {

                                console.log(data);
                                if (data.success) {
                                    Swal.fire(
                                        'Mantap!',
                                        'Data Pelayanan berhasil disimpan!',
                                        'success'
                                    );

                                    var notifData = [
                                        data.recipient, data.disposisi
                                    ];
                                    // if (!(typeof socket === "undefined")) {
                                    socket.emit('sendNotifToServer', notifData);
                                    // }
                                    searchData('{{ $id_pelayanan }}');
                                    fetchSummary();
                                } else {
                                    Swal.fire(
                                        'Perhatian!', data.message,
                                        'warning'
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
                                    $.each(err.responseJSON.errors,
                                        function(i, error) {
                                            var el = $(document).find(
                                                '[name="' +
                                                i + '"]');
                                            el.after($('<span class="ajax-invalid" style="color: red;">' +
                                                error[0] +
                                                '</span>'));
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

                    }, 1500);
                }
            });

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
                            Swal.fire(
                                'Great!', 'Data sukses di update!', 'success'
                            );
                            if (!(typeof socket === "undefined")) {
                                socket.emit('sendSummaryToServer', data.summary);
                            }

                            searchData('{{ $id_pelayanan }}');
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
    </script>



@endsection
