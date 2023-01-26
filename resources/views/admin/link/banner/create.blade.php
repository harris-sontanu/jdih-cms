<!-- Modal -->
<div class="modal fade" id="create-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="store-banner-form" action="{{ route('admin.link.banner.store') }}" method="post" novalidate enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <img id="image-src-0" class="rounded img-fluid mb-3" src="{{ asset('assets/admin/images/placeholders/cover.jpg') }}" alt="Placeholder">

                    <div class="mb-3">
                        <label for="image" class="form-label">Unggah Gambar:</label>
                        <input id="image" type="file" class="form-control upload-img" name="image" data-id="0">
                        <div class="form-text text-muted">Format: gif, png, jpg, jpeg, bmp, svg, webp. Ukuran maks: 2Mb.</div>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Judul:</label>
                        <input id="title" type="text" class="form-control upload-img" name="title">
                    </div>

                    <div class="mb-3">
                        <label for="url" class="form-label">URL:</label>
                        <input id="url" type="url" class="form-control upload-img" name="url">
                    </div>

                    <div class="mb-3">
                        <label for="desc" class="form-label">Keterangan Banner:</label>
                        <textarea id="desc" name="desc" rows="4" class="form-control mb-3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tampilan:</label>
                        <div>
                            <div class="form-check form-check-inline form-check-reverse">
                                <input type="radio" class="form-check-input" name="display" value="main" checked>
                                <label class="form-check-label">Utama</label>
                            </div>

                            <div class="form-check form-check-inline form-check-reverse">
                                <input type="radio" class="form-check-input" name="display" value="aside">
                                <label class="form-check-label">Samping</label>
                            </div>

                            <div class="form-check form-check-inline form-check-reverse">
                                <input type="radio" class="form-check-input" name="display" value="popup">
                                <label class="form-check-label">Popup</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-check form-check-inline form-check-reverse">
                        <input type="checkbox" class="form-check-input" id="publication" name="publication" checked>
                        <label class="form-check-label" for="publication">Tayang:</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tutup</button>
                    <button class="btn btn-indigo">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
