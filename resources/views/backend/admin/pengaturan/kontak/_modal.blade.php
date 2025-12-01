<div class="modal fade" id="fModal" tabindex="-1" aria-labelledby="judul-modal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content modalBox">
            <form id="fForm" method="POST" action="{{ route('pengaturan-kontak.store') }}">
                @csrf
                <input type="hidden" name="id" id="id" />

                <div class="modal-header">
                    <h5 class="modal-title" id="judul-modal">Tambah Kontak</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_kantor" class="form-label">Nama Kantor</label>
                        <input type="text" name="nama_kantor" id="nama_kantor" class="form-control" required />
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" name="telepon" id="telepon" class="form-control" />
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" />
                    </div>

                    <div class="mb-3">
                        <label for="jam_operasional" class="form-label">Jam Operasional</label>
                        <textarea name="jam_operasional" id="jam_operasional" class="form-control" rows="2"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" id="submitBtn" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>

            </form>
        </div>
    </div>
</div>