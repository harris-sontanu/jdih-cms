@extends('jdih.layouts.app')

@section('title', 'Galeri Foto | ' . strip_tags($appName))
@section('content')

<!-- Page title -->
<section class="bg-dark bg-opacity-3 mb-4">
    <div class="page-content container p-0">
        <div class="content-wrapper">
            <div class="content">
                <div class="page-header text-center">
                    <div class="page-header-content">
                        <div class="page-title pt-5 pb-7">
                            <h2 class="d-block display-6 fw-bold mb-0">Galeri Foto</h2>
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
        <main class="content row gx-5">

            @forelse ($photos as $photo)
                <div class="col-xl-4">
                    <article class="card shadow post-entry mb-4">
                        <figure class="card-img-actions m-0">
                            <img class="card-img img-fluid" src="{{ $photo->thumbSource }}">
                            <div class="card-img-actions-overlay card-img">
                                <a href="{{ $photo->source }}" class="btn btn-outline-white btn-icon rounded-pill" data-bs-popup="lightbox" data-gallery="gallery1">
                                    <i class="ph-plus"></i>
                                </a>
                            </div>
                        </figure>
                    </article>
                </div>
            @empty

            @endforelse

            {{ $photos->links('jdih.layouts.pagination') }}

        </main>
        <!-- /content area -->

    </div>
    <!-- /main content -->

</div>
<!-- /page container -->

@endsection

@section('script')
    @include('jdih.gallery.script')
@endsection
