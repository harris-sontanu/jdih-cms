<select id="taxonomy_id" name="taxonomy_id" class="form-control select @error('taxonomy_id') is-invalid @enderror">
    <option value="">Pilih Kategori</option>
    @foreach ($taxonomies as $key => $value)
        <option value="{{ $key }}" @selected($selectedId == $key)>{{ $value }}</option>
    @endforeach
</select>
