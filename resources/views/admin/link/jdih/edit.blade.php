
<form class="update-jdih-form" action="{{ route('admin.link.jdih.update', $jdih->id) }}" method="post" novalidate enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <input type="hidden" name="type" value="{{ $jdih->type }}">
    <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title">Ubah Anggota JDIH</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <img id="image-src-{{ $jdih->image_id }}" class="rounded img-fluid mb-3 mx-auto d-block" src="{{ $jdih->image->thumbSource }}" alt="Placeholder">

        <div class="mb-3">
            <label for="media" class="form-label">Unggah Gambar:</label>
            <input id="media" type="file" class="form-control upload-img" name="image" data-id="{{ $jdih->image_id }}" >
            <div class="form-text text-muted">Format: gif, png, jpg, jpeg, bmp, svg, webp. Ukuran maks: 2Mb.</div>
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Judul:</label>
            <input id="title" type="text" class="form-control" name="title" value="{{ $jdih->title }}">
        </div>

        <div class="mb-3">
            <label for="url" class="form-label">URL:</label>
            <input id="url" type="url" class="form-control" name="url" value="{{ $jdih->url }}">
        </div>

        <div class="mb-3">
            <label for="desc" class="form-label">Keterangan:</label>
            <textarea id="desc" name="desc" rows="4" class="form-control mb-3">{{ $jdih->desc }}</textarea>
        </div>

        <div class="form-check form-check-inline form-check-reverse">
            <input type="checkbox" class="form-check-input" id="publication" name="publication" @checked($jdih->published_at)>
            <label class="form-check-label" for="publication">Tayang:</label>
        </div>
    </div>
    <div class="modal-footer border-top-0 pt-0">
        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tutup</button>
        <button class="btn btn-indigo">Ubah</button>
    </div>
</form>
