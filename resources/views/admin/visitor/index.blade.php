@extends('admin.layouts.app')

@section('title', $pageTitle)
@section('content')

<!-- Content area -->
<div class="content pt-0">
    <!-- Inner container -->
    <div class="d-flex align-items-stretch align-items-lg-start flex-column flex-lg-row">

        <!-- Left content -->
        <div class="flex-1 order-2 order-lg-1">

            <!-- Law yearly column chart -->
            <div class="card">
                <div class="card-header py-sm-0">
                    <h5 class="py-sm-3 mb-sm-0">Statistik Pengunjung</h5>
                </div>

                <div class="card-body">
                    <div class="chart-container">
                        <div class="chart has-fixed-height" id="visitor-chart"></div>
                    </div>
                </div>
            </div>
            <!-- /law yearly column chart -->
        </div>

        <div class="sidebar sidebar-component sidebar-expand-lg bg-transparent shadow-none order-1 order-lg-2 ms-lg-3 mb-3 sidebar-mobile-expanded">

			<div class="sidebar-content">
                <!-- Pie with legend -->
                <div class="card card-body text-center">
                    <h6 class="mb-0">Statistik Peramban</h6>
                    <div id="date-stats" class="fs-sm text-muted mb-3"></div>

                    <div class="svg-center" id="browser-chart"></div>
                </div>
                <!-- /pie with legend -->
            </div>

		</div>
	</div>
</div>
<!-- /content area -->

@endsection

@section('script')
    @include('admin.visitor.script')
@endsection
