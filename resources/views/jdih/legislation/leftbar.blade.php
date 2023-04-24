<aside class="sidebar sidebar-component sidebar-expand-lg align-self-start bg-transparent shadow-none me-lg-3">

    <div class="sidebar-content">

        @isset($view)
            @include($view)
        @else
            @include('jdih.legislation.filter')
        @endisset

        @if (isset($latestMonographs) AND $latestMonographs->count() > 0)
            <div class="mb-4">
                <div class="sidebar-section-header p-0">
                    <h4 class="fw-bold">Monografi Hukum</h4>
                </div>

                <div id="carouselMonographs" class="carousel slide shadow rounded" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($latestMonographs as $monograph)
                            <div class="carousel-item @if ($loop->first) active @endif">
                                <div class="card shadow-none m-0">
                                    <a href="{{ route('legislation.monograph.show', ['category' => $monograph->category->slug, 'legislation' => $monograph->slug]) }}">
                                        <img class="card-img-top img-fluid h-450 object-fit-cover" src="{{ $monograph->coverThumbSource }}">
                                    </a>

                                    <div class="card-body">
                                        <h6 class="card-title mb-0 text-truncate" title="{{ $monograph->title }}">{{ $monograph->title }}</h6>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselMonographs"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselMonographs"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        @endif

        <!-- Latest laws -->
        @if (isset($latestLaws) AND $latestLaws->count() > 0)
            <div class="mb-4">
                <div class="sidebar-section-header p-0">
                    <h4 class="fw-bold mb-0">Peraturan Terbaru</h4>
                </div>
                <div class="sidebar-section-body scrollable px-0 pb-0">
                    @foreach ($latestLaws as $law)
                        <div class="d-flex mb-3">
                            <div class="me-3">
                                <div class="bg-danger bg-opacity-10 text-danger lh-1 rounded-pill p-2">
                                    <span class="letter-icon">0{{ $loop->iteration }}</span>
                                </div>
                            </div>
                            <div class="flex-fill">
                                <h6 class="mb-1"><a href="{{ route('legislation.law.show', ['category' => $law->category->slug, 'legislation' => $law->slug]) }}" class="fw-semibold text-body">{{ $law->shortTitle }}</a></h6>
                                <ul class="list-inline list-inline-bullet text-muted fs-sm mb-0">
                                    <li class="list-inline-item"><i class="ph-calendar-blank me-2"></i>{{ $law->dateFormatted($law->published_at) }}</li>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <!-- /latest laws -->

    </div>

</aside>
