<div class="modal fade" id="menuModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTitle">Tambah Menu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="menuForm" action="{{ route('pengaturan-menu.store') }}" method="POST">
                @csrf
        
                <div class="modal-body">

                    <input type="hidden" name="id" id="menu_id">

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Nama Menu <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" name="name" id="name" class="form-control" required placeholder="Contoh: Dashboard">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Icon</label>
                        <div class="col-sm-9">
                            <input type="text" name="icon" id="icon" class="form-control" placeholder="Contoh: bi bi-house-door">
                            <small class="text-muted">
                                Gunakan Bootstrap Icons → <a href="https://icons.getbootstrap.com/" target="_blank">Lihat Icon</a>
                            </small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">URL Menu</label>
                        <div class="col-sm-9">
                            <input type="text" name="url" id="url" class="form-control" placeholder="/dashboard">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Parent Menu</label>
                        <div class="col-sm-9">
                            <select name="parent_id" id="parent_id" class="form-select select2">
                                <option value="">Menu Utama</option>
                                @foreach($parents as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Biarkan kosong jika menu utama</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Order</label>
                        <div class="col-sm-9">
                            <input type="number" name="order" id="order" class="form-control" value="0">
                        </div>
                    </div>

                </div> {{-- modal-body --}}

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" id="saveMenuBtn" class="btn btn-primary">Simpan</button>
                </div>

            </form>

        </div>
    </div>
</div>
