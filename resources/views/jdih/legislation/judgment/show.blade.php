@extends('jdih.layouts.app')

@section('title', $legislation->shortTitle . ' | ' . strip_tags($appName))
@section('content')

<!-- Page title -->
<section class="bg-dark bg-opacity-3 mb-4">
    <div class="page-content container py-3 px-0">
        <div class="content-wrapper">
            <div class="content">
                <div class="page-header page-header-content d-lg-flex">
                    <div class="breadcrumb">
                        <a href="{{ route('homepage') }}" class="breadcrumb-item text-body"><i class="ph-house"></i></a>
                        <a href="{{ route('legislation.index') }}" class="breadcrumb-item text-body">Produk Hukum</a>
                        <a href="{{ route('legislation.judgment.index') }}" class="breadcrumb-item text-body">Putusan Pengadilan</a>
                        <a href="{{ route('legislation.judgment.category', ['category' => $legislation->category->slug]) }}" class="breadcrumb-item text-body">{{ $legislation->category->name }}</a>
                        <span class="breadcrumb-item active text-truncate d-inline-block w-25" title="{{ $legislation->shortTitle }}">{{ $legislation->shortTitle }}</span>
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
        <div class="content row gx-4">

            @include('jdih.layouts.like-and-share', ['like' => 5, 'view' => $legislation->view, 'download' => $legislation->documents->sum('download')])

            <main class="col-xl-8">
                <article class="card shadow-sm mb-4">
                    <div class="card-header px-4 pb-0 pt-4 border-bottom-0">
                        <h2 class="d-block display-6 fw-bold mb-2">{{ $legislation->shortTitle }}</h2>
                        <ul class="post-meta list-inline list-inline-bullet text-muted">
                            <li class="list-inline-item"><i class="ph-clock me-2"></i>{{ $legislation->timeFormatted($legislation->published_at, "G:i") }} WITA</li>
                            <li class="list-inline-item"><i class="ph-calendar-blank me-2"></i>{{ $legislation->timeFormatted($legislation->published_at, "l, j F Y") }}</li>
                            <li class="list-inline-item"><i class="ph-user me-2"></i>{{ $legislation->user->name }}</li>
                        </ul>
                    </div>

                    <!-- Meta data -->
                    <section class="card-body fs-lg p-4">
                        <div class="d-flex mb-3">
                            <div class="me-4">
                                <div class="bg-pink bg-opacity-10 text-pink lh-1 rounded-pill p-2">
                                    <i class="ph-check"></i>
                                </div>
                            </div>
                            <div class="row flex-fill">
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Jenis Putusan</h4>
                                    <u><a href="{{ route('legislation.judgment.category', ['category' => $legislation->category->slug]) }}" class="text-body"> {{ $legislation->category->name }}</a></u>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Nomor Putusan</h4>
                                    <p class="mb-0">{{ $legislation->code_number }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="me-4">
                                <div class="bg-pink bg-opacity-10 text-pink lh-1 rounded-pill p-2">
                                    <i class="ph-check"></i>
                                </div>
                            </div>
                            <div class="flex-fill">
                                <h4 class="mb-1 fw-bold">Judul</h4>
                                <p class="mb-0">{{ $legislation->title }}</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="me-4">
                                <div class="bg-pink bg-opacity-10 text-pink lh-1 rounded-pill p-2">
                                    <i class="ph-check"></i>
                                </div>
                            </div>
                            <div class="row flex-fill">
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Jenis Peradilan</h4>
                                    <p class="mb-0">{{ $legislation->justice }}</p>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Singkatan Jenis Peradilan</h4>
                                    <p class="mb-0">
                                        <a href="{{ route('legislation.judgment.category', ['category' => $legislation->category->slug]) }}" class="text-body"> {{ $legislation->category->abbrev }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="me-4">
                                <div class="bg-pink bg-opacity-10 text-pink lh-1 rounded-pill p-2">
                                    <i class="ph-check"></i>
                                </div>
                            </div>
                            <div class="row flex-fill">
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Tgl. Dibacakan</h4>
                                    <p class="mb-0">{{ $legislation->timeFormatted($legislation->published, 'j F Y') }}</p>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">T.E.U. Badan</h4>
                                    <p class="mb-0">{{ $legislation->author }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="me-4">
                                <div class="bg-pink bg-opacity-10 text-pink lh-1 rounded-pill p-2">
                                    <i class="ph-check"></i>
                                </div>
                            </div>
                            <div class="row flex-fill">
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Sumber</h4>
                                    <p class="mb-0">{{ $legislation->source }}</p>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Tempat Peradilan</h4>
                                    <p class="mb-0">{{ $legislation->place }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="me-4">
                                <div class="bg-pink bg-opacity-10 text-pink lh-1 rounded-pill p-2">
                                    <i class="ph-check"></i>
                                </div>
                            </div>
                            <div class="row flex-fill">
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Subjek</h4>
                                    <p class="mb-0">{{ $legislation->subject }}</p>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Status</h4>
                                    <p class="mb-0">{!! $legislation->status->badge() !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="me-4">
                                <div class="bg-pink bg-opacity-10 text-pink lh-1 rounded-pill p-2">
                                    <i class="ph-check"></i>
                                </div>
                            </div>
                            <div class="row flex-fill">
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Bidang Hukum</h4>
                                    <u><a href="{{ route('legislation.judgment.index', ['fields[]' => $legislation->field->slug]) }}" class="text-body">{{ $legislation->field->name }}</a></u>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Bahasa</h4>
                                    <p class="mb-0">{{ $legislation->language }}</p>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- /meta data -->

                </article>

                @isset($legislation->masterDocumentSource)
                    <!-- Documents preview -->
                    <section class="card shadow-sm fs-lg mb-4">
                        <div class="card-header border-bottom-0 pb-0 px-4">
                            <h4 class="fw-bold mb-0">Pratinjau Dokumen</h4>
                        </div>
                        <div class="card-body">
                            <figure id="master-view" data-file="{{ $legislation->masterDocumentSource }}" data-name="{{ $legislation->masterDocument()->media->name }}" class="rounded mb-0" style="height: 720px;">
                            </figure>
                            @include('jdih.legislation.pdfEmbed', ['el' => 'master-view'])
                        </div>
                    </section>
                    <!-- /documents preview -->
                @endisset

                @if (isset($banners) AND $banners->count() > 3)
                    <!-- Banners -->
                    <section class="mb-4">
                        <div class="row gx-4">
                            @foreach ($banners as $banner)
                                @break($loop->iteration > 3)
                                <div class="col-xl-4">
                                    <div class="card bg-white border-0 lift mb-0">
                                        <a href="{{ $banner->url }}"><img src="{{ $banner->image->source }}" class="img-fluid rounded" alt="" srcset=""></a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                    <!-- /banners -->
                @endif
            </main>

            <aside class="col-xl-3">

                <!-- Download -->
                <div class="card shadow mb-4">

                    <div class="card-body">
                        <div class="text-center pt-2">
                            {!! QrCode::size(180)->margin(2)->generate(url()->current()); !!}
                            <p class="mb-0">Pindai kode QR</p>
                        </div>
                        @isset($legislation->masterDocumentSource)
                            <div class="mt-4">
                                <form action="{{ route('legislation.download', $legislation->masterDocument()->id) }}" method="post">
                                    @method('PUT')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-lg btn-labeled btn-labeled-start fw-bold rounded w-100 mb-2">
                                        <span class="btn-labeled-icon bg-black bg-opacity-20">
                                            <i class="ph-download"></i>
                                        </span>
                                        Dokumen
                                    </button>
                                </form>
                            </div>
                        @endisset
                    </div>

                </div>
                <!-- /download -->

                @include('jdih.legislation.rightbar')

            </aside>

        </div>
        <!-- /content area -->

    </div>
    <!-- /main content -->

</div>
<!-- /page container -->

@if(isset($otherLegislations) AND $otherLegislations->count() > 0)
    <!-- Other legislations -->
    <section class="bg-dark bg-opacity-3">
        <div class="container py-5">
            <div class="content-wrapper">
                <div class="content py-4">
                    <h2 class="fw-bold section-title text-center mb-4 pb-2">Lihat {{ $legislation->category->name }} Lainnya</h2>
                    <div class="row gx-4">
                        @foreach ($otherLegislations as $judgment)
                            <div class="col-xl-3 my-3">
                                <div class="card lift h-100">
                                    <a href="{{ route('legislation.judgment.show', ['category' => $judgment->category->slug, 'legislation' => $judgment->slug])}}" class="text-body">
                                        <div class="card-img-actions">
                                            <img class="card-img-top img-fluid" src="{{ $judgment->coverSource }}" alt="">
                                        </div>

                                        <div class="card-body fs-lg pb-0">
                                            <p class="mb-0 text-body">{{ $judgment->title }}</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /other legislations -->
@endif

@endsection

@section('script')
    @include('jdih.legislation.script')
@endsection
