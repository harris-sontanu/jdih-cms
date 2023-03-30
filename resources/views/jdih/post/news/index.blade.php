@extends('jdih.layouts.app')

@section('title', 'Berita | ' . strip_tags($appName))
@section('content')

<!-- Page title -->
<section class="bg-dark bg-opacity-3 mb-4">
    <div class="page-content container py-3 px-0">
        <div class="content-wrapper">
            <div class="content">
                <div class="page-header page-header-content d-lg-flex">
                    <div class="page-title">
                        <h2 class="fw-bold mb-0">
                            @isset($taxonomy)
                                {{ $taxonomy->name }}
                            @else
                                @if (Request::get('title'))
                                    Cari Berita tentang "{{ Request::get('title') }}"
                                @else
                                    Berita
                                @endif
                            @endif
                        </h2>
                    </div>

                    <div class="mb-3 my-lg-auto ms-lg-auto">
                        <div class="breadcrumb">
                            <a href="{{ route('homepage') }}" class="breadcrumb-item text-body"><i class="ph-house"></i></a>
                            @isset($taxonomy)
                                <a href="{{ route('news.index') }}" class="breadcrumb-item text-body">Berita</a>
                                <span class="breadcrumb-item active">{{ $taxonomy->name }}</span>
                            @else
                                <span class="breadcrumb-item active">Berita</span>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /page title -->

<!-- Page container -->
<div class="page-content container">

    @include('jdih.post.aside', ['view' => 'jdih.post.news.filter'])

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Content area -->
        <main class="content ms-lg-3">

            <div class="row gx-4">
                @foreach ($posts as $news)
                    <article class="col-xl-6 mb-4">
                        <div class="card shadow mb-0">
                            <figure class="figure mb-0">
                                <a href="{{ route('news.show', ['taxonomy' => $news->taxonomy->slug, 'post' => $news->slug]) }}">
                                    <img src="{{ $news->cover->source }}" class="figure-img img-fluid card-img-top m-0" alt="{{ $news->cover->name }}">
                                </a>
                            </figure>
                            <div class="card-body">
                                <a href="{{ route('news.taxonomy', ['taxonomy' => $news->taxonomy->slug]) }}" class="badge bg-danger bg-opacity-10 text-danger rounded-pill">{{ $news->taxonomy->name }}</a>
                                <h4 class="card-title pt-1 mb-1">
                                    <a href="{{ route('news.show', ['taxonomy' => $news->taxonomy->slug, 'post' => $news->slug]) }}" class="text-body">{{ $news->title }}</a>
                                </h4>

                                <ul class="list-inline list-inline-bullet text-muted mb-3">
                                    <li class="list-inline-item"><i class="ph-calendar-blank me-2"></i>{{ $news->dateFormatted($news->published_at) }}</li>
                                    <li class="list-inline-item"><i class="ph-eye me-2"></i>{{ $news->view }}</li>
                                </ul>

                                <div class="fs-lg">
                                    {!! $news->excerpt !!}
                                </div>
                            </div>
                        </div>
                    </article>

                    @if (isset($banners) AND $banners->count() > 0)
                        @if ($loop->last)
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
                    @endif

                @endforeach
            </div>

            {{ $posts->links('jdih.layouts.pagination') }}

        </main>
        <!-- /content area -->

    </div>
    <!-- /main content -->

</div>
<!-- /page container -->

@endsection

@section('script')
    @include('jdih.post.news.script')
@endsection
