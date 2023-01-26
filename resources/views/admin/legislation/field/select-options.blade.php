<select id="field_id" name="field_id" class="form-control select @error('field_id') is-invalid @enderror">
    <option value="">Pilih Bidang Hukum</option>
    @foreach ($fields as $key => $value)     
        <option value="{{ $key }}" @selected($selectedId == $key)>{{ $value }}</option>          
    @endforeach
</select>