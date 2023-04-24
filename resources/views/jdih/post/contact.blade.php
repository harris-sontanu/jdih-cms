@extends('jdih.layouts.app')

@section('title', $page->title . ' | ' . strip_tags($appName))
@section('content')

<!-- Page title -->
<section class="bg-dark bg-opacity-3 mb-4">
    <div class="page-content container p-0">
        <div class="content-wrapper">
            <div class="content">
                <div class="page-header text-center">
                    <div class="page-header-content">
                        <div class="page-title pt-5 pb-7">
                            <h2 class="d-block display-6 fw-bold mb-0">{{ $page->title }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /page title -->

<!-- Page container -->
<div class="page-content container pt-0 mt-n7">

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Content area -->
        <div class="content row gx-5">

            <main class="col-xl-10 offset-xl-1">
                <article class="card shadow post-entry mb-4">
                    <div class="row gx-0">
                        <div class="col-xl-6">
                            <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.openstreetmap.org/export/embed.html?bbox=115.23217588663104%2C-8.669524852755153%2C115.2366551756859%2C-8.667138438806793&amp;layer=mapnik&amp;marker=-8.668331647675165%2C115.23441553115845"></iframe>
                        </div>
                        <div class="col-xl-6">
                            <div class="p-10 fs-lg" style="padding: 4.5rem">
                                <dl class="row mb-0">
                                    <dt class="col-xl-2 text-danger"><i class="ph-2x ph-phone"></i></dt>
                                    <dd class="col-xl-10 mb-4">
                                        <h4 class="fw-bold mb-0">Telepon</h4>
                                        {{ $phone }}
                                    </dd>

                                    <dt class="col-xl-2 text-danger"><i class="ph-2x ph-house"></i></dt>
                                    <dd class="col-xl-10 mb-4">
                                        <h4 class="fw-bold mb-0">Alamat</h4>
                                        {{ $fullAddress }}
                                    </dd>

                                    <dt class="col-xl-2 text-danger"><i class="ph-2x ph-envelope"></i></dt>
                                    <dd class="col-xl-10 mb-4">
                                        <h4 class="fw-bold mb-0">Surel</h4>
                                        {{ $email }}
                                    </dd>

                                    <dt class="col-xl-2 text-danger"><i class="ph-2x ph-globe"></i></dt>
                                    <dd class="col-xl-10">
                                        <h4 class="fw-bold mb-0">Situs</h4>
                                        {{ $appUrl }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </article>

                @if (isset($banners) AND $banners->count() > 0)
                    <div class="row gx-4 mb-4">
                        @foreach ($banners as $banner)
                            @break($loop->iteration > 3)
                            <div class="col-xl-4">
                                <div class="card shadow bg-white border-0 lift mb-0">
                                    <a href="{{ $banner->url }}"><img src="{{ $banner->image->source }}" class="img-fluid rounded" alt="" srcset=""></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </main>

        </div>
        <!-- /content area -->

    </div>
    <!-- /main content -->

</div>
<!-- /page container -->

@endsection
