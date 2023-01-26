<div class="card-body">

    <div class="alert alert-info border-0">
        Dokumen pendukung pembentukan peraturan tersebut. Contoh: Kajian Hukum.
    </div>

    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#add-doc-relation-modal"><i class="ph-link-simple me-2"></i>Tambah Dokumen Terkait</button>

</div>

<div class="table-responsive">
    <table id="document-relation-table" class="table">
        <thead>
            <tr>
                <th width="1" class="text-center">#</th>
                <th>Jenis</th>
                <th>Dokumen</th>
                <th>Keterangan</th>
                <th width="1" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody id="doc-relation-table-body">
            @if(!empty($documentRelationships) AND count($documentRelationships) > 0)
                @php
                    $i = 1;
                @endphp
                @foreach ($documentRelationships as $relation)
                    <tr>
                        <td class="text-center sequence">{{ $i }}</td>
                        <td>{{ $relation->relatedTo->category->name }}</td>
                        <td>
                            <a class="text-body fw-semibold" href="{{ route('admin.legislation.'.$relation->relatedTo->category->type->route.'.show', $relation->relatedTo) }}">{{ $relation->relatedTo->title }}</a>
                            @empty($law)
                                <input type="hidden" name="docRelatedTo[]" value="{{ $relation->related_to }}">
                            @endempty
                        </td>
                        <td>
                            {{ $relation->note }}
                            @empty($law)
                                <input type="hidden" name="docRelatedNote[]" value="{{ $relation->note }}">
                            @endempty
                        </td>
                        <td class="text-center">
                            <button
                                type="button"
                                class="btn btn-link p-0 text-body unlink-relationship"
                                data-route="{{ route('admin.legislation.law.doc-relationship-destroy', $relation->legislation_id) }}"
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
