<!-- Filter -->
<div class="card shadow-lg">
    <div class="sidebar-section-header">
        <h5 class="mb-0">Filter</h5>
    </div>
    <div class="sidebar-section-body pt-0">
        <form class="filter-form" action="{{ route('legislation.law.index') }}" method="get">
            <div class="mb-3">
                <label for="title" class="d-block form-label fw-semibold">Judul</label>
                <textarea name="title" id="title" rows="3" cols="20" class="form-control" placeholder="Contoh: covid-19">{{ Request::get('title') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="category" class="d-block form-label fw-semibold">Jenis / Bentuk</label>
                <select id="category" name="category" class="form-select select-search">
                    <option value="">Pilih Jenis</option>
                    @foreach ($categories as $key => $value)
                        <option value="{{ $key }}" @selected(Request::get('category') === $key OR (isset($category) AND $category->id === $key))>
                            {{ Str::title($value) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="code_number" class="d-block form-label fw-semibold">Nomor</label>
                <input type="text" name="code_number" id="code_number" class="form-control"
                    placeholder="Contoh: 3" value="{{ Request::get('code_number') }}">
            </div>

            <div class="mb-3">
                <label for="year" class="d-block form-label fw-semibold">Tahun</label>
                <input type="number" name="year" id="year" class="form-control"
                    placeholder="Contoh: 2022" value="{{ Request::get('year') }}">
            </div>

            <div class="mb-3">
                <label for="subject" class="d-block form-label fw-semibold">Subjek</label>
                <input type="text" name="subject" id="subject" class="form-control"
                    placeholder="Contoh: PUNGUTAN LIAR" value="{{ Request::get('subject') }}">
            </div>

            <div class="mb-3">
                <label for="field" class="d-block form-label fw-semibold">Bidang Hukum</label>
                <select id="field" name="field" class="form-select select-search">
                    <option value="">Pilih Bidang Hukum</option>
                    @foreach ($fields as $key => $value)
                        <option value="{{ $key }}" @selected(Request::get('field') === $key)>
                            {{ Str::title($value) }}</option>
                    @endforeach
                </select>
            </div>

            <button id="filterBtn" type="submit" class="btn btn-danger px-3 fw-semibold w-100">Cari</button>
        </form>
    </div>
</div>
<!-- /filter -->
