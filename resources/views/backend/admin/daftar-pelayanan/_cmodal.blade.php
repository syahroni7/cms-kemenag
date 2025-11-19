<div class="modal fade" id="ExtralargeModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cetak Bukti Pendaftaran Pelayanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-print">
                <div class="mx-2 my-2">
                    <iframe id="cetak-bukti-link" class="responsive-iframe" src="" frameborder="0"></iframe>
                </div>

            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> --}}
        </div>
    </div>
</div><!-- End Extra Large Modal-->



<!-- Tambah Group -->
<div class="modal fade" id="arsipModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <form id="arsipForm" method="post" action="{{ route('arsip-pelayanan.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span id="judul-modal"></span> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body modalBox">

                    {{ csrf_field() }}

                    <input type="hidden" name="id_pelayanan" id="arsip_id_pelayanan">
                    <div class="row card-body">
                        <div class="col-md-6 mb-3">
                            <label for="arsip_no_registrasi" class="form-label fw-bold">No Registrasi</label>
                            <input class="form-control" name="no_registrasi" id="arsip_no_registrasi" type="text" value="" placeholder="No Registrasi" disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="arsip_id_layanan" class="form-label fw-bold">Nama Layanan</label>
                            <select name="id_layanan" id="arsip_id_layanan" class="form-control select2" disabled="true">
                                <option selected="">Pilih Layanan</option>
                                @foreach ($daftar_layanan as $layanan)
                                    <option value="{{ $layanan->id_layanan }}">{{ $layanan->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="arsip_perihal" class="form-label fw-bold">Perihal</label>
                            <input class="form-control" name="perihal" id="arsip_perihal" type="text" value="" placeholder="Perihal" disabled>
                        </div>


                        <div class="col-md-12 mb-3 arsip-masuk-box">
                            <label for="arsip_masuk_url" class="form-label fw-bold">Arsip Masuk</label><br>
                            {{-- Arsip Box --}}
                            <div id="arsip-masuk-filebox" class="masuk-img" style="display: none">
                                <img class="img-fluid" id="arsip-masuk-src" src="" alt="" width="200">
                            </div>
                            {{-- End of Arsip Box --}}

                            <button id="upload_widget_opener_masuk" type="button" class="btn btn-secondary btn-sm upload_widget_opener_masuk">Upload</button>
                            <input type="hidden" id="arsip_masuk_url" name="arsip_masuk_url" value="" required>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button id="submitBtn" type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
