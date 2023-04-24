<div class="modal fade" id="add-relation-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="add-relationship-form" action="{{ route('admin.legislation.law.show-relationship') }}" method="POST">
                @csrf
                <input id="relationType" type="hidden" name="type" value="">
                @isset ($law)
                    <input type="hidden" name="id" value="{{ $law->id }}">
                @endisset
                <div class="modal-body">
                    <div id="status-options-container" class="mb-3">
                        <label for="statusOptions" class="form-label">Status</label>
                        <select id="statusOptions" name="statusOptions" class="select2 @error('statusOptions') is-invalid @enderror">
                            <option value="">Pilih Status</option>
                            @foreach ($statusOptions as $status)
                                <option value="{{ $status->value }}" @selected(old('statusOptions') == $status->value)>{{ $status->label() }}</option>
                            @endforeach
                        </select>
                        @error('statusOptions')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="statusRelatedTo" class="form-label">Cari Monografi</label>
                        <select id="statusRelatedTo" name="statusRelatedTo" class="form-control @error('statusRelatedTo') is-invalid @enderror">
                            <option value="">Cari monografi</option>
                        </select>
                        @error('statusRelatedTo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-0">
                        <label for="statusNote" class="form-label @error('statusNote') is-invalid @enderror">Keterangan</label>
                        <textarea id="statusNote" name="statusNote" rows="4" class="form-control"></textarea>
                        @error('statusNote')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-indigo">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
