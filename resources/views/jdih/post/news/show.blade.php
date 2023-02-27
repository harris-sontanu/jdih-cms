@extends('jdih.layouts.app')

@section('title', $news->title . ' | ' . strip_tags($appName))
@section('content')

<!-- Page container -->
<div class="page-content container">

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Content area -->
        <main class="content ms-lg-3">
            <div class="row gx-5">
                <div class="col-xl-8 mb-4">

                    <article class="post-entry">
                        <div class="post-title my-4">
                            <h3 class="fw-bold mb-2"><a href="#" class="link-danger">Neque</a></h3>
                            <h2 class="display-6 fw-bold">{{ $news->title }}</h2>
                            <ul class="post-meta list-inline list-inline-bullet text-muted mb-3">
                                <li class="list-inline-item"><i class="ph-calendar-blank me-2"></i>{{ $news->dateFormatted($news->published_at) }}</li>
                                <li class="list-inline-item"><i class="ph-user me-2"></i>{{ $news->author->name }}</li>
                                <li class="list-inline-item"><i class="ph-eye me-2"></i>{{ $news->view }}</li>
                            </ul>
                        </div>
    
                        <figure class="figure mb-4">
                            <img src="{{ $news->cover->source }}" class="figure-img img-fluid rounded shadow-lg" alt="...">
                            <figcaption class="figure-caption fs-6">{{ $news->cover->caption }}</figcaption>
                        </figure>
    
                        <div class="post-body fs-5 mb-4">
                            {!! $news->body !!}
                        </div>
    
                        @if (!empty($news->galleries) AND count($news->galleries) > 0)
                            <h3 class="fw-bold mb-4">Foto-foto</h3>
                            <div class="row gx-4">
                                @foreach ($news->galleries as $gallery)
                                    <div class="col-4">
                                        <div class="card shadow-lg mb-4">
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
                        
                        <div class="post-share fs-lg d-flex align-items-center mb-4 border-top border-bottom py-4">
                            @isset($news->source)
                                <p class="fs-lg mb-0"><span class="fw-bold">Sumber:</span> {{ $news->source }}</p>
                            @endisset
                            <div class="ms-auto">
                                <ul class="list-inline mb-0 ms-3">
                                    @foreach ($shares as $share)
                                        <li class="list-inline-item me-1">
                                            <a href="{{ $share['url'] }}" target="_blank" class="btn btn-{{ $share['color'] }} rounded-pill p-2 lift" title="Bagikan ke {{ $share['title'] }}" data-bs-popup="tooltip">
                                                <i class="{{ $share['icon'] }} m-1"></i>
                                            </a>
                                        </li>
                                    @endforeach
                                    <li class="list-inline-item">
                                        <button type="button" data-url="{{ url()->current() }}" class="copy-link btn btn-light rounded-pill p-2 lift" title="Salin URL" data-bs-popup="tooltip">
                                            <i class="ph-link m-1"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </article>

                </div>

                <aside class="col-xl-3 offset-xl-1">

                    <!-- Popular News -->
                    <div class="mt-4">
                        <h5 class="fw-bold mb-4">Berita Populer</h5>

                        <div class="sidebar-section-body px-0 pb-0">
                            @foreach ($popularNews as $news)
                                <div class="d-flex mb-3">
                                    <a href="#" class="me-3">
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

                </aside>
            </div>

        </main>
        <!-- /content area -->

    </div>
    <!-- /main content -->

</div>
<!-- /page container -->

<!-- Other news -->
<section class="bg-dark bg-opacity-3">
    <div class="container py-5">
        <div class="content-wrapper">
            <div class="content py-4">
                <h2 class="fw-bold section-title text-center mb-4 pb-2">Lihat Berita {{ $news->taxonomy->name }} lainnya</h2>
                <div class="row gx-5">
                    @foreach ($otherNews as $news)
                        <div class="col-xl-4 my-3">
                            <div class="card shadow-lg">
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

@endsection

@section('script')
    @include('jdih.post.news.script')
@endsection
