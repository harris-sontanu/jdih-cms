@extends('jdih.layouts.app')

@section('content')

@include('jdih.homepage.slide')

<section class="bg-dark">
    <div class="container pt-5 pb-0">
        <div class="content-wrapper">
            <div class="content row mb-5">
                <div class="col-12 col-md-3">
                    <img src="{{ asset('assets/admin/images/demo/users/face12.jpg') }}" class="rounded-circle d-block m-auto" height="160">
                </div>
                <div class="col-12 col-md-9 text-light">
                    <h2 class="mb-3 text-handwriting">Sekapur Sirih</h2>
                    <p class="fs-lg">Situs ini merupakan situs resmi Biro Hukum Setda Provinsi Bali. Situs ini memuat data dan informasi-informasi produk hukum baik produk hukum pusat maupun daerah. Disamping itu, situs ini memuat pula informasi mengenai buku-buku referensi tentang hukum yang dimiliki oleh Biro Hukum Provinsi Bali.<br></p>
                    <div class="author mt-4">
                        <span class="fw-semibold">IDA BAGUS GEDE SUDARSANA, SH</span><br>
                        <span class="text-light fs-sm">Kepala Biro  Hukum </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="content-wrapper">
            <div class="content py-5">
                <div class="d-flex pb-4">
                    <h2 class="fw-bold flex-grow-1 section-title">Statistik Produk Hukum</h2>
                    <a href="#" class="btn bg-danger bg-opacity-20 text-danger py-2 px-3 lift fw-semibold">Lihat Statistik lainnya<i class="ph-arrow-right ms-2"></i></a>
                </div>
                <div class="row gx-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-body shadow-lg lift">
                            <a href="#" class="text-dark">
                                <div class="d-flex align-items-center">
                                    <i class="ph-scales ph-2x text-success me-3"></i>

                                    <div class="flex-fill text-end">
                                        <h4 class="mb-0">{{ $totalLaws }}</h4>
                                        <span class="text-muted">total peraturan</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-body shadow-lg lift">
                            <a href="#" class="text-dark">
                                <div class="d-flex align-items-center">
                                    <i class="ph-books ph-2x text-indigo me-3"></i>

                                    <div class="flex-fill text-end">
                                        <h4 class="mb-0">{{ $totalMonographs }}</h4>
                                        <span class="text-muted">total monografi</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-body shadow-lg lift">
                            <a href="#" class="text-dark">
                                <div class="d-flex align-items-center">
                                    <div class="flex-fill">
                                        <h4 class="mb-0">{{ $totalArticles }}</h4>
                                        <span class="text-muted">total artikel</span>
                                    </div>

                                    <i class="ph-newspaper ph-2x text-primary ms-3"></i>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-body shadow-lg lift">
                            <a href="#" class="text-dark">
                                <div class="d-flex align-items-center">
                                    <div class="flex-fill">
                                        <h4 class="mb-0">{{ $totalJudgments }}</h4>
                                        <span class="text-muted">total putusan</span>
                                    </div>

                                    <i class="ph-stamp ph-2x text-danger ms-3"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

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

@section('script')
    @include('jdih.homepage.script')
@endsection
