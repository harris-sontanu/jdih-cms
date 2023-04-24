<tr>
    <td class="text-center sequence">{{ $sequence }}</td>
    <input type="hidden" name="typeRelationship[]" value="{{ $type->value }}">
    @isset($status)    
        <td>
            {{ $status->label() }}
            <input type="hidden" name="statusRelationship[]" value="{{ $status->value }}">
        </td>
    @endisset
    <td>
        <a class="text-body fw-semibold" href="{{ route('admin.legislation.law.show', $law->id) }}">{{ $law->title }}</a>
        <input type="hidden" name="relatedTo[]" value="{{ $law->id }}">
    </td>
    <td>
        {{ $note }}
        <input type="hidden" name="noteRelationship[]" value="{{ $note }}">
    </td>
    <td class="text-center">
        <button
            type="button"
            class="btn btn-link p-0 text-body unlink-relationship"
            @isset($parent)
                data-route="{{ route('admin.legislation.law.relationship-destroy', $parent->id) }}"
                data-type="{{ $type->value }}"
                @isset($status) data-status="{{ $status->value }}" @endisset
                data-related="{{ $law->id }}"
            @endisset
            data-bs-popup="tooltip"
            title="Hapus Hubungan">
            <i class="ph-link-simple-break"></i>
        </button>
    </td>
</tr>
