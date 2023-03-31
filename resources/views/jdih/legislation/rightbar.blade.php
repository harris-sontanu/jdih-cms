<!-- Latest News -->
@if (isset($latestNews) AND $latestNews->count() > 0)
<div class="mb-4">
    <h5 class="fw-bold mb-3">Berita Terbaru</h5>

    <div class="sidebar-section-body scrollable px-0 pb-0">
        @foreach ($latestNews as $news)
            <div class="d-flex mb-3">
                <div class="me-3">
                    <div class="bg-danger bg-opacity-10 text-danger lh-1 rounded-pill p-2">
                        <span class="letter-icon">0{{ $loop->iteration }}</span>
                    </div>
                </div>
                <div class="flex-fill">
                    <h6 class="mb-1"><a href="{{ route('news.show', ['taxonomy' => $news->taxonomy->slug, 'post' => $news->slug]) }}" class="fw-semibold text-body">{{ $news->title }}</a></h6>
                    <ul class="list-inline list-inline-bullet text-muted fs-sm mb-0">
                        <li class="list-inline-item"><i class="ph-calendar-blank me-2"></i>{{ $news->dateFormatted($news->published_at) }}</li>
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif
<!-- /latest news -->

@if (isset($asideBanners) AND $asideBanners->count() > 0)
<!-- Aside banners -->
<div class="mb-4">
    @foreach ($asideBanners as $banner)
        @break($loop->iteration > 3)
        <a href="{{ $banner->url }}"><img src="{{ $banner->image->source }}" class="img-fluid shadow rounded @if($loop->iteration > 1) mt-3 @endif" alt="{{ $banner->title }}"></a>
    @endforeach
</div>
<!-- /aside banners -->
@endif
