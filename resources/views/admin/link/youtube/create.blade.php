<!-- Modal -->
<div class="modal fade" id="create-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="store-youtube-form" action="{{ route('admin.link.youtube.store') }}" method="post" novalidate enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" value="youtube">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Tautan YouTube</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul</label>
                        <input id="title" type="text" class="form-control" name="title">
                    </div>

                    <div class="mb-3">
                        <label for="url" class="form-label">URL</label>
                        <input id="url" type="url" class="form-control" name="url">
                        <div class="form-text text-muted">Contoh: https://youtu.be/rzNzJZ5AQO0</div>
                    </div>

                    <div class="mb-3">
                        <label for="desc" class="form-label">Keterangan</label>
                        <textarea id="desc" name="desc" rows="4" class="form-control mb-3"></textarea>
                    </div>

                    <div class="form-check form-check-inline form-check-reverse">
                        <input type="checkbox" class="form-check-input" id="publication" name="publication" checked>
                        <label class="form-check-label" for="publication">Tayangkan di Galeri Video</label>
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
