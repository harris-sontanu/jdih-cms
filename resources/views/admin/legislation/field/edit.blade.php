
<form id="update-field-form" action="{{ route('admin.legislation.field.update', $field->id) }}" method="post">
    @method('PUT')
    @csrf
    <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title">Ubah Bidang Hukum</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ $field->name }}" placeholder="Hukum Pidana">
        </div>
        <label for="desc" class="form-label">Deskripsi</label>
        <textarea name="desc" id="desc" class="form-control" rows="4">{{ $field->desc }}</textarea>
    </div>
    <div class="modal-footer border-top-0 pt-0">
        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-indigo">Ubah</button>
    </div>
</form>
