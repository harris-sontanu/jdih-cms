<div class="modal fade" id="add-status-relation-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Keterangan Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="add-status-relationship-form" action="{{ route('admin.legislation.law.status-relationship-row') }}" method="POST">
                @csrf
                @if (!empty($law))
                    <input type="hidden" name="id" value="{{ $law->id }}">
                @endif
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="statusOptions" class="form-label">Status</label>
                        <select id="statusOptions" name="statusOptions" class="form-select @error('statusOptions') is-invalid @enderror">
                            <option value="">Pilih Status</option>
                            @foreach ($statusOptions as $status)
                                <option value="{{ $status->value }}" @selected(old('statusOptions') == $status->value)>{{ Str::title($status->value) }}</option>
                            @endforeach
                        </select>
                        @error('statusOptions')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="statusRelatedTo" class="form-label">Cari Peraturan</label>
                        <select id="statusRelatedTo" name="statusRelatedTo" class="form-control select-laws-data @error('statusRelatedTo') is-invalid @enderror">
                            <option value="">Cari peraturan</option>
                        </select>
                        @error('statusRelatedTo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @endif
                    </div>
                    <div class="mb-0">
                        <label for="statusNote" class="form-label @error('statusNote') is-invalid @enderror">Keterangan</label>
                        <textarea id="statusNote" name="statusNote" rows="4" class="form-control"></textarea>                        
                        @error('statusNote')
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