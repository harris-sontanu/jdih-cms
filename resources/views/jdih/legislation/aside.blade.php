<!-- Filter -->
<aside class="sidebar sidebar-main sidebar-expand-lg align-self-start shadow-lg ms-0">

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
                <label class="d-block form-label fw-semibold">Tipe</label>
                <select class="form-select select">
                    @foreach ($types as $key => $value)
                        <option value="{{ $key }}" @selected(Request::get('type') == $key)>{{ Str::title($value) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="d-block form-label fw-semibold">Jenis / Bentuk</label>
                <select class="form-select select-search">
                    <option value="">Pilih Jenis</option>
                    @foreach ($categories as $key => $value)
                        <option value="{{ $key }}" @selected(Request::get('category') == $key)>{{ Str::title($value) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="d-block form-label fw-semibold">Bidang Hukum</label>
                <select class="form-select select-search">
                    <option value="">Pilih Bidang Hukum</option>
                    @foreach ($matters as $key => $value)
                        <option value="{{ $key }}" @selected(Request::get('matter') == $key)>{{ Str::title($value) }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-danger px-3 fw-semibold w-100">Cari</button>
        </div>
    </div>
</aside>
<!-- /filter -->