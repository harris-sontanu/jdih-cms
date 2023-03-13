<!-- Filter -->
<div class="card shadow mb-4">
    <div class="sidebar-section-header pb-0">
        <h5 class="mb-0">Filter</h5>
    </div>

    <form class="filter-form"
        @isset($category)
            action="{{ route('legislation.article.category', ['category' => $category->slug]) }}"
        @else
            action="{{ route('legislation.article.index') }}"
        @endisset
        method="get">

        <!-- Sidebar search -->
        <div class="sidebar-section">
            <div class="sidebar-section-header border-bottom">
                <span class="fw-semibold">Kata Kunci</span>
                <div class="ms-auto">
                    <a href="#sidebar-search" class="text-reset" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator"></i>
                    </a>
                </div>
            </div>

            <div class="collapse show" id="sidebar-search">
                <div class="sidebar-section-body">
                    <div class="form-control-feedback form-control-feedback-end">
                        <input id="title" type="search" name="title" autofocus class="form-control form-control-danger" placeholder="Contoh: covid-19" value="{{ Request::get('title') }}">
                        <div class="form-control-feedback-icon">
                            <i class="ph-magnifying-glass opacity-50"></i>
                        </div>
                    </div>
                    <div class="form-text text-muted">Tekan Enter untuk mencari</div>
                </div>
            </div>
        </div>
        <!-- /sidebar search -->

        <!-- Categories filter -->
        @empty($category)
            <div class="sidebar-section">
                <div class="sidebar-section-header border-bottom">
                    <span class="fw-semibold">Jenis / Bentuk</span>
                    <div class="ms-auto">
                        <a href="#categories" class="text-reset" data-bs-toggle="collapse">
                            <i class="ph-caret-down collapsible-indicator"></i>
                        </a>
                    </div>
                </div>

                <div class="collapse show" id="categories">
                    <div class="sidebar-section-body">
                        @foreach ($categories as $key => $value)
                            @if ($loop->iteration === 6 AND !Request::get('categories'))
                                <div id="categories-hidden" style="display: none">
                            @endif
                            <label class="form-check mb-2">
                                <input type="checkbox" name="categories[]" @checked(Request::get('categories') AND in_array($key, Request::get('categories'))) class="form-check-input form-check-input-danger" value="{{ $key }}">
                                <span class="form-check-label">{{ Str::title($value) }}</span>
                            </label>
                            @if ($loop->last AND !Request::get('categories'))
                                </div>
                            @endif
                        @endforeach
                        @empty(Request::get('categories'))
                            <a role="button" class="link-danger fs-sm options-hide-toggle" data-target="categories-hidden">Lihat semua</a>
                        @endempty
                    </div>
                </div>
            </div>
        @endempty
        <!-- /categories options -->

        <!-- Catalogue filter -->
        <div class="sidebar-section">
            <div class="sidebar-section-header border-bottom">
                <span class="fw-semibold">Katalog</span>
                <div class="ms-auto">
                    <a href="#catalogue" class="text-reset" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator"></i>
                    </a>
                </div>
            </div>

            <div class="collapse show" id="catalogue">
                <div class="sidebar-section-body">
                    <div class="mb-3">
                        <label class="form-label">T.E.U. Orang / Badan:</label>
                        <input id="author" type="search" name="author" class="form-control" placeholder="Contoh: THAMRIN, HUSNI" value="{{ Request::get('author') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sumber:</label>
                        <input id="source" type="search" name="source" class="form-control" placeholder="Contoh: MAJALAH HUKUM NASIONAL" value="{{ Request::get('source') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tahun Terbit:</label>
                        <input id="year" type="number" name="year" class="form-control" placeholder="Contoh: 2012" value="{{ Request::get('year') }}">
                    </div>
                    <label class="form-label">Subjek: <output id="value"></output></label>
                    <input id="subject" type="text" name="subject" class="form-control" placeholder="Contoh: PUNGUTAN LIAR" value="{{ Request::get('subject') }}">
                </div>
            </div>
        </div>
        <!-- /catalogue filter -->

        <!-- Fields filter -->
        <div class="sidebar-section">
            <div class="sidebar-section-header border-bottom">
                <span class="fw-semibold">Bidang Hukum</span>
                <div class="ms-auto">
                    <a href="#fields" class="text-reset @empty(Request::get('fields')) collapsed @endempty" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="ph-caret-down collapsible-indicator"></i>
                    </a>
                </div>
            </div>

            <div class="collapse @if(Request::get('fields')) show @endif" id="fields">
                <div class="sidebar-section-body">
                    @foreach ($fields as $key => $value)
                        @if ($loop->iteration === 6 AND !Request::get('fields'))
                            <div id="fields-hidden" style="display: none">
                        @endif
                        <label class="form-check mb-2">
                            <input type="checkbox" name="fields[]" @checked(Request::get('fields') AND in_array($key, Request::get('fields'))) class="form-check-input form-check-input-danger" value="{{ $key }}">
                            <span class="form-check-label">{{ Str::title($value) }}</span>
                        </label>
                        @if ($loop->last AND !Request::get('fields'))
                            </div>
                        @endif
                    @endforeach
                    @empty(Request::get('fields'))
                        <a role="button" class="link-danger fs-sm options-hide-toggle" data-target="fields-hidden">Lihat semua</a>
                    @endempty
                </div>
            </div>
        </div>
        <!-- /fields options -->

    </form>

</div>
<!-- /filter -->
