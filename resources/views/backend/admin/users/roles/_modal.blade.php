<!-- Modal Tambah/Edit Role -->
<div class="modal fade" id="fModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <form id="fForm" method="post" action="{{ route('user-roles.store') }}">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">
            <input type="hidden" name="id_role" id="id_role" value="">
            
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roleModalLabel">
                        <span id="judul-modal">Tambah Data Level / Peran User</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body modalBox">
                    <div class="row">
                        <div class="col-12">
                            <!-- Nama Level -->
                            <div class="row mb-4">
                                <label for="name" class="col-sm-3 col-form-label">
                                    Nama Level User <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name" required
                                           placeholder="Masukkan nama level user (contoh: publisher, admin, user)">
                                    <div class="form-text">Contoh: super_administrator, publisher, editor</div>
                                    <div class="invalid-feedback" id="name-error"></div>
                                </div>
                            </div>

                            <!-- Permissions -->
                            <div class="row">
                                <label class="col-sm-3 col-form-label">
                                    Izin Akses <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-9">
                                    <div class="card">
                                        <div class="card-body">
                                            <!-- Menu Permissions -->
                                            @if(isset($permissions['menu']) && count($permissions['menu']) > 0)
                                            <div class="mb-4">
                                                <h6 class="card-title text-primary mb-3">
                                                    <i class="bi bi-list"></i> Menu Permissions
                                                </h6>
                                                <div class="row">
                                                    @foreach ($permissions['menu'] as $perm)
                                                        <div class="col-md-6 mb-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input permission-checkbox" 
                                                                       type="checkbox" 
                                                                       name="permissions[]" 
                                                                       value="{{ $perm->id }}" 
                                                                       id="perm_menu_{{ $perm->id }}">
                                                                <label class="form-check-label" for="perm_menu_{{ $perm->id }}">
                                                                    {{ str_replace('menu-', '', $perm->name) }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <hr>
                                            @endif

                                            <!-- Page Permissions -->
                                            @if(isset($permissions['page']) && count($permissions['page']) > 0)
                                            <div class="mb-4">
                                                <h6 class="card-title text-success mb-3">
                                                    <i class="bi bi-file-earmark"></i> Page Permissions
                                                </h6>
                                                <div class="row">
                                                    @foreach ($permissions['page'] as $perm)
                                                        <div class="col-md-6 mb-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input permission-checkbox" 
                                                                       type="checkbox" 
                                                                       name="permissions[]" 
                                                                       value="{{ $perm->id }}" 
                                                                       id="perm_page_{{ $perm->id }}">
                                                                <label class="form-check-label" for="perm_page_{{ $perm->id }}">
                                                                    {{ str_replace('page-', '', $perm->name) }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <hr>
                                            @endif

                                            <!-- Lainnya Permissions -->
                                            @if(isset($permissions['lainnya']) && count($permissions['lainnya']) > 0)
                                            <div class="mb-3">
                                                <h6 class="card-title text-warning mb-3">
                                                    <i class="bi bi-gear"></i> Operational Permissions
                                                </h6>
                                                <div class="row">
                                                    @foreach ($permissions['lainnya'] as $perm)
                                                        <div class="col-md-6 mb-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input permission-checkbox" 
                                                                       type="checkbox" 
                                                                       name="permissions[]" 
                                                                       value="{{ $perm->id }}" 
                                                                       id="perm_lainnya_{{ $perm->id }}">
                                                                <label class="form-check-label" for="perm_lainnya_{{ $perm->id }}">
                                                                    {{ $perm->name }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif

                                            <!-- Validation Message -->
                                            <div class="invalid-feedback" id="permissions-error">
                                                Pilih setidaknya satu permission
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                    <button id="submitBtn" type="button" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>