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
                        <h3 class="card-title mb-0">{{ $page->title }}</h3>
                    </div>

                    <div class="card-body pt-0">

                        @if ($page->cover)
                            <div class="mb-3">
                                <img src="{{ $page->cover->mediaUrl }}" class="img-fluid rounded mx-auto d-block">
                                @if (!empty($page->cover->caption))<span class="mt-1 d-block text-muted text-center">{{ $page->cover->caption }}</span>@endif
                            </div>
                        @endif

                        <div class="mb-3">
                            {!! $page->body !!}
                        </div>

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
                                    <td class="text-end">{!! $page->publicationBadge() !!}</td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap"><i class="ph-user me-2"></i>Penulis:</td>
                                    <td class="text-end">{{ $page->author->name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap"><i class="ph-calendar-blank me-2"></i>Posting:</td>
                                    <td class="text-end">
                                        <abbr data-bs-popup="tooltip" title="{{ $page->dateFormatted($page->created_at, true) }}">{{ $page->dateFormatted($page->created_at) }}</abbr>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap"><i class="ph-calendar-blank me-2"></i>Terbit:</td>
                                    <td class="text-end">
                                        <abbr data-bs-popup="tooltip" title="{{ $page->dateFormatted($page->published_at, true) }}">{{ $page->dateFormatted($page->published_at) }}</abbr>
                                    </td>
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
    @include('admin.page.script')
@endsection
