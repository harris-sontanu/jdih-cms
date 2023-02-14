@extends('jdih.layouts.app')

@section('title', 'Produk Hukum | ' . $appName)
@section('content')

<section class="bg-light">
    <div class="container">
        <div class="content-wrapper">
            <div class="d-flex px-2">
                <div class="breadcrumb py-3">
                    <a href="index.html" class="breadcrumb-item"><i class="ph-house"></i></a>
                    <span class="breadcrumb-item active">Produk Hukum</span>
                </div>

                <a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                    <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Page container -->
<div class="page-content container">

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Content area -->
        <div class="content">

            @include('jdih.legislation.aside')   

        </div>
        <!-- /content area -->

    </div>
    <!-- /main content -->

</div>
<!-- /page container -->

@endsection

@section('script')
    @include('jdih.legislation.script')
@endsection
