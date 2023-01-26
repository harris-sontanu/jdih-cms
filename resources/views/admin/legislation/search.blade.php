<div class="dropdown-menu-scrollable-lg">

    @if (!empty($laws) AND count($laws) > 0)
        <div class="dropdown-header">
            Peraturan Perundang-undangan
            @if (count($laws) == 3)
                <a href="{{ route('admin.legislation.law.index', ['search' => $term]) }}" class="float-end">
                    Lihat semua
                    <i class="ph-arrow-circle-right ms-1"></i>
                </a>
            @endif
        </div>

        @foreach ($laws as $law)
            <a href="{{ route('admin.legislation.law.show', $law->id) }}" title="{{ $law->title }}" class="text-body dropdown-item">
                <div class="me-3">
                    <img src="{{ $law->userPictureUrl($law->user->picture, $law->user->name) }}" alt="{{ $law->user->name }}" class="w-32px h-32px rounded-pill">
                </div>

                <div class="d-flex flex-column flex-grow-1 text-truncate">
                    <div class="fw-semibold text-truncate">{{ $law->title }}</div>
                    <span class="fs-sm text-muted text-truncate">{{ $law->category_name }}</span>
                </div>
            </a>
        @endforeach
    @endif

    @if (!empty($monographs) AND count($monographs) > 0)
        <div class="dropdown-divider"></div>

        <div class="dropdown-header">
            Monografi Hukum
            @if (count($monographs) == 3)
                <a href="{{ route('admin.legislation.monograph.index', ['search' => $term]) }}" class="float-end">
                    Lihat semua
                    <i class="ph-arrow-circle-right ms-1"></i>
                </a>
            @endif
        </div>

        @foreach ($monographs as $monograph)
            <a href="{{ route('admin.legislation.monograph.show', $monograph->id) }}" title="{{ $monograph->title }}" class="dropdown-item text-body">
                <div class="me-3">
                    <img src="{{ $monograph->userPictureUrl($monograph->user->picture, $monograph->user->name) }}" alt="{{ $monograph->user->name }}" class="w-32px h-32px rounded-pill">
                </div>

                <div class="d-flex flex-column flex-grow-1 text-truncate">
                    <div class="fw-semibold text-truncate">{{ $monograph->title }}</div>
                    <span class="fs-sm text-muted text-truncate">{{ $monograph->category_name }}</span>
                </div>
            </a>
        @endforeach
    @endif

    @if (!empty($articles) AND count($articles) > 0)
        <div class="dropdown-divider"></div>

        <div class="dropdown-header">
            Artikel Hukum
            @if (count($articles) == 3)
                <a href="{{ route('admin.legislation.article.index', ['search' => $term]) }}" class="float-end">
                    Lihat semua
                    <i class="ph-arrow-circle-right ms-1"></i>
                </a>
            @endif
        </div>

        @foreach ($articles as $article)
            <a href="{{ route('admin.legislation.article.show', $article->id) }}" title="{{ $article->title }}" class="text-body dropdown-item">
                <div class="me-3">
                    <img src="{{ $article->userPictureUrl($article->user->picture, $article->user->name) }}" alt="{{ $article->user->name }}" class="w-32px h-32px rounded-pill">
                </div>

                <div class="d-flex flex-column flex-grow-1 text-truncate">
                    <div class="fw-semibold text-truncate">{{ $article->title }}</div>
                    <span class="fs-sm text-muted text-truncate">{{ $article->category_name }}</span>
                </div>
            </a>
        @endforeach
    @endif

    @if (!empty($judgments) AND count($judgments) > 0)
        <div class="dropdown-divider"></div>

        <div class="dropdown-header">
            Putusan Pengadilan
            @if (count($judgments) == 3)
                <a href="{{ route('admin.legislation.judgment.index', ['search' => $term]) }}" title="{{ $judgment->title }}" class="float-end">
                    Lihat semua
                    <i class="ph-arrow-circle-right ms-1"></i>
                </a>
            @endif
        </div>

        @foreach ($judgments as $judgment)
            <a href="{{ route('admin.legislation.judgment.show', $judgment->id) }}" class="text-body dropdown-item">
                <div class="me-3">
                    <img src="{{ $judgment->userPictureUrl($judgment->user->picture, $judgment->user->name) }}" alt="{{ $judgment->user->name }}" class="w-32px h-32px rounded-pill">
                </div>

                <div class="d-flex flex-column flex-grow-1 text-truncate">
                    <div class="fw-semibold text-truncate">{{ $judgment->title }}</div>
                    <span class="fs-sm text-muted text-truncate">{{ $judgment->category_name }}</span>
                </div>
            </a>
        @endforeach
    @endif

    @if (count($laws) == 0 AND count($monographs) == 0 AND count($articles) == 0 AND count($judgments) == 0)
        <div class="dropdown-header">Data tidak ditemukan...</div>
    @endif

</div>
