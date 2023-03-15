<!-- Modal -->
<div class="modal fade" id="create-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="store-image-form" action="{{ route('admin.media.slide.store') }}" method="post" novalidate enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Unggah Slide</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <img id="image-src-0" class="rounded img-fluid mb-3" src="{{ asset('assets/admin/images/placeholders/cover.jpg') }}" alt="Placeholder">

                    <div class="mb-3">
                        <label for="header" class="form-label">Judul</label>
                        <input type="text" id="header" name="header" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="subheader" class="form-label">Sub Judul</label>
                        <input type="text" id="subheader" name="subheader" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="desc" class="form-label">Keterangan Slide</label>
                        <textarea id="desc" name="desc" rows="4" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Unggah Gambar</label>
                        <input id="image" type="file" class="form-control upload-img" name="image" data-id="0">
                        <div class="form-text text-muted">Format: gif, png, jpg, jpeg, bmp, svg, webp. Ukuran maks: 2Mb.</div>
                    </div>

                    <label for="position" class="form-label">Posisi Gambar</label>
                    <div>
                        <label class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="position" value="top" checked>
                            <span class="form-check-label">Atas</span>
                        </label>

                        <label class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="position" value="center">
                            <span class="form-check-label">Tengah</span>
                        </label>

                        <label class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="position" value="bottom">
                            <span class="form-check-label">Bawah</span>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tutup</button>
                    <button class="btn btn-indigo">Unggah</button>
                </div>
            </form>
        </div>
    </div>
</div>
