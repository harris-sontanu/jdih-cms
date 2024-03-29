@extends('jdih.layouts.app')

@section('title', $questionnerSettings->title . ' | ' . strip_tags($appName))
@section('content')

<!-- Page title -->
<section class="bg-dark bg-opacity-3 mb-4">
    <div class="page-content container p-0">
        <div class="content-wrapper">
            <div class="content">
                <div class="page-header text-center">
                    <div class="page-header-content">
                        <div class="page-title pt-5 pb-7">
                            <h2 class="d-block display-6 fw-bold mb-0">{{ $questionnerSettings->title }}</h2>
                            <div class="text-muted mt-1 fs-lg">{{ $questionnerSettings->desc }}</div>
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
        <div class="content row gx-5">

            <main class="col-xl-10 offset-xl-1">
                <article class="card shadow post-entry mb-4">

                    <div class="card-body fs-5 post-container">

                        @if (session('message'))
                            <div class="alert alert-success border-0 alert-dismissible fade show">
                                {!! session('message') !!}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger border-0 alert-dismissible fade show">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('vote') }}" method="post">
                            @csrf

                            @if (isset($identityQuestions) AND $identityQuestions->count() > 0)
                                <h3 class="fw-bold">Identitas Responden</h3>

                                @foreach ($identityQuestions as $question)
                                    <div class="d-flex mb-3">
                                        <div class="me-3">
                                            <div class="bg-danger bg-opacity-10 text-danger lh-1 rounded-pill p-2">
                                                <span class="letter-icon">0{{ $loop->iteration }}</span>
                                            </div>
                                        </div>
                                        <div class="flex-fill">
                                            <p class="mb-3">{{ $question->title }}</p>

                                            @foreach ($question->answers as $answer)
                                                <div class="form-check mb-2 d-flex align-items-center">
                                                    <input id="answer-{{ $answer->id }}" type="radio" class="form-check-input me-2" name="answers[{{ $question->id }}]" value="{{ $answer->id }}">
                                                    <label for="answer-{{ $answer->id }}" class="form-check-label cursor-pointer">{{ $answer->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            @if (isset($questions) AND $questions->count() > 0)
                                <h3 class="fw-bold">Pertanyaan</h3>

                                @foreach ($questions as $question)
                                    <div class="d-flex mb-3">
                                        <div class="me-3">
                                            <div class="bg-danger bg-opacity-10 text-danger lh-1 rounded-pill p-2">
                                                <span class="letter-icon">0{{ $loop->iteration }}</span>
                                            </div>
                                        </div>
                                        <div class="flex-fill">
                                            <p class="mb-2">{{ $question->title }}</p>

                                            @foreach ($question->answers as $answer)
                                                <div class="form-check mb-2 d-flex align-items-center">
                                                    <input id="answer-{{ $answer->id }}" type="radio" class="form-check-input me-2" name="answers[{{ $question->id }}]" value="{{ $answer->id }}">
                                                    <label for="answer-{{ $answer->id }}" class="form-check-label cursor-pointer">{{ $answer->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            <button type="submit" class="btn btn-lg btn-danger lift px-3 fw-semibold">Kirim<i class="ph-paper-plane-tilt ms-2"></i></button>
                        </form>
                    </div>

                </article>

                @if (isset($banners) AND $banners->count() > 0)
                    <div class="row gx-4 mb-4">
                        @foreach ($banners as $banner)
                            @break($loop->iteration > 3)
                            <div class="col-xl-4">
                                <div class="card shadow bg-white border-0 lift mb-0">
                                    <a href="{{ $banner->url }}"><img src="{{ $banner->image->source }}" class="img-fluid rounded" alt="" srcset=""></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </main>

        </div>
        <!-- /content area -->

    </div>
    <!-- /main content -->

</div>
<!-- /page container -->

@endsection
