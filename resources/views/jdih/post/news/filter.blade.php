<!-- Filter -->
<div class="card shadow-lg">
    <div class="sidebar-section-header">
        <h5 class="mb-0">Cari Berita</h5>
    </div>

    <div class="sidebar-section-body">
        <div class="form-control-feedback form-control-feedback-end">
            <input type="search" class="form-control" placeholder="Cari...">
            <div class="form-control-feedback-icon">
                <i class="ph-magnifying-glass"></i>
            </div>
        </div>
    </div>

    <div class="sidebar-section-header">
        <h5 class="mb-0">Kategori</h5>
    </div>

    <div class="nav nav-sidebar">
        @foreach ($taxonomies as $taxonomy)
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

<div class="mt-4">
    <h5 class="fw-bold">Berita Populer</h5>

    <div class="sidebar-section-body px-0 pb-0">
        @foreach ($popularNews as $news)
            <div class="d-flex mb-3">
                <a href="#" class="me-3">
                    <img src="{{ $news->cover->thumbSource }}" class="rounded shadow" alt="{{ $news->cover->name }}" width="48">
                </a>
                <div class="flex-fill">
                    <h6><a href="{{ route('news.show', ['taxonomy' => $news->taxonomy->slug, 'news' => $news->slug]) }}" class="fw-semibold text-body">{{ $news->title }}</a></h6>
                    <ul class="list-inline list-inline-bullet text-muted fs-sm">
                        <li class="list-inline-item"><i class="ph-calendar-blank me-2"></i>{{ $news->dateFormatted($news->published_at) }}</li>
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
</div>
