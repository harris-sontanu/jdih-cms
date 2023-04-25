@extends('admin.layouts.app')

@section('title', $pageTitle)
@section('content')

    <!-- Content area -->
    <div class="content pt-0">

        @include('admin.layouts.message')

        <!-- Form -->
        <form method="POST" action="{{ route('admin.page.store') }}" novalidate enctype="multipart/form-data">
            @csrf

            <!-- Inner container -->
            <div class="d-flex align-items-stretch align-items-lg-start flex-column flex-lg-row">

                <!-- Left content -->
                <div class="flex-1 order-2 order-lg-1">

                    <div class="card card-body">

                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">

                                <div class="mb-3">
                                    <label class="col-form-label" for="title">Judul:</label>
                                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror @error('slug') is-invalid @enderror" value="{{ old('title') }}" autofocus>
                                    <div class="form-text text-muted">Format penulisan: huruf awal setiap kata pada judul ditulis kapital.</div>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="ckeditor_body" class="col-form-label">Isi:</label>
                                    <textarea name="body" class="form-control @error('body') is-invalid @enderror" id="ckeditor_body">{{ old('body') }}</textarea>
                                    @error('body')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="ckeditor_excerpt" class="col-form-label">Cuplikan:</label>
                                    <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" id="ckeditor_excerpt">{{ old('excerpt') }}</textarea>
                                    @error('excerpt')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="author" class="col-form-label">Penulis:</label>
                                    <select id="author_id" name="author_id" class="select @error('author_id') is-invalid @enderror">
                                        <option value="">Pilih Penulis</option>
                                        @foreach ($authors as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('author_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                    </div>

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
                                </tbody>
                            </table>
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <button type="submit" name="draft" class="btn btn-link px-0">Simpan ke Draf</button>
                                <button type="submit" name="publish" class="btn btn-indigo">Terbit</button>
                            </div>
                        </div>

                        <div class="card">
                            <div class="sidebar-section-header border-bottom">
                                <span class="fw-semibold"><i class="ph-folder me-2"></i>Kategori</span>
                            </div>
                            <div class="sidebar-section-body">
                                <div id="taxonomy-options">
                                    <select id="taxonomy_id" name="taxonomy_id" class="select @error('taxonomy_id') is-invalid @enderror">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($taxonomies as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('taxonomy_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#create-taxonomy-modal">+ Kategori</a>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="sidebar-section-header border-bottom">
                                <span class="fw-semibold"><i class="ph-image-square me-2"></i>Sampul</span>
                            </div>

                            <div class="card-img-actions mx-1 mt-1">
                                <img id="cover-img" class="card-img img-fluid" src="{{ asset('assets/admin/images/placeholders/placeholder.jpg') }}" alt="Placeholder">
                            </div>

                            <div class="card-body">
                                <textarea name="caption" rows="4" class="form-control mb-3" placeholder="Keterangan gambar"></textarea>

                                <input id="cover-input" type="file" class="form-control @error('cover') is-invalid @enderror" name="cover">
                                <div class="form-text text-muted">Format: gif, png, jpg, jpeg, bmp, svg, webp.</div>
                                @error('cover')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
    @include('admin.taxonomy.create')
@endsection

@section('script')
    @include('admin.page.script')
@endsection
