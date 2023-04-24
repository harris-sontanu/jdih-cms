
<form id="update-institute-form" action="{{ route('admin.legislation.institute.update', $institute->id) }}" method="post">
    @method('PUT')
    @csrf
    <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title">Ubah Pemrakarsa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ $institute->name }}" placeholder="Biro Hukum Setda Provinsi Bali">
        </div>
        <div class="mb-3">
            <label for="abbrev" class="form-label">Singkatan</label>
            <input type="text" class="form-control" name="abbrev" id="abbrev" value="{{ $institute->abbrev }}" placeholder="BIRO HUKUM">
        </div>
        <div class="mb-3">
            <label for="code" class="form-label">Kode</label>
            <input type="text" class="form-control" name="code" id="code" value="{{ $institute->code }}">
        </div>
        <div class="mb-0">
            <label for="desc" class="form-label">Deskripsi</label>
            <textarea name="desc" id="desc" class="form-control" rows="4">{{ $institute->desc }}</textarea>
        </div>
    </div>
    <div class="modal-footer border-top-0 -pt-0">
        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-indigo">Ubah</button>
    </div>
</form>