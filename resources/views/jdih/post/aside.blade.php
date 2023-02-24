<aside class="sidebar sidebar-component sidebar-expand-lg align-self-start bg-transparent shadow-none me-lg-3">

    <div class="sidebar-content">

        @isset($view)
            @include('jdih.post.'.$view.'.filter')
        @else
            @include('jdih.post.filter')
        @endisset

        <div class="my-4">
            <h5 class="fw-bold">Monografi Hukum</h5>

            <div id="carouselExampleIndicators" class="carousel slide shadow-lg rounded" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($popularMonographs as $monograph)
                        <div class="carousel-item {{ $i === 0 ? 'active' : null }}">
                            <div class="card shadow-none m-0">
                                <a href="#">
                                    <img class="card-img-top img-fluid" src="{{ $monograph->coverThumbSource }}"
                                        alt="">
                                </a>

                                <div class="card-body">
                                    <h6 class="card-title mb-0">{{ $monograph->title }}</h6>
                                </div>
                            </div>
                        </div>
                        @php
                            $i++;
                        @endphp
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

    </div>

    <div class="my-4">
        <h5 class="fw-bold">Tautan</h5>

        @foreach ($banners as $banner)
            <div class="card shadow-lg border-0">
                <a href="{{ $banner->url }}"><img src="{{ $banner->image->source }}" class="img-fluid rounded" alt="" srcset=""></a>
            </div>
        @endforeach
    </div>

</aside>
