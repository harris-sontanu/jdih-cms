<form id="update-document-form" action="{{ route('admin.legislation.document.update', $document->id) }}" method="post" enctype="multipart/form-data" novalidate>
    @method('PUT')
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Ubah Dokumen {{ $document->name }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        @if ($document->type === 'attachment')
            <div class="mb-3">
                <label for="order" class="form-label">Urutan Lampiran</label>
                <input type="number" name="order" id="order" class="form-control" value="{{ $document->order }}">
            </div>
        @endif
        <div class="mb-0">
            <label class="form-label">Dokumen</label>
            <input id="document" type="file" class="form-control" name="document">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-indigo">Unggah</button>
    </div>
</form>