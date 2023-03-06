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
                            {{-- <button type="submit" class="btn btn-danger btn-lg lift w-100 fw-bold @empty($legislation->masterDocumentSource) disabled @endempty">Unduh<i class="ph-download ms-2"></i></button> --}}

                            <div class="btn-group w-100 lift">
                                <button type="button" @empty($legislation->masterDocumentSource) disabled @endempty class="btn btn-danger btn-lg btn-labeled btn-labeled-start dropdown-toggle fw-bold" data-bs-toggle="dropdown">
                                    <span class="btn-labeled-icon bg-black bg-opacity-20">
                                        <i class="ph-download"></i>
                                    </span>
                                    Unduh
                                </button>

                                <div class="dropdown-menu">
                                    <form action="{{ route('legislation.download', $legislation->masterDocument()->id) }}" method="post">
                                        @method('PUT')
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="ph-file-pdf me-2"></i>Batang Tubuh
                                        </button>
                                    </form>
                                    <a href="#" class="dropdown-item">Action</a>
                                    <a href="#" class="dropdown-item">Another action</a>
                                    <a href="#" class="dropdown-item">One more action</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="#" class="dropdown-item">Separated line</a>
                                </div>
                            </div>
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
                                        <u>
                                            <a href="{{ route('legislation.law.index', ['field' => $legislation->field->slug]) }}" class="text-body">{{ $legislation->field->name }}</a>
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
                                    <div class="bg-pink bg-opacity-10 text-pink lh-1 rounded-pill p-2">
                                        <i class="ph-check"></i>
                                    </div>
                                </div>
                                <div class="row flex-fill">
                                    <div class="col-6">
                                        <h4 class="mb-1 fw-bold">Pemrakarsa</h4>
                                        <u>
                                            <a href="{{ route('legislation.law.index', ['institute' => $legislation->institute->slug]) }}" class="text-body">{{ $legislation->institute->name }}</a>
                                        </u>
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

                        <!-- Legislation relationships -->
                        <ul class="nav nav-tabs nav-tabs-underline border-top" role="tablist">
                            <li class="nav-item" role="presentation">
                                <h6 class="fw-bold mb-0"><a class="nav-link active py-3" data-bs-toggle="tab" role="tab" aria-current="page" href="#status">Keterangan Status</a></h6>
                            </li>
                            <li class="nav-item ms-3" role="presentation">
                                <h6 class="fw-bold mb-0"><a class="nav-link disabled py-3" data-bs-toggle="tab" role="tab" href="#legislation">Peraturan Terkait</a></h6>
                            </li>
                            <li class="nav-item ms-3" role="presentation">
                                <h6 class="fw-bold mb-0"><a class="nav-link disabled py-3" data-bs-toggle="tab" role="tab" href="#document">Dokumen Terkait</a></h6>
                            </li>
                        </ul>

                        <div class="tab-content pt-4 pb-1 fs-lg">
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
                        <!-- /legislation relationships -->

                        <div class="post-share fs-lg d-flex align-items-center mb-4 border-top border-bottom py-3">
                            <p class="fs-lg mb-0"><span class="fw-bold">Bagikan:</span></p>
                            <div class="ms-auto">
                                <ul class="list-inline mb-0 ms-3">
                                    @foreach ($shares as $share)
                                        <li class="list-inline-item me-1">
                                            <a href="{{ $share['url'] }}" target="_blank" class="btn btn-{{ $share['color'] }} rounded-pill p-1 lift" title="Bagikan ke {{ $share['title'] }}" data-bs-popup="tooltip">
                                                <i class="{{ $share['icon'] }} m-1"></i>
                                            </a>
                                        </li>
                                    @endforeach
                                    <li class="list-inline-item">
                                        <button type="button" data-url="{{ url()->current() }}" class="copy-link btn btn-light rounded-pill p-1 lift" title="Salin URL" data-bs-popup="tooltip">
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
