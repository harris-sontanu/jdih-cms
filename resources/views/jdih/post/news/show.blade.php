@extends('jdih.layouts.app')

@section('title', $news->title . ' | ' . strip_tags($appName))
@section('content')

<!-- Page container -->
<div class="page-content container">

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Content area -->
        <main class="content ms-lg-3">
            <div class="row">
                <div class="col-xl-10 offset-xl-1">
                    <h2 class="display-6 fw-bold">{{ $news->title }}</h2>
                </div>
            </div>

        </main>
        <!-- /content area -->

    </div>
    <!-- /main content -->

</div>
<!-- /page container -->

@endsection
