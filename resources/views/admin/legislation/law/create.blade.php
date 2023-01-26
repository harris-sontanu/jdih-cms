@extends('admin.layouts.app')

@section('title', $pageTitle)
@section('content')

    <!-- Content area -->
    <div class="content pt-0">

        @include('admin.layouts.message')

        <!-- Form -->
        <form method="POST" action="{{ route('admin.legislation.law.store') }}" novalidate enctype="multipart/form-data">
            @csrf

            <!-- Inner container -->
            <div class="d-flex align-items-stretch align-items-lg-start flex-column flex-lg-row">

                <!-- Left content -->
                <div class="flex-1 order-2 order-lg-1">

                    @include('admin.legislation.law.tab.index')

                </div>
                <!-- /left content -->

                <div class="sidebar sidebar-component sidebar-expand-lg bg-transparent shadow-none order-1 order-lg-2 ms-lg-3 mb-3">

                    <div class="sidebar-content">

                        <div class="card">
                            <div class="sidebar-section-header border-bottom">
                                <span class="fw-semibold"><i class="ph-globe-hemisphere-east me-2"></i>Publikasi</span>
                            </div>

                            <table class="table table-borderless my-2 table-xs">
                                <tbody>
                                    <tr>
                                        <td class="text-nowrap"><i class="ph-tag me-2"></i>Status:</td>
                                        <td class="text-end"><span class="badge bg-warning bg-opacity-20 text-warning">Draf</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><i class="ph-user me-2"></i>Operator:</td>
                                        <td class="text-end">{{ Auth::guard('admin')->user()->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><i class="ph-calendar-blank me-2"></i>Terbit:</td>
                                        <td class="text-end">
                                            <input type="text" class="form-control datetimerange-single text-end @error('published_at') is-invalid @enderror" name="published_at" value="{{ old('published_at', empty($law) ? now()->translatedFormat('d-m-Y H:i') : $law->published_at) }}">
                                            @error('published_at')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <button type="submit" name="draft" class="btn btn-link px-0">Simpan ke Draf</button>
                                <button type="submit" name="publish" class="btn btn-indigo">Terbit</button>
                            </div>
                        </div>

                        <div class="card">
                            <div class="sidebar-section-header border-bottom">
                                <span class="fw-semibold"><i class="ph-files me-2"></i>Dokumen</span>
                            </div>

                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="master" class="col-form-label">Batang Tubuh</label>
                                    <input type="file" class="form-control @error('master') is-invalid @enderror" name="master" accept=".pdf">
                                    <div class="form-text text-muted">Format: pdf. Ukuran maks: 2Mb.</div>
                                    @error('master')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="abstract" class="col-form-label">Abstrak</label>
                                    <input type="file" class="form-control @error('abstract') is-invalid @enderror" name="abstract" accept=".pdf">
                                    <div class="form-text text-muted">Format: pdf. Ukuran maks: 2Mb.</div>
                                    @error('abstract')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="attachment" class="col-form-label">Lampiran</label>
                                    <input type="file" class="form-control @error('attachment.*') is-invalid @enderror" name="attachment[]" accept=".doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf, .zip, .rar, .rtf, .txt">
                                    @error('attachment.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <button type="button" class="btn btn-link p-0 mt-1 form-text new-attachment">Tambah Lampiran</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /sidebar content -->

                </div>
                <!-- /sidebar -->

            </div>

        </form>

    </div>
    <!-- /content area -->

@endsection

@section('modal')
    @include('admin.legislation.matter.create')
    @include('admin.legislation.institute.create')
    @include('admin.legislation.field.create')
    @include('admin.legislation.law.tab.add-status-relation-modal')
    @include('admin.legislation.law.tab.add-law-relation-modal')
    @include('admin.legislation.law.tab.add-doc-relation-modal')
@endsection

@section('script')
    @include('admin.legislation.script')
@endsection
