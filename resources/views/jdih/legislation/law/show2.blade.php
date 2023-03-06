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
        <main class="content row">
            <div class="col-xl-10 offset-xl-1">
                <div class="row gx-5">
                    <div class="col-xl-3">
                        <img @isset ($legislation->masterDocumentSource) data-pdf-thumbnail-file="{{ $legislation->masterDocumentSource }}" @endisset src="{{ $legislation->coverThumbSource }}" alt="{{ $legislation->title }}" class="img-fluid rounded shadow-lg mt-3">

                        <div class="mt-4">
                            <button type="submit" class="btn btn-danger btn-lg lift w-100 fw-bold @empty($legislation->masterDocumentSource) disabled @endempty">Unduh<i class="ph-download ms-2"></i></button>
                        </div>

                        <div class="mt-4 text-center">
                            {!! QrCode::size(200)->margin(2)->generate(url()->current()); !!}
                        </div>
                    </div>
                    <div class="col-xl-9">
                        <h2 class="d-block display-6 fw-bold mb-2">{{ $legislation->shortTitle }}</h2>
                        <ul class="post-meta list-inline list-inline-bullet text-muted mb-5 fs-lg">
                            <li class="list-inline-item"><i class="ph-calendar-blank me-2"></i>{{ $legislation->dateFormatted($legislation->published_at) }}</li>
                            <li class="list-inline-item"><i class="ph-user me-2"></i>{{ $legislation->user->name }}</li>
                            <li class="list-inline-item"><i class="ph-eye me-2"></i>{{ $legislation->view }}</li>
                            <li class="list-inline-item"><i class="ph-download me-2"></i>{{ $legislation->documents->sum('download') }}</li>
                        </ul>

                        <!-- Meta data -->
                        <div class="fs-lg mb-5">
                            <div class="d-flex mb-3">
                                <div class="me-4">
                                    <div class="bg-pink bg-opacity-10 text-pink lh-1 rounded-pill p-2">
                                        <i class="ph-check"></i>
                                    </div>
                                </div>
                                <div class="row flex-fill">
                                    <div class="col-6">
                                        <h4 class="mb-1 fw-bold">Jenis Dokumen</h4>
                                        <p class="mb-0"><a href="{{ route('legislation.law.category', ['category' => $legislation->category->slug]) }}" class="text-body"> {{ $legislation->category->name }}</a></p>
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
                                        <p class="mb-0">{{ $legislation->dateFormatted($legislation->published) }}</p>
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
                                        <h4 class="mb-1 fw-bold">Singkatan Jenis</h4>
                                        <p class="mb-0">
                                            <a href="{{ route('legislation.law.category', ['category' => $legislation->category->slug]) }}" class="text-body">{{ $legislation->category->abbrev }}</a>
                                        </p>
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
                                        <h4 class="mb-1 fw-bold">Tempat Terbit</h4>
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
                                        <p class="mb-0">
                                            <a href="{{ route('legislation.law.index', ['status' => $legislation->status]) }}" class="text-body">{!! $legislation->statusBadge !!}</a>
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
                                        <h4 class="mb-1 fw-bold">Bidang Hukum</h4>
                                        <p class="mb-0">
                                            <a href="{{ route('legislation.law.index', ['field' => $legislation->field->slug]) }}" class="text-body">{{ $legislation->field->name }}</a>
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
                                        <h4 class="mb-1 fw-bold">Pemrakarsa</h4>
                                        <p class="mb-0">
                                            <a href="{{ route('legislation.law.index', ['institute' => $legislation->institute->slug]) }}" class="text-body">{{ $legislation->institute->name }}</a>
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <h4 class="mb-1 fw-bold">Urusan Pemerintahan</h4>
                                        @if($legislation->matters->count() > 0)
                                            <ul class="list-inline mb-0">
                                                @foreach ($legislation->matters as $matter)
                                                    <li class="list-inline-item me-1 mb-1"><a href="{{ route('legislation.law.index', ['matter' => $matter->slug]) }}" class="badge bg-purple bg-opacity-20 text-purple">{{ $matter->name }}</a></li>
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
                                    <div class="bg-pink bg-opacity-10 text-pink lh-1 rounded-pill p-2">
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
                        </div>
                        <!-- /meta data -->

                        <div class="post-share fs-lg d-flex align-items-center mb-4 border-top border-bottom py-3">
                            <p class="fs-lg mb-0"><span class="fw-bold">Berbagi:</span></p>
                            <div class="ms-auto">
                                <ul class="list-inline mb-0 ms-3">
                                    @foreach ($shares as $share)
                                        <li class="list-inline-item me-1">
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
