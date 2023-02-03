
<form id="update-group-form" action="{{ route('admin.employee.group.update', $group->id) }}" method="post">
    @method('PUT')
    @csrf
    <input type="hidden" name="type" value="{{ $group->type }}">
    <div class="modal-header">
        <h5 class="modal-title">Ubah Grup Pegawai</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ $group->name }}" placeholder="Hukum Pidana">
        </div>
        <label for="desc" class="form-label">Deskripsi</label>
        <textarea name="desc" id="desc" class="form-control" rows="4">{{ $group->desc }}</textarea>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-indigo">Ubah</button>
    </div>
</form>
