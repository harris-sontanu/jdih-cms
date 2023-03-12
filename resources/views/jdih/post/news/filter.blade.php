<!-- Filter -->
<div class="card shadow">
    <div class="sidebar-section-header pb-0">
        <h5 class="mb-0">Filter</h5>
    </div>

    <form class="filter-form"
        @isset($category)
            action="{{ route('legislation.law.category', ['category' => $category->slug]) }}"
        @else
            action="{{ route('legislation.law.index') }}"
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

        <!-- Taxonomy filter -->
        <div class="sidebar-section">
            <div class="sidebar-section-header border-bottom">
                <span class="fw-semibold">Kategori</span>
                <div class="ms-auto">
                    <a href="#taxonomies" class="text-reset" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator"></i>
                    </a>
                </div>
            </div>

            <div class="collapse show" id="taxonomies">
                <div class="nav nav-sidebar">
                    @foreach ($taxonomies as $taxonomy)
                        @continue($taxonomy->publishedPosts->count() === 0)
                        <li class="nav-item">
                            <a href="{{ route('news.taxonomy', ['taxonomy' => $taxonomy->slug]) }}" class="nav-link">
                                <i class="ph-folder me-2"></i>
                                {{ $taxonomy->name }}
                                <span class="badge bg-teal bg-opacity-10 text-teal rounded-pill ms-auto">{{ $taxonomy->publishedPosts->count() }}</span>
                            </a>
                        </li>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- /taxonomy filter -->

    </form>

</div>
<!-- /filter -->
