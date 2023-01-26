<div class="card-body">

    <div class="alert alert-info border-0">
        Dasar yuridis pembentukan peraturan (lihat pada konsideran menimbang). Contoh: Peraturan Presiden Nomor 33 Tahun 2012.
    </div>

    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#add-law-relation-modal"><i class="ph-link-simple me-2"></i>Tambah Peraturan Terkait</button>

</div>

<div class="table-responsive">
    <table id="law-relation-table" class="table">
        <thead>
            <tr>
                <th width="1" class="text-center">#</th>
                <th>Status</th>
                <th>Peraturan</th>
                <th>Keterangan</th>
                <th width="1" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody id="law-relation-table-body">
            @if(!empty($lawRelationships) AND count($lawRelationships) > 0)
                @php
                    $i = 1;
                @endphp
                @foreach ($lawRelationships as $relation)
                    <tr>
                        <td class="text-center sequence">{{ $i }}</td>
                        <td>
                            {{ Str::title($relation->status) }}
                            @empty($law)
                                <input type="hidden" name="lawRelationshipOptions[]" value="{{ $relation->status }}">
                            @endempty
                        </td>
                        <td>
                            <a class="text-body fw-semibold" href="{{ route('admin.legislation.law.show', $relation->relatedTo) }}">{{ $relation->relatedTo->title }}</a>
                            @empty($law)
                                <input type="hidden" name="lawRelatedTo[]" value="{{ $relation->related_to }}">
                            @endempty
                        </td>
                        <td>
                            {{ $relation->note }}
                            @empty($law)
                                <input type="hidden" name="lawRelatedNote[]" value="{{ $relation->note }}">
                            @endempty
                        </td>
                        <td class="text-center">
                            <button 
                                type="button" 
                                class="btn btn-link p-0 text-body unlink-relationship" 
                                data-route="{{ route('admin.legislation.law.law-relationship-destroy', $relation->legislation_id) }}"
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