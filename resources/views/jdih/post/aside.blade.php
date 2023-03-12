<aside class="sidebar sidebar-component sidebar-expand-lg align-self-start bg-transparent shadow-none me-lg-4">

    <div class="sidebar-content">

        @isset($view)
            @include($view)
        @else
            @include('jdih.post.filter')
        @endisset

        @if (isset($popularNews) AND $popularNews->count() > 0)
            <!-- Popular News -->
            <div class="my-4">
                <div class="sidebar-section-header p-0">
                    <h5 class="fw-bold mb-0">Berita Populer</h5>
                </div>

                <div class="sidebar-section-body px-0 pb-0">
                    @foreach ($popularNews as $news)
                        <div class="d-flex mb-4">
                            <a href="{{ route('news.show', ['taxonomy' => $news->taxonomy->slug, 'post' => $news->slug]) }}" class="me-3">
                                <img src="{{ $news->cover->thumbSource }}" class="rounded shadow" alt="{{ $news->cover->name }}" width="64">
                            </a>
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
            <!-- /popular news -->
        @endif

    </div>

</aside>
