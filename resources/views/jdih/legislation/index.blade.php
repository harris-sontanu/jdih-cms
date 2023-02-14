@extends('jdih.layouts.app')

@section('title', 'Produk Hukum | ' . $appName)
@section('content')

<!-- Page container -->
<div class="page-content container">

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Content area -->
        <div class="content">

            <div class="d-flex">
                <div class="breadcrumb py-3">
                    <a href="index.html" class="breadcrumb-item"><i class="ph-house me-2"></i>Beranda</a>
                    <span class="breadcrumb-item active">Produk Hukum</span>
                </div>

                <a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                    <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                </a>
            </div>

            <div class="d-lg-flex align-items-lg-start">

                @include('jdih.legislation.aside')

                <main class="flex-1 ms-lg-3">

                    <section class="d-flex align-items-center mb-4">
                        <span>Menampilkan 1 - 10 dari 1.277 produk hukum</span>
                        <div class="ms-auto my-auto">
                            <span class="d-inline-block me-2">Urutkan</span>
                            <div class="btn-group">
                                <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown">Terbaru</button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="#" class="dropdown-item active">Terbaru</a>
                                    <a href="#" class="dropdown-item">Terpopuler</a>
                                    <a href="#" class="dropdown-item">Nomor kecil ke besar</a>
                                    <a href="#" class="dropdown-item">Dilihat paling banyak</a>
                                    <a href="#" class="dropdown-item">Dilihat paling sedikit</a>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="card card-body">
						<div class="d-sm-flex align-items-sm-start">
							<a href="#" class="d-block me-sm-3 mb-3 mb-sm-0">
								<img src="{{ asset('assets/jdih/images/demo/book2.jpg') }}" width="96">
							</a>

							<div class="flex-fill">
								<h5 class="mb-1">
									<a href="#">Interaction UX/UI Industrial Designer</a>
								</h5>

								<ul class="list-inline list-inline-bullet text-muted mb-2">
									<li class="list-inline-item"><a href="#" class="text-body">Dell</a></li>
									<li class="list-inline-item">Amsterdam, Netherlands</li>
								</ul>

								Extended kindness trifling remember he confined outlived if. Assistance sentiments yet unpleasing say. Open they an busy they my such high. An active dinner wishes at unable hardly no talked on. Immediate him her resolving his favourite. Wished denote abroad at branch at. Mind what no by kept.
							</div>

							<div class="flex-shrink-0 ms-sm-3 mt-2 mt-sm-0">
								<span class="badge bg-primary">New</span>
							</div>
						</div>
					</div>
                </main>
            </div>



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
