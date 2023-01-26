<div class="modal fade" id="add-doc-relation-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Dokumen Terkait</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="add-doc-relationship-form" action="{{ route('admin.legislation.law.doc-relationship-row') }}" method="POST">
                @csrf
                @if (!empty($law))
                    <input type="hidden" name="id" value="{{ $law->id }}">
                @endif
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="docRelatedTo" class="form-label">Cari Dokumen</label>
                        <select id="docRelatedTo" name="docRelatedTo" class="form-control select-search-docs @error('docRelatedTo') is-invalid @enderror">
                            <option value="">Cari dokumen</option>
                        </select>
                        @error('docRelatedTo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @endif
                    </div>
                    <div class="mb-0">
                        <label for="docRelatedNote" class="form-label @error('docRelatedNote') is-invalid @enderror">Keterangan</label>
                        <textarea id="docRelatedNote" name="docRelatedNote" rows="4" class="form-control"></textarea>                        
                        @error('docRelatedNote')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-indigo">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>