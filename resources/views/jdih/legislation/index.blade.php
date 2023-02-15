@extends('jdih.layouts.app')

@section('title', 'Produk Hukum | ' . $appName)
@section('content')

<div class="page-content container pb-0">
    <div class="content-wrapper">
        <div class="d-flex content">
            <div class="breadcrumb">
                <a href="{{ route('homepage') }}" class="breadcrumb-item text-body"><i class="ph-house me-2"></i>Beranda</a>
                <span class="breadcrumb-item active">Produk Hukum</span>
            </div>

            <a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>
    </div>
</div>

<!-- Page container -->
<div class="page-content container">

    @include('jdih.legislation.aside')

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
                    produk hukum
                </p>
                <div class="ms-auto my-auto">
                    <span class="d-inline-block me-2">Urutkan</span>
                    <div class="btn-group">
                        <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown">Terbaru</button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="#" class="dropdown-item active">Terbaru</a>
                            <a href="#" class="dropdown-item">Terpopuler</a>
                            <a href="#" class="dropdown-item">Nomor kecil ke besar</a>
                            <a href="#" class="dropdown-item">Dilihat paling banyak</a>
                            <a href="#" class="dropdown-item">Dilihat paling sedikit</a>
                        </div>
                    </div>
                </div>
            </section>

            @foreach ($legislations as $legislation)
                <article class="card card-body shadow-lg mb-4">
                    <div class="d-sm-flex align-items-sm-start">

                        <a href="#" class="d-block me-sm-3 mb-3 mb-sm-0">
                            <img @isset ($legislation->masterDocumentSource) data-pdf-thumbnail-file="{{ $legislation->masterDocumentSource }}" @endisset src="{{ $legislation->coverThumbSource }}" alt="{{ $legislation->title }}" class="w-lg-120px border">
                        </a>

                        <div class="flex-fill">
                            <a href="#" class="badge bg-indigo bg-opacity-10 text-indigo rounded-pill mb-1">{{ $legislation->category->name }}</a>
                            <h4 class="mb-1">
                                <a href="#" class="text-body">{{ $legislation->shortTitle }}</a>
                            </h4>

                            <ul class="list-inline list-inline-bullet text-muted mb-3">
                                <li class="list-inline-item"><i class="ph-calendar-blank me-2"></i>{{ $legislation->dateFormatted($legislation->published_at) }}</li>
                                <li class="list-inline-item"><i class="ph-eye me-2"></i>{{ $legislation->view }}</li>
                                <li class="list-inline-item"><i class="ph-download me-2"></i>{{ $legislation->documents->sum('download') }}</li>
                            </ul>
                            
                            <p class="fs-lg mb-0">{!! $legislation->excerpt !!}</p>
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
