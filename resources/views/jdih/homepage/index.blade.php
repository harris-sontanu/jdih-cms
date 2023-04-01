@extends('jdih.layouts.app')

@section('content')

@include('jdih.homepage.slide')

<!-- Welcome -->
<section class="bg-dark">`
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
                        <span class="text-light fs-sm">Kepala Biro  Hukum</span>
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
                <a href="{{ route('legislation.index') }}" class="btn btn-dark lift px-3 fw-semibold">Lihat semua Produk Hukum<i class="ph-arrow-right ms-2"></i></a>
            </div>
            <div class="row gx-4 fs-lg">
                <div class="col-sm-6 col-xl-3">
                    <div class="card card-body shadow lift">
                        <a href="{{ route('legislation.law.index') }}" class="text-dark">
                            <div class="d-flex align-items-center">
                                <i class="ph-scales ph-2x text-success me-3"></i>

                                <div class="flex-fill text-end">
                                    <h2 class="counter display-7 mb-0">{{ $totalLaws }}</h2>
                                    <span class="text-muted">total peraturan</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card card-body shadow lift">
                        <a href="{{ route('legislation.monograph.index') }}" class="text-dark">
                            <div class="d-flex align-items-center">
                                <i class="ph-books ph-2x text-indigo me-3"></i>

                                <div class="flex-fill text-end">
                                    <h2 class="counter display-7 mb-0">{{ $totalMonographs }}</h2>
                                    <span class="text-muted">total monografi</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card card-body shadow lift">
                        <a href="{{ route('legislation.article.index') }}" class="text-dark">
                            <div class="d-flex align-items-center">
                                <div class="flex-fill">
                                    <h2 class="counter display-7 mb-0">{{ $totalArticles }}</h2>
                                    <span class="text-muted">total artikel</span>
                                </div>

                                <i class="ph-newspaper ph-2x text-primary ms-3"></i>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card card-body shadow lift">
                        <a href="{{ route('legislation.judgment.index') }}" class="text-dark">
                            <div class="d-flex align-items-center">
                                <div class="flex-fill">
                                    <h2 class="counter display-7 mb-0">{{ $totalJudgments }}</h2>
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

            @isset ($popularLaw)
                <!-- Popular law -->
                <div class="row pb-5 gx-5">
                    <div class="col-xl-6 m-auto">
                        <figure id="adobe-dc-view" data-file="{{ $popularLaw->masterDocumentSource }}" data-name="{{ $popularLaw->masterDocument()->media->file_name }}" class="rounded shadow" style="height: 700px;">
                        </figure>
                        @include('jdih.legislation.pdfEmbed', ['el' => 'adobe-dc-view'])
                    </div>
                    <div class="col-xl-6">
                        <span class="fw-bold badge bg-danger bg-opacity-10 text-danger rounded-pill mb-2 fs-lg px-3 py-2"><i class="ph-fire me-2"></i>Terhangat</span>
                        <a href="{{ route('legislation.law.show', ['category' => $popularLaw->category->slug, 'legislation' => $popularLaw->slug]) }}" class="d-block display-6 fw-bold text-body mb-4">{{ $popularLaw->shortTitle }}</a>
                        <div class="fs-lg">
                            <div class="d-flex mb-3">
                                <div class="me-4">
                                    <div class="bg-danger bg-opacity-10 text-danger lh-1 rounded-pill p-2">
                                        <i class="ph-check"></i>
                                    </div>
                                </div>
                                <div class="row flex-fill">
                                    <div class="col-6">
                                        <h4 class="mb-1 fw-bold">Jenis Dokumen</h4>
                                        <u><a href="{{ route('legislation.law.category', ['category' => $popularLaw->category->slug]) }}" class="text-body"> {{ $popularLaw->category->name }}</a></u>
                                    </div>
                                    <div class="col-6">
                                        <h4 class="mb-1 fw-bold">Nomor</h4>
                                        <p class="mb-0">{{ $popularLaw->code_number }}</p>
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
                                    <p class="mb-0">{{ $popularLaw->title }}</p>
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
                                        <p class="mb-0">{{ $popularLaw->timeformatted($popularLaw->approved, "j F Y") }}</p>
                                    </div>
                                    <div class="col-6">
                                        <h4 class="mb-1 fw-bold">Tgl. Pengundangan</h4>
                                        <p class="mb-0">{{ $popularLaw->timeformatted($popularLaw->published, "j F Y") }}</p>
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
                                        <p class="mb-0">{{ $popularLaw->subject }}</p>
                                    </div>
                                    <div class="col-6">
                                        <h4 class="mb-1 fw-bold">Status</h4>
                                        <p class="mb-0">
                                            <a href="{{ route('legislation.law.index', ['statuses[]' => $popularLaw->status]) }}" class="text-body">{!! $popularLaw->statusBadge !!}</a>
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
                                        <h4 class="mb-1 fw-bold">Pemrakarsa</h4>
                                        <u>
                                            <a href="{{ route('legislation.law.index', ['institutes[]' => $popularLaw->institute->slug]) }}" class="text-body">{{ $popularLaw->institute->name }}</a>
                                        </u>
                                    </div>
                                    <div class="col-6">
                                        <h4 class="mb-1 fw-bold">Urusan Pemerintahan</h4>
                                        @if($popularLaw->matters->count() > 0)
                                            <ul class="list-inline mb-0">
                                                @foreach ($popularLaw->matters as $matter)
                                                    <li class="list-inline-item me-1 mb-1"><a href="{{ route('legislation.law.index', ['matters[]' => $matter->slug]) }}" class="badge bg-purple bg-opacity-20 text-purple">{{ $matter->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-5">
                                <a href="{{ route('legislation.law.show', ['category' => $popularLaw->category->slug, 'legislation' => $popularLaw->slug]) }}" class="btn btn-outline-dark lift px-3 me-3 fw-semibold">Lihat Detail<i class="ph-arrow-right ms-2"></i></a>
                                @isset($popularLaw->masterDocumentSource)
                                    <form action="{{ route('legislation.download', $popularLaw->masterDocument()->id) }}" method="post">
                                        @method('PUT')
                                        @csrf
                                        <button type="submit" class="btn btn-dark lift px-3 fw-semibold">
                                            Unduh<i class="ph-download ms-2"></i>
                                        </button>
                                    </form>
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /popular law -->
            @endisset

            @if (isset($latestLaws) AND $latestLaws->count() > 0)
                <!-- Latest laws -->
                <section class="latest-legislation py-5">
                    <div class="d-flex pb-4">
                        <h2 class="fw-bold me-xl-auto section-title mb-0">Peraturan Terbaru</h2>
                        <a href="{{ route('legislation.law.index') }}" class="btn btn-dark lift px-3 fw-semibold">Lihat semua Peraturan<i class="ph-arrow-right ms-2"></i></a>
                    </div>
                    <div class="row gx-4">
                        @foreach ($latestLaws as $law)
                            <div class="col-xl-4 my-3">
                                <div class="card lift shadow h-100">
                                    <a href="{{ route('legislation.law.show', ['category' => $law->category->slug, 'legislation' => $law->slug])}}" class="text-body link-danger">
                                        <div class="card-header border-0 pb-0">
                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill mb-2">{{ $law->category->name }}</span>
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
                <!-- /latest laws -->
            @endif

        </div>
        <!-- /content area -->

    </div>
    <!-- /main content -->

</div>
<!-- /latest laws -->

@isset($monograph)
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
                            <h3 class="fw-bold text-danger"><a href="{{ route('legislation.monograph.index') }}" class="link-danger">Monografi Hukum</a></h3>
                            <a href="{{ route('legislation.monograph.show', ['category' => $monograph->category->slug, 'legislation' => $monograph->slug]) }}" class="d-block display-7 fw-bold link-light mb-4">{{ $monograph->title }}</a>
                            <div class="fs-lg">

                                <div class="d-flex mb-3">
                                    <div class="me-4">
                                        <div class="bg-danger bg-opacity-10 text-danger lh-1 rounded-pill p-2">
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
                                        <div class="bg-danger bg-opacity-10 text-danger lh-1 rounded-pill p-2">
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
                                        <div class="bg-danger bg-opacity-10 text-danger lh-1 rounded-pill p-2">
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
                                    <a href="{{ route('legislation.monograph.show', ['category' => $monograph->category->slug, 'legislation' => $monograph->slug]) }}" class="btn btn-outline-danger lift px-3 me-3 fw-semibold">Lihat Detail<i class="ph-arrow-right ms-2"></i></a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /monograph -->
@endisset

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
                    <div class="card card-body shadow rounded-lg">
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
                <div class="row gx-4">
                    @foreach ($latestLaws as $law)
                        <div class="col-xl-4 my-3">
                            <div class="card lift shadow h-100">
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

@if(isset($latestNews) AND $latestNews->count() > 0)
    <!-- News -->
    <section class="bg-light">
        <div class="container py-5">
            <div class="content-wrapper">
                <div class="content py-4">
                    <div class="d-flex mb-4 pb-2">
                        <h2 class="fw-bold me-xl-auto section-title mb-0">Berita dan Kegiatan Terbaru</h2>
                        <a href="{{ route('news.index') }}" class="btn btn-dark lift px-3 fw-semibold">Lihat semua Berita dan Kegiatan<i class="ph-arrow-right ms-2"></i></a>
                    </div>
                    <div class="row gx-4">
                        @foreach ($latestNews as $news)
                            <div class="col-xl-4 my-3">
                                <div class="card shadow">

                                    <figure class="figure card-img mb-0">
                                        <a href="{{ route('news.show', ['taxonomy' => $news->taxonomy->slug, 'post' => $news->slug]) }}">
                                            <img src="{{ $news->cover->source }}" class="img-fluid card-img-top m-0 h-250 object-fit-cover" alt="{{ $news->cover->name }}">
                                        </a>
                                    </figure>

                                    <div class="card-body">
                                        <a href="{{ route('news.taxonomy', ['taxonomy' => $news->taxonomy->slug]) }}" class="badge bg-teal bg-opacity-10 text-teal rounded-pill">{{ $news->taxonomy->name }}</a>
                                        <h4 class="card-title pt-1">
                                            <a href="{{ route('news.show', ['taxonomy' => $news->taxonomy->slug, 'post' => $news->slug]) }}" class="text-body">{{ $news->title }}</a>
                                        </h4>

                                        <ul class="list-inline list-inline-bullet text-muted mb-0">
                                            <li class="list-inline-item"><i class="ph-calendar-blank me-2"></i>{{ $news->dateFormatted($news->published_at) }}</li>
                                            <li class="list-inline-item"><i class="ph-eye me-2"></i>{{ $news->view }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /news -->
@endif

<!-- FAQ -->
<section class="bg-dark">
    <div class="container py-5">
        <div class="content-wrapper">
            <div class="content py-4">
                <div class="row gx-5">
                    <div class="col-xl-5">
                        <div class="card card-body bg-dark shadow ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/Y5ZlcHiGthw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="col-xl-7 text-light">
                        <span class="d-block display-7 fw-bold mb-4">Pertanyaan yang sering diajukan</span>
                        <div class="card shadow">
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

                        <div class="card shadow">
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

                        <div class="card shadow">
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

                @if (isset($members) AND $members->count() > 0)
                    <div class="row gx-5 mb-5">
                        <div class="col-xl-4 m-auto">
                            <h3 class="display-7 fw-bold">Struktur Pengelola {!! $appName !!}</h3>
                            <p class="fs-lg mb-3">Donec id elit non mi porta gravida at eget metus. Morbi leo risus, porta ac consectetur ac, vestibulum at eros tempus porttitor.</p>
                            <button type="button" class="btn btn-lg btn-danger lift px-3 fw-semibold">
                                Lihat Semua Pengelola<i class="ph-arrow-right ms-2"></i>
                            </button>
                        </div>
                        <div class="col-xl-8">
                            <div id="member-slider" class="row gx-4">
                                @foreach ($members as $member)
                                    <div class="col-xl-4">
                                        <div class="card shadow h-100">
                                            <div class="card-body text-center">
                                                <img class="img-fluid rounded-circle mb-3" src="{{ $member->pictureThumbUrl }}" alt="{{ $member->name }}" width="170" height="170">

                                                <h6 class="mb-0">{{ $member->name }}</h6>
                                                <span class="text-muted">{{ $member->position }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <h2 class="fw-bold section-title text-center mb-4 pb-2">Aplikasi Terkait JDIH</h2>
                <div class="row gx-5">

                    <div class="col-xl-4">
                        <div class="card h-100 card-body shadow lift pb-0" style="min-height: 135px; background-image: url({{ asset('assets/jdih/images/backgrounds/panel_bg.png') }})">
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
                        <div class="card h-100 card-body shadow lift pb-0" style="min-height: 135px; background-image: url({{ asset('assets/jdih/images/backgrounds/panel_bg.png') }})">
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
                        <div class="card h-100 card-body shadow lift pb-0" style="min-height: 135px; background-image: url({{ asset('assets/jdih/images/backgrounds/panel_bg.png') }})">
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

@if(isset($banners) AND $banners->count() > 0)
    <!-- Links -->
    <section class="bg-light">
        <div class="container py-5">
            <div class="content-wrapper">
                <div class="content py-4">
                    <div class="row gx-5 mb-5">
                        <div class="col-xl-7">
                            <figure>
                                <img src="{{ asset('assets/jdih/images/illustrations/1.png') }}" class="img-fluid">
                            </figure>
                        </div>
                        <div class="col-xl-5 m-auto">
                            <h3 class="display-6 fw-bold">Ayo Bergabung!</h3>
                            <p class="fs-lg mb-3">
                                Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Maecenas faucibus mollis interdum. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
                            </p>
                            <ul class="list list-unstyled mb-4 ms-3 fs-lg">
                                <li class="d-flex align-items-center mb-3">
                                    <div class="me-3">
                                        <div class="bg-danger bg-opacity-10 text-danger lh-1 rounded-pill p-1">
                                            <i class="ph-arrow-right"></i>
                                        </div>
                                    </div>
                                    <div class="flex-fill">Unduh <span class="fw-bold">Dokumen Produk Hukum</span></div>
                                </li>
                                <li class="d-flex align-items-center mb-3">
                                    <div class="me-3">
                                        <div class="bg-danger bg-opacity-10 text-danger lh-1 rounded-pill p-1">
                                            <i class="ph-arrow-right"></i>
                                        </div>
                                    </div>
                                    <div class="flex-fill">Menggunakan layanan <span class="fw-bold">Konsultasi Hukum</span>, <span class="fw-bold">Pengaduan Hukum</span>, dan <span class="fw-bold">Bantuan Hukum</span></div>
                                </li>
                                <li class="d-flex align-items-center mb-3">
                                    <div class="me-3">
                                        <div class="bg-danger bg-opacity-10 text-danger lh-1 rounded-pill p-1">
                                            <i class="ph-arrow-right"></i>
                                        </div>
                                    </div>
                                    <div class="flex-fill">Ikut berpartisipasi dalam memberikan masukan atau saran dalam rancangan peraturan pada <span class="fw-bold">Forum Diskusi</span></div>
                                </li>
                            </ul>
                            <div class="d-flex fs-lg">
                                <button type="button" class="btn btn-lg btn-danger lift px-3 fw-semibold">
                                    Gabung Sekarang<i class="ph-sign-in ms-2"></i>
                                </button>
                                <button type="button" class="btn btn-lg btn-outline-danger lift px-3 ms-3 fw-semibold">
                                    Daftar<i class="ph-pencil-line ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="banner-slider" class="row gx-5">
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
@endif

@endsection

@section('script')
    @include('jdih.homepage.script')
@endsection
