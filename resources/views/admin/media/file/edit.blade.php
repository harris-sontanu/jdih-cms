<form class="update-file-form" action="{{ route('admin.media.file.update', $file->id) }}" method="post" novalidate enctype="multipart/form-data">
    @method('put')
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Ubah Berkas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="media" class="form-label">Unggah Berkas</label>
            <input id="media" type="file" class="form-control" name="file">
        </div>

        <div class="mb-3">
            <label for="caption" class="form-label">Keterangan Berkas</label>
            <textarea id="caption" name="caption" rows="4" class="form-control mb-3">{{ $file->caption }}</textarea>
        </div>

        <div class="form-check form-check-inline form-check-reverse">
            <input type="checkbox" class="form-check-input" id="publication" name="publication" @checked($file->published_at)>
            <label class="form-check-label" for="publication">Tayangkan di Ruang Unduh</label>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tutup</button>
        <button class="btn btn-indigo">Unggah</button>
    </div>
</form>
