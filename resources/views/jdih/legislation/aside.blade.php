
<aside class="sidebar sidebar-component sidebar-expand-lg align-self-start bg-transparent shadow-none me-lg-3">

    <div class="sidebar-content">

        <!-- Filter -->
        <div class="card shadow-lg">
            <div class="sidebar-section-header">
                <h5 class="mb-0">Filter</h5>
            </div>
            <div class="sidebar-section-body pt-0">
                <form class="filter-form" action="{{ route('legislation.search') }}" method="get">
                    <div class="mb-3">
                        <label for="title" class="d-block form-label fw-semibold">Judul</label>
                        <input name="title" id="title" class="form-control" placeholder="Contoh: covid-19" value="{{ Request::get('title') }}" />
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
                        <input type="text" name="code_number" id="code_number" class="form-control" placeholder="Contoh: 3" value="{{ Request::get('code_number') }}">
                    </div>
    
                    <div class="mb-3">
                        <label for="year" class="d-block form-label fw-semibold">Tahun</label>
                        <input type="number" name="year" id="year" class="form-control" placeholder="Contoh: 2022" value="{{ Request::get('year') }}">
                    </div>
    
                    <div class="mb-3">
                        <label for="subject" class="d-block form-label fw-semibold">Subjek</label>
                        <input type="text" name="subject" id="subject" class="form-control" placeholder="Contoh: PUNGUTAN LIAR" value="{{ Request::get('subject') }}">
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
                        <label for="matter" class="d-block form-label fw-semibold">Urusan Pemerintahan</label>
                        <select id="matter" name="matter[]" multiple="multiple" class="form-select select">
                            @foreach ($matters as $key => $value)
                                <option value="{{ $key }}" @selected(Request::get('matter') == $key)>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
    
                    <button id="filterBtn" type="submit" class="btn btn-danger px-3 fw-semibold w-100">Cari</button>
                </form>
            </div>
        </div>
        <!-- /filter -->
        
        <div class="my-4">
            <h5 class="fw-bold">Monografi Hukum</h5>
            <div id="monograph-slider">
                @foreach ($popularMonographs as $monograph)    
                    <div class="card shadow-lg">
                        <a href="#">
                            <img class="card-img-top img-fluid" src="{{ $monograph->coverThumbSource }}" alt="">
                        </a>

                        <div class="card-body">
                            <h6 class="card-title mb-0">{{ $monograph->title }}</h6>
                            {{-- <p class="card-text mb-0"></p> --}}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
    
</aside>
