@extends('admin.layouts.app')

@section('title', $pageTitle)
@section('content')

    <!-- Content area -->
    <div class="content pt-0">

        @include('admin.layouts.message')

        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-lg-8 offset-lg-2">

                        <!-- Form -->
                        <form id="post-form" method="POST" action="{{ route('admin.setting.questionner') }}" novalidate>
                            @method('PUT')
                            @csrf
                            <fieldset>
                                <legend class="fs-base fw-bold border-bottom pb-2 mb-3"><i class="ph-pencil-line me-2"></i>Informasi Kuisioner</legend>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label">Judul:</label>
                                    <div class="col-lg-9">
                                        <input id="title" type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ $questionner->title }}">
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label">Tujuan:</label>
                                    <div class="col-lg-9">
                                        <textarea id="desc" type="text" name="desc" rows="4" spellcheck="false" class="form-control @error('desc') is-invalid @enderror">{{ $questionner->desc }}</textarea>
                                        @error('desc')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label">Status:</label>
                                    <div class="col-lg-9">
                                        <div class="form-check-horizontal">
                                            <label class="form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input" name="active" @checked($questionner->active)>
                                                <span class="form-check-label">Aktif</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row mb-0">
                                    <div class="col-lg-9 offset-lg-3">
                                        <button type="submit" class="btn btn-indigo">Ubah</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>

                        <fieldset>
                            <legend class="fs-base fw-bold border-bottom pb-2 mb-3"><i class="ph-user-list me-2"></i>Identitas Responden</legend>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($identityQuestions as $question)
                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{ $i }}.</label>
                                    <div class="col-lg-9">                                        
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" value="{{ $question->title }}">
                                            <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown"><i class="ph-gear"></i></button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#edit-modal" data-id="{{ $question->id }}"><i class="ph-pen me-2"></i>Ubah</button>
                                                <form class="delete-question-form" action="{{ route('admin.questionner.question.delete', $question->id) }}" method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="dropdown-item" type="submit" data-bs-popup="tooltip" title="Hapus"><i class="ph-trash me-2"></i>Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                Jawaban
                                            </span>
                                            <select class="form-control select" multiple="multiple" data-tags="true" data-width="1%" disabled>
                                                @foreach ($question->answers as $answer)
                                                    <option value="{{ $answer->id }}" selected>{{ $answer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @php $i++; @endphp
                            @endforeach

                            <div class="mb-3 row mb-0">
                                <div class="col-lg-9 offset-lg-3">
                                    <button type="button" class="btn btn-indigo" data-bs-toggle="modal" data-bs-target="#create-modal" data-type="identity">Tambah Pertanyaan</button>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="fs-base fw-bold border-bottom pb-2 mb-3"><i class="ph-list-numbers me-2"></i>Pertanyaan</legend>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($questions as $question)
                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{ $i }}.</label>
                                    <div class="col-lg-9">                                        
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" value="{{ $question->title }}">
                                            <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown"><i class="ph-gear"></i></button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#edit-modal" data-id="{{ $question->id }}"><i class="ph-pen me-2"></i>Ubah</button>
                                                <form class="delete-question-form" action="{{ route('admin.questionner.question.delete', $question->id) }}" method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="dropdown-item" type="submit" data-bs-popup="tooltip" title="Hapus"><i class="ph-trash me-2"></i>Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                Jawaban
                                            </span>
                                            <select class="form-control select" multiple="multiple" data-tags="true" data-width="1%" disabled>
                                                @foreach ($question->answers as $answer)
                                                    <option value="{{ $answer->id }}" selected>{{ $answer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @php $i++; @endphp
                            @endforeach

                            <div class="mb-3 row mb-0">
                                <div class="col-lg-9 offset-lg-3">
                                    <button type="button" class="btn btn-indigo" data-bs-toggle="modal" data-bs-target="#create-modal" data-type="question">Tambah Pertanyaan</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <!-- /content area -->

@endsection

@section('modal')
    @include('admin.questionner.create')
    @include('admin.layouts.modal')
@endsection

@section('script')
    @include('admin.questionner.script')
@endsection
