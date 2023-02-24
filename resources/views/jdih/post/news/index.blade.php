@extends('jdih.layouts.app')

@section('title', 'Berita | ' . strip_tags($appName))
@section('content')

<div class="page-content container pb-0 mb-4">
    <div class="content-wrapper">
        <div class="d-flex content">
            <div class="breadcrumb">
                <a href="{{ route('homepage') }}" class="breadcrumb-item text-body"><i class="ph-house"></i></a>
                <span class="breadcrumb-item active">Berita</span>
            </div>

            <a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>
    </div>
</div>

<!-- Page container -->
<div class="page-content container">

    @include('jdih.post.aside', ['view' => 'news'])

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Content area -->
        <main class="content ms-lg-3">

            <div class="row gx-4">
                @foreach ($posts as $news)
                    <div class="col-xl-6">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <figure class="figure">
                                    <img src="{{ $news->cover->source }}" class="figure-img img-fluid rounded m-0" alt="{{ $news->cover->name }}">
                                </figure>

                                <a href="{{ route('news.taxonomy', ['taxonomy' => $news->taxonomy->slug]) }}" class="badge bg-teal bg-opacity-10 text-teal rounded-pill">{{ $news->taxonomy->name }}</a>
                                <h4 class="card-title pt-1 mb-1">
                                    <a href="{{ route('news.show', ['taxonomy' => $news->taxonomy->slug, 'news' => $news->slug]) }}" class="text-body">{{ $news->title }}</a>
                                </h4>

                                <ul class="list-inline list-inline-bullet text-muted mb-3">
                                    <li class="list-inline-item"><i class="ph-calendar-blank me-2"></i>{{ $news->dateFormatted($news->published_at) }}</li>
                                    <li class="list-inline-item"><i class="ph-user me-2"></i>{{ $news->author->name }}</li>
                                    <li class="list-inline-item"><i class="ph-eye me-2"></i>{{ $news->view }}</li>
                                </ul>

                                <div class="fs-lg">
                                    {!! $news->excerpt !!}
                                </div>
                            </div>
                        </div>
                    </div>
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
