
<form action="{{ route('admin.legislation.matter.update', $matter->id) }}" method="post">
    @method('PUT')
    @csrf
    <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title">Ubah Urusan Pemerintahan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ $matter->name }}" placeholder="Pendidikan">
        </div>
        <div class="mb-0">
            <label for="desc" class="form-label">Deskripsi</label>
            <textarea name="desc" id="desc" class="form-control" rows="4" placeholder="Manajemen pendidikan, kurikulum, akreditasi, pendidik dan tenaga kependidikan, perizinan pendidikan, serta bahasa dan sastra.">{{ $matter->desc }}</textarea>
        </div>
    </div>
    <div class="modal-footer border-top-0 pt-0">
        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tutup</button>
        <button id="update-btn" data-id="{{ $matter->id }}" type="button" class="btn btn-indigo">Ubah</button>
    </div>
</form>