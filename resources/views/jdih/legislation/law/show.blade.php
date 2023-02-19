@extends('jdih.layouts.app')

@section('title', $legislation->shortTitle . ' | ' . strip_tags($appName))
@section('content')

<div class="page-content container pb-0">
    <div class="content-wrapper">
        <div class="d-flex content">
            <div class="breadcrumb">
                <a href="{{ route('homepage') }}" class="breadcrumb-item text-body"><i class="ph-house me-2"></i>Beranda</a>
                <a href="{{ route('legislation.index') }}" class="breadcrumb-item text-body">Produk Hukum</a>
                <a href="{{ route('legislation.law.index') }}" class="breadcrumb-item text-body">Peraturan Perundang-undangan</a>
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
                    <figure id="adobe-dc-view" data-file="{{ $legislation->masterDocumentSource }}" data-name="{{ $legislation->masterDocument()->media->name }}" class="rounded shadow-lg" style="height: 700px;">
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
                </div>
                <div class="col-xl-6 ps-3">
                    <h3 class="fw-bold text-danger mb-0">Populer</h3>
                    <a href="{{ route('legislation.law.show', ['category' => $legislation->category->slug, 'legislation' => $legislation->slug]) }}" class="d-block display-6 fw-bold text-body mb-4">{{ $legislation->shortTitle }}</a>
                    <div class="fs-lg">
                        <div class="d-flex mb-3">
                            <div class="me-4">
                                <div class="bg-pink bg-opacity-10 text-pink lh-1 rounded-pill p-2">
                                    <i class="ph-check"></i>
                                </div>
                            </div>
                            <div class="row flex-fill">
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Jenis Dokumen</h4>
                                    <p class="mb-0">{{ $legislation->category->name }}</p>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Nomor</h4>
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
                                    <h4 class="mb-1 fw-bold">Tgl. Penetapan</h4>
                                    <p class="mb-0">{{ $legislation->dateFormatted($legislation->approved) }}</p>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Tgl. Pengundangan</h4>
                                    <p class="mb-0">{{ $legislation->dateFormatted($legislation->approved) }}</p>
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
                                    <p class="mb-0">{!! $legislation->statusBadge !!}</p>
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
                                    <h4 class="mb-1 fw-bold">Pemrakarsa</h4>
                                    <p class="mb-0">{{ $legislation->institute->name }}</p>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Urusan Pemerintahan</h4>
                                    <p class="mb-0">{!! $legislation->matterList !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mt-5">
                            <a href="{{ route('legislation.law.show', ['category' => $legislation->category->slug, 'legislation' => $legislation->slug]) }}" class="btn btn-outline-dark lift px-3 me-3 fw-semibold">Lihat Detail</a>
                            <a href="#" class="btn btn-dark lift px-3 fw-semibold">Unduh<i class="ph-download ms-2"></i></a>
                        </div>
                    </div>
                </div>
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
