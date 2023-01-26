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
                        <form action="{{ route('admin.employee.index') }}" method="get">
                            <input type="search" name="search" class="form-control rounded-pill" placeholder="Cari nama, jabatan..." @if (Request::get('search')) value="{{ Request::get('search') }}" @endif autofocus>
                            <div class="form-control-feedback-icon">
                                <i class="ph-magnifying-glass text-muted"></i>
                            </div>
                        </form>
                    </div>
                </div>

                @include('admin.employee.feature')

            </div>

            <div id="filter-options" @empty (Request::get('filter')) style="display: none" @endempty>

                @include('admin.employee.filter')

            </div>

            @isset ($tabFilters)
                <div class="navbar navbar-expand-lg border-bottom py-2">
                    <div class="container-fluid">
                        <ul class="nav navbar-nav flex-row flex-fill">
                            @foreach ($tabFilters as $key => $value)
                                @php $active = ((empty(Request::get('tab')) AND $key === 'total') OR Request::get('tab') == $key) ? ' active' : '' @endphp
                                <li class="nav-item me-1">
                                    <a href="{{ route('admin.employee.index', ['tab' => $key] + Request::all()) }}" class="navbar-nav-link rounded{{ $active }}">
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
                                        <a href="{{ route('admin.employee.index', ['limit' => 25] + Request::all()) }}" class="dropdown-item" data-rows="25">25</a>
                                        <a href="{{ route('admin.employee.index', ['limit' => 50] + Request::all()) }}" class="dropdown-item" data-rows="50">50</a>
                                        <a href="{{ route('admin.employee.index', ['limit' => 100] + Request::all()) }}" class="dropdown-item" data-rows="100">100</a>
                                        <a href="{{ route('admin.employee.index', ['limit' => 200] + Request::all()) }}" class="dropdown-item" data-rows="200">200</a>
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
                            <th width="1"><input type="checkbox" /></th>
                            <th width="1"><i class="ph-dots-six-vertical "></i></th>
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'name') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('admin.employee.index', ['order' => 'name', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Nama</a>
                            </th>
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'position') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('admin.employee.index', ['order' => 'position', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Jabatan</a>
                            </th>
                            <th>Grup</th>
                            <th>Pangkat</th>
                            <th width="1" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="sortable">
                        @forelse ($employees as $employee)
                            <tr id="{{ $employee->id }}" class="item" data-id="{{ $employee->id }}">
                                <td><input type="checkbox" class="checkbox" data-item="{{ $employee->id }}"></td>
                                <td class="drag-handle"><i class="ph-dots-six-vertical  dragula-handle"></i></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            <img src="{{ $employee->pictureThumbUrl }}" alt="{{ $employee->name }}" class="rounded-circle" width="32" height="32">
                                        </div>
                                        <div class="div">
                                            <span class="fw-semibold d-block">{{ $employee->name }}</span>
                                            @if (!empty($employee->nip))
                                                <span class="text-muted fs-sm">NIP: {{ $employee->nip }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $employee->position }}</td>
                                <td>
                                    @foreach ($employee->groups as $group)
                                        <span class="badge bg-light border-start border-width-3 text-body rounded-start-0 border-{{ $group->class }}">{{ $group->name }}</span>
                                    @endforeach
                                </td>
                                <td>{{ $employee->rank }}</td>
                                <td class="safezone">
                                    <div class="d-inline-flex">
                                        <button type="button" class="btn btn-link p-0 text-body" data-bs-toggle="modal" data-bs-target="#show-modal" data-id="{{ $employee->id }}" data-bs-popup="tooltip" aria-label="Lihat" data-bs-original-title="Lihat">
                                            <i class="ph-eye"></i>
                                        </button>
                                        <a href="{{ route('admin.employee.edit', $employee->id) }}" class="text-body mx-2" data-bs-popup="tooltip" aria-label="Ubah" data-bs-original-title="Ubah"><i class="ph-pen"></i></a>
                                        <form class="delete-form" action="{{ route('admin.employee.destroy', $employee->id) }}" method="POST" data-confirm="Apakah Anda yakin ingin menghapus data pegawai {{ $employee->name }} ?">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-link p-0 text-body" data-bs-popup="tooltip" aria-label="Hapus" data-bs-original-title="Hapus"><i class="ph-x"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="table-warning"><td colspan="100" class="text-center text-warning">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>

                    {{ $employees->links('admin.layouts.pagination') }}

                </table>
            </div>
        </div>

    </div>
    <!-- /content area -->

@endsection

@section('modal')
    @include('admin.employee.show_modal')
@endsection

@section('script')
    @include('admin.employee.script')
@endsection
