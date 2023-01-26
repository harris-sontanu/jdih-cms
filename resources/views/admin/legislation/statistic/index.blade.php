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
                <div class="card-header d-sm-flex py-sm-0">
					<h5 class="py-sm-3 mb-sm-0">Jumlah Peraturan <span id="countYears">5</span> Tahun Terakhir</h5>
					<div class="ms-sm-auto my-sm-auto">
						<button type="button" data-bs-toggle="modal" data-bs-target="#law-statistic-filter-modal" data-action="yearlyFilter" class="btn btn-light" ><i class="ph-faders-horizontal me-2"></i>Filter</a>
					</div>
				</div>

                <div class="card-body">
                    <div class="chart-container">
                        <div class="chart has-fixed-height" id="chart_yearly_column"></div>
                    </div>
                </div>
            </div>
            <!-- /law yearly column chart -->

            <!-- Law monthly column chart -->
            <div class="card">
                <div class="card-header d-sm-flex py-sm-0">
					<h5 class="py-sm-3 mb-sm-0">Jumlah Peraturan Tahun <span id="yearTitle">{{ now()->subYear()->format('Y') }}</span></h5>
					<div class="ms-sm-auto my-sm-auto">
						<button type="button" data-bs-toggle="modal" data-bs-target="#law-statistic-filter-modal" data-action="monthlyFilter" class="btn btn-light" ><i class="ph-faders-horizontal me-2"></i>Filter</a>
					</div>
				</div>

                <div class="card-body">
                    <div class="chart-container">
                        <div class="chart has-fixed-height" id="chart_monthly_column"></div>
                    </div>
                </div>
            </div>
            <!-- /law monthly chart -->

            <!-- Law status column chart -->
            <div class="card">
                <div class="card-header">
					<h5 class="mb-0">Status Peraturan</h5>
				</div>

                <div class="card-body">
                    <div class="chart-container">
                        <div class="chart has-fixed-height" id="law_status_chart"></div>
                    </div>
                </div>
            </div>
            <!-- /law status column chart -->

        </div>

        <div class="sidebar sidebar-component sidebar-expand-lg bg-transparent shadow-none order-1 order-lg-2 ms-lg-3 mb-3 sidebar-mobile-expanded">

			<div class="sidebar-content">

                <!-- Basic line chart -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <h4 class="mb-0">{{ $countDownloads }}</h4>
                            <div class="d-inline-flex ms-auto">
                                <a class="text-body" data-card-action="reload">
                                    <i class="ph-arrow-clockwise"></i>
                                </a>
                            </div>
                        </div>

                        <div>
                            Produk Hukum yang diunduh hari ini
                            <div class="text-muted fs-sm">Rata-rata: <span id="avg-downloads"></span> buah</div>
                        </div>
                    </div>

                    <div id="chart_line_basic"></div>
                </div>
                <!-- /basic line chart -->

                <div class="sidebar-content">
                    <!-- Pie with legend -->
                    <div class="card card-body text-center">
                        <h6 class="mb-3">Jenis Peraturan paling banyak dilihat</h6>

                        <div class="svg-center" id="most-viewed-chart"></div>
                    </div>
                    <!-- /pie with legend -->
                </div>

                <div class="sidebar-content">
                    <!-- Pie with legend -->
                    <div class="card card-body text-center">
                        <h6 class="mb-0">Jenis Peraturan paling banyak diunduh</h6>
                        <div class="fs-sm text-muted mb-3">1 bulan terakhir</div>

                        <div class="svg-center" id="most-download-chart"></div>
                    </div>
                    <!-- /pie with legend -->
                </div>

            </div>

		</div>
	</div>

</div>
<!-- /content area -->

@endsection

@section('modal')
    @include('admin.legislation.statistic.modal')
@endsection

@section('script')
    @include('admin.legislation.statistic.script')
@endsection
