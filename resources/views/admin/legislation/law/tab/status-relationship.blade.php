<div class="card-body">

    <div class="alert alert-info border-0">
        Keterangan pelengkap dari status utama peraturan yang bertujuan memberikan informasi bahwa suatu peraturan telah dicabut atau pernah diubah oleh peraturan lain.
    </div>

    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#add-status-relation-modal"><i class="ph-link-simple me-2"></i>Tambah Keterangan Status</button>

</div>

<div class="table-responsive">
    <table id="status-relation-table" class="table">
        <thead>
            <tr>
                <th width="1" class="text-center">#</th>
                <th>Status</th>
                <th>Peraturan</th>
                <th>Keterangan</th>
                <th width="1" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody id="status-relation-table-body">
            @if(!empty($statusRelationships) AND count($statusRelationships) > 0)
                @php
                    $i = 1;
                @endphp
                @foreach ($statusRelationships as $relation)
                    <tr>
                        <td class="text-center sequence">{{ $i }}</td>
                        <td>
                            {{ Str::title($relation->status) }}
                            @empty($law)
                                <input type="hidden" name="statusOptions[]" value="{{ $relation->status }}">
                            @endempty
                        </td>
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
                                data-route="{{ route('admin.legislation.law.status-relationship-destroy', $relation->legislation_id) }}"
                                data-status="{{ $relation->status }}"
                                data-related="{{ $relation->related_to }}"
                                data-bs-popup="tooltip"
                                title="Hapus Hubungan">
                                <i class="ph-link-simple-break"></i>
                            </button>
                        </td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
            @else
                <tr class="table-warning">
                    <td colspan="5" class="text-center text-warning">Tidak ada data</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

