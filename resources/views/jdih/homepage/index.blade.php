@extends('jdih.layouts.app')

@section('content')

@include('jdih.homepage.slide')

<section class="bg-dark">
    <div class="container pt-5 pb-0">
        <div class="content-wrapper">
            <div class="content row mb-5">
                <div class="col-12 col-md-3">
                    <img src="{{ asset('assets/admin/images/demo/users/face12.jpg') }}" class="rounded-circle d-block m-auto" height="160">
                </div>
                <div class="col-12 col-md-9 text-light">
                    <h2 class="mb-3 text-handwriting">Sekapur Sirih</h2>
                    <p class="fs-lg">Situs ini merupakan situs resmi Biro Hukum Setda Provinsi Bali. Situs ini memuat data dan informasi-informasi produk hukum baik produk hukum pusat maupun daerah. Disamping itu, situs ini memuat pula informasi mengenai buku-buku referensi tentang hukum yang dimiliki oleh Biro Hukum Provinsi Bali.<br></p>
                    <div class="author mt-4">
                        <span class="fw-semibold">IDA BAGUS GEDE SUDARSANA, SH</span><br>
                        <span class="text-light fs-sm">Kepala Biro  Hukum </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container">
    <div class="content-wrapper">
        <div class="content py-5">
            <div class="d-flex pb-4">
                <h2 class="fw-bold me-xl-auto section-title mb-0">Statistik Produk Hukum</h2>
                <a href="#" class="btn btn-dark lift px-3 fw-semibold">Lihat Statistik lainnya<i class="ph-arrow-right ms-2"></i></a>
            </div>
            <div class="row gx-5">
                <div class="col-sm-6 col-xl-3">
                    <div class="card card-body shadow-lg lift">
                        <a href="#" class="text-dark">
                            <div class="d-flex align-items-center">
                                <i class="ph-scales ph-2x text-success me-3"></i>

                                <div class="flex-fill text-end">
                                    <h4 class="mb-0">{{ $totalLaws }}</h4>
                                    <span class="text-muted">total peraturan</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card card-body shadow-lg lift">
                        <a href="#" class="text-dark">
                            <div class="d-flex align-items-center">
                                <i class="ph-books ph-2x text-indigo me-3"></i>

                                <div class="flex-fill text-end">
                                    <h4 class="mb-0">{{ $totalMonographs }}</h4>
                                    <span class="text-muted">total monografi</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card card-body shadow-lg lift">
                        <a href="#" class="text-dark">
                            <div class="d-flex align-items-center">
                                <div class="flex-fill">
                                    <h4 class="mb-0">{{ $totalArticles }}</h4>
                                    <span class="text-muted">total artikel</span>
                                </div>

                                <i class="ph-newspaper ph-2x text-primary ms-3"></i>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card card-body shadow-lg lift">
                        <a href="#" class="text-dark">
                            <div class="d-flex align-items-center">
                                <div class="flex-fill">
                                    <h4 class="mb-0">{{ $totalJudgments }}</h4>
                                    <span class="text-muted">total putusan</span>
                                </div>

                                <i class="ph-stamp ph-2x text-danger ms-3"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Page content -->
<div class="page-content container">

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Content area -->
        <div class="content">

            <div class="row gx-5 pb-5">
                <div class="col-xl-6 m-auto">
                    <figure id="adobe-dc-view" data-file="{{ $popularLawDoc->media->source }}" data-name="{{ $popularLawDoc->media->name }}" class="rounded shadow-lg" style="height: 700px;">
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
                    <a href="#" class="d-block display-6 fw-bold text-body mb-4">{{ $popularLaw->shortTitle }}</a>
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
                                    <p class="mb-0">{{ $popularLaw->category->name }}</p>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Nomor</h4>
                                    <p class="mb-0">{{ $popularLaw->code_number }}</p>
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
                                <p class="mb-0">{{ $popularLaw->title }}</p>
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
                                    <p class="mb-0">{{ $popularLaw->dateFormatted($popularLaw->approved) }}</p>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Tgl. Pengundangan</h4>
                                    <p class="mb-0">{{ $popularLaw->dateFormatted($popularLaw->approved) }}</p>
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
                                    <p class="mb-0">{{ $popularLaw->subject }}</p>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Status</h4>
                                    <p class="mb-0">{!! $popularLaw->statusBadge !!}</p>
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
                                    <p class="mb-0">{{ $popularLaw->institute->name }}</p>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-1 fw-bold">Urusan Pemerintahan</h4>
                                    <p class="mb-0">{!! $popularLaw->matterList !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mt-5">
                            <a href="#" class="btn btn-outline-dark lift px-3 me-3 fw-semibold">Lihat Detail</a>
                            <a href="#" class="btn btn-dark lift px-3 fw-semibold">Unduh<i class="ph-download ms-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <section class="latest-legislation py-5">
                <div class="d-flex pb-4">
                    <h2 class="fw-bold me-xl-auto section-title mb-0">Peraturan Terbaru</h2>
                    <a href="#" class="btn btn-dark lift px-3 fw-semibold">Lihat semua Peraturan<i class="ph-arrow-right ms-2"></i></a>
                </div>
                <div class="row gx-5">
                    @foreach ($latestLaws as $law)                        
                        <div class="col-xl-4 my-3">
                            <div class="card lift shadow-lg h-100">
                                <a href="#" class="text-body link-danger">
                                    <div class="card-header border-0 pb-0">
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill mb-2">{{ $law->category->name }}</span>
                                        <h4 class="fw-bold mb-0">{{ $law->shortTitle }}</h4>                                
                                    </div>
                                    <div class="card-body fs-lg">
                                        <p class="mb-0 text-body">{{ $law->title }}</p>
                                    </div>       
                                </a>                         
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

        </div>
        <!-- /content area -->

    </div>
    <!-- /main content -->

</div>
<!-- /page content -->

<section class="bg-dark overlay position-relative">
    <div class="div" style="background-image: url({{ asset('assets/jdih/images/backgrounds/bg.jpg') }}); background-position:center; background-repeat:no-repeat">        
        <div class="container pt-5 pb-0" style="z-index: 2; position: relative;">
            <div class="content-wrapper">
                <div class="content row mb-5">
                    <div class="col-12 col-md-3">
                        <img src="{{ asset('assets/admin/images/demo/users/face12.jpg') }}" class="rounded-circle d-block m-auto" height="160">
                    </div>
                    <div class="col-12 col-md-9 text-light">
                        <h2 class="mb-3 text-handwriting">Sekapur Sirih</h2>
                        <p class="fs-lg">Situs ini merupakan situs resmi Biro Hukum Setda Provinsi Bali. Situs ini memuat data dan informasi-informasi produk hukum baik produk hukum pusat maupun daerah. Disamping itu, situs ini memuat pula informasi mengenai buku-buku referensi tentang hukum yang dimiliki oleh Biro Hukum Provinsi Bali.<br></p>
                        <div class="author mt-4">
                            <span class="fw-semibold">IDA BAGUS GEDE SUDARSANA, SH</span><br>
                            <span class="text-light fs-sm">Kepala Biro  Hukum </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
    @include('jdih.homepage.script')
@endsection
