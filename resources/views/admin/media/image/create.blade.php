<!-- Modal -->
<div class="modal fade" id="create-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="store-image-form" action="{{ route('admin.media.image.store') }}" method="post" novalidate enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Unggah Gambar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <img id="image-src-0" class="rounded img-fluid mb-3" src="{{ asset('assets/admin/images/placeholders/cover.jpg') }}" alt="Placeholder">

                    <div class="mb-3">
                        <label for="caption" class="form-label">Keterangan Gambar</label>
                        <textarea id="caption" name="caption" rows="4" class="form-control mb-3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="media" class="form-label">Unggah Gambar</label>
                        <input id="media" type="file" class="form-control upload-img" name="image" data-id="0">
                        <div class="form-text text-muted">Format: gif, png, jpg, jpeg, bmp, svg, webp. Ukuran maks: 2Mb.</div>
                    </div>

                    <div class="form-check form-check-inline form-check-reverse">
                        <input type="checkbox" class="form-check-input" id="publication" name="publication" checked>
                        <label class="form-check-label" for="publication">Tayangkan di Galeri Foto</label>
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
