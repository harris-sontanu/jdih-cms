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
                        <form action="{{ route('admin.legislation.log') }}" method="get">
                            <input type="search" name="search" class="form-control rounded-pill" placeholder="Cari kegiatan..." @if (Request::get('search')) value="{{ Request::get('search') }}" @endif autofocus>
                            <div class="form-control-feedback-icon">
                                <i class="ph-magnifying-glass text-muted"></i>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="ms-sm-auto my-sm-auto">
                    <div class="d-flex justify-content-center">
                        <button type="button" id="filter" class="btn btn-light me-2"><i class="ph-faders-horizontal me-2"></i>Filter</button>
                    </div>
                </div>
            </div>

            <div id="filter-options" @empty (Request::get('filter')) style="display: none" @endempty>

                <div class="card-body bg-light pb-0">
                    <form action="{{ route('admin.legislation.log') }}" id="filter-form" class="filter-form" method="GET">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="message" placeholder="Kegiatan" value="{{ Request::get('message') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <select id="user" name="user" class="form-control select-search">
                                        <option value="">Pilih Operator</option>
                                        @foreach ($users as $key => $value)
                                            <option value="{{ $key }}" @selected(Request::get('user') == $key)>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <select name="month" class="select">
                                        <option value="">Pilih Periode Kegiatan</option>
                                        <option value="1" @selected(Request::get('month') == 1)>Januari</option>
                                        <option value="2" @selected(Request::get('month') == 2)>Februari</option>
                                        <option value="3" @selected(Request::get('month') == 3)>Maret</option>
                                        <option value="4" @selected(Request::get('month') == 4)>April</option>
                                        <option value="5" @selected(Request::get('month') == 5)>Mei</option>
                                        <option value="6" @selected(Request::get('month') == 6)>Juni</option>
                                        <option value="7" @selected(Request::get('month') == 7)>Juli</option>
                                        <option value="8" @selected(Request::get('month') == 8)>Agustus</option>
                                        <option value="9" @selected(Request::get('month') == 9)>September</option>
                                        <option value="10" @selected(Request::get('month') == 10)>Oktober</option>
                                        <option value="11" @selected(Request::get('month') == 11)>November</option>
                                        <option value="12" @selected(Request::get('month') == 12)>Desember</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <input type="number" class="form-control" placeholder="Tahun Kegiatan" name="year" value="{{ Request::get('year') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ph-calendar-blank"></i></span>
                                        <input type="text" class="form-control daterange-single" name="created_at" value="{{ Request::get('created_at') }}" placeholder="Tgl. Kegiatan">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <button type="submit" name="filter" value="true" class="btn btn-indigo"><i class="ph-magnifying-glass me-2"></i>Cari</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Operator</th>
                            <th>Kegiatan</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $date = null;
                        @endphp
                        @forelse ($logs as $log)

                            @if ($date != $log->timeFormatted($log->created_at))
                                <tr class="table-active table-border-double">
                                    <td colspan="3" class="text-center">{{ $log->timeFormatted($log->created_at, 'l, n F Y') }}</td>
                                </tr>
                            @endif

                            <tr id="{{ $log->id }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            <img src="{{ $log->userPictureUrl($log->user->picture, $log->user->name) }}" alt="{{ $log->user->name }}" class="rounded-circle" width="32" height="32">
                                        </div>
                                        <div><span>{{ $log->user->name }}</span></div>
                                    </div>
                                </td>
                                <td>
                                    @if (!empty($log->legislation->id))
                                        <span>{!! $log->message; !!} pada <a class="text-body fw-semibold" href="{{ route('admin.legislation.' . $log->legislation->category->type->route . '.show', $log->legislation->id) }}">{{ $log->legislation->title }}</a></span>
                                    @endif
                                </td>
                                <td>
                                    <span class="d-block">{{ $log->timeFormatted($log->created_at, 'H:i') }}</span>
                                    <abbr class="fs-sm text-nowrap" data-bs-popup="tooltip" title="{{ $log->dateFormatted($log->created_at, true) }}">{{ $log->timeDifference($log->created_at) }}</abbr>
                                </td>
                            </tr>

                            @php
                                $date = $log->timeFormatted($log->created_at)
                            @endphp
                        @empty
                            <tr class="table-warning"><td colspan="100" class="text-center text-warning">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>

                    {{ $logs->links('admin.layouts.pagination') }}

                </table>
            </div>
        </div>

    </div>
    <!-- /content area -->

@endsection

@section('script')
    @include('admin.legislation.script')
@endsection

