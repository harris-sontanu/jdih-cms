@extends('jdih.layouts.app')

@section('content')

<div class="profile-cover position-relative overlay">
    <div class="profile-cover-img bg-dark" style="background-image: url({{ asset('assets/jdih/images/demo/cover3.jpg') }}); min-height: 480px">
        <div class="container">
            <div class="content-wrapper">
                <div class="content position-relative">
                    <div class="row">
                        <div class="col-lg-6">
                            <h2 class="fw-bold mt-5 text-white" style="font-size: 2.5rem">
                                Cari Produk Hukum <br />
                                <span class="typer fw-bold text-nowrap text-danger" data-delay="100" data-words="peraturan,monografi hukum,artikel hukum,putusan pengadilan" style="font-size: 2.5rem">peraturan</span>
                                <span class="cursor fw-bold text-danger" data-owner="typer" style="font-size: 2.5rem"></span>
                            </h2>
                            <h3 class="text-white">{{ $appDesc }}</h3>
                            <div class="navbar-search flex-fill position-relative mt-2 mt-lg-0 me-lg-3">
                                <div class="form-control-feedback form-control-lg form-control-feedback-start flex-grow-1">
                                    <input type="text" class="form-control form-control-lg border-0 py-3" placeholder="Cari produk hukum..." data-bs-toggle="dropdown">
                                    <div class="form-control-feedback-icon pt-3">
                                        <i class="ph-magnifying-glass"></i>
                                    </div>
                                    <div class="dropdown-menu w-100">
                                        <button type="button" class="dropdown-item">
                                            <div class="text-center w-32px me-3">
                                                <i class="ph-magnifying-glass"></i>
                                            </div>
                                            <span>Search <span class="fw-bold">"in"</span> everywhere</span>
                                        </button>

                                        <div class="dropdown-divider"></div>

                                        <div class="dropdown-menu-scrollable-lg">
                                            <div class="dropdown-header">
                                                Contacts
                                                <a href="#" class="float-end">
                                                    See all
                                                    <i class="ph-arrow-circle-right ms-1"></i>
                                                </a>
                                            </div>

                                            <div class="dropdown-item cursor-pointer">
                                                <div class="me-3">
                                                    <img src="../../../assets/images/demo/users/face3.jpg" class="w-32px h-32px rounded-pill" alt="">
                                                </div>

                                                <div class="d-flex flex-column flex-grow-1">
                                                    <div class="fw-semibold">Christ<mark>in</mark>e Johnson</div>
                                                    <span class="fs-sm text-muted">c.johnson@awesomecorp.com</span>
                                                </div>

                                                <div class="d-inline-flex">
                                                    <a href="#" class="text-body ms-2">
                                                        <i class="ph-user-circle"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="dropdown-item cursor-pointer">
                                                <div class="me-3">
                                                    <img src="../../../assets/images/demo/users/face24.jpg" class="w-32px h-32px rounded-pill" alt="">
                                                </div>

                                                <div class="d-flex flex-column flex-grow-1">
                                                    <div class="fw-semibold">Cl<mark>in</mark>ton Sparks</div>
                                                    <span class="fs-sm text-muted">c.sparks@awesomecorp.com</span>
                                                </div>

                                                <div class="d-inline-flex">
                                                    <a href="#" class="text-body ms-2">
                                                        <i class="ph-user-circle"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="dropdown-divider"></div>

                                            <div class="dropdown-header">
                                                Clients
                                                <a href="#" class="float-end">
                                                    See all
                                                    <i class="ph-arrow-circle-right ms-1"></i>
                                                </a>
                                            </div>

                                            <div class="dropdown-item cursor-pointer">
                                                <div class="me-3">
                                                    <img src="../../../assets/images/brands/adobe.svg" class="w-32px h-32px rounded-pill" alt="">
                                                </div>

                                                <div class="d-flex flex-column flex-grow-1">
                                                    <div class="fw-semibold">Adobe <mark>In</mark>c.</div>
                                                    <span class="fs-sm text-muted">Enterprise license</span>
                                                </div>

                                                <div class="d-inline-flex">
                                                    <a href="#" class="text-body ms-2">
                                                        <i class="ph-briefcase"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="dropdown-item cursor-pointer">
                                                <div class="me-3">
                                                    <img src="../../../assets/images/brands/holiday-inn.svg" class="w-32px h-32px rounded-pill" alt="">
                                                </div>

                                                <div class="d-flex flex-column flex-grow-1">
                                                    <div class="fw-semibold">Holiday-<mark>In</mark>n</div>
                                                    <span class="fs-sm text-muted">On-premise license</span>
                                                </div>

                                                <div class="d-inline-flex">
                                                    <a href="#" class="text-body ms-2">
                                                        <i class="ph-briefcase"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="dropdown-item cursor-pointer">
                                                <div class="me-3">
                                                    <img src="../../../assets/images/brands/ing.svg" class="w-32px h-32px rounded-pill" alt="">
                                                </div>

                                                <div class="d-flex flex-column flex-grow-1">
                                                    <div class="fw-semibold"><mark>IN</mark>G Group</div>
                                                    <span class="fs-sm text-muted">Perpetual license</span>
                                                </div>

                                                <div class="d-inline-flex">
                                                    <a href="#" class="text-body ms-2">
                                                        <i class="ph-briefcase"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="position-static">
                                    <a href="#" class="navbar-nav-link align-items-center justify-content-center w-40px h-32px position-absolute end-0 top-50 translate-middle-y p-0 me-1" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                        <i class="ph-faders-horizontal"></i>
                                    </a>

                                    <div class="dropdown-menu w-100 p-3 dropdown-menu-end start-5">
                                        <div class="d-flex align-items-center mb-3">
                                            <h6 class="mb-0">Filter Pencarian Produk Hukum</h6>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col">
                                                <label class="d-block form-label">Tipe</label>
                                                <select class="form-select w-auto flex-grow-0">
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
                                                <label class="form-label">Nomor</label>
                                                <input type="text" name="code_number" id="code_number" class="form-control" placeholder="Contoh: 12">
                                            </div>
                                            <div class="col">
                                                <label class="d-block form-label">Tahun</label>
                                                <input type="number" name="year" id="year" class="form-control" placeholder="Contoh: 2022">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="matter" class="d-block form-label">Bidang Hukum</label>
                                                <select name="matter" id="matter" class="form-select w-auto flex-grow-0">
                                                    <option value="">Pilih Bidang Hukum</option>
                                                    @foreach ($matters as $key => $value)
                                                        <option value="{{ $key }}" @selected(Request::get('matter') == $key)>{{ Str::title($value) }}</option>
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
                                            <label for="field" class="form-label">Urusan Pemerintahan</label>
                                            <select name="field" id="field" class="form-select select-search">
                                                <option value="">Pilih Urusan Pemerintahan</option>
                                                @foreach ($fields as $key => $value)
                                                    <option value="{{ $key }}" @selected(Request::get('field') == $key)>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <button type="button" class="btn btn-danger w-100">Cari</button>
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="link-white mt-3 d-block fw-bold">Lihat semua Produk Hukum<i class="ph-arrow-right ms-2"></i></a>
                        </div>
                        <div class="col-lg-6">

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Page content -->
<div class="page-content container">

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Content area -->
        <div class="content">

            <!-- Basic card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Basic card</h5>
                </div>

                <div class="card-body">
                    <h6>Start your development with no hassle!</h6>
                    <p class="mb-3">Common problem of templates is that all code is deeply integrated into the core. This limits your freedom in decreasing amount of code, i.e. it becomes pretty difficult to remove unnecessary code from the project. Limitless allows you to remove unnecessary and extra code easily just by disabling styling of certain components in <code>_config.scss</code>. Styling of all 3rd party components are stored in separate SCSS files that begin with <code>$enable-[component]</code> condition, which checks if this component is enabled in SCSS configuration and either includes or excludes it from bundled CSS file. Use only components you actually need!</p>

                    <h6>What is this?</h6>
                    <p class="mb-3">Starter kit is a set of pages, useful for developers to start development process from scratch. Each layout includes base components only: layout, page kits, color system which is still optional, bootstrap files and bootstrap overrides. No extra CSS/JS files and markup. CSS files are compiled without any plugins or components. Starter kit is moved to a separate folder for better accessibility.</p>

                    <h6>How does it work?</h6>
                    <p>You open one of the starter pages, add necessary plugins, enable components in <code>_config.scss</code> file, compile new CSS. That's it. It's also recommended to open one of main pages with functionality you need and copy all paths/JS code from there to your new page, if you don't need to change file structure.</p>
                </div>
            </div>
            <!-- /basic card -->


            <!-- Basic table -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Basic table</h5>
                </div>

                <div class="card-body">
                    Seed project includes the most basic components that can help you in development process - basic grid example, card, table and form layouts with standard components. Nothing extra. Easily turn on and off styles of different components to keep your CSS as clean as possible. Bootstrap components are always enabled.
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Username</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Eugene</td>
                                <td>Kopyov</td>
                                <td>@Kopyov</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Victoria</td>
                                <td>Baker</td>
                                <td>@Vicky</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>James</td>
                                <td>Alexander</td>
                                <td>@Alex</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Franklin</td>
                                <td>Morrison</td>
                                <td>@Frank</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /basic table -->


            <!-- Form layouts -->
            <div class="row">
                <div class="col-lg-6">

                    <!-- Horizontal form -->
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h5 class="mb-0">Horizontal form</h5>
                            <div class="hstack gap-2 ms-auto">
                                <a class="text-body" data-card-action="collapse">
                                    <i class="ph-caret-down"></i>
                                </a>
                                <a class="text-body" data-card-action="reload">
                                    <i class="ph-arrows-clockwise"></i>
                                </a>
                                <a class="text-body" data-card-action="remove">
                                    <i class="ph-x"></i>
                                </a>
                            </div>
                        </div>

                        <div class="collapse show">
                            <div class="card-body">
                                <form action="#">
                                    <div class="row mb-3">
                                        <label class="col-lg-3 col-form-label">Text input</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" placeholder="Text input">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-lg-3 col-form-label">Password</label>
                                        <div class="col-lg-9">
                                            <input type="password" class="form-control" placeholder="Password input">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-lg-3 col-form-label">Select</label>
                                        <div class="col-lg-9">
                                            <select name="select" class="form-select">
                                                <option value="opt1">Basic select</option>
                                                <option value="opt2">Option 2</option>
                                                <option value="opt3">Option 3</option>
                                                <option value="opt4">Option 4</option>
                                                <option value="opt5">Option 5</option>
                                                <option value="opt6">Option 6</option>
                                                <option value="opt7">Option 7</option>
                                                <option value="opt8">Option 8</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-lg-3 col-form-label">Textarea</label>
                                        <div class="col-lg-9">
                                            <textarea rows="5" cols="5" class="form-control" placeholder="Default textarea"></textarea>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Submit form <i class="ph-paper-plane-tilt ms-2"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /horizotal form -->

                </div>

                <div class="col-lg-6">

                    <!-- Vertical form -->
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h5 class="mb-0">Vertical form</h5>
                            <div class="hstack gap-2 ms-auto">
                                <a class="text-body" data-card-action="collapse">
                                    <i class="ph-caret-down"></i>
                                </a>
                                <a class="text-body" data-card-action="reload">
                                    <i class="ph-arrows-clockwise"></i>
                                </a>
                                <a class="text-body" data-card-action="remove">
                                    <i class="ph-x"></i>
                                </a>
                            </div>
                        </div>

                        <div class="collapse show">
                            <div class="card-body">
                                <form action="#">
                                    <div class="mb-3">
                                        <label class="form-label">Text input</label>
                                        <input type="text" class="form-control" placeholder="Text input">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Select</label>
                                        <select name="select" class="form-select">
                                            <option value="opt1">Basic select</option>
                                            <option value="opt2">Option 2</option>
                                            <option value="opt3">Option 3</option>
                                            <option value="opt4">Option 4</option>
                                            <option value="opt5">Option 5</option>
                                            <option value="opt6">Option 6</option>
                                            <option value="opt7">Option 7</option>
                                            <option value="opt8">Option 8</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Textarea</label>
                                        <textarea rows="4" cols="4" class="form-control" placeholder="Default textarea"></textarea>
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Submit form <i class="ph-paper-plane-tilt ms-2"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /vertical form -->

                </div>
            </div>
            <!-- /form layouts -->

        </div>
        <!-- /content area -->

    </div>
    <!-- /main content -->

</div>
<!-- /page content -->

@endsection
