<!-- Modal -->
<div class="modal fade" id="create-modal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.user.store') }}" method="post">
                @csrf
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title">Tambah Operator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Nama Akun</label>
                        <input type="text" class="form-control" name="username" id="username" value="{{ old('username') }}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                    </div>
                    <div>
                        <label class="form-label">Level</label>
                        <select id="role" name="role" class="form-select">
                            <option value="">Pilih Level</option>
                            @foreach ($roles as $key => $value)
                                <option value="{{ $key }}" @selected(old('role') == $key)>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tutup</button>
                    <button id="save-btn" type="button" class="btn btn-indigo">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
