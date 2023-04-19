<form class="update-youtube-form" action="{{ route('admin.link.youtube.update', $youtube->id) }}" method="post" novalidate enctype="multipart/form-data">
    @method('put')
    @csrf
    <input type="hidden" name="type" value="{{ $youtube->type }}">
    <div class="modal-header">
        <h5 class="modal-title">Ubah Tautan YouTube</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input id="title" type="text" class="form-control" name="title" value="{{ $youtube->title }}">
        </div>

        <div class="mb-3">
            <label for="url" class="form-label">URL</label>
            <input id="url" type="url" class="form-control" name="url" value="{{ $youtube->url }}">
            <div class="form-text text-muted">Contoh: https://youtu.be/rzNzJZ5AQO0</div>
        </div>

        <div class="mb-3">
            <label for="desc" class="form-label">Keterangan</label>
            <textarea id="desc" name="desc" rows="4" class="form-control mb-3">{{ $youtube->desc }}</textarea>
        </div>

        <div class="form-check form-check-inline form-check-reverse">
            <input type="checkbox" class="form-check-input" id="publication" name="publication" @checked($youtube->published_at)>
            <label class="form-check-label" for="publication">Tayangkan di Galeri Video</label>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tutup</button>
        <button class="btn btn-indigo">Unggah</button>
    </div>
</form>
