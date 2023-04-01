@extends('jdih.layouts.app')

@section('title', 'Galeri Video | ' . strip_tags($appName))
@section('content')

<!-- Page title -->
<section class="bg-dark bg-opacity-3 mb-4">
    <div class="page-content container p-0">
        <div class="content-wrapper">
            <div class="content">
                <div class="page-header text-center">
                    <div class="page-header-content">
                        <div class="page-title pt-5 pb-7">
                            <h2 class="d-block display-6 fw-bold mb-0">Galeri Video</h2>
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
        <main class="content row gx-4">

            @forelse ($videos as $video)
                <div class="col-xl-4">
                    <article class="card shadow post-entry mb-4">
                        <div class="ratio ratio-16x9">
                            {!! $video->youtubeThumbUrl !!}
                        </div>
                    </article>
                </div>
            @empty

            @endforelse

            {{ $videos->links('jdih.layouts.pagination') }}

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
