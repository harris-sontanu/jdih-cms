<tr>
    <td class="text-center sequence">{{ $sequence }}</td>
    <td>{{ $doc->category->name }}</td>
    <td>
        <a class="text-body fw-semibold" href="{{ route('admin.legislation.'.$doc->category->type->route.'.show', $doc->id) }}">{{ $doc->title }}</a>
        <input type="hidden" name="docRelatedTo[]" value="{{ $doc->id }}">
    </td>
    <td>
        {{ $note }}
        <input type="hidden" name="docRelatedNote[]" value="{{ $note }}">
    </td>
    <td class="text-center">
        <button
            type="button"
            class="btn btn-link p-0 text-body unlink-relationship"
            @if (!empty($parent))
                data-route="{{ route('admin.legislation.law.doc-relationship-destroy', $parent->id) }}"
                data-related="{{ $doc->id }}"
            @endif
            data-bs-popup="tooltip"
            title="Hapus Hubungan">
            <i class="ph-link-simple-break"></i>
        </button>
    </td>
</tr>
