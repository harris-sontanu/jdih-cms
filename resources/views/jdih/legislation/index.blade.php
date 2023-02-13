@extends('jdih.layouts.app')

@section('title', 'Produk Hukum | ' . $appName)
@section('content')

<section class="bg-dark bg-opacity-3">
    <div class="container">
        <div class="content-wrapper">
            <div class="d-flex">
                <div class="breadcrumb py-2">
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

@endsection
