<div class="dropdown-menu-scrollable-lg">

    @if (isset($laws) AND $laws->count() > 0)
        <div class="dropdown-header">
            Peraturan Perundang-undangan
            @if ($laws->count() == 3)
                <a href="{{ route('legislation.law.index', ['title' => $term]) }}" class="float-end text-body">
                    Lihat semua
                    <i class="ph-arrow-circle-right ms-1"></i>
                </a>
            @endif
        </div>

        @foreach ($laws as $law)
            <a href="{{ route('legislation.law.show', ['category' => $law->category->slug, 'legislation' => $law->slug]) }}" title="{{ $law->title }}" class="text-body dropdown-item">
                <div class="me-3">
                    {!! $law->typeFlatButton !!}
                </div>

                <div class="d-flex flex-column flex-grow-1 text-truncate">
                    <div class="fw-semibold text-truncate">{!! Str::highlightPhrase($law->title, $term) !!}</div>
                    <span class="fs-sm text-muted text-truncate">{!! Str::highlightPhrase($law->category->name, $term) !!}</span>
                </div>
            </a>
        @endforeach
    @endif

    @if (isset($monographs) AND $monographs->count() > 0)
        <div class="dropdown-divider"></div>

        <div class="dropdown-header">
            Monografi Hukum
            @if ($monographs->count() == 3)
                <a href="{{ route('legislation.monograph.index', ['title' => $term]) }}" class="float-end text-body">
                    Lihat semua
                    <i class="ph-arrow-circle-right ms-1"></i>
                </a>
            @endif
        </div>

        @foreach ($monographs as $monograph)
            <a href="{{ route('legislation.monograph.show', ['category' => $monograph->category->slug, 'legislation' => $monograph->slug]) }}" title="{{ $monograph->title }}" class="dropdown-item text-body">
                <div class="me-3">
                    {!! $monograph->typeFlatButton !!}
                </div>

                <div class="d-flex flex-column flex-grow-1 text-truncate">
                    <div class="fw-semibold text-truncate">{!! Str::highlightPhrase($monograph->title, $term) !!}</div>
                    <span class="fs-sm text-muted text-truncate">{!! Str::highlightPhrase($monograph->category->name, $term) !!}</span>
                </div>
            </a>
        @endforeach
    @endif

    @if (isset($articles) AND $articles->count() > 0)
        <div class="dropdown-divider"></div>

        <div class="dropdown-header">
            Artikel Hukum
            @if ($articles->count() == 3)
                <a href="{{ route('legislation.article.index', ['title' => $term]) }}" class="float-end text-body">
                    Lihat semua
                    <i class="ph-arrow-circle-right ms-1"></i>
                </a>
            @endif
        </div>

        @foreach ($articles as $article)
            <a href="{{ route('legislation.article.show', ['category' => $article->category->slug, 'legislation' => $article->slug]) }}" title="{{ $article->title }}" class="text-body dropdown-item">
                <div class="me-3">
                    {!! $article->typeFlatButton !!}
                </div>

                <div class="d-flex flex-column flex-grow-1 text-truncate">
                    <div class="fw-semibold text-truncate">{!! Str::highlightPhrase($article->title, $term) !!}</div>
                    <span class="fs-sm text-muted text-truncate">{!! Str::highlightPhrase($article->category->name, $term) !!}</span>
                </div>
            </a>
        @endforeach
    @endif

    @if (isset($judgments) AND $judgments->count() > 0)
        <div class="dropdown-divider"></div>

        <div class="dropdown-header">
            Putusan Pengadilan
            @if ($judgments->count() == 3)
                <a href="{{ route('legislation.judgment.index', ['title' => $term]) }}" class="float-end text-body">
                    Lihat semua
                    <i class="ph-arrow-circle-right ms-1"></i>
                </a>
            @endif
        </div>

        @foreach ($judgments as $judgment)
            <a href="{{ route('legislation.judgment.show', ['category' => $judgment->category->slug, 'legislation' => $judgment->slug]) }}" class="text-body dropdown-item">
                <div class="me-3">
                    {!! $judgment->typeFlatButton !!}
                </div>

                <div class="d-flex flex-column flex-grow-1 text-truncate">
                    <div class="fw-semibold text-truncate">{!! Str::highlightPhrase($judgment->title, $term) !!}</div>
                    <span class="fs-sm text-muted text-truncate">{!! Str::highlightPhrase($judgment->category->name, $term) !!}</span>
                </div>
            </a>
        @endforeach
    @endif

    @if ($laws->count() == 0 AND $monographs->count() == 0 AND $articles->count() == 0 AND $judgments->count() == 0)
        <div class="dropdown-header">Data yang dicari tidak ditemukan...</div>
    @endif

</div>
