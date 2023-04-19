<select id="institute_id" name="institute_id" class="form-control select @error('institute_id') is-invalid @enderror">
    <option value="">Pilih Pemrakarsa</option>
    @foreach ($institutes as $key => $value)     
        <option value="{{ $key }}" @selected($selectedId == $key)>{{ $value }}</option>          
    @endforeach
</select>