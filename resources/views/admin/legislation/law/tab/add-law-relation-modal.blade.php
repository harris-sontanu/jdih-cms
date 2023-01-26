<div class="modal fade" id="add-law-relation-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Peraturan Terkait</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="add-law-relationship-form" action="{{ route('admin.legislation.law.law-relationship-row') }}" method="POST">
                @csrf
                @if (!empty($law))
                    <input type="hidden" name="id" value="{{ $law->id }}">
                @endif
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="lawRelationshipOptions" class="form-label">Status</label>
                        <select id="lawRelationshipOptions" name="lawRelationshipOptions" class="form-select @error('lawRelationshipOptions') is-invalid @enderror">
                            <option value="">Pilih Status</option>
                            @foreach ($lawRelationshipOptions as $key => $value)
                                <option value="{{ $key }}" @selected(old('lawRelationshipOptions') == $key)>{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('lawRelationshipOptions')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="lawRelatedTo" class="form-label">Cari Peraturan</label>
                        <select id="lawRelatedTo" name="lawRelatedTo" class="form-control select-search-laws @error('lawRelatedTo') is-invalid @enderror">
                            <option value="">Cari peraturan</option>
                        </select>
                        @error('lawRelatedTo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @endif
                    </div>
                    <div class="mb-0">
                        <label for="lawRelatedNote" class="form-label @error('lawRelatedNote') is-invalid @enderror">Keterangan</label>
                        <textarea id="lawRelatedNote" name="lawRelatedNote" rows="4" class="form-control"></textarea>                        
                        @error('lawRelatedNote')
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