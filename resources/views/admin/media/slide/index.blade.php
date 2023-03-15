@extends('admin.layouts.app')

@section('title', $pageTitle)
@section('content')

    <!-- Content area -->
    <div class="content pt-0">

        @include('admin.layouts.message')

        <div class="card">
            <div class="card-header card-header d-sm-flex py-sm-0">
                <div class="py-sm-3 mb-sm-0 mb-3">
                    <div class="form-control-feedback form-control-feedback-end">
                        <form action="{{ route('admin.media.image.index') }}" method="get">
                            <input type="search" name="search" class="form-control rounded-pill" placeholder="Cari deskripsi..." @if (Request::get('search')) value="{{ Request::get('search') }}" @endif autofocus>
                            <div class="form-control-feedback-icon">
                                <i class="ph-magnifying-glass text-muted"></i>
                            </div>
                        </form>
                    </div>
                </div>

                @include('admin.media.feature', ['type' => 'gambar'])

            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            @cannot('isAuthor')
                                <th width="1"><i class="ph-dots-six-vertical "></i></th>
                            @endcannot
                            <th width="1" class="text-center">Gambar</th>
                            <th>Deskripsi</th>
                            <th>Posisi</th>
                            <th>Ukuran</th>
                            <th>Operator</th>
                            <th width="1" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="sortable">
                        @forelse ($slides as $slide)
                            <tr id="{{ $slide->id }}" class="item" data-id="{{ $slide->id }}">
                                @cannot('isAuthor')
                                    <td class="drag-handle"><i class="ph-dots-six-vertical  dragula-handle"></i></td>
                                @endcannot
                                <td class="safezone text-center"><img src="{{ $slide->image->source }}" class="img-preview rounded"></td>
                                <td>
                                    <span class="fw-semibold d-block">{{ $slide->header }}</span>
                                    @isset ($slide->subheader)
                                       <p class="d-block">{!! $slide->subheader !!}</p>
                                    @endisset
                                    @isset ($slide->desc)
                                        <p>{{ $slide->desc }}</p>
                                    @endisset
                                </td>
                                <td><span class="badge bg-info bg-opacity-20 text-info">{{ $slide->positionText }}</span></td>
                                <td>{{ $slide->image->size() }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            <img src="{{ $slide->image->userPictureUrl($slide->image->user->picture, $slide->image->user->name) }}" alt="{{ $slide->image->user->name }}" class="rounded-circle" width="32" height="32">
                                        </div>
                                        {{ $slide->image->user->name }}
                                    </div>
                                </td>
                                <td class="safezone">
                                    <div class="d-inline-flex">
                                        <a href="{{ $slide->image->source }}" class="text-body mx-1" data-lightbox="lightbox" data-bs-popup="tooltip" title="Pratinjau"><i class="ph-eye"></i></a>

                                        <button type="button" class="btn btn-link text-body p-0 mx-1" data-bs-popup="tooltip" title="Ubah" data-bs-toggle="modal" data-bs-target="#edit-modal" data-id="{{ $slide->id }}" data-route="slide"><i class="ph-pen"></i></button>

                                        <form class="delete-form" action="{{ route('admin.media.slide.destroy', $slide->id) }}" data-confirm="Apakah Anda yakin ingin menghapus slide?" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-link text-body p-0 mx-1 delete" data-bs-popup="tooltip" title="Hapus"><i class="ph-x"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="table-warning"><td colspan="100" class="text-center text-warning">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>

                    {{ $slides->links('admin.layouts.pagination') }}

                </table>
            </div>
        </div>

    </div>
    <!-- /content area -->

@endsection

@section('modal')
    @include('admin.media.slide.create')
    @include('admin.layouts.modal')
@endsection

@section('script')
    @include('admin.media.script')
@endsection
