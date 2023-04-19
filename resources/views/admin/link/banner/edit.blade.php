
<form class="update-banner-form" action="{{ route('admin.link.banner.update', $banner->id) }}" method="post" novalidate enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <input type="hidden" name="type" value="{{ $banner->type }}">
    <div class="modal-header">
        <h5 class="modal-title">Ubah Banner</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <img id="image-src-{{ $banner->image_id }}" class="rounded img-fluid mb-3 mx-auto d-block" src="{{ $banner->image->thumbSource }}" alt="Placeholder">

        <div class="mb-3">
            <label for="image" class="form-label">Unggah Gambar:</label>
            <input id="image" type="file" class="form-control upload-img" name="image" data-id="{{ $banner->image_id }}" >
            <div class="form-text text-muted">Format: gif, png, jpg, jpeg, bmp, svg, webp. Ukuran maks: 2Mb.</div>
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Judul:</label>
            <input id="title" type="text" class="form-control" name="title" value="{{ $banner->title }}">
        </div>

        <div class="mb-3">
            <label for="url" class="form-label">URL:</label>
            <input id="url" type="url" class="form-control" name="url" value="{{ $banner->url }}">
        </div>

        <div class="mb-3">
            <label for="desc" class="form-label">Keterangan Banner:</label>
            <textarea id="desc" name="desc" rows="4" class="form-control mb-3">{{ $banner->desc }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Tampilan:</label>
            <div>
                <div class="form-check form-check-inline form-check-reverse">
                    <input type="radio" class="form-check-input" name="display" value="main" @checked($banner->display == 'main')>
                    <label class="form-check-label">Utama</label>
                </div>

                <div class="form-check form-check-inline form-check-reverse">
                    <input type="radio" class="form-check-input" name="display" value="aside" @checked($banner->display == 'aside')>
                    <label class="form-check-label">Samping</label>
                </div>

                <div class="form-check form-check-inline form-check-reverse">
                    <input type="radio" class="form-check-input" name="display" value="popup" @checked($banner->display == 'popup')>
                    <label class="form-check-label">Popup</label>
                </div>
            </div>
        </div>

        <div class="form-check form-check-inline form-check-reverse">
            <input type="checkbox" class="form-check-input" id="publication" name="publication" @checked($banner->published_at)>
            <label class="form-check-label" for="publication">Tayang:</label>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tutup</button>
        <button class="btn btn-indigo">Ubah</button>
    </div>
</form>
