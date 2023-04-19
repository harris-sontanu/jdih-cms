<tr>
    <td class="text-center sequence">{{ $sequence }}</td>
    <td>
        {{ Str::title($status) }}
        <input type="hidden" name="statusOptions[]" value="{{ $status }}">
    </td>
    <td>
        <a class="text-body fw-semibold" href="{{ route('admin.legislation.law.show', $law->id) }}">{{ $law->title }}</a>
        <input type="hidden" name="statusRelatedTo[]" value="{{ $law->id }}">
    </td>
    <td>
        {{ $note }}
        <input type="hidden" name="statusNote[]" value="{{ $note }}">
    </td>
    <td class="text-center">
        <button
            type="button"
            class="btn btn-link p-0 text-body unlink-relationship"
            @if (!empty($parent))
                data-route="{{ route('admin.legislation.law.status-relationship-destroy', $parent->id) }}"
                data-status="{{ $status }}"
                data-related="{{ $law->id }}"
            @endif
            data-bs-popup="tooltip"
            title="Hapus Hubungan">
            <i class="ph-link-simple-break"></i>
        </button>
    </td>
</tr>
