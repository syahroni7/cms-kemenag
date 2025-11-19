<!-- Tambah Group -->
<div class="modal fade" id="fModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <form id="fForm" method="post" action="{{ route('arsip-pelayanan.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span id="judul-modal"></span> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body modalBox">

                    {{ csrf_field() }}

                    <input type="hidden" name="id_pelayanan" id="modal_id_pelayanan">
                    <div class="row card-body">
                        <div class="col-md-6 mb-3">
                            <label for="modal_no_registrasi" class="form-label fw-bold">No Registrasi</label>
                            <input class="form-control" name="no_registrasi" id="modal_no_registrasi" type="text" value="" placeholder="No Registrasi" disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="modal_id_layanan" class="form-label fw-bold">Nama Layanan</label>
                            <select name="id_layanan" id="modal_id_layanan" class="form-control select2" disabled="true">
                                <option selected="">Pilih Layanan</option>
                                @foreach ($daftar_layanan as $layanan)
                                    <option value="{{ $layanan->id_layanan }}">{{ $layanan->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="modal_pemohon_no_surat" class="form-label fw-bold">Perihal</label>
                            <input class="form-control" name="perihal" id="modal_perihal" type="text" value="" placeholder="Perihal" disabled>
                        </div>


                        <div class="col-md-12 mb-3 arsip-masuk-box">

                            <div class="col-12">
                                <label for="pengirim_nama" class="form-label fw-bold">Dokumen Pendukung</label>
                            </div>

                        </div>

                        <div class="col-md-12 mb-3 arsip-keluar-box">

                            <div class="col-12">
                                <label for="pengirim_nama" class="form-label fw-bold">Output Layanan</label>
                            </div>

                        </div>

                        <div class="col-md-12 mb-3 upload-container">

                            <div class="col-12">
                                <input type="file" name="data_file[]" multiple required />
                                <p class="help-block">{{ $errors->first('data_file.*') }}</p>
                            </div>

                        </div>

                        <input type="hidden" name="tipe_upload" id="tipe_upload" value="">

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


<div class="modal fade" id="ExtralargeModal" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title cetak-title">-</h5>
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
