<!-- Popular News -->
@if (isset($popularNews) AND $popularNews->count() > 0)
<div class="mb-4">
    <h4 class="fw-bold mb-3">Berita Populer</h4>

    @foreach ($popularNews as $news)
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
@endif
<!-- /popular news -->

<!-- YouTubes -->
@if (isset($youtubes) AND $youtubes->count() > 0)
<div class="mb-4">
    <h4 class="fw-bold mb-3">Video</h4>

    <div id="carouselExampleIndicators" class="carousel shadow slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($youtubes as $youtube)
                <div class="carousel-item @if ($loop->first) active @endif">
                    <div class="card shadow-0 mb-0">
                        <div class="ratio ratio-16x9">
                            <iframe src="{{ $youtube->youtubeEmbedSource}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title mb-0">{{ $youtube->title }}</h6>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
@endif
<!-- /youtubes -->

<!-- Photos -->
@if (isset($photos) AND $photos->count() > 0)
<div class="mb-4">
    <h4 class="fw-bold mb-3">Galeri Foto</h4>
    <div class="row g-0">
        @php
            $imgClass = null;
        @endphp
        @foreach ($photos as $photo)
            @if ($loop->first)
                <div class="col">
            @elseif ($loop->index % 3 === 0)
                </div><div class="col">
            @endif

            @if ($loop->iteration === 1)
                @php $imgClass = 'rounded-top-start'; @endphp
            @elseif ($loop->iteration === 3)
                @php $imgClass = 'rounded-bottom-start'; @endphp
            @elseif ($loop->iteration === 7)
                @php $imgClass = 'rounded-top-end'; @endphp
            @elseif ($loop->iteration === 9)
                @php $imgClass = 'rounded-bottom-end'; @endphp
            @else
                @php $imgClass = null; @endphp
            @endif

            <div class="card-img-actions">
                <a href="{{ $photo->source }}" class="text-white" data-bs-popup="lightbox">
                    <img class="img-fluid {{ $imgClass }}" src="{{ $photo->fitSource }}" alt="{{ $photo->title }}">
                    <span class="card-img-actions-overlay {{ $imgClass }}">
                        <i class="ph-plus"></i>
                    </span>
                </a>
            </div>
        @endforeach

    </div>
</div>
@endif
<!-- /photos -->
