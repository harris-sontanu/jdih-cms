@extends('admin.layouts.app')

@section('title', $pageTitle)
@section('content')

    <!-- Content area -->
    <div class="content pt-0">

        @include('admin.layouts.message')

        <!-- Inner container -->
        <div class="d-flex align-items-stretch align-items-lg-start flex-column flex-lg-row">

            <!-- Left content -->
            <div class="flex-1 order-2 order-lg-1">

                <div class="card">
                    <div class="card-header card-header d-sm-flex py-sm-0">
                        <div class="py-sm-3 mb-sm-0 mb-3">
                            <div class="form-control-feedback form-control-feedback-end">
                                <form action="{{ route('admin.legislation.institute.index') }}" method="get">
                                    <input type="search" name="search" class="form-control rounded-pill" placeholder="Cari nama, singkatan..." @if (Request::get('search')) value="{{ Request::get('search') }}" @endif autofocus>
                                    <div class="form-control-feedback-icon">
                                        <i class="ph-magnifying-glass text-muted"></i>
                                    </div>
                                </form>
                            </div>
                        </div>
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

                                    <th class="sorting @if (!empty($sort) AND Request::get('order') == 'name') {{ 'sorting_' . $sort }} @endif">
                                        <a href="{{ route('admin.legislation.institute.index', ['order' => 'name', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Nama</a>
                                    </th>
                                    <th class="sorting @if (!empty($sort) AND Request::get('order') == 'abbrev') {{ 'sorting_' . $sort }} @endif">
                                        <a href="{{ route('admin.legislation.institute.index', ['order' => 'abbrev', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Singkatan</a>
                                    </th>
                                    <th class="sorting @if (!empty($sort) AND Request::get('order') == 'name') {{ 'sorting_' . $sort }} @endif">
                                        <a href="{{ route('admin.legislation.institute.index', ['order' => 'code', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Kode</a>
                                    </th>
                                    <th class="text-center sorting @if (!empty($sort) AND Request::get('order') == 'total') {{ 'sorting_' . $sort }} @endif">
                                        <a href="{{ route('admin.legislation.institute.index', ['order' => 'total', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Total</a>
                                    </th>
                                    @cannot('isAuthor')
                                        <th width="1" class="text-center">Aksi</th>
                                    @endcannot
                                </tr>
                            </thead>
                            <tbody id="sortable">
                                @forelse ($institutes as $institute)
                                    <tr>
                                        <td><span class="fw-semibold d-block">{{ $institute->name }}</span></td>
                                        <td>{{ $institute->abbrev }}</td>
                                        <td>{{ $institute->code }}</td>
                                        <td class="text-center"><span class="badge rounded-pill bg-indigo">{{ $institute->legislations->count() }}</span></td>

                                        @cannot('isAuthor')
                                            <td class="safezone">
                                                <div class="d-inline-flex">
                                                    <button type="button" class="btn btn-link text-body p-0" data-bs-popup="tooltip" title="Ubah" data-bs-toggle="modal" data-bs-target="#edit-modal" data-id="{{ $institute->id }}" data-name="{{ $institute->name }}"><i class="ph-pen"></i></button>
                                                    <form class="delete-form" action="{{ route('admin.legislation.institute.destroy', $institute->id) }}" data-name="{{ $institute->name; }}" method="POST">
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

                            {{ $institutes->links('admin.layouts.pagination') }}

                        </table>
                    </div>
                </div>
            </div>

            @cannot('isAuthor')
                <div class="sidebar sidebar-component sidebar-expand-lg bg-transparent shadow-none order-1 order-lg-2 ms-lg-3 mb-3">

                    <div class="sidebar-content">
                        <div class="card">
                            <div class="sidebar-section-header border-bottom">
                                <span class="fw-semibold">Tambah Pemrakarsa</span>
                            </div>

                            <div class="sidebar-section-body">

                                <form action="{{ route('admin.legislation.institute.store') }}" method="post" novalidate>
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama:</label>
                                        <input id="name" type="text" class="form-control @if ($errors->get('name') OR $errors->get('slug')) is-invalid @endif" name="name" value="{{ old('name') }}" placeholder="Biro Hukum Setda Provinsi Bali">
                                        @if ($errors->get('name') OR $errors->get('slug'))
                                            <ul class="invalid-feedback list-unstyled">
                                                @foreach ($errors->get('name') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                                @foreach ($errors->get('slug') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label for="abbrev" class="form-label">Singkatan:</label>
                                        <input id="abbrev" type="text" class="form-control @error('abbrev') is-invalid @enderror" name="abbrev" value="{{ old('abbrev') }}">
                                        @error('abbrev')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
                                    </div>


                                    <div class="mb-3">
                                        <label for="code" class="form-label">Kode:</label>
                                        <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}">
                                        @error('code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label for="desc" class="form-label">Deskripsi:</label>
                                        <textarea id="desc" rows="4" class="form-control @error('desc') is-invalid @enderror" name="desc">{{ old('desc') }}</textarea>
                                        @error('desc')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-indigo">Simpan</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            @endcannot
        </div>

    </div>
    <!-- /content area -->

@endsection

@section('modal')
    @include('admin.layouts.modal')
@endsection

@section('script')
    @include('admin.legislation.institute.script')
@endsection
