<!-- Tambah Group -->
<div class="modal fade" id="fModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <form id="fForm" method="post" action="{{ route('daftar-pelayanan.update') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span id="judul-modal"></span> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body modalBox">

                    {{ csrf_field() }}

                    <input type="hidden" name="id_pelayanan" id="search_id_pelayanan">
                    <div class="row card-body">
                        <div class="col-md-6 mb-3">
                            <label for="search_no_registrasi" class="form-label fw-bold">No Registrasi</label>
                            <input class="form-control" name="no_registrasi" id="search_no_registrasi" type="text" value="" placeholder="No Registrasi" disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="search_id_layanan" class="form-label fw-bold">Nama Layanan</label>
                            <select name="id_layanan" id="search_id_layanan" class="form-control select2">
                                <option selected="">Pilih Layanan</option>
                                @foreach ($daftar_layanan as $layanan)
                                    <option value="{{ $layanan->id_layanan }}">{{ $layanan->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="search_pemohon_no_surat" class="form-label fw-bold">Perihal</label>
                            <input class="form-control" name="perihal" id="search_perihal" type="text" value="" placeholder="Perihal">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="search_pemohon_no_surat" class="form-label fw-bold">No. Surat
                                Permohonan</label>
                            <input class="form-control" name="pemohon_no_surat" id="search_pemohon_no_surat" type="text" placeholder="Nomor Surat" value="">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="search_pemohon_tanggal_surat" class="form-label fw-bold">Tanggal Surat
                                Permohonan</label>
                            <input type="date" class="form-control" name="pemohon_tanggal_surat" id="search_pemohon_tanggal_surat" placeholder="Tanggal Surat">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="search_pemohon_nama" class="form-label fw-bold">Nama Pemohon</label>
                            <input class="form-control" name="pemohon_nama" id="search_pemohon_nama" type="text" placeholder="Nama Pemohon" value="">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="search_pemohon_alamat" class="form-label fw-bold">Alamat
                                Pemohon</label>
                            <input class="form-control" name="pemohon_alamat" id="search_pemohon_alamat" type="text" placeholder="Alamat Pemohon" value="">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="search_pemohon_no_hp" class="form-label fw-bold">No. HP
                                Pemohon</label>
                            <input class="form-control" name="pemohon_no_hp" id="search_pemohon_no_hp" type="text" placeholder="Nomor HP Pemohon" value="">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="search_pengirim_nama" class="form-label fw-bold">Nama Pengirim</label>
                            <input class="form-control" name="pengirim_nama" id="search_pengirim_nama" type="text" placeholder="Nama Pengirim" value="">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="search_kelengkapan_syarat" class="form-label fw-bold">Kelengkapan
                                Syarat</label>
                            <select name="kelengkapan_syarat" id="search_kelengkapan_syarat" class="form-control select2" @if (!Auth::user()->hasRole('super_administrator')) disabled="disabled" @endif>
                                <option selected="">-- Pilih Kelengkapan Syarat --</option>
                                <option value="Sudah Lengkap">Sudah Lengkap</option>
                                <option value="Belum Lengkap">Belum Lengkap</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="search_status_pelayanan" class="form-label fw-bold">Status
                                Pelayanan</label>
                            <select name="status_pelayanan" id="search_status_pelayanan" class="form-control select2" @if (!Auth::user()->hasRole('super_administrator')) disabled="disabled" @endif>
                                <option selected="">-- Pilih Status Layanan --</option>
                                <option value="Baru">Baru</option>
                                <option value="Proses">Proses</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Ambil">Ambil</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="search_catatan" class="form-label fw-bold">Catatan</label>
                            <textarea class="form-control" style="height: 100px" name="catatan" id="search_catatan"></textarea>
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


<div class="modal fade" id="ExtralargeModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cetak Bukti Pendaftaran Pelayanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mx-2 my-2">
                    <iframe id="cetak-bukti-link" class="responsive-iframe" src="" frameborder="0"></iframe>
                </div>

            </div>
        </div>
    </div>
</div><!-- End Extra Large Modal-->
