<form @if ($action == 'yearlyFilter') id="law-yearly-filter-form" @else id="law-monthly-filter-form" @endif class="form-horizontal">
    <div class="modal-body">
        
        @if ($action == 'yearlyFilter')
            <div class="row mb-3">
                <label class="col-form-label col-sm-3">Tahun</label>
                <div class="col-sm-9">
                    <select name="years[]" multiple="multiple" class="form-control select">
                        <option value="">Pilih Tahun</option>
                        @foreach ($yearOptions as $year)
                            <option value="{{ $year }}" @if (in_array($year, $selectedYears)) selected @endif>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>            
        @else            
            <div class="row mb-3">
                <label class="col-form-label col-sm-3">Tahun</label>
                <div class="col-sm-9">
                    <select name="year" class="form-control select">
                        <option value="">Pilih Tahun</option>
                        @foreach ($yearOptions as $year)
                            <option value="{{ $year }}" @if ($year == now()->format('Y') - 1) selected @endif>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif

        <div class="row mb-3">
            <label class="col-form-label col-sm-3">Jenis</label>
            <div class="col-sm-9">
                <select name="categories[]" multiple="multiple" class="form-control select">
                    <option value="">Pilih Jenis</option>
                    @foreach ($categories as $key => $value)
                        <option value="{{ $key }}" @if (in_array($key, $selectedCategories)) selected @endif>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">OK</button>
    </div>
</form>