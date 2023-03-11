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
                        <a href="{{ route('legislation.monograph.index') }}" class="breadcrumb-item text-body">Monografi Hukum</a>
                        <a href="{{ route('legislation.monograph.category', ['category' => $legislation->category->slug]) }}" class="breadcrumb-item text-body">{{ $legislation->category->name }}</a>
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
        <main class="content row gx-5">

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
                                    <h4 class="mb-1 fw-bold">Jenis Monografi</h4>
                                    <u><a href="{{ route('legislation.monograph.category', ['category' => $legislation->category->slug]) }}" class="text-body"> {{ $legislation->category->name }}</a></u>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Tahun Terbit</h4>
                                    <p class="mb-0">{{ $legislation->year }}</p>
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
                                <h4 class="mb-1 fw-bold">T.E.U. Orang/Badan</h4>
                                <p class="mb-0">{{ $legislation->author }}</p>
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
                                    <h4 class="mb-1 fw-bold">Edisi</h4>
                                    <p class="mb-0">{{ $legislation->edition }}</p>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Nomor Panggil</h4>
                                    <p class="mb-0">{{ $legislation->call_number }}</p>
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
                                    <h4 class="mb-1 fw-bold">Tempat Terbit</h4>
                                    <p class="mb-0">{{ $legislation->place }}</p>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Penerbit</h4>
                                    <p class="mb-0">{{ $legislation->publisher }}</p>
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
                                    <h4 class="mb-1 fw-bold">Deskripsi Fisik</h4>
                                    <p class="mb-0">{{ $legislation->desc }}</p>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">ISBN</h4>
                                    <p class="mb-0">{{ $legislation->isbn }}</p>
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
                                <h4 class="mb-1 fw-bold">Subjek</h4>
                                <p class="mb-0">{{ $legislation->subject }}</p>
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
                                    <u><a href="{{ route('legislation.monograph.index', ['field' => $legislation->field->slug]) }}" class="text-body">{{ $legislation->field->name }}</a></u>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Bahasa</h4>
                                    <p class="mb-0">{{ $legislation->language }}</p>
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
                                    <h4 class="mb-1 fw-bold">Eksemplar</h4>
                                    <p class="mb-0">{{ $legislation->index_number }}</p>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Lokasi</h4>
                                    <p class="mb-0">{{ $legislation->location }}</p>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- /meta data -->

                </article>

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
                <div class="card shadow">

                    <img class="card-img-top img-fluid border-bottom" src="{{ $legislation->coverSource }}" alt="{{ $legislation->title }}">

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

                <!-- Latest News -->
                @if (isset($latestNews) AND $latestNews->count() > 0)
                    <div class="mt-4">
                        <h5 class="fw-bold mb-3">Berita Terbaru</h5>

                        <div class="sidebar-section-body px-0 pb-0">
                            @foreach ($latestNews as $news)
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
                @endif
                <!-- /latest news -->

                <!-- Infographs -->
                {{-- <div class="mt-4">
                    <img src="{{ asset('assets/jdih/images/demo/WhatsApp_Image_2023-02-20_at_11_30_59.jpeg') }}" class="img-fluid shadow rounded">
                    <img src="{{ asset('assets/jdih/images/demo/akhlak_biro_hukum.jpg') }}" class="img-fluid shadow rounded mt-3">
                    <img src="{{ asset('assets/jdih/images/demo/WhatsApp_Image_2022-12-05_at_13_35_10.jpeg') }}" class="img-fluid shadow rounded mt-3">
                </div> --}}
                <!-- /infographs -->

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
                        @foreach ($otherLegislations as $monograph)
                            <div class="col-xl-3 my-3">
                                <div class="card lift h-100">
                                    <a href="{{ route('legislation.monograph.show', ['category' => $monograph->category->slug, 'legislation' => $monograph->slug])}}" class="text-body">
                                        <div class="card-img-actions mx-1 mt-1">
                                            <img class="card-img img-fluid" src="{{ $monograph->coverSource }}" alt="">
                                        </div>

                                        <div class="card-body fs-lg pb-0">
                                            <p class="mb-0 text-body">{{ $monograph->title }}</p>
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
