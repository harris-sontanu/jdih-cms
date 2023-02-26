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

                    <div class="post-body fs-5">
                        {!! $news->body !!}
                    </div>
                </div>

                <div class="col-xl-3 offset-xl-1">
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
                </div>
            </div>

        </main>
        <!-- /content area -->

    </div>
    <!-- /main content -->

</div>
<!-- /page container -->

@endsection
