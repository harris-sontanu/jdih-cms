@extends('jdih.layouts.app')

@section('content')

@include('jdih.homepage.slide')

<!-- Welcome -->
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
<!-- /welcome -->

<!-- Legislation summaries -->
<section class="container">
    <div class="content-wrapper">
        <div class="content py-5">
            <div class="d-flex mb-4 pb-2">
                <h2 class="fw-bold me-xl-auto section-title mb-0">Produk Hukum</h2>
                <a href="#" class="btn btn-dark lift px-3 fw-semibold">Lihat semua Produk Hukum<i class="ph-arrow-right ms-2"></i></a>
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
<!-- /legislation summaries -->

<!-- Latest laws -->
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
                    <a href="#" class="d-block display-6 fw-bold text-body mb-4">Peraturan Gubernur Bali Nomor 1 Tahun 2023</a>
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
                                    <div class="card-body fs-lg pb-0">
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
<!-- /latest laws -->

<!-- Monograph -->
<section class="bg-dark overlay position-relative">
    <div class="div" style="background-image: url({{ asset('assets/jdih/images/backgrounds/bg.jpg') }}); background-position:center; background-repeat:no-repeat">
        <div class="container py-5" style="z-index: 2; position: relative;">
            <div class="content-wrapper">
                <div class="content row py-5 gx-5">
                    <div class="col-xl-4 px-5">
                        @isset($cover)
                            <img src="{{ $cover->media->source }}" class="img-fluid mx-auto d-block rounded">
                        @else
                            <img src="{{ asset('assets/admin/images/placeholders/placeholder.jpg') }}" class="img-fluid rounded">
                        @endisset
                    </div>
                    <div class="col-xl-8 text-light">
                        <h3 class="fw-bold text-danger"><a href="#" class="link-danger">Monografi Hukum</a></h3>
                        <a href="#" class="d-block display-7 fw-bold link-light mb-4">{{ $monograph->title }}</a>
                        <div class="fs-lg">

                            <div class="d-flex mb-3">
                                <div class="me-4">
                                    <div class="bg-pink bg-opacity-10 text-pink lh-1 rounded-pill p-2">
                                        <i class="ph-check"></i>
                                    </div>
                                </div>
                                <div class="flex-fill">
                                    <h4 class="mb-1 fw-bold">T.E.U. Badan/Pengarang</h4>
                                    <p class="mb-0">{{ $monograph->author }}</p>
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
                                        <p class="mb-0">{{ $monograph->subject }}</p>
                                    </div>
                                    <div class="col-6">
                                        <h4 class="mb-1 fw-bold">Penerbit</h4>
                                        <p class="mb-0">{{ $monograph->publisher }}</p>
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
                                        <p class="mb-0">{{ $monograph->place }}</p>
                                    </div>
                                    <div class="col-6">
                                        <h4 class="mb-1 fw-bold">Tahun Terbit</h4>
                                        <p class="mb-0">{{ $monograph->year }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-5">
                                <a href="#" class="btn btn-outline-danger lift px-3 me-3 fw-semibold">Lihat Detail<i class="ph-arrow-right ms-2"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /monograph -->

<!-- Legislation statistic -->
<section class="bg-light">
    <div class="container py-5">
        <div class="content-wrapper">
            <div class="content row py-4">
                <div class="col-xl-10 offset-xl-1">
                    <div class="d-flex mb-4 pb-2">
                        <h2 class="fw-bold me-xl-auto section-title mb-0">Statistik Peraturan</h2>
                        <a href="#" class="btn btn-dark lift px-3 fw-semibold">Lihat Statistik lainnya<i class="ph-arrow-right ms-2"></i></a>
                    </div>
                    <div class="card card-body shadow-lg rounded-lg">
                        <div class="chart-container">
                            <div class="chart" id="chart_yearly_column" style="min-height: 420px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /legislation statistic -->

<!-- Latest member's laws -->
<section class="bg-dark bg-opacity-3">
    <div class="container py-5">
        <div class="content-wrapper">
            <div class="content py-4">
                <h2 class="fw-bold section-title text-center mb-4 pb-2">Produk Hukum anggota JDIH Provinsi Bali</h2>
                <div class="row gx-5">
                    @foreach ($latestLaws as $law)
                        <div class="col-xl-4 my-3">
                            <div class="card lift shadow-lg h-100">
                                <a href="#" class="text-body">
                                    <div class="card-header border-0 pb-0">
                                        <div class="d-flex mb-2">
                                            <img src="{{ asset('assets/admin/images/demo/logos/1.svg') }}" alt="" srcset="" height="32" class="me-2">
                                            <h5 class="fw-bold">JDIH Kota Denpasar</h5>
                                        </div>
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
<!-- /latest member's laws -->

@isset($latestNews)
    <!-- News -->
    <section class="bg-light">
        <div class="container py-5">
            <div class="content-wrapper">
                <div class="content py-4">
                    <div class="d-flex mb-4 pb-2">
                        <h2 class="fw-bold me-xl-auto section-title mb-0">Berita dan Kegiatan Terbaru</h2>
                        <a href="#" class="btn btn-dark lift px-3 fw-semibold">Lihat semua Berita dan Kegiatan<i class="ph-arrow-right ms-2"></i></a>
                    </div>
                    <div class="row gx-5">
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($latestNews as $news)
                            @if ($i === 0)
                                <!-- Highlight news -->
                                <div class="post col-xl-8">
                                    <figure class="figure">
                                        <img src="{{ $news->cover->source }}" class="figure-img img-fluid rounded shadow-lg" alt="...">
                                        <figcaption class="figure-caption">{{ $news->cover->caption }}</figcaption>
                                    </figure>
                                    <div class="post-title">
                                        <h3 class="fw-bold mb-2"><a href="#" class="link-danger">{{ $news->taxonomy->name }}</a></h3>
                                        <a href="#" class="d-block display-7 fw-bold text-body mb-3">{{ $news->title }}</a>
                                    </div>
                                    <ul class="post-meta list-inline list-inline-bullet text-muted mb-3">
                                        <li class="list-inline-item"><i class="ph-calendar-blank me-2"></i>{{ $news->dateFormatted($news->published_at) }}</li>
                                        <li class="list-inline-item"><i class="ph-user me-2"></i>{{ $news->author->name }}</li>
                                        <li class="list-inline-item"><i class="ph-eye me-2"></i>{{ $news->view }}</li>
                                    </ul>
                                    <p class="fs-lg mb-3">{!! $news->excerpt !!}</p>
                                    <a href="#" class="btn btn-outline-danger lift px-3 me-3 fw-semibold">Baca Selengapnya<i class="ph-arrow-right ms-2"></i></a>
                                </div>
                                <!-- /highlight news -->

                                <!-- Latest news -->
                                <div class="col-xl-4">
                            @else
                                    <div class="post">
                                        <figure class="figure">
                                            <img src="{{ $news->cover->source }}" class="figure-img mb-0 img-fluid rounded shadow-lg" alt="...">
                                        </figure>
                                        <div class="post-title">
                                            <h5 class="fw-bold mb-1"><a href="#" class="link-danger">{{ $news->taxonomy->name }}</a></h5>
                                            <h4><a href="#" class="d-block fw-bold text-body mb-3">{!! $news->title !!}</a></h4>
                                        </div>
                                        <ul class="post-meta list-inline list-inline-bullet text-muted mb-3">
                                            <li class="list-inline-item"><i class="ph-calendar-blank me-2"></i>{{ $news->dateFormatted($news->published_at) }}</li>
                                            <li class="list-inline-item"><i class="ph-eye me-2"></i>{{ $news->view }}</li>
                                        </ul>
                                    </div>
                            @endif
                            @php
                                $i++;
                            @endphp
                        @endforeach
                        </div>
                        <!-- /latest news -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /news -->
@endisset

<!-- FAQ -->
<section class="bg-dark">
    <div class="container py-5">
        <div class="content-wrapper">
            <div class="content py-4">
                <div class="row gx-5">
                    <div class="col-xl-5">
                        <div class="card card-body bg-dark shadow-lg ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/Y5ZlcHiGthw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="col-xl-7 text-light">
                        <span class="d-block display-7 fw-bold mb-4">Pertanyaan yang sering diajukan</span>
                        <div class="card shadow-lg">
                            <div class="card-header border-bottom-0 bg-dark bg-opacity-85">
                                <h6 class="mb-0">
                                    <a data-bs-toggle="collapse" class="link-light" href="#collapsible-card1"><i class="ph-question me-2"></i>Collapsible card #1</a>
                                </h6>
                            </div>

                            <div id="collapsible-card1" class="collapse show">
                                <div class="card-body bg-dark bg-opacity-85 pt-0">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-lg">
                            <div class="card-header border-bottom-0 bg-dark bg-opacity-85">
                                <h6 class="mb-0">
                                    <a class="collapsed link-light" data-bs-toggle="collapse" href="#collapsible-card2"><i class="ph-question me-2"></i>Collapsible card #2</a>
                                </h6>
                            </div>

                            <div id="collapsible-card2" class="collapse">
                                <div class="card-body bg-dark bg-opacity-85 pt-0">
                                    Тon cupidatat skateboard dolor brunch. Тesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda.
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-lg">
                            <div class="card-header border-bottom-0 bg-dark bg-opacity-85">
                                <h6 class="mb-0">
                                    <a class="collapsed link-light" data-bs-toggle="collapse" href="#collapsible-card3"><i class="ph-question me-2"></i>Collapsible card #3</a>
                                </h6>
                            </div>

                            <div id="collapsible-card3" class="collapse">
                                <div class="card-body bg-dark bg-opacity-85 pt-0">
                                    3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it.
                                </div>
                            </div>
                        </div>

                        <a href="#" class="btn btn-outline-danger lift px-3 me-3 mt-2 fw-semibold">Lihat Pertanyaan lainnya<i class="ph-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /faq -->

<!-- Affiliate Apps -->
<section class="bg-dark bg-opacity-3">
    <div class="container py-5">
        <div class="content-wrapper">
            <div class="content py-4">
                <h2 class="fw-bold section-title text-center mb-4 pb-2">Aplikasi Terkait JDIH</h2>
                <div class="row gx-5">

                    <div class="col-xl-4">
                        <div class="card h-100 card-body shadow-lg lift pb-0" style="min-height: 135px; background-image: url({{ asset('assets/jdih/images/backgrounds/panel_bg.png') }})">
                            <a href="https://sipekenseni.baliprov.go.id" class="text-body">
                                <div class="d-flex align-items-center">
                                    <i class="ph-newspaper ph-3x text-danger me-3"></i>

                                    <div class="flex-fill text-end">
                                        <h3 class="mb-0 fw-bold">SI PEKEN SENI</h3>
                                        <span class="d-block fs-lg">Sistem Penyusunan Keputusan Gubernur Secara Elektronik</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="card h-100 card-body shadow-lg lift pb-0" style="min-height: 135px; background-image: url({{ asset('assets/jdih/images/backgrounds/panel_bg.png') }})">
                            <a href="https://fasperkadabkum.com" class="text-body">
                                <div class="d-flex align-items-center">
                                    <i class="ph-paper-plane-tilt ph-3x text-indigo me-3"></i>

                                    <div class="flex-fill text-end">
                                        <h3 class="mb-0 fw-bold">SI PENYU DEWI GITA</h3>
                                        <span class="d-block fs-lg">Sistem Penyusunan Produk Hukum Daerah Berbasis Wilayah Dengan Digitalisasi</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="card h-100 card-body shadow-lg lift pb-0" style="min-height: 135px; background-image: url({{ asset('assets/jdih/images/backgrounds/panel_bg.png') }})">
                            <a href="https://kliknphdbirohukum.website" class="text-body">
                                <div class="d-flex align-items-center">
                                    <i class="ph-hand-pointing ph-3x text-success me-3"></i>

                                    <div class="flex-fill text-end">
                                        <h3 class="mb-0 fw-bold">KLIK NPHD</h3>
                                        <span class="d-block fs-lg">Sistem Penyusunan Naskah Perjanjian Hibah Daerah</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- /affiliate apps -->

@isset($banner)
    <!-- Links -->
    <section class="bg-light">
        <div class="container py-5">
            <div class="content-wrapper">
                <div class="content py-4">
                    <h2 class="fw-bold section-title text-center mb-4 pb-2">Tautan</h2>
                    <div id="slider" class="row gx-5">
                        @foreach ($banners as $banner)
                            <div class="col-xl-3">
                                <div class="card">
                                    <a href="{{ $banner->url }}"><img class="rounded img-fluid" src="{{ $banner->image->source }}" alt="" srcset=""></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /links -->
@endisset

@endsection

@section('script')
    @include('jdih.homepage.script')
@endsection
