<div class="table-responsive">
    <table id="{{ $relationType }}-relation-table" class="table">
        <thead>
            <tr>
                <th width="1" class="text-center">#</th>
                @if ($relationType !== 'document')
                    <th>Status</th>
                @endif
                <th>Peraturan</th>
                <th>Keterangan</th>
                <th width="1" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody id="{{ $relationType }}-relation-table-body">
            @forelse ($relationships->byType($relationType) as $relation)
                <tr>
                    <td class="text-center sequence">{{ $loop->iteration }}</td>
                    @if ($relationType !== 'document')
                        <td>
                            {{ $relation->status->label() }}
                            @empty($law)
                                <input type="hidden" name="statusOptions[]" value="{{ $relation->status->value }}">
                            @endempty
                        </td>
                    @endif
                    <td>
                        <a class="text-body fw-semibold" href="{{ route('admin.legislation.law.show', $relation->relatedTo) }}">{{ $relation->relatedTo->title }}</a>
                        @empty($law)
                            <input type="hidden" name="statusRelatedTo[]" value="{{ $relation->related_to }}">
                        @endempty
                    </td>
                    <td>
                        {{ $relation->note }}
                        @empty($law)
                            <input type="hidden" name="statusNote[]" value="{{ $relation->note }}">
                        @endempty
                    </td>
                    <td class="text-center">
                        <button
                            type="button"
                            class="btn btn-link p-0 text-body unlink-relationship"
                            data-route="{{ route('admin.legislation.law.relationship-destroy', $relation->legislation_id) }}"
                            data-type = "{{ $relationType }}"
                            @if ($relationType !== 'document') data-status="{{ $relation->status->value }}" @endif
                            data-related="{{ $relation->related_to }}"
                            data-bs-popup="tooltip"
                            title="Hapus Hubungan">
                            <i class="ph-link-simple-break"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr class="table-warning">
                    <td colspan="5" class="text-center text-warning">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>