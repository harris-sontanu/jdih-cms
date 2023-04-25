@extends('admin.layouts.app')

@section('title', $pageTitle)
@section('content')

    <!-- Content area -->
    <div class="content pt-0">

        @include('admin.layouts.message')

        <!-- Form -->
        <form method="POST" action="{{ route('admin.news.update', $news->id) }}" novalidate enctype="multipart/form-data">
            @method('PUT')
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
                                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror @error('slug') is-invalid @enderror" value="{{ $news->title }}" autofocus>
                                    <div class="form-text text-muted">Format penulisan: huruf awal setiap kata pada judul ditulis kapital kecuali kata depan.</div>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="ckeditor_body" class="col-form-label">Isi:</label>
                                    <textarea name="body" class="form-control @error('body') is-invalid @enderror" id="ckeditor_body">{{ $news->body }}</textarea>
                                    @error('body')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="ckeditor_excerpt" class="col-form-label">Cuplikan:</label>
                                    <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" id="ckeditor_excerpt">{{ $news->excerpt }}</textarea>
                                    @error('excerpt')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label" for="source">Sumber:</label>
                                    <input type="text" name="source" id="source" class="form-control @error('source') is-invalid @enderror" value="{{ $news->source }}">
                                    <div class="form-text text-muted">Asal dari berita itu diperoleh.</div>
                                    @error('source')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label" for="source">Galeri Foto:</label>

                                    @if ($news->galleries->count() > 0)
                                        <div class="row">
                                            @foreach ($news->galleries as $gallery)
                                                <div class="col-sm-6 col-lg-4">
                                                    <div class="card">
                                                        <div class="card-img-actions m-0">
                                                            <img class="card-img img-fluid" src="{{ $gallery->thumbSource }}">
                                                            <div class="card-img-actions-overlay card-img">
                                                                <a href="{{ $gallery->source }}" class="btn btn-outline-white btn-icon rounded-pill" data-bs-popup="lightbox" data-gallery="gallery1">
                                                                    <i class="ph-plus"></i>
                                                                </a>

                                                                <a href="#" class="btn btn-outline-white btn-icon rounded-pill ms-2 delete-media" data-media="{{ $gallery->id }}">
                                                                    <i class="ph-trash"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <input type="file" name="photos[]" class="file-input @error('photos.*') is-invalid @enderror" multiple="multiple">
                                    @error('photos.*')
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
                                        <td class="text-end"><span class="badge bg-warning bg-opacity-20 text-warning">{!! $news->publicationLabel() !!}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><i class="ph-user me-2"></i>Penulis:</td>
                                        <td class="text-end">{{ $news->author->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><i class="ph-calendar-blank me-2"></i>Posting:</td>
                                        <td class="text-end">
                                            <abbr class="publish-date-text" data-bs-popup="tooltip" title="{{ $news->dateFormatted($news->created_at, true) }}">{{ $news->dateFormatted($news->created_at) }}</abbr>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><i class="ph-calendar-blank me-2"></i>Terbit:</td>
                                        <td class="text-end">
                                            <input type="text" class="form-control datetimerange-single text-end @error('published_at') is-invalid @enderror" name="published_at" placeholder="{{ now()->translatedFormat('d-m-Y H:i') }}" value="{{ empty($news->published_at) ? null : $news->published_at }}">
                                            @error('published_at')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <button type="submit" name="draft" class="btn btn-link px-0">Ubah ke Draf</button>
                                <button type="submit" name="publish" class="btn btn-indigo">Ubah</button>
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
                                            <option value="{{ $key }}" @selected($news->taxonomy_id === $key)>{{ $value }}</option>
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
                                <img id="cover-img" class="card-img img-fluid" src="{{ $news->cover->thumbSource ?? asset('assets/admin/images/placeholders/placeholder.jpg') }}" alt="Placeholder">
                                <div class="card-img-actions-overlay card-img">
                                    <a href="{{ $news->cover->source ?? '#' }}" class="btn btn-outline-white btn-icon rounded-pill" data-bs-popup="lightbox" data-gallery="cover">
                                        <i class="ph-plus"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="card-body">
                                <textarea name="caption" rows="4" class="form-control mb-3" placeholder="Keterangan gambar">{{ $news->cover->caption ?? '' }}</textarea>

                                <input id="cover-input" type="file" class="form-control @error('cover') is-invalid @enderror" name="cover">
                                <div class="form-text text-muted">Format: gif, png, jpg, jpeg, bmp, svg, webp. Ukuran maks: 2Mb.</div>
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
    @include('admin.news.script')
@endsection
