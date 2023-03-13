<aside class="col-xl-1 text-center pe-0 my-5">
    <div class="post-like my-4">
        <button type="button" class="btn btn-flat-pink rounded-pill p-2 border-0 mb-1">
            <i class="ph-heart"></i>
        </button>
        <p>{{ $like }}</p>
    </div>
    <div class="post-view my-4">
        <div class="bg-dark bg-opacity-10 text-dark lh-1 rounded-pill p-2 d-inline-block mb-1">
            <i class="ph-eye"></i>
        </div>
        <p>{{ $view}} </p>
    </div>
    @isset($download)
        <div class="post-download my-4">
            <div class="bg-dark bg-opacity-10 text-dark lh-1 rounded-pill p-2 d-inline-block mb-1">
                <i class="ph-download"></i>
            </div>
            <p>{{ $download }}</p>
        </div>
    @endisset
    <div class="post-bookmark my-4">
        <a href="{{ url()->current() }}" class="btn btn-flat-dark btn-icon rounded-pill border-0 bookmark" title="Bookmark"><i class="ph-bookmark-simple"></i></a>
    </div>
    <div class="post-share my-4">
        <div class="btn-group">
            <button type="button" class="btn btn-flat-dark btn-icon rounded-pill border-0" data-bs-toggle="dropdown" title="Bagikan">
                <i class="ph-share-network "></i>
            </button>

            <div class="dropdown-menu">
                @foreach ($shares as $share)
                    <a href="{{ $share['url'] }}" target="_blank" class="dropdown-item">
                        <i class="{{ $share['icon'] }} me-2"></i>Bagikan ke {{ $share['title'] }}
                    </a>
                @endforeach
                <button type="button" data-url="{{ url()->current() }}" class="dropdown-item">
                    <i class="ph-link me-2"></i>Salin Tautan
                </button>
            </div>
        </div>
    </div>
</aside>
