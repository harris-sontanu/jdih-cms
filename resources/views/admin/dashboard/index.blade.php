@extends('admin.layouts.app')

@section('title', $pageTitle)
@section('content')

<!-- Content area -->
<div class="content pt-0">

	<div class="row">
		<div class="col-sm-6 col-xl-3">
			<div class="card card-body">
				<div class="d-flex align-items-center">
					<i class="ph-scales ph-2x text-success me-3"></i>

					<div class="flex-fill text-end">
						<h4 class="mb-0">{{ number_format($totalLaws, 0, ',', '.') }}</h4>
						<span class="text-muted">Total Peraturan</span>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-6 col-xl-3">
			<div class="card card-body">
				<div class="d-flex align-items-center">
					<i class="ph-books ph-2x text-indigo me-3"></i>

					<div class="flex-fill text-end">
						<h4 class="mb-0">{{ number_format($totalMonographs, 0, ',', '.') }}</h4>
						<span class="text-muted">Total Monografi Hukum</span>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-6 col-xl-3">
			<div class="card card-body">
				<div class="d-flex align-items-center">
					<div class="flex-fill">
						<h4 class="mb-0">{{ number_format($totalArticles, 0, ',', '.') }}</h4>
						<span class="text-muted">Total Artikel Hukum</span>
					</div>

					<i class="ph-newspaper ph-2x text-primary ms-3"></i>
				</div>
			</div>
		</div>

		<div class="col-sm-6 col-xl-3">
			<div class="card card-body">
				<div class="d-flex align-items-center">
					<div class="flex-fill">
						<h4 class="mb-0">{{ number_format($totalJudgments, 0, ',', '.') }}</h4>
						<span class="text-muted">Total Putusan</span>
					</div>

					<i class="ph-stamp ph-2x text-danger ms-3"></i>
				</div>
			</div>
		</div>
	</div>

	<!-- Inner container -->
	<div class="d-flex align-items-stretch align-items-lg-start flex-column flex-lg-row">

		<!-- Left content -->
		<div class="flex-1 order-2 order-lg-1">

            <!-- Law yearly column chart -->
            <div class="card">
                <div class="card-header d-sm-flex py-sm-0">
					<h5 class="py-sm-3 mb-sm-0">Statistik Peraturan</h5>
					<div class="ms-sm-auto my-sm-auto">
						<a href="{{ route('admin.legislation.statistic') }}" class="btn btn-light" ><i class="ph-chart-bar me-2"></i>Statistik</a>
					</div>
				</div>

                <div class="card-body">
                    <div class="chart-container">
                        <div class="chart has-fixed-height" id="chart_yearly_column"></div>
                    </div>
                </div>
            </div>
            <!-- /law yearly column chart -->

			<!-- Basic table -->
			<div class="card">
				<div class="card-header d-sm-flex py-sm-0">
					<h5 class="py-sm-3 mb-sm-0">Produk Hukum Terbaru</h5>
					<div class="ms-sm-auto my-sm-auto">
						<div class="btn-group">
							<button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown"><i class="ph-plus me-2"></i>Tambah Produk Hukum</button>
							<div class="dropdown-menu dropdown-menu-end" data-popper-placement="top-end">
								<a href="{{ route('admin.legislation.law.create') }}" class="dropdown-item">Peraturan</a>
								<a href="{{ route('admin.legislation.monograph.create') }}" class="dropdown-item">Monografi Hukum</a>
								<a href="{{ route('admin.legislation.article.create') }}" class="dropdown-item">Artikel Hukum</a>
								<a href="{{ route('admin.legislation.judgment.create') }}" class="dropdown-item">Putusan</a>
							</div>
						</div>
					</div>
				</div>

				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th class="text-center">Tipe</th>
								<th>Judul</th>
								<th>Tahun</th>
								<th>Operator</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($legislations as $legislation)
								<tr>
									<td class="text-center">
                                        {!! $legislation->typeFlatButton !!}
                                    </td>
									<td>
                                        <a href="{{ route('admin.legislation.' . $legislation->category->type->route . '.show', $legislation->id) }}" class="fw-semibold text-body d-block">{{ $legislation->title }}</a>
                                        <span class="text-muted">{{ $legislation->category->name }}</span>
                                    </td>
                                    <td>{{ $legislation->year }}</td>
									<td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <img src="{{ $legislation->userPictureUrl($legislation->user->picture, $legislation->user->name) }}" alt="{{ $legislation->user->name }}" class="rounded-circle" width="32" height="32">
                                            </div>
                                            <div class="text-nowrap">
                                                <span class="d-block">{{ $legislation->user->name }}</span>
                                                <abbr class="fs-sm" data-bs-popup="tooltip" title="{{ $legislation->dateFormatted($legislation->created_at, true) }}">{{ $legislation->dateFormatted($legislation->created_at) }}</abbr>
                                            </div>
                                        </div>
                                    </td>
								</tr>
							@empty
								<tr class="table-warning"><td colspan="100" class="text-center">Belum ada produk hukum</td></tr>
							@endforelse
						</tbody>
					</table>
				</div>

			</div>
			<!-- /basic table -->

			<div class="card">

				<div class="card-header d-sm-flex py-sm-0">
					<h5 class="py-sm-3 mb-sm-0">Berita Terbaru</h5>
					<div class="ms-sm-auto my-sm-auto">
						<a href="{{ route('admin.news.create') }}" class="btn btn-light" ><i class="ph-plus me-2"></i>Tambah Berita</a>
					</div>
				</div>

				<div class="card-body pb-0">
					<div class="row">
						@php $i = 0; @endphp
						@foreach ($latestNews as $news)
							@if ($i === 0)
								<div class="col-xl-6">
							@else
								</div><div class="col-xl-6">
							@endif

							<div class="d-sm-flex align-items-sm-start mb-3">
								<a href="{{ route('admin.news.show', $news->id) }}" class="d-inline-block position-relative me-sm-3 mb-3 mb-sm-0">
									<img src="@if($news->cover){{ $news->cover->mediaThumbUrl }}@endif" class="flex-shrink-0 rounded" width="100">
								</a>

								<div class="flex-fill">
									<h6 class="mb-1"><a href="{{ route('admin.news.show', $news->id) }}">{{ $news->title }}</a></h6>
									<ul class="list-inline list-inline-bullet text-muted mb-2">
										<li class="list-inline-item fs-sm"><abbr data-bs-popup="tooltip" title="{{ $news->dateFormatted($news->published_at, true) }}">{{ $news->dateFormatted($news->published_at) }}</abbr></li>
										<li class="list-inline-item fs-sm"><a href="{{ route('admin.news.index', ['taxonomy' => $news->taxonomy->id]) }}" class="text-body">{{ $news->taxonomy->name }}</a></li>
									</ul>
									{!! $news->excerpt !!}
								</div>
							</div>
							@php $i++; @endphp
						@endforeach
						</div>
					</div>
				</div>
			</div>

		</div>

		<div class="sidebar sidebar-component sidebar-expand-lg bg-transparent shadow-none order-1 order-lg-2 ms-lg-3 mb-3 sidebar-mobile-expanded">

			<div class="sidebar-content">

                <!-- Basic area chart -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <h4 class="mb-0">{{ $countVoters }}</h4>
                            <div class="d-inline-flex ms-auto">
                                <a class="text-body" data-card-action="reload">
                                    <i class="ph-arrow-clockwise"></i>
                                </a>
                            </div>
                        </div>

                        <div>
                            Responden hari ini
                            <div class="text-muted fs-sm">Rata-rata: <span id="avg-voters"></span> responden</div>
                        </div>
                    </div>

                    <div id="vote-line-chart"></div>
                </div>
                <!-- /basic area chart -->

                <!-- Basic bar chart -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0">{{ $countVisitors }}</h4>
                            {!! $visitPercentage !!}
                        </div>

                        <div>
                            Pengunjung hari ini
                            <div class="text-muted fs-sm">Rata-rata: <span id="avg-visitor"></span> orang</div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div id="visitor-bar-chart"></div>
                    </div>
                </div>
                <!-- /basic bar chart -->

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

                    <div id="download-line-chart"></div>
                </div>
                <!-- /basic line chart -->

				<div class="card">
                    <div class="sidebar-section-header border-bottom">
                        <h5 class="mb-0"><i class="ph-clock-counter-clockwise me-2"></i>Riwayat</h5>
                    </div>

                    <div class="sidebar-section-body media-chat-scrollable">
                        <div class="list-feed">
                            @forelse ($latestLogs as $log)
                                <div class="list-feed-item">
                                    <span class="fw-semibold">{{ $log->user->name }}</span> {!! $log->message !!} pada <a href="{{ route('admin.legislation.' . $log->legislation->category->type->route . '.show', $log->legislation->id) }}">{{ $log->legislation->title }}</a>
                                    <div class="text-muted fs-sm">{{ $log->timeDifference($log->created_at) }}</div>
                                </div>
                            @empty
                                <p class="mb-0">Belum ada riwayat</p>
                            @endforelse
                        </div>
                    </div>
                </div>

			</div>

		</div>
	</div>

</div>
<!-- /content area -->

@endsection

@section('script')
    @include('admin.dashboard.script')
@endsection
