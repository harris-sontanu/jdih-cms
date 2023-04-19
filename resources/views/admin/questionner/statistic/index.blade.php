@extends('admin.layouts.app')

@section('title', $pageTitle)
@section('content')

<!-- Content area -->
<div class="content pt-0">

    <!-- Inner container -->
	<div class="d-flex align-items-stretch align-items-lg-start flex-column flex-lg-row">

		<!-- Left content -->
		<div class="flex-1 order-2 order-lg-1">

            @if ($identityQuestions->count() > 0)
                <div class="card">
                    <div class="card-header d-sm-flex py-sm-0">
                        <h5 class="py-sm-3 mb-sm-0">
                            Identitas Responden
                        </h5>
                        <div class="ms-sm-auto my-sm-auto">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#identity-filter-modal" class="btn btn-light">
                                <i class="ph-faders-horizontal me-2"></i>Filter
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($identityQuestions as $question)
                                <div id="question-chart-{{ $question->id }}-container" class="col-xl-6 col-lg-6 col-md-6 my-4">
                                    <h5 class="text-center mb-0">{{ $question->title }}</h5>
                                    <div class="chart-container">
                                        <div class="chart question-chart has-fixed-height" id="question-chart-{{ $question->id }}" data-question="{{ $question->id }}"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if ($questions->count() > 0)
                <div class="card">
                    <div class="card-header d-sm-flex py-sm-0">
                        <h5 class="py-sm-3 mb-sm-0">
                            Statistik Kuesioner
                        </h5>
                        <div class="ms-sm-auto my-sm-auto">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#questionner-filter-modal" class="btn btn-light">
                                <i class="ph-faders-horizontal me-2"></i>Filter
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($questions as $question)
                                <div id="question-chart-{{ $question->id }}-container" class="col-xl-6 col-lg-6 col-md-6 my-4">
                                    <h5 class="text-center mb-0">{{ $question->title }}</h5>
                                    <div class="chart-container">
                                        <div class="chart question-chart has-fixed-height" id="question-chart-{{ $question->id }}" data-question="{{ $question->id }}"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

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

            </div>

		</div>
	</div>

</div>
<!-- /content area -->

@endsection

@section('script')
    @include('admin.questionner.statistic.script')
@endsection
