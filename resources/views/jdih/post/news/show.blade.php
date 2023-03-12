@extends('jdih.layouts.app')

@section('title', $news->title . ' | ' . strip_tags($appName))
@section('content')

<!-- Page title -->
<section class="bg-dark bg-opacity-3 mb-4">
    <div class="page-content container py-3 px-0">
        <div class="content-wrapper">
            <div class="content">
                <div class="page-header page-header-content d-lg-flex">
                    <div class="breadcrumb">
                        <a href="{{ route('homepage') }}" class="breadcrumb-item text-body"><i class="ph-house"></i></a>
                        <a href="{{ route('news.index') }}" class="breadcrumb-item text-body">Berita</a>
                        <a href="{{ route('news.taxonomy', ['taxonomy' => $news->taxonomy->slug]) }}" class="breadcrumb-item text-body">{{ $news->taxonomy->name }}</a>
                        <span class="breadcrumb-item active text-truncate d-inline-block w-25" title="{{ $news->title }}">{{ $news->title }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /page title -->

<!-- Page container -->
<div class="page-content container">

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Content area -->
        <div class="content row gx-5">

            @include('jdih.layouts.like-and-share', ['like' => 5, 'view' => $news->view])

            <main class="col-xl-8">
                <article class="card shadow-sm post-entry">
                    <div class="card-header p-4 border-bottom-0 post-title">
                        <h2 class="d-block display-6 fw-bold mb-2">{{ $news->title }}</h2>
                        <ul class="post-meta list-inline list-inline-bullet text-muted">
                            <li class="list-inline-item"><i class="ph-clock me-2"></i>{{ $news->timeFormatted($news->published_at, "G:i") }} WITA</li>
                            <li class="list-inline-item"><i class="ph-calendar-blank me-2"></i>{{ $news->timeFormatted($news->published_at, "l, j F Y") }}</li>
                            <li class="list-inline-item"><i class="ph-user me-2"></i>{{ $news->author->name }}</li>
                        </ul>
                    </div>

                    <figure class="card-image">
                        <img src="{{ $news->cover->source }}" class="figure-img img-fluid shadow" alt="...">
                        @isset($news->cover->caption)
                            <figcaption class="figure-caption fs-6 px-4">{{ $news->cover->caption }}</figcaption>
                        @endisset
                    </figure>

                    <div class="card-body fs-5 px-4">
                        {!! $news->body !!}

                        @if (isset($news->galleries) AND $news->galleries->count() > 0)
                            <h3 class="fw-bold mt-4">Foto-foto</h3>
                            <div class="row gx-4">
                                @foreach ($news->galleries as $gallery)
                                    <div class="col-4">
                                        <div class="card shadow mb-4">
                                            <div class="card-img-actions m-0">
                                                <img class="card-img img-fluid" src="{{ $gallery->thumbSource }}">
                                                <div class="card-img-actions-overlay card-img">
                                                    <a href="{{ $gallery->source }}" class="btn btn-outline-white btn-icon rounded-pill" data-bs-popup="lightbox" data-gallery="gallery1">
                                                        <i class="ph-magnifying-glass-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @isset ($news->source)
                            <p class="mt-4"><span class="fw-bold">Sumber: </span>{{ $news->source }}</p>
                        @endisset
                    </div>
                </article>

                @if (isset($banners) AND $banners->count() > 0)
                    <div class="row gx-4 mb-4">
                        @foreach ($banners as $banner)
                            @break($loop->iteration > 3)
                            <div class="col-xl-4">
                                <div class="card shadow bg-white border-0 lift mb-0">
                                    <a href="{{ $banner->url }}"><img src="{{ $banner->image->source }}" class="img-fluid rounded" alt="" srcset=""></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </main>

            <aside class="col-xl-3">

                <!-- Popular News -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Berita Populer</h5>

                    <div class="sidebar-section-body px-0 pb-0">
                        @foreach ($popularNews as $news)
                            <div class="d-flex mb-3 @if (!$loop->last) border-bottom @endif">
                                <a href="{{ route('news.show', ['taxonomy' => $news->taxonomy->slug, 'post' => $news->slug]) }}" class="me-3">
                                    <img src="{{ $news->cover->thumbSource }}" class="rounded shadow" alt="{{ $news->cover->name }}" width="48">
                                </a>
                                <div class="flex-fill">
                                    <h6 class="mb-1"><a href="{{ route('news.show', ['taxonomy' => $news->taxonomy->slug, 'post' => $news->slug]) }}" class="fw-semibold text-body">{{ $news->title }}</a></h6>
                                    <ul class="list-inline list-inline-bullet text-muted fs-sm">
                                        <li class="list-inline-item"><i class="ph-calendar-blank me-2"></i>{{ $news->dateFormatted($news->published_at) }}</li>
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- /popular news -->

                <!-- YouTubes -->
                @if (isset($youtubes) AND $youtubes->count() > 0)
                    <div class="mb-4">
                        <h5 class="fw-bold">Video</h5>

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
                        <h5 class="fw-bold">Galeri Foto</h5>
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
                                        <img class="img-fluid {{ $imgClass }}" src="{{ $photo->thumbSource }}" alt="{{ $photo->title }}">
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

            </aside>

        </div>
        <!-- /content area -->

    </div>
    <!-- /main content -->

</div>
<!-- /page container -->

@if(isset($otherNews) AND $otherNews->count() > 0)
    <!-- Other news -->
    <section class="bg-dark bg-opacity-3">
        <div class="container py-5">
            <div class="content-wrapper">
                <div class="content py-4">
                    <h2 class="fw-bold section-title text-center mb-4 pb-2">Lihat Berita {{ $news->taxonomy->name }} lainnya</h2>
                    <div class="row gx-5">
                        @foreach ($otherNews as $news)
                            <div class="col-xl-4 my-3">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <figure class="figure">
                                            <a href="{{ route('news.show', ['taxonomy' => $news->taxonomy->slug, 'post' => $news->slug]) }}">
                                                <img src="{{ $news->cover->source }}" class="figure-img img-fluid rounded m-0" alt="{{ $news->cover->name }}">
                                            </a>
                                        </figure>

                                        <a href="{{ route('news.taxonomy', ['taxonomy' => $news->taxonomy->slug]) }}" class="badge bg-teal bg-opacity-10 text-teal rounded-pill">{{ $news->taxonomy->name }}</a>
                                        <h4 class="card-title pt-1 mb-1">
                                            <a href="{{ route('news.show', ['taxonomy' => $news->taxonomy->slug, 'post' => $news->slug]) }}" class="text-body">{{ $news->title }}</a>
                                        </h4>

                                        <ul class="list-inline list-inline-bullet text-muted mb-0">
                                            <li class="list-inline-item"><i class="ph-calendar-blank me-2"></i>{{ $news->dateFormatted($news->published_at) }}</li>
                                            <li class="list-inline-item"><i class="ph-eye me-2"></i>{{ $news->view }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /other news -->
@endif

@endsection

@section('script')
    @include('jdih.post.news.script')
@endsection
