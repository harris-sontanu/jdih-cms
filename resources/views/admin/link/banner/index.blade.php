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
                        <form action="{{ route('admin.link.banner.index') }}" method="get">
                            <input type="search" name="search" class="form-control rounded-pill" placeholder="Cari judul, keterangan..." @if (Request::get('search')) value="{{ Request::get('search') }}" @endif autofocus>
                            <div class="form-control-feedback-icon">
                                <i class="ph-magnifying-glass text-muted"></i>
                            </div>
                        </form>
                    </div>
                </div>

                @include('admin.link.feature', ['type' => 'banner'])

            </div>

            @isset ($tabFilters)
                <div class="navbar navbar-expand-lg border-bottom py-2">
                    <div class="container-fluid">
                        <ul class="nav navbar-nav flex-row flex-fill">
                            @foreach ($tabFilters as $key => $value)
                                @php $active = ((empty(Request::get('tab')) AND $key === 'total') OR Request::get('tab') == $key) ? ' active' : '' @endphp
                                <li class="nav-item me-1">
                                    <a href="{{ route('admin.link.banner.index', ['tab' => $key] + Request::all()) }}" class="navbar-nav-link rounded{{ $active }}">
                                        <span class="d-lg-inline-block ms-2">
                                            {{ Str::title($key) }}
                                            <span class="badge bg-indigo rounded-pill ms-auto ms-lg-2">{{ number_format($value, 0, ',', '.') }}</span>
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="navbar-collapse collapse" id="profile_nav">
                            <ul class="navbar-nav ms-lg-auto mt-2 mt-lg-0">
                                <li class="nav-item dropdown ms-lg-1">
                                    <a href="#" class="navbar-nav-link rounded dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="ph-list-dashes"></i>
                                        <span class="d-none d-lg-inline-block ms-2">
                                            @if (!empty(Request::get('limit')) AND $limit = Request::get('limit'))
                                                {{ $limit }}
                                            @else
                                                25
                                            @endif
                                        </span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="{{ route('admin.link.banner.index', ['limit' => 25] + Request::all()) }}" class="dropdown-item" data-rows="25">25</a>
                                        <a href="{{ route('admin.link.banner.index', ['limit' => 50] + Request::all()) }}" class="dropdown-item" data-rows="50">50</a>
                                        <a href="{{ route('admin.link.banner.index', ['limit' => 100] + Request::all()) }}" class="dropdown-item" data-rows="100">100</a>
                                        <a href="{{ route('admin.link.banner.index', ['limit' => 200] + Request::all()) }}" class="dropdown-item" data-rows="200">200</a>
                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            @endisset

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            @if (!empty(Request::get('sort')) AND $sort = Request::get('sort'))
                                @php $sortState = ($sort == 'asc') ? 'desc' : 'asc' @endphp
                            @else
                                @php $sortState = 'asc' @endphp
                            @endif

                            @cannot('isAuthor')
                                <th width="1"><input type="checkbox" /></th>
                                <th width="1"><i class="ph-dots-six-vertical "></i></th>
                            @endcannot
                            <th width="1" class="text-center">Gambar</th>
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'title') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('admin.link.banner.index', ['order' => 'title', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Judul</a>
                            </th>
                            <th>Tampilan</th>
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'user') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('admin.link.banner.index', ['order' => 'user', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Pengunggah</a>
                            </th>
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'created_at') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('admin.link.banner.index', ['order' => 'created_at', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Publikasi</a>
                            </th>
                            @cannot('isAuthor')
                                <th width="1" class="text-center">Aksi</th>
                            @endcannot
                        </tr>
                    </thead>
                    <tbody id="sortable">
                        @forelse ($banners as $banner)
                            <tr id="{{ $banner->id }}" class="item" data-id="{{ $banner->id }}">
                                @cannot('isAuthor')
                                    <td><input type="checkbox" class="checkbox" data-item="{{ $banner->id }}"></td>
                                    <td class="drag-handle"><i class="ph-dots-six-vertical dragula-handle"></i></td>
                                @endcannot
                                <td class="text-center"><img src="{{ $banner->image->thumbSource }}" class="img-preview rounded"></td>
                                <td>
                                    <span class="fw-semibold d-block">{{ $banner->title }}</span>
                                    <span class="text-muted fs-sm">{{ $banner->url }}</span>
                                </td>
                                <td>{!! $banner->display->displayBadge() !!}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            <img src="{{ $banner->userPictureUrl($banner->user->picture, $banner->user->name) }}" alt="{{ $banner->user->name }}" class="rounded-circle" width="32" height="32">
                                        </div>
                                        {{ $banner->user->name }}
                                    </div>
                                </td>
                                <td>
                                    <span class="d-block">{!! $banner->publicationLabel() !!}</span>
                                    <abbr class="fs-sm" data-bs-popup="tooltip" title="{{ $banner->dateFormatted($banner->published_at, true) }}">{{ $banner->dateFormatted($banner->published_at) }}</abbr>
                                </td>
                                @cannot('isAuthor')
                                    <td class="safezone">
                                        <div class="d-inline-flex">
                                            <a href="{{ $banner->image->source }}" class="text-body me-2" data-lightbox="lightbox" data-bs-popup="tooltip" title="Pratinjau"><i class="ph-eye"></i></a>
                                            <button type="button" class="btn btn-link text-body p-0" data-bs-popup="tooltip" title="Ubah" data-bs-toggle="modal" data-bs-target="#edit-modal" data-id="{{ $banner->id }}" data-route="banner"><i class="ph-pen"></i></button>
                                            <form class="delete-form" action="{{ route('admin.link.banner.destroy', $banner->id) }}" data-confirm="Apakah Anda yakin ingin menghapus banner?" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-link text-body p-0 ms-2 delete" data-bs-popup="tooltip" title="Hapus"><i class="ph-x"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                @endcannot
                            </tr>
                        @empty
                            <tr class="table-warning"><td colspan="100" class="text-center text-warning">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>

                    {{ $banners->links('admin.layouts.pagination') }}

                </table>
            </div>
        </div>

    </div>
    <!-- /content area -->

@endsection

@section('modal')
    @include('admin.link.banner.create')
    @include('admin.layouts.modal')
@endsection

@section('script')
    @include('admin.link.script')
@endsection
