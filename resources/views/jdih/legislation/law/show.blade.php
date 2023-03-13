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
                        <a href="{{ route('legislation.law.index') }}" class="breadcrumb-item text-body">Peraturan Perundang-undangan</a>
                        <a href="{{ route('legislation.law.category', ['category' => $legislation->category->slug]) }}" class="breadcrumb-item text-body">{{ $legislation->category->name }}</a>
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
        <div class="content row gx-5">

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
                                <div class="bg-danger bg-opacity-10 text-danger lh-1 rounded-pill p-2">
                                    <i class="ph-check"></i>
                                </div>
                            </div>
                            <div class="row flex-fill">
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Jenis Dokumen</h4>
                                    <u><a href="{{ route('legislation.law.category', ['category' => $legislation->category->slug]) }}" class="text-body"> {{ $legislation->category->name }}</a></u>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Nomor</h4>
                                    <p class="mb-0">{{ $legislation->code_number }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="me-4">
                                <div class="bg-danger bg-opacity-10 text-danger lh-1 rounded-pill p-2">
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
                                <div class="bg-danger bg-opacity-10 text-danger lh-1 rounded-pill p-2">
                                    <i class="ph-check"></i>
                                </div>
                            </div>
                            <div class="row flex-fill">
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Tgl. Penetapan</h4>
                                    <p class="mb-0">{{ $legislation->timeformatted($legislation->approved, "l, j F Y") }}</p>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Tgl. Pengundangan</h4>
                                    <p class="mb-0">{{ $legislation->timeformatted($legislation->published, "l, j F Y") }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="me-4">
                                <div class="bg-danger bg-opacity-10 text-danger lh-1 rounded-pill p-2">
                                    <i class="ph-check"></i>
                                </div>
                            </div>
                            <div class="row flex-fill">
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Singkatan Jenis</h4>
                                    <u>
                                        <a href="{{ route('legislation.law.category', ['category' => $legislation->category->slug]) }}" class="text-body">{{ $legislation->category->abbrev }}</a>
                                    </u>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">T.E.U. Badan</h4>
                                    <p class="mb-0">{{ $legislation->author }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="me-4">
                                <div class="bg-danger bg-opacity-10 text-danger lh-1 rounded-pill p-2">
                                    <i class="ph-check"></i>
                                </div>
                            </div>
                            <div class="row flex-fill">
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Sumber</h4>
                                    <p class="mb-0">{{ $legislation->source }}</p>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Tempat Terbit</h4>
                                    <p class="mb-0">{{ $legislation->place }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="me-4">
                                <div class="bg-danger bg-opacity-10 text-danger lh-1 rounded-pill p-2">
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
                                    <p class="mb-0">
                                        <a href="{{ route('legislation.law.index', ['status' => $legislation->status]) }}" class="text-body">{!! $legislation->statusBadge !!}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="me-4">
                                <div class="bg-danger bg-opacity-10 text-danger lh-1 rounded-pill p-2">
                                    <i class="ph-check"></i>
                                </div>
                            </div>
                            <div class="row flex-fill">
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Bidang Hukum</h4>
                                    <u>
                                        <a href="{{ route('legislation.law.index', ['fields[]' => $legislation->field->slug]) }}" class="text-body">{{ $legislation->field->name }}</a>
                                    </u>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Bahasa</h4>
                                    <p class="mb-0">{{ $legislation->language }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="me-4">
                                <div class="bg-danger bg-opacity-10 text-danger lh-1 rounded-pill p-2">
                                    <i class="ph-check"></i>
                                </div>
                            </div>
                            <div class="row flex-fill">
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Pemrakarsa</h4>
                                    <u>
                                        <a href="{{ route('legislation.law.index', ['institutes[]' => $legislation->institute->slug]) }}" class="text-body">{{ $legislation->institute->name }}</a>
                                    </u>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Urusan Pemerintahan</h4>
                                    @if($legislation->matters->count() > 0)
                                        <ul class="list-inline mb-0">
                                            @foreach ($legislation->matters as $matter)
                                                <li class="list-inline-item me-1 mb-1"><a href="{{ route('legislation.law.index', ['matters[]' => $matter->slug]) }}" class="badge bg-purple bg-opacity-20 text-purple">{{ $matter->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="me-4">
                                <div class="bg-danger bg-opacity-10 text-danger lh-1 rounded-pill p-2">
                                    <i class="ph-check"></i>
                                </div>
                            </div>
                            <div class="row flex-fill">
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Lokasi</h4>
                                    <p class="mb-0">{{ $legislation->location }}</p>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Penandatangan</h4>
                                    <p class="mb-0">{{ $legislation->signer }}</p>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- /meta data -->

                </article>

                <!-- Legislation relationships -->
                <section class="card shadow-sm fs-lg mb-4">
                    <div class="card-header border-bottom-0 pb-0 px-4">
                        <h4 class="fw-bold mb-0">Produk Hukum Terkait</h4>
                    </div>

                    <div class="card-body fs-lg p-0">
                        <ul class="nav nav-tabs nav-tabs-underline" role="tablist">
                            <li class="nav-item" role="presentation">
                                <h6 class="mb-0"><a class="nav-link active py-3 px-4" data-bs-toggle="tab" role="tab" aria-current="page" href="#status">Keterangan Status</a></h6>
                            </li>
                            <li class="nav-item" role="presentation">
                                <h6 class="mb-0"><a class="nav-link disabled py-3 px-4" data-bs-toggle="tab" role="tab" href="#legislation">Peraturan</a></h6>
                            </li>
                            <li class="nav-item" role="presentation">
                                <h6 class="mb-0"><a class="nav-link disabled py-3 px-4" data-bs-toggle="tab" role="tab" href="#document">Dokumen</a></h6>
                            </li>
                        </ul>

                        <div class="tab-content p-4 fs-lg">
                            <div class="tab-pane fade active show" id="status" role="tabpanel">
                                <ol class="list mb-0">
                                    @forelse ($statusRelationships as $relation)
                                        <li class="mb-3"><span class="fw-bold">{{ Str::ucfirst($relation->statusPhrase) }}</span> <u><a href="{{ route('admin.legislation.law.show', $relation->related_to) }}" target="_blank" class="text-body">{{ $relation->relatedTo->title }}</a></u> {{ $relation->note }}</li>
                                    @empty
                                        <span class="d-block mb-3 text-muted">Tidak ada data</span>
                                    @endforelse
                                </ol>
                            </div>

                            <div class="tab-pane fade" id="legislation" role="tabpanel">
                                <ol class="list mb-0">
                                    @forelse ($lawRelationships as $relation)
                                        <li class="mb-3"><span class="fw-bold">{{ Str::ucfirst($relation->statusPhrase) }}</span> <a href="{{ route('admin.legislation.law.show', $relation->related_to) }}" target="_blank" class="text-body">{{ $relation->relatedTo->title }}</a> {{ $relation-> note }}</li>
                                    @empty
                                        <span class="d-block mb-3 text-muted">Tidak ada data</span>
                                    @endforelse
                                </ol>
                            </div>

                            <div class="tab-pane fade" id="document" role="tabpanel">
                                <ol class="list mb-0">
                                    @forelse ($documentRelationships as $relation)
                                        <li class="mb-3"><span class="fw-bold">{{ Str::ucfirst($relation->statusPhrase) }}</span> <a href="{{ route('admin.legislation.law.show', $relation->related_to) }}" target="_blank" class="text-body">{{ $relation->relatedTo->title }}</a> {{ $relation-> note }}</li>
                                    @empty
                                        <span class="d-block mb-3 text-muted">Tidak ada data</span>
                                    @endforelse
                                </ol>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /legislation relationships -->

                <!-- Documents preview -->
                <section class="card shadow-sm fs-lg mb-4">
                    <div class="card-header border-bottom-0 pb-0 px-4">
                        <h4 class="fw-bold mb-0">Pratinjau Dokumen</h4>
                    </div>
                    <div class="card-body p-0">
                        <ul class="nav nav-tabs nav-tabs-underline" role="tablist">
                            <li class="nav-item" role="presentation">
                                <h6 class="mb-0"><a class="nav-link active py-3 px-4" data-bs-toggle="tab" role="tab" aria-current="page" href="#master">Peraturan</a></h6>
                            </li>
                            @if ($legislation->attachments()->count() > 0)
                                <li class="nav-item dropdown" role="presentation">
                                    <a href="#" class="nav-link py-3 px-4 fw-semibold" data-bs-toggle="dropdown">Lampiran</a>
                                    <div class="dropdown-menu">
                                        @foreach ($legislation->attachments() as $attachment)
                                            <a href="#lampiran-{{ $attachment->media->id}}" class="dropdown-item" data-bs-toggle="tab" role="tab">{{ $attachment->media->name}}</a>
                                        @endforeach
                                    </div>
                                </li>
                            @endif
                            <li class="nav-item" role="presentation">
                                <h6 class="mb-0"><a class="nav-link py-3 px-4" data-bs-toggle="tab" role="tab" href="#abstract">Abstrak</a></h6>
                            </li>
                        </ul>

                        <div class="tab-content p-4 fs-lg">
                            <div class="tab-pane fade active show" id="master" role="tabpanel">
                                @isset($legislation->masterDocumentSource)
                                    <figure id="master-view" data-file="{{ $legislation->masterDocumentSource }}" data-name="{{ $legislation->masterDocument()->media->name }}" class="rounded mb-0" style="height: 720px;">
                                    </figure>
                                    @include('jdih.legislation.pdfEmbed', ['el' => 'master-view'])
                                @else
                                    <figure class="rounded mb-0">
                                        <img src="{{ asset('assets/jdih/images/illustrations/file-not-found.jpeg') }}" class="img-fluid rounded">
                                    </figure>
                                @endisset
                            </div>
                            @foreach ($legislation->attachments() as $attachment)
                                <div class="tab-pane fade" id="lampiran-{{ $attachment->media->id }}" role="tabpanel">
                                    <figure id="attachment-{{ $attachment->media->id }}-view" data-file="{{ $legislation->documentSource($attachment->media->path) }}" data-name="{{ $attachment->media->name }}" class="rounded mb-0" style="height: 720px;">
                                    </figure>
                                    @include('jdih.legislation.pdfEmbed', ['el' => 'attachment-' . $attachment->media->id . '-view'])
                                </div>
                            @endforeach
                            <div class="tab-pane fade" id="abstract" role="tabpanel">
                                @isset($legislation->abstractDocumentSource)
                                    <figure id="abstract-view" data-file="{{ $legislation->abstractDocumentSource }}" data-name="{{ $legislation->abstractDocument()->media->name }}" class="rounded mb-0" style="height: 720px;">
                                    </figure>
                                    @include('jdih.legislation.pdfEmbed', ['el' => 'abstract-view'])
                                @else
                                    <figure class="rounded mb-0">
                                        <img src="{{ asset('assets/jdih/images/illustrations/file-not-found.jpeg') }}" class="img-fluid rounded">
                                    </figure>
                                @endisset
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /documents preview -->

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

                    <div class="card-body">
                        <div class="text-center pt-2">
                            {!! QrCode::size(180)->margin(2)->generate(url()->current()); !!}
                            <p class="mb-0">Pindai kode QR</p>
                        </div>
                        <div class="mt-4">
                            @isset($legislation->masterDocumentSource)
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
                            @endisset

                            @isset($legislation->abstractDocument()->id)
                                <form action="{{ route('legislation.download', $legislation->abstractDocument()->id) }}" method="post">
                                    @method('PUT')
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-lg btn-labeled btn-labeled-start fw-bold w-100 rounded">
                                        <span class="btn-labeled-icon bg-danger text-white">
                                            <i class="ph-download"></i>
                                        </span>
                                        Abstrak
                                    </button>
                                </form>
                            @endisset
                        </div>
                    </div>

                </div>
                <!-- /download -->

                <!-- Latest News -->
                <div class="mt-4">
                    <h5 class="fw-bold mb-3">Berita Terbaru</h5>

                    @foreach ($latestNews as $news)
                        <div class="d-flex mb-3 @if (!$loop->last) border-bottom @endif">
                            <a href="{{ route('news.show', ['taxonomy' => $news->taxonomy->slug, 'post' => $news->slug]) }}" class="me-3">
                                <img src="{{ $news->cover->thumbSource }}" class="rounded shadow" alt="{{ $news->cover->name }}" width="48">
                            </a>
                            <div class="flex-fill">
                                <h6 class="mb-1"><a href="{{ route('news.show', ['taxonomy' => $news->taxonomy->slug, 'post' => $news->slug]) }}" class="fw-semibold text-body">{{ $news->title }}</a></h6>
                                <ul class="list-inline list-inline-bullet text-muted fs-sm @if ($loop->last) mb-0 @endif">
                                    <li class="list-inline-item"><i class="ph-calendar-blank me-2"></i>{{ $news->dateFormatted($news->published_at) }}</li>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- /latest news -->

                <!-- Infographs -->
                <div class="mt-4">
                    <img src="{{ asset('assets/jdih/images/demo/WhatsApp_Image_2023-02-20_at_11_30_59.jpeg') }}" class="img-fluid shadow rounded">
                    <img src="{{ asset('assets/jdih/images/demo/akhlak_biro_hukum.jpg') }}" class="img-fluid shadow rounded mt-3">
                    <img src="{{ asset('assets/jdih/images/demo/WhatsApp_Image_2022-12-05_at_13_35_10.jpeg') }}" class="img-fluid shadow rounded mt-3">
                </div>
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
                        @foreach ($otherLegislations as $law)
                            <div class="col-xl-4 my-3">
                                <div class="card lift shadow h-100">
                                    <a href="{{ route('legislation.law.show', ['category' => $law->category->slug, 'legislation' => $law->slug])}}" class="text-body link-danger">
                                        <div class="card-header border-0 pb-0">
                                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill mb-2">{{ $law->category->name }}</span>
                                            <h4 class="fw-bold mb-0">{{ $law->shortTitle }}</h4>
                                        </div>
                                        <div class="card-body fs-lg pb-0">
                                            <p class="mb-0 text-body">{{ $law->title }}</p>
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
