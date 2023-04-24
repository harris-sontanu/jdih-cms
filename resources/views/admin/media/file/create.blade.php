<!-- Modal -->
<div class="modal fade" id="create-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="store-file-form" action="{{ route('admin.media.file.store') }}" method="post" novalidate enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title">Unggah Berkas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="media" class="form-label">Unggah Berkas</label>
                        <input id="media" type="file" class="form-control" name="file">
                    </div>

                    <div class="mb-3">
                        <label for="caption" class="form-label">Keterangan</label>
                        <textarea id="caption" name="caption" rows="4" class="form-control mb-3"></textarea>
                    </div>

                    <div class="form-check form-check-inline form-check-reverse">
                        <input type="checkbox" class="form-check-input" id="publication" name="publication" checked>
                        <label class="form-check-label" for="publication">Tayangkan di Ruang Unduh</label>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tutup</button>
                    <button class="btn btn-indigo">Unggah</button>
                </div>
            </form>
        </div>
    </div>
</div>
