<!-- Tambah Group -->
<div class="modal fade" id="fModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <form id="fForm" method="post" action="{{ route('user-data.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span id="judul-modal"></span> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body modalBox">

                    <div class="row card-body">
                        <div class="col-12">

                            <input type="hidden" name="id_user" id="id_user" value="">

                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-3 col-form-label">Pas Foto</label>
                                <div class="col-sm-9 profile">
                                    <div class="profile-edit">
                                        <img class="profile-edit" id="profile_photo_src" src="#" alt="Profile" style="max-width: 150px; display: none;">
                                    </div>
                                    <input type="file" class="form-control mt-2" id="profile_photo" name="profile_photo" accept="image/*">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-3 col-form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name" required>
                                    <div class="invalid-feedback">Nama lengkap harus diisi</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-3 col-form-label">Username / NIP <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="username" name="username" required>
                                    <div class="invalid-feedback">Username/NIP harus diisi</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-3 col-form-label">Email <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div class="invalid-feedback">Format email tidak valid</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-3 col-form-label">No HP <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="no_hp" name="no_hp" required pattern="[0-9]{10,}">
                                    <div class="invalid-feedback">No HP harus angka minimal 10 digit</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Peran Pengguna <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    @foreach ($all_roles as $role)
                                        <div class="form-check">
                                            <input class="form-check-input role-checkbox" type="checkbox" name="roles[]" value="{{ $role }}" id="role_{{ $loop->index }}">
                                            <label class="form-check-label" for="role_{{ $loop->index }}">{{ $role }}</label>
                                        </div>
                                    @endforeach
                                    <div class="invalid-feedback">Pilih minimal satu peran</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-3 col-form-label">Password <span class="text-danger create-required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password" name="password" minlength="6">
                                    <small class="text-muted edit-state">Kosongkan jika tidak ingin ubah password</small>
                                    <small class="text-muted create-state">Minimal 6 karakter</small>
                                    <div class="invalid-feedback create-state">Password harus diisi (minimal 6 karakter)</div>
                                </div>
                            </div>

                            <div class="row mb-3 edit-state">
                                <label for="inputText" class="col-sm-3 col-form-label">Block</label>
                                <div class="col-sm-9">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="block" id="block_yes" value="yes">
                                        <label class="form-check-label" for="block_yes">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="block" id="block_no" value="no" checked>
                                        <label class="form-check-label" for="block_no">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 edit-state">
                                <label for="inputText" class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status_active" value="active" checked>
                                        <label class="form-check-label" for="status_active">
                                            Aktif
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status_inactive" value="inactive">
                                        <label class="form-check-label" for="status_inactive">
                                            Tidak Aktif
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Info Last Login (Readonly) -->
                            <div class="row mb-3 edit-state">
                                <label for="inputText" class="col-sm-3 col-form-label">Terakhir Login</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control bg-light" id="last_login_info" readonly>
                                    <small class="text-muted">Informasi login terakhir user</small>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk reset form modal
    function resetModalForm() {
        document.getElementById('fForm').reset();
        document.getElementById('id_user').value = '';
        document.getElementById('profile_photo_src').style.display = 'none';
        document.getElementById('profile_photo_src').src = '#';
        document.getElementById('last_login_info').value = '';
        
        // Reset semua checkbox roles
        document.querySelectorAll('.role-checkbox').forEach(checkbox => {
            checkbox.checked = false;
        });
        
        // Reset radio buttons ke default
        document.getElementById('block_no').checked = true;
        document.getElementById('status_active').checked = true;
        
        // Hapus class invalid
        document.querySelectorAll('.is-invalid').forEach(element => {
            element.classList.remove('is-invalid');
        });
    }

    // Fungsi untuk mengisi form edit
    window.editUser = function(userId) {
        resetModalForm();
        
        // Show loading state
        document.getElementById('submitBtn').disabled = true;
        document.getElementById('submitBtn').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';

        fetch(`/user-data/${userId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const user = data.data;
                    
                    // Isi form dengan data user
                    document.getElementById('id_user').value = user.id;
                    document.getElementById('name').value = user.name || '';
                    document.getElementById('username').value = user.username || '';
                    document.getElementById('email').value = user.email || '';
                    document.getElementById('no_hp').value = user.no_hp || '';
                    
                    // Isi roles
                    if (user.roles && user.roles.length > 0) {
                        user.roles.forEach(role => {
                            const checkbox = document.querySelector(`input[name="roles[]"][value="${role.name}"]`);
                            if (checkbox) {
                                checkbox.checked = true;
                            }
                        });
                    }
                    
                    // Isi block status
                    if (user.block) {
                        document.getElementById(`block_${user.block}`).checked = true;
                    }
                    
                    // Isi status
                    if (user.status) {
                        document.getElementById(`status_${user.status}`).checked = true;
                    }
                    
                    // Isi last login info
                    if (user.last_login_at) {
                        const lastLogin = new Date(user.last_login_at);
                        const formattedDate = lastLogin.toLocaleDateString('id-ID', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                        document.getElementById('last_login_info').value = `${formattedDate} (IP: ${user.last_login_ip || 'N/A'})`;
                    } else {
                        document.getElementById('last_login_info').value = 'Belum pernah login';
                    }
                    
                    // Tampilkan foto jika ada
                    if (user.profile_photo) {
                        document.getElementById('profile_photo_src').src = user.profile_photo;
                        document.getElementById('profile_photo_src').style.display = 'block';
                    }
                    
                    // Ubah judul modal
                    document.getElementById('judul-modal').textContent = 'Edit Data Pengguna';
                    
                    // Tampilkan section edit
                    document.querySelectorAll('.edit-state').forEach(element => {
                        element.style.display = 'block';
                    });
                    document.querySelectorAll('.create-state').forEach(element => {
                        element.style.display = 'none';
                    });
                    document.querySelectorAll('.create-required').forEach(element => {
                        element.style.display = 'none';
                    });
                    
                } else {
                    alert('Gagal memuat data user');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memuat data');
            })
            .finally(() => {
                document.getElementById('submitBtn').disabled = false;
                document.getElementById('submitBtn').innerHTML = 'Simpan';
            });
    };

    // Fungsi untuk form tambah baru
    window.addNewUser = function() {
        resetModalForm();
        
        document.getElementById('judul-modal').textContent = 'Tambah Data Pengguna Baru';
        
        // Sembunyikan section edit
        document.querySelectorAll('.edit-state').forEach(element => {
            element.style.display = 'none';
        });
        document.querySelectorAll('.create-state').forEach(element => {
            element.style.display = 'block';
        });
        document.querySelectorAll('.create-required').forEach(element => {
            element.style.display = 'inline';
        });
        
        // Password required untuk create
        document.getElementById('password').required = true;
    };

    // Event listener untuk preview foto
    document.getElementById('profile_photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile_photo_src').src = e.target.result;
                document.getElementById('profile_photo_src').style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });

    // Event listener untuk submit form
    document.getElementById('submitBtn').addEventListener('click', function() {
        const form = document.getElementById('fForm');
        
        // Validasi manual untuk roles
        const roleChecked = document.querySelectorAll('.role-checkbox:checked').length > 0;
        if (!roleChecked) {
            document.querySelector('.role-checkbox').closest('.col-sm-9').classList.add('is-invalid');
            return;
        } else {
            document.querySelector('.role-checkbox').closest('.col-sm-9').classList.remove('is-invalid');
        }
        
        if (form.checkValidity()) {
            // Submit form via AJAX
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success === 'yeah') {
                    alert(data.message);
                    $('#fModal').modal('hide');
                    // Reload DataTables
                    if (typeof userTable !== 'undefined') {
                        userTable.ajax.reload();
                    }
                    location.reload(); // Fallback reload
                } else {
                    alert(data.message || 'Terjadi kesalahan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyimpan data');
            });
        } else {
            // Trigger HTML5 validation
            form.reportValidity();
        }
    });

    // Reset form ketika modal ditutup
    $('#fModal').on('hidden.bs.modal', function () {
        resetModalForm();
    });
});
</script>