<!-- Filter -->
<aside class="sidebar sidebar-component sidebar-expand-lg align-self-start shadow-lg ms-0 me-lg-3">

    <div class="sidebar-section sidebar-section-body d-flex align-items-center">
        <h5 class="mb-0">Filter</h5>
        <div class="ms-auto">
            <button type="button" class="btn btn-light border-transparent btn-icon rounded-pill btn-sm sidebar-mobile-secondary-toggle d-lg-none">
                <i class="ph-x"></i>
            </button>
        </div>
    </div>

    <div class="sidebar-section">
        <div class="sidebar-section-body pt-0">

            <div class="mb-3">
                <label class="d-block form-label fw-semibold">Judul</label>
                <textarea name="" id="" cols="30" rows="4" class="form-control" placeholder="Contoh: covid-19"></textarea>
            </div>

            <div class="mb-3">
                <label for="type" class="d-block form-label fw-semibold">Tipe</label>
                <select id="type" name="type" class="form-select select">
                    @foreach ($types as $key => $value)
                        <option value="{{ $key }}" @selected(Request::get('type') == $key)>{{ Str::title($value) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="category" class="d-block form-label fw-semibold">Jenis / Bentuk</label>
                <select id="category" name="category" class="form-select select-search">
                    <option value="">Pilih Jenis</option>
                    @foreach ($categories as $key => $value)
                        <option value="{{ $key }}" @selected(Request::get('category') == $key)>{{ Str::title($value) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="code_number" class="d-block form-label fw-semibold">Nomor</label>
                <input type="text" name="code_number" id="code_number" class="form-control" placeholder="Contoh: 3">
            </div>

            <div class="mb-3">
                <label for="year" class="d-block form-label fw-semibold">Tahun</label>
                <input type="number" name="year" id="year" class="form-control" placeholder="Contoh: 2022">
            </div>

            <div class="mb-3">
                <label for="subject" class="d-block form-label fw-semibold">Subjek</label>
                <input type="text" name="subject" id="subject" class="form-control" placeholder="Contoh: PUNGUTAN LIAR">
            </div>

            <div class="mb-3">
                <label for="field" class="d-block form-label fw-semibold">Bidang Hukum</label>
                <select id="field" name="field" class="form-select select-search">
                    <option value="">Pilih Bidang Hukum</option>
                    @foreach ($fields as $key => $value)
                        <option value="{{ $key }}" @selected(Request::get('field') == $key)>{{ Str::title($value) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="institute" class="d-block form-label fw-semibold">Pemrakarsa</label>
                <select id="institute" name="institute" class="form-select select-search">
                    <option value="">Pilih Pemrakarsa</option>
                    @foreach ($institutes as $key => $value)
                        <option value="{{ $key }}" @selected(Request::get('institute') == $key)>{{ Str::title($value) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="matters" class="d-block form-label fw-semibold">Urusan Pemerintahan</label>
                <select id="matters" name="matters[]" multiple="multiple" class="form-select select">
                    <option value="">Pilih Urusan Pemerintahan</option>
                    @foreach ($matters as $key => $value)
                        <option value="{{ $key }}" @selected(Request::get('matters') == $key)>{{ $value }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-danger px-3 fw-semibold w-100">Cari</button>
        </div>
    </div>
</aside>
<!-- /filter -->
