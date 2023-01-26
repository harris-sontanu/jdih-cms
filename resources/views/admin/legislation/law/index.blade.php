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
                        <form action="{{ route('admin.legislation.law.index') }}" method="get">
                            <input type="search" name="search" class="form-control rounded-pill" placeholder="Cari judul, jenis..." @if (Request::get('search')) value="{{ Request::get('search') }}" @endif autofocus>
                            <div class="form-control-feedback-icon">
                                <i class="ph-magnifying-glass text-muted"></i>
                            </div>
                        </form>
                    </div>
                </div>

                @include('admin.legislation.law.feature')

            </div>

            <div id="filter-options" @empty (Request::get('filter')) style="display: none" @endempty>

                @include('admin.legislation.law.filter')

            </div>

            @isset ($tabFilters)
                <div class="navbar navbar-expand-lg border-bottom py-2">
                    <div class="container-fluid">
                        <ul class="nav navbar-nav flex-row flex-fill">
                            @foreach ($tabFilters as $key => $value)
                                @php $active = ((empty(Request::get('tab')) AND $key === 'total') OR Request::get('tab') == $key) ? ' active' : '' @endphp
                                <li class="nav-item me-1">
                                    <a href="{{ route('admin.legislation.law.index', ['tab' => $key] + Request::all()) }}" class="navbar-nav-link rounded{{ $active }}">
                                        <span class="d-lg-inline-block ms-2">
                                            {{ Str::ucfirst($key) }}
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
                                        <a href="{{ route('admin.legislation.law.index', ['limit' => 25] + Request::all()) }}" class="dropdown-item" data-rows="25">25</a>
                                        <a href="{{ route('admin.legislation.law.index', ['limit' => 50] + Request::all()) }}" class="dropdown-item" data-rows="50">50</a>
                                        <a href="{{ route('admin.legislation.law.index', ['limit' => 100] + Request::all()) }}" class="dropdown-item" data-rows="100">100</a>
                                        <a href="{{ route('admin.legislation.law.index', ['limit' => 200] + Request::all()) }}" class="dropdown-item" data-rows="200">200</a>
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
                            @endcannot
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'category') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('admin.legislation.law.index', ['order' => 'category', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Jenis</a>
                            </th>
                            <th class="text-center sorting @if (!empty($sort) AND Request::get('order') == 'number') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('admin.legislation.law.index', ['order' => 'number', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Nomor</a>
                            </th>
                            <th class="text-center sorting @if (!empty($sort) AND Request::get('order') == 'year') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('admin.legislation.law.index', ['order' => 'year', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Tahun</a>
                            </th>
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'title') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('admin.legislation.law.index', ['order' => 'title', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Judul</a>
                            </th>
                            <th class="text-center sorting @if (!empty($sort) AND Request::get('order') == 'status') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('admin.legislation.law.index', ['order' => 'status', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Status</a>
                            </th>
                            <th class="text-center sorting @if (!empty($sort) AND Request::get('order') == 'user') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('admin.legislation.law.index', ['order' => 'user', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Operator</a>
                            </th>
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'published_at') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('admin.legislation.law.index', ['order' => 'published_at', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Publikasi</a>
                            </th>
                            <th width="1" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laws as $law)
                            <tr>
                                @cannot('isAuthor')
                                    <td><input type="checkbox" class="checkbox" data-item="{{ $law->id }}"></td>
                                @endcannot
                                <td><span title="{{ $law->category->name }}" data-bs-popup="tooltip">{{ $law->category->abbrev }}</span></td>
                                <td class="text-center">{{ $law->code_number }}</td>
                                <td class="text-center">{{ $law->year; }}</td>
                                <td><span class="fw-semibold">{{ $law->title; }}</span></td>
                                <td class="text-center">{!! $law->statusBadge !!}</td>
                                <td class="text-center">
                                    <img src="{{ $law->userPictureUrl($law->user->picture, $law->user->name) }}" alt="{{ $law->user->name }}" class="rounded-circle" width="32" height="32" data-bs-popup="tooltip" title="{{ $law->user->name }}">
                                </td>
                                <td>
                                    <span class="d-block">{!! $law->publicationLabel() !!}</span>
                                    <abbr class="fs-sm" data-bs-popup="tooltip" title="{{ $law->dateFormatted($law->published_at, true) }}">{{ $law->dateFormatted($law->published_at) }}</abbr>
                                </td>
                                <td class="safezone">
                                    <div class="d-inline-flex">
                                        <a href="{{ route('admin.legislation.law.show', $law->id) }}" class="text-body mx-1" data-bs-popup="tooltip" title="Lihat"><i class="ph-eye"></i></a>
                                        @if ($onlyTrashed)
                                            @can('restore', $law)
                                                <form action="{{ route('admin.legislation.law.restore', $law->id) }}" method="POST">
                                                    @method('PUT')
                                                    @csrf
                                                    <button type="submit" class="btn btn-link p-0 text-body mx-1" data-bs-popup="tooltip" title="Kembalikan"><i class="ph-arrow-arc-left"></i></button>
                                                </form>
                                            @endcan

                                            @can('forceDelete', $law)
                                                <form class="delete-form" action="{{ route('admin.legislation.law.force-destroy', $law->id) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-link p-0 text-body" data-bs-popup="tooltip" title="Hapus"><i class="ph-x"></i></button>
                                                </form>
                                            @endcan
                                        @else
                                            @can('update', $law)
                                                <a href="{{ route('admin.legislation.law.edit', $law->id) }}" class="text-body mx-1" data-bs-popup="tooltip" title="Ubah"><i class="ph-pen"></i></a>
                                            @endcan

                                            @can('delete', $law)
                                                <form action="{{ route('admin.legislation.law.destroy', $law->id) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-link p-0 text-body mx-1" data-bs-popup="tooltip" title="Buang"><i class="ph-trash"></i></button>
                                                </form>
                                            @endcan
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="table-warning"><td colspan="100" class="text-center text-warning">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>

                    {{ $laws->links('admin.layouts.pagination') }}

                </table>
            </div>
        </div>

    </div>
    <!-- /content area -->

@endsection

@section('script')
    @include('admin.legislation.script')
@endsection
