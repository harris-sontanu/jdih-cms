<!-- Filter -->
<div class="card shadow-lg">
    <div class="sidebar-section-header">
        <h5 class="mb-0">Cari Berita</h5>
    </div>

    <div class="sidebar-section-body">
        <form class="filter-form" action="{{ route('news.index') }}" method="get">
            <div class="form-control-feedback form-control-feedback-end">
                <input type="search" name="title" class="form-control" placeholder="Cari...">
                <div class="form-control-feedback-icon">
                    <i class="ph-magnifying-glass"></i>
                </div>
            </div>
        </form>
    </div>

    <div class="sidebar-section-header">
        <h5 class="mb-0">Kategori</h5>
    </div>

    <div class="nav nav-sidebar">
        @foreach ($taxonomies as $taxonomy)
            @continue($taxonomy->posts->count() === 0)
            <li class="nav-item">
                <a href="{{ route('news.taxonomy', ['taxonomy' => $taxonomy->slug]) }}" class="nav-link">
                    <i class="ph-folder me-2"></i>
                    {{ $taxonomy->name }}
                    <span class="badge bg-teal bg-opacity-10 text-teal rounded-pill ms-auto">{{ $taxonomy->posts->count() }}</span>
                </a>
            </li>
        @endforeach
    </div>

</div>
<!-- filter -->
