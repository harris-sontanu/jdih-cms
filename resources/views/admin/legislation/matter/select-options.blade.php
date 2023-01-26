<select id="matter" name="matter[]" multiple="multiple" class="form-control select @error('matter') is-invalid @enderror">
    <option value="">Pilih Bidang Urusan Pemerintahan</option>
    @foreach ($matters as $key => $value)
        @php
            $selected = false;
        @endphp
        @foreach ($selectedId as $id)
            @if ($id == $key)
                @php 
                    $selected = true; 
                @endphp 
            @endif 
        @endforeach      
        <option value="{{ $key }}" @selected($selected)>{{ $value }}</option>          
    @endforeach
</select>