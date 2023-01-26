@extends('admin.layouts.app')

@section('title', $pageTitle)
@section('content')

    <!-- Content area -->
    <div class="content pt-0">

        <!-- Inner container -->
        <div class="d-flex align-items-stretch align-items-lg-start flex-column flex-lg-row">

            <!-- Left content -->
            <div class="flex-1 order-2 order-lg-1">

                <div class="card">

                    <div class="card-header border-0">
                        <h3 class="card-title mb-0">{{ $news->title }}</h3>
                    </div>

                    <div class="card-body pt-0">
                        <div class="mb-3">
                            @if($news->cover)<img src="{{ $news->cover->mediaUrl }}" class="img-fluid rounded mx-auto d-block">@endif
                            @if (!empty($news->cover->caption))<span class="mt-1 d-block text-muted text-center">{{ $news->cover->caption }}</span>@endif
                        </div>

                        <div class="mb-3">
                            {!! $news->body !!}
                        </div>

                        @if (!empty($news->galleries) AND count($news->galleries) > 0)
                            <h5>Galeri</h5>
                            <div class="row">
                                @foreach ($news->galleries as $gallery)
                                    <div class="col-4">
                                        <div class="card">
                                            <div class="card-img-actions m-0">
                                                <img class="card-img img-fluid" src="{{ $gallery->mediaThumbUrl }}">
                                                <div class="card-img-actions-overlay card-img">
                                                    <a href="{{ $gallery->mediaUrl }}" class="btn btn-outline-white btn-icon rounded-pill" data-bs-popup="lightbox" data-gallery="gallery1">
                                                        <i class="ph-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if ($news->source)
                            <p><span class="fw-bold">Sumber:</span> {{ $news->source }}</p>
                        @endif

                    </div>
                </div>

            </div>

            <!-- Sidebar -->
            <div class="sidebar sidebar-component sidebar-expand-lg bg-transparent wmin-350 shadow-none order-1 order-lg-2 ms-lg-3 mb-3">

                <div class="sidebar-content">

                    <div class="card">
                        <div class="sidebar-section-header border-bottom">
                            <span class="fw-semibold"><i class="ph-globe-hemisphere-east me-2"></i>Publikasi</span>
                        </div>

                        <table class="table table-borderless my-2 table-xs">
                            <tbody>
                                <tr>
                                    <td class="text-nowrap"><i class="ph-tag me-2"></i>Status:</td>
                                    <td class="text-end">{!! $news->publicationBadge() !!}</td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap"><i class="ph-folder me-2"></i>Kategori:</td>
                                    <td class="text-end">@if($news->taxonomy)<a href="{{ route('admin.news.index', ['taxonomy' => $news->taxonomy->id, 'filter' => 1]) }}">{{ $news->taxonomy->name }}@endif</a></td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap"><i class="ph-user me-2"></i>Operator:</td>
                                    <td class="text-end">{{ $news->author->name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap"><i class="ph-calendar-blank me-2"></i>Posting:</td>
                                    <td class="text-end">
                                        <abbr data-bs-popup="tooltip" title="{{ $news->dateFormatted($news->created_at, true) }}">{{ $news->dateFormatted($news->created_at) }}</abbr>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap"><i class="ph-calendar-blank me-2"></i>Terbit:</td>
                                    <td class="text-end">
                                        <abbr data-bs-popup="tooltip" title="{{ $news->dateFormatted($news->published_at, true) }}">{{ $news->dateFormatted($news->published_at) }}</abbr>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap"><i class="ph-eye me-2"></i>Dilihat:</td>
                                    <td class="text-end">{{ $news->view }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- /sidebar content -->

            </div>
            <!-- /sidebar -->

        </div>

    </div>
    <!-- /content area -->

@endsection

@section('script')
    @include('admin.news.script')
@endsection
