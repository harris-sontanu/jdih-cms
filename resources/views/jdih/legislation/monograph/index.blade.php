@extends('jdih.layouts.app')

@section('title', 'Monografi Hukum | ' . strip_tags($appName))
@section('content')

<div class="page-content container pb-0">
    <div class="content-wrapper">
        <div class="d-flex content">
            <div class="breadcrumb">
                <a href="{{ route('homepage') }}" class="breadcrumb-item text-body"><i class="ph-house me-2"></i>Beranda</a>
                <a href="{{ route('legislation.index') }}" class="breadcrumb-item text-body">Produk Hukum</a>
                @isset($category)
                    <a href="{{ route('legislation.monograph.index') }}" class="breadcrumb-item text-body">Monografi Hukum</a>
                    <span class="breadcrumb-item active">{{ $category->name }}</span>
                @else
                    <span class="breadcrumb-item active">Monografi Hukum</span>
                @endisset
            </div>

            <a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>
    </div>
</div>

<!-- Page container -->
<div class="page-content container">

    @include('jdih.legislation.aside', ['view' => 'monograph'])

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Content area -->
        <main class="content ms-lg-3">

            <section class="d-flex align-items-center mb-3">
                <p class="mb-0">
                    Menampilkan
                    <span class="fw-semibold">{{ $legislations->firstItem() }}</span>
                    sampai
                    <span class="fw-semibold">{{ $legislations->lastItem() }}</span>
                    dari
                    <span class="fw-semibold">{{ number_format($legislations->total(), 0, ',', '.') }}</span>
                    monografi
                    @if (Request::get('title'))
                        untuk
                        <span class="fw-semibold">"{{ Request::get('title') }}"</span>
                    @endif

                    @isset($category)
                        untuk jenis
                        <span class="fw-semibold">"{{ $category->name }}"</span>
                    @endisset
                </p>
                <div class="ms-auto my-auto">
                    <span class="d-inline-block me-2">Urutkan</span>
                    <div class="btn-group">
                        <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown">
                            @if(Request::get('order'))
                                {{ $orderOptions[Request::get('order')] }}
                            @else
                                {{ head($orderOptions) }}
                            @endif
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            @foreach ($orderOptions as $key => $value)
                                <a
                                @isset ($category)
                                    href="{{ route('legislation.monograph.category', ['category' => $category->slug, 'order' => $key] + Request::query()) }}"
                                @else
                                    href="{{ route('legislation.monograph.index', ['order' => $key] + Request::query()) }}"
                                @endisset
                                    class="dropdown-item @if(Request::get('order') === $key OR (empty(Request::get('order')) AND $loop->first)) active @endif">
                                    {{ $value }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            @foreach ($legislations as $legislation)
                <article class="card card-body shadow-lg mb-4">
                    <div class="d-sm-flex align-items-sm-start">

                        <a href="{{ route('legislation.monograph.show', ['category' => $legislation->category->slug, 'legislation' => $legislation->slug]) }}" class="d-block me-sm-3 mb-3 mb-sm-0">
                            <img @isset ($legislation->masterDocumentSource) data-pdf-thumbnail-file="{{ $legislation->masterDocumentSource }}" @endisset src="{{ $legislation->coverThumbSource }}" alt="{{ $legislation->title }}" class="w-lg-120px border">
                        </a>

                        <div class="flex-fill">
                            <a href="{{ route('legislation.monograph.category', $legislation->category->slug) }}" class="badge bg-indigo bg-opacity-10 text-indigo rounded-pill mb-1">{{ $legislation->category->name }}</a>
                            <h4 class="mb-1">
                                <a href="{{ route('legislation.monograph.show', ['category' => $legislation->category->slug, 'legislation' => $legislation->slug]) }}" class="text-body">{!! Str::highlightPhrase($legislation->shortTitle, Request::get('title')) !!}</a>
                            </h4>

                            <ul class="list-inline list-inline-bullet text-muted mb-3">
                                <li class="list-inline-item"><i class="ph-calendar-blank me-2"></i>{{ $legislation->dateFormatted($legislation->published_at) }}</li>
                                <li class="list-inline-item"><i class="ph-eye me-2"></i>{{ $legislation->view }}</li>
                                <li class="list-inline-item"><i class="ph-download me-2"></i>{{ $legislation->documents->sum('download') }}</li>
                            </ul>

                            <p class="fs-lg mb-0">{!! Str::highlightPhrase($legislation->excerpt, Request::get('title')) !!}</p>
                        </div>

                        @isset($legislation->status)
                            <div class="flex-shrink-0 ms-sm-3 mt-2 mt-sm-0">
                                {!! $legislation->statusBadge !!}
                            </div>
                        @endisset
                    </div>
                </article>
            @endforeach

            {{ $legislations->links('jdih.layouts.pagination') }}

        </main>
        <!-- /content area -->

    </div>
    <!-- /main content -->

</div>
<!-- /page container -->

@endsection

@section('script')
    @include('jdih.legislation.script')
@endsection
