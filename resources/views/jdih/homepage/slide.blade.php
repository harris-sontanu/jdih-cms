<div class="profile-cover position-relative">

    <div id="carouselExampleFade" class="carousel slide carousel-fade overlay" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" style="background-image: url({{ asset('assets/jdih/images/demo/slide2.jpg') }}); background-position:bottom; min-height: 480px"></div>
            <div class="carousel-item" style="background-image: url({{ asset('assets/jdih/images/demo/slide1.jpg') }}); background-position:center; min-height: 480px"></div>
            <div class="carousel-item" style="background-image: url({{ asset('assets/jdih/images/demo/slide3.jpg') }}); background-position:center; min-height: 480px"></div>
            <div class="carousel-item" style="background-image: url({{ asset('assets/jdih/images/demo/slide4.jpg') }}); background-position:center; min-height: 480px"></div>
        </div>
    </div>

    <div class="container" style="margin-top: -480px; height: 480px; z-index: 2; position: relative;">
        <div class="content-wrapper">
            <div class="content">
                <div class="row gx-7">
                    <div class="col-xl-6">
                        <h2 class="fw-bold mt-5 text-white display-6">
                            Cari Produk Hukum <br />
                            <span class="typer fw-bold text-nowrap text-danger display-6" data-delay="100" data-words="peraturan,monografi hukum,artikel hukum,putusan pengadilan">peraturan</span>
                            <span class="cursor fw-bold text-danger display-6" data-owner="typer"></span>
                        </h2>
                        <h3 class="text-white">{{ $appDesc }}</h3>
                        <form class="filter-form" action="{{ route('legislation.index') }}" method="get">
                            <div class="navbar-search flex-fill position-relative mt-2 mt-lg-0 me-lg-3">
                                <div class="form-control-feedback form-control-lg form-control-feedback-start flex-grow-1">
                                    <input id="search-dropdown" name="title" type="text" autocomplete="false" autofocus class="form-control form-control-lg border-0 py-3" placeholder="Cari produk hukum..." data-bs-toggle="dropdown" value="{{ Request::get('title') }}">
                                    <div class="form-control-feedback-icon pt-3">
                                        <i class="ph-magnifying-glass"></i>
                                    </div>
                                    <div id="search-dropdown-results" class="dropdown-menu w-100" data-color-theme="light"></div>
                                </div>
                                <div class="position-static">
                                    <a href="#" class="navbar-nav-link align-items-center justify-content-center w-40px h-32px position-absolute end-0 top-50 translate-middle-y p-0 me-1" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                        <i class="ph-faders-horizontal"></i>
                                    </a>

                                    <div id="filter-dropdown-container" class="dropdown-menu w-100 p-3 dropdown-menu-end start-5">
                                        <div class="d-flex align-items-center mb-3">
                                            <h6 class="mb-0">Filter Pencarian Produk Hukum</h6>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="type" class="d-block form-label">Tipe</label>
                                                <select id="type" name="type" class="form-select select">
                                                    @foreach ($types as $key => $value)
                                                        <option value="{{ $key }}" @selected(Request::get('type') == $key)>{{ Str::title($value) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label class="form-label">Jenis / Bentuk</label>
                                                <select name="category" id="category" class="form-select select-search">
                                                    <option value="">Pilih Jenis</option>
                                                    @foreach ($categories as $key => $value)
                                                        <option value="{{ $key }}" @selected(Request::get('category') == $key)>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="code_number" class="form-label">Nomor</label>
                                                <input type="text" name="code_number" id="code_number" class="form-control" placeholder="Contoh: 12">
                                            </div>
                                            <div class="col">
                                                <label for="year" class="d-block form-label">Tahun</label>
                                                <input type="number" name="year" id="year" class="form-control" placeholder="Contoh: 2022">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="field" class="d-block form-label">Bidang Hukum</label>
                                                <select name="field" id="field" class="form-select select-search">
                                                    <option value="">Pilih Bidang Hukum</option>
                                                    @foreach ($fields as $key => $value)
                                                        <option value="{{ $key }}" @selected(Request::get('field') == $key)>{{ Str::title($value) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label for="institute" class="form-label">Pemrakarsa</label>
                                                <select name="institute" id="institute" class="form-select select-search">
                                                    <option value="">Pilih Pemrakarsa</option>
                                                    @foreach ($institutes as $key => $value)
                                                        <option value="{{ $key }}" @selected(Request::get('institute') == $key)>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="matters" class="form-label">Urusan Pemerintahan</label>
                                            <select id="matters" name="matters[]" multiple="multiple" class="form-select select">
                                                <option value="">Pilih Urusan Pemerintahan</option>
                                                @foreach ($matters as $key => $value)
                                                    <option value="{{ $key }}" @selected(Request::get('matters') == $key)>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <button type="submit" class="btn btn-danger w-100">Cari</button>
                                    </div>
                                </div>
                            </div>
                        </form> 
                        <a href="#" class="link-white mt-3 d-block fw-bold">Lihat semua Produk Hukum<i class="ph-arrow-right ms-2"></i></a>
                    </div>
                    <div class="col-xl-6 text-center">
                        <div class="row mt-5">
                            <div class="col">
                                <img src="{{ asset('assets/jdih/images/backgrounds/baliprov.png') }}" class="img-fluid" height="94">
                            </div>
                            <div class="col">
                                <img src="{{ asset('assets/jdih/images/backgrounds/gubwagub.png') }}" class="img-fluid" height="94">
                            </div>
                        </div>
                        <img src="{{ asset('assets/jdih/images/backgrounds/nangunsatkerthi2.png') }}" class="img-fluid mt-3 mb-4 px-5">
                        <h3 class="fw-bold text-white"><?php echo $company;?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
