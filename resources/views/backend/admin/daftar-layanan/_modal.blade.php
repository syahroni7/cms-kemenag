<!-- Tambah Group -->
<div class="modal fade" id="fModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <form id="fForm" method="post" action="{{ route('daftar-layanan.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span id="judul-modal"></span> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body modalBox">

                    {{ csrf_field() }}

                    <div class="row card-body">
                        <div class="col-12">


                            <input type="hidden" name="id_layanan" id="id_layanan" value="">
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-3 col-form-label">Nama Layanan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Nama Layanan">
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="Comparator" class="col-sm-3 col-form-label">Unit Pengolah</label>
                                <div class="col-sm-9">
                                    <select name="id_unit_pengolah" id="id_unit_pengolah" class="form-control select2">
                                        <option selected="">Pilih Unit Pengolah</option>
                                        @foreach ($dd['unit_all'] as $unit)
                                            <option value="{{ $unit->id_unit_pengolah }}">{{ $unit->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="Comparator" class="col-sm-3 col-form-label">Jenis Layanan</label>
                                <div class="col-sm-9">
                                    <select name="id_jenis_layanan" id="id_jenis_layanan" class="form-control select2">
                                        <option selected="">Pilih Jenis Layanan</option>
                                        @foreach ($dd['jenis_all'] as $item)
                                            <option value="{{ $item->id_jenis_layanan }}">{{ $item->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="Comparator" class="col-sm-3 col-form-label">Output Layanan</label>
                                <div class="col-sm-9">
                                    <select name="id_output_layanan" id="id_output_layanan"
                                        class="form-control select2">
                                        <option selected="">Pilih Output Layanan</option>
                                        @foreach ($dd['output_all'] as $item)
                                            <option value="{{ $item->id_output_layanan }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>



                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-3 col-form-label">Lama Layanan</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Lama Layanan"
                                            aria-label="Lama Layanan" aria-describedby="basic-addon2" id="lama_layanan"
                                            name="lama_layanan">
                                        <span class="input-group-text" id="basic-addon2">Dalam Hari</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-3 col-form-label">Biaya Layanan</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Biaya Layanan"
                                            aria-label="Biaya Layanan" aria-describedby="basic-addon2"
                                            id="biaya_layanan" name="biaya_layanan">
                                        <span class="input-group-text" id="basic-addon2">Dalam Rupiah</span>
                                    </div>
                                </div>
                            </div>


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
