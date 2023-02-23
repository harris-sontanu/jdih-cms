@extends('jdih.layouts.app')

@section('title', $legislation->shortTitle . ' | ' . strip_tags($appName))
@section('content')

<div class="page-content container pb-0 mb-4">
    <div class="content-wrapper">
        <div class="d-flex content">
            <div class="breadcrumb">
                <a href="{{ route('homepage') }}" class="breadcrumb-item text-body"><i class="ph-house"></i></a>
                <a href="{{ route('legislation.index') }}" class="breadcrumb-item text-body">Produk Hukum</a>
                <a href="{{ route('legislation.monograph.index') }}" class="breadcrumb-item text-body">Monografi Hukum</a>
                <a href="{{ route('legislation.monograph.category', ['category' => $legislation->category->slug]) }}" class="breadcrumb-item text-body">{{ $legislation->category->name }}</a>
                <span class="breadcrumb-item active">{{ $legislation->shortTitle }}</span>
            </div>

            <a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>
    </div>
</div>

<!-- Page container -->
<div class="page-content container">

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Content area -->
        <main class="content">

            <div class="row gx-5 pb-5">
                <div class="col-xl-6 m-auto">
                    @isset($legislation->masterDocumentSource)
                        <figure id="adobe-dc-view" data-file="{{ $legislation->masterDocumentSource }}" data-name="{{ $legislation->masterDocument()->media->name }}" class="rounded shadow-lg mx-4" style="height: 720px;">
                        </figure>
                        <script src="https://documentservices.adobe.com/view-sdk/viewer.js"></script>
                        <script type="text/javascript">
                            document.addEventListener("adobe_dc_view_sdk.ready", function(){
                                var adobeDCView = new AdobeDC.View({clientId: "{{ $adobeKey }}", divId: "adobe-dc-view"});
                                const article = document.querySelector("#adobe-dc-view");
                                adobeDCView.previewFile({
                                    content:{ location:
                                    { url: article.dataset.file }},
                                    metaData:{fileName: article.dataset.name}
                                },
                                {
                                    embedMode: "SIZED_CONTAINER",
                                    showDownloadPDF: false,
                                    showPrintPDF: false
                                });
                            });
                        </script>
                    @else
                        <figure class="rounded shadow-lg mx-4">
                            <img src="{{ $legislation->coverSource }}" class="img-fluid rounded">
                        </figure>
                    @endisset
                    
                    @isset($legislation->masterDocumentSource)
                        <div class="d-flex mt-4">
                            <div class="flex-grow-1">
                                <button type="submit" class="btn btn-danger btn-lg lift w-100 fw-bold p-3 @empty($legislation->masterDocumentSource) disabled @endempty">Dokumen<i class="ph-download ms-2"></i></button>
                            </div>
                            <div class="ms-3">
                                <button class="btn w-100 btn-pink btn-icon btn-lg lift p-3"><i class="ph-heart"></i></button>
                            </div>
                        </div>
                    @endisset

                    <div class="row gx-4 mt-4">
                        <div class="col">
                            <img src="{{ asset('assets/jdih/images/demo/qrcode.png') }}" alt="qrcode" class="img-fluid p-4">
                        </div>
                        <div class="col">
                            <h6 class="d-block fw-bold">Bagikan:</h6>
                            <ul class="list-inline mb-0">
                                @foreach ($shares as $share)
                                    <li class="list-inline-item me-1 mb-2">
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
                </div>
                <div class="col-xl-6">
                    <h2 class="d-block display-6 fw-bold mb-2">{{ $legislation->shortTitle }}</h2>
                    <ul class="post-meta list-inline list-inline-bullet text-muted mb-4 fs-lg">
                        <li class="list-inline-item"><i class="ph-calendar-blank me-2"></i>{{ $legislation->dateFormatted($legislation->published_at) }}</li>
                        <li class="list-inline-item"><i class="ph-user me-2"></i>{{ $legislation->user->name }}</li>
                        <li class="list-inline-item"><i class="ph-eye me-2"></i>{{ $legislation->view }}</li>
                        <li class="list-inline-item"><i class="ph-download me-2"></i>{{ $legislation->documents->sum('download') }}</li>
                    </ul>
                    <div class="fs-lg">
                        <div class="d-flex mb-3">
                            <div class="me-4">
                                <div class="bg-pink bg-opacity-10 text-pink lh-1 rounded-pill p-2">
                                    <i class="ph-check"></i>
                                </div>
                            </div>
                            <div class="row flex-fill">
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Jenis Monografi</h4>
                                    <p class="mb-0"><a href="{{ route('legislation.monograph.category', ['category' => $legislation->category->slug]) }}" class="text-body"> {{ $legislation->category->name }}</a></p>
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
                                    <p class="mb-0">
                                        <a href="{{ route('legislation.monograph.index', ['field' => $legislation->field->slug]) }}" class="text-body">{{ $legislation->field->name }}</a>
                                    </p>
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
                    </div>

                </div>

                @if (isset($otherLegislations) AND $otherLegislations->count() > 0)
                    <!-- Latest monographs -->
                    <section class="latest-legislation py-5">
                        <div class="d-flex pb-4">
                            <h2 class="fw-bold me-xl-auto section-title mb-0">Monografi Lainnya</h2>
                            <a href="{{ route('legislation.monograph.category', ['category' => $legislation->category->slug]) }}" class="btn btn-dark lift px-3 fw-semibold">Lihat semua Monografi<i class="ph-arrow-right ms-2"></i></a>
                        </div>
                        <div class="row gx-5">
                            @foreach ($otherLegislations as $monograph)
                                <div class="col-xl-4 my-3">
                                    <div class="card lift shadow-lg h-100">
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
                    </section>
                    <!-- /latest monographs -->
                @endif

            </div>

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
