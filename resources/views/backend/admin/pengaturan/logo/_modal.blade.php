<div class="modal fade" id="fModal" tabindex="-1" aria-labelledby="fModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="fForm" action="{{ route('pengaturan-logo.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="id" name="id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="judul-modal">Tambah Logo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_logo" class="form-label">Nama Logo</label>
                        <input type="text" class="form-control" id="nama_logo" name="nama_logo" placeholder="Masukkan nama logo" required>
                    </div>

                    <div class="mb-3">
                        <label for="logo" class="form-label">Logo</label>
                        <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                        <div class="mt-2">
                            <img id="preview" src="" class="img-preview" alt="Preview Logo">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="submitBtn" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
