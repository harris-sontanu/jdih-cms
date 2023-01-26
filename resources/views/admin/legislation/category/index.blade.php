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
                        <form action="{{ route('admin.legislation.category.index') }}" method="get">
                            <input type="search" name="search" class="form-control rounded-pill" placeholder="Cari nama, singkatan..." @if (Request::get('search')) value="{{ Request::get('search') }}" @endif autofocus>
                            <div class="form-control-feedback-icon">
                                <i class="ph-magnifying-glass text-muted"></i>
                            </div>
                        </form>
                    </div>
                </div>

                @cannot('isAuthor')                    
                    <div class="ms-sm-auto my-sm-auto">
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-indigo" data-bs-toggle="modal" data-bs-target="#create-modal"><i class="ph-plus me-2"></i>Tambah</button>
                        </div>
                    </div>
                @endcannot

            </div>

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
                                <th width="1"><i class="ph-dots-six-vertical "></i></th>
                            @endcannot
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'name') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('admin.legislation.category.index', ['order' => 'name', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Nama</a>
                            </th>
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'abbrev') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('admin.legislation.category.index', ['order' => 'abbrev', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Singkatan</a>
                            </th>
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'type') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('admin.legislation.category.index', ['order' => 'type', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Tipe</a>
                            </th>
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'code') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('admin.legislation.category.index', ['order' => 'code', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Kode File</a>
                            </th>
                            <th class="text-center sorting @if (!empty($sort) AND Request::get('order') == 'total') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('admin.legislation.category.index', ['order' => 'total', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Total</a>
                            </th>
                            <th>Operator</th>
                            @cannot('isAuthor')                                
                                <th width="1" class="text-center">Aksi</th>
                            @endcannot
                        </tr>
                    </thead>
                    <tbody id="sortable">
                        @forelse ($categories as $category)
                            <tr id="{{ $category->id }}" class="item" data-id="{{ $category->id }}">
                                @cannot('isAuthor')
                                    <td class="drag-handle"><i class="ph-dots-six-vertical  dragula-handle"></i></td>
                                @endcannot
                                <td>
                                    <span class="fw-semibold d-block">{{ $category->name }}</span>
                                </td>
                                <td>{{ $category->abbrev }}</td>
                                <td>{{ $category->type->name; }}</td>
                                <td>{{ $category->code ?? '-'; }}</span></td>
                                <td class="text-center"><span class="badge bg-indigo rounded-pill">{{ $category->legislations->count() }}</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            <img src="{{ $category->userPictureUrl($category->user->picture, $category->user->name) }}" alt="{{ $category->user->name }}" class="rounded-circle" width="32" height="32">
                                        </div>
                                        <div class="div">
                                            <span class="d-block">{{ $category->user->name }}</span>
                                            <abbr class="text-muted fs-sm" data-bs-popup="tooltip" title="{{ $category->dateFormatted($category->created_at, true) }}">{{ $category->dateFormatted($category->created_at) }}</abbr>
                                        </div>
                                    </div>
                                </td>
                                @cannot('isAuthor')
                                    <td class="safezone">
                                        <div class="d-inline-flex">
                                            <button type="button" class="btn btn-link text-body p-0" data-bs-popup="tooltip" title="Ubah" data-bs-toggle="modal" data-bs-target="#edit-modal" data-id="{{ $category->id }}" data-name="{{ $category->name }}"><i class="ph-pen"></i></button>
                                            <form class="delete-form" action="{{ route('admin.legislation.category.destroy', $category->id) }}" data-name="{{ $category->name; }}" method="POST">
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
                                
                    {{ $categories->links('admin.layouts.pagination') }}
                    
                </table>
            </div>
        </div>

    </div>
    <!-- /content area -->

@endsection

@section('modal')
    @include('admin.legislation.category.create')
    @include('admin.layouts.modal')
@endsection

@section('script')
    @include('admin.legislation.category.script')
@endsection 
