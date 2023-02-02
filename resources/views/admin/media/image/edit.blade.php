<form class="update-image-form" action="{{ route('admin.media.image.update', $image->id) }}" method="post" novalidate enctype="multipart/form-data">
    @method('put')
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Ubah Gambar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <img id="image-src-{{ $image->id }}" class="rounded img-fluid mb-3 mx-auto d-block" src="{{ $image->thumbSource }}">

        <div class="mb-3">
            <label for="caption" class="form-label">Judul</label>
            <input type="text" id="name" name="name" class="form-control mb-3" value="{{ $image->name }}">
        </div>

        <div class="mb-3">
            <label for="caption" class="form-label">Keterangan Gambar</label>
            <textarea id="caption" name="caption" rows="4" class="form-control mb-3">{{ $image->caption }}</textarea>
        </div>

        <div class="mb-3">
            <label for="media" class="form-label">Unggah Gambar</label>
            <input id="media" type="file" class="form-control upload-img" name="image" data-id="{{ $image->id }}">
            <div class="form-text text-muted">Format: gif, png, jpg, jpeg, bmp, svg, webp. Ukuran maks: 2Mb.</div>
        </div>

        <div class="form-check form-check-inline form-check-reverse">
            <input type="checkbox" class="form-check-input" id="publication" name="publication" @checked($image->published_at)>
            <label class="form-check-label" for="publication">Tayangkan di Galeri Foto</label>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tutup</button>
        <button class="btn btn-indigo">Unggah</button>
    </div>
</form>
